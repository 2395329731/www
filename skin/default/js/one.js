var sqlArray=new Array("","","","","");		//用来存放生成的查询条件

/////////////////////////////////////////////
///removeSql：移除指定的条件
///index:条件的索引,例如：0:物业，1总价....
/////////////////////////////////////////////
function removeSql(index){
	sqlArray[index] = "";
}
/////////////////////////////
///clearSql：清除所有的条件
/////////////////////////////
function clearSql(){
	for(var i = 0;i < sqlArray.length;i++){
		sqlArray[i]	 = "";
	}
}

/////////////////////////
///addSql：添加指定的条件
///value:指定条件的值
/////////////////////////
function addSql(index,value){
	//removeSql(index);
	sqlArray[index] = value;
	if(index == 1){
		loadRegion();
	}
	if(index == 2){
		loadBusiArea();
	}
	if(index == 4){
		loadHouseView();
	}
}

//////////////////////////////////////////
///loadBusiArea:根据前面选择的条件，生成区域
//////////////////////////////////////////
function loadRegion(){
	$(".b3 ul").html('<span>正在加载。。。。</span>');
	var url = "api.php?op=getBusiArea&top=1";
	var params = {"AreaID":sqlArray[2]};
	$.post(url,params,function(data){
		if(data.Rows.length > 0){
			var html = "";
			for(var i = 0;i < data.Rows.length;i++){
				html += '<li><a href="javascript:addSql(2,'+data.Rows[i].BusiAreaID+');">'+data.Rows[i].BusiName+'</a></li>';
			}
			$(".b3 ul").html(html);
		}else{
			$(".b3 ul").html("<span>当前系统没有版块</span>");
		}
	},'json');
}

//////////////////////////////////////////
///loadBusiArea:根据前面选择的条件，生成区域
//////////////////////////////////////////
function loadBusiArea(){
	if(sqlArray[2] == ""){
		$(".b5 ul").html('<span>如果没有选择方位，就没有版块</span>');
		return;
	}
	$(".b5 ul").html('<span>正在加载。。。。</span>');
	var url = "api.php?op=getBusiArea";
	var params = {"AreaID":sqlArray[2]};
	$.post(url,params,function(data){
		if(data.Rows.length > 0){
			var html = "";
			for(var i = 0;i < data.Rows.length;i++){
				html += '<li><a href="javascript:addSql(3,'+data.Rows[i].BusiAreaID+');">'+data.Rows[i].BusiName+'</a></li>';
			}
			$(".b5 ul").html(html);
		}else{
			$(".b5 ul").html("<span>您选择的方位，没有版块</span>");
		}
	},'json');
}

function loadHouseView(){
	$("#buildList").html("");
	$("#prompt").html("正在查找楼盘，请稍等......");
	var url = "http://localhost/api/getHouseViewListByOne.php";
	var params = new Array();
	params.push({"name":"start","value":1});
	params.push({"name":"limit","value":15});
	for(var i=0;i < sqlArray.length;i++){
		if(sqlArray[i] != ""){
			params.push({"name":"item_"+i,"value":sqlArray[i]});
		}
	}
	var character="";
	if(sqlArray[4])
	{
		if(sqlArray[4]=='7')
		{
			character='海景房';
		}
		if(sqlArray[4]=='4')
		{
			character='学区房';
		}
		if(sqlArray[4]=='5')
		{
			character='旅游地产';
		}
		if(sqlArray[4]=='6')
		{
			character='投资地产';
		}
		if(sqlArray[4]=='9')
		{
			character='宜居地产';
		}
		if(sqlArray[4]=='8')
		{
			character='经济房';
		}
		if(sqlArray[4]=='3')
		{
			character='公园';
		}
	}
	$.post(url,params,function(data){
		if(data.Rows.length > 0){
			if(data.Rows.length==15)
			{
				$("#prompt").html("这里只显示了满足条件的前15个楼盘，想了解更多楼盘，请点击更多楼盘");
			}
			else
			{
				$("#prompt").html("根据您的要求找到了"+data.Rows.length+"个楼盘，想了解更多楼盘，可以尝试其他条件");
			}
			var html = "";
			var housestr = '';
			for(var i = 0;i < data.Rows.length;i++){
				if(i<12)
				{
					housestr+= '@'+data.Rows[i].BuildingName+' ';
				}
				html +='<li><a href="'+data.Rows[i].BuildingUrl+'/" target="_blank" class="img">';
				if(data.Rows[i].BuildDefaultPic != ""){
					html += '<img src="'+data.Rows[i].BuildDefaultPic+'"/>';
				}else{
					html +='<img src="/statics/default/img/index/nopic.jpg"/>';
				}
				html +='</a><h2><a href="'+data.Rows[i].BuildingUrl+'/" target="_blank">'+data.Rows[i].BuildingName+'</a></h2>均价：';
				if(data.Rows[i].AvgPrice > 0){
					html += data.Rows[i].AvgPrice+ data.Rows[i].AvgPriceUnit;
				}else{
					html += '待定';
				}
			    html +='<p>地址：'+data.Rows[i].Address+'</p><a href="'+data.Rows[i].BuildingUrl+'/" class="detail" target="_blank">楼盘详情</a>&nbsp;<a href="'+data.Rows[i].BuildingUrl+'/peitao.html" class="gomap" target="_blank">查看地图</a></li>';
			}
			$("#share").html("<a href=\"javascript:void(0)\" onclick=\"var _t = encodeURI('我刚刚在使用了一分钟找房功能，找到了"+character+"楼盘："+housestr+"');var _url = encodeURIComponent(document.location);var _appkey = encodeURI('1266317589');var _ralateUid=encodeURI('');var _pic = encodeURI('"+data.Rows[0].BuildDefaultPic+"');var _site = '';var _u = 'http://v.t.sina.com.cn/share/share.php?url='+_url+'&appkey='+_appkey+'&ralateUid='+_ralateUid+'&site='+_site+'&pic='+_pic+'&title='+_t;window.open( _u,'', 'width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no' );\" title=\"分享到新浪微博\"><img src=\"http://www.venfang.com/images/sina.gif\" title=\"分享到新浪微博\" border=\"0\" style=\"margin-top:10px;\"/></a>");
			$("#buildList").html(html);
			$.slideView.init({panelWrapper:'panelWrapper', prevButton:'prevButton', prevMore:'prevMore', nextButton:'nextButton', nextMore:'nextMore', img:'.img'});//轮播
		}else{
			$("#prompt").html("");
			$("#buildList").html("没有找到满足条件的楼盘，建议您适当放宽条件查找");
		}
	},'json')
}





