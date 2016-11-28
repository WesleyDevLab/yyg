<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*微信管理*/
class Wechat extends CI_Controller {
    protected $wechat;
	function __construct(){
		parent::__construct();
		require_once(ROOTPATH.'/app/libraries/Wechatclass.php');
		$this->wechat = new Wechatclass();
					
	}
    //微信入口：自动登录
    public function wechats(){
        $type = $this->input->get('type');
        $code = $this->input->get('code');//获取code 
        $userinfo = $this->wechat->getOpenId($code);
        if(isset($userinfo['openid'])){
            $openid = $userinfo['openid'];
            $mem=$this->db->query("select * from `go_member_band` where `b_code`='".$openid."'")->row_array();
            $member=$this->db->query("select * from `go_member` where `uid`='".$mem['b_uid']."'")->row_array();
            if(!empty($member)) {
                _setcookie("uid", _encrypt($member['uid']), 60 * 60 * 24 * 7);
                _setcookie("ushell", _encrypt(md5($member['uid'] . $member['password'] . $member['mobile'] . $member['email'])), 60 * 60 * 24 * 7);
            }       
        }
        //回调跳转地址
        switch($type){
            case 'usercenter':      //用户个人中心
            header("location: ".G_WEB_PATH."/home");
            break;
            case 'home':            //网站首页
            header("location: ".G_WEB_PATH);
            break;
            case 'zhinan':
            header("location: ".G_WEB_PATH.'/html/zhinan');
            break;
            case 'mobilechecking':  //绑定手机号
            header("location: ".G_WEB_PATH.'/home/mobilechecking');
            break;
            //活动详情跳转到充值
            case 'cz':
            header("location: ".G_WEB_PATH."/cart/userrecharge");
            break;
        }
      
    }   		
	//首页	
	public function index(){
        // TODO 群发事件推送群发处理
        // TODO 模板消息事件推送处理
        // TODO 用户上报地理位置事件推送处理
        // TODO 自定义菜单事件推送处理
        // TODO 微信小店订单付款通知处理
        // TODO 微信卡卷(卡券通过审核、卡券被用户领取、卡券被用户删除)通知处理
        // TODO 智能设备接口
        // TODO 多客服转发处理			
        $request = $this->input;		//返回大写
        $this->load->model('Comm');       
        if (!$this->wechat->checkSignature() ) {
            echo 'Sign check fail!';
        }
        switch ($request->method(TRUE)) {
            case 'GET':
                echo $request->get('echostr');
                exit;
            case 'POST':
                $this->wechat->responseMsg();        	
            default:
                throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function createMenu(){
        $duobao = $this->wechat->getLongUrl(G_WEB_PATH.'/wechat/wechats?type=home', 'snsapi_userinfo'); 
        $usercenter = $this->wechat->getLongUrl(G_WEB_PATH.'/wechat/wechats?type=usercenter','snsapi_userinfo'); 
        $zhinan = $this->wechat->getLongUrl(G_WEB_PATH.'/wechat/wechats?type=zhinan','snsapi_userinfo');
        $menu = '{
                "button": [
                    {
                        "name": "立即夺宝",
                        "type": "view",
                        "url": "'.$duobao.'"
                    },
                    {
                        "name": "新手指南",
                        "type": "view",
                        "url": "'.$zhinan.'"
                    },
                    {
                        "name": "领取十元宝",
                        "type": "view",
                        "url": "'.$usercenter.'"
                    }
                ]
            }'; 
        $result = $this->wechat->createMenu($menu);       
        print_r($result);
    }    		
	


	
			
}