<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MG['addmember_limit'] > 0 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
require AJ_ROOT.'/include/post.func.php';
require MD_ROOT.'/addmember.class.php';
$do = new address();

switch($action) {
	case 'add':
			if($MG['addmember_limit']) {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}member WHERE company='$_company'");
			if($r['num'] >= $MG['addmember_limit']) dalert(lang($L['limit_add'], array($MG['addmember_limit'], $r['num'])), 'goback');
		}
		if($submit) {
			if($do->pass($post)) {
				$post['company'] = $_company;
				//$useridd=$userid;
				$post['companyid'] = $_userid;
				$post['groupid'] = $post['groupid'];
			 $post['company'] = $post['truename'];
			$post['passport'] = $post['passport'] ? $post['passport'] : $post['username'];
			$post['edittime'] = $post['edittime'] ? $AJ_TIME : 0;
			$post['inviter'] = $post['username'];
				
								$do->add($post);
				dmsg($L['op_add_success'], $MOD['linkurl'].'addmember.php');
			} else {
				message($do->errmsg);
			}
		} else {
			$head_title = $L['addmember_title_add'];
		}
	break;
	case 'edit':
		$userid or message();
		$do->userid = $userid;
		echo $userid;
		$r = $do->get_one();
		if(!$r || $r['company'] != $_company) message();
		if($submit) {
			if($do->pass($post)) {
				$post['company'] = $_company;
				$do->edit($post);
				dmsg($L['op_edit_success'], $forward);
			} else {
				message($do->errmsg);
			}
		} else {
			extract($r);
			$head_title = $L['addmember_title_edit'];
		}
	break;
	case 'delete':
		$userid or message($L['addmember_msg_choose']);
		$do->userid = $userid;
		$r = $do->get_one();
		if(!$r || $r['company'] != $_company) message();
		$do->delete($userid);
		dmsg($L['op_del_success'], $forward);
	break;
	default:
		$condition = "company='$_company'";
		if($keyword) $condition .= " AND member LIKE '%$keyword%'";
		$lists = $do->get_list($condition);
		$head_title = $L['addmember_title'];
	break;
	}
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}member WHERE company='$_company'");
$limit_used = $r['num'];

$limit_free = $MG['addmember_limit'] && $MG['addmember_limit'] > $limit_used ? $MG['addmember_limit'] - $limit_used : 0;
include template('addmember', $module);
?>