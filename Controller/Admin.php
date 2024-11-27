<?php
session_start(); // Khởi tạo session

include('../Model/Login.php'); // Include model
$model = new Login();

// Kiểm tra nếu đã đăng nhập
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $_SESSION['logged_in'] = true;
    header('Location: ../View/admin/index.php');
    exit;
}

// Xử lý khi form đăng nhập được submit
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $pass = trim($_POST['password']);
    $hashedPass = md5($pass); // Hash mật khẩu

    // Lưu username vào session
    $_SESSION['username'] = $username;

    // Lấy thông tin user từ database
    $result = $model->getUser($username);

    // Kiểm tra kết quả
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($hashedPass === $row['matkhau']) {
            // Đăng nhập thành công
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            header('Location: ../View/admin/index.php');
            exit;
        } else {
            $_SESSION['error'] = "Bạn Đã Nhập Sai Mật Khẩu !!!";
            header("Location: ../index.php?controller=admin");
            exit(); 
        }
    } else {
        $_SESSION['error'] = "Username Không Tồn Tại !";
        header("Location: ../index.php?controller=admin");
        exit(); 
    }
}
?>
