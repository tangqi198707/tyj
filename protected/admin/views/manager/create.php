<?php 
$this->pageTitle = '添加管理员- '.Yii::app()->name;
?>
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">添加管理员<span><a href="javascript:;" onclick="$.closePopupLayer();">×</a></span></div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list" style="width:100%;">
<form method="POST" id="myform" name="myform" action="<?php echo $this->createUrl('manager/create');?>" enctype="multipart/form-data">
<table width="77%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto;">
  <tr>
    <td>管理员帐号：</td>
    <td align="left">
    	<input name="Manager[name]" type="text" id="name" size="44" onblur="checkManagerName('<?php echo $this->createUrl('manager/checkManagerName')?>')" /><span id="suggestion" style="color:red;margin-left:10px;"></span>
    </td>
  </tr>
  <tr>
    <td>登陆密码：</td>
    <td align="left">
    	<input name="pwd" type="password" id="pwd" size="44" value=""/>
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
    	<input name="Manager[email]" type="text" id="email" size="44" value="" onblur="checkManagerEmail('<?php echo $this->createUrl('manager/checkManagerEmail');?>')" /><span id="suggestion1" style="color:red;margin-left:10px;"></span>
    </td>
  </tr>
  <tr>
    <td>联系电话：</td>
    <td align="left">
    	<input name="Manager[tel]" type="text" id="tel" size="44" value=""/>
    </td>
  </tr>
</table>
<?php 
$checkManagerUrl = $this->createUrl('manager/checkManagerName');
$checkEmailUrl = $this->createUrl('manager/checkManagerEmail');
?>

<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="AddManager('<?php echo $checkManagerUrl; ?>','<?php echo $checkEmailUrl; ?>')">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>

</form>
</div>
</div>
</div>
</div>
</div>