<?php
// define some constants to use any where in your application.

define('PROOT', "/schoolapp/");
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));

define('DB_USER', "root");
define('DB_PASSWORD', "");
define('DB', "schoolapp");
define('DB_HOST', "127.0.0.1");

define('LOG_OUT_URL', PROOT . "app/components/logout.php");
define('ADD_ADMIN_URL', PROOT . "app/components/add_admin.php");
define('CREATE_USER_URL', PROOT . "app/users/admin/users.php");
define('ADMISSION_URL', PROOT . "app/users/admin/admission/enroll.php");
define('ADMIN_DASHBOARD_URL', PROOT . "app/users/admin/dashboard.php");


define('CLIENT_DASHBOARD_URL', PROOT . "app/users/client/dashboard.php");
define('CLIENT_ADMISSION_URL', PROOT . "app/users/client/admission/enroll.php");



define('ADMIN_USER', "1");
define('CLIENT_USER', "2");

define('ADMISSION_USER', "2");
define('PRINCIPAL_USER', "3");
define('FINANCE_USER', "4");
define('TEACHER_USER', "5");


define('CHANGE_PASSWORD', "0");
define('FINE_PASSWORD', "1");

define('EMPTY_VALUE', "");
define('IS_DONE', "1");

define('RECORD_TO_SHOW', "7");
