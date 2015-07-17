<?php

class UserMsgController extends Controller
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
				'actions'=>array('admin','star','changeStar','reply','createExcel'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionReply()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$uid = isset($_GET['uid']) ? $_GET['uid'] : '';
		if(!is_numeric($id) || !is_numeric($id))exit;
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		if($method == 'create')
		{
			$url = isset($_POST['url']) ? $_POST['url'] : '';
			$adminId = Yii::app()->user->getState('adminId');
			$user = User::model()->findByPk($uid);
			$wxkey = $user->wxkey;
			$content=$_POST['content'];
			$str = '{
					    "touser":"'.$wxkey.'",
					    "msgtype":"text",
					    "text":
					    {
					         "content":"'.$content.'"
					    }
					}';
			$wechatObj = new WechatCallbackapiIsd();
			$rs = $wechatObj->replyUserMsg($str);
			$rs = json_decode($rs);
			//exit($rs->errcode.')))');
			if($rs->errcode != 0){
				exit(CHtml::script ( "alert('回复失败，请联系系统管理员');location.href='".$url."';" ));
			}
			$model = UserMsg::model()->findByPk($id);
			$model->reply = 1;
			$model->reply_id = $adminId;
			$model->reply_time = time();
			if($model->save()){
				exit(CHtml::script ( "alert('回复成功');location.href='".$url."';" ));
			}
		}

		$this->renderPartial('reply',array(
			'id' => $id,
			'uid' => $uid
		));
	}
	
	public function actionChangeStar() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		$star = isset ( $_GET ['star'] ) ? $_GET ['star'] : '';
		if (is_numeric($id) && is_numeric($star)) {
			$update_id = Yii::app()->user->getState('adminId');
			$time = time();
			$flag = UserMsg::model ()->updateByPk ( $id, array ('star' => $star,'star_id'=>$update_id,'star_time'=>$time) );
			exit ( $flag );
		}
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UserMsg('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserMsg'])){
			$model->attributes=$_GET['UserMsg'];
		}
		if(!isset($_GET['UserMsg']['keyword']) || $_GET['UserMsg']['keyword'] == 0){
			$model->keyword = 0;
		}else{
			$model->keyword = null;
		}
		if(!isset($_GET['UserMsg']['reply']) || $_GET['UserMsg']['reply'] == 0){
			$model->reply = 0;
		}else{
			$model->reply = null;
		}
		$this->render('admin',array(
			'model'=>$model,
			'search' => $_GET['UserMsg']
		));
	}
	
	public function actionCreateExcel(){
		$model=new UserMsg('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserMsg'])){
			$model->attributes=$_GET['UserMsg'];
		}
		if(!isset($_GET['UserMsg']['keyword']) || $_GET['UserMsg']['keyword'] == 0){
			$model->keyword = 0;
		}else{
			$model->keyword = null;
		}
		if(!isset($_GET['UserMsg']['reply']) || $_GET['UserMsg']['reply'] == 0){
			$model->reply = 0;
		}else{
			$model->reply = null;
		}
		
		$criteria=new CDbCriteria;
		$criteria->compare('keyword',$model->keyword);
		$criteria->compare('reply',$model->reply);
		$start = strtotime ( trim ( $_GET ['UserMsg'] ['start'] ) );
		$end = strtotime ( trim ( $_GET ['UserMsg'] ['end'] ) );
		$end = $end + 86400;
		if ($_GET ['UserMsg'] ['start'] && $_GET ['UserMsg'] ['end']) {
			$criteria->addCondition ( array ("t.entry_time > :start", "t.entry_time < :end" ) );
			$criteria->params [':start'] = $start;
			$criteria->params [':end'] = $end;
		} else if ($_GET ['UserMsg'] ['start']) {
			$criteria->addCondition ( "t.entry_time > :start" );
			$criteria->params [':start'] = $start;
		} else if ($_GET ['UserMsg'] ['end']) {
			$criteria->addCondition ( "t.entry_time < :end" );
			$criteria->params [':end'] = $end;
		}
		
		if($model->content){
			$criteria->addCondition ( "t.content like :content" );
			$criteria->params [':content'] = '%'.$model->content.'%';
		}
		if($_GET['UserMsg']['nickname']){
			$criteria->with = array( 'user' => array('condition'=>"nickname like :nickname",'params'=>array(':nickname' => $_GET['UserMsg']['nickname'].'%') ));
		}
		
		
		$criteria->order = 't.id desc';
		$msgs = UserMsg::model()->with(array('user'=>array('select'=>'nickname')))->findAll($criteria);
		include YiiBase::getPathOfAlias ( 'ext' ).'/Classes/PHPExcel.php';
		require_once YiiBase::getPathOfAlias ( 'ext' ).'/Classes/PHPExcel/Writer/Excel2007.php';
		$objExcel = new PHPExcel(); 
		$objWriter = new PHPExcel_Writer_Excel2007($objExcel);
		$objProps = $objExcel->getProperties(); 
		$objProps->setCreator("ishowdata");
		$objProps->setTitle("松下微信用户信息");
		$objExcel->setActiveSheetIndex(0); 
		$objActSheet = $objExcel->getActiveSheet();  
		$objActSheet->getColumnDimension('A')->setWidth(20); 
		$objActSheet->getColumnDimension('B')->setWidth(80); 
		$objActSheet->getColumnDimension('C')->setWidth(20); 
		$objActSheet->setCellValue('A1', '昵称');
		$objActSheet->setCellValue('B1', '内容');
		$objActSheet->setCellValue('C1', '时间'); 
		
		foreach($msgs as $key => $msg){
			$i = $key + 2;
			$objActSheet->setCellValue('A'.$i, $msg->user->nickname);
			$objActSheet->setCellValue('B'.$i, $msg->content);
			$objActSheet->setCellValue('C'.$i, date("Y-m-d H:i",$msg->entry_time)); 
		}
		$dir = '/download/userMsg/'.date("Ym");
		if(!is_dir($dir)){
			$this->createDir($dir,false);
		}
		$time = date("Y-m-d"); 
		$fileName = '/'.$dir.'/'.$time.'_'.mt_rand(1000,9999).'.xlsx';
		$objWriter->save(YiiBase::getPathOfAlias ( 'webroot' ).$fileName); 
		exit(CHtml::script ( "location.href='http://".$_SERVER['HTTP_HOST'].$fileName."';" ));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionStar()
	{
		$model=new UserMsg('search');
		$model->unsetAttributes();  // clear any default values
		$this->render('star',array(
			'model'=>$model,
			'search' => $_GET['UserMsg']
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
				$this->_model=UserMsg::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='wx-user-msg-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
