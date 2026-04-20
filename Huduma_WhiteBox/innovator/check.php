<?php
session_start(); // START SESSION

include("../../base_connect.php");
include("../../connect.php");

// Get user email – first from session, else from POST
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $loginuser = $_SESSION["username"];  // No base64_decode – it's plain text
} else {
    $loginuser = base64_decode($_POST['my_id'] ?? '');
}

if (empty($loginuser)) {
    echo base64_encode("notactive");
    exit;
}

$today = time();

$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$loginuser'") or die(mysqli_error($con));
$get = mysqli_fetch_assoc($get_user);

if (!$get) {
    echo base64_encode("notactive");
    exit;
}

$first_name      = $get['first_name'] ?? '';
$user_id         = $get['id'] ?? '';
$last_name       = $get['last_name'] ?? '';
$bio             = $get['bio'] ?? '';
$county_id       = $get['county_id'] ?? '';
$dob             = $get['dob'] ?? '';
$gender          = $get['gender'] ?? '';

$educate = mysqli_query($con, "SELECT * FROM education WHERE user_id='$user_id'") or die(mysqli_error($con));
$getp = mysqli_fetch_assoc($educate);

$University_id      = $getp['University_id'] ?? '';
$PrimarySchool      = $getp['PrimarySchool'] ?? '';
$EducationLevel_id  = $getp['EducationLevel_id'] ?? '';
$education_high     = $getp['education_high'] ?? '';
$College            = $getp['College'] ?? '';

if ($first_name && $last_name && $dob && $gender && $EducationLevel_id && $education_high) {
    echo base64_encode("active");
} else {
    echo base64_encode("notactive");
}
?>