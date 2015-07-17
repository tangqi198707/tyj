<?php 
Yii::app()->clientScript->registerScript('search', "
$('#newsMsgForm').submit(function(){
	$.fn.yiiListView.update('newsList', {
		data: $(this).serialize(),
	});
	return false;
});
");
?>
<div class="menu_tw_box">
	<div class="menu_tw_list">
    	<div class="menu_tw_title">选择素材<a href="javascript:;" onclick="$.closePopupLayer();">关闭</a></div>
    	<div class="menu_tw_xi_bt">
        	<div class="menu_tw_xi_bt_left">
        		<form id="newsMsgForm" action="<?php echo $this->createUrl('menu_msg/getNewsMsg');?>" method="get">
        		<span>搜索：</span>
        		<span>
        			<input type="text" name="menuMsg[title]" value="<?php echo $search['title']?>" />
        		</span>
        		<span>
        			<select id="category" name="menuMsg[cate_id]">
                        <option value="">选择分类</option>
                        <?php foreach($category as $key => $val){
                        	$sel = $val->id == $search['cate_id'] ? 'selected' : '';
                        	echo '<option value="'.$val->id.'" '.$sel.'>'.$val->name.'</option>';
                        }?>
                    </select>
        		</span>
        		<span class="bt">
        			<a href="javascript:;" onclick="$('#newsMsgForm').submit()">搜索</a>
        		</span>
        		</form>
        	</div>
            <div class="clear"></div>
        </div>
        <div class="menu_tw_list_box">
        	<div class="menu_tw_list_box_meu">
        	 <?php
			$this->widget('zii.widgets.CListView', array(
				'id' => 'newsList',
				'afterAjaxUpdate' => 'createNewsItemEvent',
				'dataProvider'=>$dp,
				'itemView'=>'_newsList',
				'viewData' => array('half'=>$half,'count' => $count),
				'pager' => array(
					'class'=>'LLinkPager',
				), 
				'emptyText' => '没有图文消息',
				'template' => '{items}{pager}',
			));
			?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="menu_tw_list_bt">
        	<span><a href="javascript:;" onclick="chooseNews()">确定</a><a href="javascript:;" onclick="$.closePopupLayer();">取消</a></span><div class="clear"></div></div>
        </div>
    </div>
<script type="text/javascript">
$(function(){
	createNewsItemEvent();
})
function createNewsItemEvent(){
	$('.menu_tw_list_box_one').each(function(){
		$(this).click(function(){
			$('.link_vtd').hide();
			$('.cover1').hide();
			$('.menu_tw_list_box_one').attr('id','');
			$(this).attr('id','chooseNews');
			$(this).find('.cover1').show();
			$(this).find('.link_vtd').show();
		});
		$(this).hover(function(){
				$('.cover').hide();
				$(this).find('.cover').show();
			},
			function(){
				$('.cover').hide();
			});
	});
}
</script>