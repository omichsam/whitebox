<?php
include("../../../base_connect.php");
include("../../../connect.php");

// Get user email from session (plain text)
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $loginuser = $_SESSION["username"];
} else {
    // Fallback – though session should exist
    die("User not logged in.");
}

$today = time();
$new_companyid = 0;

$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$loginuser'") or die(mysqli_error($con));
$get = mysqli_fetch_assoc($get_user);
if (!$get) {
    die("User record not found.");
}
$first_name = $get['first_name'] ?? '';
$user_id = $get['id'] ?? 0;
$last_name = $get['last_name'] ?? '';
$fullname = mysqli_real_escape_string($con, "user" . $user_id . "_" . $first_name . "_" . $last_name . "_" . $today);

$interlect_ip = mysqli_real_escape_string($con, $_POST['ip'] ?? '');
$terms_and_conditions = mysqli_real_escape_string($con, $_POST['terms_and_conditions'] ?? '');
$innovator_type = mysqli_real_escape_string($con, $_POST['innovator_type'] ?? '');
$innovationName = mysqli_real_escape_string($con, $_POST['innovationName'] ?? '');
$company_id = mysqli_real_escape_string($con, $_POST['company_id'] ?? '');
$company_name = mysqli_real_escape_string($con, $_POST['company_name'] ?? '');
$company_registration_no = mysqli_real_escape_string($con, $_POST['company_registration_no'] ?? '');
$kra_pin = mysqli_real_escape_string($con, $_POST['kra_pin'] ?? '');
$company_type = mysqli_real_escape_string($con, $_POST['company_type'] ?? '');
$sector_id = mysqli_real_escape_string($con, $_POST['sector_id'] ?? '');
$InnovationBig4Sector = mysqli_real_escape_string($con, $_POST['InnovationBig4Sector'] ?? '');

if ($interlect_ip && $terms_and_conditions && $innovator_type && $innovationName && $sector_id && $InnovationBig4Sector) {
    // Get sector ID
    $get_sector = mysqli_query($con, "SELECT id FROM sectors WHERE name='$sector_id'") or die(mysqli_error($con));
    $getid = mysqli_fetch_assoc($get_sector);
    $newsector_id = $getid['id'] ?? 0;

    // Get Big4Sector ID
    $get_bigfoursectors = mysqli_query($con, "SELECT id FROM bigfoursectors WHERE Name='$InnovationBig4Sector'") or die(mysqli_error($con));
    $getbigid = mysqli_fetch_assoc($get_bigfoursectors);
    $bg4id_id = $getbigid['id'] ?? 0;

    // Handle company
    if ($company_id) {
        $get_bigcompanysectors = mysqli_query($con, "SELECT id FROM company WHERE company_name='$company_id'") or die(mysqli_error($con));
        $getbivid = mysqli_fetch_assoc($get_bigcompanysectors);
        $new_companyid = $getbivid['id'] ?? 0;
    } else {
        $new_companyid = 0;
    }

    if ($innovator_type == "Company" && $company_name && $company_registration_no && $kra_pin && $company_type) {
        $checkuser = mysqli_query($con, "SELECT * FROM company WHERE company_name='$company_name' and company_registration_no='$company_registration_no' and kra_pin='$kra_pin'") or die(mysqli_error($con));
        if (mysqli_num_rows($checkuser) != 0) {
            $get_bigcompanysectors = mysqli_query($con, "SELECT id FROM company WHERE company_name='$company_name' and company_registration_no='$company_registration_no' and kra_pin='$kra_pin'") or die(mysqli_error($con));
            $getbivid = mysqli_fetch_assoc($get_bigcompanysectors);
            $new_companyid = $getbivid['id'] ?? 0;
        } else {
            $addVist = mysqli_query($con, "INSERT INTO company VALUES (NULL, '$user_id', '$company_name', '$company_registration_no', '$kra_pin', '$company_type', '', '$today', '$today')") or die(mysqli_error($con));
            $get_bigcompanysectors = mysqli_query($con, "SELECT id FROM company WHERE company_name='$company_name' and company_registration_no='$company_registration_no' and kra_pin='$kra_pin' and user_id='$user_id'") or die(mysqli_error($con));
            $getbivid = mysqli_fetch_assoc($get_bigcompanysectors);
            $new_companyid = $getbivid['id'] ?? 0;
        }
    }

    // Check if pending innovation exists
    $checkuser = mysqli_query($con, "SELECT * FROM innovations_table WHERE user_id='$user_id' and Status='pending'") or die(mysqli_error($con));
    if (mysqli_num_rows($checkuser) != 0) {
        $update = mysqli_query($con, "UPDATE innovations_table SET Innovation_name='$innovationName', sector_id='$newsector_id', InnovationBig4Sector='$bg4id_id', innovator_type='$innovator_type', company_id='$new_companyid' WHERE user_id='$user_id' and status='pending'") or die(mysqli_error($con));
        echo base64_encode("success");
    } else {
        $addVist = mysqli_query($con, "INSERT INTO innovations_table VALUES (NULL, '$user_id', '$innovationName', '$newsector_id', '$bg4id_id', '$innovator_type', '$new_companyid', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'pending', '$terms_and_conditions', '', '$interlect_ip', '$today')") or die(mysqli_error($con));
        echo base64_encode("success");
    }
} else {
    // Missing required fields – optionally output error
    echo base64_encode("missing_fields");
}
?>