<?php
/*
 * 自定义工具组件
 * author:roby
 * update 2016-05-12
 */

class Tool
{
    //获取xml数据转成数组返回
	static public function getXml()
	{
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

		if(empty($postObj))
		{
			return false;
		}

		$msg = array();
		foreach($postObj as $key => $value)
		{
			$msg[$key] = (string)$value;
		}
		return $msg;
	}
	static public function phpGet($url,$refer=''){
		$ch = curl_init($url);
		$options = array(
	        CURLOPT_RETURNTRANSFER => true,         // return web page
	        CURLOPT_HEADER         => false,        // don't return headers
	        CURLOPT_FOLLOWLOCATION => true,         // follow redirects
	        CURLOPT_ENCODING       => "",           // handle all encodings
	        CURLOPT_USERAGENT      => "",           // who am i
	        CURLOPT_AUTOREFERER    => true,         // set referer on redirect
	        CURLOPT_CONNECTTIMEOUT => 5,            // timeout on connect
	        CURLOPT_TIMEOUT        => 5,            // timeout on response
	        CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
	        CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
	        CURLOPT_SSL_VERIFYPEER => false,        //
	        CURLOPT_COOKIEFILE     => '',
	        CURLOPT_COOKIEJAR      => '',
	        CURLOPT_REFERER        => $refer,
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	static public function phpPost($url, $data, $refer='')
	{
		$ch = curl_init($url);
		$options = array(
		    CURLOPT_RETURNTRANSFER => true,         // return web page
		    CURLOPT_HEADER         => false,        // don't return headers
		    CURLOPT_FOLLOWLOCATION => true,         // follow redirects
		    CURLOPT_ENCODING       => "",           // handle all encodings
		    CURLOPT_USERAGENT      => "",           // who am i
		    CURLOPT_AUTOREFERER    => true,         // set referer on redirect
		    CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
		    CURLOPT_TIMEOUT        => 120,          // timeout on response
		    CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
		    CURLOPT_POST           => true,         // i am sending post data
		    CURLOPT_POSTFIELDS     => $data,        // this are my post vars
		    CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
		    CURLOPT_SSL_VERIFYPEER => false,        //
		    CURLOPT_COOKIEFILE     => '',
		    CURLOPT_COOKIEJAR      => '',
		    CURLOPT_REFERER        => $refer,
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	public static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">";

        	 }
        	 else
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

	static public function TextFilter($str)
	{
		$str = trim($str);
		$str = preg_replace( '/[\a\f\n\e\0\r\t\x0B]/is', "", $str );
		$str = htmlspecialchars($str, ENT_QUOTES);
		$str = self::_TagFilter($str);
		$str = self::_CommonFilter($str);
		return $str;
	}
	/**
	 * 做一些字符转换，防止XSS等方面的问题
	 * @param string $str
	 * @return string
	 */
	static private function _TagFilter($str)
	{
		$str = str_ireplace( "javascript" , "j&#097;v&#097;script", $str );
		$str = str_ireplace( "alert"      , "&#097;lert"          , $str );
		$str = str_ireplace( "about:"     , "&#097;bout:"         , $str );
		$str = str_ireplace( "onmouseover", "&#111;nmouseover"    , $str );
		$str = str_ireplace( "onclick"    , "&#111;nclick"        , $str );
		$str = str_ireplace( "onload"     , "&#111;nload"         , $str );
		$str = str_ireplace( "onsubmit"   , "&#111;nsubmit"       , $str );
		$str = str_ireplace( "<script"	  , "&#60;script"		  , $str );
		$str = str_ireplace( "document."  , "&#100;ocument."      , $str );

		return $str;
	}

	/**
	 * 一些字符串格式化
	 *
	 * @param string $str
	 * @return string
	 */
	static private function _CommonFilter($str)
	{
		$str = str_replace( "&#032;"			, " "			, $str );
		$str = preg_replace( "/\\\$/"			, "&#036;"		, $str );
		$str = self::_stripslashes($str);
		return $str;
	}

	/**
	 * 包装stripslashes
	 *
	 * @param string $str
	 * @return string
	 */
	static private function _stripslashes($str)
	{
		global $magic_quotes_gpc;

		if ($magic_quotes_gpc)
		{
			$str = stripslashes($str);
		}
		return $str;
	}
	public static function p1($var)
	{
		echo "<pre>";
		var_dump($var);
		echo "</pre>";
	}

	public static function p2($var)
	{
		echo "<xmp>";
		var_dump($var);
		echo "</xmp>";
	}

	/**
	 * 计算经纬度范围(距形)
	 *
	 */
	static public function locationRange($location,$km=1)
	{
		$lat = $location['lat'];
		$lng = $location['lng'];

		$range = 180 / pi() * $km / 6372.797;     //里面的 1 就代表搜索 1km 之内，单位km
		$lngR = $range / cos($lat * pi() / 180);
		$maxLat = $lat + $range;//最大纬度
		$minLat = $lat - $range;//最小纬度
		$maxLng = $lng + $lngR;//最大经度
		$minLng = $lng - $lngR;//最小经度
		return array('maxLat'=>$maxLat,'minLat'=>$minLat,'maxLng'=>$maxLng,'minLng'=>$minLng);
	}

	/**
	 * 获取两个坐标点之间的距离，单位km，小数点后2位
	 */
	static public function LocationDistance($location1,$location2)
	{
		$lat1=$location1['lat'];
		$lng1=$location1['lng'];
		$lat2=$location2['lat'];
		$lng2=$location2['lng'];

		$EARTH_RADIUS = 6378.137;
		$radLat1 = self::rad($lat1);
		$radLat2 = self::rad($lat2);
		$a = $radLat1 - $radLat2;
		$b = self::rad($lng1) - self::rad($lng2);
		$s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
		$s = $s * $EARTH_RADIUS;

		$s = round($s * 1000);
		return $s;
	}

	//LocationDistance 辅助函数
	static public function rad($d)
	{
		return $d * M_PI / 180.0;
	}

	/**
	 * TFunction::TransToBaiduLocation()
	 * 将微信经纬度转成百度经纬度
	 *
	 * @param mixed $location
	 *  位置数组，格式如下
	 *  array(
	 *  	'lat'=>$latitude,
	 * 		'lng'=>$longitude,
	 *  )
	 * @return 无。通过引用参数直接修改入参
	 */
	static public function TransToBaiduLocation(&$location, $type=0)
	{
		if($type==2)
		{
			//调用百度接口进行转换（由谷歌经纬度转百度经纬度）
			$url = 'http://api.map.baidu.com/ag/coord/convert?from=2&to=4&x='.$location['lng'].'&y='.$location['lat'];
			$ret = file_get_contents($url);
			$obj = json_decode($ret);

			//对获得的结果进行解密
			$location['lat'] = base64_decode($obj->y);
			$location['lng'] = base64_decode($obj->x);
		}
		else if($type==0)
		{
			//调用百度接口进行转换（由GPS经纬度转百度经纬度）
			$url = 'http://api.map.baidu.com/ag/coord/convert?from=0&to=4&x='.$location['lng'].'&y='.$location['lat'];
			$ret = file_get_contents($url);
			$obj = json_decode($ret);
			//对获得的结果进行解密
			$location['lat'] = base64_decode($obj->y);
			$location['lng'] = base64_decode($obj->x);
			//Yii::log(var_export($location,true),'info');
		}

	}


}