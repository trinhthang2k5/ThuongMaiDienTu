<h3 style="text-transform: uppercase; padding: 5px">Danh mục sản phẩm</h3>
<ul class="no-list-style catelog">	
	<?php
		$sql = "SELECT * FROM `catalog`";
		$result = mysqli_query($bkconn, $sql);

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<a href='index.php?idcat=". $row["id"] ."'><li>".$row["title"]."</li></a>";
			}
		} else {
			echo "không tồn tại bảng danh mục sản phẩm";
		}		
	?>
</ul>