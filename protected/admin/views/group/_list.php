<div class="wx_box">
<form id="form<?php echo $data->id;?>" name="groupForm" action="<?php echo $this->createUrl('group/update',array('id'=>$data->id))?>" method="post">
<input type="hidden" value="<?php echo $_SERVER['REQUEST_URI']?>" name="url"/>
	<div class="wx_list">
    	<div class="wx_list_title">
        	<div class="wx_list_title_left"><span>规则<?php echo $widget->dataProvider->pagination->currentPage*$widget->dataProvider->pagination->pageSize+($index+1)?>：</span><span style="font-weight: lighter;padding-left:0px"><?php echo $data->name;?></span>
        	<label>　回复方式:</label>
        		　<input type="radio" name="Group[type]" onclick="changeGroup_t('<?php echo $this->createUrl('group/changeAdmin_t',array('type'=> 'new','id'=>$data->id))?>',$(this),'0','type')" value="new" <?php echo $data->type == 'new' ? "checked='checked'":'';?>/><label>最新</label>
        		　<input type="radio" name="Group[type]" onclick="changeGroup_t('<?php echo $this->createUrl('group/changeAdmin_t',array('type'=> 'random','id'=>$data->id))?>',$(this),'1','type')" value="random" <?php echo $data->type == 'random' ? "checked='checked'":'';?>/><label>随机</label>
        		  <label>　发布状态:</label>
    			　<input type="radio" name="Group[status]" value="1" onclick="changeGroup_t('<?php echo $this->createUrl('group/changeAdmin_s',array('status'=> '1','id'=>$data->id))?>',$(this),'0')" <?php echo $data->status == '1' ? "checked='checked'":'';?>/><label>启用</label>
    			　<input type="radio" name="Group[status]" value="0" onclick="changeGroup_t('<?php echo $this->createUrl('group/changeAdmin_s',array('status'=> '0','id'=>$data->id))?>',$(this),'1')" <?php echo $data->status == '0' ? "checked='checked'":'';?>/><label>禁用</label>
        	</div>
            <div class="wx_list_title_right"><a href="javascript:;">展开</a></div>
            <div class="clear"></div>
        </div>
        <div id="wx_list_box_xq" class="wx_list_box" style="display:none">
            <div class="wx_list_gzm">
                <span>规则名：</span>
                <span><input id="groupName" name="Group[name]" type="text" value="<?php echo $data->name?>"/></span>
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
                            <?php 
                            	foreach($data->keywords as $key => $val){
                            ?>
                            		<li>
                            			<span class="dx_bt"><input name="delKeyword" type="checkbox" value="" /></span>
										<span class="tq"><?php echo $val->name?></span>
										<input id="kw_<?php echo $val->id?>" type="hidden" name="keywordName[]" value="<?php echo $val->name?>" />
										<span class="txt"><a href="javascript:;" onclick=keywordPopups($(this).parents('form').attr('id'),'kw_<?php echo $val->id?>')>编辑</a></span>
										<input type="hidden" name="keywordId[]" value="<?php echo $val->id?>" />
										<span class="pp">
											<a href="javascript:;" onclick="changeKeyword('<?php echo $this->createUrl('group/changeKeyword_s',array('status'=>$val->status == '1' ? '0':'1','id'=>$val->id))?>',$(this))"><?php echo $val->status == 1 ? '　启用' : '　禁用';?></a>
											<input type="hidden" name="keywordStatus[]" value="<?php echo $val->status?>" />
										</span>
									</li>
                            <?php 	
                            	}
                            ?>
                            </ul>
                            </div>
                        </div>
                    </div>
                    <div class="wx_list_txt_left_bt">
                    	<div class="wx_list_txt_left_bt_left"><a href="javascript:;" onclick="delKeyword1($(this).parents('form'))">删除选中</a></div>
                        <div class="wx_list_txt_left_bt_right"><a href="javascript:;" onclick="keywordPopups($(this).parents('form').attr('id'))">添加关键字</a></div>
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
                            <?php echo Message::model()->getMsgCount($data->messages,2);?>
                        </div>
                        <div class="wx_list_txt_right_txt">
                        	<div class="ulBox">
                            <ul id="msgBox">
                            <?php 
                            	foreach($data->messages as $key => $val){
                            		if($val->type == 'news'){
                            			$msg = MenuMsg::model()->findByPk($val->content);
                            			if($msg->multiple == 1){
                            				$contentArr =  json_decode($msg->content);
                            				$imgurl = $contentArr[0]->imgurl;
                            				$link = $contentArr[0]->link;
                            			}else{
                            				$imgurl = $msg->imgurl;
                            				$link = $msg->link;
                            			}
                            			$imgArr = explode(".",$imgurl );
                            			$thumbType = end($imgArr);
                            		?>
                            		<li><input name="msgId[]" type="hidden" value="<?php echo $val->id?>" />
                            		<span class="dx_bt"><input name="delText" type="checkbox" value="" /></span>
										<span class="tq_pic"><a href="<?php echo $link;?>" target="_blank"><img src='<?php echo $imgurl.'.'.$thumbType?>' /></a></span>
										<span class="tq_title_content">
										<a href="<?php echo $link;?>" target="_blank"><?php echo $msg->title;?></a>
										</span>
										<textarea style="display:none" name=msgContent[]><?php echo $msg->id;?></textarea>
										<input type="hidden" name=msgType[] value="<?php echo $val->type;?>" />
										<span class="txt">
										<a href="javascript:;" style="padding-left:12px;" onclick="changeKeyword('<?php echo $this->createUrl('group/changeMessage_s',array('status'=>$val->status == '1' ? '0':'1','id'=>$val->id))?>',$(this))"><?php echo $val->status == 1 ? '　启用':'　禁用';?></a>
										<input type="hidden" name=msgStatus[] value="<?php echo $val->status?>" />
										</span>
										</li>
                            		<?php 
                            		}else{
                            ?>
                                <li><input name="msgId[]" type="hidden" value="<?php echo $val->id?>" />
                                	<span class="dx_bt"><input name="delText" type="checkbox" value="" /></span>
									<span class="tq" id="show_<?php echo $val->id?>"><?php echo Message::showEmotions($val->content)?></span>
									<textarea id="msg_<?php echo $val->id?>" style="display:none" name=msgContent[]><?php echo str_replace("<br>","\n",$val->content);?></textarea>
									<input type="hidden" name=msgType[] value="<?php echo $val->type?>" />
									<span class="txt"><a href="javascript:;" onclick=<?php echo $val->type?>Popups($(this).parents('form').attr('id'),'msg_<?php echo $val->id?>','show_<?php echo $val->id?>')>编辑</a>
										<a href="javascript:;" onclick="changeKeyword('<?php echo $this->createUrl('group/changeMessage_s',array('status'=>$val->status == '1' ? '0':'1','id'=>$val->id))?>',$(this))"><?php echo $val->status == 1 ? '　启用':'　禁用';?></a>
										<input type="hidden" name=msgStatus[] value="<?php echo $val->status?>" />
									</span>
									</li>
							<?php }}?>
                            </ul>
                            </div>
                        </div>
                    </div>
                    <div class="wx_list_txt_right_bt">
                    	<div class="wx_list_txt_right_bt_left"><a href="javascript:;" onclick="delText1($(this).parents('form'))">删除选中</a></div>
                        <div class="wx_list_txt_right_bt_right">
                        	<span><a href="javascript:;" onclick="textPopups($(this).parents('form').attr('id'))">文字</a></span>
                            <span><a href="javascript:;" onclick="newsPopups($(this).parents('form').attr('id'),'<?php echo $this->createUrl ( 'menu_msg/getNewsMsg' )?>')">图文</a></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="wx_list_bt">
            	<div class="wx_list_bt_sc"><a href="javascript:;" onclick="delGroup($(this),'<?php echo $index;?>')">删除</a></div>
            	<div class="wx_list_bt_bc"><a href="javascript:;" onclick="checkAddGroup($(this).parents('form'),'<?php echo $this->createUrl('group/checkGroupName',array('id'=>$data->id));?>','<?php echo $this->createUrl('group/checkGroupKey');?>')">保存</a></div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="wx_list_box_lb" class="wx_list_box" style="display:block;">
        	<div class="wx_list_gjc">
            	<div class="wx_list_gjc_left">关键词：</div>
                <div class="wx_list_gjc_right">
                			<?php 
                            	foreach($data->keywords as $key => $val){
                            ?>
                            		<span><?php echo $val->name?></span>
                            <?php 	
                            	}
                            ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="wx_list_gjc">
            	<div class="wx_list_gjc_left">回复：</div>
                <div class="wx_list_gjc_right"><?php echo count($data->messages)?>条 <?php echo Message::model()->getMsgCount($data->messages);?></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    </form>
     <form id="deleteForm_<?php echo $index;?>" action="<?php echo $this->createUrl('group/delete',array('id'=>$data->id))?>" method="post">
        <input type="hidden" value="<?php echo $_SERVER['REQUEST_URI']?>" name="url"/>
     </form>
</div>
