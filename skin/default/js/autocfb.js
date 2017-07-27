define(function(require, exports, module) {
	var $pop, $bind, delay, rsDelay;
	require('jquery');
	require('../css/pop.css');
	var appendPop=function(){
		$("body").append('<ul id="autoc" class="autopop"></ul>');
		$pop = $("#autoc").on("mouseenter", "li", function() {
			$pop.find(".pop").removeClass("pop");
			$(this).addClass("pop");
		}).on("mousedown", "li", function() {
			$bind.val($(this).find("b").text()).closest("form").trigger("submit");
			$pop.hide();
		});
	},
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
	}
	if (-[1, ])
		appendPop();
	else
		$(appendPop)
	$.fn.autoC = function(url) {
		return $(this).each(function() {
			var l = 0,
				delay = 0,
				$t = $(this).attr("autocomplete", "off").on({
					focus: function() {
						resize();
						$bind = $t.trigger("keyup");
						$(window).on("resize", resize);
					},
					keydown: function(e) {
						switch (e.which) {
							case 9:
								$pop.hide();
								break;
							case 13:
								$t.val($pop.hide().find(".pop b").text());
								break;
							case 38:
								var $p = $pop.find(".pop").removeClass("pop");
								if ($p.index() > 0) $p = $p.prev().addClass("pop");
								else $p = $pop.find("li").last().addClass("pop");
								$t.val($p.find("b").text());
								return false;
							case 40:
								var $p = $pop.find(".pop").removeClass("pop");
								if ($p.index() < l) $p = $p.next().addClass("pop");
								else $p = $pop.find("li").first().addClass("pop");
								$t.val($p.find("b").text());
								return false;
						}
					},
					keyup: function(e) {
						switch (e.which) {
							case 9:
							case 38:
							case 40:
								return false;
								break;
							default:
								var val = $t.val(),
									str = "<li class='pop'><b>" + val + "</b></li>";
								if (val == "" || e.which == 13) $pop.hide();
								else {
									if (delay) clearTimeout(delay);
									delay = setTimeout(function() {
										$.ajax({
											url: url,
											dataType: 'jsonp',
											data: {
												key: val
											}
										}).done(function(data) {
											if (data.length > 0) {
												var i = 0,
													html = str;
												l = data.length;
												for (; i < l; i++) {
													html += '<li data-id="'+data[i].cid+'"><b>' + data[i].name + '</b><span> ' + data[i].address + '</span><strong style="color: #fff;"> ' + data[i].areaid + '</strong><p style="color: #fff;"> ' + data[i].map + '</p></li>';
												}
												$pop.html(html).show();
												resize();
											} else {
												$pop.hide();
											}
										});
									}, 200)
								}
								$pop.html(str);
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