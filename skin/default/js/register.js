define(function(require, exports, module) {
	require('jquery');
	var alertM = require('alert'),
		mod;
	return {
		checkStr: ['<img src="images/common/loading.gif">请稍候，正在检查', '是否已被使用', '<img src="images/mod/', '.png">', 'error.png">连接错误，', '检查', '失败，', '格式错误，请重新输入', '请检查网络连接是否已断开'],
		userName: {
			regular: [/^[\u4e00-\u9fa5|_a-zA-Z0-9]{4,20}$/,/[\u4e00-\u9fa5a-zA-Z_]+/],
			info: '4-20位，可由汉字、数字、字母和“_“组成，禁止纯数字哦~',
			error:'4-20位，可由汉字、数字、字母和“_“组成，禁止纯数字哦~',
			key: '用户名',
			val: '',
			succ: 0
		},
		email: {
			regular: [/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/],
			info: '请输入有效的电子邮箱，可用于登录和找回密码',
			key: '邮箱',
			val: '',
			succ: 0
		},
		mobile: {
			regular: [/^1[3458]\d{9}$|^0\d{2,3}\d{7,8}?$/],
			info: '手机号用于找回密码，接收房源推荐短信',
			key: '手机号码',
			val: '',
			succ: 0
		},
		tel: {
			regular: [/^1[3458]\d{9}$|^(0\d{2,4}-)?[2-9]\d{6,7}(-\d{2,5})?$|^(?!\d+(-\d+){3,})[48]00(-?\d){7,10}$/],
			info: '例如：13812345678，0311-88881234，88881234',
			key: '联系电话',
			val: '',
			succ: 0
		},
		imgCode: {
			regular: [/^[A-Za-z0-9]{4}$/],
			info: '请输入验证码，不区分大小写',
			key: '',
			val: '',
			succ: 0
		},
		mobileCode: {
			regular: [/^[0-9]{6}$/],
			info: '请输入手机验证码',
			key: '手机验证码',
			val: '',
			succ: 0
		},
		company: {
			info: '无此公司信息，建议选择其他公司或独立经纪人',
			key: '所属公司',
			val: '',
			succ: 0
		},
		store: {
			info: '无此门店信息，建议选择其他门店',
			key: '所属门店',
			val: '',
			succ: 0
		},
		city: {
			val: 0,
			succ: 0
		},
		area: {
			val: 0,
			succ: 0
		},
		circle: {
			val: 0,
			succ: 0
		},
		password: {
			info: '密码为6-16个字符，可由字母、数字及符号组成。',
			score: 0,
			confirm: 0,
			succ: 0
		},
		init: function(elm, func) {
			mod = module.exports;
			var placeholder=(function(){
					if(-[1,])
						return function($t){
							if($t.data("val")&&!$t.val().length)
								$t.attr("placeholder",$t.data("val"))
						}
					else
						return function($t){
							if($t.data("val")&&!$t.val().length)
								$t.val($t.data("val"));
						}
				})(),
				$form = $(elm).on("submit", function() {
					var suc = 1;
					$form.find("input[data-required=1]").each(function() {
						var $t = $(this);
						if (!$.trim($t.val()).length || $t.val() == $t.data("val")) {
							$t.trigger("blur");
							if (suc) {
								setTimeout(function() {
									$t.trigger("focus");
								}, 99)
								suc = 0;
							}
						}
					});
					if (suc) {
						if (Object.prototype.toString.apply(func) === "[object Function]") return func($form);
					} else return false;
				}).on("click", "a.submit", function() {
					$form.trigger("submit");
					return false;
				}),
				$input = $form.find("input[type=text],input[type=password]").each(function(){
					var $t=$(this),
						$p=$t.parent();
					$t.data("iname",$p.find("span").eq(0).text().replace(/[\s\u00A0：*]+/g, ""));
					if(!$p.find("s").length)
						$p.append("<s></s>");
					placeholder($t);
					$t.on({
						focus:function(){
							$t.removeClass("error").addClass("focus");
							if ($t.data("val") && $t.val() == $t.data("val")) $t.val("");
						},
						blur:function(){
							$t.removeClass("focus");
							if (!$.trim($t.val()).length || $t.val() == $t.data("val")) {
								if (!-[1,] && $t.data("val"))
									$t.val($t.data("val"));
								if ($t.data("required")) {
									$t.addClass("error")
									$p.next().html($t.data("iname") + "不能为空")[0].className = "ptErr";
									return false;
								}
							} else if ($.trim($t.val()).length) 
								$p.next().empty()[0].className = "pt";
							return true;
						}
					})
				});
			setTimeout(function() {
				$input.not("[readonly]").eq(0).trigger("focus");
			}, 99)
			return mod;
		},
		confirm: function($t, $i, conf, checkStr) {
			var $p = $t.parent()[0];
			$t.on({
				focus: function() {
					$i.html(conf.info)[0].className = "ptInfo";
					$p.className = "";
				},
				blur: function() {
					if (!$t.val().length || $t.val() == conf.val) {
						if (conf.succ) {
							$p.className = "succ";
						}else{
							$t.addClass("error");
						}
					} else {
						var test=1,
							val=$t.val();
						if(conf.regular.length){
							for(var i=0,l=conf.regular.length;i<l;i++){
								if(!conf.regular[i].test(val)){
									test=0;
									break;
								}
							}
						}
						if(!conf.url){
							conf.val = val;
							conf.succ = 1;
							$p.className = ("succ");
							$i.empty();
							return;
						}
						if (test) {
							conf.val = val;
							conf.succ = 0;
							$i.html(checkStr[0] + conf.key + checkStr[1])[0].className = "pt";
							$.ajax({
								url: conf.url,
								dataType: 'json',
								data: {
									val: val
								}
							}).done(function(data) {
								$i[0].className = "pt";
								if (data.state == "succ") {
									conf.succ = 1;
									$p.className = ("succ");
									$i.empty();
								} else {
									$t.addClass("error");
									$i.html(checkStr[2] + data.state + checkStr[3] + data.alert);
								}
							}).fail(function() {
								alertM(checkStr[5] + conf.key + checkStr[6] + checkStr[8], {
									cName: "error",
									rf: function() {
										$i.html(checkStr[2] + checkStr[4] + checkStr[8])[0].className = "pt";
									}
								});
							});
						} else {
							$t.addClass("error");
							$p.className = "";
							$i.html(conf.error||(conf.key + checkStr[7]))[0].className = "ptErr"
						}
					}
				}
			})
			return mod;
		},
		checkPassword: function(opt) {
			opt = $.extend({
				password: "#password",
				pinfo: "#pwInfo",
				pwConfirm: "#passwordConfirm",
				pcinfo: "#pcInfo"
			}, opt || {});
			require('../css/pwstreng.css');
			var re = function(a, b, c) {
				var j = c.replace(a, "");
				j = b - j.length;
				return j > 3 ? 3 : j;
			}
			var gps = function(h) {
				var a = h.length;
				//var b = a > 8 ? 2 : Math.floor(a / 4);
				var b= a>5?4:0;//因经纪人要求安全度下降
				var c = b + re(/[0-9]/g, a, h) + re(/[a-z]/g, a, h) + re(/[A-Z]/g, a, h) + re(/\W/g, a, h) - 2;
				return c < 0 ? 0 : (c > 10 ? 10 : c);
			}
			var $p = $(opt.password),
				$pi = $(opt.pinfo),
				$c = $(opt.pwConfirm),
				$ci = $(opt.pcinfo);
			l = 0;
			$p.on({
				focus: function() {
					if (!$p.val().length) $pi.html('<img src="images/login/pt.png" style="width:18px;height:18px;">' + mod.password.info)[0].className = "pt";
				},
				keyup: function(e) {
					var i = 0,
						html = '<b id="pwStreng" class="cf">',
						val = $p.val();
					l = gps(val);
					for (; i < l; i++) {
						html += '<i class="c' + i + '"></i>';
					}
					html += "</b>";
					if (val.length < 16) if (l < 5) html += "太简单了，混淆下字母数字试试";
					else if (l < 7) html += "简单了点，可以使用";
					else if (l < 9) html += "不错，还可以更棒";
					else html += "太棒了！赞！";
					else {
						html += "太长了！密码最长为16个字符";
						l = 0;
					}
					$pi.html(html);
					mod.password.score = l;
				},
				blur: function() {
					if ($p.val().length) {
						$p.trigger("keyup");
					}
					if (l < 5) {
						$p.addClass("error").parent()[0].className = "";
					} else {
						$p.removeClass("error").parent()[0].className = "succ";
						$pi.empty()[0].className = "pt";
					}
				}
			});
			$c.on({
				focus: function() {
					$ci.html("请再次输入密码")[0].className = "ptInfo";
				},
				blur: function() {
					if ($c.val() == $p.val()) {
						$c.removeClass("error").parent()[0].className = "succ";
						$ci.empty()[0].className = "pt";
						mod.password.confirm = 1;
					} else {
						$c.addClass("error").parent()[0].className = "";
						$ci.html("两次密码输入不一致，请重新输入")[0].className = "ptErr";
						mod.password.confirm = 0;
					}
					mod.password.succ = mod.password.score > 4 && mod.password.confirm == 1 ? 1 : 0;
				}
			});
			return mod;
		},
		checkUserName: function(opt) {
			opt = $.extend({
				userName: "#userName",
				uinfo: "#userNameInfo",
				url: ""
			}, opt || {});
			mod.userName.url = opt.url;
			return mod.confirm($(opt.userName), $(opt.uinfo), mod.userName, mod.checkStr)
		},
		checkEmail: function(opt) {
			opt = $.extend({
				email: "#email",
				einfo: "#emailInfo",
				url: ""
			}, opt || {});
			mod.email.url = opt.url;
			return mod.confirm($(opt.email), $(opt.einfo), mod.email, mod.checkStr)
		},
		checkMobile: function(opt) {
			opt = $.extend({
				mobile: "#mobile",
				minfo: "#mobileInfo",
				url: ""
			}, opt || {});
			mod.mobile.url = opt.url;
			return mod.confirm($(opt.mobile), $(opt.minfo), mod.mobile, mod.checkStr)
		},
		checkTel: function(opt) {
			opt = $.extend({
				tel: "#tel",
				tinfo: "#telInfo",
				url: ""
			}, opt || {});
			mod.tel.url = opt.url;
			return mod.confirm($(opt.tel), $(opt.tinfo), mod.tel, mod.checkStr);
		},
		sendMobileCode: function(opt) {
			opt = $.extend({
				mobile: "#mobile",
				getmCheck: "#getmCheck",
				waitM: "#waitM",
				type:"get",
				url: ""
			}, opt || {});
			var $mobile = $(opt.mobile),
				$getmCheck = $(opt.getmCheck),
				$waitM = $(opt.waitM),
				time = 121;
			var mobileTime = function() {
				if (!--time) {
					$getmCheck.html("重新获取验证码<i></i>").show();
					$waitM.hide();
					time = 121;
					clearInterval(delay);
				} else $waitM.html(time + "秒后重发验证码<i></i>");
			}
			$getmCheck.on("click", function() {
				if (mod.mobile.regular[0].test($mobile.val())) {
					$getmCheck.hide();
					$waitM.css("display", "inline-block").html("正在发送，请稍候…<i></i>");
					// $.ajax({
					// 	url: opt.url,
					// 	type: opt.type,
					// 	dataType: 'json'
					// }).done(function(fdata){
					$.ajax({
						url: opt.url,
						type: opt.type,
						dataType: 'json',
						data: {
							mobile: $mobile.val()
						}
					}).done(function(data) {
						if (data.state == "succ") {
							delay = setInterval(mobileTime, 1000);
						}else{
							$getmCheck.show();
							$waitM.hide();
						}
						alertM(data.alert, {
							cName: data.state,
							time:data.alert.length>6?3000:999
						})
					}).fail(function() {
						alertM("发送失败，请检查网络连接是否已断开", {
							cName: "error"
						});
						$getmCheck.show();
						$waitM.hide();
					});
				} else $mobile.trigger("focus");
			})
			return mod;
		},
		checkMobileCode: function(opt) {
			opt = $.extend({
				mobile: "#mobile",
				mobileCode: "#mobileCode",
				mobileCinfo: "#mobileCodeInfo",
				url: ""
			}, opt || {});
			mod.mobileCode.url = opt.url;
			var $t = $(opt.mobileCode),
				$i = $(opt.mobileCinfo),
				$m = $(opt.mobile),
				$p = $t.parent()[0],
				conf = mod.mobileCode,
				checkStr = mod.checkStr;
			$t.on({
				focus: function() {
					$i.html(conf.info)[0].className = "ptInfo";
					$p.className = "";
				},
				blur: function() {
					if (!$t.val().length || $t.val() == conf.val) {
						if (conf.succ) {
							$p.className = "succ";
						}else{
							$t.addClass("error");
						}
					} else if (conf.regular[0].test($t.val())) {
						conf.val = $t.val();
						conf.succ = 0;
						$i.html(checkStr[0] + conf.key + checkStr[1])[0].className = "pt";
						$.ajax({
							url: conf.url,
							dataType: 'json',
							data: {
								code: $t.val(),
								mobile: $m.val()
							}
						}).done(function(data) {
							$i[0].className = "pt";
							if (data.state == "succ") {
								conf.succ = 1;
								$p.className = ("succ");
								$i.empty();
							} else {
								$t.addClass("error");
								$i.html(checkStr[2] + data.state + checkStr[3] + data.alert);
							}
						}).fail(function() {
							alertM(checkStr[5] + conf.key + checkStr[6] + checkStr[8], {
								cName: "error",
								rf: function() {
									$i.html(checkStr[2] + checkStr[4] + checkStr[8])[0].className = "pt";
								}
							});
						});
					} else {
						$t.addClass("error");
						$p.className = "";
						$i.html(conf.key + checkStr[7])[0].className = "ptErr"
					}
				}
			})
			return mod;
		},
		checkImg: function(opt) {
			opt = opt ? opt : "#cimg";
			var $cimg = $(opt),
				src = $cimg.find("img").attr("src");
			$cimg.on("click", function() {
				$cimg.html('<img src="' + src + '?' + Math.random() + '">');
				return false;
			})
			return mod;
		},
		checkImgCode: function(opt) {
			opt = $.extend({
				imgCode: "#imgCheck",
				imgCinfo: "#imgCheckInfo",
				cimg: "#cimg",
				url: ""
			}, opt || {});
			var $cimg = $(opt.cimg),
				src = $cimg.find("img").attr("src");
			$cimg.on("click", function() {
				$cimg.html('<img src="' + src + '?' + Math.random() + '">');
				return false;
			})
			mod.imgCode.url = opt.url;
			return mod.confirm($(opt.imgCode), $(opt.imgCinfo), mod.imgCode, mod.checkStr);
		},
		checkArea: function(opt) {
			opt = $.extend({
				c: "#gzcyt",
				q: "#gzqxt",
				s: "#gzsyqt",
				co: "#gzcy",
				qo: "#gzqx",
				so: "#gzsyq",
				i: "#gzInfo",
				circleUrl: "",
				areaUrl: "",
				cityName:"",
				cityId:0
			}, opt || {});
			var $c = $(opt.c).attr("autocomplete", "off"),
				$q = $(opt.q).attr("autocomplete", "off"),
				$s = $(opt.s).attr("autocomplete", "off"),
				$i = $(opt.i),
				$co = $(opt.co),
				$qo = $(opt.qo),
				$so = $(opt.so),
				$p = $q.parent()[0],
				l = 0,
				checkStr = mod.checkStr,
				qoHtml = $qo.html(),
				soHtml = $so.html(),
				$t = $q,
				$o = $qo;
			var blur = function() {
				if ($o.find("a:contains('" + $t.val() + "')").length == 1 && $o.find("a:contains('" + $t.val() + "')").text() == $t.val())
					return $o.find("a:contains('" + $t.val() + "')").data("val");
				else {
					$t.addClass("error");
					$p.className = "";
					$i.html("工作区域不存在，请重新输入")[0].className = "ptErr";
					return false;
				}
			}
			$qo.add($so).add($co).on("mouseenter", "a", function() {
				$(this).parent().find(".on").removeClass("on");
				this.className = "on";
			}).on("mousedown", "a", function() {
				$t.val($(this).parent().hide().end().text());
			});
			$q.add($s).add($c).on({
				keydown: function(e) {
					switch (e.which) {
						case 9:
							$o.hide();
							break;
						case 13:
							$t.val($o.hide().find(".on").last().text());
							if ($t.index() == 1) {
								$t.trigger("blur")
								return false;
							}
							break;
						case 32:
							return false;
						case 37:
						case 38:
							var $p = $o.find(".on").removeClass("on");
							if ($p.length > 1) $p = $p.last();
							if ($p.index() > 1) $p = $p.prev().addClass("on");
							else $p = $o.find("a:last").addClass("on");
							$t.val($p.text());
							return false;
						case 39:
						case 40:
							var $p = $o.find(".on").removeClass("on");
							if ($p.length > 1) $p = $p.last();
							if ($p.index() >= l || !$p.length) $p = $o.find("a:first").addClass("on");
							else $p = $p.next().addClass("on");
							$t.val($p.text());
							return false;
					}
				},
				keyup: function(e) {
					switch (e.which) {
						case 9:
						case 32:
						case 37:
						case 39:
						case 38:
						case 40:
							return false;
							break;
						default:
							$o.find(".on").removeClass("on");
							if($o.val().length)
								$o.find("a:contains('" + $t.val() + "')").addClass("on");
					}
				}
			})
			$c.on({
				focus: function() {
					$c.parent().css("z-index", "9");
					$t = $c;
					$o = $co.show();
					l = $o.find("a").length;
				},
				blur: function() {
					$co.hide();
					if(!$.trim($c.val()).length) return false;
					var id = blur();
					if (!id){
						mod.city.succ = 0;
						mod.city.val = 0;
						mod.area.succ = 0;
						mod.area.val = 0;
						$q.hide();
						$s.hide();
						$c.className = "";
					}else if(id == mod.city.val) {
						return false;
					}else{
						mod.city.val = id;
						mod.area.val = 0;
						$q.val("").hide();
						$s.val("").hide();
						$qo.html(qoHtml);
						$co.find("input").val(id);
						$c.className = "";
						mod.clearCompany();
						$.ajax({
							url: opt.areaUrl,
							dataType: 'json',
							data: {
								cid: id
							}
						}).done(function(data) {
							if (data.state == "succ") {
								mod.city.succ = 1;
								$i.empty();
								if(data.area.length>0){
									var i = 0,
										length = data.area.length,
										html = qoHtml;
									for (; i < length; i++) {
										html += '<a href="javascript:void(0)" data-val="' + data.area[i].id + '">' + data.area[i].name + '</a>';
									}
									$qo.html(html);
									$q.show().trigger("focus");
								}else{
									$c.className = "succ";
									$q.val($c.val());
									$s.val($c.val());
								}
							} else {
								mod.city.succ = 0;
								$i.html(checkStr[2] + data.state + checkStr[3] + data.alert)[0].className = "pt";
							}
						}).fail(function() {
							mod.city.succ = 0;
							alertM("获取区域信息" + checkStr[6] + checkStr[8], {
								cName: "error",
								rf: function() {
									$i.html(checkStr[2] + checkStr[4] + "获取区域信息" + checkStr[6] + checkStr[8])[0].className = "pt";
								}
							});
						});
					}
				}
			})
			$q.on({
				focus: function() {
					$q.parent().css("z-index", "9");
					$t = $q;
					$o = $qo.show();
					l = $o.find("a").length;
				},
				blur: function() {
					$qo.hide();
					if(!$.trim($q.val()).length) return false;
					var id = blur();
					if(!id){
						mod.area.succ = 0;
						$s.hide();
						$p.className = "";
					}else if(id == mod.area.val) {
						return false;
					}else{
						mod.area.val = id;
						$s.val("").hide();
						$so.html(soHtml);
						$qo.find("input").val(id);
						$p.className = "";
						$.ajax({
							url: opt.circleUrl,
							dataType: 'json',
							data: {
								aid: id
							}
						}).done(function(data) {
							if (data.state == "succ") {
								mod.area.succ = 1;
								$i.empty();
								if(data.circle.length>0){
									var i = 0,
										length = data.circle.length,
										html = soHtml;
									for (; i < length; i++) {
										html += '<a href="javascript:void(0)" data-val="' + data.circle[i].id + '">' + data.circle[i].name + '</a>';
									}
									$so.html(html);
									$s.show().trigger("focus");
								}else{
									$p.className = "succ";
									$s.val($q.val());
								}
							} else {
								mod.area.succ = 0;
								$i.html(checkStr[2] + data.state + checkStr[3] + data.alert)[0].className = "pt";
							}
						}).fail(function() {
							mod.area.succ = 0;
							alertM("获取商业圈信息" + checkStr[6] + checkStr[8], {
								cName: "error",
								rf: function() {
									$i.html(checkStr[2] + checkStr[4] + "获取商业圈信息" + checkStr[6] + checkStr[8])[0].className = "pt";
								}
							});
						});
					}
				}
			})
			$s.on({
				focus: function() {
					if (!mod.area.succ) {
						$q.trigger("focus");
						return false;
					}
					$q.parent().css("z-index", "9");
					$t = $s;
					$o = $so;
					l = $o.find("a").length;
					if (l) $o.show()
				},
				blur: function() {
					$so.hide();
					$p.className = "";
					var id = blur();
					if (id) {
						if (id != mod.circle.val) {
							mod.circle.val = id;
							$so.find("input").val(id);
						}
						mod.circle.succ = 1;
						$i.empty();
						if (mod.area.succ) $p.className = "succ";
					} else mod.circle.succ = 0;
				}
			});
			if(opt.cityName&&opt.cityId){
				$c.val(opt.cityName);
				$co.find("input").val(opt.cityId);
				mod.city.val = opt.cityId;
				$.ajax({
					url: opt.areaUrl,
					dataType: 'json',
					data: {
						cid: opt.cityId
					}
				}).done(function(data) {
					if (data.state == "succ") {
						mod.city.succ = 1;
						$i.empty();
						if(data.area.length>0){
							var i = 0,
								length = data.area.length,
								html = qoHtml;
							for (; i < length; i++) {
								html += '<a href="javascript:void(0)" data-val="' + data.area[i].id + '">' + data.area[i].name + '</a>';
							}
							$qo.html(html);
							$q.show();
						}else{
							$c.className = "succ";
							$q.val($c.val());
							$s.val($c.val());
						}
					} else {
						mod.city.succ = 0;
						$i.html(checkStr[2] + data.state + checkStr[3] + data.alert)[0].className = "pt";
					}
				}).fail(function() {
					mod.city.succ = 0;
					alertM("获取区域信息" + checkStr[6] + checkStr[8], {
						cName: "error",
						rf: function() {
							$i.html(checkStr[2] + checkStr[4] + "获取区域信息" + checkStr[6] + checkStr[8])[0].className = "pt";
						}
					});
				});
			}
			if(opt.areaName&&opt.areaId){
				$q.val(opt.areaName);
				$qo.find("input").val(opt.areaId);
				mod.area.val = opt.areaId;
				$.ajax({
					url: opt.circleUrl,
					dataType: 'json',
					data: {
						aid: opt.areaId
					}
				}).done(function(data) {
					if (data.state == "succ") {
						mod.area.succ = 1;
						$i.empty();
						if(data.circle.length>0){
							var i = 0,
								length = data.circle.length,
								html = soHtml;
							for (; i < length; i++) {
								html += '<a href="javascript:void(0)" data-val="' + data.circle[i].id + '">' + data.circle[i].name + '</a>';
							}
							$so.html(html);
							$s.show();
						}else{
							$p.className = "succ";
							$s.val($q.val());
						}
					} else {
						mod.area.succ = 0;
						$i.html(checkStr[2] + data.state + checkStr[3] + data.alert)[0].className = "pt";
					}
				}).fail(function() {
					mod.area.succ = 0;
					alertM("获取商业圈信息" + checkStr[6] + checkStr[8], {
						cName: "error",
						rf: function() {
							$i.html(checkStr[2] + checkStr[4] + "获取商业圈信息" + checkStr[6] + checkStr[8])[0].className = "pt";
						}
					});
				});
			}
			return mod;
		},
		checkCompany: function(opt) {
			opt = $.extend({
				company: "#company",
				cid:"#companyid",
				store: "#store",
				sid:"#storeid",
				cinfo: "#companyInfo",
				cpop: "#cpop",
				curl: "",
				surl: "",
				scurl: ""
			}, opt || {});
			var $c = $(opt.company).attr("autocomplete", "off"),
				$s = $(opt.store).attr("autocomplete", "off"),
				$cid=$(opt.cid),
				$sid=$(opt.sid),
				$i = $(opt.cinfo),
				$pop = $(opt.cpop),
				$p = $c.parent()[0],
				l = 0,
				inlength = 0,
				inhtml = "",
				url = "",
				checkStr = mod.checkStr,
				$t, delay;
			$pop.on("mouseenter", "li", function() {
				$pop.find("li.pop").removeClass("pop");
				$(this).addClass("pop");
			}).on("mousedown", "li", function() {
				$t.val($(this).find("b").text());
				$pop.hide();
			});
			$c.add($s).on({
				keydown: function(e) {
					switch (e.which) {
						case 9:
							$pop.hide();
							break;
						case 32:
							return false;
						case 13:
							if (!$t.prop("readonly")) $t.val($pop.hide().find(".pop b").text());
							break;
						case 37:
						case 38:
							var $p = $pop.find(".pop").removeClass("pop");
							if ($p.index() > 0) $p = $p.prev().addClass("pop");
							else $p = $pop.find("li").eq(l).addClass("pop");
							$t.val($p.text());
							return false;
						case 39:
						case 40:
							var $p = $pop.find(".pop").removeClass("pop");
							if ($p.index() >= l || !$p.length) $p = $pop.find("li").first().addClass("pop");
							else $p = $p.next().addClass("pop");
							$t.val($p.text());
							return false;
					}
				},
				keyup: function(e) {
					switch (e.which) {
						case 9:
						case 37:
						case 38:
						case 39:
						case 40:
							return false;
							break;
						default:
							var val = $t.val(),
								str = "<li class='pop'><b>" + val + "</b></li>";
							if (!val.length){
								$pop.html(inhtml).show();
							}else {
								if (delay) clearTimeout(delay);
								delay = setTimeout(function() {
									if (val != mod.company.val)
										$p.className = "";
									$.ajax({
										url: url,
										dataType: 'json',
										data: {
											key: val,
											cid:mod.city.val
										}
									}).done(function(data) {
										var html=str;
										if (data.length > 0) {
											var i = 0;
											l = data.length;
											for (; i < l; i++) {
												html += "<li><b>" + data[i].name + "</b></li>";
											}
											l += inlength + 1;
										}
										html += inhtml;
										if($t.is(":focus"))
											$pop.html(html).show();
									});
								}, 200)
							}
							$pop.html(str + inhtml);
					}
				}
			})
			$c.on({
				focus: function() {
					$c.parent().css("z-index", "9");
					$t = $c;
					inhtml = '<li class="b"><b>其他公司</b></li><li class="b"><b>独立经纪人</b></li>';
					l = inlength = 1;
					url = opt.curl;
					$pop.removeClass("l").html(inhtml).hide();
					if($.trim($c.val()).length&&$c.val()!=$c.data("val"))
						$c.trigger("keyup");
				},
				blur: function() {
					var val = $.trim($c.val());
					$pop.hide().empty().parent().css("z-index", "0");
					if (val == mod.company.val) return false;
					mod.company.succ = 0;
					mod.store.succ = 0;
					mod.company.val = val;
					$p.className = "";
					$s.val("").hide();
					$cid.val("");
					if (!val.length || val == $c.data("val")) {
						$p.className = "";
						return false;
					}
					if (val == "其他公司" || val == "独立经纪人") {
						mod.company.succ = 1;
						mod.store.succ = 1;
						$cid.val(val=="其他公司"?"0":"-1");
						$s.val(val)
						$p.className = "succ";
					}else{
						$.ajax({
							url: opt.cCheckurl,
							dataType: 'json',
							data: {
								company: val,
								cid:mod.city.val
							}
						}).done(function(data) {
							if (data.state=="succ") {
								mod.company.succ = 1;
								$cid.val(data.cid);
								$s.show().trigger("focus");
								$i.empty();
							} else {
								$c.addClass("error");
								$i.html(checkStr[2] + 'error' + checkStr[3] + mod.company.info)[0].className = "pt";
							}
						}).fail(function() {
							alertM(checkStr[5] + mod.company.key + checkStr[6] + checkStr[8], {
								cName: "error",
								rf: function() {
									$i.html(checkStr[2] + checkStr[4] + checkStr[8])[0].className = "pt";
								}
							});
						});
					}
				}
			})
			$s.on({
				focus: function() {
					var cid = $cid.val();
					$s.parent().css("z-index", "9");
					$t = $s;
					inhtml = '<li class="b"><b>其他店面</b></li>';
					inlength = 0;
					url = opt.surl + "&companyid=" + cid;
					$pop.addClass("l").html(inhtml).show();
					if($.trim($s.val()).length&&$s.val()!=$s.data("val"))
						$s.trigger("keyup");
				},
				blur: function() {
					var val = $.trim($s.val());
					$pop.hide().empty().parent().css("z-index", "0");
					if (!val.length) {
						$p.className = "";
						return false;
					}
					if (val == mod.store.val) return false;
					mod.store.succ = 0;
					mod.store.val = val;
					$p.className = "";
					$sid.val("");
					if (val == "其他店面") {
						mod.store.succ = 1;
						$cid.val("0");
						if (mod.company.succ) $p.className = "succ";
					} else {
						$.ajax({
							url: opt.sCheckurl,
							dataType: 'json',
							data: {
								cid:$cid.val(),
								store: val
							}
						}).done(function(data) {
							if (data.state == "succ") {
								mod.store.succ = 1;
								$sid.val(data.sid);
								if (mod.company.succ) $p.className = "succ";
								$i.empty();
							} else{
								$s.addClass("error");
								$i.html(checkStr[2] + data.state + checkStr[3] + data.alert)[0].className = "pt";
							}
						}).fail(function() {
							mod.store.succ = 0;
							$p.className = "";
							alertM(checkStr[5] + mod.store.key + checkStr[6] + checkStr[8], {
								cName: "error",
								rf: function() {
									$i.html(checkStr[2] + checkStr[4] + checkStr[8])[0].className = "pt";
								}
							});
						});
					}
				}
			});
			mod.clearCompany=function(){
				$c.val("").trigger("blur");
				$cid.val("");
				$s.val("");
				$sid.val("");
			};
			return mod;
		},
		clearCompany:function(){
			return false;
			//未初始化checkCompany方法时防止报错
		}
	}
});