<?php
$this->pageTitle = '管理员管理 - '.Yii::app()->name;
?>
<div class="ht_center_box">
<script>
function checkComment(){
			ajaxBox('<?php echo $this->createUrl ( 'manager/create' )?>');
}

</script>
 <form id="searchForm" action="<?php echo $this->createUrl('manager/admin');?>" method="GET">
     <div class="content_width">
        	<div class="content_width_title">
            	<ul>
                	<li>
                    	<span>用户名：</span>
                        <span><input name="Manager[name]" type="text" value="<?php echo isset($search['name']) && $search['name']?>" /></span>
                    </li>
                	<li>
                    	<span>邮箱：</span>
                        <span><input name="Manager[email]" type="text" value="<?php echo isset($search['email']) && $search['email']?>" /></span>
                    </li>
                	<li>
                    	<span>联系电话：</span>
                        <span><input name="Manager[tel]" type="text" value="<?php echo isset($search['tel']) && $search['tel']?>" /></span>
                    </li>
                	<li style="float:right;margin:0px;"><a href="javascript:void(0);" onclick="delManager('<?php echo $this->createUrl('manager/delete',$paramArr)?>')">删除</a></li>
                    <li style="float:right;"><a href="javascript:void(0);" onclick="checkComment();">添加</a></li> 
                    <li style="float:right;"><a href="javascript:void(0);" onclick="searchForm();">搜索</a></li> 
                </ul>
            </div>
            </div>
  </form>
<div class="content_width_list">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'ajaxUpdate' => false,
	'id'=>'manager-grid',
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

		'name',

		'email',
		
		'tel',

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
				"onclick" => "ajaxBox(\"'.$this->createUrl('manager/update').'/id/$data->id\")",
			))'
		),
	),
)); ?>
