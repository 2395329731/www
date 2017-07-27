define(function(require, exports, module) {
	require('jquery');
	require('../css/tip.css');
	$.fn.tip = function(sta, con) {
		var $t = $(this),
			tip = $t.data("tip"),
			$tip;
		if (!tip) {
			tip = "tip" + Math.round(Math.random() * 999999);
			$t.data("tip", tip);
		}
		if (typeof(sta) == "undefined") sta = "tip_suc";
		else sta = !sta ? "tip_err" : "tip";
		if ($("#" + tip).length == 0) $("body").append('<div id="' + tip + '"><span></span><i class="tip_bt"></i><i class="tip_ft"></i></div>');
		$tip = $("#" + tip).attr("class", sta);
		if (con) $tip.find("span").html(con)
		var s = function() {
			var offset = $t.offset();
			$tip.css({
				left: offset.left + $t.outerWidth() + 9,
				top: offset.top
			});
		};
		s();
		$tip.fadeIn();
		$(window).on("resize", s)
		return $tip.on("click", function() {
			$(this).remove();
			$(window).off("resize", s)
		});
	}
});