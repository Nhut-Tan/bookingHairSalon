<?php
require('layouts/header.php');  // Bao gồm header chung

// Lấy controller từ URL nếu có
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = '';  // Nếu không có controller, mặc định là trống
}

// Kiểm tra controller và xử lý
switch ($controller) {
    case 'danhsachnhanvien':  // Nếu controller là 'danhsachnhanvien'
        // Gọi controller để lấy danh sách nhân viên
        require_once '../../Controller/nhanvienController.php';
        nhanvienController::hienThiDanhSachNhanVien();  // Hiển thị danh sách nhân viên
        break;
    
    default:  // Nếu không có controller hoặc controller không xác định, load trang chủ
        require('pages/home.php');  // Mặc định là hiển thị trang chủ
        break;
}

require('layouts/footer.php');  // Bao gồm footer chung
?>
