<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= CLIENT_DASHBOARD_URL ?>"><span class="text-primary">
                <img src="<?= PROOT ?>app/photos/afang_logo.png" alt="" width="45" height="35" class="d-inline-block align-text-top">
                Yalding</span> <span class="text-warning">School</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($auth_user_role == ADMIN_USER || $auth_user_role == PRINCIPAL_USER):?>
                    <?php if($auth_user_role == PRINCIPAL_USER):?>
                        <a class="nav-link active" aria-current="page" href="<?=ENROLL_STATUS?>">Enrolment Year</a>
                    <?php endif;?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=ENROLLED_STUDENTS?>">Enrolled Students</a>
                    </li>
                <?php endif;?>
                <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li> -->
            </ul>
            <ul class="navbar-nav d-flex">
                <?php if ($auth_user_role == ADMISSION_USER) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Admission
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= CLIENT_ADMISSION_URL ?>">Enroll Students</a></li>
                            <li><a class="dropdown-item" href="<?= CLIENT_CREATE_CLASS_URL ?>">Create Class</a></li>
                            <li><a class="dropdown-item" href="<?= CLIENT_CREATE_SUBJECT_URL ?>">Create School Subject</a></li>
                            <li><a class="dropdown-item" href="<?= CLIENT_SUBJECT_URL ?>">Assign Subject</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($auth_user_role == PRINCIPAL_USER) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Admission
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= CLIENT_ADMISSION_URL ?>">Enrolment</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= LOG_OUT_URL ?>" tabindex="-1">Sign out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>