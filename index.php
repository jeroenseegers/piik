<?php

require_once 'config.inc.php';
require_once 'functions.inc.php';
require_once 'omxplayer.class.php';

$sCurrentDirectory = $aConfig['TV_DIR'];
$sShowTitle = '';
$sBaseUrl = '?show=';
$bPlaying = false;
$oPlayer = new OMXPlayer($aConfig);

if (isset($_GET['show']) && !empty($_GET['show']) && is_dir($aConfig['TV_DIR'] . $_GET['show'])) {

    $sShowTitle = $_GET['show'];
    $sCurrentDirectory .= $sShowTitle .'/';
    $sBaseUrl .= $sShowTitle .'&season=';

    if (isset($_GET['season']) && !empty($_GET['season']) && is_dir($sCurrentDirectory . $_GET['season'])) {

        $sSeasonTitle = $_GET['season'];
        $sCurrentDirectory .= $sSeasonTitle .'/';
        $sBaseUrl .= $sSeasonTitle .'&episode=';

        if (isset($_GET['episode']) && !empty($_GET['episode']) && is_file($sCurrentDirectory . $_GET['episode'])) {
            $sEpisodeTitle = $_GET['episode'];
            $sBaseUrl .= $sEpisodeTitle;
            $bPlaying = true;
        }
    }
}

if ($bPlaying) {
    if (isset($_GET['action']) && !empty($_GET['action'])) {
        switch ($_GET['action']) {
            case 'pause':
                $oPlayer->send_key('p');
                echo '<a href="'. $sBaseUrl .'&action=play">Play</a><br />';
                echo '<a href="'. $sBaseUrl .'&action=stop">Stop</a><br />';
                break;

            case 'play':
                $oPlayer->send_key('p');
                echo '<a href="'. $sBaseUrl .'&action=pause">Pause</a><br />';
                echo '<a href="'. $sBaseUrl .'&action=stop">Stop</a><br />';
                break;

            case 'stop':
                $oPlayer->send_key('q');
                header('Location: /');
                break;
        }
    } else {
        $oPlayer->start_playback($sCurrentDirectory . $sEpisodeTitle);
        echo '<a href="'. $sBaseUrl .'&action=pause">Pause</a><br />';
        echo '<a href="'. $sBaseUrl .'&action=stop">Stop</a><br />';
    }
} else {
    foreach (directory_contents_to_array($sCurrentDirectory) as $sTitle) {
        echo '<a href="'. $sBaseUrl . $sTitle .'">'. $sTitle .'</a><br />';
    }
}
