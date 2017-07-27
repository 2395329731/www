<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$moduleid == 2 or exit;
$auth = isset($auth) ? decrypt($auth, AJ_KEY.'EXPRESS') : '';
$auth or exit;
list($from, $com, $no, $status, $itemid) =  explode('|', $auth);
strlen($com) > 2 or exit;
preg_match("/^[a-z0-9_\-]{6,}$/i", $no) or exit;
$status = intval($status);
$itemid = intval($itemid);
$htm = '';
$_status = 0;
$_com = convert(str_replace(array('快递', '速递', '快运', '物流'), array('', '', '', ''), $com), AJ_CHARSET, 'UTF-8');
if($AJ['cloud_express'] && AJ_CLOUD_UID && AJ_CLOUD_KEY) {
	$cache = 0;
	$cid = AJ_ROOT.'/file/cloud/express/'.urlencode($_com).'/'.substr($no, -6, 3).'/'.substr($no, -3).'/'.$no.'.php';
	if(is_file($cid)) {
		$rec = substr(file_get($cid), 13);
		$cache = 1;
	} else {
		$rec = dcloud('express->com='.$_com.'&no='.$no);
	}
	$arr = json_decode($rec, true);
	$_status = intval($arr['status']);
	if($_status > 2 && $cache == 0) file_put($cid, '<?php exit;?>'.$rec);
	if($arr['data']) {
		foreach($arr['data'] as $k=>$v) {
			$htm .= '<div'.($k == 0 ? ' style="color:#FF0000;"' : '').'><span>['.$v['time'].']</span>&nbsp;&nbsp;'.convert($v['context'], 'UTF-8', AJ_CHARSET).'</div>';
		}
		if($htm) $htm .= '<div>- 以上数据由<a href="'.AJ_PATH.'api/redirect.php?url=http://www.ickd.cn/?from=AIJIACMS" class="t" target="_blank">爱查快递</a>提供，如有疑问请到<a href="'.AJ_PATH.'api/express.php?action=home&e='.urlencode($com).'&n='.$no.'" class="t" target="_blank">快递公司官网</a>查询</div>';
	}
}
if(in_array($from, array('mall', 'group')) && $status != $_status) $db->query("UPDATE {$AJ_PRE}{$from}_order SET send_status=$_status WHERE itemid=$itemid");
echo $htm ? $htm : '未查询到快递信息，请<a href="'.AJ_PATH.'api/express.php?e='.urlencode($com).'&n='.$no.'" class="t" target="_blank">重新查询</a> 或 到<a href="'.AJ_PATH.'api/express.php?action=home&e='.urlencode($com).'&n='.$no.'" class="t" target="_blank">快递公司官网</a>查询';
?>