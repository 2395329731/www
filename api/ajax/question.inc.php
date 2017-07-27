<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if(strlen($answer) < 1) exit('1');
$answer = stripslashes($answer);
$answer = convert($answer, 'UTF-8', AJ_CHARSET);
$session = new dsession();
if(!isset($_SESSION['answerstr'])) exit('2');
if($_SESSION['answerstr'] != md5(md5($answer.AJ_KEY.$AJ_IP))) exit('3');
exit('0');
?>