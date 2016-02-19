<?php
/* @var $this UserController */
/* @var $model User */

$this->renderPartial('_header',array(
	'title'=>'Report Detail',
));

$labels = $model->attributeLabels();

function printField( $title, $value )
{	
	echo "<tr>";
	echo "<td class='title'>";
	echo $title;
	echo "&nbsp;&nbsp;&nbsp;:";
	echo "</td>";
	echo "<td class='value'>";
	echo $value;
	echo "</td>";
	echo "</tr>";
}
?>

<div class="mainbox-body">
    <div class="cm-tabs-content">
	    <form class="cm-form-highlight">
            <table class="info_detail_view">
            	<?PHP
					printField( 'User Name', $model->user->name );
					printField( 'User Mobile', $model->user->mobile );
					printField( 'Content', $model->content );

					printField( $labels['timestamp'], date("Y/m/d", $model->timestamp) );
				?>
            </table>
            
            <div class="buttons-container buttons-bg cm-toggle-button">
                <span class="cm-button-main cm-process-items">
                    <input type="button" onclick="location.href = '<?php echo $returnUrl; ?>'"  value="Back" />
                </span>
            </div>
            </form>
    </div>
</div>
