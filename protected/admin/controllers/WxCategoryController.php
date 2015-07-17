<?php

class WxCategoryController extends Controller
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
				'actions'=>array('admin','create','update','delete','checkCateName','checkDelete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCheckDelete(){
		$str = isset($_GET['str']) ? $_GET['str'] : '';
		if($str){
			$arr = explode ( ',', $str );
			$whereStr = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				if ($i == count ( $arr ) - 1) {
					$whereStr .= 'cate_id="' . $arr [$i] . '" ';
				} else {
					$whereStr .= 'cate_id="' . $arr [$i] . '" or ';
				}
			}
			$count = MenuMsg::model()->count($whereStr);
			if($count > 0){
				exit('分类正在被使用，不能删除');
			}
			exit('0');
		}
	}
	
	//检查名称返回id
	public function actionCheckCateName() {
		$name = $_GET['name'];
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$criteria=new CDbCriteria;
		$criteria->select = 'id';
		$criteria->condition = "name = :name";
		$criteria->params = array (':name' => $name );
		if(is_numeric($id)){
			$criteria->addCondition('id != :id');
			$criteria->params[':id'] = $id;
		}
		$model = WxCategory::model ()->find ($criteria);
		if ($model) {
			exit ( $model->id );
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WxCategory;

		if(isset($_POST['WxCategory']))
		{
			$model->attributes = CHtml::encodeArray ( $_POST ['WxCategory'] );
			$model->property = 'normal';
			$id = Yii::app()->user->getState('adminId');
			$model->entry_id = $id;
			$model->entry_time = time();
			if ($model->save ()) {
				exit (CHtml::script ( "alert('添加成功!');location.href='" . $this->createUrl ( 'wxCategory/admin' ) . "';" ));
			} else {
				//print_r($model->errors);
				exit ( CHtml::script ( "alert('添加失败,请重试!');location.href='" . $this->createUrl ( 'wxCategory/admin' ) . "';" ) );
			}
		}

		$this->renderpartial('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WxCategory']))
		{
			$url = isset($_POST['url']) ? $_POST['url'] : '';
			$model->attributes=CHtml::encodeArray ( $_POST ['WxCategory'] );
			$id = Yii::app()->user->getState('adminId');
			$model->update_id = $id;
			$model->update_time = time();
			if($model->save())
				exit(CHtml::script ( "alert('修改成功');window.location.href='".$url."';" ));
			else{
				exit(CHtml::script ( "alert('修改失败');window.location.href='".$url."';" ));
			}
		}

		$this->renderPartial('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		$str = isset($_POST['str']) ? $_POST['str'] : '';
		if($str){
			$url = isset($_POST['url']) ? $_POST['url'] : '';
			$arr = explode ( ',', $str );
			$whereStr = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				if ($i == count ( $arr ) - 1) {
					$whereStr .= 'id="' . $arr [$i] . '" ';
				} else {
					$whereStr .= 'id="' . $arr [$i] . '" or ';
				}
			}
			if(WxCategory::model()->deleteAll($whereStr)){
				exit(CHtml::script ( "alert('删除成功');window.location.href='".$url."';" ));
			}else{
				exit(CHtml::script ( "alert('删除失败');window.location.href='".$url."';" ));
			}
		}
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new WxCategory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WxCategory']))
			$model->attributes=$_GET['WxCategory'];

		$this->render('admin',array(
			'model'=>$model,
			'search'=> $_GET ['WxCategory'],
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
				$this->_model=WxCategory::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-wx-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
