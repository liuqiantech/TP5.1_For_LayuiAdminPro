# TP5.1_For_LayuiAdminPro
本项目为基于LayuiAdminPro版本的PHP后端开发框架，基础框架采用Thinkphp5.1。本框架实现以下功能：
###1、前后端分离下的用户状态验证
默认采用Token存库的形式，默认设置为存储在阿里云Redis数据库，默认有效期为8小时。
###2、前后端分离下的用户权限验证
采用TP5.1的前置中间件形式来验证用户是否有当前action的权限
###3、前后端分离下的前置变量验证
采用前置中间件的形式验证$_POST/$_GET输入变量，未通过验证则直接抛出异常
###4、基于请求过程的异常处理机制
有别于传统的面向过程的设计模式，本项目采用的是基于请求的面向对象的设计模式，在任何位置（包括构建函数内部）你都可以使用异常抛出机制来完成最终输出。（正确的返回是一种特殊的异常）
###5、前后端分离下的跨域处理
跨域情况下采用请求header携带token信息来验证状态的话，浏览器会先建立一次option的请求，来获取服务端允许携带的header信息。框架会自动将携带token的键名做跨域处理。
###6、容器类、门面以及静态调用
采用容器管理类来规范基础类（Auth、Input）的使用，采用门面或者静态调用的方式来规范模型的使用，尽可能减少重复实例化的操作。
###7、演示地址
前端演示：http://demo.fx115.com/ 账号 admin 密码 111111 （目前只完成了登录验证部分）
后端演示：http://test.fx115.com/