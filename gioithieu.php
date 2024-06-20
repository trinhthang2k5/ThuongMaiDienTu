<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Web bán thiết bị điện tử</title>
	<link rel="stylesheet" href="css/main_style.css">
</head>
<body>
	<!-- Header -->	
	<header><?php require_once 'public/header.php';?></header>

	<!-- Body -->
	<div class="content-center-log main-body ">
		<!-- Danh mục -->
		<div style="width: 20%; float:left; overflow: hidden; box-sizing: border-box;">
			<?php include_once 'public/catelog.php';?>
			<?php include_once 'public/tuvan.php';?>
			<!--<?php include_once 'public/tintuc.php';?> -->
		</div>
		<!-- Nội dung -->
		<div>
            <h3>Giới thiệu</h3>
            <p>- Chào mừng bạn đến với trang thương mại điện tử của chúng tôi, nơi mang đến cho bạn những sản phẩm và dịch vụ chất lượng cao. Được thành lập từ năm 2024, chúng tôi không ngừng nỗ lực cải tiến và phát triển để mang đến trải nghiệm tốt nhất cho quý khách. Đội ngũ chuyên nghiệp và tận tâm của chúng tôi luôn sẵn sàng hỗ trợ và đồng hành cùng bạn trên mọi chặng đường. 
            </p>
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