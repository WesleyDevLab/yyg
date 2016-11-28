/**进行中最新揭晓倒计时**/
function fresh(date, id){
	var sh = setInterval(function(){
        //var d = date;
        var d = date.replace('-','/');
        var d = d.replace('-','/');
        var d = d.replace('-','/');
        //为了兼容浏览器，将2013-10-23 11:25:25 改成 2013/8/20 18:20:30

        var endtime = Date.parse(new Date(d));
        endtime = endtime / 1000;               
        var nowtime = Date.parse(new Date());
        nowtime = nowtime / 1000;
        var test=new Date("2013/8/20 18:20:30");
        //alert(test+'<'+d+'>'+endtime+'>'+nowtime);
        var leftsecond = parseInt(endtime-nowtime);

        d = parseInt(leftsecond / 3600 / 24);
        h = parseInt((leftsecond / 3600) % 24);
        m = parseInt((leftsecond / 60) % 60);
        s = parseInt(leftsecond % 60);
        var td = d * 24 + h;
        if(td<10){
     		td="0"+td
     	}
        if(m<10){
     		m="0"+m
     	}
        if(s<10){
     		s="0"+s
     	}
        $("#emH"+id).html(td);
        $("#emM"+id).html(m);
        $("#emS"+id).html(s);
        if (leftsecond <= 0) {
            $('#jq_html'+id).html('等待开奖');
            clearInterval(sh);
        }			
	})
}
function dateToStr(datetime){ 
	 var year = datetime.getFullYear();
	 var month = datetime.getMonth()+1;//js从0开始取 
	 var date = datetime.getDate(); 
	 var hour = datetime.getHours(); 
	 var minutes = datetime.getMinutes(); 
	 var second = datetime.getSeconds();
	 
	 if(month<10){
	  month = "0" + month;
	 }
	 if(date<10){
	  date = "0" + date;
	 }
	 if(hour <10){
	  hour = "0" + hour;
	 }
	 if(minutes <10){
	  minutes = "0" + minutes;
	 }
	 if(second <10){
	  second = "0" + second ;
	 }
	 
	 var time = year+"-"+month+"-"+date+" "+hour+":"+minutes+":"+second; //2009-06-12 17:18:05
	// alert(time);
	 return time;
}
function handleData(data,webpath,htmlid){
	if(!htmlid){
		htmlid ='divGoodsLoading';
	}
	for(var i=0;i<data.length;i++){
		if(data[i].q_uid>0){			//往期揭晓
			var timestamp = new Date(parseInt(data[i].q_end_time)*1000);						
			var date = dateToStr(timestamp);
			var video = data[i].q_video;
			console.log(video.indexOf("http"));
			if(video.indexOf("http") < 0 )			//不存在，自动添加
			{
				video = "http://"+video;
			}
			var ul  = '<ul>';
				ul += '<div class="publish"><em class="periods red">【第'+data[i]['qishu']+'期】</em>揭晓时间：<em class="arial">'+date+'</em></div>';
				ul += '<li id="'+data[i].good_url+'" class="revConL"><img src="'+data[i].thumb+'"></li>';
				ul += '<li class="revConR">';
				ul += '<dl>';
				ul += '<dd><span>获得者<strong>：</strong><a name="uName" uweb="1385" class="rUserName">'+data[i]['q_user']+'</a></span>本期1元淘<strong>：</strong><em class="orange arial">'+data[i].gonumber+'</em>人次</dd>';
				ul += '</dl>';
				ul += '<dt>幸运号码：<em class="orange arial">'+data[i].q_user_code+'</em><br></dt>';
				ul += '<a class="look_video" href="'+video+'">查看开奖视频</a>';
				ul += '</li></ul>';		
		}else{
			if(data[i].is_xy==1){	//未上线商品
				var ul = '<ul><li>';
					ul +='<span id="'+data[i].good_url+'" class="z-Limg"><img src="'+data[i].thumb+'"></span>';
				    ul +='<div class="goodsListR">';
				    ul +='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【待上线】</em>'+data[i].title+'</h2></a>';
				    ul +='<div class="pRate">';
				    ul +='<div class="wish_value">心愿值：'+data[i].xinyuan+'</div>';
				    ul +='</div></div></li></ul>';
			}else{					//上线商品
				if(data[i].xsjx_time!=0){		//限时商品[不可能购完] 
					var timestamp = new Date(parseInt(data[i].xsjx_time)*1000);						
					var date = dateToStr(timestamp);
					fresh(date,i);
					var nowtimestamp = Date.parse(new Date());			//当前时间
					if(nowtimestamp > timestamp){						//揭晓时间已过了，等待开奖
						var ul='<ul><li>';
							ul+='<span id="'+data[i].good_url+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
							ul+='<div class="goodsListR">';
							ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
							ul+='<div class="pRate">';
							ul+='<div class="lottery_wait">等待开奖</div>';
							ul+='</ul></div>';							
					}else{
						var ul='<ul><li>';
						ul+='<span id="'+data[i].good_url+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
						ul+='<div class="goodsListR">';
						ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i].qishu+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
						ul+='<div class="pRate">';
						ul+= '<div class="announce_countdown">揭晓倒计时';			        	
					    ul+= '<em id="emH'+i+'">16</em> <strong>:</strong><em id="emM'+i+'">20</em><strong>:</strong><em id="emS'+i+'">21</em>';
					    ul+= '</div>';
					    ul+='<div class="p-bar04 participation" onclick="go_buy();" attr_goodsid="'+data[i].id+'" attr_maxnum="'+data[i].shenyurenshu+'" attr_times="'+data[i]['default_times']+'">立即参与</div>';
						ul+= '</div></div></li></ul>';							
					}			
				}else{
					if(data[i].shenyurenshu == 0){			//卖完了，等待开奖
						var ul='<ul><li>';
							ul+='<span id="'+data[i].good_url+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
							ul+='<div class="goodsListR">';
							ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
							ul+='<div class="pRate">';
							ul+='<div class="lottery_wait">等待开奖</div>';
							ul+='</ul></div>';
					}else{
						var ul='<ul><li>';
							ul+='<span id="'+data[i].good_url+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
							ul+='<div class="goodsListR">';
							ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].good_url+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
							ul+='<div class="pRate">';
							ul+='<div class="Progress-bar" id="'+data[i].good_url+'">';				
							ul+='<p class="u-progress"><span class="pgbar" style="width:'+(data[i].canyurenshu / data[i].zongrenshu)*100+'%;"><span class="pging"></span></span></p>';
							ul+='<ul class="Pro-bar-li">';
							ul+='<li class="P-bar02"><em>'+data[i].zongrenshu+'</em>总需人次</li>';
							ul+='<li class="P-bar03"><em>'+data[i].shenyurenshu+'</em>剩余人次</li>';
							ul+='</ul></div>';
				            ul+='<div class="p-bar04 participation" onclick="go_buy();" attr_goodsid="'+data[i].id+'" attr_maxnum="'+data[i].attr_maxnum+'" attr_times="'+data[i]['default_times']+'">立即参与</div>';
							ul+='</div></div></li></ul>';						
					}

				}
			}			
		}
		$("#"+htmlid).before(ul);
	}	
	
}

$(document).ready(function(){
	$('.not_online').click(function(){
		var obj = $(this);
		var sid = obj.attr('attr_sid');
		var gid = obj.attr('attr_gid');
		$.getJSON(Path.Webpath+'/goods/myxyajax/'+gid+'/'+sid,function(data){
			//console.log(data);
			if(data.code==200){
				var s = $('.P-bar02 em');
				var old_xy = s.html();
				$('.P-bar02 em').html(parseInt(old_xy)+1);
				obj.find('img').attr('src',Path.Skin+'/css/images/click_press.png');
				$.PageDialog.fail('已加入我的心愿')
			}else{
				$.PageDialog.fail(data.msg)
			}
		})		
		//obj.find('img').attr('src',Path.Skin+'/css/images/click_press.png');
	})
})