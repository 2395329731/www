<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
class db_mysqlhttp {
	var $connid;
	var $pre;
	var $querynum = 0;
	var $ttl;
	var $cursor = 0;
	var $cache_id = '';
	var $cache_ttl = '';
	var $halt = 0;
	var $cids = 0;
	var $linked = 1;
	var $result = array();
	var $cache_ids = array();
	var $http_api;
	var $insert_id;
	var $affected_rows;

	function connect($dbhost, $dbuser, $dbpass, $dbname, $dbttl, $dbcharset, $pconnect = 0) {
		$this->ttl = $dbttl;
		$func = $pconnect == 1 ? 'mysql_pconnect' : 'mysql_connect';
		if(!$this->connid = $func($dbhost, $dbuser, $dbpass)) {
			$this->linked = 0;
			$retry = 5;
			while($retry-- > 0) {
				if($this->connid = $func($dbhost, $dbuser, $dbpass)) {
					$this->linked = 1;
					break;
				}
			}
			if($this->linked == 0) {
				global $AJ_BOT;
				if($AJ_BOT) dhttp(503);
				if($this->halt) {
					exit(include template('mysql', 'message'));
				} else {
					$this->halt('Can not connect to MySQL server');
				}
			}
		}
		$version = $this->version();
		/* NOET: IN_ADMIN COMMENT MESSY */
		if($version > '4.1' && $dbcharset) mysql_query(IN_ADMIN ? "SET NAMES '".$dbcharset."'" : "SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->connid);
		if($version > '5.0') mysql_query("SET sql_mode=''", $this->connid);
		if($dbname && !mysql_select_db($dbname, $this->connid)) $this->halt('Cannot use database '.$dbname);
		return $this->connid;
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->connid);
	}

	function query($sql, $type = '', $ttl = 0, $save_id = false) {
		$select = strtoupper(substr($sql, 0, 7)) == 'SELECT ' ? 1 : 0;
		$this->http_api = $this->http_api($sql);
		$this->cursor = 0;
		if($this->ttl > 0 && $type == 'CACHE' && $select) {
			$this->cache_id = md5($sql);
			if($this->cids) $this->cache_ids[] = $this->cache_id;
			$this->result = array();
			$this->cache_ttl = ($ttl ? $ttl : $this->ttl) + mt_rand(-10, 30);
			return $this->_query($sql);
		}
		if(!$save_id) $this->cache_id = 0;
		if($this->http_api) return $this->http_query($sql);
		$func = $type == 'UNBUFFERED' ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->connid))) $this->halt('MySQL Query Error', $sql);
		$this->querynum++;
		return $query;
	}

	function get_one($sql, $type = '', $ttl = 0) {
		$sql = str_replace(array('select ', ' limit '), array('SELECT ', ' LIMIT '), $sql);
		if(strpos($sql, 'SELECT ') !== false && strpos($sql, ' LIMIT ') === false) $sql .= ' LIMIT 0,1';
		$query = $this->query($sql, $type, $ttl);
		$r = $this->fetch_array($query);
		$this->free_result($query);
		return $r;
	}
	
	function count($table, $condition = '', $ttl = 0) {
		global $AJ_TIME;
		$sql = 'SELECT COUNT(*) as amount FROM '.$table;
		if($condition) $sql .= ' WHERE '.$condition;
		$r = $this->get_one($sql, $ttl ? 'CACHE' : '', $ttl);
		return $r ? $r['amount'] : 0;
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return ($this->cache_id || $this->http_api) ? $this->_fetch_array($query) : mysql_fetch_array($query, $result_type);
	}

	function affected_rows() {
		return $this->affected_rows ? $this->affected_rows : mysql_affected_rows($this->connid);
	}

	function num_rows($query) {
		return mysql_num_rows($query);
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function result($query, $row) {
		return @mysql_result($query, $row);
	}

	function free_result($query) {
		if(is_resource($query) && get_resource_type($query) === 'mysql result') {
			return @mysql_free_result($query);
		}
	}

	function insert_id() {
		return $this->insert_id ? $this->insert_id : mysql_insert_id($this->connid);
	}

	function fetch_row($query) {
		return mysql_fetch_row($query);
	}

	function version() {
		return mysql_get_server_info($this->connid);
	}

	function close() {
		return mysql_close($this->connid);
	}

	function error() {
		return @mysql_error($this->connid);
	}

	function errno() {
		return intval($this->error());
	}

	function halt($message = '', $sql = '')	{
		if($message && AJ_DEBUG) log_write("\t\t<query>".$sql."</query>\n\t\t<errno>".$this->errno()."</errno>\n\t\t<error>".$this->error()."</error>\n\t\t<errmsg>".$message."</errmsg>\n", 'sql');
		if($this->halt) message('MySQL Query:'.str_replace($this->pre, '[pre]', $sql).' <br/> MySQL Error:'.str_replace($this->pre, '[pre]', $this->error()).' MySQL Errno:'.$this->errno().' <br/>Message:'.$message);
	}

	function _query($sql) {
		global $dc;
		$this->result = $dc->get($this->cache_id);
		if(!is_array($this->result)) {
			$tmp = array(); 
			if($this->http_api) {
				$this->http_query($sql);
			} else {
				$result = $this->query($sql, '', '', true);
				while($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$tmp[] = $r; 
				}
				$this->result = $tmp;
				$this->free_result($result);
			}
			$dc->set($this->cache_id, $this->result, $this->cache_ttl);
		}
		return $this->result;
	}

	function _fetch_array($query = array()) {
		if($query) $this->result = $query;
		if(isset($this->result[$this->cursor])) {
			return $this->result[$this->cursor++];
		} else {
			$this->cursor = $this->cache_id = 0;
			return array();
		}
	}

	function http_api($sql) {
		$API = array(
			'sell_5' => 'http://127.0.0.1/aijiacms/v5g/api/mysqlhttp.php',
			'webpage' => 'http://127.0.0.1/aijiacms/v5g/api/mysqlhttp.php',
		);
		$t = '';
		$i = intval(strpos($sql, $this->pre));
		if($i > 1) {
			$i += strlen($this->pre);
			while(preg_match("/^[a-z0-9_]{1}$/", $sql{$i})) {
				$t .= $sql{$i++};
			}
		}
		return ($t && isset($API[$t])) ? $API[$t] : '';
	}

	function http_post($sql) {		
		$rec = dcurl($this->http_api, $par);
		return substr($rec, 0, 2) == 'a:' ? unserialize($rec) : $rec;
		//return substr($rec, 0, 1) == '[' ? json_decode($rec, true) : $rec;
	}

	function http_query($sql) {
		$this->result = $this->http_post($sql, $this->http_api);
		if(is_array($this->result)) {
			/*
			//JSON
			foreach($this->result as $k=>$v) {
				$this->result[$k] = array_map('urldecode', $v);
			}
			*/
		} else if(strpos($this->result, ':') !== false) {
			$t = explode(':', $this->result);
			if($t[0] == 'ID') {
				$this->insert_id = $t[1];
			} else if($t[0] == 'OK') {					
				$this->affected_rows = $t[1];
			}
		} else {
			//exit($this->result);
		}
	}
}
?>