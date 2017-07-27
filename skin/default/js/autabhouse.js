define(function(require, exports, module) {
	require('jquery');
	$.fn.autab = function(menu, list, time, delay, easing, callback, init) {
		return $(this).each(function() {
			var $p = $(this),
				$m = $p.find(menu),
				$l = $p.find(list),
				i = 0,
				d = delay ? delay : 0,
				t,
				e = easing ? easing : 0;
			init = init ? init : false;
			$m.on({
				mouseenter:function() {
					var $t = $(this);
					t = setTimeout(function() {
						i = $m.removeClass("on").index($t.addClass("on"));
						switch(e){
							case 0:
								$l.hide().eq(i).show();
								break;
							case 1:
								$l.hide().eq(i).css({display:"block",opacity:0}).animate({opacity:1});
								break;
							case 2:
								$p.find("ul").stop().animate({left:-1*i*210},300);
								break;
						}
						
						if($.isFunction(callback)){
							callback.call($t);
						}
					}, d * 1000)
				},
				mouseleave:function() {
					clearTimeout(t);
				}
			});
			
			if(!!init){
				$m.eq(0).trigger("mouseenter");
			}
			if(e == 2){
				//如果是第二种效果，重新计算Ul的宽度
				$("ul",this).width($(this).width()*$l.size()+$l.size()*10);
			}
			
			$p.on({
				mouseenter:function(){
					$p.addClass("on")
				},
				mouseleave:function(){
					$p.removeClass("on")
				}
			}).on("click",".gol",function(){
				var $t=$m.filter(".on")
				if($t.index()==0)
					$t=$m.last()
				else
					$t=$t.prev()
				$t.trigger("mouseenter")
			}).on("click",".gor",function(e){
				var $t=$m.filter(".on")
				if($t.index()==$m.length-1)
					$t=$m.first()
				else
					$t=$t.next()
				$t.trigger("mouseenter");
			})
			if (time > 0) {
				var l = $m.length;
				var func = function() {
						i++;
						i = i == l ? 0 : i;
						var $t=$m.removeClass("on").eq(i).addClass("on");
						switch(e){
							case 0:
								$l.hide().eq(i).show();
								break;
							case 1:
								$l.hide().eq(i).css({display:"block",opacity:0}).animate({opacity:1});
								break;
							case 2:
								$p.find("ul").stop().animate({left:-1*i*210},300);
								break;
						}
						if($.isFunction(callback)){
							callback.call($t);
						}
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