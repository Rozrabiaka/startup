<?php
/** @var common\widgets\PostMenuWidget $links */
?>

<?php if (!empty($links)): ?>
    <div class="links-dom">
        <div class="click-links-menu">...</div>
        <div class="links-menu">
			<?php foreach ($links as $key => $link): ?>
                <span><a href="<?= $link ?>"><?= $key ?> </a></span>
			<?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>