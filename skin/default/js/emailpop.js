define(function(require, exports, module) {
	require('jquery');
	require('../css/pop.css');
	var $pop, $bind, delay, rsDelay, l,
	list = ["gmail.com", "sina.com", "163.com", "qq.com", "126.com", "vip.sina.com", "sina.cn", "hotmail.com", "sohu.com", "yahoo.cn", "139.com", "wo.com.cn", "189.cn", "21cn.com"],
		resize = function() {
			if (rsDelay) clearTimeout(rsDelay);
			rsDelay = setTimeout(function() {
				var offset = $bind.offset();
				$pop.css({
					left: offset.left,
					top: offset.top + $bind.outerHeight() + 2,
					width: $bind.outerWidth()
				});
			}, 99)
		},
		appendPop=function(){
			$("body").append('<ul id="emailpop" class="autopop"></ul>');
			$pop = $("#emailpop").on("mouseenter", "li:not(:first)", function() {
				$pop.find(".pop").removeClass("pop");
				$(this).addClass("pop");
			}).on("mousedown", "li:not(:first)", function() {
				$bind.val($(this).text());
				$pop.hide();
			});
		}
	if (-[1, ])
		appendPop();
	else
		$(appendPop)
	$.fn.emailpop = function() {
		return $(this).attr("autocomplete", "off").each(function() {
			var $t = $(this).on({
				focus: function() {
					resize();
					$bind = $t.trigger("keydown");
					$(window).on("resize", resize);
				},
				keydown: function(e) {
					switch (e.which) {
						case 9:
							$pop.hide();
							break;
						case 32:
							return false;
							break;
						case 13:
							$t.val($pop.hide().find(".pop").text());
							break;
						case 38:
							var $p = $pop.find(".pop").removeClass("pop");
							if ($p.index() > 1) $p = $p.prev().addClass("pop");
							else $p = $pop.find("li").last().addClass("pop");
							$t.val($p.text());
							return false;
						case 40:
							var $p = $pop.find(".pop").removeClass("pop");
							if ($p.index() < l - 1) $p = $p.next().addClass("pop");
							else $p = $pop.find("li").eq(1).addClass("pop");
							$t.val($p.text());
							return false;
						default:
							if (delay) clearTimeout(delay);
							delay = setTimeout(function() {
								var val = $t.val();
								if ($.trim(val).length) {
									var i = 0,
										s = val.indexOf("@"),
										u = val,
										r = "",
										html = '<li class="notpop">请选择邮箱类型</li><li class="pop">' + val + '</li>';
									if (s >= 0) {
										u = val.substr(0, s);
										r = val.substr(s + 1)
									}
									l = list.length;
									for (; i < l; i++) {
										if (r.length > 0) {
											if (list[i].indexOf(r) > -1 && r != list[i]) html += "<li>" + u + "@" + list[i] + "</li>";
										} else html += "<li>" + u + "@" + list[i] + "</li>"
									}
									l = $pop.html(html).show().find("li").length;
									resize();
								} else $pop.hide();
							}, 98)
					}
				},
				blur: function() {
					$pop.hide();
					$(window).off("resize", resize);
				}
			})
		})
	}
});