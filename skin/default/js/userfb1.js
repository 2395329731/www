define(function(require, exports, module) {
	require('jquery');
	require("tip");
	require("autocfb");
	var mod, alertM = require("alert");
	return {
		action:"",
		username: 0,
		password: 0,
		page_index: 0,
		shop: 0,
		floor: 0,
		office: 0,
		office_name: "",
		esf: 0,
		esf_name: "",
		room: 0,
		area: 0,
		price: 0,
		mobile_type: 0,
		mobile_code: 0,
		init: function(opt) {
			mod = module.exports;
			var $ba_info = $("#ba_info"),
				$page1 = $("#page1"),
				$page2 = $("#page2"),
				$hf = $("#hide_form"),
				$cf = $("#form_cli"),
				$f = $("#form").on("click", ".buttons a", function() {
					$f.trigger("submit");
					return false;
				}).on("submit", function() {
					if (!mod.page_index) {
						submit_check()
						if (submit_check()) {
							mod.page_index = 1;
							$ba_info.html("没有个联系方式怎么能" + ($sell.is(".on") ? "卖" : "租") + "得出去~");
							$(".tip_suc,.tip_err").remove();
							$page1.animate({
								left: -1000,
								opacity: "hide"
							})
							$page2.animate({
								left: 0,
								opacity: "show"
							})
						}
					} else {
						if (user_check()) {
							alertM("正在提交，请稍候…", {
								cName: "loading",
								time: "y"
							});
							$.ajax({
								url: mod.action,
								type: "post",
								dataType: 'json',
								data: $f.serialize()
							}).done(function(data) {
								alertM(data.alert, {
									cName: data.state
								})
								if (data.state == "succ") {
									setTimeout(function() {
										window.location.href = data.href
									}, 999)
								}
							}).fail(function() {
								alertM("提交失败，请检查网络连接是否已断开", {
									cName: "error"
								});
							});
						}
					}
					return false;
				}),
				$re_back = $("#re_back").on("click", function() {
					mod.page_index = 0;
					$ba_info.html("首先要发布基本信息才能发布");
					$(".tip_suc,.tip_err").remove();
					$page1.animate({
						left: 0,
						opacity: "show"
					})
					$page2.animate({
						left: 1000,
						opacity: "hide"
					})
				})
				$price_name = $("#price_name"),
				$price_num = $("#price_num"),
				$sell = $("#sell").on("click", function() {
					$f.attr("action", $sell.addClass("on").data("action"));
					$price_name.html("价格：");
					$price_num.html("万");
					$rent.removeClass("on");
					$(".tip_suc,.tip_err").remove();
				}),
				$rent = $("#rent").on("click", function() {
					$f.attr("action", $rent.addClass("on").data("action"));
					$price_name.html("租金：");
					$price_num.html("元");
					$sell.removeClass("on");
					$(".tip_suc,.tip_err").remove();
				}),
				$esf = $("#esf").on("click", function() {
					if ($esf.is(".on"))
						return;
					$office.removeClass("on");
					$officeUl.appendTo($hf);
					$shop.removeClass("on");
					$shopUl.appendTo($hf);
					$esf.addClass("on");
					$esfUl.appendTo($cf);
					$(".tip_suc,.tip_err").remove();
				}),
				$esfUl = $("#esf_ul"),
				$office = $("#office").on("click", function() {
					if ($office.is(".on"))
						return;
					$esf.removeClass("on");
					$esfUl.appendTo($hf);
					$shop.removeClass("on");
					$shopUl.appendTo($hf);
					$office.addClass("on");
					$officeUl.appendTo($cf);
					$(".tip_suc,.tip_err").remove();
				}),
				$officeUl = $("#office_ul"),
				$shop = $("#shop").on("click", function() {
					if ($shop.is(".on"))
						return;
					$esf.removeClass("on");
					$esfUl.appendTo($hf);
					$office.removeClass("on");
					$officeUl.appendTo($hf);
					$shop.addClass("on");
					$shopUl.appendTo($cf);
					$(".tip_suc,.tip_err").remove();
				}),
				$shopUl = $("#shop_ul"),
				$price = $("#price").on("blur", function() {
					var val = $.trim($price.val());
					if (/^[1-9]{1}(([0-9]{0,7})|([0-9]{0,4}\.{1}[0-9]{1,2})|([0-9]{0,5}\.{1}[0-9]?))$/.test(val) || val === "0" || !val.length) {
						mod.price = 1;
						$price.parent().find("span").last().tip();
					} else {
						mod.price = 0;
						$price.parent().find("span").last().tip(0, "价格限最大8位数字，小数点后最多两位");
					}
				}),
				$buildarea = $("#buildarea").on("blur", function() {
					var t = $buildarea.val();
					if (/^[1-9]{1}(([0-9]{0,7})|([0-9]{0,4}\.{1}[0-9]{1,2})|([0-9]{0,5}\.{1}[0-9]?))$/.test(t)) {
						mod.area = 1;
						$buildarea.parent().find("span").last().tip();
					} else {
						mod.area = 0;
						$buildarea.parent().find("span").last().tip(0, "面积限最大8位数字，小数点后最多两位");
					}
				}),
				$room = $("#room"),
				$halls = $("#hall"),
				$toilets = $("#toilet"),

				$add_esf = $("#add_esf").on("click", function() {
					alertM(opt.esf_add+"#"+escape($esf_name.val()), {
						title: "在地图上标注小区的位置",
						time: "y",
						iframe: 1,
						width: 900,
						height: 420,
						btnY: 0
					})
					return false;
				}),
				$esf_cid = $("#esf_cid"),
				$address = $("#address"),
				$areaid = $("#areaid"),
				$map = $("#map"),
				$esf_name = $("#esf_name").autoC(opt.esf_autoc).trigger("focus").on("blur", function() {
					var t = $esf_name.val();
					setTimeout(function() {
						if ($esf.is(".on")) {
							if (mod.esf && mod.esf_name == t)
								return;
							if (mod.esf_name != t) {
								mod.esf_name = t;
								var id = 0;
								$("#autoc li").each(function() {
									var $t = $(this);
									
									if ($t.index() > 0 && $t.find("b").html() == t)
										id = $t.data("id"),
									    address=$(this).find("span").text(),
										areaid = $(this).find("strong").text(),
										map = $(this).find("p").text();
								})
								
								if (id) {
									mod.esf = 1;
									$esf_cid.val(id);
									$address.val(address);
									$areaid.val(areaid);
									$map.val(map);
									$esf_name.removeClass("pad_r").tip();
									$add_esf.hide();
									return;
								}
							}
							$esf_cid.val("")
							mod.esf = 0;
							$esf_name.addClass("pad_r").tip(0, "未找到此小区，请重新选择或添加小区");
							$add_esf.show();
						}
					}, 240)
				}),
				$add_office = $("#add_office").on("click", function() {
					alertM(opt.office_add+"#"+escape($office_name.val()), {
						title: "在地图上标注写字楼的位置",
						time: "y",
						iframe: 1,
						width: 800,
						height: 480,
						btnY: 0
					})
					return false;
				}),
				$office_cid = $("#office_cid"),
				$office_name = $("#office_name").autoC(opt.office_autoc).trigger("focus").on("blur", function() {
					var t = $office_name.val();
					setTimeout(function() {
						if ($office.is(".on")) {
							if (mod.office && mod.office_name == t)
								return;
							if (mod.office_name != t) {
								mod.office_name = t;
								var id = 0;
								$("#autoc li").each(function() {
									var $t = $(this);
									if ($t.index() > 0 && $t.find("b").html() == t)
										id = $t.data("id");
								})
								if (id) {
									mod.office = 1;
									$office_cid.val(id)
									$office_name.removeClass("pad_r").tip();
									$add_office.hide();
									return;
								}
							}
							$office_cid.val("")
							mod.office = 0;
							$office_name.addClass("pad_r").tip(0, "未找到此写字楼，请重新选择或添加写字楼");
							$add_office.show();
						}
					}, 240)
				}),
				$x = $("#laticoor"),
				$y = $("#longcoor"),
				$shop_city = $("#shop_city"),
				$shop_area = $("#shop_area"),
				$shop_address = $("#shop_address"),
				$shop_name = $("#shop_name").on("focus", function() {
					alertM(opt.shop_set+"#"+escape($shop_name.val()), {
						title: "在地图上标注商铺物业的位置",
						time: "y",
						iframe: 1,
						width: 800,
						height: 480,
						btnY: 0
					})
					return false;
				}).on("blur", function() {
					if (!$shop_name.val().length) {
						mod.shop = 0;
						$shop_name.tip(0, "请设定商铺物业名称");
					}
				}),
				setFloor = function(type, f1, f2) {
					alertM.remove();
					mod.floor = 1;
					$floor_type.val(type);
					var str = "";
					if (type == 1) {
						str = "单层，第" + f1 + "层";
						$fs1.val(f1);
					}
					if (type == 2) {
						//f2=(f2=f2-f1)>0?f2+f1:(f1=f2+f1)-f2;
						f2 = (f2 = f2 - f1) > 0 ? f2 + (f1 - 0) : (f1 = f2 + (f1 - 0)) - f2;
						str = "多层，第" + f1 + "层至第" + f2 + "层";
						$fs2.val(f1);
						$fs2_2.val(f2);
					}
					if (type == 3) {
						str = "独栋，共" + f1 + "层";
						$fs3.val(f1)
					}
					$floor.val(str).tip();
				},
				$floor = $("#floor").on("focus", function() {
					alertM('<form id="add_form"> <p>请选择相应楼层并输入层数，层数必须为大于0的整数。</p> <p> <input name="aftype" checked="checked" class="radio" id="aftype1" type="radio"> <label for="aftype1">单层</label> <input name="aftype" class="radio" type="radio" id="aftype2"> <label for="aftype2">多层</label> <input name="aftype" class="radio" type="radio" id="aftype3"> <label for="aftype3">独栋</label> </p> <p> <span id="fp1"> 第 <input id="afs1" type="text" class="s">层</span> <span id="fp2"> 第 <input id="afs2" type="text" class="s"> 层 至 第 <input id="afs2_2" type="text" class="s">层</span> <span id="fp3"> 共 <input id="afs3" type="text" class="s">层</span> <a href="javascript:" class="obtn" id="add"> <button type="submit"></button> 确定 </a> </p> </form>', {
						title: "设定商铺楼层",
						time: "y",
						height: 120,
						btnY: 0,
						of: function() {
							var $af = $("#add_form").on("submit", function() {
								if ($af1.prop("checked")) {
									if (/^[1-9]+\d*$/.test($afs1.val()))
										setFloor(1, $afs1.val())
									else
										$afs1.addClass("error").trigger("focus")
								}
								if ($af2.prop("checked")) {
									if (!/^[1-9]+\d*$/.test($afs2.val()))
										$afs2.addClass("error").trigger("focus")
									else if (!/^[1-9]+\d*$/.test($afs2_2.val()))
										$afs2_2.addClass("error").trigger("focus")
									else
										setFloor(2, $afs2.val(), $afs2_2.val())
								}
								if ($af3.prop("checked")) {
									if (/^[1-9]+\d*$/.test($afs3.val()))
										setFloor(3, $afs3.val())
									else
										$afs3.addClass("error").trigger("focus")
								}
								return false;
							}).on("click", "a", function() {
								$af.trigger("submit");
								return false;
							}),
								$af1 = $("#aftype1"),
								$af2 = $("#aftype2"),
								$af3 = $("#aftype3"),
								$afp1 = $("#fp1"),
								$afp2 = $("#fp2"),
								$afp3 = $("#fp3"),
								$afs1 = $("#afs1"),
								$afs2 = $("#afs2"),
								$afs2_2 = $("#afs2_2"),
								$afs3 = $("#afs3")
								$af1.add($af2).add($af3).on("change", function() {
									$afp1.hide();
									$afp2.hide();
									$afp3.hide();
									if ($af1.prop("checked")) {
										$afp1.show();
									}
									if ($af2.prop("checked")) {
										$afp2.show();
									}
									if ($af3.prop("checked")) {
										$afp3.show();
									}
								})
						}
					})
					return false;
				}).on("blur", function() {
					if (!$floor.val().length) {
						mod.floor = 0;
						$floor.tip(0, "请设定商铺楼层");
					}
				}).on("click",function(){
					$(this).trigger("focus");
				}),
				$floor_type = $("#floor_type"),
				$fs1 = $("#fs1"),
				$fs2 = $("#fs2"),
				$fs2_2 = $("#fs2_2"),
				$fs3 = $("#fs3"),
				submit_check = function() {
					var b = 1;
					if ($esf.is(".on")) {
						if (!mod.esf) {
							b = 0;
							$esf_name.trigger("blur");
						}
						if (!mod.room) {
							b = 0;
							$room.trigger("blur")
						}
					}
					if ($office.is(".on")) {
						if (!mod.office) {
							b = 0;
							$office_name.trigger("blur");
						}
					}
					if ($shop.is(".on")) {
						if (!mod.shop) {
							b = 0;
							$shop_name.trigger("blur");
						}
						if (!mod.floor) {
							b = 0;
							$floor.trigger("blur")
						}
					}
					if (!mod.area) {
						b = 0;
						$buildarea.trigger("blur")
					}
					if (!mod.price) {
						b = 0;
						$price.trigger("blur")
					}
					return b;
				},
				$user_name = $("#user_name").on("blur", function() {
					if ($user_name.val().length < 9 && $user_name.val().length > 1) {
						$user_name.tip();
					} else {
						$user_name.tip(0, "联系人长度应在2到8字之间")
					}
				}),
					$mobile = $("#mobile").on("blur", function() {
					if (/^1[3458]\d{9}$|^0\d{2,3}\d{7,8}?$/.test($mobile.val())) {
						$mobile.tip();
					} else {
						$mobile.tip(0, "请输入正确的手机号码")
					}
				}),
				user_check = function() {
					var b = 1;
					if (!$user_name.val().length) {
						b = 0;
						$user_name.trigger("blur");
					}
				
					return b;
				}

			$room.add($halls).add($toilets).on("blur", function() {
				if (/^[1-9]+\d*$/.test($room.val()) && /^[0-9]+\d*$/.test($halls.val()) && /^[0-9]+\d*$/.test($toilets.val())) {
					$room.parent().find("span").last().tip();
					mod.room = 1;
				} else {
					mod.room = 0;
					$room.parent().find("span").last().tip(0, "户型限整数");
				}
			})

			window.setEsf = function(name, id,address,areaid,map) {
				alertM.remove();
				mod.esf = 1;
				mod.esf_name = name;
				$esf_cid.val(id);
				$address.val(address);
				$areaid.val(areaid);
				$map.val(map);
				$esf_name.val(name).removeClass("pad_r").tip();
				$add_esf.hide();
			}
			window.setOffice = function(name, id) {
				alertM.remove();
				mod.office = 1;
				mod.office_name = name;
				$office_cid.val(id);
				$office_name.val(name).removeClass("pad_r2").tip();
				$add_office.hide();
			}
			window.setShop = function(x, y, city, area, address, name) {
				alertM.remove();
				mod.shop = 1;
				$x.val(x);
				$y.val(y);
				$shop_city.val(city);
				$shop_area.val(area);
				$shop_address.val(address);
				$shop_name.val(name).tip();
			}

			$("#btn_wt").on("click",function(){
				if($sell.is(".on"))
					mod.action=opt.sell_wt
				else
					mod.action=opt.rent_wt
			})
			$("#btn_fb").on("click",function(){
				if($sell.is(".on"))
					mod.action=opt.sell_fb
				else
					mod.action=opt.rent_fb
			})
			var type=window.location.href.split("#");
			if(type.length>1){
				type=type[1].split("");
				if(type[0]=="z"){
					$rent.trigger("click")
				}
				if(type[1]==2){
					$office.trigger("click")
				}
				if(type[1]==3){
					$shop.trigger("click")
				}
			}

		}
	}
})