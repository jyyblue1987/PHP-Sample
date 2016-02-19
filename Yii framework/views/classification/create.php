<?php
/* @var $this ClassificationController */
/* @var $model Classification */

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>'New Classification',
));
?>

<?php
    $this->renderPartial('_form', array(
        'model'=>$model,
        'Classification'=>$Classification,
        'buttonTitle'=>'Create',
        'returnUrl'=>$returnUrl,
    ));
?>