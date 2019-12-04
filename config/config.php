<?php

/**
 * Date Time Configuration
 */
date_default_timezone_set("Asia/Kuala_Lumpur");

$dateTime = new DateTime();
$date_created = $dateTime->format('Y-m-d H:i:s');

$current_date = date('Y-m-d');

$current_time = date("H:i:s");