<?php
require_once 'Database.php';

class Khachhang {

    // Lấy thông tin khách hàng theo email
    public static function layKhachHangTheoEmail($emailkh) {
        $db = new Database();
        $db->connect();
        $stmt = $db->conn->prepare("SELECT * FROM khachhang WHERE emailkh = ?");
        $stmt->bind_param("s", $emailkh);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Đảm bảo đóng kết nối sau khi lấy kết quả
        $db->closeDatabase();
        
        return $result->fetch_assoc(); // Trả về thông tin khách hàng
    }

    // Thêm khách hàng mới
    public static function themKhachHang($tenkh, $sdt, $emailkh) {
        $db = new Database();
        $db->connect();
        $stmt = $db->conn->prepare("INSERT INTO khachhang (ten, sdt, emailkh) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $tenkh, $sdt, $emailkh);
        $stmt->execute();
        
        // Đảm bảo đóng kết nối sau khi lấy insert_id
        $insert_id = $db->conn->insert_id;
        $db->closeDatabase();
        
        return $insert_id; // Trả về mã khách hàng vừa thêm
    }
}
