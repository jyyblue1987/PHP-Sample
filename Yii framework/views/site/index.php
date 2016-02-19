<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$icons_path = Yii::app()->request->baseUrl . 'models/css/images/icons/';

$admin_count = Admin::model()->count();
$user_count = User::model()->count();
$total_count = $admin_count + $user_count;
$disabled_count =  User::model()->countByAttributes(array(
            'status'=> '0'
        ));

?>

<div class="clear mainbox-title-container">
    <h1 class="mainbox-title float-left">
        Dashboard
    </h1>
</div>

<div class="statistics-box users">
    <h2>
        <span class="float-right hidden">
            <img src="<?php echo $icons_path; ?>icon_hide.gif" width="13" height="13" border="0" alt="Hide" title="Hide" />
            <img src="<?php echo $icons_path; ?>icon_close.gif" width="13" height="13" border="0" alt="Close" title="Close" />
        </span>
        Users
    </h2>	
    <div class="statistics-body clear">
        <ul>
            <li class="customer-users">
                <span>Administrator:</span>
                <em><?php echo $admin_count; ?></em>
            </li>

            <li class="staff-users">
                <span>Users:</span>
                <em><?php echo $user_count; ?></em>
            </li>

            <li class="total-users">
                <span>Total:</span>
                <em><?php echo $total_count; ?></em>
            </li>

            <li class="disabled-users">
                <span>Disabled:</span>
                <em><?php echo $disabled_count; ?></em>
            </li>
        </ul>
    </div>
</div>