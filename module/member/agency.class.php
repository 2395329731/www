<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class dlink {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function dlink() {
		global $db, $AJ_PRE;
		$this->table = $AJ_PRE.'link';
		$this->db = &$db;
		$this->fields = array('listorder', 'title','style','username','addtime','editor','edittime','status', 'linkurl');
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
		if(!$post['username']) return $this->_($L['link_pass_username']);
		if(!$post['title']) return $this->_($L['link_pass_title']);
		if(!$post['linkurl']) return $this->_($L['link_pass_linkurl']);
		return true;
	}

	function set($post) {
		global $MOD, $AJ_TIME, $_username, $_userid;
		if(!$this->itemid) $post['addtime'] = $AJ_TIME;
		$post['edittime'] = $AJ_TIME;
		$post['editor'] = $_username;
		if(!defined('AJ_ADMIN')) $post = dhtmlspecialchars($post);
		return $post;
	}

	function get_one() {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}

	function get_list($condition = '1', $order = 'listorder DESC, itemid DESC') {
		global $pages, $page, $pagesize, $offset;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['title'] = set_style($r['title'], $r['style']);
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		global $AJ, $MOD, $module;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->itemid = $this->db->insert_id();
		return $this->itemid;
	}

	function edit($post) {
		global $AJ, $MOD, $module;
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function delete($itemid, $all = true) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { 
				$this->delete($v, $all); 
			}
		} else {
			$this->itemid = $itemid;
			$r = $this->get_one();
			if($all) {
				$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
			}
		}
	}

	function check($itemid, $status = 3) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { 
				$this->check($v, $status); 
			}
		} else {
			$this->db->query("UPDATE {$this->table} SET status=$status WHERE itemid=$itemid");
		}
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>