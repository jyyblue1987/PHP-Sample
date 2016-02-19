<?php
/* @var $this ReportController */
/* @var $model Report */

$title = 'Reports';

$this->renderPartial('_header',array(
	'title'=>$title,
));

$this->renderPartial('_search',array(
	'model' => $model,
	'User_name' => $User_name,
	'User_mobile' => $User_mobile,
	'User_countryid' => $User_countryid,
));

?>

<div class="mainbox-body" >
    <div id="content_manage_users">
        <?php echo CHtml::beginForm(); ?>

<?php
        $pageSize = $model->search()->getPagination()->getPageSize();

        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'data_grid_view',
            'dataProvider'=>$model->searchByUser($User_name, $User_mobile),
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
				array(
            		'header'=>'No',
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
                    'name'=>'user.mobile',
					'htmlOptions' => array('width' => '15%'),
                ),
				array(
                    'name'=>'content',
					'type'=>'raw',
                    'value'=>array( $this, 'getContentDataColumn'),
//					'htmlOptions' => array('width' => '10%'),
                ),
                array(
                    'name'=>'timestamp',
                    'value'=>'date("M j, Y", $data->timestamp)',
					'htmlOptions' => array('width' => '10%'),
                ),
                array(
                    'header'=>CHtml::dropDownList('pageSize',$pageSize, array(5=>5,10=>10,20=>20,50=>50,100=>100),array(
                            'onchange'=>"$.fn.yiiGridView.update('data_grid_view',{ data:{pageSize: $(this).val() }})",
                        )),
                    'class'=>'CButtonColumn',
                    'template'=>'{view}&nbsp&nbsp{delete}',
                    'htmlOptions' => array('width' => '5%'),
                ),
				array(
					'value'=>'',
					'htmlOptions' => array('width' => '10px'),
				),
            ),
        ));
?>
        
        <div class="buttons-container buttons-bg">
            <div id="float-tool-bar" class="float-left">
                <span class="submit-button cm-button-main cm-confirm cm-process-items">
                    <input id="btDeleteSelected" class="cm-confirm cm-process-items" type="submit" name="bt_delete_selected" value="Delete selected" />
                </span>
                <?php if( isset($csvLink) ) : ?>
                &nbsp;&nbsp;&nbsp;
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
		jQuery(document).on('click','#data_grid_view a.view',function() {
            var returnUrl = $('#data_grid_view').yiiGridView('getUrl');
            var url = jQuery(this).attr('href');

            requestUrlWithData( url, {returnUrl: returnUrl}, 'POST' );
            return false;
        });
		
		jQuery(document).on('DOMSubtreeModified','#data_grid_view',function() {
            $.ceFloatingBar();
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
        
        $("#btDeleteSelected").click( function(event) {
            var idList = $("input[type=checkbox]:checked").serialize();
            if( idList )
            {
                if( confirm("Are you sure want to delete?") )
                {
                    var postparam = idList;

                    var url = "<?php echo Yii::app()->homeUrl . '?r=report/deleteselected'?>";

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