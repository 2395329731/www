
<?php
require('../common.inc.php');
$id=$_REQUEST['cid'];
//分页设置
$page=$_REQUEST['page']?$_REQUEST['page']:1;
$condition = "status=3 and houseid=$id";
//价目格范围
    if($j==0 and $j!='' ){$condition.=' AND price<200';}
	if($j== 1){
			$condition.=" AND price>=200  AND price<500";}
	if($j== 2){
			$condition.=' AND price>=500 AND price<1000';}
	if($j== 3){
			$condition.=' AND price>=1000 AND price<1500';}
	if($j== 4){
			$condition.=' AND price>=1500 AND price<2000';}
	if($j== 5){
			$condition.=' AND price>=2000 AND price<3000';}
	if($j== 6){
			$condition.=' AND 3000<=price';}
		//户型范围
	if($h== 0 and $h!='' ){
			$condition.=' AND room=1';
		}
	if($h == 1){
			$condition.=" AND room=2";}
	if($h == 2){
			$condition.=' AND room=3';
			
		}
	if($h== 3){
			$condition.=' AND room=4';
		}
		if($h== 4){
			$condition.=' AND room=5';
		}
	if($h == 5){
			$condition.=' AND 5<=room ';
		}
		//list_order 排序转换
		if($b == ''){
			$order = " order by itemid desc";
		}
		if($b == price_up){
			$order = " order by price asc";
		}
		if($b == price_down){
			$order = " order by price desc";
		}
		if($b == area_up){
			$order = " order by houseearm asc";
		}
		if($b == area_down){
			$order = " order by houseearm desc";
		}

  $pagesize =5;
	$hsall=$db->pre.'rent_7';
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  $condition");
	$items = $r['num'];
	$cnum = $r['num'];
	$pages = pages($r['num'], $page, $pagesize);
	$page=isset($page)?intval($page):1;       
     $pagenum=ceil($items/$pagesize); 
      If($page>$pagenum || $page == 0){
       Echo "暂无数据";
       Exit;
}
$offset=($page-1)*$pagesize;
$pagenum=ceil($items/$pagesize);                                   
$page=min($pagenum,$page);//获得首页
$prepg=$page-1;//上一页
$nextpg=($page==$pagenum ? 0 : $page+1);//下一页
$offset=($page-1)*$pagesize;                                     


$pagenav=" <div class='list_page'><em>";
if($prepg) $pagenav.=" <a href='javascript:;'onClick='mapPatch.goPage(".$prepg.")'>上页</a> </em>"; else $pagenav.="上页</em>";
if($nextpg) $pagenav.="<em> <a href='javascript:;'onClick='mapPatch.goPage(".$nextpg.")'>下页</a></em> "; else $pagenav.=" <em>下页</em>";
$pagenav.="<em>第<b>".$page."</b>页</em><em>共".$pagenum."页</em></div>";
function charsetIconv($vars,$from='gbk',$to='utf-8') {
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
$result = mysql_query("SELECT * FROM $hsall where $condition $order LIMIT $offset,$pagesize ");
	
	while($r = mysql_fetch_array($result)) {
		$arr=$r['map'];
		$r['linkurl'] = $MODULE[7][linkurl].$r['linkurl'];
		$edittime=timetodate($r[edittime], 3);
		$thumb=imgurl($r[thumb]);
		$r['title']=dsubstr($r[title], 38, '');
		if($r['$paytype'])$r['$paytype']="押".$r['$paytype'];
		if($r['$paytype2'])$r['$paytype2']='付'.$r['$paytype'];
		if($r['price'])
		{$price=$r['price'].'元/月';}
		 else 
		 {$price='面议';}
	?>
	
   <div class="list_item" title="<?php echo $r['title'];?>"><ul><li class="lit_1"><a href="<?php echo $r['linkurl'];?>" target="_blank"><img src="<?php echo $thumb;?>" height="48" width="64"></a></li><li class="lit_2"><a href="<?php echo $r['linkurl'];?>" target="_blank"><?php echo $r['title'];?></a><br><?php echo $r['room'];?>室<?php echo $r['hall'];?>厅 , <?php echo $r['houseearm'];?>㎡ , <?php echo $r['floor1'];?>层共<?php echo $r['floor3'];?>层<br><span><a href="<?php echo userurl($r[username], '');?>" target="_blank"><?php echo $r['truename'];?></a> <?php echo $edittime;?> 发布</span></li><li class="lit_3"><?php echo $price;?><br><i> </i></li></ul></div>
	 
<?php
}
                                                             //显示数据
?>  


 <?php echo $pagenav?>