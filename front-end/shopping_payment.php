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
		<!-- Form đăng ký -->
		<div style="width: 400px; height: 300px; margin: 0 auto; margin-top: 100px; overflow: hidden; box-sizing: border-box; padding: 10px">
			<fieldset style="padding: 10px">
				<legend><h2>Thông tin giao hàng</h2></legend>
				<form name="#" action="#" method="POST" style="width: 100%">
					<table style="width: 100%" cellspacing="6" cellpadding="6">
						<!-- Mã khách đặt hàng -->
						<input type="text" name="Ma_kh" id="Ma_kh" hidden="" value="<?php echo $_SESSION["Ma_kh"]?>">		
						<tr>
							<td>Tên người nhận</td>
							<td><input type="text" name="Ten_kh" id="Ten_kh" required="" value="<?php echo $_SESSION["Ten_kh"]?>"> <span style="color: red">*</span></td>
						</tr>
						<tr>
							<td>Điện thoại</td>
							<td><input type="text" name="Dien_thoai" id="Dien_thoai" required="" value="<?php echo $_SESSION["Dien_thoai"]?>"> <span style="color: red">*</span></td>
						</tr>
						<tr>
							<td>Địa chỉ</td>
							<td><input type="text" name="Dia_chi" id="Dia_chi" value="<?php echo $_SESSION["Dia_chi"]?>"></td>
						</tr>
						<tr>
							<td>Thanh toán</td>
							<td><input type="text" name="Thanh_toan" id="Thanh_toan"></td>
						</tr>												
						<tr>	
							<td></td>						
							<td>
								<input type="submit" name="submit" value="Đặt hàng" onclick="" />
								<input type="reset" value="Làm lại">
							</td>
						</tr>
						<tr>
							<td colspan="2"><span id="msg_error" style="color: red"></span></td>
						</tr>
					</table>
				</form>
			</fieldset>
		</div>

		<!-- Xử lý đơn hàng gửi đi -->
		<?php
			if (isset($_POST["submit"])) {
				$sql = "INSERT INTO `hoa_don`(`Ma_kh`, `Ten_nhan`, `Dien_thoai_nhan`, `Dia_chi_nhan`,`Thanh_toan`,`Tong_tien`) VALUES (?,?,?,?,?,?)";
				$stmt = mysqli_prepare($bkconn, $sql); // Chuẩn bị kết nối

				// Đổ dữ liệu prepare
				mysqli_stmt_bind_param($stmt, "issssd", $_POST["Ma_kh"],$_POST["Ten_kh"],$_POST["Dien_thoai"],$_POST["Dia_chi"],$_POST["Thanh_toan"],$_SESSION["totalBill"]);

				// Kích hoạt lệnh
				if (mysqli_stmt_execute($stmt)) {
					echo "<h1 style='text-align:center'>Đặt hàng thành công</h1>";
					$idhd = mysqli_stmt_insert_id($stmt); // Lấy id hóa đơn sau khi thêm >>> đổ lên Hóa Đơn Chi Tiết

					$arrCart = $_SESSION["cart"]; // Biến mảng (từ session) chứa các sản phẩm trong giỏ hàng
					$sql = ""; // Lệnh truy vấn		
					foreach ($arrCart as $key => $value) {
						$sql .= "INSERT INTO `hoa_don_ct`(`Ma_hd`, `Ma_sp`, `So_luong`, `Gia_ban`) VALUES (".$idhd.",".$key.",".$value.",(SELECT`price` FROM `product` WHERE `id` = ".$key."));";
					}
					if (mysqli_multi_query($bkconn, $sql)) {
						echo "<h3 style='text-align:center'>Thêm chi tiết Hóa Đơn thành công</h3>";
					} else {
						echo "<span style='color:red'>Lỗi thêm Chi Tiết Hóa Đơn: ".mysqli_error($bkconn)."</span>";
					}

					// Làm sạch giỏ hàng sau khi thanh toán
					unset($_SESSION["cart"]);
					unset($_SESSION["totalBill"]);
				}				
			}
			
		?>

	</div>
	
	<!-- Footer -->
	<footer>
		<div class="content-center">
			<?php include_once 'public/footer.php';?>
		</div>
	</footer>
</body>
</html>