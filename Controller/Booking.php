<?php
include ('../../Model/Cuochen.php');
class Booking{
    public static function getAllListBooking(){
        $result=Cuochen::layDsCuochen();
        require_once ('../../View/admin/pages/listBooking.php');    
    }
}
?>