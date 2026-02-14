# Ứng Dụng Lịch Vạn Niên (Lunar Calendar App)

Đây là dự án mẫu cho ứng dụng Lịch Vạn Niên hiện đại dành cho người Việt, được xây dựng bằng **Kotlin**, **Jetpack Compose** (Material 3), và tuân theo kiến trúc **Clean Architecture + MVVM**.

## 🛠 Công Nghệ Sử Dụng

*   **Ngôn ngữ:** Kotlin
*   **Giao diện:** Jetpack Compose (Material Design 3)
*   **Kiến trúc:** Clean Architecture + MVVM
*   **Dependency Injection:** Hilt
*   **Cơ sở dữ liệu:** Room Database
*   **Điều hướng:** Jetpack Compose Navigation
*   **Xử lý bất đồng bộ:** Coroutines & Flow

## 📋 Yêu Cầu Hệ Thống

*   **Android Studio:** Phiên bản mới nhất (Hedgehog hoặc Iguana được khuyến nghị).
*   **JDK:** Java 17.
*   **Android SDK:** Min SDK 26, Target SDK 34.

## 🚀 Hướng Dẫn Cài Đặt & Chạy Ứng Dụng

1.  **Mở dự án:**
    *   Khởi động Android Studio.
    *   Chọn **Open** và dẫn tới thư mục `LunarCalendarApp`.

2.  **Đồng bộ hóa Gradle (Sync Project):**
    *   Đợi Android Studio tải các thư viện cần thiết. Đảm bảo máy tính có kết nối mạng.
    *   Nếu gặp lỗi version, hãy kiểm tra `settings.gradle.kts` và `build.gradle.kts` để đảm bảo JDK 17 được chọn trong *Settings > Build, Execution, Deployment > Build Tools > Gradle*.

3.  **Chạy ứng dụng:**
    *   Kết nối thiết bị Android thật hoặc tạo máy ảo (Emulator).
    *   Nhấn nút **Run** (biểu tượng tam giác xanh) trên thanh công cụ.

## 📂 Cấu Trúc Dự Án

Dự án được chia thành các lớp (layers) rõ ràng:

*   **`domain`**: Chứa các Model (`LunarDate`) và Business Logic độc lập.
*   **`data`**:
    *   `local`: Cấu hình Room Database, Entity (`UserEvent`), và DAO.
*   **`presentation`**: Chứa giao diện UI và ViewModels.
    *   `daily`: Màn hình xem lịch ngày (`DailyCalendarScreen`, `DailyCalendarViewModel`).
    *   `navigation`: Cấu hình điều hướng màn hình.
*   **`core/utils`**: Chứa các tiện ích dùng chung, quan trọng nhất là `LunarDateConverter` (Chuyển đổi Dương Lịch -> Âm Lịch Việt Nam).
*   **`di`**: Cấu hình Hilt Dependency Injection.

## ✨ Tính Năng Chính

*   **Xem Lịch Ngày:** Hiển thị ngày Dương, ngày Âm, Tiết khí, và Giờ Hoàng Đạo.
*   **Chuyển Đổi Lịch:** Thuật toán tính toán ngày Âm lịch dựa trên múi giờ Việt Nam (GMT+7).
*   **Quản Lý Sự Kiện:** Cơ sở dữ liệu sẵn sàng để lưu trữ sự kiện người dùng (Sinh nhật, Giỗ chạp...).
*   **Giao Diện Hiện Đại:** Hỗ trợ Dark Mode và Material You.

---
*Dự án được tạo bởi AI Senior Android Engineer.*
