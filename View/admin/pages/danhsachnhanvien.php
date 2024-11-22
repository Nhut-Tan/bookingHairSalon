<?php if (!empty($nhanviens)): ?>
<div class="container mt-4">
    <h2 class="text-center">Danh Sách Nhân Viên</h2>
    <div class="text-right mb-3">
        <a href="?action=themNhanVien" class="btn btn-primary">Thêm Nhân Viên</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã Nhân Viên</th>
                <th>Họ Tên</th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Hình Ảnh</th>
                <th>Tác Vụ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nhanviens as $nhanvien): ?>
                <tr>
                    <td><?= $nhanvien['manv'] ?></td>
                    <td><?= $nhanvien['ten'] ?></td>
                    <td><?= $nhanvien['email'] ?></td>
                    <td><?= $nhanvien['sdt'] ?></td>
                    <td>
                        <img src="../../public/user/hinhnv/<?= $nhanvien['hinh'] ?>" alt="<?= $nhanvien['ten'] ?>" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>
                        <a href="?action=suaNhanVien&manv=<?= $nhanvien['manv'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="?action=xoaNhanVien&manv=<?= $nhanvien['manv'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <p class="text-center">Không có nhân viên nào trong danh sách.</p>
<?php endif; ?>
