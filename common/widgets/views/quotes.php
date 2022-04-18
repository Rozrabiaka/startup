<?php /** @var $quote common\widgets\QuotesWidget */ ?>

<div class="quotes-widget">
    <div class="q-p-t">
        <p class="text-p-q">&laquo; <span class="text-q"><?php echo $quote->text ?></span> &raquo;</p>
        <p class="author-q-p">&copy; <span class="author-q"><?php echo $quote->author ?></span></p>
    </div>
</div>