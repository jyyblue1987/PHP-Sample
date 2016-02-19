<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<table cellpadding="0" cellspacing="0" border="0" class="content-table">
    <tr valign="top">
        <td width="1px" class="side-menu">
            <div id="right_column">
            </div>
        </td>
        <td class="login-page">

            <div id="main_column_login" class="clear">
                <div class="login-wrap">
                    <h1 class="clear">
                        <a href="index.php" class="float-left">Phone Book</a>
                        <span>login pannel</span>
                    </h1>
                    <form action="<?php echo Yii::app()->request->requestUri; ?>" method="post" name="LoginForm" class="cm-form-highlight cm-skip-check-items">
                        <div class="login-content">
                            <div class="clear-form-field">
                                <p><label for="email" class="cm-required cm-email">Email:</label></p>
                                <input id="email" type="text" name="LoginForm[username]" size="20" class="input-text cm-focus" tabindex="1" value=<?PHP echo $model->username; ?> ></input>
                            </div>
                            <div class="clear-form-field">
                                <p><label for="password" class="cm-required">Password:</label></p>
                                <input type="password" id="password" name="LoginForm[password]" size="20" class="input-text" tabindex="2" value=<?PHP if($model->password!=="") echo $model->password; ?> ></input>
                            </div>
                            <div class="buttons-container nowrap">
                                <div class="float-left">
                                    <span  class="submit-button cm-button-main ">
                                        <input type="submit" name="dispatch[auth.login]" value="Login" tabindex="3" />
                                    </span>
                                </div>
                                <div class="float-right">
                                    <a href="forget_password.php" class="underlined">Forgot your password?</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--main_column_login-->
            </div>
        </td>
    </tr>
</table>

<div class="cm-notification-container cm-notification-container-top">
     <?PHP
        if( $model->errorCode !== UserIdentity::ERROR_NONE )
        {
            Functions::alertErrorMessageByID('ACCOUNT_USER_OR_PASS_INVALID');
        }
    ?>
</div>