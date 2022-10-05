<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/schoolapp/core/init.php';

if (isset($_SESSION['ADMIN_USER_SESSIONS'])) {
    unset($_SESSION['ADMIN_USER_SESSIONS']);
} else if (isset($_SESSION['CLIENT_USER_SESSIONS'])) {
    unset($_SESSION['CLIENT_USER_SESSIONS']);
}
$_SESSION['success_mesg'] = 'You are now logg out, have a nice day!';
redirect(PROOT . 'index.php');
