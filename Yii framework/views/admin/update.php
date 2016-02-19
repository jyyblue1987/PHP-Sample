<?php
/* @var $this AdminController */
/* @var $model Admin */

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>'Edit Profile : ' . $model->username,
));
?>

<?php
    $this->renderPartial('_form', array(
        'model'=>$model,
        'Admin'=>$Admin,
        'buttonTitle'=>'Save',
        'returnUrl'=>$returnUrl,
    ));
?>