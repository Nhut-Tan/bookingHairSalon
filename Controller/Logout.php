<?php
class AuthController {
    // Hàm xử lý đăng xuất
    public static function logout() {// Khởi động session nếu chưa có
        session_unset(); // Xóa tất cả các biến session
        session_destroy(); // Hủy session hiện tại

        // Chuyển hướng về trang đăng nhập với tham số controller=admin
        header("Location: ../../index.php?controller=admin");
        exit(); // Kết thúc script
    }
}

// Gọi hàm logout
// AuthController::logout();
?>
