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
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý tin tức</h1>
		
			
			<?php
            if (isset($_POST["submit"])) {
                $updateId = isset($_POST["MaTT"]) ? $_POST["MaTT"] : 0;
                $Tieu_de = $_POST["txtTieu_de"];
                $Noi_dung = $_POST["txtNoi_dung"];

                if ($updateId != 0) {
                    $sql = "UPDATE `tin_tuc` SET `Tieu_de`='$Tieu_de', `Noi_dung`='$Noi_dung' WHERE `MaTT`=$updateId";
                } else {
                    $sql = "INSERT INTO `tin_tuc` (`Tieu_de`, `Noi_dung`) VALUES ('$Tieu_de', '$Noi_dung')";
                }

                if (mysqli_query($tmdtconn, $sql)) {
                    if ($updateId != 0) {
                        echo "Sửa dữ liệu thành công!";
                    } else {
                        $updateId = mysqli_insert_id($tmdtconn);
                        echo "Thêm dữ liệu thành công!";
                    }

                    // Handle file upload
                    if (!empty($_FILES["fileToUpload"]["name"])) {
                        $filePath = $_FILES["fileToUpload"];
                        $extension = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
                        $filename = "news_$updateId.$extension";

                        if (uploadFile($filePath, $filename)) {
                            $sql = "UPDATE `tin_tuc` SET `Hinh_anh`='$filename' WHERE `MaTT`=$updateId";
                            mysqli_query($tmdtconn, $sql);
                        } else {
                            echo "Tải lên ảnh thất bại.";
                        }
                    }
                } else {
                    echo "Thất bại: " . mysqli_error($tmdtconn) . " (" . $sql . ")";
                }
            }
            ?>

			<?php

			// Load dữ liệu sản phẩm theo ID
			$nID=0; $nTieu_de=""; $nNoi_dung=""; $nNgay_dang_tin=""; $nHinh_anh="";
			if (isset($_GET["newsid"])) {
				$sql = "SELECT * FROM `tin_tuc` WHERE MaTT = " . $_GET["newsid"];

				$result = mysqli_query($tmdtconn, $sql);

				if(mysqli_num_rows($result) > 0){
					while ($row = mysqli_fetch_assoc($result)) {
						$nID = $row["MaTT"];
						$nTieu_de = $row["Tieu_de"];
						$nNoi_dung = $row["Noi_dung"];
						$nHinh_anh = $row["Hinh_anh"];
					}
				}
			}
			?>

			<div class="container mt-3" style="background-color: #ebebeb;">
				<fieldset style="margin-bottom: 10px; margin-top: 10px">
						<form action="" method="POST" enctype="multipart/form-data">
							<input type="hidden" id="MaTT" name="MaTT" value="<?php echo $nID?>">

							<div class="mb-3 mt-3" style="width:200px; float:left; box-sizing:border-box; margin:0 30px">
								<label for="Tieu_de" class="form-label">Tiêu đề:</label>
								<input type="text" class="form-control" id="txtTieu_de" placeholder="Nhập tiêu đề" name="txtTieu_de" value="<?php echo $nTieu_de?>">
							</div>

							<div class="mb-3 mt-3" style="width:200px; float:left; box-sizing:border-box; margin:0 30px">
								<label for="Noi_dung" class="form-label">Nội dung:</label>
								<input type="text" class="form-control" id="txtNoi_dung" placeholder="Nhập nội dung" name="txtNoi_dung" value="<?php echo $nNoi_dung?>">
							</div>

							<div class="mb-3 mt-3" style="width:250px; float:left; box-sizing:border-box; margin:0 30px">
								<label for="Hinh_anh" class="form-label">Ảnh tin tức:</label>
								<?php if (!empty($nHinh_anh)) { ?>
                                <img width="200" height="200" src='<?php echo "image/" . $nHinh_anh ?>' alt="Ảnh tin tức">
                            <?php } ?>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>

                        <div class="mb-3" style="clear:both;">
                            <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $nID ? 'Sửa' : 'Thêm' ?>" style="width:150px; margin:0 30px">
                            <input class="btn btn-warning" type="reset" value="Làm lại" style="width:150px; margin:0 30px">
                        </div>
                    </form>
                </fieldset>
            </div>

            <?php
            $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
            $items_per_page = 5;

            $sql = "SELECT CEIL(COUNT(*) / $items_per_page) AS 'totalpage' FROM `tin_tuc`";
            $result = mysqli_query($tmdtconn, $sql);
            $totalpage = mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result)["totalpage"] : 0;

            $offset = $page * $items_per_page;
            $sql = "SELECT * FROM `tin_tuc` LIMIT $offset, $items_per_page";
            $result = mysqli_query($tmdtconn, $sql);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="container mt-3">
                    <table class="table table-bordered">
                        <thead> 
                            <tr>
                                <th>Mã tin tức</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Ngày đăng tin</th>
                                <th>Hình ảnh</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row["MaTT"] ?></td>
                                    <td><?php echo $row["Tieu_de"] ?></td>
                                    <td><?php echo $row["Noi_dung"] ?></td>
                                    <td><?php echo $row["Ngay_dang_tin"] ?></td>
                                    <td style="text-align: center"><?php echo "<img width='50' height='50' src='image/".$row["Hinh_anh"]."' alt='Lỗi hiển thị ảnh'>"; ?> </td> 
                                    <td>
                                        <a href="?newsid=<?php echo $row["MaTT"] ?>" class="btn btn-info">Sửa</a>
                                        <a onclick="return confirm('Bạn có muốn xóa tin tức này không?');" href="delete_news.php?idtt=<?php echo $row["MaTT"] ?>" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <br>
                <ul class="phan-trang">
                    <?php for ($i = 1; $i <= $totalpage; $i++) { ?>
                        <li><a href='?page=<?php echo $i ?>'><?php echo $i ?></a></li>
                    <?php } ?>
                </ul>
                <?php
            } else {
                echo "<span class='error'>Không tìm thấy tin tức phù hợp</span>";
            }
            ?>
        </div>
    </div>
</body>
</html>
