<?php
// Kết nối tới cơ sở dữ liệu và lấy danh sách nhân viên và dịch vụ
require_once '../Model/Dichvu.php';
require_once '../Model/Nhanvien.php';
require_once '../Model/Khachhang.php';
require_once '../Model/Cuochen.php';
require_once '../Model/Dichvudat.php';

// Lấy danh sách dịch vụ từ database
$dichvus = Dichvu::layDanhSachDichVu();
// Lấy danh sách nhân viên từ database
$nhanviens = Nhanvien::layDanhSachNhanVien();

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenkh = $_POST['tenkh'];
 
    $sdt = $_POST['sdt'];
    $emailkh = $_POST['emailkh'];
    $manv = $_POST['manv'];
    $giobd = $_POST['giobd'];
    $dichvu = $_POST['dichvu'];

    // Kiểm tra thông tin khách hàng, nếu không có thì thêm mới
    $khachhang = Khachhang::layKhachHangTheoEmail($emailkh);
    if (!$khachhang) {
        $makh = Khachhang::themKhachHang($tenkh, $sdt, $emailkh);
    } else {
        $makh = $khachhang['makh'];
    }

    // Tính toán giờ kết thúc
    $thoiluong = 0;
    foreach ($dichvu as $madv) {
        $dichvuInfo = Dichvu::layDichVuTheoID($madv);
        $thoiluong += $dichvuInfo['thoiluong']; // Tổng thời gian của dịch vụ
    }

    // Tính giờ kết thúc
    $giokt = date('Y-m-d H:i:s', strtotime($giobd) + $thoiluong * 60);

    // Tạo cuộc hẹn
    $data = [
        'makh' => $makh,
        'manv' => $manv,
        'giobd' => $giobd,
        'giokt' => $giokt,
        'dichvu' => $dichvu
    ];
    $mach = Cuochen::taoCuocHen($data);

    // Thêm các dịch vụ vào cuộc hẹn
    foreach ($dichvu as $madv) {
        Dichvudat::themDichVuVaoCuocHen($mach, $madv);
    }

    // Thông báo thành công
    echo "Cuộc hẹn đã được đặt thành công. Mã cuộc hẹn: " . $mach;
}
?>
