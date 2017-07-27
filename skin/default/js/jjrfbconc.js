define(function(require, exports, module) {
	require('jquery');
	require("tip");
	require('autab');
	return {
		communityname: 0,
		floor: 0,
		totalfloor: 0,
		area: 0,
		room: 0,
		hall: 0,
		toilet: 0,
		price: 0,
		title: 0,
		content: 0,
		tags: 0,
		paytype:0,
		zfrent:1,
		xzlfloor:0,
		sparea:0,
		spbusinessstatus:0,
		spfloortype:1,
		spfloors:0,
		sprenttype:0,
		init: function(formtype, opt) {
(function() {
	var URL = "";
	window.UEDITOR_CONFIG = {
		textarea: "info",
		UEDITOR_HOME_URL: URL,
		toolbars: [
			['fontfamily', 'fontsize', 'forecolor', 'bold', 'backcolor','justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', 'removeformat']
		],
		labelMap: {},
		contextMenu: {},
		fontsize:[12, 14, 16, 18, 20, 24],
		fontfamily:[
			{ label:'',name:'songti',val:'宋体,SimSun'},
			{ label:'',name:'yahei',val:'微软雅黑,Microsoft YaHei'},
			{ label:'',name:'kaiti',val:'楷体,楷体_GB2312, SimKai'},
			{ label:'',name:'heiti',val:'黑体, SimHei'}
		],
		minFrameHeight: 240,
		autoHeightEnabled: false,
		pasteplain: !0,
		wordCount: !0,
		maximumWords: 3e3,
		initialContent: '',
		initialFrameWidth: "auto",
		initialFrameHeight: 160,
		autoClearEmptyNode: !0,
		zIndex: 60,
		initialStyle: 'body{font-size:14px;color:#333;font-family:SimSun,sans-serif;margin:0;padding:2px 9px;line-height:1.625;box-shadow: 0 1px 3px #DDD inset;}',
		wordCount: 0,
		elementPathEnabled: 0
	};
})();

			var mod = module.exports,
				alertM = require("alert"),
				$b = $("body"),
				$houseage = $("#houseage").on("blur", function() {
					var t = $houseage.val();
					if (/^[1-9]\d{3}$/.test(t)) {
						$houseage.parent().find("span").last().tip();
						mod.houseage = 1;
					} else {
						mod.houseage = 0;
						$houseage.parent().find("span").last().tip(0, "建造年代限4位整数")
					}
				}).on("focus", function() {
					if ($houseage.val() == "请输入建造年代") $houseage.val("")
				}),
				$price = $("#price").on("blur", function() {
					var val=$.trim($price.val());
					if (/^[1-9]{1}(([0-9]{0,7})|([0-9]{0,4}\.{1}[0-9]{1,2})|([0-9]{0,5}\.{1}[0-9]?))$/.test(val)||val==="0"||!val.length) {
						mod.price = 1;
						$price.parent().find("span").last().tip();
					} else {
						mod.price = 0;
						$price.parent().find("span").last().tip(0, "价格限最大8位数字，小数点后最多两位");
					}
				}),
				$buildarea = $("#buildarea").on("focus", function() {
					if ($buildarea.val() == "请输入建筑面积") $buildarea.val("")
				}).on("blur",function(){
					var t = $buildarea.val();
					if (!t.length) $buildarea.val("请输入建筑面积");
					if (/^[1-9]{1}(([0-9]{0,7})|([0-9]{0,4}\.{1}[0-9]{1,2})|([0-9]{0,5}\.{1}[0-9]?))$/.test(t)) {
						mod.area = 1;
						$buildarea.parent().find("span").last().tip();
					} else {
						mod.area = 0;
						$buildarea.parent().find("span").last().tip(0, "面积限最大8位数字，小数点后最多两位");
					}
				}),
				$txtCommunityAddress=$("#txtCommunityAddress").on("focus", function() {
					if ($txtCommunityAddress.val() == "请输入详细地址") $txtCommunityAddress.val("")
				}).on("blur", function() {
					if (!$.trim($txtCommunityAddress.val()).length) $txtCommunityAddress.val("请输入详细地址")
				}),
				$housetitle = $("#housetitle").on("blur", function() {
					var t = $(this).val();
					if (t.length < 4 || t.length > 50) {
						mod.title = 0;
						$(this).tip(0, "房源标题限4-50个字内");
					} else {
						$(this).tip();
						mod.title = 1;
					}
				}),
				$editor = $("#editip"),
				$editorTab = $("#editorTab").on("mouseenter", "div.biaoqin a", function() {
					$(this).parent().find("div.biaoqinTab").hide().eq($(this).index()).show();
				}).on("mouseleave", function() {
					$editorPanl.hide();
				}).autab("span.edi", "div.biaoqin"),
				$editorPanl = $editorTab.find("div.biaoqinTab").on("click", "a", function() {
					$ue.execCommand("insertHTML", $(this).parent().find("textarea").val())
				}),
				$circleid = $("#circleid"),
				$areaid = $("#areaid").on("change", function() {
					if($areaid.val())
						$.ajax({
							url: opt.getcircle,
							dataType: "json",
							data: {
								areaid: $areaid.val()
							}
						}).done(function(data) {
							var str="";
							for(var i=0,l=data.length;i<l;i++){
								str+='<option value="'+data[i].val+'">'+data[i].name+'</option>'
							}
							$circleid.html(str);
						}).fail(function() {
							alertM("获取商圈失败,请检查网络连接是否断开", {
								cName: "error"
							})
						})
				});

			if (formtype == "esf" || formtype == "zf" || formtype=="xzl") {
				var delay, rsDelay,
					$pop = $("#autoVn").on("mouseenter", "li", function() {
						$pop.find(".pop").removeClass("pop");
						$(this).addClass("pop");
					}).on("mousedown", "li", function() {
						address=$(this).find("span").text();
						vname=$(this).find("b").text();
						$villagename.val(vname).tip();
						$cid.val($(this).data("val"));
						$address.val(address);
						mod.communityname = 1;
						$pop.hide();
						$pophide.css("display","none");
					}).on("mousedown","a.red",function(e){
						setTimeout(function(){
							$addxq.show();
						},99)
						$pop.hide();
						$pophide.css("display","none");
					}).on("click", function(e) {
						e.stopImmediatePropagation()
					}),
					pophtml=$pop.html(),
					resize = function() {
						if (rsDelay) clearTimeout(rsDelay);
						rsDelay = setTimeout(function() {
							var offset = $villagename.offset();
							$pop.css({
								left: offset.left,
								top: offset.top + $villagename.outerHeight() + 2
							});
							$pophide.css({
								left: offset.left,
								top: offset.top + $villagename.outerHeight() + 2
							});
						}, 99)
					},
					l = 0,
					delay = 0,
					$cid = $("#cid"),
					$address = $("#address"),
					$villagenamecon = $("#villagenamecon").on("click", function(e) {
						e.stopImmediatePropagation()
					}),
					$addxq = $("#addxq").on("click", function(e) {
						e.stopImmediatePropagation();
						$pop.hide();
						$pophide.css("display","none");
					}),
					villagename=$.trim($villagenamecon.find("span.inl").text()).replace(/[\s\u00A0：*]+/g, ""),
					vsname=villagename.substr(0,villagename.length-2),
					vname='',
					$villagename = $("#villagename").attr("autocomplete", "off").on({
						focus: function() {
							resize();
							$villagename.trigger("keyup");
							$(window).on("resize", resize);
							$pophide.css("display","block");
						},
						keydown: function(e) {
							switch (e.which) {
								case 9:
									$pop.hide();
									break;
								case 13:
									$villagename.val($pop.hide().find(".pop b").text());
									break;
								case 38:
									var $p = $pop.find(".pop").removeClass("pop");
									if ($p.index() > 0) $p = $p.prev().addClass("pop");
									else $p = $pop.find("li").last().addClass("pop");
									$villagename.val($p.find("b").text()).tip();
									$cid.val($p.data("val"));
									mod.communityname = 1;
									return false;
								case 40:
									var $p = $pop.find(".pop").removeClass("pop");
									if(!$p.length || $p.index() == (l-1)) $p = $pop.find("li").first().addClass("pop");
									else $p = $p.next().addClass("pop");
									vname=$p.find("b").text();
									$villagename.val(vname).tip();
									$cid.val($p.data("val"));
						           // $address.val(address);
									mod.communityname = 1;
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
									var val = $villagename.val(),
										str = "<ul>";
									if(e.which == 13){
										$pop.hide();
										return;
									}
									if (val == ""){
										$pop.html(pophtml);
										l=$pop.find("li").length;
										if(l>0){
											$pop.show();
											$pophide.height($pop.height());
										}
										else
											$pop.hide();
										resize();
										return;
									}
									if(val!=vname){
										vname=val;
										mod.villagename=0;
										$cid.val("");
										
										$villagename.tip().remove();
									}
									if (delay) clearTimeout(delay);
									delay = setTimeout(function() {
										$.ajax({
											url: opt.autoc,
											dataType: 'jsonp',
											data: {
												query: val
											}
										}).done(function(data) {
											var i = 0,
												html = str;
											if (data.length > 0) {
												l = data.length;
												for (; i < l; i++) {
													html += '<li data-val="'+data[i].hid+'"><b>' + data[i].name + '</b><span> ' + data[i].address + '</span></li>';
												}
											}
											var $u=$pop.find("ul").html(html);
											resize();
											if(l>9)
												$u.css("height","240px")
											$pop.show();
											$pophide.height($pop.height());
										});
									}, 400)
									$pop.html('<ul></ul><p>未找到所需'+vsname+'？请直接输入公司名称 <a href=javascript:window.close()" class="red"><b>关闭'+vsname+'</b></a></p>');
									$pophide.height($pop.height());
							}
						},
						blur: function() {
							$(window).off("resize", resize);
							if(!$.trim($villagename.val()).length){
								$villagename.tip(0,"请输入"+villagename);
								mod.communityname = 0;
							}else if(!$cid.val()){
								$villagename.tip().on({
									mousedown:function(){
										$addxq.show();
										return false;
									},
									click:function(e) {
										e.stopImmediatePropagation()
									}
								});
								mod.communityname = 0;
							}
						}
					});
				$pop.after('<iframe src="javascript:" frameborder="0" id="pophide"></iframe>');
				var $pophide=$("#pophide");
				if($villagename.length>0)
					resize();
				$("#addCommunity").on("click", function() {
					if (!$.trim($villagename.val())){
						alertM("请输入"+villagename, {
							cName: "error"
						})
					}
					else if (!$areaid.val()){
						alertM("请选择区域", {
							cName: "error"
						})
					}
					else if (!$.trim($txtCommunityAddress.val()).length || $txtCommunityAddress.val() == "请输入详细地址"){
						alertM("请输入详细地址", {
							cName: "error"
						})
					}
					else {
						$.ajax({
							url: opt.addcommunity,
							dataType: "json",
							type:"post",
							data: {
								areaid: $areaid.val(),
								circleid: $circleid.val(),
								villagename: $villagename.val(),
								txtCommunityAddress: $txtCommunityAddress.val(),
								operate:opt.addcommunityStr
							}
						}).done(function(data) {
							if (data.state == "succ") {
								$cid.val(data.cid)
								$villagename.tip();
								mod.communityname = 1;
								$addxq.hide();
							} else alertM(data.alert, {
								cName: data.state
							})
						}).fail(function() {
							alertM("添加"+villagename+"失败,请检查网络连接是否断开", {
								cName: "error"
							})
						})
					}
				});
				$b.on("click", function() {
					$addxq.hide();
					$pop.hide();
					$pophide.css("display","none");
				});
			}else{
				var $villagename = $("#villagename").on("blur", function() {
						if($.trim($villagename.val()).length){
							$villagename.next().tip();
							mod.communityname = 1;
						}else{
							mod.communityname = 0;
							$villagename.next().tip(0,"请输入物业名称");
						}
					})
			}

			if($villagename.length==0){
				mod.communityname = 1;
			}

			if (formtype == "esf" || formtype == "zf") {
				var $rooms = $("#rooms").on("blur", function() {
						if (/^[1-9]+\d*$/.test($rooms.val())) {
							$rooms.parent().find("span").last().tip().remove();
							mod.room = 1;
						} else {
							mod.room = 0;
							$rooms.parent().find("span").last().tip(0, "户型限整数");
						}
					}),
					$halls = $("#halls").on("blur", function() {
						if (/^[1-9]+\d*$/.test($halls.val())||$halls.val()==="0") {
							$rooms.parent().find("span").last().tip().remove();
							mod.hall = 1;
						} else {
							mod.hall = 0;
							$rooms.parent().find("span").last().tip(0, "户型限整数");
						}
					}),
					$toilets = $("#toilets").on("blur", function() {
						if (/^[1-9]+\d*$/.test($toilets.val())||$toilets.val()==="0") {
							$rooms.parent().find("span").last().tip().remove();
							mod.toilet = 1;
						} else {
							mod.toilet = 0;
							$rooms.parent().find("span").last().tip(0, "户型限整数");
						}
					}),
					$addTags = $("#addTags"),
					$biaoqinl = $("#biaoqinl").on("click", "a", function() {
						$(this).parent().remove();
						if ($biaoqinl.find("span").length < 5) $addTags.show()
						if ($biaoqinl.find("span").length == 1) mod.tags = 0;
					}).on("focus", "input", function() {
						$biaoqintab.show();
						$addTags.tip().remove();
					}).on("click", function(e) {
						e.stopImmediatePropagation()
					}),
					$biaoqintab = $("#biaoqintab").on("click", "a", function() {
						var $t = $(this),
							$s = $biaoqinl.find("span");
						if ($s.filter(":contains('" + $t.text() + "')").length) return false
						else {
							if ($s.length > 3) {
								$addTags.hide()
								$biaoqintab.hide();
							} else {
								$addTags.show().tip().remove()
							}
							$s.last().after('<span class="des_post">' + $t.text() + '<a href="javascript:;"></a><input type="hidden" name="tagtext[]" value="' + $t.text() + '"></span>');
							mod.tags = 1;
						}
					}).on("click", function(e) {
						e.stopImmediatePropagation()
					}).autab("span", "div"),
					$floors = $("#floors"),
					$totalfloors = $("#totalfloors");
				$floors.add($totalfloors).on("blur", function() {
					if (/^[1-9]+\d*$/.test($floors.val())&&/^[1-9]+\d*$/.test($totalfloors.val())) {
						if ($floors.val() - 0 > $totalfloors.val() - 0) {
							mod.floor = 0;
							mod.totalfloor = 0;
							$(this).parent().find("span").last().tip(0, "总楼层数不能小于所在楼层数")
						} else {
							mod.floor = 1;
							mod.totalfloor = 1;
							$(this).parent().find("span").last().tip()
						}
					} else {
						mod.floor = 0;
						mod.totalfloors = 0;
						$(this).parent().find("span").last().tip(0, "楼层限整数")
					};
				});
				$b.on("click", function() {
					$biaoqintab.hide();
				})
			}

			if(formtype=="zf"){
				var $limit = $("#limit"),
					$paytypecon = $("#paytypecon"),
					$pricetype = $("#pricetype"),
					$paytype = $("#paytype"),
					$paytype2 = $("#paytype2"),
					$rent1 = $("#rent1").on("click", function() {
						if ($rent1.prop("checked")) {
							$paytypecon.show();
							$limit.hide();
							$pricetype.html("元/月");
							mod.zfrent=1;
						}
						$("div.tip_suc,div.tip_err").remove()
					}),
					$rent2 = $("#rent2").on("click", function() {
						if ($rent2.prop("checked")) {
							$paytypecon.show();
							$limit.show();
							$pricetype.html("元/月")
							mod.zfrent=2;
						}
						$("div.tip_suc,div.tip_err").remove()
					}),
					$rent3 = $("#rent3").on("click", function() {
						if ($rent3.prop("checked")) {
							$paytypecon.hide();
							$limit.hide();
							$pricetype.html("元/日")
							mod.zfrent=3;
						}
						$("div.tip_suc,div.tip_err").remove()
					});
				$paytype.add($paytype2).on("blur",function(){
					if ((/^[1-9]+\d*$/.test($paytype.val())||$paytype.val()==="0")&&(/^[1-9]+\d*$/.test($paytype2.val())||$paytype2.val()==="0")) {
						$paytype.parent().find("span").last().tip();
						mod.paytype = 1;
					} else {
						mod.paytype = 0;
						$paytype.parent().find("span").last().tip(0, "付款方式限整数");
					}
				})
			}

			if(formtype.indexOf("sp")>-1){
				var $floortypecon1 = $("#floortypecon1"),
					$floortypecon2 = $("#floortypecon2"),
					$floortypecon3 = $("#floortypecon3"),
					$floortip=$floortypecon1.parent().find("span").last();
					$floortype1 = $("#floortype1").on("click", function() {
						if ($floortype1.prop("checked")) {
							$floortypecon1.show();
							$floortypecon2.hide();
							$floortypecon3.hide();
							mod.spfloortype=1;
							$floortip.tip().remove();
						}
					}),
					$floortype2 = $("#floortype2").on("click", function() {
						if ($floortype2.prop("checked")) {
							$floortypecon1.hide();
							$floortypecon2.show();
							$floortypecon3.hide();
							mod.spfloortype=2;
							$floortip.tip().remove();
						}
					}),
					$floortype3 = $("#floortype3").on("click", function() {
						if ($floortype3.prop("checked")) {
							$floortypecon1.hide();
							$floortypecon2.hide();
							$floortypecon3.show();
							mod.spfloortype=3;
							$floortip.tip().remove();
						}
					}),
					$floors=$("#floors").on("blur",function(){
						if(/^[1-9]+\d*$/.test($floors.val())){
							$floortip.tip();
							mod.spfloors=1;
						}
						else{
							$floortip.tip(0,"楼层限整数");
							mod.spfloors=0;
						}
					}),
					$totalfloors=$("#totalfloors").on("blur",function(){
						if(/^[1-9]+\d*$/.test($totalfloors.val())){
							$floortip.tip();
							mod.spfloors=3;
						}
						else{
							$floortip.tip(0,"楼层限整数");
							mod.spfloors=0;
						}
					}),
					$totalfloors2=$("#totalfloors2"),
					$floors2=$("#floors2"),
					$laticoor = $("#laticoor"),
					$longcoor = $("#longcoor"),
					$sparea=$areaid.parent().find("span").last(),
					$businessindustry=$("#businessindustry"),
					$businessstatus=$("#businessstatus").on("change",function(){
						if($businessstatus.val()>0){
							if($businessstatus.val()==1){
								$businessindustry.show();
							}
							mod.spbusinessstatus=1;
							$businessstatus.parent().find("span").last().tip()
						}else{
							mod.spbusinessstatus=0;
							$businessstatus.parent().find("span").last().tip(0,"请选择营业状态")
						}
					});

				$totalfloors2.add($floors2).on("blur",function(){
					if(/^[1-9]+\d*$/.test($floors2.val())&&/^[1-9]+\d*$/.test($totalfloors2.val())){
						$floortip.tip();
						mod.spfloors=2;
					}
					else{
						$floortip.tip(0,"楼层限整数");
						mod.spfloors=0;
					}
				})

				$("#showmap,#laticoor,#longcoor").on("click", function() {
					alertM(opt.maphref+"?#" + $laticoor.val() + "#" + $longcoor.val(), {
						iframe: 1,
						time: "y",
						width: 624,
						height: 440,
						title: "添加地图标注",
						btnY: 0
					})
					window.alertM = alertM;
				});
				$areaid.on("change",function(){
					if(!$areaid.val()){
						mod.sparea=0;
						$sparea.tip(0,"请选择区域")
					}else if($areaid.val()>0&&$.trim($txtCommunityAddress.val()).length>0&&$txtCommunityAddress.val()!="请输入详细地址"){
						$sparea.tip();
						mod.sparea=1;
					}else{
						mod.sparea=0;
						$sparea.tip().remove();
					}
				});
				$circleid.on("change",function(){
					if($areaid.val()>0&&$.trim($txtCommunityAddress.val()).length>0&&$txtCommunityAddress.val()!="请输入详细地址"){
						$sparea.tip();
						mod.sparea=1;
					}else{
						mod.sparea=0;
						$sparea.tip().remove();
					}
				});
				$txtCommunityAddress.on("blur",function(){
					if(!$areaid.val()){
						mod.sparea=0;
						$sparea.tip(0,"请选择区域")
					}
					else if (!$.trim($txtCommunityAddress.val()).length||$txtCommunityAddress.val()=="请输入详细地址"){
						$sparea.tip(0,"请输入详细地址")
					}
					else if($areaid.val()>0&&$.trim($txtCommunityAddress.val()).length>0&&$txtCommunityAddress.val()!="请输入详细地址"){
						$sparea.tip();
						mod.sparea=1;
					}else{
						mod.sparea=0;
						$sparea.tip().remove();
					}
				})

				if(formtype=="spz"){
					var $paytype = $("#paytype"),
						$paytype2 = $("#paytype2"),
						$shoprenttypecon = $("#shoprenttypecon"),
						$transfertype0=$("#transfertype0"),
						$transfertype1=$("#transfertype1"),
						$transfertype2=$("#transfertype2"),
						$transferfee=$("#transferfee").on("blur",function(){
							if (/^[1-9]{1}(([0-9]{0,7})|([0-9]{0,4}\.{1}[0-9]{1,2})|([0-9]{0,5}\.{1}[0-9]?))$/.test($transferfee.val())||$transferfee.val()==="0") {
								if($shoprenttype1.prop("checked")){
									mod.sprenttype = 1;
									$shoprenttype1.parent().find("span").last().tip();
								}
							} else {
								mod.sprenttype = 0;
								$shoprenttype1.parent().find("span").last().tip(0, "转让费限最大8位数字，小数点后最多两位");
							}
							if($transferfee.val()=="")
								$transferfee.val("请输入转让费")
						}).on("focus",function(){
							if($transferfee.val()=="请输入转让费")
								$transferfee.val("")
						}),
						$shoprenttype1 = $("#shoprenttype1").on("click", function() {
							if ($shoprenttype1.prop("checked")) {
								$shoprenttypecon.show();
								if (/^[1-9]{1}(([0-9]{0,7})|([0-9]{0,4}\.{1}[0-9]{1,2})|([0-9]{0,5}\.{1}[0-9]?))$/.test($transferfee.val())||$transferfee.val()==="0"){
									mod.sprenttype = 1;
									$shoprenttype1.parent().find("span").last().tip();
								}else{
									mod.sprenttype = 0;
									$shoprenttype1.parent().find("span").last().tip(0, "转让费限最大8位数字，小数点后最多两位");
								}
							}
						}),
						$shoprenttype2 = $("#shoprenttype2").on("click", function() {
							if ($shoprenttype2.prop("checked")) {
								$shoprenttypecon.hide();
								mod.sprenttype=1;
								$shoprenttype1.parent().find("span").last().tip();
							}
						});
					$paytype.add($paytype2).on("blur",function(){
						if ((/^[1-9]+\d*$/.test($paytype.val())||$paytype.val()==="0")&&(/^[1-9]+\d*$/.test($paytype2.val())||$paytype2.val()==="0")) {
							$paytype.parent().find("span").last().tip();
							mod.paytype = 1;
						} else {
							mod.paytype = 0;
							$paytype.parent().find("span").last().tip(0, "付款方式限整数");
						}
					});
					$transfertype1.add($transfertype2).on("click",function(){
						if(!$transfertype0.prop("checked")){
							mod.sprenttype=1;
							$shoprenttype1.parent().find("span").last().tip();
						}
					})
					if ($shoprenttype2.prop("checked")) {
						$shoprenttypecon.hide();
					}
					if($shoprenttype1.prop("checked")){
						$shoprenttypecon.show();
					}
				}
			}

			if(formtype=="xzl"){
				var $floorarea=$("#floorarea1,#floorarea2,#floorarea3").on("click",function(){
					mod.xzlfloor=1;
					$floorarea.parent().find("span").last().tip();
				})
			}

			$ue.addListener("blur", function() {
				var t = $.trim($ue.getContentTxt()).length;
				if (t > 1000 || t < 8) {
					$editor.tip(0, "房源描述限8-999个字内");
					mod.content = 0;
				} else {
					mod.content = 1;
					$editor.tip().remove();
				}
			})

			$("#addMB").on("click", function() {
				if (!$.trim($ue.getContentTxt()).length) alertM("请先添加编辑器内容", {
					cName: "error"
				})
				else alertM('自定义模板名称：<input type="text" id="mbname"/><p style="text-align:center;margin:9px 0 0 0" class="red" id="mbinfo"></p>', {
					time: "y",
					width: 360,
					btnN: 1,
					btnYT: "确认添加",
					title: "添加自定义模板",
					yf: function() {
						var $t = $("#mbname"),
							$i = $("#mbinfo");
						if ($t.val().length < 4 || $t.val().length > 12) {
							$t.trigger("focus");
							$i.html("自定义模板名称限4到12位字！")
						} else {
							$.ajax({
								url: opt.addMbUrl,
								type:"post",
								dataType: "json",
								data: {
									name: $t.val(),
									housetype: $("input[name='validrules']").eq(0).val(),
									content: $ue.getContent()
								}
							}).done(function(data) {
								if (data.state == "succ") alertM(data.alert, {
									cName: "succ"
								})
								else $i.html(data.alert)
							}).fail(function() {
								$i.html("模板添加失败，请检查网络连接是否已断开")
							})
						}
						return false;
					}
				})
			})

			var submitChecker=function(){
				var bl=0;
				if (!mod.communityname) {
					bl = 1;
					$villagename.trigger("blur");
				}
				if (!mod.title) {
					bl = 1;
					$housetitle.trigger("blur");
				}
				if (!mod.content) {
					bl = 1;
					$ue.fireEvent("blur");
				}
				if (!mod.price) {
					bl = 1;
					$price.trigger("blur");
				}
				if (!mod.area) {
					bl = 1;
					$buildarea.trigger("blur");
				}
				if (formtype == "esf" || formtype == "zf") {
					if (!mod.floor) {
						bl = 1;
						$floors.trigger("blur");
					}
					if (!mod.totalfloor) {
						bl = 1;
						$totalfloors.trigger("blur");
					}
					if (!mod.room) {
						bl = 1;
						$rooms.trigger("blur");
					}
					// if ($biaoqinl.find("input").length<3) {
					// 	bl = 1;
					// 	$addTags.tip(0, "请添加房源特色标签");
					// }
				}
				if(formtype=="zf"){
					if(mod.zfrent==1&&!mod.paytype){
						bl=1;
						$paytype.trigger("blur");
					}
				}
				if(formtype=="xzl"){
					if(!$floorarea.filter(":checked")){
						bl=1;
						$floorarea.parent().find("span").last().tip(0,"请选择楼层范围");
					}
				}
				if(formtype.indexOf("sp")>-1){
					if (!mod.sparea) {
						bl = 1;
						$txtCommunityAddress.trigger("blur");
					}
					if(!mod.spbusinessstatus){
						bl=1;
						$businessstatus.trigger("change");
					}
					if(mod.spfloortype!=mod.spfloors){
						bl=1;
						if ($floortype1.prop("checked")) {
							$floortype1.trigger("click");
							$floors.trigger("blur");
						}
						if ($floortype2.prop("checked")) {
							$floortype2.trigger("click");
							$totalfloors2.add($floors2).trigger("blur");
						}
						if ($floortype3.prop("checked")) {
							$floortype3.trigger("click");
							$totalfloors.trigger("blur");
						}
					}
					if(formtype=="spz"){
						if(!$shoprenttype1.prop("checked")&&!$shoprenttype2.prop("checked")){
							bl=1;
							$shoprenttype1.parent().find("span").last().tip(0,"请选择出租形式");
						}else if(!mod.sprenttype&&$shoprenttype1.prop("checked")){
							bl=1;
							$transferfee.trigger("blur");
						}
						if(!mod.paytype){
							bl=1;
							$paytype.trigger("blur")
						}
					}
				}
				return bl;
			}
			var $form = $("#subform").on("submit", function() {
					submitChecker();
					var bl = submitChecker();
					if (bl) {
						var i=9999;
						if(!mod.communityname)
							i=$villagename.offset().top;
						else
							$("div.tip_err").each(function(){
								var t=$(this).offset().top;
								i=t<i?t:i;
							})
						$('html,body').delay(99).animate({
							scrollTop: i-24
						},function(){
							alertM.remove();
						})
						return false;
					}
					alertM("检查成功，正在提交……",{cName:"succ"})
				}),
				trigger = 1,
				$pic = $("#pic");
			$("#uploadform").on("click", function() {
				alertM("正在检查数据，请稍候", {
					cName: "loading",
					time:"y"
				})
				$pic.prop("checked", true);
			})
			$("#sendhouseform").on("click", function() {
				alertM("正在检查数据，请稍候", {
					cName: "loading",
					time:"y"
				})
				$pic.prop("checked", false);
			})
			$(function(){
				$("body").append('<a href="javascript:" id="goTop" title="返回顶部">返回顶部</a>')
				var $gt=$("#goTop").on("click",function(){
					$('html,body').animate({
						scrollTop: 0
					})
				})
				if (!-[1, ] && !window.XMLHttpRequest) {
					var $w = $(window).on('scroll', function() {
						$gt.stop(true, false).animate({
							top: $w.height() - $gt.height() + $w.scrollTop() - 99
						})
					});
				}
			})
		}
	}
});