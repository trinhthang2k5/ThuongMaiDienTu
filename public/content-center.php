<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="../css/main_style.css">
</head>
<body>
<div class="box-search">
    <h1>LỌC SẢN PHẨM</h1>
    <form action="#" method="GET" style="float: left;">
        Mô tả sản phẩm:
        <input id="search_infor" name="search_infor" type="text" placeholder="Tìm kiếm" value="<?php echo isset($_GET["search_infor"]) ? $_GET["search_infor"] : "" ?>">
        Giá tối thiểu:
        <input id="search_price_min" name="search_price_min" type="text" value="<?php echo isset($_GET["search_price_min"]) ? $_GET["search_price_min"] : 2000000 ?>">
        Giá tối đa:
        <input id="search_price_max" name="search_price_max" type="text" value="<?php echo isset($_GET["search_price_max"]) ? $_GET["search_price_max"] : 10000000 ?>">
        <input type="submit" name="submit" value="Tìm kiếm">
    </form>
</div>
<?php
	$condition = "";
	if (isset($_GET["MaLSP"])) {
		$condition = " WHERE MaLSP = ". $_GET["MaLSP"];
	}

	// Tìm kiếm cơ bản
	if (isset($_GET["search"])) {
		$condition = " WHERE Ten_sp LIKE '%". $_GET["search"] ."%' 
			OR Mo_ta LIKE '%". $_GET["search"] ."%' 
			OR Thong_tin LIKE '%". $_GET["search"] ."%'";
	}

	// Tìm kiếm nâng cao
	if(isset($_GET["search_infor"]) || isset($_GET["search_price_min"]) || isset($_GET["search_price_max"])){
		$condition = " WHERE 1=1 ";
		if (isset($_GET["search_infor"])&&strlen($_GET["search_infor"])>0) {
			$condition .= " AND Ten_sp LIKE '%". $_GET["search_infor"] ."%' 
			OR Mo_ta LIKE '%". $_GET["search_infor"] ."%' 
			OR Thong_tin LIKE '%". $_GET["search_infor"] ."%'";
		}
		if (isset($_GET["search_price_min"])) {
			$condition .= " AND Gia_tien >= " . $_GET["search_price_min"];
		}
		if (isset($_GET["search_price_max"])) {
			$condition .= " AND Gia_tien <= " . $_GET["search_price_max"];
		}
	}

	// 1. Lệnh truy vấn 
	$sql = "SELECT * FROM `San_pham`" . $condition;

	// 2. Truy vấn
	$result = mysqli_query($conn, $sql);

	// 3. Duyệt
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			// Sản phẩm
			echo "<div class='San_pham-title'>";
			echo "<a href='Thongtin_sp.php?MaSP=".$row["MaSP"]."'><img width='290px' height='290px' src='public/images/".$row["Hinh_anh"]."' alt='hp123'></a> <br>";
			echo "<h3>".$row["Ten_sp"]."</h3>";
			echo "<div class='box-desc'>".$row["Thong_tin"]."</div>";			
			echo "<div class='box-price'>".formatCurrency($row["Gia_ban"])."</div>";
			echo "</div>";
		}
	}


?>
</body>
</html>