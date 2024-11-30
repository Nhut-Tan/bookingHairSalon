
<div class="container mt-4">
    <h2 class="text-center">Danh Sách Cuộc Hẹn</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã cuộc hẹn</th>
                <th>Tên KH</th>
                <th>Dịch vụ</th>
                <th>Thời gian bắt đầu</th>
                <th>Nhân viên</th>
            </tr>
        </thead>
        <tbody>

          <?php foreach($result as $arr)
         
          {
            ?>
                <tr>
                    <td><?php echo $arr['mach'];?></td>
                    <td><?php echo $arr['tenkh'];?></td>
                    <td>
                        <?php
                       echo $arr['dichvudat'];
                       ?>
                    </td>
                    <td><?php echo $arr['giobd'];?></td>
                    <td><?php echo $arr['tennv'];?></td>
                   
          <?php  
          }
          ?>        
        </tbody>
    </table>
</div>

