<?php
require_once '../Model/Database.php';
$db = new Database();
$db->connect();
if ($db->conn) {
    echo "Database connected successfully!";
} else {
    echo "Failed to connect to the database.";
}
$db->closeDatabase();
?>
