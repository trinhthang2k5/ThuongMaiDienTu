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
            <h3>Tổng Đài Hỗ Trợ</h3>
            <p>- Để đảm bảo mọi thắc mắc và yêu cầu của quý khách được giải quyết một cách nhanh chóng và hiệu quả, chúng tôi cung cấp dịch vụ tổng đài hỗ trợ 24/7. Bạn có thể liên hệ với chúng tôi qua số điện thoại [số điện thoại] hoặc email [email hỗ trợ] để được tư vấn và hỗ trợ kịp thời. Đội ngũ nhân viên chuyên nghiệp và giàu kinh nghiệm của chúng tôi luôn sẵn sàng lắng nghe và giải đáp mọi câu hỏi của bạn, từ thông tin sản phẩm, dịch vụ đến hỗ trợ kỹ thuật và xử lý khiếu nại. 
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