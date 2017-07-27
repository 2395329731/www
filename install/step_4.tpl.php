<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include IN_ROOT.'/header.tpl.php';
?>
<script language="JavaScript" src="images/jquery.min.js"></script>
  <div class="box">
  <div class="insdirbg">
  <div class="insjd04"></div>
  <div class="insdir_l">
  <div class="t1 by"></div> <div class="t2 by"></div>
  <div class="insdir_lbh">
  <ul>
    <li>1、安装须知</li>
    <li>2、软件许可协议</li>
    <li>3、运行环境检测</li>
    <li  class="dir">4、文件权限检测</li>
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
  <p><strong><span><?php echo $step;?>：</span>文件权限检测</strong></p>	
         <p> 开始文件权限检测...
	<table cellpadding="4" cellspacing="1" width="100%" bgcolor="#F1F1F1">
	<tr bgcolor="#C0C0C0" align="center">
	<td width="15%">目录/文件</td>
	<td width="8%">属性</td>
	<td width="15%">目录/文件</td>
	<td width="8%">属性</td>
	<td width="15%">目录/文件</td>
	<td width="8%">属性</td>
	</tr>
	<?php foreach($FILES as $k=>$v) { ?>
	<?php if($k%3 == 0) { ?>
	<tr bgcolor="#D4D0C8" align="center">
	<?php } ?>
	<td align="left">&nbsp;<?php echo $v['name'];?></td>
	<td><?php echo $v['write'] ? '<span style="color:blue;">可写</span>' : '<span style="color:red;">不可写</span>';?></td>
	<?php if($k%3 == 2) { ?>
	</tr>
	<?php } ?>
	<?php } ?>
	</table>
	<br/>
	<?php
	if($pass) {
		echo '&nbsp;&nbsp;目录/文件属性通过检测，请点 下一步(N) 继续安装';
	} else {
		echo '<br/>&nbsp;&nbsp;<span style="color:red;">目录/文件属性未通过检测，安装无法进行!</span> <br/><br/>&nbsp;&nbsp;';
		if($ISWIN) {
			echo '请设置不可写目录/文件(含子目录及文件)写入权限';
		} else {
			echo '请设置不可写目录/文件(含子目录及文件)属性为可写('.AJ_CHMOD.')';
		}
	}
	?>
    
	 
  </div>
</div>
    <div class="t2 bs"></div> <div class="t1 bs"></div>
  </div>
  </div>

      <div class="ins_rin" align="center">
     <form id="install" action="index.php?" method="post">
	<input type="hidden" name="step" value="5">
    <span><input onClick="javascript:history.back(-1);" type="button" name="step" value="返回上一步"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;'/></span> <span><input onClick="$('#install').submit();" type="button" name="step" value="通过检测继续"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;' <?php if(!$pass) echo ' disabled';?>/></span>
    </form>
      </div>


  </div>
</div>
</body>
</html>
