<?php
require_once 'Database.php'; 
class Quantrivien {
    public static function taoQuanTriVien($data) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        // Thêm quản trị viên vào bảng quantrivien
        $stmt = $db->conn->prepare("INSERT INTO quantrivien (tendn, email, hoten, matkhau) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $data['tendn'], $data['email'], $data['hoten'], $data['matkhau']);
        $stmt->execute();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }

    public static function layQuanTriVien($maqt) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM quantrivien WHERE maqt = ?");
        $stmt->bind_param("i", $maqt);
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result->fetch_assoc(); // Trả về thông tin quản trị viên
    }
}
?>
