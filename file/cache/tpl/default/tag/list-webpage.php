<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
| <a href="<?php if($t['domain']) { ?><?php echo $t['domain'];?><?php } else { ?><?php echo linkurl($t['linkurl'], 1);?><?php } ?>
" class="bottom_text2"><?php echo $t['title'];?></a> 
<?php } } ?>