<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
class dcache {
	var $pre;
	var $obj;

    function dcache() {
		$this->obj = new Memcache;
		include AJ_ROOT.'/file/config/memcache.inc.php';
		$num = count($MemServer);
		$key = $num == 1 ? 0 : abs(crc32($GLOBALS['AJ_IP']))%$num;
		$this->obj->connect($MemServer[$key]['host'], $MemServer[$key]['port'], 2);
    }

	function get($key) {
        return $this->obj->get($this->pre.$key);
    }

    function set($key, $val, $ttl = 600) {
         return $this->obj->set($this->pre.$key, $val, 0, $ttl);
    }

    function rm($key) {
        return $this->obj->delete($this->pre.$key);
    }

    function clear() {
        return $this->obj->flush();
    }

	function expire() {
		return true;
	}
}
?>