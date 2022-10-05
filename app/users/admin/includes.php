<?php
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
if ($user_data['user_role'] != ADMIN_USER) {
    login_redirect();
}
include(ROOT . DS . "app" . DS . "components" . DS . "admin_nav.php");
$errors = [];
