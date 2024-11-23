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

    public static function taoTinTuc($data, $file) {
        $db = new Database();
        $db->connect();
    
        try {
            // Xử lý upload hình ảnh
            $hinh = '';
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                $targetDir = "../../public/user/hinhkm/"; // Đường dẫn thư mục lưu ảnh
                $hinh = basename($file['name']);
                $targetFilePath = $targetDir . $hinh;
    
                // Di chuyển file từ tmp vào thư mục đích
                if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    throw new Exception("Không thể upload hình ảnh.");
                }
            }
    
            // Thêm tin tức vào cơ sở dữ liệu
            $stmt = $db->conn->prepare("INSERT INTO tintuckhuyenmai (tieude, noidung, hinhanh) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $data['tieude'], $data['noidung'], $hinh);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                $result = true; // Thành công
            } else {
                $result = false; // Thất bại
            }
    
            $stmt->close();
        } catch (Exception $e) {
            $result = false;
            error_log("Lỗi khi thêm tin tức: " . $e->getMessage());
        }
    
        $db->closeDatabase();
        return $result;
    }
    
    public static function  capNhatTinTuc($matintuc, $data, $file) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu
    
        try {
            // Lấy thông tin hiện tại của tin tức để kiểm tra ảnh cũ nếu có
            $stmt = $db->conn->prepare("SELECT hinhanh FROM tintuckhuyenmai WHERE matintuc = ?");
            $stmt->bind_param("i", $matintuc);
            $stmt->execute();
            $result = $stmt->get_result();
            $tintuc = $result->fetch_assoc();
    
            if ($tintuc) {
                // Xử lý hình ảnh mới (nếu có)
                $hinhanh = $tintuc['hinhanh']; // Giữ lại tên ảnh cũ nếu không upload ảnh mới
                if ($file && $file['error'] === UPLOAD_ERR_OK) {
                    // Nếu có ảnh mới, thay thế ảnh cũ
                    $targetDir = "../../public/user/hinhkm/"; // Đường dẫn thư mục lưu ảnh
                    $hinhanh = basename($file['name']);
                    $targetFilePath = $targetDir . $hinhanh;
    
                    // Di chuyển file từ tmp vào thư mục đích
                    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                        // Xóa ảnh cũ nếu có
                        if ($tintuc['hinhanh']) {
                            $oldFilePath = $targetDir . $tintuc['hinhanh'];
                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath);  // Xóa file ảnh cũ
                            }
                        }
                    } else {
                        throw new Exception("Không thể upload hình ảnh.");
                    }
                }
    
                // Cập nhật thông tin tin tức
                $stmt = $db->conn->prepare("UPDATE tintuckhuyenmai SET tieude = ?, noidung = ?, hinhanh = ? WHERE matintuc = ?");
                $stmt->bind_param("sssi", $data['tieude'], $data['noidung'], $hinhanh, $matintuc);
                $stmt->execute();
    
                if ($stmt->affected_rows > 0) {
                    $result = true; // Thành công
                } else {
                    $result = false; // Thất bại hoặc không có thay đổi
                }
    
                $stmt->close();
            } else {
                $result = false; // Tin tức không tồn tại
            }
        } catch (Exception $e) {
            $result = false;
            error_log("Lỗi khi sửa tin tức: " . $e->getMessage());
        }
    
        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result;
    }
    


    // Xóa tin tức khuyến mãi
    public static function xoaTinTuc($matintuc) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu
    
        try {
            // Lấy thông tin tin tức để lấy tên ảnh (nếu có) trước khi xóa
            $stmt = $db->conn->prepare("SELECT hinhanh FROM tintuckhuyenmai WHERE matintuc = ?");
            $stmt->bind_param("i", $matintuc); // "i" cho kiểu INT
            $stmt->execute();
            $result = $stmt->get_result();
            $tintuc = $result->fetch_assoc();
    
            if ($tintuc) {
                // Kiểm tra và xóa ảnh nếu có
                $hinhanh = $tintuc['hinhanh'];
                if ($hinhanh) {
                    $targetDir = "../../public/user/hinhkm/";
                    $targetFilePath = $targetDir . $hinhanh;
    
                    if (file_exists($targetFilePath)) {
                        unlink($targetFilePath); // Xóa file ảnh
                    }
                }
    
                // Thực thi câu lệnh xóa tin tức
                $stmt = $db->conn->prepare("DELETE FROM tintuckhuyenmai WHERE matintuc = ?");
                $stmt->bind_param("i", $matintuc); // "i" cho kiểu INT
                $stmt->execute();
    
                if ($stmt->affected_rows > 0) {
                    $result = true; // Thành công
                } else {
                    $result = false; // Thất bại
                }
    
                $stmt->close();
            } else {
                $result = false; // Tin tức không tồn tại
            }
        } catch (Exception $e) {
            $result = false;
            error_log("Lỗi khi xóa tin tức: " . $e->getMessage());
        }
    
        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result;
    }
    
}
?>
