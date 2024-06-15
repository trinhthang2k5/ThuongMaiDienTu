<?php
include_once 'tmdt_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invoiceId']) && isset($_POST['newStatus'])) {
	$invoiceId = $_POST['invoiceId'];
	$newStatus = $_POST['newStatus'];
	$currentDate = date('Y-m-d H:i:s');

	// Update the status and possibly the delivery date
	if ($newStatus == 1) {
		$sql = "UPDATE hoa_don SET Trang_thai = 1, Ngay_giao_hang = '$currentDate' WHERE MaHD = $invoiceId";
	} else {
		$sql = "UPDATE hoa_don SET Trang_thai = 2 WHERE MaHD = $invoiceId";
	}

	if (mysqli_query($tmdtconn, $sql)) {
		echo "Success";
	} else {
		echo "Error: " . mysqli_error($tmdtconn);
	}
}
?>
