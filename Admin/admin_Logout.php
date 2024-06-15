<?php
// Khởi động session
session_start();

// Xóa tất cả các biến session
$_SESSION = array();

// Nếu sử dụng session cookies, thì cũng xóa nó
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc trang chính
header("Location: index.php");
exit;
?>
