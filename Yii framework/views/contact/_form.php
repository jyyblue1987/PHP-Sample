<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->textField($model,'country_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pname'); ?>
		<?php echo $form->textField($model,'pname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'pname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'homeaddr'); ?>
		<?php echo $form->textField($model,'homeaddr',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'homeaddr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'housetel'); ?>
		<?php echo $form->textField($model,'housetel',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'housetel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php echo $form->textField($model,'birthday'); ?>
		<?php echo $form->error($model,'birthday'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'class_id'); ?>
		<?php echo $form->textField($model,'class_id'); ?>
		<?php echo $form->error($model,'class_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->textField($model,'group_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->