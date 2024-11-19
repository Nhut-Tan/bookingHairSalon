<?php
require_once 'Database.php'; 
class Nhanvien {
    // Hàm tạo nhân viên
    public static function taoNhanVien($data) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        // Thêm nhân viên vào bảng nhanvien
        $stmt = $db->conn->prepare("INSERT INTO nhanvien (ten, sdt, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $data['ten'], $data['ho'], $data['sdt'], $data['email']);
        $stmt->execute();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }

    // Hàm lấy thông tin một nhân viên theo mã nhân viên
    public static function layNhanVien($manv) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM nhanvien WHERE manv = ?");
        $stmt->bind_param("i", $manv);
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result->fetch_assoc(); // Trả về thông tin nhân viên
    }

    // Hàm lấy tất cả nhân viên từ cơ sở dữ liệu
    public static function layDanhSachNhanVien() {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM nhanvien");
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu

        return $result->fetch_all(MYSQLI_ASSOC); // Trả về tất cả các nhân viên dưới dạng mảng
    }
}
?>
