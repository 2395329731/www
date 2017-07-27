<?php
require('../common.inc.php');
$condition = "status=3 and map<>'' and isnew=1";
if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);}
if($district) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$district";
if($protype) $condition .= " AND FIND_IN_SET('$protype',`catid`)" ;	 
if($sale or $sale!='') $condition .= " AND typeid=$sale" ;	
//echo  $condit'ion;
	if($price=='~4000' and $price!='' ){
			$condition.=' AND price<4000';
		}
	if($price == '4000-5000'){
			$condition.=" AND price>=4000  AND price<5000";
			
		}
	if($price == '5000-6000'){
			$condition.=' AND 5000<=price AND price<6000';
			
		}
	if($price == '6000-7000'){
			$condition.=' AND 6000<=price AND price<7000';
		}
	if($price == '7000-8000'){
			$condition.=' AND 7000<=price AND price<8000';
		}
	if($price == '8000-9000'){
			$condition.=' AND 8000<=price AND price<9000';
		}
	if($price == '9000-10000'){
			$condition.=' AND 9000<=price AND price<10000';
		}
    if($price == '10000~'){
			$condition.=' AND 10000<=price';
		}
		
	
		
		
		$newhouse=$db->pre.'newhouse_6';
 $str='[';
	$result = $db->query("SELECT * FROM $newhouse WHERE {$condition} ");
	while($r = mysql_fetch_array($result)) {
		$arr=$r['map'];
		$r['linkurl'] = $MODULE[6][linkurl].$r['linkurl'];
		$cnum=$r['num'];
		$typeid=$r['typeid'];
		if ($typeid==1){ $typename='待售';}
		if ($typeid==2){ $typename='在售';}
		if ($typeid==3){ $typename='尾盘';}
		if ($typeid==4){ $typename='售完';}
		$thunb=imgurl($r[thumb]);
		$catname=search_cats($r['catid'], '6');
		
	$map=explode(",",$arr);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }
		   $a='{cid:'.$r['itemid'].','.'cname:"'.$r['title'].'",'.'cnum:"'.$cnum.'",'.'averprice:"'.$r['price'].'", selltime:"'.$r['selltime'].'",'.'imgsrc:"'.$thunb.'",'.'href:"'.$r['linkurl'].'",'.'protype:"'.$catname.'",'.'emplor:"'.$r['kfs'].'",'.'tel:"'.$r['telephone'].'",'.'hseat:"'.$r['address'].'",'.'saletype:"'.$typename.'",'.'sales:"'.$r['typeid'].'", x:'.$x.', y:'.$y.', xs:'.$y.'},';
		 
	 
		$str .=$a;
	}
	$len=strlen($str); 
	if($len==1){
	 $s=substr($str,0,$len); }
	 else
	{$s=substr($str,0,$len-1);}  
	//$s=substr($str,0,$len-1); 
	$s .=']';

	echo $s;
	?>