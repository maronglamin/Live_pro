<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
include './../includes.php';

$enroll_class = ((isset($_POST['enroll'])) ? sanitize($_POST['enroll']) : '');

if (isset($_GET['stud'])) {
    $student_id = (int)sanitize($_GET['stud']);

    if (isset($_POST)) {
        $required = ['enroll'];
        foreach ($required as $fields) {
            if ($_POST[$fields] == EMPTY_VALUE) {
                $errors[] .= 'Please select class.';
                break;
            }
        }
        if (!empty($errors)) {
            redirect('file-profile.php?complete='. $student_id);
            echo display_errors($errors);
        } else {
            $db->query("UPDATE `enroll_student` SET `enroll_class` = '{$enroll_class}' WHERE `stud_id` = '{$student_id}'"); 
            redirect('file-profile.php?complete='. $student_id);
        }
    }
}

if (isset($_GET['complete'])) {
    $student_id = (int)sanitize($_GET['complete']);

    $complete_stud_info = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id}'");
    $complete_val = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id}'");
    $complete_photo = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$student_id}'");
    $photo = mysqli_fetch_assoc($complete_photo);

    $enroll_class = $db->query("SELECT * FROM `school_class`");
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
                                <div class="container">
                                    <div class="row">
                                        <!-- load picture when the enrolled student's picture is not oploaded -->
                                        <?php if ($photo['stud_prof_photo_url'] == EMPTY_VALUE) : ?>
                                            <div class="col-md-12 user-img mb-5">
                                                <h3 class="text-center text-secondary">Profile Photo</h3>
                                                <img src="<?= PROOT ?>app/photos/user-default.png" class="user-img d-block m-auto mb-2" />
                                            </div>
                                            <form action="file-profile.php?complete=<?= $student_id ?>" method="post" enctype="multipart/form-data">
                                                <?php
                                                if (isset($_POST['save_photo'])) {
                                                    $filename =  $student_id . "-" .  $_FILES['photo']['name'];
                                                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                                    $destination = '../../../photos/' . $filename;
                                                    $size = $_FILES['photo']['size'];
                                                    $file = $_FILES['photo']['tmp_name'];
                                                    if (!in_array($extension, ['jpg', 'png', 'jpng', 'JPG', 'PNG', 'JPNG'])) {
                                                        $errors[] .= 'Photo format isn\'t allowed';
                                                    }
                                                    if ($filename == EMPTY_VALUE) {
                                                        $errors[] .= 'No scanned file selected';
                                                    }

                                                    if (!empty($errors)) {
                                                        echo display_errors($errors);
                                                    } else {
                                                        if (move_uploaded_file($file, $destination)) {
                                                            $url = ltrim($destination, '../../../');
                                                            $db->query("UPDATE `enroll_student` SET `stud_prof_photo_url` = '{$url}', `enroll_done` = 1 WHERE `stud_id` = $student_id");
                                                            echo spinner();
                                                            redirect('enroll.php?complete=' . $student_id);
                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="mb-2">
                                                    <input type="file" value="Select File" class="form-control form-control" id="photo" name="photo">
                                                </div>
                                                <button type="submit" name="save_photo" class="btn btn-primary mb-5">Upload File</button>
                                                <a href="enroll.php" name="save_photo" class="btn btn-danger mb-5">Cancel</a>
                                            </form>
                                        <?php else : ?>
                                            <!-- load the picture from the database -->
                                            <?php while ($stud_prof_photo = mysqli_fetch_assoc($complete_stud_info)) : ?>
                                                <div class="col-md-12 user-img mt-1 mb-3">
                                                    <h3 class="text-center text-secondary"><?= $stud_prof_photo['stud_name'] ?></h3>
                                                    <img src="<?= PROOT . 'app/' . $stud_prof_photo['stud_prof_photo_url'] ?>" class="user-img d-block m-auto mb-2" />
                                                </div>
                                                <div class="mt-5 text-end">
                                                    <a href="enroll.php" class="btn btn-outline-dark mt-5">Back</a>
                                                </div>
                                                <?php if ($stud_prof_photo['enroll_class'] == EMPTY_VALUE):?>
                                                <form action="file-profile.php?stud=<?=$stud_prof_photo['stud_id']?>" method="post">
                                                    <h3 class="text-center text-secondary">Enroll into a CLASS</h3>
                                                    <div class="mt-2">
                                                        <select name="enroll" id="enroll" class="form-control form-control-sm">
                                                            <option value="">Select Enroll class</option>
                                                            <?php while($class = mysqli_fetch_assoc($enroll_class)):?>
                                                            <option value="<?=$class['class_id']?>"><?=$class['class_name']?></option>
                                                            <?php endwhile;?>
                                                        </select>
                                                    </div>
                                                    <div class="mt-2 mb-3">
                                                        <button type="submit" class="btn btn-sm btn-outline-dark">Enroll</button>
                                                    </div>
                                                </form>
                                                <?php else:?>
                                                    <h3 class="text-secondary text-center"><?=$stud_prof_photo['stud_name']?> has been enrolled to a class</h3>
                                                <?php endif;?>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3 class="text-center text-secondary mt-1">Verified Student Info</h3>
                                <?php while ($stud_info = mysqli_fetch_assoc($complete_val)) : ?>
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
                </div>
            </section>
        </div>
    </div>

<?php }
