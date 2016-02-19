<?php
/* @var $this SmsHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sms Histories',
);

$this->menu=array(
	array('label'=>'Create SmsHistory', 'url'=>array('create')),
	array('label'=>'Manage SmsHistory', 'url'=>array('admin')),
);
?>

<h1>Sms Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
