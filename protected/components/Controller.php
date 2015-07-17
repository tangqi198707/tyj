<?php

class Controller extends CController
{

	public $layout='main';

	public $menu=array();

	//初始化
	public function init()
	{
		parent::init(); 
//		error_reporting(0);
		error_reporting(E_ALL ^ E_NOTICE);
		header("Content-type: text/html; charset=utf-8"); 
		Yii::app()->clientScript->registerCoreScript('jquery');
		
		//后台管理
		if(Yii::app()->request->scriptUrl == '/admin.php')
		{
			$this->layout = 'adminLayout';
			$this->defaultAction = 'login';
			if($this->id != 'site' && !Yii::app()->user->getState('adminId')){
				$this->redirect(array('site/login'));
			}
			
		}else{
		}

	}
	
	public function httpGet($url){
		$ch = curl_init($url) ;  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 100);  
		$result = curl_exec($ch);
		if(curl_errno($ch)){//出错则显示错误信息
			print curl_error($ch);
		}
		curl_close($ch) ;  
		return $result;
	}
	
	public function delLocalImg($img){
		if (is_file ( Yii::getPathOfAlias ( 'webroot' ) . $img )) {
			@unlink ( Yii::getPathOfAlias ( 'webroot' ) . $img );
		}
	}
	
	function getXmlString(){
$string = <<<XML
<?xml version='1.0' encoding='utf-8'?>
<xml>
</xml>
XML;
return $string;
	}

	//发邮件
	public function sendMail($title='设置新密码',$body="body",$sendtowho,$cc=false,$file=false,$from=false)
	{
		$mail = new PHPMailer();     //得到一个PHPMailer实例
	
		$mail->CharSet = "utf-8"; //设置采用utf-8编码
		$mail->IsSMTP();                    //设置采用SMTP方式发送邮件
		$mail->SMTPDebug  = 1;                     // 启用SMTP调试功能
		// 1 = errors and messages
		// 2 = messages only
		$mail->Host = Yii::app()->params['MAIL_SMTP'];    //设置邮件服务器的地址
	
		$mail->Port = 25;                           //设置邮件服务器的端口，默认为25,587
	
		$mail->From     = $from ? $from : Yii::app()->params['MAIL_ADDRESS']; //设置发件人的邮箱地址
		$mail->FromName = "松下";                       //设置发件人的姓名
		$mail->SMTPAuth = true;                                    //*设置SMTP是否需要密码验证，true表示需要
	
		$mail->Username = Yii::app()->params['MAIL_LOGINNAME'];               //用户名
		$mail->Password = Yii::app()->params['MAIL_PASSWORD'];                    //密码
		$mail->Subject = $title;                                 //设置邮件的标题
		$mail->AltBody = "text/html";                                // optional, comment out and test
		$mail->Body = $body;
		$mail->IsHTML(true);                                        //设置内容是否为html类型
		//$mail->WordWrap = 50;                                 //设置每行的字符数
		//		$mail->AddReplyTo(Yii::app()->params['shoujianEmail'],"zdinfo");     //设置回复的收件人的地址
		if (is_array($sendtowho)) {                            //收件人列表array
			foreach ($sendtowho as $addr){
				$mail->AddAddress($addr);
			}
		}else {
			$mail->AddAddress($sendtowho);     //设置收件的地址
		}
		if($cc)
		{
			if (is_array($cc)) {                            //收件人列表array
				foreach ($cc as $addr){
					$mail->AddCC($addr);
				}
			}else {
				$mail->AddCC($cc);     //设置收件的地址
			}
		}
		if($file)
		{
			$mail->AddAttachment($file);
		}
		return $mail->Send();
	}

	//上传图片
	/*
	 * $inputName 表单的name.	eg:$_POST['News']['img']
	* $dirname 存放文件的文件夹名称
	* 成功返回  新上传的文件的路径
	* 失败 返回 false
	*/
	public function uploadFile($inputName,$dirname,$debug=FALSE){
		if (!empty($inputName)){
			//			    var_dump($_POST['News']['img']);
			$imgfile = $inputName;    //上传的图片
			$newDir = str_replace ( 'upfileTmp', 'upfile/'.$dirname, substr_replace ( $imgfile, '', strrpos ( $imgfile, '/' ) ) );
			$newDir = str_replace ( Yii::app ()->baseUrl, YiiBase::getPathOfAlias ( 'webroot' ), $newDir );
			
			if (!is_dir($newDir)) {
				if (!$this->createdir ( $newDir,false )) {
					exit('创建目录失败'.' '.$newDir);
				}
			}
			@fclose(fopen($newDir.'/index.htm', 'w'));    //防打印目录
			if(Yii::app()->baseUrl)
				$dir = str_replace(Yii::app()->baseUrl,YiiBase::getPathOfAlias('webroot'),$imgfile);
			else
				$dir = YiiBase::getPathOfAlias('webroot').$imgfile;
			$destination_dir = '';
			if ($debug) {
				echo '<pre>';
				echo '$inputName:'.$imgfile.'<br>';
				echo '$newDir:'.$newDir.'<br>';
				echo '$dir:'.$dir.'<br>';
				echo '$fileUrl:'.str_replace ( 'upfileTmp', 'upfile/'.$dirname, $dir ).'<br>';
				echo '</pre>';
			}
	
			$res = copy ( $dir, str_replace ( 'upfileTmp', 'upfile/'.$dirname, $dir ) );
			if ($res) {
				$upFileUrl = str_replace('upfileTmp','upfile/'.$dirname,$imgfile);
				return $upFileUrl;
			}
		}
		else {
			return false;
		}
	}

	//验证码
	public function getVerification()
	{
		ob_clean();
		Header("Content-type: image/gif");
		/*
		 * 初始化
		*/
		$border = 0; //是否要边框 1要:0不要
		$how = 4; //验证码位数
		$w = $how*15; //图片宽度
		$h = 24; //图片高度
		$fontsize = 5; //字体大小
		$font = YiiBase::getPathOfAlias('webroot').'/media/images/consola.ttf';		//字体
		$alpha = "abcdefghijkmnopqrstuvwxyz"; //验证码内容1:字母
		$number = "023456789"; //验证码内容2:数字
		$randcode = ""; //验证码字符串初始化
		srand((double)microtime()*1000000); //初始化随机数种子
		$useFont = true;	//使用字体
		$useBorder = true;	//使用边框
	
		$im = ImageCreate($w, $h); //创建验证图片
	
		/*
		 * 绘制基本框架
		*/
		$bgcolor = ImageColorAllocate($im, 255, 255, 255); //设置背景颜色
		ImageFill($im, 0, 0, $bgcolor); //填充背景色
		if($border)
		{
			$black = ImageColorAllocate($im, 0, 0, 0); //设置边框颜色
			ImageRectangle($im, 0, 0, $w-1, $h-1, $black);//绘制边框
		}
	
		/*
		 * 逐位产生随机字符
		*/
		for($i=0; $i<$how; $i++)
		{
			$alpha_or_number = mt_rand(0, 1); //字母还是数字
			$str = $alpha_or_number ? $alpha : $number;
			$which = mt_rand(0, strlen($str)-1); //取哪个字符
			$code = substr($str, $which, 1); //取字符
			$color3 = ImageColorAllocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100)); //字符随即颜色
			if ($useFont) {
			$j = !$i ? 2 : $j+15; //绘字符位置
			imagettftext($im,18,mt_rand(-5, 5),$j,20,$color3,$font,$code);
			}else{
			$j = !$i ? 4 : $j+15; //绘字符位置
			ImageChar($im, $fontsize, $j, 3, $code, $color3); //绘字符
			}
			$randcode .= $code; //逐位加入验证码字符串
		}
	
		/*
		* 添加干扰
		*/
		for($i=0; $i<5; $i++)//绘背景干扰线
		{
		$color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰线颜色
		ImageArc($im, mt_rand(-5,$w), mt_rand(-5,$h), mt_rand(20,300), mt_rand(20,200), 55, 44, $color1); //干扰线
		}
		for($i=0; $i<$how*40; $i++)//绘背景干扰点
		{
		$color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰点颜色
		ImageSetPixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2); //干扰点
		}
		if ($useBorder) {
		imagerectangle($im,0,0,$w-1,$h-1,$color3);	//添加边框
		}
	
		//把验证码字符串写入session
		session_start();
		$_SESSION['randcode'] = $randcode;
		/*绘图结束*/
		Imagegif($im);
		ImageDestroy($im);
		/*绘图结束*/
	}

	//中文截取
	public static function utf8_substr($str,$start) {
		$null = "";
		preg_match_all("/./u", $str, $ar);
		if(func_num_args() >= 3) {
			$end = func_get_arg(2);
			if(count($ar[0]) <= $end)
				return $str;
			return join($null, array_slice($ar[0],$start,$end)).'...';
		} else {
			return join($null, array_slice($ar[0],$start));
		}
	}
	//复制文件
	public function xCopy($source, $destination, $child){
	    if (! is_dir ( $destination )) { //验证$dir是否是正确的目录格式
			$this->createdir ( $destination ,true ); //创建新的分组目录
		}
		
	    $handle=opendir($source);
	    while($entry=readdir($handle)) {
	        if(($entry!=".")&&($entry!="..")){
	            if(is_dir($source."/".$entry)){
	                if($child){
	                	$this->xCopy($source."/".$entry,$destination."/".$entry,$child);
	                }
	            }else{
	                copy($source."/".$entry,$destination."/".$entry);
	            }
	        }
	    }
    	return true;
	}
	
	//获取文件后缀名
	public function getDir($file_name){
		$extend = pathinfo($file_name);
		$extend = strtolower($extend["extension"]);
		return $extend;
	}

	//创建目录
	public function createdir($dir,$type){
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
					if (!mkdir($cur_dir,0774)) {
						exit($cur_dir);
					    return false;
					}
				}
			}
		}
		return true;
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
			$thumbType = end(explode(".",$url ));
			if(file_exists($dir.'.'.$thumbType))
			@unlink ( $dir.'.'.$thumbType );
		}
	}
}