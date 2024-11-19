<?php
// Kết nối tới cơ sở dữ liệu và lấy danh sách nhân viên và dịch vụ
require_once '../Model/Dichvu.php';
require_once '../Model/Nhanvien.php';

// Lấy danh sách dịch vụ từ database
$dichvus = Dichvu::layDanhSachDichVu();
// Lấy danh sách nhân viên từ database
$nhanviens = Nhanvien::layDanhSachNhanVien();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Cuộc Hẹn</title>
</head>
<body>
    <h1>Đặt Cuộc Hẹn</h1>
    <form action="../Controller/DatCuocHenController.php" method="POST">
        <!-- Thông tin khách hàng -->
        <label for="tenkh">Tên Khách Hàng:</label>
        <input type="text" id="tenkh" name="tenkh" required><br><br>

        <label for="sdt">Số Điện Thoại:</label>
        <input type="text" id="sdt" name="sdt" value="<?php echo isset($_POST['sdt']) ? $_POST['sdt'] : ''; ?>" required><br><br>

        <label for="emailkh">Email:</label>
        <input type="email" id="emailkh" name="emailkh" required><br><br>

        <!-- Chọn nhân viên -->
        <label for="manv">Chọn Nhân Viên:</label>
        <select name="manv" id="manv" required>
            <?php foreach ($nhanviens as $nhanvien): ?>
                <option value="<?= $nhanvien['manv'] ?>"><?= $nhanvien['ten'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <!-- Chọn dịch vụ -->
        <label for="dichvu">Chọn Dịch Vụ:</label><br>
        <?php foreach ($dichvus as $dichvu): ?>
            <input type="checkbox" name="dichvu[]" value="<?= $dichvu['madv'] ?>" data-thoiluong="<?= $dichvu['thoiluong'] ?>"> 
            <?= $dichvu['tendv'] ?> (Thời gian: <?= $dichvu['thoiluong'] ?> phút)<br>
        <?php endforeach; ?>
        <br>

        <!-- Thời gian bắt đầu -->
        <label for="giobd">Giờ Bắt Đầu:</label>
        <input type="datetime-local" id="giobd" name="giobd" required><br><br>

        <label for="giokt">Giờ Kết Thúc:</label>
        <input type="text" id="giokt" name="giokt" readonly><br><br>

        <button type="submit">Đặt Cuộc Hẹn</button>
    </form>

    <script>
      // Hàm tính thời gian kết thúc dựa trên dịch vụ đã chọn
document.querySelectorAll('input[name="dichvu[]"]').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        calculateEndTime();
    });
});

// Hàm tính thời gian kết thúc
function calculateEndTime() {
    let totalDuration = 0;
    let startTime = document.getElementById('giobd').value;

    // Tính tổng thời gian của các dịch vụ đã chọn
    document.querySelectorAll('input[name="dichvu[]"]:checked').forEach(function (checkbox) {
        totalDuration += parseInt(checkbox.getAttribute('data-thoiluong'));
    });

    if (startTime && totalDuration > 0) {
        let startDate = new Date(startTime);
        startDate.setMinutes(startDate.getMinutes() + totalDuration);  // Cộng thời gian vào

        // Hiển thị thời gian kết thúc
        document.getElementById('giokt').value = startDate.toISOString().slice(0, 16);  // Đảm bảo định dạng ISO
    }
}

// Tính thời gian kết thúc khi người dùng thay đổi giờ bắt đầu
document.getElementById('giobd').addEventListener('change', function () {
    calculateEndTime();
});

    </script>
</body>
</html>
