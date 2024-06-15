<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="css/main_style.css">
	<script type="text/javascript" src="js/main_script.js"></script>
</head>
<body>
	<!-- Header -->	
	<header><?php require_once 'public/header.php';?></header>

	<!-- Body -->
	<div class="content-center main-body">
		<!-- Danh mục -->
		<div style="width: 20%; float:left; overflow: hidden; box-sizing: border-box;">
			<?php include_once 'public/catelog.php';?>
		</div>
		<!-- Nội dung -->
		<div style="width: 80%; float:left; overflow: hidden; box-sizing: border-box; padding: 10px">
			<?php 
				echo "<h1>Thông tin sản phẩm</h1>";
				
				if (isset($_GET["prodId"])) {
					$sql = "SELECT * FROM `product` WHERE id = " . $_GET["prodId"];
					$result = mysqli_query($bkconn, $sql);
					if(mysqli_num_rows($result) == 1){
						while ($row = mysqli_fetch_assoc($result)) {
							// Sản phẩm chi tiết
							echo "<div class='product-detail'>";
							echo "<a href='product_detail.php?prodId=".$row["id"]."'><img width='290px' height='290px' src='public/images/".$row["imagelink"]."' alt='hp123'></a> <br>";
							echo "<h3>".$row["name"]."</h3>";
							$fmt = numfmt_create("vi_VN", NumberFormatter::CURRENCY);
							echo "<div class='box-desc'><b>Giá:</b>".numfmt_format_currency($fmt, $row["price"], "VND")."</div>";
							echo "<p style='text-align:left'>".$row["detail"]."</p>";						
							echo "<a href='shopping_add.php?prodId=".$row["id"]."'><button class='box-buy'>MUA</button></a>";
							echo "</div>";
						}						
					}
				}
			?>			
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