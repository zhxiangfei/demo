<?php
namespace app\index\controller;
use think\Controller;

/**
 * 微信类
 */
class Wechat extends Controller
{

	protected  $APPID = 'wxb3b89a8c3882ff51';
	protected  $APPSECRET = '0a40b7bd8f03b947867dd99441d9ba78';

	/**
	* 微信服务器配置时 验证token的url
	*/
	public function checkToken()
	{
		header("Content-type: text/html; charset=utf-8");

		//1.将timestamp,nonce,toke按字典顺序排序
		$timestamp = $_GET['timestamp'];
		$nonce = $_GET['nonce'];
		$token = 'asd123456zxc';
		$signature = $_GET['signature'];
		$array = array($timestamp,$nonce,$token);
		//2.将排序后的三个参数拼接之后用sha1加密
		$tmpstr = implode('',$array);
		$tmpstr = sha1($tmpstr);
		//3.将加密后的字符串与signature进行对比，判断该请求是否来自微信
		if($tmpstr == $signature){
		    echo $_GET['echostr'];
		    exit;
		}
	}

	/**
	* curl请求 
	*/
	public function http_curl($url, $type = 'get', $res = 'json', $arr = ''){
	  $cl = curl_init();
	  curl_setopt($cl, CURLOPT_URL, $url);
	  curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, false);
	  if($type == 'post'){
	    curl_setopt($cl, CURLOPT_POST, 1);
	    curl_setopt($cl, CURLOPT_POSTFIELDS, $arr);
	  }
	  $output = curl_exec($cl);
	  curl_close($cl);
	  return json_decode($output, true);
	  if($res == 'json'){
	    if( curl_error($cl)){
	      return curl_error($cl);
	    }else{
	      return json_decode($output, true);
	    }
	  }
	}

	/**
	 * 获取 AccessToken
	 */
	public function getAccessToken()
	{
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->APPID."&secret=".$this->APPSECRET;

		// 先判断 access_token 文件里的token是否过期，没过期继续使用，过期就更新
		$data = json_decode($this->get_php_file(ROOT_PATH."public".DS."wxtxt".DS."access_token.txt"));
		// 过期 更新
		if ($data->expire_time < time()) {
			
			$res = $this->http_curl($url);
			$access_token = $res['access_token'];
			if ($access_token) {
				// 在当前时间戳的基础上加7000s (两小时)
				$data->expire_time = time() + 7000;
				$data->access_token = $res['access_token'];
				$this->set_php_file(ROOT_PATH."public".DS."wxtxt".DS."access_token.txt",json_encode($data));
			}
		}else{
			// 未过期 直接使用
			$access_token = $data->access_token;
		}
		return $access_token;
	}
    
  	/**
	 * 获取 JsApiTicket
	 */
  	public function getJsApiTicket()
  	{
  		// 先判断 jsapi_ticket是否过期 没过期继续使用，过期就更新
  		$data = json_decode($this->get_php_file(ROOT_PATH."public".DS."wxtxt".DS."jsapi_ticket.txt"));

  		if ($data->expire_time < time()) {
  			// 过期 更新
  			$accessToken = $this->getAccessToken();
  			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
  			$res = $this->http_curl($url);
  			$ticket = $res['ticket'];
  			if ($ticket) {
  				$data->expire_time = time() + 7000;
  				$data->jsapi_ticket = $ticket;
  				$this->set_php_file(ROOT_PATH."public".DS."wxtxt".DS."jsapi_ticket.txt",json_encode($data));
  			}
  		}else{
  			$ticket = $data->jsapi_ticket;
  		}
  		return $ticket;
  	}


    // 获取存储文件中的token ticket
    private function get_php_file($filename) {
    	return trim(file_get_contents($filename));
  	}
  	// 把token ticket 存储到文件中
  	private function set_php_file($filename, $content) {
    	$fp = fopen($filename, "w");
    	fwrite($fp,  $content);
    	fclose($fp);
  	}

}