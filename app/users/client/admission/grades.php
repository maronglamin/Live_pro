<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");

$search_code = ((isset($_POST['search_code'])) ? sanitize($_POST['search_code']) : '');
$errors = [];

$subjects = $db->query("SELECT * FROM `subjects` ORDER BY `subj_grade_level`,`subj_name` ASC LIMIT 1");

?>
<br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary">Grades Inputted </h2>
                    <p>View the grades inputted by a perticular subject teacher.</p>
                    <div class="card">
                        <div class="container">
                            <h3 class="text-secondary text-center">Master List Of Subjects</h3>
                            <div id="content-center">
                                <div class="row">
                                    <div class="col">
                                        <form action="grades.php" method="post">
                                            <?php if (isset($_POST['search_subject'])) {
                                                 $required = ['search_code'];
                                                 foreach ($required as $fields) {
                                                     if ($_POST[$fields] == EMPTY_VALUE) {
                                                         $errors[] .= 'Subject can not be left Empty';
                                                         break;
                                                     }
                                                 }
                                                 if (!empty($errors)) {
                                                    echo display_errors($errors);
                                                } else {
                                                    $search_qry = $db->query("SELECT * FROM `stud_grades` `SG`, `subjectS` `SB`, `enroll_student` `ENS` WHERE `SG`.`stud_id` = `ENS`.`stud_id` AND `SG`.`subj_code` = `SB`.`subj_code` AND `SB`.`subj_code` = '{$search_code}'");

                                                }
                                            }
                                            ?>
                                            <div class="row mt-2 mb-3">
                                                    <div class="col col-md-4">
                                                        <input type="text" name="search_code" id="search_code" placeholder="Enter subject code" class="form-control form-control-sm">
                                                        <small>search by subject code and by default, The first ASCENDING ORDER subject appear below</small>
                                                    </div>
                                                    <div class="col">
                                                        <button type="submit" name="search_subject" class="btn btn-sm btn-outline-dark">Fetch</button>
                                                    </div>
                                            </div>
                                        </form>

                                        <?php if(isset($_POST['search_subject'])):?>
                                            <div id="subject-list">
                                                <h3 class="text-secondary"></h3>
                                                    <div class="container">
                                                        <table class="table table-striped table-sm table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Subject Code</th>
                                                                    <th scope="col">Student Id</th>
                                                                    <th scope="col">Student name</th>
                                                                    <th scope="col">Test 1</th>
                                                                    <th scope="col">Test 2</th>
                                                                    <th scope="col">Tests</th>
                                                                    <th scope="col">Exam</th>
                                                                    <th scope="col">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php 
                                                                if ($search_code == '') {
                                                                    $errors[] .= 'Subject can not be left Empty';
                                                                } elseif (isset($_POST['search_subject'])) {
                                                                    while ($result = mysqli_fetch_assoc($search_qry)) { ?>
                                                                    <tr>
                                                                        <th scope="row"><?=$result['subj_code']?></th>
                                                                        <th scope="row"><?=$result['stud_id']?></th>
                                                                        <td scope="row"><?=$result['stud_name']?></td>
                                                                        <td scope="row"><?=(int)$result['grade_1']?></td>
                                                                        <td scope="row"><?=(int)$result['grade_2']?></td>
                                                                        <td scope="row"><?=(int)$result['grade_1'] + (int)$result['grade_2']?></td>
                                                                        <td scope="row"><?=(int)$result['grade_3']?></td>
                                                                        <td scope="row"><?=(int)$result['grade_1'] + (int)$result['grade_2'] + (int)$result['grade_3']?></td>
                                                                         
                                                                    </tr>
                                                                <?php } }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                                            <button class="btn btn-outline-dark mb-3" type="button" onClick="printElement('subject-list', 'Afang School app')">Print</button>
                                        <?php elseif(!isset($_POST['search_subject'])):?>
                                            <?php while ($subject = mysqli_fetch_assoc($subjects)):
                                                $sid = $subject['subj_code'];
                                                $sub_qry = $db->query("SELECT * FROM `stud_grades` `SG`, `subjectS` `SB`, `enroll_student` `ENS` WHERE `SG`.`stud_id` = `ENS`.`stud_id` AND `SG`.`subj_code` = `SB`.`subj_code` AND `SB`.`subj_code` = '{$sid}'");
                                            ?>
                                            <div id="subject-list">
                                                <h3 class="text-secondary"><?=$subject['subj_name']?> for grade <?=$subject['subj_grade_level']?></h3>
                                                    <div class="container">
                                                        <table class="table table-striped table-sm table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Subject Code</th>
                                                                    <th scope="col">Student Id</th>
                                                                    <th scope="col">Student name</th>
                                                                    <th scope="col">Test 1</th>
                                                                    <th scope="col">Test 2</th>
                                                                    <th scope="col">Tests</th>
                                                                    <th scope="col">Exam</th>
                                                                    <th scope="col">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php while($sub_data = mysqli_fetch_assoc($sub_qry)):?>
                                                                    <tr>
                                                                        <th scope="row"><?=$sub_data['subj_code']?></th>
                                                                        <td scope="row">SN<?=$sub_data['stud_id']?></td>
                                                                        <td scope="row"><?=$sub_data['stud_name']?></td>
                                                                        <td scope="row"><?=(int)$sub_data['grade_1']?></td>
                                                                        <td scope="row"><?=(int)$sub_data['grade_2']?></td>
                                                                        <td scope="row"><?=(int)$sub_data['grade_1'] + (int)$sub_data['grade_2']?></td>
                                                                        <td scope="row"><?=(int)$sub_data['grade_3']?></td>
                                                                        <td scope="row"><?=(int)$sub_data['grade_1'] + (int)$sub_data['grade_2'] + (int)$sub_data['grade_3']?></td>                                                    
                                                                    </tr>
                                                                <?php endwhile;?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                                            <button class="btn btn-outline-dark mb-3" type="button" onClick="printElement('subject-list', 'Afang School app')">Print</button>
                                    </div>
                                    <?php endwhile;?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
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
