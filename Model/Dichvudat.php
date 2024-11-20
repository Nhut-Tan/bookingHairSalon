<?php
require_once 'Database.php';  // Giả sử bạn có lớp Database để kết nối cơ sở dữ liệu

class Dichvudat {

    public static function themDichVuVaoCuocHen($mach, $madv) {
        $db = new Database();
        $db->connect(); // Kết nối cơ sở dữ liệu
    
        // Kiểm tra xem dịch vụ này đã được thêm vào cuộc hẹn chưa
        $stmt = $db->conn->prepare("SELECT COUNT(*) FROM dichvudat WHERE mach = ? AND madv = ?");
        $stmt->bind_param("ii", $mach, $madv);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        
        if ($count > 0) {
            // Nếu dịch vụ đã tồn tại trong cuộc hẹn, không chèn thêm
        } else {
            // Nếu dịch vụ chưa tồn tại, thêm vào bảng dichvudat
            $stmt = $db->conn->prepare("INSERT INTO dichvudat (mach, madv) VALUES (?, ?)");
            $stmt->bind_param("ii", $mach, $madv);
            $stmt->execute();
        }
        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }
    

    // Lấy danh sách dịch vụ của một cuộc hẹn
    public static function layDichVuCuaCuocHen($mach) {
        $db = new Database();
        $db->connect(); // Kết nối cơ sở dữ liệu
        
        // Lấy danh sách dịch vụ đã chọn cho cuộc hẹn
        $stmt = $db->conn->prepare("SELECT d.tendv, d.mota, d.gia, d.thoiluong 
                                    FROM dichvudat dv 
                                    JOIN dichvu d ON dv.madv = d.madv
                                    WHERE dv.mach = ?");
        $stmt->bind_param("i", $mach);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách dịch vụ
    }

    // Xóa dịch vụ khỏi cuộc hẹn
    public static function xoaDichVuKhoiCuocHen($mach, $madv) {
        $db = new Database();
        $db->connect(); // Kết nối cơ sở dữ liệu
        
        // Xóa dịch vụ khỏi bảng dichvudat
        $stmt = $db->conn->prepare("DELETE FROM dichvudat WHERE mach = ? AND madv = ?");
        $stmt->bind_param("ii", $mach, $madv);
        $stmt->execute();
        
        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }
}
?>
