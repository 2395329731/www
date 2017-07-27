<?php  header("content-type:text/html; charset=gbk");


defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/newhouse/common.inc.php';
require AJ_ROOT.'/module/newhouse/newhouse.class.php';
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
$_GET["q"] = charsetIconv($_GET["q"]);
$q = $_GET["q"];
$biao=$AJ_PRE.'newhouse';
if($action == 'getBoroughList'){
$result = $db->query("SELECT * FROM $biao WHERE isnews=1 and title like '%".$q."%' or letter like '%".$q."%'");

while ($rows = mysql_fetch_array($result)) {
			$rowss[] = $rows;
		}
		
		

		$str = "";

foreach ($rowss as $key=>$value) {
		if($value['title']){
			
			$str .= $value['title']."|".$value['itemid']."|".$value['address']."|".$value['areaid']."\n";
		}else{
			$str .= $value['title']."|".$value['itemid']."|".$value['address']."|".$value['areaid']."\n";
		}
	}

	$str .= "我要创建新小区|addBorough|addBorough\n";
		echo $str;
  
}

	
elseif($action == 'saveBorough'){
$_POST = charsetIconv($_POST);

$_POST['username'] =$_username;
$do = new newhouse(6);

    if(!$exest_id = $do->checkNameUnique($_POST['borough_name'])){

       if($borough_id = $do->addBorough($_POST)){
			echo 'success|'.$id;
		   }else{
			echo 0;
		           }
		
	}else{
		echo $exest_id."|-1";
	}


	}





?>