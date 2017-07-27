define(function(require, exports, module) {
	require('jquery');
	$.fn.autolr = function(p,lw,length) {
		return $(this).each(function() {
			var $t=$(this),
				$l=$t.find(".au_l"),
				$r=$t.find(".au_r"),
				$p=$t.find(p),
				l=$p.find("a").length,
				pw=lw*length,
				i=0;
			$p.width(l*lw+9);
			l=Math.ceil(l/length);
			$r.on("click",function(){
				i++;
				if(i==l)
					i=0;
				$p.animate({
					left:0-i*pw
				})
			})
			$l.on("click",function(){
				i--;
				if(i<0)
					i=l-1;
				$p.animate({
					left:0-i*pw
				})
			})
		})
	}
});