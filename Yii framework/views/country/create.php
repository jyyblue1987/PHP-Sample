<?php
/* @var $this CountryController */
/* @var $model Country */

if( $error === 'SUCCESS' )
    Functions::alertSuccessMessage('');
else if( $error !== '' )
    Functions::alertErrorMessage ($error);

$this->renderPartial('_header',array(
	'title'=>'New Country',
));
?>

<?php
    $this->renderPartial('_form', array(
        'model'=>$model,
        'Country'=>$Country,
        'buttonTitle'=>'Create',
        'returnUrl'=>$returnUrl,
    ));
?>