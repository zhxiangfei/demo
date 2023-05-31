<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Wechat;

/**
 * 微信功能开发
 */
class Wxopera extends Wechat
{

  	/**
	 * 生成二维码
	 */
	public function qrcode(){
		
		// 实例化微信操作类
		$wx = new Wechat();
		
		$token = $wx->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
		
		$param = array();
		$param['action_name'] = "QR_LIMIT_SCENE";
		$param['action_info'] = array( 'scene' => array( 'scene_id'=>'123'  )  );
		$param = json_encode($param);
		
		// 获取二维码的ticket和二维码图片解析地址
		$res = $wx->http_curl($url, 'post', 'json', $param);
	
		// 通过ticket换取二维码
		$qrcode = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$res['ticket'];
		
		// 输出二维码路径
		$this->assign('qrcode',$qrcode);
		return $this->fetch();
	}
	
	/**
	 * 网页授权
	 */
	 public function shouquan(){
	 	
	 	$wx = new Wechat();
	 	$APPID = $wx->APPID;
	 	$redirect = urlencode("http://test.zizhuyou.site/index/Wxopera/callback");
		
		// 调起微信授权提示
	 	$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$APPID."&redirect_uri=".$redirect."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
		// 跳转授权页面
		$this->redirect($url);
	 
	 }
	 
	 /**
	 * 网页授权的回调
	 */
	 public function callback(){
	 	
	 	$wx = new Wechat();
	 	$APPID = $wx->APPID;
	 	$APPSECRET = $wx->APPSECRET;
	 	
	 	// 一、获取用户授权回调里的code  code只有五分钟有效
		echo "<pre>";
	 	// 获取当前url的参数部分
	 	$params = $_SERVER["QUERY_STRING"];	// s=/index/Wxopera/callback&code=071W7rvB0IcmQk2z3VuB0ZvNvB0W7rv6&state=STATE
	 	// 拆分成数组
		$arr = explode('&',$params);
		$code = explode('=',$arr[1]);
		$code = $code[1];
		
		// 二、通过code获取网页授权access_token 有效期7200s,过期需要重新获取，这里暂不处理过期的问题
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$APPSECRET&code=$code&grant_type=authorization_code";
	 	$res = $wx->http_curl($url);
	 
	 	// 三、获取用户信息
	 	$url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=".$res['access_token']."&openid=".$res['openid']."&lang=zh_CN";
	 	
	 	$userinfo = $wx->http_curl($url2);
	 	
	 	print_r($userinfo);
	 }
	
	
	////////////////////////微信分享/////////////////////////
	/**
	 * 微信分享
	 */
	public function share(){
		$signPackage = json_decode($this->getSignPackage(),true);
	
		$this->assign('signPackage',$signPackage);
		return $this->fetch();
	}
	
	/**
	 * 生成签名
	 */
	public function getSignPackage() 
	{

		// 实例化微信操作类
		$wx = new Wechat();

		// 获取 ticket
	    $jsapiTicket = $wx->getJsApiTicket();

	    // 注意 URL 一定要动态获取，不能 hardcode.
	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	    // 当前页面的url
	    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	    $timestamp = time();	//生成签名的时间戳
	    $nonceStr = $this->createNonceStr();	//生成前面的随机串

	    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
	    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
	    // 对string进行sha1加密
	    $signature = sha1($string);

	    $signPackage = array(
	      "appId"     => $wx->APPID,
	      "nonceStr"  => $nonceStr,
	      "timestamp" => $timestamp,
	      "url"       => $url,
	      "signature" => $signature,
	      "rawString" => $string
	    );
	    return json_encode($signPackage); 
	}

	/**
	 * 生成签名的随机串
	 */
	private function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	}


	/////////////////////模板推送/////////////////////////
	public function pushmsg(){
		// 实例化微信操作类
		$wx = new Wechat();
		
		$token = $wx->getAccessToken();
		
		// 推送数据
		$data = [
			"touser" => "xxxxx",		//接收者的openid
			"template_id" => "xx-xx",		//申请的消息模板id
			"url" => "http://test.zizhuyou.site/index/Plantocr/index",	//推送消息中点击跳转的链接，不填就不会跳转
			"data" => array(
				"name" => array("value"=>"测试用户","color"=>"#173177"),
				"time" => array("value"=>date('Y-m-d H:i:s',time()),"color"=>"#173177")
			)
		];
		
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token";
		
		// 发送模板消息
		$res = $wx->http_curl($url, 'post', 'json', json_encode($data));
		echo "<pre>";
		print_r($res);
	}

}