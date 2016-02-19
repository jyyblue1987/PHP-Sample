<?php
/* @var $this CountryController */
/* @var $model Country */
/* @var $form CActiveForm */

?>

<div id="search-form" class="section-border">
    <form name="user_search_form" action="<?php echo Yii::app()->createUrl($this->route);?>" method="GET" class="">
        <table cellpadding="0" cellspacing="0" border="0" class="search-header">
            <tr>
                <td style="display:none">
                    <input type="hidden" name="r" value="country/admin">
                </td>
                <td class="search-field nowrap">
                    <label for="elm_name">Country Name:</label>
                    <div class="break">
                        <input class="input-text" type="text" name="Country[name]" id="elm_name" value="<?php echo $model->name; ?>" />
                    </div>
                </td>
                <td class="search-field nowrap">
                    <label for="elm_name">Phone Prefix:</label>
                    <div class="break">
                        <input class="input-text" type="text" name="Country[phone_prefix]" id="elm_name" value="<?php echo $model->phone_prefix; ?>" />
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