<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php include template('header');?>
<div class="m">
<div class="nav">当前位置: <a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> &raquo; <a href="<?php echo AJ_PATH;?><?php echo $linkurl;?>"><?php echo $title;?></a></div>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" class="left_menu">
<ul>
<li class="left_menu_li"><a href="<?php echo $MODULE['1']['linkurl'];?>">网站首页</a></li>
<?php $tags=tag("table=webpage&condition=item='$_item'&areaid=$cityid&pagesize=99&order=listorder desc,itemid desc&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
<li class="left_menu_li" id="webpage_<?php echo $t['itemid'];?>"><a href="<?php if($t['domain']) { ?><?php echo $t['domain'];?><?php } else { ?><?php echo AJ_PATH;?><?php echo $t['linkurl'];?><?php } ?>
"><?php echo $t['title'];?></a></li>
<?php } } ?>
</ul>
</td>
<td valign="top">
<div class="left_box">

<div style="border-bottom:#C0C0C0 1px dotted;margin:5px 15px 5px 15px;line-height:36px;" class="t_c px14"><strong><?php echo $title;?></strong></div>
<div class="content" id="content"><?php echo $content;?></div>
<br/>
</div>
</td>
</tr>
</table>
</div>
<script type="text/javascript">try{Dd('webpage_<?php echo $itemid;?>').className='left_menu_on';}catch(e){}</script>
<?php include template('footer');?>