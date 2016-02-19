<?php
/* @var $this UserController */
/* @var $model User */

$this->renderPartial('_header',array(
	'title'=>'User : ' . $model->name,
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
            <h2 class="subheader">
                User information
            </h2>

            <table class="info_detail_view">
            	<?PHP
					printField( 'User Photo', '<img src="uploads/' . $model->photo_filename . '" alt="" width="100" height="100">' );
					printField( $labels['name'], $model->name );
					printField( $labels['pname'], $model->pname );
					printField( $labels['email'], $model->email );
					printField( $labels['mobile'], $model->mobile );
					printField( $labels['country.name'], $model->country->name );
					printField( $labels['homeaddr'], $model->homeaddr );
					printField( $labels['housetel'], $model->housetel );
					printField( $labels['birthday'], $model->birthday );
					//printField( $labels['reg_stamp'], date("M j, Y", $model->reg_stamp) );
					printField( $labels['reg_stamp'], date("Y/m/d", $model->reg_stamp) );
					printField( $labels['update_stamp'], date("Y/m/d", $model->update_stamp) );
					printField( $labels['classification.name'], $model->classification ? $model->classification->name : '-' );
					printField( $labels['status'], $model->status === '1' ? 'Active' : 'Inactive' );
					printField( $labels['is_verified'], $model->is_verified === '1' ? 'Yes' : 'No' );
				?>
            </table>
            
            <?PHP
				for( $idx = 0; $idx < count($model->company); $idx ++ )
				{
			?>
                    <h2 class="subheader">
                        Company information <?php echo '(' . ($idx+1) . ')'; ?>
                    </h2>
                    <table class="info_detail_view">
            <?php
					printField( 'Company Name', $model->company[$idx]->name );
					printField( 'Department', $model->company[$idx]->department );
					printField( 'Job', $model->company[$idx]->jobtitle );
					printField( 'Address', $model->company[$idx]->address );
					printField( 'Telephone', $model->company[$idx]->telephone );
					printField( 'Fax', $model->company[$idx]->fax );
					printField( 'Notes', $model->company[$idx]->notes );
					printField( 'Email', $model->company[$idx]->email );
					printField( 'Website', $model->company[$idx]->website );
			?>
            		</table>
            <?php
					//echo count($model->company);
				}
			?>
            
            <div class="buttons-container buttons-bg cm-toggle-button">
                <span class="cm-button-main cm-process-items">
                    <input type="button" onclick="location.href = '<?php echo $returnUrl; ?>'"  value="Back" />
                </span>
            </div>
            </form>
    </div>
</div>
