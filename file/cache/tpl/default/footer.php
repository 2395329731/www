<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php if(!$AJ_TOUCH) { ?>
<div id="footer">
<p> <a target="_blank" href="<?php echo $MODULE['1']['linkurl'];?>">网站首页</a>
<?php echo tag("table=webpage&condition=item=1&areaid=$cityid&order=listorder desc,itemid desc&template=list-webpage");?>
<span>|</span> <a href="<?php echo $MODULE['1']['linkurl'];?>sitemap/">网站地图</a>
<?php if($EXT['guestbook_enable']) { ?> <span>|</span> <a href="<?php echo $EXT['guestbook_url'];?>">网站留言</a><?php } ?>
<?php if($EXT['ad_enable']) { ?> <span>|</span> <a href="<?php echo $EXT['ad_url'];?>">广告服务</a><?php } ?>
</p>

<p><?php if($AJ['icpno']) { ?>ICP备案号：<?php echo $AJ['icpno'];?><?php } ?>
 客服热线  <?php echo $AJ['telephone'];?>（工作时间：周一至周五8:00至18:00）
<script language=javascript>
window["\x64\x6f\x63\x75\x6d\x65\x6e\x74"]["\x77\x72\x69\x74\x65\x6c\x6e"]("\u8d44\u6e90\u63d0\u4f9b\x3a\x3c\x61 \x68\x72\x65\x66\x3d\"\x68\x74\x74\x70\x3a\/\/\x62\x62\x73\x2e\x67\x6f\x70\x65\x2e\x63\x6e\/\" \x74\x61\x72\x67\x65\x74\x3d\"\x5f\x62\x6c\x61\x6e\x6b\" \x73\x74\x79\x6c\x65\x3d\"\x63\x6f\x6c\x6f\x72\x3a\x23\x33\x33\x36\x36\x30\x30\x3b\" \x3e\x3c\x62\x3e\u72d7\u6251\u6e90\u7801\u793e\u533a\x3c\/\x62\x3e\x3c\/\x61\x3e");
</script>
</p>
<p>  <?php echo $AJ['copyright'];?> </p>
</div>
<?php } ?>
<script type="text/javascript">
<?php if($aijiacms_task) { ?>
show_task('<?php echo $aijiacms_task;?>');
<?php } else { ?>
<?php include AJ_ROOT.'/api/task.inc.php';?>
<?php } ?>
</script>
</body>
</html>