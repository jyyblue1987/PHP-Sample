<?php
/* @var $this ClassificationController */
/* @var $model Classification */
/* @var $form CActiveForm */

?>

<div class="mainbox-body">
    <div class="cm-tabs-content">
        <form name="profile_form" action="" method="post" class="cm-form-highlight">
            <div id="content_general">
                <fieldset>
                    <h2 class="subheader">
                        Classification information
                    </h2>
                    <div class="form-field" style="display:none">
                    	<input type="text" name="returnUrl" value="<?php echo $returnUrl; ?>" />
                    </div>
                    <div class="form-field">
                        <label for="username" class="cm-required">Classification Name:</label>
                        <input type="text" id="username" name="Classification[name]" class="input-text" size="32" maxlength="50" value="<?php echo $Classification['name']; ?>" />
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