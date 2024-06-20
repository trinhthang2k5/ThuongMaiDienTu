<?php require_once 'tmdt_connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="../css/main_style.css">
	<link rel="stylesheet" href="css/admin_Login.css">
	<script type="text/javascript" src="../js/main_script.js"></script>
</head>
<body onload="onloadFormComplete()"> 
	<!-- Header -->	
	<div class="content-center" style="color: white; background: linear-gradient(-180deg,#f53d2d,#f63);width: 100%;height: 110px;">	
		<div class="content-center__header-name">
			<h1 style="text-transform: uppercase; float: left; line-height: 100px;margin-left:200px">Hệ thống quản lý</h1>
		</div>
	</div>

	<?php
	if (isset($_POST["submit"])) {		
		$uname = $_POST["username"];
		$pass = md5($_POST["password"]);
		$sql = "SELECT * FROM `quan_tri` WHERE `Tai_khoan` = ? AND `Mat_khau` = ?";
		$stmt = mysqli_prepare($tmdtconn, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
		mysqli_stmt_execute($stmt); // Kích hoạt lệnh prepare
		$result = mysqli_stmt_get_result($stmt); // Lấy dữ liệu trả về

		if (mysqli_num_rows($result) > 0) {						
			header("Location: manager_product.php");
		} else {
			// Đăng nhập thất bại
			echo "<script>alert('Tài khoản/mật khẩu không đúng!');</script>";
		}
	}
	?>

	<!-- Body -->
	<div class="content-center main-body">
		<!-- Form đăng nhập -->
		<div class="form-tt">
				<h2>Đăng nhập</h2>
				<form name="form_login" action="#" method="POST">
					<input type="text" name="username" id="username" placeholder="Nhập tên đăng nhập" required="">
					<input type="password" name="password" id="password" placeholder="Nhập mật khẩu"  required="">
					<input type="checkbox" id="checkbox" name="checkbox"><label class="checkbox-text">Nhớ đăng nhập lần sau</label>
					<input type="submit" name="submit" value="Đăng nhập" onclick="return validateLogin();" />
				</form>
		</div>
	</div>
	
	<!-- Footer -->
	<!--<footer>
		<div class="content-center">
			<//?//php include_once '../public/footer.php';?>
		</div>
	</footer>-->
</body>
</html>