<?php
if (isset($_POST['submit_enroll'])) {
    $required = ['acad_year', 'name', 'pname', 'mobile', 'snumber'];
    foreach ($required as $fields) {
        if ($_POST[$fields] == EMPTY_VALUE) {
            $errors[] .= 'You must fill out all fields.';
            break;
        }
    }
    if (!empty($errors)) {
        echo display_errors($errors);
    } else {
        $db->query("INSERT INTO `enroll_student`(`stud_id`, `stud_name`, `stud_parent_name`, `stud_parent_mobile`, `stud_enroll_yr`, `stud_inputted_by`) VALUES ('{$stud_number}','{$stud_name}','{$stud_parent_name}','{$stud_parent_mobile}', '{$acad_year}', '{$auth_user_name}')");
        echo spinner();
        redirect('enroll.php');
    }
} elseif (isset($_POST['save'])) {
    $required = ['gender', 'pschool', 'address', 'pbirth', 'date-birth', 'health'];
    foreach ($required as $fields) {
        if ($_POST[$fields] == EMPTY_VALUE) {
            $errors[] .= 'You must fill out all fields.';
            break;
        }
    }
    if (!empty($errors)) {
        echo display_errors($errors);
    } else {
        $db->query("UPDATE `enroll_student` SET `stud_prev_sch` = '{$stud_prev_sch}',
                        `stud_address` = '{$stud_address}', `stud_gender` = '{$stud_gender}', 
                        `stud_place_birth` = '{$stud_place_birth}', `stud_date_brith` = '{$stud_date_birth}',
                        `health_relate_problem` = '{$stud_health}'
                        WHERE `stud_id` = '{$student_id}'");
        echo spinner();
        redirect('enroll.php');
    }
}
