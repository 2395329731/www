<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class wenfang {
	var $itemid;
	var $db;
	var $table;
	var $errmsg = errmsg;

    function wenfang() {
		global $db,$item_id;
		$this->table = $db->pre.'wenfang';
		$this->db = &$db;
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
		if(!$post['content']) return $this->_($L['wenfang_pass_content']);
		return true;
	}

	function set($post) {
		global $AJ_TIME, $_username;
		$post['hidden'] = isset($post['hidden']) ? 1 : 0;
		$post['status'] = $post['status'] == 3 ? 3 : 2;
		in_array($post['star'], array(1, 2, 3)) or $post['star'] = 3;
		if($post['reply']) {
			$post['replytime'] = $AJ_TIME;
			$post['reply'] = trim($post['reply']);
		}
		$post['editor'] = $_username;
		return $post;
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}

	function get_list($condition = 'status=3', $order = 'itemid DESC') {
		global $MOD, $TYPE, $pages, $page, $pagesize, $offset, $items;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
		$items = $r['num'];
		$pages = pages($items, $page, $pagesize);		
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 6);
			$r['replydate'] = $r['replytime'] ? timetodate($r['replytime'], 6) : '';
			$lists[] = $r;
		}
		return $lists;
	}

	function edit($post) {
		$post = $this->set($post);
		$r = $this->get_one();
	
		$sql = '';
		foreach($post as $k=>$v) {
			$sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function delete($itemid) {
		global $MOD, $L;
		if(is_array($itemid)) {
			foreach($itemid as $v) { 
				$this->delete($v); 
			}
		} else {
			$this->itemid = $itemid;
			$r = $this->get_one();
			if($r) {
				
				$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
				if($r['username'] && $MOD['credit_del_wenfang']) {
					credit_add($r['username'], -$MOD['credit_del_wenfang']);
					credit_record($r['username'], -$MOD['credit_del_wenfang'], 'system', $L['wenfang_record_del'], 'ID:'.$r['itemid']);
				}
			}
		}
	}

	function check($itemid, $status = 3) {
		global $MOD, $L;
		if(is_array($itemid)) {
			foreach($itemid as $v) { 
				$this->check($v, $status); 
			}
		} else {
			if($MOD['credit_add_wenfang'] && $status == 3) {
				$this->itemid = $itemid;
				$item = $this->get_one();
				if($item['username']) {
					credit_add($item['username'], $MOD['credit_add_wenfang']);
					credit_record($item['username'], $MOD['credit_add_wenfang'], 'system', $L['wenfang_record_add'], 'ID:'.$itemid);
				}
			}
			$this->db->query("UPDATE {$this->table} SET status=$status WHERE itemid=$itemid");
		}
	}

	


	function _add($post) {
		global $AJ_TIME, $_username;
		$post['moduleid'] = intval($post['moduleid']);
		$post['itemid'] = intval($post['itemid']);
		if(!$post['moduleid'] || !$post['itemid']) return false;
		
	}

	function _edit($post) {
		foreach($post as $k=>$v) {
			$v['moduleid'] = intval($v['moduleid']);
			$v['itemid'] = intval($v['itemid']);
			if(!$v['moduleid'] || !$v['itemid']) return false;
		
		}
	}

	
	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>