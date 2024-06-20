<?php
include_once 'tmdt_connect.php';

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    $sql = "SELECT san_pham.MaSP, san_pham.Ten_sp, san_pham.Mo_ta, san_pham.Thong_tin, san_pham.Gia_ban, san_pham.Hinh_anh, san_pham.So_luong,
                   san_pham.Ten_nhan_hieu, san_pham.Ngay_cap_nhap, san_pham.Trang_thai, loai_san_pham.Ten_loai
            FROM `san_pham` JOIN `loai_san_pham` ON san_pham.MaLSP = loai_san_pham.MaLSP
            WHERE san_pham.MaSP = '$productId'";
    $result = mysqli_query($tmdtconn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
?>
