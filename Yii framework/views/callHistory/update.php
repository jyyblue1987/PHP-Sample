<?php
/* @var $this CallHistoryController */
/* @var $model CallHistory */

$this->breadcrumbs=array(
	'Call Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CallHistory', 'url'=>array('index')),
	array('label'=>'Create CallHistory', 'url'=>array('create')),
	array('label'=>'View CallHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CallHistory', 'url'=>array('admin')),
);
?>

<h1>Update CallHistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>