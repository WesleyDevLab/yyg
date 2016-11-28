<?php

require_once(ROOTPATH.'/app/libraries/Tool.php');
define("TOKEN", "weixin");
class Wechatclass{
	public $gAccount = 'gh_459b6e99bb64';  
	private $config = array(
		'token'=>'weixin',
		'appid'=>'wxb9e4a7edd6d6ee4e',
		'appsecret'=>'defcf33ad8cc680c18459729ada60bc2',
		'type'=>'3',
		'scope'=>'snsapi_base',
	);
	private $_pushTpl = '{"touser": "%s","template_id": "%s","data": %s}';
	private $_pushTpl_url = '{"touser": "%s","template_id": "%s","url":"%s","data": %s}';
	private $cacheObj = '';
    private $jsApiKey = 'jsapi_key';
	private $accessKey = 'access_key';
	public $accessToken='';
    protected $CI;
	public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->driver('cache');
        $this->CI->load->helper('cookie');
        $this->CI->load->model('Comm');         //加载写入bug公用模型
        $this->getAccessToken();
        $this->cacheObj =  $this->CI->cache->memcached;
	}
	//获取access_token并缓存
    public function getAccessToken(){
        //$this->accessToken = $this->cacheObj->get($this->accessKey);
        if( !$this->accessToken ){
            $accessTokenUrl = sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s", $this->config['appid'], $this->config['appsecret']);
            $rs = Tool::phpGet( $accessTokenUrl );
            $array = json_decode($rs,  true);
            $this->accessToken = $array['access_token'];
            //$this->CI->Comm->debug(var_export($this->cacheObj));
            //$this->cacheObj->save( $this->accessKey, $this->accessToken, 2*3600 );
        }
        return $this->accessToken;
    }
    public function createMenu($menuJson){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->accessToken;       
        $result = Tool::phpPost($url, $menuJson);   
        return $result;
    }    	
    //获取JS API需要的参数
    public function getJsApi(){
    	$timestamp = time();
        $nonce = 'test123455*&123abc';
        $ticketArr = $this->cacheObj->get($this->jsApiKey);
        if( $ticketArr==null || $ticketArr === false || $ticketArr['errcode'] != 0 )
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->accessToken.'&type=jsapi';
            $rs = Tool::phpGet($url);
            $arr = json_decode($rs, true);
            if($arr['errcode']=="40001"){
                $this->getAccessToken();
            }
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->accessToken.'&type=jsapi';
            $rs = Tool::phpGet($url);
            $arr = json_decode($rs, true);
            $ticket = $arr['ticket'];
            $this->cacheObj->set($this->jsApiKey, $arr, $arr['expires_in']);
        }else{
            $ticket = $ticketArr['ticket'];
        }
        //生成签名
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $qstring = 'jsapi_ticket='.$ticket.'&noncestr='.$nonce.'&timestamp='.$timestamp.'&url='.$url;
        $sign = sha1($qstring);
        $js_list=array('appId'=>$this->config['appid'],'timestamp'=>$timestamp,'nonceStr'=>$nonce,'signature'=>$sign,'jsapi_ticket'=>$ticket,'url'=>$url);
        return $js_list;
    }
    //构建模板消息
    public static function makeData($first, $keyword1, $keyword2, $keyword3, $remark){
        $keyword3_html = '';
        if(!empty($keyword3)){
	        $keyword3_html = '"keyword3": {
				                   "value":"'.$keyword3.'",
				                   "color":""
				               },';
        }
        $data = '{
               "first": {
                   "value":"'.$first.'",
                   "color":""
               },
               "keyword1":{
                   "value":"'.$keyword1.'",
                   "color":""
               },
               "keyword2": {
                   "value":"'.$keyword2.'",
                   "color":""
               },'.
               $keyword3_html.'
               "remark":{
                   "value":"'.$remark.'",
                   "color":"#173177"
               }
             }';
        return $data;
    }
    //发送模板消息 [$accessToken参数是为发送其它公众号而设置的]
    public function SendTemplate($accessToken, $touserid, $templateid, $data, $url=''){
    	if(empty($accessToken)){
    		$accessToken = $this->getAccessToken();
    	}
    	if(empty($url)){
    		$msg = sprintf($this->_pushTpl,$touserid,$templateid,$data);
    	}else{
    		$msg = sprintf($this->_pushTpl_url,$touserid,$templateid,$url,$data);
    	}
        $templateUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$accessToken;
        $result = Tool::phpPost($templateUrl, $msg);        
        return json_decode($result,true);
    }    	
			
    public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }    
    public function checkSignature(){
        $signature = $this->CI->input->get('signature');
        $timestamp = $this->CI->input->get('timestamp');
        $nonce = $this->CI->input->get('nonce');

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    //响应消息
    public function responseMsg(){
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents("php://input");
        if (!empty($postStr)){
            //$this->logger("R \r\n".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            if (($postObj->MsgType == "event") && ($postObj->Event == "subscribe" || $postObj->Event == "unsubscribe")){
                //过滤关注和取消关注事件
            }else{
                
            }
            //消息类型分离
            switch ($RX_TYPE){
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                   if (strstr($postObj->Content, "第三方")){
                        $result = $this->relayPart3("http://www.fangbei.org/test.php".'?'.$_SERVER['QUERY_STRING'], $postStr);
                    }else{
                        $result = $this->receiveText($postObj);
                    }
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            //$this->logger("T \r\n".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }
	public function getLongUrl($rUrl, $scope='', $state=''){
    	$rUrl = urlencode($rUrl);
    	$appId = $this->config['appid'];
        if($scope==''){         //授权方式[静默：snsapi_base ，用户手动授权：snsapi_userinfo]
            $scope = $this->config['scope'];
        }    	
    	if($state == ''){
    		$state = $this->gAccount;
    	}
     	$webRedirectUrlTpl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appId ."&redirect_uri=". $rUrl ."&response_type=code&scope=". $scope ."&state=". $state ."#wechat_redirect";
    	return $webRedirectUrlTpl;
    }      
    //获取用户openid[含静默授权、用户手动授权]
 	public function getOpenId($code){
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->config['appid']."&secret=".$this->config['appsecret']."&code=".$code."&grant_type=authorization_code"; 
        $userInfoJson = Tool::phpGet($url);
        $userInfo = array();
        if(!empty($userInfoJson)){
            $userInfo = json_decode($userInfoJson, true);
        }
        return $userInfo;       //如果是静默授权，只能获取用户openid        
    }   

    //接收事件消息
    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event){
            case "subscribe":
                $msgType = "text";
                $time = time();
                //  查询用户信息
                $retuser = $this->CI->db -> query("SELECT `b_uid` FROM `go_member_band` WHERE `b_code` ='".$object->FromUserName."' LIMIT 1")->row_array();
                $user_id = $retuser['b_uid'];                
                //查询关注回复
                $lang = $this->CI->db -> query("SELECT `cfg_value` FROM `go_wxch_cfg` WHERE `cfg_name` = 'reply'")->row_array();
                //查询后台配置的默认密码
                $pwd = $this->CI->db -> query("SELECT `cfg_value` FROM `go_wxch_cfg` WHERE `cfg_name` = 'userpwd'")->row_array();
                $cfgv = trim($pwd['cfg_value']);
                if(!empty($cfgv)){
                    $password = $cfgv;
                }else{
                    //默认随机产生密码
                    $password = '123456';
                }
                
                $longurl = $this->getLongUrl(G_WEB_PATH.'/wechat/wechats?type=mobilechecking',"snsapi_userinfo");                                
                if(empty($retuser)){
                    //用户没有关注过
                    $contentgz = htmlspecialchars_decode($lang['cfg_value']);
                    //$this->CI->Comm->debug($this->accessToken.'>>>'.$object->FromUserName);
                    $user_info_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->accessToken.'&openid='.$object->FromUserName;
                    $user_info = json_decode(Tool::phpGet($user_info_url),true);
                    //获取用户的openid
                    $uopenid = $user_info['openid'];

                    if(empty($uopenid)){
                        //获取用户openid 失败
                        $contentStr = '信息获取失败，请取消关注后再重新关注';
                        $result = $this->transmitText($object, $contentStr);
                        return $result;
                    }
                    // 自动获取用户的微信资料
                    $password2 = md5($password);
                    $headimg  = $user_info['headimgurl'];
                    $nickname = $user_info['nickname'];

                    //因为不存在用户信息，所以就进行写入操作
                    $song = CZSONG;
                    $ipaddress = _get_ip_dizhi();
                    $this->CI->db-> query("INSERT INTO `go_member` (`username`, `password`, `time`, `img`, `first`,`money`,`user_ip`) VALUES ('$nickname', '$password2','$time','$headimg', '1', '$song','$ipaddress')");
                    $b_uid = $this->CI->db->insert_id();
                    //新增微信用户绑定
                    $this->CI->db-> Query("INSERT INTO `go_member_band` SET `b_uid` = '$b_uid' , `b_time` = '$time', `b_type`='weixin', `b_code`='".$object->FromUserName."'"); 

                    $song = CZSONG;
                    $data1 = array(
                        'uid' => $b_uid,
                        'type' => 1,
                        'pay' => '账户',
                        'content' => '注册赠送',
                        'money' => $song,
                        'time' => $time
                    );
                    $this->CI->db->insert('go_member_account', $data1);  

                    //新增微信用户
                    $sex =   $user_info['sex'];
                    $city =   $user_info['city'];
                    $province =   $user_info['province'];
                    $country =   $user_info['country'];
                    $subscribe_time =   $user_info['subscribe_time'];
                    $this->CI->db -> Query("INSERT INTO `go_weixin_user`(`uid`,`subscribe`,`wxid`,`nickname`,`sex`,`city`,`country`,`time`,`typeid`,`headimgurl`,`subscribe_time`,`localimgurl`,`setp`,`uname`,`coupon`) VALUES ('$b_uid','1','".$object->FromUserName."','$nickname','$sex','$city','$country','$time','0','$headimg','$subscribe_time','/statics/uploads/photo/member.jpg','1','$nickname','0');");

                    //首次关注自动注册
                    $contentreg = "\n\n恭喜您注册成功!\n您的用户名为:".$nickname."\n密码为:".$password."\n\n请及时绑定手机号码<a href='".$longurl."'>立即绑定</a>";

                    //关注送红包
                    //$gzshb = $this->coupon($fromUsername);

                    $contentStr = $contentgz.$contentreg;

                }else{

                    $contentgz = htmlspecialchars_decode($lang['cfg_value']);
                    //接下来是用户已经绑定的情况
                    $retuser = $this->CI->db -> query( "SELECT * from `go_member` WHERE `uid`= $user_id")->row_array();                
                    $this->CI->db ->query("UPDATE `go_member` SET `first` = '0' WHERE `uid`= $user_id");

                    $contentreg ="\n\n尊敬的".$retuser['username']."您好！\n\n您已经关注成功,如果您没有修改过密码,您的默认密码是 ".$password."，如果您还没有绑定手机号码，建议您及时修改并绑定手机号，以便我们及时与您取得联系！"."\n\n请及时绑定手机号码<a href='".$longurl."'>立即绑定</a>";
                    //关注送红包
                    //$gzshb = $this->coupon($fromUsername);

                    $contentStr = $contentgz.$contentreg;

                }

                $content = $contentStr;
                //$content = "欢迎关注方倍工作室 ";
                //$content .= (!empty($object->EventKey))?("\n来自二维码场景 ".str_replace("qrscene_","",$object->EventKey)):"";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "COMPANY":
                        $content = array();
                        $content[] = array("Title"=>"方倍工作室", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        break;
                    default:
                        $content = "点击菜单：".$object->EventKey;
                        break;
                }
                break;
            case "VIEW":
                $content = "跳转链接 ".$object->EventKey;
                break;
            case "SCAN":
                $content = "扫描场景 ".$object->EventKey;
                break;
            case "LOCATION":
                $content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;
            case "scancode_waitmsg":
                if ($object->ScanCodeInfo->ScanType == "qrcode"){
                    $content = "扫码带提示：类型 二维码 结果：".$object->ScanCodeInfo->ScanResult;
                }else if ($object->ScanCodeInfo->ScanType == "barcode"){
                    $codeinfo = explode(",",strval($object->ScanCodeInfo->ScanResult));
                    $codeValue = $codeinfo[1];
                    $content = "扫码带提示：类型 条形码 结果：".$codeValue;
                }else{
                    $content = "扫码带提示：类型 ".$object->ScanCodeInfo->ScanType." 结果：".$object->ScanCodeInfo->ScanResult;
                }
                break;
            case "scancode_push":
                $content = "扫码推事件";
                break;
            case "pic_sysphoto":
                $content = "系统拍照";
                break;
            case "pic_weixin":
                $content = "相册发图：数量 ".$object->SendPicsInfo->Count;
                break;
            case "pic_photo_or_album":
                $content = "拍照或者相册：数量 ".$object->SendPicsInfo->Count;
                break;
            case "location_select":
                $content = "发送位置：标签 ".$object->SendLocationInfo->Label;
                break;
            default:
                $content = "receive a new event: ".$object->Event;
                break;
        }

        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收文本消息
    private function receiveText($object){
        $keyword = trim($object->Content);
        //多客服人工回复模式
        if (strstr($keyword, "请问在吗") || strstr($keyword, "在线客服")){
            $result = $this->transmitService($object);
            return $result;
        }

        //自动回复模式
        if (strstr($keyword, "文本")){
            $content = "这是个文本消息222";
        }else if (strstr($keyword, "表情")){
            $content = "中国：".$this->bytes_to_emoji(0x1F1E8).$this->bytes_to_emoji(0x1F1F3)."\n仙人掌：".$this->bytes_to_emoji(0x1F335);
        }else if (strstr($keyword, "单图文")){
            $content = array();
            $content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
            $content = array();
            $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
        }else if (strstr($keyword, "音乐")){
            $content = array();
            $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3", "HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3"); 
        }else{
            $content = date("Y-m-d H:i:s",time())."\nOpenID：".$object->FromUserName."\n技术支持 方倍工作室";
        }

        if(is_array($content)){
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收图片消息
    private function receiveImage($object){
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object){
        $content = "你发送的是位置，经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object){
        if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = "你刚才说的是：".$object->Recognition;
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }
        return $result;
    }

    //接收视频消息
    private function receiveVideo($object){
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object){
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content){
        if (!isset($content) || empty($content)){
            return "";
        }

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray){
        if(!is_array($newsArray)){
            return "";
        }
        $itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray){
        if(!is_array($musicArray)){
            return "";
        }
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray){
        $itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray){
        $itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
    </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray){
        $itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object){
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复第三方接口消息
    private function relayPart3($url, $rawData){
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //字节转Emoji表情
    function bytes_to_emoji($cp){
        if ($cp > 0x10000){       # 4 bytes
            return chr(0xF0 | (($cp & 0x1C0000) >> 18)).chr(0x80 | (($cp & 0x3F000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x800){   # 3 bytes
            return chr(0xE0 | (($cp & 0xF000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x80){    # 2 bytes
            return chr(0xC0 | (($cp & 0x7C0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else{                    # 1 byte
            return chr($cp);
        }
    }
}
?>