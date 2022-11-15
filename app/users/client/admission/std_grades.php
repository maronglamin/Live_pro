<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");

$errors = [];
$std_number = ((isset($_POST['std_number'])) ? sanitize($_POST['std_number']) : '');

$class = $db->query("SELECT * FROM `school_class`");

?>
<br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary">Scores </h2>
                    <p>View the inputed grades of students in a perticular.</p>

                <?php if (!isset($_GET['classid'])){?>
                    <div class="card col-md-6 offset-3">
                        <div class="container">
                            <h3 class="text-secondary text-center">Result by class levels</h3>
                            <div class="row">
                                    <div class="container">
                                        <div class="card">
                                        <table class="table table-striped table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Class Name</th>
                                                    <th scope="col">Class Level</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($result = mysqli_fetch_assoc($class)):?>
                                                    <tr>
                                                        <th scope="row"><?=$result['class_name']?></th>
                                                        <td scope="row">Grade <?=$result['class_name_figure']?></td>
                                                        <td scope="row" class="text-end">
                                                            <a href="std_grades.php?classid=<?=$result['class_id']?>" class="btn btn-sm btn-outline-dark">Load Data</a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile;?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                <?php } elseif (isset($_GET['classid'])) {
                    $classid = (int)sanitize($_GET['classid']);
                    $class_list = $db->query("SELECT stg.stud_id, stg.subj_code, stg.grade_1, stg.grade_2, stg.grade_3, sc.class_name, ens.stud_name FROM stud_grades stg, school_class sc, enroll_student ens WHERE ens.stud_id = stg.stud_id AND stg.stud_enroll_class = sc.class_id AND sc.class_id = '{$classid}' ORDER BY stg.stud_id DESC LIMIT 15");
                ?>
                        <div class="card p-3">
                            <h3 class="text-secondary text-center">Student List</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="text-secondary text-center">Search Scores</h4>
                                        </div>
                                        <form action="std_grades.php?classid=<?=$classid?>" method="post" class="mt-2 p-3">
                                            <?php 
                                                if(isset($_POST['sn_fetch'])) {
                                                $required = ['std_number'];
                                                 foreach ($required as $fields) {
                                                     if ($_POST[$fields] == EMPTY_VALUE) {
                                                         $errors[] .= 'Student id can not be empty';
                                                         break;
                                                     }
                                                 }
                                                 if (!empty($errors)) {
                                                    echo display_errors($errors);
                                                } else {
                                                    $class_list = $db->query("SELECT stg.stud_id, stg.subj_code, stg.grade_1, stg.grade_2, stg.grade_3, sc.class_name, ens.stud_name FROM stud_grades stg, school_class sc, enroll_student ens WHERE ens.stud_id = stg.stud_id AND stg.stud_enroll_class = sc.class_id AND ens.stud_id = '{$std_number}' AND sc.class_id = '{$classid}'");
                                                }
                                            }
                                            ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" name="std_number" placeholder="Enter student id" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col">
                                                        <button type="submit" name="sn_fetch" class="btn btn-sm btn-outline-dark">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            <?php 
                                if ($std_number == '') {
                                    $errors[] .= 'Student id can not be empty';
                                } elseif(isset($_POST['sn_fetch'])) {
                                    $details = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$std_number}'");
                                    ?>
                                    <div class="col-md-8">
                                        <div id="report_card">
                                        <h4 class="text-center text-secondary">Report card</h4>
                                            <div class="card p-3">
                                                <?php while($detail = mysqli_fetch_assoc($details)):?>
                                                    <div class="row">
                                                        <div class="col">
                                                            STUDENT NAME : <strong><?=cap($detail['stud_name'])?></strong><br>
                                                            PRINTED DATE: <strong><?=human_date(date("Y-m-d H:i:s"))?></strong><br>
                                                        </div>
                                                        <div class="col report-card-img">
                                                        <img src="<?= PROOT . 'app/' . $detail['stud_prof_photo_url'] ?>" class="user-img d-block m-auto mb-2" />                                                        </div>
                                                    </div>
                                                <?php endwhile;?>
                                                <div class="card mx-2 mt-4">
                                                    <table class="table table-striped table-sm table-hover">
                                                        <thead>
                                                                <tr>
                                                                    <th scope="col">Subject Code</th>
                                                                    <th scope="col">Test 1 </th>
                                                                    <th scope="col">Test 2 </th>
                                                                    <th scope="col">Test </th>
                                                                    <th scope="col">Exams </th>
                                                                    <th scope="col">Total</th>
                                                                    <th scope="col">Grade</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($result = mysqli_fetch_assoc($class_list)):?>
                                                                <tr>
                                                                    <th scope="col"><?=$result['subj_code']?></th>
                                                                    <td scope="col"><?=$result['grade_1']?></td>
                                                                    <td scope="col"><?=$result['grade_2']?></td>
                                                                    <td scope="col"><?= (int)$result['grade_1'] + (int)$result['grade_2']?></td>
                                                                    <td scope="col"><?=$result['grade_3']?></td>
                                                                    <td scope="col"><?=(int)$result['grade_1'] + (int)$result['grade_2'] + (int)$result['grade_3']?></td>
                                                                    <td scope="col"><?=$result['subj_code']?></td>
                                                                </tr>
                                                            <?php endwhile;?>
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-dark mt-3" type="button" onClick="printElement('report_card', 'Afang School app')">Print</button>
                            <?php }?>
                            <?php if(!isset($_POST['sn_fetch'])):?>
                                <div class="col-md-8">
                                <div class="card mx-2">
                                    <table class="table table-striped table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">SN#</th>
                                                <th scope="col">Full name</th>
                                                <th scope="col">Subject Code</th>
                                                <th scope="col">T1</th>
                                                <th scope="col">T2</th>
                                                <th scope="col">EX</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($list = mysqli_fetch_assoc($class_list)):?>
                                                <tr>
                                                    <th scope="row">SN<?=$list['stud_id']?></th>
                                                    <td><?=cap($list['stud_name'])?></td>
                                                    <td><?=$list['subj_code']?></td>
                                                    <td><?=$list['grade_1']?></td>
                                                    <td><?=$list['grade_2']?></td>
                                                    <td><?=$list['grade_3']?></td>
                                                </tr>
                                            <?php endwhile;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                <?php  }?>
            </div>
        </div>
    </div>
</div>


<script>
    function printElement(elem, title) {
        var popup = window.open('', '_blank', `width=${window.innerWidth}, height=${window.innerHeight}`);

        popup.document.write('<html><head><link rel="stylesheet" href="<?=PROOT?>css/custom.min.css"><title>' + title + '</title>');
        popup.document.write('<style></style>');
        popup.document.write('</head><body>');
        popup.document.write(document.getElementById(elem).innerHTML);
        popup.document.write('</body></html>');

        popup.document.close();
        popup.focus();

        popup.print();
        popup.close();

        return true;
    }
</script>