## 一、项目介绍 

1. php+websocket聊天室
2. 无限级评论
3. 输入框回车生成标签
4. 植物识别
5. 发送邮件
6. 基于THINKPHP5实现红蓝投票功能
7. 微信开发之JS-SDK + PHP实现录音、上传、语音识别
8. 微信开发之微信网页授权
9. 微信开发之生成二维码
10. 微信开发之JS-SDK + PHP实现分享朋友/QQ，朋友圈/QQ空间
11. 微信开发之消息模板推送

## 二、目录结构

#### 模型 ####
1. 评论
	- Comment.php
2. 投票
	- Vote.php

----------

#### 控制器 ####
1. php+websocket聊天室
	- Chart.php 聊天室首页
	- Server.php websocket服务核心代码
	- Socket.php 运行websocket服务 
2. 评论
	- Comment.php 评论	 
3. 其他
	- Other.php 输入框回车生成标签
4. 植物识别
	- Plantorc.php 
5.  发送邮件
	- Sendmail.php  发送邮件、验证注册激活账号
6.  基于THINKPHP5实现红蓝投票功能	
	- Vote.php 
7.  微信开发之JS-SDK + PHP实现录音、上传、语音识别
	- Wechat.php	微信操作类
	- Wxmedia.php  录音、语音识别
8.  微信开发之微信网页授权
	- Wxopera.php -> shouquan()	微信操作类
9.  微信开发之生成二维码		
	- Wxopera.php -> qrcode()
10.  微信开发之JS-SDK + PHP实现分享朋友/QQ，朋友圈/QQ空间
	- Wxopera.php -> share()
11.  微信开发之消息模板推送
	- Wxopera.php -> pushmsg()
12.  
	

	


----------

#### 页面 ####
1. php+websocket聊天室
	- chart ->index.html 聊天室首页
2. 评论
	- comment -> index.html	 
3. 其他
	- other	->	tags.html 输入框回车生成标签
4. 植物识别
	- plantorc	->	index.html 
5.  基于THINKPHP5实现红蓝投票功能
	- vote	->	index.html
6.  微信开发之JS-SDK + PHP实现录音、上传、语音识别
	- wxmedia -> index.html
7.  微信开发之生成二维码
	- wxopera -> qrcode.html
8.  微信开发之JS-SDK + PHP实现分享朋友/QQ，朋友圈/QQ空间
	- wxopera -> share.html
9.  
	


----------

#### 第三方类库 ####
1. phpmailer 发送邮件


## 补充说明 ##
1. php+websocket聊天室，需要开启socket组件 参考：[https://www.cnblogs.com/zxf100/p/12671258.html](https://www.cnblogs.com/zxf100/p/12671258.html "ThinkPHP5+WebSocket+MySQL实现聊天室")
2. 植物识别：对接的是"百度AI开发平台"的接口，接口地址：[https://ai.baidu.com/ai-doc/IMAGERECOGNITION/Mk3bcxe9i](https://ai.baidu.com/ai-doc/IMAGERECOGNITION/Mk3bcxe9i "植物识别")
3. 发送邮件需要phpmailer第三方类库扩展，需要开启邮箱的几个服务，参考：[https://www.cnblogs.com/zxf100/p/12627088.html](https://www.cnblogs.com/zxf100/p/12627088.html "Thinkphp5+PHPMailer实现发送邮件") 和  [https://www.cnblogs.com/zxf100/p/12658351.html](https://www.cnblogs.com/zxf100/p/12658351.html "thinkphp实现用户注册时邮箱激活")
4. 微信开发之JS-SDK + PHP实现录音、上传、语音识别 参考 [微信开发之JS-SDK + PHP实现录音、上传、语音识别](https://www.cnblogs.com/zxf100/p/12718661.html "微信开发之JS-SDK + PHP实现录音、上传、语音识别")
5. 微信开发之网页授权 参考 [https://www.cnblogs.com/zxf100/p/12720983.html](https://www.cnblogs.com/zxf100/p/12720983.html "微信开发之网页授权 PHP")
6. 微信开发之生成二维码 参考 [https://www.cnblogs.com/zxf100/p/12720093.html](https://www.cnblogs.com/zxf100/p/12720093.html "微信开发之生成二维码，扫码关注公众号PHP")
7. 微信开发之JS-SDK + PHP实现分享朋友/QQ，朋友圈/QQ空间 参考 	[https://www.cnblogs.com/zxf100/p/12749770.html](https://www.cnblogs.com/zxf100/p/12749770.html "微信开发之JS-SDK + php 实现分享朋友/朋友圈，QQ/QQ空间")