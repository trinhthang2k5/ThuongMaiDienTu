<?php 
$idKH = $_GET['idkh'];
require_once 'tmdt_connect.php';
$xoa_sql = "DELETE FROM khach_hang WHERE MaKH=$idKH";
mysqli_query($tmdtconn, $xoa_sql);
header("Location: manager_customer.php");
?>