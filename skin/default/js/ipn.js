define(function(require, exports, module) {
	require('jquery');
	var alertM = require('alert');
	return function(elm, url, id) {
		var $t = $(elm),
			$txt = $t.find("input");
		$txt.keyup(function(e) {
			if ($txt.val().length > 5) {
				setTimeout(function(){
					var val = $txt.val();
					$txt.val(val.substr(0,5));
				},99)
			}
		});
		$t.on("submit", function() {
			$.ajax({
				url: url,
				dataType: 'json',
				data: {
					hid: id,
					name: $txt.val()
				}
			}).done(function(data) {
				if (data.state == "succ") {
					$txt.val("");
				}
				alertM(data.alert, {
					cName: data.state
				});
			}).fail(function() {
				alertM("印象发布失败，请检查网络连接是否已断开", {
					cName: "error"
				});
			});
			return false;
		}).on("click", "a", function() {
			var t=$.trim($txt.val())
			if(!t.length||t==$txt.attr("placeholder")){
				$txt.trigger("focus");
			}else
				$t.trigger("submit")
		}).on("click", "span", function() {
			var $t = $(this).find("b");
			$.ajax({
				url: url,
				dataType: 'json',
				data: {
					id: $(this).data("id")
				}
			}).done(function(data) {
				if (data.state == "succ") {
					$t.html($t.html() - 0 + 1);
				}
				alertM(data.alert, {
					cName: data.state
				});
			}).fail(function() {
				alertM("印象发布失败，请检查网络连接是否已断开", {
					cName: "error"
				});
			});
		}).on("mouseenter", "span", function() {
			$(this).addClass("on")
		}).on("mouseleave", "span", function() {
			$(this).removeClass("on")
		})
		return $t;
	}
});