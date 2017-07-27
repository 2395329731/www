<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include IN_ROOT.'/header.tpl.php';
?>

  <div class="box">
  <div class="insdirbg">
  <div class="insjd05"></div>
  <div class="insdir_l">
  <div class="t1 by"></div> <div class="t2 by"></div>
  <div class="insdir_lbh">
  <ul>
    <li>1、安装须知</li>
    <li>2、软件许可协议</li>
    <li>3、运行环境检测</li>
    <li >4、文件权限检测</li>
    <li  class="dir">5、帐号设置</li>
     <li>6、即将完成</li>
	<li>7、安装完成</li>
    </ul></div>
    <div class="t2 by"></div> <div class="t1 by"></div>
  </div>
  <div class="insdir_r">
  <div class="t1 bs"></div> <div class="t2 bs"></div>
  <div class="insdir_rbh">
   <div id="introducetd">
<iframe id="db_tester" name="db_tester" style="display:none;"></iframe>
<form action="index.php" method="post" id="db_form" target="db_tester">
<input type="hidden" name="step" value="db_test"/>
<input type="hidden" name="tdb_host" id="tdb_host"/>
<input type="hidden" name="tdb_user" id="tdb_user"/>
<input type="hidden" name="tdb_pass" id="tdb_pass"/>
<input type="hidden" name="tdb_name" id="tdb_name"/>
<input type="hidden" name="ttb_pre" id="ttb_pre"/>
<input type="hidden" name="ttb_test" id="ttb_test"/>
</form>
<script type="text/javascript">
function test() {
	if($('db_host').value == '') {
		alert('请填写数据库服务器');
		$('db_host').focus();
		return;
	}
	$('tdb_host').value = $('db_host').value;

	if($('db_user').value == '') {
		alert('请填写数据库用户名');
		$('db_user').focus();
		return;
	}
	$('tdb_user').value = $('db_user').value;
	$('tdb_pass').value = $('db_pass').value;

	if($('db_name').value == '') {
		alert('请填写数据库名');
		$('db_name').focus();
		return;
	}
	$('tdb_name').value = $('db_name').value;

	if($('tb_pre').value == '') {
		alert('请填写数据表前缀');
		$('tb_pre').focus();
		return;
	}
	$('ttb_pre').value = $('tb_pre').value;
	$('db_form').submit();
}
function check() {
	if($('db_host').value == '') {
		alert('请填写数据库服务器');
		$('db_host').focus();
		return false;
	}

	if($('db_user').value == '') {
		alert('请填写数据库用户名');
		$('db_user').focus();
		return false;
	}

	if($('db_name').value == '') {
		alert('请填写数据库名');
		$('db_name').focus();
		return false;
	}

	if($('tb_pre').value == '') {
		alert('请填写数据表前缀');
		$('tb_pre').focus();
		return false;
	}

	if($('username').value.length < 4) {
		alert('超级管理员户名最少4位');
		$('username').focus();
		return false;
	}

	if(!$('username').value.match(/^[a-z0-9]+$/)) {
		alert('超级管理员户名只能使用小写字母(a-z)、数字(0-9)');
		$('username').focus();
		return false;
	}

	if($('password').value.length < 6) {
		alert('超级管理员密码最少6位');
		$('password').focus();
		return false;
	}

	if($('email').value.length < 6) {
		alert('请填写超级管理员Email[重要]');
		$('email').focus();
		return false;
	}

	var AJ_path = '<?php echo $AJ_PATH;?>';
	if($('path').value == '') {
		alert('系统安装路径不能为空，如果安装在网站根目录，请填写/ ');
		$('path').focus();
		return false;
	}
	if(AJ_path && $('path').value != AJ_path) {
		if(!confirm('确定要改变系统安装路径?')) {
			$('path').value = AJ_path;
		}
	}
	var AJ_url = '<?php echo $AJ_URL;?>';
	if($('url').value == '') {
		alert('网站访问地址不能为空，请填写当前网站访问地址');
		$('url').focus();
		return false;
	}
	if(AJ_url && $('url').value != AJ_url) {
		if(!confirm('确定要改变网站访问地址?')) {
			$('url').value = AJ_url;
		}
	}

	if($('cookie_pre').value == '') {
		alert('Cookie前缀不能为空');
		$('cookie_pre').focus();
		return false;
	}
	$('tip').style.display = '';
	$('submit').disabled = true;
	return true;
}
</script>
<form action="index.php" method="post" id="dform" onsubmit="return check();">
<input type="hidden" name="step" value="6"/>
   <table width="646px" border="0" cellspacing="1" cellpadding="0" class="table">
  <tr>
    <td colspan="2" align="center"><strong><font style="font-size:14px">填写数据库信息</font></strong></td>
  </tr>
  <tr>
    <td width="18%" align="right">数据库主机：</td>
    <td width="60%">
 <input name="db_host" type="text" id="db_host" value="<?php echo $CFG['db_host'];?>" style="width:150px" class="insput"/></td>
  </tr>
  <tr>
    <td width="18%" align="right">数据库帐号：</td>
    <td width="60%"><input name="db_user" type="text" id="db_user" value="<?php echo $CFG['db_user'];?>" style="width:150px" class="insput"/></td>
  </tr>
  <tr>
    <td width="18%" align="right">数据库密码：</td>
    <td width="60%"><input name="db_pass" type="text" id="db_pass" value="<?php echo $CFG['db_pass'];?>" style="width:150px" class="insput"/></td>
  </tr>
  <tr>
    <td width="18%" align="right">数据库名称：</td>
    <td width="60%"><input name="db_name" type="text" id="db_name" value="<?php echo $CFG['db_name'];?>" style="width:150px" onblur="$('ttb_test').value=0;test();void(0);" class="insput"/></td>
  </tr>
  <tr title="如果一个数据库安装多个aijiacms，请修改表前缀">
    <td width="18%" align="right">数据表前缀：</td>
    <td width="60%"><input name="tb_pre" type="text" id="tb_pre" value="<?php echo $CFG['tb_pre'];?>" style="width:150px" class="insput"/> <font color="#FF3300">不建议修改!</font></td>
  </tr>
  <tr title=>
  
    <td width="18%" align="right">测试数据库连接：</td>
    <td width="60%"><input type="button" value="测试数据库连接" onclick="$('ttb_test').value=1;test();void(0);" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong><font style="font-size:14px">填写管理员信息</font></strong></td>
  </tr>
  <tr>
    <td width="18%" align="right">管理帐号：</td>
    <td width="60%"><input name="username" id="username" type="text" value="aijiacms" style="widtd:120px" class="insput"/> 由2到30个数字，字母，下划线组成！</td>
  </tr>
  <tr>
    <td width="18%" align="right">管理密码：</td>
    <td width="60%"><input name="password" id="password" type="password" value="aijiacms" style="widtd:120px" class="insput"/> 由6到30个数字，字母，下划线组成！<font color="#FF3300">默认为 aijiacms</font></td>
  </tr>
 
  <tr>
    <td width="18%" align="right">E-mail：</td>
    <td width="60%"><input name="email" id="email" type="text" value="mail@yourdomain.com" style="widtd:120px" class="insput"/>
	<input type="hidden" name="step" value="6"></td>
  </tr>
 

   <tr>
    <td width="18%" align="right">网站访问地址：</td>
    <td width="60%"><input name="url" type="text" value="<?php echo $AJ_URL;?>" style="widtd:160px" class="insput"/> <font color="#FF3300"></font></td>
  </tr>
</table>
  </div>
</div>
    <div class="t2 bs"></div> <div class="t1 bs"></div>
  </div>
  </div>

      <div class="ins_rin" align="center">
	
    <span><input onClick="javascript:history.back(-1);" type="button" name="step" value="返回上一步"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;'/></span> <span><input type="submit"  value="确认信息继续"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;'  id="submit"/>
	
	</span>
    </form>

      </div>

  </div>
</div>
</body>
</html>
