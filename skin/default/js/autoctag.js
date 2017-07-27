define(function(require, exports, module) {
	require('jquery');
	require('../css/mod/pop.css');
	return function(t, url, tagLength) {
		var init = function() {
			if (!$("#aTagUl").length) {
				$("body").append('<ul id="aTagUl" class="autopop"></ul>');
				$("#aTagUl").on("mouseenter", "li", function() {
					$pop.find(".pop").removeClass("pop");
					$(this).addClass("pop");
				}).on("mousedown", "li", function() {
					var $t = $(this).find("b")
					addTag($t.text(), $t.data("hid"))
				})
			}
			var tName = t.substr(1).split(" ").join("");
			tagLength = tagLength ? tagLength : 99;
			var delay, rsDelay,
				$this = $(t).before('<div id="' + tName + '_tags" class="form_atags" style="display:none"></div>'),
				$tags = $("#" + tName + "_tags").on("click", "a", function() {
					$(this).parent().remove();
					var i = $tags.find("div").length;
					if (i < tagLength)
						$this.show();
					$this.trigger("focus");
				}).css("width",$this.outerWidth());
			$pop = $("#aTagUl"),
			addTag = module.exports.addTag = function(id,val) {
				var $tag = $tags.find("input[value=" + id + "]").parent();
				if ($tag.length) {
					$tag.addClass("on");
					setTimeout(function() {
						$tag.removeClass("on");
					}, 200)
				} else {
					$tags.show().append('<div>' + id + '<a href="javascript:"></a><input type="hidden" name="' + $this.attr("name") + '" value="' + id + '"/></div><input type="hidden" name=hids[] value="' + val + '"/></div>');
					setTimeout(function() {
						$this.trigger("focus");
					}, 99)
					if ($tags.find("div").length == tagLength)
						$this.hide();
				}
				$this.val("")
			}
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
			};
			$this.each(function() {
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
									var $li = $pop.find(".pop b")
									if ($li.length > 0) {
										addTag($li.text(), $li.data("hid"));
										return false;
									}
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
									var val = $t.val();
									if (val == "" || e.which == 13) $pop.hide();
									else {
										// if (delay) clearTimeout(delay);
										// delay = setTimeout(function() {
										$.ajax({
											url: url,
											dataType: 'jsonp',
											data: {
												key: val
											}
										}).done(function(data) {
											if (data.length > 0) {
												var i = 1,
													html = '<li class="pop"><b data-hid="' + data[0].hid + '">' + data[0].name + '</b> ' + data[0].address + '</li>';
												l = data.length;
												for (; i < l; i++) {
													html += '<li><b data-hid="' + data[i].hid + '">' + data[i].name + '</b> ' + data[i].address + '</li>';
												}
												$pop.html(html).show();
												resize();
											} else {
												$pop.hide();
											}
										});
										// }, 400)
									}
									$pop.empty();
							}
						},
						blur: function() {
							$pop.hide();
							$(window).off("resize", resize);
						}
					})
			})
			module.exports.setTags = function(array) {
				$(function(){
					if ($.isArray(array) && array.length > 0) {
						for (var i = 0, l = array.length; i < l; i++) {
							addTag(array[i].val, array[i].id)
						}
					}
				})
			}
		};
		if (-[1, ])
			init();
		else
			$(init)
	}
});