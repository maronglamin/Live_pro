<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/schoolApp/core/connection/init.php';

$new_password = ((isset($_POST['new'])) ? sanitize($_POST['new']) : '');
$confirm_password = ((isset($_POST['confirm'])) ? sanitize($_POST['confirm']) : '');
$errors = [];

?>

<br><br><br><br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-md-4 col-md-offset-4 well">
            <h3 class="text-center">Change Password!</h3>
            <hr>
            <?php
            if ($_POST) {

                if (strlen($new_password) < 6) {
                    $errors[] = 'The password must be at least 6 characters.';
                }
                if ($new_password != $confirm_password) {
                    $errors[] .= "Your new password and confirmation does not match";
                }
                if (!empty($errors)) {
                    echo display_errors($errors);
                } else {
                    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                    $user_id = $user_data['user_id'];
                    $db->query("UPDATE `users` SET `password` = '{$hashed}', `change_password` = FINE_PASSWORD WHERE `user_id` = '{$user_id}'");
                    $_SESSION['success_mesg'] = 'Password changed successfully.';

                    if ($user_data['user_role'] == ADMIN_USER) {
                        unset($_SESSION['ADMIN_USER_SESSIONS']);
                    } else if ($user_data['user_role'] == TEACHER_USER) {
                        unset($_SESSION['TEACHER_USER_SESSIONS']);
                    } else {
                        unset($_SESSION['STUDENT_USER_SESSIONS']);
                    }
                    redirect(PROOT . 'index.php');
                }
            } ?>

            <form action="#" method="post">
                <div class="form-group">
                    <label for="new">New Password</label>
                    <input type="password" name="new" id="new" class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirm">Confirm Password</label>
                    <input type="password" name="confirm" id="confirm" class="form-control">
                </div>
                <input type="submit" value="Change" class="btn btn-default">
            </form>
        </div>
    </div>
</div>