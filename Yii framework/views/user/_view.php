<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode($data->country_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pname')); ?>:</b>
	<?php echo CHtml::encode($data->pname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('homeaddr')); ?>:</b>
	<?php echo CHtml::encode($data->homeaddr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('housetel')); ?>:</b>
	<?php echo CHtml::encode($data->housetel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthday')); ?>:</b>
	<?php echo CHtml::encode($data->birthday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vcode')); ?>:</b>
	<?php echo CHtml::encode($data->vcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reg_stamp')); ?>:</b>
	<?php echo CHtml::encode($data->reg_stamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login_stamp')); ?>:</b>
	<?php echo CHtml::encode($data->login_stamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_online')); ?>:</b>
	<?php echo CHtml::encode($data->is_online); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secure_key')); ?>:</b>
	<?php echo CHtml::encode($data->secure_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class_id')); ?>:</b>
	<?php echo CHtml::encode($data->class_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photo_name')); ?>:</b>
	<?php echo CHtml::encode($data->photo_name); ?>
	<br />

	*/ ?>

</div>