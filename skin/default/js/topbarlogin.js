define(function(require, exports, module) {
	require('jquery');
	require('cookie');
	var alertM=require("alert"),
		cg=require('config');
	$(function(){
		var $d=$("body"),
			$tb=$("#top_bar"),
			$lis=$tb.find('ul.fr li').on({
				mouseenter:function(){
					$(this).addClass("on")
				},
				mouseleave:function(){
					$(this).removeClass("on")
				}
			}),
			$li=$lis.eq(0),
			formInit=function(){
				var delay=0,
					ustr=[
						'<a href="',
						'" class="top_p" title="欢迎你：',
						'"><img src="',
						'"></a><div class="top_lged">',
						'" class="top_p1">个人中心',
						'" class="top_p5">短消息',
						'" class="top_p2">系统消息',
						'" class="top_p3">我的积分',
						'" class="top_p4">退出',
						'</a>',
						'</div>',
						'<input id="top_co" placeholder="请输入验证码" type="text" name="code"/><span id="top_de"><img src="',
						'"></span><br>'
					],
					$f=$tb.find("form"),
					$un=$("#top_un"),
					$pa=$("#top_pa"),
					foc = function($i) {
						$i.css("borderColor", "#f00").focus();
						setTimeout(function() {
							$i.css("borderColor", "#ddd");
						}, 200)
						setTimeout(function() {
							$i.css("borderColor", "#f00");
						}, 400)
						setTimeout(function() {
							$i.css("borderColor", "#ddd");
						}, 600)
						setTimeout(function() {
							$i.css("borderColor", "#f00");
						}, 800)
						setTimeout(function() {
							$i.removeAttr("style");
						}, 800)
					},
					closeli=function(){
						$lis.removeClass("on");
						$d.off("click",closeli);
					};
				$li.off().on({
					mouseenter:function(){
						var $t=$(this);
						delay=setTimeout(function(){
							$lis.removeClass("on")
							$t.addClass("on");
							$d.off("click",closeli).on("click",closeli)
						},320)
					},
					mouseleave:function(){
						clearTimeout(delay);
					},
					click:function(e){
						e.stopImmediatePropagation();
					}
				});
				$f.on("",function(){
					var $co=$("#top_co");
					if(!$un.val().length||$un.val()==$un.attr("placeholder"))
						foc($un);
					else if(!$pa.val().length)
						foc($pa);
					else if($co.length&&(!$co.val().length||$co.val()==$co.attr("placeholder")))
						foc($co);
					else
						$.ajax({
							url:$f.attr("action"),
							dataType:"jsonp",
							data:$f.serialize()
						}).done(function(data){
							if(data.state=="succ"){
								var html=ustr[0]+data.urls[0]+ustr[1]+data.username+ustr[2]+data.avatar+ustr[3];
								for(var i=0,l=data.urls.length;i<l;i++){
									if(data.urls[i].length)
										html+=ustr[0]+data.urls[i]+ustr[i+4]+ustr[9];
								}
								$li.removeClass("on").html(html+ustr[10]);
								var mel=(data.melength-0)+(data.nolength-0);
								if(data.melength-0)
									$li.find("a.top_p5").append('(<span class="red">'+data.melength+'</span>)')
								if(data.nolength-0)
									$li.find("a.top_p2").append('(<span class="red">'+data.nolength+'</span>)')
								if(mel)
									$li.append('<span class="msgl">'+mel+'</span>');
								if(data.callback)
									$d.append(data.callback);
								exitInit();
							}
							else{
								alertM(data.alert,{cName:data.state});
								if(data.codesrc&&!$("#top_co").length){
									$pa.after(ustr[11]+data.codesrc+ustr[12]);
									$("#top_co").trigger("focus").next().on("click",function(){
										$(this).html('<img src="' + $(this).find("img").attr("src") + '?' + Math.random() + '">')
									});
								}
							}
						}).fail(function(){
							alertM("登录失败，请检查网络连接是否已断开",{cName:"error"})
						})
					return false;
				})
			},
			exitInit=function(){
				$li.off().on({
					mouseenter:function(){
						$(this).addClass("on")
					},
					mouseleave:function(){
						$(this).removeClass("on")
					}
				}).find(".top_p4").on("click",function(){
				
					
				})
			};
		if($("#login_tip").length&&!cg.islogin()&&!$.cookie("login_tip")){
			var $ltp=$("#login_tip").show().on("click","a",function(){
				$ltp.remove();
				$.cookie("login_tip","1",{expires:30,domain:cg.domain,path:cg.path})
			})
		}
		if($tb.find("form").length){
			formInit();
		}else{
			exitInit();
		}
	})
});