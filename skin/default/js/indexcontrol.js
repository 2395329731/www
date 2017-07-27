define(function(require, exports, module) {
	require('jquery');
	require('autab');
	require("cookie");
	var userloc=window.location.href.split("/");
	userloc=userloc[userloc.length-2].split(".");
	$.cookie("userloc",userloc[0],{path:"/",expires:999,domain:userloc[1]+"."+userloc[2]});
	$("#tab1").autab("i", "li", 4);
	$("#tab12,#tab13").autab("a.h4tab", "table", 0, 0.2);
	$("#tab21,#tab22,#tab23,#tab24,#tab25").autab("a.h4tab", "ul", 0, 0.2);
	$("#tab31").autab("a.h4tab", "div.ibA", 0, 0.2);
	$("#tab41,#tab42").autab("a.h4tab", "div.autab", 0, 0.2);
	$("#tab51").autab("li", "p", 0, 0.2);
	$("#tab52").autab("li", "div.zdxImg", 4);
	$("#tab12,#tab13,#tab21,#tab22,#tab23,#tab24,#tab25,#tab31,#tab41,#tab42").each(function() {
		var $a = $(this).find("a.more");
		if ($a.length > 0) $(this).find("a.h4tab").mouseover(function() {
			$a.attr("href", $(this).attr("href"))
		})
	})

	var spcid = 500;
	var $p = $('#wyly');
	var h = $p.find('ul').clone().appendTo($p).height();
	function ulA() {
		var t = $p.scrollTop();
		$p.scrollTop(t >= h ? 0 : t + 1)
	}
	var iv = setInterval(ulA, 32);
	$p.hover(function() {
		clearInterval(iv)
	}, function() {
		iv = setInterval(ulA, 32);
	})


	$("#city").hover(function() {
		$(this).find("div").show();
	}, function() {
		$(this).find("div").hide();
	})

	$("#ullr,#ull").each(function() {
		var i = 0,
			$t = $(this),
			$ul = $t.find("ul"),
			l = $ul.find("li").length,
			w = $ul.find("li").width();
		$ul.width(l * w + 9);
		$(this).on("click", "a.l", function() {
			i--;
			if (i == -1) i = l - 1;
			$ul.stop(true, false).animate({
				left: -i * w
			})
		}).on("click", "a.r", function() {
			i++;
			if (i == l) i = 0;
			$ul.stop(true, false).animate({
				left: -i * w
			})
		})
	}).on({
		mouseenter:function() {
			$(this).addClass("on")
		},
		mouseleave:function() {
			$(this).removeClass("on")
		}
	})
	var $ztcon = $("#ztcon"),
		$zti = $("#ztControl i"),
		i = 1,
		d = 0;
	var ztFunc = function() {
		i++;
		i = i >= 4 ? 1 : i;
		$zti.removeClass("on").eq(i).addClass("on");
		$ztcon.stop(true, false).animate({
			top: (1 - i) * 146
		});
	}
	var ztA = setInterval(ztFunc, 4000);
	$zti.on("mouseenter", function() {
		d = $(this).index();
		if (d > 0 && d < 4) {
			i = d;
			$zti.removeClass("on").eq(i).addClass("on");
			$ztcon.stop(true, false).animate({
				top: (1 - i) * 146
			});
		}
	}).on("click", function() {
		if (d == 0) {
			i = i == 1 ? 2 : i - 2;
		}
		ztFunc();
	}).add($ztcon).hover(function() {
		clearInterval(ztA);
	}, function() {
		ztA = setInterval(ztFunc, 4000);
	})
})