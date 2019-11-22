<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');
ob_start();
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
                        <form name="announce_frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <!-- <label for="inputTitle">Title</label> -->
                                <input type="text" name="inputTitle" class="form-control form-control-sm" id="inputTitle" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="inputContent" id="inputContent" rows="3" placeholder="New Announcement"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm px-5 pull-right" name="postbtn">Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        function time_elapsed_string($datetime, $full = false)
        {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }

        $table_result = mysqli_query($conn, "SELECT * FROM announcement WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
        $count = mysqli_num_rows($table_result);
        if ($count == 0) {
            print '<div class="card text-center"><div class="card-body"><h6>No Results Available</h6></div></div>';
        } else {
            while ($table_row = mysqli_fetch_assoc($table_result)) {
                echo '<div class="card">
                <div class="card-header">
                    <div class="d-flex w-100 justify-content-between">
                        <span>' . $table_row["ann_title"] . '</span>
                        <small>' . time_elapsed_string($table_row['date_created']) . '</small>
                    </div>
                </div>
                <div class="card-body">
                    ' . $table_row["ann_content"] . '
                </div>
            </div>';
            }
        }
        ?>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
</body>

</html>
<?php
if (isset($_POST["postbtn"])) {
    $title = $conn->real_escape_string($_POST['inputTitle']);
    $content = $conn->real_escape_string($_POST['inputContent']);

    $query = "INSERT INTO announcement (ann_title, ann_content, date_created, clinic_id) VALUES ('" . $title . "', '" . $content . "','" . $date_created . "', '" . $clinic_row['clinic_id'] . "')";
    if (mysqli_query($conn, $query)) {
        header('Location: announcement.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    ob_end_clean();
    mysqli_close($conn);
}
?>