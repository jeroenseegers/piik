<?php

if (isset($_GET['image']) && !empty($_GET['image']) && file_exists($_GET['image'])) {
    if (is_readable($_GET['image'])) {
        $info = getimagesize($_GET['image']);
        if ($info !== FALSE) {
            header("Content-type: {$info['mime']}");
            readfile($_GET['image']);
            exit();
        }
    }
}
