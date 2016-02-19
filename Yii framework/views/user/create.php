<?php
/* @var $this AdminController */
/* @var $model Admin */

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>'New profile (Administrator)',
));
?>

<?php
    $this->renderPartial('_form', array(
        'model'=>$model,
        'Admin'=>$Admin,
        'buttonTitle'=>'Create',
        'returnUrl'=>$returnUrl,
    ));
?>