<?php
/* @var $this UserController */
/* @var $model User */

$title = 'Users';

$this->renderPartial('_header',array(
	'title'=>$title,
));

$this->renderPartial('_search',array(
	'model'=>$model,
));
?>

<div class="mainbox-body" >
    <div id="content_manage_users">
        <?php echo CHtml::beginForm(); ?>

<?php
        $pageSize = $model->search()->getPagination()->getPageSize();

        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'data_grid_view',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'columns'=>array(
               array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 2,
                    'checkBoxHtmlOptions' => array(
                        'name' => 'selected_ids[]',
                        ),
                    'value' =>'$data->id',
                    'footer'=>'',
                ),
				/*
				array(
            		'header'=>'No',
            		//'value'=>'$row+1',
					'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        		),*/
				array(
                    'name'=>'name',
					'type'=>'raw',
                    'value'=>array( $this, 'getNameDataColumn'),
                    'htmlOptions' => array('width' => '10%'),
                ),
				array(
                    'name'=>'mobile',
					'type'=>'raw',
					'value'=>array( $this, 'getMobileDataColumn'),
					//'value'=>'$data->country->phone_prefix . " " . $data->mobile',
                ),
				array(
                    'name'=>'email',
                    'type'=>'raw',
                    'value'=>array( $this, 'getEmailDataColumn'),
                ),
				array(
                    'name'=>'country.name',
					//'value'=>'"(" . $data->country->phone_prefix . ") " . $data->country->name ',
					'value'=>'$data->country->name',
                ),
				array(
					'name'=>'classification.name',
					'type'=>'raw',
					'value'=>array( $this, 'getClassDataColumn'),
                ),
                array(
                    'name'=>'reg_stamp',
                    'value'=>'date("M j, Y", $data->reg_stamp)',
                ),
                array(
                    'name'=>'status',
                    'type'=>'raw',
                    'value'=>array( $this, 'getStatusDataColumn'),
                ),
                array(
                    'header'=>CHtml::dropDownList('pageSize',$pageSize, array(5=>5,10=>10,20=>20,50=>50,100=>100),array(
                            'onchange'=>"$.fn.yiiGridView.update('data_grid_view',{ data:{pageSize: $(this).val() }})",
                        )),
                    'class'=>'CButtonColumn',
                    'template'=>'{view}&nbsp;{contact}&nbsp;{update}&nbsp;{delete}',
					'buttons'=>array
                    (
						'view' => array
                        (
                            'label'=>'View user profile',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/customers.png',
                            'url'=>'Yii::app()->createUrl("user/view' . '", array("id"=>$data->id))',
                            'options'=>array( 'class'=>'view' ),
                        ),
						'contact' => array
                        (
                            'label'=>'View user contacts',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/usergroups.png',
                            'url'=>'Yii::app()->createUrl("contact/admin' . '", array("id"=>$data->id))',
                            'options'=>array( 'class'=>'view' ),
                        ),
					),
                    'htmlOptions' => array('width' => '8%'),
                )
            ),
        ));
?>

        <div class="buttons-container buttons-bg">
            <div id="float-tool-bar" class="float-left">
                <span class="submit-button cm-button-main cm-confirm cm-process-items">
                    <input id="btDeleteSelected" class="cm-confirm cm-process-items" type="submit" name="bt_delete_selected" value="Delete selected" />
                </span>
                &nbsp;&nbsp;&nbsp;
                <?php if( isset($csvLink) ) : ?>
                <span class="cm-button-main cm-process-items">
                    <input type="button" onclick="window.open('<?php echo $csvLink; ?>');"  value="Export CSV" />
                </span>
                <?php endif ?>
            </div>
        </div>

    <?php echo CHtml::endForm(); ?>

    </div>
</div>

<script type='text/javascript'>
    $(document).ready(function(){
        
        jQuery(document).on('click','#data_grid_view a.update',function() {
            var returnUrl = $('#data_grid_view').yiiGridView('getUrl');
            var url = jQuery(this).attr('href');
            requestUrlWithData( url, {returnUrl: returnUrl}, 'POST' );
            return false;
        });
		
		jQuery(document).on('click','#data_grid_view a.view',function() {
            var returnUrl = $('#data_grid_view').yiiGridView('getUrl');
            var url = jQuery(this).attr('href');
            requestUrlWithData( url, {returnUrl: returnUrl}, 'POST' );
            return false;
        });
        
        jQuery(document).on('click','#select_all_rows',function() {
            jQuery("input[name='selected_ids\[\]']:enabled").each(function() {this.checked=true;});
            jQuery("input[name='data_grid_view_c0_all']:enabled").each(function() {this.checked=true;});
            return false;
        });
        
        jQuery(document).on('click','#unselect_all_rows',function() {
            jQuery("input[name='selected_ids\[\]']:enabled").each(function() {this.checked=false;});
            jQuery("input[name='data_grid_view_c0_all']:enabled").each(function() {this.checked=false;});
            return false;
        });
		
		jQuery(document).on('DOMSubtreeModified','#data_grid_view',function() {
            $.ceFloatingBar();
        });
        
        $("#btDeleteSelected").click( function(event) {
            var idList = $("input[type=checkbox]:checked").serialize();
            if( idList )
            {
                if( confirm("Are you sure want to delete?") )
                {
                    var postparam = idList;
                    
                    var url = "<?php echo Yii::app()->homeUrl . '?r=user/deleteselected'?>";

                    $.post(url, postparam, function(response) {
                        jQuery('#data_grid_view').yiiGridView('update');
                    });
                }
            }
            else
            {
                alert("Your selection is empty. Please select items first.");
            }
            
            return false;// if return true then submit action call
        });
    });
</script>