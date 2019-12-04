<?php
require_once('../config/autoload.php');
require_once('./includes/session.inc.php');
require_once('./includes/path.inc.php');


$schedule_id = $_GET["scheduleid"];
/* $stmt_page = $conn->prepare("SELECT * FROM schedule WHERE schedule_id = ?");
$stmt_page->bind_param("i", $schedule_id);
$stmt_page->execute();
$result = $stmt_page->get_result();
$row = $result->fetch_assoc();
 */

$result = mysqli_query($conn,"SELECT * FROM schedule WHERE schedule_id = '".$schedule_id."' ");
$row = mysqli_fetch_assoc($result);

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor     = escape_input($_POST['inputDoctor']);
    $day  = escape_input($_POST['inputDay']);
    $from    = escape_input($_POST['inputTimeFrom']);
    $to  = escape_input($_POST['inputTimeTo']);
    $min  = escape_input($_POST['inputMinute']);
    $status  = escape_input($_POST['inputStatus']);

    if (empty($doctor)) {
        array_push($errors, "Doctor is required");
    }
    if (empty($day)) {
        array_push($errors, "Day is required");
    }
    if (empty($from)) {
        array_push($errors, "Start Time is required");
    }
    if (empty($to)) {
        array_push($errors, "End Time is required");
    }
    if (empty($min)) {
        array_push($errors, "Minutes is required");
    } else {
        if (!preg_match($regrex['num'], $min)) {
            array_push($errors, "Only can be number");
        }
    }
    if (empty($status)) {
        array_push($errors, "Status is required");
    }

    if (count($errors) == 0)
    {
        /* $stmt = $conn->prepare("UPDATE schedule SET doctor_id = ?, day = ?, start_time = ?, end_time = ?, consultation_time = ?, status = ? ");
        $stmt->bind_param("isssii", $doctor, $day, $from, $to, $min, $status);
        if ($stmt->execute()) {
            
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        $stmt->close(); */
    }

    $sid = $schedule_id;
    header("Location: schedule-edit.php?scheduleid=$sid");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
</head>

<body>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form name="report_frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <?php echo display_error(); ?>
                            <div class="form-group row">
                                <label for="inputDoctor" class="col-sm-3 col-form-label text-right">Select Dortor</label>
                                <div class="col-sm-6">
                                    <select name="inputDoctor" class="form-control form-control-sm" id="inputDoctor">
                                        <option value="">Choose</option>
                                        <?php
                                            $tresult = mysqli_query($conn, "SELECT * FROM doctors WHERE clinic_id = ".$clinic_row['clinic_id']." ");
                                            while ($trow = mysqli_fetch_assoc($tresult)) {
                                                if ($trow["doctor_id"] == $row["doctor_id"]) {
                                                    $selected = "selected";
                                                } else { $selected = ""; }
                                                echo '<option value="'.$trow["doctor_id"].'" '.$selected.'>'.$trow["doctor_lastname"].' '.$trow["doctor_firstname"].'</option>'.PHP_EOL;
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputDay" class="col-sm-3 col-form-label text-right">Select Day</label>
                                <div class="col-sm-6">
                                    <select name="inputDay" class="form-control form-control-sm" id="inputDay">
                                        <?php
                                        $dayitem = array("Monday","Tuesday","Wednesday","Thurday","Friday","Saturday","Sunday");
                                        foreach($dayitem as $daylist) {
                                            if (strtolower($daylist) == strtolower($row["day"])) {
                                                $selected1 = "selected";
                                            } else { $selected1 = ""; }
                                            echo '<option value="'.$daylist.'" '.$selected1.'>'.$daylist.'</option>'.PHP_EOL;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputTime" class="col-sm-3 col-form-label text-right">Set Time Range</label>
                                <div class="col-sm-6 input-group">
                                    <input type="text" name="inputTimeFrom" class="form-control form-control-sm timepicker" id="inputTimeFrom" placeholder="From" value="<?= $row["start_time"] ?>">
                                    <input type="text" name="inputTimeTo" class="form-control form-control-sm timepicker" id="inputTimeTo" placeholder="To" value="<?= $row["end_time"] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputMinute" class="col-sm-3 col-form-label text-right">Set Per Patient Time</label>
                                <div class="col-sm-6">
                                    <input type="text" name="inputMinute" class="form-control form-control-sm" id="dateto" value="<?= $row["consultation_time"] ?>">
                                    <small class="form-text text-muted">You can set only minute</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputStatus" class="col-sm-3 col-form-label text-right">Status</label>
                                <div class="col-sm-6">
                                    <select type="text" name="inputStatus" class="form-control form-control-sm" id="datefrom" placeholder="From Date">
                                        <?php
                                            if ($row["status"] == 1)
                                                $selected3 = "selected";
                                            else
                                                $selected3 = "";
                                        ?>
                                        <option value="1" <?= $selected3 ?>>Active</option>
                                        <option value="0" <?= $selected3 ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-md-center pt-3">
                                <button type="reset" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear</button>
                                <button type="submit" class="btn btn-primary btn-sm px-5" name="submitbtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
    <script type="text/javascript">
        $(function () {
            $('.timepicker').datetimepicker({
                format: 'LT'
            });
        });
    </script>
</body>

</html>