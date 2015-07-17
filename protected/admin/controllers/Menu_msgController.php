<?php

class Menu_msgController extends Controller
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
				'actions'=>array('createLinkMsg','updateMsg','updateLinkMsg','createMsg',
								'admin','create','update','checkDel','delete','getNewsMsg',
								'createMultiple','updateMultiple'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	
	public function actionGetNewsMsg(){
		$model = new MenuMsg('newsList');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['menuMsg']))
			$model->attributes=$_GET['menuMsg'];
		$dp = $model->newsList();
		$count = $dp->getItemCount();
		$half = $count % 2 == 0 ? $count / 2 : ceil($count / 2);
		$category = WxCategory::model()->findAll(array(
			'select' => 'id,name',
			'order' => 'id desc'
		));
		$this->renderPartial('newsMsg',array(
			'dp'=>$dp,
			'count' => $count,
			'half' => $half,
			'category' => $category,
			'search' => $_GET['menuMsg'],
		),false,true);
	}
	
	public function actionCreate()
	{
		$model=new MenuMsg;
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		if($method == 'create')
		{
			$content = $_POST['content'];
			$_POST = CHtml::encodeArray($_POST);
			$id = Yii::app()->user->getState('adminId');
			$model->type = 'news';
			$model->title = $_POST['title'];
			$model->author = $_POST['author'];
			$model->show_cover = $_POST['show_cover'] == 1 ? 1 : 0;
			$model->abstract = str_replace(array("\r\n","\n"),array("<br>","<br>"),CHtml::encode($_POST['abstract']));
			$model->content=$content;
			$imgurl = '';
			if($_POST["imgurl"]){
				$imgurl = $_POST["imgurl"]; //获取临时上传路径
				$dir = '/upfile/wx/' . date ( Ym ); //拼接目录
			
				if (! is_dir ( $dir )) { //验证$dir是否是正确的目录格式
					$this->createdir ( $dir ,false); //创建新的分组目录
				}
				if (Yii::app ()->baseUrl){
					$dir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $imgurl );
					$thumbDir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $_POST["thumb"] );
				}else{
					$dir = YiiBase::getPathOfAlias ( 'webroot' ) . $imgurl;
					$thumbDir = YiiBase::getPathOfAlias ( 'webroot' ) . $_POST["thumb"];
				}
				copy ( $dir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ) );
				$imgurl = str_replace('upfileTmp', 'upfile/wx', $_POST["imgurl"]);
				$thumbArr = explode(".",$_POST["thumb"] );
				$thumbType = end($thumbArr);
				copy ( $thumbDir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ).'.'.$thumbType );
			}
			
			$model->imgurl = $imgurl;
			$model->link = $_POST['link'];
			$model->cate_id = $_POST['category'];
			$model->entry_id = $id;
			$model->entry_time = time();
			if($model->save()){
				exit(CHtml::script ( "alert('添加成功');location.href='".$this->createUrl('menu_msg/admin')."';" ));
			}else{
				exit(print_r($model->errors));
				exit(CHtml::script ( "alert('添加失败请重试');location.href='".$this->createUrl('menu_msg/admin')."';" ));
			}
		}
		$category = WxCategory::model()->findAll(array(
			'select' => 'id,name',
			'order' => 'id desc'
		));
		$this->renderPartial('create',array(
			'model'=>$model,
			'category' => $category,
		));
	}
	
	
	public function actionCreateMultiple(){
		$model=new MenuMsg;
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		if($method == 'create')
		{
			$_POST = CHtml::encodeArray($_POST);
			$id = Yii::app()->user->getState('adminId');
			$model->type = 'news';
			$model->multiple = 1;
			$model->show = 0;
			$model->title = $_POST['title'][0];
			$model->imgurl = 'imgurl';
			$model->link = 'link';
			if(is_array($_POST["imgurl"])){
				foreach($_POST["imgurl"] as $key => $imgurl){
					$dir = '/upfile/wx/' . date ( Ym ); //拼接目录
				
					if (! is_dir ( $dir )) { //验证$dir是否是正确的目录格式
						$this->createdir ( $dir ,false); //创建新的分组目录
					}
					if (Yii::app ()->baseUrl){
						$dir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $imgurl );
						$thumbDir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $_POST["thumb"][$key] );
					}else{
						$dir = YiiBase::getPathOfAlias ( 'webroot' ) . $imgurl;
						$thumbDir = YiiBase::getPathOfAlias ( 'webroot' ) . $_POST["thumb"][$key];
					}
					copy ( $dir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ) );
					$imgurl = str_replace('upfileTmp', 'upfile/wx', $_POST["imgurl"][$key]);
					$thumbArr = explode(".",$_POST["thumb"][$key] );
					$thumbType = end($thumbArr);
					copy ( $thumbDir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ).'.'.$thumbType );
					$_POST['imgurl'][$key] = $imgurl;
				}
			}
			$content = MenuMsg::model()->getMultipleNewsContent($_POST);
			$model->content=$content;
			
			$model->cate_id = $_POST['category'];
			$model->entry_id = $id;
			$model->entry_time = time();
			if($model->save()){
				foreach($_POST['title'] as $key => $val){
					$child=new MenuMsg;
					$child->title = $val;
					$child->author = $_POST['author'][$key];
					$child->show_cover = $_POST['show_cover'][$key];
					$child->type = 'news';
					$child->content = CHtml::decode($_POST['content'][$key]);
					$child->imgurl = $_POST['imgurl'][$key];
					$child->link = $_POST['link'][$key];
					$child->fid = $model->id;
					$child->cate_id = $_POST['category'];
					$child->entry_id = $model->entry_id;
					$child->entry_time = $model->entry_time;
					$child->save();
				}
				exit(CHtml::script ( "alert('添加成功');location.href='".$this->createUrl('menu_msg/admin')."';" ));
			}else{
				exit(print_r($model->errors));
				exit(CHtml::script ( "alert('添加失败请重试');location.href='".$this->createUrl('menu_msg/admin')."';" ));
			}
		}
		$category = WxCategory::model()->findAll(array(
			'select' => 'id,name',
			'order' => 'id desc'
		));
		$this->renderPartial('createMultiple',array(
			'model'=>$model,
			'category' => $category,
		));
	}
	
	
	public function actionUpdateMultiple(){
		$model = $this->loadModel();
		$contentArr =  json_decode($model->content);
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		if($method == 'update')
		{
			$url = isset($_POST['url']) ? $_POST['url'] : '';
			$_POST = CHtml::encodeArray($_POST);
			$id = Yii::app()->user->getState('adminId');
			$model->title = $_POST['title'][0];
			foreach($contentArr as $key => $val){
				if(!in_array($val->imgurl,$_POST["imgurl"])){
					$this->delImg($val->imgurl,true);
				}
			}
			if(is_array($_POST["imgurl"])){
				foreach($_POST["imgurl"] as $key => $imgurl){
					if($imgurl && strpos($imgurl,'upfileTmp') !== false){
						if(!in_array($contentArr[$key]->imgurl,$_POST["imgurl"]))
							$this->delImg($contentArr[$key]->imgurl,true);
						
						$dir = '/upfile/wx/' . date ( Ym ); //拼接目录
					
						if (! is_dir ( $dir )) { //验证$dir是否是正确的目录格式
							$this->createdir ( $dir ,false); //创建新的分组目录
						}
						if (Yii::app ()->baseUrl){
							$dir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $imgurl );
							$thumbDir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $_POST["thumb"][$key] );
						}else{
							$dir = YiiBase::getPathOfAlias ( 'webroot' ) . $imgurl;
							$thumbDir = YiiBase::getPathOfAlias ( 'webroot' ) . $_POST["thumb"][$key];
						}
						copy ( $dir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ) );
						$imgurl = str_replace('upfileTmp', 'upfile/wx', $_POST["imgurl"][$key]);
						$thumbArr = explode(".",$_POST["thumb"][$key] );
						$thumbType = end($thumbArr);
						copy ( $thumbDir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ).'.'.$thumbType );
						$_POST['imgurl'][$key] = $imgurl;
					}
				}
			}
			//exit($model->content);
			$content = MenuMsg::model()->getMultipleNewsContent($_POST);
			preg_match_all ( '/src=(.*?upload1.*?)"/i', $model->content, $arr );
			//print_r($arr);exit;
			if(count($arr)){
				foreach ( $arr[1] as $k ) { //[删除老图片]提交的在库中不存在，但在本地中有、删除
					if (strpos ( $content, $k ) == false) {
						$k = str_replace(array('\"','\/'),array('','/'),substr($k,0,strlen($k)-1));
						if(is_file ( YiiBase::getPathOfAlias ( 'webroot' ) . $k )){
							@unlink ( YiiBase::getPathOfAlias ( 'webroot' )  . $k );
						}
					}
				}
			}
			//echo $content;exit;
			$model->content=$content;
			
			$model->cate_id = $_POST['category'];
			$model->update_id = $id;
			$model->update_time = time();
			if($model->save()){
				$oldChild = MenuMsg::model()->findAll('fid = '.$model->id);
				$oldCount = count($oldChild);
				$newCount = count($_POST['title']);
				$i = 0;
				foreach($oldChild as $key => $child){
					if(!$_POST['title'][$key])break;
					$child->title = $_POST['title'][$key];
					$child->author = $_POST['author'][$key];
					$child->show_cover = $_POST['show_cover'][$key];
					$child->type = 'news';
					$child->content = $_POST['content'][$key];
					$child->imgurl = $_POST['imgurl'][$key];
					$child->link = $_POST['link'][$key];
					$child->fid = $model->id;
					$child->cate_id = $_POST['category'];
					$child->update_id = $model->update_id;
					$child->update_time = $model->update_time;
					if(!$child->save()){
						exit(print_r($child->errors));
					}
					$i++;
				}
				if($oldCount > $newCount){
					$whereStr = '';
					for(;$i < $oldCount ;$i++ ){
						if($i == $oldCount - 1){
							$whereStr .= 'id = '.$oldChild[$i]->id;
						}else{
							$whereStr .= 'id = '.$oldChild[$i]->id.' or ';						
						}
					}
					MenuMsg::model()->deleteAll($whereStr);
				}else if($oldCount < $newCount){
					foreach($_POST['title'] as $key => $val){
						if($key >= $i){
							$child=new MenuMsg;
							$child->title = $val;
							$child->author = $_POST['author'][$key];
							$child->show_cover = $_POST['show_cover'][$key];
							$child->type = 'news';
							$child->content = $_POST['content'][$key];
							$child->imgurl = $_POST['imgurl'][$key];
							$child->link = $_POST['link'][$key];
							$child->fid = $model->id;
							$child->cate_id = $_POST['category'];
							$child->entry_id = $model->entry_id;
							$child->entry_time = $model->entry_time;
							$child->update_id = $model->update_id;
							$child->update_time = $model->update_time;
							$child->save();
						}
					}
				}
				exit(CHtml::script ( "alert('修改成功');window.location.href='".$url."';" ));
			}else{
				exit(print_r($model->errors));
				exit(CHtml::script ( "alert('修改失败请重试');window.location.href='".$url."';" ));
			}
		}
		$category = WxCategory::model()->findAll(array(
			'select' => 'id,name',
			'order' => 'id desc'
		));
		$contentArr =  json_decode($model->content);
		$imgArr = explode(".",$contentArr[0]->imgurl );
        $thumbType = end($imgArr);
		$this->renderPartial('updateMultiple',array(
			'model'=>$model,
			'thumbType' => $thumbType,
			'category' => $category,
			'contentArr' => $contentArr,
		));
	}
	
	public function actionUpdate(){
		$model = $this->loadModel();
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		if($method == 'update')
		{
			$url = isset($_POST['url']) ? $_POST['url'] : '';
			$content = $_POST['content'];
			$_POST = CHtml::encodeArray($_POST);
			$id = Yii::app()->user->getState('adminId');
			$model->title = $_POST['title'];
			$model->author = $_POST['author'];
			$model->show_cover = $_POST['show_cover'] == 1 ? 1 : 0;
			$model->abstract = str_replace(array("\r\n","\n"),array("<br>","<br>"),CHtml::encode($_POST['abstract']));
			preg_match_all ( '/src="\/(js\/ueditor\/php\/upload1.*?)"/i', $model->content, $arr );
			if(count($arr)){
				foreach ( $arr[1] as $k ) { //[删除老图片]提交的在库中不存在，但在本地中有、删除
					if (strpos ( $content, $k ) == false && is_file ( YiiBase::getPathOfAlias ( 'webroot' ) . '/' . $k )) {
						@unlink ( YiiBase::getPathOfAlias ( 'webroot' ) . '/' . $k );
					}
				}
			}
			$model->content=$content;
			if($_POST["imgurl"] && strpos($_POST["imgurl"],'upfileTmp') !== false){
				$this->delImg($model->imgurl,true);
				
				$imgurl = '';
				$imgurl = $_POST["imgurl"]; //获取临时上传路径
				$dir = '/upfile/wx/' . date ( Ym ); //拼接目录
			
				if (! is_dir ( $dir )) { //验证$dir是否是正确的目录格式
					$this->createdir ( $dir ,false); //创建新的分组目录
				}
				if (Yii::app ()->baseUrl){
					$dir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $imgurl );
					$thumbDir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $_POST["thumb"] );
				}else{
					$dir = YiiBase::getPathOfAlias ( 'webroot' ) . $imgurl;
					$thumbDir = YiiBase::getPathOfAlias ( 'webroot' ) . $_POST["thumb"];
				}
				copy ( $dir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ) );
				$imgurl = str_replace('upfileTmp', 'upfile/wx', $_POST["imgurl"]);
				$thumbArr = explode(".",$_POST["thumb"] );
				$thumbType = end($thumbArr);
				copy ( $thumbDir, str_replace ( 'upfileTmp', 'upfile/wx', $dir ).'.'.$thumbType );
				$model->imgurl = $imgurl;
			}
			$model->link = $_POST['link'];
			$model->cate_id = $_POST['category'];
			$model->update_id = $id;
			$model->update_time = time();
			if($model->save()){
				exit(CHtml::script ( "alert('修改成功');window.location.href='".$url."';" ));
			}else{
				exit(print_r($model->errors));
				exit(CHtml::script ( "alert('修改失败请重试');window.location.href='".$url."';" ));
			}
		}
		$category = WxCategory::model()->findAll(array(
			'select' => 'id,name',
			'order' => 'id desc'
		));
		$imgArr = explode(".",$model->imgurl );
        $thumbType = end($imgArr);
		$this->renderPartial('update',array(
			'model'=>$model,
			'thumbType' => $thumbType,
			'category' => $category,
		));
	}
	
	
	
	public function actionCreateMsg(){
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		if(is_numeric($_POST['mid']) && $type)
		{
			if($type == 'text'){
				$model=new MenuMsg;
				$model->content = str_replace("\n","<br>",CHtml::encode($_POST['content']));
				$model->type = $type;
				$model->cate_id = 0;
				$model->entry_id = Yii::app()->user->getState('adminId');
				$model->entry_time = time();
				$transaction = $model->dbConnection->beginTransaction();
				try {
					if(!$model->save()){
						throw new Exception('error_create_menuMsg');
					}
					$menu = Menu::model()->findByPk($_POST['mid']);
					$menu->msg_id = $model->id;
					if(!$menu->save()){
						throw new Exception('error_update_menu');
					}
					$transaction->commit();
					echo $model->id;exit;
				}catch (Exception $e) {
					//exit($e->getMessage());
					$transaction->rollBack();
					echo '0';exit;
				}
			}else if($type == 'news'){
				$msgId = isset($_POST['msgId']) ? $_POST['msgId'] : '';
				if(!is_numeric($msgId)){
					exit('0');
				}
				$menu = Menu::model()->findByPk($_POST['mid']);
				$menu->msg_id = $msgId;
				if($menu->save()){
					echo $menu->id;exit;
				}else{
					echo '0';exit;
				}
			}
		}
		echo '0';exit;
	}
	
	
	public function actionUpdateMsg(){
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		if($type)
		{
			if($type == 'text'){
				if(!$_POST['id']){
					$this->actionCreateMsg();
				}else{
					$model=MenuMsg::model()->findByPk($_POST['id']);
					$model->content=str_replace("\n","<br>",CHtml::encode($_POST['content']));
					$model->update_id = Yii::app()->user->getState('adminId');
					$model->update_time = time();
					if($model->save())
						echo $model->id;
					else
						echo '0';
				}
				exit;
			}else if($type == 'news'){
				$msgId = isset($_POST['msgId']) ? $_POST['msgId'] : '';
				if(!is_numeric($msgId)){
					exit('0');
				}
				$menu = Menu::model()->findByPk($_POST['mid']);
				$menu->msg_id = $msgId;
				if($menu->save()){
					echo $menu->id;
				}else{
					echo '0';
				}
				exit;
			}
		}
		echo '0';exit;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateLinkMsg()
	{
		$model=new MenuMsg;

		if(is_numeric($_POST['mid']) && isset($_POST['linkMsg']))
		{
			$model->content=CHtml::encode($_POST['linkMsg']);
			$model->type = 'view';
			$model->cate_id = 0;
			$model->entry_id = Yii::app()->user->getState('adminId');
			$model->entry_time = time();
			$transaction = $model->dbConnection->beginTransaction();
			try {
				if(!$model->save()){
					throw new Exception('error_create_menuMsg');
				}
				$menu = Menu::model()->findByPk($_POST['mid']);
				$menu->msg_id = $model->id;
				if(!$menu->save()){
					throw new Exception('error_update_menu');
				}
				$transaction->commit();
				echo $model->id;exit;
			}catch (Exception $e) {
				$transaction->rollBack();
				echo '0';exit;
			}
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdateLinkMsg()
	{
		$model=$this->loadModel();

		if(isset($_GET['linkMsg']))
		{
			$model->content=CHtml::encode($_GET['linkMsg']);
			$model->update_id = Yii::app()->user->getState('adminId');
			$model->update_time = time();
			if($model->save())
				echo $model->id;
			else
				echo '0';
		}
	}

	public function actionAdmin()
	{
		$model=new MenuMsg('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['menuMsg']))
			$model->attributes=$_GET['menuMsg'];

		$category = WxCategory::model()->findAll(array(
			'select' => 'id,name',
			'order' => 'id desc'
		));
		$dp = $model->search('default');
		$dp->criteria->compare('fid',0);
		$this->render('admin',array(
			'model'=>$model,
			'search'=> $_GET ['menuMsg'],
			'category' => $category,
			'dp' => $dp
		));
	}
	
	
	public function actionCheckDel(){
		$str = isset($_GET['str']) ? $_GET['str'] : '';
		if($str){
			$arr = explode ( ',', $str );
			$whereStr = 'status = 1 and (';
			for($i = 0; $i < count ( $arr ); $i ++) {
				if ($i == count ( $arr ) - 1) {
					$whereStr .= 'msg_id="' . $arr [$i] . '" ';
				} else {
					$whereStr .= 'msg_id="' . $arr [$i] . '" or ';
				}
			}
			$whereStr .= ')';
			$count = Menu::model()->count($whereStr);
			echo $count;
		}
	}
	
	public function actionDelete(){
		$str = isset ( $_POST ['str'] ) ? $_POST ['str'] : '';
		$arr = explode ( ',', $str );
		$whereStr = $whereStrChild = '';
		for($i = 0; $i < count ( $arr ); $i ++) {
			if ($i == count ( $arr ) - 1) {
				$whereStr .= 'id="' . $arr [$i] . '" ';
				$whereStrChild .= 'fid="' . $arr [$i] . '" ';
			} else {
				$whereStr .= 'id="' . $arr [$i] . '" or ';
				$whereStrChild .= 'fid="' . $arr [$i] . '" or ';
			}
		}
		$url = isset ( $_POST ['url'] ) ? $_POST ['url'] : '';
		$models = MenuMsg::model ()->findAll ( $whereStr );
		foreach($models as $key => $val){
			if($val->multiple == 1){
				$contentArr =  json_decode($val->content);
				foreach($contentArr as $k => $v){
					$this->delImg($v->imgurl,true);
				}
				preg_match_all ( '/src=(.*?upload1.*?)"/i', $val->content, $arr );
				//print_r($arr);exit;
				if(count($arr)){
					foreach ( $arr[1] as $k ) { //[删除老图片]提交的在库中不存在，但在本地中有、删除
						$k = str_replace(array('\"','\/'),array('','/'),substr($k,0,strlen($k)-1));
						if(is_file ( YiiBase::getPathOfAlias ( 'webroot' ) . $k )){
							@unlink ( YiiBase::getPathOfAlias ( 'webroot' )  . $k );
						}
					}
				}
			}else{
				$this->delImg($val->imgurl,true);
				preg_match_all ( '/src="\/(js\/ueditor\/php\/upload1.*?)"/i', $val->content, $arr );
				if(count($arr)){
					foreach ( $arr[1] as $k ) { //[删除老图片]提交的在库中不存在，但在本地中有、删除
						if (is_file ( YiiBase::getPathOfAlias ( 'webroot' ) . '/' . $k )) {
							@unlink ( YiiBase::getPathOfAlias ( 'webroot' ) . '/' . $k );
						}
					}
				}
			}
		}
		if (MenuMsg::model ()->deleteAll ( $whereStr )) {
			MenuMsg::model ()->deleteAll ( $whereStrChild );
			exit ( CHtml::script ( "alert('删除成功!');location.href='" . $url . "';" ) );
		} else
		{
			exit ( "<script>alert('删除失败,请重试!');location.href='" . $url . "';</script>" );
		}
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
				$this->_model=MenuMsg::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-msg-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
