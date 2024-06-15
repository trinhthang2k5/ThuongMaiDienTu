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
	<link rel="stylesheet" href="../font_icon/themify-icons/themify-icons.css">
	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		table tr:hover {
			background-color: yellow;
		}
		.box-odd {
			background-color: cyan;
		}
	</style>
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
	<script>
		function updateStatus(invoiceId, currentStatus) {
			var newStatus = currentStatus === 0 ? 1 : 2; // 0 -> 1 (Chưa giao to Đang giao), 1 -> 2 (Đang giao to Hoàn thành)
			var confirmMessage = currentStatus === 0 ? 'Xác nhận đơn hàng "Đang giao"?' : 'Xác nhận đơn hàng "Hoàn thành"?';

			if (confirm(confirmMessage)) {
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "update_status.php", true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function () {
					if (xhr.readyState == 4 && xhr.status == 200) {
						location.reload(); // Refresh the page to reflect changes
					}
				};
				xhr.send("invoiceId=" + invoiceId + "&newStatus=" + newStatus);
			}
		}

		function showDetails(invoiceId) {
			// Fetch invoice details via AJAX
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "get_invoice_details.php?invoiceId=" + invoiceId, true);
			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4 && xhr.status == 200) {
					var details = JSON.parse(xhr.responseText);
					document.getElementById('invoiceDetails').innerHTML = `
						<p><strong>Mã hóa đơn:</strong> ${details.MaHD}</p>
						<p><strong>Ngày tạo hóa đơn:</strong> ${details.Ngay_HD}</p>
						<p><strong>Tên người nhận:</strong> ${details.Hoten_nguoinhan}</p>
						<p><strong>Địa chỉ người nhận:</strong> ${details.Diachi_nguoinhan}</p>
						<p><strong>Điện thoại:</strong> ${details.Dienthoai_nguoinhan}</p>
						<p><strong>Địa chỉ Email:</strong> ${details.Diachi_email}</p>
						<p><strong>Ngày giao hàng:</strong> ${details.Ngay_giao_hang}</p>
						<p><strong>Tên sản phẩm:</strong> ${details.Ten_sp}</p>
						<p><strong>Thông tin:</strong> ${details.Thong_tin}</p>
						<p><strong>Số lượng:</strong> ${details.So_luong_ban}</p>
						<p><strong>Phương thức thanh toán:</strong> ${details.Ten_PTTT}</p>
						<p><strong>Phương thức vận chuyển:</strong> ${details.TenPTVC}</p>
						<p><strong>Thành tiền:</strong> ${details.Gia_ban}</p>
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
		<div style="width: 20%; float: left; overflow: hidden; box-sizing: border-box;">
			<?php include_once 'menu.php';?>
		</div>
		<!-- Nội dung -->
		<div style="width: 80%; float: left; overflow: hidden; box-sizing: border-box; padding: 10px;">
			<!-- Trang quản lý hóa đơn -->
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý Hóa Đơn</h1>
			<!-- Mở kết nối tới csdl -->
			<?php 
				$page = 0;
				$items_per_page = 5; // Số lượng mục trên mỗi trang
				
				if (isset($_GET["page"])) {
					$page = $_GET["page"] - 1;
				}
				
				// Lấy tổng số trang
				$sql = "SELECT CEIL(COUNT(*) / $items_per_page) AS 'totalpage' FROM `hoa_don`";
				$result = mysqli_query($tmdtconn, $sql);
				$totalpage = 0;
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)){
						$totalpage = $row["totalpage"];
					}
				}
				
				// Tính toán offset
				$offset = $page * $items_per_page;

				include_once 'tmdt_connect.php';			
				// Tải hóa đơn (all)
				$sql = "SELECT hoa_don.MaHD, hoa_don.Hoten_nguoinhan, hoa_don.Dienthoai_nguoinhan, ct_hoa_don.So_luong_ban, ct_hoa_don.Gia_ban,
				hoa_don.Trang_thai, san_pham.Ten_sp
				FROM `hoa_don` JOIN `ct_hoa_don` ON hoa_don.MaHD = ct_hoa_don.MaHD
							   JOIN `san_pham` ON hoa_don.MaSP = san_pham.MaSP
						LIMIT ".$offset.", 5";

				$result = mysqli_query($tmdtconn, $sql); // Truy vấn

				// Duyệt hiển thị dữ liệu
				if (mysqli_num_rows($result) > 0) {
					// Code bảng dữ liệu hiển thị
			?>
				<div class="container mt-3">
				<table class="table table-bordered">
					<tr>
						<th>Mã hóa đơn</th>
						<th>Tên sản phẩm</th>
						<th>Tên người nhận</th>
						<th>Điện thoại</th>
						<th>Số lượng</th>
						<th>Thành tiền</th>
						<th>Trạng thái</th>
						<th>Hoạt động</th>						
					</tr>		
					<?php
					 $cnt = 1;
					// Duyệt vòng lặp lấy dữ liệu 
					 while ($row = mysqli_fetch_assoc($result)) {
					 	if ($cnt % 2 != 0) {							
					 		echo "<tr class='box-odd'>";
					 	} else {
					 		echo "<tr>";
					 	}
					 	$cnt++;
					 	echo "<td>".$row["MaHD"]."</td>";
					 	echo "<td>".$row["Ten_sp"]."</td>";
					 	echo "<td>".$row["Hoten_nguoinhan"]."</td>";
					 	echo "<td>".$row["Dienthoai_nguoinhan"]."</td>";
					 	echo "<td>".$row["So_luong_ban"]."</td>"; 
					 	echo "<td>".$row["Gia_ban"]."</td>"; 
					 	echo "<td style='text-align:center'>";
					 	if ($row["Trang_thai"] == 0) {
					 		echo "<button class='btn btn-danger' onclick='updateStatus(".$row["MaHD"].", 0)'>Chưa giao</button>";
					 	} elseif ($row["Trang_thai"] == 1) {
							echo "<button class='btn btn-warning' onclick='updateStatus(".$row["MaHD"].", 1)'>Đang giao</button>";
					 	} else {
					 		echo "<button class='btn btn-success' style='padding:6px 7px'>Hoàn thành</button>";
					 	}
					 	echo "</td>";
					 	echo "<td><button class='btn btn-info' onclick='showDetails(".$row["MaHD"].")'>Chi tiết</button></td>";	
					 	echo "</tr>";
					 }
					?> 
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

	<!-- Modal -->
	<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Chi tiết Hóa đơn</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="invoiceDetails">
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
