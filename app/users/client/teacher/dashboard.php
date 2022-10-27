<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
if ($user_data['user_role'] != TEACHER_USER) {
    login_error_redirect(PROOT . "index.php", "Admin Pages");
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");
$errors = [];

$subjects = $db->query("SELECT * FROM `sole_subject_user` WHERE `user_name` = '{$auth_user_name}'");
$subject  = mysqli_fetch_assoc($subjects);

?>

<div class="container-fluid mt-3">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary"><?=$auth_user_fullname?></h2>
                <p>Quickly track your records on students for the subjects your teach.</p>
            </div>
        </div>
        <section>
            <div class="container">
                <div class="card p-3">
                    <h3 class="text-secondary text-center">Management Students on subject you teacher</h3>
                    <div class="row">
                        <?php if ($subject['subj_primary'] != ''):?>
                            <div class="col-md-4">
                                <div class="card mt-3" style="width: 22rem;">
                                <img src="<?=GROUP_USER_ICON?>" class="card-img-top" style="width: 250px;height: 172px;margin: 10px auto 0 auto;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Code: <?=$subject['subj_primary']?></h5>
                                    <p class="card-text">The Subject code is associated only to one grade. Get into the grade list of students</p>
                                    <a href="teacher/list.php?code=<?=$subject['subj_primary']?>" class="btn btn-outline-dark">Go to List</a>
                                    <a href="teacher/entry.php?code=<?=$subject['subj_primary']?>" class="btn btn-outline-dark">Grades</a>
                                </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if ($subject['subj_sec_1'] != ''):?>
                            <div class="col-md-4">
                                <div class="card mt-3" style="width: 22rem;">
                                <img src="<?=GROUP_USER_ICON?>" class="card-img-top" style="width: 250px;height: 172px;margin: 10px auto 0 auto;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Code: <?=$subject['subj_sec_1']?></h5>
                                    <p class="card-text">The Subject code is associated only to one grade. Get into the grade list of students</p>
                                    <a href="teacher/list.php?code=<?=$subject['subj_sec_1']?>" class="btn btn-outline-dark">Go to List</a>
                                    <a href="teacher/entry.php?code=<?=$subject['subj_sec_1']?>" class="btn btn-outline-dark">Grades</a>
                                </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if ($subject['subj_sec_2'] != ''):?>
                            <div class="col-md-4">
                                <div class="card mt-3" style="width: 22rem;">
                                <img src="<?=GROUP_USER_ICON?>" class="card-img-top" style="width: 250px;height: 172px;margin: 10px auto 0 auto;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Code: <?=$subject['subj_sec_2']?></h5>
                                    <p class="card-text">The Subject code is associated only to one grade. Get into the grade list of students</p>
                                    <a href="teacher/list.php?code=<?=$subject['subj_sec_2']?>" class="btn btn-outline-dark">Go to List</a>
                                    <a href="teacher/entry.php?code=<?=$subject['subj_sec_2']?>" class="btn btn-outline-dark">Grades</a>
                                </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if ($subject['subj_sec_3'] != ''):?>
                            <div class="col-md-4">
                                <div class="card mt-3" style="width: 22rem;">
                                <img src="<?=GROUP_USER_ICON?>" class="card-img-top" style="width: 250px;height: 172px;margin: 10px auto 0 auto;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Code: <?=$subject['subj_sec_3']?></h5>
                                    <p class="card-text">The Subject code is associated only to one grade. Get into the grade list of students</p>
                                    <a href="teacher/list.php?code=<?=$subject['subj_sec_3']?>" class="btn btn-outline-dark">Go to List</a>
                                    <a href="teacher/entry.php?code=<?=$subject['subj_sec_3']?>" class="btn btn-outline-dark">Grades</a>
                                </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if ($subject['subj_sec_4'] != ''):?>
                            <div class="col-md-4">
                                <div class="card mt-3" style="width: 22rem;">
                                <img src="<?=GROUP_USER_ICON?>" class="card-img-top" style="width: 250px;height: 172px;margin: 10px auto 0 auto;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Code: <?=$subject['subj_sec_4']?></h5>
                                    <p class="card-text">The Subject code is associated only to one grade. Get into the grade list of students</p>
                                    <a href="teacher/list.php?code=<?=$subject['subj_sec_4']?>" class="btn btn-outline-dark">Go to List</a>
                                    <a href="teacher/entry.php?code<?=$subject['subj_sec_4']?>" class="btn btn-outline-dark">Grades</a>
                                </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>