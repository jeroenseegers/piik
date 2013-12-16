<div>
    <?php if ($sAction == 'idle' || $sAction == 'stop') : ?>
    <a href="<?php echo $aInfo['url']; ?>&action=start" class="btn btn-success btn-lg btn-block">
        <span class="glyphicon glyphicon-play"></span> Play
    </a>
    <?php elseif($sAction == 'play' || $sAction == 'start') : ?>
    <a href="<?php echo $aInfo['url']; ?>&action=pause" class="btn btn-primary btn-lg btn-block">
        <span class="glyphicon glyphicon-pause"></span> Pause
    </a>
    <a href="<?php echo $aInfo['url']; ?>&action=stop" class="btn btn-danger btn-lg btn-block">
        <span class="glyphicon glyphicon-stop"></span> Stop
    </a>
    <?php elseif($sAction == 'pause') : ?>
    <a href="<?php echo $aInfo['url']; ?>&action=play" class="btn btn-success btn-lg btn-block">
        <span class="glyphicon glyphicon-play"></span> Play
    </a>
    <a href="<?php echo $aInfo['url']; ?>&action=stop" class="btn btn-danger btn-lg btn-block">
        <span class="glyphicon glyphicon-stop"></span> Stop
    </a>
    <?php endif; ?>
</div>
