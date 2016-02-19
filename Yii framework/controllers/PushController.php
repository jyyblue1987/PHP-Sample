<?php

require_once('push_message.php');

class PushController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	
	protected function getNameDataColumn($data,$row)
	{
		$viewLink = Yii::app()->homeUrl . '?r=user/view&id=' . $data->id;
		
		if( $data->name !== '' )
			$label = $data->name;
		else
			$label = '&nbsp;';//'unnamed';
		
		$theCellValue = CHtml::link( $label, $viewLink, array('class' => 'update'));

		return $theCellValue;
	}
	
	protected function getMobileDataColumn($data,$row)
	{           
		$viewLink = Yii::app()->homeUrl . '?r=contact/admin&id=' . $data->id;
		
		$theCellValue = CHtml::link( $data->mobile, $viewLink, array('class' => 'view'));

		return $theCellValue;
	}
	
	protected function getMessageDataColumn($data,$row)
	{           
		$theCellValue = $data->message;

		return $theCellValue;
	}
	
		
	protected function getSendMessageColumn($data,$row)
	{           
		$viewLink = Yii::app()->homeUrl . '?r=push/send&id=' . $data->id;
		$theCellValue = CHtml::link( "Send", $viewLink, array('class' => 'view'));

		return $theCellValue;
	}

	protected function getDeleteMessageColumn($data,$row)
	{           
		$viewLink = Yii::app()->homeUrl . '?r=push/delete&id=' . $data->id;
		//$theCellValue = '&nbsp;&nbsp;|  ' . CHtml::link( "Delete", $viewLink, array('class' => 'view'));
		
		$theCellValue = '&nbsp;&nbsp;|  ' . CHtml::link( CHtml::encode('Delete'), array('push/delete', 'id'=>$data->id),
		  array(
			'submit'=>array('push/delete', 'id'=>$data->id),
			'class' => 'delete','confirm'=>'This will remove the push message. Are you sure?'
		  )
		);


		return $theCellValue;
	}
	
	protected function getClassDataColumn($data,$row)
	{           
		if( isset( $data->classification->name ) )
		{
			$theCellValue = $data->classification->name;
		}
		else
		{
			$theCellValue = '';
		}

		return $theCellValue;
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations			
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'contact', 'admin','delete','deleteselected', 'send'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'deleteselected'),
				'users'=>array('admin@gmail.com'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=user/admin";
			
		$model = User::model()->findByPk($id);

		$this->render('view',array(
			'model'=>$model,
			'returnUrl'=>$returnUrl,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Push;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$push = array();
		$error = '';
		
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=push/admin";
		
		if(isset($_POST['Push']))
		{
			$push = $_POST['Push'];
			
			$error = $model->addPush($push);	
			
			if( $push['status'] === '0' ) // send
				$this->sendPushMessage($push['message']);			
		}
		
		if( !isset($_POST['Push']) || $error==='SUCCESS' )
		{
			$push['message'] = '';
			$push['status'] = '1';
		}
		
		$this->render('create',array(
			'model'=>$model,
			'error'=>$error,
			'push' => $push,
			'returnUrl'=>$returnUrl,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		        
		$User = array();
		$error = '';
		
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=user/admin";

		if( isset($_POST['User']) )
		{
			$User = $_POST['User'];
			
			$error = $model->saveUser($User);
		}
		else
		{
			$User['status'] = $model->status;
		}

		$this->render('update',array(
			'model'=>$model,
			'User'=>$User,
			'error'=>$error,
			'returnUrl'=>$returnUrl,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionDeleteselected()
	{
		$selected_ids = $_POST['selected_ids'];

		foreach( $selected_ids as $id )
		{
			$this->loadModel($id)->delete();
		}
		
		//$this->actionAdmin();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Push('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Push']))
			$model->attributes=$_GET['Push'];
			
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		
		$error = '';
		if (isset($_GET['error'])) {
			$error = $_GET['error'];
		}
		
		$this->render('admin',array(
			'model'=>$model,
			'error'=>$error,
		));
	}
	
	public function actionSend($id)
	{
		$model=$this->loadModel($id);
		$message = $model->message;
		
		$this->sendPushMessage($message);
		
		$error = 'SUCCESS';

		$this->redirect(array('admin','error'=>$error));
		
	}
	
	private function sendPushMessage($message)
	{
		$android_users = User::model()->findAll('device=?',array('android'));
		$ios_users = User::model()->findAll('device=?',array('iphone'));
		
		$gcm_key = array();
		foreach( $android_users as $android )
		{
			$pushkey = $android->pushkey;
			if( empty($pushkey) )
				continue;
			$gcm_key[] = $pushkey;
		}		
		
		$apn_key = array();
		foreach( $ios_users as $ios )
		{
			$pushkey = $ios->pushkey;
			if( empty($pushkey) )
				continue;
			$apn_key[] = $pushkey;
		}		
		
		//var_dump($gcm_key);
		
		$ret1 = push2Android($gcm_key, $message);
		$ret2 = push2IPhone($apn_key, $message);	
	}
	
	protected function getStatusDataColumn($data,$row)
	{
		if( $data->status == 0 )
		{
			$theCellValue = 'Sent';
		}
		else
		{
			$theCellValue = 'Draft';
		}

		return $theCellValue;
	}
	
	public function loadModel($id)
	{
		$model=Push::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
