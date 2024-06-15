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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
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
	 <style>
    .custom-collapse {
      background-color: #dee2e6; /* Màu nền mặc định của collapse khi đã mở */
      transition: background-color 0.3s; /* Hiệu ứng chuyển đổi màu nền */
    }
    .custom-collapse.collapsing {
      background-color: white; /* Màu nền khi collapse đang đóng */
    }
  </style>
  <script>
	function showDetails(productId) {
			// Fetch invoice details via AJAX
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "get_product_details.php?productId=" + productId, true);
			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4 && xhr.status == 200) {
					var details = JSON.parse(xhr.responseText);
					document.getElementById('productDetails').innerHTML = `
						<p><strong>Mã sản phẩm:</strong> ${details.MaSP}</p>
						<p><strong>Loại sản phẩm:</strong> ${details.Ten_loai}</p>
						<p><strong>Tên sản phẩm:</strong> ${details.Ten_sp}</p>
						<p><strong>Nhãn hiệu:</strong> ${details.Ten_nhan_hieu}</p>
						<p><strong>Mô tả:</strong> ${details.Mo_ta}</p>
						<p><strong>Thông tin:</strong> ${details.Thong_tin}</p>
						<p><strong>Giá tiền:</strong> ${details.Gia_tien}</p>
						<p><strong>Hình ảnh:</strong> ${details.Hinh_anh}</p>
						<p><strong>Số lượng:</strong> ${details.So_luong}</p>
						<p><strong>Ngày cập nhập:</strong> ${details.Ngay_cap_nhap}</p>
						<p><strong>Trạng thái:</strong> ${details.Trang_thai}</p>
					`;
					var modal = new bootstrap.Modal(document.getElementById('detailsModal'));
					modal.show();
				}
			};
			xhr.send();
		}
  </script>
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
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý sản phẩm</h1>
			<!-- Mở kết nối tới csdl -->
			<?php 
			include_once 'tmdt_connect.php';
			require_once 'upload_file.php';
			?>
			<!-- Thêm/Sửa sản phẩm nếu có dữ liệu gửi đi -->
			<?php
				if (isset($_POST["submit"])) {
					$updateID = isset($_POST["MaSP"]) ? $_POST["MaSP"] : 0;

					$idcat = $_POST["optCatelog"];
					$Ten_sp = $_POST["txtTen_sp"];
					$Mo_ta = $_POST["txtMo_ta"];
					$Thong_tin = $_POST["txtThong_tin"];
					$Gia_tien = $_POST["txtGia_tien"];
					$So_luong = $_POST["txtSo_luong"];
					$Ten_nhan_hieu = $_POST["txtTen_nhan_hieu"];
					$Trang_thai = isset($_POST["chkTrang_thai"]) ? 1 : 0;

					if ($updateID != 0) {
						$sql = "UPDATE san_pham SET `MaLSP`='$idcat', Ten_sp='$Ten_sp', Mo_ta='$Mo_ta', Thong_tin='$Thong_tin',
								Gia_tien=$Gia_tien, So_luong=$So_luong, Ten_nhan_hieu='$Ten_nhan_hieu', Trang_thai=$Trang_thai 
								WHERE MaSP=$updateID";
					} else {
						$sql = "INSERT INTO san_pham (MaLSP, Ten_sp, Mo_ta, Thong_tin, Gia_tien, So_luong, Ten_nhan_hieu, Trang_thai)
								VALUES ('$idcat', '$Ten_sp', '$Mo_ta', '$Thong_tin', $Gia_tien, $So_luong, '$Ten_nhan_hieu', $Trang_thai)";
					}

					if (mysqli_query($tmdtconn, $sql)) {
						$idPrd = $updateID != 0 ? $updateID : mysqli_insert_id($tmdtconn);

						if ($idPrd != 0) {
							echo $updateID != 0 ? "Sửa dữ liệu thành công!" : "Thêm dữ liệu thành công!";

							// Handle file upload
							if (!empty($_FILES["fileToUpload"]["name"])) {
								$filePath = $_FILES["fileToUpload"];
								$extension = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
								$filename = "prd_" . $idPrd . "." . $extension;

								if (uploadFile($filePath, $filename)) {
									$sql = "UPDATE `san_pham` SET `Hinh_anh`='$filename' WHERE MaSP=$idPrd";
									mysqli_query($tmdtconn, $sql);
								} else {
									echo "Tải lên ảnh thất bại.";
								}
							}
						}
					} else {
						echo "Thất bại: " . mysqli_error($tmdtconn) . " (" . $sql . ")";
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

			<!-- Tạo form nhập dữ liệu sản phẩm -->
			<div class="container mt-3" style="background-color: #ebebeb;">
				<fieldset style="margin-bottom: 10px; margin-top: 10px">
						<form action="" method="POST" enctype="multipart/form-data">
							<input type="hidden" id="MaSP" name="MaSP" value="<?php echo $pID?>">

							<div class="mb-3 mt-3" style="width:200px; float:right; box-sizing:border-box; margin:0 190px 0 0">
								<label for="So_luong" class="form-label">Số lượng sản phẩm:</label>
								<input type="number" class="form-control" id="txtSo_luong" placeholder="Nhập số lượng"
									name="txtSo_luong" min="0" step="1" value="<?php echo $pSo_luong?>">
							</div>

							<div class="mb-3 mt-3" style="width:200px; float:left; box-sizing:border-box; margin:0 30px">
								<label for="txtTen_sp" class="form-label">Tên sản phẩm:</label>
								<input type="text" class="form-control" id="txtTen_sp" placeholder="Nhập tên sản phẩm" name="txtTen_sp" value="<?php echo $pTen_sp?>">
							</div>

							<div class="mb-3 mt-3" style="width:200px; float:left; box-sizing:border-box; margin:0 30px">
								<label for="txtGia_tien" class="form-label">Giá sản phẩm:</label>
								<input type="number" class="form-control" id="txtGia_tien" placeholder="Nhập giá tiền"
									name="txtGia_tien" min="0" step="1" value="<?php echo $pGia_tien?>">
							</div>

							<div class="container mt-3" style="width:225px; float:right; box-sizing:border-box; margin:0 177px 0 0">
								<label for="Ten_loai" class="form-label">Loại sản phẩm:</label>
								<select class="form-select" name="optCatelog" id="optCatelog">
									<?php
									while ($row = mysqli_fetch_assoc($resultCat)) {
										if ($pCat == $row["MaSP"]) {
											echo "<option selected value='". $row["MaLSP"] ."'>". $row["Ten_loai"] ."</option>";
										} else {
											echo "<option value='". $row["MaLSP"] ."'>". $row["Ten_loai"] ."</option>";
										}
									}
									?>
								</select>
							</div>

							<div class="mb-3 mt-3" style="float: bottom; box-sizing:border-box; width:460px; margin:0 30px">
								<label for="txtMo_ta" class="form-label">Mô tả</label>
								<textarea class="form-control" name="txtMo_ta" id="txtMo_ta" placeholder="Điền mô tả sản phẩm"><?php echo $pMo_ta?></textarea>
							</div>

							<div class="container mt-3" style="width:225px; float:right; box-sizing:border-box; margin:0 177px 0 0">
								<label for="Ten_loai" class="form-label">Nhãn hiệu:</label>
								<input type="text" class="form-control" id="txtTen_nhan_hieu" placeholder="Nhập nhãn hiệu sản phẩm" name="txtTen_nhan_hieu" value="<?php echo $pTen_nhan_hieu?>">
							</div>

							<div class="mb-3 mt-3" style="float: bottom; box-sizing:border-box; width:460px; margin:0 30px">
								<label for="txtThong_tin" class="form-label">Thông tin</label>
								<textarea class="form-control" name="txtThong_tin" id="txtThong_tin" placeholder="Điền thông tin sản phẩm"><?php echo $pThong_tin?></textarea>
							</div>

							<div class="mb-3 mt-3" style="width:250px; float:left; box-sizing:border-box; margin:0 30px">
								<label for="Hinh_anh" class="form-label">Ảnh sản phẩm:</label>
								<?php
								if (!empty($pHinh_anh)) {
									?>
									<img width="200" height="200" src='<?php echo "image/" . $pHinh_anh ?>' alt="lỗi ">
								<?php }?>
								<input type="file" name="fileToUpload" id="fileToUpload">
							</div>


							<br>
							<br>
							<div style="width:250px; float:left; box-sizing:border-box; margin:0 100px 50px 100px">
								<label class="form-check-label" style="width: 100px;">Có hàng</label>
								<?php
								if ($pTrang_thai) {
									?>
									<input class="form-check-input" type="checkbox" name="chkTrang_thai" id="chkTrang_thai" value="1" checked="">
								<?php } else {?>
									<input class="form-check-input" type="checkbox" name="chkTrang_thai" id="chkTrang_thai" value="1">
								<?php }?>
							</div>
							<?php
							if ($pID) {
								?>
								<input class="btn btn-primary" type="submit" name="submit" value="Sửa"
									style="width:150px; float: bottom; box-sizing:border-box; margin:0 30px 15px 30px">
							<?php } else { ?>
								<input class="btn btn-primary" type="submit" name="submit" value="Thêm"
									style="width:150px; float: bottom; box-sizing:border-box; margin:0 30px 15px 30px">
							<?php }?>
							<input class="btn btn-warning" type="reset" value="Làm lại"
								style="float: bottom; box-sizing:border-box; margin:0 30px 15px 30px; width:150px">
						</form>
				</fieldset>
			</div>

			<?php
				$page = 0;
				$items_per_page = 5; // Số lượng mục trên mỗi trang
				
				if (isset($_GET["page"])) {
					$page = $_GET["page"] - 1;
				}
				
				// Lấy tổng số trang
				$sql = "SELECT CEIL(COUNT(*) / $items_per_page) AS 'totalpage' FROM `san_pham`";
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
				$sql = "SELECT * FROM `san_pham` JOIN loai_san_pham ON san_pham.MaLSP=loai_san_pham.MaLSP
				
				LIMIT ".$offset.", 5";
				// echo $sql;

				$result = mysqli_query($tmdtconn, $sql); // Truy vấn
				// $result = mysqli_multi_query($tmdtconn, $sql); // Truy vấn

				// Duyệt hiển thị dữ liệu
			if (mysqli_num_rows($result) > 0) {
					// Code bảng dữ liệu hiển thị

			?>
			<div class="container mt-3" style="padding: 0;">        
					<table class="table table-bordered">
					<thead> 
					<tr>
						<th>Mã sản phẩm</th>
						<th>Loại sản phẩm</th>
						<th>Tên sản phẩm</th>
						<th>Giá tiền</th>
						<th>Hình ảnh</th>
						<th>Số lượng</th>
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
							<td><?php echo $row["Ten_sp"] ?></td>
							<td><?php      
							 $price = number_format($row["Gia_tien"], 0, ',', '.'); // Số thập phân là 0, dấu phân cách hàng nghìn là "," và dấu phân cách thập phân là "."

							// Hiển thị giá tiền với định dạng VND
							echo "<div>" . $price . " VND</div>";
							?></td>
							<td style="text-align: center"><?php echo "<img width='50' height='50' src='image/".$row["Hinh_anh"]."' alt='Lỗi hiển thị ảnh'>"; ?> </td> 
						
							<td><?php echo $row["So_luong"] ?></td>
							<?php 
							if ($row["Trang_thai"] == 1) {
								echo "<td>Có hàng</td>";
							} else {
								echo "<td>Hết hàng</td>";
							} 
							?>
							<td style="width:140px"><a style=" float:left; margin-right:17px" href="?prdid=<?php echo $row["MaSP"] ?>" class="btn btn-info">Sửa</a>
								<a style=" float:left; margin-right:0" onclick="return confirm('Bạn có muốn xóa sản phẩm này không?');" href="delete_product.php?prdid=<?php echo $row["MaSP"] ?>" class="btn btn-danger">Xóa</a> <br> <br>
								<?php echo "<button style='margin-left:25px' class='btn btn-primary' onclick='showDetails(".$row["MaSP"].")'>Chi tiết</button>" ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					</table>
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

	<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Chi tiết sản phẩm</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="productDetails">
					<!-- Details will be populated by JavaScript -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
	
?>