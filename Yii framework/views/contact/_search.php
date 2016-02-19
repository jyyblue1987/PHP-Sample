<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div id="search-form" class="section-border">
    <form name="user_search_form" action="<?php echo Yii::app()->createUrl($this->route);?>" method="GET" class="">
        <table cellpadding="0" cellspacing="0" border="0" class="search-header">
            <tr>
                <td style="display:none">
                    <input type="hidden" name="r" value="contact/admin">
                </td>
                <td style="display:none">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
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
                    <label for="elm_group">Contact Group:</label>
                    <select name="User[group_id]" id="elm_group">
                        <option value='' selected="selected">All</option>
                        <?php
                            $group_list = Group::modelById($id)->findAll();
                            foreach( $group_list as $group )
                            {
                        ?>
                        <option value='<?php echo $group->id ?>'
                            <?php if ($model->group_id === $group->id) : ?>
                                selected="selected"
                            <?php endif; ?>
                        ><?php echo $group->name; ?></option>
                        <?php } ?>
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