<?php

// Mở kết nối
$tmdtconn = mysqli_connect('localhost','root','','tmdt');

// Kiểm tra lỗi
if (!$tmdtconn) {
	die("Kết nối thất bại: " . mysqli_connect_error());
}

// Hàm định dạng tiền tệ
function formatCurrency($curr){
	return number_format($curr,0,",","."). " VNĐ";
	// $fmt = numfmt_create("vi_VN", NumberFormatter::CURRENCY);
	// return numfmt_format_currency($fmt, $curr, "VND");
}

// Hàm định dạng số
function formatNumber($num, $decimal){
	return number_format($num, $decimal, ',', '.'); // Định dạng kiểu thập phân là dấu <,>
}

?>