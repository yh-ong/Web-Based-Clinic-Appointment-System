<?php

/**
 * Date Time Configuration
 */
date_default_timezone_set("Asia/Kuala_Lumpur");

$dateTime = new DateTime();
$date_created = $dateTime->format('Y-m-d H:i:s');