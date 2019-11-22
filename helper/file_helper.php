<?php
function layouts($file) {
    $file = __DIR__.'/../views/layouts/'.$file;
    include $file;
}