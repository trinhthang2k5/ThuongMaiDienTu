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
	<?php
	if (isset($_POST["submit"])) {		
		$uname = $_POST["username"];
		$pass = md5($_POST["password"]);
		$Ho_ten = $_POST["Ho_ten"];
        $Dia_chi = $_POST["Dia_chi"];
        $Dien_thoai = $_POST["Dien_thoai"];
		$Email = $_POST["Email"];
	    $gioi_tinh = $_POST["Gioi_tinh"];
	    $email = $_POST["email"];
		// Thêm dữ liệu vào bảng `khach_hang`
        $sql_khach_hang = "INSERT INTO `khach_hang`(`Ho_ten`, `Dia_chi`, `Dien_thoai`, `Email`, `Gioi_tinh`) VALUES (?, ?, ?, ?, ?)";
        $stmt_khach_hang = mysqli_prepare($conn, $sql_khach_hang);
        mysqli_stmt_bind_param($stmt_khach_hang, "sssss", $Ho_ten, $Dia_chi, $Dien_thoai, $Email, $gioi_tinh);
        mysqli_stmt_execute($stmt_khach_hang);

        // Lấy ID khách hàng vừa thêm
        $MaKH = mysqli_stmt_insert_id($stmt_khach_hang);

		// Lệnh prepare
		$sql = "INSERT INTO `nguoi_dung`(`Tai_khoan`, `Mat_khau`, `MaKH`) VALUES (?,?,?)";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "sss", $uname, $pass, $MaKH);
		$result = mysqli_stmt_execute($stmt);
		// Kích hoạt lệnh prepare
		if ($result) {
			// Đăng ký thành công
			echo "<script>alert('Đăng ký thành công! Vui lòng đăng nhập.');</script>";
		} else {
			// Đăng nhập thất bại
			echo "<script>alert('Đăng ký thất bại!');</script>";
		}
	}
	?>
	<!-- Body -->
	<div class="content-center-log main-body">
		<!-- Form đăng ký -->
		<div style="width: 400px; height: 300px; margin: 0 auto; margin-top: 100px; overflow: hidden; box-sizing: border-box; padding: 10px">
			<fieldset style="padding: 10px">
				<legend><h2>Đăng ký</h2></legend>
				<form name="form_login" action="#" method="POST" style="width: 100%">
					<table style="width: 100%" cellspacing="6" cellpadding="6">
					    <tr>
                            <td>Tên:</td>
                            <td><input type="text" name="ten" required></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td><input type="text" name="dia_chi" required></td>
                        </tr>
                        <tr>
                            <td>Điện thoại:</td>
                            <td><input type="text" name="dien_thoai" required></td>
                        </tr>
					    <tr>
							<td>Email:</td>
							<td><input type="email" name="email" id="email" required=""> <span style="color: red">*</span></td>
						</tr>
						<tr>
                            <td>Giới tính</td>
                            <td>
                                <input type="radio" name="Gioi_tinh" value="Nam" required> Nam
                                <input type="radio" name="Gioi_tinh" value="Nữ" required> Nữ
                            </td>
                        </tr>
						<tr>
							<td>Tài khoản: </td>
							<td><input type="text" name="username" id="username" required=""> <span style="color: red">*</span></td>
						</tr>
						<tr>
							<td>Mật khẩu</td>
							<td><input type="password" name="password" id="password" required=""> <span style="color: red">*</span></td>
						</tr>
						<tr>	
							<td></td>						
							<td>
								<input type="submit" name="submit" value="Đăng ký" onclick="" />
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
	</div>
	
	<!-- Footer -->
	<footer>
		<div class="content-center">
			<?php include_once 'public/footer.php';?>
		</div>
	</footer>
</body>
</html>
