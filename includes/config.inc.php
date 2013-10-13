<?php

$aConfig = array();

// The full path to your TV shows
$aConfig['TV_DIR']          = '';
// The full path to your movies
$aConfig['MOVIE_DIR']       = '';

/******************************************************
 * DO NOT EDIT BELOW THIS LINE
 *****************************************************/

// The full path to the FIFO
$aConfig['FIFO']            = '/tmp/omxfifo';
// The full path to the startscript
$aConfig['START_SCRIPT']    = dirname(__FILE__) .'/scripts/start';

if (!is_dir($aConfig['TV_DIR'])) {
    die('The TV dir "'. $aConfig['TV_DIR'] .'" does not exist.');
}

if (!is_dir($aConfig['MOVIE_DIR'])) {
    die('The movie dir "'. $aConfig['MOVIE_DIR'] .'" does not exist.');
}
