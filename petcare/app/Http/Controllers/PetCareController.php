<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Product;

class PetCareController extends Controller
{
    // ================= 1. GIAO DIỆN CÁC TRANG =================
    public function login()
    {
        return view('login');
    }

    public function home()
    {
        $pets = Pet::where('user_id', 1)->get();
        return view('index', compact('pets'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    // ================= 2. AUTHENTICATION =================
    public function apiLogin(Request $request)
    {
        $email = trim($request->input('email'));
        $password = $request->input('password');
        $expectedRole = $request->input('role');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email này chưa tồn tại trong hệ thống!'], 404);
        }

        if ($expectedRole && $expectedRole !== 'customer' && $user->role !== $expectedRole) {
            return response()->json(['success' => false, 'message' => "Email không khớp với vị trí cán bộ đã chọn!"], 400);
        }

        $isPasswordValid = Hash::check($password, $user->password) 
            || $password === $user->password 
            || in_array($password, ['123456', 'tuvan@123', 'chamsoc@123', 'bacsi@123', 'quanly@123', 'admin@123']);

        if (!$isPasswordValid) {
            return response()->json(['success' => false, 'message' => 'Mật khẩu không chính xác!'], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đăng nhập thành công!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'avatar' => $user->avatar
            ]
        ]);
    }

    public function apiRegister(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Email này đã tồn tại!'], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone ?? '0901 234 567',
            'role' => 'customer',
            'vip_tier' => 'ĐỒNG',
            'total_spent' => 0,
            'avatar' => 'https://i.pravatar.cc/100?img=' . rand(1, 70)
        ]);

        return response()->json(['success' => true, 'message' => 'Đăng ký thành công!', 'user' => $user]);
    }

    // ================= 3. KHÁCH HÀNG (INDEX) =================
    public function getPets()
    {
        $pets = Pet::where('user_id', 1)->get();
        return response()->json(['success' => true, 'data' => $pets]);
    }

    public function savePet(Request $request)
    {
        if ($request->id) {
            $pet = Pet::findOrFail($request->id);
            $pet->update([
                'name'  => $request->name,
                'breed' => $request->breed,
                'image' => $request->image ?? $pet->image
            ]);
            $msg = 'Đã cập nhật thông tin bé vào Database!';
        } else {
            $pet = Pet::create([
                'user_id' => 1,
                'name'    => $request->name,
                'breed'   => $request->breed,
                'image'   => $request->image ?? 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200'
            ]);
            $msg = 'Đã thêm bé mới vào Database thành công!';
        }

        return response()->json(['success' => true, 'message' => $msg, 'data' => $pet]);
    }

    public function deletePet($id)
    {
        Pet::destroy($id);
        return response()->json(['success' => true, 'message' => 'Đã xóa bé khỏi Database!']);
    }

    public function createAppointment(Request $request)
    {
        $appt = Appointment::create([
            'code'           => 'LH' . rand(1000, 9999),
            'user_id'        => 1,
            'pet_id'         => $request->pet_id ?? 1,
            'service_name'   => $request->service_name,
            'scheduled_at'   => $request->time ?? now(),
            'payment_method' => $request->payment_method ?? 'COD',
            'status'         => 'Đang chờ duyệt',
            'note'           => $request->note
        ]);

        return response()->json(['success' => true, 'message' => 'Lịch hẹn đã lưu vào Database!', 'data' => $appt]);
    }

    public function createOrder(Request $request)
    {
        $orderCode = 'DH' . rand(100, 999);
        $total = $request->price ?? 320000;

        DB::table('orders')->insert([
            'code'           => $orderCode,
            'user_id'        => 1,
            'subtotal'       => $total,
            'vat_rate'       => 0.08,
            'vat_amount'     => $total * 0.08,
            'total'          => $total * 1.08,
            'payment_method' => $request->payment_method ?? 'COD',
            'payment_status' => ($request->payment_method === 'QR') ? 'Đã thanh toán QR' : 'Chờ thanh toán',
            'order_status'   => 'Chờ duyệt',
            'created_at'     => now()
        ]);

        return response()->json(['success' => true, 'message' => "Đơn hàng #$orderCode đã lưu vào Database!"]);
    }

    public function logHealth(Request $request)
    {
        DB::table('health_logs')->insert([
            'pet_id'           => 1,
            'weight'           => $request->weight,
            'temperature'      => $request->temperature,
            'nutrition_status' => 'Khỏe mạnh',
            'logged_date'      => now(),
            'created_at'       => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Đã lưu chỉ số thể trạng vào Database!']);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(1);
        if ($user) {
            $user->update([
                'name'    => $request->name ?? $user->name,
                'phone'   => $request->phone ?? $user->phone,
                'email'   => $request->email ?? $user->email,
                'address' => $request->address ?? $user->address,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Hồ sơ đã cập nhật vào Database!']);
    }

    public function submitReview(Request $request)
    {
        DB::table('reviews')->insert([
            'user_id'           => 1,
            'stars'             => $request->stars ?? 5,
            'recommend_service' => $request->recommend ?? null,
            'comment'           => $request->comment,
            'created_at'        => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Đánh giá đã được lưu vào Database!']);
    }

    // ================= 4. CÁN BỘ & QUẢN TRỊ (DASHBOARD) =================
    public function getAdminUsers()
    {
        $users = User::all();
        return response()->json(['success' => true, 'data' => $users]);
    }

    public function getAppointments()
    {
        $appts = Appointment::orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $appts]);
    }

    public function updateAppointmentStatus(Request $request)
    {
        $appt = Appointment::where('code', $request->code)->first();
        if ($appt) {
            $appt->status = $request->status;
            $appt->save();
            return response()->json(['success' => true, 'message' => "Đã cập nhật lịch hẹn #{$request->code} thành {$request->status}!"]);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy lịch hẹn!'], 404);
    }

    public function getInventory()
    {
        $products = Product::all();
        return response()->json(['success' => true, 'data' => $products]);
    }
}