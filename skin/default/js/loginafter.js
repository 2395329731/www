define(function(require, exports, module) {
	require('jquery');
	require('cookie');
	var alertM = require('alert'),
		hash = function(str) {
			var hash = 0;
			for (var i = str.length - 1; i >= 0; i--) {
				hash = hash * 31 + str.charCodeAt(i);
			}
			return (hash % 999983);
		},
		etName = "e" + hash(window.location.href);
	$(function() {
		setTimeout(function() {
			eval($.cookie(etName));
			$.cookie(etName, "");
		}, 9)
	})
	return function(t, type, fun, login, url) {
		if (login) $(t).on(type, fun)
		else{
			var d=window.location.host.split(".");
			d=d[d.length-2]+"."+d[d.length-1];
			document.domain = d;
			$(t).on(type, function() {
				alertM(url, {
					iframe: 1,
					time: "y",
					btnY: 0,
					width: 600,
					title: "登录",
					height: 200,
					cf: function() {
						$.cookie(etName, '');
					}
				});
				$.cookie(etName, '$("' + t + '").eq(' + $(this).index(t) + ').trigger("' + type + '")');
				return false;
			})
		}
	}
});