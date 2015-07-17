var codeArr = Array(
		'/::)','/::~','/::B','/::|','/:8-)','/::<','/::$','/::X','/::Z',"/::<",'/::-|','/::@','/::P','/::D','/::O',
		'/::(','/::+','/:--b','/::Q','/::T','/:,@P','/:,@-D','/::d','/:,@o','/::g','/:|-)','/::!','/::L','/::>','/::,@',
		'/:,@f','/::-S','/:?','/:,@x','/:,@@','/::8','/:,@!','/:!!!','/:xx','/:bye','/:wipe','/:dig','/:handclap','/:&-(','/:B-)',
		'/:<@','/:@>','/::-O','/:>-|','/:P-(',"/::'|",'/:X-)','/::*','/:@x','/:8*','/:pd','/:<W>','/:beer','/:basketb','/:oo',
		'/:coffee','/:eat','/:pig','/:rose','/:fade','/:showlove','/:heart','/:break','/:cake','/:li','/:bome','/:kn','/:footb','/:ladybug','/:shit',
		'/:moon','/:sun','/:gift','/:hug','/:strong','/:weak','/:share','/:v','/:@)','/:jj','/:@@','/:bad','/:lvu','/:no','/:ok',
		'/:love','/:<L>','/:jump','/:shake','/:<O>','/:circle','/:kotow','/:turn','/:skip','/:oY','/:#-0','/:hiphot','/:kiss','/:<&','/:&>'
	);
function create(){
	var count = 0;
	var left = 0;
	var html = "";
	var table = $('.emotions').find('table');
	for(var i = 0; i < 7;i++){
		html += "<tr>";
		for(var j = 0;j < 15; j++){
			left = count * 24;
			html += '<td><div class="eItem" style="background-position:'+left+'px 0;"></div></td>';
			count--;
		}
		html += "</tr>";
	}
	table.html(table.html()+html);
}
//给文本框赋值
function setContent(msgId){
	var editDiv = $('#popupLayer_popups').find('#editDiv');
	var codeHtml = $.trim(editDiv.html().toString()).replace(/<br>$/i,'').replace(/<img src=".*?\/media\/images\/emotions\/(.*?).gif">/ig,function(a,b){
		return codeArr[b];
	});
	//alert(codeHtml);
	/*codeHtml = $.trim(codeHtml).replace(/<p>/ig,"");
	codeHtml = $.trim(codeHtml).replace(/<div>/ig,"\n");
	//alert(codeHtml);
	codeHtml = $.trim(codeHtml).replace(/<\/div>/ig,"");
	//alert(codeHtml);
	codeHtml = $.trim(codeHtml).replace(/<\/p>/ig,brReplace);
	codeHtml = $.trim(codeHtml).replace(/&nbsp;/ig,brReplace);
	//alert(codeHtml);
*/	
	codeHtml = $.trim(codeHtml).replace(/<div><br><\/div>/ig,"\n");
	//alert(codeHtml);
	codeHtml = $.trim(codeHtml).replace(/<div>(.*?)<\/div>/ig,"\n$1");
	//alert(codeHtml);
	codeHtml = $.trim(codeHtml).replace(/<span.*?<br><\/span>/ig,"\n");
	codeHtml = $.trim(codeHtml).replace(/<\/div>/ig,"");
	codeHtml = $.trim(codeHtml).replace(/<div>/ig,"\n");
	//alert(codeHtml);
	codeHtml = $.trim(codeHtml).replace(/<br>/ig,"\n");
	codeHtml = $.trim(codeHtml).replace(/\r\n/ig,"");
	//alert(codeHtml);
	$('#popupLayer_popups').find('#'+msgId).val(codeHtml);
}
var rangeSel,range;
$(function(){
	create();
	$('.emotions').mouseleave(function(){
		$('.emotions').fadeOut('fast');
	});
	$('#popupLayer_popups .emotionsWord').live('click',function(){
		$('#popupLayer_popups .emotions').toggle('fast');
	});
	$('#editDiv').live('blur',function(){
		getRange();
	});
	$('#editDiv').live('keydown',function(e){
		if(document.all && e.which==13){
			var textRange=document.selection.createRange();
		    textRange.text="\r\n";
		    textRange.select();
		    return false;
		}
	});
})
function getRange(){
    if (window.getSelection)//ff
    {
        // IE9 and non-IE 
        rangeSel = window.getSelection(); 
        if (rangeSel.getRangeAt && rangeSel.rangeCount) { 
            range = rangeSel.getRangeAt(0);
        } 
    }  
}

function createHover(){
	$("#popupLayer_popups .eItem").each(function(i){
		$(this).hover(
			function(){
				$(this).parent().css('borderColor','blue');
				$('#popupLayer_popups .emotionsGif').html('<img src="/media/images/emotions/'+i+'.gif"/>');
			},
			function(){
				$(this).parent().css('borderColor','#DFE6F6');
				$('#popupLayer_popups .emotionsGif').html('');
			}
		);
		$(this).click(function(){
			var editDiv = $('#popupLayer_popups').find("#editDiv");
			var oldHtml = $.trim(editDiv.html()).replace(/<br>$/i,'');
			insertHTML('<img src="/media/images/emotions/'+i+'.gif"/>',editDiv);
			$('.emotions').fadeOut('fast');
		});
	})
}

function insertHTML(html,obj) 
{ 
	var dthis=obj[0];//要插入内容的某个div,在标准浏览器中 无需这句话 
    if (window.getSelection)//ff
    {
        // IE9 and non-IE 
    	/*for(i in range.startContainer){
    		if(range.startContainer[i])
    			console.log(i+'**'+range.startContainer[i]);
    	}*/
    	//console.log(range.isPointInRange());
    	//alert(range.startContainer);//parentElement
    	//alert(range.startContainer+'***'+range.startContainer.parentNode.id+'***'+range.startContainer.id+'***'+range.startContainer.parentNode.offsetParent.id);
        if (range && (range.startContainer == 'HTMLDivElement' || range.startContainer.parentNode.id == 'editDiv' || range.startContainer.id == 'editDiv' || (range.startContainer.parentNode.offsetParent && range.startContainer.parentNode.offsetParent.id == 'editDiv')) && rangeSel.getRangeAt && rangeSel.rangeCount) { 
	            range.deleteContents(); 
	            var el = document.createElement('div'); 
	            el.innerHTML = html; 
	            var frag = document.createDocumentFragment(), node, lastNode; 
	            while ( (node = el.firstChild) ) 
	            { 
	                lastNode = frag.appendChild(node); 
	            } 
	            range.insertNode(frag); 
	            if (lastNode) {
	                range = range.cloneRange(); 
	                range.setStartAfter(lastNode); 
	                range.collapse(true); 
	                rangeSel.removeAllRanges(); 
	                rangeSel.addRange(range); 
	            } 
        }else{
        	obj.html(obj.html()+html);
    	}
    }  
    else if (document.selection && document.selection.type !='Control')  
    { 
        $(dthis).focus(); //在非标准浏览器中 要先让你需要插入html的div 获得焦点 
        range= document.selection.createRange();//获取光标位置 
        range.pasteHTML(html);    //在光标位置插入html 如果只是插入text 则就是fus.text="..." 
        $(dthis).focus(); 
    } 
}  