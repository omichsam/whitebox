<?php
include("../../base_connect.php");
include("../../connect.php");

// Get user email – session username is plain text
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $user = $_SESSION["username"];
} else {
    $user = base64_decode($_POST["my_id"] ?? '');
}

if (empty($user)) {
    die("User not identified.");
}

$now_time = time();
$today = date('Y-m-d');
$historypage = base64_decode($_POST['historypage'] ?? '');

$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$user'") or die(mysqli_error($con));
$get = mysqli_fetch_assoc($get_user);
$user_id = $get['id'] ?? 0;

if ($user_id == 0) {
    die("Invalid user.");
}

$checkuser = mysqli_query($con, "SELECT * FROM page_history WHERE user_id='$user_id' AND status='active' AND date_added='$today'") or die(mysqli_error($con));

if (mysqli_num_rows($checkuser) != 0) {
    // Deactivate previous active and old pages
    mysqli_query($con, "UPDATE page_history SET status='oldpage' WHERE user_id='$user_id' AND status='previous' AND date_added='$today'");
    mysqli_query($con, "UPDATE page_history SET status='previous' WHERE user_id='$user_id' AND status='active' AND date_added='$today'");
}

// Insert new page history
mysqli_query($con, "INSERT INTO page_history VALUES (NULL, '$user_id', '$historypage', 'active', '$now_time', '$today')") or die(mysqli_error($con));
?>