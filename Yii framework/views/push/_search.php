<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */

?>

<div id="search-form" class="section-border">
    <form name="user_search_form" action="<?php echo Yii::app()->createUrl($this->route);?>" method="GET" class="">
        <table cellpadding="0" cellspacing="0" border="0" class="search-header">
            <tr>
                <td style="display:none">
                    <input type="hidden" name="r" value="push/admin">
                </td>
                <td class="search-field nowrap">
                    <label for="elm_name">Broadcast Message:</label>
                    <div class="break">
                        <input class="input-text" type="text" name="Push[message]" id="elm_name" value="<?php echo $model->message; ?>" />
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