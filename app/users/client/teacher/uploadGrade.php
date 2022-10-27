<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
$grade_first = ((isset($_POST['first-grade'])) ? sanitize($_POST['first-grade']) : '');
$grade_sec = ((isset($_POST['sec-grade'])) ? sanitize($_POST['sec-grade']) : '');
$grade_third = ((isset($_POST['third-grade'])) ? sanitize($_POST['third-grade']) : '');

$student_id = ((isset($_POST['stud_id'])) ? sanitize($_POST['stud_id']) : '');
$errors = [];

if (isset($_GET['code'])) { 
    $code = sanitize($_GET['code']);

     if (isset($_POST['save_grades'])){
        $checkCode = $db->query("SELECT * FROM `stud_grades` WHERE `stud_id` = '{$student_id}' AND `teacher_id` = '{$auth_user_name}' AND `subj_code` = '{$code}'");
        $checkCount = mysqli_num_rows($checkCode);

        $required = ['first-grade', 'sec-grade', 'third-grade'];
        foreach ($required as $fields) {
            if ($_POST[$fields] == EMPTY_VALUE) {
                redirect('list.php?code='. $code);
                $errors[] .= $fields .' is mandatory.';
                break;
            }
        }
            if ($checkCount != 0) {
                redirect('list.php?code='. $code);
                $errors[] .= 'The Student id '. $student_id . ' grades\'s has been entered';
            }
            if (!empty($errors)) {
                echo display_errors($errors);
            } else {
                $db->query("INSERT INTO `stud_grades`(`stud_id`, `teacher_id`, `subj_code`, `grade_1`, `grade_2`, `grade_3`) VALUES ('{$student_id}','{$auth_user_name}','{$code}','{$grade_first}','{$grade_sec}','{$grade_third}')");
                redirect('list.php?code='. $code);
            }
        
    } }?>
