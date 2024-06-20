<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'tmdt';

// Mở kết nối
$conn = mysqli_connect($server, $username, $password, $database);

// Kiểm tra lỗi
if (!$conn) {
	die("Kết nối thất bại: " . mysqli_connect_error());
}

// Hàm định dạng tiền tệ
function formatCurrency($curr){
    return number_format($curr,0,",",".")." VNĐ";
}
// Hàm định dạng số
function formatNumber($num, $decimal){
	return number_format($num, $decimal, ',', '.'); // Định dạng kiểu thập phân là dấu <,>
}

?>