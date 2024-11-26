<?php
//session_start();
$controller = isset($_GET['controller']) ? $_GET['controller'] : '';

// Chỉ include header và footer nếu controller không phải là 'admin'
if ($controller !== 'admin') {
    require('View/user/header.php');
}

// Gọi controller phù hợp
switch ($controller) {
    case 'admin':
        include 'View/admin/pages/login.php';
        break; 
    case 'hienthiformdatlich':
        require_once 'Controller/DatCuocHenController.php';
        DatCuocHenController::hienThiFormDatLich();  
        break;
    case 'datlichhen':
        require_once 'Controller/DatCuocHenController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            DatCuocHenController::datlich(); 
        } 
        break;
    case 'hienthitintuc':
        require_once 'View/user/tintucchitiet.php'; 
        break;
    default:
        // Nếu không có controller hoặc controller không xác định, load trang chủ
        require('View/user/home.php');  // Mặc định là hiển thị trang chủ
        break;
}

// Chỉ include footer nếu controller không phải là 'admin'
if ($controller !== 'admin') {
    require('View/user/footer.php');
}
?>
