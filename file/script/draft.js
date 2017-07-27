/*
	[Aijiacms  System] Copyright (c) 2012-2016 Aijiacms.COM
	This is NOT a freeware, use is subject to license.txt
*/
var fck_html = '';
document.write('<div style="width:98%;color:#666666;">'); 
document.write('<a href="javascript:" onclick="fck_get_data();" class="t">'+L['data_recovery']+'</a>');
document.write('&nbsp;|&nbsp;');
document.write('<a href="javascript:" onclick="fck_save_draft();" class="t">'+L['save_draft']+'</a>');
document.write('&nbsp;|&nbsp;<span id="fck_switch"></span>&nbsp;&nbsp;<span id="fck_data_msg"></span>');
document.write('</div>');
function fck_get_data() {makeRequest('action=get_data&mid='+ModuleID, AJPath, '_fck_get_data');} 
function _fck_get_data() {   
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {  
		if(xmlHttp.responseText) {
			if(confirm(lang(L['if_cover_data'], [xmlHttp.responseText.substring(0, 19)]))) editor.html(xmlHttp.responseText.substring(19, xmlHttp.responseText.length));
		} else {
			alert(L['no_data']);
		}
	}
}
function fck_save_data() {
	var l = FCKLen(); if(l < 10) return;
	var c = FCKXHTML();if(fck_html == c) return;
	makeRequest('action=save_data&mid='+ModuleID+'&content='+encodeURIComponent(c), AJPath);
	fck_html = c; var today = new Date();
	Dd('fck_data_msg').innerHTML = '<img src="'+DTPath+'file/image/clock.gif"/>'+lang(L['draft_auto_saved'], [today.getHours(), today.getMinutes(), today.getSeconds()]);
}
function fck_save_draft() {
	var l = FCKLen();
	if(l < 10) {alert(lang(L['at_least_10_letters'], [l]));return;}
	if(confirm(L['stop_auto_save'])) {
		fck_stop();
		makeRequest('action=save_data&mid='+ModuleID+'&content='+encodeURIComponent(FCKXHTML()), AJPath);
		Dd('fck_data_msg').innerHTML = L['draft_saved'];
		window.setTimeout(function(){Dd('fck_data_msg').innerHTML = '';}, 3000);
	}
}
var fck_interval;
function fck_init() {
	fck_interval = setInterval('fck_save_data()', 30000); 
	Dd('fck_data_msg').innerHTML = '';
	Dd('fck_switch').innerHTML = '<a href="javascript:" class="t" onclick="fck_stop();">'+L['stop_save']+'</a>';
}
function fck_stop() {
	clearInterval(fck_interval);
	Dd('fck_data_msg').innerHTML = L['draft_save_stopped'];
	Dd('fck_switch').innerHTML = '<a href="javascript:" class="t" onclick="fck_init();">'+L['start_save']+'</a>';
}
fck_init();