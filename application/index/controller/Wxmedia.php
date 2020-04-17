<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Wechat;

/**
 * 微信语音识别
 */
class Wxmedia extends Wechat
{

	/**
	 * 语音识别
	 */
	public function index()
	{
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
	
}