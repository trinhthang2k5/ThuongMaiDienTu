<?php
include_once 'tmdt_connect.php';

if (isset($_GET['invoiceId'])) {
    $invoiceId = $_GET['invoiceId'];
    $sql = "SELECT hoa_don.MaHD, hoa_don.Ngayxuat_HD, hoa_don.Hoten_nguoinhan, hoa_don.Dia_chi_nguoinhan, hoa_don.Dienthoai_nguoinhan, hoa_don.Diachi_email, 
    hoa_don.Ngay_giao_hang, ct_hoa_don.So_luong, ct_hoa_don.Gia_ban, san_pham.Ten_sp, san_pham.Thong_tin, pt_thanh_toan.Ten_PTTT, pt_van_chuyen.Ten_PTVC
            FROM `ct_hoa_don` JOIN `hoa_don` ON hoa_don.MaHD = ct_hoa_don.MaHD
                           JOIN `san_pham` ON ct_hoa_don.MaSP = san_pham.MaSP
                           JOIN `pt_thanh_toan` ON ct_hoa_don.MaPTTT = pt_thanh_toan.MaPTTT
                           JOIN `pt_van_chuyen` ON ct_hoa_don.MaPTVC = pt_van_chuyen.MaPTVC
            WHERE ct_hoa_don.MaHD = '$invoiceId'";

    $result = mysqli_query($tmdtconn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
?>
