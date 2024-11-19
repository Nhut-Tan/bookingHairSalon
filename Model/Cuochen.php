<?php
require_once 'Database.php'; 
class Cuochen {
    // Tạo cuộc hẹn
    public static function taoCuocHen($data) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        // Tạo cuộc hẹn trong bảng cuochhen
        $stmt = $db->conn->prepare("INSERT INTO cuochhen (makh, manv, giobd, giokt) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die('Error preparing SQL statement: ' . $db->conn->error);
        }

        // Bind params và execute
        $stmt->bind_param("iiss", $data['makh'], $data['manv'], $data['giobd'], $data['giokt']);
        $stmt->execute();

        // Kiểm tra nếu việc insert thành công
        if ($stmt->affected_rows > 0) {
            $mach = $db->conn->insert_id; // Lấy mã cuộc hẹn vừa tạo

            // Gắn dịch vụ vào cuộc hẹn
            foreach ($data['dichvu'] as $madv) {
                $stmt = $db->conn->prepare("INSERT INTO dichvudat (mach, madv) VALUES (?, ?)");
                $stmt->bind_param("ii", $mach, $madv);
                $stmt->execute();
            }

            $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
            return $mach;
        } else {
            // Nếu không có dòng nào được affected
            echo "Lỗi khi tạo cuộc hẹn!";
            return false;
        }
    }

    // Hủy cuộc hẹn
    public static function huyCuocHen($mach) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        // Cập nhật trạng thái hủy cho cuộc hẹn
        $stmt = $db->conn->prepare("UPDATE cuochhen SET huy = TRUE WHERE mach = ?");
        $stmt->bind_param("i", $mach);
        $stmt->execute();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
    }

    // Lấy danh sách cuộc hẹn
    public static function layDanhSachCuocHen() {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        $stmt = $db->conn->prepare("SELECT * FROM cuochhen");
        $stmt->execute();
        $result = $stmt->get_result();

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách cuộc hẹn
    }
}
?>
