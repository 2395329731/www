function GetCommunity(keyword, operate){
$.ajax({
		url: SiteUrl+"house.php?action=community",
		type:'GET',
		complete :function(){},
		dataType: 'json',
		data: {query: keyword, pn: 30, action: operate},
		error: function() { alert('发生未知错误,请联系管理员.');},
		success: function(response) {
			if(response){
				var Suggestions = response.suggestions;
				var CommunityID = response.mainids;
				var Len = Suggestions.length;
				if (Len === 0) {
					$('#divSearchResult').hide();
					$('#addCommunity').show();
					$('#txtCommunityName').val(keyword);
				}else{
					var resultShow;
					var ID;
					var IN;
					var NA;
					//document.getElementById("divShow").style.display = "block";
					resultShow = "<ul>";
					for (i = 0; i < Len; i++){
						ID = CommunityID[i];
						IN = Suggestions[i];
						NA = IN.replace(/<span>.*<\/span>/gi, '');
						resultShow += "<li class=\"\" onclick='SelectedCommunity(\"" + NA + "\",\"" + ID + "\");' class=\"\" onmouseover=\"this.className = 'li_hover';\" onmouseout=\"this.className = '';\">";
						resultShow += IN;
						resultShow += "</li>";
					}
					resultShow += "</ul>";
					$('#divShow').show();
					$('#divShow').html(resultShow);
					$('#addCommunity').show();
				}
			}			
		}
   });
}

var arrCommunity;
var sOldValue = '';
var _CommunityName,operate;
function CommunitySearch(_CommunityName){
	var operate = (pubhousetype == 2 || pubhousetype == 1) ? "community" : "office";
	var s = _CommunityName;
	if (sOldValue != s){
		$('#vid').val('');
		$('#divShow').html('<div style="height:28px;line-height:28px;color:#CCCCCC"><img src="'+imgUrl+'loading_nx.gif" align="absmiddle"/>加载中,请稍候...</div>');
		$('#divSearchResult').show();
		arrCommunity = new Array();
		if (s != ''){
			 GetCommunity(_CommunityName, operate);
		}else{
			$('#divShow').hide();
			$('#txtCommunityName').val($('#tbCommunityName').val());
		}
		sOldValue = s;
	}
}
function SelectedCommunity(_CommunityName, _CommunityID){
	$('#villagename').val(_CommunityName);
	$('#villagename').focus();
	$('#vid').val(_CommunityID);
	$('#divSearchResult').hide();
	$('#addCommunity').hide();
}

function saveCommnuity(operate){
	var name = $("#txtCommunityName").val();
	var areaid = $("#areaid").val();
	var circleid = $("#circleid").val();
	var address = $("#txtCommunityAddress").val();
	$.post(SiteUrl+"ajax/addcommunity", {'name':name,'areaid':areaid,'circleid':circleid,'address':address,'operate':operate},
		function(data)
		  {
			var msg = data.split('|');
			if(msg[0]=="success"){
				alert('保存成功.');
				$('#vid').val(msg[1]);
				$('#villagename').val(name);
				$('#divSearchResult').hide();
				$('#addCommunity').hide();
			}else{
				alert(msg[1]);
			}
		  }
		);
}

function saveComtwo(){
	var name = $("#txtCommunityName").val();
	var areaid = $("#areaid_com").val();
	var circleid = $("#circleid_com").val();
	var address = $("#txtCommunityAddress").val();
	var operate = (pubhousetype == 2 || pubhousetype == 1) ? "community" : "office";
	$.post(SiteUrl+"api.php?op=addcommunity", {'name':name,'areaid':areaid,'circleid':circleid,'address':address,'operate':operate},
		function(data)
		  {
			var msg = data.split('|');
			if(msg[0]=="success"){
				alert('保存成功.');
				$('#vid').val(msg[1]);
				$('#villagename').val(name);
				$('#divSearchResult').hide();
				$('#addCommunity').hide();
			}else{
				alert(msg[1]);
			}
		  }
		);
}

//检查小区
function checkCommunity(){
	var bol=false;
	var name = $("#villagename").val();
	$.ajax({
		type: "POST",
		async: false,
		url: SiteUrl+"ajax/checkCommunity",
		data: {villagename:name},
		success: function(data){
			if(data == 'true') {
				bol=true;
				$('#addCommunity').hide();
				$('#divSearchResult').hide();
			}else{
				bol=false;
			}
		}
	});
	return bol;
}

