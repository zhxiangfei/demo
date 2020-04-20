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
	

}