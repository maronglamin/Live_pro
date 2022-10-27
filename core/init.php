<?php
// require the configuration setting where you define the contants 
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/config.php';

// connect to the database
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB);
if (mysqli_connect_errno()) {
    echo "fail to connect with the error: " . mysqli_connect_error();
    die();
}

session_start();


if (isset($_SESSION['ADMIN_USER_SESSIONS'])) {

    $admin_id = $_SESSION['ADMIN_USER_SESSIONS'];
    $query = $db->query("SELECT * FROM `users` WHERE `user_id` = '{$admin_id}'");
    $user_data = mysqli_fetch_assoc($query);
    $fn = explode(' ', $user_data['full_name']);
    $user_data['first'] = $fn[0];

    # the currently signed in user
    $auth_user = $user_data['user_id'];
    $auth_user_type = $user_data['user_type'];
    $auth_user_name = $user_data['user_name'];
    $auth_user_role = $user_data['user_role'];
    $auth_user_fullname = $user_data['full_name'];
    $auth_password_change = $user_data['change_password'];
    
} elseif (isset($_SESSION['CLIENT_USER_SESSIONS'])) {

    $user_id = $_SESSION['CLIENT_USER_SESSIONS'];
    $query = $db->query("SELECT * FROM `users` WHERE `user_id` = '{$user_id}'");
    $user_data = mysqli_fetch_assoc($query);
    $fn = explode(' ', $user_data['full_name']);
    $user_data['fname'] = $fn[0];

    # the currently signed in user
    $auth_user = $user_data['user_id'];
    $auth_user_type = $user_data['user_type'];
    $auth_user_name = $user_data['user_name'];
    $auth_user_role = $user_data['user_role'];
    $auth_user_fullname = $user_data['full_name'];
    $auth_password_change = $user_data['change_password'];
}

include(ROOT . DS . "core" . DS . "head.php");
require_once(ROOT . DS . "core" . DS . "func.php");

// session messages
if (isset($_SESSION['success_mesg'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>' . ' ' . $_SESSION['success_mesg'] . '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    unset($_SESSION['success_mesg']);
}

if (isset($_SESSION['error_mesg'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>' . ' ' . $_SESSION['error_mesg'] . '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    unset($_SESSION['error_mesg']);
}

// $open = $db->query("SELECT * FROM `start_enrollment` WHERE `opened` != '1'");
// $open_record = mysqli_fetch_assoc($open);
