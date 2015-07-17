<?php

class MessageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

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
				'actions'=>array('create','update','admin','changeStatus','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	
	/**
	 * 修改审核状态
	 */
	public function actionChangeStatus() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		if ($id) {
			$update_id = Yii::app()->user->getState('adminId');
			$time = time();
			$update_name = Yii::app ()->user->getState ( 'adminInfo' )->name;
			$status = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
			$flag = Message::model ()->updateByPk ( $id, array ('status' => $status,'update_id'=>$update_id,'update_time'=>$time) );
			exit ( $flag.'*'.$update_name.'*'.date('Y-m-d',$time) );
		}
	}
	
	//检查用户名返回id
	public static function actionCheckMessageName() {
		$name = $_GET['name'];
		$model = Message::model ()->find ( array ( //不能用findBySql
				'select' => 'id',
				'condition' => "title = :title",
				'params' => array (':title' => $name ),
		) );
		if ($model) {
			return $model->id ;
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Message;
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		if($method == 'create')
		{
			$id = Yii::app()->user->getState('adminId');
			$model->content=$_POST['content'];
			$model->status = 1;
			$model->groupid = -1;
			$model->type = 'text';
			$model->entry_id = $id;
			$model->entry_time = time();
			if($model->save()){
				exit(CHtml::script ( "alert('添加成功');location.href='".$this->createUrl('message/admin')."';" ));
			}else{
				exit(print_r($model->errors));
				exit(CHtml::script ( "alert('添加失败请重试');location.href='".$this->createUrl('message/admin')."';" ));
			}
		}

		$this->renderPartial('create',array(
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
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		if($method == 'update')
		{
			$url = isset($_POST['url']) ? $_POST['url'] : '';
			$id = Yii::app()->user->getState('adminId');
			$model->content=$_POST['content'];
			$model->update_id = $id;
			$model->update_time = time();
			if($model->save()){
				exit(CHtml::script ( "alert('修改成功');location.href='".$url."';" ));
			}else{
				exit(CHtml::script ( "alert('修改失败请重试');location.href='".$url."';" ));
			}
		}
		$divContent = Message::model()->showEmotions($model->content);
		$this->renderPartial('update',array(
			'model'=>$model,
			'divContent' => $divContent,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		$str = isset ( $_POST ['str'] ) ? $_POST ['str'] : '';
		$arr = explode ( ',', $str );
		$whereStr = '';
		for($i = 0; $i < count ( $arr ); $i ++) {
			if ($i == count ( $arr ) - 1) {
				$whereStr .= 'id="' . $arr [$i] . '" ';
			} else {
				$whereStr .= 'id="' . $arr [$i] . '" or ';
			}
		}
		$url = isset ( $_POST ['url'] ) ? $_POST ['url'] : '';
		
		if (Message::model ()->deleteAll ( $whereStr )) {
			exit ( CHtml::script ( "alert('删除成功!');location.href='" . $url . "';" ) );
		} else
		{
			exit ( "<script>alert('删除失败,请重试!');location.href='" . $url . "';</script>" );
		}
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Message('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['message']))
			$model->attributes=$_GET['message'];
		$this->render('admin',array(
			'model'=>$model,
			'search'=> $_GET ['message'],
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
				$this->_model=Message::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='message-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
