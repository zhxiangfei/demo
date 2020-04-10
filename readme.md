## 一、项目介绍 

1. php+websocket聊天室
2. 无限级评论
3. 输入框回车生成标签
4. 植物识别
5. 发送邮件
6. 基于THINKPHP5实现红蓝投票功能

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

----------

#### 第三方类库 ####
1. phpmailer 发送邮件


## 补充说明 ##
1. php+websocket聊天室，需要开启socket组件 参考：[https://www.cnblogs.com/zxf100/p/12671258.html](https://www.cnblogs.com/zxf100/p/12671258.html "ThinkPHP5+WebSocket+MySQL实现聊天室")
2. 植物识别：对接的是"百度AI开发平台"的接口，接口地址：[https://ai.baidu.com/ai-doc/IMAGERECOGNITION/Mk3bcxe9i](https://ai.baidu.com/ai-doc/IMAGERECOGNITION/Mk3bcxe9i "植物识别")
3. 发送邮件需要phpmailer第三方类库扩展，需要开启邮箱的几个服务，参考：[https://www.cnblogs.com/zxf100/p/12627088.html](https://www.cnblogs.com/zxf100/p/12627088.html "Thinkphp5+PHPMailer实现发送邮件") 和  [https://www.cnblogs.com/zxf100/p/12658351.html](https://www.cnblogs.com/zxf100/p/12658351.html "thinkphp实现用户注册时邮箱激活")