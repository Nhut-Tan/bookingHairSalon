<!DOCTYPE html>
<html lang="en">

<head>
  <title>IRON CAP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="Public/user/style.css">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="Public/user/css/ionicons.min.css">
  <link rel="stylesheet" href="Public/user/css/style.css">

</head>

<body>

   <!-- Phần điều hướng (Navbar) -->
   <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
    <div class="container-fluid">
      <div class="col-2 col-sm-1">
        <img class="logo img-fluid" src="Public/user/HinhAnhThuoc/images.jfif" alt="">
      </div>
      <div class="col-9 col-sm-2">
        <a class="navbar-brand" href="#" style="color: aliceblue; font-size: 40px;">IRONCAP</a>
      </div>
      <div class="col-1">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbarNav">
      <div class="col-sm-7">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="gap: 40px;">
            <li class="nav-item">
                <a class="nav-link text-light" href="index.php">
                    <i class="bi bi-house-door"></i> Trang Chủ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="#dichvu">
                    <i class="bi bi-gear"></i> Dịch Vụ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="#khuyenmai">
                    <i class="bi bi-tag"></i> Tin Tức Khuyến Mãi
                </a>
            </li>
        </ul>
        </div>
        <div class="col-sm-5">
         <!-- header.php -->
         <form class="d-flex" method="POST" action="index.php?controller=hienthiformdatlich" onsubmit="return validatePhoneNumber()">
               <input style="border-radius:15px; font-size: 17px; margin-top:6px;" class="form-control me-2" type="text" placeholder="Nhập Số Điện Thoại Để Đặt Lịch" aria-label="nhap so dt" name="sdt" id="sdt" value="<?php echo isset($_POST['sdt']) ? $_POST['sdt'] : ''; ?>">
               <button class="btn btn-outline-light" style="font-size: 17px; font-weight: bold; border-radius:15px;" type="submit">ĐẶT LỊCH</button>
         </form>
        </div>
      </div>
    </div>
  </nav>

  <script>

    function validatePhoneNumber() {
    const phoneNumber = document.getElementById('sdt').value;

    // Kiểm tra độ dài tối đa 10 số
    if (phoneNumber.length != 10 ) {
      alert("Số điện thoại Sai ");
      return false;
    }

    // Kiểm tra xem số điện thoại chỉ chứa chữ số
    if (!/^\d*$/.test(phoneNumber)) {
      alert("Số điện thoại chỉ được chứa các chữ số!");
      return false;
    }

    return true;
  }
    // Lấy thanh menu
    const navbar = document.getElementById("navbar");

    // Lắng nghe sự kiện cuộn trang
    window.onscroll = function () {
      stickyNavbar();
    };

    // Thêm/loại bỏ lớp sticky khi cuộn trang
    function stickyNavbar() {
      if (window.pageYOffset > navbar.offsetTop) {
        navbar.classList.add("sticky");
      } else {
        navbar.classList.remove("sticky");
      }
    }
  </script>