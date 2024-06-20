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

    <?php
    // Kiểm tra nếu chưa có thông tin khách hàng trong session thì lấy từ CSDL
    if (!isset($_SESSION["MaKH"])) {
        if (isset($_SESSION["id"])) {
            $userId = $_SESSION["id"];
            $sql_khach_hang = "SELECT `MaKH`, `Ho_ten`, `Dien_thoai`, `Dia_chi` FROM `khach_hang` WHERE `MaKH` = ?";
            $stmt_khach_hang = mysqli_prepare($conn, $sql_khach_hang);

            if ($stmt_khach_hang) {
                mysqli_stmt_bind_param($stmt_khach_hang, "i", $userId);
                if (mysqli_stmt_execute($stmt_khach_hang)) {
                    $result_khach_hang = mysqli_stmt_get_result($stmt_khach_hang);

                    if (mysqli_num_rows($result_khach_hang) > 0) {
                        $row_khach_hang = mysqli_fetch_assoc($result_khach_hang);
                        $_SESSION["MaKH"] = $row_khach_hang["MaKH"];
                        $_SESSION["Ho_ten"] = $row_khach_hang["Ho_ten"];
                        $_SESSION["Dien_thoai"] = $row_khach_hang["Dien_thoai"];
                        $_SESSION["Dia_chi"] = $row_khach_hang["Dia_chi"];
                    } else {
                        echo "<script>alert('Không tìm thấy thông tin khách hàng!');</script>";
                    }
                } else {
                    echo "<script>alert('Lỗi thực thi câu lệnh!');</script>";
                    echo mysqli_stmt_error($stmt_khach_hang); // Debug lỗi
                }
            } else {
                echo "<script>alert('Lỗi chuẩn bị câu lệnh!');</script>";
                echo mysqli_error($conn); // Debug lỗi kết nối
            }
        } else {
            echo "<script>alert('Không có thông tin người dùng!');</script>";
        }
    }

    // Thiết lập giá trị mặc định cho các biến session nếu chưa tồn tại
    $_SESSION["Ho_ten"] = isset($_SESSION["Ho_ten"]) ? $_SESSION["Ho_ten"] : "";
    $_SESSION["Dien_thoai"] = isset($_SESSION["Dien_thoai"]) ? $_SESSION["Dien_thoai"] : "";
    $_SESSION["Dia_chi"] = isset($_SESSION["Dia_chi"]) ? $_SESSION["Dia_chi"] : "";
    ?>

    <!-- Body -->
    <div class="content-center-log main-body">
        <!-- Form đặt hàng -->
        <div style="width: 400px; height: 300px; margin: 0 auto; margin-top: 100px; overflow: hidden; box-sizing: border-box; padding: 10px">
            <fieldset style="padding: 10px">
                <legend><h2>Thông tin giao hàng</h2></legend>
                <form action="#" method="POST" style="width: 100%">
                    <table style="width: 100%" cellspacing="6" cellpadding="6">
                        <!-- Mã khách hàng -->
                        <input type="hidden" name="MaKH" value="<?php echo isset($_SESSION["MaKH"]) ? $_SESSION["MaKH"] : ""; ?>">     
                        <tr>
                            <td>Tên người nhận</td>
                            <td><input type="text" name="Hoten_nguoinhan" required value="<?php echo isset($_SESSION["Ho_ten"]) ? $_SESSION["Ho_ten"] : ""; ?>"> <span style="color: red">*</span></td>
                        </tr>
                        <tr>
                            <td>Điện thoại</td>
                            <td><input type="text" name="Dienthoai_nguoinhan" required value="<?php echo isset($_SESSION["Dien_thoai"]) ? $_SESSION["Dien_thoai"] : ""; ?>"> <span style="color: red">*</span></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td><input type="text" name="Dia_chi_nguoinhan" value="<?php echo isset($_SESSION["Dia_chi"]) ? $_SESSION["Dia_chi"] : ""; ?>"></td>
                        </tr>
                        <tr>    
                            <td></td>                        
                            <td>
                                <input type="submit" name="submit" value="Đặt hàng">
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

        <!-- Xử lý đơn hàng -->
        <?php
        if (isset($_POST["submit"])) {
            // Lấy thông tin từ form
            $MaKH = $_POST["MaKH"];
            $Hoten_nguoinhan = $_POST["Hoten_nguoinhan"];
            $Dienthoai_nguoinhan = $_POST["Dienthoai_nguoinhan"];
            $Dia_chi_nguoinhan = $_POST["Dia_chi_nguoinhan"];

            // Thực hiện câu lệnh SQL để insert đơn hàng
            $sql = "INSERT INTO `hoa_don`(`MaKH`, `Hoten_nguoinhan`, `Dienthoai_nguoinhan`, `Dia_chi_nguoinhan`) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "isss", $MaKH, $Hoten_nguoinhan, $Dienthoai_nguoinhan, $Dia_chi_nguoinhan);
                if (mysqli_stmt_execute($stmt)) {
                    echo "<h1 style='text-align:center'>Đặt hàng thành công</h1>";
                    $idhd = mysqli_stmt_insert_id($stmt); // Lấy id hóa đơn sau khi thêm để sử dụng cho chi tiết hóa đơn
                    if (!empty($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
                        $arrCart = $_SESSION["cart"];
                        $sql_cthd = ""; // Lệnh truy vấn
        
                        foreach ($arrCart as $key => $value) {
                            $sql_cthd .= "INSERT INTO `ct_hoa_don`(`MaHD`, `MaSP`, `So_luong`, `Gia_ban`) VALUES ($idhd, $key, $value, (SELECT `Gia_ban` FROM `San_pham` WHERE `id` = $key)); ";
                        }
        
                        if (mysqli_multi_query($conn, $sql_cthd)) {
                            echo "<h3 style='text-align:center'>Thêm chi tiết Hóa Đơn thành công</h3>";
                        } else {
                            echo "<span style='color:red'>Lỗi thêm Chi Tiết Hóa Đơn: " . mysqli_error($conn) . "</span>";
                        }
                    } else {
                        echo "<span style='color:red'>Giỏ hàng của bạn đang trống.</span>";
                    }
					 // Làm sạch giỏ hàng sau khi thanh toán
                    unset($_SESSION["cart"]);
                    unset($_SESSION["totalBill"]);

                } else {
                    echo "<span style='color:red'>Đặt hàng không thành công!</span>";
                }
            } else {
                echo "<span style='color:red'>Lỗi chuẩn bị câu lệnh SQL: " . mysqli_error($conn) . "</span>";
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
