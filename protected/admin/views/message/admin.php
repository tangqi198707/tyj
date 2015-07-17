<?php
$this->pageTitle = '默认回复管理 - '.Yii::app()->name;
?>

<div class="content_width">
    <div class="content_width_title">
        <ul>
            <li>
                <form id="searchForm" action="<?php echo $this->createUrl('message/admin');?>" method="GET">
                    <span>默认回复：</span>
                    <span><input name="message[content]" type="text" value="<?php echo $search['content']?>" /></span>
                </form>
            </li>
            <li><a href="javascript:void(0);" onclick="$('#searchForm').submit()">搜索</a></li> 
            <li><a href="javascript:void(0);" onclick="ajaxBox('<?php echo $this->createUrl ( 'message/create' )?>');">添加</a></li> 
            <li>
                <form id="delForm" action="<?php echo $this->createUrl('message/delete');?>" method="post">
                    <input type="hidden" id="str" name="str"/>
                    <input type="hidden" value="<?php echo $_SERVER['REQUEST_URI']?>" name="url"/>
                    <a href="javascript:void(0);" onclick="delMsg()">删除</a>
                </form>
            </li>
        </ul>
    </div>
<div class="content_width_list">
<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
	'ajaxUpdate' => false,
	'id'=>'default-grid',
	'itemsCssClass' => 'content_width_list',
	'pager' => array(
		'class'=>'LLinkPager',
	),
	'pagerCssClass' => 'pager',   //css 样式名
	'enableSorting' => false,
	'dataProvider'=>$model->search('default'),
	'emptyText' => '没有默认回复',
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
			'cssClassExpression'=>'msgContentTd',
			'name'	=>'内容',
			'type'=>'raw',
			'value'	=>'Message::model()->showEmotions($data->content)',
		),
		array(
			'name' =>'添加人',
			'value'=>'Manager::getManagerName($data->entry_id)',
		),

		array(
			'name'	=>'添加时间',
			'value'	=>'date("Y-m-d",$data->entry_time)',
		),

		array(
			'name'	=>'修改人',
			'value'	=>'$data->update_id == "" ? "无修改" : Manager::getManagerName($data->update_id)',
		),

		array(

			'name'	=>'修改时间',
			'value'	=>'$data->update_time == "" ? "无修改" : date("Y-m-d",$data->update_time)',

		),
		
		array(
		'name' => '修改',
		'type'=>'raw',
		'value'=>'CHtml::link("修改", "javascript:void(0)",array(
				"onclick" => "ajaxBox(\"'.$this->createUrl('message/update').'/id/$data->id\")",
			))'
		),
		
		array(
		'name' => '状态',
		'type' => 'raw',
		'value' => '$data->status == 1 ? CHtml::link("有效","javascript:void(0)",array(
						"onclick" => "changeDefaultStatus(\"'.$this->createUrl('message/changeStatus',array('status'=>0)).'/id/$data->id\",$(this))",
					)) : CHtml::link("无效", "javascript:void(0)",array(
						"onclick" => "changeDefaultStatus(\"'.$this->createUrl('message/changeStatus',array('status'=>1)).'/id/$data->id\",$(this))",
					))',
		),
	),
)); 
?>