<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends CheckHomeBase {
    private $Cartlist;
    private $init_step;
    private $person_enable;
    private $goods_enable;	
	function __construct(){
		parent::__construct();
        $this->Cartlist = _getcookie('Cartlist');
        $this->init_step = 5;
        if($this->userinfo){
            $this->person_enable = $this->userinfo['money'];
        }else{
            $this->person_enable = 0;
        }		
	}	

	//ajax获取商品列表信息
	public function glistajax(){
		$cate_band =htmlspecialchars($this->uri->segment(3));
		$select =htmlspecialchars($this->uri->segment(4));
		$p =htmlspecialchars($this->uri->segment(5)) ? $this->uri->segment(5) :1;
		$arr = array('code' => 400);

		if(!$select){
			$select = '10';
		}
		if($cate_band){
			$fen1 = intval($cate_band);
			$cate_band = 'list';
		}
		$sun_id_str = "'".$fen1."'";
		if($fen1){
			$sun_cate = $this->db->query("SELECT cateid from `go_goods_cat` where `parentid` = '$fen1'")->result_array();
			foreach($sun_cate as $v){
				$sun_id_str .= ","."'".$v['cateid']."'";
			}
		}
		if(empty($fen1)){
			$brand=$this->db->query("select * from `go_goods_brand` where 1 order by `sort` DESC")->result_array();
			$daohang = '所有分类';
		}else{
			$brand=$this->db->query("select * from `go_goods_brand` where `cateid` in ($sun_id_str) order by `sort` DESC")->result_array();
			$daohang=$this->db->query("select * from `go_goods_cat` where `cateid` = '$fen1' order by `sort` DESC")->row_array();
			$daohang = $daohang['name'];
		}
		$category=$this->db->query("select * from `go_goods_cat` where `status` = '0'")->result_array();
		//分页
		$end=10;
		$star=($p-1)*$end;
		$select_w = 'order by is_xy asc,';
		if($select == 10){
			$select_w .= '`shenyurenshu` ASC';
		}
		if($select == 20){
			//$select_w = "and `renqi` = '1'";			//roby 08-06
			$select_w .= '`canyurenshu` DESC';
		}
		if($select == 30){
			$select_w .= '`shenyurenshu` ASC';
		}
		if($select == 40){
			$select_w .= '`updatetime` DESC';
		}
		if($select == 50){
			$select_w .= '`money` DESC';
		}
		if($select == 60){
			$select_w .= '`money` ASC';
		}
		if($fen1){
			$count=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 and `cateid` in ($sun_id_str) $select_w")->result_array();
		}else{
			$count=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 $select_w")->result_array();
		}
		if($fen1){
			$shoplist=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 and `cateid` in ($sun_id_str) $select_w limit $star,$end")->result_array();
		}else{
			$shoplist=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 $select_w limit $star,$end")->result_array();
		}
		$max_renqi_qishu = 1;
		$max_renqi_qishu_id = 1;
		if(!empty($shoplistrenqi)){
			foreach ($shoplistrenqi as $renqikey =>$renqiinfo){
				if($renqiinfo['qishu'] >= $max_renqi_qishu){
					$max_renqi_qishu = $renqiinfo['qishu'];
					$max_renqi_qishu_id = $renqikey;
				}
			}
			$shoplistrenqi[$max_renqi_qishu_id]['t_max_qishu'] = 1;
		}
		$this_time = time();
		if(count($shoplist) > 1){
					if($shoplist[0]['createtime'] > $this_time - 86400*3)
					$shoplist[0]['t_new_goods'] = 1;
		}
		$pagex=ceil(count($count)/$end);
		if($p<=$pagex){
			$shoplist[0]['page']=$p+1;
		}
		if($pagex>0){
			$shoplist[0]['sum']=$pagex;
		}else if($pagex==0){
			$shoplist[0]['sum']=$pagex;
		}
        $Mcartlist=json_decode(stripslashes($this->Cartlist),true);
        if( $shoplist[0]['sum']>0 ){
        	$shoplist = $this->readHtml($shoplist);
	        foreach($shoplist as $a=>$shop){				//此处用于前台计算真正可购买的数量
	        	if($Mcartlist){
		            foreach($Mcartlist as $k => $row){
		                if($shop['id'] == $k){
		                	/*
		                	if($shop['shenyurenshu'] - $row['num']>=0){
		                		$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'] - $row['num'];
		                	}else{
		                		$shoplist[$a]['attr_maxnum'] = 0;
		                	}
		                	*/
		                	$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'] - $row['num'];
		                    
		                }else{
		                	$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'];
		                }
		            }	        		
	        	}else{
	        		$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'];
	        	}
	        }        	
        }
        //print_r($shoplist);exit;
		echo json_encode($shoplist);
	}
	
	//ajax获取商品列表信息
	public function glistbrandajax(){
		$cate_band =htmlspecialchars($this->uri->segment(3));
		$select =htmlspecialchars($this->uri->segment(4));
		$p =htmlspecialchars($this->uri->segment(5)) ? $this->uri->segment(5) :1;
		$arr = array('code' => 400);

		if(!$select){
			$select = '10';
		}
		if($cate_band){
			$fen1 = intval($cate_band);
			$cate_band = 'list';
		}
		//分页
		$end=10;
		$star=($p-1)*$end;
		if($fen1){
			$count=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 and brandid='".$fen1."'")->result_array();
		}else{
			$count=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0")->result_array();
		}
		if($fen1){
			$shoplist=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 and brandid='".$fen1."' order by is_xy asc limit $star,$end")->result_array();
		}else{
			$shoplist=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 order by is_xy limit $star,$end")->result_array();
		}
		$max_renqi_qishu = 1;
		$max_renqi_qishu_id = 1;
		if(!empty($shoplistrenqi)){
			foreach ($shoplistrenqi as $renqikey =>$renqiinfo){
				if($renqiinfo['qishu'] >= $max_renqi_qishu){
					$max_renqi_qishu = $renqiinfo['qishu'];
					$max_renqi_qishu_id = $renqikey;
				}
			}
			$shoplistrenqi[$max_renqi_qishu_id]['t_max_qishu'] = 1;
		}
		$this_time = time();
		if(count($shoplist) > 1){
					if($shoplist[0]['createtime'] > $this_time - 86400*3)
					$shoplist[0]['t_new_goods'] = 1;
		}
		$pagex=ceil(count($count)/$end);
		if($p<=$pagex){
			$shoplist[0]['page']=$p+1;
		}
		if($pagex>0){
			$shoplist[0]['sum']=$pagex;
		}else if($pagex==0){
			$shoplist[0]['sum']=$pagex;
		}
		
        $Mcartlist=json_decode(stripslashes($this->Cartlist),true);
        if( $shoplist[0]['sum']>0 ){
	        foreach($shoplist as $a=>$shop){
	        	if($Mcartlist){
		            foreach($Mcartlist as $k => $row){
		                if($shop['id'] == $k){
		                    $shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'] - $row['num'];
		                }else{
		                	$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'];
		                }
		            }	        		
	        	}
	        } 
	        $shoplist = $this->readHtml($shoplist);       	
        }
        //print_r($shoplist);exit;
		echo json_encode($shoplist);
	}
	public function jiejiaoajax(){
		$type =htmlspecialchars($this->uri->segment(3));
		$sid_where = '';
		if($type=='soon'){
			$p =htmlspecialchars($this->uri->segment(4)) ? $this->uri->segment(4) :1;
		}
		if($type=='before'){		//往期揭晓
			$sid =htmlspecialchars($this->uri->segment(4));
			$p =htmlspecialchars($this->uri->segment(5)) ? $this->uri->segment(5) :1;
			if($sid){
				$sid_where = ' and sid='.$sid;			
			}
			
		}
		$arr = array('code' => 400);		
		$end=10;
		$star=($p-1)*$end;		
		switch($type){
			case 'soon':	//即将揭晓
			$count=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 and is_xy=0 and (shenyurenshu=0 or xsjx_time!=0 or shenyurenshu<10) order by shenyurenshu asc")->result_array();
			$shoplist=$this->db->query("select * from `go_goods` where `q_uid`='0' and status=0 and is_xy=0 and (shenyurenshu=0 or xsjx_time!=0 or shenyurenshu<10) order by shenyurenshu asc limit $star,$end")->result_array();			
			$now_time = time();

			break;
			case 'before':	//往期揭晓
			$count=$this->db->query("select * from `go_goods` where `q_uid`!='0' $sid_where and status=0  order by q_end_time desc")->result_array();
			$shoplist=$this->db->query("select * from `go_goods` where `q_uid`!='0' $sid_where and status=0  order by q_end_time desc limit $star,$end")->result_array();						
			foreach($shoplist as $key=>$val){
				$recodeinfo=$this->db->query("select sum(gonumber) as gonumber from `go_member_go_record` where `uid` ='$val[q_uid]'  and `shopid`='$val[id]' ")->row_array();
				$shoplist[$key]['gonumber']=$recodeinfo['gonumber'];
			}
			break;
		}
		$pagex=ceil(count($shoplist)/$end);
		if($p<=$pagex){
			$shoplist[0]['page']=$p+1;
		}
		if($pagex>0){
			$shoplist[0]['sum']=$pagex;
		}else if($pagex==0){
			$shoplist[0]['sum']=$pagex;
		}
        $Mcartlist=json_decode(stripslashes($this->Cartlist),true);
        if( $shoplist[0]['sum']>0 ){
	        foreach($shoplist as $a=>$shop){
	        	if($Mcartlist){
		            foreach($Mcartlist as $k => $row){
		                if($shop['id'] == $k){
		                    $shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'] - $row['num'];
		                }else{
		                	$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'];
		                }
		            }	        		
	        	}
	        }
	        $shoplist = $this->readHtml($shoplist);        	
        }
        
        //print_r($shoplist);exit;
		echo json_encode($shoplist);     		
		
	}
	//添加心愿
	public function myxyajax(){
		$gid = safe_replace($this->uri->segment(3));
		$sid = safe_replace($this->uri->segment(4));
		$nowtime = time();
		//do 判断是否24小时内添加过，是否登录
		$data['code'] = 200;
		if($this->userinfo){		//已登录
			$now_xinyuan = 1;
			$row = $this->getRow('go_xy',"q_uid='".$this->userinfo['uid']."' and good_id='".$gid."' and sid='".$sid."' order by updatetime desc");		//获取最近一条记录

			//php获取今日开始时间戳和结束时间戳
			$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
			$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;			
			if($row){
				//if(strtotime($row['updatetime']) > $nowtime-24*3600){			//未超过二十四小时
				if(strtotime($row['updatetime']) > $beginToday){				//上一条留言时间上于今天起始时间
					$data['code'] = 400;
					$data['msg'] = '一天之内只能许愿一次噢!';
					exit(json_encode($data)); 		
				}
				$now_xinyuan = $row['xinyuan']+1;
				$flag = $this->db->Query("update `go_xy` SET `xinyuan` = '$now_xinyuan' where `id` = '".$row['id']."'");				
			}else{
				$d= array(
					'good_id'=> $gid,
					'sid' => $sid,
					'q_uid' => $this->userinfo['uid'],
					'xinyuan' => $now_xinyuan
				);
				$flag = $this->db->insert('go_xy', $d);
			}
			$this->db->Query("update `go_goods` SET  `xinyuan` = (xinyuan+1) where `id` = '".$gid."'");
			if(!$flag){
				$data['code'] = 403; 	//插入或更新错误 
				$data['msg'] = '插入或更新错误';
 			}			
		}else{						//未登录
			$data['code'] = 402;
			$data['msg'] = '登录后才能加入心愿';		
		}
		exit(json_encode($data));
	}
	//某商品购买记录
	public function getGoodBuyList(){
		$good_id =intval($this->uri->segment(3)) ? $this->uri->segment(3) :1;
		if($good_id){
		$p =htmlspecialchars($this->uri->segment(4)) ? $this->uri->segment(4) :1;
		$arr = array('code' => 400);		
		$end=10;
		$star=($p-1)*$end;		
		$count=$this->db->query("select b.*,a.gonumber from `go_member_go_record` a left join `go_goods` b on a.shopid=b.id where a.shopid='$good_id' order by a.time desc")->result_array();
		$shoplist=$this->db->query("select b.*,a.gonumber,a.uid,a.goucode,a.username,a.time as btime from `go_member_go_record` a left join `go_goods` b on a.shopid=b.id where a.shopid='$good_id' order by a.time desc, a.id desc limit $star,$end")->result_array();						

		$pagex=ceil(count($count)/$end);
		if($p<=$pagex){
			$shoplist[0]['page']=$p+1;
		}
		if($pagex>0){
			$shoplist[0]['sum']=$pagex;
		}else if($pagex==0){
			$shoplist[0]['sum']=$pagex;
		}
        $Mcartlist=json_decode(stripslashes($this->Cartlist),true);
        if( $shoplist[0]['sum']>0 ){
	        foreach($shoplist as $a=>$shop){
	        	$goucode = explode(',',$shop['goucode']);
	        	if(count($goucode)>1){
	        		$shoplist[$a]['code_duan'] = $goucode[0].'-'.end($goucode);
	        	}else{
	        		$shoplist[$a]['code_duan'] = $goucode[0];
	        	}
	        	$member = $this->getRow('go_member',"uid='".$shop['uid']."'");
	        	$shoplist[$a]['uphoto'] = $member['img'];
	        	$shoplist[$a]['ip'] = $member['user_ip'];
	        	if($Mcartlist){
		            foreach($Mcartlist as $k => $row){
		                if($shop['id'] == $k){
		                    $shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'] - $row['num'];
		                }else{
		                	$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'];
		                }
		            }	        		
	        	}
	        }        	
        }
        //$shoplist = $this->readHtml($shoplist);
		echo json_encode($shoplist);			
		}
		
	}
	//我的购买记录
	public function getUserBuyList(){
		$member = $this->userinfo;
		$p =htmlspecialchars($this->uri->segment(3)) ? $this->uri->segment(3) :1;
		$arr = array('code' => 400);		
		$end=10;
		$star=($p-1)*$end;		
		$count=$this->db->query("select b.*,sum(a.gonumber) as gonumber,a.uid from `go_member_go_record` a left join `go_goods` b on a.shopid=b.id where a.uid='$member[uid]' GROUP BY b.id order by a.time desc")->result_array();
		$shoplist=$this->db->query("select b.*,sum(a.gonumber) as gonumber,a.uid from `go_member_go_record` a left join `go_goods` b on a.shopid=b.id where a.uid='$member[uid]' GROUP BY b.id order by a.time desc limit $star,$end")->result_array();						


		$pagex=ceil(count($count)/$end);
		if($p<=$pagex){
			$shoplist[0]['page']=$p+1;
		}
		if($pagex>0){
			$shoplist[0]['sum']=$pagex;
		}else if($pagex==0){
			$shoplist[0]['sum']=$pagex;
		}
        $Mcartlist=json_decode(stripslashes($this->Cartlist),true);
        if( $shoplist[0]['sum']>0 ){
	        foreach($shoplist as $a=>$shop){
	        	$shoplist[$a]['good_url'] = G_WEB_PATH.'/index/info/'.$shop['id'];
	        	if($Mcartlist){
		            foreach($Mcartlist as $k => $row){
		                if($shop['id'] == $k){
		                    $shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'] - $row['num'];
		                }else{
		                	$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'];
		                }
		            }	        		
	        	}
	        }        	
        }
		echo json_encode($shoplist);

	}	
	//获得的商品
	public function getOrderList(){
		$member = $this->userinfo;
		$p =htmlspecialchars($this->uri->segment(3)) ? $this->uri->segment(3) :1;
		$arr = array('code' => 400);		
		$end=10;
		$star=($p-1)*$end;		
		$count=$this->db->query("select *,sum(gonumber) as gonumber from `go_member_go_record` a left join `go_goods` b on a.shopid=b.id where b.q_uid='$member[uid]' and a.uid='$member[uid]' GROUP BY b.id ")->result_array();
		$shoplist=$this->db->query("select *,sum(gonumber) as gonumber from `go_member_go_record` a left join `go_goods` b on a.shopid=b.id where  b.q_uid='$member[uid]' and a.uid='$member[uid]' GROUP BY b.id limit $star,$end")->result_array();						


		$pagex=ceil(count($count)/$end);
		if($p<=$pagex){
			$shoplist[0]['page']=$p+1;
		}
		if($pagex>0){
			$shoplist[0]['sum']=$pagex;
		}else if($pagex==0){
			$shoplist[0]['sum']=$pagex;
		}
        $Mcartlist=json_decode(stripslashes($this->Cartlist),true);
        if( $shoplist[0]['sum']>0 ){
	        foreach($shoplist as $a=>$shop){
	        	if($Mcartlist){
		            foreach($Mcartlist as $k => $row){
		                if($shop['id'] == $k){
		                    $shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'] - $row['num'];
		                }else{
		                	$shoplist[$a]['attr_maxnum'] = $shop['shenyurenshu'];
		                }
		            }	        		
	        	}
	        }
	        $shoplist = $this->readHtml($shoplist);        	
        }        
		echo json_encode($shoplist);

	}
	//获取我的心愿商品
	public function getXyAjax(){
		$p =intval($this->uri->segment(5)) ? $this->uri->segment(5) :1;
		$uid = $this->userinfo['uid'];
		$end=10;
		$star=($p-1)*$end;		
		$count=$this->db->query("select * from `go_xy` as x left join go_goods as g on x.good_id=g.id where x.`q_uid`='$uid' and g.is_xy=1 order by x.updatetime desc")->result_array();
		$shoplist=$this->db->query("select g.*,x.xinyuan as xyed from `go_xy` as x left join go_goods as g on x.good_id=g.id and g.is_xy=1 where x.`q_uid`='$uid' order by x.updatetime desc limit $star,$end")->result_array();			
		$pagex=ceil(count($count)/$end);
		if($p<=$pagex){
			$shoplist[0]['page']=$p+1;
		}
		if($pagex>0){
			$shoplist[0]['sum']=$pagex;
		}else if($pagex==0){
			$shoplist[0]['sum']=$pagex;
		}
		if( $shoplist[0]['sum']>0 ){
			$shoplist = $this->readHtml($shoplist);
		}
		echo json_encode($shoplist);     		
		
	}
	//获取全部留言
	public function getMessage(){
		$good_id  = intval($this->uri->segment(3));
		$data = array(
			'good_id'=>$good_id
		);
		$p =intval($this->uri->segment(4)) ? $this->uri->segment(4) :1;
		if($good_id){
			$end=1;
			$star=($p-1)*$end;		
			$count=$this->db->query("select * from `go_goods_comment` as c left join go_member as m ON c.q_uid=m.uid where c.good_id='".$good_id."' and c.status=0 order by c.updatetime desc")->result_array();
			$shoplist=$this->db->query("select * from `go_goods_comment` as c left join go_member as m ON c.q_uid=m.uid where c.good_id='".$good_id."' and c.status=0 order by c.updatetime desc limit $star,$end")->result_array();			
			$pagex=ceil(count($count)/$end);
			if($p<=$pagex){
				$shoplist[0]['page']=$p+1;
			}
			if($pagex>0){
				$shoplist[0]['sum']=$pagex;
			}else if($pagex==0){
				$shoplist[0]['sum']=$pagex;
			}
			foreach($shoplist as $k=>$row){
				$user = $this->getRow("go_member","uid='".$row['q_uid']."'","uid,img");
				$shoplist[$k]['user'] = $this->get_user_name($row['q_uid']);
				$shoplist[$k]['thumb'] = G_WEB_PATH.'/'.$user['img'];
			}
			echo json_encode($shoplist);     		
			
		}
		
		
	}	
		
				
				
}
