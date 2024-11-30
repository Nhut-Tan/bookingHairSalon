<?php
require_once 'Database.php'; 

class Dichvu {
    public static function layDanhSachDichVu() {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu
        $conn = $db->getConnection(); // Lấy đối tượng kết nối PDO

        $stmt = $conn->prepare("SELECT * FROM dichvu");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy tất cả kết quả dưới dạng mảng liên kết

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result;
    }

    public static function layDichVuTheoID($madv) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu
        $conn = $db->getConnection(); // Lấy đối tượng kết nối PDO

        $stmt = $conn->prepare("SELECT * FROM dichvu WHERE madv = :madv");
        $stmt->bindParam(':madv', $madv, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Lấy một hàng dữ liệu dưới dạng mảng liên kết

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result;
    }
    
    public static function taoDichVu($data) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu
        $conn = $db->getConnection(); // Lấy đối tượng kết nối PDO

        $stmt = $conn->prepare("INSERT INTO dichvu (tendv, mota, gia, thoiluong, maloai) 
                                    VALUES (:tendv, :mota, :gia, :thoiluong, :maloai)");
        $stmt->bindParam(':tendv', $data['tendv'], PDO::PARAM_STR);
        $stmt->bindParam(':mota', $data['mota'], PDO::PARAM_STR);
        $stmt->bindParam(':gia', $data['gia'], PDO::PARAM_STR); // Nếu giá là float hoặc số thực
        $stmt->bindParam(':thoiluong', $data['thoiluong'], PDO::PARAM_INT);
        $stmt->bindParam(':maloai', $data['maloai'], PDO::PARAM_INT);
        $stmt->execute();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }
}
