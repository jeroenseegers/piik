<div class="row">
    <?php foreach($aInfo['file_list'] as $aShow): ?>
    <div class="col-xs-6 col-sm-3">
        <a href="<?php echo $aShow['url']; ?>" title="<?php echo $aShow['title']; ?>">
            <?php echo $aShow['title']; ?>
        </a>
    </div>
    <?php endforeach; ?>
</div>
