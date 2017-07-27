<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include IN_ROOT.'/header.tpl.php';
?>
 <div class="box">
  <div class="insdirbg">
  <div class="insjd07"></div>
  <div class="insdir_l">
  <div class="t1 by"></div> <div class="t2 by"></div>
  <div class="insdir_lbh">
  <ul>
    <li>1、安装须知</li>
    <li>2、软件许可协议</li>
    <li>3、运行环境检测</li>
    <li>4、文件权限检测</li>
    <li>5、帐号设置</li>
   <li class="dir">6、即将完成</li>
	<li>7、安装完成</li>
    </ul></div>
    <div class="t2 by"></div> <div class="t1 by"></div>
  </div>
  <div class="insdir_r">
  <div class="t1 bs"></div> <div class="t2 bs"></div>
  <div class="insdir_rbh">
  <div id="introducetd">
   <p><strong><span><?php echo $step;?>：</span>安装即将完成</strong></p>	
   <textarea style="width:515px;height:215px;" id="msgbox"> </textarea>
<form action="index.php" method="post" id="dform">
<input type="hidden" name="step" value="7"/>
<input type="hidden" name="url" value="<?php echo $url;?>"/>
<input type="hidden" name="username" value="<?php echo $username;?>"/>
<input type="hidden" name="password" value="<?php echo $password;?>"/>
<input type="hidden" name="step" value="7"/>
<input type="button" value="上一步(P)" onclick="history.back(-1);" disabled/>
<input type="submit" value="下一步(N)"/>
&nbsp;&nbsp;
<input type="button" value="取消(C)" onclick="if(confirm('您确定要退出安装向导吗？')) window.close();"/>
</form>
  </div>
</div>
    <div class="t2 bs"></div> <div class="t1 bs"></div>
  </div>
  </div>
  </div>
</div>
<script type="text/javascript">
$('msgbox').value = '';
<?php
$time = 400;
foreach($msgs as $v) {
?>
setTimeout("$('msgbox').value += ' # <?php echo $v;?>\\n';", <?php echo $time;?>);
<?php
	$time += 200;
}
$time += 200;
?>
setTimeout("$('dform').submit();", <?php echo $time;?>);
</script>
</body>
</html>