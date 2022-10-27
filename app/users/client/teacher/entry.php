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

$grade_first = ((isset($_POST['first-grade'])) ? sanitize($_POST['first-grade']) : '');
$grade_sec = ((isset($_POST['sec-grade'])) ? sanitize($_POST['sec-grade']) : '');
$grade_third = ((isset($_POST['third-grade'])) ? sanitize($_POST['third-grade']) : '');

$student_id_search = ((isset($_POST['student_id'])) ? sanitize($_POST['student_id']) : '');

if (isset($_GET['code'])) { 
    $code = sanitize($_GET['code']);
    // $stud_id = (int)sanitize($_GET['std_id']);
    $qry_codes = $db->query("SELECT * FROM `subjects` WHERE `subj_code` = '{$code}'");
    // $qry_stud_ids = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$stud_id}'");


    $qry_code = mysqli_fetch_assoc($qry_codes);
    // $qry_stud_id = mysqli_fetch_assoc($qry_stud_ids);

?>
<br><br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary"><?=$auth_user_fullname?></h2>
                <p>Enter grades of the selected student.</p>
            </div>
        </div>
        <section>
            <div class="container">
                <div class="card p-3">
                    <h3 class="text-secondary text-center"><?=$qry_code['subj_name']?></h3>
                    <form action="entry.php?code=<?=$qry_code['subj_code']?>" method="post">
                    <?php if (isset($_POST['fetch_student_id'])) {
                            $required = ['student_id'];
                            foreach ($required as $fields) {
                                if ($_POST[$fields] == EMPTY_VALUE) {
                                    $errors[] .= 'Student Id is mandatory.';
                                    break;
                                }
                            }
                            if (!empty($errors)) {
                                echo display_errors($errors);
                            } else { 
                                    $class_qry = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id_search}'");
                            }
                     }?>
                            <div class="row">
                                <div class="col col-md-3">
                                        <input type="number" name="student_id" id="student_id" placeholder="Enter student id" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-dark" name="fetch_student_id">Fetch</button>
                                </div>
                            </div>
                            </form>

                            <?php 
                                if ($student_id_search == '') {
                                $errors[] .= 'You must select a class.';
                                } if (isset($_POST['fetch_student_id'])) {
                                while ($result = mysqli_fetch_assoc($class_qry)) { 
                                $stud_id = $result['stud_id'];
                                ?>
                            <form action="uploadGrade.php?code=<?=$qry_code['subj_code']?>" method="post">
                                <div class="row">
                                    <div class="col">
                                        <input type="hidden" name="stud_id" value="<?=$stud_id?>">
                                        <div class="col-md-8">
                                            <div class="mt-2">
                                                <input type="text" name="stud_name" id="stud_name" disabled value="<?=$result['stud_name']?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="mt-2">
                                                <input type="number" name="first-grade" id="first-grade" min="0" max="25" placeholder="Enter Score, maximum 25" class="form-control form-control-sm">
                                            </div>
                                            <div class="mt-2">
                                                <input type="number" name="sec-grade" id="sec-grade" min="0" max="25" placeholder="Enter Score, maximum 25" class="form-control form-control-sm">
                                            </div>
                                            <div class="mt-2">
                                                <input type="number" name="third-grade" id="third-grade" min="0" max="50" placeholder="Enter Score, maximum 50" class="form-control form-control-sm">
                                            </div>
                                            <button class="btn btn-outline-dark mt-3" type="submit" name="save_grades">Save</button>
                                            <button class="btn btn-outline-dark mt-3" type="reset">Reset</button>
                                            <a href="list.php?code=<?=$qry_code['subj_code']?>" class="btn btn-outline-dark mt-3">Back</a>
                                        </div>
                                    </div>
                                    <div class="col">
                                    <img src="<?= PROOT . 'app/' . $result['stud_prof_photo_url'] ?>" class="user-img d-block m-auto mb-2" />
                                    </div>
                                </div>
                            </form>
                        <?php }}?>
                </div>
            </div>
        </section>
    </div>
</div>
<?php } elseif(isset($_GET['edit']) && isset($_GET['edit_std'])) { 
    $code = sanitize($_GET['edit']);
    $stud_id = (int)sanitize($_GET['edit_std']);
    $qry_codes = $db->query("SELECT * FROM `subjects` WHERE `subj_code` = '{$code}'");
    $qry_stud_ids = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$stud_id}'");
    $existing_studs = $db->query("SELECT * FROM `stud_grades`  WHERE `stud_id` = '{$stud_id}' AND `teacher_id` = '{$auth_user_name}' AND `subj_code` = '{$code}'");

    $qry_code = mysqli_fetch_assoc($qry_codes);
    $qry_stud_id = mysqli_fetch_assoc($qry_stud_ids);
    $existing_stud = mysqli_fetch_assoc($existing_studs);
    ?>
<br><br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary"><?=$auth_user_fullname?></h2>
                <p>Edit grades of the selected student.</p>
            </div>
        </div>
        <section>
            <div class="container">
                <div class="card p-3">
                    <h3 class="text-secondary text-center"><?=$qry_code['subj_name']?></h3>
                    <form action="entry.php?edit=<?=$qry_code['subj_code']?>&edit_std=<?=$qry_stud_id['stud_id']?>" method="post"> 
                    <?php if (isset($_POST['edit_grades'])){
                            $checkCode = $db->query("SELECT * FROM `stud_grades` WHERE `stud_id` = '{$stud_id}' AND `teacher_id` = '{$auth_user_name}' AND `subj_code` = '{$code}'");
                            $checkCount = mysqli_num_rows($checkCode);

                            $required = ['first-grade', 'sec-grade', 'third-grade'];
                            foreach ($required as $fields) {
                                if ($_POST[$fields] == EMPTY_VALUE) {
                                    $errors[] .= $fields .' is mandatory.';
                                    break;
                                }
                                if (!empty($errors)) {
                                    echo display_errors($errors);
                                } else {
                                    $db->query("UPDATE `stud_grades` SET `grade_1` = '{$grade_first}', `grade_2` = '{$grade_sec}', `grade_3` = '{$grade_third}' WHERE `stud_id` = '{$stud_id}' AND `teacher_id` = '{$auth_user_name}' AND `subj_code` = '{$code}'");
                                    redirect('list.php?code='. $qry_code['subj_code']);
                                }
                            }
                        }?>  
                        <div class="row">
                            <div class="col">
                                <div class="col-md-4">
                                    <div class="mt-2">
                                        <input type="text" name="stud_name" id="stud_name" disabled value="<?=$qry_stud_id['stud_name']?>" class="form-control form-control-sm">
                                    </div>
                                    <div class="mt-2">
                                        <input type="number" name="first-grade" id="first-grade" min="0" max="25" value="<?=$existing_stud['grade_1']?>" placeholder="Enter Score, maximum 25" class="form-control form-control-sm">
                                    </div>
                                    <div class="mt-2">
                                        <input type="number" name="sec-grade" id="sec-grade" min="0" max="25" value="<?=$existing_stud['grade_2']?>" placeholder="Enter Score, maximum 25" class="form-control form-control-sm">
                                    </div>
                                    <div class="mt-2">
                                        <input type="number" name="third-grade" id="third-grade" min="0" max="50" value="<?=$existing_stud['grade_3']?>" placeholder="Enter Score, maximum 50" class="form-control form-control-sm">
                                    </div>
                                    <button class="btn btn-outline-dark mt-3" type="submit" name="edit_grades">Update</button>
                                    <button class="btn btn-outline-dark mt-3" type="reset">Reset</button>
                                    <a href="list.php?code=<?=$qry_code['subj_code']?>" class="btn btn-outline-dark mt-3">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<?php }?>