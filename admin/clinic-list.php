<?php
require_once("includes/dbconnection.php");

include("includes/session.php");
include("includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/styles.php';?>
</head>

<body>
    <?php include 'includes/navigate.php'; ?>
    <div class="page-content" id="content">
        <?php include 'includes/header.php';?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <h5 class="card-title mr-auto">Clinics List</h5>
                        </div>
                        <div class="card-inner">
                            <!-- Datatable -->
                            <div class="data-tables">
                                <table id="datatable" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Clinic ID #</th>
                                            <th>Clinic Name</th>
                                            <th>Phone Number</th>
                                            <th>Date Added</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $table_result = mysqli_query($conn, "SELECT * FROM clinics");
                                        while ($table_row = mysqli_fetch_assoc($table_result)) {
                                            $id = $table_row["clinic_id"];
                                            $encrypt_id = urlencode(base64_encode($id));
                                        ?>
                                        <tr>
                                            <td><?php echo $table_row["clinic_id"]; ?></td>
                                            <td><?php echo $table_row["clinic_name"];?></td>
                                            <td><?php echo $table_row["clinic_contact"];?></td>
                                            <td><?php echo $table_row["date_created"];?></td>
                                            <td>
                                                <?php if ($table_row["clinic_status"] == "Approved") {
                                                    echo '<span class="badge badge-success">Approved</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">Not Approve</span>';
                                                }?>
                                            </td>
                                            <td>
                                                <a href="clinic-view.php?cid=<?php echo $encrypt_id;?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                                                <a href="clinic-edit.php?cid=<?php echo $encrypt_id;?>" class="btn btn-sm btn-secondary"><i class="fa fa-pen"></i> Edit</a>
                                                <a href="clinic-view.php" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Clinic ID #</th>
                                            <th>Clinic Name</th>
                                            <th>Phone Number</th>
                                            <th>Date Added</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- End Datatable -->
                        </div>
                    </div>
                </div>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
    </div>

    <?php include 'includes/footer.php';?>
</body>
</html>