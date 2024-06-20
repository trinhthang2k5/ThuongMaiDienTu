<h3 style="text-transform: uppercase;padding: 10px">Danh mục sản phẩm</h3>
<ul class="no-list-style loai_san_pham">	
	<?php
		$sql = "SELECT * FROM `loai_san_pham`";
		$result = mysqli_query($conn, $sql); ?>
		
		<select name="" id="">
			<option value=""></option>
		</select>	

		<?php
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<a href='index.php?MaLSP=". $row["MaLSP"] ."'><li>".$row["Ten_loai"]."</li></a><br></br>";
			}
		} else {
			echo "không tồn tại bảng danh mục sản phẩm";
		}	
	?>
</ul>