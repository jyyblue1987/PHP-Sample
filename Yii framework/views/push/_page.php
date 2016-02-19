<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div id="pagination_contents">
    <div class="pagination clear cm-pagination-wraper top-pagination">
        <div class="float-right">

            <?php echo $pageNavigation; ?>

            <span class="pagination-total-items">&nbsp;Total items:&nbsp;</span><span><?php echo $total; ?>&nbsp;/</span>

            <div class="tools-container inline">
                <div class="tools-content inline">
                    <a class="cm-combo-on cm-combination pagination-selector" id="sw_tools_list_pagination_381469667"><?php echo $items_per_page; ?></a>
                    <div id="tools_list_pagination_381469667" class="cm-tools-list popup-tools hidden cm-popup-box cm-smart-position">
                        <ul>
                            <li class="strong">Items per page:</li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=10" rev="pagination_contents">10</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=20" rev="pagination_contents">20</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=30" rev="pagination_contents">30</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=40" rev="pagination_contents">40</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=50" rev="pagination_contents">50</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=60" rev="pagination_contents">60</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=70" rev="pagination_contents">70</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=80" rev="pagination_contents">80</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=90" rev="pagination_contents">90</a></li>
                            <li><a href="<?php echo $listPerLink; ?>&items_per_page=100" rev="pagination_contents">100</a></li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div><!-- page-form -->