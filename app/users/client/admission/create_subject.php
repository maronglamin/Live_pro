<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
if ($user_data['user_role'] != ADMISSION_USER) {
    login_error_redirect(PROOT . "index.php", "Admin Pages");
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");
$errors = [];

$subj_name = ((isset($_POST['sname'])) ? sanitize($_POST['sname']) : '');
$subj_level = ((isset($_POST['grade-level'])) ? sanitize($_POST['grade-level']) : '');
$subj_status = ((isset($_POST['is-active'])) ? sanitize($_POST['is-active']) : '');
$subj_period = ((isset($_POST['period'])) ? sanitize($_POST['period']) : '');
$subj_code = ((isset($_POST['scode'])) ? sanitize($_POST['scode']) : '');


$per_page_record = RECORD_TO_SHOW;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $per_page_record;
$subj_data = $db->query("SELECT * FROM `subjects` ORDER BY `subj_grade_level`, `subj_name` ASC LIMIT $start_from, $per_page_record");

if (isset($_GET['act']) || isset($_GET['deact'])) {
    $act = (int)sanitize($_GET['act']);
    $deact = (int)sanitize($_GET['deact']);
    $current_date = date("Y-m-d H:i:s");

    if (isset($_GET['act'])) {
        $db->query("UPDATE `subjects` SET `subj_status`= '1', `updated_at` = '{$current_date}', `updated_by` = '{$auth_user_name}' WHERE `subj_id`= '{$act}'");
    } else {
        $db->query("UPDATE `subjects` SET `subj_status`= '0', `updated_at` = '{$current_date}', `updated_by` = '{$auth_user_name}' WHERE `subj_id`='{$deact}'");
    }  
    redirect('create_subject.php');   
}
?>

<br><br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary">Subjects</h2>
                <p>
                    Create subjects as per the grade levels in the school. 
                    Catergorizing your subjects in levels give a better data stucturing.
                </p>
            </div>
        </div>
        <section>
            <div class="col">
                <div class="container">
                    <div class="card mt-2 p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-secondary">Record New Subject</h4>
                                </div>
                                <div class="card-body">
                                <?php
                                    if (isset($_POST['submit_subject'])) {
                                        $code_ex = $db->query("SELECT * FROM `subjects` WHERE `subj_code` = '{$subj_code}'");
                                        $code_res = mysqli_num_rows($code_ex);

                                        $required = ['sname', 'grade-level', 'is-active', 'period'];
                                        foreach ($required as $fields) {
                                            if ($_POST[$fields] == EMPTY_VALUE) {
                                                $errors[] .= 'You must fill out all fields.';
                                                break;
                                            }
                                        }
                                        if ($code_res != 0){
                                            $errors[] .= "The subject code Exists in records.";
                                        }
                                        if (!empty($errors)) {
                                            echo display_errors($errors);
                                        } else {
                                            $db->query("INSERT INTO `subjects`(`subj_name`, `subj_code`, `subj_grade_level`, `subj_status`, `subj_period`, `inputted_by`) VALUES ('{$subj_name}', '{$subj_code}','{$subj_level}','{$subj_status}','{$subj_period}','{$auth_user_name}')");
                                            echo spinner();
                                            redirect('create_subject.php');
                                        }
                                    }
                                            ?>
                                    <form action="#" method="post">
                                        <div class="row">
                                        <div class="mt-2 col-md-12">
                                            <input type="text" name="sname" id="sname" placeholder="Subject Name e.g. Social And Enviromental Studies" class="form-control form-control-sm">
                                        </div>
                                        <div class="mt-2 col-md-12">
                                            <input type="text" name="scode" id="scode" placeholder="Subject Code and Code must be unique" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                        <select name="grade-level" id="grade-level" class="form-control form-control-sm">
                                            <option value="">Select Grade Level</option>
                                            <option value="7">Grade Seven (7)</option>
                                            <option value="8">Grade Eight (8)</option>
                                            <option value="9">Grade Nine (9)</option>
                                        </select>
                                        </div>
                                        <div class="mt-2">
                                            <select name="is-active" id="is-active" class="form-control form-control-sm">
                                                <option value="">Select subject status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Close</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <input type="number" name="period" min="1" id="period" class="form-control form-control-sm" placeholder="periods per week">
                                        </div>
                                        <div class="d-grid gap-2 p-2">
                                            <button name="submit_subject" class="btn btn-outline-dark" type="submit">Save</button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-secondary">Subjects</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Subject Code</th>
                                                <th scope="col">Subject Name</th>
                                                <th scope="col">Grade Level</th>
                                                <th scope="col">Period</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($subj = mysqli_fetch_assoc($subj_data)):?>
                                            <tr>
                                                <th scope="row"><?=$subj['subj_code']?></th>
                                                <td scope="row"><?=substrwords($subj['subj_name'], 21)?></td>
                                                <td><?=$subj['subj_grade_level']?></td>
                                                <td><?=$subj['subj_period']?> periods per week</td>
                                                <td><?=(($subj['subj_status']) == 1) ? 'Active <a href="create_subject.php?deact=' .$subj['subj_id'] .'" class="btn btn-sm btn-outline-primary">Deactivate</a>' : '<a href="create_subject.php?act='. $subj['subj_id'] . '" class="btn btn-sm btn-outline-danger">Activate</a>' ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endwhile;?>
                                        </tbody>
                                    </table>
                                    <?php
                                $enroll_stud_query = $db->query("SELECT COUNT(*) FROM `subjects` ORDER BY `subj_grade_level` ASC");
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
                                                <a class="page-link" href="create_subject.php?page=<?= ($page - 1) ?>" tabindex="-1">Previous</a>
                                            <?php endif; ?>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <?php if ($i == $page) : ?>
                                                <li class="page-item"><a class="page-link" href="create_subject.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php else : ?>
                                                <li class="page-item"><a class="page-link" href="create_subject.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <?php if ($page < $total_pages) : ?>
                                                <a class="page-link" href="create_subject.php?page=<?= ($page + 1) ?>">Next</a>
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
        </section>
    </div>
</div>