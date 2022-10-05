<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Adding Admin users");
}
include(ROOT . DS . "app" . DS . "components" . DS . "admin_nav.php");

$reg_name = ((isset($_POST['name'])) ? sanitize($_POST['name']) : '');
$reg_user_name = ((isset($_POST['user_name'])) ? sanitize($_POST['user_name']) : '');
$reg_password = 'A5p1@!bl..';

?>


<div class="container-fluid">
    <div class="row">
        <div class="login-container card p-2">
            <h3 class="text-center text-secondary">Register users</h3>
            <?php

            if ($_POST) {

                $emailQuery = $db->query("SELECT * FROM users WHERE email = '{$reg_email}' ");
                $emailCount = mysqli_num_rows($emailQuery);

                $userQuery = $db->query("SELECT * FROM users WHERE `user_name` = '{$reg_user_name}'");
                $userCount = mysqli_num_rows($userQuery);

                if ($emailCount != 0) {
                    $errors[] = 'That email exist in our database';
                }

                if ($userCount != 0) {
                    $errors[] = 'That user name exist in our database';
                }

                $required = array('name', 'user_name');
                foreach ($required as $fields) {
                    if ($_POST[$fields] == '') {
                        $errors[] = 'You must fill out all fields marked with star(*).';
                        break;
                    }
                }
                if (!empty($errors)) {
                    echo display_errors($errors);
                } else {
                    // add user
                    $hashed = password_hash($reg_password, PASSWORD_DEFAULT);
                    $db->query("INSERT INTO users (`full_name`, `user_name`, `password`, `user_role`) VALUES('$reg_name', '$reg_user_name', '$hashed', '1')");
                    redirect(PROOT . 'app/users/admin/users.php');
                }
            }
            ?>
            <form action="#" method="post">
                <div class="mt-2">
                    <input type="text" name="name" id="name" placeholder="Full name" class="form-control">
                </div>
                <div class="mt-2">
                    <input type="text" name="user_name" id="user_name" placeholder="username" class="form-control">
                </div>
                <div class="mt-2">
                    <input type="password" name="new" id="new" placeholder="deafault password is A5p1@!bl.." disabled class="form-control">
                </div>
                <div class="mt-2 mb-2">
                    <select name="user-role" id="user-role" class="form-control form-control-sm">
                        <option value="">Select user role to the system</option>
                        <option value="2">Admission Officer</option>
                        <option value="3">Pricinpal</option>
                        <option value="4">Financial Officer</option>
                        <option value="5">Staff Teacher</option>
                    </select>
                </div>
                <input type="submit" value="Add" class="btn btn-outline-dark">
                <a href="<?= PROOT ?>app/users/admin/dashboard.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>