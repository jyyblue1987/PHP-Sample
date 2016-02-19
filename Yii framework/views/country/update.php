<?php
/* @var $this AdminController */
/* @var $model Admin */

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>'Edit Country : ' . $model->name,
));
?>

<?php
    $this->renderPartial('_form', array(
        'model'=>$model,
        'Country'=>$Country,
        'buttonTitle'=>'Save',
        'returnUrl'=>$returnUrl,
    ));
?>