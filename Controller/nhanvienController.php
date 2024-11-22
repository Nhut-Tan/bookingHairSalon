<?php
require_once '../../Model/Nhanvien.php';

class nhanvienController {
    public static function hienThiDanhSachNhanVien() {
        $nhanviens = Nhanvien::layDanhSachNhanVien();
        include '../../View/admin/pages/danhsachnhanvien.php';
    }
}
?>
