<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
$user_name = ((isset($_POST['user_name'])) ? sanitize($_POST['user_name']) : '');
$password = ((isset($_POST['password'])) ? sanitize($_POST['password']) : '');

$user_name = trim($user_name);
?>


<div class="container-fluid">
    <div class="row">
        <div class="login-container card">
            <div class="p-3">
                <h3 class="text-center text-warning">Yalding School</h3>
                <p class="text-secondary text-center">Sign in</p>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <?php
                    if ($_POST) {
                       
                        //check if the email exist in the database
                        $query = $db->query("SELECT * FROM `users` WHERE `user_name` = '{$user_name}'");
                        $user = mysqli_fetch_assoc($query);
                        $userCount = mysqli_num_rows($query);

                        if ($userCount < 1) {
                            $errors[] = 'That record doesn\' t exist in our record';
                        }
                        if ($user != NULL && !password_verify($password, $user['password'])) {
                            $errors[] = 'The password does not match our records. please try again.';
                        }

                        // check if user is deleted 
                        $delquery = $db->query("SELECT * FROM `users` WHERE `user_name` = '{$user_name}' AND `deleted` != 0");
                        $counter = mysqli_num_rows($delquery);


                        if ($counter == 1) {
                            $errors[] = 'Access denied to the system, PLEASE contact us';
                        }

                        $permitQuery = $db->query("SELECT * FROM `users` WHERE `user_name` = '{$user_name}' AND `permission` = 0");
                        $counterPermission = mysqli_num_rows($permitQuery);

                        // check for permission  
                        if ($counterPermission == 1) {
                            $errors[] = 'You are disable to login to the system. Please wait until you are unlock';
                        }

                        // display error if it occurs 
                        if (!empty($errors)) {
                            echo display_errors($errors);
                        } else {
                            //log user in
                            $query = $db->query("SELECT * FROM `users` WHERE `user_name` = '{$user_name}'");
                            $user_role = mysqli_fetch_assoc($query);

                            if ($user_role['user_type'] == ADMIN_USER) {
                                if ($user_role['change_password'] == CHANGE_PASSWORD) {
                                    redirect(PROOT . "app" . DS . "components" . DS . "change_password.php?change=" . $user_role['user_id']);
                                }
                                $user_id = $user['user_id'];
                                login_admin($user_id);
                            } else if ($user_role['user_type'] == CLIENT_USER) {
                                if ($user_role['change_password'] == CHANGE_PASSWORD) {
                                    redirect(PROOT . "app" . DS . "components" . DS . "change_password.php?change=" . $user_role['user_id']);
                                }
                                $user_id = $user['user_id'];
                                login_client($user_id);
                            } else {
                                echo '<div class="btn btn-danger btn-block">We have no controller over this Action.</div>';
                            }
                        }
                    }
                    ?>
                    <form action="#" method="post" class="mt-3">
                        <div class="form-group mt-2">
                            <input type="text" name="user_name" id="user_name" required placeholder="username" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <input type="password" name="password" id="password" required placeholder="Password" class="form-control">
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary mb-4 mt-2">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>