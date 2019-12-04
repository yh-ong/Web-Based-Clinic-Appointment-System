<?php 
require_once("includes/dbconnection.php");

include("includes/session.php");
include("includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $PAGE_TITLE; ?></title>
    <?php include 'includes/styles.php'; ?>
</head>

<body>
    <?php include 'includes/navigate.php'; ?>
    <!-- Page content holder -->
    <div class="page-content" id="content">
        <?php include 'includes/header.php';?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <form name="add_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="d-flex">
                                <input type="text" name="add_speciality" class="form-control mr-2" value="" placeholder="Add Speciality">
                                <button class="btn btn-primary col-3 ml-auto" type="submit" name="savebtn" id="button-addon2">Add</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <!-- Datatable -->
                        <div class="data-tables">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Speciality ID #</th>
                                        <th>Speciality Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $table_result = mysqli_query($conn, "SELECT * FROM speciality");
                                    while ($table_row = mysqli_fetch_assoc($table_result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $table_row["speciality_id"]; ?></td>
                                            <td><?php echo $table_row["speciality_name"]; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-modal<?php echo $table_row["speciality_id"]; ?>"><i class="fa fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="edit-modal<?php echo $table_row["speciality_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalCenterTitle">Edit Speciality</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form name="update_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                        <div class="modal-body">
                                                            <small class="form-text text-muted">ID #<?php echo $table_row["speciality_id"]; ?></small>
                                                            <input type="hidden" name="speciality_id" value="<?php echo $table_row["speciality_id"]; ?>">
                                                            <input type="text" name="update_speciality" class="form-control" value="<?php echo $table_row["speciality_name"]; ?>">
                                                            <small class="form-text text-muted">Previous Name: <?php echo $table_row["speciality_name"]; ?></small>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="updatebtn" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Speciality ID #</th>
                                        <th>Speciality Name</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- End Datatable -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

<?php
$current_link = htmlspecialchars($_SERVER["PHP_SELF"]);
// ADD
if(isset($_POST["savebtn"])) {
    $add_speciality = $_POST["add_speciality"];
    $sql = "INSERT INTO speciality (speciality_name) VALUES ('" . $add_speciality . "')";
    $sqlbackup = "INSERT INTO speciality_backup (speciality_name) VALUES ('" . $add_speciality . "')";

    if (!$result = $conn->query($sql)) {
        ?><script>Swal.fire("Error", "Running the query <?php echo $conn->error; ?>", "error")</script><?php
    } else {
        echo "<script>Swal.fire({ title: 'Successful!', text: '$add_speciality Has Been Added', type: 'success' }).then(function() { location.href = '$current_link'; });</script>";
    }
}

// UPDATE
if (isset($_POST["updatebtn"])) {
    $id = $_POST["speciality_id"];
    $update = $_POST["update_speciality"];
    $sql = "UPDATE speciality SET speciality_name = '" . $update . "' WHERE speciality_id = '" . $id . "'";

    if (!$result = $conn->query($sql)) {
        ?><script>Swal.fire("Error", "Running the query <?php echo $conn->error; ?>", "error")</script><?php
    } else {
        echo "<script>Swal.fire({ title: 'Successful!', text: '$update Has Been Updated', type: 'success' }).then(function() { location.href = '$current_link'; });</script>";
    }
}

// DELETE
if (isset($_POST["deletebtn"])) {
    $id = $_POST["speciality_id"];
    $sql = "DELETE FROM speciality WHERE speciality_id = '" . $id . "'";

    if (!$result = $conn->query($sql)) {
        ?><script>Swal.fire("Error", "Running the query <?php echo $conn->error; ?>", "error")</script><?php
    } else {
        echo "<script>Swal.fire({ title: 'Successful!', text: 'Has Been Deleted', type: 'success' }).then(function() { location.href = '$current_link'; });</script>";
    }
}
?>