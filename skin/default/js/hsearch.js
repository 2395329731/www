define(function(require, exports, module) {
	require('jquery');
	require('autoc');
	return function(elm, obj) {
		var type = apptype;
		$(function(){
			$(elm).on("click",".search_item",function(e){
				$(this).addClass("on");
				$(".search_item_list",elm).slideDown(300);
				e.stopImmediatePropagation();
			}).attr("onsubmit","");
			$(".search_item_list li",elm).hover(function(){
				$(this).addClass("on");
			},function(){
				$(this).removeClass("on");
			}).click(function(){
				$(".search_item span",elm).text($(this).text());
				$(".search_item",elm).data({"url":$(this).data("url"),"hz":$(this).data("hz")});
				$(".search_item_list",elm).hide();

				type = $(this).data("type");
				$(".search_item",elm).data("type",type);
				$(".keyword",elm).css({color:"#ccc"}).data("url",obj[type].autoUrl).val(obj[type].msg);
			});
			
			
			var $d=$("body").on("click",function(){
					$city_change.removeClass("on");
					$(".search_item_list").slideUp(100);
					$(".search_item").removeClass("on");
				}),
				$city_change=$("#city_change").on("click",function(e){
					e.stopImmediatePropagation()
				}).on("click","#city_c",function(){
					$city_change.toggleClass("on");
				}).on("click","p a",function(e){
					$city_change.removeClass("on");
					//return false
				}),
				$f=$(elm).on("submit",function() {
					var keyword = $(".keyword",elm).val();
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
		})
	}
})