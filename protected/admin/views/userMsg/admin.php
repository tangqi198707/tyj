<?php
$this->pageTitle = '消息管理 - '.Yii::app()->name;
?>
<style type="text/css">
.msgContentTd{width:400px}
</style>
     <div class="content_width">
        	<div class="content_width_title">
        		<form id="searchForm" action="<?php echo $this->createUrl('userMsg/admin');?>" method="GET">
	            	<ul>
	                	<li>
	                    	<span>隐藏关键词消息：</span>
	                    	<input type="hidden" name="UserMsg[keyword]" id="keyword" value="<?php echo $search['keyword'];?>" />
	                        <span><input class="checkbox" type="checkbox"  <?php echo !isset($_GET['UserMsg']['keyword']) || $search['keyword'] == 0 ? 'checked' : '';?> onclick="$('#keyword').val($(this).attr('checked') ? 0 : 1);"/></span>
	                        <span>隐藏已回复消息：</span>
	                        <input type="hidden" name="UserMsg[reply]" id="reply" value="<?php echo $search['reply'];?>" />
	                        <span><input class="checkbox" type="checkbox"  <?php echo !isset($_GET['UserMsg']['reply']) || $search['reply'] == 0 ? 'checked' : '';?> onclick="$('#reply').val($(this).attr('checked') ? 0 : 1);"/></span>
	                    
	                    </li>
	                    <li>
	                    	<label>内容：</label>
	                    	<input type="text" name="UserMsg[content]" value="<?php echo $search['content'];?>" />
	                    </li>
	                    <li>
	                    	<label>昵称：</label>
	                    	<input type="text" name="UserMsg[nickname]" value="<?php echo $search['nickname'];?>" />
	                    </li>
	                </ul>
	                <ul>
	                	<li>
		                    <label>发布时间：</label>
							<label>从</label>
							<input name="UserMsg[start]" style="width:110px;" type="text" onclick="WdatePicker()"; value="<?php echo $search['start']?>" readonly/> 
							<label>至</label> 
							<input name="UserMsg[end]" style="width:110px;" type="text" onclick="WdatePicker()"; value="<?php echo $search['end']?>" readonly/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                    </li>
	                    <li><a href="javascript:void(0);" onclick="$('#searchForm').submit()">搜索</a></li>
	                    <li><a href="javascript:void(0);" onclick="window.open('<?php echo $this->createUrl('userMsg/createExcel',$_GET)?>')">导出</a></li>
	                </ul>
                </form>
            </div>
 
  <div class="content_width_list">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'ajaxUpdate' => false,
	'id'=>'default-grid',
	'itemsCssClass' => 'content_width_list',
	'pager' => array(
		'class'=>'LLinkPager',
	),
	'pagerCssClass' => 'pager',   //css 样式名
	'enableSorting' => false,
	'dataProvider'=>$model->search(false),
	'emptyText' => '没有消息',
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'id'=>'sel',
			'selectableRows' => 2,
			'checkBoxHtmlOptions'=>array(
			'name' => 'sel',
			),
		), 
		array(
			'name'	=>'头像',
			'type'=>'raw',
			'value'	=>'$data->user->headimgurl ? CHtml::image($data->user->headimgurl,$data->user->nickname,array("width"=>60,"style"=>"margin:5px")) : ""',
		),
		array(
			'cssClassExpression'=>'nickname',
			'name'	=>'昵称',
			'type'=>'raw',
			'value'	=>'$data->user->nickname',
		),
		array(
			'cssClassExpression'=>'msgContentTd',
			'name' =>'内容',
			'type' => 'raw',
			'value'=>'$data->type == image ? CHtml::link(substr_replace($data->content,"",0,strrpos($data->content,"/")+1),"$data->content",array(
				"target" => "_blank"
			)) : Message::model()->showEmotions($data->content)',
		),
		array(
			'name'	=>'回复状态',
			'value'	=>'$data->reply == 1 ? "已回复" : "未回复"',
		),
		array(
			'name'	=>'收藏状态',
			'value'	=>'$data->star == 1 ? "已收藏" : "未收藏"',
		),

		array(

			'name'	=>'消息时间',
			'value'	=>'date("Y-m-d H:i",$data->entry_time)',

		),
		array(
			'name' => '收藏',
			'type' => 'raw',
			'value' => '$data->star == 1 ? CHtml::link("已收藏","javascript:void(0)",array(
				"onclick" => "changeStar(\"'.$this->createUrl('userMsg/changeStar',array('star'=>0)).'/id/$data->id\",$(this))",
			)) : CHtml::link("未收藏", "javascript:void(0)",array(
				"onclick" => "changeStar(\"'.$this->createUrl('userMsg/changeStar',array('star'=>1)).'/id/$data->id\",$(this))",
			))',
		),
		array(
			'name' => '回复',
			'type'=>'raw',
			'value'=>'CHtml::link("回复", "javascript:void(0)",array(
				"onclick" => "ajaxBox(\"'.$this->createUrl('userMsg/reply').'/id/$data->id/uid/$data->uid\")",
			))'
		),
	),
)); ?>