<div class="row">
    <?php foreach($aInfo['file_list'] as $aMovie): ?>
    <div class="col-xs-6 col-sm-3">
        <a href="<?php echo $aMovie['url']; ?>" title="<?php echo $aMovie['title']; ?>">
            <?php echo $aMovie['title']; ?>
        </a>
    </div>
    <?php endforeach; ?>
</div>
