<?php 
$this->pageTitle = '修改资讯- '.Yii::app()->name;
?>
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">修改资讯<span><a href="javascript:;" onclick="$.closePopupLayer();"></a></span></div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list" style="width:100%;">
<form method="POST" id="myform" name="myform" action="<?php echo $this->createUrl('Dynamic/update',array('id'=>$model->id));?>" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $_SERVER['HTTP_REFERER']?>" name="url"/>
<table width="81%"  border="0" cellpadding="0" cellspacing="0" style="font-size:12px;margin:0 auto;text-align:center;">
  <tr>
    <td style="display:block;width:60px;line-height:40px;">标题</td>
    <td align="left">
    	<input name="Dynamic[title]" type="text" id="title" size="44" style="width:498px" value="<?php echo $model->title;?>"/>
    </td>
  </tr>
   <tr>
    <td>资讯图片</td>
    <td align="left" valign="middle">
    <div class="llwj_text_div_big">
		      <div style="position:absolute;z-index:100;left:0px;top:3px;">
		      	<input class="textbox" type="text" id="info_img" name="Dynamic[info_img]" style="width:200px;" value="<?php echo $model->info_img;?>" readOnly />
		      </div>
		      <iframe class="iframe_style_ys" src="<?php echo $this->createUrl('upload/up',array('id'=>'info_img'));?>" frameborder="no" border="0" scrolling="no"></iframe>
			  <span class="tjrb_form_span2"><a href="#"><img src="/media/images/llwj_btn.png" alt=""/></a></span>
		</div>
    </td>
  </tr>
   <tr>
    <td>资讯内容</td>
    <td align="left">
    	<textarea name="Dynamic[content]" id="content" style="margin-top:3px;"><?php echo $model->content;?> </textarea>
    </td>
  </tr>
</table>
<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="AddDynamic()">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
</div>
</form>
</div>
</div> 
</div>
</div>
</div>
<script type="text/javascript" src="/media/js/ajaxfileupload.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript">
function createMyEditor(){
	UE.getEditor('content');
}
loadEditor();
var upUrl = '<?php echo $this->createUrl('upload/up',array('thumb'=>true))?>';
$(function(){
	$('.popup-body').find('#title').live('keyup',function(){
		$('.popup-body').find('#showTitle').html($(this).val());
	});
})
</script>
