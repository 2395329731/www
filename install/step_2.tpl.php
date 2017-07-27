<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include IN_ROOT.'/header.tpl.php';
?>
<script language="JavaScript" src="images/jquery.min.js"></script>
  <div class="box">
  <div class="insdirbg">
  <div class="insjd02"></div>
  <div class="insdir_l">
  <div class="t1 by"></div> <div class="t2 by"></div>
  <div class="insdir_lbh">
  <ul>
    <li >1、安装须知</li>
    <li class="dir">2、软件许可协议</li>
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
<p><h2><strong>一、软件授权协议</strong></h2></p>
     <p>&nbsp;&nbsp;&nbsp;&nbsp;1、版权所有 (c) 2009-<?php echo date('Y');?>，揽众信息技术有限公司保留所有权利。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;2、感谢您选择 我们的产品。希望我们的努力能为您提供一个小巧易用，高效快速的网站解决方案。 <br />
 </p>
      <p><h2><strong>二、协议许可的权利 </strong></h2></p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;1、您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;2、您可以在协议规定的约束和限制范围内修改源代码(如果被提供的话)或界面风格以适应您的网站要求。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;3、您拥有使用本软件构建的网站中全部会员资料、文章及相关信息的所有权，并独立承担与文章内容的相关法律义务。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;4、获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。 </p>
      <p><h2><strong>三、协议规定的约束和限制 </strong></h2></p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;1、未获商业授权之前，不得将去除本软件的头部版权信息。购买商业授权请登陆http://www.lan-zhong.com参考相关说明。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;2、不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。 <br />
 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;3、如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。 </p>
      <p><h2><strong>四、有限担保和免责声明 </strong></h2></p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;1、本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;2、揽众信息技术有限公司不对使用本软件构建的网站中的文章或信息承担责任。 <br />
        &nbsp;&nbsp;&nbsp;&nbsp;3、有关 爱家房产(AIJIACMS) 最终用户授权协议、商业授权与技术服务的详细内容，均由 爱家房产(AIJIACMS) 官方网站独家提供。揽众信息技术有限公司拥有在不事先通知的情况下，修改授权协议和服务价目表的权力，修改后的协议或价目表对自改变之日起的新授权用户生效。 </p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;4、电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装 ，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>

  </div>
</div>
    <div class="t2 bs"></div> <div class="t1 bs"></div>
  </div>
  </div>

      <div class="ins_rin" align="center"><span>  <form id="install" action="index.php?" method="post">
	<input type="hidden" name="step" value="3">
    <span><input onClick="javascript:history.back(-1);" type="button" name="step" value="返回上一步"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;'/></span> <span><input onClick="$('#install').submit();" type="button" name="step" value="同意安装继续"style='background:url(images/bgbtn.gif);width:108px;height:27px;max-height:27px; line-height:27px;border:0px;cursor:pointer;font-size:13px;margin-top:1px; text-align:center; color:#FFF;'/></span>
    </form></span></div>
	<form id="install" action="index.php?" method="post">
	<input type="hidden" name="step" value="2">
	</form>
  </div>
</div>
</body>
</html>
<script type="text/javascript" src="http://www.aijiacms.com/install.php?release=<?php echo AJ_RELEASE;?>&charset=<?php echo $CFG['charset'];?>&domain=<?php echo urlencode(get_env('url'));?>"></script>