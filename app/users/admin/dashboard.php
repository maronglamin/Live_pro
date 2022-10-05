<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
if ($user_data['user_role'] != ADMIN_USER) {
    login_error_redirect(PROOT . "index.php", "Admin Pages");
}
include(ROOT . DS . "app" . DS . "components" . DS . "admin_nav.php");
$errors = [];

$per_page_record = RECORD_TO_SHOW;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $per_page_record;
$enroll_stud_query = $db->query("SELECT * FROM `enroll_student` ORDER BY `stud_id` ASC LIMIT $start_from, $per_page_record");


# academic year query
$acd_year_query = $db->query("SELECT * FROM `acad_year` WHERE `acad_year_closed_status` != 1 ORDER BY `acad_year_id`");

if (isset($_GET['statusOpen']) || $_GET['statusClose']) {
    $tatus_open = (int)sanitize($_GET['statusOpen']);
    $tatus_close = (int)sanitize($_GET['statusClose']);

    if (isset($_GET['statusOpen'])) {
        $db->query("UPDATE `acad_year` SET `close_acad_year` = 0, `re_open_by` = '{$auth_user_name}' WHERE `acad_year_id` = '{$tatus_open}'");
    } else {
        $db->query("UPDATE `acad_year` SET `close_acad_year` = 1, `closed_by` = '{$auth_user_name}' WHERE `acad_year_id` = '{$tatus_close}'");
    }
    redirect('dashboard.php');
}

?>
<div class="container-fluid mt-3">
    <div class="grid">
        <div class="col">
            <div class="container">
                <h2 class="text-secondary">Enrollment History</h2>
                <p>Open</p>
            </div>
        </div>
        <section>
            <div class="container">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="text-center text-secondary">Academic Year</h3>
                            <div class="card ms-2 mx-2">
                                <div class="card-header">
                                    <h4 class="text-secondary">Add an academic year.</h4>
                                    <small>This categorize student in the year they were enrolled</small>
                                </div>
                                <div class="row mt-3 ms-1 mx1">
                                    <div class="col-md-12">
                                        <?php
                                        // action for adding an academic year
                                        if (isset($_GET['academic_year'])) {
                                            $acad_year = ((isset($_POST['acad_year'])) ? sanitize($_POST['acad_year']) : '');

                                            if (isset($_POST)) {
                                                if ($acad_year == '') {
                                                    $errors[] .= "Year not filled";
                                                }
                                                if (!empty($errors)) {
                                                    echo display_errors($errors);
                                                } else {
                                                    $db->query("INSERT INTO `acad_year`(`acad_year`, `acad_year_inputted_by`) VALUES ('{$acad_year}','{$auth_user}')");
                                                    echo spinner();
                                                    redirect('dashboard.php');
                                                }
                                            }
                                        }
                                        ?>
                                        <form class="row" action="dashboard.php?academic_year=1" method="post">
                                            <div class="col">
                                                <div class="mb-2">
                                                    <input type="date" name="acad_year" class="form-control" placeholder="Academic year" />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <input type="submit" value="Save" class="btn btn-outline-dark" />
                                                </div>
                                            </div>
                                        </form>
                                        <p class="text-secondary"><strong>Note!</strong> Added academic year will be open until it you clos it</p>
                                    </div>
                                </div>
                                <table class="table table-striped table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Opened By</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($acad_year_res = mysqli_fetch_assoc($acd_year_query)) :
                                            $inputted_user_id = $acad_year_res['acad_year_inputted_by'];
                                            $input_by_query = $db->query("SELECT `user_id`, `user_name` FROM `users` WHERE `user_id` = '{$inputted_user_id}'");
                                            $loading = false;
                                        ?>
                                            <?php while ($input_by_res = mysqli_fetch_assoc($input_by_query)) : ?>
                                                <tr>
                                                    <th scope="row"><?= day_month($acad_year_res['acad_year']) ?></th>
                                                    <td><?= $input_by_res['user_name'] ?></td>
                                                    <?php if ($acad_year_res['close_acad_year'] == 0) : ?>
                                                        <td><a href="dashboard.php?statusClose=<?= $acad_year_res['acad_year_id'] ?>" class="btn btn-danger btn-sm">Close</a></td>
                                                    <?php else : ?>
                                                        <td><a href="dashboard.php?statusOpen=<?= $acad_year_res['acad_year_id'] ?>" class="btn btn-outline-dark btn-sm">Reopen</a></td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-center text-secondary">Student's Profile</h3>
                            <form action="#" method="post" class="ms-3 mx-3">
                                <div class="card mt-2 ms-2 mx-2">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                    </div>
                                </div>
                                <p class="text-secondary">Search Student</p>
                                <div class="row">
                                    <div class="col-md-6 form-group mt-2 mb-2">
                                        <input type="text" name="stnumber" id="stnumber" placeholder="student id number" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-6 form-group mt-2 mb-2">
                                        <input type="text" name="stnumber" id="stname" placeholder="full names" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </form>
                            <div class="card mx-2">
                                <table class="table table-striped table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">SN#</th>
                                            <th scope="col">Full name</th>
                                            <th scope="col">Enrolled year</th>
                                            <th scope="col">Parent mobile</th>
                                            <th scope="col">Enrolled by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($enroll_stud = mysqli_fetch_assoc($enroll_stud_query)) : ?>
                                            <tr>
                                                <th scope="row"><?= 'SN' . $enroll_stud['stud_id'] ?></th>
                                                <td><?= $enroll_stud['stud_name'] ?></td>
                                                <td><?= year_format($enroll_stud['stud_enroll_yr']) ?></td>
                                                <td class="text-end"><?= $enroll_stud['stud_parent_mobile'] ?></td>
                                                <td class="text-end"><?= $enroll_stud['stud_inputted_by'] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <?php
                                $enroll_stud_query = $db->query("SELECT COUNT(*) FROM `enroll_student` ORDER BY `stud_id` DESC");
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
                                                <a class="page-link" href="dashboard.php?page=<?= ($page - 1) ?>" tabindex="-1">Previous</a>
                                            <?php endif; ?>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <?php if ($i == $page) : ?>
                                                <li class="page-item"><a class="page-link" href="dashboard.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php else : ?>
                                                <li class="page-item"><a class="page-link" href="dashboard.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <?php if ($page < $total_pages) : ?>
                                                <a class="page-link" href="dashboard.php?page=<?= ($page + 1) ?>">Next</a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>