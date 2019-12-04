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
                <div class="card">
                    <div class="card-body">
                        <!-- Datatable -->
                        <div class="data-tables">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Time</th>
                                        <th>Provider</th>
                                        <th>Type</th>
                                        <th>Confirmation</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Unity Butler</td>
                                        <td>9:00 AM</td>
                                        <td>San Francisco</td>
                                        <td>Follow Up Visit</td>
                                        <td><span class="badge badge-pill badge-success mr-1">&#10004;</span>Confirmed</td>
                                        <td>2009/12/09</td>
                                        <td><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</button></td>
                                    </tr>
                                    <tr>
                                        <td>Howard Hatfield</td>
                                        <td>10:00 AM</td>
                                        <td>San Francisco</td>
                                        <td>New Patient</td>
                                        <td><span class="badge badge-pill badge-warning mr-1">&#33;</span>Not Confirmed</td>
                                        <td>2008/12/16</td>
                                        <td><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</button></td>
                                    </tr>
                                    <tr>
                                        <td>Hope Fuentes</td>
                                        <td>12:00 PM</td>
                                        <td>San Francisco</td>
                                        <td>Sick Visit</td>
                                        <td><span class="badge badge-pill badge-success mr-1">&#10004;</span>Confirmed</td>
                                        <td>2010/02/12</td>
                                        <td><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</button></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Time</th>
                                        <th>Provider</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Confirmation</th>
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