<?php

class ContactController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	
	protected function getNameDataColumn($data,$row)
	{
		if( isset($data->user) )
		{
			$viewLink = Yii::app()->homeUrl . '?r=user/view&id=' . $data->id;
		
			$theCellValue = CHtml::link( $data->user->name, $viewLink, array('class' => 'view'));
		}
		else
			$theCellValue = "-";

		return $theCellValue;
	}
	
	protected function getMobileDataColumn($data,$row)
	{           
		$viewLink = Yii::app()->homeUrl . '?r=user/contact&id=' . $data->id;
		
		$theCellValue = CHtml::link( $data->mobile, $viewLink, array('class' => 'view'));

		return $theCellValue;
	}
	
	protected function getEmailDataColumn($data,$row)
	{
		if( isset($data->user) )
		{
			$theCellValue = CHtml::link( $data->user->email, 'mailto:' . $data->user->email, array('class' => ''));
		}
		else
			$theCellValue = "-";

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
	
	protected function getStatusDataColumn($data,$row)
	{
		if( !isset($data->user) )
		{
			$theCellValue = '-';
		}
		else if( $data->user->status == 1 )
		{
			$theCellValue = 'Active';
		}
		else
		{
			$theCellValue = 'Inactive';
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
				'actions'=>array('create','update','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Contact;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contact']))
		{
			$model->attributes=$_POST['Contact'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contact']))
		{
			$model->attributes=$_POST['Contact'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Contact');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{
		//$this->createContactView($id);
	
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=user/admin";

		$model = Contact::modelById($id);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
			
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('admin',array(
			'model'=>$model,
			'id'=>$id,
			'returnUrl'=>$returnUrl,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Contact the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Contact::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Contact $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contact-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
