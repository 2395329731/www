define(function(require, exports, module) {
	require('jquery');
	require('autoc');
	require('autab');
	var type = "xf";

	
	return function(elm, obj) {
		
		//菜单切换
		var timeout;
		$("#tab_c_menu").autab(".ht",".autab",0,0,0,function(){
			type = $(this).data("type");
			$("#tab_c_menu .keyword").css({color:"#ccc"}).data("url",obj[type].autoUrl).val(obj[type].msg);
		},false).mouseenter(function(e) {
			clearTimeout(timeout);
			$(".header_l_menu").slideDown(300);
		}).mouseleave(function(e) {
			window.hlm_timeout = timeout = setTimeout(function(){
				$(".header_l_menu").hide();
			},500);
		});
		$(elm).each(function(){
			var self = this;
			$(self).on("click",".search_item",function(e){
				$(this).addClass("on");
				$(".search_item_list",self).slideDown(300);
				e.stopImmediatePropagation();
			}).attr("onsubmit","");
			$(".search_item_list li",self).hover(function(){
				$(this).addClass("on");
			},function(){
				$(this).removeClass("on");
			}).click(function(){
				$(".search_item span",self).text($(this).text());
				$(".search_item_list",self).hide();
	
				type = $(this).data("type");
				$(".keyword",self).css({color:"#ccc"}).val(obj[type].msg);
			});
				
				
			$("body").on("click",function(){
				$(".search_item_list").slideUp(100);
				$(".search_item").removeClass("on");
			}),
			$f=$(self).on("submit",function() {
				var keyword = $(".keyword",self).val();
				if(keyword == obj[type].msg){
					$(this).attr("action", obj[type].initUrl);
				}else{
					$(this).attr("action", obj[type].url + keyword + obj[type].hz);
				}
			}).find(".keyword").on("focus",function(){
				if($(this).val() == obj[type].msg){
					$(this).val("");
					$(this).css({color:"#333"});
				}
			}).on("blur",function(){
				if($(this).val() == ""){
					$(this).val(obj[type].msg);
					$(this).css({color:"#ccc"});
				}
			}).data("url",obj[type].autoUrl).autoC();
		});
	}
})