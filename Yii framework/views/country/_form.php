<?php
/* @var $this CountryController */
/* @var $model Country */
/* @var $form CActiveForm */
?>

<div class="mainbox-body">
    <div class="cm-tabs-content">
        <form name="profile_form" action="" method="post" class="cm-form-highlight">
            <div id="content_general">
                <fieldset>
                    <h2 class="subheader">
                        Country information
                    </h2>
                    <div class="form-field" style="display:none">
                    	<input type="text" name="returnUrl" value="<?php echo $returnUrl; ?>" />
                    </div>
                    <div class="form-field">
                        <label for="username" class="cm-required">Country Name:</label>
                        <input type="text" id="username" name="Country[name]" class="input-text" size="32" maxlength="50" value="<?php echo $Country['name']; ?>" />
                    </div>

                    <div class="form-field">
                        <label for="contactno" class="cm-required">Phone Prefix</label>
                        <input type="text" id="contactno" name="Country[phone_prefix]" class="input-text" size="32" maxlength="4" value="<?php echo $Country['phone_prefix']; ?>" />
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