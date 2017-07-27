define(function(require, exports, module) {
	require('jquery');
	require('../css/pk.css');
	var alertM = require('alert');
	return function(opt) {
		opt = $.extend({
			elm:"",
			hlength:3,
			url:"",
			type:"楼盘"
		}, opt || {});
		var $w = $(window);
		$(function(){
			$("body").append('<div id="pk_box"><a href="javascript:" class="sh"></a><div id="pk_con"><h4>您可以选择'+opt.hlength+'个'+opt.type+'进行对比</h4><div id="pk_list"><p>请选择'+opt.type+'加入到对比栏<br>最多可同时对比'+opt.hlength+'个'+opt.type+'</p></div></div></div>');
			var $pk = $("#pk_box"),
				$pklist=$("#pk_list").on("click", "a.clear", function() {
					$(this).parent().slideUp(function(){
						$(this).remove();
						if ($pk.find("li").length == 1)
							$pklist.html('<p>请选择'+opt.type+'加入到对比栏<br>最多可同时对比'+opt.hlength+'个'+opt.type+'</p>')
						$.cookie("db", "", "")
					});
				}).on("click", "a.qk", function() {
					$pklist.html('<p>请选择'+opt.type+'加入到对比栏<br>最多可同时对比'+opt.hlength+'个'+opt.type+'</p>')
					$.cookie("db", "", "")
				}).on("click", "a.db", function() {
					if ($pk.find("li").length > 2) {
						var href = [];
						$pk.find("a[data-val]").each(function() {
							href.push($(this).data("val"))
						});
						setTimeout(function() {
							if(opt.type=="楼盘")
								window.location.href = opt.url + href.join("-") + "";
							else
								  window.location.href = opt.url + href.join("-") + "";
								  
						}, 99)
					}else
						alertM("请至少选择2个" + opt.type, {
							cName: "error"
						})
				});
			$pk.on("click", "a.sh", function() {
				if(!$pk.is(".on"))
					$pk.addClass("on").animate({
						width:212
					})
				else
					$pk.removeClass("on").animate({
						width:30
					});
				if (!-[1, ] && !window.XMLHttpRequest) {
					$pk.css("top",$w.scrollTop() + $w.height() / 2 - 99)
				}
			});
			if($.cookie("db")){
				$pk.addClass("on").animate({
					width:212
				})
				$pklist.html("<ul>"+$.cookie("db")+"</ul>");
			};
			$(opt.elm).on("click", function() {
				var $t = $(this);
				if(!$pk.is(".on")){
					$pk.addClass("on").animate({
						width:212
					})
				}
				if (!-[1, ] && !window.XMLHttpRequest) {
					$pk.css("top",$w.scrollTop() + $w.height() / 2 - 99)
				}
				if(!$pklist.find("ul").length){
					$pklist.html('<ul><li class="last"><a href="javascript:" class="db">比比看</a><a href="javascript:" class="qk">清&nbsp;&nbsp;空</a></li></ul>')
				}
				if ($pklist.find("li").length < opt.hlength+1) {
					var bl = 1;
					$pklist.find("a").each(function() {
						if ($t.data("val") == $(this).data("val")) {
							alertM("请勿选择重复" + opt.type, {
								cName: "cross"
							});
							bl = 0;
							return false;
						}
					})
					if (bl) {
						$pklist.find("li").last().before('<li><a href="javascript:" class="clear"></a><a data-val="' + $t.data("val") + '" href="' + $t.data("url") + '">' + $t.data("name") + '</a></li>');
						$.cookie("db", $pklist.find("ul").html());
					}
				} else alertM("最多只能选择" + opt.hlength + "个" + opt.type, {
					cName: "error"
				})
			})
			if (!-[1, ] && !window.XMLHttpRequest) {
				$pk.css("top", $w.scrollTop() + $w.height() / 2 - 99).show()
				$w.on('scroll', function() {
					$pk.stop().animate({
						top: $w.scrollTop() + $w.height() / 2 - 99
					})
				});
			}else{
				$pk.css("top",$w.height() / 2 - 99).show()
			}
			$w.on("resize",function(){
				$pk.css("top",$w.height() / 2 - 99)
			})
		})
	}
});