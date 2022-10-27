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

$class_query = $db->query("SELECT * FROM `school_class`");


$student_class = ((isset($_POST['student-class'])) ? sanitize($_POST['student-class']) : '');


if (isset($_GET['code'])) { 
    $code = sanitize($_GET['code']);
    $table_code = $db->query("SELECT * FROM `subjects` WHERE `subj_code` = '{$code}'");
    $code_table = mysqli_fetch_assoc($table_code);
    $grade = $code_table['subj_grade_level'];
    $class_grades = $db->query("SELECT * FROM `school_class` WHERE `class_name_figure` = '{$grade}'");

    $class_select = $db->query("SELECT * FROM `school_class` WHERE `class_name_figure` = '{$grade}'");
?>
<br><br>
<div class="container-fluid mt-5">
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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                   <h4 class="text-secondary"><?=$code_table['subj_code']?></h4> 
                                </div>
                                <div class="card-body">
                                    <p class="text-secondary">Subject: <?=$code_table['subj_name']?></p>
                                    <table class="table table-striped table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Grade</th>
                                                <th scope="col">Class Name</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($class_grade = mysqli_fetch_assoc($class_grades)):?>
                                                <tr>
                                                    <th scope="row"><?=$class_grade['class_name_figure']?></th>
                                                    <td><?=$class_grade['class_name']?></td>
                                                </tr>
                                            <?php endwhile;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form action="list.php?code=<?=$code ?>" method="post">
                            <?php 
                                if (isset($_POST['fetch_class'])) {
                                    $required = ['student-class'];
                                    foreach ($required as $fields) {
                                        if ($_POST[$fields] == EMPTY_VALUE) {
                                            $errors[] .= 'You must select a class.';
                                            break;
                                        }
                                    }
                                    if (!empty($errors)) {
                                        echo display_errors($errors);
                                    } else { 
                                            $class_qry = $db->query("SELECT DISTINCT `ens`.`stud_id`, `stg`.`grade_1`, `stg`.`grade_2`, `stg`.`grade_3`, `ens`.`stud_name` FROM `enroll_student` `ens`, `stud_grades` `stg` WHERE `stg`.`stud_id` = `ens`.`stud_id` AND `ens`.`enroll_class` = '{$student_class}' AND `stg`.`subj_code` = '{$code}'");  

                                    }
                                }
                                ?>
                                <h4 class="text-secondary">Select class to show</h4>
                                <div class="row">
                                    <div class="col">
                                        <select name="student-class" id="student-class" class="form-control form-control-sm">
                                            <option value="">Select Class name</option>
                                            <?php while($select_data = mysqli_fetch_assoc($class_select)):?>
                                                    <option value="<?=$select_data['class_id']?>"><?=$select_data['class_name']?></option>
                                            <?php endwhile;?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button type="submit" name="fetch_class" id="fetch_class" class="btn btn-outline-dark">Fetch</button>
                                    </div>

                                    <table class="table table-striped table-sm table-hover mt-2">
                                    <thead>
                                        <tr>
                                            <th scope="col">SN#</th>
                                            <th scope="col">Full name</th>
                                            <th scope="col">Tests</th>
                                            <th scope="col">Exams</th>
                                            <th scope="col">Scares</th>
                                            <th scope="col"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                         if ($student_class == '') {
                                            $errors[] .= 'You must select a class.';
                                         } elseif (isset($_POST['fetch_class'])) {
                                            while ($result = mysqli_fetch_assoc($class_qry)) { 
                                            ?>
                                                    <tr>
                                                        <th scope="row"><?= $result['stud_id']?></th>
                                                        <td><?= $result['stud_name']?></td>
                                                        <td class="text-end"><?=(int)$result['grade_1'] + (int)$result['grade_2']?></td>
                                                        <td class="text-start"><?=(int)$result['grade_3']?></td>
                                                        <td class="text-start"><?=(int)$result['grade_1'] + (int)$result['grade_2'] + (int)$result['grade_3']?></td>
                                                        <td><a href="entry.php?edit=<?=$code?>&edit_std=<?=$result['stud_id']?>" class="btn btn-outline-dark btn-sm">Edit Scores</a></td>
                                                    </tr>
                                        <?php }}  ?>
                                    </tbody>
                                </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php }