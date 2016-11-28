/**
 * Created by PhpStorm.
 * Author: roby
 * Email:zdwroby@gmail.com
 * Date: 2016/6/20 17:09
 * Desc: 
 */

$(document).ready(function(){
	$('.jq_write_menu').on('blur', "input[num_float]", function(){
    	a=parseFloat($(this).val());
        if(isNaN(a) || (a<0 && typeof($(this).attr('small_than_zero'))=='undefined')){
            $(this).val('');
        }else{
            if(typeof($(this).attr('not_zero'))!='undefined' && ($(this).val()==''||$(this).val()==0)){
                $(this).val('');
                return false;
            }
            if(typeof($(this).attr('int'))!='undefined' ){
                $(this).val(Math.round(a));
				
                return false;
            }
            $(this).val(a.toFixed(2))
        }		
	}).bind("keyup",function(){
		if(this.value==this.value2)return;
	    if(this.value.search(/^\d*(?:\.\d{0,2})?$/)==-1)this.value=(this.value2)?this.value2:'';else this.value2=this.value;		
	});	
	if($('input[num_float]').length > 0){
		$('input[num_float]').blur(function(){
	    	a=parseFloat($(this).val());
	        if(isNaN(a) || (a<0 && typeof($(this).attr('small_than_zero'))=='undefined')){
	            $(this).val('');
	        }else{
	            if(typeof($(this).attr('not_zero'))!='undefined' && ($(this).val()==''||$(this).val()==0)){
	                $(this).val('');
	                return false;
	            }
	            if(typeof($(this).attr('int'))!='undefined' ){
	                $(this).val(Math.round(a));
					
	                return false;
	            }
	            $(this).val(a.toFixed(2))
	        }
	    }).bind("keyup",function(){
	        if(this.value==this.value2)return;
	        if(this.value.search(/^\d*(?:\.\d{0,2})?$/)==-1)this.value=(this.value2)?this.value2:'';else this.value2=this.value;
	   })		
	}
	/*------------公众号基本信息管理start-----------*/
	$('.jq_add_ga').on('click', function(){
		var id = $(this).data('id');
		if(id){
			layerIframe('编辑公众号', weburl+'/admin/home/publicnumber?id='+id,"850px");
		}else{
			layerIframe('添加公众号', weburl+'/admin/home/publicnumber',"850px");
		}
		
	})
	$('.jq_delete_ga').on('click',function(){
		var id = $(this).data('id');
		var table = $(this).data('table');
		var csrf = $(this).data('csrf');
		delPrompt('/admin/ajaxga/delete', id, table, csrf);
	})


	$('.jq_add_menu').click(function(){
		var is_child = $(this).attr('is_child');
		var parent_id = $(this).attr('parent_id');
		var this_tr;
		if(is_child ==1){	//添加的是子菜单
			this_tr = $(this).parent().parent();
		}
		addMenu(is_child, parent_id, this_tr);
	})
	/*弹框内容展示*/
	$(".jq_write_menu").on("click", '.jq_choose_art',function(){
		var type = $(this).data('type');			//弹框类型1、2、3
		var title = $(this).data('title');
		switch(type){
			case 1:  //发送消息
			case 2:  //跳转到图文信息页
			case 3:  //触发关键词
			 
			break;
		}
		layerPage(type, title);
	});
	$('.jq_write_menu').on("change", '.jq_choose_type', function(){
		var optionObj = $(this).find("option:selected");
		var type = optionObj.data('val');
		var title = optionObj.data('title'); 				//点击该按钮打开的弹框标题
		var button_text = optionObj.text();	
		var nextTd = $(this).parent().next();
		$(this).next('.jq_choose_type_res').val(type);		//赋值到隐藏表单
		var i = $(this).attr('attr_i');
		var edit_type = $(this).attr('attr_type');			//判断是新增还是编辑
		triggerAction(i, edit_type, type, title, button_text, nextTd);
	})
	//生成自定义菜单
	$('.jq_create_menu').on('click',function(){
        $.post('/admin/ajaxga/createmenu', {aid:aid}, function(r) {
        	//console.log(r);return false;
        	if(r.code=='200'){
        		layer.msg(r.msg, {icon:1,time:2000}, function(){window.location.reload();});
        	}				                           
        }, 'json');		
	})
	//保存菜单  表单验证
	$('#menuForm').on('submit',function(){
		var flag = true;
		$('.jq_sort').each(function(){			//验证显示顺序
			var e = $(this);
			if(e.val() == ''){
				e.focus();
				layer.msg('显示顺序不能为空', {icon:1,time:2000});
				flag = false;
				return;	
			}
		})
		if(!flag) return false;
		$('.jq_name').each(function(){			//验证主菜单名称
			var e = $(this);
			if(e.val() == ''){
				e.focus();
				layer.msg('主菜单名称不能为空', {icon:1,time:2000});
				flag = false;
				return;				
			}
		})
		if(!flag) return false;
		var menu_type = $('.jq_choose_type_res').val();
		if(menu_type == 4){			//触发动作是跳转url
			$('.jq_url').each(function(){
				var e = $(this);
				if(e.val() == ''){
					e.focus();
					layer.msg('跳转链接不能为空', {icon:1,time:2000});
					flag = false;
					return;				
				}				
			})
		}else{						//触发动作是选择图文消息或关键字
			$('.jq_response').each(function(){		//验证响应动作
				var e = $(this);
				if(e.val() == ''){
					e.focus();
					layer.msg('响应动作不能为空', {icon:1,time:2000});
					flag = false;
					return;				
				}
			})
		}
		console.log(flag);
		if(!flag) return false;
        $.post( $(this).attr('action'), $(this).serialize(), function(r) {
        	//console.log(r);return false;
        	if(r.code=='200'){
        		layer.msg(r.msg, {icon:1,time:2000}, function(){window.location.reload();});
        	}				                           
        }, 'json');		
		return false;


	})	


})



/*添加一行菜单记录 table tr*/
function addMenu(is_child, parent_id, this_tr){
	var i = $('.jq_write_menu .jq_tr').length+1;
	var subhtml = '';
	if(is_child==1){
		subhtml = '<i class="board"></i>';
	}
	var menu_html = '<tr class="jq_tr">'+ 
    '<td><input name="new[sort]['+i+']" value="0" size="3" type="text" num_float int class="form-control jq_sort"></td>'+
    '<td>'+
        '<input type="hidden" name="new[parent]['+i+']" value="'+parent_id+'">'+
    	subhtml +        
        '<input style="width:70%;display: inline-block;" name="new[name]['+i+']" size="10" type="text" class="form-control jq_name" maxlength="30">'+
    '</td>'+
    '<td>'+     
        '<select class="form-control m-b jq_choose_type" attr_type="new" attr_i="'+i+'" name="new[type]['+i+']" style="position: relative;top:8px;">'+
                '<option value="1" selected data-val="1" data-text="选择图文信息" data-title="选择图文信息">发送信息</option>'+
                '<option value="2" data-val="2" data-text="跳转到图文信息页" data-title="选择图文信息">跳转到图文信息页</option>'+
                '<option value="3" data-val="3" data-text="选择关键词" data-title="选择关键词信息">触发关键词</option>'+
                '<option value="4" data-val="4" data-info="new">跳转链接</option>'+
        '</select>'+
        '<input type="hidden" class="jq_choose_type_res" value="1" name="new[trigger_action]['+i+']">'+        
    '</td>'+
    '<td>'+         
		'<button type="button" data-title="选择图文" class="btn btn-default btn-sm jq_choose_art">选择图文消息</button>'+
		'<input type="hidden" class="jq_response" value="" name="new[response]['+i+']">'+
    '</td>'+
    '<td>'+ 
		'<input type="checkbox" class="jq_is_show" value="1" name="new[is_show]['+i+']" checked>'+    
    '</td>'+ 
    '<td><a href="javascript:void()" class="jq_del">删除</a></td>'+
'</tr>';
	if(is_child == 1){
		this_tr.after(menu_html);
	}else{
		$('.jq_write_menu').append(menu_html);
	}
	

}
/*触发动作的选择决定响应动作的结果*/
function triggerAction(i, edit_type, type, title, button_text, nextTd){
	var html = '';
	switch(type){
		case 1:  //发送消息
		case 2:  //跳转到图文信息页
		case 3:  //触发关键词 
		html = '<button type="button" data-type="'+type+'" data-title="'+title+'" class="btn btn-default btn-sm jq_choose_art">'+button_text+'</button>'+
			   '<input type="hidden" class="jq_response" value="" name="'+edit_type+'[response]['+i+']">';
		break;
		case 4:  //跳转链接
		html = '<input name="'+edit_type+'[url]['+i+']" size="10" type="text" class="form-control jq_url" maxlength="30">';
		break;
		default:
	}
	nextTd.html(html);
	
}
/*响应动作：layer页面层 1、2选择图文消息、跳转到图文消息页，3为关键词*/
function layerPage(type, title, content, width, height){
	var type = arguments[0] || '默认弹框';
	var title = arguments[1] || '信息';
	var content= arguments[2] || '<div style="padding:20px;">即直接给content传入html字符<br>当内容宽高超过定义宽高，会自动出现滚动条。<br><br><br><br><br><br><br><br><br><br><br>很高兴在下面遇见你</div>';
	var width= arguments[3] || '420px';
	var height= arguments[4] || '240px';
	parent.layer.open({
		type: 1,
		title:title,
		area: [width, height],
		skin: "layui-layer-rim",
		content: content
	});
}
//iframe层
function layerIframe(title, url, width, height){
	var width= arguments[2] || '380px';
	var height= arguments[3] || '80%';	
	parent.layer.open({
	    type: 2,
	    title: title,
	    shadeClose: true,
	    shade: 0.8,
	    area: [width, height],
	    content: url //iframe的url
	});
}
//删除 提示框
function delPrompt(url, id, table, csrf){
	parent.layer.confirm("您真的要删除该条记录吗？", {
		title:'温馨提示',
		skin: "layer-ext-moon"
	}, function(e, t) {
		parent.layer.close(e);
		//Ajax获取
		$.post(url, {'id':id,'table':table, '_csrf':csrf}, function(r){
		  if(r.code==200){
		  	  console.log(r);
			  layer.msg(r.msg, {icon:1,time:2000}, function(){window.location.reload();});
		  }

		},'json');

	})	
}
/***********************基础工具*****************************/
function isInArray(search,arr){
	var i = arr.length;  
    while (i--) {  
        if (arr[i] === search) {  
            return true;  
        }  
    }  
}
function showTips(text, time) {
    if(arguments.length < 1) {
        alert('请填写提示');
        return;
    }

    var text = text,
        time = time;

    var wrap_div = '<div class="myTips" id="myTips" style="position: fixed;top: 0; left: 0;width: 100%;height: 100%;z-index: 10000;"><div style="position: absolute;padding: 20px;background: rgba(0, 0, 0, 0.7);position: absolute; left:50%; top:50%; -webkit-transform:translate(-50%,-50%); transform:translate(-50%,-50%);font-size: 18px;border-radius: 10px;color:#fff;opacity: 0.9;">'+ text +'</div>';


    if($('.myTips').length > 0) {
        $('.myTips').find('div').text(text);
    } else {
        $("body").append(wrap_div);
    }

    if(time != undefined && time) {
        $("#myTips").show();
        setTimeout(function() {
            $("#myTips").hide();
        }, time);
    }

}