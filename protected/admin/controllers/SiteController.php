<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	
	public $myError;
	public $articleid;
	public $companyImg = array();
	public $folder = '';
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionWxIsd(){
		$wechatObj = new WechatCallbackapiIsd();
		//$wechatObj->valid();
		$wechatObj->responseIsdWxMsg();
	}
	
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	
	//验证用户的验证码是否正确
	public function actionCheckVerification()
	{
		$yzm = isset($_GET['yzm']) ? $_GET['yzm'] : '';
		if($yzm)
		{
			session_start();
			if ($_SESSION['randcode'] != strtolower($yzm) ){
				exit('验证码不正确');
			}else{
				exit('');
			}
		}
	}

	public function actionVerification(){
		$this->getVerification();
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{

		$this->layout = 'adminNoLayout';
		$name = $pwd = ''; 
		if (isset ( $_POST ["name"] )) {
			$name = isset ( $_POST ['name'] ) ? $_POST ['name'] : '';
			$pwd = isset ( $_POST ['pwd'] ) ? $_POST ['pwd'] : '';
			$myError = 1;
			$model = Manager::model ()->find ( 'name = :name and status = 1', array (':name' => $name ) );
			if ($model == NULL)
				$this->myError = -1;
			else if ($model->password != md5 ( $pwd ))
				$this->myError = -1;
			else {
					$this->myError = 0;
					$myIdentity = new UserIdentity ( $name, $pwd );
					Yii::app ()->user->login ( $myIdentity );
					Yii::app ()->user->setState ( 'adminId', $model->id );
					Yii::app ()->user->setState ( 'adminInfo', $model );
					$this->redirect ( array ("manager/admin" ) );
					
				}
			}
		$this->render ( 'login', array ('name' => $name, 'pwd' => $pwd ) );
	}
	
	
	
	
	//忘记密码
	public function actionForgetPwd(){
	
		$this->layout = 'retrieve';
		$_name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$_email = isset($_POST['email']) ? trim($_POST['email']) : '';
		$retmsg ='';
		$flag = false;
			
		if ($_name && $_email) {
			$flag = true;
			$model = Manager::Model()->find(array(
					'select'	=>'id,name,email',
					'condition'	=>'name=:name and email=:email',
					'params'	=>array(':name'=>$_name,':email'=>$_email),
			));
			$rand = rand(100000,9999999);
			$new = Manager::model()->updateByPk($model->id,array('password'=>md5($rand)));
			if ($model){                        //获得用户信息
				$m_id = $model->id;
				$m_name = $model->name;
				$m_email = $model->email;
				$year = date('Y',time());
				$mailBody    ="$m_name,您好!<hr>";
				$mailBody.= "松下已经收到你的密码重置请求:<br/>";
				$mailBody.= "&nbsp;&nbsp;&nbsp;&nbsp;系统随机密码：($rand)，请您尽快修改密码！<hr>";
				//$mailBody.= "<a href='$m_link'>$m_link</a>\n<hr>";
				$mailBody.= "© $year 松下：这是一个系统消息,请不要直接回复。";
					
				if ($this->sendMail('松下：设置密码',$mailBody,$m_email)) {
	
					$retmsg = '你好,重置密码已经发送到您的电子邮件';
				}else{
					$retmsg = '发送失败，请重新发送';
				}
					
			}else{
				$retmsg = '帐户或邮箱填写不正确!';
			}
		}
		else {
			$retmsg = '请填写有效的信息';
		}
			
		$this->render('forgetPwd',array('retmsg'=>$retmsg,'flag'=>$flag));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirect(Yii::app()->homeUrl);
	}
}