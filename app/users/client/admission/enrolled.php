<?php
require_once $_SERVER['DOCUMENT_ROOT'] . './schoolapp/core/init.php';
// include(ROOT . DS . 'nav.php');
if (!is_logged_in()) {
    login_error_redirect(PROOT . "index.php", "Dashboard");
}
include(ROOT . DS . "app" . DS . "components" . DS . "client_nav.php");
if (!($auth_user_role == PRINCIPAL_USER)) {
    login_redirect();
}

$per_page_record = 15;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $per_page_record;
$inputs = $db->query("SELECT * FROM `enroll_student` WHERE `auth_enroll` = 1 ORDER BY `stud_enroll_yr` DESC LIMIT $start_from, $per_page_record");

?>
<br><br>
<div class="container-fluid mt-5">
    <div class="grid">
        <div class="col">
            <div class="container card mt-5">
            <h3 class="text-center text-secondary mb-2">Approve Admission Inputs</h3>
            <div class="card mx-2 p-2">
            <table class="table table-striped table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">Record Number</th>
                    <th scope="col">SN#</th>
                    <th scope="col">Full name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Enrolled Year</th>
                    <th scope="col">Parent's Mobile</th>
                    <th scope="col">Address</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($input = mysqli_fetch_assoc($inputs)):?>
                    <tr>
                        <th scope="row"><?= cap('YS' . $input['stud_id'] . "IB". $input['stud_inputted_by'] . $input['record_id']) ?></th>
                        <th scope="row"><?= 'SN' . $input['stud_id'] ?></th>
                        <td><?= $input['stud_name'] ?></td>
                        <td><?= human_date($input['stud_date_brith']) ?></td>
                        <td><?=year_format($input['stud_enroll_yr'])?></td>
                        <td><?=$input['stud_parent_mobile']?></td>
                        <td><?=$input['stud_address']?></td>
                    </tr>
                    <?php endwhile;?>
                    </tbody>
                </table>
                <?php
                    $enroll_stud_query = $db->query("SELECT COUNT(*) FROM `enroll_student` WHERE `auth_enroll` = 1 ORDER BY `stud_enroll_yr` DESC");
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
                                    <a class="page-link" href="enrolled.php?page=<?= ($page - 1) ?>" tabindex="-1">Previous</a>
                                <?php endif; ?>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <?php if ($i == $page) : ?>
                                    <li class="page-item"><a class="page-link" href="enrolled.php?page=<?= $i ?>"><?= $i ?></a></li>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link" href="enrolled.php?page=<?= $i ?>"><?= $i ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item">
                                <?php if ($page < $total_pages) : ?>
                                    <a class="page-link" href="enrolled.php?page=<?= ($page + 1) ?>">Next</a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>
                    </div>
        </div>
    </div>
</div>