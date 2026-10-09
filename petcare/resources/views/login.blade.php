<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PetCare Pro - Trung Tâm Y Tế & Chăm Sóc Thú Cưng</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="modern-pet-app">

    <!-- Toast Thông Báo -->
    <div id="toast-box" class="toast-container"></div>

    <!-- Nút Khẩn Cấp SOS Cố Định (Rất cần cho chủ thú cưng) -->
    <a href="tel:1900888999" class="sos-floating-badge" title="Gọi cấp cứu thú y 24/7">
        <i class="fas fa-truck-medical"></i> <span>SOS 24/7: 1900 888 999</span>
    </a>

    <!-- THANH ĐIỀU HƯỚNG TRÊN (TOPBAR) -->
    <header class="app-topbar">
        <div class="brand-logo">
            <i class="fas fa-paw brand-icon"></i>
            <div>
                <h2>PETCARE PRO</h2>
                <small>Bệnh Viện & Nghỉ Dưỡng Thú Cưng</small>
            </div>
        </div>

        <div class="topbar-actions">
            <button class="btn-action btn-appointment" onclick="switchNavTab('nav-booking')">
                <i class="fas fa-calendar-plus"></i> Đặt Lịch Khám
            </button>
            <div class="user-pill-profile" onclick="switchNavTab('nav-pets')">
                <img src="https://i.pravatar.cc/100?img=12" alt="Avatar">
                <div>
                    <strong>Nguyễn Văn A</strong>
                    <span class="badge-vip-pill">VIP ĐỒNG</span>
                </div>
            </div>
            <button class="btn-icon-logout" onclick="logoutToAuth()" title="Đăng xuất">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </div>
    </header>

    <div class="app-container">
        
        <!-- THANH MENU BÊN TRÁI -->
        <aside class="app-sidebar">
            <nav class="sidebar-menu">
                <button class="nav-btn active" onclick="switchNavTab('nav-overview', this)">
                    <i class="fas fa-house-chimney"></i> <span>Tổng quan</span>
                </button>
                <button class="nav-btn" onclick="switchNavTab('nav-pets', this)">
                    <i class="fas fa-shield-dog"></i> <span>Hồ sơ & Sổ tiêm</span>
                </button>
                <button class="nav-btn" onclick="switchNavTab('nav-booking', this)">
                    <i class="fas fa-calendar-check"></i> <span>Đặt lịch dịch vụ</span>
                </button>
                <button class="nav-btn" onclick="switchNavTab('nav-social', this)">
                    <i class="fas fa-camera-retro"></i> <span>Khoảnh khắc bé cưng</span>
                    <span class="bubble-hot">Hot</span>
                </button>
                <button class="nav-btn" onclick="switchNavTab('nav-shop', this)">
                    <i class="fas fa-bag-shopping"></i> <span>Nhà thuốc & Dinh dưỡng</span>
                </button>
                <button class="nav-btn" onclick="switchNavTab('nav-reviews', this)">
                    <i class="fas fa-star-half-stroke"></i> <span>Đánh giá dịch vụ</span>
                </button>
            </nav>

            <div class="clinic-info-card">
                <small><i class="fas fa-location-dot"></i> Trụ sở chính:</small>
                <p>Số 120 Hai Bà Trưng, Quận 1, TP.HCM</p>
                <small><i class="fas fa-clock"></i> Cấp cứu: Mở cửa 24/7</small>
            </div>
        </aside>

        <!-- KHÔNG GIAN NỘI DUNG CHÍNH -->
        <main class="app-main-content">

            <!-- PHÂN HỆ 1: TỔNG QUAN -->
            <section id="nav-overview" class="view-panel active">
                <!-- Banner Chào Mừng & Thẻ VIP -->
                <div class="hero-welcome-card">
                    <div class="hero-text">
                        <h1>Xin chào, Nguyễn Văn A! 👋</h1>
                        <p>Chào mừng bạn và các bé cưng quay trở lại trung tâm y tế PetCare Pro.</p>
                        <div class="hero-quick-stats">
                            <div class="stat-pill"><i class="fas fa-paw"></i> <strong>3</strong> bé thú cưng</div>
                            <div class="stat-pill"><i class="fas fa-syringe"></i> <strong>1</strong> mũi tiêm sắp tới</div>
                            <div class="stat-pill"><i class="fas fa-award"></i> Hạng thẻ <strong>ĐỒNG</strong></div>
                        </div>
                    </div>
                    <div class="vip-member-card">
                        <div class="vip-card-head">
                            <span>PETCARE MEDICAL VIP</span>
                            <i class="fas fa-shield-cat"></i>
                        </div>
                        <div class="vip-card-body">
                            <h3>NGUYỄN VĂN A</h3>
                            <small>Mã số: PC-MEMBER-88992</small>
                        </div>
                        <div class="vip-card-foot">
                            <span>Ưu đãi: Giảm 5% dịch vụ khám</span>
                            <small>Tích lũy: 850.000 đ</small>
                        </div>
                    </div>
                </div>

                <!-- Thao tác nhanh -->
                <div class="section-header">
                    <h2>Dịch Vụ Nổi Bật Yêu Cầu Nhiều Nhất</h2>
                </div>
                <div class="quick-services-grid">
                    <div class="quick-service-box" onclick="openBookingService('Khám sức khỏe tổng quát', 250000)">
                        <div class="icon-bubble color-emerald"><i class="fas fa-stethoscope"></i></div>
                        <h4>Khám Tổng Quát</h4>
                        <p>Chẩn đoán hình ảnh, siêu âm & xét nghiệm máu</p>
                    </div>
                    <div class="quick-service-box" onclick="openBookingService('Tiêm phòng vắc xin 7 bệnh', 350000)">
                        <div class="icon-bubble color-blue"><i class="fas fa-syringe"></i></div>
                        <h4>Tiêm Vắc Xin</h4>
                        <p>Vắc-xin 7 bệnh ngừa dại chuẩn quốc tế</p>
                    </div>
                    <div class="quick-service-box" onclick="openBookingService('Spa Bùn Khoáng Thảo Dược', 250000)">
                        <div class="icon-bubble color-orange"><i class="fas fa-bath"></i></div>
                        <h4>Spa & Phục Hồi Lông</h4>
                        <p>Ủ bùn khoáng nóng, massage khử mùi da</p>
                    </div>
                    <div class="quick-service-box" onclick="openBookingService('Khách Sạn Thú Cưng Phòng VIP', 400000)">
                        <div class="icon-bubble color-purple"><i class="fas fa-hotel"></i></div>
                        <h4>Khách Sạn 5 Sao</h4>
                        <p>Điều hòa lọc ion, camera riêng 24/7 trên App</p>
                    </div>
                </div>
            </section>

            <!-- PHÂN HỆ 2: HỒ SƠ BÉ CƯNG & SỔ TIÊM ĐIỆN TỬ -->
            <section id="nav-pets" class="view-panel">
                <div class="section-header-action">
                    <div>
                        <h2>Danh Sách Bé Cưng Của Bạn</h2>
                        <p>Lưu trữ hồ sơ y tế, thể trạng và theo dõi mũi tiêm phòng ngừa</p>
                    </div>
                    <button class="btn-action btn-save" onclick="openAddPetModal()">
                        <i class="fas fa-plus"></i> Thêm Bé Mới
                    </button>
                </div>

                <!-- Danh sách Pet dạng Card Hiện Đại -->
                <div class="pet-cards-grid" id="pet-list-container">
                    <!-- Nạp qua API -->
                </div>

                <!-- Sổ Tiêm & Bệnh Án Điện Tử -->
                <div class="medical-records-wrapper">
                    <h3><i class="fas fa-file-waveform"></i> Sổ Tiêm & Lịch Sử Điều Trị Gần Nhất</h3>
                    <div class="table-card">
                        <table>
                            <thead>
                                <tr>
                                    <th>Thời gian</th>
                                    <th>Bé cưng</th>
                                    <th>Nội dung khám / Loại Vắc-xin</th>
                                    <th>Bác sĩ phụ trách</th>
                                    <th>Ngày nhắc mũi tiếp</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10/01/2026</td>
                                    <td><strong>Bé Lu</strong> (Corgi)</td>
                                    <td>Vắc xin 7 bệnh phòng ngừa dại</td>
                                    <td>BS. Trần Nam</td>
                                    <td>10/01/2027</td>
                                    <td><span class="badge-status badge-success">Đã hoàn thành</span></td>
                                </tr>
                                <tr>
                                    <td>15/03/2026</td>
                                    <td><strong>Bé Lu</strong> (Corgi)</td>
                                    <td>Tái khám viêm da dị ứng nhẹ</td>
                                    <td>BS. Hoàng Kim Yến</td>
                                    <td>-</td>
                                    <td><span class="badge-status badge-info">Đã hồi phục</span></td>
                                </tr>
                                <tr>
                                    <td>02/06/2026</td>
                                    <td><strong>Bé Miu</strong> (Mèo Anh)</td>
                                    <td>Xét nghiệm sinh hóa máu 12 chỉ số</td>
                                    <td>BS. Trần Nam</td>
                                    <td>-</td>
                                    <td><span class="badge-status badge-success">Bình thường</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- PHÂN HỆ 3: ĐẶT LỊCH DỊCH VỤ -->
            <section id="nav-booking" class="view-panel">
                <div class="booking-centered-card">
                    <div class="booking-card-head">
                        <i class="fas fa-calendar-check fa-2x"></i>
                        <h2>Đặt Lịch Khám & Làm Đẹp Thú Cưng</h2>
                        <p>Bác sĩ và Kỹ thuật viên sẽ chuẩn bị đón tiếp bé chu đáo nhất</p>
                    </div>

                    <div class="booking-form-body">
                        <div class="form-group">
                            <label><i class="fas fa-paw"></i> Chọn bé thú cưng đến khám</label>
                            <select id="book-pet-select">
                                <option value="1">Bé Lu (Corgi - 11.5 kg)</option>
                                <option value="2">Bé Miu (Mèo Anh Lông Ngắn - 4.2 kg)</option>
                                <option value="3">Bé Bơ (Golden Retriever - 26 kg)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-stethoscope"></i> Dịch vụ yêu cầu</label>
                            <select id="book-service-name">
                                <option value="Khám sức khỏe tổng quát định kỳ">Khám sức khỏe tổng quát định kỳ (250.000 VNĐ)</option>
                                <option value="Tiêm phòng vắc xin 7 bệnh">Tiêm phòng vắc xin 7 bệnh (350.000 VNĐ)</option>
                                <option value="Cắt tỉa tạo kiểu Teddy Bear">Cắt tỉa tạo kiểu Teddy Bear (300.000 VNĐ)</option>
                                <option value="Spa Tắm Bùn Khoáng Thảo Mộc">Spa Tắm Bùn Khoáng Thảo Mộc (250.000 VNĐ)</option>
                                <option value="Khách sạn thú cưng phòng VIP">Khách sạn thú cưng phòng VIP (400.000 VNĐ/ngày)</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-clock"></i> Ngày & Giờ hẹn</label>
                                <input type="datetime-local" id="book-time-input">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-wallet"></i> Thanh toán</label>
                                <select id="book-payment-method">
                                    <option value="COD">Tiền mặt tại phòng khám</option>
                                    <option value="QR">Quét mã Chuyển khoản QR</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-notes-medical"></i> Ghi chú cho bác sĩ</label>
                            <textarea id="book-note-input" rows="2" placeholder="Ví dụ: Bé hơi nhát người lạ, da tai đang ngứa..."></textarea>
                        </div>

                        <button class="btn-action btn-submit-booking" onclick="submitBookingForm()">
                            <i class="fas fa-check"></i> XÁC NHẬN ĐẶT LỊCH NGAY
                        </button>
                    </div>
                </div>
            </section>

            <!-- PHÂN HỆ 4: KHOẢNH KHẮC BÉ CƯNG (PET SOCIAL MOMENTS - XU HƯỚNG MẠNG XÃ HỘI) -->
            <section id="nav-social" class="view-panel">
                <div class="social-feed-container">
                    
                    <!-- Khung Tạo Bài Viết Mới -->
                    <div class="create-post-card">
                        <div class="create-post-top">
                            <img src="https://i.pravatar.cc/100?img=12" alt="Avatar">
                            <input type="text" id="social-post-text" placeholder="Hôm nay bé cưng của bạn thế nào? Chia sẻ khoảnh khắc đáng yêu nhé...">
                        </div>
                        <div class="create-post-bottom">
                            <label class="btn-media-upload">
                                <i class="fas fa-image" style="color:#00b894;"></i> Thêm ảnh bé
                                <input type="file" accept="image/*" style="display:none;">
                            </label>
                            <button class="btn-action btn-share-post" onclick="shareCommunityPost()">
                                <i class="fas fa-paper-plane"></i> Đăng Khoảnh Khắc
                            </button>
                        </div>
                    </div>

                    <!-- Danh sách bài đăng mạng xã hội -->
                    <div class="social-stream" id="social-stream-box">
                        <!-- Bài viết 1 -->
                        <div class="social-post-card">
                            <div class="post-header">
                                <img src="https://i.pravatar.cc/100?img=12" alt="Avatar">
                                <div>
                                    <strong>Nguyễn Văn A</strong> <span>cùng 🐾 <em>Bé Lu</em></span>
                                    <small><i class="fas fa-clock"></i> 2 giờ trước</small>
                                </div>
                            </div>
                            <p class="post-caption">Hôm nay Lu đi spa tắm bùn khoáng về lông mướt rượt thơm tho quá trời! Cảm ơn bác sĩ PetCare ❤️</p>
                            <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=600" class="post-photo" alt="Pet Post">
                            <div class="post-interaction-bar">
                                <button class="btn-heart-like" onclick="likePost(this)"><i class="fas fa-heart"></i> <span>24 yêu thích</span></button>
                                <button class="btn-comment"><i class="fas fa-comment"></i> <span>6 bình luận</span></button>
                            </div>
                        </div>

                        <!-- Bài viết 2 -->
                        <div class="social-post-card">
                            <div class="post-header">
                                <img src="https://i.pravatar.cc/100?img=5" alt="Avatar">
                                <div>
                                    <strong>Trần Hương</strong> <span>cùng 🐾 <em>Miu Miu</em></span>
                                    <small><i class="fas fa-clock"></i> Hôm qua</small>
                                </div>
                            </div>
                            <p class="post-caption">Vừa tiêm nhắc mũi 7 bệnh xong, bé về ăn no rồi ngủ ngoan không hề sốt tí nào! Rất an tâm về tay nghề bác sĩ.</p>
                            <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=600" class="post-photo" alt="Pet Post">
                            <div class="post-interaction-bar">
                                <button class="btn-heart-like" onclick="likePost(this)"><i class="fas fa-heart"></i> <span>45 yêu thích</span></button>
                                <button class="btn-comment"><i class="fas fa-comment"></i> <span>12 bình luận</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PHÂN HỆ 5: NHÀ THUỐC & DINH DƯỠNG (PET SHOP) -->
            <section id="nav-shop" class="view-panel">
                <div class="section-header">
                    <div>
                        <h2>Nhà Thuốc & Thức Ăn Thú Cưng Chính Hãng</h2>
                        <p>100% sản phẩm có nguồn gốc xuất xứ rõ ràng, kiểm định y tế</p>
                    </div>
                </div>

                <div class="products-showcase-grid">
                    <div class="product-item-card">
                        <img src="https://images.unsplash.com/photo-1568640347023-a616a30bc3bd?w=250" alt="Hạt Royal Canin">
                        <h4>Hạt Royal Canin Corgi 2kg</h4>
                        <p class="product-price">320.000 VNĐ</p>
                        <small>Hỗ trợ cơ xương khớp & mượt lông</small>
                        <button class="btn-action btn-buy-now" onclick="triggerFastOrder('Hạt Royal Canin Corgi 2kg', 320000)">
                            <i class="fas fa-cart-shopping"></i> Mua Ngay
                        </button>
                    </div>

                    <div class="product-item-card">
                        <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=250" alt="Thuốc Bio-Derma">
                        <h4>Thuốc Bôi Trị Nấm Bio-Derma</h4>
                        <p class="product-price">95.000 VNĐ</p>
                        <small>Đặc trị viêm da, nấm kẽ móng chó mèo</small>
                        <button class="btn-action btn-buy-now" onclick="triggerFastOrder('Thuốc Bôi Trị Nấm Bio-Derma', 95000)">
                            <i class="fas fa-cart-shopping"></i> Mua Ngay
                        </button>
                    </div>

                    <div class="product-item-card">
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=250" alt="Xịt Khử Mùi">
                        <h4>Xịt Khử Mùi Sinh Học Bio-Clean 500ml</h4>
                        <p class="product-price">110.000 VNĐ</p>
                        <small>Khử mùi hôi nệm, tiêu diệt 99% vi khuẩn</small>
                        <button class="btn-action btn-buy-now" onclick="triggerFastOrder('Xịt Khử Mùi Bio-Clean 500ml', 110000)">
                            <i class="fas fa-cart-shopping"></i> Mua Ngay
                        </button>
                    </div>

                    <div class="product-item-card">
                        <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=250" alt="Vòng Cổ">
                        <h4>Vòng Cổ Phản Quang Phát Sáng</h4>
                        <p class="product-price">85.000 VNĐ</p>
                        <small>An toàn khi dắt thú cưng đi dạo buổi tối</small>
                        <button class="btn-action btn-buy-now" onclick="triggerFastOrder('Vòng Cổ Phản Quang', 85000)">
                            <i class="fas fa-cart-shopping"></i> Mua Ngay
                        </button>
                    </div>
                </div>
            </section>

            <!-- PHÂN HỆ 6: ĐÁNH GIÁ TRẢI NGHIỆM -->
            <section id="nav-reviews" class="view-panel">
                <div class="review-compose-card">
                    <h3><i class="fas fa-pen-fancy"></i> Gửi Cảm Nhận Của Bạn Về Bác Sĩ & Dịch Vụ</h3>
                    <div class="form-group" style="margin-top:15px;">
                        <label>Đánh giá số sao:</label>
                        <select id="review-stars-val">
                            <option value="5">⭐⭐⭐⭐⭐ 5 Sao (Tuyệt vời)</option>
                            <option value="4">⭐⭐⭐⭐ 4 Sao (Rất tốt)</option>
                            <option value="3">⭐⭐⭐ 3 Sao (Tạm ổn)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Chia sẻ trải nghiệm:</label>
                        <textarea id="review-comment-val" rows="3" placeholder="Bác sĩ thăm khám thế nào? Bé cưng có thích nhân viên spa không?..."></textarea>
                    </div>
                    <button class="btn-action btn-save" onclick="sendReviewData()">
                        <i class="fas fa-paper-plane"></i> Đăng Đánh Giá
                    </button>
                </div>
            </section>

        </main>
    </div>

    <!-- MODAL THÊM BÉ MỚI (LƯU THẲNG DATABASE) -->
    <div id="pet-modal" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fas fa-paw"></i> Thêm Hồ Sơ Bé Cưng</h3>
                <button onclick="closeModal('pet-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="pet-form-id">
                <div class="form-group">
                    <label>Tên bé cưng:</label>
                    <input type="text" id="pet-form-name" placeholder="Ví dụ: Bé Lu, Bé Miu...">
                </div>
                <div class="form-group">
                    <label>Giống loài:</label>
                    <input type="text" id="pet-form-breed" placeholder="Ví dụ: Corgi, Poodle, Mèo Anh...">
                </div>
                <div class="form-group">
                    <label>Cân nặng (kg):</label>
                    <input type="number" step="0.1" id="pet-form-weight" placeholder="Ví dụ: 8.5">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-action btn-cancel" onclick="closeModal('pet-modal')">Hủy</button>
                <button class="btn-action btn-save" onclick="savePetToDatabase()"><i class="fas fa-save"></i> Lưu Vào Database</button>
            </div>
        </div>
    </div>

    <!-- MODAL ĐẶT HÀNG NHANH -->
    <div id="order-modal" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fas fa-bag-shopping"></i> Xác Nhận Đơn Hàng</h3>
                <button onclick="closeModal('order-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <p>Mặt hàng: <strong id="order-product-name">Hạt Royal Canin</strong></p>
                <p>Tổng tiền: <strong id="order-product-price" style="color:#00b894; font-size:18px;">320.000 VNĐ</strong></p>
                <div class="form-group" style="margin-top:15px;">
                    <label>Hình thức thanh toán:</label>
                    <select id="order-pay-method">
                        <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                        <option value="QR">Quét mã QR Ngân Hàng</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-action btn-cancel" onclick="closeModal('order-modal')">Hủy</button>
                <button class="btn-action btn-save" onclick="confirmOrderSubmission()"><i class="fas fa-check"></i> Đặt Hàng Ngay</button>
            </div>
        </div>
    </div>

    <!-- Script JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>