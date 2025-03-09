# 🏸 Badminton Connect

Badminton Connect là một nền tảng giúp kết nối người chơi cầu lông, tìm kiếm sân cầu lông gần vị trí và tìm bạn chơi cùng dựa trên trình độ và thời gian rảnh rỗi.

## 🚀 Mục tiêu MVP

1. **Tìm kiếm sân cầu lông:**
   - Hiển thị các sân cầu gần vị trí người dùng thông qua Google Maps API.
   - Cung cấp bộ lọc sân theo giá thuê, khoảng cách, tiện ích (phòng thay đồ, bãi đỗ xe, ...).

2. **Tìm bạn chơi cùng:**
   - Tìm kiếm người chơi dựa trên trình độ (Mới bắt đầu, trung bình, cao cấp, vận động viên phong trào).
   - Lọc theo thời gian rảnh rỗi và khu vực chơi.
   - Hệ thống chat đơn giản để trao đổi trước khi hẹn chơi.

3. **Hồ sơ người dùng:**
   - Thông tin cá nhân: Tên, ảnh đại diện, giới thiệu ngắn gọn.
   - Trình độ chơi, lịch sử trận đấu (có thể nhập tay hoặc đồng bộ từ các giải đấu cộng đồng nếu có).
   - Đánh giá và bình luận từ những người đã chơi cùng.

4. **Tích hợp bản đồ và định vị:**
   - Cho phép người dùng định vị vị trí hiện tại và đề xuất sân cầu gần nhất.

---

## 🛠 Công nghệ sử dụng

### Backend:
- **Laravel**: Framework PHP mạnh mẽ và linh hoạt để xây dựng API và quản lý dữ liệu.
- **MySQL**: Lưu trữ dữ liệu người dùng, sân cầu, trận đấu và các hoạt động khác.
- **Redis**: Hỗ trợ lưu trữ tạm và cache cho hệ thống chat.

### Frontend:
- **Nuxt.js**: Sử dụng cho giao diện người dùng với khả năng SEO tốt và trải nghiệm mượt mà.
- **shadcn/ui**: Xây dựng giao diện đơn giản, dễ tùy biến và đẹp mắt.
- **Google Maps API**: Tích hợp bản đồ và định vị vị trí.

### Realtime Chat:
- **Socket.IO**: Tạo hệ thống chat đơn giản và thời gian thực.

---

## 🚧 Cài đặt & Chạy dự án

### Yêu cầu hệ thống:
- **PHP >= 8.1** với **Composer**.
- **Node.js >= 16** với **npm** hoặc **yarn**.
- **MySQL** hoặc **MariaDB**.

### Bước 1: Clone dự án
```sh
git clone https://github.com/yourusername/badminton-connect.git
cd badminton-connect
```

### Bước 2: Cài đặt Backend (Laravel)
```sh
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Bước 3: Cài đặt Frontend (Nuxt.js)
```sh
npm install
npm run dev
```

### Bước 4: Truy cập ứng dụng
- Backend: [http://localhost:8000](http://localhost:8000)
- Frontend: [http://localhost:3000](http://localhost:3000)

---

## 📝 API Documentation

The application provides a RESTful API with the following endpoints:

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login and get token
- `GET /api/user` - Get authenticated user profile
- `POST /api/logout` - Logout and invalidate token

### Users
- `GET /api/users` - List all users (admin only)
- `GET /api/users/{id}` - Get user by ID
- `POST /api/users` - Create a new user (admin only)
- `PUT /api/users/{id}` - Update user details
- `DELETE /api/users/{id}` - Delete a user

### Branches
- `GET /api/branches` - List all branches with optional location filtering
- `GET /api/branches/{id}` - Get branch details
- `POST /api/branches` - Create a new branch (admin only)
- `PUT /api/branches/{id}` - Update branch details (admin/manager only)
- `DELETE /api/branches/{id}` - Delete a branch (admin only)
- `GET /api/branches/{id}/bookings` - List branch bookings

### Courts
- `GET /api/courts` - List all courts with optional filters
- `GET /api/courts/{id}` - Get court details
- `POST /api/courts` - Create a new court (admin/manager only)
- `PUT /api/courts/{id}` - Update court details (admin/manager only)
- `DELETE /api/courts/{id}` - Delete a court (admin only)
- `GET /api/courts/{id}/bookings` - List court bookings

### Bookings
- `GET /api/bookings` - List all bookings (admin only)
- `GET /api/bookings/{id}` - Get booking details
- `POST /api/bookings` - Create a new booking
- `PUT /api/bookings/{id}` - Update booking status (admin/manager only)
- `DELETE /api/bookings/{id}` - Delete a booking (if pending)
- `GET /api/my-bookings` - List authenticated user's bookings

## 📬 Postman Collection

A Postman collection is available for testing the API. Import the file:
`badminton-connect-api.json`

---

## 📂 Cấu trúc thư mục
```
├── app                   # Core application code
│   ├── Filament          # Admin panel resources
│   ├── Forms             # Form components
│   ├── Http              # Controllers and middleware
│   ├── Models            # Database models
│   └── Providers         # Service providers
├── database              # Migrations & Seeders
├── resources             # Frontend resources
├── routes                # API and web routes
└── README.md             # Project documentation
```

---

## 📧 Liên hệ
Nếu có thắc mắc hoặc đóng góp, vui lòng liên hệ qua email: hi@tuanha.dev
