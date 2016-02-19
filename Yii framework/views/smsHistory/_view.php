<?php
/* @var $this SmsHistoryController */
/* @var $data SmsHistory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from')); ?>:</b>
	<?php echo CHtml::encode($data->from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to')); ?>:</b>
	<?php echo CHtml::encode($data->to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sendtime')); ?>:</b>
	<?php echo CHtml::encode($data->sendtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receivetime')); ?>:</b>
	<?php echo CHtml::encode($data->receivetime); ?>
	<br />


</div>