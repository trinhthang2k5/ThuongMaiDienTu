<?php
include_once 'tmdt_connect.php';

if (isset($_GET['invoiceId'])) {
    $invoiceId = $_GET['invoiceId'];
    $sql = "SELECT hoa_don.MaHD, hoa_don.Ngay_HD, hoa_don.Hoten_nguoinhan, hoa_don.Diachi_nguoinhan, hoa_don.Dienthoai_nguoinhan, hoa_don.Diachi_email, 
    hoa_don.Ngay_giao_hang, ct_hoa_don.So_luong_ban, ct_hoa_don.Gia_ban, san_pham.Ten_sp, san_pham.Thong_tin, pt_thanh_toan.Ten_PTTT, pt_van_chuyen.TenPTVC
            FROM `hoa_don` JOIN `ct_hoa_don` ON hoa_don.MaHD = ct_hoa_don.MaHD
                           JOIN `san_pham` ON hoa_don.MaSP = san_pham.MaSP
                           JOIN `pt_thanh_toan` ON hoa_don.MaPTTT = pt_thanh_toan.MaPTTT
                           JOIN `pt_van_chuyen` ON hoa_don.MaPTVC = pt_van_chuyen.MaPTVC
            WHERE hoa_don.MaHD = '$invoiceId'";

    $result = mysqli_query($tmdtconn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
?>
