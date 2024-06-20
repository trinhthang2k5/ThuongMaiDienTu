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
            <h3>Khuyến Mại</h3>
            <p>- Chúng tôi luôn mang đến cho khách hàng những chương trình khuyến mại hấp dẫn và đa dạng, từ giảm giá sản phẩm, quà tặng kèm đến tích điểm đổi thưởng. Để không bỏ lỡ những ưu đãi đặc biệt, hãy theo dõi trang web và fanpage của chúng tôi thường xuyên. Đặc biệt, khi đăng ký làm thành viên của trang thương mại điện tử, bạn sẽ nhận ngay ưu đãi hấp dẫn và được cập nhật những chương trình khuyến mại mới nhất qua email hoặc tin nhắn SMS.
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