<?php
defined('IN_AIJIACMS') or exit('Access Denied');

function dtexit($error='error',$success='',$path='') {
	if($success=='success'){
	exit('{"success":"ok","path":"'.$path.'"}');
	}else{
	exit('{"error":"'.$error.'"}');
	}
}

function mobile_ismobile() {
	global $UAType, $AJ_URL;
	if($UAType=='computer') mobile_msg('PC浏览请使用电脑发布信息！');
}

function dlayerm($dmessage = errmsg, $dforward = '', $time = '') {
	global $CFG, $AJ;
	if(AJ_CHARSET != 'UTF-8') $dmessage = convert($dmessage, AJ_CHARSET, 'UTF-8');
	exit(include template('layerm', 'mobile'));
}

function utftext($msg) {
	global $EXT, $CFG;
	$msg = $msg;
	$msg = convert($msg, $CFG['charset'],  'utf-8');
	return $msg;
}

function hideStars($str) { //用户名、邮箱、手机账号中间字符串以*隐藏 
    if (strpos($str, '@')) { 
        $email_array = explode("@", $str); 
        $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀 
        $count = 0; 
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count); 
        $rs = $prevfix . $str; 
    } else { 
        $pattern = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i'; 
        if (preg_match($pattern, $str)) { 
            $rs = preg_replace($pattern, '$1****$2', $str); // substr_replace($name,'****',3,4); 
        } else { 
            $rs = substr($str, 0, 3) . "***" . substr($str, -1); 
        } 
    } 
    return $rs; 
}

function im_mobweb($id, $style = 0) {
	global $MODULE;
	return $id ? '<a href="chat.php?touser='.$id.'" target="_blank" rel="nofollow"><img src="'.AJ_PATH.'api/online.png.php?username='.$id.'&style='.$style.'" title="点击交谈/留言" alt="" align="absmiddle" onerror="this.src=DTPath+\'file/image/web-off.gif\';"/></a>' : '';
}

?>