<div class="row">
    <?php foreach($aInfo['file_list'] as $aShow): ?>
    <div class="col-xs-6 col-sm-3">
        <a href="<?php echo $aShow['url']; ?>" title="<?php echo $aShow['title']; ?>">
            <img src="/image.php?image=<?php echo $aInfo['dir'] . $aShow['title'] . '/folder.jpg'; ?>" alt="<?php echo $aShow['title']; ?>" class="img-rounded img-responsive thumbnail-showlist">
        </a>
    </div>
    <?php endforeach; ?>
</div>
