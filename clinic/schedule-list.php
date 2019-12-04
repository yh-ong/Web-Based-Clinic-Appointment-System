<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
    <script>
        $(document).ready(function() {
            let error = "is-invalid";
            let require = "Please fill out this field";

            $('#dateto').on('keyup blur', function() {
                var input = $('#dateto').val();
                if (input == '') {
                    $(this).addClass(error);
                    $('#minuteterror').text(require);
                } else if ($.isNumeric(input)) {
                    $(this).removeClass(error);
                    $('#minuteterror').empty();
                    $(this).addClass('is-valid');
                } else {
                    $(this).addClass(error);
                    $('#minuteterror').text('Only number is valid');
                }
            });
        })
    </script>
</head>

<body>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <div class="card">
                    <div class="card-body">
                        <!-- Datatable -->
                        <?php
                        function headerTable()
                        {
                            $header = array("Doctor", "Start Time", "End Time", "Consultation Time", "Day", "Statis", "Action");
                            $arrlen = count($header);
                            for ($i = 0; $i < $arrlen; $i++) {
                                echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
                            }
                        }
                        ?>
                        <div class="data-tables">
                            <table id="datatable" class="table table-responsive-lg" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <?php headerTable(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tlist = $conn->query("SELECT * FROM schedule");
                                    while ($trow = $tlist->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $trow["schedule_title"]; ?></td>
                                            <td><?= $trow["start_time"]; ?></td>
                                            <td><?= $trow["end_time"]; ?></td>
                                            <td><?= $trow["consultation_time"]; ?> per mins</td>
                                            <td><?= $trow["day"]; ?></td>
                                            <td>
                                                <?php if ($trow["status"] == 1) {
                                                        echo '<span class="badge badge-success px-3 py-1">Active</span></td>';
                                                    } else {
                                                        echo '<span class="badge badge-warning px-3 py-1">Inactive</span></td>';
                                                    }
                                                    ?>
                                            <td>
                                                <button data-toggle="modal" data-target="#edit_modal_scheduleid<?= $trow["schedule_id"]; ?>" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i> Edit</button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="edit_modal_scheduleid<?= $trow["schedule_id"]; ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Schedule</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form name="report_frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                        <div class="modal-body">
                                                            <?php echo display_error(); ?>
                                                            <div class="form-group row">
                                                                <label for="inputDoctor" class="col-sm-3 col-form-label text-right">Select Dortor</label>
                                                                <div class="col-sm-6">
                                                                    <select name="inputDoctor" class="form-control form-control-sm" id="inputDoctor">
                                                                        <option value="">Choose</option>
                                                                        <?php
                                                                            $tresult2 = mysqli_query($conn, "SELECT * FROM doctors WHERE clinic_id = " . $clinic_row['clinic_id'] . " ");
                                                                            while ($trow2 = mysqli_fetch_assoc($tresult2)) {
                                                                                if ($trow2["doctor_id"] == $trow["doctor_id"]) {
                                                                                    $selected = "selected";
                                                                                } else {
                                                                                    $selected = "";
                                                                                }
                                                                                echo '<option value="' . $trow2["doctor_id"] . '" ' . $selected . '>' . $trow2["doctor_lastname"] . ' ' . $trow2["doctor_firstname"] . '</option>' . PHP_EOL;
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
                                                                            $dayitem = array("Monday", "Tuesday", "Wednesday", "Thurday", "Friday", "Saturday", "Sunday");
                                                                            foreach ($dayitem as $daylist) {
                                                                                if (strtolower($daylist) == strtolower($trow["day"])) {
                                                                                    $selected1 = "selected";
                                                                                } else {
                                                                                    $selected1 = "";
                                                                                }
                                                                                echo '<option value="' . $daylist . '" ' . $selected1 . '>' . $daylist . '</option>' . PHP_EOL;
                                                                            } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="inputTime" class="col-sm-3 col-form-label text-right">Set Time Range</label>
                                                                <div class="col-sm-6 input-group">
                                                                    <input type="text" name="inputTimeFrom" class="form-control form-control-sm timepicker" id="inputTimeFrom" placeholder="From" value="<?= $trow["start_time"] ?>">
                                                                    <input type="text" name="inputTimeTo" class="form-control form-control-sm timepicker" id="inputTimeTo" placeholder="To" value="<?= $trow["end_time"] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="inputMinute" class="col-sm-3 col-form-label text-right">Set Per Patient Time</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text" name="inputMinute" class="form-control form-control-sm" id="dateto" value="<?= $trow["consultation_time"] ?>">
                                                                    <small class="form-text text-muted">You can set only minute</small>
                                                                    <div id="minuteterror" class="invalid-feedback"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="inputStatus" class="col-sm-3 col-form-label text-right">Status</label>
                                                                <div class="col-sm-6">
                                                                    <select type="text" name="inputStatus" class="form-control form-control-sm" id="datefrom" placeholder="From Date">
                                                                        <?php
                                                                            if ($trow["status"] == 1)
                                                                                $selected3 = "selected";
                                                                            else
                                                                                $selected3 = "";
                                                                            ?>
                                                                        <option value="1" <?= $selected3 ?>>Active</option>
                                                                        <option value="0" <?= $selected3 ?>>Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="reset" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear</button>
                                                            <button type="submit" class="btn btn-primary btn-sm px-5" name="submitbtn">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <?php headerTable(); ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- End Datatable -->
                    </div>
                </div>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
    </div>

    <?php include JS_PATH; ?>
    <script type="text/javascript">
        $(function() {
            $('.timepicker').datetimepicker({
                format: 'LT'
            });
        });
    </script>
</body>

</html>