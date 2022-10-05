<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
$errors = [];

if (isset($_GET['change'])) {
    $user_id = (int)sanitize($_GET['change']);

    $new_password = ((isset($_POST['new'])) ? sanitize($_POST['new']) : '');
    $confirm_password = ((isset($_POST['confirm'])) ? sanitize($_POST['confirm']) : '');

?>
    <div class="container-fluid">
        <div class="login-container">
            <div class="card p-4">
                <div class="row">
                    <h3 class="text-center text-secondary">Set Password</h3>
                    <form action="change_password.php?change=<?= $user_id ?>" method="post">
                        <?php
                        if ($_POST) {
                            $required = array('new', 'confirm');
                            foreach ($required as $fields) {
                                if ($_POST[$fields] == '') {
                                    $errors[] = 'Fields can\'t be empty.';
                                    break;
                                }
                            }
                            if (strlen($new_password) < 6) {
                                $errors[] = 'Password must be at least 6 characters.';
                            }
                            if ($new_password != $confirm_password) {
                                $errors[] .= "Your new password and confirmation does not match";
                            }
                            if (!empty($errors)) {
                                echo display_errors($errors);
                            } else {
                                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                                $db->query("UPDATE `users` SET `password` = '{$hashed}', `change_password` = '1' WHERE `user_id` = '{$user_id}'");
                                unset($_SESSION['ADMIN_USER_SESSIONS']);
                                redirect(PROOT . 'index.php');
                            }
                        } ?>
                        <div class="mt-5">
                            <input type="password" name="new" id="new" placeholder="New Password" class="form-control form-control-sm">
                        </div>
                        <div class="mt-2">
                            <input type="password" name="confirm" id="confirm" placeholder="Confirm Password" class="form-control form-control-sm mb-3">
                        </div>
                        <input type="submit" value="Change" class="btn btn-outline-dark mb-2">
                        <a href="<?= PROOT ?>app/users/admin/dashboard.php" class="btn btn-danger mb-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }
?>