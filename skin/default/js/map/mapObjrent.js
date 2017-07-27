//Document By JodJin 2011/04/27
var W,H,mW,mH;
var mapObj={
	map:null,
	dataDelay:null,
	init:function(){
		this.autoSize();
		this.map=new mapApi(c,x,y,z);
	},
	autoSize:function(){
		var mhDis=$("#mapheader").css("display");
		var mhH=$("#mapheader").height()+15;
		if(mhDis=="none"){mhH=0;}
		W=window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		H=window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		mW=W;
		mH=H-mhH-($("#mapnoti").height()+1);
		$("#"+c).css({width:""+mW+"px",height:""+mH+"px"});
	},
	inData:function(){
		var me=this;
		me.closeWin();
		var bounds=me.map.getBound();
		params.ac=mapPatch.getItnVal("ac");
		var paramsIt=mapPatch.objMerge(bounds,params);
		var doParams=mapPatch.reParams(paramsIt);
		$.ajax({
			type:"post",
			url:"getrdata.php",
			data:doParams,
			dataType:"html",
			beforeSend:function(){
				$("#is_loading").show();
				$("#info_num").html("").hide();
			},
			success:function(msg){
				me.map.clearMarkers();
				var infoNum=0;
				var infos = eval(msg);
				infoNum = infos.length;
				if(infoNum>0){
					me.showResult(infos);
				}
				$("#is_loading").hide();
				$("#info_num").html("在这里找到了"+infoNum+"个小区").show();
			},
			error:function(){
				alert("系统错误");
			}
		});
	},
	closeWin:function(){
		this.map.closeWin();
	},
	showResult:function(metaMarkers){
		this.map.drawMarkers(metaMarkers);
	}
};
$(document).ready(function(){
	mapPatch.loadAP();
	mapObj.init();
	var map=mapObj.map;
	mapObj.inData();
	map.dataTrig(function(){
		if(null != mapObj.dataDelay){clearTimeout(mapObj.dataDelay);}
		mapObj.dataDelay=setTimeout(function(){mapObj.inData();},500);				  
	});
	$(window).bind("resize",function(){
		mapObj.autoSize();
	});
	$("#tab_m_views").click(function(){
		var itcls=$(this).attr("class");
		if(itcls=="m_fullp"){
			$("#mapheader").hide();
			$(this).removeClass().addClass("m_normp").html("退出全屏");
		}
		else{
			$("#mapheader").show();
			$(this).removeClass().addClass("m_fullp").html("全屏地图");
		}
		mapObj.autoSize();
	});
	$("#ksub").click(function(){
		var keyVal=mapPatch.getItnVal("k");
		if($.trim(keyVal)==""){alert("请输入小区关键字");mapPatch.itN("k").focus();return;}
		else{
			params.k=encodeURIComponent(mapPatch.getItnVal("k"));
			mapObj.inData();
			map.setCenter(x,y,12);
		}				  
	});
	$("#areaOrder").click(function(){
		$(this).addClass("onorder").siblings().removeClass("onorder");
		_b=(_b=='area_up')?'area_down':'area_up';
		$("#areaOrder i").html((_b=='area_up')?'↑':'↓');
		mapObj.map.dataWin();
	});
	$("#priceOrder").click(function(){
		$(this).addClass("onorder").siblings().removeClass("onorder");
		_b=(_b=='price_up')?'price_down':'price_up';
		$("#priceOrder i").html((_b=='price_up')?'↑':'↓');
		mapObj.map.dataWin();
	});
});