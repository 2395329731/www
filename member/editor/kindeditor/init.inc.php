<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$moddir = defined('AJ_ADMIN') ? $MODULE[2]['moduledir'].'/editor/' : 'editor/';
$draft = $textareaid == 'content' && $_userid && $AJ['save_draft'];
if($AJ['save_draft'] == 2 && !defined('AJ_ADMIN')) $draft = false;
$_width = is_numeric($width) ? $width.'px' : $width;
$_height = is_numeric($height) ? $height.'px' : $height;
$editor .= '<script type="text/javascript" charset="utf-8" src="'.$moddir.'kindeditor/kindeditor-min.js"></script>';
$editor .= '<script type="text/javascript" charset="utf-8" src="'.$moddir.'kindeditor/lang/zh_CN.js"></script>';
$editor .= '<script type="text/javascript">';
$editor .= 'var ModuleID = '.$moduleid.';';
$editor .= 'var DTAdmin = '.(defined('AJ_ADMIN') ? 1 : 0).';';
$editor .= 'var EDPath = "'.$moddir.'kindeditor/";';
$editor .= 'var ABPath = "'.$MODULE[2]['linkurl'].'editor/kindeditor/";';
$editor .= 'var EDW = "'.$_width.'";';
$editor .= 'var EDH = "'.$_height.'";';
$editor .= 'var EDD = "'.($draft ? 1 : 0).'";';
$editor .= 'var EID = "'.$textareaid.'";';
$editor .= 'var FCKID = "'.$textareaid.'";';
$editor .= '$(\'#'.$textareaid.'\').css({width:\''.$_width.'\',height:\''.$_height.'\',display:\'\'});';
$editor .= 'KindEditor.ready(function(K) { ';
$editor .= 'window.editor = K.create(\'#'.$textareaid.'\', {';
#$editor .= 'autoHeightMode : true,';
#$editor .= 'afterCreate : function() { this.loadPlugin(\'autoheight\'); },';
$editor .= 'urlType:\'domain\',';
#$editor .= 'newlineTag:\'br\',';
if($toolbarset == 'Aijiacms') {
	$editor .= "items : [".(defined('AJ_ADMIN') ? "'source', '|', " : "")."'wordpaste', 'plainpaste', '|', 'bold', 'forecolor', 'fontsize', 'link', 'unlink', 'image', 'multiimage', 'media', 'hr', 'justifyleft', 'justifycenter', 'justifyright', 'insertfile', ".($moduleid == 18 ? "'emoticons', " : "")."'fullscreen'],";
} else if($toolbarset == 'Simple') {
	$editor .= "items : [".(defined('AJ_ADMIN') ? "'source', '|', " : "")."'wordpaste', 'plainpaste', '|', 'bold', 'forecolor', 'fontsize', 'link', 'unlink', 'image', 'justifyleft', 'justifycenter', 'justifyright', 'insertfile', ".($moduleid == 18 ? "'emoticons', " : "")."'fullscreen'],";
} else if($toolbarset == 'Basic') {
	$editor .= "items : [".(defined('AJ_ADMIN') ? "'source', '|', " : "")."'bold', 'forecolor', 'fontsize', 'link', 'unlink', 'image', 'justifyleft', 'justifycenter', 'justifyright', ".($moduleid == 18 ? "'emoticons', " : "")."'fullscreen'],";
} else if($toolbarset == 'Message') {
	$editor .= "items : [".(defined('AJ_ADMIN') ? "'source', '|', " : "")."'wordpaste', 'plainpaste', '|', 'bold', 'forecolor', 'fontsize', 'link', 'unlink', 'image', 'emoticons', 'justifyleft', 'justifycenter', 'justifyright', 'insertfile', ".($moduleid == 18 ? "'emoticons', " : "")."'fullscreen'],";
} else if($toolbarset == 'Touch') {
	$editor .= "items : [".(defined('AJ_ADMIN') ? "'source', '|', " : "")." 'image'".($moduleid == 18 ? " ,'emoticons'" : "")."],";
} else {
	$editor .= "items : [".(defined('AJ_ADMIN') ? "'source', '|', " : "")."'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste', 'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',	'justifyfull', 'insertorderedlist', 'insertunorderedlist', '|', 'removeformat', 'clearhtml', 'quickformat', '|', 'fullscreen', '/', 'link', 'unlink', 'anchor','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',	'italic', 'underline', 'strikethrough', 'lineheight', 'table', 'hr', 'emoticons', '|', 'image', 'multiimage', 'media', 'insertfile'],";
}
$editor .= 'uploadJson:UPPath+\'?action=kindeditor&from=editor&moduleid='.$moduleid.'\'';
$editor .= '}); });';
$editor .= '</script>';
$editor .= '<script type="text/javascript" src="'.$moddir.'kindeditor/init.api.js"></script>';
$editor .= '<script type="text/javascript" src="'.AJ_STATIC.'file/script/editor.js"></script>';
?>