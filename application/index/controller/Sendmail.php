<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use phpmailer\PHPMailer;
use phpmailer\Exception;

class Sendmail extends Controller
{
	// 发送邮件
	public function index()
    {
		$toemail = 'xx@126.com';	//这里写的是收件人的邮箱
        $active_url = "http://test.zxf/index/sendmail/active.html?id=1&active_key=123";
        $body =  "亲爱的".$toemail."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/> 
                    <a href='".$active_url."' target= '_blank'>点击激活</a><br/> 
                    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。"; 

        $mail=new Phpmailer();
        $mail->isSMTP();	// 使用SMTP服务（发送邮件的服务）
        $mail->CharSet = "utf8";	// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = "smtp.qq.com";	// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;	// 是否使用身份验证
        $mail->Username = "xx@qq.com";	// 申请了smtp服务的邮箱名（自己的邮箱名）
        $mail->Password = "hcstaffeplbcjgii";	// 发送方的邮箱密码，不是登录密码,是qq的第三方授权登录码,要自己去开启（之前叫你保存的那个密码）
        $mail->SMTPSecure = "ssl";	// 使用ssl协议方式,
        $mail->Port = 465;	// QQ邮箱的ssl协议方式端口号是465/587
        $mail->setFrom("xxxx@qq.com","测试发件人");	// 设置发件人信息，如邮件格式说明中的发件人,
        $mail->addAddress($toemail,'测试收件人');	// 设置收件人信息，如邮件格式说明中的收件人
        $mail->addReplyTo("xxxxxxxxxx@qq.com","Reply");	// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
        $mail->Subject = "这是一个测试邮件";	// 邮件标题
        $mail->Body = $body;// 邮件正文
        
        $mail->CharSet = "UTF-8";   //字符集
        $mail->Encoding = "base64"; //编码方式
        $mail->IsHTML(true);    //支持html格式内容

       if(!$mail->send()){	// 发送邮件
           echo "Message could not be sent.";
           echo "Mailer Error: ".$mail->ErrorInfo;	// 输出错误信息
        }else{
            echo '';
            return '发送成功';
        }
	}

    // 验证注册激活账户
    public function active()
    {
        $data = request()->param();
        // 通过id找对应的激活码
        $active_key = Db::table('active')->where(['id'=>$data['id']])->value('active_key');
        if ($active_key) {

            // 验证激活码是否正确
            if ($active_key == $data['active_key']) {
                // 更改激活状态
                $res = Db::table('active')->where(['id'=>$data['id']])->update(['status'=>1]);
                if ($res) {
                    echo "激活成功";
                }else{

                    echo "激活失败";
                }
            }else{
                echo "激活码不正确";
            }
        }else{
            echo "用户不存在";
        }
    }

}