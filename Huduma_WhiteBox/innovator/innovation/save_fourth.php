<?php
include("../../../base_connect.php");
include("../../../connect.php");

// Get user email from session (plain text)
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $loginuser = $_SESSION["username"];
} else {
    $loginuser = base64_decode($_POST['token_bd'] ?? '');
}

if (empty($loginuser)) {
    die("User not identified.");
}

$new_names = "";
$today = time();

$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$loginuser'") or die(mysqli_error($con));
$get = mysqli_fetch_assoc($get_user);
if (!$get) {
    die("User record not found.");
}
$first_name = $get['first_name'] ?? '';
$user_id = $get['id'] ?? 0;
$last_name = $get['last_name'] ?? '';

if ($user_id == 0) {
    die("Invalid user ID.");
}

$fullname = mysqli_real_escape_string($con, "user" . $user_id . "_" . $first_name . "_" . $last_name . "_" . $today);

$get_pending = mysqli_query($con, "SELECT Innovation_Id FROM innovations_table WHERE user_id='$user_id' and status='pending'") or die(mysqli_error($con));
$getpending = mysqli_fetch_assoc($get_pending);
$Innovation_Id = (int)($getpending['Innovation_Id'] ?? 0);

if ($Innovation_Id == 0) {
    die("No pending innovation found.");
}

// Handle partners
$number_partners = (int)($_POST['number_partners'] ?? 0);
for ($ad = 1; $ad <= $number_partners; $ad++) {
    $base = "Member_" . $ad;
    $roled = "role_" . $ad;
    $nameds = mysqli_real_escape_string($con, $_POST[$base] ?? '');
    $roles = mysqli_real_escape_string($con, $_POST[$roled] ?? '');

    $checkuser = mysqli_query($con, "SELECT * FROM innovators_partners WHERE member_id='$ad' and Innovation_Id='$Innovation_Id'") or die(mysqli_error($con));
    if (mysqli_num_rows($checkuser) != 0) {
        $update = mysqli_query($con, "UPDATE innovators_partners SET member_name='$nameds', member_role='$roles' WHERE member_id='$ad' and Innovation_Id='$Innovation_Id'") or die(mysqli_error($con));
    } else {
        $addmember = mysqli_query($con, "INSERT INTO innovators_partners VALUES (NULL, '$Innovation_Id', '$ad', '$nameds', '$roles')") or die(mysqli_error($con));
    }
}

// Handle expectations
$acquisition = mysqli_real_escape_string($con, $_POST['acquisition'] ?? '');
$funding = mysqli_real_escape_string($con, $_POST['funding'] ?? '');
$user_defined = mysqli_real_escape_string($con, $_POST['user_defined'] ?? '');
$othersd = mysqli_real_escape_string($con, $_POST['othersd'] ?? '');
$implementers = mysqli_real_escape_string($con, $_POST['implementers'] ?? '');
$patnership = mysqli_real_escape_string($con, $_POST['patnership'] ?? '');
$link = mysqli_real_escape_string($con, $_POST['link'] ?? '');

if ($funding || $othersd || $implementers || $patnership || $acquisition) {
    $checkuser = mysqli_query($con, "SELECT * FROM innovation_expectation WHERE Innovation_id='$Innovation_Id'") or die(mysqli_error($con));
    if (mysqli_num_rows($checkuser) != 0) {
        $update = mysqli_query($con, "UPDATE innovation_expectation SET petnership_implementors='$implementers', patnership_innovators='$patnership', funding='$funding', communities='$user_defined', acquisition='$acquisition' WHERE Innovation_id='$Innovation_Id'") or die(mysqli_error($con));
    } else {
        $addmember = mysqli_query($con, "INSERT INTO innovation_expectation VALUES (NULL, '$Innovation_Id', '$implementers', '$patnership', '$funding', '$user_defined', '$acquisition')") or die(mysqli_error($con));
    }
}

// Handle supporting document
if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
    $atachment = $_FILES['file']['name'];
    $picsize = $_FILES['file']['size'];
    $pictmp = $_FILES['file']['tmp_name'];
    @move_uploaded_file($pictmp, "../../documents/supportdocs/" . $_FILES['file']['name']);
    if ($atachment) {
        rename("../../documents/supportdocs/" . $_FILES['file']['name'], "../../documents/supportdocs/" . $fullname . ".pdf");
        $new_names = $fullname . ".pdf";
    } else {
        $new_names = "";
    }
} else {
    $new_names = "";
}

// Handle intellectual property document
$Propert = $_POST['propertyselected'] ?? '';
if ($Propert == "Yes") {
    if (isset($_FILES['doc']['name']) && $_FILES['doc']['name'] != '') {
        $atachment = $_FILES['doc']['name'];
        $picsize = $_FILES['doc']['size'];
        $pictmp = $_FILES['doc']['tmp_name'];
        @move_uploaded_file($pictmp, "../../documents/propertyatachments/" . $_FILES['doc']['name']);
        if ($atachment) {
            rename("../../documents/propertyatachments/" . $_FILES['doc']['name'], "../../documents/propertyatachments/" . $fullname . ".pdf");
            $new_proprty = $fullname . ".pdf";
        } else {
            $new_proprty = "";
        }
    } else {
        $new_proprty = "";
    }
} else {
    $new_proprty = "";
}

$update = mysqli_query($con, "UPDATE innovations_table SET useful_links='$link', attachments='$new_names', property_attachement='$new_proprty' WHERE Innovation_Id='$Innovation_Id' and user_id='$user_id'") or die(mysqli_error($con));

if ($update) {
    echo base64_encode("success");
} else {
    echo base64_encode("error");
}
?>