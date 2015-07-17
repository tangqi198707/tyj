<?php
$this->pageTitle = '菜单管理 - '.Yii::app()->name;
?>
<div class="menu_box">
	<div class="menu_list">
    	<div class="menu_list_left">
        	<div class="menu_list_title">
            	<span class="menu_cd">菜单管理</span>
                <span class="menu_tj" name="order1"><a href="javascript:;" onclick="menuPopups(0,'<?php echo $this->createUrl('menu/checkAdd',array('type'=>'parent'))?>',0)">添加</a></span>
                <span class="menu_px" name="order1"><a href="javascript:;" onclick="orderBegin(true)">排序</a></span>
                <span class="menu_tj" name="order2" style="display:none"><a href="javascript:;" onclick="submitOrder('<?php echo $this->createUrl('menu/order')?>')">完成</a></span>
                <span class="menu_px" name="order2" style="display:none"><a href="javascript:;" onclick="orderCancel()">取消</a></span>
                <div class="clear"></div>
            </div>
            <div class="menu_list_left_dl">
            	<dl id="menuDl">
            		<?php 
            			$no = $pno = 0;
            			foreach($model as $key => $val){
						?>
						<div pno="<?php echo $pno?>" name="parent_0">
						<dt id="menu_<?php echo $val->id?>" no="<?php echo $no;?>" parent="1">
							<span class="txt" id="menuTxt_<?php echo $val->id?>" onclick="editBegin($(this).attr('id'))"><?php echo $val->name?></span>
							<span name="operation" onclick="delMenu('<?php echo $val->id?>','<?php echo $this->createUrl('menu/delete',array('id'=>$val->id))?>')">删除</span>
							<span name="operation" onclick="updateMenuPopups('<?php echo $val->id?>','<?php echo $val->pid?>')">编辑</span>
							<span name="operation" onclick="menuPopups(1,'<?php echo $this->createUrl('menu/checkAdd',array('type'=>'child','pid'=>$val->id))?>','<?php echo $val->id?>')">添加</span>
							<div class="orderSpan" id="order_<?php echo $val->id?>"></div>
							<div class="clear"></div>
						</dt>
						<?php 
							$no++;	
							$childModel = Menu::model()->findAll(array(
								'condition' => 'pid = '.$val->id.' and status = 1',
								'order' => 'weight'
							));
							if($childModel){
								foreach($childModel as $k => $v){
								?>
								<dd id="menu_<?php echo $v->id?>" name="childDd_<?php echo $val->id?>" no="<?php echo $no;?>">
									<span class="txt" id="menuTxt_<?php echo $v->id?>" onclick="editBegin($(this).attr('id'))"><?php echo $v->name?></span>
									<span name="operation" onclick="delMenu('<?php echo $v->id?>','<?php echo $this->createUrl('menu/delete',array('id'=>$v->id))?>')">删除</span>
									<span name="operation" onclick="updateMenuPopups('<?php echo $v->id?>','<?php echo $v->pid?>')">编辑</span>
									<div class="orderSpan" id="order_<?php echo $v->id?>"></div>
									<div class="clear"></div>
								</dd>
								<?php 	
								$no++;	
								}
							}
							echo '</div>';
							$pno++;
            			}
            		?>
                </dl>
            </div>
        </div>
        <div class="menu_list_right">
        	<div class="menu_list_title">
        		<span class="menu_cd">动作设置</span>
        		<a href="javascript:;" id="updateLinkMsgBtn" onclick="updateLinkMsgBegin()">修改</a>
        	</div>
        	<div id="menuMsgPrompt" name="msgDiv">你可以先添加一个菜单，然后开始为其设置响应动作</div>
        	<div id="menuMsgType" name="msgDiv">
        		<div class="menuMsgTypeTitle">请选择订阅者点击菜单后，公众号做出的相应动作</div>
        		<div class="menuMsgTypeBtnDiv">
        			<a href="javascript:;" onclick="createMsgBegin();">发送信息</a>
        			<a href="javascript:;" onclick="changeMsgDiv('linkMsgDiv')">跳转到网页</a>
        			<div class="clear"></div>
        		</div>
        	</div>
        	<div id="linkMsgDiv" name="msgDiv">
        		<div class="linkMsgTitle">订阅者点击该子菜单会跳到以下链接</div>
        		<div class="linkMsgInputDiv">
        			<input type="text" id="linkMsg" />
        		</div>
        		<div class="linkMsgBtnDiv">
        			<a href="javascript:;" id="addLinkMsgBtn" onclick="addLinkMsg('<?php echo $this->createUrl('Menu_msg/createLinkMsg')?>')">保存</a>
        			<a href="javascript:;" id="addLinkMsgBtn2" style="display:none">保存</a>
        			<a href="javascript:;" onclick="showMsgType()">返回</a>
        			<div class="clear"></div>
        		</div>
        	</div>
        	<div id="showLinkMsgDiv" name="msgDiv">
        		<div class="menuMsgTypeTitle">订阅者点击该子菜单会跳到以下链接</div>
        		<div id="showLinkMsg"></div>
        	</div>
        	<div id="updateLinkMsgDiv" name="msgDiv">
        		<div class="linkMsgTitle">订阅者点击该子菜单会跳到以下链接</div>
        		<div class="linkMsgInputDiv">
        			<input type="text" id="updateLinkMsg" />
        			<input type="hidden" id="updateLinkMsgId"/>
        		</div>
        		<div class="linkMsgBtnDiv">
        			<a href="javascript:;" id="updateLinkBtn" onclick="updateLinkMsg('<?php echo $this->createUrl('Menu_msg/updateLinkMsg')?>')">保存</a>
        			<a href="javascript:;" id="updateLinkBtn2" style="display:none">保存</a>
        			<a href="javascript:;" onclick="closeUpdateLinkMsg()">返回</a>
        			<div class="clear"></div>
        		</div>
        	</div>
            <div class="menu_list_right_box" id="createMsgDiv" name="msgDiv">
            	<div class="menu_list_right_txt">订阅者点击该子菜单会收到以下消息</div>
                <div class="menu_list_right_list">
                	<div class="menu_list_right_title">
                    	<a href="javascript:;" id="textTag" class="menu_vtd" name="text" onclick="chooseTextTag()">文字</a>
                    	<a href="javascript:;" id="newsTag" name="news" onclick="chooseNewsTag()">图文消息</a>
                        <div class="clear"></div>
                    </div>
                    <div class="menu_list_right_text" id="textDiv">
                    	<input type="hidden" id="updateMsgId" />
                    	<textarea id="message" style="display:none"></textarea>
                    	<div id="editDiv" contenteditable="true"></div>
                    </div>
                    <div class="menu_list_right_text" id="newsDiv" style="display:none">
                    	<div class=""></div>
                    </div>
                    <div class="menu_list_right_xz">
                    	<div class="emotionsBox">
				    		<a href="javascript:;" class="emotionsWord"></a>
					    	<div class="emotions">
				            <table cellspacing="0" cellpadding="0">
				            </table>
					        <div class="emotionsGif"></div>
					    </div>
				        </div>
                    	</div>
                </div>
                <div class="menu_list_right_bt">
                	<a class="msgBtn" href="javascript:;" id="createMsgBtn" onclick="addMenuMsg($('#message'),$('.menu_vtd').attr('name'),$('#editDiv'),'<?php echo $this->createUrl('menu_msg/createMsg');?>')">保存</a>
                	<a class="msgBtn" href="javascript:;" id="createMsgBtn2" style="display:none">保存</a>
                	<a class="msgBtn" href="javascript:;" id="updateMsgBtn" onclick="updateMenuMsg($('#message'),$('.menu_vtd').attr('name'),$('#editDiv'),'<?php echo $this->createUrl('menu_msg/updateMsg');?>')">保存</a>
                	<a class="msgBtn" href="javascript:;" id="updateMsgBtn2" style="display:none">保存</a>
                	<a href="javascript:;" onclick="changeMsgDiv('menuMsgType')">返回</a>
                </div>
            </div>
            
            <div id="showMenuMsg" name="msgDiv">
            	<div class="menuMsgTypeTitle">订阅者点击该子菜单会收到以下消息</div>
            	<div id="showMsg"></div>
            	<div id="copyNewsDiv" style="display:none">
	            	<div class="menu_tw_list_box_one_bak">
	                    <div class="menu_tw_list_box_title"></div>
	                    <div class="menu_tw_list_box_time"></div>
	                    <div class="menu_tw_list_box_pic"><img src="" /></div>
	                    <div class="menu_tw_list_box_text"></div>
	                    <div class="multipleList"></div>
	                    <input type="hidden" value="" />
	                </div>
	            </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="publish">
    	<a href="javascript:;" id="publishMenuBtn" onclick="publishMenu('<?php echo $this->createUrl('menu/createWxMenu');?>')">发布</a>
    	<a href="javascript:;" id="publishMenuBtn2" style="display:none">发布</a>
    </div>
</div>

<!-- ------------------------------------ -->
<div id="addMenu" style="display:none">
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">输入提示框</div>
<div class="popcon" style="width:100%;background-color:white;height:300px;">
<div class="form_list" style="width:100%;padding-top:80px">
<table width="75%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto">
	<tr>
		<td id="menuPrompt"></td>
	</tr>
  <tr>
    <td>
    	<input type="text" name="menu" id="menu" />
    	<input type="hidden" id="child" />
    	<input type="hidden" id="pid" />
    	<input type="hidden" id="menuLimit" />
    </td>
  </tr>
</table>
<div class="twx_list_bt">
        	<div class="twx_list_bt_bc">
        		<a id="submitBtn" href="javascript:;" onclick="addMenu($('.popup-body').find('#menu'),'<?php echo $this->createUrl('menu/create')?>',$('.popup-body').find('#child').val(),$('.popup-body').find('#pid').val())">完成</a>
        		<a id="submitBtn2" href="javascript:;" style="display:none">完成</a>	
        	</div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- ------------------------------------ -->

<div id="updateMenu" style="display:none">
<div class="content">
<div class="pop" style="width:100%; left:0; background:none;">
<div class="popBox">
<div class="popTitle">输入提示框</div>
<div class="popcon" style="width:100%;background-color:white;height:300px;">
<div class="form_list" style="width:100%;padding-top:80px">
<table width="75%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; text-align:center;margin:0 auto">
	<tr>
		<td id="menuPrompt"></td>
	</tr>
  <tr>
    <td>
    	<input type="text" name="menu" id="menu" />
    	<input type="hidden" id="menuId" />
    	<input type="hidden" id="menuLimit" />
    </td>
  </tr>
</table>
<div class="twx_list_bt">
        	<div class="twx_list_bt_bc"><a href="javascript:;" id="updateMenuBtn" onclick="updateMenu($('.popup-body').find('#menu'),'<?php echo $this->createUrl('menu/update')?>',$('.popup-body').find('#menuId').val())">完成</a></div>
        	<div class="twx_list_bt_bc"><a href="javascript:;" id="updateMenuBtn2" style="display:none">完成</a></div>
            <div class="twx_list_bt_bc"><a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
            <div class="clear"></div>
        </div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="/media/js/emotions.js"></script>
<script type="text/javascript">
var cloneDl = false;
var menuJson = '<?php echo $menuJson;?>';
//alert(menuJson);
var getMenuJsonUrl = '<?php echo $this->createUrl('menu/getMenuJson')?>';
$(function(){
	var moveObj = false;
	var moveParent = false;
	$(".orderSpan").live('mousedown',function(e)//e鼠标事件  
		    {  
				if(!cloneDl){
					cloneDl = $('#menuDl').clone(true);
		    	}
		    	moveObj = $(this).parent();
		    	var no = moveObj.attr('no');
		    	var objName = moveObj.attr('parent');
		    	if(objName == 1){
		    		moveParent = true;
		    		moveObj = moveObj.parent();
		    		no = moveObj.attr('pno');
			    }else
			    	moveParent = false;
		    	if($('.ddTmp').length == 0){
		    		moveObj.after('<dd class="ddTmp"></dd>');
		    	}
		        var x = e.pageX;//获得鼠标指针离DIV元素左边界的距离  
		        var y = e.pageY;//获得鼠标指针离DIV元素上边界的距离  
		        $(document).bind("mousemove",function(ev)//绑定鼠标的移动事件，因为光标在DIV元素外面也要有效果，所以要用doucment的事件，而不用DIV元素的事件  
		        {  
		        	moveObj.css({position:'absolute'});
		        	moveObj.stop();//加上这个之后  
		            var _x = ev.pageX - x;//获得X轴方向移动的值  
		            var height = 30;
		            if(moveParent){
			            if(no == 0){
							height = parseInt($("div[pno=0]").css('height'))
				        }else{
				        	height = 0;
			            	for(var i=0;i<no;i++){
								height = height + parseInt($("div[pno='"+i+"']").css('height'));
							}
					    }
			        }
		            var _y,flag;
		            if(moveParent){
						var moveArr = new Array();
						height = 0;
						var len = $('div[pno]').length;
						for(var i=0;i<=len;i++){
							moveArr[i] = height;
							height += parseInt($("div[pno='"+i+"']").css('height')); 
						}
						_y = ev.pageY - y + moveArr[no];
						if(_y <= moveArr[1]){
							flag = 0;
						}else if(_y < moveArr[2]){
							flag = 1;
						}else{
							flag = 2;
						}
			        }else{
			        	_y = ev.pageY - y + no * height;
			            flag = parseInt(_y / height);
				    }
		            //$('#menuMsgPrompt').html(moveArr[0]+'**'+moveArr[1]+'**'+moveArr[2]+'**'+moveArr[3]+'**'+_y+'**'+flag);
		            
		            var currPid = getPid(moveObj);
		            if(flag != no){
		            	var section = $('dd[no="'+flag+'"]').length == 0 ? $('dt[no="'+flag+'"]') : $('dd[no="'+flag+'"]');
			            if(moveParent){
			            	section = $('div[pno="'+flag+'"]');
				        }
			            var spid = getPid(section);
		            	if(currPid == spid){
		            		$('.ddTmp').remove();
							if($('.ddTmp').length == 0){
								section.after('<dd class="ddTmp"></dd>');
					    	}
			            }
		            }
		            if(moveParent){
						if(_y < 0){
							$('.ddTmp').remove();
							if($('.ddTmp').length == 0){
								$("div[pno='0']").before('<dd class="ddTmp"></dd>');
					    	}
						}
			        }
		            moveObj.animate({left:_x+"px",top:_y+"px"},5);  
		        });  
		              
		     });  
		       
		     $(document).mouseup(function()  
		     {  
			     if(moveObj){
			    	 moveObj.css({position:'static',top:0,left:0});
			    	 $('.ddTmp').after(moveObj);
				     $('.ddTmp').remove();
				     resetNo();
				     moveObj = false;
				 }
		         $(this).unbind("mousemove");  
		     })
})
function getPid(obj){
	if(obj.length != 0){
		var currName = obj.attr('name');
		if(currName){
			var arr = currName.split('_');
			return arr[1];
		}
		var currId = obj.attr('id');
		if(currId){
			var arr = currId.split('_');
			return arr[1];
		}
	}
	return false;
}
function resetNo(){
	var doms = $("[pno]");
	doms.each(function(i){
		$(this).attr('pno',i);
	});
	var doms = $("[no]");
	doms.each(function(i){
		$(this).attr('no',i);
	});
}
function orderCancel(){
	if(cloneDl){
		$('#menuDl').html(cloneDl.html());
	}
	orderBegin(false);
}
function chooseNews(){
	$('.link_vtd').hide();
	$('#chooseNews').find('.cover1').hide();
	$('#newsDiv div').addClass('menu_tw_list_box_one_bak').html($('#chooseNews').html());
	$('.menu_list_left').css('height',$('.menu_list').css('height'));
	$.closePopupLayer();
}
function chooseNewsTag(){
	$('.menu_list_right_title a').removeClass('menu_vtd');
	$('#newsTag').addClass('menu_vtd');
	$('.menu_list_right_text').hide();
	$('#newsDiv').show();
	ajaxBox('<?php echo $this->createUrl ( 'menu_msg/getNewsMsg' )?>',{},function(){},true);
}
</script>