<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*购物页面*/
class Cart extends CheckHomeBase {
	private $Cartlist;
    private $init_step;
    private $person_enable;
    private $goods_enable;	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->Cartlist = _getcookie('Cartlist');
        $this->init_step = 5;
        if($this->userinfo){
            $this->person_enable = $this->userinfo['money'];
        }else{
            redirect(G_WEB_PATH.'/user/login');
        }       						
	}		
	//购物车商品列表
	public function cartlist(){
		$data['init_step'] = $this->init_step;
		$data['Cartlist'] = $this->Cartlist;
		$data['person_enable'] = $this->person_enable;
		$data['curr'] = 'cart';
		$Mcartlist=json_decode(stripslashes($this->Cartlist),true);
		$shopids='';
		if(is_array($Mcartlist)){
			foreach($Mcartlist as $key => $val){
				$shopids.=intval($key).',';
			}
			$shopids=str_replace(',0','',$shopids);
			$shopids=trim($shopids,',');

		}
		//echo $shopids;
		$shoplist=array();
		if($shopids!=NULL){
			$shoparr=$this->db->query("SELECT * FROM `go_goods` where `id` in($shopids)")->result_array();
		}
		if(!empty($shoparr)){
		  foreach($shoparr as $key=>$val){
		    if($val['q_end_time']=='' || $val['q_end_time']==NULL){
			   $shoplist[$key]=$val;
			   $Mcartlist[$val['id']]['num']=$Mcartlist[$val['id']]['num'];
			   $Mcartlist[$val['id']]['shenyu']=$val['shenyurenshu'];
			   $Mcartlist[$val['id']]['money']=$val['yunjiage'];

			}
		  }
		  _setcookie('Cartlist',json_encode($Mcartlist),'');
		}
		$MoenyCount=0;
		$Cartshopinfo='{';
		if(count($shoplist)>=1){
			foreach($Mcartlist as $key => $val){
					$key=intval($key);
					if(isset($shoplist[$key])){
						$shoplist[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;
						$MoenyCount+=$shoplist[$key]['yunjiage']*$shoplist[$key]['cart_gorenci'];
						$shoplist[$key]['cart_xiaoji']=substr(sprintf("%.3f",$shoplist[$key]['yunjiage']*$val['num']),0,-1);
						$shoplist[$key]['cart_shenyu']=$shoplist[$key]['zongrenshu']-$shoplist[$key]['canyurenshu'];
						$Cartshopinfo.="'$key':{'shenyu':".$shoplist[$key]['cart_shenyu'].",'num':".$val['num'].",'money':".$shoplist[$key]['yunjiage']."},";
					}
			}
		}
		$shop=0;

		if(!empty($shoplist)){
		   $shop=1;
		}
		$data['shop'] = $shop;
		$data['shoplist'] = $this->readHtml($shoplist); 
		$data['Mcartlist'] = $Mcartlist;
		$MoenyCount=substr(sprintf("%.3f",$MoenyCount),0,-1);
		$Cartshopinfo.="'MoenyCount':$MoenyCount}";
		$this->load->view('cart/cartlist',$data);
	}
	//支付界面
	public function pay(){
		$member = $this->userinfo;
		$Mcartlist=json_decode(stripslashes($this->Cartlist),true);
		$shopids='';
		if(is_array($Mcartlist)){
			foreach($Mcartlist as $key => $val){
				$shopids.=intval($key).',';
			}
			$shopids=str_replace(',0','',$shopids);
			$shopids=trim($shopids,',');

		}

		$shoplist=array();
		if($shopids!=NULL){
			$shoplist=$this->db->query("SELECT * FROM `go_goods` where `id` in($shopids)")->result_array();
		}
		foreach($shoplist as $k=>$row){
			unset($shoplist[$k]);
			$shoplist[$row['id']] = $row;
		}
		$MoenyCount=0;
		if(count($shoplist)>=1){
			foreach($Mcartlist as $key => $val){
					$key=intval($key);
					if(isset($shoplist[$key])){
						$shoplist[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;
						$MoenyCount+=$shoplist[$key]['yunjiage']*$shoplist[$key]['cart_gorenci'];
						$shoplist[$key]['cart_xiaoji']=substr(sprintf("%.3f",$shoplist[$key]['yunjiage']*$val['num']),0,-1);
						$shoplist[$key]['cart_shenyu']=$shoplist[$key]['zongrenshu']-$shoplist[$key]['canyurenshu'];
						$ten_per = floor($shoplist[$key]['zongrenshu']/1) > 0 ? floor($shoplist[$key]['zongrenshu']/1) : 1;
						$max = $ten_per > $shoplist[$key]['cart_shenyu'] ? $shoplist[$key]['cart_shenyu'] : $ten_per;
						if($val['num'] > $max){
							$this->_mobileMsg($shoplist[$key]['title']."购买数量不能大于".$max,G_WEB_PATH.'/cart/cartlist');
							return false;
						}
					}
			}
			$shopnum=0;  //表示有商品
		}else{
			_setcookie('Cartlist',NULL);
			//_messagemobile("购物车没有商品!",WEB_PATH);
			$shopnum=1; //表示没有商品
		}
		// 总支付价格
		$MoenyCount = substr ( sprintf ( "%.3f", $MoenyCount ), 0, - 1 );
		// 会员余额
		$Money = $member ['money'];
		// 商品数量
		$shoplen = count ( $shoplist );
		
		$fufen_dikou = 0;
		
		$paylist = $this->db->query("SELECT * FROM `go_pay` where `pay_start` = '1' AND pay_mobile = 1")->result_array();
		
		$this->load->driver('cache');
		$submitcode = uniqid ();
		$this->cache->memcached->save('submitcode', $submitcode);
		$data['curr'] = 'cart';
		$data['shoplist'] = $this->readHtml($shoplist);
		$data['MoenyCount'] = $MoenyCount;
		$data['Money'] = $Money;
		$data['member'] = $member;
		$data['shopnum'] = $shopnum;
		$data['fufen_dikou'] = $fufen_dikou;
		$data['submitcode'] = $submitcode;
		$this->load->view('cart/payment',$data);
		$this->load->view('layout/footer');		  
	
	}
	// 开始支付
	public function paysubmit() {
		header ( "Cache-control: private" );
		$checkpay = $this->uri->segment(3); 		// 获取支付方式 fufen money bank
		$banktype = $this->uri->segment( 4 ); 		// 获取选择的银行 CMBCHINA ICBC CCB
		$money = $this->uri->segment( 5 ); 			// 获取需支付金额
		$fufen = $this->uri->segment( 6 ); 			// 获取淘豆
		$submitcode1 = $this->uri->segment ( 7 ); 	// 获取SESSION
		
		$uid = $this->userinfo ['uid'];

		$this->load->driver('cache');
		$submitcode = $this->cache->memcached->get('submitcode');		
		if (!empty ( $submitcode1 )) {
			if (isset ( $submitcode )) {
				$submitcode2 = $submitcode;
			} else {
				$submitcode2 = null;
			}		
			if ($submitcode1 == $submitcode2) {
				$this->cache->memcached->save('submitcode',null);
			} else {
			  $WEB_PATH = G_WEB_PATH;
			  $this->_mobileMsg( "请不要重复提交...<a href='{$WEB_PATH}/cart/cartlist' style='color:#22AAFF'>返回购物车</a>查看" );
			  return false;
			}
		}
		$this->load->model('buy');
		$this->db->trans_start();
		//购买次数
		$Cartlist=json_decode(stripslashes($this->Cartlist),true);
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
			$shoplist=$this->db->query("SELECT * FROM `go_goods` where `id` in($shopids) and `q_uid`=0 ")->result_array();
			foreach($shoplist as $k=>$shop){					
				$shoplist[$shop['id']] = $shop;
				unset($shoplist[$k]);
			}		
		}else{
			$this->db->trans_rollback();
			$this->_mobileMsg('购物车内没有商品!');
			return false;
		}
		$MoenyCount= 0;
		if(count($shoplist)>=1){
			foreach($Cartlist as $key => $val){
				$key=intval($key);
				if(isset($shoplist[$key]) && $shoplist[$key]['shenyurenshu'] != 0){
					$shoplist[$key]['cart_gorenci']=$val['num'] ? $val['num'] : 1;
					$shoplist[$key]['cart_xiaoji']=substr(sprintf("%.3f",$shoplist[$key]['yunjiage'] * $shoplist[$key]['cart_gorenci']),0,-1);
					$shoplist[$key]['cart_shenyu']=$shoplist[$key]['zongrenshu']-$shoplist[$key]['canyurenshu'];
					$MoenyCount+=$shoplist[$key]['yunjiage']*$shoplist[$key]['cart_gorenci'];
										
					if($shoplist[$key]['cart_gorenci'] >= $shoplist[$key]['shenyurenshu']){
						$shoplist[$key]['cart_gorenci'] = $shoplist[$key]['shenyurenshu'];
					}
					//循环生成购买码
					$buy_code_arr = array();
					for($i=0;$i<$shoplist[$key]['cart_gorenci'];$i++){
						$buy_code_arr[$i] = $this->buy->pay_get_shop_codes($shoplist[$key]['id'],$i);
					}
					$goucode = implode(',',$buy_code_arr);

					$ordersn = $this->buy->pay_get_dingdan_code('A');
					$ip = _get_ip_dizhi();
					$time = time();
					$data = array(
						'code' => $ordersn,
						'username' => $this->get_user_name($this->userinfo['uid']),
						'uphoto' => $this->userinfo['img'],
						'uid' => $this->userinfo['uid'],
						'shopid' => $shoplist[$key]['id'],
						'shopname' => $shoplist[$key]['title'],
						'shopqishu' => $shoplist[$key]['qishu'],
						'gonumber'=> $shoplist[$key]['cart_gorenci'],
						'goucode' => $goucode,
						'moneycount'=>$shoplist[$key]['cart_xiaoji'],
						'pay_type' => '账户',
						'ip' => $ip,
						'status' => '已付款,未发货,未完成',
						'time' => $time						
					);
					$flag = $this->db->insert('go_member_go_record', $data);
					if(!$flag){
						$this->db->trans_rollback();
						$this->_mobileMsg('插入购买记录失败!');
						return false;
					}
					$nowcanyu = $shoplist[$key]['canyurenshu'] + $shoplist[$key]['cart_gorenci'];	//目前参与人次
					$nowshenyu = $shoplist[$key]['shenyurenshu']-$shoplist[$key]['cart_gorenci'];
					$flag2 = $this->db->Query("update `go_goods` SET `canyurenshu` = '$nowcanyu',`shenyurenshu`='$nowshenyu'  where `id` = '".$shoplist[$key]['id']."'");
					if(!$flag2){
						$this->db->trans_rollback();
						$this->_mobileMsg('商品记录更新失败!');
						return false;
					}						
					//购买完了，如果非限时购买商品则须再开一期  移到开奖时生成
					/*
					if($nowshenyu ==0 && $shoplist[$key]['qishu']<MAXQISHU && $shoplist[$key]['xsjx_time'] == 0){
						$data2 = array(
							'sid' => $shoplist[$key]['sid'],
							'cateid' => $shoplist[$key]['cateid'],
							'brandid' => $shoplist[$key]['brandid'],
							'title' => $shoplist[$key]['title'],
							'title2' => $shoplist[$key]['title2'],
							'keywords' => $shoplist[$key]['keywords'],
							'description' => $shoplist[$key]['description'],
							'money' => $shoplist[$key]['money'],
							'yunjiage' => $shoplist[$key]['yunjiage'],
							'default_times' => $shoplist[$key]['default_times'],
							'zongrenshu' => $shoplist[$key]['zongrenshu'],
							'canyurenshu' => 0,												//改
							'shenyurenshu' => $shoplist[$key]['zongrenshu'],				//改
							'qishu' => $shoplist[$key]['qishu']+1,							//改
							'maxqishu' => $shoplist[$key]['maxqishu'],
							'thumb' => $shoplist[$key]['thumb'],
							'picarr' => $shoplist[$key]['picarr'],
							'content' => $shoplist[$key]['content'],
							'codes_table'=> $shoplist[$key]['codes_table'],
							'pos' => $shoplist[$key]['pos'],
							'renqi' => $shoplist[$key]['renqi'],
							'hot' => $shoplist[$key]['hot'],
							'order' => $shoplist[$key]['order'],
							'createtime' => date('Y-m-d H:i:s'),
						);
						$flag4 =  $this->db->insert('go_goods', $data2);
						if(!$flag4){
							$this->db->trans_rollback();
							$this->_mobileMsg('重新生成一期商品失败!');
							return false;
						}						
					}
					*/
					
								
				}else{
					unset($shoplist[$key]);
				}
			}
			if(count($shoplist) < 1){
				$this->db->trans_rollback();
				$this->_mobileMsg('购物车内没有商品!');
				return false;
			}
			//插入消费记录
			$data3 = array(
				'uid' => $this->userinfo['uid'],
				'type' => '-1',
				'pay' => '账户',
				'content' => '购买商品',
				'money' => $MoenyCount,
				'time' => $time
			);
			$flag3 =  $this->db->insert('go_member_account', $data3);
			if(!$flag3){
				$this->db->trans_rollback();
				$this->_mobileMsg('商品消费记录更新失败!');
				return false;
			}			
		}else{
			$this->db->trans_rollback();
			$this->_mobileMsg('购物车里商品已经卖完或已下架!');
			return false;
		}
		//更新个人钱包
		$now_money = $this->userinfo['money']-$MoenyCount;
		$flag3 = $this->db->Query("update `go_member` SET `money` = '$now_money' where `uid` = '$uid'");
		if(!$flag3){
			$this->db->trans_rollback();
			$this->_mobileMsg('个人信息未同步更新!');
			return false;
		}		
		$this->db->trans_commit();
		header( "location: " . G_WEB_PATH . "/cart/paysuccess" );
		
	}
	//购买成功页面
	public function paysuccess(){
		_setcookie('Cartlist',NULL);
		$data['curr'] = 'cart';
		$this->load->view('cart/paysuccess',$data);
		$this->load->view('layout/footer2');		  
	}	
	//用户充值
	public function userrecharge(){
		$member=$this->userinfo;

		$data['title']="账户充值";
		$data['curr'] = 'home';

		$data['paylist'] = $this->db->query("SELECT * FROM `go_pay` where `pay_start` = '1' AND pay_mobile = 1")->result_array();
		$this->load->view('cart/recharge',$data);
		$this->load->view('layout/footer');			
	}
	//充值动作：跳转到网银支付
	public function addmoney(){
		header ('Content-type:text/html;charset=utf-8');
		include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_b2c/sdk/acp_service.php';	
		
		$this->load->model('buy');
		$ordersn = $this->buy->pay_get_dingdan_code('C');
		$money = intval($this->uri->segment(3))*100;		//金额
		//$money = 1;
		
		//产品：跳转网关支付产品<br>		
		$params = array(
			//以下信息非特殊情况不需要改动
			'version' => '5.0.0',                 //版本号
			'encoding' => 'utf-8',				  //编码方式
			'txnType' => '01',				      //交易类型
			'txnSubType' => '01',				  //交易子类
			'bizType' => '000201',				  //业务类型
			'frontUrl' =>  com\unionpay\acp\sdk\SDK_FRONT_NOTIFY_URL,  //前台通知地址
			'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL,	  //后台通知地址
			'signMethod' => '01',	              //签名方法
			'channelType' => '08',	              //渠道类型，07-PC，08-手机
			'accessType' => '0',		          //接入类型
			'currencyCode' => '156',	          //交易币种，境内商户固定156
			
			//TODO 以下信息需要填写
			'merId' => MECHETID,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
			'orderId' => $ordersn,	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
			'txnTime' => date('YmdHis'),	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
			'txnAmt' => $money,	//交易金额，单位分，此处默认取demo演示页面传递的参数
			'reqReserved' =>$this->userinfo ['uid'],        //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
		);
		
		com\unionpay\acp\sdk\AcpService::sign ( $params );
		$uri = com\unionpay\acp\sdk\SDK_FRONT_TRANS_URL;
		$html_form = com\unionpay\acp\sdk\AcpService::createAutoFormHtml( $params, $uri );
		echo $html_form;			
	}
	//商户前台通知界面
	public function front(){
		header ('Content-type:text/html;charset=utf-8');
		include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_b2c/sdk/acp_service.php';
		if (isset ( $_POST ['signature'] )) {			
				//$flag = com\unionpay\acp\sdk\AcpService::validate ( $_POST );
				if($_POST ['respCode']=='00' || $_POST ['respCode']=='A6'){		//验签通过并支付成功验签通过并支付成功
					$this->db->trans_start();
					$uid = $_POST ['reqReserved'];
					$member = $this->getRow("go_member","uid='".$uid."'");
					$old_money = $member['money'];
					$orderId = $_POST ['orderId'];
					$czMoney = intval($_POST['txnAmt'])/100;
					$now_money = $old_money +  $czMoney;
					$nowtime = time();
					$data1 = array(
						'uid' => $uid,
						'type' => 1,
						'pay' => '账户',
						'content' => '充值',
						'money' => $czMoney,
						'time' => $nowtime
					);
					$flag1 =  $this->db->insert('go_member_account', $data1);
					if(!$flag1){
						$this->db->trans_rollback();
					}					
					$data2 = array(
						'uid' => $uid,
						'code' => $orderId,
						'money' => $czMoney,
						'pay_type' => '银联支付',
						'status' => '已付款',
						'time' => $nowtime,
						'score' => 0,
						'scookies' => 0
					);
					$flag2 =  $this->db->insert('go_member_addmoney_record', $data2);
					if(!$flag2){
						$this->db->trans_rollback();
					}
					$flag3 = $this->db->Query("update `go_member` SET `money` = '$now_money' where `uid` = '$uid'");
					if(!$flag3){
						$this->db->trans_rollback();
					}
					$this->db->trans_commit();
					header( "location: " . G_WEB_PATH);

				}
		}		
	}
	public function test(){
		$arr = array(
			'reqReserved' => 1095,
			'money' => 3,
			'orderId' => '201201111'
		);
		$abc = postCurl("http://ygtest.98czs.net/cart/back",$arr);
		print_r($abc);		
	}	
	//商户后台通知界面
	public function back(){
		header ('Content-type:text/html;charset=utf-8');
		include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_b2c/sdk/acp_service.php';
		if (isset ( $_POST ['signature'] )) {			
				//$flag = com\unionpay\acp\sdk\AcpService::validate ( $_POST );
				if($_POST ['respCode']=='00' || $_POST ['respCode']=='A6'){		//验签通过并支付成功
					$this->db->trans_start();
					$uid = $_POST ['reqReserved'];
					$member = $this->getRow("go_member","uid='".$uid."'");
					$old_money = $member['money'];
					$orderId = $_POST ['orderId'];
					$czMoney = intval($_POST['txnAmt'])/100;
					$now_money = $old_money +  $czMoney;
					$nowtime = time();
					$data1 = array(
						'uid' => $uid,
						'type' => 1,
						'pay' => '账户',
						'content' => '充值',
						'money' => $czMoney,
						'time' => $nowtime
					);
					$flag1 =  $this->db->insert('go_member_account', $data1);
					if(!$flag1){
						$this->db->trans_rollback();
					}					
					$data2 = array(
						'uid' => $uid,
						'code' => $orderId,
						'money' => $czMoney,
						'pay_type' => '银联支付',
						'status' => '已付款',
						'time' => $nowtime,
						'score' => 0,
						'scookies' => 0
					);
					$flag2 =  $this->db->insert('go_member_addmoney_record', $data2);
					if(!$flag2){
						$this->db->trans_rollback();
					}
					$flag3 = $this->db->Query("update `go_member` SET `money` = '$now_money' where `uid` = '$uid'");
					if(!$flag3){
						$this->db->trans_rollback();
					}
					$this->db->trans_commit();															
				}
		}		
	}
		
}
