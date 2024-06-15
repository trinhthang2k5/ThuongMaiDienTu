<?php
include_once 'tmdt_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Ensure to sanitize inputs and hash the password in a real application
    $sql = "INSERT INTO `quan_tri` (Tai_khoan, Mat_khau) VALUES ('$username', '$password')";

 mysqli_query($tmdtconn, $sql);

    header("Location: manager_account.php");
}
?>
