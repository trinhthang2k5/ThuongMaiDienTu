<?php 
$idLSP = $_GET['ctlid'];
require_once 'tmdt_connect.php';
$xoalsp_sql = "DELETE FROM loai_san_pham WHERE MaLSP=$idLSP";
mysqli_query($tmdtconn, $xoalsp_sql);
header("Location: manager_catelog.php");
?>