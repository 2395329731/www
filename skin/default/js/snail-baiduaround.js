define(function(require, exports, module) {
	require('jquery');
	var HOUSE_URL;
	var Maker = function(position, content) {
		this._position = position;
		this._content = content;
		this._div = null;
	};
	var MP = Maker.prototype = new BMap.Overlay();
	var latlng,name_index;
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

	var $result_box = $("#map_traffic_search_box");
	var $result_list = $result_box.find("ul");
	var $result_type = $result_box.find("h4");
	$result_list.on("mouseover", "li", function(event) {
		$(this).addClass("tab-on");
	}).on("mouseout", "li", function(event) {
		$(this).removeClass("tab-on");
	});

	return {
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
			var marker = new Maker(latlng, "<div style='position:absolute;margin-top:-39px;margin-left:-23px'><table border='0' cellspacing='0' cellpadding='0'><tr><td class='mask_left'>" + name + "</td><td class='mask_right'>&nbsp;</td></tr></table></div>");
			marker.enableMassClear = false;
			map.addOverlay(marker);
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
			module.exports.addOverlay(lng, lat, name);
			localSearch = new BMap.LocalSearch(map, {
				pageCapacity: 26
			});
			localSearch.setSearchCompleteCallback(module.exports.onBaidu);
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
					url: HOUSE_URL + "map/getaround",
					//url:"map.json",
					data: {
						"minX": min_x,
						"maxX": max_x,
						"minY": min_y,
						"maxY": max_y
					},
					dataType: 'json',
					success: function(jsonStr) {
						module.exports.onLocal(jsonStr);
					}
				})
			} else {
				localSearch.searchInBounds(keyword, bounds);
			}
		},
		onLocal: function(results) {
			var len = 0;
			if (!(results && (len = results.length))) {
				return;
			}
			module.exports.clearResult();
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
				var numChar = module.exports.numToChar(index);

				module.exports.addMarker(point, item, numChar);
				html.push(module.exports.getResultListItem(item, numChar));
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
			var marker = new Maker(point, module.exports.getMarkerHtml(item, numChar));
			map.addOverlay(marker);
			var curPop = popInfo[numChar] = {};
			curPop["info"] = module.exports.getPopInfo(item);
			curPop["point"] = point;
			curPop["ref"] = marker.getDomNode();

			return marker;
		},
		getMarkerHtml: function(result, numChar) {
			var labelHtml = [];

			labelHtml.push("<span class='icon' ");
			labelHtml.push("title='");
			labelHtml.push(result.title);
			labelHtml.push("' ");
			labelHtml.push("style='cursor:pointer;position:absolute;margin-top:-31px;margin-left:-11px;'>");
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
			sContent.push(module.exports.getTitleHtml(result));

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
		getResultListItem: function(result, numChar) {
			var raw_id = result.raw_id;
			var title = result.title;
			var sContent = [];

			sContent.push("<li>");

			sContent.push("<span class='icon'>");
			sContent.push(numChar);
			sContent.push("</span>");

			sContent.push(module.exports.getTitleHtml(result));

			sContent.push("</li>");

			return sContent.join("");
		},
		onBaidu: function(results) {
			var len = 0;
			if (!(results && (len = results.getCurrentNumPois()))) {
				return;
			}
			module.exports.clearResult();
			var marker = new Maker(latlng, "<div style='position:absolute;margin-top:-39px;margin-left:-23px'><table border='0' cellspacing='0' cellpadding='0'><tr><td class='mask_left'>" + name_index + "</td><td class='mask_right'>&nbsp;</td></tr></table></div>");
			marker.enableMassClear = false;
			map.addOverlay(marker);
			var html = [];
			for (var index = 0; index < len; index++) {
				var item = results.getPoi(index);
				var point = item.point;
				var numChar = module.exports.numToChar(index);

				module.exports.addMarker(point, item, numChar);
				html.push(module.exports.getResultListItem(item, numChar));
			}
			$result_type.html(keyword);
			$result_list.html(html.join(""));
		},
		clearResult: function() {
			map.clearOverlays();
			$result_list.empty();
		}
	}
});