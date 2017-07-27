<?php  

require '../common.inc.php';
require AJ_ROOT.'/include/post.func.php';

$_GET = safe_replace($_GET);
$_POST = safe_replace($_POST);
$biao=$AJ_PRE.'newhouse_6';
if($action == 'house'){
$condition = 'status=3 and isnew=1';
$keyword = safe_replace(trim($_GET['key']));
$callback = trim($_GET['callback']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";
}
else
{
$condition.= " and (title like '%$keyword%' or address like '%$keyword%')";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$v['title'] = unicode_encode($v['title']);
$v['address'] = unicode_encode($v['address']);
$r = array('hid'=>$v['itemid'],'name'=>$v['title'],'address'=>$v['address']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
}
if($action == 'xiaoqu'){
$condition = 'status=3 ';
$keyword = safe_replace(trim($_GET['key']));
$callback = trim($_GET['callback']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";
}
else
{
$condition.= " and (title like '%$keyword%' or address like '%$keyword%')";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$v['title'] = unicode_encode($v['title']);
$v['address'] = unicode_encode($v['address']);
$r = array('hid'=>$v['itemid'],'name'=>$v['title'],'address'=>$v['address']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
}

// 选择小区
if($action == 'xq'){
$condition = 'status=3 ';
$keyword = safe_replace(trim($_GET['query']));
$callback = trim($_GET['callback']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";
}
else
{
$condition.= " and (title like '%$keyword%' or address like '%$keyword%')";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$v['title'] = unicode_encode($v['title']);
$v['address'] = unicode_encode($v['address']);
if($v['map']){$map=$v['map'];}
else{
$map=getCoordinate(trimall(area_poss($v['areaid'], ' ')).$v['address']);}
$r = array('hid'=>$v['itemid'],'name'=>$v['title'],'address'=>$v['address'],'map'=>$map,'areaid'=>$v['areaid']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
}
//楼盘
if($action == 'loupan'){
$condition = 'status=3 and isnew=1';
$keyword = safe_replace(trim($_GET['query']));
$callback = trim($_GET['callback']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";
}
else
{
$condition.= " and (title like '%$keyword%' or address like '%$keyword%')";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$v['title'] = unicode_encode($v['title']);
$v['address'] = unicode_encode($v['address']);
$r = array('hid'=>$v['itemid'],'name'=>$v['title'],'address'=>$v['address']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
}
//分销楼盘
if($action == 'fxlp'){
$condition = 'status=3 and isnew=1 and isfx=1  ';
$keyword = safe_replace(trim($_GET['key']));
$callback = trim($_GET['callback']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";
}
else
{
$condition.= " and (title like '%$keyword%' or address like '%$keyword%' or itemid=$hid)";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$v['title'] = unicode_encode($v['title']);
$v['address'] = unicode_encode($v['address']);
$r = array('hid'=>$v['itemid'],'name'=>$v['title'],'address'=>$v['address']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
}
//推荐楼盘

if($action == 'tuijian'){
$_POST['username'] =$_username;
$_POST['hids']=implode(',',$_POST['hids']);
$_POST['hname']=implode(',',$_POST['hname']);
$_POST['areaids']=implode(',',$_POST['areaids']);
foreach(explode(',', $_POST['hids']) as $v) {$db->query("UPDATE {$AJ_PRE}newhouse_6 SET star0=star0+1 WHERE itemid=$v");}		
   foreach($_POST as $k=>$v)
	   {
		   $_POST[$k]=(!get_magic_quotes_gpc ())?addslashes (trim($v)) :trim($v);
		   //$_POST[$k]=iconv("UTF-8","GBK//IGNORE",$_POST[$k]);
	   }
	     $db->query("insert into {$AJ_PRE}fenxiao(`truename`,`mobile`,`house`,`hname`,`note`,`areaid`,`tuijian`,`addtime`,`status`) values('".$_POST['truename']."','".$_POST['mobile']."','".$_POST['hids']."','".$_POST['hname']."','".$_POST["info"]."','".$_POST["areaids"]."','".$_POST["username"]."',".time().",0)");
	 	
	  	
	   if($db->insert_id())
	   

       echo json_encode(array('data'=>'1','alert'=>'推荐成功！现在可以查看<a href="client.php">推荐记录</a>，也可以<a href="tuijian.php">继续推荐</a>'));
	   else
	     echo json_encode(array('data'=>'0','alert'=>'推荐失败！'));
}
//预约看房

if($action == 'yuyue'){
$_POST['title']=addslashes($title);
$_POST['touser']=$touser;
$_POST['fromuser']=$fromuser;
$_POST['content']=addslashes($content);
$_POST['telephone']=$telephone;
$_POST['truename']=$truename;
$_POST['linkurl']=$linkurl;
$db->query("UPDATE {$AJ_PRE}member SET message=message+1 WHERE username='$touser'");
  $db->query("INSERT INTO {$AJ_PRE}message (title,typeid,touser,fromuser,content,addtime,ip,status,telephone,truename,sex,email,linkurl) VALUES ('$title', 3,'$touser','$fromuser','$content','$AJ_TIME','$AJ_IP',3,'$telephone','$truename','$sex','$email','$linkurl')");
		
   
	   if($db->insert_id())

       echo json_encode(array('state'=>'succ'));
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'预约失败！'));
}

//发送验证码
if($action =='sends') {
$_REQUEST['mobile']=$mobile;
$_REQUEST['encode']=$encode;
$_REQUEST['content']=$content;
$r = $db->get_one("SELECT encode FROM {$db->pre}sms WHERE mobile=$mobile order by itemid desc");
$mobile_code=$r['encode'];
	if($mobile_code ==$encode) {
                $content = strip_sms($content);
				$word = word_count($content);
				send_sms($mobile, $content, $word);
				$json_str = json_encode(array('state'=>'succ','alert'=>'发送成功！'));
				}
				else
				{	$json_str = json_encode(array('state'=>'error','alert'=>'您的手机验证码错误！'));
                                    
									  }
    

		
echo $callback."(".$json_str.")";
	  
	
	}
	//发送验证码
if($action =='sendscode') {
$MEB = cache_read('module-2.php');
$mobile = isset($mobile) ? trim($mobile) : '';
	if(!is_mobile($mobile)) exit('2');
		isset($_SESSION['mobile_send']) or $_SESSION['mobile_send'] = 0;
		if($_SESSION['mobile_time'] && $AJ_TIME - $_SESSION['mobile_time'] < 180) exit('5');
		if($_SESSION['mobile_send'] > 4) exit('6');
        $mobilecode = random(6, '0123456789');
		$_SESSION['mobile'] = $mobile;
		$_SESSION['mobile_code'] = md5($mobile.'|'.$mobilecode);
		$_SESSION['mobile_time'] = $AJ_TIME;
		$_SESSION['mobile_send'] = $_SESSION['mobile_send'] + 1;

     $content = lang('sms->sms_code', array($mobilecode, $MEB['auth_days'])).$AJ['sms_sign'];
       send_sms($mobile, $content, $mobilecode);
		
		 $json_str =  json_encode(array('state'=>'succ','alert'=>'发送成功！'));

		
		
		
		
		
echo $callback."(".$json_str.")";
	  
	
	}
//团购报名

if($action == 'groupbuy'){
$_POST['title']=addslashes($title);
$_POST['touser']=$touser;
$_POST['fromuser']=$fromuser;
$_POST['content']=addslashes($title);
//$_POST['mobile']=$mobile;
$_POST['telephone']=$telephone;
$_POST['truename']=$truename;
$_POST['email']=$email;
$_POST['linkurl']=$linkurl;
$db->query("UPDATE {$AJ_PRE}member SET message=message+1 WHERE username='$touser'");
  $db->query("INSERT INTO {$AJ_PRE}message (title,typeid,touser,fromuser,content,addtime,ip,status,telephone,truename,sex,email,linkurl) VALUES ('$title', 1,'$touser','$fromuser','$content','$AJ_TIME','$AJ_IP',3,'$telephone','$truename','$sex','$email','$linkurl')");
		
   
	   if($db->insert_id())

       echo json_encode(array('state'=>'succ'));
	   else
	     echo json_encode(array('state'=>'0','alert'=>'预约失败！'));
}
//手机版团购报名
//团购报名

if($action == 'wapgroup'){
$_POST['title']=addslashes($title);
$_POST['touser']=$touser;
$_POST['fromuser']=$fromuser;
$_POST['content']=addslashes($title);
$_POST['mobile']=$mobile;
$_POST['truename']=$truename;
$_POST['email']=$email;
$_POST['linkurl']=$linkurl;
$db->query("UPDATE {$AJ_PRE}member SET message=message+1 WHERE username='$touser'");
  $db->query("INSERT INTO {$AJ_PRE}message (title,typeid,touser,fromuser,content,addtime,ip,status,telephone,truename,sex,email,linkurl) VALUES ('$title', 1,'$touser','$fromuser','$content','$AJ_TIME','$AJ_IP',3,'$mobile','$truename','$sex','$email','$linkurl')");
		
   
	   if($db->insert_id())

     echo json_encode(array('state'=>'succ','alert'=>'提交成功！'));
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'提交失败！'));
}

//手机版推荐看房

if($action == 'waptuijian'){
$_POST['tuijian'] =$_POST['tuijian'];
$_POST['hids']=$_POST['hids'];
$_POST['hname']=$_POST['hname'];
$_POST['areaids']=implode(',',$_POST['areaids']);
foreach(explode(',', $_POST['hids']) as $v) {$db->query("UPDATE {$AJ_PRE}newhouse_6 SET star0=star0+1 WHERE itemid=$v");}		
   foreach($_POST as $k=>$v)
	   {
		   $_POST[$k]=(!get_magic_quotes_gpc ())?addslashes (trim($v)) :trim($v);
		   //$_POST[$k]=iconv("UTF-8","GBK//IGNORE",$_POST[$k]);
	   }
	     $db->query("insert into {$AJ_PRE}fenxiao(`truename`,`mobile`,`house`,`hname`,`note`,`areaid`,`tuijian`,`addtime`,`status`) values('".$_POST['truename']."','".$_POST['mobile']."','".$_POST['hids']."','".$_POST['hname']."','".$_POST["info"]."','".$_POST["areaids"]."','".$_POST["tuijian"]."',".time().",0)");
	 	
	  	
	   if($db->insert_id())
	   
  echo json_encode(array('state'=>'succ','alert'=>'提交成功！'));
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'提交失败！'));
}
//看房团

if($action == 'kanfang'){
$_GET['lp']=addslashes($lp);
$title='看房团招募-楼盘：'.$lp;
$username=$_username ? $_username : '游客';
$content=$title;
$_GET['mobile']=$mobile;
$_GET['truename']=$truename;
$_GET['hids']=$hids;
  $db->query("INSERT INTO {$AJ_PRE}guestbook (title,username,content,addtime,ip,status,telephone,truename,hids,lp) VALUES ('$title','$username','$content','$AJ_TIME','$AJ_IP',2,'$mobile','$truename','$hids','$lp')");
		
   
	   if($db->insert_id())

       echo json_encode(array('state'=>'succ','alert'=>'提交成功！'));
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'提交失败！'));
}
//免费获取2份设计方案

if($action == 'jia'){
$title='免费获取2份设计方案报名';
$username=$_username ? $_username : '游客';
$content=$title;
$_GET['mobile']=$mobile;
$_GET['truename']=$truename;
  $db->query("INSERT INTO {$AJ_PRE}guestbook (title,username,content,addtime,ip,status,telephone,truename) VALUES ('$title','$username','$content','$AJ_TIME','$AJ_IP',2,'$mobile','$truename')");
		
   
	   if($db->insert_id())

       echo json_encode(array('state'=>'succ','alert'=>'提交成功！'));
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'提交失败！'));
}
// 中介
if($action == 'company'){
$biao=$AJ_PRE.'company';
$condition = 'groupid=7 ';
$keyword = safe_replace(trim($_GET['query']));
$callback = trim($_GET['callback']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (company like '%$keyword%' or letter like '%$keyword%' )";
}
else
{
$condition.= " and (company like '%$keyword%' or address like '%$keyword%')";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY userid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['company']=str_replace('·', '%26%23183%3b', $v['company']);
$v['company'] = unicode_encode($v['company']);
$v['address'] = unicode_encode($v['address']);
$r = array('hid'=>$v['userid'],'name'=>$v['company'],'address'=>$v['address']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
}

//增加小区

if($action == 'addcommunity'){
$_POST['communityname']=addslashes($communityname);
$_POST['areaid']=$areaid;
$quyu=$_POST['city'].$_POST['areaname'];
$address = str_replace($quyu,'',$_POST['address']);
$letter = GetPinyin($communityname);
$pinyin = Pinyin($communityname);
$map=$_POST['longcoor'].','.$_POST['laticoor'];
$_POST['linkurl']=$linkurl;
  $db->query("INSERT INTO {$AJ_PRE}newhouse_6 (title,areaid,catid,address,map,addtime,ip,status,linkurl,letter,pinyin) VALUES ('$communityname', '$areaid',1,'$address','$map','$AJ_TIME','$AJ_IP',3,'$linkurl','$letter','$pinyin')");
		 $itemid = $db->insert_id();
        $db->query("INSERT INTO {$AJ_PRE}newhouse_data_6 (itemid,content) VALUES ('$itemid', '$title')");
		   $linkurl = $itemid.'/';
			$db->query("UPDATE {$AJ_PRE}newhouse_6 SET  linkurl='$linkurl' where itemid=$itemid");
	  if($itemid)
     
     echo json_encode(array('state'=>'succ','name'=>$communityname,'id'=>$itemid,'address'=>$address,'areaid'=>$areaid,'map'=>$map,'alert'=>'添加成功！'));
	
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'添加失败！'));
}
//关联地图

if($action == 'map'){

echo getCoordinate(trimall(area_poss($_GET['areaid'], ' ')).$_GET['address']);

}

//发布二手房

if($action == 'fabusale'){

	$fields = array(
				'title' => $title,
				);
			$fields = dhtmlspecialchars($fields);
		
			$keyword = $communityname.','.$price.','.$address.','.$area.',';
			$title = $communityname.','.$area.'平米'.$price.$unit;
			$fields['title'] = $title;
		    $fields['adddate'] = timetodate($AJ_TIME, 3);
			$fields['price'] = $price;
			$fields['telephone'] = trim($mobile);
			$fields['truename'] = $surname;
			$fields['catid'] = 8;
			$fields['areaid'] = $areaid;
			$fields['map'] = $map;
			$fields['address'] = $address;
			$fields['truename'] = $username;
			$fields['mobile'] = $mobile;
			$fields['room'] = $room;
			$fields['hall'] = $hall;
			$fields['balcony'] = $toilet;
			$fields['houseearm'] = $area;
			$fields['housename'] = $communityname;
			$fields['houseid'] = $cid;
			$fields['keyword'] = $keyword;
			$fields['typeid'] = 0;
			$fields['status'] = 2;
			$fields['ip'] = $AJ_IP;
			$fields['addtime'] = $AJ_TIME;
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			$db->query("INSERT INTO {$AJ_PRE}sale_5 ($sqlk) VALUES ($sqlv)");
			$itemid = $db->insert_id();
		   $db->query("INSERT INTO {$AJ_PRE}sale_data_5 (itemid,content) VALUES ('$itemid', '$title')");
		   $linkurl = 'show-'.$itemid.'.html';
			$db->query("UPDATE {$AJ_PRE}sale_5 SET  linkurl='$linkurl' where itemid=$itemid");
			
          if($itemid)
           echo json_encode(array('state'=>'succ','alert'=>'提交成功！','href'=>$MODULE[2]['linkurl'].'publish.php?&action=sucess'));
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'提交失败！'));
	  
}
//发布租房

if($action == 'faburent'){

	$fields = array(
				'title' => $title,
				);
			$fields = dhtmlspecialchars($fields);
		
			$keyword = $communityname.','.$price.','.$address.','.$area.',';
			$title = $communityname.','.$area.'平米'.$price.$unit;
			$fields['title'] = $title;
		    $fields['adddate'] = timetodate($AJ_TIME, 3);
			$fields['price'] = $price;
			$fields['telephone'] = trim($mobile);
			$fields['truename'] = $surname;
			$fields['catid'] = 13;
			$fields['areaid'] = $areaid;
			$fields['map'] = $map;
			$fields['address'] = $address;
			$fields['truename'] = $username;
			$fields['mobile'] = $mobile;
			$fields['room'] = $room;
			$fields['hall'] = $hall;
			$fields['balcony'] = $toilet;
			$fields['houseearm'] = $area;
			$fields['housename'] = $communityname;
			$fields['houseid'] = $cid;
			$fields['keyword'] = $keyword;
			$fields['typeid'] = 0;
			$fields['status'] = 2;
			$fields['renttype'] = 1;
			$fields['ip'] = $AJ_IP;
			$fields['addtime'] = $AJ_TIME;
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			$db->query("INSERT INTO {$AJ_PRE}rent_7 ($sqlk) VALUES ($sqlv)");
			$itemid = $db->insert_id();
		   $db->query("INSERT INTO {$AJ_PRE}rent_data_7 (itemid,content) VALUES ('$itemid', '$title')");
		   $linkurl = 'show-'.$itemid.'.html';
			$db->query("UPDATE {$AJ_PRE}rent_7 SET  linkurl='$linkurl' where itemid=$itemid");
			
          if($itemid)
           echo json_encode(array('state'=>'succ','alert'=>'提交成功！','href'=>$MODULE[2]['linkurl'].'publish.php?&action=sucess'));
	   else
	     echo json_encode(array('state'=>'fals','alert'=>'提交失败！'));
	  
}
// 选择小区
if($action == 'xzxq'){
$condition = 'status=3 ';
$keyword = safe_replace(trim($_GET['key']));
$callback = trim($_GET['callback']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";
}
else
{
$condition.= " and (title like '%$keyword%' or address like '%$keyword%')";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$v['title'] = unicode_encode($v['title']);
$v['address'] = unicode_encode($v['address']);
$r = array('cid'=>$v['itemid'],'name'=>$v['title'],'address'=>$v['address'],'areaid'=>$v['areaid'],'map'=>$v['map']);
$json[] = JSON($r);
}
$json_str = implode(',',$json);
}

echo $callback."([".$json_str."])";
}
//小区选择
if($action == 'community'){
$condition = 'status=3';
$keyword = safe_replace(trim($_GET['query']));
$action = trim($_GET['community']);
$pn = intval($_GET['pn']);
$p = '/^[a-z]+$/i';
if(preg_match($p,$keyword))
{
$condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";
}
else
{
$condition.= " and (title like '%$keyword%' or address like '%$keyword%')";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{ 
foreach($tags AS $k=>$v) {
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$v['title'] = unicode_encode($v['title']);
$v['address'] = unicode_encode($v['address']);
$address[] = "\"".$v['address']."\"";
$title[] = "\"".$v['title'].'<span>'.$v['address'].'<\/span>'."\"";
$id[] = $v['itemid'];
}
$address = implode(',',$address);
$xml_str = implode(',',$title);
$ids = implode(',',$id);

}
echo "{\"query\":\"".$keyword."\",\"suggestions\":[".$xml_str."],\"mainadds\":[".$address."],\"mainids\":[".$ids."]}";
}

//楼盘地图
if($action == 'getaround'){
$x1 = $_GET['minY'];
$x2 = $_GET['maxY'];
$y1 = $_GET['minX'];
$y2 = $_GET['maxX'];
$condition = "status=3 and isnew=1 and map<>''";
$selltime = $_POST['selltime'];
$typeid = $_POST['typeid'];
if (isset($typeid) &&!empty($typeid))
{
//$condition.=" and `typeid` in ($typeid)";
}
$districts = $_POST['districts'];
$params = $_POST['params'];
$purposes = intval($_POST['purposes']);
$sort = $_POST['sort'];
if (isset($sort) &&!empty($sort))
{
if($sort=="pa")
{
$order = "price asc";
}
elseif($sort=="pd")
{
$order = "price desc";
}
}
$random = $_POST['random'];
if (isset($purposes) &&!empty($purposes))
{
//$condition..=" and `type` like '%$purposes%'";
}
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
		
if($tags)
{
$json = array();
foreach($tags AS $k=>$v) {
$map = explode(',',$v['map']);
foreach($map as $key =>$value){
		  $lngX =$map['0'];
		   $latY=$map['1']; 
		   }

if(($lngX>$x1) &&($lngX<$x2) &&($latY>$y1) &&($latY<$y2))
{
$v['title']=str_replace('·', '%26%23183%3b', $v['title']);
$title = unicode_encode($v['title']);
$address = unicode_encode($v['address']);
$r = array('lat'=>$latY,'lng'=>$lngX,'title'=>$title,'address'=>$address,'raw_id'=>$v['id']);
$json[] = JSON($r);
}
else
{
continue;
}
}
$json_str .= "[";
$json_str .= implode(',',$json);
$json_str .= "]";
echo $json_str;
}
else
{
$json_str ="{status:\"1\",allnum:\"0\",maxpage:\"0\",pagenow:\"0\",hits:{";
$json_str .= "hit:[";
$json_str .= "]}}";
echo $json_str;
}
}
function arrayRecursive(&$array,$function,$apply_to_keys_also = false)
{
foreach ($array as $key =>$value) {
if (is_array($value)) {
arrayRecursive($array[$key],$function,$apply_to_keys_also);
}else {
$array[$key] = $function($value);
}
if ($apply_to_keys_also &&is_string($key)) {
$new_key = $function($key);
if ($new_key != $key) {
$array[$new_key] = $array[$key];
unset($array[$key]);
}
}
}
}
function JSON($array) {
arrayRecursive($array,'urlencode',true);
$json = json_encode($array);
return urldecode($json);
}
function unicode_encode($name)
{
$name = urldecode($name);
$name = iconv('UTF-8','UCS-2BE',$name);
$len = strlen($name);
$str = '';
for ($i = 0;$i <$len -1;$i = $i +2)
{
$c = $name[$i];
$c2 = $name[$i +1];
if (ord($c) >0)
{
$str .= '\u'.base_convert(ord($c),10,16).str_pad(base_convert(ord($c2),10,16),2,0,STR_PAD_LEFT);
}
else
{
$str .= $c2;
}
}
return $str;
}


?>