<?php
/* @var $this SmsHistoryController */
/* @var $model SmsHistory */

$this->breadcrumbs=array(
	'Sms Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SmsHistory', 'url'=>array('index')),
	array('label'=>'Create SmsHistory', 'url'=>array('create')),
	array('label'=>'View SmsHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SmsHistory', 'url'=>array('admin')),
);
?>

<h1>Update SmsHistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>