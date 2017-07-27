<?php
defined('IN_AIJIACMS') or exit('Access Denied');
?>
<iframe src="<?php echo AJ_PATH;?>api/map/baidu/show.php?itemid=<?php echo urlencode($item['itemid']);?>&title=<?php echo urlencode($item['title']);?>&address=<?php echo urlencode($item['address']);?>&map=<?php echo $map;?>" style="width:99%;height:<?php echo $map_height;?>px;" scrolling="no" frameborder="0"></iframe>