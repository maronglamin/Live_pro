<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
if ($user_data['user_role'] != ADMIN_USER) {
    login_redirect(PROOT . "index.php");
}
include(ROOT . DS . "app" . DS . "components" . DS . "admin_nav.php");
$errors = [];
$reg_name = ((isset($_POST['name'])) ? sanitize($_POST['name']) : '');
$reg_user_name = ((isset($_POST['user_name'])) ? sanitize($_POST['user_name']) : '');
$user_role = ((isset($_POST['user-role'])) ? sanitize($_POST['user-role']) : '');
$reg_password = 'A5p1@!bl..';

$per_page_record = RECORD_TO_SHOW;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $per_page_record;
$user_sql = $db->query("SELECT * FROM `users` WHERE `user_id` != '{$auth_user}' AND `user_id` != 'MM2200' ORDER BY `user_role` ASC LIMIT $start_from, $per_page_record");

if (isset($_GET['dis'])) {
    $id = (int)sanitize($_GET['dis']);

    $db->query("UPDATE `users` SET `permission` = '0' WHERE `user_id` = '{$id}'");
    redirect("users.php");
}

if (isset($_GET['enb'])) {
    $id = (int)sanitize($_GET['enb']);

    $db->query("UPDATE `users` SET `permission` = '1' WHERE `user_id` = '{$id}'");
    redirect("users.php");
}

if (isset($_GET['del'])) {
    $id = (int)sanitize($_GET['del']);

    $db->query("UPDATE `users` SET `deleted` = '1' WHERE `user_id` = '{$id}'");
    redirect("users.php");
}
if (isset($_GET['act'])) {
    $id = (int)sanitize($_GET['act']);

    $db->query("UPDATE `users` SET `deleted` = '0' WHERE `user_id` = '{$id}'");
    redirect("users.php");
}

?>
<br>
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-primary">System Users</h2>
                <p>View all users of the system i.e the teaching staff, principal and others.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card p-3">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-center text-secondary">Staff in the school system</h3>
                    <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Full Name</th>
                                <th scope="col">User name</th>
                                <th scope="col">User Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($users = mysqli_fetch_assoc($user_sql)) : ?>
                                <tr>
                                    <td scope="row"><?= $users['full_name'] ?></td>
                                    <td scope="row"><?= $users['user_name'] ?></td>
                                    <td scope="row">
                                        <?php if ($users['user_role'] == ADMIN_USER) {
                                            echo "Administrator";
                                        } elseif ($users['user_role'] == ADMISSION_USER) {
                                            echo "Admission Officer";
                                        } elseif ($users['user_role'] == PRINCIPAL_USER) {
                                            echo "The Principal";
                                        } elseif ($users['user_role'] == TEACHER_USER) {
                                            echo "Teacher";
                                        } elseif ($users['user_role'] == FINANCE_USER) {
                                            echo "Financial Accountant";
                                        } else {
                                            echo "Unauthorized user";
                                        } ?>
                                    </td>
                                    <td scope="row">
                                        <?php if ($users['permission'] == '1') : ?>
                                            <a href="users.php?dis=<?= $users['user_id'] ?>" class="btn btn-sm btn-info">Disable</a>
                                        <?php else : ?>
                                            <a href="users.php?enb=<?= $users['user_id'] ?>" class="btn btn-sm btn-info">Enable</a>
                                        <?php endif; ?>
                                        <?php if ($users['deleted'] == '1') : ?>
                                            <a href="users.php?act=<?= $users['user_id'] ?>" class="btn btn-sm btn-warning">activate</a>
                                        <?php else : ?>
                                            <a href="users.php?del=<?= $users['user_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php
                    $enroll_stud_query = $db->query("SELECT COUNT(*) FROM `users` ORDER BY `user_id` DESC");
                    $row = mysqli_fetch_row($enroll_stud_query);
                    $total_records = $row[0];

                    $total_pages = ceil($total_records / $per_page_record);
                    $pagLink = "";

                    ?>
                    <p class="text-secondary text-center">Showing <?= $page ?> of <?= $total_pages ?>. Total Recorded <?= $total_records ?></p>
                    <nav aria-label="Page navigation example p-2">
                        <ul class="pagination justify-content-end">
                            <li class="page-item">
                                <?php if ($page >= 2) : ?>
                                    <a class="page-link" href="users.php?page=<?= ($page - 1) ?>" tabindex="-1">Previous</a>
                                <?php endif; ?>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <?php if ($i == $page) : ?>
                                    <li class="page-item"><a class="page-link" href="users.php?page=<?= $i ?>"><?= $i ?></a></li>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link" href="users.php?page=<?= $i ?>"><?= $i ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item">
                                <?php if ($page < $total_pages) : ?>
                                    <a class="page-link" href="users.php?page=<?= ($page + 1) ?>">Next</a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-4">
                    <h3 class="text-center text-secondary">Register Staff</h3>
                    <form action="#" method="post">
                        <?php
                        if ($_POST) {

                            $userQuery = $db->query("SELECT * FROM users WHERE `user_name` = '{$reg_user_name}'");
                            $userCount = mysqli_num_rows($userQuery);

                            if ($userCount != 0) {
                                $errors[] = 'That user name exist in our database';
                            }

                            $required = array('name', 'user_name');
                            foreach ($required as $fields) {
                                if ($_POST[$fields] == '') {
                                    $errors[] = 'You must fill all fields';
                                    break;
                                }
                            }
                            if (!empty($errors)) {
                                echo display_errors($errors);
                            } else {
                                // add user
                                $hashed = password_hash($reg_password, PASSWORD_DEFAULT);
                                $db->query("INSERT INTO users (`full_name`, `user_name`, `password`, `user_role`) VALUES('$reg_name', '$reg_user_name', '$hashed', '{$user_role}')");
                                echo spinner();
                                redirect(PROOT . 'app/users/admin/users.php');
                            }
                        } ?>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" placeholder="Full name" class="form-control form-control-sm">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="user_name" id="user_name" placeholder="username" class="form-control form-control-sm">
                        </div>
                        <div class="mt-2">
                            <input type="password" name="new" id="new" placeholder="deafault password is A5p1@!bl.." disabled class="form-control form-control-sm">
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
                        <button type="reset" class="btn btn-danger">Reset</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>