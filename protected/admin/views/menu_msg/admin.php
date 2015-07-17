<?php
$this->pageTitle = '素材管理 - '.Yii::app()->name;
?>

     <div class="content_width">
        	<div class="content_width_title">
            	<ul>
                	<li>
                	<form id="searchForm" action="<?php echo $this->createUrl('menu_msg/admin');?>" method="GET">
                    	<span>标题：</span>
                        <span><input name="menuMsg[title]" type="text" value="<?php echo $search['title']?>" /></span>
                        <span>分类：</span>
                        <span>
                        	<select id="category" name="menuMsg[cate_id]">
                        		<option value="">选择分类</option>
                        		<?php foreach($category as $key => $val){
                        			$sel = $val->id == $search['cate_id'] ? 'selected' : '';
                        			echo '<option value="'.$val->id.'" '.$sel.'>'.$val->name.'</option>';
                        		}?>
                        	</select>
                        </span>
                         </form>
                    </li>
                    <li><a href="javascript:void(0);" onclick="$('#searchForm').submit()">搜索</a></li> 
                    <li><a href="javascript:void(0);" onclick="ajaxBox('<?php echo $this->createUrl ( 'menu_msg/create' )?>');">单图文</a></li> 
                    <li><a href="javascript:void(0);" onclick="ajaxBox('<?php echo $this->createUrl ( 'menu_msg/createMultiple' )?>');">多图文</a></li>
                	<li>
                	<form id="delForm" action="<?php echo $this->createUrl('menu_msg/delete');?>" method="post">
                		<input type="hidden" id="str" name="str"/>
                		<input type="hidden" value="<?php echo $_SERVER['REQUEST_URI']?>" name="url"/>
                		<a href="javascript:void(0);" onclick="delNewsMsg('<?php echo $this->createUrl('menu_msg/checkDel')?>')">删除</a>
                	</form>
                	</li>
                </ul>
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
	'dataProvider'=>$dp,
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

		'title',
		array(
			'name' =>'分类',
			'value'=>'$data->cate->name',
		),
		array(
			'name' =>'类型',
			'value'=>'$data->multiple == 1 ? "多图文" : "单图文"',
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
		'value'=>'$data->multiple == 1? CHtml::link("修改", "javascript:void(0)",array(
				"onclick" => "ajaxBox(\"'.$this->createUrl('menu_msg/updateMultiple').'/id/$data->id\")",
			)) : CHtml::link("修改", "javascript:void(0)",array(
				"onclick" => "ajaxBox(\"'.$this->createUrl('menu_msg/update').'/id/$data->id\")",
			))'
		),
	),
)); ?>