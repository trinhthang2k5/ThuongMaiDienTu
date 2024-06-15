<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="fontawesome pro 6.3.0/fontawesome pro 6.3.0/FontAwesome.Pro.6.3.0/css/all.css">
	<link rel="stylesheet" href="css/main_style.css">
	<title>Document</title>
	
</head>
<body>
	<div class="content-center" style="color: white">
	<div class="menu">
		<li><a href="trangchu.php">TRANG CHỦ</a>|</li>
		<li><a href="">TỔNG ĐÀI HỖ TRỢ</a>|</li>
		<li><a href="">CHÍNH SÁCH BÁN HÀNG</a>|</li>
		<li><a href="">KHUYẾN MÃI</a>|</li>
		<li><a href="">TRUNG TÂM DỊCH VỤ</a>|</li>
		<li><a href="">TIN TỨC</a>|</li>
		<a href="customer_register.php"><i class="fa-thin fa-user"></i> ĐĂNG KÝ </a>|	
		<a href="customer_login.php">ĐĂNG NHẬP</a>
	</div>
	<!-- Mở kết nối tới csdl -->
	<?php include_once 'bk_connect.php';?>
	
	<div style="width: 60%; float: left; line-height: 100px">
		<h1 style="text-transform: uppercase;"><a href="index.php">Hệ thống bán hàng trực tuyến</a></h1>
	</div>
	<div style="width: 40%; float: left; line-height: 100px">
		<!-- Form tìm kiếm -->
		<form action="#" method="GET" style="width: 100%; float: right; height: 50px; padding: 0px; margin: 0px; line-height: 50px; margin-right: 5px; text-align: right;">
			<input id="search" name="search" type="text" placeholder="Tìm kiếm">
			<input type="submit" name="submit" value="Tìm kiếm">
		</form>
		
		<!-- Tài khoản đăng nhập / giỏ hàng -->
		<div style="width: 100%;float: right; height: 50px; padding: 0px; margin: 0px; line-height: 50px; text-align: right; vertical-align: middle;">
			<a style="float: right" href="shopping_cart.php"><img src="public/images/ic_cart.png" alt="Giỏ hàng"></a>
			<?php
				session_start();
				if (isset($_SESSION["username"])) {
					echo "Xin chào " . $_SESSION["username"] . " (<a href='public/logout.php'>Thoát</a>)";	
				} else {		
			?>
			<?php } ?>
		</div>
	</div>
</div>
</body>
</html>
