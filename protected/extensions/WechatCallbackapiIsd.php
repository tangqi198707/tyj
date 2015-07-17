<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", Yii::app()->params['token']);
define("APPID", Yii::app()->params['appid']);
define("APPSECRET", Yii::app()->params['appsecret']);
class WechatCallbackapiIsd
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseIsdWxMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
/*$postStr = '<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1351776360</CreateTime>
<MsgType><![CDATA[location]]></MsgType>
<Location_X>23.134521</Location_X>
<Location_Y>113.358803</Location_Y>
<Scale>20</Scale>
<Label><![CDATA[中国河北省保定市徐水县G4京港澳高速]]></Label>
<MsgId>1234567890123456</MsgId>
</xml>';*/
		/*$postStr = '<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1351776360</CreateTime>
<MsgType><![CDATA[location]]></MsgType>
<Location_X>23.134521</Location_X>
<Location_Y>113.358803</Location_Y>
<Scale>20</Scale>
<Label><![CDATA[北京市]]></Label>
<MsgId>1234567890123456</MsgId>
</xml>';*/
		/*$postStr = '<xml><ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[opXCkjp4ktEH1iGbCmFqoZ3E0gY4aabb]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
<EventKey><![CDATA[qrscene_123123]]></EventKey>
<Ticket><![CDATA[TICKET]]></Ticket>
</xml>';*/
		/*$postStr = '<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[oftpatyvtqioVBxY-8jOvI1smtdM]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[CLICK]]></Event>
<EventKey><![CDATA[msg_2]]></EventKey>
</xml>';*/
		/*$postStr = ' <xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[oftpatyvtqioVBxY-8jOvI1smtdM]]></FromUserName> 
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[car]]></Content>
 <MsgId>1234567890123456</MsgId>
 </xml>';*/
		/*$postStr = '<xml>
 <ToUserName><![CDATA[]]></ToUserName>
 <FromUserName><![CDATA[opXCkjp4ktEH1iGbCmFqoZ3E0gY4]]></FromUserName>
 <CreateTime>1397714195</CreateTime>
 <MsgType><![CDATA[image]]></MsgType>
 <PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz/38me8kS109cr8eou2SNXjibQ8NY5YnVAD6UCZU6FV5IVE0CCZgSp3g8lNr3gPYzjcWITs8ybjla5w94BTVLCCCg/0]]></PicUrl>
 <MediaId><![CDATA[Cp4uRTMAy80YYBgUCtKykpywTkJg2ukTfpXng_45D7OrWdzpFG7Nng0WZEDCjBww]]></MediaId>
 <MsgId>6010598223174811797</MsgId>
 </xml>';*/
		
      	//extract post data
    	if (!empty($postStr)){
		//if (1){
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $event = $postObj->Event;
                $messageType = $postObj->MsgType;
                //$keyword = 'sfsfww';
                $user = User::model()->find(array(
                			'condition' => 'wxkey = :key',
                			'params' => array(':key' => $fromUsername)
                		));
                if($user && !$user->nickname){
                	$user = User::model()->createNewUser($fromUsername,$user);
                }
                if(!$user){
                	$model = new User;
                	$user = User::model()->createNewUser($fromUsername,$model);
                }
                $time = time();
				if(!empty( $keyword ) || $postObj->MediaId || $event || $postObj->MsgType == 'location')
                {
                	$message = $userContent = $list = false;
                	$gid = 0;//默认回复
                	if($event){
                		if($event == 'subscribe'){//关注
                			$uid = $user->id;
                			if(!$uid){
                				exit();
                			}
                			$userContent = '加关注';
                			$message = Message::model()->find(array(
								'condition' => "groupid = -1 and status = 1",
								'order' => 'id desc'
							));
							$message->content = CHtml::decode($message->content);
							$message->content = str_replace('chooseCity','chooseCity/uid/'.$uid,$message->content);
							//exit($message->content);
                		}else if($event == 'unsubscribe'){
                			/*User::model()->deleteAll(array(
                				'condition' => 'wxkey = :key',
                				'params' => array(':key' => $fromUsername)
                			));*/
                		}else if($event == 'CLICK'){
                			$userContent = '菜单事件'.$postObj->EventKey;
                			$arr = explode('_',$postObj->EventKey);
                			$mid = $arr[1];
                			if(is_numeric($mid)){
                				$message = MenuMsg::model()->findByPk($mid);
                			}
                			if(strpos($message->content,'getMsgByCity') !== false){
                				$arr = explode('_',$message->content);
                				$cate = $arr[1];
                				if($user->city_id == 1){
                					//默认北京的
                					$message = MenuMsg::model()->find(array(
                						'condition' => 'cate_id = :cate and city_id = :city and fid = 0',
                						'params' => array(':cate'=>$cate,':city'=>35),
                						'order'=>'id desc'
                					));
                				}else{
                					$message = MenuMsg::model()->find(array(
                						'condition' => 'cate_id = :cate and city_id = :city and fid = 0',
                						'params' => array(':cate'=>$cate,':city' => $user->city_id),
                						'order' => 'id desc'
                					));
                				}
                			}else if($message->content == 'changeCity'){
                				$message = new MenuMsg;
                				$message->type = 'text';
                				$message->content = '<a href="http://sqdwx.dig24.cn/site/chooseCity/uid/'.$user->id.'">更改城市</a>，我们将把与您相关的信息发送给您';
                			}
                		}else if($event == 'LOCATION'){
                			/*$log = new Log;
							$log->username = $fromUsername;
							$log->content = '纬度 :'.$postObj->Latitude.'_经度: '.$postObj->Longitude.'_精度 :'.$postObj->Precision;
							$log->groupid = $gid;
							$log->type = 'location';
							$log->msgid = 0;
							$log->entry_time = $time;
							$log->save();
							exit();*/
                		}
                	}else{
                		if($postObj->MsgType == 'location'){//发送位置
                			//$this->getUserCity($postObj);
                			//$list = true;
                			//$messages = MenuMsg::model()->getPositionMsg($postObj->Label);
                		}else{
                			$userContent = $postObj->Content;
                			if($messageType == 'text'){
		                		$kw = Keyword::model()->getByKeyword($keyword);
		                		$group = $kw->group;
			                	//exit($kw->name.'&&'.$kw->count.'**'.$group->name);
			                	$gtype = 'new';
			                	if($kw && $group){
			                		$gid = $group->id;
			                		$gtype = $group->type;
			                		$kw->count += 1;
									$kw->save();
			                	}
			                	$message = Message::model()->getMessageByGroup($gid,$gtype);
			                	if($message->type == 'news'){
			                		$message = MenuMsg::Model()->findByPk($message->content);
			                	}
			                	if($message->content == '是否给优惠券'){
			                		if($user->id){
				                		if($user->register == 0){
				                			$message->content = '<a href="http://sqdwx.dig24.cn/site/register/uid/'.$user->id.'">注册</a>';
				                		}else{
				                			$time = time();
				                			$cate = CouponCate::model()->find(array(
				                				'condition'=> 'INSTR(:key,name)',
				                				'params' => array(':key'=> $keyword)
				                			));
				                			if($cate){
					                			$coupon = Coupon::model()->find(array(
					                				'condition' => 'status = 1 and end_time > "'.$time.'"',
					                				'order' => 'id desc'
					                			));
					                			if($coupon){
					                				$coupon->status = 0;
					                				$coupon->uid = $user->id;
					                				if($coupon->save()){
					                					$message->content = '优惠券：'.$coupon->content;
					                				}else{
					                					$message->content = '优惠券获取失败请重试';
					                				}
					                			}else{
					                				$message->content = '优惠券已发完';
					                			}
				                			}else{
				                				$message->content = '请正确输入您想要的优惠券，如：电影优惠券';
				                			}
				                		}
			                		}
			                	}
                			}else if($messageType == 'image'){
                				$image = $this->getMediaImage($postObj->MediaId);
                				$userContent = $image ;
                				//$userContent = $postObj->toUser.'**'.$postObj->MsgId;
                				
                			}
		                	UserMsg::model()->createUserMsg($user->id,$userContent,$gid,$messageType);
                		}
                	}
                	//exit($message->content);
                	$resultStr = '';
                	$msgType = $message->type;
                	//exit($contentStr);
                	if(strpos($message->content,'car/index') !== false){
                		$message->content = str_replace('car/index','car/index/uid/'.$user->id,$message->content);
                	}
                	if($list){
                		$resultStr = MenuMsg::model()->getNewsList($messages,$fromUsername, $toUsername, $time, $msgType);
                	}else if(isset($message->multiple) && $message->multiple == 1){
                		$resultStr = MenuMsg::model()->getNewsList(json_decode($message->content),$fromUsername, $toUsername, $time, $msgType,$message->id);
                	}else{
	                	$imgurl = isset($message->imgurl) ? "http://".$_SERVER['HTTP_HOST'].$message->imgurl : '';
	                	$textTpl = Message::model()->getTextTpl($msgType,$imgurl,$message->id);
	                	$contentStr = $message->content;
                		
                		if($msgType == 'news'){
                			$contentStr = $message->abstract ? $message->abstract : strip_tags($message->content,"<br><p>");
	                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,$message->title, str_replace(array('<br>','<p>','</p>'),array("\n","","\n"),$contentStr));
	                	}else
	                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, str_replace('<br>',"\n",$contentStr));
                	}
                	//exit($resultStr);
                	$log = new Log;
					$log->username = $fromUsername;
					$log->content = $userContent;
					$log->groupid = $gid;
					$log->keywordid = $kw->id;
					$log->type = $message->type;
					$log->msgid = $message->id;
					$log->entry_time = $time;
					$log->save();
	                	
	                echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
	
    //得到用户详细信息
    public function getUserInfo($from){
    	$token = $this->getToken();
    	$response = $this->httpGet("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$from&lang=zh_CN");
    	$result = json_decode($response);
		return $result;
    }
    
    
    //得到用户地理位置
    public function getUserCity($postObj){
    	$log = new Log;
		$log->username = 'test';
		$log->content = '维度  :'.$postObj->Location_X.'_精度 : '.$postObj->Location_Y.'_位置信息 :'.$postObj->Label;
		$log->groupid = 0;
		$log->type = 'location';
		$log->msgid = 0;
		$log->entry_time = time();;
		$log->save();
		exit();
    }
    
    public function replyUserMsg($content){
    	$token = $this->getToken();
    	return $this->httpPost('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token,$content);
    }
    
    //download media
    public function getMediaImage($mediaId){
    	$token = $this->getToken();
    	$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token.'&media_id='.$mediaId;
    	$fileInfo = $this->downloadWeixinFile($url);
    	$destination_folder=Yii::getPathOfAlias('webroot')."/upfile/userImg/".date("Ymd").'/';
		if(!is_dir($destination_folder)){
			Yii::app()->controller->createdir($destination_folder,true);
		}
		$destination = $destination_folder.date('Ymd').'_'.mt_rand(1000,99999).'.jpg';
		$this->saveWeixinFile($destination,$fileInfo['body']);
    	return str_replace(Yii::getPathOfAlias('webroot'),Yii::app()->request->baseUrl,$destination);
    }
    
   	public function downloadWeixinFile($url){
   		$ch = curl_init($url);
   		curl_setopt($ch, CURLOPT_HEADER, 0);
   		curl_setopt($ch, CURLOPT_NOBODY, 0);
   		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
   		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
   		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   		$package = curl_exec($ch);
   		$httpinfo = curl_getinfo($ch);
   		curl_close($ch);
   		return array('header'=>$httpinfo,'body'=>$package);
   	}
   	
   	public function saveWeixinFile($filename,$filecontent){
   		$local_file = fopen($filename, 'w');
   		if(false !==  $local_file){
   			if(false !== fwrite($local_file,$filecontent)){
   				fclose($local_file);
   			}
   		}
   	}
    
    
	//HTTP提交内容
	public function httpPost($url, $jsonData){
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$result = curl_exec($ch) ;
		curl_close($ch) ;
		return $result;
	}
	
	public function httpGet($url){
		$ch = curl_init($url) ;  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
		$result = curl_exec($ch);
		curl_close($ch) ;  
		return $result;
	}
	
	//获取Token
	public function getToken(){
		$response = $this->httpGet("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET);
		$result = json_decode($response);
		return $result->access_token;
	}
	
	
	//生成微信菜单
	public function createMenu( $str){
		return;
		$token = $this->getToken();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
		return $this->httpPost($url, $str);
	}
    
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>