<?php
include("../../base_connect.php");
include("../../connect.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Getting variables
$loginuser = '';

if (isset($_SESSION["username"])) {
  $loginuser = base64_decode($_SESSION["username"]);
} elseif (isset($_POST['my_id'])) {
  $loginuser = base64_decode($_POST['my_id']);
}

if (empty($loginuser)) {
  echo base64_encode("inactive");
  exit;
}

// Fetch user data
$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$loginuser'");
if (!$get_user) {
  echo base64_encode("inactive");
  exit;
}

$get = mysqli_fetch_assoc($get_user);
if (!$get) {
  echo base64_encode("inactive");
  exit;
}

// Get user fields
$first_name = $get['first_name'];
$user_id = $get['id'];
$last_name = $get['last_name'];
$bio = $get['bio'];
$county_id = $get['county_id'];
$dob = $get['dob'];
$gender = $get['gender'];
$address = $get['address'];
$country = $get['country'];
$city = $get['city'];
$phone = $get['phone'];
$pic = $get['pic'];

// Check required fields (matching dashboard.php)
$required_fields = [
  'first_name' => $first_name,
  'last_name' => $last_name,
  'address' => $address,
  'county_id' => $county_id,
  'country' => $country,
  'pic' => $pic,
  'dob' => $dob,
  'phone' => $phone,
  'city' => $city
];

$missing = [];
foreach ($required_fields as $field => $value) {
  if (empty($value)) {
    $missing[] = $field;
  }
}

// Return active only if all required fields are present
if (empty($missing)) {
  echo base64_encode("active");
} else {
  // For debugging - you can check the error log
  error_log("Profile incomplete for $loginuser. Missing: " . implode(', ', $missing));
  echo base64_encode("inactive");
}
?>