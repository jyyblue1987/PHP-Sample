<?php
/* @var $this CallHistoryController */
/* @var $model CallHistory */

$this->breadcrumbs=array(
	'Call Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CallHistory', 'url'=>array('index')),
	array('label'=>'Manage CallHistory', 'url'=>array('admin')),
);
?>

<h1>Create CallHistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>