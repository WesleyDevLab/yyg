<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Html extends CheckHomeBase {	
	function __construct(){
		parent::__construct();	
	}	
	//广告
	public function broad(){
		$type = intval($this->uri->segment(3));		//广告
		if($type){
			if(is_weixin()){
				require_once(ROOTPATH.'/app/libraries/Wechatclass.php');
				$wechat = new Wechatclass();
				//跳转到冲值
				$cz = $wechat->getLongUrl(G_WEB_PATH.'/wechat/wechats?type=cz', 'snsapi_userinfo'); 				
			}else{
				$cz = G_WEB_PATH.'/cart/userrecharge';
			}
			$data['cz'] = $cz;
			$this->load->view('html/activity_detail'.$type,$data);
		}else{
			$this->load->view('html/activity_detail');
		}
		
	}
	//协议
	public function xieyi(){
		$data['curr'] = 'home';
		$this->load->view('html/xieyi',$data);
		$this->load->view('layout/footer2');
	}
	//新手指南
	public function zhinan(){
		$this->load->view('html/zhinan');		
	}
	
				
				
}
