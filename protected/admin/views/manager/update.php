<?php 
$this->pageTitle = '修改管理员 - '.Yii::app()->name;
?>
<?php 
	$chickUpdateEmailUrl = $this->createUrl('manager/checkManagerEmail',array('id'=>$model->id));
?>
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">修改管理员<span><a href="javascript:;" onclick="$.closePopupLayer();">×</a></span></div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list" style="width:100%;">
<form method="POST" id="myform" action="<?php echo $this->createUrl('manager/update',array('id' => $model->id));?>" enctype="multipart/form-data">
<table width="77%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto;">
  <tr>
    <td>管理员帐号：</td>
    <td align="left">
    	<input name="Manager[name]" type="text" id="name" size="44" value="<?php echo $model->name;?>" readOnly/>
    </td>
  </tr>
  <tr>
    <td>登陆密码：</td>
    <td align="left">
    	<input name="password" type="password" id="password" size="44" value=""/>
    </td>
  </tr>
    <tr>
    <td>确认登陆密码：</td>
    <td align="left">
    	<input name="Con_pwd" type="password" id="Con_pwd" size="44" value=""/>
    </td>
  </tr>
  <tr>
    <td>邮　　箱：</td>
    <td align="left">
    	<input name="Manager[email]" type="text" id="email" size="44" value="<?php echo $model->email;?>" onblur="checkManagerEmail('<?php echo $chickUpdateEmailUrl; ?>')" /><span id="suggestion1" style="color:red;margin-left:10px;"></span>
    </td>
  </tr>
  <tr>
    <td>联系电话：</td>
    <td align="left">
    	<input name="Manager[tel]" type="text" id="tel" size="44" value="<?php echo $model->tel;?>" />
    </td>
  </tr>
</table>

<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="UpdateManager('<?php echo $chickUpdateEmailUrl ;?>')">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>

</form>
</div>
</div>
</div>
</div>
</div>
