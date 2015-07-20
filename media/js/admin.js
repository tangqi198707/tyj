//ajax窗口
function ajaxBox(url,params,after,noJquery){
	$.openPopupLayer({
		name: "ajaxBox",
		url: url,
		parameters : params,
		afterClose: after,
		noJquery : noJquery
	});
}
//提交搜索
function searchForm()
{
	$('#searchForm').submit();
}
var form = null;
var commonKwId = null;
var commonMsgId = null;
//================================ 登陆验证 ================================
//验证管理员登录
function checkDenglu(url) {
	var name = $('#name');
	var pwd = $('#pwd');
	var yzm = $('#yzm');
	if ($.trim(name.val()) == '') {
		alert('请输入用户名!');
		name.select();
		return false;
	} else if ($.trim(pwd.val()) == '') {
		alert('请输入密码!');
		pwd.select();
		return false;
	}else if($.trim(yzm.val()) == ''){
		alert('填写验证码');
		yzm.select();		
	}else if($.trim(yzm.val()) != ''){
		$.get(url,{yzm:yzm.val(),rand:Math.random()},function(data){
			if(data){
				alert(data);
				yzm.select();
			}else{
				$("#dl").submit();
			}
		});
	}
}

// ================================   唯一性          ================================
//用户唯一性
function checkManagerName(checkurl) {
	var name = $("#name");
	$.get(checkurl, {
		name : name.val()
	}, function(data) {
		if (data) {
			$('#suggestion').html("用户名已存在!");
		} else {
			$('#suggestion').html("");
		}
	})
}
// 邮箱唯一性验证
function checkManagerEmail(checkur2) {
	var email = $("#email");
	$.get(checkur2, {
		email : email.val()
	}, function(data) {
		if (data) {
			$('#suggestion1').html("邮箱已存在!");
		} else {
			$('#suggestion1').html("");
		}
	})
}

// ================================ 修改发表状态 ================================

function changeStatus(url, event){
	var adminObj = event.parent().prev().prev();
	var timeObj = event.parent().prev();
	if (confirm('确定要改变(' + event.parent().parent().find('td').next().html()
			+ ')的发布状态吗？')) {
		$.get(url, {
			rand : Math.random()
		}, function(data) {
			if (event.html() == '未发布'){
				event.html('发布');
				event.attr('onclick',event.attr('onclick').toString().replace('status/1', 'status/0'));
			}else{
				event.html('未发布');
				event.attr('onclick',event.attr('onclick').toString().replace('status/0', 'status/1'));
			}
		});
	}
}


function changeAdmin(url, event) {
	if (confirm('确定要改变(' + event.parent().parent().find('td').next().html()
			+ ')的发布状态吗？')) {
		$.get(url, {
			rand : Math.random()
		}, function(data) {
			var arr = data.split("*");
			if (event.html() == '注册'){
					event.html('禁止');
					event.parent().prev().prev().prev().html(arr['1']);
					event.parent().prev().prev().html(arr['2']);
				}
			else{
					event.html('注册');
					event.parent().prev().prev().prev().html(arr['1']);
					event.parent().prev().prev().html(arr['2']);
				}
			if (event.attr('onclick').toString().indexOf('status/0') != -1)
				event.parent().html(
						event.parent().html().replace('status/0', 'status/1'));
			else
				event.parent().html(
						event.parent().html().replace('status/1', 'status/0'));
		});
	}
}




//弹出消息
function showMsg(str) {
	alert(str);
}

//=================================管理员管理==============================
//验证添加管理员
function AddManager(checkurl,checkur2)
{
	var name	= $("#name");
	var pwd		= $("#pwd");
	var Con_pwd	= $("#Con_pwd");
	var email	= $("#email");
	var roleid	= $("#roleid");
	var rule_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	
	if(!$.trim(name.val())){
		alert('请填写账户名称!');
		name.select();
	}else if(pwd.val().length<6){
		alert('密码不能小于6位!');
		pwd.select();
	}else if($.trim(pwd.val()) != $.trim(Con_pwd.val())){
		alert('两次密码不一致!');
		Con_pwd.select();
	}else if(!$.trim(email.val())){
		alert('请填写邮箱!');
		email.select();
	}else if(email.val() && !rule_email.test($.trim(email.val()))){
		alert('邮箱格式不正确!');
		email.select();
	}else if($('#privileges:checked').length<=0){
		alert('请选择权限');
		return false;
	}else if (name.val()) {
		$.get(checkurl, {
			name : name.val()
		}, function(data) {
			if (data) {
				alert('用户名已存在!');
				name.select();
			}else{
				if (email.val()) {
					$.get(checkur2, {
						email : email.val()
					}, function(data) {
						if (data) {
							alert('邮箱已存在!');
							email.select();
						}else{
							$('#myform').submit();
						}
					})
				}
			}
		})
	}
}

function AddWxCategory(checkurl)
{
	var name	= $("#name");
	if(!$.trim(name.val())){
		alert('请填写分类名称');
		name.select();
	}else if (name.val()) {
		$.get(checkurl, {
			name : $.trim(name.val())
		}, function(data) {
			if (data) {
				alert('分类已存在');
				name.select();
			}else{
				$('#myform').submit();
			}
		})
	}
}


//验证修改管理员
function UpdateManager(checkurl)
{
	var name	= $("#name");
	var email	= $("#email");
	var roleid	= $("#roleid");
	var rule_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	
	if(!$.trim(name.val())){
		alert('请填写账户名称!');
		name.select();
	}else if(!$.trim(email.val())){
		alert('请填写邮箱!');
		email.select();
	}else if(email.val() && !rule_email.test($.trim(email.val()))){
		alert('邮箱格式不正确!');
		email.select();
	}else if(email.val()) {
		$.get(checkurl, {
			email : email.val()
		}, function(data) {
			if (data) {
				alert('邮箱已存在!');
				email.select();
			}else{
				$('#myform').submit();
			}
		})
	}
}

//删除管理员
function delManager(url) {
	var checked_num = $("input[name='sel']:checked").length;
	if (checked_num == 0) {
		alert('请先选定要删除的管理员!');
		return false;
	} else {
		if (!confirm('确定删除选定管理员?'))
			return false;
		else {
			var str = '';
			$("input[name='sel']:checked").each(function() {
				str += $(this).val() + ',';
			});
			str = str.substring(0, str.length - 1);
			location.href = url + "/str/" + str;
		}
	}
}

function deleteItem(checkUrl) {
	var checked_num = $("input[name='sel']:checked").length;
	if (checked_num == 0) {
		alert('请先选定要删除的选项');
		return false;
	} else {
		if (!confirm('确定删除？'))
			return false;
		else {
			var str = '';
			$("input[name='sel']:checked").each(function() {
				str += $(this).val() + ',';
			});
			str = str.substring(0, str.length - 1);
			if(checkUrl){
				$.get(checkUrl,{str:str,rand:Math.random()},function(data){
					if(data == 0){
						$('#str').val(str);
						$('#delForm').submit();
					}else{
						alert(data);
					}
				})
			}else{
				$('#str').val(str);
				$('#delForm').submit();
			}
		}
	}
}


/* 微信 **********************************************************************/
//验证添加回复
function AddNews(title,imgurl,thumb,content,link,type,menu,category,city){
	var titleVal = $.trim(title.val());
	var imgurlVal = $.trim(imgurl.val());
	var thumbVal = $.trim(thumb.val());
	var contentVal = $.trim(UE.getEditor('content').getContent());
	var linkVal = $.trim(link.val());
	var abst = $('#abstract');
	var abstVal = $.trim(abst.val());
	var contentValBrTag = contentVal.replace(/\n/ig,'<br>');
	if(titleVal == '' || titleVal.length > 64){
		alert('标题不能为空且最多64字');
		title.select();
	}else if(abstVal.length > 120){
		alert('摘要最多120字');
		abst.select();
	}else if(contentVal == '' || contentVal.length > 20000){
		alert('正文不能为空且最多20000字');
		content.select();
	}else if(imgurlVal == ''){
		alert('必须上传封面');
	}else{
		if(menu){
			if(city.val() == ''){
				alert('请选择城市');
				city.focus();
				return false;
			}else if(category.val() == ''){
				alert('请选择分类');
				category.focus();
				return false;
			}else{
				$('#menuMsgNewsForm').submit();return false;
			}
		}
	}
}

function ajaxFileUpload(id,succ,index)
{
	var imgBox = $('.popup-body').find('#upImgBox');
	$.ajaxFileUpload
	(
		{
			url:upUrl,
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			data:{name:'logan', id:'id'},
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					if(data.error != '')
					{
						$('#'+id).val('');
						alert(data.error);
					}else
					{
						eval( succ + '("'+data.msg+'","'+index+'");');
					}
				}
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
	
	return false;

}


function upCoverSucc(src){
	var thumb = '';
	if(src.indexOf('@!@') != -1){
		var arr = src.split('@!@');
		src = arr[0];
		thumb = arr[1];
	}
	$('.popup-body').find('.twx_list_box_left_pic').html('<img id="cover" src="'+src+'" />');
	if(thumb){
		var img = '<img src="'+thumb+'" /><a href="javascript:;" onclick="delUpImg()">删除</a>';
		$('.popup-body').find('#upImgBox').html(img);
	}
	$('.popup-body').find('#imgurl').val(src);
	$('.popup-body').find('#thumb').val(thumb);
}

//删除上传的图片
function delUpImg(index){
	var cover = $('.popup-body').find('.twx_list_box_left_pic');
	var upBox = $('.popup-body').find('#upImgBox');
	var imgurl = $('#imgurl');
	if(index || index==0){
		cover = $('#list_'+index).find('#cover');
		upBox = $('#detail_'+index).find('#upImgBox');
		imgurl = $('#imgurl_'+index);
	}
	cover.html('封面图片');
	upBox.html('');
	imgurl.val('');
}

function addMultipleNews(){
	var city = $('#addCity');
	var category = $('#addCategory');
	if(city.val() == ''){
		alert('请选择城市');
		city.focus();
		return false;
	}else if(category.val() == ''){
		alert('请选择分类');
		category.focus();
		return false;
	}else{
		var error = -1;
		$('input[name="title[]"]').each(function(){
			var titleVal = $.trim($(this).val());
			if(titleVal == '' || titleVal.length > 64){
				alert('标题不能为空且最多64字');
				var index = getDetailIndex($(this));
				error = index;
				return false;
			}
		});
		if(error != -1){
			changeDetailMarginTop(error);
			return false;
		}
		$('textarea[name="content[]"]').each(function(){
			var contentVal = $.trim($(this).val());
			if(contentVal == '' || contentVal.length > 20000){
				alert('正文不能为空且最多20000字');
				var index = getDetailIndex($(this));
				error = index;
				return false;
			}
		});
		if(error != -1){
			changeDetailMarginTop(error);
			return false;
		}
		$('input[name="imgurl[]"]').each(function(){
			var imgurlVal = $.trim($(this).val());
			if(imgurlVal == ''){
				alert('必须上传封面');
				var index = getDetailIndex($(this));
				error = index;
				return false;
			}
		});
		if(error != -1){
			changeDetailMarginTop(error);
			return false;
		}
		$('#menuMsgNewsForm').submit();
	}
}
function delMultipleNews(obj){
	var index = getListIndexNum(obj);
	var len = getMultipleNewsLen();
	if(len > 2){
		var prev = obj.prev();
		changeDetailMarginTop(getListIndexNum(prev));
		$('#list_'+index).remove();
		$('#detail_'+index).remove();
	}else{
		alert('无法删除，多条图文至少要有2条消息');
	}
}

function getMultipleNewsLen(){
	return $("div[name='multipleNewsList']").length;
}
function getDetailIndex(obj){
	var arr = obj.parents('.twx_list_box_txt_box').attr('id').split('_');
	return arr[1];
}
function getListIndex(obj){
	return $('.popup-body').find('div[name="multipleNewsList"]').index(obj);
}
function getListIndexNum(obj){
	var arr = obj.attr('id').split('_');
	return parseInt(arr[1]);
}
function changeDetailMarginTop(index){
	var currDetail = $('#detail_'+index);
	currDetail.siblings().hide();
	currDetail.show();
	var height0 = parseInt($('#list_0').css('height')) + 20;
	var mt = 0;
	var i = getListIndex($('#list_'+index));
	if(i == 0){
		mt = 0;
	}else if(i == 1){
		mt = height0;
	}else{
		mt = (i - 1) * 100 + height0;
	}
	currDetail.parent().css('marginTop',mt+'px');
	changePopHeight();
}
function changePopHeight(){
	$('#popupLayerScreenLocker').css('height',$(document).height());
}

function upMultipleCoverSucc(src,index){
	var thumb = '';
	if(src.indexOf('@!@') != -1){
		var arr = src.split('@!@');
		src = arr[0];
		thumb = arr[1];
	}
	$('#list_'+index).find('#cover').html('<img id="cover" src="'+src+'" />');
	if(thumb){
		var img = '<img src="'+thumb+'" /><a href="javascript:;" onclick=\'delUpImg("'+index+'")\'>删除</a>';
		$('#detail_'+index).find('#upImgBox').html(img);
	}
	$('#imgurl_'+index).val(src);
	$('#thumb_'+index).val(thumb);
}

function addNewsList(){
	var last = $('.popup-body').find('div[name="multipleNewsList"]:last');
	var lastIndex = getListIndexNum(last);
	var len = getMultipleNewsLen();
	if(len < 10){
		var list = getNewsListHtml(lastIndex+1);
		last.after(list);
		var detail = getNewsDetailHtml(lastIndex+1);
		$('#detail_'+lastIndex).after(detail);
		createEditor();
		changePopHeight();
	}else{
		alert('最多只可以加入10条图文信息');
	}
}
function getNewsListHtml(index){
	var html = '<div class="multipleNewsList" name="multipleNewsList" id="list_'+index+'">';
		html += '<span id="showTitle" class="multipleNewsListTitle">标题</span>';
		html += '<span class="multipleNewsListThumb" id="cover">封面图片</span>';
		html += '<div class="clear"></div>';
		html += '<div class="multipleNewsListCover">';
		html += "<a class=multipleNewsListEdit href=javascript:; onclick=editNewsDetail($(this).parents('.multipleNewsList'))>编辑</a>";
		html += '<a href="javascript:;" onclick=\'delMultipleNews($(this).parents(".multipleNewsList"))\'>删除</a>';
		html += '</div>';
		html += '</div>';
	return html;
}
function getNewsDetailHtml(index){
	var html = '<div class="twx_list_box_txt_box" id="detail_'+index+'" style="display:none" name="multipleNewsDetail">';
		html += '<div class="twx_list_box_right_title">';
		html += '<p>标题</p>';
		html += '<p>';
		html += '<input name="title[]" type="text" maxLength="64"/>';
		html += '</p>';
		html += '</div>';
		html += '<div class="twx_list_box_right_title">';
		html += '<p>作者</p>';
		html += '<p>';
		html += '<input name="author[]" type="text" maxLength="64"/>';
		html += '</p>';
		html += '</div>';
		html += '<div class="twx_list_box_right_title">';
		html += '<p>封面<span>小图片建议尺寸：200像素 * 200像素</span></p>';
		html += '<p>';
		html += '<div class="uploadDiv">';
		html += '<a href="javascript:;"><img src="/media/images/uploadWord.jpg" /></a>';
		html += '<div id="updiv" style="">';
		html += '<input id="fileToUpload_'+index+'" class="fileToUpload" type="file" name="fileToUpload" onchange=\'return ajaxFileUpload("fileToUpload_'+index+'","upMultipleCoverSucc",'+index+');\'>';
		html += '<input type="hidden" id="imgurl_'+index+'" name="imgurl[]">';
		html += '<input name="thumb[]" id="thumb_'+index+'" type="hidden">';
		html += '</div>';
		html += '</div>';
		html += '<div id="upImgBox" class="upImgBox">';
		html += '</div>';
		html += '</p>';
		html += '</div>';
		html += '<div class="twx_list_box_right_title" style="margin-top:5px">';
		html += '<span>';
		html += '<input id="show_cover_'+index+'" name="show_cover_chk" class="checkbox" type="checkbox" maxLength="64" checked/>';
		html += '<input type="hidden" id="show_cover_'+index+'_val" name="show_cover[]" value="1" />';
		html += '</span>';
		html += '<span>封面图片显示在正文中';
		html += '</span>';
		html += '</div>';
		html += '<div class="twx_list_box_right_title">';
		html += '<p>正文</p>';
		html += '<p><textarea id="content_'+index+'" name="content[]" cols="" rows=""></textarea></p>';
		html += '</div>';
		html += '<div class="twx_list_box_right_title">';
		html += '<p>添加原文链接<span>必须以“http://”等开头</span></p>';
		html += '<p><input name="link[]" type="text" value=""/></p>';
		html += '</div>';
		html += '</div>';
	return html;
}

function editNewsDetail(obj){
	var index = getListIndexNum(obj);
	changeDetailMarginTop(index);
}

function delNewsMsg(url) {
	var checked_num = $("input[name='sel']:checked").length;
	if (checked_num == 0) {
		alert('请先选定要删除的回复!');
		return false;
	} else {
		if (!confirm('确定删除选定回复?'))
			return false;
		else {
			var str = '';
			$("input[name='sel']:checked").each(function() {
				str += $(this).val() + ',';
			});
			str = str.substring(0, str.length - 1);
			$.get(url,{str:str,rand:Math.random()},function(data){
				if(data == 0){
					$('#str').val(str);
					$('#delForm').submit();
				}else{
					alert('消息正在被菜单使用不能删除');
				}
			})
			
		}
	}
}

//DIV弹窗
function menuPopups(child,url,pid){
	$.get(url,{rand:Math.random()},function(data){
		if(data == 's'){
			var json = getMenuMsg('menu_'+pid);
			if(json && $('dd[name="childDd_'+pid+'"]').length == 0){
				if(!confirm('使用二级菜单后,当前编辑的消息不会被保存。确定使用二级菜单?')){
					return false;
				}
			}
			$.openPopupLayer({
				name: "popups",
				target: 'addMenu',
				success: function(){
					var prompt = pid == 0 ? '菜单名称名字不多于4个汉字或8个字母:' : '菜单名称名字不多于8个汉字或16个字母:';
					var limit = pid == 0 ? 8 : 16;
					$('.popup-body').find('#menuPrompt').html(prompt);
					$('.popup-body').find('#child').val(child);
					$('.popup-body').find('#pid').val(pid);
					$('.popup-body').find('#menuLimit').val(limit);
				}
			});
		}else{
			if(child == 0){
				alert('一级菜单最多只能三个');
			}else if(child == 1){
				alert('二级菜单最多只能5个');
			}
		}
	});
}

function getMenuMsg(mid){
	//alert(menuJson);return false;
	var obj = eval('(' + menuJson + ')');   
	return eval('obj.' + mid);
}

function addMenu(obj,url,child,pid){
	var reg = /[\u4e00-\u9faf]+/g;
	var menuVal = $.trim(obj.val());
	if(menuVal == ''){
		alert('请填写菜单名称');
		obj.select();
	}else{
		var len = menuVal.length;
		var chineseCount = 0;
		var chinese = menuVal.match(reg);
		if(chinese){
			chineseCount = chinese.toString().replace(/,/g,'').length;
		}
		var finaLen = (len - chineseCount) + (chineseCount * 2);
		var limit = $('.popup-body').find('#menuLimit').val();
		if(finaLen > limit){
			alert($('.popup-body').find('#menuPrompt').html());
			obj.select();
		}else{
			$('.popup-body').find('#submitBtn').hide();
			$('.popup-body').find('#submitBtn2').show();
			var order = 0;
			var noObjs = $('[no]');
			if(noObjs.length != 0){
				order = parseInt(noObjs.last().attr('no'))+1;
			}
			$.post(url,{name:menuVal,pid:pid,order:order,rand:Math.random()},function(data){
				if(data != 0){
					if(child == 0){
						var str = '<div name="parent_0" pno="100"><dt id="menu_'+data+'" no="100" parent="1"><span class="txt" id="menuTxt_'+data+'" onclick="editBegin(\'menu_'+data+'\')">'+menuVal+'</span><span name="operation" onclick="delMenu('+data+',\'/hk_manage.php/menu/delete/id/'+data+'\')">删除</span><span name="operation" onclick="updateMenuPopups('+data+','+pid+')">编辑</span><span name="operation" onclick="menuPopups(1,\'/hk_manage.php/menu/checkAdd/type/child/pid/'+data+'\','+data+')">添加</span><div class="orderSpan" id="order_'+data+'"></div><div class="clear"></div></dt></div>';
						$('#menuDl').append(str);
					}else if(child == 1){
						var str = '<dd id="menu_'+data+'" name="childDd_'+pid+'" no="100"><span class="txt" id="menuTxt_'+data+'" onclick="editBegin(\'menu_'+data+'\')">'+menuVal+'</span><span name="operation" onclick="delMenu('+data+',\'/hk_manage.php/menu/delete/id/'+data+'\')">删除</span><span name="operation" onclick="updateMenuPopups('+data+','+pid+')">编辑</span><div class="orderSpan" id="order_'+data+'"></div><div class="clear"></div></dd>';
						var p = $('#menu_'+pid);
						var lastDd = $('dd[name="childDd_'+pid+'"]');
						if(lastDd.length){
							lastDd.last().after(str);
						}else{
							p.after(str);
						}
					}
					resetNo();
				}else{
					alert('添加失败请重试');
				}
				$.closePopupLayer();
			});
		}
	}
}

//DIV弹窗
function updateMenuPopups(id,pid){
	$.openPopupLayer({
		name: "popups",
		target: 'updateMenu',
		success: function(){
			var prompt = pid == 0 ? '菜单名称名字不多于4个汉字或8个字母:' : '菜单名称名字不多于8个汉字或16个字母:';
			var limit = pid == 0 ? 8 : 16;
			$('.popup-body').find('#menuPrompt').html(prompt);
			$('.popup-body').find('#menuLimit').val(limit);
			$('.popup-body').find('#menuId').val(id);
			$('.popup-body').find('#menu').val($('#menu_'+id).find('.txt').html());
		}
	});
}

function delMenu(id,url){
	if(confirm('删除后该菜单下设置的消息将不会被保存')){
		$.get(url,{rand:Math.random()},function(data){
			if(data == 's'){
				$('#updateLinkMsgBtn').hide();
				$('#menuMsgPrompt').html('你可以先添加一个菜单，然后开始为其设置响应动作');
				changeMsgDiv('menuMsgPrompt');
				$('#menu_'+id).remove();
				$('dd[name="childDd_'+id+'"]').remove();
			}else{
				alert('删除失败请重试');
			}
			$.closePopupLayer();
		});
	}
}

function updateMenu(obj,url,id){
	var reg = /[\u4e00-\u9faf]+/g;
	var menuVal = $.trim(obj.val());
	if(menuVal == ''){
		alert('请填写菜单名称');
		obj.select();
	}else{
		var len = menuVal.length;
		var chineseCount = 0;
		var chinese = menuVal.match(reg);
		if(chinese){
			chineseCount = chinese.toString().replace(/,/g,'').length;
		}
		var finaLen = (len - chineseCount) + (chineseCount * 2);
		var limit = $('.popup-body').find('#menuLimit').val();
		if(finaLen > limit){
			alert($('.popup-body').find('#menuPrompt').html());
			obj.select();
		}else{
			$('.popup-body').find('#updateMenuBtn').hide();
			$('.popup-body').find('#updateMenuBtn2').show();
			$.post(url,{name:menuVal,id:id,rand:Math.random()},function(data){
				if(data == 's'){
					$('#menu_'+id).find('.txt').html(menuVal);
				}else{
					alert('修改失败请重试');
				}
				$.closePopupLayer();
			});
		}
	}
	
}

function changeMsgDiv(id){
	$('div[name="msgDiv"]').hide();
	$('#'+id).show();
}

function editBegin(id){
	var arr = id.split('_');
	var mid = arr[1];
	var children = $('dd[name="childDd_'+mid+'"]');
	$('[no]').removeClass('selMenu');
	$('#menu_'+mid).addClass('selMenu');
	$('#updateLinkMsgBtn').hide();
	$('#linkMsg').val('');
	$('#updateLinkMsg').val('');
	if(children.length > 0){
		$('#menuMsgPrompt').html('已有子菜单，无法设置动作');
		changeMsgDiv('menuMsgPrompt');
	}else{
		var json = getMenuMsg('menu_'+mid);
		if(json){
			$('#updateLinkMsgBtn').show();
			if(json.type == 'view'){
				$('#showLinkMsg').html(json.content);
				changeMsgDiv('showLinkMsgDiv');
			}else if(json.type == 'text'){
				$('#showMsg').html(json.content);
				changeMsgDiv('showMenuMsg');
			}else if(json.type == 'news'){
				updateCopyData(json);
				$('#showMsg').html($('#copyNewsDiv').html());
				changeMsgDiv('showMenuMsg');
			}
		}else{
			changeMsgDiv('menuMsgType');
		}
	}
	$('.menu_list_left').css('height',$('.menu_list').css('height'));
}

function createMsgBegin(){
	$('#showMsg').html('');
	$('.msgBtn').hide();
	$('#editDiv').html('');
	$('#newsDiv div').removeClass('menu_tw_list_box_one_bak').html('');
	$('#createMsgBtn').show();
	$('.menu_list_right_text').hide();
	$('#textDiv').show();
	$('.menu_list_right_title a').removeClass('menu_vtd');
	$('#textTag').addClass('menu_vtd');
	changeMsgDiv('createMsgDiv');
}


function addMenuMsg(name,type,show,url){
	var midArr = $('.selMenu').attr('id').split('_');
	var mid = midArr[1];
	if(type == 'text'){
		setContent($('#message'));//return false;
		var nameVal = $.trim(name.val());
		if(nameVal == ''){
			alert('回复文字不能为空');
			name.select();
		}else if(nameVal.length > 600){
			alert('回复文字最多600字');
			name.select();
		}else{
			$('#createMsgBtn').hide();
			$('#createMsgBtn2').show();
			$.post(url,{content:nameVal,type:type,mid:mid,rand:Math.random()},function(data){
				if(data != '0'){
					$('#showMsg').html(show.html());
					changeMsgDiv('showMenuMsg');
					$('#updateLinkMsgBtn').show();
					$.get(getMenuJsonUrl,{rand:Math.random()},function(d){
						menuJson = d;
						alert('添加成功');
						$('#createMsgBtn2').hide();
						$('#createMsgBtn').show();
					})
				}else{
					alert('修改失败请重试');
					$('#createMsgBtn2').hide();
					$('#createMsgBtn').show();
				}
			});
		}
	}else{
		$('#createMsgBtn').hide();
		$('#createMsgBtn2').show();
		var msg_id = $('#newsDiv .menu_tw_list_box_one_bak').find('input').val();
		$.post(url,{type:type,mid:mid,msgId:msg_id,rand:Math.random()},function(data){
			if(data != '0'){
				$('#showMsg').html($('#newsDiv').html());
				changeMsgDiv('showMenuMsg');
				$('#updateLinkMsgBtn').show();
				$.get(getMenuJsonUrl,{rand:Math.random()},function(d){
					menuJson = d;
					var json = getMenuMsg('menu_'+mid);
					updateCopyData(json);
					alert('添加成功');
					$('#createMsgBtn2').hide();
					$('#createMsgBtn').show();
				})
			}else{
				alert('修改失败请重试');
				$('#createMsgBtn2').hide();
				$('#createMsgBtn').show();
			}
		});
	}
}

function textPopups(formId,msgId,showId){
	$.openPopupLayer({
		name: "popups",
		target: 'addText',
		success: function(){
				if(formId){
					form = $('#'+formId);
				}
				if(msgId){
					$('.popup-body').find('#message').val($('#'+msgId).val());
					$('.popup-body').find('#editDiv').html($('#'+showId).html().replace(/\n/ig,""));
					commonMsgId = msgId
				}else{
					commonMsgId = null;
				}
				createHover();
			}
	});
}

//验证添加回复
function AddText(name,type,show){
	setContent(type == 'func' ? 'func' : 'message');//return false;
	var nameVal = $.trim(name.val());
	var nameValBrTag = $.trim(show.html());
	if(nameVal == ''){
		alert('回复文字不能为空');
		name.select();
	}else if(nameVal.length > 300){
		alert('回复文字最多300字');
		name.select();
	}else{
		var unique = true;
		var msgBox = form.find('#msgBox');
		msgBox.find("textarea[name='msgContent[]']").each(function(){
			if($(this).attr('id') != commonMsgId && nameVal == $(this).val()){
				alert('回复文字已存在');
				name.select();
				unique = false;
				return false;
			}
		});
		if(unique == true){
			if(commonMsgId){
				msgBox.find("textarea[name='msgContent[]']").each(function(){
					if($(this).attr('id') == commonMsgId){
						$(this).val(nameVal);
						$(this).prev().html(nameValBrTag);
						return false;
					}
				});
			}else{
				var rand = Math.floor(Math.random()*1000);
				var time = Date.parse(new Date());
				var id = 'msg_'+rand+'_'+time;
				var showId = 'show_'+rand+'_'+time;
				var msgHtml = '<li><span class="dx_bt"><input name="delText" type="checkbox" value="" /></span>';
				msgHtml += '<span class="tq" id="'+showId+'">'+nameValBrTag+'</span>';
				msgHtml += '<textarea id="'+id+'" style="display:none" name=msgContent[]>'+nameVal+'</textarea>';
				msgHtml += '<input type="hidden" name=msgType[] value="'+type+'" />';
				msgHtml += '<span class="txt"><a href="javascript:;" onclick='+type+'Popups("'+form.attr('id')+'","'+id+'","'+showId+'")>编辑</a>';
				msgHtml += '<a href="javascript:;" onclick="changeAddKeyword($(this),\'hf\')">　启用</a>';
				msgHtml += '<input type="hidden" name=msgStatus[] value="1" />';
				msgHtml += '<input type="hidden" name=thumb[] value="" />';
				msgHtml += '<input type="hidden" name=title[] value="" />';
				msgHtml += '<input type="hidden" name=link[] value="" />';
				msgHtml += '<input type="hidden" name=imgurl[] value="" /></span></li>';
				msgBox.append(msgHtml);
				var textCount = form.find('#'+type+'Count');
				textCount.html(parseInt(textCount.html())+1);
				$.closePopupLayer();
			}
			$.closePopupLayer();
		}
	}
}

function changeAddKeyword(event,type){
	if(confirm('确定要改变发布状态吗？')){
		if(event.html().indexOf('启用') != -1){
			event.html('　禁用')
			if(type)
				event.parent().find("input[name='msgStatus[]']").val('0');
			else
				event.parent().find("input[name='keywordStatus[]']").val('0');
		}else{
			event.html('　启用');
			if(type)
				event.parent().find("input[name='msgStatus[]']").val('1');
			else
				event.parent().find("input[name='keywordStatus[]']").val('1');
		}
	}
}

//DIV弹窗
function keywordPopups(formId,kwId){
	$.openPopupLayer({
		name: "popups",
		target: 'addKeyword',
		success: function(){
				if(formId){
					form = $('#'+formId);
				}
				if(kwId){
					$('.popup-body').find('#keyword').val($('#'+kwId).val());
					commonKwId = kwId
				}else{
					commonKwId = null;
				}
			}
	});
}


//验证添加 关键字
function AddKeyword(name){
	var nameVal = $.trim(name.val());
	if(nameVal == ''){
		alert('关键字不能为空');
		name.select();
	}else if(nameVal.length > 30){
		alert('关键字最多30字');
		name.select();
	}else{
		var unique = true;
		var keywordBox = form.find('#keywordBox');
		keywordBox.find("input[name='keywordName[]']").each(function(){
			if($(this).attr('id') != commonKwId && nameVal == $(this).val()){
				alert('关键字已存在');
				name.select();
				unique = false;
				return false;
			}
		});
		if(unique == true){
			if(commonKwId){
				keywordBox.find("input[name='keywordName[]']").each(function(){
					if($(this).attr('id') == commonKwId){
						$(this).val(nameVal);
						$(this).prev().html(nameVal);
						return false;
					}
				});
			}else{
					var rand = Math.floor(Math.random()*1000);
					var time = Date.parse(new Date());
					var id = 'kw_'+rand+'_'+time;
					var keywordHtml = '<li><span class="dx_bt"><input name="delKeyword" type="checkbox" value="" /></span>';
					keywordHtml += '<span class="tq">'+nameVal+'</span>';
					keywordHtml += '<input id="'+id+'" type="hidden" name="keywordName[]" value="'+nameVal+'" />';
					keywordHtml += '<span class="txt"><a href="javascript:;" onclick=keywordPopups("'+form.attr('id')+'","'+id+'")>编辑</a></span>';
					keywordHtml += '<span class="pp"><a href="javascript:;" onclick="changeAddKeyword($(this))">　启用</a>';
					keywordHtml += '<input type="hidden" name="keywordStatus[]" value="1" /></span></li>';
					keywordBox.append(keywordHtml);
				
			}
			$.closePopupLayer();
		}
	}
}

//DIV弹窗
function newsPopups(formId,url){
	form = $('#'+formId);
	ajaxBox(url,{},function(){},true);
}

//删除关键字
function delKeyword1(form){
	form.find("input[name='delKeyword']:checked").each(function(){
		$(this).parents('li').remove();
	});
}
//删除回复
function delText1(form){
	form.find("input[name='delText']:checked").each(function(){
		var p = $(this).parents('li');
		var typeName = p.find("input[name='msgType[]']").val()+'Count';
		p.remove();
		var countObj = form.find('#'+typeName);
		countObj.html(parseInt(countObj.html())-1);
	});
}

//更新规则
function checkAddGroup(form,checkurl,checkurl2){
	var keyword = form.find('input[name="keywordName[]"]');
	var keywordid = form.find('input[name="keywordId[]"]');
	var groupName = form.find('#groupName');
	var keywordCount = keyword.length;
	var messageCount = form.find("textarea[name='msgContent[]']").length;
	var type = form.find('#type');
	var status = form.find('#status');
	if($.trim(groupName.val()) == ''){
		alert('请填写规则名称');
		groupName.select();
	}else if(groupName.val().length > 60){
		alert('规则名最多60字');
		groupName.select();
	}else if(keywordCount == 0){
		alert('到少要有一个关键字');
	}else if(messageCount == 0){
		alert('到少要有一个回复');
	}else{
		$.get(checkurl, {
			name : groupName.val()
		}, function(data) {
			if ($.trim(data)) {
				alert('规则名称已存在!');
				groupName.select();
			}else{
				var kwStr = '';
				var kwId = '';
				keyword.each(function(i){
					if(i == keyword.length - 1)
						kwStr += $(this).val();
					else
						kwStr += $(this).val() + '@!@';
				});
				keywordid.each(function(i){
					if(i == keyword.length - 1)
						kwId += $(this).val();
					else
						kwId += $(this).val() + '@!@';
				});
				$.get(checkurl2, {
					name : kwStr,
					id	: kwId
				}, function(data) {
					if ($.trim(data)) {
						alert('关键字('+data+')存在其他规则组中!');
					}else{
						form.submit();
					}
				})
			}
		});
	}
}

function changeKeyword(url,event) {
	var obj = event.parent().parent().find('.tq').length > 0 ? event.parent().parent().find('.tq') : event.parent().parent().find('.tq_title_content').find('a');
	var statusVal = obj.html();
	if (confirm('确定要改变(' + statusVal + ')的发布状态吗？')) {
		$.get(url, {
			rand : Math.random()
		}, function(data) {
			var status = event.next().val() == 1 ? 0 : 1;
			event.next().val(status);
			if (event.html().indexOf('启用') != -1){
				event.html('　禁用');
			}else{
				event.html('　启用');
			}
			if (event.attr('onclick').toString().indexOf('status/0') != -1)
				event.parent().html(
						event.parent().html().replace('status/0', 'status/1'));
			else
				event.parent().html(
						event.parent().html().replace('status/1', 'status/0'));
		});
	}
}

//删除规则
function delGroup(event,index){
	var statusVal = event.parents(".wx_list").find('.wx_list_title_left').find('span').next().html();
	if (confirm('确定要删除(' + statusVal + ')吗？')) {
		//alert(event.parents('#deleteForm').attr('action'));
		$('#deleteForm_'+index).submit();
	}
}

function changeGroup_t(url,event,i,type){
	var statusVal = event.parent().parent().find('span').next().html();
	if (confirm('确定要改变(' + statusVal + ')的状态类型吗？')) {
		$.get(url, {
			rand : Math.random()
		}, function(data) {
			if(type){
				event.parent().find('input:radio[name="Group[type]"]').attr("checked",false);
				event.parent().find('input:radio[name="Group[type]"]').eq(i).attr("checked",'checked');
			}else{
				event.parent().find('input:radio[name="Group[status]"]').attr("checked",false);
				event.parent().find('input:radio[name="Group[status]"]').eq(i).attr("checked",'checked');
			}
		});
	}
}


//添加默认回复
function AddMessage(){
	var content = $('#msgContent');
	setContent();
	if($.trim(content.val()) == ''){
		alert('回复文字不能为空');
	}else{
		$('#defaultForm').submit();
	}
}

//修改默认回复状态
function changeDefaultStatus(url, event) {
	if (confirm('确定要改变(' + event.parent().parent().find('td').next().html()
			+ ')的发布状态吗？')) {
		$.get(url, {
			rand : Math.random()
		}, function(data) {
			var arr = data.split("*");
			if (event.html() == '有效'){
					event.html('无效');
					event.parent().prev().prev().prev().html(arr['1']);
					event.parent().prev().prev().html(arr['2']);
				}
			else{
					event.html('有效');
					event.parent().prev().prev().prev().html(arr['1']);
					event.parent().prev().prev().html(arr['2']);
				}
			if (event.attr('onclick').toString().indexOf('status/0') != -1)
				event.parent().html(
						event.parent().html().replace('status/0', 'status/1'));
			else
				event.parent().html(
						event.parent().html().replace('status/1', 'status/0'));
		});
	}
}

function delMsg() {
	var checked_num = $("input[name='sel']:checked").length;
	if (checked_num == 0) {
		alert('请先选定要删除的回复!');
		return false;
	} else {
		if (!confirm('确定删除选定回复?'))
			return false;
		else {
			var str = '';
			$("input[name='sel']:checked").each(function() {
				str += $(this).val() + ',';
			});
			str = str.substring(0, str.length - 1);
			$('#str').val(str);
			$('#delForm').submit();
		}
	}
}

function updateLinkMsgBegin(){
	$('#editDiv').html('');
	$('#newsDiv div').removeClass('menu_tw_list_box_one_bak').html('');
	var json = getMenuMsg($('.selMenu').attr('id'));
	var type = json.type;
	if(type == 'view'){
		$('#updateLinkMsgId').val(json.id);
		$('#updateLinkMsg').val(json.content);
		changeMsgDiv('updateLinkMsgDiv');
	}else{
		$('.msgBtn').hide();
		$('.menu_list_right_title').find('a').removeClass('menu_vtd');
		$('a[name="'+type+'"]').addClass('menu_vtd');
		$('.menu_list_right_text').hide();
		$('#'+type+'Div').show();
		if(type == 'text'){
			$('#updateMsgId').val(json.id);
			$('#editDiv').html(json.content);
		}else{
			$('#newsDiv').find('div').addClass('menu_tw_list_box_one_bak').html($('#copyNewsDiv .menu_tw_list_box_one_bak').html());
		}
		$('#updateMsgBtn').show();
		changeMsgDiv('createMsgDiv');
	}
	$('.menu_list_left').css('height',$('.menu_list').css('height'));
}

function chooseTextTag(){
	$('.menu_list_right_title a').removeClass('menu_vtd');
	$('#textTag').addClass('menu_vtd');
	$('.menu_list_right_text').hide();
	$('#textDiv').show();
}

function updateMenuMsg(name,type,show,url){
	var midArr = $('.selMenu').attr('id').split('_');
	var mid = midArr[1];
	if(type == 'text'){
		setContent($('#message'));
		var nameVal = $.trim(name.val());
		if(nameVal == ''){
			alert('回复文字不能为空');
			name.select();
		}else if(nameVal.length > 600){
			alert('回复文字最多600字');
			name.select();
		}else{
			$('#updateMsgBtn').hide();
			$('#updateMsgBtn2').show();
			$.post(url,{id:$('#updateMsgId').val(),mid:mid,content:nameVal,type:type,rand:Math.random()},function(data){
				if(data != '0'){
					$('#showMsg').html(show.html());
					changeMsgDiv('showMenuMsg');
					$.get(getMenuJsonUrl,{rand:Math.random()},function(d){
						menuJson = d;
						alert('修改成功');
						$('#updateMsgBtn2').hide();
						$('#updateMsgBtn').show();
					})
				}else{
					alert('修改失败请重试');
					$('#updateMsgBtn2').hide();
					$('#updateMsgBtn').show();
				}
			});
		}
	}else if(type == 'news'){
		$('#updateMsgBtn').hide();
		$('#updateMsgBtn2').show();
		var msg_id = $('#newsDiv .menu_tw_list_box_one_bak').find('input').val();
		$.post(url,{msgId:msg_id,mid:mid,type:type,rand:Math.random()},function(data){
			if(data != '0'){
				$('#showMsg').html($('#newsDiv').html());
				changeMsgDiv('showMenuMsg');
				$.get(getMenuJsonUrl,{rand:Math.random()},function(d){
					menuJson = d;
					var json = getMenuMsg('menu_'+mid);
					updateCopyData(json);
					alert('修改成功');
					$('#updateMsgBtn2').hide();
					$('#updateMsgBtn').show();
				})
			}else{
				alert('修改失败请重试');
				$('#updateMsgBtn2').hide();
				$('#updateMsgBtn').show();
			}
		});
	}
}

function updateCopyData(json){
	$('#copyNewsDiv input').val(json.id);
	$('#copyNewsDiv .menu_tw_list_box_title').html(json.content.title);
	$('#copyNewsDiv .menu_tw_list_box_time').html(json.content.date);
	if(json.content.multiple == 1){
		$('#copyNewsDiv .menu_tw_list_box_text').hide();
		$('#copyNewsDiv .multipleList').show();
		$('#copyNewsDiv .menu_tw_list_box_pic img').attr('src',json.content.body[0].imgurl);
		var html = '';
		for(var i = 1 ; i < json.content.body.length; i++){
			var arr = json.content.body[i].imgurl.split('.');
			var thumbType = arr[arr.length-1];
			html += '<div class="multipleNews">';
			html += '<span class="title">'+json.content.body[i].title+'</span>';
			html += '<span class="thumb"><img src="'+json.content.body[i].imgurl+'.'+thumbType+'"></span>';
			html += '<div class="clear"></div>';
			html += '</div>';
		}
		$('#copyNewsDiv .multipleList').html(html);
	}else{
		$('#copyNewsDiv .multipleList').hide();
		$('#copyNewsDiv .menu_tw_list_box_text').show();
		$('#copyNewsDiv .menu_tw_list_box_pic img').attr('src',json.content.imgurl);
		$('#copyNewsDiv .menu_tw_list_box_text').html(json.content.body);
	}
}

function orderBegin(flag){
	if(flag){
		$('span[name="order1"]').hide();
		$('span[name="order2"]').show();
		$('span[name="operation"]').hide();
		$('.orderSpan').show();
	}else{
		$('span[name="order1"]').show();
		$('span[name="order2"]').hide();
		$('span[name="operation"]').show();
		$('.orderSpan').hide();
	}
}

function submitOrder(url){
	var obj = $('[no]');
	var str = '[';
	obj.each(function(i){
		var idArr = $(this).attr('id').split('_');
		var id = idArr[1];
		str += '{"id":"'+id+'","weight":"'+$(this).attr("no")+'"}';
		if(i < obj.length -1){
			str += ',';
		}
	});
	str += ']';
	$.get(url,{str:str,rand:Math.random()},function(data){
		if(data == 's'){
			alert('排序成功');
			orderBegin(false);
		}else{
			alert('排序失败请重试');
		}
		$.closePopupLayer();
	});
}

function publishMenu(url){
	$('#publishMenuBtn').hide();
	$('#publishMenuBtn2').show();
	$.get(url,{rand:Math.random()},function(data){
		if(data == 'null menu'){
			alert('空菜单，不能同步');
		}else if(data == 'no response'){
			alert('存在还未设置响应动作的菜单，请检查');
		}else{
			var rs = eval('(' + data + ')');
			if(rs.errcode == 0 && rs.errmsg == 'ok'){
				alert('菜单发布成功');
			}else{
				alert('发布失败请重试');
			}
		}
		$('#publishMenuBtn2').hide();
		$('#publishMenuBtn').show();
	});
}

function changeStar(url, event) {
	if (confirm('确定要改变该消息的收藏状态吗？')) {
		$.get(url, {
			rand : Math.random()
		}, function(data) {
			if (event.html() == '已收藏'){
					event.html('未收藏');
				}
			else{
					event.html('已收藏');
				}
			if (event.attr('onclick').toString().indexOf('star/0') != -1)
				event.parent().html(event.parent().html().replace('star/0', 'star/1'));
			else
				event.parent().html(event.parent().html().replace('star/1', 'star/0'));
		});
	}
}

function createEditor(){
	$('textarea[name="content[]"]').each(function(){
		UE.getEditor($(this).attr('id'));
	});
}


function addLinkMsg(url){
	var linkMsg = $('#linkMsg');
	if(!CheckUrl(linkMsg.val())){
		alert('请输入正确的URL');
		linkMsg.select();
	}else{
		var midArr = $('.selMenu').attr('id').split('_');
		var mid = midArr[1];
		$('#addLinkMsgBtn').hide();
		$('#addLinkMsgBtn2').show();
		$.post(url,{linkMsg:linkMsg.val(),mid:mid,rand:Math.random()},function(data){
			if(data != 0){
				$('#showLinkMsg').html(linkMsg.val());
				changeMsgDiv('showLinkMsgDiv');
				$('#updateLinkMsgBtn').show();
				$.get(getMenuJsonUrl,{rand:Math.random()},function(d){
					menuJson = d;
					alert('添加成功');
					$('#addLinkMsgBtn2').hide();
					$('#addLinkMsgBtn').show();
				})
			}else{
				alert('添加失败请重试');
				$('#addLinkMsgBtn2').hide();
				$('#addLinkMsgBtn').show();
			}
		});
	}
}

function CheckUrl(str) {
	var RegUrl = new RegExp();
	RegUrl.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
	if (!RegUrl.test(str)) {
		return false;
	}
		return true;
} 

function closeUpdateLinkMsg(){
	$('#updateLinkMsg').val('');
	var json = getMenuMsg($('.selMenu').attr('id'));
	$('#showLinkMsg').html(json.content);
	changeMsgDiv('showLinkMsgDiv');
}

function updateLinkMsg(url){
	var linkMsg = $('#updateLinkMsg');
	if(!CheckUrl(linkMsg.val())){
		alert('请输入正确的URL');
		linkMsg.select();
	}else{
		$('#updateLinkBtn').hide();
		$('#updateLinkBtn2').show();
		$.get(url,{id:$('#updateLinkMsgId').val(),linkMsg:linkMsg.val(),rand:Math.random()},function(data){
			if(data != 0){
				$('#showLinkMsg').html(linkMsg.val());
				changeMsgDiv('showLinkMsgDiv');
				$.get(getMenuJsonUrl,{rand:Math.random()},function(d){
					menuJson = d;
					alert('修改成功');
					$('#updateLinkBtn2').hide();
					$('#updateLinkBtn').show();
				})
			}else{
				alert('修改失败请重试');
				$('#updateLinkBtn2').hide();
				$('#updateLinkBtn').show();
			}
		});
	}
}
function loadEditor() {  
    var script = document.createElement("script");  
    script.src = "/js/ueditor/ueditor.all.js";
    document.body.appendChild(script);  
  } 
function showMsgType(){
	$('#linkMsg').val('');
	changeMsgDiv('menuMsgType');
}

function delMember(url) {
	var checked_num = $("input[name='sel']:checked").length;
	if (checked_num == 0) {
		alert('请先选定要删除的会员!');
		return false;
	} else {
		if (!confirm('确定删除选定会员?'))
			return false;
		else {
			var str = '';
			$("input[name='sel']:checked").each(function() {
				str += $(this).val() + ',';
			});
			str = str.substring(0, str.length - 1);
			location.href = url + "/str/" + str;
		}
	}
}

function deleteItem(checkUrl) {
	var checked_num = $("input[name='sel']:checked").length;
	if (checked_num == 0) {
		alert('请先选定要删除的选项');
		return false;
	} else {
		if (!confirm('确定删除？'))
			return false;
		else {
			var str = '';
			$("input[name='sel']:checked").each(function() {
				str += $(this).val() + ',';
			});
			str = str.substring(0, str.length - 1);
			if(checkUrl){
				$.get(checkUrl,{str:str,rand:Math.random()},function(data){
					if(data == 0){
						$('#str').val(str);
						$('#delForm').submit();
					}else{
						alert(data);
					}
				})
			}else{
				$('#str').val(str);
				$('#delForm').submit();
			}
		}
	}
}