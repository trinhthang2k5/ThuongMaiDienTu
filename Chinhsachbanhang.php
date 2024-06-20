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
            <h3>Chính Sách Bán Hàng</h3>
            <p>- Tại trang thương mại điện tử, chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng với chính sách bán hàng minh bạch và công bằng. Mọi sản phẩm đều được niêm yết giá rõ ràng và không có phí ẩn. Chúng tôi cung cấp nhiều hình thức thanh toán linh hoạt, từ chuyển khoản ngân hàng, thẻ tín dụng đến thanh toán khi nhận hàng. Bên cạnh đó, chính sách đổi trả hàng trong vòng 15 ngày và bảo hành lên đến 1 năm giúp bạn yên tâm hơn khi mua sắm tại đây. 
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