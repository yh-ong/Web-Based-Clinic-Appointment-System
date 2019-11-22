<?php
echo '<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>'. $PAGE_TITLE .'</title>
<link rel="shortcut icon" type="image/png" href="../assets/img/icon/favicon.ico">' . PHP_EOL;

$cssItem = array(
    'bootstrap.min.css',
    'bootstrap-datetimepicker.min.css',
    'dataTables.bootstrap4.min.css',
    'bootstrap-select.min.css',
    'animate.css',
    'themify-icons.css',
    'owl.carousel.min.css',
    'all.min.css',
    'metisMenu.min.css',
    'sweetalert2.min.css',
    'typography.css',
    'default.css',
    'clinic/login.css'
);

foreach ($cssItem as $cssPath) {
    echo '<link rel="stylesheet" href="' . ('../assets/css/' . $cssPath) . '">' . PHP_EOL;
}