<?php
/*
	[Aijiacms System] Copyright (c) 2011-2015 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
class dcache {
	var $pre;

    function dcache() {
		//
    }

    function get($key) {
		return wincache_ucache_get($this->pre.$key);
    }

    function set($key, $val, $ttl = 600) {
		return wincache_ucache_set($this->pre.$key, $val, $ttl);
    }

    function rm($key) {
		return wincache_ucache_delete($this->pre.$key);
    }

    function clear() {
        return wincache_ucache_clear();
    }

	function expire() {
		return true;
	}
}
?>