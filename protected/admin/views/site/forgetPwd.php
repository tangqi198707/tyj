<?php 
$this->pageTitle = Yii::app()->name . ' - 找回密码';
?>
<div class="hy_zhma">
<div class="hy_zhma_title">找回密码</div>
		<form action="<?php echo $this->createUrl('site/forgetPwd'); ?>" id='wjform' method = "post" >
			<p><label>登录账户</label>
				<input type="text" id="name" name="name" class="wjmm_inp_text" />
			</p>
			<p><label>邮　　箱</label>
				<input type="text" id="email" name="email" class="wjmm_inp_text" />
			</p>
			<p class="wjmm_p">
				<a href="javascript:;" class="zc_a" onclick="checkPost()" style="padding-right:60px;">找回密码</a>
				<a href="<?php echo $this->createUrl('site/login');?>" class="zc_a">回到后台</a>
			</p>
		</form>
</div>
<script type="text/javascript">

	var msg = '<?php echo $retmsg; ?>';
	var flag = '<?php echo $flag; ?>';
	if(flag){
    	if(msg){
    		alert(msg);
    	}
	}
	function checkPost(){
		var form = $('#wjform');
		var name = $('#name');
		var email = $('#email');
		if($.trim(name.val()) == ''){
			alert('请填写用户!');
			name.select();
		}
		else if($.trim(email.val()) == ''){
			alert('请填写邮箱!');
			email.select();
		} else {
			form.submit();
		}
	}
</script>