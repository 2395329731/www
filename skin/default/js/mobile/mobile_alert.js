window.al=function(opt){
	// targetElement 用来区分将构造的内容添加到哪个元素里去 默认 body 元素
	// closeButton 用来关闭弹出的元素 默认.al_c 元素
	// animationStart 使用哪个动画开始
	// animationEnd 使用哪个动画结束
	// isBlur 是否使用模糊效果
	// s 用来区分使用哪个功能，该值赋给 id='al_t' 和 id="al_p" 用于单独写样式
	opt = $.extend({
		id:'alert',
		targetElement: 'body',
		closeButton: 'al_c',
		animationStart:'alm',
		animationEnd:'alr',
		isBlur:true,
		s: 'switch',
		t: '提示',
		p: '提示',
		of: function() {},
		cf: function() {},
		rf: function() {}
	}, opt || {});


	$(opt.targetElement).append('<div class="'+opt.id+' '+opt.animationStart+' animate"><div class="'+opt.s+'"><div id="al_t"><a href="javascript:" class="'+opt.closeButton+'"></a>'+opt.t+'</div><div id="al_p">'+opt.p+'</div></div></div>');
	var $a=$("."+opt.id);
	if(opt.isBlur===true && opt.targetElement=='body'){
		$a.siblings().addClass("blur")
	}else if(opt.isBlur=='none' && opt.targetElement=='body'){
		$a.siblings().addClass("none")
	}
	$("."+opt.closeButton,$a).on("click",function(){
		if(opt.cf.call($a)===false){
			return false
		}
		al.remove.call($a);
	})

	al.remove=function(){
		var $a = this;
		$a.addClass(opt.animationEnd);
		setTimeout(function() {
			$a.remove();
			opt.rf.call($a);
		}, 350);
		$a.siblings().removeClass("blur");
		$a.siblings().removeClass("none");
	}
	opt.of.call($a);
	
	$(".sousuo").on("click",".category p",function(){
		$(this).next("ul").show();
	});
	
	$(".sousuo").on("click",".category input",function(){
		$(".theact").text($(this).attr("rel"));
		$("#category").val($(this).val());
		$(this).parents("ul").hide();
	});
	
	switch(theact){
		case "esflist" :
			$(".theact").text("二手房");
			$("#category").val("esf");
			$("#form_search ul").find("input[value='esf']").attr("checked","checded");
			break;
		case "zflist" :
			$(".theact").text("租房");
			$("#category").val("zf");
			$("#form_search ul").find("input[value='zf']").attr("checked","checded");
			break;
		case "xqlist" :
			$(".theact").text("小区");
			$("#category").val("xq");
			$("#form_search ul").find("input[value='xq']").attr("checked","checded");
			break;
		case "news" :
			$(".theact").text("资讯");
			$("#category").val("news");
			$("#form_search ul").find("input[value='news']").attr("checked","checded");
			break;
		default:
			$(".theact").text("新房");
			$("#category").val("xf");	
			$("#form_search ul").find("input[value='xf']").attr("checked","checded");
	}
}
