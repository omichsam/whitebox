<?php
include("../../../base_connect.php");
include("../../../connect.php");

// Get user email from session (plain text)
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $loginuser = $_SESSION["username"];
} else {
    $loginuser = $_POST['userd'] ?? '';
}

if (empty($loginuser)) {
    echo "user_not_found";
    exit;
}

$dated = time();

$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$loginuser'") or die(mysqli_error($con));
$get = mysqli_fetch_assoc($get_user);
if (!$get) {
    echo "user_not_found";
    exit;
}

$first_name = $get['first_name'] ?? '';
$id = $get['id'] ?? 0;
$last_name = $get['last_name'] ?? '';
$fullname = mysqli_real_escape_string($con, "user" . $id . "_" . $first_name . "_" . $last_name . "_" . $dated);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['upfile']['name']) && $_FILES['upfile']['error'] == 0) {
    $picname = $_FILES['upfile']['name'];
    $picsize = $_FILES['upfile']['size'];
    $pictmp = $_FILES['upfile']['tmp_name'];

    // Ensure target directory exists
    $target_dir = "../../images/innovators/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Move uploaded file
    $target_file = $target_dir . basename($picname);
    if (move_uploaded_file($pictmp, $target_file)) {
        // Rename to desired name
        $new_names = $fullname . ".png";
        $new_path = $target_dir . $new_names;
        if (rename($target_file, $new_path)) {
            $update = mysqli_query($con, "UPDATE users SET pic='$new_names' WHERE email='$loginuser'") or die(mysqli_error($con));
            if ($update) {
                echo "success";
            } else {
                echo "db_error";
            }
        } else {
            echo "rename_failed";
        }
    } else {
        echo "upload_failed";
    }
} else {
    echo "no_file";
}
?>