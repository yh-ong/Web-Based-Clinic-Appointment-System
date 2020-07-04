<?php
// Clinic
$HOME_PAGE = "index.php";
$BRAND_NAME = "Clinic ME";
$PATH = "doclab/doctor";

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
        $CURRENT_PAGE = "Patient Profile";
        $CURRENT_PATH = "View Patient";
        $PAGE_TITLE = "Patient | $BRAND_NAME";
        break;
    
    // Doctor
    case '/'.$PATH.'/doctor.php':
        $CURRENT_PAGE = "Doctor Profile";
        $CURRENT_PATH = "Doctor";
        $PAGE_TITLE = "Doctor | $BRAND_NAME";
        break;
    case '/'.$PATH.'/doctor-edit.php':
        $CURRENT_PAGE = "Edit Profile";
        $CURRENT_PATH = "Doctor";
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
    
    case '/'.$PATH.'/clinic.php':
        $CURRENT_PAGE = "Clinic";
        $CURRENT_PATH = "";
        $PAGE_TITLE = "Clinic | $BRAND_NAME";
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

    case '/'.$PATH.'/treatment.php':
        $CURRENT_PAGE = "Treatment";
        $CURRENT_PATH = "Treatment";
        $PAGE_TITLE = "Treatment | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/report.php':
        $CURRENT_PAGE = "Report";
        $CURRENT_PATH = "Report";
        $PAGE_TITLE = "Report | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/review.php':
        $CURRENT_PAGE = "Review";
        $CURRENT_PATH = "Review";
        $PAGE_TITLE = "Review | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/password.php':
        $CURRENT_PAGE = "Reset Password";
        $CURRENT_PATH = "Reset Password";
        $PAGE_TITLE = "Reset Password | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/reset.php':
        $CURRENT_PAGE = "Reset Password";
        $CURRENT_PATH = "Reset Password";
        $PAGE_TITLE = "Reset Password | $BRAND_NAME";
        break;
    
    case '/'.$PATH.'/activate.php':
        $CURRENT_PAGE = "Activate Doctor Account";
        $CURRENT_PATH = "Activate Doctor Account";
        $PAGE_TITLE = "Activate Doctor Account | $BRAND_NAME";
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