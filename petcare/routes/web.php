<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetCareController;

// Điều hướng trang chính
Route::get('/', [PetCareController::class, 'login'])->name('login');
Route::get('/login', [PetCareController::class, 'login']);
Route::get('/home', [PetCareController::class, 'home'])->name('home');
Route::get('/dashboard', [PetCareController::class, 'dashboard'])->name('dashboard');

// Auth API
Route::post('/api/login', [PetCareController::class, 'apiLogin']);
Route::post('/api/register', [PetCareController::class, 'apiRegister']);

// Khách hàng & Thú cưng API
Route::get('/api/pets', [PetCareController::class, 'getPets']);
Route::post('/api/pets/save', [PetCareController::class, 'savePet']);
Route::delete('/api/pets/{id}', [PetCareController::class, 'deletePet']);

// Lịch hẹn & Y tế API
Route::get('/api/appointments', [PetCareController::class, 'getAppointments']);
Route::post('/api/appointments/create', [PetCareController::class, 'createAppointment']);
Route::get('/api/medical-records', [PetCareController::class, 'getMedicalRecords']);

// Cộng đồng thú cưng (Social Feed) API
Route::get('/api/community/posts', [PetCareController::class, 'getCommunityPosts']);
Route::post('/api/community/posts/create', [PetCareController::class, 'createCommunityPost']);

// Cửa hàng & Đơn hàng API
Route::get('/api/products', [PetCareController::class, 'getProducts']);
Route::post('/api/orders/create', [PetCareController::class, 'createOrder']);
Route::post('/api/reviews/submit', [PetCareController::class, 'submitReview']);
Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});