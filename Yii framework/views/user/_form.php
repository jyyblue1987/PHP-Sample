<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

?>

<div class="mainbox-body">
    <div class="cm-tabs-content">
        <form name="profile_form" action="" method="post" class="cm-form-highlight">
            <div id="content_general">
                <fieldset>
                    <h2 class="subheader">
                        User information
                    </h2>
                    <div class="form-field" style="display:none">
                    	<input type="text" name="returnUrl" value="<?php echo $returnUrl; ?>" />
                    </div>
                    <div class="form-field">
                        <label for="name">User Name:</label>
                        <input type="text" id="name" name="User[name]" class="input-text" size="32" maxlength="50" value="<?php echo $model->name; ?>" readonly="readonly"/>
                    </div>
                    
                    <div class="form-field">
                        <label for="pname">Preferred Name:</label>
                        <input type="text" id="pname" name="User[pname]" class="input-text" size="32" maxlength="50" value="<?php echo $model->pname; ?>" readonly="readonly"/>
                    </div>

                    <div class="form-field">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="User[email]" class="input-text" size="32" maxlength="100" value="<?php echo $model->email; ?>" readonly="readonly" />
                    </div>

                    <div class="form-field">
                        <label for="contactno">Mobile:</label>
                        <input type="text" id="contactno" class="input-text" size="32" maxlength="20" value="<?php echo $model->mobile; ?>"  readonly="readonly"/>
                    </div>

					<div class="form-field">
                        <label for="country">Country:</label>
                        <input type="text" id="country" class="input-text" size="32" maxlength="100" value="<?php echo $model->country->name; ?>" readonly="readonly" />
                    </div>
                    
                    <div class="form-field">
                        <label class="cm-required">Status:</label>
                        <div class="select-field">
                            <input type="radio" name="User[status]" id="user_data_0_a"
                                <?php if( $User['status']==='1') echo 'checked="checked"'; ?>
                                   value="1" class="radio" /><label for="user_data_0_a">Active</label>
                            <input type="radio" name="User[status]" id="user_data_0_d"
                                   <?php if( $User['status']!=='1') echo 'checked="checked"'; ?>
                                   value="0" class="radio" /><label for="user_data_0_d">Inactive</label>
                        </div>
                    </div>
                </fieldset>

            </div>

            <div class="buttons-container buttons-bg cm-toggle-button">
                <span  class="submit-button cm-button-main ">
                    <input type="submit" name="dispatch[profiles.update]" value="<?php echo $buttonTitle; ?>" />
                </span>
                &nbsp;&nbsp;&nbsp;
                <span class="cm-button-main cm-process-items">
                    <input type="button" onclick="location.href = '<?php echo $returnUrl; ?>'"  value="Cancel" />
                </span>
            </div>
        </form>
    </div>
</div>