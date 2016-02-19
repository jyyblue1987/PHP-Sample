<?php
/* @var $this UserController */
/* @var $dataProvider */
/* @var $filter search params */

$title = 'Administrator';

// current dir
$curr_path =  Yii::app()->homeUrl . "?r=user";

$listLink = $curr_path . "/admin";
$addLink = $curr_path . "/create";
$editLink = $curr_path . "/update";
$deleteLink = $curr_path . "/admin";
$csvLink = $curr_path . "admin/save_csv.php?rating=2&";

$listPerLink = $curr_path . "/admin";

$usernameLink = $curr_path . "/admin&sort_by=user_name";

$pageNavigation = "1 2 3";

$search_user_name= "Admin Name";
$search_user_status = 1;

$items_per_page = Functions::getParameter('items_per_page', 10);

$total = 11;//$dataProvider->getItemCount();

$this->renderPartial('_header',array(
	'title'=>$title,
        'addLink'=>$addLink,
));

$this->renderPartial('_search',array(
        'filter'=>$filter,
));
?>

<div class="mainbox-body" >
    <div id="content_manage_users">
        
        <?php
            $this->renderPartial('_page',array(
                'pageNavigation'=>$pageNavigation,
                'total'=>$total,
                'listPerLink'=>$listPerLink,
                'items_per_page'=>$items_per_page,
            ));
        ?>
        
        <?php
        

        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
        'columns'=>array
        (
           array(
            'class' => 'CCheckBoxColumn',
                        'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'submission_ids[]',
            ),
            'value' =>'$data->id',
        ),
            array(
                'name'=>'username',
                'header' => 'Admin Name',
                'value'=>'$data->username',
                'htmlOptions' => array('width' => '25%'),
            ),
            array(
                'name'=>'email',
                'header' => 'Email',
                'type'=>'raw',
                'value'=>array( $this, 'getEmailDataColumn'),
                'htmlOptions' => array('width' => '25%'),
            ),
            array(
                'name'=>'reg_stamp',
                'header'=>'Registered',
                'value'=>'date("M j, Y", $data->reg_stamp)',
                'htmlOptions' => array('width' => '25%'),
            ),
            array(
                'name'=>'status',
                'header' => 'Status',
                'type'=>'raw',
                'value'=>array( $this, 'getStatusDataColumn'),
                'htmlOptions' => array('width' => '10%'),
            ),
            array(
                'class'=>'CButtonColumn',
            ),
        ),
        ));
        ?>
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table sortable">
            <tr>
                <th width="5%" class="center cm-no-hide-input">
                    <input type="checkbox" name="check_all" value="Y" title="Check / uncheck all" class="checkbox cm-check-items" />
                </th>
                <th width="25%">
                    <a href="<?php echo $usernameLink; ?>"><b>Admin Name</b></a>
                </th>
                <th width="25%">
                    &nbsp;&nbsp;&nbsp;<b>Email</b>
                </th>
                <th width="15%">
                    &nbsp;&nbsp;&nbsp;<b>Registered</b>
                </th>
                <th width="10%">
                    &nbsp;&nbsp;&nbsp;<b>Status</b>
                </th>
                <th width="10%">
                    &nbsp;&nbsp;&nbsp;<b>Action</b>
                </th>
            </tr>

            <?php foreach ($dataProvider->getData() as $v1) : ?>
                <tr class=" ">
                    <td class="center cm-no-hide-input">
                        <input type="checkbox" name="user_ids[]" value="<?php echo $v1['id']; ?>" class="checkbox cm-item" /></td>
                    <td><a href="<?php echo $editLink; ?>&id=<?php echo $v1['id']; ?>"><span><?php echo $v1['username']; ?></span></a></td>
                    <td width="25%"><a href="mailto:<?php echo $v1['email']; ?>"><?php echo $v1['email']; ?></a></td>
                    <td><?php echo date("j M, Y", $v1['reg_stamp']); ?></td>
                    <td>
                        <?php if ($v1['status'] === '1') : ?>
                            Active
                        <?php else : ?>
                            Inactive
                        <?php endif; ?>
                    </td>
                    <td class="nowrap">
                        <a class="tool-link " href="<?php echo $editLink; ?>&id=<?php echo $v1['id']; ?>" >Edit</a>
                        &nbsp;&nbsp;|
                        <ul class="cm-tools-list tools-list">
                            <li><a class="cm-confirm" href="<?php echo $deleteLink; ?>&id=<?php echo $v1['id']; ?>">Delete</a></li>
                        </ul>
                    </td>
                </tr>

            <?php endforeach; ?>

            <?php if ($total === 0) : ?>
                <tr class="no-items">
                    <td class="center cm-no-hide-input" colspan="8">
                        <p>No data found.</p>
                    </td>
                </tr>
            <?php endif; ?>

        </table>

        <div class="table-tools">
            <a href="#users" name="check_all" class="cm-check-items cm-on underlined">Select all</a>|
            <a href="#users" name="check_all" class="cm-check-items cm-off underlined">Unselect all</a>
        </div>

        <?php
            $this->renderPartial('_page',array(
                'pageNavigation'=>$pageNavigation,
                'total'=>$total,
                'listPerLink'=>$listPerLink,
                'items_per_page'=>$items_per_page,
            ));
        ?>

    </div>

    <div class="buttons-container buttons-bg">
        <div class="float-left">
            <span class="submit-button cm-button-main cm-confirm cm-process-items">
                <input class="cm-confirm cm-process-items" type="submit" name="dispatch[profiles.m_delete]" value="Delete selected" />
            </span>
            &nbsp;&nbsp;&nbsp;
            <span class="cm-button-main cm-process-items">
                <input type="button" onclick="window.open('<?php echo $csvLink; ?>');"  value="Export CSV" />
            </span>
        </div>
    </div>

        <!--content_manage_users-->
</div>

<?php
//require_once($curr_path . "models/bottom.php");
//<a class="sort-link desc" href="/phonebook/index.php?r=user/admin&User_sort=id&ajax=user-grid">ID</a>
//<a class="sort-link desc" href="/phonebook/index.php?r=user/admin&User_sort=id.desc&ajax=user-grid">ID</a>
?>
