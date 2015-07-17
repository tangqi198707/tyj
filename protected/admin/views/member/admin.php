<?php
$this->pageTitle = '会员管理 - '.Yii::app()->name;
?>
<div class="ht_center_box">
 <form id="searchForm" action="<?php echo $this->createUrl('member/admin');?>" method="GET">
     <div class="content_width">
        	<div class="content_width_title">
            	<ul>
                	<li>
                    	<span>帐号：</span>
                        <span><input name="Member[name]" type="text" value="<?php echo isset($search['name'])?$search['name']:''?>" /></span>
                    </li>
                	<li>
                    	<span>电话：</span>
                        <span><input name="Member[tel]" type="text" value="<?php echo isset($search['tel'])?$search['tel']:''?>" /></span>
                    </li>
                	<li style="float:right;margin:0px;"><a href="javascript:void(0);" onclick="delMember('<?php echo $this->createUrl('member/delete',$paramArr)?>')">删除</a></li>
                    <li style="float:right;"><a href="javascript:void(0);" onclick="searchForm();">搜索</a></li> 
                </ul>
            </div>
            </div>
  </form>
<div class="content_width_list">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'ajaxUpdate' => false,
	'id'=>'Member-grid',
	'itemsCssClass' => 'content_width_list',
	'pager' => array(
		'class'=>'LLinkPager',
	),
	'pagerCssClass' => 'pager',   //css 样式名
	'enableSorting' => false,
	'dataProvider'=>$model->search(),
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
			'name'	=>'用户名',
			'value'	=>'$data->name',
		),
		array(
			'name'	=>'性别',
			'value'	=>'$data->sex==0 ? "女" : "男" ',
		),
		array(
			'name'	=>'电话',
			'value'	=>'$data->tel',
		),
		array(
			'name'	=>'邮箱',
			'value'	=>'$data->email',
		),
		array(
			'name'	=>'地址',
			'value'	=>'$data->address',
		),
		array(
			'name'	=>'注册时间',
			'value'	=>'date("Y-m-d",$data->entry_time)',
		),
		array(
			'name'	=>'修改人',
			'value'	=>'$data->update_id == 0 ? "无修改" : Manager::model()->getManagerName($data->update_id)',
		),
		array(
			'name'	=>'修改时间',
			'value'	=>'$data->update_time == 0 ? "无修改" : date("y-m-d",$data->update_time)',
		),
		array(
		'name' => '修改',
		'type'=>'raw',
		'value'=>'CHtml::link("修改", "javascript:void(0)",array(
				"onclick" => "ajaxBox(\"'.$this->createUrl('Member/update').'/id/$data->id\")",
			))'
		),
	),
)); ?>
