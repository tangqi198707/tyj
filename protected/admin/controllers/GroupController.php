<?php

class GroupController extends Controller
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
				'actions'=>array('create','addKeyword','addMsg','updateKeyword','updateMsg','update','admin','delete','changeAdmin_t',
				'changeAdmin_s','checkGroupName','checkGroupKey','changeKeyword_s','changeMessage_s'),
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
	public function actionChangeAdmin_t() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		if ($id) {
			$type = isset ( $_GET ['type'] ) ? $_GET ['type'] : '';
			$flag = Group::model ()->updateByPk ( $id, array ('type' => $type) );
			exit ( $flag );
		}
	}
	
	public function actionChangeAdmin_s() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		if ($id) {
			$status = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
			$flag = Group::model ()->updateByPk ( $id, array ('status' => $status) );
			exit ( $flag );
		}
	}
	/**
	 * 修改关键字审核状态
	 */
	public function actionChangeKeyword_s() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		if ($id) {
			$status = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
			$flag = Keyword::model ()->updateByPk ( $id, array ('status' => $status) );
			exit ( $flag );
		}
	}
	/**
	 * 修改回复审核状态
	 */
	public function actionChangeMessage_s() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		if ($id) {
			$status = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
			$flag = Message::model ()->updateByPk ( $id, array ('status' => $status) );
			exit ( $flag );
		}
	}
	
	//检查规则名返回id
	public function actionCheckGroupName() {
		$id = trim($_GET['id']);
		$name = $_GET['name'];
		if($id){
			$model = Group::model ()->find ( array ( //不能用findBySql
					'select' => 'id',
					'condition' => "name = :name and id != :id",
					'params' => array (':name' => $name,':id'=>$id )
			));
		}else{
			$model = Group::model ()->find ( array ( //不能用findBySql
				'select' => 'id',
				'condition' => "name = :name",
				'params' => array (':name' => $name ),
		) );
		}
		if ($model) {
			exit($model->id);
		}
	}
	//检查关键字返回id
	public function actionCheckGroupKey() {
		$id = trim($_GET['id']);
		$kwId = explode('@!@', $id);
		$name = $_GET['name'];
		$kwArr = explode('@!@', $name);
		$nameStr = ' ';
		if($id){
			foreach($kwArr as $k=>$val){
				$model = Keyword::model ()->find ( array ( //不能用findBySql
						'select' => 'name',
						'condition' => "name = :name and id != :id",
						'params' => array (':name' => $val ,':id' => $kwId[$k]),
				) );
				if($model)
					$nameStr .= $model->name.' ';
			}
		}else{
			foreach($kwArr as $val){
				$model = Keyword::model ()->find ( array ( //不能用findBySql
						'select' => 'name',
						'condition' => "name = :name",
						'params' => array (':name' => $val ),
				) );
				if($model)
					$nameStr .= $model->name.' ';
			}
		}
		exit(trim($nameStr));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Group;

		if(isset($_POST['Group']))
		{
			//print_r($_POST);exit;
			$transaction = $model->dbConnection->beginTransaction();
			try {
				$time = time();
				$id = Yii::app()->user->getState('adminId');
				$model->attributes=$_POST['Group'];
				$model->entry_id = $id;
				$model->entry_time = $time;
				if (!$model->save()) {
					throw new Exception('error_create_group');
				}
				foreach($_POST['keywordName'] as $key => $val){
					$keyword = new Keyword;
					$keyword->name = $val;
					$keyword->groupid = $model->id;
					$keyword->status = isset($_POST['keywordStatus']) ? $_POST['keywordStatus'][$key] : '';
					$keyword->entry_id = $id;
					$keyword->entry_time = $time;
					if (!$keyword->save()) {
						throw new Exception('error_create_keyword');
					}
				}
				foreach($_POST['msgContent'] as $key => $val){
					$message = new Message;
					$message->type = isset($_POST['msgType']) ? $_POST['msgType'][$key] : '';
					$message->content = str_replace("\n","<br>",$val);
					$message->groupid = $model->id;
					$message->status = isset($_POST["msgStatus"]) ? $_POST["msgStatus"][$key] : '';
					$message->entry_id = $id;
					$message->entry_time = $time;
					if (!$message->save()) {
						print_r($message->getErrors());
						throw new Exception('error_create_message');
					}
				}
				$transaction->commit();
				exit( "<script>alert('添加成功!');location.href='".$this->createUrl('group/admin')."';</script>" );
			} catch (Exception $e) {
				$transaction->rollBack();
				$msg = $e->getMessage();
				//exit($msg);
				exit( "<script>alert('添加失败,请重试!');location.href='".$this->createUrl('group/admin')."';</script>" );
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$id=$_GET['id'];
		$whereStr = 'id="' . $id . '" ';
		$whereStr2 = 'groupid="' . $id . '" ';
		$model=$this->loadModel();
		//exit(print_r($_POST));
		if(isset($_POST['Group']))
		{
			$url = isset($_POST['url']) ? $_POST['url'] : '';
			$transaction = $model->dbConnection->beginTransaction();
			try {
				$time = time();
				$id = Yii::app()->user->getState('adminId');
				$model->attributes=$_POST['Group'];
				$model->update_id = $id;
				$model->update_time = $time;
				if (!$model->save()) {
					throw new Exception('error_update_group');
				}
				if($_POST['keywordId']){
					foreach($model->keywords as $val){
						if(!in_array($val->id,$_POST['keywordId'])){
							if (!$val->delete()) {
								throw new Exception('error_deletel_keyword');
							}
						}
					}
				}else{
					if($model->keywords){
						if (!Keyword::model ()->deleteAll ( $whereStr2 )) {
							throw new Exception('error_deletel_keyword_all');
						}
					}
				}
				foreach($_POST['keywordName'] as $key => $val){
					if($_POST['keywordId'][$key])
						$keyword = Keyword::model()->findByPk($_POST['keywordId'][$key]);
					else
						$keyword = new Keyword;
					$keyword->name = $val;
					$keyword->groupid = $model->id;
					$keyword->status = isset($_POST['keywordStatus']) ? $_POST['keywordStatus'][$key] : '';
					if($keyword->entry_id)
						$keyword->update_id = $id;
					else
						$keyword->entry_id = $id;
					if($keyword->entry_time)
						$keyword->update_time = $time;
					else
						$keyword->entry_time = $time;
					if (!$keyword->save()) {
						//exit(print_r($keyword->getErrors()));
						throw new Exception('error_update_keyword');
					}
				}
				if($_POST['msgId']){
					foreach($model->messages as $val){
						if(!in_array($val->id,$_POST['msgId'])){
							if (!$val->delete()) {
								throw new Exception('error_deletel_message');
							}
						}
					}
				}else{
					foreach($model->messages as $val){
						if (!$val->delete()) {
							throw new Exception('error_delete_message_all');
						}
					}
				}
				foreach($_POST['msgContent'] as $key => $val){
					if($_POST['msgId'][$key]){
						$message = Message::model()->findByPk($_POST['msgId'][$key]);
					}else{
						$message = new Message;
					}
					$message->type = isset($_POST['msgType']) ? $_POST['msgType'][$key] : '';
					$message->content = str_replace("\n","<br>",$val);
					
					$message->groupid = $model->id;
					$message->status = isset($_POST["msgStatus"]) ? $_POST["msgStatus"][$key] : '';
					if($message->entry_id)
						$message->update_id = $id;
					else
						$message->entry_id = $id;
					if($message->entry_time)
						$message->update_time = $time;
					else
						$message->entry_time = $time;
					if (!$message->save()) {
						print_r($message->getErrors());
						throw new Exception('error_update_message');
					}
				}
				$transaction->commit();
				exit ( CHtml::script ( "alert('更新成功');location.href='" . $url . "';" ) );
			} catch (Exception $e) {
				$transaction->rollBack();
				$msg = $e->getMessage();
				//exit($msg);
				exit( "<script>alert('修改失败,请重试!');location.href='".$this->createUrl('group/admin')."';</script>" );
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		$model=new Group;
		$id=$_GET['id'];
		$whereStr = 'id="' . $id . '" ';
		$whereStr2 = 'groupid="' . $id . '" ';
		$url = isset($_POST['url']) ? $_POST['url'] : '';
		$transaction = $model->dbConnection->beginTransaction();
			try {
				if(Keyword::model()->find($whereStr2)){
					if (!Keyword::model ()->deleteAll ( $whereStr2 )) {
						throw new Exception('error_deletel_keyword');
					}
				}
				$messages = Message::model()->findAll($whereStr2);
				if($messages){
					foreach($messages as $val){
						if (!$val->delete()) {
							throw new Exception('error_deletel_message');
						}
					}
				}
				if (!Group::model ()->deleteAll ( $whereStr )) {
					throw new Exception('error_deletel_group');
				}
			$transaction->commit();
			exit ( CHtml::script ( "alert('删除成功');location.href='" . $url . "';" ) );
			}catch (Exception $e) {
				$transaction->rollBack();
				$msg = $e->getMessage();
				//exit($msg);
				exit( "<script>alert('删除失败,请重试!');location.href='".$this->createUrl('group/admin')."';</script>" );
			}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Group'])){
			$model->attributes=$_GET['Group'];
		}
		$this->render('admin',array(
			'model'=>$model,
			'search'=> $_GET ['Group'],
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
				$this->_model=Group::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
