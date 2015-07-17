<?php

class UploadController extends Controller
{	
	public function up($myFile,$type)
	{
		header('Content-Type: text/html; charset=utf-8');
		set_time_limit(0);
		//$type为1时为上传图片
		$destination_folder=Yii::getPathOfAlias('webroot')."/upfileTmp/".date("Ym").'/';
		if(!is_dir($destination_folder)){
			mkdir($destination_folder,0777);
		    @fclose(fopen($destination_folder.'index.htm', 'w'));    //防打印目录
		}
		$maxPicSize=1024000;//1M [60K img--61280]
		$upFileMaxSize = 209715200;
		$uptypes=array(
		    'image/jpg',
		    'image/gif',
			'image/jpeg',
			'image/png',
			'image/bmp',
		);
		
		$filename = $myFile["tmp_name"];
		$filesize = $myFile['size'];
		
		$image_size_arr = @getimagesize($filename);//$image_size_arr[1]：高 | $image_size_arr[0]：宽
		$pinfo=pathinfo($myFile["name"]);
		$ftype= isset($pinfo['extension']) ? $pinfo['extension'] : '';
		$destination = $destination_folder.time().'_'.mt_rand(1000,9999).'.'.$ftype;
		if(!file_exists($destination_folder))
		{
			mkdir($destination_folder);
		}

		if($type != 'video' && $type != 'book')
		{
			if(!in_array($image_size_arr['mime'],$uptypes))
				return -3;//上传文件格式有误
			if($maxPicSize < $filesize)
				return -2;//图片大小超过限定范围
		}
		
		if ($type == 'book') {
			if($upFileMaxSize < $filesize)
				return -2;//附件大小超过限定范围		    
		}
		
		if(!is_uploaded_file($filename))
		{
			return -1;//请先选择您想要上传的文件
		}		
		if($type == 'video')
		{
			if($pinfo['extension'] != 'flv' && $pinfo['extension'] != 'mov')
				return -3;//上传视频格式有误
		}
		if(!move_uploaded_file ($filename, $destination))
		{
			return -4;//移动文件出错
		}
		//上传成功后预览
		$img = str_replace(Yii::getPathOfAlias('webroot'),Yii::app()->request->baseUrl,$destination);
		return $img;
	}
	
	//上传图片
	public function actionUp()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$method = isset($_GET['method']) ? $_GET['method'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] :'';
		$action = isset($_GET['act']) ? $_GET['act'] :'';
		$title = isset($_GET['title']) ? $_GET['title'] :'';
		if($method == 'up')
		{
			$rs = $this->up($_FILES["upfile"],$type);
		}
		$this->renderPartial('upload',array(
			'id' => $id,
			'rs' => $rs,
			'type' => $type,
			'action' => $action,
		));
	}
	
}