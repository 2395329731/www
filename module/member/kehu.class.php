<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class kehu {
	var $itemid;
	var $db;
	var $table;
	var $errmsg = errmsg;

    function kehu() {
		global $db, $AJ_PRE;
		$this->table = $AJ_PRE.'fenxiao';
		$this->db = &$db;
    }

	function get_one($condition = '') {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid' $condition");
	}

	function get_list($condition = 'status=0', $order = 'addtime DESC') {
		global $MOD, $pages, $page, $pagesize, $offset, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$lists = array();
	
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$lists[] = $r;
		}
		return $lists;
	}

	function edit($post) {
		global $AJ_PRE, $_username, $AJ_TIME, $GROUP, $L;
$dstatus = array(
    '待受理',
	'已预约',
	'已到访',
	'已交定金',
	'已成交',
);
		$item = $this->get_one();
		$gsql = $msql = $csql = '';
		if($post['cprice'] && $post['cmoney']) {
			$gsql = "edittime=$AJ_TIME,editor='$_username',status=$post[status],cprice=$post[cprice],cmoney=$post[cmoney],snote='$post[snote]',house2='$post[house2]',shouse='$post[shouse]'";
		}else{
		
		$gsql = "edittime=$AJ_TIME,editor='$_username',status=$post[status],snote='$post[snote]'";
		}
		$statuss =$dstatus[($post['status'])];
		 if($post['status'] >0) {
			if($item['tuijian']) {
				if($post['message'] && $post['content']) {
				send_message($item['tuijian'], '您推荐的客户'.$item['truename'].$statuss,  nl2br($post['content']));
					$gsql .= ",message=1";
				}
				
			}
		}
	   if($post['status'] == 4) {
			if($item['tuijian']) {
				
				//$msql = $csql = "groupid=$item[groupid],company='$item[company]'";
				$vip = $GROUP[$item['groupid']]['vip'];
				$csql .= ",vip=$vip,vipt=$vip";
			if(isset($post['cmoney']) && $post['cmoney']) {
					//money_add($item['tuijian'], $post['cmoney']);
					amount_record($item['tuijian'], $item['truename'], $post['cmoney'],$_username, '0',  '');
				}
			}
		}
	
		$star = 'star'.$post['status'];
		$houseid=$post['house2'];
		$this->db->query("UPDATE {$this->table} SET $gsql WHERE itemid=$this->itemid");
		$this->db->query("UPDATE {$AJ_PRE}newhouse_6 SET {$star}=`{$star}`+1 WHERE itemid=$houseid");
		
		return true;
	}

	function delete($itemid, $all = true) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->delete($v); }
		} else {
			$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
		}
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
//分销区域
function fenxiaoqy($areaid) {
	global $MODULE, $db;
	$condition = " parentid=0 AND areaid IN ($areaid)";
	$result = $db->query("SELECT areaid,areaname FROM {$db->pre}area where $condition");
	
	while($c = $db->fetch_array($result)) {
		    
			 $html .= $c['areaname'] . "&nbsp;";
			
		
		}
       $html = rtrim($html, ','); 
	return $html;
}
function fxlp($house) {
	global $db, $dc, $CFG;
   $r = $db->get_one("SELECT * FROM {$db->pre}newhouse_6 WHERE itemid=$house ");
      $title=$r['title'];
	return $title;
}
?>