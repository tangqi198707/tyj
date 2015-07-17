<?php
$this->pageTitle = '消息管理 - '.Yii::app()->name;
?>
<style type="text/css">
.msgContentTd{width:400px}
</style>
     <div class="content_width">
        	<div class="content_width_title">
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
	'dataProvider'=>$model->search(true),
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