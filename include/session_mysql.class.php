<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
class dsession {
	var $db;
	var $table;
	var $time;

    function dsession() {
		global $db, $AJ_TIME;
		$this->db = &$db;
		$this->table = $this->db->pre.'session';
	    $this->time = $AJ_TIME;
		if(AJ_DOMAIN) @ini_set('session.cookie_domain', '.'.AJ_DOMAIN);
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		session_cache_limiter('private, must-revalidate');
		session_start();
		header("cache-control: private");
    }

    function open($path, $name) {
		return true;
    }

    function close() {
		$this->gc();
    } 

    function read($sid) {
		$r = $this->db->get_one("SELECT data FROM {$this->table} WHERE sessionid='$sid'");
		return $r ? $r['data'] : '';
    } 

    function write($sid, $data) {
		$data = addslashes($data);
        $this->db->query("REPLACE INTO {$this->table} (sessionid,data,lastvisit) VALUES('$sid', '$data', '$this->time')");
    } 

    function destroy($sid) { 
		$this->db->query("DELETE FROM {$this->table} WHERE sessionid='$sid'");
    } 

	function gc() {
		$expiretime = $this->time - 1800;
		$this->db->query("DELETE FROM {$this->table} WHERE lastvisit<$expiretime");
    }
}
?>