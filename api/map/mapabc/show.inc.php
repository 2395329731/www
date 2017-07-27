<?php
defined('IN_AIJIACMS') or exit('Access Denied');
?>
<iframe src="<?php echo AJ_PATH;?>api/map/mapabc/show.php?company=<?php echo urlencode($COM['company']);?>&address=<?php echo urlencode($COM['address']);?>&map=<?php echo $map;?>" style="width:99%;height:<?php echo $map_height;?>px;" scrolling="no" frameborder="0"></iframe>