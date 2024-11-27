<?php
include ('../../Model/Cuochen.php');
class Booking{
    public static function getAllListBooking(){
        $result=Cuochen::layDsCuochen();
        //$admin_subview='listBooking.php';
        require_once ('../../View/admin/pages/listBooking.php');
       
    }
}
?>