<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="css/main_style.css">
</head>
<body>
	<!-- Header -->	
	<header><?php require_once 'public/header.php';?></header>

	<!-- Body -->
	<div class="content-center main-body">
	<!-- Danh mục menu trái -->
		<div style="width: 20%; float:left; overflow: hidden; box-sizing: border-box;">
			<?php include_once 'public/catelog.php';?>
		</div>
	<!-- Hiển thị thông tin sản phẩm-->
		<div style="width: 80%; overflow: hidden; box-sizing: border-box;padding:5px">
			<?php include_once 'public/slider.php';?>
		</div>
	</div>
	 <!--Hiển thị các sản phẩm-->
	<div class="mainproduct">
	<div style="width: 100%;overflow: hidden; box-sizing: border-box; padding: 10px">
			<?php include_once 'public/content-center1.php';?>
	</div>
	</div>
	<!-- Footer -->
	<footer>
		<div class="content-center">
			<?php include_once 'public/footer.php';?>
		</div>
	</footer>
</body>
</html>