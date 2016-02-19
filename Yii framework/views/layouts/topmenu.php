<?PHP

$curr_path = "";
$agentgroup = 1000;

$login_id = Yii::app()->user->id;
$admin_info = Admin::findByEmail( $login_id );

?>

<script type='text/javascript'>
    $(document).ready(function() {        
        jQuery(document).on('click','#update_profile',function() {
		//$("#update_profile").click( function(event) {
            //var returnUrl = $('#data_grid_view').yiiGridView('getUrl');
            //var url = jQuery(this).attr('href');
			var returnUrl = location.href;
			var url = jQuery(this).attr('href');
			
            requestUrlWithData( url, {returnUrl: returnUrl}, 'POST' );
            
            return false;
        });
	});
</script>
<div id="ajax_loading_box" class="ajax-loading-box">
    <div id="ajax_loading_message" class="ajax-inner-loading-box">Loading...</div>
</div>
<div class="header-wrap">
    <div id="header">
        <div id="logo">
            <a href=<?php echo Yii::app()->homeUrl;?>><?php echo CHtml::encode(Yii::app()->name); ?></a>
        </div>

        <div id="top_quick_links">
            <div class="nowrap">
                <a id="update_profile" href="<?php echo Yii::app()->homeUrl;?>?r=admin/update&id=<?php echo $admin_info->id; ?>">
                    <span><?php echo Yii::app()->user->name; ?></span>
                </a>
                <span class="top-signout" title="Sign out">
                    <a href="<?php echo Yii::app()->homeUrl;?>?r=site/logout" class="text-link">&nbsp;</a>
                </span>
            </div>
        </div>
        <div id="top_menu">
            <ul id="alt_menu"></ul>
        </div>
        <ul id="menu">
            <li class="dashboard dashboard-active">
                <a href=<?php echo Yii::app()->homeUrl;?> title="Home">&nbsp;</a>
            </li>

            <li>
                <a class="drop">Administrator</a>
                <div class="dropdown-column">
                    <div class="col">
                        <ul>
                            <li class="blank administrators">
                            	<a href="<?php echo Yii::app()->homeUrl;?>?r=admin/admin">
                                    <span>Administrators</span>
                                    <span class="hint">List of store administrators, registered users with an administrator account.</span>
                            	</a>
                            </li>
                            <li class="blank localizations">
                            	<a href="<?php echo Yii::app()->homeUrl;?>?r=country/admin">
                                    <span>Countries</span>
                                    <span class="hint">Manage countries phone prefix number.</span>
                                </a>
                            </li>
                            <li class="blank usergroups">
                            	<a href="<?php echo Yii::app()->homeUrl;?>?r=classification/admin">
                            		<span>Classifications</span>
                                    <span class="hint">Create new classification and edit the existing ones.</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <li>
                <a class="drop">User</a>
                <div class="dropdown-column">
                    <div class="col">
                        <ul>
                            <li class="blank users">
                            	<a href="<?php echo Yii::app()->homeUrl;?>?r=user/admin">
                                    <span>Users</span>
                                    <span class="hint">Manage users that are registered at your store.</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            
            <li>
                <a class="drop">History</a>
                <div class="dropdown-column">
                    <div class="col">
                        <ul>
                            <li class="blank call">
                                <a href="<?php echo Yii::app()->homeUrl;?>?r=CallHistory/admin">
                                    <span>Call History</span>
                                    <span class="hint">View all call history.</span>
                                </a>
                            </li>
                            <li class="blank newsletters">
                            	<a href="<?php echo Yii::app()->homeUrl;?>?r=SmsHistory/admin">
                                	<span>SMS History</span>
                                    <span class="hint">View all sms history.</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
	
            <li>
	            <a href="<?php echo Yii::app()->homeUrl;?>?r=report/admin">Report</a>
            </li>
			
			<li>
				<a class="drop">Push Notification</a>
				<div class="dropdown-column">
					<div class="col">
						<ul>
							<li class="blank localizations"><a href="<?php echo Yii::app()->homeUrl;?>?r=push/admin"><span>Push Notification</span>
									<span class="hint">Create new push events and edit the existing ones.</span></a>
							</li>
						</ul>
					</div>
				</div>
            </li>
			
        </ul>
        <!--header-->
    </div>
</div>