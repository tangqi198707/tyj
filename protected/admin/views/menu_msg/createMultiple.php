<form id="menuMsgNewsForm" action="<?php echo $this->createUrl('menu_msg/createMultiple',array('method'=>'create'));?>" method="post">
<div id="addNews">
<div class="twx_box">
	<div class="twx_list">
    	<div class="twx_list_title">图文消息</div>
        <div class="twx_list_box">
        	<div class="twx_list_box_left">
            	<div class="twx_list_box_txt_box" name="multipleNewsList" id="list_0">
                    <div id="showTitle" class="twx_list_box_left_title">标题</div>
                    <div class="twx_list_box_left_time"><?php echo date('Y-m-d')?></div>
                    <div class="twx_list_box_left_pic" id="cover">封面图片</div>
                    <div class="multipleNewsListCover" id="multipleNewsListCoverFirst">
                		<a href="javascript:;" onclick="editNewsDetail($(this).parents('.twx_list_box_txt_box'))">编辑</a>
                	</div>
                </div>
                <div class="multipleNewsList" name="multipleNewsList" id="list_1">
                	<span id="showTitle" class="multipleNewsListTitle">标题</span>
                	<span class="multipleNewsListThumb" id="cover">封面图片</span>
                	<div class="clear"></div>
                	<div class="multipleNewsListCover">
                		<a class="multipleNewsListEdit" href="javascript:;" onclick="editNewsDetail($(this).parents('.multipleNewsList'))">编辑</a>
                		<a href="javascript:;" onclick="delMultipleNews($(this).parents('.multipleNewsList'));">删除</a>
                	</div>
                </div>
                <div class="addMultipleNews">
                	<a href="javascript:;" onclick="addNewsList()">添加</a>
                </div>
            </div>
            <div class="twx_list_box_right">
            	<div class="twx_list_box_txt_box" id="detail_0" name="multipleNewsDetail">
            		<div class="twx_list_box_right_title">
                        <p>分类</p>
                        <p>
                        	<select id="addCategory" name="category">
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
                        	<input name="title[]" type="text" maxLength="64"/>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>作者</p>
                        <p>
                        	<input name="author[]" type="text" maxLength="64"/>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>封面<span>大图片建议尺寸为360像素 * 200像素的jpg或png封面</span></p>
                        <p>
                        	<div class="uploadDiv">
                        		<a href="javascript:;"><img src="/media/images/uploadWord.jpg" /></a>
                        		<div id="updiv" style="">
									<input id="fileToUpload_0" class="fileToUpload" type="file" name="fileToUpload" onchange="return ajaxFileUpload('fileToUpload_0','upMultipleCoverSucc',0);">
									<input type="hidden" id="imgurl_0" name="imgurl[]">
									<input id="thumb_0" name="thumb[]" type="hidden">
							</div>
                        	</div>
                        	<div id="upImgBox" class="upImgBox">
                        	</div>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title" style="margin-top:5px">
                        <span>
                        	<input id="show_cover_0" class="checkbox" name="show_cover_chk" type="checkbox" maxLength="64" checked/>
                        	<input type="hidden" id="show_cover_0_val" name="show_cover[]" value="1" />
                        </span>
                        <span>封面图片显示在正文中
                        </span>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>正文</p>
                        <p><textarea id="content_0" name="content[]" cols="" rows=""></textarea></p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>添加原文链接<span>必须以“http://”等开头</span></p>
                        <p><input name="link[]" type="text" value=""/></p>
                    </div>
                </div>
                
                <div class="twx_list_box_txt_box" id="detail_1" style="display:none" name="multipleNewsDetail">
                	<div class="twx_list_box_right_title">
                        <p>标题</p>
                        <p>
                        	<input name="title[]" type="text" maxLength="64"/>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>作者</p>
                        <p>
                        	<input name="author[]" type="text" maxLength="64"/>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>封面<span>小图片建议尺寸：200像素 * 200像素</span></p>
                        <p>
                        	<div class="uploadDiv">
                        		<a href="javascript:;"><img src="/media/images/uploadWord.jpg" /></a>
                        		<div id="updiv" style="">
									<input id="fileToUpload_1" class="fileToUpload" type="file" name="fileToUpload" onchange="return ajaxFileUpload('fileToUpload_1','upMultipleCoverSucc',1);">
									<input type="hidden" id="imgurl_1" name="imgurl[]">
									<input name="thumb[]" id="thumb_1" type="hidden">
							</div>
                        	</div>
                        	<div id="upImgBox" class="upImgBox">
                        	</div>
                        </p>
                    </div>
                    <div class="twx_list_box_right_title" style="margin-top:5px">
                        <span>
                        	<input id="show_cover_1" class="checkbox" name="show_cover_chk" type="checkbox" maxLength="64" checked/>
                        	<input type="hidden" id="show_cover_1_val" name="show_cover[]" value="1" />
                        </span>
                        <span>封面图片显示在正文中
                        </span>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>正文</p>
                        <p><textarea id="content_1" name="content[]" cols="" rows=""></textarea></p>
                    </div>
                    <div class="twx_list_box_right_title">
                        <p>添加原文链接<span>必须以“http://”等开头</span></p>
                        <p><input name="link[]" type="text" value=""/></p>
                    </div>
                </div>
                
            </div>
            <div class="clear"></div>
        </div>
        <div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="addMultipleNews()">完成</a></div>
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
	createEditor();
}
var upUrl = '<?php echo $this->createUrl('ajaxUpload/up',array('thumb'=>true))?>';
$(function(){
	loadEditor();
	$('.popup-body').find("input[name='title[]']").live('keyup',function(){
		var index = getDetailIndex($(this));
		$('#list_'+index).find('#showTitle').html($(this).val());
	});
	$('.popup-body').find('div[name="multipleNewsList"]').live('mouseenter',function(){
		$(this).find('.multipleNewsListCover').show();
	});
	$('.popup-body').find('div[name="multipleNewsList"]').live('mouseleave',function(){
		$(this).find('.multipleNewsListCover').hide();
	});
	$('input[name="show_cover_chk"]').live('click',function(){
		var v = $(this).attr('checked') ? 1 : 0;
		$('#'+$(this).attr('id')+'_val').val(v);
	});
})
</script>