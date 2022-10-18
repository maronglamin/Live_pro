<?php
$per_page_record = 15;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $per_page_record;
$inputs = $db->query("SELECT * FROM `enroll_student` WHERE `stud_inputted_by` = '{$auth_user_name}' ORDER BY `stud_id` DESC LIMIT $start_from, $per_page_record");

?>
<h2 class="text-secondary">Enrolment History</h2>
                <p>View the overall students enrolled by your user name to the system</p>
                <div class="card">
                    <div class="container">
                    <?php if(!isset($_GET['view'])):?>
                        <h3 class="text-center text-secondary">Review Your Inputs</h3>
                        <div class="card mx-2 p-2">
                        <table class="table table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SN#</th>
                                <th scope="col">Full name</th>
                                <th scope="col">Inputs status</th>
                                <th scope="col">Approved</th>
                                <th scope="col"></th>

                            </tr>
                            </thead>
                            <tbody>
                                <?php while($input = mysqli_fetch_assoc($inputs)):?>
                                <tr>
                                    <th scope="row"><?= 'SN' . $input['stud_id'] ?></th>
                                    <td><?= $input['stud_name'] ?></td>
                                    <td>
                                    <?php  
                                            if ($input['health_relate_problem'] == EMPTY_VALUE) {
                                                echo 'Input the second phrase registeration';
                                            } elseif($input['stud_prof_photo_url'] == EMPTY_VALUE) {
                                                echo 'Upload the student profile photo';
                                            } else {
                                                echo 'Inputs completed';
                                            }  
                                        ?>
                                    </td>
                                    <td><?=($input['auth_enroll'] == 0)? "Not Aproved": "Approved"?></td>
                                    <td>
                                        <a href="dashboard.php?view=<?=$input['stud_id']?>" class="btn btn-sm btn-outline-dark">View</a>
                                        <?php if ($input['auth_enroll'] == 1):?>
                                        <a href="<?=PROOT?>letter.php?view=<?=$input['stud_id']?>" class="btn btn-sm btn-outline-dark">admission letter</a>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <?php endwhile;?>
                                </tbody>
                            </table>
                            <?php
                                $enroll_stud_query = $db->query("SELECT COUNT(*) FROM `enroll_student` WHERE `stud_inputted_by` = '{$auth_user_name}' ORDER BY `stud_id` DESC");
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
                    <?php else:
                        $stud_id = (int)sanitize($_GET['view']);
                        $stud_data = $db->query("SELECT * FROM `enroll_student` WHERE `stud_id` = '{$stud_id}'");
                        $stud = mysqli_fetch_assoc($stud_data);
                        ?>
                        <h3 class="text-center text-secondary mt-2 mb-2"><?=$stud['stud_name']?></h3>
                        <div class="container">
                            <div class="row">
                                <?php if ($stud['stud_prof_photo_url'] == EMPTY_VALUE):?>
                                    <div class="col-md-12 user-img mb-5">
                                    <h3 class="text-center text-secondary">Profile Photo</h3>
                                    <img src="<?= DEFAULT_USER_ICON ?>" class="user-img d-block m-auto mb-2" />
                                </div>
                                <?php else:?>
                                <div class="col-md-4">
                                    <div class="col-md-12 user-img mt-1 mb-3">
                                        <img src="<?= PROOT . 'app/' . $stud['stud_prof_photo_url'] ?>" class="user-img d-block m-auto mb-2" />
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="col-md-8">
                                    <ul class="list-group">
                                    <li class="list-group-item">Student number: <?='SN'.$stud['stud_id']?></li>
                                    <li class="list-group-item">Student Name: <strong><?=$stud['stud_name']?></strong></li>
                                    <li class="list-group-item">Parent's Mobile: <?=$stud['stud_parent_mobile']?></li>
                                    <li class="list-group-item">
                                        <?php  
                                            if ($stud['health_relate_problem'] == EMPTY_VALUE) {
                                                echo 'Input the second phrase registeration';
                                            } elseif($stud['stud_prof_photo_url'] == EMPTY_VALUE) {
                                                echo 'Upload the student profile photo';
                                            } else {
                                                echo 'Inputs completed';
                                            }  
                                        ?>
                                        </li>
                                    <li class="list-group-item">Complete actions: <br><br>
                                            
                                            <?php if ($stud['health_relate_problem'] == EMPTY_VALUE):?>
                                                <a href="<?=PROOT?>app/users/client/admission/sec-data.php?complete=<?=$stud['stud_id']?>" class="btn btn-sm btn-info">contiune registering</a>
                                            <?php endif;?>
                                            <?php if($stud['stud_prof_photo_url'] == EMPTY_VALUE):?>
                                                <a href="<?=PROOT?>app/users/client/admission/file-profile.php?complete=<?=$stud['stud_id']?>" class="btn btn-sm btn-primary">Upload</a>
                                            <?php else:?>
                                                <h4 class="text-secondary">Registeration completed</h4>
                                            <?php endif;?>
                                    </li>
                                    </ul>
                                    <a href="dashboard.php" class="btn btn-outline-primary mt-4 mb-3">Back</a>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>