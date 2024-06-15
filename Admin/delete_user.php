<?php 
$id = $_GET['accid'];
require_once 'tmdt_connect.php';
$xoaacc_sql = "DELETE FROM quan_tri WHERE id=$id";
mysqli_query($tmdtconn, $xoaacc_sql);
header("Location: manager_account.php");
?>