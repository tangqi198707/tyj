<?php

class MenuController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('checkAdd','create','update','admin','delete','order','getMenuJson','createWxMenu'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionGetMenuJson(){
		exit(Menu::model()->getMenuJson());
	}
	
	public function actionCreateWxMenu(){
		$wechatObj = new WechatCallbackapiIsd();
		$json = Menu::model()->getWxMenuJson();
		if($json == 'null menu' || $json == 'no response'){
			exit($json);
		}
		//exit('{"errcode":0,"errmsg":"ok"}');
		exit($wechatObj->createMenu($json));
	}
	
	public function actionOrder(){
		$str = isset($_GET['str']) ? $_GET['str'] : '';
		if($str){
			$json = json_decode($str);
			foreach($json as $key => $val){
				if(is_numeric($val->id) && is_numeric($val->weight)){
					$model = Menu::model()->findByPk($val->id);
					$model->weight = $val->weight;
					if(!$model->save()){
						exit('f');
					}
				}else{
					exit('f');					
				}
			}
			exit('s');
		}
	}

	public function actionCheckAdd(){
		$type = $_GET['type'] ? $_GET['type'] : '';
		if($type){
			if($type == 'parent'){
				$count = Menu::model()->count('status = 1 and pid = 0');
				if($count < 3){
					exit('s');
				}
			}else if($type == 'child'){
				$pid = $_GET['pid'] ? $_GET['pid'] : '';
				if(is_numeric($pid)){
					$count = Menu::model()->count(array(
						'condition' => 'status = 1 and pid = :pid',
						'params' => array(':pid' => $pid),
					));
					if($count < 5){
						exit('s');
					}
				}
			}
			exit('f');
		}
	}
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Menu;
		if(isset($_POST['name']))
		{
			$model->name = CHtml::encode($_POST['name']);
			$model->pid = $_POST['pid'];
			$model->weight = $_POST['order'];
			$model->entry_id = Yii::app()->user->getState('adminId');
			$model->entry_time = time();
			if($model->save())
				echo $model->id;
			else
				echo "0";
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		if(isset($_POST['name']) && is_numeric($_POST['id']))
		{
			$model=Menu::model()->findByPk($_POST['id']);
			$model->name = CHtml::encode($_POST['name']);
			$model->update_id = Yii::app()->user->getState('adminId');
			$model->update_time = time();
			if($model->save()){
				exit('s');
			}else{
				exit('f');
			}
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		$id = $_GET['id'];
		if(is_numeric($id))
		{
			$count = Menu::model()->updateAll(array('status'=>0),"id = :id or pid = :pid",array(':id'=>$id,':pid'=>$id));
			if($count > 0){
				exit('s');
			}else{
				exit('f');
			}
		}
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		/*$json = Menu::model()->getWxMenuJson();
		var_dump($json);
		exit;*/
		$model = Menu::model()->findAll(array(
			'condition' => 'pid = 0 and status = 1',
			'order' => 'weight'
		));
		$menuJson = Menu::model()->getMenuJson();
		//exit($menuJson);
		$this->render('admin',array(
			'model'=>$model,
			'menuJson' => $menuJson
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Menu::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
