<?php
include("../../../base_connect.php");
include("../../../connect.php");

// Get user email from session (plain text)
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $loginuser = $_SESSION["username"];
} else {
    die("User not logged in.");
}

$today = time();

$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$loginuser'") or die(mysqli_error($con));
$get = mysqli_fetch_assoc($get_user);
if (!$get) {
    die("User record not found.");
}
$first_name = $get['first_name'] ?? '';
$user_id = $get['id'] ?? 0;
$last_name = $get['last_name'] ?? '';
$fullname = mysqli_real_escape_string($con, "user" . $user_id . "_" . $first_name . "_" . $last_name . "_" . $today);

$ProblemSolution = mysqli_real_escape_string($con, $_POST['ProblemSolution'] ?? '');
$Problemidentified = mysqli_real_escape_string($con, $_POST['Problemidentified'] ?? '');
$impact = mysqli_real_escape_string($con, $_POST['impact'] ?? '');
$InnovationLevel = mysqli_real_escape_string($con, $_POST['InnovationLevel'] ?? '');
$ideas = mysqli_real_escape_string($con, $_POST['ideas'] ?? '');
$Explain = mysqli_real_escape_string($con, $_POST['Explain'] ?? '');

if ($ProblemSolution && $Problemidentified && $impact && $InnovationLevel && $ideas && $Explain) {
    $update = mysqli_query($con, "UPDATE innovations_table SET need='$Problemidentified', solution='$ProblemSolution', impact='$impact', originality='$ideas', originality_explanation='$Explain', stage='$InnovationLevel' WHERE user_id='$user_id' and status='pending'") or die(mysqli_error($con));
    echo base64_encode("success");
} else {
    echo base64_encode("missing_fields");
}
?>