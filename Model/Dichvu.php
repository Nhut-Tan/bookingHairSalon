<?php
require_once 'Database.php'; 
class Dichvu {
    public static function layDanhSachDichVu() {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM dichvu");
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về tất cả dịch vụ
    }

    public static function layDichVuTheoID($madv) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM dichvu WHERE madv = ?");
        $stmt->bind_param("i", $madv);
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result->fetch_assoc(); // Trả về dịch vụ với mã madv
    }
    
    public static function taoDichVu($data) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("INSERT INTO dichvu (tendv, mota, gia, thoiluong, maloai) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $data['tendv'], $data['mota'], $data['gia'], $data['thoiluong'], $data['maloai']);
        $stmt->execute();
        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }
}
?>
