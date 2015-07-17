<?php
$this->pageTitle = '登录 - '.Yii::app()->name;
?>

<div class="de_index">

	<div class="logo"><img src="/media/images/ishowdata_logo.png" alt=""/></div>
   <!-- <div class="dl_title"><img src="/media/images/dl_title.png" height="60" width="477" alt=""/></div>-->

    <div class="dl">
    	<form id="dl" action="<?php echo $this->createUrl('site/login',array('method' =>'login'));?>" method="post">
    	<div class="dl_width">
        	<ul>
            	<li>
                	<span class="text">登录账户</span>
                    <span><input type="text" name="name" id="name" value="<?php echo $name;?>" /></span>
                </li>
            	<li>
                	<span  class="text">密　　码</span>
                    <span><input  type="password" name="pwd" id="pwd" value="<?php echo $pwd?>" /></span>
                </li>
            	<li>
                	<span class="text">验</span><span class="text" style=" padding:0px 6px;">证</span><span class="text">码</span>
                    <span class="yzm"><input name="yzm" type="text" id="yzm" /></span>
                    <span class="ymz"><img id="yzm_img" src="<?php echo $this->createUrl('site/verification') ?>"></img></span>
                    <span class="kbq"><a href="javascript:;" onclick="changeyzm($('#yzm_img'),'<?php echo $this->createUrl('site/verification') ?>')">看不清，换一张</a></span>
                </li>
            	<li>
                	<span class="dl_but"><a href="javascript:void(0);"  onclick="checkDenglu('<?php echo $this->createUrl('site/checkVerification')?>')">登录</a></span>
                    <span class="wjma"><a href="<?php echo $this->createUrl('site/forgetPwd') ?>">忘记密码？</a></span>
                </li>                
            </ul>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
var error = '<?php echo $this->myError;?>';
if(error == -1){
	alert('用户名、密码错误');
}
function changeyzm(obj,url)
{
	now = new Date();
	time = now.getTime();
	obj.attr('src',url+'/rand/'+time);
	return false;
	
}
</script>

