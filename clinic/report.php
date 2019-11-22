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
                        <form name="report_frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group row">
                                <label for="inputDateFrom" class="col-sm-3 col-form-label text-right">From Date</label>
                                <div class="col-sm-6">
                                    <input type="text" name="inputDateFrom" class="form-control form-control-sm" id="datefrom">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputDateTo" class="col-sm-3 col-form-label text-right">To Date</label>
                                <div class="col-sm-6">
                                    <input type="text" name="inputDateTo" class="form-control form-control-sm" id="dateto">
                                </div>
                            </div>
                            <div class="d-flex justify-content-md-center pt-3">
                                <button type="clear" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear</button>
                                <button type="submit" class="btn btn-primary btn-sm px-5" name="generatebtn">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if (isset($_POST["generatebtn"])) {
            $datefrom = $conn->real_escape_string($_POST['inputDateFrom']);
            $dateto = $conn->real_escape_string($_POST['inputDateTo']);

            $query = "SELECT * FROM appointment WHERE datefrom = '".$datefrom."' AND dateto = '".$dateto."'";
            if (mysqli_query($conn, $query)) {
        ?><div class="result-page">
            <div class="action-btn-group">
                <button type="button" class="btn btn-primary btn-sm px-5" onClick="download();" name="downloadbtn"
                    download><i class="fas fa-download"></i> Download as PDF</button>
                <button type="button" class="btn btn-primary btn-sm px-5" onClick="print();" name="printbtn"><i
                        class="fas fa-print"></i> Print</button>
            </div>
            <div class="card">
                <div class="card-body" id="printContent">
                    <table class="table" border="1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($conn);
                }
                ob_end_clean();
                mysqli_close($conn);
            }
        ?>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
    <script>
        function print() {
            var w = window.open('', '', 'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');
            var html = $("#printContent").html();

            $(w.document.body).html(html);
            w.focus();
            w.print();
            w.close();
        }
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datefrom').datetimepicker({
                format: 'YYYY-MM-DD',
            });
            $('#dateto').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: false,
            });

            $('#datefrom').on('dp.change', function (e) {
                $('#dateto').data('DateTimePicker').minDate(e.date);
            });
            $('#dateto').on('dp.change', function (e) {
                $('#datefrom').data('DateTimePicker').maxDate(e.date);
            });
        });
    </script>
</body>

</html>