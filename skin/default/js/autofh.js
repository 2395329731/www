define(function(require, exports, module) {
	require('jquery');
	require("tip");
	$.fn.autofh = function(menu, list, time) {
		var $ts = $(this);
		return $ts.each(function() {
			var $t = $(this),
				$f = $t.find("form"),
				$fi = $f.find("input:eq(0)"),
				$fs = $f.find("input:eq(1)");
			$t.on("focus", "input", function() {
				$ts.removeClass("on")
				$t.addClass("on");
				$("body").on("click",function() {
					$t.removeClass("on");
					$(this).off("click")
				})
			}).on("keydown", "input", function(e) {
				if (e.which == 13) $f.find("button").click();
				if (e.which == 9 || e.which == 8) return;
				if (e.which < 48 || e.which > 105 || (e.which > 57 && e.which < 96)) return false;
			}).on("click", "button", function() {
				if ($fs.val() != "" && $fs.val() - 0 < $fi.val()) {
					$fs.tip(0, "最大值不可以小于最小值").delay(1999).animate({
						opacity: 0
					}, function() {
						$(this).remove();
					});
					return false;
				}
				if ($fi.val() == "" && $fs.val() == "") {
					$fs.tip(0, "最大值或最小值必须输入一项").delay(1999).animate({
						opacity: 0
					}, function() {
						$(this).remove();
					});
					$fi.focus();
					return false;
				}
				var val = $fi.val() ? $fi.val() : 0;
				if ($fs.val() != "") val += "_" + $fs.val();
				var endStr = $f.data("end") ? $f.data("end") : "";
				endStr += ".html";
				setTimeout(function() {
					window.location.href = $f.attr("action") + val + endStr;
				}, 99)
			}).click(function() {
				return false;
			})
		})
	}
});