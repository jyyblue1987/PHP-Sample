<?php

class ClassificationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	
	protected function getNameDataColumn($data,$row)
	{
		$updateLink = Yii::app()->homeUrl . '?r=classification/update&id=' . $data->id;
		
		$theCellValue = CHtml::link( $data->name, $updateLink, array('class' => 'update'));

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
		$model=new Classification;
		
		$Classification = array();
		$error = '';
		
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=classification/admin";

		if( isset($_POST['Classification']) )
		{
			$Classification = $_POST['Classification'];
			
			$error = $model->addClassification($Classification);
		}
                
		if( !isset($_POST['Classification']) || $error==='SUCCESS' )
		{
			$Classification['name'] = '';
		}

		$this->render('create',array(
			'model'=>$model,
			'Classification'=>$Classification,
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
                
		$Classification = array();
		$error = '';
		
		if( isset($_REQUEST['returnUrl']) )
			$returnUrl = $_REQUEST['returnUrl'];
		else
			$returnUrl = Yii::app()->homeUrl . "?r=classification/admin";

		if( isset($_POST['Classification']) )
		{
			$Classification = $_POST['Classification'];
			
			$error = $model->saveClassification($Classification);
		}
		else
		{
			$Classification['name'] = $model->name;
		}

		$this->render('update',array(
			'model'=>$model,
			'Classification'=>$Classification,
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
		$dataProvider=new CActiveDataProvider('Classification');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Classification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Classification']))
			$model->attributes=$_GET['Classification'];
			
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
	 * @return Classification the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Classification::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Classification $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='classification-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
