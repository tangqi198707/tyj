<?php
$this->pageTitle = '关键词自动回复 - '.Yii::app()->name;
?>
<div class="menu_box">
 <form id="searchForm" action="<?php echo $this->createUrl('group/admin');?>" method="GET">
     <div class="content_width">
        	<div class="content_width_title">
            	<ul>
                	<li>
                    	<span>规则名：</span>
                        <span><input name="Group[name]" type="text" value="<?php echo $search['name']?>" /></span>
                    </li>
                    <li>
	                    <label>发布时间：</label>
						<label>从</label>
						<input name="Group[publish_start]" style="width:110px;" type="text" onclick="WdatePicker()"; value="<?php echo $search['publish_start']?>" readonly/> 
						<label>至</label> 
						<input name="Group[publish_end]" style="width:110px;" type="text" onclick="WdatePicker()"; value="<?php echo $search['publish_end']?>" readonly/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </li>
                    <li><a href="javascript:void(0);" onclick="$('#searchForm').submit();">搜索</a></li> 
                    <li><a id="tj" href="javascript:void(0);" >添加</a></li> 
                </ul>
            </div>
     </div>
  </form>
<div id="wx_list_box_c" class="wx_box" style="display:none">
<form id="form0" name="groupForm" action="<?php echo $this->createUrl('group/create')?>" method="post">
	<div class="wx_list">
    	<div class="wx_list_title">
        	<div class="wx_list_title_left">
        		<span>新规则</span>
        		  <label>　回复方式:</label>
        		　<input type="radio" name="Group[type]" value="new" checked="checked"/><label>最新</label>
        		　<input type="radio" name="Group[type]" value="random" /><label>随机</label>
        		  <label>　发布状态:</label>
    			　<input type="radio" name="Group[status]" value="1" checked="checked"/><label>启用</label>
    			　<input type="radio" name="Group[status]" value="0" /><label>禁用</label>
        	</div>
            <div class="wx_list_title_right"><a href="javascript:;">收起</a></div>
            <div class="clear"></div>
        </div>
        <div id="wx_list_box_xq" class="wx_list_box">
            <div class="wx_list_gzm">
                <span>规则名：</span>
                <span><input id="groupName" name="Group[name]" type="text" /></span>
                <span>规则名最多60字</span>
                <div class="clear"></div>
            </div>
            <div class="wx_list_txt">
            	<div class="wx_list_txt_left">
                    <div class="wx_list_txt_title">
                        <div class="wx_list_txt_title_left">关键字</div>
                        <div class="wx_list_txt_title_right"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="wx_list_txt_box">
                        <div class="wx_list_txt_left_txt">
                        <div class="ulBox">
                            <ul id="keywordBox">
                            </ul>
                            </div>
                        </div>
                    </div>
                    <div class="wx_list_txt_left_bt">
                    	<div class="wx_list_txt_left_bt_left"><a href="javascript:;" onclick="delKeyword1($(this).parents('form'))">删除选中</a></div>
                        <div class="wx_list_txt_left_bt_right"><a href="javascript:;" onclick="keywordPopups('form0')">添加关键字</a></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="wx_list_txt_right">
                	<div class="wx_list_txt_title">
                   		<div class="wx_list_txt_title_left">回复</div>
                        <div class="clear"></div>
                    </div>
                    <div class="wx_list_txt_box">
                        <div class="wx_list_txt_right_tit">
                            <span>文字（<label id="textCount">0</label>）</span>
                            <span>图文（<label id="newsCount">0</label>）</span>
                        </div>
                        <div class="wx_list_txt_right_txt">
                        <div class="ulBox">
                            <ul id="msgBox">
                            </ul>
                            </div>
                        </div>
                    </div>
                    <div class="wx_list_txt_right_bt">
                    	<div class="wx_list_txt_right_bt_left"><a href="javascript:;" onclick="delText1($(this).parents('form'))">删除选中</a></div>
                        <div class="wx_list_txt_right_bt_right">
                        	<span><a href="javascript:;" onclick="textPopups('form0')">文字</a></span>
                            <span><a href="javascript:;" onclick="newsPopups('form0','<?php echo $this->createUrl ( 'menu_msg/getNewsMsg' )?>')">图文</a></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="wx_list_bt">
            	<div class="wx_list_bt_sc"><a href="javascript:;">删除</a></div>
            	<div class="wx_list_bt_bc"><a href="javascript:;" onclick="checkAddGroup($(this).parents('form'),'<?php echo $this->createUrl('group/checkGroupName');?>','<?php echo $this->createUrl('group/checkGroupKey');?>')">保存</a></div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="wx_list_box_lb" class="wx_list_box"  style="display:none;">
        	<div class="wx_list_gjc">
            	<div class="wx_list_gjc_left">关键词：</div>
                <div class="wx_list_gjc_right">
                </div>
                <div class="clear"></div>
            </div>
            <div class="wx_list_gjc">
            	<div class="wx_list_gjc_left">回复：</div>
                <div class="wx_list_gjc_right">0条 （0条文字，0个函数，0条图文）</div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    </form>
</div>
<div class="content_width_list">
 <?php
$this->widget('zii.widgets.CListView', array(
    'ajaxUpdate' => false,
	'id' => 'group_list',
	'dataProvider'=>$model->search(),
	'itemView'=>'_list',
	'pager' => array(
		'class'=>'LLinkPager',
	), 
	'emptyText' => '没有关键词自动回复'
	//'template' => '{items}{pager}',
));
?>
</div>
<script type="text/javascript" src="/media/js/emotionsGroup.js"></script>
<script type="text/javascript">
var updateKeywordUrl = '<?php echo $this->createUrl('group/updateKeyword')?>';
var updateMsgUrl = '<?php echo $this->createUrl('group/updateMsg')?>';
$(function(){
  	$(".wx_list_title_right a").click(function(){
  	  	var p = $(this).parents('.wx_list_title');
  	  	var a = $(this);
	  	p.siblings().slideToggle('normal',function(){
	  		var str = p.next().css('display') == 'block' ? '收起' : '展开';
		  	a.html(str);
		});
	});
  	$("#tj").click(function(){
		$("#wx_list_box_c").slideToggle();
	});
});
</script>
<!-- --------------------------------------------------- -->
<div id="addKeyword" style="display:none">
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">关键字</div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list">
<table width="60%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto">
  <tr>
    <td>关键字：</td>
    <td align="left">
    	<input id="keyword" type="text" maxLength="30"/>
    </td>
  </tr>
  <tr>
    <td align="right" colspan="2" style="color:#B2B2B2;padding-right:25px">
    	关键字最多30字
    </td>
  </tr>
</table>

<div class="twx_list_bt">
    <div class="twx_list_bt_bc"><a href="javascript:;" onclick="AddKeyword($('.popup-body').find('#keyword'))">完成</a></div>
    <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
    <div class="clear"></div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>

<!-- --------------------------------------------------- -->
<div id="addText" style="display:none">
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">文字消息</div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list" style="width:100%;">
<table width="75%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto">
  <tr>
    <td>回复文字：</td>
    <td align="left">
    	<div class="emotionsBox">
    		<a href="javascript:;" class="emotionsWord"></a>
	    	<div class="emotions">
            <table cellspacing="0" cellpadding="0">
            </table>
	        <div class="emotionsGif"></div>
	    </div>
        </div>
    	<textarea rows="10" cols="50" id="message" style="display:none"></textarea>
    	<div id="editDiv" contenteditable="true"></div>
    </td>
  </tr>
</table>
<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="AddText($('.popup-body').find('#message'),'text',$('.popup-body').find('#editDiv'))">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>

</div>

</div>
</div>
</div>
</div>
</div>



<script type="text/javascript" src="/media/js/ajaxfileupload.js"></script>
<script type="text/javascript">
var upUrl = '<?php echo $this->createUrl('upload/up',array('thumb'=>true))?>';
$(function(){
	$('.popup-body').find('#title').live('keyup',function(){
		$('.popup-body').find('#showTitle').html($(this).val());
	});
})
function chooseNews(){
	var linkVal = $('#chooseNews').find('#newsMsgLink').val();
	var imgUrl = $('#chooseNews').find('#newsMsgThumb').find('img').attr('src');
	var arr = imgUrl.split('.');
	var thumbVal = imgUrl+'.'+arr[arr.length-1];
	var titleVal = $('#chooseNews').find('#newsMsgTitle').html();
	var msgId = $('#chooseNews').find('#newsMsgId').val();
	var msgBox = form.find('#msgBox');
	var type = 'news';
	var msgHtml = '<li><span class="dx_bt"><input name="delText" type="checkbox" value="" /></span>';
	msgHtml += '<span class="tq_pic"><a href="'+linkVal+'" target="_blank"><img src='+thumbVal+' /></a></span>';
	msgHtml += '<span class="tq_title_content"><a href="'+linkVal+'" target="_blank">'+titleVal+'</a></span>';
	msgHtml += '<input type="hidden" name=msgType[] value="'+type+'" />';
	msgHtml += '<textarea style="display:none" name=msgContent[]>'+msgId+'</textarea>';
	msgHtml += '<span class="txt">';
	msgHtml += '<a href="javascript:;" style="padding-left:12px;" onclick="changeAddKeyword($(this),\'hf\')">　启用</a>';
	msgHtml += '<input type="hidden" name=msgStatus[] value="1" />';
	msgBox.append(msgHtml);
	var textCount = form.find('#'+type+'Count');
	textCount.html(parseInt(textCount.html())+1);
	$.closePopupLayer();
}
</script>
</div>