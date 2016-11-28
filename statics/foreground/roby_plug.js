function handleData(data,webpath){
	for(var i=0;i<data.length;i++){
		console.log(data[i].is_xy+">>"+data[i].xsjx_time);
		if(data[i].is_xy==1){	//未上线商品
			var ul = '<ul><li>';
				ul +='<span id="41" class="z-Limg"><img src="http://wx.91k8.me/statics/uploads/shopimg/20160826/30103261176203.jpg"></span>';
			    ul +='<div class="goodsListR">';
			    ul +='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="41"><em class="red">【待上新】</em>'+data[i].title+'</h2></a>';
			    ul +='<div class="pRate">';
			    ul +='<div class="wish_value">心愿值：'+data[i].xinyuan+'</div>';
			    ul +='</div></div></li></ul>';
		}else{					//上线商品
			if(data[i].xsjx_time!=0){		//限时商品[不可能购完] 
				var timestamp = new Date(parseInt(data[i].xsjx_time)*1000);						
				var date = dateToStr(timestamp);
				fresh(date,i);
				if(data[i].shenyurenshu >0){
					var ul='<ul><li>';
					ul+='<span id="'+data[i].id+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
					ul+='<div class="goodsListR">';
					ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].id+'"><em class="red">【第'+data[i].qishu+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
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
						ul+='<span id="'+data[i].id+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
						ul+='<div class="goodsListR">';
						ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].id+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
						ul+='<div class="pRate">';
						ul+='<div class="lottery_wait">等待开奖</div>';
						ul+='</ul></div>';
			            ul+='<div class="p-bar04 participation" onclick="go_buy();" attr_goodsid="'+data[i].id+'" attr_maxnum="'+data[i].attr_maxnum+'" attr_times="'+data[i]['default_times']+'">立即参与</div>';
						ul+='</div></div></li></ul>';					
				}else{
					var ul='<ul><li>';
						ul+='<span id="'+data[i].id+'" class="z-Limg"><img src="'+webpath+data[i].thumb+'"></span>';
						ul+='<div class="goodsListR">';
						ul+='<a href="'+data[i].good_url+'" class="prolist_name"><h2 id="'+data[i].id+'"><em class="red">【第'+data[i]['qishu']+'期】</em>'+(data[i].title).substr(0,15)+'</h2></a>';
						ul+='<div class="pRate">';
						ul+='<div class="Progress-bar" id="'+data[i].id+'">';				
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
		$("#divGoodsLoading").before(ul);						
	}	
}