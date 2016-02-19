<?php
/* @var $this AdminController */
/* @var $model Admin */

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>'New Push',
));
?>

<?php
    $this->renderPartial('_form', array(
        'model'=>$model,
        'push'=>$push,
        'buttonTitle'=>'Create',
        'returnUrl'=>$returnUrl,
    ));
?>