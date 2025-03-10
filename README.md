# 🏸 Badminton Connect

Badminton Connect là một nền tảng giúp kết nối người chơi cầu lông, tìm kiếm sân cầu lông gần vị trí và tìm bạn chơi cùng dựa trên trình độ và thời gian rảnh rỗi.

## 🚀 Mục tiêu MVP

1. **Tìm kiếm sân cầu lông:**
    - Hiển thị các sân cầu gần vị trí người dùng thông qua Google Maps API.
    - Cung cấp bộ lọc sân theo giá thuê, khoảng cách, tiện ích (phòng thay đồ, bãi đỗ xe, ...).

2. **Tìm bạn chơi cùng:**
    - Tìm kiếm người chơi dựa trên trình độ (Mới bắt đầu, trung bình, cao cấp, vận động viên phong trào).
    - Lọc theo thời gian rảnh rỗi và khu vực chơi.

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
- **React Native**: Dùng để phát triển ứng dụng di động đa nền tảng (Android & iOS).
- **shadcn/ui**: Thư viện giao diện nhẹ và linh hoạt.
- **React Navigation**: Hỗ trợ điều hướng trong ứng dụng.
- **Expo hoặc React Native CLI**: Tùy chọn cách triển khai ứng dụng.
- **Google Maps API**: Tích hợp bản đồ và định vị vị trí.
---

## 🚧 Cài đặt & Chạy dự án

### Yêu cầu hệ thống:
- **PHP >= 8.1** với **Composer**.
- **Node.js >= 16** với **npm** hoặc **yarn**.
- **MySQL** hoặc **MariaDB**.
- **Expo CLI** nếu chạy với Expo.
