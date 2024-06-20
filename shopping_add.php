<?php
session_start();
if (isset($_GET["MaSP"])) {	
	$idp = $_GET["MaSP"];	
	
	// Kiểm tra đã có biến session giỏ hàng chưa
	if (isset($_SESSION["cart"][$idp])) {
		$_SESSION["cart"][$idp] += 1;
	} else {
		$_SESSION["cart"][$idp] = 1;
	}

	header("Location: shopping_cart.php");
	
}
?>