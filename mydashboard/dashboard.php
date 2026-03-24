<?php
//session_start();
//include("../base_connect.php");
include("../connect.php");

// Get user email from POST
$user = isset($_POST["model"]) ? base64_decode($_POST["model"]) : '';

if (empty($user)) {
    die("User not found");
}

$today = date('Y-m-d');
$get_elerning = "not_shown";

// Fetch user data
$sql = "SELECT * FROM users WHERE email='$user'";
$query_run = mysqli_query($con, $sql) or die(mysqli_error($con));

$first_name = $last_name = $bio = $gender = $dob = $pic = $country = $county_id = '';
$user_state = $city = $address = $postal = $provider = $provider_id = $county = $phone = $user_id = '';

while ($row = mysqli_fetch_array($query_run)) {
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $bio = $row['bio'];
    $gender = $row['gender'];
    $dob = $row['dob'];
    $pic = $row['pic'];
    $country = $row['country'];
    $county_id = $row['county_id'];
    $user_state = $row['user_state'];
    $city = $row['city'];
    $address = $row['address'];
    $postal = $row['postal'];
    $provider = $row['provider'];
    $provider_id = $row['provider_id'];
    $county = $row['county'];
    $phone = $row['phone'];
    $user_id = $row['id'];
}

// Check if profile is complete
$required_fields = [
    'address' => $address,
    'county_id' => $county_id,
    'country' => $country,
    'pic' => $pic,
    'dob' => $dob,
    'last_name' => $last_name,
    'first_name' => $first_name,
    'phone' => $phone,
    'city' => $city
];

$missing_fields = [];
foreach ($required_fields as $field => $value) {
    if (empty($value)) {
        $missing_fields[] = $field;
    }
}

$profile_complete = empty($missing_fields);
$profile_status = $profile_complete ? "active" : "incomplete";

if ($profile_complete) {
    $error_message = "Welcome: $first_name";
} else {
    $error_message = "Welcome: $first_name";
}
// End profile completion check

// Check e-learning access
$couted = 0;
$sql = "SELECT * FROM e_learning_users WHERE email='$user'";
$query_run = mysqli_query($con, $sql) or die(mysqli_error($con));

while ($row = mysqli_fetch_array($query_run)) {
    $couted++;
}

if ($couted > 0) {
    $get_elerning = "";
} else {
    $get_elerning = "not_shown";
}

// Check pitch availability
$day = 0;
$times = 0;
$pitchmode = "not_shown";
$fulldate = 0;
$Innovation_Id = 0;
$time_variant = time();
$contb = 1800;
$new_time = $time_variant + $contb;

$sqlde = "SELECT * FROM innovations_table WHERE user_id ='$user_id'";
$query_runr = mysqli_query($con, $sqlde) or die(mysqli_error($con));

while ($row = mysqli_fetch_array($query_runr)) {
    $Innovation_Id = $row['Innovation_Id'];
    if ($Innovation_Id) {
        $get_event = mysqli_query($con, "SELECT * FROM events WHERE Innovation_Id='$Innovation_Id'") or die(mysqli_error($con));
        $getevent = mysqli_fetch_assoc($get_event);
        if ($getevent) {
            $day = $getevent['planned_date'];
            $times = $getevent['planned_time'];
            $status = $getevent['status'];
            if ($day && $times) {
                $fulldate = date('m/d/Y H:i:s', $day);
                if ($time_variant >= $day) {
                    $superdate = $time_variant - $day;
                    if ($superdate >= $contb) {
                        $pitchmode = "not_shown";
                    } else {
                        $pitchmode = "";
                    }
                } else {
                    $pitchmode = "";
                }
            }
        }
    }
}

// Check page history
$new_page = "";
$sqlxlk = "SELECT * FROM page_history WHERE status='active' AND user_id='$user_id' AND date_added='$today'";
$query_runxlk = mysqli_query($con, $sqlxlk) or die(mysqli_error($con));

while ($row = mysqli_fetch_array($query_runxlk)) {
    $new_page = $row['page'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhiteBox Dashboard</title>

    <!-- Global CSS starts -->
    <link rel="stylesheet" type="text/css" href="Huduma_WhiteBox/css/lib.css">
    <link href="Huduma_WhiteBox/css/app.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="Huduma_WhiteBox/css/animate.css">
    <link rel="stylesheet" href="Huduma_WhiteBox/css/only_dashboard.css">
    <link rel="stylesheet" href="Huduma_WhiteBox/css/morris.css">

    <style type="text/css">
        .notyholderp {
            color: red;
        }

        .not_shown {
            display: none;
        }

        .user_btns {
            cursor: pointer;
        }

        #home_display {
            min-height: 300px;
            background: #f5efed;
            min-width: 100% !important;
        }

        .menu_dtz {
            cursor: pointer;
        }

        .timer_span {
            display: inline-block;
            font-size: 1.0em;
            list-style-type: none;
            padding: 1em;
            text-transform: uppercase;
        }

        .timer_span_li {
            display: block;
            font-size: 2.5rem;
            color: #5F0000;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .logout-btn {
            color: #fff;
            cursor: pointer;
            float: right;
        }

        .spacer {
            float: right;
            margin-left: 15px;
        }
    </style>
</head>

<body>

    <input type="hidden" id="user_email" value="<?php echo base64_encode($user); ?>">
    <input type="hidden" id="profile_status" value="<?php echo $profile_status; ?>">

    <script type="text/javascript" src="Huduma_WhiteBox/js/jquery.js"></script>
    <script charset="utf-8" src="Huduma_WhiteBox/css/momenttimelinetweet.js"></script>
    <script charset="utf-8" src="Huduma_WhiteBox/css/timeline.js"></script>

    <!-- Header Start -->
    <nav class="navbar navbar-default container-fluid" style="max-height: 77px !important">
        <div class="navbar-header" style="max-height: 66px !important">
            <button type="button" id="back_dashb" class="navbar-toggle collapsed">
                <span><a href="#"><i class="livicon" data-name="responsive-menu" data-size="25" data-loop="true"
                            data-c="#757b87" data-hc="#ccc" id="livicon-1" style="width: 25px; height: 25px;"></i>
                    </a></span>
            </button>
            <a class="menu_dtz" class="navbar-brand"><img src="Huduma_WhiteBox/Whitebox.png" alt="logo"
                    class="logo_positiondd">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a class="menu_dtz btn notificationbtn" id=""><i class="fa fa-bell bell_hides no-radius"></i><i
                            class="notyholderp"></i></a>
                </li>
                <li><a class="menu_dtz" id="backtoDashboard">My Dashboard</a></li>
                <li><a class="menu_dtz" id="logout">Logout</a></li>
                <a class="navbar-brand "><img src="Huduma_WhiteBox/moict.png" alt="logo" class="logo_position"> </a>

                <!-- Modal -->
                <div class="modal" id="mainMenu">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <hr class="text-warning" style="border: solid 1px;">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://www.whitebox.go.ke/advisory">
                                                <i class="livicon" data-name="comments" data-size="40" data-loop="true"
                                                    data-c="green" data-hc="#BC0000" id="livicon-3"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">Advisory Council</p>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://www.whitebox.go.ke/SecTeam">
                                                <i class="livicon" data-name="users" data-size="40" data-loop="true"
                                                    data-c="brown" data-hc="black" id="livicon-4"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">Secretariat</p>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://www.whitebox.go.ke/investors">
                                                <i class="livicon" data-name="briefcase" data-size="40" data-loop="true"
                                                    data-c="purple" data-hc="orange" id="livicon-5"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">Investors</p>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="text-primary">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://www.whitebox.go.ke/contact">
                                                <i class="livicon" data-name="tablet" data-size="40" data-loop="true"
                                                    data-c="#757b87" data-hc="#5BC0DE" id="livicon-6"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">Talk to us</p>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://www.whitebox.go.ke/partners">
                                                <i class="livicon" data-name="link" data-size="40" data-loop="true"
                                                    data-c="#ffad4e" data-hc="black" id="livicon-7"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">Partners</p>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://www.whitebox.go.ke/faq">
                                                <i class="livicon" data-name="question" data-size="40" data-loop="true"
                                                    data-c="#FC936D" data-hc="#4483cb" id="livicon-8"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">FAQs</p>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="text-primary">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://goo.gl/pqfuzq" target="_blank">
                                                <i class="livicon" data-name="desktop" data-size="40" data-loop="true"
                                                    data-c="#88b0dd" data-hc="#44cecb" id="livicon-9"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">Virtual Library</p>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                            <a href="https://www.whitebox.go.ke/eventcalender">
                                                <i class="livicon" data-name="clapboard" data-size="40" data-loop="true"
                                                    data-c="#4d79ff" data-hc="#ff1a1a" id="livicon-10"
                                                    style="width: 40px; height: 40px;"></i>
                                                <p style="text-align: center;">Media</p>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="text-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
    </nav>
    <!-- Header End -->

    <!-- Profile Completion Warning -->
    <?php if (!$profile_complete && !empty($missing_fields)): ?>
        <div class="alert alert-warning" style="margin: 20px;">
            <strong>⚠️ Profile Incomplete!</strong> Please complete your profile to access all features.
            Missing fields:
            <?php
            $missing_display = [];
            foreach ($missing_fields as $field) {
                $missing_display[] = ucfirst(str_replace('_', ' ', $field));
            }
            echo implode(', ', $missing_display);
            ?>
        </div>
    <?php endif; ?>

    <div class="ribbon"></div>

    <!-- Content Section -->
    <section class="content-header dashboard_holder my-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <h3 id="dashpdrt" class="mb-0 mr-3">
                    <?php echo $error_message ?>
                </h3>
                <span class="hidden-xs header_info" id="dashboard_loaders"></span>
            </div>

            <div class="d-flex align-items-center">
                <a class="notificationbtn btn menu_dtz desktop_hidden mr-2" id="notifications">
                    <i class="fa fa-bell not_shown bell_hides"></i>
                    <i class="notyholderp"></i>
                </a>
                <a class="btn desktop_hidden btn-danger" id="log_touter" style="color: #fff;cursor: pointer;">Logout</a>
            </div>
        </div>
    </section>

    <section class="col-md-12 container-fluid not_shown no_padding" id="content_divesr"></section>
    <section class="col-md-12 container-fluid not_shown no_padding" id="home_display"></section>
    <section class="col-md-12 container-fluid not_shown no_padding" id="clock_holders"
        style="text-align: center;background: #fff">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-xs-12 col-sm-6" id="clock_data" style="float:center !important;"></div>
        </div>
    </section>

    <!-- Dashboard Cards -->
    <section class="content dashboard_holder py-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig user_btns" role="profile"
                style="margin-bottom: 50px;">
                <div class="lightbluebg no-radius">
                    <div class="panel-body squarebox square_boxs user-cards">
                        <div class="col-md-12 pull-left nopadmar no_padding">
                            <div class="row">
                                <div class="square_box col-md-8 col-xs-8 no_padding pull-left">
                                    <h3 style="color: #fff;">My Profile</h3>
                                </div>
                                <div class="col-md-4 no_padding col-xs-4" style="text-align:right;">
                                    <i class="livicon pull-right" data-name="user" data-l="true" data-c="#fff"
                                        data-hc="#fff" data-s="80" id="livicon-11"
                                        style="width: 80px; height: 80px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 margin_10 animated fadeInUpBig user_btns" role="my_skills"
                style="margin-bottom: 50px;">
                <div class="greybg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-md-12 pull-left nopadmar no_padding">
                            <div class="row no_padding">
                                <div class="square_box col-md-8 col-xs-8 no_padding pull-left">
                                    <h3 style="color: #fff;">My Skills</h3>
                                </div>
                                <div class="col-md-4 no_padding col-xs-4" style="text-align:right;">
                                    <i class="livicon pull-right" data-name="wrench" data-l="true" data-c="#fff"
                                        data-hc="#fff" data-s="80" id="livicon-12"
                                        style="width: 80px; height: 80px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig user_btns" role="submit"
                style="margin-bottom: 50px;">
                <div class="palebluecolorbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-md-12 pull-left nopadmar no_padding">
                            <div class="row no_padding">
                                <div class="square_box col-md-8 col-xs-8 no_padding pull-left">
                                    <h3 style="color: #fff;">Submit Innovation</h3>
                                </div>
                                <div class="col-md-4 no_padding col-xs-4" style="text-align:right;">
                                    <i class="livicon pull-right" data-name="pen" data-l="true" data-c="#fff"
                                        data-hc="#fff" data-s="80" id="livicon-13"
                                        style="width: 80px; height: 80px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig user_btns" role="innovations"
                style="margin-bottom: 50px;">
                <div class="redbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-md-12 pull-left nopadmar no_padding">
                            <div class="row no_padding">
                                <div class="square_box col-md-8 col-xs-8 no_padding pull-left">
                                    <h3 style="color: #fff;">My Innovations</h3>
                                </div>
                                <div class="col-md-4 no_padding col-xs-4" style="text-align:right;">
                                    <i class="livicon pull-right" data-name="eye-open" data-l="true" data-c="#fff"
                                        data-hc="#fff" data-s="80" id="livicon-14"
                                        style="width: 80px; height: 80px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 margin_10 animated fadeInUpBig user_btns" role="company"
                style="margin-bottom: 50px;">
                <div class="goldbg no-radius">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-md-12 pull-left nopadmar no_padding">
                            <div class="row no_padding">
                                <div class="square_box col-md-8 col-xs-8 no_padding pull-left">
                                    <h3 style="color: #fff;">Add Company</h3>
                                </div>
                                <div class="col-md-4 no_padding col-xs-4" style="text-align:right;">
                                    <i class="livicon pull-right" data-name="briefcase" data-l="true" data-c="#fff"
                                        data-hc="#fff" data-s="80" id="livicon-15"
                                        style="width: 80px; height: 80px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 <?php echo $pitchmode ?> col-md-6 col-sm-6 margin_10 animated fadeInUpBig user_btns"
                role="pitch" style="margin-bottom: 50px;" name="<?php echo $Innovation_Id ?>" id="pitch_bholder">
                <div class="no-radius" style="background: #acd;margin-top: 10px;">
                    <div class="panel-body squarebox square_boxs">
                        <div class="col-md-12 pull-left nopadmar no_padding">
                            <div class="row no_padding">
                                <div class="square_box col-md-12 col-xs-12 no_padding pull-left">
                                    <h3 style="color: #fff;">Pitch</h3>
                                </div>
                                <div class="col-md-12 no_padding col-xs-12" style="text-align:right;">
                                    <ul>
                                        <li class="timer_span"><span class="timer_span_li" id="days"></span>days</li>
                                        <li class="timer_span"><span class="timer_span_li" id="hours"></span>Hrs</li>
                                        <li class="timer_span"><span class="timer_span_li" id="minutes"></span>Min</li>
                                        <li class="timer_span"><span class="timer_span_li" id="seconds"></span>Sec</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <div class="copyright footer-text">
        <div class="container">
            <p>Copyright © Huduma WhiteBox,
                <?php echo date('Y') ?>
            </p>
        </div>
    </div>

    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
        data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"
            id="livicon-22" style="width: 18px; height: 18px;"></i>
    </a>

    <!-- JavaScript Section -->
    <script type="text/javascript" src="Huduma_WhiteBox/css/lib.js"></script>
    <script type="text/javascript" src="Huduma_WhiteBox/css/bootstrap.js"></script>
    <script type="text/javascript" src="Huduma_WhiteBox/css/moment.js"></script>
    <script src="Huduma_WhiteBox/css/moment.js" type="text/javascript"></script>
    <script type="text/javascript" src="Huduma_WhiteBox/css/countUp.js"></script>
    <script src="Huduma_WhiteBox/css/morris.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var historypage = "";
            var my_id = $("#user_email").val();

            // Set user email if empty
            if (!my_id) {
                my_id = btoa('<?php echo $user ?>');
                $("#user_email").val(my_id);
            }

            // Load clock data
            $.get("clock.php", function (data) {
                $("#clock_data").html(data);
            });

            // Refresh notifications
            $.post("modules/system/external/control/refresh.php", { my_id: my_id }, function (data) {
                $(".notyholderp").html(data);
            });

            // Handle e-learning buttons visibility
            var get_elerning = $.trim('<?php echo $get_elerning ?>');
            if (get_elerning == "not_shown") {
                $(".elearningrequest").show();
                $("#elearning_request").show();
                $("#elearning_lognew").show();
                $(".elearningleader").hide();
            } else {
                $("#elearning_request").hide();
                $("#elearning_lognew").hide();
                $(".elearningrequest").hide();
            }

            // Notification button click
            $(".notificationbtn").click(function () {
                var my_id = $("#user_email").val();
                var historypage = btoa("notifications");
                $.post("Huduma_WhiteBox/innovator/updatepage.php", { my_id: my_id, historypage: historypage }, function (data) { });
                $.post("modules/system/external/pages/notifications/notifications.php", { my_id: my_id }, function (data) {
                    $("#dashboard_loaders").html("");
                    $("#home_display").html(data).show();
                    $('html, body').animate({ scrollTop: '0px' }, 300);
                    $(".dashboard_holder").hide();
                    $("#content_divesr").html("home_display");
                });
            });

            // User buttons click handler
            $(".user_btns").click(function () {
                var my_role = $(this).attr("role");
                var loader = $("#loader").html();
                $("#dashboard_loaders").html("Loading..." + loader);

                if (my_role == "pitch") {
                    var innovation = $(this).attr("name");
                    var my_id = $("#user_email").val();
                    $.post("modules/system/external/pages/pitch/pitch_page.php", { my_id: my_id, innovation: innovation }, function (data) {
                        $("#dashboard_loaders").html("");
                        $("#home_display").html(data).show();
                        $('html, body').animate({ scrollTop: '0px' }, 300);
                        $(".dashboard_holder").hide();
                        $("#content_divesr").html("home_display");
                    });
                } else if (my_role == "profile") {
                    var historypage = btoa("profile");
                    $.post("Huduma_WhiteBox/innovator/updatepage.php", { my_id: my_id, historypage: historypage }, function (data) { });
                    $.post("Huduma_WhiteBox/innovator/profile.php", { my_id: my_id }, function (data) {
                        $("#dashboard_loaders").html("");
                        $("#home_display").html(data).show();
                        $('html, body').animate({ scrollTop: '0px' }, 300);
                        $(".dashboard_holder").hide();
                        $("#content_divesr").html("home_display");
                    });
                } else if (my_role == "innovations") {
                    var my_id = $("#user_email").val();
                    var historypage = btoa("innovations");
                    $.post("Huduma_WhiteBox/innovator/updatepage.php", { my_id: my_id, historypage: historypage }, function (data) { });
                    $.post("Huduma_WhiteBox/innovator/innovations.php", { my_id: my_id }, function (data) {
                        $("#dashboard_loaders").html("");
                        $("#home_display").html(data).show();
                        $('html, body').animate({ scrollTop: '0px' }, 300);
                        $(".dashboard_holder").hide();
                        $("#content_divesr").html("home_display");
                    });
                } else {
                    var my_id = $("#user_email").val();
                    // Check profile completion before allowing access
                    $.post("Huduma_WhiteBox/innovator/check.php", { my_id: my_id }, function (data) {
                        var dadat = atob(data);
                        console.log("Profile status:", dadat);

                        if (dadat == "active") {
                            var historypage = btoa(my_role);
                            $.post("Huduma_WhiteBox/innovator/updatepage.php", { my_id: my_id, historypage: historypage }, function (data) { });
                            $.post("Huduma_WhiteBox/innovator/" + my_role + ".php", { my_id: my_id }, function (data) {
                                $("#dashboard_loaders").html("");
                                $("#home_display").html(data).show();
                                $('html, body').animate({ scrollTop: '0px' }, 300);
                                $(".dashboard_holder").hide();
                                $("#content_divesr").html("home_display");
                            });
                        } else {
                            var txt;
                            var r = confirm("You have not updated your profile details. Press OK to update or Cancel to stop?");
                            if (r == true) {
                                var historypage = btoa("profile");
                                $.post("Huduma_WhiteBox/innovator/updatepage.php", { my_id: my_id, historypage: historypage }, function (data) { });
                                $.post("Huduma_WhiteBox/innovator/profile.php", { my_id: my_id }, function (data) {
                                    $("#dashboard_loaders").html("");
                                    $("#home_display").html(data).show();
                                    $('html, body').animate({ scrollTop: '0px' }, 300);
                                    $(".dashboard_holder").hide();
                                    $("#content_divesr").html("home_display");
                                });
                            } else {
                                $("#dashboard_loaders").html("");
                                alert("Please complete your profile to access this feature.");
                            }
                        }
                    });
                }
            });

            // Back to dashboard
            $("#back_dashb, #backtoDashboard").click(function () {
                var my_id = $("#user_email").val();
                var historypage = btoa("Dashboard");
                $.post("Huduma_WhiteBox/innovator/updatepage.php", { my_id: my_id, historypage: historypage }, function (data) { });
                $("#home_display").hide().html("");
                $(".dashboard_holder").show();
                $("#content_divesr").html("dashboard_holder");
                $('html, body').animate({ scrollTop: '0px' }, 300);
            });

            // Logout functionality
            $("#logout, #log_touter").click(function () {
                var r = confirm("Do you wish to logout?");
                if (r == true) {
                    var my_id = $("#user_email").val();
                    var historypage = btoa("Dashboard");
                    $.post("Huduma_WhiteBox/innovator/updatepage.php", { my_id: my_id, historypage: historypage }, function (data) { });
                    $.post("login/logout.php", function (data) {
                        var ddata = atob(data);
                        if (ddata == "success") {
                            location.replace("index.php");
                        }
                    });
                }
            });

            // Session check interval
            setInterval(function () {
                check_session();
            }, 10000);

            // Load page history
            var loader = $("#loader").html();
            var history = '<?php echo $new_page ?>';
            var my_id = $("#user_email").val();

            if (history != "" && history != "Dashboard") {
                $("#dashboard_loaders").html("Retrieving pages..." + loader);
                if (history == "notifications") {
                    $.post("modules/system/external/pages/notifications/notifications.php", { my_id: my_id }, function (data) {
                        $("#dashboard_loaders").html("");
                        $("#home_display").html(data).show();
                        $('html, body').animate({ scrollTop: '0px' }, 300);
                        $(".dashboard_holder").hide();
                        $("#content_divesr").html("home_display");
                    });
                } else {
                    $.post("Huduma_WhiteBox/innovator/" + history + ".php", { my_id: my_id }, function (data) {
                        $("#dashboard_loaders").html("");
                        $("#home_display").html(data).show();
                        $('html, body').animate({ scrollTop: '0px' }, 300);
                        $(".dashboard_holder").hide();
                        $("#content_divesr").html("home_display");
                    });
                }
            }

            // Pitch timer
            var date_start = '<?php echo $fulldate ?>';
            const second = 1000, minute = second * 60, hour = minute * 60, hhour = minute * 30, day = hour * 24;
            let countDown = new Date(date_start).getTime();
            let x = setInterval(function () {
                let now = new Date().getTime();
                let distance = countDown - now;

                if (distance > 0) {
                    document.getElementById('days').innerText = Math.floor(distance / (day));
                    document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour));
                    document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute));
                    document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
                } else {
                    distance = now - countDown;
                    if (distance > hhour) {
                        document.getElementById('days').innerText = 0;
                        document.getElementById('hours').innerText = 0;
                        document.getElementById('minutes').innerText = 0;
                        document.getElementById('seconds').innerText = 0;
                        $("#pitch_bholder").hide();
                    } else {
                        document.getElementById('days').innerText = Math.floor(distance / (day));
                        document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour));
                        document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute));
                        document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
                    }
                }
            }, second);

            // E-learning button handlers
            $(".elearningrequest, #elearning_log").click(function () {
                var loader = $("#loader").html();
                $("#dashboard_loaders").html("Sending request " + loader);
                var model = $("#user_email").val();
                $.post("mydashboard/e_learningaccess.php", { model: model }, function (data) {
                    if (atob($.trim(data)) == "success") {
                        $.post("mydashboard/e_learning.php", { model: model }, function (data) {
                            $("#landing_page").show().html(data);
                        });
                    } else {
                        $("#dashboard_loaders").html(data);
                    }
                });
            });
        });

        // Session check function
        function check_session() {
            $.ajax({
                url: "mydashboard/session.php",
                method: "POST",
                success: function (data) {
                    if (data == '1') {
                        window.location.href = "index.php";
                    }
                }
            });
            var my_id = $("#user_email").val();
            $.post("modules/system/external/control/refresh.php", { my_id: my_id }, function (data) {
                $(".notyholderp").html(data);
            });
        }
    </script>

</body>

</html>