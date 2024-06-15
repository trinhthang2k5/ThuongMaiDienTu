<?php 
			include_once 'tmdt_connect.php';
			require_once 'upload_file.php';
			?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="../css/main_style.css">
	<!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
		.phan-trang{
			width: 100%; 
			text-align: center; 
			list-style: none; 
			list-style: none;
			font-weight: bold;
			font-size: 1.5em;
			overflow: hidden;
			margin-bottom: 10px; 
		}
		.phan-trang li{			
			display: inline;
		}
		.phan-trang a{
			padding: 10px;
			border: 1px solid #ebebeb;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<!-- Header -->	
	<header><?php require_once 'header.php';?></header>

	<!-- Body -->
	<div class="content-center main-body">
		<!-- Danh mục -->
		<div style="width: 20%; float:left; overflow: hidden; box-sizing: border-box;">
			<?php include_once 'menu.php';?>
		</div>
		<!-- Nội dung -->
		<div style="width: 80%; float:left; overflow: hidden; box-sizing: border-box; padding: 10px;">
			<!-- Trang quản lý khách hàng -->
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý Khách Hàng</h1>
		
			<?php
				$page = 0;
				$items_per_page = 5; // Số lượng mục trên mỗi trang
				
				if (isset($_GET["page"])) {
					$page = $_GET["page"] - 1;
				}
				
				// Lấy tổng số trang
				$sql = "SELECT CEIL(COUNT(*) / $items_per_page) AS 'totalpage' FROM `khach_hang`";
				$result = mysqli_query($tmdtconn, $sql);
				$totalpage = 0;
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)){
						$totalpage = $row["totalpage"];
					}
				}
				
				// Tính toán offset
				$offset = $page * $items_per_page;

				// Lấy items trong trang
				$sql = "SELECT * FROM `khach_hang` 
				
				LIMIT ".$offset.", 5";
				// echo $sql;

				$result = mysqli_query($tmdtconn, $sql); // Truy vấn
				// $result = mysqli_multi_query($tmdtconn, $sql); // Truy vấn

				// Duyệt hiển thị dữ liệu
				if (mysqli_num_rows($result) > 0) {
			?>
				<div class="container mt-3">          
					<form action="#" method="post">
						<table class="table table-bordered">
						<thead> 
							<tr>
								<th>Mã khách hàng</th>
								<th>Tên khách hàng</th>
								<th>Địa chỉ</th>
								<th>Điện thoại</th>
								<th>Email</th>
								<th>Giới tính</th>
								<th>Hoạt động</th>
							</tr>	
						</thead>
						<tbody>
							<?php
								// Duyệt vòng lặp lấy dữ liệu 
								while ($row = mysqli_fetch_assoc($result)) {
							?>
							<tr>
								<td><?php echo $row["MaKH"] ?></td>
								<td><?php echo $row["Ho_ten"] ?></td>
								<td><?php echo $row["Dia_chi"] ?></td>
								<td><?php echo $row["Dien_thoai"] ?></td>
								<td><?php echo $row["Email"] ?></td>
								<?php 
								if ($row["Gioi_tinh"] == 1) {
									echo "<td>Nam</td>";
								} else {
									echo "<td>Nữ</td>";
								} 
								?>
								<td><a onclick="return confirm('Bạn có muốn xóa khách hàng này không?');" 
								href="delete_customer.php?idkh=<?php echo $row["MaKH"] ?>" class="btn btn-danger">Xóa</a></td>
							</tr>
								<?php } ?>
						</tbody>
						</table>
					</form>
				</div>
					<br> 
					<ul class="phan-trang">
					<?php
						for ($i=1; $i <= $totalpage; $i++) { 
						echo "<li><a href='?page=".$i."'>".$i."</a></li>";
						}
					?>
					</ul>	
					<?php
						} else {
							echo "<span class='error'>Không tìm thấy sản phẩm phù hợp</span>";
						}
					?>

		</div>
	</div>
</body>
</html>