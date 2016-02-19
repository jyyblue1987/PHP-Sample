<?php
/* @var $this ReportController */
/* @var $model Report */
/* @var $form CActiveForm */

?>

<div id="search-form" class="section-border">
    <form name="user_search_form" action="<?php echo Yii::app()->createUrl($this->route);?>" method="GET" class="">
        <table cellpadding="0" cellspacing="0" border="0" class="search-header">
            <tr>
                <td style="display:none">
                    <input type="hidden" name="r" value="report/admin">
                </td>
                <td class="search-field nowrap">
                    <label for="elm_name">User Name:</label>
                    <div class="break">
                        <input class="input-text" type="text" size="15" name="User_name" id="elm_name" value="<?php echo $User_name; ?>"/>
                    </div>
                </td>
                <td class="search-field nowrap">
                    <label for="elm_mobile">Mobile:</label>
                    <div class="break">
                        <input class="input-text" type="text" size="15" name="User_mobile" id="elm_mobile" value="<?php echo $User_mobile; ?>"/>
                    </div>
                </td>
				<td class="search-field nowrap">
                    <label for="elm_mobile">Content:</label>
                    <div class="break">
                        <input class="input-text" type="text" size="15" name="Report[content]" id="elm_mobile" value="<?php echo $model->content; ?>"/>
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