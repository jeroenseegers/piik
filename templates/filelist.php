<?php foreach($aShowList as $aShow): ?>
<div>
    <a href="<?php echo $aShow['url']; ?>" title="<?php echo $aShow['title']; ?>">
        <?php echo $aShow['title']; ?>
    </a>
</div>
<?php endforeach; ?>
