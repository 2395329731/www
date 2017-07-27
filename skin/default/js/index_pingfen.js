define(function(require, exports, module) {
	require('jquery');
	function js(scoretotal,url){
		var starcontent = '';
		if(scoretotal>0){
			for(var i=1;i<6;i++)
			{
				if(i<=scoretotal) //红星
				{
					starcontent += '<li><img src="'+SKPath+'images/index/red_statr.png" width="16" height="16"></li>';                                
				}
				else if(i > scoretotal && i == Math.ceil(scoretotal) ) //半颗星
				{
					starcontent += '<li><img src="'+SKPath+'images/index/red_hlfe_statr.png" width="16" height="16"></li>';
				}
				else //灰星
				{
					starcontent += '<li><img src="'+SKPath+'images/index/gray_statr.png" width="16" height="16"></li>';
				}
			}
		}else{
			//starcontent += '<li><a href="' + url + '" style="font-size:12px;color:#c20000;">(暂无点评，马上第一个点评吧!)</a>';
		}
		return starcontent;
	}

	return function(ele){
		$(ele).each(function(index, element) {
			var scoretotal = $(element).data("pf");
			var url = $(element).prev("a").attr("href");
			var html = js(scoretotal,url);
			$(this).html(html);
		});
	}

});