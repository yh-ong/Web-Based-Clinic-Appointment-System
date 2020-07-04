<?php
// Clinic
$HOME_PAGE = "index.php";
$BRAND_NAME = "Clinic ME";
$PATH = "doclab/clinic";

switch ($_SERVER["SCRIPT_NAME"]) {
    case '/'.$PATH.'/login.php':
        $CURRENT_PAGE = "Login";
        $CURRENT_PATH = "Login";
        $PAGE_TITLE = "Login | $BRAND_NAME";
        break;
    
    // Patient
    case '/'.$PATH.'/patient-list.php':
        $CURRENT_PAGE = "Patient List";
        $CURRENT_PATH = "Patient List";
        $PAGE_TITLE = "Patient | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/patient-add.php':
        $CURRENT_PAGE = "Add Patient";
        $CURRENT_PATH = "Add Patient";
        $PAGE_TITLE = "Patient | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/patient-view.php':
        $CURRENT_PAGE = "View Patient";
        $CURRENT_PATH = "View Patient";
        $PAGE_TITLE = "Patient | $BRAND_NAME";
        break;
    
    // Doctor
    case '/'.$PATH.'/doctor-list.php':
        $CURRENT_PAGE = "Doctor List";
        $CURRENT_PATH = "Doctor List";
        $PAGE_TITLE = "Doctor | $BRAND_NAME";
        break;

    case '/'.$PATH.'/doctor-add.php':
        $CURRENT_PAGE = "Add Doctor";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Doctor | $BRAND_NAME";
        break;
    
        case '/'.$PATH.'/doctor-view.php':
        $CURRENT_PAGE = "View Doctor";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Doctor | $BRAND_NAME";
        break;

    // Clinic
    case '/'.$PATH.'/clinic-list.php':
        $CURRENT_PAGE = "Clinic List";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Clinic | $BRAND_NAME";
        break;
    case '/'.$PATH.'/clinic-add.php':
        $CURRENT_PAGE = "Add Clinic";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Clinic | $BRAND_NAME";
        break;
    case '/'.$PATH.'/clinic-view.php':
        $CURRENT_PAGE = "View Clinic";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Clinic | $BRAND_NAME";
        break;
    case '/'.$PATH.'/profile-edit.php':
        $CURRENT_PAGE = "Edit Clinic";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Clinic | $BRAND_NAME";
        break;
    case '/'.$PATH.'/profile.php':
        $CURRENT_PAGE = "Clinic Profile";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Profile | $BRAND_NAME";
        break;
    
    // Appointment
    case '/'.$PATH.'/appointment.php':
        $CURRENT_PAGE = "Appointment";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Appointment | $BRAND_NAME";
        break;

    // Schedule
    case '/'.$PATH.'/schedule.php':
        $CURRENT_PAGE = "Schedule";
        $CURRENT_PATH = "Schedule";
        $PAGE_TITLE = "Schedule | $BRAND_NAME";
        break;
    case '/'.$PATH.'/schedule-list.php':
        $CURRENT_PAGE = "Schedule List";
        $CURRENT_PATH = "Schedule";
        $PAGE_TITLE = "Schedule | $BRAND_NAME";
        break;
    case '/'.$PATH.'/schedule-setup.php':
        $CURRENT_PAGE = "Schedule Setup";
        $CURRENT_PATH = "Schedule";
        $PAGE_TITLE = "Schedule | $BRAND_NAME";
        break;
    case '/'.$PATH.'/schedule-edit.php':
        $CURRENT_PAGE = "Schedule Edit";
        $CURRENT_PATH = "Schedule";
        $PAGE_TITLE = "Schedule | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/speciality.php':
        $CURRENT_PAGE = "Speciality";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Speciality | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/language.php':
        $CURRENT_PAGE = "Language";
        $CURRENT_PATH = "Language";
        $PAGE_TITLE = "Language | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/report.php':
        $CURRENT_PAGE = "Report";
        $CURRENT_PATH = "Report";
        $PAGE_TITLE = "Report | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/admin.php':
        $CURRENT_PAGE = "Edit Admin Profile";
        $CURRENT_PATH = "Edit Admin Profile";
        $PAGE_TITLE = "Edit Admin Profile | $BRAND_NAME";
        break;
    
    // Index Page
    default:
        $CURRENT_PAGE = "Dashboard";
        $PAGE_TITLE = "Home | $BRAND_NAME";
        break;
}

define('NAVIGATION', 'layouts/navigate.php');
define('HEADER', 'layouts/nav_header.php');
define('WIDGET', 'layouts/widget.php');