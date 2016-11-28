<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*购物页面*/
class Service extends CI_Controller  {
	//商户前台通知界面
	public function front(){
		header ('Content-type:text/html;charset=utf-8');
		include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_b2c/sdk/acp_service.php';
		if (isset ( $_POST ['signature'] )) {			
				//$flag = com\unionpay\acp\sdk\AcpService::validate ( $_POST );
				if($_POST ['respCode']=='00' || $_POST ['respCode']=='A6'){		//验签通过并支付成功验签通过并支付成功
					header( "location: " . G_WEB_PATH);

				}
		}		
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
					$member = $this->db->query("select * from go_member where uid='".$uid."'")->row_array();
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
					//充值送
					$song = 0;
					if($czMoney>=20 && $czMoney<200){
						$song = 10;
					}
					if($czMoney>=200){
						$song = 100;
					}
					if($song>0){
						$data11 = array(
							'uid' => $uid,
							'type' => 1,
							'pay' => '账户',
							'content' => '充值赠送元宝',
							'money' => $song,
							'time' => $nowtime
						);
						$flag11 =  $this->db->insert('go_member_account', $data11);
						if(!$flag11){
							$this->db->trans_rollback();
						}												
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
					$now_money += $song;
					$flag3 = $this->db->Query("update `go_member` SET `money` = '$now_money' where `uid` = '$uid'");
					if(!$flag3){
						$this->db->trans_rollback();
					}
					$this->db->trans_commit();															
				}
		}		
	}	
	
}
