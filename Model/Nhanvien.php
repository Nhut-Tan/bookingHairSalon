<?php
require_once 'Database.php'; 
class Nhanvien {
    // Hàm tạo nhân viên
    public static function taoNhanVien($data, $file) {
        $db = new Database();
        $db->connect();

        try {
            // Xử lý upload hình ảnh
            $hinh = '';
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                $targetDir = "../../public/user/hinhnv/"; // Đường dẫn thư mục lưu ảnh
                $hinh = basename($file['name']);
                $targetFilePath = $targetDir . $hinh;

                // Di chuyển file từ tmp vào thư mục đích
                if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    throw new Exception("Không thể upload hình ảnh.");
                }
            }

            // Thêm nhân viên vào cơ sở dữ liệu
            $stmt = $db->conn->prepare("INSERT INTO nhanvien (ten, sdt, email, hinh) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $data['ten'], $data['sdt'], $data['email'], $hinh);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $result = true; // Thành công
            } else {
                $result = false; // Thất bại
            }

            $stmt->close();
        } catch (Exception $e) {
            $result = false;
            error_log("Lỗi khi thêm nhân viên: " . $e->getMessage());
        }

        $db->closeDatabase();
        return $result;
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
    public static function xoaNhanVien($manv) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu
    
        try {
            // Lấy thông tin nhân viên để lấy tên ảnh (nếu có) trước khi xóa
            $stmt = $db->conn->prepare("SELECT hinh FROM nhanvien WHERE manv = ?");
            $stmt->bind_param("i", $manv);
            $stmt->execute();
            $result = $stmt->get_result();
            $nhanvien = $result->fetch_assoc();
    
            if ($nhanvien) {
                // Kiểm tra và xóa ảnh nếu có
                $hinh = $nhanvien['hinh'];
                if ($hinh) {
                    $targetDir = "../../public/user/hinhnv/";
                    $targetFilePath = $targetDir . $hinh;
    
                    if (file_exists($targetFilePath)) {
                        unlink($targetFilePath);  // Xóa file ảnh
                    }
                }
    
                // Thực thi câu lệnh xóa nhân viên
                $stmt = $db->conn->prepare("DELETE FROM nhanvien WHERE manv = ?");
                $stmt->bind_param("i", $manv);
                $stmt->execute();
    
                if ($stmt->affected_rows > 0) {
                    $result = true; // Thành công
                } else {
                    $result = false; // Thất bại
                }
    
                $stmt->close();
            } else {
                $result = false; // Nhân viên không tồn tại
            }
        } catch (Exception $e) {
            $result = false;
            error_log("Lỗi khi xóa nhân viên: " . $e->getMessage());
        }
    
        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result;
    }
     // Hàm sửa thông tin nhân viên
     public static function suaNhanVien($manv, $data, $file) {
        $db = new Database();
        $db->connect(); // Kết nối đến cơ sở dữ liệu

        try {
            // Lấy thông tin hiện tại của nhân viên để kiểm tra ảnh cũ nếu có
            $stmt = $db->conn->prepare("SELECT hinh FROM nhanvien WHERE manv = ?");
            $stmt->bind_param("i", $manv);
            $stmt->execute();
            $result = $stmt->get_result();
            $nhanvien = $result->fetch_assoc();

            if ($nhanvien) {
                // Xử lý hình ảnh mới (nếu có)
                $hinh = $nhanvien['hinh']; // Giữ lại tên ảnh cũ nếu không upload ảnh mới
                if ($file && $file['error'] === UPLOAD_ERR_OK) {
                    // Nếu có ảnh mới, thay thế ảnh cũ
                    $targetDir = "../../public/user/hinhnv/"; // Đường dẫn thư mục lưu ảnh
                    $hinh = basename($file['name']);
                    $targetFilePath = $targetDir . $hinh;

                    // Di chuyển file từ tmp vào thư mục đích
                    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                        // Xóa ảnh cũ nếu có
                        if ($nhanvien['hinh']) {
                            $oldFilePath = $targetDir . $nhanvien['hinh'];
                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath);  // Xóa file ảnh cũ
                            }
                        }
                    } else {
                        throw new Exception("Không thể upload hình ảnh.");
                    }
                }

                // Cập nhật thông tin nhân viên
                $stmt = $db->conn->prepare("UPDATE nhanvien SET ten = ?, sdt = ?, email = ?, hinh = ? WHERE manv = ?");
                $stmt->bind_param("ssssi", $data['ten'], $data['sdt'], $data['email'], $hinh, $manv);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $result = true; // Thành công
                } else {
                    $result = false; // Thất bại
                }

                $stmt->close();
            } else {
                $result = false; // Nhân viên không tồn tại
            }
        } catch (Exception $e) {
            $result = false;
            error_log("Lỗi khi sửa nhân viên: " . $e->getMessage());
        }

        $db->closeDatabase(); // Đóng kết nối cơ sở dữ liệu
        return $result;
    }
    
}
?>
