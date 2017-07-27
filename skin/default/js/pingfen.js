define(function(require, exports, module) {
	require('jquery');
	var alertM = require('alert');
	return function(elm,url, id) {
		var $mydp = $(elm),
			$pfBtn = $mydp.find("div.fr a"),
			drawStar = function(li, i, c) {
				var l = li.length,
					index = 0;
				for (; index < l; index++) {
					if (index % 2 == 0) {
						if (index < i) li.eq(index).addClass(c)
						else li.eq(index).removeClass(c)
					} else {
						if (index < i) li.eq(index).addClass("r" + c)
						else li.eq(index).removeClass("r" + c)
					}
				}
			},
			$myt = $mydp.find("b.score");
		$mydp=$mydp.find("div.lpdf");
		var $s = $mydp.find("span.red");
		var doscr = function() {
			var i = 0;
			var l = 0;
			$s.each(function() {
				if ($(this).html()) {
					i += $(this).html() - 0;
					l += 1;
				}
			})
			l = l ? l : 1;
			$myt.html(Math.round(i / l));
		}
		$mydp.on("mouseover", "li", function() {
			var $t = $(this);
			var $p = $t.parent();
			var i = $t.index() + 1;
			var $li = $p.find("li").removeClass("c rc");
			drawStar($li, i, "h");
			$p.next().html(i * 10);
			doscr();
		}).on("click", "li", function() {
			var $t = $(this);
			var $p = $t.parent();
			var i = $t.index() + 1;
			drawStar($p.find("li"), i, "c");
			$p.next().html(i * 10);
			$p.data("s", i);
		}).on("mouseout", "li", function() {
			var $p = $(this).parent();
			var $li = $p.find("li").removeClass("h rh");
			if ($p.data("s")) {
				var i = $p.data("s");
				drawStar($li, i, "c");
				$p.next().html(i * 10);
			} else $p.next().html("");
			doscr();
		}).find("li:odd").addClass("r");
		$pfBtn.on("click", function() {
			alertM("正在提交评分，请稍候", {
				cName: "loading"
			});
			if ($myt.html() == 0) {
				alertM("请先评分", {
					cName: "error"
				});
				return false;
			}
			$.ajax({
				url: url,
				dataType: 'json',
				data: {
					hid: id,
					a: $s.eq(0).html(),
					b: $s.eq(1).html(),
					c: $s.eq(2).html(),
					d: $s.eq(3).html(),
					e: $s.eq(4).html()
				}
			}).done(function(data) {
				if (data.state == "succ") {
					$("#total-marks").html(data.score + "/100");
					$("#point_price_pic").css("width", data.price_score);
					$("#point_price_mark").html(data.price_score + "分");
					$("#point_price_count").html(data.price_num);
					$("#point_milieu_pic").css("width", data.milieu_score);
					$("#point_milieu_mark").html(data.milieu_score + "分");
					$("#point_milieu_count").html(data.milieu_num);
					$("#point_property_pic").css("width", data.property_score);
					$("#point_property_mark").html(data.property_score + "分");
					$("#point_property_count").html(data.property_num);
					$("#point_traffic_pic").css("width", data.traffic_score);
					$("#point_traffic_mark").html(data.traffic_score + "分");
					$("#point_traffic_count").html(data.traffic_num);
					$("#point_facility_pic").css("width", data.facility_score);
					$("#point_facility_mark").html(data.facility_score + "分");
					$("#point_facility_count").html(data.facility_num);
					$mydp.find("li").removeClass("c rc").end().find("span.red").html("0");
					$myt.html("0");
				}
				alertM(data.alert, {
					cName: data.state
				});
			}).fail(function() {
				alertM("评分提交失败，请检查网络连接是否已断开", {
					cName: "error"
				});
			});
		})
	}
});