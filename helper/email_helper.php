<?php
/*
 * Send Email
 */
if (!function_exists('send_email')) {
    function send_mail($recipient, $subject, $message) {
        return mail($recipient, $subject, $message);
    }
}