<?php 
$this->pageTitle = '修改会员信息 - '.Yii::app()->name;
?>
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">修改管理员<span><a href="javascript:;" onclick="$.closePopupLayer();">×</a></span></div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list" style="width:100%;">
<form method="POST" id="myform" action="<?php echo $this->createUrl('member/update',array('id' => $model->id));?>" enctype="multipart/form-data">
<table width="77%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto;">
  <tr>
    <td>帐号：</td>
    <td align="left">
    	<input name="Member[accountsnum]" type="text" id="accountsnum" size="44" value="<?php echo $model->accountsnum;?>" readOnly/>
    </td>
  </tr>
  <tr>
    <td>登陆密码：</td>
    <td align="left">
    	<input name="Member[pwd]" type="text" id="pwd" size="44" value="<?php echo $model->pwd;?>" readOnly/>
    </td>
  </tr>
<!--  <tr>-->
<!--    <td>确认密码：</td>-->
<!--    <td align="left">-->
<!--    	<input name="Member[pwds]" type="text" id="pwds" size="44" value="" />-->
<!--    </td>-->
<!--  </tr>-->
  <tr>
    <td>联系电话：</td>
    <td align="left">
    	<input name="Member[tel]" type="text" id="tel" size="44" value="<?php echo $model->tel;?>" />
    </td>
  </tr>
  <tr>
    <td>邀请码：</td>
    <td align="left">
    	<input name="Member[invitenum]" type="text" id="invitenum" size="44" value="<?php echo $model->invitenum;?>" readOnly/>
    </td>
  </tr>
  <tr>
    <td>关注项目：</td>
    <td align="left">
    	<?php if($model->attention==0){
    	?>
    	<input name="Member[attention]" type="radio" id="attention" size="44" value="0" checked style="width:35px"/>商务园
    	<input name="Member[attention]" type="radio" id="attention" size="44" value="1" style="width:35px"/>香林第6区
    	<?php 	
    	}else{
    	?>
    	<input name="Member[attention]" type="radio" id="attention" size="44" value="0" style="width:35px"/>·商务园
    	<input name="Member[attention]" type="radio" id="attention" size="44" value="1" checked style="width:35px"/>·香林第6区
    	<?php 	
    	}?>
    </td>
  </tr>
  <tr>
    <td>积分：</td>
    <td align="left">
    	<input name="Member[integral]" type="text" id="integral" size="44" value="<?php echo $model->integral;?>" />
    </td>
  </tr>
</table>

<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="UpdateMember()">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>

</form>
</div>
</div>
</div>
</div>
</div>
