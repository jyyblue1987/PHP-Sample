<?php
/* @var $this AdminController */
/* @var $title header title */
/* @var $addLink add new user link */
?>

<div class="clear mainbox-title-container">
    <?php if( isset($addLink) ): ?>
    <div class="tools-container">
        <span class="action-add">
            <a id='create_button' href="<?php echo $addLink;?>">Create</a>
        </span>
    </div>
    <?php endif ?>
    <h1 class="mainbox-title float-left">
        <?php echo $title; ?>
    </h1>
</div>