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
    echo base64_encode("user_not_found");
    exit;
}

$today = date('Y-m-d');

// Sanitize inputs
$first_name = mysqli_real_escape_string($con, $_POST['first_name'] ?? '');
$last_name = mysqli_real_escape_string($con, $_POST['last_name'] ?? '');
$gender = mysqli_real_escape_string($con, $_POST['gender'] ?? '');
$pdtp_number = mysqli_real_escape_string($con, $_POST['pdtp_number'] ?? '');
$dob = mysqli_real_escape_string($con, $_POST['dob'] ?? '');
$bio = mysqli_real_escape_string($con, $_POST['bio'] ?? '');
$universities = mysqli_real_escape_string($con, $_POST['University_id'] ?? '');
$educationlevels = mysqli_real_escape_string($con, $_POST['EducationLevel_id'] ?? '');
$SecondarySchool = mysqli_real_escape_string($con, $_POST['SecondarySchool'] ?? '');
$College = mysqli_real_escape_string($con, $_POST['College'] ?? '');
$Certifications = mysqli_real_escape_string($con, $_POST['Certifications'] ?? '');
$email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
$address = mysqli_real_escape_string($con, $_POST['address'] ?? '');
$country = mysqli_real_escape_string($con, $_POST['country'] ?? '');
$county_id = mysqli_real_escape_string($con, $_POST['county_id'] ?? '');
$education_high = mysqli_real_escape_string($con, $_POST['education_high'] ?? '');
$PrimarySchool = mysqli_real_escape_string($con, $_POST['PrimarySchool'] ?? '');

// Get user data
$get_user = mysqli_query($con, "SELECT * FROM users WHERE email='$loginuser'") or die(mysqli_error($con));
$get = mysqli_fetch_assoc($get_user);
if (!$get) {
    echo base64_encode("user_not_found");
    exit;
}
$user_id = $get['id'];

// Get e_learning user if exists
$get_userg = mysqli_query($con, "SELECT * FROM e_learning_users WHERE email='$loginuser'") or die(mysqli_error($con));
$getp = mysqli_fetch_assoc($get_userg);
$user_pd = $getp['id'] ?? 0;

// Get county serial number
$getccounties = mysqli_query($con, "SELECT * FROM counties WHERE county_name='$county_id'") or die(mysqli_error($con));
$getcounties = mysqli_fetch_assoc($getccounties);
$serial_no = $getcounties['serial_no'] ?? '';

// Get country sortname
$getccountry = mysqli_query($con, "SELECT * FROM countries WHERE name='$country'") or die(mysqli_error($con));
$getcountryd = mysqli_fetch_assoc($getccountry);
$sortname = $getcountryd['sortname'] ?? '';

// Get university ID
$get_university = mysqli_query($con, "SELECT * FROM universities WHERE UniversityName='$universities'") or die(mysqli_error($con));
$getuniversity = mysqli_fetch_assoc($get_university);
$University_id = $getuniversity['id'] ?? 0;

// Get education level ID
$geteducation_levels = mysqli_query($con, "SELECT * FROM education_levels WHERE EducationLevelName='$educationlevels'") or die(mysqli_error($con));
$geteducationlevels = mysqli_fetch_assoc($geteducation_levels);
$Education_id = $geteducationlevels['id'] ?? 0;

// Update users table
$updates = mysqli_query($con, "UPDATE users SET email='$email', first_name='$first_name', last_name='$last_name', gender='$gender', dob='$dob', county_id='$serial_no', country='$sortname', address='$address', bio='$bio' WHERE id='$user_id'") or die(mysqli_error($con));

// Update e_learning_users if exists
if ($user_pd > 0) {
    mysqli_query($con, "UPDATE e_learning_users SET email='$email' WHERE id='$user_pd'") or die(mysqli_error($con));
}

// Update session email (store plain text, not base64)
$_SESSION["username"] = $email;

// Check if education record exists
$checkExist = mysqli_query($con, "SELECT * FROM education WHERE user_id='$user_id'") or die(mysqli_error($con));
if (mysqli_num_rows($checkExist) != 0) {
    $update_edu = mysqli_query($con, "UPDATE education SET University_id='$University_id', PrimarySchool='$PrimarySchool', EducationLevel_id='$Education_id', education_high='$education_high', SecondarySchool='$SecondarySchool', Certifications='$Certifications', College='$College', Pdtp_number='$pdtp_number' WHERE user_id='$user_id'") or die(mysqli_error($con));
} else {
    $insert_edu = mysqli_query($con, "INSERT INTO education VALUES (NULL, '$user_id', '$University_id', '$Education_id', '$education_high', '$College', '$PrimarySchool', '$SecondarySchool', '$Certifications', '$today', '$today', '$pdtp_number')") or die(mysqli_error($con));
}

echo base64_encode("success");
?>