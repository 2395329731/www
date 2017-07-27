<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$_page = $page <= 1 ? $total : ($page - 1);
$demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
$url = $_page == 1 ? $home_url : str_replace('{aijiacms_page}', $_page, $demo_url);
$pages .= '<input type="hidden" id="aijia'.'cms_previous" value="'.$url.'"/><a href="'.$url.'" title="'.$L['prev_page'].'">上一页</a> ';
if($total >= 1) {
	$_page = 1;
	$url = $home_url;
	$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
}
if($total >= 2) {
	$_page = 2;
	$url = str_replace('{aijiacms_page}', $_page, $demo_url);
	$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
}
if($total >= 3) {
	$pages .= '&nbsp;&#8230;&nbsp;';
	if($total > 4) {
		if($page <= 2) {
			$min = 3; $max = 3 + $step*2;
		} else if($page >= $total - 1) {
			$min = $total - 2 - $step*2; $max = $total - 2;
		} else {
			$min = $page - $step; $max = $page + $step;
		}
		if($min < 3) $min = 3;
		if($max > $total - 2) $max = $total - 2;
		if($page == 3) while($max < $page + $step*2 && $max < $total - 2) { $max++; }
		if($page == 4) while($max < $page + $step*2 - 1 && $max < $total - 2) { $max++; }
		if($page == $total - 3) while($min > $page - $step*2 + 1 && $min - 1 > 2) { $min--;}
		if($page == $total - 2) while($min > $page - $step*2 && $min - 1 > 2) { $min--; }
		for($_page = $min; $_page <= $max; $_page++) {
			$url = $_page == 1 ? $home_url : str_replace('{aijiacms_page}', $_page, $demo_url);
			$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a  href="'.$url.'" >&nbsp;'.$_page.'&nbsp;</a>  ';
		}
		$pages .= '&nbsp;&#8230;&nbsp;';
	}
	if($total >= 4) {
		$_page = $total - 1;
		$url = $_page == 1 ? $home_url : str_replace('{aijiacms_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}
	if($total >= 3) {
		$_page = $total;
		$url = $_page == 1 ? $home_url : str_replace('{aijiacms_page}', $_page, $demo_url);
		$pages .= $page == $_page ? '<strong>&nbsp;'.$_page.'&nbsp;</strong> ' : ' <a href="'.$url.'">&nbsp;'.$_page.'&nbsp;</a>  ';
	}
}
$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $home_url : str_replace('{aijiacms_page}', $_page, $demo_url);
$pages .= '<a href="'.$url.'" title="'.$L['next_page'].'">下一页</a> <input type="hidden" id="aijia'.'cms_next" value="'.$url.'"/>&nbsp;'.lang($L['info_page'], array($items, $total)).'&nbsp;';

?>