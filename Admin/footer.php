<?php
				if (isset($_POST["submit"])) {
					$MaSP = 0; // Mã cập nhật
					if(isset($_POST["MaSP"])){
						$MaSP = $_POST["MaSP"];
					}

					$idcat = $_POST["optCatelog"];
					$Ten_sp = $_POST["txtTen_sp"];
					$Mo_ta = $_POST["txtMo_ta"];
					$Thong_tin = $_POST["txtThong_tin"];
					$Gia_tien = $_POST["txtGia_tien"];
					$So_luong = $_POST["txtSo_luong"];
					$Ten_nhan_hieu = $_POST["txtTen_nhan_hieu"];
					$Trang_thai = isset($_POST["chkTrang_thai"])? 1 : 0;		

					$sql = "";

					if ($MaSP != 0) {
						$sql = "UPDATE san_pham SET MaLSP='".$idcat."',Ten_sp='".$Ten_sp."',Mo_ta='".$Mo_ta."',Thong_tin='".$Thong_tin."',
						Gia_tien='".$Gia_tien."',So_luong='".$So_luong."',Ten_nhan_hieu='".$Ten_nhan_hieu."',Trang_thai='".$Trang_thai."' WHERE MaSP=".$MaSP;
					} else {
						$sql = "INSERT INTO san_pham (MaLSP, Ten_sp, Mo_ta, Thong_tin, Gia_tien, So_luong, Ten_nhan_hieu, Trang_thai)
						VALUES ('".$idcat."','".$Ten_sp."','".$Mo_ta."','".$Thong_tin."','".$Gia_tien."','".$So_luong."','".$Ten_nhan_hieu."','".$Trang_thai."')";
					}

					mysqli_query($tmdtconn, $sql);
					$idPrd = 0;
					if ($MaSP == 0) {
						$idPrd = mysqli_insert_id($tmdtconn);
					}

					if ($idPrd != 0 || $MaSP!= 0) {
						if ($MaSP != 0) {
							echo "Sửa dữ liệu thành công!";
						} else {
							echo "Thêm dữ liệu thành công!";
						}
						// Tải file ảnh lên server
						if (!empty($_FILES["fileToUpload"]["name"])) {
							$filePath = $_FILES["fileToUpload"];
							$extension = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
							$filename = "";
							if ($MaSP != 0) {
								$filename = "prd_" . $MaSP . "." . $extension; // Sửa
							} else {
								$filename = "prd_" . $idPrd . "." . $extension; // Thêm
							}			
							
							uploadFile($filePath, $filename);

						// Cập nhật tên ảnh khi THÊM / SỬA
						$idUpdate = ($MaSP != 0)? $MaSP : $idPrd;
						$sql = "UPDATE `san_pham` SET `Hinh_anh`='" . $filename . "' WHERE MaSP = " . $idUpdate;

						mysqli_query($tmdtconn, $sql); // Truy vấn						
					} else {
						// echo "Không có file tải lên";
					}				
				} else {
					echo "Thất bại: " . mysqli_error($tmdtconn) . "(". $sql .")";
				}			
			}
			?>


			<!-- Tải danh mục sản phẩm -->
			<?php
			$sql = "SELECT * FROM `loai_san_pham`";
			// Truy vấn
			$resultCat = mysqli_query($tmdtconn, $sql); // Dữ liệu danh mục

			// Load dữ liệu sản phẩm theo ID
			$pID=0; $pCat=0; $pTen_sp=""; $pMo_ta=""; $pThong_tin=""; $pGia_tien=0; $pHinh_anh=""; $pNgay_cap_nhat=""; $pTrang_thai=true; $pTen_nhan_hieu="";
			if (isset($_GET["prdid"])) {
				$sql = "SELECT * FROM `san_pham` WHERE MaSP = " . $_GET["prdid"];

				$result = mysqli_query($tmdtconn, $sql);

				if(mysqli_num_rows($result) > 0){
					while ($row = mysqli_fetch_assoc($result)) {
						$pID = $row["MaSP"];
						$pTen_sp = $row["Ten_sp"];
						$pCat = $row["MaLSP"];
						$pMo_ta = $row["Mo_ta"];
						$pThong_tin = $row["Thong_tin"];
						$pGia_tien = $row["Gia_tien"];
						$pHinh_anh = $row["Hinh_anh"];
						$pSo_luong = $row["So_luong"];
						$pTen_nhan_hieu = $row["Ten_nhan_hieu"];
						$pTrang_thai = $row["Trang_thai"];
					}
				}
			}
			?>










<?php 
require_once 'tmdt_connect.php';
require_once 'upload_file.php';
?>

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
		<div style="width: 18%; float:left; overflow: hidden; box-sizing: border-box;">
			<?php include_once 'menu.php';?>
		</div>
		<!-- Nội dung -->
		<div style="width: 82%; float:left; overflow: hidden; box-sizing: border-box; padding: 10px;">
			
			<h1 style="margin-bottom: 10px; width:500px">Quản lý sản phẩm</h1>
			<a href="add_product.php" class="btn btn-success" style="float: right; margin:0 12px 15px 0">Thêm sản phẩm mới</a>



               <!-- 		EDIT_USER.PHP      -->


			<?php
				$page = 0;
				if (isset($_GET["page"])) {
					// echo $_GET["page"];
					$page = $_GET["page"]-1;
				}

				// Lấy tổng số trang
				$sql = "SELECT CEIL((SELECT COUNT(*) FROM `san_pham`) / 6) AS 'totalpage'"; // Mỗi page 6 items >>> có thể thay đổi theo tham số
				$result = mysqli_query($tmdtconn, $sql);
				$totalpage = 0;
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)){
						$totalpage = $row["totalpage"];
					}
				}
				$sql = "SELECT ".$page." * (SELECT (SELECT COUNT(*) FROM `san_pham`) / (SELECT CEIL((SELECT COUNT(*) FROM `san_pham`) / 6))) AS 'offset'";
				$result = mysqli_query($tmdtconn, $sql);
				$offset = 0;
				while ($row = mysqli_fetch_assoc($result)) {
					$offset = (int) $row["offset"];
				}

				// Lấy items trong trang
				$sql = "SELECT * FROM `san_pham` JOIN loai_san_pham ON san_pham.MaLSP=loai_san_pham.MaLSP
				
				LIMIT ".$offset.", 6";
				// echo $sql;

				$result = mysqli_query($tmdtconn, $sql); // Truy vấn
				// $result = mysqli_multi_query($tmdtconn, $sql); // Truy vấn

				// Duyệt hiển thị dữ liệu
				if (mysqli_num_rows($result) > 0) {
					// Code bảng dữ liệu hiển thị

			?>
			<div class="container mt-3">          
				<form action="add_product.php" method="post">
					<table class="table table-bordered">
					<thead> 
					<tr>
						<th>Mã sản phẩm</th>
						<th>Loại sản phẩm</th>
						<th>Nhãn hiệu</th>
						<th>Tên sản phẩm</th>
						<th>Mô tả</th>
						<th>Giá tiền</th>
						<th>Hình ảnh</th>
						<th>Số lượng</th>
						<th>Ngày cập nhập</th>
						<th>Trạng thái</th>
						<th>Hoạt động</th>
					</tr>	
					</thead>
					<tbody>
					<?php
				// Duyệt vòng lặp lấy dữ liệu 
						while ($row = mysqli_fetch_assoc($result)) {
					?>
						<tr>
							<td><?php echo $row["MaSP"] ?></td>
							<td><?php echo $row["Ten_loai"] ?></td>
							<td><?php echo $row["Ten_nhan_hieu"] ?></td>
							<td><?php echo $row["Ten_sp"] ?></td>
							<td><?php echo $row["Mo_ta"] ?></td>
							<td><?php echo $row["Gia_tien"] ?></td>
							<td><?php echo $row["Hinh_anh"] ?></td>
							<td><?php echo $row["So_luong"] ?></td>
							<td><?php echo $row["Ngay_cap_nhap"] ?></td>
							<?php 
							if ($row["Trang_thai"] == 1) {
								echo "<td>Còn</td>";
							} else {
								echo "<td>Hết</td>";
							} 
							?>
							<td><a href="edit_product.php?id=<?php echo $row["MaSP"] ?>" class="btn btn-info">Sửa</a>
								<a onclick="return confirm('Bạn có muốn xóa sản phẩm này không?');" href="delete_product.php?id=<?php echo $row["MaSP"] ?>" class="btn btn-danger">Xóa</a></td>
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
<?php
?>
