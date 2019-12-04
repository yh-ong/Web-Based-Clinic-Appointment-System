<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');
ob_start();

// Get Prev & Next Mon
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This Month
    $ym = date('Y-m');
}

// Check format
$timestamp = strtotime($ym, "-01");
if ($timestamp === false) {
    $timestamp = time();
}

// Today
$today = date('Y-m-j', time());

// Calender Title
$cal_title = date('F Y', $timestamp);

// Prev & Next Month Link
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));

// number of day in the month
$day_count = date('t', $timestamp);

// 0:Sun 1:Mon 2:Tue
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

// Create Calender
$weeks = array();
$week = '';

/**
 * Add Event
 */
function getEvents($date = ''){ 
    $eventListHTML = ''; 
    $date = $date?$date:date("Y-m-d"); 
     
    // Fetch events based on the specific date 
    $result = $conn->query("SELECT schedule_title FROM schedule WHERE date_from = '".$date."' AND status = 1"); 
    if($result->num_rows > 0){ 
        $eventListHTML = '<h2>Events on '.date("l, d M Y",strtotime($date)).'</h2>'; 
        $eventListHTML .= '<ul>'; 
        while($row = $result->fetch_assoc()){  
            $eventListHTML .= '<li>'.$row['title'].'</li>'; 
        } 
        $eventListHTML .= '</ul>'; 
    } 
    echo $eventListHTML; 
}


// Add Empty Cell
$week .= str_repeat('<td></td>' . PHP_EOL, $str);
for ($day = 1; $day <= $day_count; $day++, $str++) {
    $date = $ym . '-' . $day;

    if ($today == $date) {
        $week .= '<td class="today">' . $day;
    } else {
        $week .= '<td>' . $day;
    }
    $week .= '</td>' . PHP_EOL;

    // End of the week || end of the month
    if ($str % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }
        $weeks[] = '<tr>' . PHP_EOL . $week . '</tr>' . PHP_EOL;

        // Prepare for new week
        $week = '';
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
    <style>
        .calender {
            padding: 20px;
        }

        .today {
            background: var(--primary-color);
            color: #fff !important;
        }

        .calender th {
            text-align: center;
            height: 30px;
        }

        .calender td {
            text-align: center;
            height: 80px;
        }

        .table-tight>thead>tr>th,
        .table-tight>tbody>tr>th,
        .table-tight>tfoot>tr>th,
        .table-tight>thead>tr>td,
        .table-tight>tbody>tr>td,
        .table-tight>tfoot>tr>td {
            padding-left: 0;
            padding-right: 0;
        }

        .table-tight-vert>thead>tr>th,
        .table-tight-vert>tbody>tr>th,
        .table-tight-vert>tfoot>tr>th,
        .table-tight-vert>thead>tr>td,
        .table-tight-vert>tbody>tr>td,
        .table-tight-vert>tfoot>tr>td {
            padding-top: 0;
            padding-bottom: 0;
        }

        .calender th:nth-of-type(7),
        .calender td:nth-of-type(7) {
            color: blue;
        }

        .calender th:nth-of-type(1),
        .calender td:nth-of-type(1) {
            color: red;
        }

        .calender a .fas {
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12 mt-3">
                <button type="button" class="btn btn-primary btn-sm pull-right px-5" data-toggle="modal" data-target="#modalPassword">Add Schedule</button>
                <!-- Modal -->
                <div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalPasswordTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modalPasswordTitle">Add Schedule</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form name="resetform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inputTitle">Title</label>
                                        <input type="text" name="inputTitle" class="form-control" id="inputTitle" placeholder="Enter Schedule Title">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputDateFrom">From</label>
                                            <input type="text" name="inputDateFrom" class="form-control" id="datefrom" placeholder="Enter Date From">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputDateTo">Until</label>
                                            <input type="text" name="inputDateTo" class="form-control" id="dateto" placeholder="Enter Date Until">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="savebtn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="calender">
                        <h3 class="text-center">
                            <a href="?ym=<?php echo $prev; ?>"><i class="fas fa-chevron-left"></i></a>
                            <span class="mx-5"><?php echo $cal_title; ?></span>
                            <a href="?ym=<?php echo $next; ?>"><i class="fas fa-chevron-right"></i></a></h3>
                        <br>
                        <table class="table table-bordered table-tight">
                            <tr>
                                <th>SUN</th>
                                <th>MON</th>
                                <th>TUE</th>
                                <th>WED</th>
                                <th>THU</th>
                                <th>FRI</th>
                                <th>SAT</th>
                            </tr>
                            <?php
                            foreach ($weeks as $week) {
                                echo $week;
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
    <script type="text/javascript">
        $(function() {
            $('#datefrom').datetimepicker({
                format: 'YYYY-MM-DD',
            });
            $('#dateto').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: false,
            });

            $('#datefrom').on('dp.change', function(e) {
                $('#dateto').data('DateTimePicker').minDate(e.date);
            });
            $('#dateto').on('dp.change', function(e) {
                $('#datefrom').data('DateTimePicker').maxDate(e.date);
            });
        });
    </script>
</body>
</html>
<?php
if (isset($_POST["savebtn"])) {
    $title = $conn->real_escape_string($_POST['inputTitle']);
    $date_from = $conn->real_escape_string($_POST['inputDateFrom']);
    $date_to = $conn->real_escape_string($_POST['inputDateTo']);
    $status = 1;

    $query = "INSERT INTO schedule (schedule_title, date_from, date_to, status, clinic_id) VALUES ('" . $title . "', '" . $date_from . "','" . $date_to . "', '" . $status . "', '" . $clinic_row['clinic_id'] . "')";
    if (mysqli_query($conn, $query)) {
        header("Refresh:0");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    ob_end_clean();
    mysqli_close($conn);
}
?>