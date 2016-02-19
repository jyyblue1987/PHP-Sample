<?php
/* @var $this PushController */
/* @var $model Push */

$title = 'Push Notification';

$addLink = Yii::app()->homeUrl . "?r=push/create";

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>$title,
        'addLink'=>$addLink,
));


$this->renderPartial('_search',array(
	'model'=>$model,
));

$postFilterParam = 'Push[message]=' . $model->message;

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
				/*array(
            		'header'=>'No',
					'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
					'htmlOptions' => array('width' => '5%'),
        		),*/
                array(
                    'name'=>'message',
                    'type'=>'raw',
                    'value'=>array( $this, 'getMessageDataColumn'),
                    'htmlOptions' => array('width' => '68%'),
                ),
                array(
                    'name'=>'status',
                    'type'=>'raw',
                    'value'=>array( $this, 'getStatusDataColumn'),
                    'htmlOptions' => array('width' => '15%'),
                ), 
                array(
                    'name'=>'reg_stamp',
                    'value'=>'date("M j, Y", $data->reg_stamp)',
                    'htmlOptions' => array('width' => '15%'),
                ),
				array(
				    'header'=>CHtml::dropDownList('pageSize',$pageSize, array(5=>5,10=>10,20=>20,50=>50,100=>100),array(
                            'onchange'=>"$.fn.yiiGridView.update('data_grid_view',{ data:{pageSize: $(this).val() }})",
                        )),
					'type'=>'raw',
                    'value'=>array( $this, 'getSendMessageColumn'),                    
                ), 			
/*				array(
					'type'=>'raw',
                    'value'=>array( $this, 'getDeleteMessageColumn'),                    
                ), 	
*/				
				array(
                    'class'=>'CButtonColumn',
                    'template'=>'{delete}',                    
                ),
				
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
       
       jQuery(document).on('click','#create_button',function() {
            var returnUrl = $('#data_grid_view').yiiGridView('getUrl');
            var url = '<?php echo $addLink; ?>'
            //url = url + '&returnUrl=' + encodeURIComponent(returnUrl);
            //window.location = url;
            requestUrlWithData( url, {returnUrl: returnUrl}, 'POST' );
            return false;
        });
        
        jQuery(document).on('click','#data_grid_view a.update',function() {
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
                    
                    var url = "<?php echo Yii::app()->homeUrl . '?r=push/deleteselected'?>";
                    
                    postparam = postparam + "<?PHP echo '&' . $postFilterParam;?>";

                    $.post(url, postparam, function(response) {
                        //$('#data_grid_view').replaceWith($('#data_grid_view', response));
                        jQuery('#data_grid_view').yiiGridView('update');
                    });
    
                    //$.fn.yiiGridView.update('data_grid_view', { type:'POST', url:url, data: postparam });
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