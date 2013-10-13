<div>
    <?php if ($sAction == 'idle' || $sAction == 'stop') : ?>
    <a href="<?php echo $aInfo['url']; ?>&action=start">Play</a>
    <?php elseif($sAction == 'play' || $sAction == 'start') : ?>
    <a href="<?php echo $aInfo['url']; ?>&action=pause">Pause</a>
    <a href="<?php echo $aInfo['url']; ?>&action=stop">Stop</a>
    <?php elseif($sAction == 'pause') : ?>
    <a href="<?php echo $aInfo['url']; ?>&action=play">Play</a>
    <a href="<?php echo $aInfo['url']; ?>&action=stop">Stop</a>
    <?php endif; ?>
</div>
