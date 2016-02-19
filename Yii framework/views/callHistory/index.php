<?php
/* @var $this CallHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Call Histories',
);

$this->menu=array(
	array('label'=>'Create CallHistory', 'url'=>array('create')),
	array('label'=>'Manage CallHistory', 'url'=>array('admin')),
);
?>

<h1>Call Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
