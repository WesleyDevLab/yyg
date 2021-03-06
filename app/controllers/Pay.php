<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pay extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}	
	public function jsnotify(){
		require_once(ROOTPATH.'/app/libraries/wxpay/pay/JsNotify.php');
		
		$notify = new JsNotify();
		$notify->Handle(false);			
	}
	public function jspay(){
		ini_set('date.timezone','Asia/Shanghai');
		//error_reporting(E_ERROR);
		require_once(ROOTPATH.'/app/libraries/wxpay/pay/WxPay.JsApiPay.php');
		require_once(ROOTPATH.'/app/libraries/wxpay/pay/log.php');

		//初始化日志
		$logHandler= new CLogFileHandler(ROOTPATH.'/app/libraries/wxpay/'.date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		
		$money = intval($this->input->get('money'))*100;
		//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		
		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee($money);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://www.91czs.cn/pay/jsnotify");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
		//print_r($order);
		$jsApiParameters = $tools->GetJsApiParameters($order);
		$data['jsApiParameters'] = $jsApiParameters;
		
		//获取共享收货地址js函数参数
		$editAddress = $tools->GetEditAddressParameters();
		$data['editAddress'] = $editAddress;
		
		//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
		/**
		 * 注意：
		 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
		 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
		 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
		 */

		
		$this->load->view('pay/jspay',$data);
	}

		
}
