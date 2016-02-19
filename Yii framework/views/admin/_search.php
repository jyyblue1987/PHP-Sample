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
                    <input type="hidden" name="r" value="admin/admin">
                </td>
                <td class="search-field nowrap">
                    <label for="elm_name">Admin Name:</label>
                    <div class="break">
                        <input class="input-text" type="text" name="Admin[username]" id="elm_name" value="<?php echo $model->username; ?>" />
                    </div>
                </td>
                <td class="search-field">
                    <label for="elm_email">Status:</label>
                    <select name="Admin[status]">
                        <option value='' selected="selected">All</option>
                        <option value='1'
                            <?php if ($model->status === '1') : ?>
                                selected="selected"
                            <?php endif; ?> 
                        >Active</option>
                        <option value='0'
                            <?php if ($model->status === '0') : ?>
                                selected="selected"
                            <?php endif; ?>
                        >Inactive</option>
                    </select>
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