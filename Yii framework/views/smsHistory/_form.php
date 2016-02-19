<?php
/* @var $this SmsHistoryController */
/* @var $model SmsHistory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sms-history-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php echo $form->textField($model,'to',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sendtime'); ?>
		<?php echo $form->textField($model,'sendtime',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'sendtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receivetime'); ?>
		<?php echo $form->textField($model,'receivetime',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'receivetime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->