define(function(require, exports, module) {
	require('jquery');
	var alertM = require("alert"),
		$tl = $("#tlist").on("mouseover", "tr", function() {
			$(this).addClass("on").find("div").addClass("on");
		}).on("mouseout", "tr", function() {
			$(this).removeClass("on").find("div").removeClass("on");
		}).on("click", "input.hid", function() {
			if ($(this).prop("checked")) $(this).parent().parent().addClass("selected");
			else $(this).parent().parent().removeClass("selected");
			checkAll();
		}).on("click", "label", function() {
			$(this).parents("tr").find("input[type=checkbox]").trigger("click");
		}),
		$tlCB = $tl.find('input.hid'),
		$menu = $("#hideMenu"),
		$allCB = $("#allCB").on("click", function() {
			if ($(this).prop("checked")) $tlCB.not(":checked").trigger("click");
			else $tlCB.filter(":checked").trigger("click");
		}),
		$showNO = $("#showNO").on("change", function() {
			if ($(this).prop("checked")) $tl.addClass("show");
			else $tl.removeClass("show");
		}),
		mh = $menu.offset().top,
		hBoolean = 1,
		$w = $(window),
		l = $tlCB.length,
		checkAll = function() {
			if ($tlCB.filter(":checked").length == l) $allCB.prop("checked", 1);
			else $allCB.prop("checked", 0);
		},
		$searchHouse = $("#searchHouse"),
		$order = $("#order"),
		$sortSelect = $("#sortSelect").on("change", function() {
			$order.val($sortSelect.val());
			$searchHouse.trigger("submit");
		}),
		$hform = $("#houseList"),
		$tinfo = $searchHouse.parent().prev(),
		reload = function() {
			setTimeout(function() {
				window.location.reload();
			}, 2000)
		};
	$("table tr").each(function() {
		$(this).find("td").last().addClass("lastTd");
		$(this).find("th").last().addClass("lastTd");
	});
	$("#subSearch").after('<button type="submit" class="sBtn">搜索房源</button>').remove();
	$("#qxT a.potip").on({
		mouseenter:function(){
			$(this).parent().css("z-index","9")
		},
		mouseleave:function(){
			$(this).parent().css("z-index","0")
		}
	});
	$(document).ajaxStart(function() {
	
	});

	if (!-[1, ] && !window.XMLHttpRequest) {
		$w.on("scroll", function() {
			if ($w.scrollTop() > mh) {
				hBoolean = 0;
				$menu.css({
					top: $w.scrollTop() - mh + 35
				});
			} else if ($w.scrollTop() < mh && !hBoolean) {
				hBoolean = 1;
				$menu.css({
					top: "35px"
				});
			}
		})
	} else {
		$w.on("scroll", function() {
			if ($w.scrollTop() > mh && hBoolean) {
				hBoolean = 0;
				$menu.css({
					position: "fixed",
					top: "0"
				});
			} else if ($w.scrollTop() < mh && !hBoolean) {
				hBoolean = 1;
				$menu.css({
					position: "absolute",
					top: "35px"
				});
			}
		})
	}
	$w.trigger("scroll");
	return {
		deleteItem: function(url) {
			$menu.on("click", "a.del", function() {
				if ($tlCB.filter(":checked").length)
					alertM("确认删除选中的" + $tlCB.filter(":checked").length + "条房源吗？<br>注意：删除的房源无法恢复", {
						title: "删除房源",
						time: "y",
						btnN: 1,
						btnYT: "确认删除",
						yf: function() {
							$.ajax({
								url: url,
								data: $hform.serialize(),
								type: "post",
								dataType: "json"
							}).done(function(data) {
								if (data.state == "succ")
									reload();
								alertM(data.alert, {
									cName: data.state
								})
							}).fail(function() {
								alertM("删除房源失败，请检查网络连接是否已断开", {
									cName: "error"
								})
							})
							return 0;
						}
					})
				else
					alertM("请至少选择一项要操作的房源", {
						cName: "error"
					})
			})
			return module.exports;
		},
		deleteMessage: function(url, name) {
			name = name ? name : "房源留言";
			var ptype = name ? "post" : "get";
			$menu.on("click", "a.del", function() {
				if ($tlCB.filter(":checked").length)
					alertM("确认删除选中的" + $tlCB.filter(":checked").length + "条" + name + "吗？", {
						title: "删除" + name + "",
						time: "y",
						btnN: 1,
						btnYT: "确认删除",
						yf: function() {
							$.ajax({
								url: url,
								data: $hform.serialize(),
								type: ptype,
								dataType: "json"
							}).done(function(data) {
								if (data.state == "succ")
									reload();
								alertM(data.alert, {
									cName: data.state
								})
							}).fail(function() {
								alertM("删除" + name + "失败，请检查网络连接是否已断开", {
									cName: "error"
								})
							})
							return 0;
						}
					})
				else
					alertM("请至少选择一项要操作的" + name + "", {
						cName: "error"
					})
			})
			return module.exports;
		},
		refresh: function(furl, aurl, hdata) {
			$menu.on("click", "a.ref", function() {
				if ($tlCB.filter(":checked").length) {
					$.ajax({
						url: furl,
						data: $hform.serialize(),
						type: "post",
						dataType: "json"
					}).done(function(data) {
						alertM(data.alert, {
							cName: data.state
						});
						if (data.state == "succ") {
							$tlCB.filter(":checked").each(function() {
								$(this).parents("tr").find("td").eq(3).find("span").first().html("今日已刷新");
							});
							if ($("#qxT").length&&data.data.length)
								$("#qxT").replaceWith(data.data)
						}
					}).fail(function() {
						alertM("刷新房源失败，请检查网络连接是否已断开", {
							cName: "error"
						})
					})
				} else
					alertM("请至少选择一项要操作的房源", {
						cName: "error"
					})
			})
			$tl.on("click", "a.ref", function() {
				var $t = $(this).parent();
				hdata.hid = $t.parent().find("input.hid").val();
				$.ajax({
					url: aurl,
					data: hdata,
					type: "post",
					dataType: "json"
				}).done(function(data) {
					if (data.state == "succ") {
						$t.find("span").first().html("今日已刷新");
						if ($("#qxT").length&&data.data.length)
							$("#qxT").replaceWith(data.data)
					}
					alertM(data.alert, {
						cName: data.state
					})
				}).fail(function() {
					alertM("刷新房源失败，请检查网络连接是否已断开", {
						cName: "error"
					})
				})
			})
			return module.exports;
		},
		deleteRefresh: function(url) {
			$menu.on("click", "a.delRef", function() {
				if ($tlCB.filter(":checked").length)
					alertM("取消针对选中的" + $tlCB.filter(":checked").length + "条房源设置的预约刷新吗?", {
						title: "取消房源预约刷新",
						time: "y",
						btnYT: "取消预约",
						yf: function() {
							var $ts=[];
							$tlCB.filter(":checked").each(function() {
								var $td = $(this).parents("tr").find("td").eq(3),
									td = $td.html().split("<br>");
								$td.data("html",$td.html()).html(td[0] + "<br>" + td[1] + '<br><a href="javascript:;" class="setRef">预约刷新</a>')
								$ts.push($td);
							});
							$.ajax({
								url: url,
								data: $hform.serialize(),
								global:false,
								dataType: "json",
								type:"post"
							}).done(function(data) {
								if (data.state == "succ") {
									if ($tinfo.attr("class") == "tinfo")
										$("#qxT").replaceWith(data.data)
								}else{
									alertM(data.alert, {
										cName: data.state
									})
									for(var i=0,l=$ts.length;i<l;i++){
										$ts[i].html($ts[i].data("html"));
									}
								}
							}).fail(function() {
								alertM("取消预约失败，请检查网络连接是否已断开", {
									cName: "error"
								})
								for(var i=0,l=$ts.length;i<l;i++){
									$ts[i].html($ts[i].data("html"));
								}
							})
						}
					})
				else
					alertM("请至少选择一项要操作的房源", {
						cName: "error"
					})
			})
			return module.exports;
		},
		offShelf: function(url) {
			$menu.on("click", "a.offShelf", function() {
				if ($tlCB.filter(":checked").length)
					$.ajax({
						url: url,
						data: $hform.serialize(),
						type: "post",
						dataType: "json"
					}).done(function(data) {
						if (data.state == "succ")
							reload();
						alertM(data.alert, {
							cName: data.state
						})
					}).fail(function() {
						alertM("下架房源失败，请检查网络连接是否已断开", {
							cName: "error"
						})
					})
				else
					alertM("请至少选择一项要操作的房源", {
						cName: "error"
					})
			})
			return module.exports;
		},
		onShelf: function(url) {
			$menu.on("click", "a.onShelf", function() {
				if ($tlCB.filter(":checked").length)
					$.ajax({
						url: url,
						data: $hform.serialize(),
						type: "post",
						dataType: "json"
					}).done(function(data) {
						if (data.state == "succ")
							reload();
						alertM(data.alert, {
							cName: data.state
						})
					}).fail(function() {
						alertM("上架房源失败，请检查网络连接是否已断开", {
							cName: "error"
						})
					})
				else
					alertM("请至少选择一项要操作的房源", {
						cName: "error"
					})
			})
			return module.exports;
		},
		setRefresh: function(url) {
			$menu.on("click", "a.setRef", function() {
				if ($tlCB.filter(":checked").length) {
					var i = [];
					$tlCB.filter(":checked").each(function() {
						i.push($(this).val());
					})
					alertM(url + i.join(), {
						iframe: 1,
						time: "y",
						width: 400,
						height: 200,
						btnY: 0,
						title: "房源置顶"
					})
				} else
					alertM("请至少选择一项要操作的房源", {
						cName: "error"
					})
				return false;
			})
			$tl.on("click", "a.setRef", function() {
				alertM(url + $(this).parent().parent().find("input.hid").val(), {
					iframe: 1,
					time: "y",
					width: 400,
					height: 200,
					btnY: 0,
					title: "房源置顶"
				})
				return false;
			})
			return module.exports;
		},
		setNotes: function(url, hdata) {
			$tl.on("click", "a.setNotes", function() {
				hdata.hid = $(this).parent().parent().find("input.hid").val();
				$.ajax({
					url: url,
					data: hdata,
					dataType: "json"
				}).done(function(data) {
					var str = '<div id="refList"><table width="100%"><tr><th>日期</th><th>时间</th><th>类型</th></tr>'
					if (data.length > 0)
						for (var i = 0, l = data.length; i < l; i++) {
							str += '<tr><td>' + data[i].starttime + "至" + data[i].endtime + '</td><td>' + data[i].hour + '</td><td>' + data[i].type + '</td></tr>'
					} else {
						str += '<tr><td colspan=3 style="text-align:center">查无记录</td></tr>'
					}
					alertM(str + "</table></div>", {
						time: "y",
						width: "480",
						title: "查看定时记录"
					})
				}).fail(function() {
					alertM("获取定时纪录失败，请检查网络连接是否已断开", {
						cName: "error"
					})
				})
			})
			return module.exports;
		},
		rePush: function(url) {
			$menu.on("click", "a.rePush", function() {
				if ($tlCB.filter(":checked").length)
					$.ajax({
						url: url,
						data: $hform.serialize(),
						type: "post",
						dataType: "json"
					}).done(function(data) {
						if (data.state == "succ")
							reload();
						alertM(data.alert, {
							cName: data.state
						})
					}).fail(function() {
						alertM("重新发布房源失败，请检查网络连接是否已断开", {
							cName: "error"
						})
					})
				else
					alertM("请至少选择一项要操作的房源", {
						cName: "error"
					})
			})
			return module.exports;
		},
		refreshNotes: function(url, hdata) {
			var html = function(data) {
				var str = '<div id="refList"><table width="100%"><tr><th>日期</th><th>时间</th><th>类型</th><th>状态</th></tr>'
				for (var i = 0, l = data.note.length; i < l; i++) {
					str += '<tr><td>' + data.note[i].time + '</td><td>' + data.note[i].hour + '</td><td>' + data.note[i].type + '</td><td>' + data.note[i].status + '</td></tr>'
				}
				str += '</table><div class="pages cf">' + data.page + '/' + data.pages;
				if (data.page - 0 < data.pages - 0)
					str += '<a href="javascript:" class="lightbtn next fr">下一页</a>'
				if (data.page != 1)
					str += '<a href="javascript:" class="lightbtn prev fr">上一页</a>'
				str += "</div>";
				return str;
			}
			$tl.on("click", "a.notes", function() {
				hdata.hid = $(this).parent().parent().find("input.hid").val();
				hdata.page = 1;
				$.ajax({
					url: url,
					data: hdata,
					dataType: "json"
				}).done(function(data) {
					alertM(html(data), {
						time: "y",
						width: "430",
						btnY: 0,
						title: "刷新纪录"
					})
					var $p = $("#alertP").on("click", "a.next", function() {
						hdata.page = data.page - 0 + 1;
						$.ajax({
							url: url,
							data: hdata,
							dataType: "json"
						}).done(function(data) {
							$p.html(html(data))
						}).fail(function() {
							alertM("获取刷新纪录失败，请检查网络连接是否已断开", {
								cName: "error"
							})
						})
					}).on("click", "a.prev", function() {
						hdata.page = data.page - 1;
						$.ajax({
							url: url,
							data: hdata,
							dataType: "json"
						}).done(function(data) {
							$p.html(html(data))
						}).fail(function() {
							alertM("获取刷新纪录失败，请检查网络连接是否已断开", {
								cName: "error"
							})
						})
					})
				}).fail(function() {
					alertM("获取刷新纪录失败，请检查网络连接是否已断开", {
						cName: "error"
					})
				})
			})
			return module.exports;
		},
		addTag: function(url, addUrl, hdata) {
			$tl.on("click", "a.addTag", function() {
				var $t = $(this).parent();
				hdata.hid = $t.parent().find("input.hid").val();
				$.ajax({
					url: url,
					data: hdata,
					dataType: "json"
				}).done(function(data) {
					var str = '<form id="tagform"><span class="red">提醒：每个标签的使用期限是7天,到期后系统将自动取消。</span><div class="tipInfo"><h3>特别提醒：</h3>新推房源必须为7天内新创建的房源</div><ul><li><input id="tag1" name="tag" type="radio" class="hid" value="1" ' + (data.newtag.status || 'disabled="disabled"') + '><label for="tag1"><img src="images/common/tag_urgent1.gif" width="23" height="23"><b>新推房源</b>可使用 ' + data.newtag.limit + ' 个， 已使用 ' + data.newtag.used + ' 个 剩余 ' + data.newtag.remain + ' 个</label></li><li><input id="tag2" name="tag" type="radio" class="hid" value="2" ' + (data.recommendtag.status || 'disabled="disabled"') + '><label for="tag2"><img src="images/common/tag_urgent2.gif" width="23" height="23"><b>推荐房源</b>可使用 ' + data.recommendtag.limit + ' 个， 已使用 ' + data.recommendtag.used + ' 个 剩余 ' + data.recommendtag.remain + ' 个</label></li><li><input id="tag3" name="tag" type="radio" class="hid" value="3" ' + (data.urgenttag.status || 'disabled="disabled"') + '><label for="tag3"><img src="images/common/tag_urgent3.gif" width="23" height="23"><b>急售房源</b>可使用 ' + data.urgenttag.limit + ' 个， 已使用 ' + data.urgenttag.used + ' 个 剩余 ' + data.urgenttag.remain + ' 个</label></li></ul></form>';
					alertM(str, {
						time: "y",
						width: "430",
						title: "使用标签",
						btnN: 1,
						btnYT: "使用标签",
						yf: function() {
							if ($("#tagform").find("input:checked").length) {
								hdata.type = $("#tagform").find("input:checked").val();
								$t.data("html",$t.html()).html('<img src="images/common/tag_urgent' + hdata.type + '.gif" width="23" height="23" align="absmiddle"> <a href="javascript:" class="removeTag" data-tag="' + hdata.type + '">取消标签</a>')
								$.ajax({
									url: addUrl,
									data: hdata,
									type: "post",
									global:false,
									dataType: "json"
								}).done(function(data) {
									if (data.state == "succ") {
										if ($("#qxT").length&&data.data.length)
											$("#qxT").replaceWith(data.data)
									}else{
										alertM(data.alert, {
											cName: data.state
										})
										$t.html($t.data("html"));
									}
								}).fail(function() {
									alertM("添加标签失败，请检查网络连接是否已断开", {
										cName: "error"
									})
									$t.html($t.data("html"));
								})
							} else {
								$("#tagform").find("span").html("提醒：请至少选择一个标签")
							}
						}
					})
				}).fail(function() {
					alertM("添加标签失败，请检查网络连接是否已断开", {
						cName: "error"
					})
				})
			})
			return module.exports;
		},
		removeTag: function(url, hdata) {
			$tl.on("click", "a.removeTag", function() {
				var $t = $(this).parent();
				hdata.hid = $t.parent().find("input.hid").val();
				hdata.type = $(this).data("tag");
				alertM("确定要取消该标签吗?", {
					title: "取消房源标签",
					time: "y",
					btnN: 1,
					btnYT: "取消标签",
					yf: function() {
						$t.data("html",$t.html()).html('<a href="javascript:" class="addTag">添加标签</a>')
						$.ajax({
							url: url,
							data: hdata,
							type: "post",
							global:false,
							dataType: "json"
						}).done(function(data) {
							if (data.state == "succ") {
								if ($("#qxT").length&&data.data.length)
									$("#qxT").replaceWith(data.data)
							}else{
								alertM(data.alert, {
									cName: data.state
								})
								$t.html($t.data("html"));
							}
						}).fail(function() {
							alertM("取消标签失败，请检查网络连接是否已断开", {
								cName: "error"
							})
							$t.html($t.data("html"));
						})
					}
				})
			})
			return module.exports;
		},
		setReaded: function(url) {
			$menu.on("click", "a.setreaded", function() {
				if ($tlCB.filter(":checked").length)
					$.ajax({
						url: url,
						data: $hform.serialize(),
						type: "post",
						dataType: "json"
					}).done(function(data) {
						if (data.state == "succ")
							reload();
						alertM(data.alert, {
							cName: data.state
						})
					}).fail(function() {
						alertM("标记已读失败，请检查网络连接是否已断开", {
							cName: "error"
						})
					})
				else
					alertM("请至少选择一项要操作的信息", {
						cName: "error"
					})
			})
			return module.exports;
		},
		wt:function(url){
			$tl.on("click", "a.on", function() {
				var $t = $(this).parent();
				$t.data("html",$t.html()).html('<span class="red">已接受</span>')
				$.ajax({
					url: url,
					data: {
						eid:$t.parent().find("input.hid").val(),
						type:"on"
					},
					type: "post",
					dataType: "json"
				}).done(function(data) {
					alertM(data.alert, {
						cName: data.state
					})
					if (data.state != "succ") {
						$t.html($t.data("html"));
					}
				}).fail(function() {
					alertM("接受委托失败，请检查网络连接是否已断开", {
						cName: "error"
					})
					$t.html($t.data("html"));
				})
			}).on("click", "a.off", function() {
				var $t = $(this).parent();
				alertM('<p>请输入拒绝委托原因：</p><textarea id="jujueinfo" style="width:280px;"></textarea><p class="red" id="errinfo">（可输入2到20字）</p>', {
					title: "拒绝委托",
					time: "y",
					btnN: 1,
					btnYT: "拒绝委托",
					yf: function() {
						if($.trim($("#jujueinfo").val()).length<2||$.trim($("#jujueinfo").val()).length>20){
							$("#errinfo").html('拒绝委托原因长度限2到20字内');
							return false;
						}
						$t.data("html",$t.html()).html('已拒绝');
						$.ajax({
							url: url,
							data: {
								eid:$t.parent().find("input.hid").val(),
								type:"off",
								info:$("#jujueinfo").val()
							},
							type: "post",
							dataType: "json"
						}).done(function(data) {
							alertM(data.alert, {
								cName: data.state
							})
							if (data.state != "succ") {
								$t.html($t.data("html"));
							}
						}).fail(function() {
							alertM("拒绝委托失败，请检查网络连接是否已断开", {
								cName: "error"
							})
							$t.html($t.data("html"));
						})
					}
				})
			})
			return module.exports;
		},
		showInfo:function(url){
			$tl.on("click", "a.showinfo", function() {
				var $t = $(this).parent().parent().parent();
				$.ajax({
					url: url,
					data: {
						eid:$t.find("input.hid").val()
					},
					type: "post",
					dataType: "html"
				}).done(function(data) {
					alertM(data, {
						title:"委托信息详情",
						time:"y",
						btnY:0
					})
				}).fail(function() {
					alertM("查询委托信息失败，请检查网络连接是否已断开", {
						cName: "error"
					})
				})
			})
			return module.exports;
		}
	}
});