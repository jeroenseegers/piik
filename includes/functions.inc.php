<?php

function directory_contents_to_array($sDirectory, $aFilter = array('.', '..')) {
    $aReturn = array();
    
    if ($rHandle = opendir($sDirectory)) {
        while (false !== ($sTitle = readdir($rHandle))) {
            if (!in_array($sTitle, $aFilter)) {
                $aReturn[] = $sTitle;
            }
        }
        closedir($rHandle);
    }

    return $aReturn;
}
