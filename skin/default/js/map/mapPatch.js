//Document By JodJin 2011/04/27
var _id=function(e){return (typeof e == "string") ? document.getElementById(e) : e;}
var defNone='不限';
var defFt=["选择城区","选择片区","价格不限","面积不限","户型不限"];
var defPStr='<p>&and;请先选择城区</p>';
var defFilter=["Districts","Plates","Prices","Areas","Units"];
var _marker,p,d_j,d_h,_b='';
var mapPatch={
	itN:function(itn){
		return $("*[name='"+itn+"']");
	},
	setItnVal:function(itn,itv){
		$("*[name='"+itn+"']").attr("value",itv);
	},
	getItnVal:function(itn){
		var val=$.trim($("*[name='"+itn+"']").attr("value"));
		return val;
	},
	loadAP:function(){
	  	for(var i=0;i<defFilter.length;i++){
			var _t=defFilter[i].toLowerCase();
			this.hovTrig("#"+_t,"#"+_t+"Its","onhov");
			var filterData=eval(defFilter[i]);
			if(i==1){
				var filterStr=defPStr;
			}
			else{
				var filterStr='';
				filterStr+='<a href="javascript:;" hidefocus>'+defNone+'</a>';
				if(i==0){
					for(var k=0;k<filterData.length;k++){
						filterStr+='<a href="javascript:;" hidefocus>'+filterData[k].name+'</a>'; 
					}	
				}else{
					for(var k=0;k<filterData.length;k++){
						filterStr+='<a href="javascript:;" hidefocus>'+filterData[k]+'</a>'; 
					}	
				}
			}
			$("#"+_t+"Its").html(filterStr);
			if(_t=='prices' || _t=='units'){
				$("#shift_"+_t).html(filterStr);
			}
			this.cikTrig(_t);
	  	}
	},
	hovTrig:function(t,c,s){
		$(t).hover(function(){
			$(this).addClass(s);
			$(c).show();						  
		},function(){
			$(this).removeClass(s);
			$(c).hide();	
		});
		$(c).hover(function(){
			$(t).addClass(s);
			$(this).show();						  
		},function(){
			$(t).removeClass(s);
			$(this).hide();	
		});
	},
	cikTrig:function(t){
		if(t=='prices' || t=='units'){
			$("#shift_"+t+" a").click(function(){
				var _j=$("#shift_"+t+" a").index(this);
				$(this).addClass("onshift").siblings().removeClass("onshift");
				if(t=='prices'){d_j=($(this).text()==defNone)?null:(_j-1);}
				if(t=='units'){d_h=($(this).text()==defNone)?null:(_j-1);}
				mapObj.map.dataWin();
			});
		}
		$("#"+t+"Its a").click(function(){
			var j=$("#"+t+"Its a").index(this)-1;
			$(this).parent().hide();
			var aTxt=$(this).text();
			$("#"+t+" a").html(aTxt);
			var filterWidth=0;
			for(var i=0;i<defFilter.length;i++){
				var itv=j;
				if(t==defFilter[i].toLowerCase() && aTxt==defNone){
					j="";
					itv="";
					$("#"+t+" a").html(defFt[i]);
				}
				filterWidth+=$("#"+defFilter[i].toLowerCase()).width();
				if(t=="prices"){params.price=itv;}
				if(t=="areas"){params.area=itv;}
				if(t=="units"){params.units=itv;}
				
			}
			if(t=="districts"){
				$("#plates a").html(defFt[1]);
				if(aTxt==defNone){
					params.district="";
					params.plate="";
					$("#platesIts").html(defPStr);
				}else{
					//var j=$("#"+t+"Its a").index(this)-1;
					var Dist=eval(defFilter[0]);
					var Did=Dist[j].aid;
					mapObj.map.setCenter(Dist[j].x,Dist[j].y,z);
					params.district=Did;
					var itPlate=Plates[Did];
					var filterStr='';
					filterStr+='<a href="javascript:;">'+defNone+'</a>';
					for(var k=0;k<itPlate.length;k++){
						filterStr+='<a href="javascript:;">'+itPlate[k].name+'</a>'; 
					}
					$("#platesIts").html(filterStr);
					$("#platesIts a").click(function(){
						var aTxt=$(this).text();
						var pInt=$("#platesIts a").index(this)-1;
						$(this).parent().hide();
						if(aTxt==defNone){
							params.plate="";
							$("#plates a").html(defFt[1]);
						}else{
							params.plate=itPlate[pInt].pid;
							$("#plates a").html(aTxt);
						}
						mapObj.inData();
					});
				}
			}
			mapObj.inData();
			$(".hovcont").css({width:(filterWidth+50)+"px"});
		});
	},
	goPage:function(_p){
		p=_p;
		mapObj.map.dataWin();
	},
	objMerge:function(){
		var result={};
		for(var i=0;i<arguments.length;i++){
			if('object' != typeof(arguments[i])){
				alert("参数错误");
				break;
			}
			for(j in arguments[i]){
				result[j] = arguments[i][j];
			}
		}
		return result;
	},
	reParams:function(itpas){
		var trigVal="";
		for(var i in itpas){
			trigVal += i+"="+itpas[i]+"&";
		}
		return trigVal;
	},
	getAbsPoint : function (e)
	{
		var x = e.offsetLeft;
		var y = e.offsetTop;
		while(e = e.offsetParent)
		{
			x += e.offsetLeft;
			y += e.offsetTop;
		}
		return {'x': x, 'y': y};
	},
	getRealStyle : function(node)
	{
		var RealStyle;
		if (node.currentStyle)                            /*先试 IE 的 简单API */
		{
			RealStyle = node.currentStyle;
		}
		else if (window.getComputedStyle)              /* 再试 W3C API */
		{
			RealStyle = window.getComputedStyle(node, null);
		}
		return RealStyle;
	},
	getStyleNum:function(value)
	{
		var num = parseInt(value);
		return ( num > 0) ? num : 0;
	},
	oldDocumentHeight:0,
	getWindowWidth:function()
	{
		return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	},
	getWindowHeight:function()
	{
		return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	},
	getDocumentWidth:function() {
		return document.documentElement.scrollWidth || document.body.scrollWidth;
	},
	getDocumentHeight:function() {
		return document.documentElement.scrollHeight || document.body.scrollHeight;
	},
	drag: function(elementToDrag, event, container) {
        var startX = event.clientX,
        startY = event.clientY;
        var container = container || null;
        if (container) container = _id(container);
        var origX = elementToDrag.offsetLeft,
        origY = elementToDrag.offsetTop;
        var deltaX = startX - origX,
        deltaY = startY - origY;
        if (document.addEventListener) {
            document.addEventListener("mousemove", moveHandler, true);
            document.addEventListener("mouseup", upHandler, true)
        } else if (document.attachEvent) {
            elementToDrag.setCapture();
            elementToDrag.attachEvent("onmousemove", moveHandler);
            elementToDrag.attachEvent("onmouseup", upHandler);
            elementToDrag.attachEvent("onlosecapture", upHandler)
        } else {
            var oldmovehandler = document.onmousemove;
            var olduphandler = document.onmouseup;
            document.onmousemove = moveHandler;
            document.onmouseup = upHandler
        }
        if (event.stopPropagation) event.stopPropagation();
        else event.cancelBubble = true;
        if (event.preventDefault) event.preventDefault();
        else event.returnValue = false;
        function moveHandler(e) {
            if (!e) e = window.event;
            var realStyle = mapPatch.getRealStyle(elementToDrag);
            var dragWidth = elementToDrag.offsetWidth;
            var dragHeight = elementToDrag.offsetHeight;
            if (container) {
                var contWidth = container.offsetWidth;
                var contHeight = container.offsetHeight
            } else {
                var contWidth = mapPatch.getDocumentWidth();
                var contHeight = mapPatch.oldDocumentHeight
            }
            var leftMin = e.clientX - deltaX;
            var leftMax = contWidth - dragWidth;
            var dragLeft = (leftMin < 0) ? 0: (leftMax < leftMin) ? leftMax: leftMin;
            var topMin = e.clientY - deltaY;
            var topMax = contHeight - dragHeight;
            var dragTop = (topMin < 0) ? 0: (topMax < topMin) ? topMax: topMin;
            elementToDrag.style.left = dragLeft + "px";
            elementToDrag.style.top = dragTop + "px";
            if (e.stopPropagation) e.stopPropagation();
            else e.cancelBubble = true
        }
        function upHandler(e) {
            if (!e) e = window.event;
            if (document.removeEventListener) {
                document.removeEventListener("mouseup", upHandler, true);
                document.removeEventListener("mousemove", moveHandler, true)
            } else if (document.detachEvent) {
                elementToDrag.detachEvent("onlosecapture", upHandler);
                elementToDrag.detachEvent("onmouseup", upHandler);
                elementToDrag.detachEvent("onmousemove", moveHandler);
                elementToDrag.releaseCapture()
            } else {
                document.onmouseup = olduphandler;
                document.onmousemove = oldmovehandler
            }
            if (e.stopPropagation) e.stopPropagation();
            else e.cancelBubble = true
        }
    }
};