<?php

class UserController extends Controller
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
	
	protected function getEmailDataColumn($data,$row)
	{           
		$theCellValue = CHtml::link( $data->email, 'mailto:' . $data->email, array('class' => ''));

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
				'actions'=>array('create','update', 'contact', 'admin','delete','deleteselected'),
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
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
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
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
			
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/*
	public function createContactView($id)
	{
		$contact_tbl = 'contact_' . $id;
		
		$queryCommand = "create or replace view contact as select A.group_id, user.* from " . $contact_tbl . " as A";
		$queryCommand = $queryCommand . " left join user on user.mobile = A.mobile";
           
		Yii::app()->db->createCommand($queryCommand)->query();
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
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
