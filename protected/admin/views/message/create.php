<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">添加默认回复</div>
<div class="popcon" style="width:100%;background-color:white">
<div class="form_list" style="width:100%;">
<form method="POST" id="defaultForm" action="<?php echo $this->createUrl('message/create',array('method'=>'create'));?>">
<table width="75%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto" id="table">
  <tr>
    <td>默认回复：</td>
    <td align="left">
    	<div class="emotionsBox">
    		<a href="javascript:;" class="emotionsWord"></a>
	    	<div class="emotions">
	              <table cellspacing="0" cellpadding="0">
	              </table>
	              <div class="emotionsGif"></div>
	        </div>
        </div>
    	<textarea rows="10" cols="50" id="msgContent" name="content" style="display:none"></textarea>
    	<div id="editDiv" contenteditable="true"></div>
    </td>
  </tr>
</table>

<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" onclick="AddMessage()">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>

</form>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="/media/js/emotions.js"></script>
