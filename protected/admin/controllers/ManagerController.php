<?php

class ManagerController extends Controller
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
				'actions'=>array('create','update','admin','delete','changeAdmin','updateMyself','checkManagerName','checkManagerEmail'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionChangeAdmin() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		if ($id) {
			$update_id = Yii::app()->user->getState('adminId');
			$time = time();
			$update_name = Manager::getManagerName($update_id);
			$status = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
			$flag = Manager::model ()->updateByPk ( $id, array ('status' => $status,'update_id'=>$update_id,'update_time'=>$time) );
			exit ( $flag.'*'.$update_name.'*'.date('Y-m-d',$time) );
		}
	}


	public function actionCreate()
	{
		$model=new Manager;

		if(isset($_POST['Manager']))
		{
			$model->attributes = CHtml::encodeArray ( $_POST ['Manager'] );
			$model->password	=	md5($_POST['Con_pwd']);
			$id = Yii::app()->user->getState('adminId');
			$model->status = 1;
			$model->entry_id = $id;
			$model->entry_time = time();
			if ($model->save ()) {
				exit (CHtml::script ( "alert('添加成功!');location.href='" . $this->createUrl ( 'manager/admin' ) . "';" ));
			} else {
				//print_r($model->errors);
				exit ( CHtml::script ( "alert('添加失败,请重试!');location.href='" . $this->createUrl ( 'manager/admin' ) . "';" ) );
			}
		}

		$this->renderpartial('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();
		
		$id = $_GET ['id'];
		if(isset($_POST['Manager']))
		{
			$oldpwd = $model->password;
			$model->attributes = CHtml::encodeArray ( $_POST ['Manager'] );
			$id = Yii::app()->user->getState('adminId');
			$model->update_id = $id;
			$model->update_time = time();
			if ($_POST['password']) {
				$model->password = md5 ( $_POST['password'] );
			} else {
				$model->password = $oldpwd;
			}
			if ($model->save ()) {
				exit ( CHtml::script ( "alert('更新成功');location.href='" . $this->createUrl ( 'manager/admin', array ('id' => $_GET ['id'] ) ) . "';" ) );
			} else {
				//print_r($model->errors);
				exit ( "<script>alert('更新失败,请重试!')</script>" );
			}
		}

		$this->renderpartial('update',array(
			'model'=>$model,
		));
	}


	public function actionDelete()
	{	
		$str = isset ( $_GET ['str'] ) ? $_GET ['str'] : '';
		$page = isset ( $_GET ['Manager_page'] ) ? $_GET ['Manager_page'] : 1;
		$search = isset ( $_GET ['Manager'] ) ? $_GET ['Manager'] : '';
		$arr = explode ( ',', $str );
		$whereStr = '';
		for($i = 0; $i < count ( $arr ); $i ++) {
			if ($i == count ( $arr ) - 1) {
				$whereStr .= 'id="' . $arr [$i] . '" ';
			} else {
				$whereStr .= 'id="' . $arr [$i] . '" or ';
			}
		}
		if (Manager::model ()->deleteAll ( $whereStr )) {
			exit ( CHtml::script ( "alert('删除成功!');location.href='" . $this->createUrl ( 'manager/admin', array ('Manager_page' => $page, 'Manager' => $search ) ) . "';" ) );
		} else
		{
			exit ( "<script>alert('删除失败,请重试!'),opener.location.reload();</script>" );
		}
	}
	
	//检查用户名返回id
	public function actionCheckManagerName() {
		$name = $_GET['name'];
		$model = Manager::model ()->find ( array ( //不能用findBySql
				'select' => 'id',
				'condition' => "name = :name",
				'params' => array (':name' => $name ),
		) );
		if ($model) {
			exit ( $model->id );
		}
	}
	
	//检查邮箱返回id
	public function actionCheckManagerEmail() {
		$id= $_GET['id'];
		$email = $_GET['email'];
		if ($id) {	//修改
			$model = Manager::model ()->find ( array ( //不能用findBySql
					'select' => 'id',
					'condition' => "email = :email and id != :id",
					'params' => array (':email' => $email,':id'=>$id )
			) );
		}else{ //添加
			$model = Manager::model ()->find ( array ( //不能用findBySql
					'select' => 'id',
					'condition' => "email = :email",
					'params' => array (':email' => $email)
			) );
		}
	
		exit ( $model->id );
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Manager('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Manager']))
			$model->attributes=$_GET['Manager'];
		$paramArr = array();
		if($_GET ['Manager'] && array_filter($_GET ['Manager'])){
			$paramArr['Manager'] = $_GET ['Manager'];
		}
		if($_GET['Manager_page']){
			$paramArr['Manager_page'] = $_GET['Manager_page'];
		}
		$this->render('admin',array(
			'model'=>$model,
			'search'=> $_GET ['Manager'],
			'paramArr' => $paramArr
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
				$this->_model=Manager::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='manager-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
