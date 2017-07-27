<?php
require('../common.inc.php');
$condition = "a.status=3 and b.map<>'' and b.status=3";
if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);}
if($district) $condition .= $ARE['child'] ? " AND a.areaid IN (".$ARE['arrchildid'].")" : " AND a.areaid=$district";
//echo  $condition;
if($price==0 and $price!='' ){
			$condition.=' AND a.price<30';
		}
	if($price ==1){
			$condition.=" AND a.price>=30  AND a.price<50";
			
		}
	if($price == 2){
			$condition.=' AND 50<=a.price AND a.price<80';
			
		}
	if($price== 3){
			$condition.=' AND 80<=a.price AND a.price<100';
		}
	if($price== 4){
			$condition.=' AND 100<=a.price AND a.price<120';
		}
	if($price == 5){
			$condition.=' AND 120<=a.price AND a.price<150';
		}
		if($price == 6){
			$condition.=' AND 200<=a.price ';
		}
			//面积范围
	if($area== 0 and $area!='' ){
			$condition.=' AND houseearm<40';
		}
	if($area == 1){
			$condition.=" AND houseearm>40  AND houseearm<60";}
	if($area == 2){
			$condition.=' AND 60<=houseearm AND houseearm<80';
			
		}
	if($area== 3){
			$condition.=' AND 80<=houseearm AND houseearm<100';
		}
	if($area == 4){
			$condition.=' AND 100<=houseearm AND houseearm<120';
		}
	if($area == 5){
			$condition.=' AND 120<=houseearm AND houseearm<150';
		}
	if($area == 6){
			$condition.=' AND 150<=houseearm';
		}
		//户型范围
	if($units== 0 and $units!='' ){
			$condition.=' AND room=1';
		}
	if($units == 1){
			$condition.=" AND room=2";}
	if($units == 2){
			$condition.=' AND room=3';
			
		}
	if($units== 3){
			$condition.=' AND room=4';
		}
		if($units== 4){
			$condition.=' AND room=5';
		}
	if($units == 5){
			$condition.=' AND 5<=room ';
		}
		$hsall=$db->pre.'sale_5';
		$newhouse=$db->pre.'newhouse_6';
$sql='select count(a.houseid) as num,b.itemid as itemid,b.map as map,b.title as housename from '.$hsall.' as a left join '.$newhouse.' as b on a.houseid = b.itemid where  '.$condition.' group by a.houseid';
 $str='[';
	$result = mysql_query($sql);
	while($r = mysql_fetch_array($result)) {
		$arr=$r['map'];
		$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
		$cnum=$r['num'];;
		$averprice=get_avg_price($r[itemid]);
	$map=explode(",",$arr);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }
		   $a='{cid:'.$r['itemid'].','.'cname:"'.$r['housename'].'",'.'cnum:"'.$cnum.'",'.'averprice:"'.$averprice.'", x:'.$x.', y:'.$y.', xs:'.$y.'},';
		 
	 
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