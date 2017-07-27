define(function(require, exports, module) {
	require('jquery');
	var alertM = require('alert'),
		globalSaleFloors = null,
		chk6 = true,
		chk4 = true,
		chk3 = true,
		chk2 = true,
		chk1 = true,
		$aPanl=$("#aPanl"),
		apDelay=0;
	String.prototype.toQueryParams = function(b) {
		var a = this.strip().match(/([^?#]*)(#.*)?$/);
		if (!a) {
			return {}
		}
		var getvalue = a[1].split(b || '&');
		param = module.exports.obj2Json(getvalue);
		params = eval('(' + param + ')');
		return params;
	}
	String.prototype.strip = function() {
		return this.replace(/^\s+/, "").replace(/\s+$/, "")
	}
	String.prototype.format = function(a) {
		var c = this,
			b;
		for (b in a) {
			c = c.replace("%" + b, a[b])
		}
		return c
	};
	var bMapLabelList = [];
	return {
		createBmapLabelESF: function(i, b, c, h, f, e, n) {
			var d = '<div id="m_' + i + '" class="marker_' + e + (n ? ' marker_hover' : '') + '"><div class="marker_word">' + '<span style="font-weight:bold;">' + b + '</span>' + '&nbsp;套' + '<span class="marker_name" style="' + (n ? 'display:inline-block' : 'display:none') + '">' + c + '</span>' + '%tip<em class="marker_r"></em></div><em class="marker_b"></em></div>';
			isIE6 = window.ActiveXObject && !window.XMLHttpRequest;
			if (isIE6 != null && isIE6 == true) {
				var j = 0;
				if (b != null && b != "") {
					j = b.length
				}
				var a = 0;
				if (map.getZoom() >= 16) {
					d = '<div id="m_' + i + '" class="marker_' + e + (n ? ' marker_hover' : '') + '" oLen="' + (j) + '" mLen="' + (j + a) + '" style="width:' + ((j + a) * 12) + 'px;"><div class="marker_word" style="width:100%">' + '<span style="font-weight:bold;">' + b + '</span>' + '&nbsp;套' + '<span class="marker_name" style="' + (n ? 'display:inline-block' : 'display:none') + '">' + c + '</span>' + '%tip<em class="marker_r"></em></div><em class="marker_b"></em></div>'
				} else {
					d = '<div id="m_' + i + '" class="marker_' + e + (n ? ' marker_hover' : '') + '" oLen="' + (j) + '" mLen="' + (j + a) + '" style="width:' + (j * 12) + 'px;"><div class="marker_word" style="width:100%">' + '<span style="font-weight:bold;">' + b + '</span>' + '&nbsp;套' + '<span class="marker_name" style="' + (n ? 'display:inline-block' : 'display:none') + '">' + c + '</span>' + '%tip<em class="marker_r"></em></div><em class="marker_b"></em></div>'
				}
			}

			d = d.format({
				tip: ""
			})
			var c = new BMap.Label(d, {
				offset: new BMap.Size(-19, -25),
				position: h
			});
			if (n) {
				c.setZIndex(bMapLabelList.length + 100);
			} else {
				c.setZIndex(bMapLabelList.length);
			}

			c._originalZIndex = bMapLabelList.length;
			c._originalClassName = "marker_" + e;
			c.setStyle({
				border: "none",
				backgroundColor: "transparent"
			});
			c.addEventListener("click", function() {
				module.exports.openTipFrame(i, f)
			});

			c.addEventListener("mouseover", function() {
				if (!$("#m_" + i).hasClass('marker_hover')) {
					$("#m_" + i).addClass("marker_10").parent().css("z-index",bMapLabelList.length + 100);
					$("#m_" + i).find('.marker_name').show();
				}
			});
			c.addEventListener("mouseout", function() {
				if (!$("#m_" + i).hasClass('marker_hover')) {
					c.setZIndex(c._originalZIndex);
					$("#m_" + i).removeClass('marker_10').parent().css("z-index",c._originalZIndex);
					$("#m_" + i).find('.marker_name').hide();
				}
			})
			bMapLabelList.push(c);
			map.addOverlay(c)
		},
		createBmapLabel: function(i, b, g, h, f, e) {
			var d = '<div id="m_' + i + '" class="marker_' + e + '"><div class="marker_word">' + b + '%tip<em class="marker_r"></em></div><em class="marker_b"></em></div>';
			isIE6 = window.ActiveXObject && !window.XMLHttpRequest;
			if (isIE6 != null && isIE6 == true) {
				var j = 0;
				if (b != null && b != "") {
					j = b.length
				}
				var a = 0;
				if (g != null && g != "") {
					a = g.length
				}
				if (map.getZoom() >= 16) {
					d = '<div id="m_' + i + '" class="marker_' + e + '" oLen="' + (j) + '" mLen="' + (j + a) + '" style="width:' + ((j + a) * 12) + 'px;"><div class="marker_word" style="width:100%">' + b + '%tip<em class="marker_r"></em></div><em class="marker_b"></em></div>'
				} else {
					d = '<div id="m_' + i + '" class="marker_' + e + '" oLen="' + (j) + '" mLen="' + (j + a) + '" style="width:' + (j * 12) + 'px;"><div class="marker_word" style="width:100%">' + b + '%tip<em class="marker_r"></em></div><em class="marker_b"></em></div>'
				}
			}
			if (g != null && g != "") {
				if (map.getZoom() >= 16) {
					d = d.format({
						tip: '<span id="pr_' + i + '" class="phide" style="display: inline;">' + g + "</span>"
					})
				} else {
					d = d.format({
						tip: '<span id="pr_' + i + '" class="phide" style="display: none;">' + g + "</span>"
					})
				}
			} else {
				d = d.format({
					tip: ""
				})
			}
			var c = new BMap.Label(d, {
				offset: new BMap.Size(-19, -25),
				position: h
			});
			c.setZIndex(bMapLabelList.length);
			c._originalZIndex = bMapLabelList.length;
			c._originalClassName = "marker_" + e;
			c.setStyle({
				border: "none",
				backgroundColor: "transparent"
			});
			c.addEventListener("click", function() {
				module.exports.openTipFrame(i, f)
			});
			if (g != null) {
				if (map.getZoom() >= 16) {
					c.addEventListener("mouseover", function() {
						$("#m_" + i).attr("class", "marker_10").parent().css("z-index",bMapLabelList.length + 100)
					});
					c.addEventListener("mouseout", function() {
						$("#m_" + i).attr("class", c._originalClassName).parent().css("z-index",c._originalZIndex)
					})
				} else {
					c.addEventListener("mouseover", function() {
						$("#pr_" + i).css("display", "inline");
						if (isIE6 != null && isIE6 == true) {
							$("#m_" + i).width($("#m_" + i).attr("mLen"))
						}
						$("#m_" + i).attr("class", "marker_10").parent().css("z-index",bMapLabelList.length + 100)
					});
					c.addEventListener("mouseout", function() {
						$("#pr_" + i).css("display", "none");
						if (isIE6 != null && isIE6 == true) {
							$("#m_" + i).width($("#m_" + i).attr("oLen"))
						}
						$("#m_" + i).attr("class", c._originalClassName).parent().css("z-index",c._originalZIndex)
					})
				}
			} else {
				c.addEventListener("mouseover", function() {
					$("#m_" + i).attr("class", "marker_10").parent().css("z-index",bMapLabelList.length + 100)
				});
				c.addEventListener("mouseout", function() {
					c.setZIndex(c._originalZIndex);
					$("#m_" + i).attr("class", c._originalClassName).parent().css("z-index",c._originalZIndex)
				})
			}
			bMapLabelList.push(c);
			map.addOverlay(c)
		},
		getNewFloors: function(e, b, c, a, d, m, n, f) {
			var bounds = map.getBounds(); //实例化边界
			var max_y = bounds.getNorthEast().lng;
			var max_x = bounds.getNorthEast().lat;
			var min_y = bounds.getSouthWest().lng;
			var min_x = bounds.getSouthWest().lat;
			var ajaxurl = "";
			if (searchType == 'xinfang') ajaxurl = SITE_URL + "api/map/gethouse.php?areaid=" + e + "&keywords=" + (params.keyword != '' ? encodeURIComponent(params.keyword) : '') + "&circleid=" + b + "&projecttype=" + c + "&buildfeature=" + a + "&price=" + d + "&minX=" + min_x + "&maxX=" + max_x + "&minY=" + min_y + "&maxY=" + max_y + '&random=' + Math.random()
			else {
				if (searchType == 'ershoufang') {
					ajaxurl = SITE_URL + "api/map/get_esf.php?";
				} else if (searchType == 'zufang') {
					ajaxurl = SITE_URL + "api/map/get_esf.php?type=zufang&";
				}
				ajaxurl += "areaid=" + e + "&circleid=" + b + "&price=" + c + "&roomtype=" + a + "&area=" + d + "&houseage=" + m + "&project=" + n + "&keywords=" + (params.keyword != '' ? encodeURIComponent(params.keyword) : '') + "&minX=" + min_x + "&maxX=" + max_x + "&minY=" + min_y + "&maxY=" + max_y + '&random=' + Math.random()
			}
			$.ajax({
				url: ajaxurl,
				dataType: 'json'
			}).done(function(h) {
				if (searchType == 'xinfang') {
					if (h.newHouses) {
						if (arguments.length == 6 || f == true) {
							var g = new BMap.Point(params.l2, params.l1);
							map.centerAndZoom(g, params.l3);
						}
						if (h.newHouses != null) {
							globalSaleFloors = h.newHouses;
							module.exports.chooseShowLabel();
						}
					} else {
						map.clearOverlays();
						$aPanl.css("top","24px");
						if(apDelay){
							clearTimeout(apDelay);
							apDelay=0;
						}
						apDelay=setTimeout(function(){
							$aPanl.css("top","-72px");
						},6000)
					}
				} else {
					if (h.xiaoqu) {
						if (arguments.length == 8 || f == true) {
							var g = new BMap.Point(params.l2, params.l1);
							map.centerAndZoom(g, params.l3);
						}
						if (h.xiaoqu != null) {
							globalSaleFloors = h.xiaoqu;
							module.exports.ShowLabel();
						}
					} else {
						map.clearOverlays();
						$aPanl.css("top","24px");
						if(apDelay){
							clearTimeout(apDelay);
							apDelay=0;
						}
						apDelay=setTimeout(function(){
							$aPanl.css("top","-72px");
						},6000)
					}
				}
			})
		},
		getKeyHouse: function(k) {
			if (searchType == "xinfang") {
				$.ajax({
					url: SITE_URL + "api/map/gethouse.php?keyword=" + encodeURIComponent(k),
					dataType: 'json',
					success: function(h) {
						if (h) {
							params.l1 = h.newHouses.bmapy;
							params.l2 = h.newHouses.bmapx;
							params.l3 = 14;
							location.hash = $.param(params);
							var g = new BMap.Point(h.newHouses.bmapx, h.newHouses.bmapy);
							map.centerAndZoom(g, params.l3);
							globalSaleFloors = h.newHouses;
							module.exports.chooseShowLabel();
							module.exports.searchHouse();
						} else {
							alertM('没有找到该楼盘', {
								cName: "error"
							});
						}
					}
				})
			} else {
				if (searchType == 'ershoufang') {
					var ajaxurl = SITE_URL + "api/map/gethouse.php?";
				} else if (searchType == 'zufang') {
					var ajaxurl = SITE_URL + "api/map/gethouse?&type=zufang";
				}
				$.ajax({
					url: ajaxurl + "keyword=" + encodeURIComponent(k),
					dataType: 'jsonp',
					success: function(h) {
						if (h) {
							params.l1 = h.xiaoqu.bmapy;
							params.l2 = h.xiaoqu.bmapx;
							params.l3 = 14;
							location.hash = $.param(params);
							var g = new BMap.Point(h.xiaoqu.bmapx, h.xiaoqu.bmapy);
							map.centerAndZoom(g, params.l3);
							globalSaleFloors = h.xiaoqu;
							module.exports.ShowLabel();
							module.exports.searchHouse();
						} else {
							alertM('没有找到该小区', {
								cName: "error"
							});
						}
					}
				})
			}
		},
		getCurrentHouses: function(type) {
			var bounds = map.getCenter(); 
			params.l1 = bounds.lat; 
			params.l2 = bounds.lng; 
			params.l3 = map.getZoom(); 
			params.keyword='';
			if (type == 'dragend') {
				//params.a1 = ''; //初始化为0
				//params.a2 = '';
				params.h = '';
			}
			module.exports.initSearchStyle(params);
		},
		searchHouse: function() {
			module.exports.initBmap(params); //初始化url参数
			if (searchType == 'xinfang') module.exports.getNewFloors(filter.areaid, filter.circleid, filter.project, filter.feature, filter.price, true);
			else module.exports.getNewFloors(filter.areaid, filter.circleid, filter.price, filter.roomtype, filter.area, filter.houseage, filter.project, true);
		},
		keywordSearch: function() {
			module.exports.getKeyHouse(params.keyword);
		},
		ShowLabel: function() {
			if (searchType == 'ershoufang') {
				var schedule = 3;
			} else if (searchType == 'zufang') {
				var schedule = 2;
			}
			map.clearOverlays();
			var a = 0;
			var b = map.getBounds();
			if (globalSaleFloors != null) {
				bMapLabelList = [];
				$.each(globalSaleFloors, function(c) {
					if (parseInt(globalSaleFloors[c].bmapx) == 0 || parseInt(globalSaleFloors[c].bmapy == 0)) {
						return true;
					}
					var d = new BMap.Point(globalSaleFloors[c].bmapx, globalSaleFloors[c].bmapy);
					if (b.containsPoint(d)) {
						module.exports.createBmapLabelESF(
						globalSaleFloors[c].communityid,
						globalSaleFloors[c].housenums,
						globalSaleFloors[c].communityname,
						d,
						globalSaleFloors[c],
						schedule,
						globalSaleFloors[c].current);
						/*a++;
						if (map.getZoom() > 13) {
							if (a >= 49) {
								return false
							}	//暂不限制房源显示套数 
						} else {
							if (map.getZoom() > 10) {
								if (a >= 29) {
									return false
								}
							} else {
								if (a >= 9) {
									return false
								}
							}
						}*/
					}
				})
			}
		},
		chooseShowLabel: function() {
			map.clearOverlays();
			var a = 0;
			var b = map.getBounds();
			test = map.getCenter();
			if (globalSaleFloors != null) {
				bMapLabelList = [];
				$.each(globalSaleFloors, function(c) {
					if (parseInt(globalSaleFloors[c].bmapx) == 0 || parseInt(globalSaleFloors[c].bmapy == 0)) {
						return true;
					}
					var d = new BMap.Point(globalSaleFloors[c].bmapx, globalSaleFloors[c].bmapy);
					if (b.containsPoint(d)) {
						var sellSchedule = globalSaleFloors[c].current ? 10 : globalSaleFloors[c].sellSchedule;
						if (chk6 == true && globalSaleFloors[c].sellSchedule == 6) {
							module.exports.createBmapLabel(
							globalSaleFloors[c].floorId,
							globalSaleFloors[c].floor,
							null,
							d,
							globalSaleFloors[c],
							sellSchedule);
							a++;
						} else if (chk4 == true && globalSaleFloors[c].sellSchedule == 4) {
							module.exports.createBmapLabel(
							globalSaleFloors[c].floorId,
							globalSaleFloors[c].floor,
							null,
							d,
							globalSaleFloors[c],
							sellSchedule);
							a++;
						} else if (chk3 == true && globalSaleFloors[c].sellSchedule == 3) {
							module.exports.createBmapLabel(
							globalSaleFloors[c].floorId,
							globalSaleFloors[c].floor,
							null,
							d,
							globalSaleFloors[c],
							sellSchedule);
							a++;
						} else if (chk2 == true && globalSaleFloors[c].sellSchedule == 2) {
							module.exports.createBmapLabel(
							globalSaleFloors[c].floorId,
							globalSaleFloors[c].floor,
							null,
							d,
							globalSaleFloors[c],
							sellSchedule);
							a++;
						} else if (chk1 == true && globalSaleFloors[c].sellSchedule == 1) {
							module.exports.createBmapLabel(
							globalSaleFloors[c].floorId,
							globalSaleFloors[c].floor,
							null,
							d,
							globalSaleFloors[c],
							sellSchedule);
							a++;
						}
						/*if (map.getZoom() > 13) {
							if (a >= 49) {
								return false
							}	//暂不限制房源显示套数 
						} else {
							if (map.getZoom() > 10) {
								if (a >= 29) {
									return false
								}
							} else {
								if (a >= 9) {
									return false
								}
							}
						}*/
					}
				})
			}
		},
		openTipFrame: function(c, b) {
			alertM("正在加载，请稍候", {
				cName: "loading",
				time:'y'
			})
			if (searchType == "xinfang") {
				$.ajax({
					type: "GET",
					url: SITE_URL + "api/map/housetip.php?floorId=" + c,
					dataType: 'json'
				}).done(function(data) {
					if (data != null) {
						var url = "";
						if (data.aliasname != "noAlias") url = "<a href='" + HOUSE_URL + data.aliasname + "' target='_blank'>";
						else url = "<a href='javascript:'>";
						var k = "&nbsp;";
						if (data.sellSchedule != "0") {
							switch(data.sellSchedule-0){
								case 1:
									data.sellSchedule=1;
									break;
								case 2:
									data.sellSchedule=2;
									break;
								case 3:
									data.sellSchedule=3;
									break;
									case 4:
									data.sellSchedule=4;
									break;
							}
							k += "<img src='" + IMG_URL + "map/sellSchedule" + data.sellSchedule + ".gif' style='vertical-align:middle;'/>";
						}
						var bbs='';
						if(data.boardId)
							bbs='<a href="'+data.boardId+'" target="_blank" class="fr">进入业主论坛</a>';
						var company='';
						if(data.company!="暂无")
							company=data.company;
						else
							company=data.company;
						var averageprice="";
						if(data.averageprice)
							averageprice='<li><span>项目均价：</span><b style="color:#f70">'+data.averageprice+'</b></li>';
						var html = '<ul id="xfalert"><li>' + url + '<img src="' + data.issuePic + '"></a></li>'+averageprice+'<li>'+bbs+'<span>项目类型：</span>'+data.floorUse+'</li><li><span>开盘日期：</span>' + data.openQuotation + '</li><li><span>开发商：</span>'+company+'</li><li><span>项目地址：</span>' + data.address + '</li><li><span>售楼电话：</span>' + data.phone + '</li></li></ul>'
						alertM(html, {
							time: 'y',
							btnY: 0,
							width: '360',
							title: url + b.floor + "</a>" + k
						})
					} else alertM("无此楼盘详细信息", {
						cName: "error"
					})
				})
			} else {
				if (searchType == 'ershoufang') {
					var ajaxurl = SITE_URL + "api/map/houselist.php?";
					var houseurl = ESF_URL;
					var unit = '万';
					var jun='元';
				} else if (searchType == 'zufang') {
					var ajaxurl = SITE_URL + "api/map/houselist.php?type=zufang&";
					var houseurl = RENT_URL;
					var unit = '元/月';
					var jun='元/月';
				}
				$.ajax({
					type: "GET",
					cache:false,
					url: ajaxurl + "communityid=" + c + "&roomtype=" + filter.roomtype + "&area=" + filter.area+ "&price=" + filter.price+ "&areaid=" + filter.areaid+ "&circleid=" + filter.circleid+ "&houseage=" + filter.houseage+ "&project=" + filter.project,
					//url:ajaxurl + "communityid=" + c + "areaid=" + e + "&circleid=" + b  + "&roomtype=" + a;
					dataType: 'json'
				}).done(function(data) {
					if (data != null) {
						var price='<h5>按'+(searchType == 'ershoufang'?'售价':'租金')+'筛选:</h5><ul id="map2_filters_price"><li><a priceid="0" href="javascript:;">不限</a></li>';
						var t;
						for(t in data.price){
							price+='<li><a priceid="'+data.price[t].fid+'" href="javascript:;">'+data.price[t].name+'</a></li>'
						}
						price+="</ul>";
						var room='<h5>按房型筛选:</h5><ul id="map2_filters_roomtype"><li><a roomid="0" href="javascript:;">不限</a></li>';
						for(t in data.room){
							room+='<li><a roomid="'+data.room[t].fid+'" href="javascript:;">'+data.room[t].name+'</a></li>'
						}
						room+="</ul>";
						var html='<div class="cf" id="esfalert"><div class="fl">'+price+room+'<ul><li><a target="_blank" class="map2_comm_moreinfo" href="'+COMMUNITY_URL+data.communityid+'/">查看小区详情&gt;&gt;</a></li><li><a target="_blank" class="map2_comm_fresh" href="'+COMMUNITY_URL+data.communityid+'/price.html">查看小区房价&gt;&gt;</a></li></ul></div><div id="map2_propertys"><div id="map2_info_sort"><span class="fr">排序：<a rel="area" href="javascript:;" class="lightbtn">按面积排序</a><a rel="price" href="javascript:;" class="lightbtn">按价格排序</a></span><span class="span_propnum"> 找到 <em id="house_nums" class="prop_num" style="">'+data.nums+'</em> 套房子 </span></div>';
						var list="";
						if(data.nums-0>0){
							list='<div id="property_list"><table width="100%">'
							for(var i=0,l=data.house.length;i<l;i++){
								list+='<tr><td><a href="'+houseurl+'show-'+data.house[i].hid+'.html" target="_blank"><img src="'+data.house[i].titlepic+'"></a></td><td><a class="title" title="'+data.house[i].title+'" href="'+houseurl+'show-'+data.house[i].hid+'.html" target="_blank">'+data.house[i].title+'</a><p>'+data.house[i].room+'室'+data.house[i].hall+'厅，'+data.house[i].area+'平米，'+data.house[i].floor+'/'+data.house[i].totalfloor+'层</p></td><td><b class="red">'+data.house[i].price+unit+'</b></td></tr>'}
							list+='</table></div>'
						}else{
							list='<div id="noprops"><p>很抱歉，没有在该小区找到符合条件的房源。</p><p><b>建议您：</b>重新选择房源筛选条件。</p></div>'
						}
						var page='<div id="map2_info_page"><a href="javascript:;" class="page_next lightbtn fr">下一页</a>'+ data.curpage +'/'+ data.totalpage +'</div>'
						alertM(html+list+page,{
							title:'<a href="'+COMMUNITY_URL+data.communityid+'/" target="_blank">'+b.communityname+'</a><b>均价：'+b.sellprice+jun+'</b>',
							width:'640',
							time:'y',
							btnY:0,
							of:function(){
								var dialogFilter={
									page:data.curpage,
									totalpage:data.totalpage,
									price:filter.price,
									roomtype:filter.roomtype,
									area:filter.area,
									areaid:filter.areaid,
									circleid:filter.circleid,
									houseage:filter.houseage,
									project:filter.project,
									areaorder:'',
									priceorder:''
								};
								var communityData=function(){
									$("#property_list table").html('<tr><td><img src="'+IMG_URL+'/map/8-0.gif" style="width:220px;height:19px;"></td></tr>');
									$.ajax({
										type: "GET",
										cache:false,
										url:ajaxurl + "communityid=" + c + "&price=" + dialogFilter.price + "&roomtype=" + dialogFilter.roomtype + "&area=" + dialogFilter.area + "&areaid=" + dialogFilter.areaid + "&circleid=" + dialogFilter.circleid + "&houseage=" + dialogFilter.houseage + "&project=" + dialogFilter.project + "&curpage=" + dialogFilter.page+ "&areaorder=" + dialogFilter.areaorder + "&priceorder=" + dialogFilter.priceorder,
										dataType: 'json'
									}).done(function(data){
										if(data.curpage==1 && data.nums-0>6)
											$("#map2_info_page").html('<a href="javascript:;" class="page_next lightbtn fr">下一页</a>'+ data.curpage +'/'+ data.totalpage);
										else if(data.curpage==data.totalpage)
											$("#map2_info_page").html('<a href="javascript:;" class="page_prev lightbtn fr">上一页</a>'+ data.curpage +'/'+ data.totalpage);
										else{
											$("#map2_info_page").html('<a href="javascript:;" class="page_next lightbtn fr">下一页</a><a href="javascript:;" class="page_prev lightbtn fr">上一页</a>'+ data.curpage +'/'+ data.totalpage);
										}
										var list="";
										if(data.nums-0>0){
											for(var i=0,l=data.house.length;i<l;i++){
												list+='<tr><td><a href="'+houseurl+'show-'+data.house[i].hid+'.html" target="_blank"><img src="'+data.house[i].titlepic+'"></a></td><td><a class="title" title="'+data.house[i].title+'" href="'+houseurl+'show-'+data.house[i].hid+'.html" target="_blank">'+data.house[i].title+'</a><p>'+data.house[i].room+'室'+data.house[i].hall+'厅，'+data.house[i].area+'平米，'+data.house[i].floor+'/'+data.house[i].totalfloor+'层</p></td><td><b class="red">'+data.house[i].price+unit+'</b></td></tr>'}
										}else
											list='<div id="noprops"><p>很抱歉，没有在该小区找到符合条件的房源。</p><p><b>建议您：</b>重新选择房源筛选条件。</p></div>';
										$("#property_list table").html(list);
										$("#house_nums").html(data.nums)
									}).fail(function(){
										$("#property_list").html('<div id="noprops"><p>很抱歉，没有在该小区找到符合条件的房源。</p><p><b>建议您：</b>重新选择房源筛选条件。</p></div>')
									})
								}
								$('#map2_filters_price').on('click','a', function(){
									$('#map2_filters_price a').removeClass("on");
									$(this).addClass("on");
									dialogFilter.price = $(this).attr('priceid');
									dialogFilter.page = 1;
									communityData();
								})
								$('#map2_filters_roomtype').on('click','a', function(){
									$('#map2_filters_roomtype a').removeClass("on");
									$(this).addClass("on");
									dialogFilter.roomtype = $(this).attr('roomid');
									dialogFilter.page = 1;
									communityData();
								})
								$('#map2_info_page').on('click','.page_prev', function(){
									if(dialogFilter.page > 1){
										--dialogFilter.page;
									}
									communityData();
								}).on('click','.page_next', function(){
									if(dialogFilter.page < dialogFilter.totalpage){
										++dialogFilter.page;
									}
									communityData();
								})
								$('#map2_info_sort').on('click','.lightbtn',function(){
									if($(this).attr('rel') == 'area'){
										$(this).addClass('on').next().text("按价格排序").removeClass('on');
										dialogFilter.priceorder = '';
										if(dialogFilter.areaorder == '' || dialogFilter.areaorder == 'DESC'){
											dialogFilter.areaorder = 'ASC';
											$(this).text('面积从小到大');
										}else{
											dialogFilter.areaorder = 'DESC';
											$(this).text('面积从大到小');	
										}
									}else if($(this).attr('rel') == 'price'){
										$(this).addClass('on').prev().text("按面积排序").removeClass('on');
										dialogFilter.areaorder = '';
										if(dialogFilter.priceorder == '' || dialogFilter.priceorder == 'DESC'){
											dialogFilter.priceorder = 'ASC';
											$(this).text('价格从小到大');
										}else{
											dialogFilter.priceorder = 'DESC';
											$(this).text('价格从大到小');
										}
									}
									communityData();
								})
							}
						})
					}else
						alertM("无此房源详细信息",{cName:"error"})
				}).fail(function(){
					alertM("查找失败，请检查网络连接是否已断开",{cName:"error"})
				})
			}
		},
		search: function(c) {
			c = $.trim(c);
			if (c == "" || c == "\u8f93\u5165\u697c\u76d8\u540d\u67e5\u8be2") {
				alertM("\u8bf7\u5148\u8f93\u5165\u697c\u76d8\u540d");
				return
			}
			var b = false;
			var a = -1;
			if (globalSaleFloors != null) {
				$.each(globalSaleFloors, function(d) {
					if (globalSaleFloors[d].floor == c) {
						map.centerAndZoom(new BMap.Point(globalSaleFloors[d].bmapx,
						globalSaleFloors[d].bmapy), 17);
						b = true;
						return false
					} else {
						if (globalSaleFloors[d].floor.indexOf(c) > -1) {
							a = d;
							return false
						}
					}
				});
				if (b == false) {
					if (a > -1) {
						map.centerAndZoom(new BMap.Point(globalSaleFloors[a].bmapx,
						globalSaleFloors[a].bmapy), 17)
					} else {
						alertM("\u6ca1\u6709\u627e\u5230\u8be5\u697c\u76d8", {
							cName: "error"
						});
					}
				}
			}
		},
		colorCheck: function(a, state) {
			if (state) {
				switch (a) {
					case 6:
						chk6 = true;
						break;
					case 4:
						chk4 = true;
						break;
					case 3:
						chk3 = true;
						break;
					case 2:
						chk2 = true;
						break;
					case 1:
						chk1 = true;
						break;
				}
			} else {
				switch (a) {
					case 6:
						chk6 = false;
						break;
					case 4:
						chk4 = false;
						break;
					case 3:
						chk3 = false;
						break;
					case 2:
						chk2 = false;
						break;
					case 1:
						chk1 = false;
						break;
				}
			}
			module.exports.chooseShowLabel()
		},
		obj2Json: function(obj) {
			var ret = [];
			for (var a in obj) {
				if (obj[a].split('=')[0]) {
					ret.push(obj[a].split('=')[0] + ':' + (obj[a].split('=')[1] != '' ? '\'' + obj[a].split('=')[1] + '\'' : '\'\''));
				}
			}
			return '{' + ret.join(',') + '}';
		},
		addDom: function(obj) {
			obj.find('dl.DL1').first().removeClass('init_drop_list');
			obj.find('dl.DL1').first().addClass('over_drop_list');
		},
		delDom: function(obj) {
			obj.find('dl.DL1').first().removeClass('over_drop_list');
			obj.find('dl.DL1').first().addClass('init_drop_list');
		},
		MM_showHideLayers: function(v) {
			var apDiv3 = $("#apDiv3");
			if (v == "show") {
				apDiv3.css("visibility", "visible");
			} else {
				apDiv3.css("visibility", "hidden");
			}
		},
		closeMapInfoDiv: function() {
			$("#ppp").hide();
			$("#chkMorePic").attr("checked", false);
		},
		initBmap: function(params) {
			$aPanl.on("click","a.reZoom",function(){
				$aPanl.css("top","-72px");
				map.setZoom(14);
				module.exports.getCurrentHouses('zoomend');
			}).on("click","a.reCenter",function(){
				$aPanl.css("top","-72px");
				map.reset();
				module.exports.getCurrentHouses('dragend');
			})
			if (searchType == "xinfang") {
				if (!$.isEmptyObject(params)) {
					//此下else分支控制url
					if (params.l1 != undefined && params.l1 > 0 && params.l2 != undefined && params.l2 > 0 && params.l3 != undefined && parseInt(params.l3) > 0) {
						center.lat = parseFloat(params.l1);
						center.lng = parseFloat(params.l2);
						center.zoom = parseInt(params.l3);
					} else {
						params.l1 = center.lat;
						params.l2 = center.lng;
						params.l3 = center.zoom;
					}
					var reset = new BMap.Point(params.l2, params.l1);
					map.setCenter(reset);
					if (params.a1 != undefined && parseInt(params.a1) >= 0) {
						filter.areaid = parseInt(params.a1); //区域ID
					} else {
						params.a1 = '';
						filter.areaid = 0;
					}

					if (params.a2 != undefined && parseInt(params.a2) >= 0) {
						filter.circleid = parseInt(params.a2); //商圈ID
					} else {
						params.a2 = '';
						filter.circleid = 0;
					}

					if (params.f1 != undefined && parseInt(params.f1) >= 0) {
						filter.price = parseInt(params.f1); //均价
					} else {
						params.f1 = '';
						filter.price = 0;
					}

					if (params.f2 != undefined && parseInt(params.f2) >= 0) {
						filter.project = parseInt(params.f2); //项目类型
					} else {
						params.f2 = '';
						filter.project = 0;
					}

					if (params.f3 != undefined && parseInt(params.f3) >= 0) {
						filter.feature = parseInt(params.f3); //建筑特征
					} else {
						params.f3 = '';
						filter.feature = 0;
					}

					if (params.h != undefined && parseInt(params.h) >= 0) {
						params.h = parseInt(params.h); //浏览记录
					} else {
						params.h = '';
					}

					if (params.keyword != undefined && params.keyword != '输入名称或地标') {
						filter.keyword = params.keyword; //搜索关键字
					} else {
						params.keyword = '';
						filter.keyword = '';
					}
					location.hash = $.param(params);
				} else {
					//设置参数
					params.l1 = center.lat;
					params.l2 = center.lng;
					params.l3 = center.zoom;
					params.a1 = '';
					params.a2 = '';
					params.f1 = '';
					params.f2 = '';
					params.f3 = '';
					params.h = ''; //浏览记录
					params.keyword = '';
					var url = {
						'l1': center.lat,
						'l2': center.lng,
						'l3': center.zoom,
						'a1': '',
						'a2': '',
						'f1': '',
						'f2': '',
						'f3': '',
						'keyword': '',
						'h': ''
					};
				}
			} else {
				if (!$.isEmptyObject(params)) {
					//此下else分支控制url
					if (params.l1 != undefined && params.l1 > 0 && params.l2 != undefined && params.l2 > 0 && params.l3 != undefined && parseInt(params.l3) > 0) {
						center.lat = parseFloat(params.l1);
						center.lng = parseFloat(params.l2);
						center.zoom = parseInt(params.l3);
					} else {
						params.l1 = center.lat;
						params.l2 = center.lng;
						params.l3 = center.zoom;
					}
					var reset = new BMap.Point(params.l2, params.l1);
					map.setCenter(reset);
					if (params.a1 != undefined && parseInt(params.a1) >= 0) {
						filter.areaid = parseInt(params.a1); //区域ID
					} else {
						params.a1 = '';
						filter.areaid = 0;
					}

					if (params.a2 != undefined && parseInt(params.a2) >= 0) {
						filter.circleid = parseInt(params.a2); //商圈ID
					} else {
						params.a2 = '';
						filter.circleid = 0;
					}

					if (params.f1 != undefined && parseInt(params.f1) >= 0) {
						filter.price = parseInt(params.f1); //均价
					} else {
						params.f1 = '';
						filter.price = 0;
					}

					if (params.f2 != undefined && parseInt(params.f2) >= 0) {
						filter.roomtype = parseInt(params.f2); //户型
					} else {
						params.f2 = '';
						filter.roomtype = 0;
					}

					if (params.f3 != undefined && parseInt(params.f3) >= 0) {
						filter.area = parseInt(params.f3); //面积
					} else {
						params.f3 = '';
						filter.area = 0;
					}

					if (params.f4 != undefined && parseInt(params.f4) >= 0) {
						filter.houseage = parseInt(params.f4); //建筑年代
					} else {
						params.f4 = '';
						filter.houseage = 0;
					}

					if (params.f5 != undefined && parseInt(params.f5) >= 0) {
						filter.project = parseInt(params.f5); //项目类型
					} else {
						params.f5 = '';
						filter.project = 0;
					}

					if (params.h != undefined && parseInt(params.h) >= 0) {
						params.h = parseInt(params.h); //浏览记录
					} else {
						params.h = '';
					}

					if (params.keyword != undefined && params.keyword != '\u8f93\u5165\u540d\u79f0\u6216\u5730\u6807') {
						filter.keyword = params.keyword; //搜索关键字
					} else {
						params.keyword = '';
						filter.keyword = '';
					}
					location.hash = $.param(params);
				} else {
					//设置参数
					params.l1 = center.lat;
					params.l2 = center.lng;
					params.l3 = center.zoom;
					params.a1 = '';
					params.a2 = '';
					params.f1 = '';
					params.f2 = '';
					params.f3 = '';
					params.f4 = '';
					params.f5 = '';
					params.h = ''; //浏览记录
					params.keyword = '';
					var url = {
						'l1': center.lat,
						'l2': center.lng,
						'l3': center.zoom,
						'a1': '',
						'a2': '',
						'f1': '',
						'f2': '',
						'f3': '',
						'f4': '',
						'f5': '',
						'keyword': '',
						'h': ''
					};
					location.hash = $.param(url);
				}
			}
		},
		initSearchStyle: function(params) {
			if ($('#keyword').val() != "输入名称或地标" && $('#keyword').val() != '') {
				module.exports.keywordSearch();
				$('#keyword').val(params.keyword);
				return;
			}
			$.each($('#price a'), function() { //价格
				if (params.f1 == $(this).attr('fid')) {
					$(this).addClass('on');
				} else {
					$(this).removeClass('on');
				}
			})
			$.each($('#areaList a'), function() { //区域
				if (params.a1 == $(this).attr('pid')) {
					$('#areaList').find('span').html($(this).html());
					$('#areaList').find('s').width($('#areaList').outerWidth() - 2)
					return false;
				}
			})
			$.each($('#blockList a'), function() { //商圈
				if (params.a2 == $(this).attr('pid')) {
					$('#blockList').find('span').html($(this).html());
					$('#blockList').find('s').width($('#blockList').outerWidth() - 2)
					return false;
				}
			})
			if (searchType == "xinfang") {
				$.each($('#project a'), function() { //项目类型
					if (params.f2 == $(this).attr('fid')) {
						$(this).addClass('on');
					} else {
						$(this).removeClass('on');
					}
				})
				$.each($('#feature a'), function() { //建筑特征
					if (params.f3 == $(this).attr('fid'))
					 $('#feature span').html($(this).html());
				})
				/*$.each($('#recentList a'), function(){//浏览记录
					if(params.h == $(this).attr('hid')){
						$('#recent_select').html($(this).html());
					}
				})*/
			} else {
				$.each($('#roomtype a'), function() { //项目类型
					if (params.f2 == $(this).attr('fid')) {
						$(this).addClass('on');
					} else {
						$(this).removeClass('on');
					}
				})
				$.each($('#filter_area a'), function() { //面积
					if (params.f3 == $(this).attr('paramid')) $('#filter_area span').html($(this).html());
				})
				$.each($('#filter_age a'), function() { //建筑年代
					if (params.f4 == $(this).attr('paramid')) $('#filter_age span').html($(this).html());
				})
				$.each($('#filter_type a'), function() { //项目类型
					if (params.f5 == $(this).attr('paramid')) $('#filter_type span').html($(this).html());
				})
				/*$.each($('#recentList a'), function(){//浏览记录
					if(params.h == $(this).attr('hid')){
						$('#recent_select').html($(this).html());
					}
				})*/
			}
			module.exports.searchHouse();
		}
	}
});