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
    <?php include 'includes/navigate.php';?>
    <div class="page-content" id="content">
        <?php include 'includes/header.php';?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="validationCustom01">First name</label>
                                    <input type="text" class="form-control" id="validationCustom01" placeholder="First name" value="" required>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom02">Last name</label>
                                    <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="" required>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustomUsername">Gender</label>
                                    <div class="form-group">
                                        <select class="custom-select" required>
                                            <option value="">Select Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <label for="validationCustom03">Phone Number</label>
                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Phone Number" required>
                                    <div class="invalid-feedback">Please provide a valid phone number.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom04">State</label>
                                    <input type="text" class="form-control" id="validationCustom04" placeholder="State" required>
                                    <div class="invalid-feedback">Please provide a valid state.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom05">Zip</label>
                                    <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" required>
                                    <div class="invalid-feedback">Please provide a valid zip.</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="validationCustom01">Date</label>
                                    <div class="form-group">
                                        <select class="form-control" required>
                                            <option value="">Day</option>
                                            <?php for ($i = 1; $i <= 31; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            } ?>
                                        </select>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control datefield month" required>
                                            <option value="">Month</option>
                                            <?php for ($m = 1; $m <= 12; $m++) {
                                                $mlabel = date('F', mktime(0, 0, 0, $m, 1));
                                                echo '<option value="' . $mlabel . '">' . $mlabel . '</label>';
                                            } ?>
                                        </select>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" required>
                                            <option value="">Years</option>
                                            <?php for ($i = date('Y'); $i < date('Y') + 5; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            } ?>
                                        </select>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom02">Time - AM</label>
                                    <div class="form-group">
                                        <select class="form-control" required>
                                            <option value="0900">09:00</option>
                                            <option value="0930">09:30</option>
                                            <option value="1000">10:00</option>
                                            <option value="1000">10:30</option>
                                            <option value="1000">11:00</option>
                                            <option value="1000">11:30</option>
                                        </select>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom02">Time - PM</label>
                                    <div class="form-group">
                                        <select class="form-control" required>
                                            <option value="0900">12:00</option>
                                            <option value="0930">12:30</option>
                                            <option value="1000">01:00</option>
                                            <option value="1000">01:30</option>
                                            <option value="1000">02:00</option>
                                            <option value="1000">02:30</option>
                                            <option value="1000">03:00</option>
                                            <option value="1000">03:30</option>
                                            <option value="1000">04:00</option>
                                            <option value="1000">04:30</option>
                                        </select>
                                        <div class="invalid-feedback">Invalid</div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Example starter JavaScript for disabling form submissions if there are invalid fields
                                (function() {
                                    'use strict';
                                    window.addEventListener('load', function() {
                                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                        var forms = document.getElementsByClassName('needs-validation');
                                        // Loop over them and prevent submission
                                        var validation = Array.prototype.filter.call(forms, function(form) {
                                            form.addEventListener('submit', function(event) {
                                                if (form.checkValidity() === false) {
                                                    event.preventDefault();
                                                    event.stopPropagation();
                                                }
                                                form.classList.add('was-validated');
                                            }, false);
                                        });
                                    }, false);
                                })();
                            </script>
                            <button type="submit" name="savebtn" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>