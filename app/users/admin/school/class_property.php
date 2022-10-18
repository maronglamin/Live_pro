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
$search = [];

$class_query = $db->query("SELECT * FROM `school_class`");
$class_select = $db->query("SELECT * FROM `school_class`");

$class_name_word = ((isset($_POST['class-name-word'])) ? sanitize($_POST['class-name-word']) : '');
$class_name_figure = ((isset($_POST['class-name-figure'])) ? sanitize($_POST['class-name-figure']) : '');
$class_size = ((isset($_POST['class-size'])) ? sanitize($_POST['class-size']) : '');
$student_class = ((isset($_POST['student-class'])) ? sanitize($_POST['student-class']) : '');

?>
<br><br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary">Classes</h2>
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
                        <h2 class="text-secondary text-center">Create Class with its PROPERTY</h2>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="text-center text-secondary">Create Class Name</h4>
                                    </div>
                                    <div class="mt-4">
                                        <form action="#" method="post" class="row p-2">
                                            <?php 
                                                if (isset($_POST['submit_class'])) {
                                                    $required = ['class-name-word', 'class-name-figure', 'class-size'];
                                                    foreach ($required as $fields) {
                                                        if ($_POST[$fields] == EMPTY_VALUE) {
                                                            $errors[] .= 'You must fill out all fields.';
                                                            break;
                                                        }
                                                    }
                                                    if (!empty($errors)) {
                                                        echo display_errors($errors);
                                                    } else {
                                                        $db->query("INSERT INTO `school_class`(`class_name`, `class_name_figure`, `class_size`, `class_create_by`) VALUES ('{$class_name_word}','$class_name_figure','{$class_size}','{$auth_user_name}')");
                                                        echo spinner();
                                                        redirect('class_property.php');
                                                    }
                                                }
                                            ?>
                                                <div>
                                                    <input type="text" name="class-name-word" id="class-name" placeholder="Class Name in words (e.g Seven Square)" class="form-control form-control-sm mb-2">
                                                    <input type="text" name="class-name-figure" id="class-name" placeholder="Class Name in figures (e.g 7 Square)" class="form-control form-control-sm mb-2">
                                                    <select name="class-size" id="class-size" class="form-control form-control-sm mb-2">
                                                        <option value="">Select Class size</option>
                                                        <option value="35">35 Students</option>
                                                        <option value="40">40 Students</option>
                                                        <option value="45">45 Students</option>
                                                        <option value="50">50 Students</option>
                                                        <option value="55">55 Students</option>
                                                        <option value="60">60 Students</option>
                                                    </select>
                                                </div>
                                                <div class="d-grid gap-2 p-2">
                                                    <button name="submit_class" class="btn btn-outline-dark" type="submit">Create</button>
                                                </div>
                                                <div>
                                            </form>
                                            <table class="table table-striped table-sm table-hover mt-2">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Grade</th>
                                                        <th scope="col">Short Name</th>
                                                        <th scope="col">Class Size</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while($sch_data = mysqli_fetch_assoc($class_query)):?>
                                                        <tr>
                                                            <th scope="row"><?=$sch_data['class_name']?></th>
                                                            <td><?=$sch_data['class_name_figure']?></td>
                                                            <td><?=$sch_data['class_size']?> Pupils</td>
                                                        </tr>
                                                    <?php endwhile;?>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-center text-secondary">Student in a selected class</h4>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 ms-2">
                                        <form action="#" method="post">
                                            <div class="col">
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
                                                                $class_qry = $db->query("SELECT * FROM `enroll_student` WHERE `enroll_class` = '{$student_class}'");                                                            }
                                                            
                                                        }
                                                    ?>
                                            </div>
                                            <select name="student-class" id="student-class" class="form-control form-control-sm">
                                                <option value="">select to show</option>
                                                <?php while($select_data = mysqli_fetch_assoc($class_select)):?>
                                                    <option value="<?=$select_data['class_id']?>"><?=$select_data['class_name']?></option>
                                                <?php endwhile;?>
                                            </select>
                                            </div>
                                            <div class="col mt-3">
                                                <input name="fetch_class" type="submit" value="Fetch" class="btn btn-outline-dark">
                                            </div>
                                        </form>
                                </div>
                                <table class="table table-striped table-sm table-hover mt-2">
                                    <thead>
                                        <tr>
                                            <th scope="col">SN#</th>
                                            <th scope="col">Full name</th>
                                            <th scope="col">Enrolled year</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Address</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                         if ($student_class == '') {
                                            $errors[] .= 'You must select a class.';
                                         } elseif (isset($_POST['fetch_class'])) {
                                            while ($result = mysqli_fetch_assoc($class_qry)) { ?>
                                    <tr>
                                        <th scope="row"><?= $result['stud_id']?></th>
                                        <td><?= $result['stud_name']?></td>
                                        <td><?= year_format($result['stud_enroll_yr'])?></td>
                                        <td><?= (($result['stud_gender']) == 1)? 'Male': 'Female'?></td>
                                        <td><?= $result['stud_address']?></td>
                                    </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
