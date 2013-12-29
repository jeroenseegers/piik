<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require_once 'includes/config.inc.php';
require_once 'includes/functions.inc.php';

$sType = isset($_GET['type']) ? $_GET['type'] : 'tv';
$sPageTitle = '';
$sNavigation = generate_navigation($_GET);

switch (strtolower($sType)) {
    case 'tv':
        $oShow              = new TVShow();
        $oShow->sBaseDir    = $aConfig['TV_DIR'];
        $aInfo              = $oShow->get_info($_GET);
        break;
    case 'movie':
        $oMovie             = new Movie();
        $oMovie->sBaseDir   = $aConfig['MOVIE_DIR'];
        $aInfo              = $oMovie->get_info($_GET);
        break;
}

require_once 'templates/header.php';
switch ($aInfo['type']) {
    case 'none':
        if ($sType == 'tv') {
        require_once('templates/showlist.php');
        } else {
        require_once('templates/movielist.php');
        }
        break;

    case 'show':
        require_once('templates/seasonlist.php');
        break;

    case 'season':
        require_once('templates/episodelist.php');
        break;

    case 'episode':
    case 'movie':
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
