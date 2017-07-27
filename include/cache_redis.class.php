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
		$this->obj = new Redis;
		include AJ_ROOT.'/file/config/redis.inc.php';
		$num = count($RedisServer);
		$key = $num == 1 ? 0 : abs(crc32($GLOBALS['AJ_IP']))%$num;
		$this->obj->connect($RedisServer[$key]['host'], $RedisServer[$key]['port']);
    }

	function get($key) {
        return $this->obj->get($this->pre.$key);
    }

    function set($key, $val, $ttl = 600) {
         return $ttl ? $this->obj->setex($this->pre.$key, $ttl, $val) : $this->obj->set($this->pre.$key, $val);
    }

    function rm($key) {
        return $this->obj->delete($this->pre.$key);
    }

    function clear() {
        return $this->obj->flushAll();
    }

	function expire() {
		return true;
	}
}
?>