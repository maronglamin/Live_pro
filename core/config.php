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


define('DEFAULT_USER_ICON', PROOT . "app/photos/user-default.png");
define('GROUP_USER_ICON', PROOT . "app/photos/group-users.png");


define('CLIENT_DASHBOARD_URL', PROOT . "app/users/client/dashboard.php");
define('CLIENT_ADMISSION_URL', PROOT . "app/users/client/admission/enroll.php");
define('CLIENT_CREATE_CLASS_URL', PROOT . "app/users/client/admission/create_class.php");
define('CLIENT_CREATE_SUBJECT_URL', PROOT . "app/users/client/admission/create_subject.php");
define('CLIENT_SUBJECT_URL', PROOT . "app/users/client/admission/steach.php");
define('ADMISSION_OFFICER_DASHBOAD', 'admission/admission_dashboard.php');
define('ADMISSION_PRINCIPAL_DASHBOAD', 'admission/approve_admission.php');

define('ENROLLED_STUDENTS', PROOT. 'app/users/client/admission/enrolled.php');
define('ADMIN_ENROLLED_STUDENTS', PROOT. 'app/users/admin/admission/enrolled.php');
define('ENROLL_STATUS', PROOT. 'app/users/client/admission/enroll-status.php');
define('ENROLL_YEAR', PROOT. 'app/users/admin/admission/academic-year.php');
define('ADMISSION_LETTER', PROOT. 'app/users/admin/admission/letter.php');

define('TEACHER_DASHBOAD', 'teacher/dashboard.php');

define('CLASS_PROPERTY', PROOT. 'app/users/admin/school/class_property.php');
define('SUBJECT_URL', PROOT. 'app/users/admin/school/subjects.php');
define('ASSIGN_SUBJ_URL', PROOT. 'app/users/admin/school/steach.php');


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
