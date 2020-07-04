<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div id="datepicker"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Datatable -->
                        <?php
                        function headerTable()
                        {
                            $header = array("App ID #", "Patient", "App Date", "Time", "Treatment Type", "Confirmation", "Action");
                            $arrlen = count($header);
                            for ($i = 0; $i < $arrlen; $i++) {
                                echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
                            }
                        }
                        ?>
                        <div class="data-tables table-responsive">
                            <table id="datatable" class="table nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <?php headerTable(); ?>
                                    </tr>
                                </thead>
                                <tbody id="responsecontainer"></tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <?php headerTable(); ?>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>
                        <!-- End Datatable -->
                    </div>
                </div>
            </div>
        </div> <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
    <script>
        $(document).ready(function() {
            $('button[name="checkbtn"]').click(function() {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-successful');
                $(this).html('<i class="fas fa-plane-arrival mr-3"></i>Arrive');
            });
        });
    </script>
    <script type="text/javascript">
		$(function() {
			$('#datepicker').datetimepicker({
				inline: true,
				minDate: '<?= $current_date ?>',
				format: 'YYY-MM-DD',
			});
		}).on('dp.change', function(event) {
			var formatted = event.date.format('YYYY-MM-DD');
			loadData(formatted,  <?= $clinic_row['clinic_id'] ?>);
		});

		function loadData(formatted, id) {
			$.ajax({
				type: "POST",
				data: {
					date: formatted,
					id: id,
				},
				url: 'loadAppointment.php',
				dateType: "html",
				success: function(response) {
					$("#responsecontainer").html(response);
				}
			});
		}
    </script>
    <script>
        function updateId(id)
        {
            $.ajax({
                type: "POST",
                data: {
                    id: id
                },
                url: 'updateArrive.php',
                success: function(data) {
                    console.log(data);
                    location.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
</body>

</html>