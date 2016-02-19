<?php
/* @var $this SmsHistoryController */
/* @var $model SmsHistory */

 	header('Content-type: application/json');
 
		 echo CJSON::encode($response);
		
		 Yii::app()->end();

?>