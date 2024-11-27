<?php
// Kết nối tới cơ sở dữ liệu và lấy danh sách nhân viên và dịch vụ
require_once 'Model/Dichvu.php';
require_once 'Model/Nhanvien.php';
require_once 'Model/Khachhang.php';
require_once 'Model/Cuochen.php';
require_once 'Model/Dichvudat.php';

class DatCuocHenController {

    private $dichvus;
    private $nhanviens;

    // Constructor để khởi tạo dữ liệu
    public function __construct() {
        // Lấy danh sách dịch vụ và nhân viên từ database
        $this->dichvus = Dichvu::layDanhSachDichVu();
        $this->nhanviens = Nhanvien::layDanhSachNhanVien();
    }

    public static function hienThiFormDatLich() {
        include 'View/user/formdatlich.php';  
    }

    public static function datlich() {
        // Xử lý khi form được submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra sự tồn tại của các chỉ mục trước khi truy cập
            $tenkh = isset($_POST['tenkh']) ? $_POST['tenkh'] : '';
            $sdt = isset($_POST['sdt']) ? $_POST['sdt'] : '';
            $emailkh = isset($_POST['emailkh']) ? $_POST['emailkh'] : '';
            $manv = isset($_POST['manv']) ? $_POST['manv'] : '';
            $giobd = isset($_POST['giobd']) ? $_POST['giobd'] : '';
            $dichvu = isset($_POST['dichvu']) ? $_POST['dichvu'] : [];

            // Kiểm tra xem các giá trị đã có đúng không
            if (empty($tenkh) || empty($sdt) || empty($emailkh) || empty($manv) || empty($giobd) || empty($dichvu)) {
                // Nếu có trường nào còn trống, có thể thông báo lỗi cho người dùng
                echo "Vui lòng điền đầy đủ thông tin!";
                header("Location: index.php?controller=hienthiformdatlich");
                exit(); 
                return; // Dừng thực thi nếu thiếu thông tin
            }

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
            include 'View/user/datlichthanhcong.php';
            exit;
        }
    }
}
?>
