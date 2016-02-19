<?php
/* @var $this SmsHistoryController */
/* @var $model SmsHistory */

$this->breadcrumbs=array(
	'Sms Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SmsHistory', 'url'=>array('index')),
	array('label'=>'Manage SmsHistory', 'url'=>array('admin')),
);
?>

<h1>Create SmsHistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>