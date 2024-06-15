<?php 
$idTT = $_GET['idtt'];
require_once 'tmdt_connect.php';
$xoatt_sql = "DELETE FROM tin_tuc WHERE MaTT=$idTT";
mysqli_query($tmdtconn, $xoatt_sql);
header("Location: manager_news.php");
?>