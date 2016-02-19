<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

?>

<div id="search-form" class="section-border">
    <form name="user_search_form" action="<?php echo Yii::app()->createUrl($this->route);?>" method="GET" class="">
        <table cellpadding="0" cellspacing="0" border="0" class="search-header">
            <tr>
                <td style="display:none">
                    <input type="hidden" name="r" value="user/admin">
                </td>
                <td class="search-field nowrap">
                    <label for="elm_name">User Name:</label>
                    <div class="break">
                        <input class="input-text" type="text" size="15" name="User[name]" id="elm_name" value="<?php echo $model->name; ?>"/>
                    </div>
                </td>
                <td class="search-field nowrap">
                    <label for="elm_mobile">Mobile:</label>
                    <div class="break">
                        <input class="input-text" type="text" size="15" name="User[mobile]" id="elm_mobile" value="<?php echo $model->mobile; ?>"/>
                    </div>
                </td>
                <td class="search-field nowrap">
                    <label for="elm_email">Email:</label>
                    <div class="break">
                        <input class="input-text" type="text" size="15" name="User[email]" id="elm_email" value="<?php echo $model->email; ?>"/>
                    </div>
                </td>
                <td class="search-field">
                    <label for="elm_country">Country:</label>
                    <select name="User[country_id]" id="elm_country">
                        <option value='' selected="selected">All</option>
                        <?php
							$country_list = Country::model()->findAllBySql('select * from country order by name ASC');
							foreach( $country_list as $country )
							{
						?>
                        <option value='<?php echo $country->id ?>'
                            <?php if ($model->country_id === $country->id) : ?>
                                selected="selected"
                            <?php endif; ?>
                        ><?php echo $country->name; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td class="search-field">
                    <label for="elm_class">Classification:</label>
                    <select name="User[class_id]" id="elm_class">
                        <option value='' selected="selected">All</option>
                        <?php
							$class_list = Classification::model()->findAllBySql('select * from classification order by name ASC');
							foreach( $class_list as $class )
							{
						?>
                        <option value='<?php echo $class->id ?>'
                            <?php if ($model->class_id === $class->id) : ?>
                                selected="selected"
                            <?php endif; ?>
                        ><?php echo $class->name; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td class="search-field">
                    <label for="elm_status">Status:</label>
                    <select name="User[status]" id="elm_status">
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