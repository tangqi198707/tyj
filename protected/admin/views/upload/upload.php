<html>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.1.min.js"></script>
<body style="padding:4px; padding-top:2px; padding-left:0px; margin:0px;">
<form id="upForm" action="<?php echo $this->createUrl('upload/up',array('method'=>'up','id'=>$id,'type'=>$type,'act'=>$action))?>" method="post" enctype="multipart/form-data">
<input name='upfile' id="upfile" type="file" onchange="document.getElementById('upForm').submit();" value=""/>
</form>
<script type="text/javascript">
var rs = "<?php echo $rs;?>";
var msg = '';
var action = "<?php echo $action; ?>";
if(rs != '')
{
	if(rs.length < 3)
	{
		parent.document.getElementById('<?php echo $id?>').value = '';
		if(rs == -1)
			parent.showMsg('请先选择您想要上传的文件');
		else if(rs == -2)
			parent.showMsg('大小超过限定范围');
		else if(rs == -3)
			parent.showMsg('上传文件格式有误');
		else if(rs == -4)
			parent.showMsg('移动文件出错');
	}
	else
	{
		var id = '<?php echo $id?>';
		parent.document.getElementById(id).value = rs;
		//alert(rs);
		if(action == 'append'){
			if(id.indexOf('_') != -1){
				parent.document.getElementById(id).value = '';
				var arr = id.split('_');	//eg:id="gznr_file_url_1"
				var type = arr[0];      //gznr
				var id_num = parseInt(arr[3]); //1
				var div_obj = $('#'+type+'_div_'+id_num+'',window.parent.document);		//eg:id="gznr_div_1"
				var file_name = $('#'+type+'_file_name_'+id_num+'',window.parent.document).val(); //eg:id="gznr_file_name_1"
				$('#'+type+'_file_name_'+id_num+'',window.parent.document).val(''); 
				
				
				id_num = parseInt(Math.random()*1000);
				var url = '/upload/up/id/'+type+'_file_url_'+id_num+'/act/append/type/book';
				var str ='<div id="'+type+'_div_'+id_num+'" class="table_div_one" name="wxsc_qb">'
				str +='<p class="table_p1">';
				str += '<span class="table_span1">'+"图片简介："+'</span>';
				str += '<span align="left">';
				str += '<textarea style="width:251px;height:75px;" name="'+type+'_file_name[]" id="'+type+'_file_name_'+id_num+'" type="text">'+file_name+'</textarea></span></p>';
				str += '<div class="table_sc_div_zt">';
				str += '<span class="table_span1">轮播图片：</span>';
				str += '<div class="table_sc_div">';
				str += '<div class="llwj_text_div_big">';
				str += '<div style="position:absolute;z-index:100;left:0px;top:0px;">';
				str += '<input style="width:200px;" class="textbox" type="text" id="'+type+'_file_url_'+id_num+'" name="'+type+'_file_url[]" readonly="readonly" value="'+rs+'" />';
				str += '</div>'
				str += '<a style="padding-left:210px;margin-top:2px;float:left;display:block;" href="javascript:;" onclick="$(this).parents(\'.table_div_one\').empty();"><img src="/images/sc.png"></a></div></td></tr></table>'
				str += '</div></div></div>'
				div_obj.before(str);
				console.log(str);
			}
			
		}
		
	}
}



</script></body>
</html>
