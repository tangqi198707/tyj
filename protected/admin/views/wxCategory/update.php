<?php 
$this->pageTitle = '修改分类- '.Yii::app()->name;
?>
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">修改分类<span><a href="javascript:;" onclick="$.closePopupLayer();">×</a></span></div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list" style="width:100%;">
<form method="POST" id="myform" name="myform" action="<?php echo $this->createUrl('wxCategory/update',array('id'=>$model->id));?>" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $_SERVER['HTTP_REFERER']?>" name="url"/>
<table width="77%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto;">
  <tr>
    <td>分类名称：</td>
    <td align="left">
    	<input name="WxCategory[name]" type="text" id="name" size="44" value="<?php echo $model->name?>" />
    </td>
  </tr>
</table>
<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="AddWxCategory('<?php echo $this->createUrl('wxCategory/checkCateName',array('id'=>$model->id)); ?>')">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>

</form>
</div>
</div>
</div>
</div>
</div>