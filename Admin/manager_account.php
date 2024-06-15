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
        table tr:hover {
            background-color: yellow;
        }

        .box-odd {
            background-color: cyan;
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
        <div style="width: 80%; float:left; overflow: hidden; box-sizing: border-box; padding: 10px;" class="container mt-3">
            <!-- Trang quản lý user -->
            <h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý tài khoản</h1>
            <!-- Mở kết nối tới csdl -->
            <?php 
                include_once 'tmdt_connect.php';            
                // Tải hóa đơn (all)
                $sql = "SELECT * FROM `quan_tri`";

                $result = mysqli_query($tmdtconn, $sql); // Truy vấn

                // Duyệt hiển thị dữ liệu
                if (mysqli_num_rows($result) > 0) {
                    // Code bảng dữ liệu hiển thị
            ?>
                <table class="table table-hover">
                    <tr>
                        <th>Tên tài khoản</th>
                        <th>Mật khẩu</th>
                        <th><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAccountModal">Thêm mới</button></th>
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
                        echo "<td>".$row["Tai_khoan"]."</td>";
                        echo "<td>".$row["Mat_khau"]."</td>";
                        ?>
                        <td style="padding-left: 27px;"><a onclick="return confirm('Bạn có muốn xóa tài khoản này không?');" href="delete_user.php?accid=<?php echo $row["id"] ?>" class="btn btn-danger">Xóa</a></td>
                        <?php
                    }
                    ?>
                </table>
                <?php
                }
                ?>
        </div>
    </div>

    <!-- Modal for Adding New Account -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountModalLabel">Thêm tài khoản mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_user.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên tài khoản</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
