
<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include IN_ROOT.'/header.tpl.php';
?>
<script language="JavaScript" src="images/jquery.min.js"></script>

  <div class="box">
  <div class="insdirbg">
  <div class="insjd01"></div>
  <div class="insdir_l">
  <div class="t1 by"></div> <div class="t2 by"></div>
  <div class="insdir_lbh">
  <ul>
    <li class="dir">1、安装须知</li>
    <li>2、软件许可协议</li>
    <li>3、运行环境检测</li>
    <li>4、文件权限检测</li>
    <li>5、帐号设置</li>
    <li>6、即将完成</li>
	 <li>7、安装完成</li>
    </ul></div>
    <div class="t2 by"></div> <div class="t1 by"></div>
  </div>
  <div class="insdir_r">
  <div class="t1 bs"></div> <div class="t2 bs"></div>
  <div class="insdir_rbh">
  <div id="introducetd">
  <h1><span>1、</span>安装须知</h1>

<h3>（一）<strong>运行环境需求</strong></h3>

			<p>可用的 httpd 服务器（如 Apache，Zeus，IIS 等）</p>
			<p>PHP 5.0.x 及以上 </p>
			<p>Mysql 5.0.x 及以上</p>
	
          <br />
		  <h3>（二）<strong>程序安装步骤</strong></h3>

			<p>第一步：使用ftp工具中的二进制模式将本软件包里的 upload 目录上传至服务器，假设上传后目录仍为 upload；</p>
			<p>第二步：访问 http://yourwebsite/upload/install.php 进入安装程序，根据安装向导提示完成安装；</p>
			<p>第三步：进入网站后台，一键更新，安装完毕！</p>
		 <br />
		  <h3>（三）<strong>使用注意事项</strong></h3>

			<p>二次开发：如果您需要修改程序代码，请用专业的PHP编辑器软件，禁止用记事本打开修改程序文件；</p>
			<p>数据迁移：<font color="#FF0000">如果是数据迁移（二次安装），会员密钥请填写第一次安装时的密钥</font>！</p>
		<br />
		<p>当前版本：<?php echo AJ_VERSION;?> <?php echo strtoupper($CFG['charset']);?> <span id="upgrade_notice" style="color:#FF0000">

  </div>
</div>
    <div class="t2 bs"></div> <div class="t1 bs"></div>
  </div>
  </div>

      <div class="ins_rin" align="center"><span><input onClick="$('#install').submit();" type="button" name="step" value="下 一 步"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;'/></span></div>
	<form id="install" action="index.php?" method="post">
	<input type="hidden" name="step" value="2">
	</form>
  </div>
</div>
</body>
</html>
