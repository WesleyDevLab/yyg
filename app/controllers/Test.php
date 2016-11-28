<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}	
	//首页	
	public function index(){
		$list = $this->db->query("select * from ipaddr where country='中国' and dist is not null limit 51,100")->result_array();
		foreach($list as $row){

			$ipstart = ip2long($row['ipstart']);
			$ipend = ip2long($row['ipend']);
			for($i=$ipstart; $i<=$ipend; $i++){
				$data = array(
					'ip' => long2ip($i),
					'area' => '',
					'country' => $row['country'],
					'province' => $row['province'],
					'city' => $row['dist'],
					'isp' => $row['isp'],
					'status' => 0
				);
				$flag = $this->db->insert('ip',$data);
			}

		}
	}
	//新手指南
	public function zhinan(){
		$this->load->view('html/zhinan');		
	}
	//编写乘法口诀
	public function koujuan(){
		for($i=1;$i<10;$i++){			
			for($j=1;$j<=$i;$j++){
				echo $j.'x'.$i.'='.$i*$j.'&nbsp;';
			}
			echo "<br>\n";  //换行
		}
	}
	//冒泡排序[由小到大]
	public function maopao($arr){
		$length = count($arr);
		//最后一个不用比较，必为最大
		for($i=0;$i<$length-1;$i++){
			for($j=0;$j<$length-1-$i;$j++){
				if($arr[$j]>$arr[$j+1]){	//需要修改排序
					$temp = $arr[$j];
					$arr[$j] = $arr[$j+1];
					$arr[$j+1] = $temp;
				}
			}
		}
		return $arr;	
	}
	/*
	*快速排序算法是对冒泡算法的一个优化。
	*他的思想是先对数组进行分割， 
	*把大的元素数值放到一个临时数组里，
	*把小的元素数值放到另一个临时数组里
	*(这个分割的点可以是数组中的任意一个元素值，一般用第一个元素，即$array[0])，
	*然后继续把这两个临时数组重复上面拆分，最后把小的数组元素和大的数组元素合并起来。
	*这里用到了递归的思想。
	*/
	public function quickSort($array){
	    if(!isset($array[1])){
	    	return $array;
	    }	        
	    $mid = $array[0]; //获取一个用于分割的关键字，一般是首个元素
	    $leftArray = array(); 
	    $rightArray = array();
	    foreach($array as $v)
	    {
	        if($v > $mid){
	        	$rightArray[] = $v;  //把比$mid大的数放到一个数组里
	        }	           
	        if($v < $mid){
	        	$leftArray[] = $v;   //把比$mid小的数放到另一个数组里
	        }	            
	    }
	    $leftArray = $this->quickSort($leftArray); 		   //把比较小的数组再一次进行分割
	    $leftArray[] = $mid;        				  //把分割的元素加到小的数组后面，不能忘了它哦
	    $rightArray = $this->quickSort($rightArray);  		 //把比较大的数组再一次进行分割
	    return array_merge($leftArray,$rightArray); //组合两个结果
	}
	//比较排序效率
	public function bijiao(){
		$a = array_rand(range(1,3000), 1500);  //甚至在冒泡算法超过1600个元素的时候会出现内存不足的提示，但这里为了测出两个之间的差别大小， 就设置成了1500，保证冒泡算法也能执行完毕。
		shuffle($a);  //获取已经打乱了顺序的数组
		$t1 = microtime(true);
		$arr1 = $this->quickSort($a);  //快速排序
		$t2 = microtime(true);
		echo (($t2-$t1)*1000).'ms<br/>';
	
		$t1 = microtime(true);
		$arr2 = $this->maopao($a);
		$t2 = microtime(true);
		echo (($t2-$t1)*1000).'ms<br/>';

		$t1 = microtime(true);
		sort($a);
		$t2 = microtime(true);
		echo (($t2-$t1)*1000).'ms<br/>';


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
		
		//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		
		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://www.91czs.cn/pay/jsnotify");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
		print_r($order);
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

		
		$this->load->view('test/jspay',$data);
	}

		
}
