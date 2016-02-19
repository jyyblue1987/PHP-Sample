<?php
/* @var $this CallHistoryController */
/* @var $model CallHistory */
/* @var $form CActiveForm */

?>

<div id="search-form" class="section-border">
    <form name="user_search_form" action="<?php echo Yii::app()->createUrl($this->route);?>" method="GET" class="">
        <table cellpadding="0" cellspacing="0" border="0" class="search-header">
            <tr>
                <td style="display:none">
                    <input type="hidden" name="r" value="callhistory/admin">
                </td>
                <td class="search-field nowrap">
                    <label for="elm_from">From:</label>
                    <div class="break">
                        <input class="input-text" type="text" name="CallHistory[from_mobile]" id="elm_from" value="<?php echo $model->from_mobile; ?>" />
                    </div>
                </td>
                <td class="search-field nowrap">
                    <label for="elm_to">To:</label>
                    <div class="break">
                        <input class="input-text" type="text" name="CallHistory[to_mobile]" id="elm_to" value="<?php echo $model->to_mobile; ?>" />
                    </div>
                </td>
                <td class="buttons-container">
                    <span  class="submit-button ">
                        <input type="submit" name="mode" value="Search" />
                    </span>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
        Yii::app()->clientScript->registerScript('Search', "
            $('#search-form form').submit(function(){
                    $.fn.yiiGridView.update('data_grid_view', {
                    data: $(this).serialize()
                });
                return false;
            });
        ");
?>