<form id="menuMsgNewsForm" action="<?php echo $this->createUrl('menu_msg/create',array('method'=>'create'));?>" method="post">
<div id="addNews">
<div class="twx_box">
	<div class="twx_list">
    	<div class="twx_list_title">图文消息</div>
        <div class="twx_list_box">
        	<div class="twx_list_box_left">
            	<div class="twx_list_box_txt_box">
                    <div id="showTitle" class="twx_list_box_left_title">标题</div>
                    <div class="twx_list_box_left_time"><?php echo date('Y-m-d')?></div>
                    <div class="twx_list_box_left_pic">封面图片</div>
                </div>
            </div>
            <div class="twx_list_box_right">
            	<div class="twx_list_box_txt_box">
            		<div class="twx_list_box_right_title">
                        <p>分类</p>
                        <p>
                        	<select id="category" name="category">
                        		<option value="">选择分类</option>
                        		<?php foreach($category as $key => $val){
                        			echo '<option value="'.$val->id.'">'.$val->name.'</option>';
                        		}?>
                        	</select>
                        </p>
                    </div>
                	<div class="twx_list_box_right_title">
                        <p>标题</p>
                        <p>
                        	<input id="title" name="title" type="text" maxLength="64"/>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>作者</p>
                        <p>
                        	<input id="author" name="author" type="text" maxLength="64"/>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>封面<span>大图片建议尺寸为360像素 * 200像素的jpg或png封面</span></p>
                        <p>
                        	<div class="uploadDiv">
                        		<a href="javascript:;"><img src="/media/images/uploadWord.jpg" /></a>
                        		<div id="updiv" style="">
									<input id="fileToUpload" type="file" name="fileToUpload" onchange="return ajaxFileUpload('fileToUpload','upCoverSucc');">
									<input id="imgurl" type="hidden" name="imgurl">
									<input id="thumb" name="thumb" type="hidden">
							</div>
                        	</div>
                        	<div id="upImgBox" class="upImgBox">
                        	</div>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title" style="margin-top:5px">
                        <span>
                        	<input id="show_cover" name="show_cover" class="checkbox" type="checkbox" maxLength="64" checked value="1"/>
                        </span>
                        <span>封面图片显示在正文中
                        </span>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>摘要</p>
                        <p><textarea id="abstract" name="abstract" cols="" rows=""></textarea></p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>正文</p>
                        <p><textarea id="content" name="content" cols="" rows=""></textarea></p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>添加原文链接<span>必须以“http://”等开头</span></p>
                        <p><input id="link" name="link" type="text" value=""/></p>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="AddNews($('.popup-body').find('#title'),$('.popup-body').find('#imgurl'),$('.popup-body').find('#thumb'),$('.popup-body').find('#content'),$('.popup-body').find('#link'),'news',true,$('.popup-body').find('#category'),$('.popup-body').find('#city'))">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>
    </div>
</div>
</div>
</form>
<script type="text/javascript" src="/media/js/ajaxfileupload.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript">
function createMyEditor(){
	UE.getEditor('content');
}
loadEditor();
var upUrl = '<?php echo $this->createUrl('ajaxUpload/up',array('thumb'=>true))?>';
$(function(){
	$('.popup-body').find('#title').live('keyup',function(){
		$('.popup-body').find('#showTitle').html($(this).val());
	});
})
</script>