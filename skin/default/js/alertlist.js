define(function(require, exports, module) {
	require('jquery');
	var alertM = require('alert');
	var arr = ['<ul id="pricechange">', '<li><b>免费订阅', '的最新楼盘消息和价格变动通知服务</b></li>', '<li>留下您的手机或邮箱, 如果', '有最新楼盘消息或价格变动, 我们会第一时间通知您.</li>', '<li><b>发送', '的房源信息到您的手机</b></li><li>您将会收到如下信息：</li><li class="gray9">', '</li>', '<li>请选择订阅服务:</li><li><input name="flagprice" id="flagprice" type="checkbox" style="width:20px;" value="1"><label for="flagprice">价格变动通知</label><input name="flaginfo" id="flaginfo" type="checkbox" value="2"><label for="flaginfo">楼盘最新消息</label></li>', '<li>请输入您的Email地址:（<a href="javascript:void(0)" id="contact_tel">我要用手机订阅</a>）</li><li><input type="text" name="email" id="email"></li>', '<li>请输入您的手机号码:</li><li><input type="text" name="mobile" id="dymobile"></li>', '<li>请输入您收到的验证码:</li><li><input type="text" name="mobile" id="dyencode" style="width:50px">&nbsp;<a href="javascript:void(0)" class="dycheck">点击免费获取验证码</a></li>', '<li id="minfo"></li></ul>'];
	var mobileArr = ['<ul id="mobilea"></li><li>系统先呼叫您，再接通<b class="red">', '</b>电话</li><li class="red">本次通话免费</li><li>您的电话将显示号码 010-**** 的来电</li><li>若未成功，请稍后重试。</li><li>请输入您的电话号码:</li><li><input type="text" name="mobile" id="mpH"></li><li id="minfo">电话格式如0311********或138********</li></ul>'];
	var messageArr = ['<ul style="padding:24px 24px 0 24px"><li><span>收件人：</span><input type="text" id="uname" value="', '" readonly></li><li><span>内容：</span><textarea id="utext"></textarea></li><li style="padding:0 0 0 72px;font-size:12px">（限2-300字）</li><li id="minfo"></li>'];
	var favoriteArr = ['<ul>','<li><span></span><a href="javascript:void(0)" id="favlike">收藏房源</a></li>','<li><span></span><a target="_blank" href="', '" id="saveToDesk">保存到桌面</a></li> <li><span></span><a href="javascript:void(0)" id="saveToFav">添加到浏览器收藏夹</a></li> <li><span></span><a href="javascript:void(0)" id="saveToCopy">复制当前页面链接</a></li><li id="minfo"></li></ul>']
	var reportArr = ['<form><input type="hidden" name="hid" value="', '" /> <ul style="padding:0 32px"> <li> <input type="radio" value="1" name="slt" id="slt_1" class="radio"> <label for="slt_1">该房源已售或不存在</label> </li> <li> <input type="radio" value="2" name="slt" id="slt_2" class="radio"> <label for="slt_2">该房源售价与实际价格严重不符</label> </li> <li> <input type="radio" value="3" name="slt" id="slt_3" class="radio"> <label for="slt_3">该房源信息描述或照片与实际不符</label> </li> <li> <b>其他：（选填）</b> </li> <li> <input type="text" name="wronginfo" id="wronginfo"></li> <li id="minfo"></li> </ul></form>']
	var lMeAr=['<form id="lmform" action=""><input type="hidden" name="uid" value="','"><ul><li><span></span> 给 <b class="red">','</b> 留言 </li><li><span>姓名：</span><input type="text" name="truename" id="truename" value="','"></li><li><span>联系方式：</span><input type="text" name="contact" id="contact" value="','"></li><li><span>内容：</span><textarea name="info" id="info"></textarea></li><li style="padding:0 0 0 72px;font-size:12px">（限2-300字）</li><li id="minfo"></li></ul></form>']
	var groupBuyArr=['<form id="gb_a_al_form"><input type="hidden" name="id" value="','"><ul><li><span></span><b class="red">','</b></li><li><span><b class="red">*</b> 姓名：</span><input type="text" name="truename" id="gb_a_name">&nbsp;<b class="red">*</b> 手机：<input type="text" id="gb_a_mobile" name="mobile"></li><li id="minfo"></li></ul></form>']
	var zjzArr=['<form id="zjz_form"><input type="hidden" name="hids" value="','"><ul><li><span><b class="red">*</b> 姓名：</span><input type="text" id="zjz_name" name="truename"></li><li><span><b class="red">*</b> 手机：</span><input type="text" id="zjz_mobile" name="mobile"></li><li><span>备注：</span><textarea id="zjz_info" name="info"></textarea></li><li id="minfo"></li></ul></form>'];
	var mobileArr1='<form id="free_m_div"><div></div><ul><li>温馨提示：免费通话不收取任何费用，请放心使用!</li><li>请输入您的电话号码</li><li><input type="text" name="mobile" id="fmd_m"></li><li><input type="text" name="code" id="fmd_c" placeholder="请输入验证码"><a href="javascript:" title="点击切换验证码"><img src="http://l.2013.com/static/img/y.png" alt=""></a></li><li><a href="javascript:" class="obtn"><button type="submit"></button> 免费通话 </a></li></ul></form>';
	return {
		sendToMobile: function(name, info, hid, checkurl, murl) {
			alertM(arr[0] + arr[5] + name + arr[6] + info + arr[7] + arr[10] + arr[11] + arr[12], {
				title: "发送房源信息到手机",
				time: "y",
				width: 400,
				btnN: 1,
				btnYT: '发送',
				yf: function() {
					var $m = $("#dymobile");
					var $e = $("#dyencode");
					var $i = $("#minfo");
					if (!/^1[3458]\d{9}$/.test($m.val())) {
						$i.html("请填写正确的手机号码格式<br>格式如138********");
						$m.focus();
					} else if ($e.val() == "") {
						$i.html("请填写验证码");
						$e.focus();
					} else {
						$.ajax({
							url: murl,
							dataType: 'jsonp',
							data: {
								id: hid,
								mobile: $m.val(),
								encode: $e.val()
							}
						}).done(function(data) {
							if (data.state == "succ") alertM(data.alert, {
								cName: data.state
							})
							else $i.html(data.alert);
						}).fail(function() {
							$i.html("发送失败<br>请检查网络连接是否已断开");
						});
					}
					return false;
				}
			})
			var $m = $("#dymobile");
			var $i = $("#minfo");
			$("#pricechange").on("click", "a.dycheck", function() {
				var $t = $(this);
				if (!/^1[3458]\d{9}$/.test($m.val())) {
					$i.html("请填写正确的手机号码格式");
					$m.focus();
				} else {
					$.ajax({
						url: checkurl,
						dataType: 'jsonp',
						data: {
							mobile: $m.val()
						}
					}).done(function(data) {
						if (data.state == "succ") {
							$t.attr("class", "dywaite").html("等待120秒后再次点击");
							var i = 119;
							var setin = setInterval(function() {
								$t.html("等待" + i + "秒后再次点击")
								if (--i < 0) {
									$t.attr("class", "dycheck").html("点击免费获取验证码");
									clearInterval(setin);
								}
							}, 999)
						}
						$i.html(data.alert);
					}).fail(function() {
						$i.html("验证码发送失败<br>请检查网络连接是否已断开");
					});
				}
			})
			$m.keydown(function(e) {
				if (e.which == 9 || e.which == 8) return;
				if (e.which < 48 || e.which > 105 || (e.which > 57 && e.which < 96)) return false;
			})
		},
		callMobile: function(name, hid, url,src) {
			// alertM(mobileArr[0] + name + mobileArr[1], {
			// 	title: '欢迎致电<b class="red">' + name + "</b>",
			// 	width: 450,
			// 	time: "y",
			// 	btnYT: '拨打',
			// 	btnN: 1,
			// 	yf: function() {
			// 		var $mph = $("#mpH");
			// 		var $i = $("#minfo");
			// 		if (/^1[3458]\d{9}$|^0\d{2,3}\d{7,8}?$/.test($mph.val())) {
			// 			$.ajax({
			// 				url: url,
			// 				dataType: 'text',
			// 				data: {
			// 					hid: hid,
			// 					phone: $mph.val()
			// 				}
			// 			}).done(function(data) {
			// 				$i.html(data);
			// 			}).fail(function() {
			// 				$i.html("电话转接失败<br>请检查网络连接是否已断开");
			// 			});
			// 		} else $i.html("电话格式错误<br>格式如0311********或138********<br>请重新输入")
			// 		return 0
			// 	}
			// });
			if($("#free_m_div").length<1){
				$("#free_mobile").parent().append(mobileArr1);
				var $m = $("#fmd_m").on("focus",function(){
						$fmd.find("div").show()
					}).on("blur",function(){
						$fmd.find("div").hide()
					}),
					$c = $("#fmd_c"),
					$fmd=$("#free_m_div").on("submit",function(){
						if(!$c.val().length){
							alertM("验证码不可为空",{
								cName:"error",
								rf:function(){
									$c.trigger("focus")
								}
							})
							return false;
						}
						if (/^1[3458]\d{9}$|^0\d{2,3}\d{7,8}?$/.test($m.val())) {
							$.ajax({
								url: url,
								dataType: 'json',
								data: {
									hid: hid,
									phone: $m.val(),
									seccode: $c.val()
								}
							}).done(function(data) {
								alertM(data.alert,{cName:data.state});
								if(data.state=="succ"){
									$fmd.hide();
									$m.val("");
									$c.val("");
								}
							}).fail(function() {
								alertM("电话转接失败,请检查网络连接是否已断开",{cName:"error"});
							});
						} else 
							alertM("电话格式错误,请重新输入",{
								cName:"error",
								rf:function(){
									$m.trigger("focus")
								}
							})
						return false;
					}).on("click","a.obtn",function(){
						$fmd.trigger("submit")
					});
				$c.next().on("click",function(){
					var $t=$(this)
						src = $t.find("img").attr("src");
					$t.find("img").remove();
					$t.html('<img src="' + src + '?' + Math.random() + '">');
					return false;
				}).find("img").attr("src",src)
			}
			$("#free_m_div").toggle()
			$("#fmd_m").trigger("focus")
		},
		sendMessage: function(name, url, pid) {
			alertM(messageArr[0] + name + messageArr[1], {
				width: 480,
				title: "写短消息",
				time: "y",
				btnN: 1,
				of:function(){
					if(!name.length)
						$("#uname").prop("readonly",false)
				},
				yf: function() {
					var $n = $("#uname"),
						$t = $("#utext"),
						$i = $("#minfo");
					$("#alertM").on("focus", "input,textarea", function() {
						$i.html("")
					})
					if ($n.val() == "") $i.html("姓名不得为空");
					else if ($t.val() == "") $i.html("消息内容不得为空");
					else {
						$.ajax({
							url: url,
							type: "POST",
							dataType: 'jsonp',
							data: {
								pid:pid,
								name: $n.val(),
								message: $t.val()
							}
						}).done(function(data) {
							if (data.state == "succ") alertM(data.alert, {
								cName: data.state
							});
							else $i.html(data.alert);
						}).fail(function() {
							$i.html("发送消息失败<br>请检查网络连接是否已断开");
						});
					}
					return 0;
				}
			})
		},
		leaveMessage:function(opt){
			alertM(lMeAr[0]+opt.uid+lMeAr[1]+opt.uname+lMeAr[2]+opt.truename+lMeAr[3]+opt.contact+lMeAr[4], {
				width: 420,
				title: "写短消息",
				time: "y",
				btnN: 1,
				yf: function() {
					var $i=$("#minfo");
					$("#lmform").on("focus", "input,textarea", function() {
						$i.html("")
					})
					if ($("#truename").val() == "") $i.html("姓名不得为空");
					else if ($("#contact").val() == "") $i.html("联系方式不得为空");
					else if ($("#info").val() == "") $i.html("留言内容不得为空");
					else {
						$.ajax({
							url: opt.url,
							type: "POST",
							dataType: 'jsonp',
							data: $("#lmform").serialize()
						}).done(function(data) {
							if (data.state == "succ") alertM(data.alert, {
								cName: data.state
							});
							else $i.html(data.alert);
						}).fail(function() {
							$i.html("发送消息失败<br>请检查网络连接是否已断开");
						});
					}
					return 0;
				}
			})
		},
		favorite: function(downurl,hdata) {
			require("copy");
			var html=favoriteArr[0];
			if(hdata)
				html+=favoriteArr[1];
			html+=favoriteArr[2] + downurl + favoriteArr[3];
			alertM(html, {
				title: "收藏房源信息",
				time: "y",
				btnY: 0
			})
			var $i = $("#minfo");
			$("#saveToFav").on("click",function() {
				var sURL = window.location.href;
				var sTitle = document.title;
				try {
					window.external.addFavorite(sURL, sTitle);
				} catch (e) {
					try {
						window.sidebar.addPanel(sTitle, sURL, "");
					} catch (e) {
						$i.html("加入收藏失败<br>请使用Ctrl+D进行添加");
					}
				}
			})
			$("#favlike").on("click",function(){
				$.ajax({
					url:hdata.url,
					dataType:"jsonp",
					data:hdata
				}).done(function(data){
					alertM(data.alert,{cName:data.state})
				}).fail(function(){
					alertM("收藏房源失败，请检查网络连接是否已断开",{cName:"error"});
				})
			})
			setTimeout(function() {
				$("#saveToCopy").zclip({
					copy: window.location.href,
					afterCopy: function() {
						$i.html("复制成功")
					}
				});
			}, 400)
		},
		report: function(hid, url) {
			alertM(reportArr[0] + hid + reportArr[1], {
				title: "举报该房源信息",
				time: "y",
				btnN: 1,
				width: 400,
				yf: function() {
					var $c = $("#alertM :radio"),
						$t = $("#wronginfo"),
						$i = $("#minfo");
					$("#alertM").on("focus", "input", function() {
						$i.html("")
					})
					if (!$c.is(":checked") && $t.val() == "") $i.html("请至少填写一项投诉举报内容！");
					else {
						$.ajax({
							url: url,
							type: "POST",
							dataType: 'jsonp',
							data: $("#alertM form").serialize()
						}).done(function(data) {
							if (data.state == "succ") alertM(data.alert, {
								cName: data.state
							});
							else $i.html(data.alert);
						}).fail(function() {
							$i.html("发送消息失败<br>请检查网络连接是否已断开");
						});
					}
					return 0;
				}
			})
		},
		sendHouse:function(opt){
			alertM('<ul><li>您将会收到如下信息：</li><li class="gray9">' + opt.info + '</li><li>请输入您的手机号码：</li><li><input type="text" name="mobile" id="dymobile"></li><li>请输入您收到的验证码：</li><li><input type="hidden" name="content" id="content" value="'+ opt.info +'"/><input type="text" name="mobile" id="dyencode" style="width:80px">&nbsp;<a href="javascript:" class="red" style="font-size:12px">点击免费获取验证码</a></li><li class="red" style="font-size:12px" id="dyms"></li></ul>',{
				title:'发送' + (opt.name?opt.name + '的':'')+'房源信息到您的手机',
				time: "y",
				btnN: 1,
				btnYT:"发送",
				width:400,
				of:function(){
					var $m = $("#dymobile").keydown(function(e) {
							if (e.which == 9 || e.which == 8) return;
							if (e.which < 48 || e.which > 105 || (e.which > 57 && e.which < 96)) return false;
						}),
						$e = $("#dyencode"),
						$dyms=$("#dyms");
					$(this).on("click", "a.red", function() {
						var $t = $(this);
						if (!/^1[3458]\d{9}$/.test($m.val())) {
							$dyms.html("请填写正确的手机号码格式").show().delay(999).slideUp();
							$m.trigger("focus");
						} else {
							$.ajax({
								url: opt.checkurl,
								dataType: 'jsonp',
								data: {
									mobile: $m.val(),
									id: opt.hid
								}
							}).done(function(data) {
								if (data.state == "succ") {
									$t.removeAttr("class").html("等待120秒后可以再次点击");
									var i = 119;
									var setin = setInterval(function() {
										$t.html("等待" + i + "秒后可以再次点击")
										if (--i < 0) {
											$t.attr("class", "red").html("点击免费获取验证码");
											clearInterval(setin);
										}
									}, 999)
								}
								$dyms.html(data.alert).show().delay(2000).slideUp();
							}).fail(function() {
								$dyms.html("发送失败，请检查网络连接是否已断开").show().delay(999).slideUp();
							});
						}
						return false;
					})
				},
				yf:function(){
					var $m = $("#dymobile"),
					$e = $("#dyencode"),
					$c = $("#content"),
					$dyms=$("#dyms");
					if (!/^1[3458]\d{9}$/.test($m.val())) {
						$dyms.html("请填写正确的手机号码格式").show().delay(999).slideUp();
						$m.focus();
					} else if ($e.val() == "") {
						$dyms.html("请填写验证码").show().delay(999).slideUp();
						$e.focus();
					} else {
						$.ajax({
							url: opt.murl,
							dataType: 'jsonp',
							data: {
								id: opt.hid,
								content: $c.val(),
								mobile: $m.val(),
								encode: $e.val()
							}
						}).done(function(data) {
							if (data.state == "succ")
								alertM(data.alert, {
									cName: "succ"
								})
							else
								$dyms.html(data.alert).show().delay(2000).slideUp();
						}).fail(function() {
							$dyms.html("发送失败，请检查网络连接是否已断开").show().delay(999).slideUp();
						});
					}
					return false;
				}
			})
		},
		joinGroupBuy:function(hid,title,url){
			alertM('<h1><img width="490" src="images/xinfang/kft-newsteps.png" /></h1>'+groupBuyArr[0]+hid+groupBuyArr[1]+title+groupBuyArr[2],{
				title:'填写参团信息',
				time: "y",
				btnYT:"我要参团",
				width:540,
				yf:function(){
					var $name = $("#gb_a_name"),
						$tel = $("#gb_a_mobile"),
						$info = $("#gb_a_info"),
						$i = $("#minfo"),
						$t = $("#gb_a_al_form");
					if (!$name.val().length) {
						$i.html("姓名不得为空")
						$name.trigger("focus")
					} else if (!/^1[3458]\d{9}$|^(0\d{2,4}-)?[2-9]\d{6,7}(-\d{2,5})?$/.test($tel.val())) {
						$i.html("手机号码格式错误");
						$tel.trigger("focus")
					} else {
						$i.html("");
						$.ajax({
							url: url,
							dataType: 'json',
							data: $t.serialize()
						}).done(function(data) {
							if (data.state == "succ") {
								alertM(data.alert, {cName:"succ"});
							}else{
								$i.html(data.alert)
							}
						}).fail(function() {
							$i.html("团购请求失败，请检查网络连接是否已断开")
						});
					}
					return false;
				}
			})
		},
		joinZjz:function(hid,url){
			alertM(zjzArr[0]+hid+zjzArr[1],{
				title:'报名享受独家优惠',
				time: "y",
				btnYT:"我要报名",
				width:420,
				yf:function(){
					var $name = $("#zjz_name"),
						$tel = $("#zjz_mobile"),
						$i = $("#minfo"),
						$t = $("#zjz_form");
					if (!$name.val().length) {
						$i.html("姓名不得为空")
						$name.trigger("focus")
					} else if (!/^1[3458]\d{9}$|^(0\d{2,4}-)?[2-9]\d{6,7}(-\d{2,5})?$/.test($tel.val())) {
						$i.html("手机号码格式错误");
						$tel.trigger("focus")
					} else {
						$i.html("");
						$.ajax({
							url: url,
							dataType: 'jsonp',
							data: $t.serialize()
						}).done(function(data) {
							if (data.state == "succ") {
								alertM(data.alert, {cName:"succ"});
							}else{
								$i.html(data.alert)
							}
						}).fail(function() {
							$i.html("报名请求失败，请检查网络连接是否已断开")
						});
					}
					return false;
				}
			})
		}
	}
})