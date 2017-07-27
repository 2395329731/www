define(function(require, exports, module) {
	require('jquery');
	var cg = require('config'),
		alertM = require('alert');
	return function(elm, loginurl) {
		var $f=$(elm);
		if($f.data("needlogin"))
			cg.needlogin($f.find("textarea,button"),["click","focus"]);
		var $s=$f.find("span"),
			$t=$f.find("textarea").on("keyup",function(){
				var l = $.trim($t.val()).length-0;
				if (l < 50) $s.html('您还可以输入 <b class="red">' + (50 - l) + '</b> 个字');
				else $s.html('您已超出 <b class="red">' + (l - 50) + '</b> 个字');
			})
		$f.on("submit",function(){
			if ($.trim($t.val()).length < 6) {
				alertM("完善下提问吧，会不会太简单了？", {
					cName: "error",
					rf: function() {
						$t.trigger("focus");
					}
				});
				return false;
			}
			if ($.trim($t.val()).length > 50) {
				alertM("提问内容太多啦，再简单点？", {
					cName: "error",
					rf: function() {
						$t.trigger("focus");
					}
				});
				return false;
			}
			$.ajax({
				url:$f.attr("action"),
				dataType:"jsonp",
				data:$f.serialize(),
				type:"POST"
			}).done(function(data){
				alertM(data.alert,{cName:data.state})
				if(data.state=="succ")
					setTimeout(function(){
						window.location.reload();
					},3000)
			}).fail(function(){
				alertM("提问提交失败，请检查网络连接是否已断开",{cName:"error"});
			})
			return false;
		});
	}
});