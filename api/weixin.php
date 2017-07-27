<?php

require '../common.inc.php';

$weixin_token = $AJ['weixin_token'];
$weixin_reply = $AJ['weixin_reply'];
//$weixin_reply = iconv("GBK","UTF-8",$weixin_reply);
define("TOKEN", $weixin_token);
define("WX_REPLY",$weixin_reply);
$wechatObj = new wechatCallbackapiTest();
if($_GET["echostr"])
{
$wechatObj->valid();
}
if (!empty($GLOBALS["HTTP_RAW_POST_DATA"]))
{
$wechatObj->responseMsg();
}
class wechatCallbackapiTest
{
public function valid()
{
$echoStr = $_GET["echostr"];
if($this->checkSignature()){
echo $echoStr;
exit;
}
}
public function responseMsg()
{
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
if (!empty($postStr)){
$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
$RX_TYPE = trim($postObj->MsgType);
switch ($RX_TYPE)
{
case "text":
$resultStr = $this->receiveText($postObj);
break;
case "location":
$resultStr = $this->receiveLocation($postObj);
break;
case "event":
$resultStr = $this->receiveEvent($postObj);
break;
default:
$resultStr = "unknow msg type: ".$RX_TYPE;
break;
}
echo $resultStr;
}else {
echo "";
exit;
}
}
private function receiveText($object)
{
global $db,$EXT;
$funcFlag = 0;
$keyword = trim($object->Content);
$resultStr = "";
$cityArray = array();
$contentStr = "";
$needArray = false;
$illegal = false;
$saytome = false;
if ($keyword == "Hello2BizUser"){
$contentStr = WX_REPLY;
$resultStr = $this->transmitText($object,$contentStr);
return $resultStr;
}
elseif(stripos($keyword,'楼盘')!==false)
{
$pattern = "|#(.*)#?$|Uis";
if(preg_match_all($pattern,$keyword,$matches))
{
$skeyword = safe_replaces($matches[1][0]);
}
   if(!empty($skeyword))
    {
   if(stripos($skeyword,'楼盘名')!==false)
    {
    $skeyword = str_replace('楼盘名','',$skeyword);
    }

 //搜索楼盘结束
$newhouse=$db->pre.'newhouse_6';
$condition = "status=3 and isnew=1";
$skeyword2 =$skeyword;
//$skeyword2 = iconv("UTF-8","GBK",$skeyword);
$condition.= " and (title like '%$skeyword2%' or letter like '%$skeyword2%' )";
$result = $db->query("SELECT * FROM $newhouse WHERE {$condition} order by itemid desc LIMIT 0,10 ");
	$total = $db->count($newhouse, $condition);
while($r = $db->fetch_array($result)) {
  $tags[] = $r;
		}
if($tags)
        {

   if($total>1)
           {
		   
   foreach($tags AS $k=>$v) {
   //$v['title'] = iconv("GBK","UTF-8",$v['title']);
   $url=$EXT[wap_url].'index.php?moduleid=6&itemid='.$v[itemid];
    //$linkurl = $MODULE[6][linkurl].$v['linkurl'];
    $title[] = '<a href="'. $url.'">'.$v['title'].'</a>';
                             }
   $xml_str = implode("\n\t",$title);
   $msgType = "text";
   $contentStr = "查询到以下和“".$skeyword."”相匹配的楼盘:\n\t".$xml_str."\n了解详情请输入精确的楼盘名。";
          }
else
          {
   // $title = iconv("GBK","UTF-8",$tags[0]['title']);
  $title=$tags[0]['title'];
   $url=$EXT[wap_url].'index.php?moduleid=6&itemid='.$tags[0]['itemid'];
    $address=$tags[0]['address'];
  // $address = iconv("GBK","UTF-8",$tags[0]['address']);
   $tel = $tags[0]['telephone'];
   $price = $tags[0]['price'];
   if($price)
		{$price=$price.'元/㎡';}
		 else 
		 {$price='待定';}
   $contentStr = "楼盘名：".$title."\n地址：".$address."\n电话：".$tel."\n价格：".$price."\n更多详细信息：".$url;
          }
      }
      
 else
     {
$contentStr = "没有找到和“".$skeyword."”匹配的楼盘，建议您换个词试试。查询楼盘请输入：楼盘#楼盘名";
     }
     }
	 //搜索楼盘结束
else
  {
$contentStr = "查询楼盘输入:楼盘#楼盘名";
  }
}
else
{
$contentStr = "查询楼盘请输入:楼盘#楼盘名";
}
$resultStr = $this->transmitText($object,$contentStr,$funcFlag);
return $resultStr;
}
private function receiveLocation($object)
{
$funcFlag = 0;
$resultStr = "";
$cityArray = array();
$contentStr = "";
$needArray = false;
$illegal = false;
$saytome = false;
$myLat = $object->Location_X;
$myLng = $object->Location_Y;
settype($myLat,"float");
settype($myLng,"float");
$Label = $object->Label;
$find = stripos($Label,' ');
if($find!==false)
{
$Label = substr($Label,0,$find);
}
$range = 180 / pi() * 1 / 6372.797;
$lngR = $range / cos($myLat * pi() / 180);
$maxLat = $myLat +$range;
$minLat = $myLat -$range;
$maxLng = $myLng +$lngR;
$minLng = $myLng -$lngR;
$conditions = "status=3 and isnew=1";
$sql = $db->query("SELECT * FROM $newhouse WHERE {$conditions} order by itemid desc LIMIT 0,10 ");
$result = mysql_fetch_array($sql);
if($result)
{
$num=0;
foreach($result AS $k=>$v) {
list($lngX,$latY,$zoom) = explode('|',$v['map']);
if(($lngX>$minLng) &&($lngX<=$maxLng) &&($latY>$minLat) &&($latY<=$maxLat))
{
$num++;
//$v['title'] = iconv("GBK","UTF-8",$v['title']);
  $url=$EXT[wap_url].'index.php?moduleid=6&itemid='.$v['itemid'];
$title[] = '<a href="'.$url.'">'.$v['title'].'</a>';
}
}
if($num>0)
{
$xml_str = implode("\n",$title);
$contentStr = "您当前位置“".$Label."”1000米范围内查询到以下楼盘:\r\n".$xml_str."\n了解详情请输入精确的楼盘名";
}
else
{
$contentStr = "您当前位置“".$Label."”1000米范围内没有查询到楼盘信息。\n查询楼盘请输入：楼盘#楼盘名";
}
}
else
{
$contentStr = "您当前位置“".$Label."”1000米范围内没有查询到楼盘信息。\n查询楼盘请输入：楼盘#楼盘名";
}
$resultStr = $this->transmitText($object,$contentStr,$funcFlag);
return $resultStr;
}
private function receiveEvent($object)
{
$contentStr = "";
switch ($object->Event)
{
case "subscribe":
$contentStr = WX_REPLY;
break;
}
$resultStr = $this->transmitText($object,$contentStr);
return $resultStr;
}
private function transmitText($object,$content,$flag = 0)
{
$textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
$resultStr = sprintf($textTpl,$object->FromUserName,$object->ToUserName,time(),$content,$flag);
return $resultStr;
}

private function checkSignature()
{
$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];
$token = TOKEN;
$tmpArr = array($token,$timestamp,$nonce);
sort($tmpArr);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );
if( $tmpStr == $signature ){
return true;
}else{
return false;
}
}
}
function safe_replaces($string) {
$string = str_replace('%20','',$string);
$string = str_replace('%27','',$string);
$string = str_replace('%2527','',$string);
$string = str_replace('*','',$string);
$string = str_replace('"','&quot;',$string);
$string = str_replace("'",'',$string);
$string = str_replace('"','',$string);
$string = str_replace(';','',$string);
$string = str_replace('<','&lt;',$string);
$string = str_replace('>','&gt;',$string);
$string = str_replace("{",'',$string);
$string = str_replace('}','',$string);
$string = str_replace('\\','',$string);
return $string;
}
?>