<?php
require_once('Database.php');
    class Login extends Database
    {
        public function getUser($username){
            $db=new Database();
            $db->connect();
            $sql = "SELECT maqt,tendn,matkhau FROM quantrivien WHERE tendn = ? ";
            $stmt =$db->conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
    }
?>