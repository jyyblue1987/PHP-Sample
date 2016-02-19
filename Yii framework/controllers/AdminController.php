<?php

class AdminController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
        
	public $status = true;
	
	protected function getAdminNameDataColumn($data,$row)
	{
		$updateLink = Yii::app()->homeUrl . '?r=admin/update&id=' . $data->id;
		
		$theCellValue = CHtml::link( $data->username, $updateLink, array('class' => 'update'));

		return $theCellValue;
	}
	
	protected function getEmailDataColumn($data,$row)
	{           
		$theCellValue = CHtml::link( $data->email, 'mailto:' . $data->email, array('class' => ''));

		return $theCellValue;
	}
	
	protected function getStatusDataColumn($data,$row)
	{
		if( $data->status == 1 )
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
				'actions'=>array('admin', 'create','update', 'delete', 'deleteselected'),
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
		$model=new Admin;
		
		$Admin = array();
		$error = '';
		
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=admin/admin";

		if( isset($_POST['Admin']) )
		{
			$Admin = $_POST['Admin'];
			
			$error = $model->addAdmin($Admin);
		}
                
		if( !isset($_POST['Admin']) || $error==='SUCCESS' )
		{
			$Admin['email'] = '';
			$Admin['username'] = '';
			$Admin['contactno'] = '';
			$Admin['password1'] = '';
			$Admin['password2'] = '';
			$Admin['status'] = '1';
		}

		$this->render('create',array(
			'model'=>$model,
			'Admin'=>$Admin,
			'error'=>$error,
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
                
		$Admin = array();
		$error = '';
		
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=admin/admin";

		if( isset($_POST['Admin']) )
		{
			$Admin = $_POST['Admin'];

			$error = $model->saveAdmin($Admin);
		}
		else
		{
			$Admin['email'] = $model->email;
			$Admin['username'] = $model->username;
			$Admin['contactno'] = $model->contactno;
			$Admin['password1'] = '';
			$Admin['password2'] = '';
			$Admin['status'] = $model->status;
		}

		$this->render('update',array(
			'model'=>$model,
			'Admin'=>$Admin,
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
		$dataProvider=new CActiveDataProvider('Admin');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Admin('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_REQUEST['Admin']))
			$model->attributes=$_REQUEST['Admin'];

		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Admin the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Admin::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Admin $model the model to be validated
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
