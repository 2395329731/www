define(function(require, exports, module) {
	require('jquery');
	var alertM = require('alert');
	require("emailpop");
	return function(elm, callback) {
		var $name = $("#gb_name"),
			$tel = $("#gb_mobile"),
			$info = $("#gb_info"),
			$email=$("gb_email"),
			$code = $("#gb_code"),
			$xy = $("#xy_alert"),
			$t = $(elm).on("submit", function() {
				if (!$name.val().length) {
					showM("姓名不得为空")
					$name.trigger("focus")
				} else if (!/^1[3458]\d{9}$|^(0\d{2,4}-)?[2-9]\d{6,7}(-\d{2,5})?$/.test($tel.val())) {
					showM("手机号码格式错误");
					$tel.trigger("focus")
				}  else {
					var $b = $t.find("b.red");
					$.ajax({
						url: $t.attr("action"),
						dataType: 'json',
						data: $t.serialize()
					}).done(function(data) {
						if (data.state == "succ") {
							$b.html($b.html() - 0 + 1);
							$name.val("");
							$tel.val("");
							$email.val("");
							$info.val("");
							
						}
						if (data.state != "succ" && $xy.length) {
							$xy.html(data.alert);
						}else{
							alertM(data.alert, {
								cName: data.state
							});
							if ($.isFunction(callback))
							callback();
						}
					}).fail(function() {
						showM("团购请求失败，请检查网络连接是否已断开")
					});
				}
				return false;
			}).on("click", "a.obtn", function() {
				$t.trigger("submit")
			}),
			showM = $xy.length ? function(str) {
				$xy.html(str);
			} : function(str) {
				alertM(str, {
					cName: "error"
				});
			};
			if (!$xy.length) {
				$("#gb_email").emailpop();
			}
		$code.next().on("click", function() {
			var $t = $(this)
			src = $t.find("img").attr("src");
			$t.find("img").remove();
			$t.html('<img src="' + src + '?' + Math.random() + '">');
			return false;
		})
	}
});