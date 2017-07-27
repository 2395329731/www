		var hammertime = null;
		var maxWidth = 0;
		var marginLeft = 0;
		function addPan(obj) {
			marginLeft = 0;
			// 获取最大的滑动值
			maxWidth = obj.siblings(".hidden-menu").width();
			hammertime = new Hammer(obj[0], {
				domEvents : true
			});
			// 开始拖动
			hammertime.on("panstart", function(e) {
				obj.css({
					"transition" : "margin-left 0s",
					"-webkit-transition" : "margin-left 0s",
				});
				marginLeft = parseInt(obj.css("margin-left"), 10);
				obj.parent().siblings().each(function() {
					$(this).children(".drop-div").css({
						"transition" : "margin-left 0.2s",
						"-webkit-transition" : "margin-left 0.2s",
						"margin-left" : "0px"
					});
				});
			});
			// 拖动过程
			hammertime.on("panmove", function(e) {
				var panRange = marginLeft + e.deltaX;
				if (panRange < 0 && panRange > -maxWidth) {
					obj.css({
						"margin-left" : panRange + "px"
					});
				}
			});
			// 拖动结束
			hammertime.on("panend", function(e) {
				marginLeft = parseInt(obj.css("margin-left"));
				if (e.deltaX < 0) {
					if (marginLeft > -30) {
						obj.css({
							"transition" : "margin-left 0.2s",
							"-webkit-transition" : "margin-left 0.2s",
							"margin-left" : "0px"
						});
					} else {
						obj.css({
							"transition" : "margin-left 0.2s",
							"-webkit-transition" : "margin-left 0.2s",
							"margin-left" : (-maxWidth) + "px"
						});
					}
				} else {
					if (marginLeft < -(maxWidth - 30)) {
						obj.css({
							"transition" : "margin-left 0.2s",
							"-webkit-transition" : "margin-left 0.2s",
							"margin-left" : (-maxWidth) + "px"
						});
					} else {
						obj.css({
							"transition" : "margin-left 0.2s",
							"-webkit-transition" : "margin-left 0.2s",
							"margin-left" : "0px"
						});
					}
				}
			});
		}

		jQuery(document).ready(function() {
			$(".aui-in li").each(function() {
				// 添加手势
				addPan($(this).children(".drop-div"));
			});
			$(".drop-div").on("tap", function() {
				$(".drop-div").css({
					"transition" : "margin-left 0.2s",
					"-webkit-transition" : "margin-left 0.2s",
					"margin-left" : "0px"
				});
			});
		});

function delitemid(mid, itemid) {
        swal({
			title: "确定删除信息吗",
			text: "",
			type: "",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "删除" },
			function(){
$.post("user.php", { action: "delete", mid: mid, itemid: itemid },function(data){
     		if(data.error == 'ok') {
				$('#'+itemid+'').remove();
				laymsg('狠心删除');
		} else {
			laymsg(data.error);
		}
	},'json');

	});
}
