<?php
/* @var $this ContactController */
/* @var $model Contact */

$title = 'User Contacts';

$this->renderPartial('_header',array(
	'title'=>$title,
));

$this->renderPartial('_search',array(
	'model'=>$model,
	'id'=>$id,
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
					'value'=>'',
					'htmlOptions' => array('width' => '10px'),
				),
				array(
            		'header'=>'No',
            		//'value'=>'$row+1',
					'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
					'htmlOptions' => array('width' => '3%'),
        		),
				array(
                    'name'=>'user.name',
					'type'=>'raw',
                    'value'=>array( $this, 'getNameDataColumn'),
                    'htmlOptions' => array('width' => '15%'),
                ),
				array(
                    'name'=>'pname',
                    'htmlOptions' => array('width' => '15%'),
                ),
				array(
                    'name'=>'mobile',
					'htmlOptions' => array('width' => '15%'),
                ),
				array(
                    'name'=>'country.name',
					'value'=>'$data->country->name',
					'htmlOptions' => array('width' => '10%'),
                ),
				array(
					'name'=>'group.name',
					'value'=>'$data->group ? $data->group->name: ""',
					'htmlOptions' => array('width' => '10%'),
                ),
				array(
                    'name'=>'user.email',
                    'type'=>'raw',
                    'value'=>array( $this, 'getEmailDataColumn'),
					'htmlOptions' => array('width' => '10%'),
                ),
                array(
                    'name'=>'user.reg_stamp',
                    'value'=>'$data->user ? date("M j, Y", $data->user->reg_stamp) : "-"',
					'htmlOptions' => array('width' => '10%'),
                ),
                array(
                    'name'=>'user.status',
                    'value'=>array( $this, 'getStatusDataColumn'),
					'htmlOptions' => array('width' => '5%'),
                ),
                array(
                    'header'=>CHtml::dropDownList('pageSize',$pageSize, array(5=>5,10=>10,20=>20,50=>50,100=>100),array(
                            'onchange'=>"$.fn.yiiGridView.update('data_grid_view',{ data:{pageSize: $(this).val() }})",
                        )),
                    'class'=>'CButtonColumn',
                    'template'=>'{view}',
					'buttons'=>array
                    (
						'view' => array
                        (
							'visible'=>'$data->user',
                            'label'=>'View user profile',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/customers.png',
                            'url'=>'Yii::app()->createUrl("user/view' . '", array("id"=>$data->id))',
                            'options'=>array( 'class'=>'view' ),
                        ),
                    ),
                    'htmlOptions' => array('width' => '5%'),
                ),
				array(
					'value'=>'',
					'htmlOptions' => array('width' => '10px'),
				),
            ),
        ));
?>

        <div class="buttons-container">
        	&nbsp;&nbsp;&nbsp;
        </div>
        
        <div class="buttons-container buttons-bg cm-toggle-button">
            <span class="cm-button-main cm-process-items">
                <input type="button" onclick="location.href = '<?php echo $returnUrl; ?>'"  value="Back" />
            </span>
        </div>

    <?php echo CHtml::endForm(); ?>

    </div>
</div>

<script type='text/javascript'>
    $(document).ready(function(){
		jQuery(document).on('click','#data_grid_view a.view',function() {
            var returnUrl = $('#data_grid_view').yiiGridView('getUrl');
            var url = jQuery(this).attr('href');
			
			//returnUrl = returnUrl + "&returnUrl=<?php echo $returnUrl; ?>";
			returnUrl = returnUrl + '&returnUrl=' + encodeURIComponent('<?php echo $returnUrl; ?>');
            requestUrlWithData( url, {returnUrl: returnUrl}, 'POST' );
            return false;
        });
		
		jQuery(document).on('DOMSubtreeModified','#data_grid_view',function() {
            $.ceFloatingBar();
        });
    });
</script>