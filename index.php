<?php

require_once 'includes/config.inc.php';
require_once 'includes/functions.inc.php';

$sType = 'tv';
$sPageTitle = '';

switch (strtolower($sType)) {
    default:
        $oShow              = new TVShow();
        $oShow->sBaseDir    = $aConfig['TV_DIR'];
        $aInfo              = $oShow->get_info($_GET);
        break;
}

require_once 'templates/header.php';
switch ($aInfo['type']) {
    case 'none':
    case 'show':
        $aShowList = $aInfo['file_list'];
        require_once('templates/folderlist.php');
        break;

    case 'season':
        $aShowList = $aInfo['file_list'];
        require_once('templates/filelist.php');
        break;

    case 'episode':
        $sAction = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : 'idle';
        switch ($sAction) {
            case 'start':
                $oPlayer = new OMXPlayer($aConfig);
                $oPlayer->start_playback($aInfo['dir']);
                break;

            case 'play':
            case 'pause':
                $oPlayer = new OMXPlayer($aConfig);
                $oPlayer->send_key('p');
                break;

            case 'stop':
                $oPlayer = new OMXPlayer($aConfig);
                $oPlayer->send_key('q');
                break;
        }
        require_once('templates/view.php');
        break;
}
require_once 'templates/footer.php';
