/* ==========================================================================
   PETCARE PRO - JAVASCRIPT ĐIỀU KHIỂN GIAO DIỆN & TƯƠNG TÁC CHUẨN 2026
   ========================================================================== */

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

// 1. Toast Thông báo
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-box');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = `modern-toast toast-${type}`;
    const icon = type === 'success' ? 'fa-circle-check' : (type === 'error' ? 'fa-circle-xmark' : 'fa-circle-info');
    toast.innerHTML = `<i class="fa-solid ${icon}"></i><span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => { toast.remove(); }, 3000);
}

function closeModal(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('open');
}

// 2. Chuyển tab mượt mà
function switchNavTab(tabId, el) {
    document.querySelectorAll('.view-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));

    const target = document.getElementById(tabId);
    if (target) target.classList.add('active');

    if (el) {
        el.classList.add('active');
    } else {
        const btn = document.querySelector(`[onclick*="${tabId}"]`);
        if (btn) btn.classList.add('active');
    }
}

// 3. Quản lý Thú cưng (Fetch từ SQL Server)
async function renderPets() {
    const container = document.getElementById('pet-list-container');
    if (!container) return;

    try {
        const res = await fetch('/api/pets');
        const json = await res.json();
        const pets = json.data || [];

        container.innerHTML = pets.map(p => `
            <div class="pet-profile-card">
                <img src="${p.image || 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200'}" alt="${p.name}">
                <div class="pet-profile-info">
                    <h4>${p.name}</h4>
                    <p><i class="fas fa-paw"></i> ${p.breed}</p>
                    <span class="weight-tag"><i class="fas fa-weight-scale"></i> ${p.weight || 5} kg</span>
                </div>
                <div class="pet-card-actions">
                    <button class="btn-sm btn-edit" onclick="openEditPet(${p.id}, '${p.name}', '${p.breed}', ${p.weight || 5})"><i class="fas fa-pen"></i> Sửa</button>
                    <button class="btn-sm btn-del" onclick="deletePetRecord(${p.id})"><i class="fas fa-trash"></i> Xóa</button>
                </div>
            </div>
        `).join('');
    } catch (e) {
        console.error("Lỗi nạp thú cưng:", e);
    }
}

function openAddPetModal() {
    document.getElementById('pet-form-id').value = '';
    document.getElementById('pet-form-name').value = '';
    document.getElementById('pet-form-breed').value = '';
    document.getElementById('pet-form-weight').value = '';
    document.getElementById('pet-modal').classList.add('open');
}

function openEditPet(id, name, breed, weight) {
    document.getElementById('pet-form-id').value = id;
    document.getElementById('pet-form-name').value = name;
    document.getElementById('pet-form-breed').value = breed;
    document.getElementById('pet-form-weight').value = weight;
    document.getElementById('pet-modal').classList.add('open');
}

async function savePetToDatabase() {
    const id = document.getElementById('pet-form-id').value;
    const name = document.getElementById('pet-form-name').value.trim();
    const breed = document.getElementById('pet-form-breed').value.trim();
    const weight = document.getElementById('pet-form-weight').value;

    if (!name || !breed) return showToast("Vui lòng nhập tên và giống loài!", "warning");

    try {
        const res = await fetch('/api/pets/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ id: id || null, name, breed, weight })
        });
        const data = await res.json();
        if (data.success) {
            showToast(data.message);
            closeModal('pet-modal');
            renderPets();
        }
    } catch (e) {
        showToast("Lỗi lưu cơ sở dữ liệu!", "error");
    }
}

async function deletePetRecord(id) {
    if (confirm("Bạn có chắc chắn muốn xóa hồ sơ bé này khỏi Database?")) {
        try {
            const res = await fetch(`/api/pets/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() }
            });
            const data = await res.json();
            if (data.success) {
                showToast(data.message, "info");
                renderPets();
            }
        } catch (e) {
            showToast("Lỗi khi xóa bé cưng!", "error");
        }
    }
}

// 4. Đặt Lịch Hẹn
function openBookingService(serviceName, price) {
    switchNavTab('nav-booking');
    const select = document.getElementById('book-service-name');
    if (select) {
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].text.includes(serviceName)) {
                select.selectedIndex = i;
                break;
            }
        }
    }
}

async function submitBookingForm() {
    const service = document.getElementById('book-service-name').value;
    const time = document.getElementById('book-time-input').value;
    const note = document.getElementById('book-note-input').value;
    const payMethod = document.getElementById('book-payment-method').value;

    if (!time) return showToast("Vui lòng chọn ngày và giờ hẹn!", "warning");

    try {
        const res = await fetch('/api/appointments/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
            body: JSON.stringify({
                service_name: service,
                scheduled_at: time,
                payment_method: payMethod,
                note: note
            })
        });
        const data = await res.json();
        if (data.success) {
            showToast(data.message, "success");
            document.getElementById('book-time-input').value = '';
            document.getElementById('book-note-input').value = '';
        }
    } catch (e) {
        showToast("Lỗi đặt lịch!", "error");
    }
}

// 5. Mạng xã hội thú cưng (Pet Social Feed)
function likePost(btn) {
    btn.classList.toggle('liked');
    const span = btn.querySelector('span');
    let count = parseInt(span.innerText) || 0;
    if (btn.classList.contains('liked')) {
        btn.style.color = '#ff4757';
        span.innerText = `${count + 1} yêu thích`;
    } else {
        btn.style.color = '#64748b';
        span.innerText = `${Math.max(0, count - 1)} yêu thích`;
    }
}

async function shareCommunityPost() {
    const input = document.getElementById('social-post-text');
    if (!input || !input.value.trim()) return showToast("Vui lòng viết đôi dòng cảm nhận về bé cưng!", "warning");

    try {
        const res = await fetch('/api/community/posts/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
            body: JSON.stringify({ content: input.value.trim() })
        });
        const data = await res.json();
        showToast(data.message);
        input.value = '';
    } catch (e) {
        showToast("Lỗi chia sẻ bài viết!", "error");
    }
}

// 6. Mua hàng nhanh (Fast Order)
let currentOrderData = { name: '', price: 0 };
function triggerFastOrder(name, price) {
    currentOrderData = { name, price };
    document.getElementById('order-product-name').innerText = name;
    document.getElementById('order-product-price').innerText = price.toLocaleString() + ' VNĐ';
    document.getElementById('order-modal').classList.add('open');
}

async function confirmOrderSubmission() {
    closeModal('order-modal');
    const payMethod = document.getElementById('order-pay-method').value;

    try {
        const res = await fetch('/api/orders/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
            body: JSON.stringify({
                total: currentOrderData.price,
                payment_method: payMethod
            })
        });
        const data = await res.json();
        showToast(data.message, "success");
    } catch (e) {
        showToast("Lỗi đặt đơn hàng!", "error");
    }
}

// 7. Gửi đánh giá
async function sendReviewData() {
    const stars = document.getElementById('review-stars-val').value;
    const comment = document.getElementById('review-comment-val').value;
    if (!comment.trim()) return showToast("Vui lòng nhập nhận xét của bạn!", "warning");

    try {
        const res = await fetch('/api/reviews/submit', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
            body: JSON.stringify({ stars, comment })
        });
        const data = await res.json();
        showToast(data.message, "success");
        document.getElementById('review-comment-val').value = '';
    } catch (e) {
        showToast("Lỗi gửi đánh giá!", "error");
    }
}

function logoutToAuth(event) {
    if (event) event.preventDefault();
    
    // Xóa sạch thông tin đăng nhập trong trình duyệt
    localStorage.removeItem('pc_logged_role');
    localStorage.removeItem('pc_logged_email');
    localStorage.removeItem('pc_show_login_success');
    sessionStorage.clear();

    // Chuyển hướng thẳng về trang đăng nhập
    window.location.href = '/login';
}
window.logoutToAuth = logoutToAuth;

// Tự động nạp dữ liệu khi mở trang
window.addEventListener('DOMContentLoaded', () => {
    renderPets();
});