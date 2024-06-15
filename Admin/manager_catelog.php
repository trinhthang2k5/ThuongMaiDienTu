<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>QL Sản phẩm</title>
	<link rel="stylesheet" href="../css/main_style.css">
	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		.phan-trang {
			width: 100%; 
			text-align: center; 
			list-style: none;
			font-weight: bold;
			font-size: 1.5em;
			overflow: hidden;
			margin-bottom: 10px; 
		}
		.phan-trang li {			
			display: inline;
		}
		.phan-trang a {
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
			<!-- Trang quản lý sản phẩm -->
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý danh mục</h1>
			<!-- Mở kết nối tới csdl -->
			<?php 
				include_once 'tmdt_connect.php';
				require_once 'upload_file.php';
			?>
			<!-- Thêm/Sửa sản phẩm nếu có dữ liệu gửi đi -->
			<?php
				if (isset($_POST["submit"])) {
					$updateID = isset($_POST["MaLSP"]) ? $_POST["MaLSP"] : 0;
					$Ten_loai = $_POST["txtTen_loai"];
					$sql = "";

					if ($updateID != 0) {
						$sql = "UPDATE loai_san_pham SET Ten_loai='$Ten_loai' WHERE MaLSP=$updateID";
					} else {
						$sql = "INSERT INTO loai_san_pham (Ten_loai) VALUES ('$Ten_loai')";
					}

					if (mysqli_query($tmdtconn, $sql)) {
						echo $updateID != 0 ? "Sửa dữ liệu thành công!" : "Thêm dữ liệu thành công!";
					} else {
						echo "Thất bại: " . mysqli_error($tmdtconn) . "(". $sql .")";
					}
				}
			?>

			<!-- Tải danh mục sản phẩm -->
			<?php
				$sql = "SELECT * FROM `loai_san_pham`";
				$resultCat = mysqli_query($tmdtconn, $sql);

				$pCat = 0; $pTen_loai = "";
				if (isset($_GET["ctlid"])) {
					$sql = "SELECT * FROM `loai_san_pham` WHERE MaLSP = " . $_GET["ctlid"];
					$result = mysqli_query($tmdtconn, $sql);

					if (mysqli_num_rows($result) > 0) {
						$row = mysqli_fetch_assoc($result);
						$pCat = $row["MaLSP"];
						$pTen_loai = $row["Ten_loai"];
					}
				}
			?>

			<!-- Tạo form nhập dữ liệu sản phẩm -->
			<div style="background-color: #dee2e6;">
				<fieldset style="margin-bottom: 10px; margin-top: 10px">
					<legend style="text-align: center;">THÊM DANH MỤC</legend>
					<form action="" method="POST" enctype="multipart/form-data">
						<input type="hidden" id="MaLSP" name="MaLSP" value="<?php echo $pCat; ?>">
						<div class="container mt-3" style="width:225px; float:left; box-sizing:border-box; margin:0 177px 0 0">
							<label for="Ten_loai" class="form-label">Tên danh mục:</label>
							<input type="text" class="form-control" id="txtTen_loai" placeholder="Nhập tên danh mục" name="txtTen_loai" value="<?php echo $pTen_loai; ?>" required>
						</div>
						<br><br>
						<input class="btn btn-primary" type="submit" name="submit" value="<?php echo $pCat ? 'Sửa' : 'Thêm'; ?>" style="width:150px; float: bottom; box-sizing:border-box; margin:0 30px 15px 30px">
						<input class="btn btn-warning" type="reset" value="Làm lại" style="float: bottom; box-sizing:border-box; margin:0 30px 15px 30px; width:150px">
					</form>
				</fieldset>
			</div>

			<?php
				$page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
				$items_per_page = 5;

				$sql = "SELECT CEIL(COUNT(*) / $items_per_page) AS 'totalpage' FROM `loai_san_pham`";
				$result = mysqli_query($tmdtconn, $sql);
				$totalpage = mysqli_fetch_assoc($result)["totalpage"];

				$offset = $page * $items_per_page;
				$sql = "SELECT * FROM `loai_san_pham` LIMIT $offset, $items_per_page";
				$result = mysqli_query($tmdtconn, $sql);

				if (mysqli_num_rows($result) > 0) {
			?>
			<div class="container mt-3">          
				<form action="#" method="post">
					<table class="table table-bordered">
					<thead> 
						<tr>
							<th>Mã danh mục</th>
							<th>Tên danh mục</th>
							<th>Hoạt động</th>
						</tr>	
					</thead>
					<tbody>
						<?php
							while ($row = mysqli_fetch_assoc($result)) {
						?>
							<tr>
								<td><?php echo $row["MaLSP"]; ?></td>
								<td><?php echo $row["Ten_loai"]; ?></td>
								<td>
									<a style="float:left" href="?ctlid=<?php echo $row["MaLSP"]; ?>" class="btn btn-info">Sửa</a> 
									<a style="float:left" onclick="return confirm('Bạn có muốn xóa danh mục này không?');" href="delete_catelog.php?ctlid=<?php echo $row["MaLSP"]; ?>" class="btn btn-danger">Xóa</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
					</table>
				</form>
			</div>
			<br> 
			<ul class="phan-trang">
				<?php
					for ($i = 1; $i <= $totalpage; $i++) {
						echo "<li><a href='?page=$i'>$i</a></li>";
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
