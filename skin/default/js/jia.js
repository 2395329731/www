define(function(require, exports, module) {
	var $pop, $bind, delay, rsDelay;
	require('jquery');
	require('../css/pop.css');
	var alertM = require("alert");
	
	var appendPop=function(){
		$("body").append('<ul id="autoc2" class="autopop"></ul>');
		$pop = $("#autoc2").on("mouseenter", "li:gt(0)", function() {
			$pop.find(".pop").removeClass("pop");
			$(this).addClass("pop");
		}).on("mousedown", "li:gt(0)", function() {
			$bind.val($(this).find("b").text());
			$pop.hide();
			$("#kanfangtuan .hid").val($(this).data("hid"));
		});
	},
	resize = function() {
		if (rsDelay) clearTimeout(rsDelay);
		rsDelay = setTimeout(function() {
			var offset = $bind.offset();
			$pop.css({
				left: offset.left,
				top: offset.top + $bind.outerHeight() + 2,
				width: $bind.outerWidth()
			});
		}, 99)
	}
	if (-[1, ])
		appendPop();
	else
		$(appendPop)
		



	function autoc(ele,url){
		var l = 0,
			delay = 0,
			$t = ele.attr("autocomplete", "off").on({
				focus: function() {
					resize();
					$bind = $t.trigger("keyup");
					$(window).on("resize", resize);
				},
				keydown: function(e) {
					switch (e.which) {
						case 9:
							$pop.hide();
							break;
						case 13:
							$t.val($pop.hide().find(".pop b").text());
							break;
						case 38:
							var $p = $pop.find(".pop").removeClass("pop");
							if ($p.index() > 0) $p = $p.prev().addClass("pop");
							else $p = $pop.find("li").last().addClass("pop");
							$t.val($p.find("b").text());
							return false;
						case 40:
							var $p = $pop.find(".pop").removeClass("pop");
							if ($p.index() < l) $p = $p.next().addClass("pop");
							else $p = $pop.find("li").first().addClass("pop");
							$t.val($p.find("b").text());
							return false;
					}
				},
				keyup: function(e) {
					switch (e.which) {
						case 9:
						case 38:
						case 40:
							return false;
							break;
						default:
							var val = $t.val(),
								str = "<li class='pop'><b>" + val + "</b></li>";
							if (val == "" || e.which == 13) $pop.hide();
							else {
								// if (delay) clearTimeout(delay);
								// delay = setTimeout(function() {
									$.ajax({
										url: url,
										dataType: 'jsonp',
										data: {
											key: val
										}
									}).done(function(data) {
										if (data.length > 0) {
											var i = 0,
												html = str;
											l = data.length;
											for (; i < l; i++) {
												html += '<li data-hid="' + data[i].hid + '"><b>' + data[i].name + '</b> ' + data[i].address + '</li>';
											}
											$pop.html(html).show();
											resize();
										} else {
											$pop.hide();
										}
									});
								// }, 400)
							}
							$pop.html(str);
					}
				},
				blur: function() {
					if($("#kanfangtuan .hid").val() == 0){
						
					}else{
						$pop.hide();
						$(window).off("resize", resize);
					}
				}
			})
	}
		


		
		
		
	function checkFocus(ele,txt){
		if($(ele).val() == txt){
			$(ele).val("").css({color:"#333"});
		}
	}
	function checkBlur(ele,txt){
		if($(ele).val() == ""){
			$(ele).val(txt).css({color:"#ccc"});
		}
	}
	
	
	return function(elm, autoUrl){
		var name = $("input[name='truename']",$(elm)).focus(function(){
			checkFocus(this,"您的姓名");
		}).blur(function(){
			checkBlur(this,"您的姓名");
		});
		var tel = $("input[name='mobile']",$(elm)).focus(function(){
			checkFocus(this,"您的手机号");
		}).blur(function(){
			checkBlur(this,"您的手机号");
		});
		var lp = $("input[name='lp']",$(elm)).focus(function(){
			checkFocus(this,"输入关键字 选择意向楼盘");
		}).blur(function(){
			checkBlur(this,"输入关键字 选择意向楼盘");
		});
		
		autoc(lp,autoUrl);




		$(elm).on("submit",function(){
			if(name.val() == '' || name.val() == '您的姓名'){
				alertM("姓名不能为空",{cName:"error"});
				return false;
			}else if(!/^[\u4e00-\u9fa5]{1,4}$/.test(name.val())){
				alertM("请输入最多四个中文字",{cName:"error"});
				return false;
			}else if(tel.val() == '' || tel.val() == '您的手机号'){
				alertM("手机号不能为空",{cName:"error"});
				return false;
			}else if(!/^1[3458]\d{9}$/.test(tel.val())){
				alertM("请填写正确的手机号码格式",{cName:"error"});
				return false;
			}else if(lp.val() == '' || lp.val() == '意向楼盘'){
				alertM("请输入您的意向楼盘",{cName:"error"});
				return false;
			}
			
			$.ajax({
				url:$(this).attr("action"),
				type:"GET",
				dataType:"json",
				data:$(this).serialize()
			}).done(function(data) {
				if(data.state == 'succ'){
					alertM(data.alert,{cName:data.state});
				}else{
					alertM(data.alert,{cName:"error"});
				}
			}).fail(function() {
				alertM("提交失败，请检查网络连接是否已断开", {
					cName: 'error'
				});
			});
			
			return false;
		})
	}
});