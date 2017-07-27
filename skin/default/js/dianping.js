define(function(require, exports, module) {
	require('jquery');
	var cg = require('config'),
		alertM = require('alert');
	return {
		dcInit:function(elm,url){
			$(elm).on("click", "a.d,a.c",function(){
				var $t=$(this),
					$b = $t.find("b");
				$b.html($b.html() - 0 + 1);
				$.ajax({
					url: url,
					dataType: 'json',
					data: {
						cid: $t.closest("li").data("id"),
						dotype: $t.is(".d")?"digg":"down"
					}
				}).done(function(data) {
					if (data.state != "succ") {
						alertM(data.alert, {cName: data.state});
						$b.html($b.html() - 1);
					}
				}).fail(function() {
					
				})
			})
			return module.exports;
		},
		reInit: function(elm) {
			var $f=$(elm);
			if($f.data("needlogin"))
				cg.needlogin($f.find("textarea,a.obtn"),["click","focus"]);
			$f.on("submit", function() {
				if(!$t.val().length||$t.val().length>200)
					alertM("回复长度限1到200字",{cName:"cross",rf:function(){$t.trigger("focus")}})
				else{
					alertM("正在提交回复，请稍候…",{cName:"loading"})
					$.ajax({
						url: $f.attr("action"),
						dataType: 'json',
						data: $f.serialize()
					}).done(function(data) {
						if (data.state == "succ") {
							setTimeout(function() {
								window.location.reload()
							}, 999)
						}
						alertM(data.alert, {cName: data.state});
					}).fail(function() {
						alertM("回复提交失败，请检查网络连接是否已断开", {
							cName: "error"
						});
					});
				}
				return false;
			}).on("click","a.obtn",function(){
				$f.trigger("submit")
			}),
			$t=$f.find("textarea").on("keyup",function(){
				var l = 200 - $t.val().length;
				if (l > 0) $l.html('您还可以输入 <b class="red">' + l + '</b>个字符');
				else if (l == 0) $l.html('您正好输入 <b class="red">200</b>个字符');
				else $l.html('您已超出 <b class="red">' + (0 - l) + '</b>个字符');
			}),
			$l=$f.find("i.fr");
			return module.exports;
		},
		formInit: function(elm) {
			var $f=$(elm);
			if($f.data("needlogin"))
				cg.needlogin($f.find("input,textarea,a.obtn"),["click","focus"]);
			$f.on("submit", function() {
				if(!$i.val().length)
					alertM("标题不得为空",{cName:"cross",rf:function(){$i.trigger("focus")}})
				else if(!$t.val().length||$t.val().length>200)
					alertM("评价长度限1到200字",{cName:"cross",rf:function(){$t.trigger("focus")}})
				else if($c.length&&!$c.val().length)
					alertM("验证码不得为空",{cName:"cross",rf:function(){$c.trigger("focus")}})
				else{
					alertM("正在提交点评，请稍候", {
						cName: "loading"
					});
					$.ajax({
						url: $f.attr("action"),
						dataType: 'json',
						data: $f.serialize()
					}).done(function(data) {
						if (data.state == "succ") {
							setTimeout(function() {
								window.location.reload()
							}, 999)
						}
						alertM(data.alert, {
							cName: data.state
						});
					}).fail(function() {
						alertM("", {
							cName: ""
						});
					});
				}
				return false;
			}).on("click","a.obtn",function(){
				$f.trigger("submit")
			}),
			$i=$f.find("input.t"),
			$t=$f.find("textarea").on("keyup",function(){
				var l = 200 - $t.val().length;
				if (l > 0) $l.html('您还可以输入 <b class="red">' + l + '</b>个字符');
				else if (l == 0) $l.html('您正好输入 <b class="red">200</b>个字符');
				else $l.html('您已超出 <b class="red">' + (0 - l) + '</b>个字符');
			}),
			$l=$f.find("i.fr"),
			$c=$f.find("input.s"),
			$s=$("#scroli a").on("mousemove",function(e){
				var i=e.pageX-$s.offset().left;
				i=Math.ceil(i/26);
				$s.attr("class","s"+i);
			}).on("mouseleave",function(){
				$s.attr("class","s"+$s.data("s"));
			}).on("click",function(e){
				var i=e.pageX-$s.offset().left;
				i=Math.ceil(i/26);
				$s.attr("class","s"+i).data("s",i).next().val(i);
			});
			$c.next().on("click",function(){
				var $t=$(this)
					src = $t.find("img").attr("src");
				$t.find("img").remove();
				$t.html('<img src="' + src + '?' + Math.random() + '">');
				return false;
			})
			return module.exports;
		}
	}
})