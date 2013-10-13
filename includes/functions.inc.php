<?php

function __autoload($sClassName) {
    if (file_exists('classes/'. strtolower($sClassName) .'.class.php')) {
        require_once 'classes/'. strtolower($sClassName) .'.class.php';
    }
}
