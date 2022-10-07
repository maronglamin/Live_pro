<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';

if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Enroll");
}
if (!($auth_user_role == ADMISSION_USER || $auth_user_role == PRINCIPAL_USER)) {
    login_redirect();
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");
$errors = [];  

$acad_year = ((isset($_POST['acad_year'])) ? sanitize($_POST['acad_year']) : '');
$stud_number = ((isset($_POST['snumber'])) ? sanitize($_POST['snumber']) : '');
$stud_name = ((isset($_POST['name'])) ? sanitize($_POST['name']) : '');
$stud_parent_name = ((isset($_POST['pname'])) ? sanitize($_POST['pname']) : '');
$stud_parent_mobile = ((isset($_POST['mobile'])) ? sanitize($_POST['mobile']) : '');
$stud_gender = ((isset($_POST['gender'])) ? sanitize($_POST['gender']) : '');
$stud_prev_sch = ((isset($_POST['pschool'])) ? sanitize($_POST['pschool']) : '');
$stud_address = ((isset($_POST['address'])) ? sanitize($_POST['address']) : '');
$stud_place_birth = ((isset($_POST['pbirth'])) ? sanitize($_POST['pbirth']) : '');
$stud_date_birth = ((isset($_POST['date-birth'])) ? sanitize($_POST['date-birth']) : '');
$stud_health = ((isset($_POST['health'])) ? sanitize($_POST['health']) : '');


$acad_year_query = $db->query("SELECT `acad_year_id`, `acad_year` FROM `acad_year` WHERE `close_acad_year` != 1 AND `acad_year_closed_status` != 1");

$per_page_record = RECORD_TO_SHOW;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $per_page_record;
$enroll_stud_query = $db->query("SELECT * FROM `enroll_student` ORDER BY `stud_id` DESC LIMIT $start_from, $per_page_record");
$form_filled = $db->query("SELECT * FROM `acad_year` WHERE `close_acad_year` != 1");
$form_check = mysqli_fetch_assoc($form_filled);

?>
<br>
<div class="container-fluid mt-5">
    <div class="grid">
        <section>
            <div class="col">
                <div class="container">
                    <div class="col-md-6">
                        <h2 class="text-secondary">School enrollment</h2>
                        <p>Register your students on the currently opened academic
                            admission year.To enroll a student in a different academic
                            year, re-open the perticular admission date.</p>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="text-secondary text-center">Register </h3>
                            <form action="enroll.php" method="post">
                                <?php include('register-stud.php'); ?>
                                <div class="col-md-12 mt-2 p-2">
                                    <select name="acad_year" id="acad_year" aria-placeholder="Select an academic year" class="form-control form-control-sm">
                                        <option value="">Select an academic year</option>
                                        <?php while ($acad_year_res = mysqli_fetch_assoc($acad_year_query)) : ?>
                                            <option value="<?= $acad_year_res['acad_year'] ?>">
                                                Academic year <?= year_format($acad_year_res['acad_year']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <?php if ($form_check != NULL) : ?>
                                    <div class="col-md-12 p-2">
                                        <input type="number" name="snumber" id="snumber" class="form-control form-control-sm" placeholder="Assign student identification number">
                                    </div>
                                    <div class="col-md-12 p-2">
                                        <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Student full name as it's on the documents">
                                    </div>
                                    <div class="col-md-12 p-2">
                                        <input type="text" name="pname" id="pname" class="form-control form-control-sm" placeholder="Parent's name (either of the parent)">
                                    </div>
                                    <div class="col-md-12 p-2">
                                        <input type="tel" name="mobile" id="mobile" class="form-control form-control-sm" placeholder="Parent's mobile number">
                                        <small>Enter mobile number including the country e.g. <span class="fst-bold">+220</span></small>
                                    </div>
                                    <div class="d-grid gap-2 p-2">
                                        <button name="submit_enroll" class="btn btn-outline-dark" type="submit">Enroll</button>
                                    </div>
                                <?php else : ?>
                                    <p class="text-secondary p-2">Admission was closed, kindly check on the authorities to re-open it</p>
                                <?php endif; ?>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-secondary text-center">Enrolled Students</h3>
                            <div class="card mx-2">
                                <table class="table table-striped table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">SN#</th>
                                            <th scope="col">Full name</th>
                                            <th scope="col">Enrolled year</th>
                                            <th scope="col">Parent mobile</th>
                                            <th scope="col"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($enroll_stud = mysqli_fetch_assoc($enroll_stud_query)) : ?>
                                            <tr>
                                                <th scope="row"><?= 'SN' . $enroll_stud['stud_id'] ?></th>
                                                <td><?= $enroll_stud['stud_name'] ?></td>
                                                <td class="text-end"><?= year_format($enroll_stud['stud_enroll_yr']) ?></td>
                                                <td class="text-end"><?= $enroll_stud['stud_parent_mobile'] ?></td>
                                                <td>
                                                    <?php if ($enroll_stud['health_relate_problem'] == EMPTY_VALUE) { ?>
                                                        <a href="sec-data.php?complete=<?= $enroll_stud['stud_id']; ?>" class="mx-1 btn btn-outline-warning btn-sm">contiune</a>
                                                    <?php }
                                                    if ($enroll_stud['stud_prof_photo_url'] == EMPTY_VALUE) { ?>
                                                        <a href="file-profile.php?complete=<?= $enroll_stud['stud_id'] ?>" class="btn btn-outline-primary btn-sm">Upload</a>
                                                    <?php }
                                                    if ($enroll_stud['enroll_done'] == IS_DONE) { ?>
                                                        <a href="file-profile.php?complete=<?= $enroll_stud['stud_id']; ?>" class="btn btn-outline-success btn-sm">View</a>
                                                    <?php } ?>
                                                </td>
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
                                                <a class="page-link" href="enroll.php?page=<?= ($page - 1) ?>" tabindex="-1">Previous</a>
                                            <?php endif; ?>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <?php if ($i == $page) : ?>
                                                <li class="page-item"><a class="page-link" href="enroll.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php else : ?>
                                                <li class="page-item"><a class="page-link" href="enroll.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <?php if ($page < $total_pages) : ?>
                                                <a class="page-link" href="enroll.php?page=<?= ($page + 1) ?>">Next</a>
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