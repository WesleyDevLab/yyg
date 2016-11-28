<?php
class Buy extends CI_Model {
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
    }
	//生成订单号
	function pay_get_dingdan_code($dingdanzhui=''){
		return $dingdanzhui.time().substr(microtime(),2,6).rand(0,9);
	}
	//处理cookie
	public function getCookieGoods(){
		$cookie = _getcookie('Cartlist');
		if($cookie){
			$Cartlist=json_decode(stripslashes($cookie),true);
			$shopids='';			//商品ID
			if(is_array($Cartlist)){
				foreach($Cartlist as $key => $val){
					$shopids.=intval($key).',';
				}
				$shopids=str_replace(',0','',$shopids);
				$shopids=trim($shopids,',');	
			}	
			$shoplist=array();		//商品信息
			if($shopids!=NULL){
				$shoplist=$this->db->query("SELECT * FROM `go_goods` where `id` in($shopids) and `q_uid`=0")->result_array();
				foreach($shoplist as $k=>$shop){					
					$shoplist[$shop['id']] = $shop;
					unset($shoplist[$k]);
				}
				return $shoplist;
			}		
		}
		return false;
	}
	//购买商品
	public function go_record(){
		$this->db->trans_start();
		
	} 
	//生成购买码
	public function pay_get_shop_codes($gid,$k){	
		$good = $this->db->query("select qishu from go_goods where id='".$gid."'")->row_array();		//商品记录
		$cate_bm = sprintf("%04d", $good['qishu']);
		$buys = $this->db->query("select gonumber from go_member_go_record where shopid='".$gid."'")->result_array();
		$num = 0;
		if(count($buys)>0){
			foreach($buys as $buy){
				$num += $buy['gonumber'];
			}
		}
		$num +=$k;
		$good_bm = sprintf("%04d", ($num+1));
	
		$nownum = $cate_bm.$good_bm;
		return $nownum;
	}	  



}