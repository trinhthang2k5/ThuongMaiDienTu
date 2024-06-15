<?php 
$idSP = $_GET['prdid'];
require_once 'tmdt_connect.php';
$xoa_sql = "DELETE FROM san_pham WHERE MaSP=$idSP";

mysqli_query($tmdtconn, $xoa_sql);
header("Location: manager_product.php");
?>