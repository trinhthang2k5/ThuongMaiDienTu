<?php
function uploadFile($filePath, $filename) {
    $target_dir = "../public/images/";
    $target_file = $target_dir . basename($filename);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $error_message = "";

    // Check if image file is a actual image or fake image
    $check = getimagesize($filePath["tmp_name"]);
    if ($check === false) {
        $error_message = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($filePath["size"] > 500000) { // 500KB
        $error_message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return $error_message;
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($filePath["tmp_name"], $target_file)) {
            return "success";
        } else {
            return "Sorry, there was an error uploading your file.";
        }
    }
}
?>
