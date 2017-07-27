define(function(require, exports, module) {
	require('jquery');
	$(function(){
		$("body").append('<div id="go_to_top" style="position:fixed;bottom:20px;right:30px; width:53px;height:53px; background:#FF8500 url('+SKPath+'/images/mod/to_top.gif) no-repeat 50% 50%;display:none;cursor:pointer;"></div>')
		var $w=$(window),
			$div=$('#go_to_top').on({
				'mouseenter':function() {
					$div.css('opacity',0.7);
				},
				'mouseleave':function() {
					$div.css('opacity',1);	
				},
				'click':function() {
					$('html,body').animate({scrollTop:0});
				}
			}),
			timer=0,tmp,
			tEvent=function() {
				if ($w.scrollTop()>0 ) {
					$div.show();
				}else{
					$div.hide();
				}
			};
		if (!-[1,]&&!window.XMLHttpRequest) {
			tmp=$w.height()-60;
			$div.css({
				'top':tmp,
				'bottom':'',
				'position':'absolute',
				'display':'block'
			});
			tEvent=function(){
				$div.stop().animate({'top':tmp+$w.scrollTop()});
			}
		}
		$w.on('scroll',function() {
			clearTimeout(timer);
			timer=setTimeout(tEvent,200);
		});
	})
});