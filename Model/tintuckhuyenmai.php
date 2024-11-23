<?php
require_once 'Database.php'; 

class Tintuckhuyenmai {
    // Lấy danh sách tất cả tin tức khuyến mãi
    public static function layDanhSachTinTuc() {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM tintuckhuyenmai ORDER BY ngaydang DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách tin tức
    }

    // Lấy một tin tức khuyến mãi theo ID
    public static function layTinTucTheoID($matintuc) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM tintuckhuyenmai WHERE matintuc = ?");
        $stmt->bind_param("i", $matintuc); // "i" cho kiểu INT
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result->fetch_assoc(); // Trả về tin tức với mã matintuc
    }

    // Thêm một tin tức khuyến mãi mới
    public static function taoTinTuc($data) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("INSERT INTO tintuckhuyenmai (tieude, noidung, hinhanh) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['tieude'], $data['noidung'], $data['hinhanh']); // "sss" cho kiểu string
        $stmt->execute();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }

    // Cập nhật tin tức khuyến mãi
    public static function capNhatTinTuc($matintuc, $data) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("UPDATE tintuckhuyenmai SET tieude = ?, noidung = ?, hinhanh = ? WHERE matintuc = ?");
        $stmt->bind_param("sssi", $data['tieude'], $data['noidung'], $data['hinhanh'], $matintuc); // "sssi" cho 3 string và 1 int
        $stmt->execute();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }

    // Xóa tin tức khuyến mãi
    public static function xoaTinTuc($matintuc) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("DELETE FROM tintuckhuyenmai WHERE matintuc = ?");
        $stmt->bind_param("i", $matintuc); // "i" cho kiểu INT
        $stmt->execute();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }
}
?>
