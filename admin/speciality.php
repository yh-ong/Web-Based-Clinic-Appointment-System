<?php 
include("../config/autoload.php");
include("includes/session.inc.php");
include("includes/path.inc.php");
$current_link = htmlspecialchars($_SERVER["PHP_SELF"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include CSS_PATH; ?>
    <style>
    .thumbnail {
        border: 1px solid #ddd;
        width: 52px;
        height: 52px;
        margin: auto;
    }
    </style>
</head>

<body>
    <?php include NAVIGATION; ?>
    <!-- Page content holder -->
    <div class="page-content" id="content">
        <?php include HEADER;?>
        <?php
            $errors = array();

            if (isset($_POST['savebtn'])) {
                $add_speciality = escape_input($_POST['inputSpeciality']);
                $filename = $_FILES['inputIcon']['name'];
            
                if (empty($add_speciality)) {
                    array_push($errors, "Speciality is required");
                }

                if (empty($filename)) {
                    array_push($errors, "Icon is required");
                }
            
                if (count($errors) == 0) {

                    if (isset($_FILES["inputIcon"]["name"])) {
                        $allowed =  array('png', 'jpg', 'jpeg');
                        $filename = $_FILES['inputIcon']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            echo "<script>Swal.fire('Oops...','Only can be image!','error')</script>";
                            exit();
                        } else {
                            if (!empty($_FILES['inputIcon']['name'])) {
                                $folderpath = "../uploads/icons" . "/";
                                $path = "../uploads/icons" . "/" . $_FILES['inputIcon']['name'];
                                $image = $_FILES['inputIcon']['name'];
                    
                                if (!file_exists($folderpath)) {
                                    mkdir($folderpath, 0777, true);
                                    move_uploaded_file($_FILES['inputIcon']['tmp_name'], $path);
                                } else {
                                    move_uploaded_file($_FILES['inputIcon']['tmp_name'], $path);
                                }
                            } else {
                                echo "<script>Swal.fire('Oops...','You should select a file to upload!','error')</script>";
                                exit();
                            }
                        }
                    }
                

                    $sql = "INSERT INTO speciality (speciality_name) VALUES ('" . $add_speciality . "')";
                    $sqlbackup = "INSERT INTO speciality_backup (speciality_name) VALUES ('" . $add_speciality . "')";

                    if (!$result = $conn->query($sql)) {
                        ?><script>Swal.fire("Error", "Running the query <?php echo $conn->error; ?>", "error")</script><?php
                    } else {
                        echo "<script>Swal.fire({ title: 'Successful!', text: '$add_speciality Has Been Added', type: 'success' }).then(function() { location.href = '$current_link'; });</script>";
                    }
                }
            }
        ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form name="add_form" class="inline-form" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                            <?php echo display_error(); ?>
                            <div class="form-group row">
								<label for="inputSpeciality" class="col-sm-3 col-form-label text-right">Speciality</label>
								<div class="col-sm-6">
									<input type="text" name="inputSpeciality" id="inputSpeciality" class="form-control form-control-sm">
								</div>
							</div>
                            <div class="form-group row">
								<label for="inputIcon" class="col-sm-3 col-form-label text-right">Icon</label>
								<div class="col-sm-6">
									<input type="file" name="inputIcon" id="inputIcon" accept="image/*" onchange="openFile(event)" class="form-control form-control-sm">
                                </div>
                                <script>
                                    var openFile = function(file) {
                                        var input = file.target;

                                        var reader = new FileReader();
                                        reader.onload = function() {
                                            var dataURL = reader.result;
                                            var output = document.getElementById('output');
                                            output.src = dataURL;
                                        };
                                        reader.readAsDataURL(input.files[0]);
                                    };
                                </script>
                            </div>
                            <div class="form-group row">
                            <label for="inputIcon" class="col-sm-3 col-form-label text-right"></label>
                                <div class="col-sm-6 text-center">
                                    <img src="../assets/img/empty/empty-image.png" id="output" class="img-fluid thumbnail" width="52px">
                                </div>
                            </div>
							<div class="d-flex justify-content-md-center pt-2">
								<button type="reset" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear</button>
								<button type="submit" class="btn btn-primary btn-sm px-5" name="savebtn">Add</button>
							</div>
						</form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <!-- Datatable -->
                        <div class="data-tables">
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Icon</th>
                                        <th>Name</th>
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
                                            <td><img src="../uploads/icons/<?php echo $table_row["speciality_icon"]; ?>" alt="<?php echo $table_row["speciality_icon"]; ?>" width="40px"></td>
                                            <td><?php echo $table_row["speciality_name"]; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-modal<?php echo $table_row["speciality_id"]; ?>"><i class="fa fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletemodal<?php echo $table_row["speciality_id"]; ?>"><i class="fa fa-trash"></i> Delete</button>
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
                                                    <form name="update_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <small class="form-text text-muted">ID #<?php echo $table_row["speciality_id"]; ?></small>
                                                            <input type="hidden" name="speciality_id" value="<?php echo $table_row["speciality_id"]; ?>">
                                                            <input type="text" name="update_speciality" class="form-control" value="<?php echo $table_row["speciality_name"]; ?>">
                                                            <small class="form-text text-muted">Previous Name: <?php echo $table_row["speciality_name"]; ?></small>
                                                            <input type="file" name="inputUpdateIcon" class="form-control" accept="image/*" onchange="iconFile(event)">
                                                            <img src="../uploads/icons/<?= $table_row["speciality_icon"] ?>" id="icon_output" class="img-fluid thumbnail" width="52px">
                                                            <script>
                                                                var iconFile = function(file) {
                                                                    var input = file.target;

                                                                    var reader = new FileReader();
                                                                    reader.onload = function() {
                                                                        var dataURL = reader.result;
                                                                        var output = document.getElementById('icon_output');
                                                                        output.src = dataURL;
                                                                    };
                                                                    reader.readAsDataURL(input.files[0]);
                                                                };
                                                            </script>
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
                                        <div class="modal fade" id="deletemodal<?= $table_row['speciality_id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="border:none;">
                                                        <!-- <h5 class="modal-title" id="deleteModalLabel">Delete</h5> -->
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="speciality_id" value="<?= $table_row['speciality_id'] ?>">
                                                            Are you sure want to delete <strong><?= $table_row['speciality_name'] ?></strong> ?
                                                        </div>
                                                        <div class="modal-footer" style="border:none;">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="deletebtn" class="btn btn-sm btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Icon</th>
                                        <th>Name</th>
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
    <?php include JS_PATH; ?>
</body>
</html>

<?php
$current_link = htmlspecialchars($_SERVER["PHP_SELF"]);
// UPDATE
if (isset($_POST["updatebtn"])) {

    if (isset($_FILES["inputUpdateIcon"]["name"])) {
        $allowed =  array('png', 'jpg', 'jpeg');
        $filename = $_FILES['inputUpdateIcon']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            echo "<script>Swal.fire('Oops...','Only can be image!','error')</script>";
            exit();
        } else {
            if (!empty($_FILES['inputUpdateIcon']['name'])) {
                $folderpath = "../uploads/icons" . "/";
                $path = "../uploads/icons" . "/" . $_FILES['inputUpdateIcon']['name'];
                $image = $_FILES['inputUpdateIcon']['name'];
    
                if (!file_exists($folderpath)) {
                    mkdir($folderpath, 0777, true);
                    move_uploaded_file($_FILES['inputUpdateIcon']['tmp_name'], $path);
                } else {
                    move_uploaded_file($_FILES['inputUpdateIcon']['tmp_name'], $path);
                }
            } else {
                echo "<script>Swal.fire('Oops...','You should select a file to upload!','error')</script>";
                exit();
            }
        }
    }

    $id = $_POST["speciality_id"];
    $update = $_POST["update_speciality"];
    $sql = "UPDATE speciality SET speciality_name = '" . $update . "', speciality_icon = '".$image."' WHERE speciality_id = '" . $id . "'";

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