<?php

class AjaxUploadController extends Controller
{	
	public function upfile($myFile,$thumb=false,$type=false)
	{
		header('Content-Type: text/html; charset=utf-8');
		set_time_limit(0);
		//$type为1时为上传图片
		$destination_folder=Yii::getPathOfAlias('webroot')."/upfileTmp/".date("Ym").'/';
		if(!is_dir($destination_folder)){
			mkdir($destination_folder,0777);
		    @fclose(fopen($destination_folder.'index.htm', 'w'));    //防打印目录
		}
		$maxPicSize=500000;//1M [60K img--61280]
		
		$error = '';
		
		$uptypes=array(
		    'image/jpg',
			'image/jpeg',
			'image/png',
		);
		
		$filename = $myFile["tmp_name"];
		$filesize = $myFile['size'];
		
		$image_size_arr = @getimagesize($filename);//$image_size_arr[1]：高 | $image_size_arr[0]：宽
		$pinfo=pathinfo($myFile["name"]);
		$ftype= isset($pinfo['extension']) ? $pinfo['extension'] : '';
		$fileName = time().'_'.mt_rand(1000,9999).'.'.$ftype;
		$destination = $destination_folder.$fileName;
		if(!file_exists($destination_folder))
		{
			mkdir($destination_folder);
		}
		if($type){
			if($ftype != $type )
				return 4;
		}else{
			if(!in_array($image_size_arr['mime'],$uptypes)){
				return 4;
			}
		}
		if($maxPicSize < $filesize)
		{
			return 1;
		}
		if(!is_uploaded_file($filename))
		{
			return 2;
		}		
		if(!move_uploaded_file ($filename, $destination))
		{
			return 3;
		}
		//上传成功后预览
		$error = str_replace(Yii::getPathOfAlias('webroot'),Yii::app()->request->baseUrl,$destination);
		if($thumb){
				$thumbDir = $destination_folder.'thumb';
				$thumbImage = $thumbDir.'/'.$fileName;
				if(!is_dir($thumbDir)){
					mkdir($thumbDir,0777);
				    @fclose(fopen($thumbDir.'index.htm', 'w'));    //防打印目录
				}
				$w = $image_size_arr[0];
				$h = $image_size_arr[1];
				$width = 100;
				$height = $width * $h / $w;
				$resizeimage = new ResizeImage($destination, $width, round($height), "1",$thumbImage);
				return $error.'@!@'.str_replace(Yii::getPathOfAlias('webroot'),Yii::app()->request->baseUrl,$thumbImage);;
		}
		return $error;
	}
	
	public function actionUp()
	{
		$error = "";
		$msg = "";
		$fileElementName = 'fileToUpload';
		if(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
		{
			$error = '请选择要上传的文件';
		}else 
		{
			$thumb = isset($_GET['thumb']) ? $_GET['thumb'] : '';
			$type = isset($_GET['type']) ? $_GET['type'] : '';
			$rs = $this->upfile($_FILES['fileToUpload'],$thumb,$type);
			if(is_numeric($rs))
			{
				switch ($rs)
				{
					case 1: $error = '请上传500K以内的文件';break;
					case 2: $error = '请先选择您想要上传的文件';break;
					case 3: $error = '上传文件出错';break;
					case 4: $error = '上传文件格式有误';break;
				}
			}else{
				$msg = $rs;
			}
			
		}
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "'\n";
		echo "}";
	}
}