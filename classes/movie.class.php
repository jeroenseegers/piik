<?php

class Movie {

    private $_sBaseDir      = '';
    private $_sType         = 'none';
    private $_sUrl          = '/';

    private $_sMovieTitle    = '';
    private $_sMovieDir      = '';

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
            case 'movie':
                $aReturn['type']        = 'movie';
                $aReturn['dir']         = $this->_sMovieDir;
                $aReturn['url']         = $this->_sUrl;
                $aReturn['file_list']   = $this->_list_relevant_files();
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
        if (isset($aValues['movie']) && !empty($aValues['movie']) && is_dir($this->_sBaseDir.$aValues['movie'])) {
            $this->_sType       = 'movie';
            $this->_sMovieTitle  = $aValues['movie'];
            $this->_sMovieDir    = $this->_sBaseDir . $this->_sMovieTitle .'/'. $this->_sMovieTitle .'.mkv';
            $this->_sUrl        = '?type=movie&movie='. urlencode($this->_sMovieTitle);
        }

        return $this->_sType;
    }

    private function _list_relevant_files() {
        $aReturn = array();
        
        switch ($this->_sType) {
            case 'none':
                if ($rHandle = opendir($this->_sBaseDir)) {
                    while (false !== ($sTitle = readdir($rHandle))) {
                    if (is_dir($this->_sBaseDir.$sTitle) && !in_array($sTitle, array('.', '..', 'metadata'))) {
                            $aReturn[] = array(
                                'title' => $sTitle,
                                'url'   => $this->_sUrl.'?type=movie&movie='.$sTitle
                            );
                        }
                    }
                    closedir($rHandle);
                }
            break;
            case 'movie':
                if ($rHandle = opendir($this->_sMovieDir)) {
                    while (false !== ($sTitle = readdir($rHandle))) {
                    if (is_dir($this->_sMovieDir.$sTitle) && !in_array($sTitle, array('.', '..', 'metadata'))) {
                            $aReturn[] = array(
                                'title' => $sTitle,
                                'url'   => $this->_sUrl
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
