<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';

if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Enroll");
}
if ($user_data['user_role'] != ADMISSION_USER) {
    login_redirect();
}

include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");
$errors = []; 
$stud_gender = ((isset($_POST['gender'])) ? sanitize($_POST['gender']) : '');
$stud_prev_sch = ((isset($_POST['pschool'])) ? sanitize($_POST['pschool']) : '');
$stud_address = ((isset($_POST['address'])) ? sanitize($_POST['address']) : '');
$stud_place_birth = ((isset($_POST['pbirth'])) ? sanitize($_POST['pbirth']) : '');
$stud_date_birth = ((isset($_POST['date-birth'])) ? sanitize($_POST['date-birth']) : '');
$stud_health = ((isset($_POST['health'])) ? sanitize($_POST['health']) : '');

if (isset($_GET['complete'])) {
    $student_id = (int)sanitize($_GET['complete']);

    $complete_stud_info = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id}'");
    $complete_photo = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id}'");
    $completed = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id}' AND `stud_prev_sch` != NULL AND `health_relate_problem` != NULL");
    $completed_resp = mysqli_fetch_assoc($completed);
    $photo_uploaded = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id}' AND `stud_prof_photo_url` != NULL");
    $photo_resp = mysqli_fetch_assoc($photo_uploaded);
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
                                <h3 class="text-center text-secondary">...Continue Registering</h3>
                                <form action="sec-data.php?complete=<?= $student_id ?>" method="post">
                                    <?php include('register-stud.php'); ?>
                                    <div class="col-md-12 mt-2 p-2">
                                        <select name="gender" id="gender" class="form-control form-control-sm">
                                            <option value="">Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2 p-2">
                                        <input type="text" name="pschool" id="pschool" placeholder="Previously attended school" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-12 mt-2 p-2">
                                        <input type="text" name="address" id="address" placeholder="Address" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-12 mt-2 p-2">
                                        <input type="text" name="pbirth" id="pbirth" placeholder="place of birth" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-12 mt-2 p-2">
                                        <input type="date" name="date-birth" id="date-birth" placeholder="date of birth" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-12 mt-2 p-2">
                                        <textarea name="health" id="health" cols="30" rows="3" class="form-control form-control-sm" placeholder="breif health status of the student"></textarea>
                                    </div>
                                    <div class="d-grid gap-2 p-2">
                                        <button name="save" class="btn btn-outline-dark" type="submit">Save</button>
                                        <a href="enroll.php" class="btn btn-outline-dark">Back</a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <h3 class="text-center text-secondary mt-1">Verified Student Info</h3>
                                <?php while ($stud_info = mysqli_fetch_assoc($complete_stud_info)) : ?>
                                    <ol class="list-group list-group-numbered list-group-flush p-2">
                                        <li class="list-group-item">SN<?= $stud_info['stud_id'] ?> <span class="ps-3"><?= " " . $stud_info['stud_name'] ?></span></li>
                                        <li class="list-group-item"> <span class="fw-bold">Student's Parent name</span><br>
                                            <?= $stud_info['stud_parent_name'] ?>
                                        </li>
                                        <li class="list-group-item"><span class="fw-bold">Student's Parent Mobile number</span><br>
                                            <?= $stud_info['stud_parent_mobile'] ?>

                                        </li>
                                        <li class="list-group-item"> <span class="fw-bold">previously attended school name</span><br>
                                            <?= $stud_info['stud_prev_sch'] ?>
                                        </li>
                                        <li class="list-group-item"> <span class="fw-bold">Address of the student</span><br>
                                            <?= $stud_info['stud_address'] ?>
                                        </li>
                                        <?php if ($stud_info['stud_gender'] == NULL) : ?>
                                            <li class="list-group-item">
                                                <span class="fw-bold">Gender of the student</span>
                                            </li>
                                        <?php else : ?>
                                            <li class="list-group-item"> <span class="fw-bold">Gender of the student</span><br>
                                                <?= (($stud_info['stud_gender']) == 1) ? "Male" : "Female" ?>
                                            </li>
                                        <?php endif; ?>

                                        <li class="list-group-item"><span class="fw-bold">The health constrains of the student</span><br>
                                            <?= $stud_info['health_relate_problem'] ?>
                                        </li>
                                    </ol>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
            </section>

        <?php }
