<?php
/* @var $this CallHistoryController */
/* @var $model CallHistory */

$this->breadcrumbs=array(
	'Call Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CallHistory', 'url'=>array('index')),
	array('label'=>'Create CallHistory', 'url'=>array('create')),
	array('label'=>'Update CallHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CallHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CallHistory', 'url'=>array('admin')),
);
?>

<h1>View CallHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from',
		'to',
		'starttime',
		'endtime',
	),
)); ?>
