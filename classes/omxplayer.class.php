<?php

class OMXPlayer {

    private $_sFifo             = '';
    private $_sStartScript      = '';
    private $_aPids             = array();

    public function __construct($aConfig) {
        $this->_sFifo           = $aConfig['FIFO'];
        $this->_sStartScript    = $aConfig['START_SCRIPT'];
    }

    public function start_playback($sVideoFile, $sSubtitleFile = '') {
        // Check if the given videofile exists
        if (empty($sVideoFile) || !file_exists($sVideoFile)) {
            throw new Exception('File "'. $sVideoFile. '" not found.', 404);
        }

        // Create FIFO
        $this->send_key('q');
        posix_mkfifo($this->_sFifo, 0777);

        // Start playback
        shell_exec($this->_sStartScript .' '. escapeshellarg($sVideoFile) .' '. escapeshellarg($this->_sFifo));
    }

    public function send_key($sKey) {
        exec('pgrep omxplayer', $this->_aPids);

        if (!empty($this->_aPids) && is_writeable($this->_sFifo)) {
            if ($rFifo = fopen($this->_sFifo, 'w')) {
                stream_set_blocking($rFifo, false);
                fwrite($rFifo, $sKey);
                fclose($rFifo);

                if ($sKey == 'q') {
                    sleep(1);
                    @unlink($this->_sFifo);
                }
            }
        }
    }

}
