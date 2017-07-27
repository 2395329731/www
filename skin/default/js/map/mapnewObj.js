//Document By JodJin 2011/11/07
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
		var paramsIt=mapPatch.objMerge(bounds,params);
		var doParams=mapPatch.reParams(paramsIt);
		$.ajax({
			type:"post",
			url:"getnewdata.php",
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
				var infohtml="";
				if(typeof(infos)!="undefined"){
					infoNum = infos.length;
					if(infoNum>0)
					{
						me.showResult(infos);
						if(infoNum>1)
						{
						 for(var i=0;i<infos.length;i++)
						 {
		                 var infotr=infos[i];						
						 infohtml +='<LI><span class="sico'+infotr.sales+'">'+infotr.saletype+'</span>&nbsp;';
						 infohtml +='<A title='+infotr.cname+' href="javascript:;" onclick="mapObj.mapto('+infotr.cid+','+infotr.x+','+infotr.y+')">'+infotr.cname+'</A>';
						 infohtml +='<BR><DIV style="COLOR: #777; MARGIN-LEFT: 14px">均价：<LABEL  style="COLOR: #ff4d00">'+infotr.averprice+' </LABEL>元/㎡<BR>电话：'+infotr.tel+'';
						 infohtml +='<BR>地址：'+infotr.hseat+'</DIV></LI>';
	                     }
						 $("#infolist_num").text(infoNum);
						 $("#houselist").html(infohtml).show();	
					   }
					}
				}
				$("#is_loading").hide();
				$("#info_num").html("在这里找到了"+infoNum+"个楼盘").show();	
				
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
	},
	mapto:function(cid,x,y){
		params.k="";
		params.district="";
		params.plate="";
		params.protype="";
		params.price="";	
		params.sale="";
		params.hid=cid;
		mapObj.inData();
		this.map.setCenter(x,y,16);
	},
	Nocondition:function()
	{
	   	params={city:"sy",k:"",district:"",plate:"",protype:"",price:"",sale:"1,2,3",r:Math.random()};
		mapObj.inData();
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
		if($.trim(keyVal)==""){alert("请输入楼盘名称或地址关键字");mapPatch.itN("k").focus();return;}
		else{
			params.k=encodeURIComponent(mapPatch.getItnVal("k"));
			params.district="";
		    params.plate="";
		    params.protype="";
		    params.price="";
			params.hid="";
			params.sale="";
			mapObj.inData();
			map.setCenter(x,y,12);
		}				  
	});
	
});