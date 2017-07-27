<?php 


defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/member/common.inc.php';
require AJ_ROOT.'/module/member/member.class.php';
require AJ_ROOT.'/include/post.func.php';
if(!check_group($_groupid, $MOD['group_search'])) {
	$head_title = lang('message->without_permission');
	include template('noright', 'message');
	exit;
}
//$action = $_REQUEST['action'];


function charsetIconv($vars,$from='utf-8',$to='gbk') {
	if (is_array($vars)) {
		$result = array();
		foreach ($vars as $key => $value) {
			$result[$key] = charsetIconv($value);
		}
	} else {
		$result = iconv($from,$to, $vars);
	}
	return $result;
}
//$_GET["q"] = charsetIconv($_GET["q"]);
$q = $_GET["q"];

$biao=$AJ_PRE.'company';
$hsall=$AJ_PRE.'area';
$ARE = $db->get_one("SELECT child,arrchildid FROM $hsall ");
 //$condition .= $ARE['child'] ? "  areaid IN (".$ARE['arrchildid'].") AND" : " areaid=$cityid AND ";
$result = $db->query("SELECT * FROM $biao WHERE $condition groupid=7 and (company like '%".$q."%' or letter like '%".$q."%') ");


while ($rows = mysql_fetch_array($result)) {
			$rowss[] = $rows;
		}
		
		

		$str = "";

foreach ($rowss as $key=>$value) {
		if($value['company']){
			
			$str .= $value['company']."|".$value['userid']."\n";
		}else{
			$str .= $value['company']."|".$value['userid']."\n";
		}
	}

	$str .= $q."\n独立经纪人";
		echo $str;







?>