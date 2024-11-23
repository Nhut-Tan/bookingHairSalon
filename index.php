<?php
  require('View/user/header.php');
  $controller = isset($_GET['controller']) ? $_GET['controller'] : '';
// Gọi controller phù hợp
switch ($controller) {
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

require('View/user/footer.php');
?>
