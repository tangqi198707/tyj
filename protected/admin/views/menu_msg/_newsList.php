<?php echo $index == 0 ? '<div class="menu_tw_list_box_left">' : '';
$contentArr =  json_decode($data->content);
?>
                <div class="menu_tw_list_box_one">
                    <div class="menu_tw_list_box_title" id="newsMsgTitle"><?php echo $data->title?></div>
                    <div class="menu_tw_list_box_time"><?php echo date('Y/m/d',$data->entry_time)?></div>
                    <div class="menu_tw_list_box_pic" id="newsMsgThumb"><img src="<?php echo $data->multiple == 1 ? $contentArr[0]->imgurl : $data->imgurl?>" /></div>
                    <?php if($data->multiple == 1){
                    		foreach($contentArr as $key => $val){
                    			if($key == 0)continue;
                    			$imgArr = explode(".",$val->imgurl );
        						$thumbType = end($imgArr);
                    	?>
	                    <div class="multipleList">
	                    	<div class="multipleNews">
	                    		<span class="title"><?php echo $val->title?></span>
	                    		<span class="thumb"><img src="<?php echo $val->imgurl.'.'.$thumbType?>"></span>
	                    		<div class="clear"></div>
	                    	</div>
	                    </div>
	                <?php }}else{
	                	?>
	                	<div class="menu_tw_list_box_text"><?php echo $data->abstract ? $data->abstract : strip_tags($data->content,"<br><p>")?></div>
	                	<?php 
	                }?>
                    <div class="cover"></div>
                    <div class="cover1"></div>
                    <div class="link_vtd" style=" display:none;"></div>
                    <input type="hidden" id="newsMsgId" value="<?php echo $data->id?>" />
                    <input type="hidden" id="newsMsgLink" value="<?php echo $data->multiple == 1 ? $contentArr[0]->link : $data->link?>" />
                </div>
<?php echo $index == $half - 1 ? '</div><div class="menu_tw_list_box_right">' : '';?>
<?php echo $index == $count - 1 ? '</div><div class="clear"></div>' : '';?>
