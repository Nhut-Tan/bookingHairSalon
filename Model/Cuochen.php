<?php
require_once 'Database.php'; 

class Cuochen {
    // Tạo cuộc hẹn
    public static function taoCuocHen($data) {
        $db = new Database();
        $db->connect();

        try {
            $conn = $db->getConnection();

            // Bắt đầu transaction
            $conn->beginTransaction();

            // Tạo cuộc hẹn trong bảng cuochhen
            $stmt = $conn->prepare("INSERT INTO cuochhen (makh, manv, giobd, giokt) VALUES (:makh, :manv, :giobd, :giokt)");
            $stmt->bindParam(':makh', $data['makh']);
            $stmt->bindParam(':manv', $data['manv']);
            $stmt->bindParam(':giobd', $data['giobd']);
            $stmt->bindParam(':giokt', $data['giokt']);
            $stmt->execute();

            // Lấy mã cuộc hẹn vừa tạo
            $mach = $conn->lastInsertId();

            // Gắn dịch vụ vào cuộc hẹn
            $stmt = $conn->prepare("INSERT INTO dichvudat (mach, madv) VALUES (:mach, :madv)");
            foreach ($data['dichvu'] as $madv) {
                $stmt->bindParam(':mach', $mach);
                $stmt->bindParam(':madv', $madv);
                $stmt->execute();
            }

            // Commit transaction
            $conn->commit();

            $db->closeDatabase();
            return $mach;
        } catch (Exception $e) {
            // Rollback transaction nếu có lỗi
            $conn->rollBack();
            error_log("Lỗi khi tạo cuộc hẹn: " . $e->getMessage());
            return false;
        }
    }

    // Hủy cuộc hẹn
    public static function huyCuocHen($mach) {
        $db = new Database();
        $db->connect();

        try {
            $conn = $db->getConnection();

            // Cập nhật trạng thái hủy cho cuộc hẹn
            $stmt = $conn->prepare("UPDATE cuochhen SET huy = TRUE WHERE mach = :mach");
            $stmt->bindParam(':mach', $mach, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->rowCount() > 0; // Kiểm tra nếu có dòng nào bị ảnh hưởng
        } catch (Exception $e) {
            error_log("Lỗi khi hủy cuộc hẹn: " . $e->getMessage());
            $result = false;
        }

        $db->closeDatabase();
        return $result;
    }

    // Lấy danh sách cuộc hẹn
    public static function layDanhSachCuocHen() {
        $db = new Database();
        $db->connect();

        try {
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM cuochhen");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy danh sách cuộc hẹn
        } catch (Exception $e) {
            error_log("Lỗi khi lấy danh sách cuộc hẹn: " . $e->getMessage());
            $result = false;
        }

        $db->closeDatabase();
        return $result;
    }

    // Lấy danh sách chi tiết các cuộc hẹn
    public static function layDsCuochen() {
        $db = new Database();
        $db->connect();

        try {
            $conn = $db->getConnection();

            $stmt = $conn->prepare("
                SELECT c.mach, c.giobd, kh.ten AS tenkh, nv.ten AS tennv, 
                       GROUP_CONCAT(dv.tendv SEPARATOR ', ') AS dichvudat
                FROM cuochhen c
                JOIN khachhang kh ON c.makh = kh.makh
                JOIN nhanvien nv ON c.manv = nv.manv
                JOIN dichvudat dvd ON c.mach = dvd.mach
                JOIN dichvu dv ON dvd.madv = dv.madv
                GROUP BY c.mach, kh.ten, nv.ten
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy danh sách chi tiết cuộc hẹn: " . $e->getMessage());
            $result = false;
        }

        $db->closeDatabase();
        return $result;
    }
}
?>