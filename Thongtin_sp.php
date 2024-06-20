<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Web bán thiết bị điện tử</title>
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
				
				if (isset($_GET["MaSP"])) {
					$sql = "SELECT * FROM `san_pham` WHERE MaSP = " . $_GET["MaSP"];
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result) == 1){
						while ($row = mysqli_fetch_assoc($result)) {
							// Sản phẩm chi tiết
							echo "<div class='Thongtin_sp'>";
							echo "<a href='Thongtin_sp.php?MaSP=".$row["MaSP"]."'><img width='400px' height='400px' src='public/images/".$row["Hinh_anh"]."' alt='hp123'></a> <br>";
							echo "<h3>".$row["Ten_sp"]."</h3>";
							echo "<div class='box-desc'>".$row["Mo_ta"]."</div>";
							echo "<div class='box-desc'>".$row["Thong_tin"]."</div>";
							// Định dạng giá tiền
                            $price = number_format($row["Gia_ban"], 0, ',', '.'); // Số thập phân là 0, dấu phân cách hàng nghìn là "," và dấu phân cách thập phân là "."

                            // Hiển thị giá tiền với định dạng VND
                            echo "<div class='box-desc'><b>Giá:</b> " . $price . " VND</div>";						
							echo "<a href='shopping_add.php?MaSP=".$row["MaSP"]."'><button class='box-buy'>MUA</button></a>";
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