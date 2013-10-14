<?php

function __autoload($sClassName) {
    if (file_exists('classes/'. strtolower($sClassName) .'.class.php')) {
        require_once 'classes/'. strtolower($sClassName) .'.class.php';
    }
}

function generate_navigation($aParts) {
    $sReturn = '<li>Home</li>';

    if (!empty($aParts)) {
        if (isset($aParts['show']) && !empty($aParts['show'])) {
            $sReturn = '<li><a href="/">Home</a></li>';
            if (isset($aParts['season']) && !empty($aParts['season'])) {
                $sReturn .= '<li><a href="/?show='. urlencode($aParts['show']) .'">'. $aParts['show'] .'</a></li>';
                if (isset($aParts['episode']) && !empty($aParts['episode'])) {
                    $sReturn .= '<li><a href="/?show='. urlencode($aParts['show']) .'&season='. urlencode($aParts['season']) .'">'. $aParts['season'] .'</a></li>';
                } else {
                    $sReturn .= '<li>'. $aParts['season'] .'</li>';
                }
            } else {
                $sReturn .= '<li>'. $aParts['show'] .'</li>';
            }
        }
    }

    return $sReturn;
}
