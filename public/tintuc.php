<?php
  include_once 'bk_connect.php';
?>
<?php
	// 1. Lệnh truy vấn 
	$sql = "SELECT * FROM `tin_tuc`";
	// 2. Truy vấn
	$result = mysqli_query($conn, $sql);
    // var_dump($result);
    // die();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th colspan="2">TIN TỨC MỚI</th>
        </tr>
        <?php foreach($result as $rs){?>
        <tr>
            <td><img width='60px' height='60px' src="public/images/<?php echo $rs['Hinh_anh']; ?>"></td>
            <td><?php echo $rs['Tieu_de']; ?></td>
        </tr>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
