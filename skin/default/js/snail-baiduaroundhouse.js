define(function(require, exports, module) {
	require('jquery');
	var HOUSE_URL;
	var Maker = function(position, content) {
		this._position = position;
		this._content = content;
		this._div = null;
	};
	var MP = Maker.prototype = new BMap.Overlay();
	
	MP.initialize = function(map) {
		var div = null;
		var content = this._content;
		this._map = map;
		if (!content.nodeType) {
			div = document.createElement("div");
			div.innerHTML = content;
			div = div.firstChild;
		} else {
			div = content
		}
		div.style.position = "absolute";
		map.getPanes().markerPane.appendChild(div);
		this._div = div;
		return div;
	};
	MP.getDomNode = function() {
		return this._div;
	};
	MP.draw = function() {
		var pos = this._position;
		var position = this._map.pointToOverlayPixel(this._position);
		this._div.style.left = position.x + "px";
		this._div.style.top = position.y + "px";
	};

	var popInfo = {};
	var house = false;
	var map;
	var keyword;
	var localSearch;
	var LNG;
	var LAT;

	var latlng,name_index,distance,transit,driving;
	
	var $search_box = $("#search_box");
	
	
	
	//公交、驾车
	$(".icon-18,.icon-19").on("click",function(){
		XF_DETAIL_MAP.resetTo();
		XF_DETAIL_MAP.clearResult();
		XF_DETAIL_MAP.addOverlay(LNG,LAT,name_index);
		$("#traffic_title").text($(this).text());
		XF_DETAIL_MAP.traffic_title = $(this).text();
		$("#sstartname").val(name_index);
		$(".peitao .map_tag").hide();
		$(".peitao .map_lp,.peitao .map_lpcon").show();
		$("#bus_wrap,#drive_wrap").hide().empty();
		return false;
	});

	$("#backMap").click(function(){
		XF_DETAIL_MAP.resetTo();
		XF_DETAIL_MAP.clearResult();
		XF_DETAIL_MAP.addOverlay(LNG,LAT,name_index);
		
		//查询公交路线
		$("#map_nav a.on").trigger("click");
		
		$(".peitao .map_tag,.map_lpcon").show();
		$(".peitao .map_lp").hide();
		$("#bus_wrap,#drive_wrap").hide().empty();
	});
	
	
	
	
	
	
	

	XF_DETAIL_MAP = {
		sstartname:null,
		sendname:null,
		tag:null,
		traffic_title:'公交',
		have_arr_new: {bus:'公交', subway:'地铁', ct:'餐饮', bank:'银行', school:'学校', hos:'医院', buy:'购物', park:'公园', parking:'停车场', gas:'加油站',supermark:'超市',ktv:'KTV',bar:'酒吧',cinema:'电影院',beauty:'美容院',cafe:'咖啡厅',kindergarten:'幼儿园',primarysc:'小学',middlesc:'中学',university:'大学',traffic:'交通',fun:'娱乐',hs:'楼盘'},
		checkFocus:function(ele,txt){
			if(ele.value == txt){
				ele.value = '';
			}
		},
		checkBlur:function(ele,txt){
			if(ele.value == ''){
				ele.value = txt;
			}
		},
		resetTo: function(){
			//移动到初始化的位置
			map.centerAndZoom(latlng,15);
		},
		setKEY: function(key) {
			keyword = key;
		},
		setH: function(h) {
			house = h;
		},
		setURL: function(url) {
			HOUSE_URL = url;
		},
		addOverlay:function(lng,lat,name){
			var latlng = new BMap.Point(lng, lat);
			var marker = new Maker(latlng, "<div style='position:absolute;z-index:999;margin-top:-39px;margin-left:-23px'><table border='0' cellspacing='0' cellpadding='0'><tr><td class='mask_left'>" + name + "</td><td class='mask_right'>&nbsp;</td></tr></table></div>");
			marker.enableMassClear = false;
			map.addOverlay(marker);
		},
		//计算两点间距离
		getShortDistance : function(lon1, lat1, lon2, lat2){
			var DEF_PI = 3.14159265359; // PI
			var DEF_2PI = 6.28318530712; // 2*PI
			var DEF_PI180 = 0.01745329252; // PI/180.0
			var DEF_R = 6370693.5; // radius of earth	
			var ew1, ns1, ew2, ns2, dx, dy, dew, distance;
			// 角度转换为弧度
			ew1 = lon1 * DEF_PI180;
			ns1 = lat1 * DEF_PI180;
			ew2 = lon2 * DEF_PI180;
			ns2 = lat2 * DEF_PI180;
			// 经度差
			dew = ew1 - ew2;
			// 若跨东经和西经180 度，进行调整
			if (dew > DEF_PI)
			dew = DEF_2PI - dew;
			else if (dew < -DEF_PI)
			dew = DEF_2PI + dew;
			dx = DEF_R * Math.cos(ns1) * dew; // 东西方向长度(在纬度圈上的投影长度)
			dy = DEF_R * (ns1 - ns2); // 南北方向长度(在经度圈上的投影长度)
			// 勾股定理求斜边长
			distance = Math.sqrt(dx * dx + dy * dy);
			return parseInt(distance);
		},
		drawMap: function(lng, lat, name, elm) {
			LNG = lng;
			LAT = lat;
			if (lng <= 0 && lat <= 0) return;
			latlng = new BMap.Point(lng, lat);
			name_index=name;
			map = new BMap.Map(document.getElementById(elm), {
				minZoom: 12,
				maxZoom: 18
			});
			map.centerAndZoom(latlng, 15);
			map.enableScrollWheelZoom();
			map.addControl(new BMap.NavigationControl({
				type: BMAP_NAVIGATION_CONTROL_LARGE
			}));
			map.addControl(new BMap.OverviewMapControl());
			map.addControl(new BMap.ScaleControl());
			this.addOverlay(lng, lat, name); //添加地图覆盖物 楼盘名字
			localSearch = new BMap.LocalSearch(map, {
				pageCapacity: 20
			});
			localSearch.setSearchCompleteCallback(this.onBaidu);
			distance = new BMapLib.DistanceTool(map, {lineStroke:2,lineColor:"#c20000"}); // 测距功能
			transit = new BMap.TransitRoute(map, {renderOptions: {map: map, autoViewport: true}, onSearchComplete: this.milkSearchFun}); //公交路线
			driving = new BMap.DrivingRoute(map, {renderOptions: {map: map, autoViewport: true}, onSearchComplete: this.driverSearchFun}); //驾车路线
			
		},
		changeStartEnd: function(){
			var c= $("#sstartname").val();
			$("#sstartname").val($("#sendname").val());
			$("#sendname").val(c);
		},
		transitSearch: function(){
			//公交、驾车路线查询
			if(XF_DETAIL_MAP.traffic_title == '公交'){
				XF_DETAIL_MAP.sstartname = $("#sstartname").val();
				XF_DETAIL_MAP.sendname = $("#sendname").val();
				transit.search(this.sstartname,this.sendname);
			}else if(XF_DETAIL_MAP.traffic_title == '驾车'){
				XF_DETAIL_MAP.sstartname = $("#sstartname").val();
				XF_DETAIL_MAP.sendname = $("#sendname").val();
				driving.search(this.sstartname,this.sendname);
			}
			return false;
		},
		drawLine:function(index){
            var me=this;
            var results = XF_DETAIL_MAP.gjresult;
            var opacity = 0.45;
            var planObj = results.getPlan(index);
            var bounds = new Array();
            var addMarkerFun = function(point,imgType,index,title){
                var url,width,height,myIcon;
                // imgType:1的场合，为起点和终点的图；2的场合为过程的图形
                if(imgType == 1){
                    url = "http://map.baidu.com/image/dest_markers.png";
                    width = 42;
                    height = 34;
                    myIcon = new BMap.Icon(url,new BMap.Size(width, height),{offset: new BMap.Size(14, 32),imageOffset: new BMap.Size(0, 0 - index * height)});
                }else{
                    url = "http://map.baidu.com/image/trans_icons.png";
                    width = 22;
                    height = 25;
                    var d = 25,cha = 0,jia = 0
                    if(index == 2){
                        d = 21;
                        cha = 5;
                        jia = 1;
                    }
                    myIcon = new BMap.Icon(url,new BMap.Size(width, d),{offset: new BMap.Size(10, (11 + jia)),imageOffset: new BMap.Size(0, 0 - index * height - cha)});
                }

                var marker = new BMap.Marker(point, {icon: myIcon});
                if(title != null && title != "") marker.setTitle(title);
                // 起点和终点放在最上面
                if(imgType == 1) marker.setTop(true);
                map.addOverlay(marker);
            };
            var addPoints = function(points){
                for(var i = 0; i < points.length; i++) bounds.push(points[i]);
            };

			map.clearOverlays();
            // 绘制驾车步行线路
            for (var i = 0; i < planObj.getNumRoutes(); i ++){
                var route = planObj.getRoute(i);
                if (route.getDistance(false) > 0){
                    // 步行线路有可能为0
                    map.addOverlay(new BMap.Polyline(route.getPath(), {strokeStyle:"dashed",strokeColor: "#30a208",strokeOpacity:0.75,strokeWeight:4,enableMassClear:true}));
                }
            }
            // 绘制公交线路
            for (i = 0; i < planObj.getNumLines(); i ++){
                var line = planObj.getLine(i);
                addPoints(line.getPath());
                // 公交
                if(line.type == BMAP_LINE_TYPE_BUS){
                    // 上车
                    addMarkerFun(line.getGetOnStop().point,2,2,line.getGetOnStop().title);
                    // 下车
                    addMarkerFun(line.getGetOffStop().point,2,2,line.getGetOffStop().title);
                    // 地铁
                }else if(line.type == BMAP_LINE_TYPE_SUBWAY){
                    // 上车
                    addMarkerFun(line.getGetOnStop().point,2,3,line.getGetOnStop().title);
                    // 下车
                    addMarkerFun(line.getGetOffStop().point,2,3,line.getGetOffStop().title);
                }
                map.addOverlay(new BMap.Polyline(line.getPath(), {strokeColor: "#0030ff",strokeOpacity:opacity,strokeWeight:6,enableMassClear:true}));
            }
            map.setViewport(bounds);
            // 终点
            addMarkerFun(results.getEnd().point,1,1);
            // 开始点
            addMarkerFun(results.getStart().point,1,0);
        },
		show_menu:function(ele,index,total){
			//XF_DETAIL_MAP.clearResult();
			XF_DETAIL_MAP.addOverlay(LNG,LAT,name_index);

			for(var i=0; i<parseInt(total); i++){
				$("#"+ele+i).hide();
			}
			$("#"+ele+index).show();
			
			XF_DETAIL_MAP.drawLine(index);
			/*var firstPlan = XF_DETAIL_MAP.gjresult.getPlan(index);
			// 绘制步行线路
			for (var i = 0; i < firstPlan.getNumRoutes(); i++){
				var walk = firstPlan.getRoute(i);
				if (walk.getDistance(false) > 0){
					// 步行线路有可能为0
					map.addOverlay(new BMap.Polyline(walk.getPath(), {lineColor: "green"}));
				}
			}
			// 绘制公交线路
			for (i = 0; i < firstPlan.getNumLines(); i++){
				var line = firstPlan.getLine(i);
				map.addOverlay(new BMap.Polyline(line.getPath()));
			}*/
		},
		driverSearchFun : function(){
            var drivewrapDiv = $("#drive_wrap");
            if(null != driving && null != drivewrapDiv){
                var result = driving.getResults();
                var count = result.getNumPlans();
                var tansitHtml = [];
                if(count > 0){
                    var plan = result.getPlan(0);
                    var time = parseInt(plan.getDuration(false));
                    var distance = parseFloat(plan.getDistance(false)/1000);
                    distance = Math.round(distance * 10) / 10;
                    var thisnum = 0;
                    tansitHtml.push('<div class="map_line_tit">约'+distance+'公里/'+parseInt(time/60)+'分钟</div>');
                    tansitHtml.push('<dl class="map_line_way drive"><dt class="start"><strong>'+XF_DETAIL_MAP.sstartname+'</strong></dt>');
                    if(plan.getNumRoutes() > 0){
                        var routes = plan.getRoute(0);
                        var l = routes.getNumSteps();
                        for(var m = 0; m < l; m++){
                            thisnum = m + 1;
                            tansitHtml.push('<dd><i>'+thisnum+'.</i><div class="info">'+routes.getStep(m).getDescription(false)+'</div></dd>');
                        }
                    }
                    tansitHtml.push('<dt class="end"><strong>'+XF_DETAIL_MAP.sendname+'</strong></dt></dl>');
                }else{ 
                    tansitHtml.push('<div class="lzbcxb" id="lzbcxb">');
                    tansitHtml.push('<div class="title">请选择准确的起点、途经点或终点</div>');
                    tansitHtml.push('<div class="content">');
                    tansitHtml.push('<div class="seltop">');
                    tansitHtml.push('<div class="s3"></div>');
                    tansitHtml.push('<div class="name">起点：<strong>'+XF_DETAIL_MAP.sstartname+'</strong></div>');
                    tansitHtml.push('</div>');
                    tansitHtml.push('<div class="seltop mart5">');
                    tansitHtml.push('<div class="s3"></div>');
                    tansitHtml.push('<div class="name">终点：<strong>'+XF_DETAIL_MAP.sendname+'</strong></div>');
                    tansitHtml.push('</div>');
                    tansitHtml.push('<div class="info">未找到相关地点。<br />您可以修改搜索内容。</div>');
                    tansitHtml.push('</div>');
                    tansitHtml.push('</div>');
                }
                drivewrapDiv.html(tansitHtml.join(''));
                XF_DETAIL_MAP.hideDiv('bus_wrap');
				$(".map_lpcon").hide();
                drivewrapDiv.show();
            }
		},
		gjresult:null,
		milkSearchFun : function(){
            var drivewrapDiv = $("#bus_wrap");
            if(null != transit && null != drivewrapDiv){
                XF_DETAIL_MAP.gjresult = transit.getResults();
                var count = XF_DETAIL_MAP.gjresult.getNumPlans();
                var tansitHtml = '';
                if(count > 0){
                    tansitHtml += '<div id="dv_scroll">';
                    for(var i = 0; i <count; i++){
                        var plan = XF_DETAIL_MAP.gjresult.getPlan(i);
                        var linesnum = plan.getNumLines();
                        var num = i+1;
                        tansitHtml += '<div class="map_line" >';
                        tansitHtml += '<div class="map_line_tit" onclick="XF_DETAIL_MAP.show_menu(\'buswarp\',\''+i+'\',\''+count+'\');">';
                        tansitHtml += '<strong><span class="hcard">'+num+'、</span>';
                        for(var j = 0; j < linesnum; j++){
                            var zhandian = plan.getLine(j).title;
                            var zhandianarr = zhandian.split("(");
                            tansitHtml += zhandianarr[0];
                            if(j < linesnum -1){  
                                tansitHtml += '<span class="rarr">→</span>';
                            }
                        }
                        var time = parseInt(plan.getDuration(false));
                        var distance = parseFloat(plan.getDistance(false)/1000);
                        distance = Math.round(distance * 10) / 10;
                        tansitHtml += '</strong><em>约'+parseInt(time/60)+'分钟/'+distance+'公里</em>';
                        tansitHtml += '</div>';
                        if(0 == i){
                            tansitHtml += '<div id="buswarp'+i+'">';
                        }else{
                            tansitHtml += '<div id="buswarp'+i+'" style="display:none">';
                        }
                        tansitHtml += '<dl class="map_line_way">';
                        tansitHtml += '<dt class="start"><strong>'+XF_DETAIL_MAP.sstartname+'</strong></dt>';
                        var stationcount = plan.getNumLines();
                        for(var m = 0; m < stationcount; m++){
                            var routs = plan.getRoute(m);
                            var lines = plan.getLine(m);
                            if('0' != routs.getDistance(false)){
                                tansitHtml += '<dd>';
                                tansitHtml += '<i class="walk"></i>';
                                tansitHtml += '<div class="info">步行至&nbsp;<a href="javascript:void(0)" >'+lines.getGetOnStop().title+'</a></div>';
                                tansitHtml += '</dd>';
                            }
                            tansitHtml += '<dd>';
                            if(lines.title.indexOf("地铁") > 0 ){
                                tansitHtml += '<i class="bus">&nbsp;</i>';
                            }else{
                                tansitHtml += '<i class="bus">&nbsp;</i>';
                            }
                            var ztitle = lines.title.split("(");
                            tansitHtml += '<div class="info">乘坐&nbsp;<strong>'+ztitle[0]+'</strong>,&nbsp;在&nbsp;<a class="ks" href="javascript:void(0)" >'+lines.getGetOffStop().title+'</a>&nbsp;下车&nbsp;&nbsp;</div>';
                            tansitHtml += '<dd>';
                        }
                        var routs = plan.getRoute(stationcount+1);
                        if(null != routs && '0' != routs.getDistance(false)){
                            tansitHtml += '<dd>';
                            tansitHtml += '<i class="walk"></i>';
                            tansitHtml += '<div class="info">步行至&nbsp;<a class="ks" href="javascript:void(0)" >'+lines.getGetOnStop().title+'</a></div>';
                            tansitHtml += '</dd>';
                        }
                        tansitHtml += '<dt class="end" ><strong>'+XF_DETAIL_MAP.sendname+'</strong></dt>';
                        tansitHtml += '</dl>';
                        tansitHtml += '</div>';
                        tansitHtml += '</div>';
                    }	
                    tansitHtml += '</div>';
                }else{ 
                    tansitHtml += '<div class="lzbcxb" id="lzbcxb">';
                    tansitHtml += '<div class="title">请选择准确的起点、途经点或终点</div>';
                    tansitHtml += '<div class="content">';
                    if('s' == this.tag){
                        tansitHtml += '<div class="seltop  no2">';
                        tansitHtml += '<div class="s4"></div>';
                        tansitHtml += '<div class="name1">起点：<strong>'+this.sstartname+'</strong></div>';
                        tansitHtml += '</div>';
                    }else{
                        tansitHtml += '<div class="seltop  mart5">';
                        tansitHtml += '<div class="s3"></div>';
                        tansitHtml += '<div class="name">起点：<strong>'+this.sstartname+'</strong></div>';
                        tansitHtml += '</div>';
                    }
                    if('e' == this.tag){
                        tansitHtml += '<div class="seltop no2">';
                        tansitHtml += '<div class="s4"></div>';
                        tansitHtml += '<div class="name1">起点：<strong>'+this.sendname+'</strong></div>';
                        tansitHtml += '</div>';
                    }else{
                        tansitHtml += '<div class="seltop mart5">';
                        tansitHtml += '<div class="s3"></div>';
                        tansitHtml += '<div class="name">终点：<strong>'+this.sendname+'</strong></div>';
                        tansitHtml += '</div>';
                    }
                    tansitHtml += '<div class="info">未找到相关地点。<br />您可以修改搜索内容。</div>';
                    tansitHtml += '</div>';
                    tansitHtml += '</div>';
                }
                drivewrapDiv.html(tansitHtml);
                XF_DETAIL_MAP.hideDiv('drive_wrap');
                $(".map_lpcon").hide();
                drivewrapDiv.show();
            }
		},
		hideDiv:function(ele){
			document.getElementById(ele).style.display = "none";
		},
		distanceOpen: function(){
			distance.open();
		},
		distanceClose: function(){
			distance.close();
		},
		getMaps: function() {
			if (LNG <= 0 && LAT <= 0) return;
			bounds = map.getBounds();
			var max_y = bounds.getNorthEast().lng;
			var max_x = bounds.getNorthEast().lat;
			var min_y = bounds.getSouthWest().lng;
			var min_x = bounds.getSouthWest().lat;
			if (house) {
				$.ajax({
					type: 'GET',
					//url: HOUSE_URL + "map/getaround",
					url:"map.json",
					data: {
						"minX": min_x,
						"maxX": max_x,
						"minY": min_y,
						"maxY": max_y
					},
					dataType: 'json',
					success: function(jsonStr) {
						XF_DETAIL_MAP.onLocal(jsonStr);
					},
					error : function(jsonStr){
						//alert(jsonStr.length)
					}
				})
			} else {
				localSearch.searchNearby(keyword, latlng, 2500);
			}
		},
		onLocal: function(results) {
			var len = 0;
			if (!(results && (len = results.length))) {
				return;
			}
			XF_DETAIL_MAP.clearResult();
			var marker = new Maker(latlng, "<div style='position:absolute;margin-top:-39px;margin-left:-23px'><table border='0' cellspacing='0' cellpadding='0'><tr><td class='mask_left'>" + name_index + "</td><td class='mask_right'>&nbsp;</td></tr></table></div>");
			marker.enableMassClear = false;
			map.addOverlay(marker);
			var html = [];
			var index = 0;
			len = Math.min(len, 26);
			for (var i = 0; i < len; i++) {
				var item = results[i];

				if (parseInt($('#house_raw_id').val()) == item.raw_id) {
					continue;
				}

				var point = new BMap.Point(item.lng, item.lat);
				var numChar = XF_DETAIL_MAP.numToChar(index);

				XF_DETAIL_MAP.addMarker(point, item, numChar);
				html.push(XF_DETAIL_MAP.getResultListItem(item, numChar));
				index++;
			}
			if (keyword) {
				$result_type.html(keyword);
			} else {
				$result_type.html('楼盘');
			}

			$result_list.html(html.join(""));
		},
		numToChar: function(num) {
			return String.fromCharCode(65 + num);
		},
		addMarker: function(point, item, numChar) {
			var marker = new Maker(point, XF_DETAIL_MAP.getMarkerHtml(item, numChar));
			map.addOverlay(marker);
			var curPop = popInfo[numChar] = {};
			curPop["info"] = XF_DETAIL_MAP.getPopInfo(item);
			curPop["point"] = point;
			curPop["ref"] = marker.getDomNode();

			return marker;
		},
		getMarkerHtml: function(result, numChar) {
			var labelHtml = [];

			labelHtml.push("<span class='icon map_marker' ");
			labelHtml.push("title='");
			labelHtml.push(result.title);
			labelHtml.push("' ");
			labelHtml.push("style='cursor:pointer;position:absolute;margin-top:-23px;margin-left:-21px;'>");
			labelHtml.push(numChar);
			labelHtml.push("</span>");

			return labelHtml.join("");
		},
		getPopInfo: function(result) {
			var name = result.title;
			var address = result.address || "";
			var tel = result.phoneNumber;

			var sContent = [];

			sContent.push("<div style='font-size:12px;margin:0px;padding:0px;width:200px;height:60px;'>");
			sContent.push(XF_DETAIL_MAP.getTitleHtml(result));

			if (address) {
				if (result.type == 1) {
					sContent.push("<div>路线：");
				} else {
					sContent.push("<div>地址：");
				}
				sContent.push(address);
				sContent.push("</div>");
			}

			if (tel) {
				sContent.push("<div style='color:orange'>电话：");
				sContent.push(tel);
				sContent.push("</div>");
			}

			sContent.push("</div>");

			return sContent.join("");
		},
		getTitleHtml: function(item) {
			var html = [];
			var raw_id = item.raw_id;
			var title = item.title;
			var spell = item.spell;

			html.push("<div>");
			if (raw_id) {
				html.push("<a target='_blank' href='" + HOUSE_URL + spell + ".html");
				html.push("'>");
				html.push(title);
				html.push("</a>");
			} else {
				html.push("<b>");
				html.push(title);
				html.push("</b>");
			}
			html.push("</div>");

			return html.join("");
		},
		getResultListItem: function(result, juli, keyword) {
			var title = result.title;
			var sContent = [];

			sContent.push("<li><a href=\"javascript:void(0);\" class=\"xxicon icon-20\" target=\"_blank\">");
			sContent.push(title+"（"+keyword+"）</a>");
			sContent.push("<span>"+juli+"米</span>");
			sContent.push("</li>");

			return sContent.join("");
		},
		onBaidu: function(results) {
			var len = 0;
			if (!(results && (len = results.getCurrentNumPois()))) {
				return;
			}
			XF_DETAIL_MAP.clearResult();
			XF_DETAIL_MAP.addOverlay(LNG, LAT, name_index); //添加地图覆盖物 楼盘名字
			var html = [],
				items = [];
			for (var index = 0; index < len; index++) {
				var item = results.getPoi(index);
				var point = item.point;
				//计算距离
				var juli = XF_DETAIL_MAP.getShortDistance(point.lng,point.lat,LNG,LAT);

				items.push({item:item,juli:juli});
			}


			//冒泡循环，按照距离由近到远排序
			for(index=0;index<items.length;index++){
				for(var y=index;y<items.length;y++){
					var z;
					if(parseInt(items[index].juli)>parseInt(items[y].juli)){
						z = items[index];
						items[index] = items[y];
						items[y] = z;
					}
				}
			}

			for(index=0;index<items.length;index++){
				var point = items[index].item.point;
				var numChar = XF_DETAIL_MAP.numToChar(index);
				XF_DETAIL_MAP.addMarker(point, items[index].item, numChar);
				html.push(XF_DETAIL_MAP.getResultListItem(items[index].item, items[index].juli, results.keyword));
			}

			$search_box.html(html.join(""));

			$("#search_box li,.search_box").off("mouseenter").off("mouseleave");
			$("#search_box li").mouseenter(function(){
				var index = $(this).index();
				$(this).addClass("on");
				$(".map_marker:eq("+index+")").addClass("on");
			}).mouseleave(function(){
				var index = $(this).index();
				$(this).removeClass("on");
				$(".map_marker:eq("+index+")").removeClass("on");
			});

			$(".map_marker").mouseenter(function(){
				var index = $(this).index(".map_marker");
				$(this).addClass("on");
				$("#search_box li:eq("+index+")").addClass("on");
			}).mouseleave(function(){
				var index = $(this).index(".map_marker");
				$(this).removeClass("on");
				$("#search_box li:eq("+index+")").removeClass("on");
			});
		},
		clearResult: function() {
			map.clearOverlays();
		}
	}
});