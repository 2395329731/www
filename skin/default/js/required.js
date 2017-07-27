define(function(require, exports, module) {
	require('jquery');
	$.fn.required = function(callback) {
		var $form = $(this).on("focus", "input", function() {
			var $t = $(this).removeClass("error").addClass("focus");
		}).on("blur", "input", function() {
			var $t = $(this).removeClass("focus");
		}).on("click",".cbox",function(){
			$(this).toggleClass("active");
			var check = $(this).data("check") == 1 ? 0 : 1;
			$(this).data("check",check);
		}).on("submit", function() {
			var suc = 1,
				delay = 1;
			$form.find("input[data-required]").each(function() {
				var $t = $(this);
				if ($.trim($t.val()) == "" || $t.val() == $t.attr("placeholder")) {
					if (suc & delay) {
						clearTimeout(delay);
						delay = setTimeout(function() {
							$t.focus();
						}, 500);
					}
					suc = 0;
					$t.addClass("error");
					setTimeout(function() {
						$t.removeClass("error");
					}, 200);
					setTimeout(function() {
						$t.addClass("error");
					}, 400);
				}
			});
			if($form.find(".cbox").data("check") != 1){
				suc = 0;
				$form.find(".checkbox .red").removeClass("none");
			}
			if (suc) {
				if (Object.prototype.toString.apply(callback) === "[object Function]") return callback();
			} else return false;
		});
		return $form;
	}
});