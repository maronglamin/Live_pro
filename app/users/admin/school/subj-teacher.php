<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
if ($user_data['user_role'] != ADMIN_USER) {
    login_error_redirect(PROOT . "index.php", "Admin Pages");
}
include(ROOT . DS . "app" . DS . "components" . DS . "admin_nav.php");
$errors = [];

$username = ((isset($_POST['username'])) ? sanitize($_POST['username']) : '');
$user_name = ((isset($_POST['user-name'])) ? sanitize($_POST['user-name']) : '');
$primary_code = ((isset($_POST['primary-code'])) ? sanitize($_POST['primary-code']) : '');
$sec_code_one = ((isset($_POST['sec-code1'])) ? sanitize($_POST['sec-code1']) : '');
$sec_code_two = ((isset($_POST['sec-code2'])) ? sanitize($_POST['sec-code2']) : '');
$sec_code_three = ((isset($_POST['sec-code3'])) ? sanitize($_POST['sec-code3']) : '');



?>

<br><br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary">Assign Subjects for school teacher</h2>
                <p>
                    School teacher that teaches a perticular subject should be captured in this modeling.
                </p>
            </div>
        </div>
        <section>
            <div class="container">
                <div class="card">
                    <h2 class="text-secondary text-center">Subject to a teacher</h2>
                    <div class="mt-2 p-3">
                        <?php
                            if (isset($_POST['save-username'])) {
                                $required = ['username'];
                                    foreach ($required as $fields) {
                                        if ($_POST[$fields] == EMPTY_VALUE) {
                                            $errors[] .= 'You must fill out all fields.';
                                            break;
                                        }
                                    }
                                    if (!empty($errors)) {
                                        echo display_errors($errors);
                                    } else {
                                        $user_qty = $db->query("SELECT * FROM `users` WHERE `user_name` = '{$username}'");
                                    }
                            }
                        ?>
                        <form action="#" method="post">
                            <div class="mt-2 col-md-4">
                                <input type="text" name="username" id="username" placeholder="Enter teacher's USERNAME" class="form-control form-control-sm">
                            </div>
                            <div class="mt-2">
                            <button type="submit" name="save-username" class="btn btn-sm btn-outline-dark">Fetch</button>
                            </div>
                        </form>

                        <?php 
                            if ($username == '') {
                            $errors[] .= 'You must select a class.';
                            } elseif (isset($_POST['save-username'])) {
                            while ($user = mysqli_fetch_assoc($user_qty)) { ?>

                            <form action="subj-teacher.php?check=1" method="post">
                            <?php 
                            if (isset($_GET['check'])) {
                                if(isset($_POST['assigned'])) {
                                    dnd($_POST);
                                    $required = ['primary-code'];
                                    foreach ($required as $fields) {
                                        if ($_POST[$fields] == EMPTY_VALUE) {
                                            $errors[] .= 'You must select a class.';
                                            break;
                                        }
                                    }
                                    if (!empty($errors)) {
                                        echo display_errors($errors);
                                    } else {
                                        $db->query("INSERT INTO `sole_subject_user`(`user_name`, `subj_primary`, `subj_sec_1`, `subj_sec_2`, `subj_sec_3`,`inputted_by`) VALUES ('{$user_name}','{$primary_code}', '{$sec_code_one}', '{$sec_code_two}','{$sec_code_three}','{$auth_user_name}')");
                                        redirect("subj-teacher.php");
                                    }
                                }
                            }
                            ?>
                            <h3 class="text-secondary"><?=$user['full_name']?></h3>
                                <div class="row align-items-start">
                                    <div class="col">
                                        <div class="mt-2">
                                            <input type="text" name="full-name" disabled value="<?=$user['full_name']?>" id="full-name" class="form-control form-control-sm">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="user-name" disabled value="<?=$user['user_name']?>" id="user-name" class="form-control form-control-sm">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="join-date" disabled value="Joinned on the <?=day_month($user['join_date'])?>" id="join-date" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h3 class="text-center text-secondary">Primary subject code</h3>
                                        <div class="mt-2">
                                            <input type="text" name="primary-code" id="primary-code" placeholder="Enter primary/major subject code" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h3 class="text-center text-secondary">Secondary subject code</h3>
                                        <div class="mt-2">
                                            <input type="text" name="sec-code1" id="sec-code1" placeholder="Enter Secondary/minor subject code (optional)" class="form-control form-control-sm">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="sec-code2" id="sec-code2" placeholder="Enter Secondary/minor subject code (optional)" class="form-control form-control-sm">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="sec-code3" id="sec-code3" placeholder="Enter Secondary/minor subject code (optional)" class="form-control form-control-sm">
                                        </div>
                                        <div class="mt-2 text-end">
                                            <button type="submit" id="assigned" name="assigned" class="btn btn-outline-dark">Assign</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php }}?>  
                    </div>
                </div>
            </div>
    </div>
        </section>
</div>