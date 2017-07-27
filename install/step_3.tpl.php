<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include IN_ROOT.'/header.tpl.php';
?>
<script language="JavaScript" src="images/jquery.min.js"></script>
  <div class="box">
  <div class="insdirbg">
  <div class="insjd03"></div>
  <div class="insdir_l">
  <div class="t1 by"></div> <div class="t2 by"></div>
  <div class="insdir_lbh">
  <ul>
    <li>1、安装须知</li>
    <li>2、软件许可协议</li>
    <li class="dir">3、运行环境检测</li>
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
  <table width="646px" border="0" cellspacing="1" cellpadding="0" class="table">
                  <tr>
                    <td width="18%"><strong>检查项目</strong></td>
                    <td width="36%"><strong>当前环境</strong></td>
                    <td width="28%"><strong>安装建议</strong></td>
                    <td width="18%"><strong>功能影响</strong></td>
                  </tr>
                  <tr>
                    <td>操作系统</td>
                    <td><?php echo strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'?'Windows操作系统':'unix操作系统';?></td>
                    <td>Windows_NT/Linux/Freebsd</td>
                    <td><font color="red">√</font></td>
                  </tr>
                  <tr>
                    <td>web 服务器</td>
                    <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
                    <td>Apache/IIS</td>
                    <td><font color="red">√</font></td>
                  </tr>
                  <tr>
                    <td>php 版本</td>
                    <td>php <?php echo phpversion();?></td>
                    <td>php 5.0.0 及以上</td>
                    <td><?php if(phpversion() >= '5.0.0'){ ?><font color="red">√<?php }else{ ?><font color="red">无法安装</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>支持 mysql</td>
                    <td><?php echo $PHP_MYSQL;?></td>
                    <td>必须支持</td>
                    <td><?php if(extension_loaded('mysql')){ ?><font color="red">√</font><?php }else{ ?><font color="red">无法安装</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>gd 扩展</td>
                    <td><?php echo $PHP_GD;?></td>
                    <td>jpg gif png</td>
                    <td><?php if(extension_loaded('gd')&&function_exists('imagecreate')){ ?><font color="red">√</font><?php }else{ ?><font color="red">不支持缩略图和水印</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>URL打开文件</td>
                    <td><?php echo $PHP_URL ? '支持' : '不支持';?></td>
                    <td>支持</td>
                    <td><?php if(extension_loaded('iconv') || extension_loaded('mbstring')){ ?><font color="red">√</font><?php }else{ ?><font color="red">建议开启</font><?php }?></td>
                  </tr>

                 
                  <tr>
                    <td>allow_url_fopen</td>
                    <td><?php echo ini_get('allow_url_fopen')?'√':'×';?></td>
                    <td>建议打开</td>
                    <td><?php if(ini_get('allow_url_fopen')){ ?><font color="red">√</font><?php }else{ ?><font color="red">不支持保存远程图片或采集</font><?php }?></td>
                  </tr>
                </table>
  </div>
</div>
    <div class="t2 bs"></div> <div class="t1 bs"></div>
  </div>
  </div>

      <div class="ins_rin" align="center">
     <form id="install" action="index.php?" method="post">
	<input type="hidden" name="step" value="4">
    <span><input onClick="javascript:history.back(-1);" type="button" name="step" value="返回上一步"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;'/></span> <span><input onClick="$('#install').submit();" type="button" name="step" value="通过检测继续"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;' <?php if(!$pass) echo ' disabled';?>/></span>
    </form>
      </div>


  </div>
</div>
</body>
</html>
