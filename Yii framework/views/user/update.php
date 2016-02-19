<?php
/* @var $this AdminController */
/* @var $model Admin */

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>'Edit User : ' . $model->name,
));
?>

<?php
    $this->renderPartial('_form', array(
        'model'=>$model,
        'User'=>$User,
        'buttonTitle'=>'Save',
        'returnUrl'=>$returnUrl,
    ));
?>