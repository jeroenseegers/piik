<?php

class TVShow {

    private $_sBaseDir      = '';
    private $_sType         = 'none';
    private $_sUrl          = '/';

    private $_sShowTitle    = '';
    private $_sShowDir      = '';

    private $_sSeason       = '';
    private $_sSeasonDir    = '';

    private $_sEpisodeTitle = '';
    private $_sEpisodeFile  = '';

    private $_aFilter       = array('mkv');

    public function __construct() {}

    public function get_info($aValues) {
        $aReturn = array(
            'type'      => 'none',
            'dir'       => $this->_sBaseDir,
            'url'       => '',
            'file_list' => $this->_list_relevant_files()
        );

        switch ($this->_get_requested_type($aValues)) {
            case 'show':
                $aReturn['type']        = 'show';
                $aReturn['dir']         = $this->_sShowDir;
                $aReturn['url']         = $this->_sUrl;
                $aReturn['file_list']   = $this->_list_relevant_files();
                break;

            case 'season':
                $aReturn['type']        = 'season';
                $aReturn['dir']         = $this->_sSeasonDir;
                $aReturn['url']         = $this->_sUrl;
                $aReturn['file_list']   = $this->_list_relevant_files();
                break;

            case 'episode':
                $aReturn['type']        = 'episode';
                $aReturn['url']         = $this->_sUrl;
                $aReturn['dir']         = $this->_sEpisodeFile;
                $aReturn['file_list']   = array();
                break;
        }
        
        return $aReturn;
    }

    public function __set($sKey, $vValue) {
        switch ($sKey) {
            case 'sBaseDir':
                if (is_dir($vValue)) {
                    $this->_sBaseDir = $vValue;
                } else {
                    throw new Exception('"'. $vValue .'" is not a valid directory.');
                }
                break;
        }
    }

    private function _get_requested_type($aValues) {
        if (isset($aValues['show']) && !empty($aValues['show']) && is_dir($this->_sBaseDir.$aValues['show'])) {
            $this->_sType       = 'show';
            $this->_sShowTitle  = $aValues['show'];
            $this->_sShowDir    = $this->_sBaseDir . $this->_sShowTitle .'/';
            $this->_sUrl        = '?show='. urlencode($this->_sShowTitle);
        }

        if (isset($aValues['season']) && !empty($aValues['season']) && is_dir($this->_sShowDir.$aValues['season'])) {
            $this->_sType       = 'season';
            $this->_sSeason     = $aValues['season'];
            $this->_sSeasonDir  = $this->_sShowDir . $this->_sSeason .'/';
            $this->_sUrl        .= '&season='. urlencode($this->_sSeason);
        }

        if (isset($aValues['episode']) && !empty($aValues['episode']) && file_exists($this->_sSeasonDir.$aValues['episode'])) {
            $this->_sType           = 'episode';
            $this->_sEpisodeTitle   = $aValues['episode'];
            $this->_sEpisodeFile    = $this->_sSeasonDir . $this->_sEpisodeTitle;
            $this->_sUrl            .= '&episode='. urlencode($this->_sEpisodeTitle);
        }

        return $this->_sType;
    }

    private function _list_relevant_files() {
        $aReturn = array();
        
        switch ($this->_sType) {
            case 'show':
                if ($rHandle = opendir($this->_sShowDir)) {
                    while (false !== ($sTitle = readdir($rHandle))) {
                    if (is_dir($this->_sShowDir.$sTitle) && !in_array($sTitle, array('.', '..', 'metadata'))) {
                            $aReturn[] = array(
                                'title' => $sTitle,
                                'url'   => $this->_sUrl .'&season='. urlencode($sTitle)
                            );
                        }
                    }
                    closedir($rHandle);
                }
            break;

            case 'season':
                if ($rHandle = opendir($this->_sSeasonDir)) {
                    while (false !== ($sTitle = readdir($rHandle))) {
                        if (in_array(strtolower(substr($sTitle, strrpos($sTitle, '.')+1)), $this->_aFilter)) {
                            $aReturn[] = array(
                                'title' => $sTitle,
                                'url'   => $this->_sUrl .'&episode='. urlencode($sTitle)
                            );
                        }
                    }
                    closedir($rHandle);
                }
            break;

            default:
                if ($rHandle = opendir($this->_sBaseDir)) {
                    while (false !== ($sTitle = readdir($rHandle))) {
                    if (is_dir($this->_sBaseDir.$sTitle) && !in_array($sTitle, array('.', '..', 'metadata'))) {
                            $aReturn[] = array(
                                'title' => $sTitle,
                                'url'   => $this->_sUrl .'?show='. urlencode($sTitle)
                            );
                        }
                    }
                    closedir($rHandle);
                }
                break;
        }

        return $aReturn;
    }

}
