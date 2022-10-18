<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Classes Management");
}
if ($user_data['user_role'] != ADMIN_USER) {
    login_error_redirect(PROOT . "index.php", "Admin Pages");
}
include(ROOT . DS . "app" . DS . "components" . DS . "admin_nav.php");
$errors = [];

$teacher = ((isset($_POST['username'])) ? sanitize($_POST['username']) : '');
$primary = ((isset($_POST['primary'])) ? sanitize($_POST['primary']) : '');
$sec = ((isset($_POST['sec1'])) ? sanitize($_POST['sec1']) : '');
$sec2 = ((isset($_POST['sec2'])) ? sanitize($_POST['sec2']) : '');
$sec3 = ((isset($_POST['sec3'])) ? sanitize($_POST['sec3']) : '');
$sec4 = ((isset($_POST['sec4'])) ? sanitize($_POST['sec4']) : '');

$per_page_record = RECORD_TO_SHOW;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $per_page_record;
$subj_lists = $db->query("SELECT * FROM `sole_subject_user` ORDER BY `record_id` DESC LIMIT $start_from, $per_page_record");
?>

<br><br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary">Assign Subjects</h2>
                <p>
                    Create classes with unique identifiers. Classes will be in assigning enrolled students to it. <br>
                    However, a teacher should be asigned to over sight and control the class created.
                </p>
            </div>
        </div>
        <section>
            <div class="col">
                <div class="container">
                    <div class="card mt-2 p-3">
                        <h2 class="text-secondary text-center">Subject Teachers</h2>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="text-center text-secondary">Subject codes</h4>
                                    </div>
                                    <div class="mt-4">
                                    <?php 
                                        if (isset($_POST['asign'])) {
                                                $required = ['primary', 'username'];
                                                foreach ($required as $fields) {
                                                    if ($_POST[$fields] == EMPTY_VALUE) {
                                                        $errors[] .= 'One of the required field is not filled.';
                                                        break;
                                                    }
                                                }
                                                $pri = $db->query("SELECT * FROM `subjects` WHERE `subj_code` = '{$primary}'");
                                                $count_pri = mysqli_num_rows($pri);
                                                $user = $db->query("SELECT * FROM `users` WHERE `user_name` = '{$teacher}'");
                                                $count_user= mysqli_num_rows($user);
                                                $check = mysqli_fetch_assoc($user);
                                                
                                                if ($count_pri == 0) {
                                                    $errors[] .= "The Primary subject code does not exists in records";
                                                } elseif ($count_user == 0) {
                                                    $errors[] .= "The username does not exists in records";
                                                }
                                                if ($check != NULL && $check['user_role'] != TEACHER_USER) {
                                                    $errors[] .= "The username is not a teacher and can not be a subject";
                                                }
                                                if (!empty($errors)) {
                                                    echo display_errors($errors);
                                                } else {
                                                    $db->query("INSERT INTO `sole_subject_user`(`user_name`, `subj_primary`, `subj_sec_1`, `subj_sec_2`, `subj_sec_3`,`subj_sec_4`,`inputted_by`) VALUES ('{$teacher}','{$primary}', '{$sec}', '{$sec2}','{$sec3}','{$sec4}','{$auth_user_name}')");
                                                    redirect("steach.php");
                                                }
                                            }
                                        ?>
                                    <form action="#" method="post" class="row p-2">
                                        <div class="mt-2">
                                            <input type="text" name="username" id="username" class="form-control form-control-sm" placeholder="Teacher's username">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="primary" id="primary" class="form-control form-control-sm" placeholder="Enter primary subject code">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="sec1" id="primary" class="form-control form-control-sm" placeholder="Enter secondary subject code (optional)">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="sec2" id="primary" class="form-control form-control-sm" placeholder="Enter secondary subject 2 code (optional)">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="sec3" id="primary" class="form-control form-control-sm" placeholder="Enter secondary subject 3 code (optional)">
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" name="sec4" id="primary" class="form-control form-control-sm" placeholder="Enter secondary subject 4 code (optional)">
                                        </div>
                                        <div class="d-grid gap-2 p-2">
                                            <button name="asign" class="btn btn-outline-dark" type="submit">Assign</button>
                                        </div>
                                    </form>
                                        </div>
                                </div>
                         </div>
                            <div class="col-md-8">
                                <table class="table table-striped table-sm table-hover mt-2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Teacher</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Primary Subject</th>
                                            <th scope="col">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($subj_list = mysqli_fetch_assoc($subj_lists)):
                                            $teacher = $subj_list['user_name'];
                                            $sub_lists = $db->query("SELECT `u`.`full_name`, `s`.`subj_grade_level`, `s`.`subj_name` FROM `sole_subject_user` `su`, `users` `u`, `subjects` `S` WHERE `s`.`subj_code` = `su`.`subj_primary` AND `su`.`user_name` = `u`.`user_name` AND `su`.`user_name` ='{$teacher}'");
                                            ?>
                                            <?php while($sub_list = mysqli_fetch_assoc($sub_lists)):?>
                                            <tr>
                                                <th scope="row"><?=$sub_list['full_name']?></th>
                                                <td><?=$subj_list['subj_primary']?></td>
                                                <td><?=$sub_list['subj_name']?></td>
                                                <td>Grade <?=$sub_list['subj_grade_level']?></td>
                                            </tr>
                                            <?php endwhile;?>
                                        <?php endwhile;?>
                                    </tbody>
                                </table>
                                <?php
                                    $enroll_stud_query = $db->query("SELECT COUNT(*) FROM `sole_subject_user` ORDER BY `record_id` DESC");
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
                                                <a class="page-link" href="steach.php?page=<?= ($page - 1) ?>" tabindex="-1">Previous</a>
                                            <?php endif; ?>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <?php if ($i == $page) : ?>
                                                <li class="page-item"><a class="page-link" href="steach.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php else : ?>
                                                <li class="page-item"><a class="page-link" href="steach.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <?php if ($page < $total_pages) : ?>
                                                <a class="page-link" href="steach.php?page=<?= ($page + 1) ?>">Next</a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </nav>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
