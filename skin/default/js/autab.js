define(function(require, exports, module) {
	require('jquery');
	$.fn.autab = function(menu, list, time, delay, easing, callback) {
		return $(this).each(function() {
			var $p = $(this),
				$m = $p.find(menu),
				$l = $p.find(list),
				i = 0,
				d = delay ? delay : 0,
				t;
			$m.on({
				mouseenter:function() {
					var $t = $(this);
					t = setTimeout(function() {
						i = $m.removeClass("on").index($t.addClass("on"));
						if(easing){
							$l.hide().eq(i).css({display:"block",opacity:0}).animate({opacity:1});
						}else{
							$l.hide().eq(i).show();
						}
						if($.isFunction(callback)){
							callback.call($t);
						}
					}, d * 1000)
				}, 
				mouseleave:function() {
					clearTimeout(t);
				}
			})
			if (time > 0) {
				var l = $m.length;
				var func = function() {
						i++;
						i = i == l ? 0 : i;
						$m.removeClass("on").eq(i).addClass("on");
						$l.hide().eq(i).show();
					},
					iv = setInterval(func, time * 1000),
					tcl=0;
				$p.on({
					mouseenter:function() {
						clearInterval(iv);
					},
					mouseleave:function(e,tClear){
						clearInterval(iv);
						if(typeof(tClear)!="undefined")
							tcl=tClear;
						if(!tcl){
							iv = setInterval(func, time * 1000)
						}					
					}
				})
			}
		})
	}
});