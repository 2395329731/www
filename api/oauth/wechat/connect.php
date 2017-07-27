<?php
require '../../../common.inc.php';
if($AJ_MOB['browser'] == 'weixin' && $EXT['weixin']) dheader($EXT['mobile_url'].'weixin.php?action=connect');
require 'init.inc.php';
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=<?php echo AJ_CHARSET;?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>微信登录<?php echo $AJ['seo_delimiter'];?><?php echo $AJ['sitename'];?></title>
	<style>
	* {word-break:break-all;font-family:"Segoe UI","Lucida Grande",Helvetica,Arial,Verdana,"Microsoft YaHei";}
	body {margin:0;font-size:14px;color:#333333;background:#EFEFF4;-webkit-user-select:none;}
	</style>
</head>
<body>
	<div style="width:100%;text-align:center;padding-top:30px;">
		<div id="weixin_qrcode"></div>
		<div style="padding:16px;font-size:16px;color:#999999;">
		<?php if($AJ_TOUCH) { ?>
		<a href="http://www.aijiacms.com/tool/scan.html" rel="external" style="color:#2E7DC6;text-decoration:none;">如何扫描？</a>&nbsp;&nbsp;|&nbsp;&nbsp;
		<?php } ?>
		<a href="<?php echo $MODULE[2]['linkurl'].$AJ['file_login'];?>" style="color:#2E7DC6;text-decoration:none;">取消并返回</a>
		</div>
	</div>
	<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
	<script type="text/javascript">
	var obj = new WxLogin({
		id:"weixin_qrcode", 
		appid: "<?php echo WX_ID;?>", 
		scope: "snsapi_login", 
		redirect_uri: "<?php echo urlencode(WX_CALLBACK);?>",
		state: "",
		style: "",
		href: ""
	});
	</script>
</body>
</html>