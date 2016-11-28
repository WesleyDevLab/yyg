<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopajax extends CheckHomeBase {
	private $Mcartlist;
	function __construct()
	{
		parent::__construct();
		$Mcartlist=_getcookie("Cartlist");
		$this->Mcartlist=json_decode(stripslashes($Mcartlist),true);		
	}	
	//获取晒单
	public function getUserPostList(){
	   $FIdx=safe_replace($this->uri->segment(4));
	   $EIdx=10;//safe_replace($this->segment(5));

	   $member=$this->userinfo;
	   $post=$this->db->query("select * from `go_shaidan` a left join `go_goods` b on a.sd_shopid=b.id where a.sd_userid='$member[uid]' order by a.sd_time desc" )->result_array();

	   $postlist['listItems']=$this->db->query("select * from `go_shaidan` a left join `go_goods` b on a.sd_shopid=b.id where a.sd_userid='$member[uid]' order by a.sd_time desc limit $FIdx,$EIdx" )->result_array();

		if(empty($postlist['listItems'])){
		  $postlist['code']=1;
		}else{

		  foreach($postlist['listItems'] as $key=>$val){
	        $postlist['listItems'][$key]['sd_time']=date('Y-m-d H:i',$val['sd_time']);
	      }

		   $postlist['code']=0;
		}
		$postlist['postCount']=count($post);

	    echo json_encode($postlist);
	}
	//获取未晒单
	public function getUserUnPostList(){
	   $FIdx=safe_replace($this->uri->segment(4));
	   $EIdx=10;//safe_replace($this->segment(5));

	   $member=$this->userinfo;
	    //获得的商品
	    $orderlist=$this->db->query("select * from `go_member_go_record` a left join `go_goods` b on a.shopid=b.id where b.q_uid='$member[uid]' order by a.time desc" )->result_array();

		//获取晒单
		$postlist=$this->db->GetList("select * from `go_shaidan` a left join `go_goods` b on a.sd_shopid=b.id where a.sd_userid='$member[uid]' order by a.sd_time desc" )->result_array();
		$huoid='';

		$sd_id = $r_id = array();
		foreach($postlist as $sd){
			$sd_id[]=$sd['sd_shopid'];
		}

		foreach($orderlist as $rd){
			if(!in_array($rd['shopid'],$sd_id)){
				$r_id[]=$rd['shopid'];
			}
		}
		if(!empty($r_id)){
			$rd_id=implode(",",$r_id);
			$rd_id = trim($rd_id,',');
		}else{
			$rd_id="0";
		}

		//未晒单
	   $unpost=$this->db->query("select * from  `@#_shoplist`  where id in($rd_id) order by id" )->result_array();

	   $unpostlist['listItems']=$this->db->query("select * from  `go_goods`  where id in($rd_id) order by id limit  $FIdx, $EIdx" );

		if(empty($unpostlist['listItems'])){
		   $unpostlist['code']=1;
		}else{
		  foreach($unpostlist['listItems'] as $key=>$val){
	        $unpostlist['listItems'][$key]['q_end_time']=microt($val['q_end_time']);
	      }
		   $unpostlist['code']=0;
		}
	    $unpostlist['unPostCount']=count($unpost);

	  echo json_encode($unpostlist);

	}
	//充值记录
	public function getUserRecharge(){
	   $member=$this->userinfo;

	   $FIdx=safe_replace($this->uri->segment(3));
	   $EIdx=10;//safe_replace($this->segment(5));

	    $Rechargelist=$this->db->query("select * from `go_member_account` where `uid`='$member[uid]' and `pay` = '账户' and `type`='1'  ORDER BY time DESC")->result_array();

	    $Recharge['listItems']=$this->db->query("select * from `go_member_account` where `uid`='$member[uid]' and `pay` = '账户' and `type`='1'  ORDER BY time DESC limit $FIdx,$EIdx ")->result_array();

        if(empty($Recharge['listItems'])){
		    $Recharge['code']=1;
		}else{
		  foreach($Recharge['listItems'] as $key=>$val){
		    $Recharge['listItems'][$key]['time']=date("Y-m-d H:i:s",$val['time']);
		  }
		    $Recharge['code']=0;
		}
 		$Recharge['count']=count($Rechargelist);

		echo json_encode($Recharge);

	}	
	//消费记录
	public function getUserConsumption(){
	   $member=$this->userinfo;
	   $FIdx=safe_replace($this->uri->segment(3));
	   $EIdx=10;//safe_replace($this->segment(5));

	   $Consumptionlist=$this->db->query("select * from `go_member_account` where `uid`='$member[uid]' and `pay` = '账户' and `type`='-1' ")->result_array();

	   $Consumption['listItems']=$this->db->query("select * from `go_member_account` where `uid`='$member[uid]' and `pay` = '账户' and `type`='-1'  ORDER BY time DESC limit $FIdx,$EIdx ")->result_array();
        if(empty($Consumption['listItems'])){
		    $Consumption['code']=1;
		}else{

		  foreach($Consumption['listItems'] as $key=>$val){
		    $Consumption['listItems'][$key]['time']=date("Y-m-d H:i:s",$val['time']);
		  }
		    $Consumption['code']=0;
		}
 		$Consumption['count']=count($Consumptionlist);

		echo json_encode($Consumption);

	}	
		
		
}
