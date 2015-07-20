<?php 
class DynamicController extends Controller{
	
	public $layout='adminLayout';
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function actionChangeAdmin() {
		$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : '';
		if ($id) {
			$status = isset ( $_GET ['status'] ) ? $_GET ['status'] : '';
			$flag =Dynamic::model ()->updateByPk ( $id, array ('status' => $status) );
			exit ( "$flag" );
		}
	}
	
	public function actionAdmin()
	{
		$model=new Dynamic('search');
		$model->unsetAttributes();
		$paramArr = array();
		if(isset($_GET['Dynamic'])){
			$model->attributes=$_GET['Dynamic'];
		
			if($_GET ['Dynamic'] && array_filter($_GET ['Dynamic'])){
				$paramArr['Dynamic'] = $_GET ['Dynamic'];
			}
			$_GET['Dynamic_page'] = isset($_GET['Dynamic_page'])?$_GET['Dynamic_page']:1;
			if($_GET['Dynamic_page']){
				$paramArr['Dynamic_page'] = $_GET['Dynamic_page'];
			}
		}
		$this->render('admin',array(
			'model'=>$model,
			'search'=> isset($_GET['Dynamic'])?$_GET['Dynamic']:'',
			'paramArr' => $paramArr,
		));
	}
	
	public function actionCreate()
	{
		$model=new Dynamic;
		if(isset($_POST['Dynamic']))
		{			
			//封面图片		
			$info_img='';
			if($_POST ['Dynamic']['info_img']){
				$info_img = $_POST ['Dynamic'] ['info_img']; 
				$dir = '/upfile/Dynamic/info_img/' . date ( 'Ym' ); 
						
				if (! is_dir ( $dir )) { 
					$this->createdir ( $dir ); 
				}
				if (Yii::app ()->baseUrl)
					$dir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $info_img );
				else
					$dir = YiiBase::getPathOfAlias ( 'webroot' ) . $info_img;
				copy ( $dir, str_replace ( 'upfileTmp', 'upfile/Dynamic/info_img', $dir ) );
				$info_img = str_replace('upfileTmp', 'upfile/Dynamic/info_img', $_POST ['Dynamic'] ['info_img']);
			}
			
			$model->attributes = CHtml::encodeArray ( $_POST ['Dynamic'] );
			$id = Yii::app()->user->getState('adminId');
			$id = Yii::app()->user->getState('adminId');
			
			$model->title = $_POST ['Dynamic']['title'];
			$model->content = $_POST ['Dynamic']['content'];
			$model->status = 1;
			$model->info_img = $info_img;
			$model->entry_id = $id;
			$model->entry_time = time();
			if ($model->save()) {
				header('content-type:text/html;charset=utf-8');
				exit (CHtml::script ( "alert('添加成功!');location.href='" . $this->createUrl ( 'Dynamic/admin' ) . "';" ));
			}else{
				header('content-type:text/html;charset=utf-8');
				exit( "<script>alert('添加失败,请重试!'),opener.location.reload();</script>" );
			}
		}
		$this->renderpartial('create',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdate()
	{
		$url = isset ( $_POST ['url'] ) ? $_POST ['url'] : '';	
		$model=new Dynamic;
		if(isset($_POST['Dynamic']))
		{
			//cover_img新闻图片
			$info_img_url = $_POST ['Dynamic'] ['info_img'];
			if (strpos ( $info_img_url, 'upfileTmp' )) { //如果新上传了图片,更新
				$oldimg_url = YiiBase::getPathOfAlias ( 'webroot' ) . $model ['info_img'];
				if (is_file ( $oldimg_url )) {
					@unlink ( $oldimg_url );
				}
				if (Yii::app ()->baseUrl)
					$dir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $info_img_url );
				else
					$dir = YiiBase::getPathOfAlias ( 'webroot' ) . $info_img_url;
				$newDir = str_replace ( 'upfileTmp', 'upfile/Dynamic/info_img', substr_replace ( $info_img_url, '', strrpos ( $info_img_url, '/' ) ) );
				$this->createdir ( '/' . $newDir );
				copy ( $dir, str_replace ( 'upfileTmp', 'upfile/Dynamic/info_img', $dir ) );
				$_POST ['Dynamic'] ['info_img'] = str_replace ( 'upfileTmp', 'upfile/Dynamic/info_img', $_POST ['Dynamic'] ['info_img'] );
			}
			$info_img = str_replace('upfileTmp', 'upfile/Dynamic/info_img', $_POST ['Dynamic'] ['info_img']);
			$this->DelEditorImgOnUpdate(array($model->content),array($_POST ['Dynamic']['content']));
			$model->attributes = CHtml::encodeArray ( $_POST ['Dynamic'] );
			$id = Yii::app()->user->getState('adminId');
			$model->title = $_POST ['Dynamic']['title'];
			$model->content = $_POST ['Dynamic']['content'];
			$model->info_img = $info_img;
			$_POST ['Dynamic']['update_id'] = $id;
			$_POST ['Dynamic']['update_time'] = time();
			if($model->updateByPk($_GET['id'], $_POST ['Dynamic']))
			{
				header('content-type:text/html;charset=utf-8');
				exit (CHtml::script ( "alert('修改成功!');location.href='" .$url. "';" ));
			}else{
				header('content-type:text/html;charset=utf-8');
				exit( "<script>alert('修改失败,请重试!'),opener.location.reload();</script>" );
			}
		}
		$model = Dynamic::model()->findByPk($_GET['id']);
		$this->renderpartial( 'update',array(
				'model'=>$model,
		));
	}
	
	
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
		$models = Dynamic::model ()->findAll ( $whereStr );
		
		foreach($models as $key => $val){
			$this->delImg($val->info_img);
			$this->delEditorImg(array($val->content));
		}
		if (Dynamic::model ()->deleteAll ( $whereStr )) {
			header('content-type:text/html;charset=utf-8');
			exit ( CHtml::script ( "alert('删除成功!');location.href='" . $url . "';" ) );
		} else {
			header('content-type:text/html;charset=utf-8');
			exit ( "<script>alert('删除失败,请重试!');location.href='" . $url . "';</script>" );
		}
		
	}		
/**
	 * 删除图片
	 * @param $imgArr
	 */
	public function delMgzImg($imgArr){
		for($i = 0; $i < count ($imgArr); $i ++) {
			$this->delLocalImg($imgArr[$i]);
		}
	}
	
	public function delLocalImg($imgUrl){
		if (is_file ( Yii::getPathOfAlias ( 'webroot' ) . $imgUrl )) {
			@unlink ( Yii::getPathOfAlias ( 'webroot' ) . $imgUrl );
		}
	}
	
	//创建目录
	public function createdir($dir,$type = false){
		if(!$type){
			if(!Yii::app()->baseUrl)
				$dir = YiiBase::getPathOfAlias('webroot').$dir;
		}
		if (!is_dir($dir)){
			$temp = explode('/',$dir);
			$cur_dir = "";
			for($i=0;$i<count($temp);$i++){
				$cur_dir .= $temp[$i]."/";
				if(strpos(YiiBase::getPathOfAlias('webroot').'/',$cur_dir) !== false || strpos(str_replace('pcn-internal','pcn',YiiBase::getPathOfAlias('webroot')).'/',$cur_dir) !== false)
					continue;
				//echo $cur_dir.'***'.str_replace('pcn-internal','pcn',YiiBase::getPathOfAlias('webroot'))."<br/>";
				if (!is_dir($cur_dir)){
					if (!mkdir($cur_dir,0777)) {
						exit($cur_dir);
					    return false;
					}
				}
			}
		}
		return true;
	}
	
	//修改时删除编辑器里不存在的图片
	public function DelEditorImgOnUpdate($oldArray,$array){
		foreach($oldArray as $key => $content){
			$content = CHtml::decode($content);
			preg_match_all ( '/src="\/(js\/ueditor\/php\/upload1.*?)"/i', $content, $arr );
			//print_r($arr);exit;
			if(count($arr)){
				foreach ( $arr[1] as $k ) { //[删除老图片]提交的在库中不存在，但在本地中有、删除
					if (strpos ( $array[$key], $k ) == false) {
						if(is_file ( YiiBase::getPathOfAlias ( 'webroot' ) . '/' . $k )){
							@unlink ( YiiBase::getPathOfAlias ( 'webroot' )  . '/' . $k );
						}
					}
				}
			}
		}
	}
	
	//删除编辑器上传图片
	public function delEditorImg($array){
		foreach($array as $key => $content){
			$content = CHtml::decode($content);
			preg_match_all ( '/src="\/(js\/ueditor\/php\/upload1.*?)"/i', $content, $arr );
			if(count($arr)){
				foreach ( $arr[1] as $k ) { //[删除老图片]提交的在库中不存在，但在本地中有、删除
					if (is_file ( YiiBase::getPathOfAlias ( 'webroot' ) . '/' . $k )) {
						@unlink ( YiiBase::getPathOfAlias ( 'webroot' ) . '/' . $k );
					}
				}
			}
		}
	}
	
	//删除图片
	public function delImg($url,$thumb=false){
		if (Yii::app ()->baseUrl){
			$dir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $url );
		}else{
			$dir = YiiBase::getPathOfAlias ( 'webroot' ) . $url;
		}
		if(file_exists($dir))
			@unlink ( $dir );
		if($thumb){
			$arr_url = explode(".",$url ); 
			$thumbType = end($arr_url);
			if(file_exists($dir.'.'.$thumbType))
			@unlink ( $dir.'.'.$thumbType );
		}
	}
}
?>
