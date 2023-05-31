<?php
namespace app\index\controller;
use think\Controller;

/**
 * 植物识别
 */
class Plantocr extends Controller
{

	public function index()
	{
		if (request()->isPost()) {

			$APIKER = config('APIKER');
			$SECTERKEY = config('SECTERKEY');

			// 上传图片
			$file = request()->file('img');
			$info = $file->move(ROOT_PATH.'public'.DS.'uploads'.DS);

			if ($info) {
				
				// 识别
				// 获取token json转数组
				$token = json_decode($this->getAccessToken($APIKER,$SECTERKEY),true);
				$url = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/plant?access_token='.$token['access_token'];

				$img = file_get_contents(ROOT_PATH.'public'.DS.'uploads'.DS.$info->getSaveName());

				$bodys = array(
					'image' => base64_encode($img),	//base64编码的图像数据
					'baike_num' => 1	//百科信息结果数
				);

				$res = $this->requestPost($url,$bodys);
				// json转数组
				$res = json_decode($res,true);

				echo "<pre>";
				print_r($res);

				// 判断是否出错
				if (isset($res['error_code'])) {

					echo $res['error_msg'];
				}else{

					// 取第一个数据
					if ($res['result'][0]['name'] == '非植物') {
						echo "非植物";
					}else{
						print_r($res['result']['0']);
					}
				}

			}else{
				// 上传失败
				echo $file->getError();
			}
		
		}else{

			return $this->fetch();
		}
	}

	/**
	 * Curl请求
	 */
	public function requestPost($url = '',$param = '')
	{
		if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($curl);//运行curl
        // var_dump(curl_error($curl));
        curl_close($curl);
        
        return $data;
	}

	/**
	 * 获取access_token
	 */
	public function getAccessToken($APIKER,$SECTERKEY)
	{
		$url = 'https://aip.baidubce.com/oauth/2.0/token';
	    $post_data['grant_type'] = 'client_credentials';
	    $post_data['client_id'] = $APIKER;
	    $post_data['client_secret'] = $SECTERKEY;
	    $o = "";
	    foreach ( $post_data as $k => $v ) 
	    {
	    	$o.= "$k=" . urlencode( $v ). "&" ;
	    }
	    // 截掉最后一个字符‘&’
	    $post_data = substr($o,0,-1);
	    
	    $info = $this->requestPost($url, $post_data);
	   	    
	    return $info;
	}

}