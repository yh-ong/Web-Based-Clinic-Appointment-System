<div id="preloader">
    <div class="loader"></div>
</div>
<!-- Vertical navbar -->
<div class="navbar-sidebar">
    <div class="vertical-nav bg-white sidebar-shadow" id="sidebar">
        <div class="sidebar-header">
            <a href="#" data-toggle="tooltip" data-placement="bottom" title="" class="logo-src" data-original-title="Clinic"><?php echo $BRAND_NAME?></a>
        </div>
        <!-- Sidebar Inner -->
        <div class="sidebabr-inner">
            <ul class="nav flex-column bg-white mb-0" id="metismenu">
                <!-- Upper -->
                <p class="sidebar-heading px-3 pb-1 mb-0">Main</p>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'index.php') !== FALSE) {echo 'mm-active';} ?>">
                    <a href="index.php" class="nav-link"><i class="fas fa-tachometer-alt mr-3 fa-fw"></i>Dashboard</a>
                </li>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'doctor.php') !== FALSE) {echo 'mm-active';} ?>">
                    <a href="doctor.php" class="nav-link"><i class="fas fa-stethoscope mr-3 fa-fw"></i>Profile</a>
                </li>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'patient-list.php') !== FALSE) {echo 'mm-active';} ?>">
                    <a href="patient-list.php" class="nav-link" ><i class="fas fa-user-injured mr-3 fa-fw"></i>Patients</a>
                </li>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'appointment.php') !== FALSE) {echo 'mm-active';} ?>">
                    <a href="appointment.php" class="nav-link" ><i class="fas fa-calendar-check mr-3 fa-fw"></i>Appointment</a>
                </li>
                <li class="nav-item <?php if (preg_match('/(schedule)/',$_SERVER["REQUEST_URI"]) == TRUE) {echo 'mm-active';} ?>">
                    <a href="#" class="nav-link has-arrow" aria-expanded="false"><i class="fa fa-user-clock mr-3 fa-fw"></i>Schedule</a>
                    <ul class="side-collapse">
                        <a href="sch-list.php" class="nav-link"><i class="far fa-calendar mr-3 fa-fw"></i>Manage Schedule</a>
                        <!-- <a href="schedule-setup.php" class="nav-link"><i class="far fa-calendar-plus mr-3 fa-fw"></i>Schedule Setup</a> -->
                        <!-- <a href="schedule.php" class="nav-link"><i class="far fa-calendar-alt mr-3 fa-fw"></i>View Schedule</a> -->
                    </ul>
                </li>
                <!-- End Upper -->
                <p class="sidebar-heading px-3 pb-1 mb-0">Others</p>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'treatment.php') !== FALSE) {echo 'mm-active';} ?>">
                    <a href="treatment.php" class="nav-link"><i class="fas fa-stream mr-3 fa-fw"></i>Treatment Type</a>
                </li>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'review.php') !== FALSE) {echo 'mm-active';} ?>">
                    <a href="review.php" class="nav-link"><i class="fas fa-star mr-3 fa-fw"></i>Review</a>
                </li>
                <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'report.php') !== FALSE) {echo 'mm-active';} ?>">
                    <a href="report.php" class="nav-link"><i class="fas fa-chart-area mr-3 fa-fw"></i>Report</a>
                </li>
            </ul>
        </div>
        <!-- Sidebar Inner -->
    </div>
</div>
<!-- End vertical navbar -->