<?php
/* @var $this CallHistoryController */
/* @var $model CallHistory */

$title = 'Call History';

?>

<div class="mainbox-body" >
    <div id="content_manage_users">

	<?php
        $this->renderPartial('_header',array(
            'title'=>$title,
        ));
    
        $this->renderPartial('_search',array(
            'model'=>$model,
        ));
    ?>
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
				array(
                    'name'=>'from_mobile',
                    'htmlOptions' => array('width' => '13%'),
                ),
				array(
                    'name'=>'caller.name',
					'type'=>'raw',
                    'value'=>array( $this, 'getCallerNameColumn'),
                    'htmlOptions' => array('width' => '13%'),
                ),
				array(
                    'name'=>'to_mobile',
                    'htmlOptions' => array('width' => '13%'),
                ),
				array(
                    'name'=>'receiver.name',
					'type'=>'raw',
                    'value'=>array( $this, 'getReceiverNameColumn'),
                    'htmlOptions' => array('width' => '13%'),
                ),
				array(
                    'name'=>'starttime',
                    'value'=>'date("M j, Y H:i:s", $data->starttime)',
                    'htmlOptions' => array('width' => '13%'),
                ),
				array(
                    'name'=>'endtime',
                    'value'=>'date("M j, Y H:i:s", $data->endtime)',
                    'htmlOptions' => array('width' => '13%'),
                ),
				array(
					//'name' => 'id',
					'header'=>'Time',
                    'value'=>array( $this, 'getTimeColumn'),
					'htmlOptions' => array('width' => '13%'),
                ),
                array(
                    'header'=>CHtml::dropDownList('pageSize',$pageSize, array(5=>5,10=>10,20=>20,50=>50,100=>100),array(
                            'onchange'=>"$.fn.yiiGridView.update('data_grid_view',{ data:{pageSize: $(this).val() }})",
                        )),
                    'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'htmlOptions' => array('width' => '5%'),
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
            //url = url + '&returnUrl=' + encodeURIComponent(returnUrl);
            //window.location = url;
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
                    
                    var url = "<?php echo Yii::app()->homeUrl . '?r=classification/deleteselected'?>";

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
