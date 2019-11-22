<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');
?><!DOCTYPE html>
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
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <?php headerTable(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $table_result = mysqli_query($conn, "SELECT * FROM schedule");
                                    while ($table_row = mysqli_fetch_assoc($table_result)) {
                                        ?><tr>
                                            <td><?= $table_row["schedule_title"]; ?></td>
                                            <td><?= $table_row["start_time"]; ?></td>
                                            <td><?= $table_row["end_time"]; ?></td>
                                            <td><?= $table_row["consultation_time"]; ?></td>
                                            <td><?= $table_row["day"]; ?></td>
                                            <td>
                                                <?php if ($table_row["status"] == 1) {
                                                    echo '<span class="badge badge-success px-3 py-1">Active</span></td>';
                                                } else {
                                                    echo '<span class="badge badge-warning px-3 py-1">Inactive</span></td>';
                                                }
                                                 ?>
                                            <td>
                                                <a href="schedule-edit.php?docid=<?=$table_row["doctor_id"];?>?day=<?=$table_row["day"];?>" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i> Edit</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
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
</body>

</html>