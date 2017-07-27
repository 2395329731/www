function LoginDialog(option, regster_data) {
	function init() {
		tabLogin=J.g("tabBtnLogin"),
		cLogin=J.g("tab_Login"),
		cRegister=J.g("tab_Register"),
		tabRegister=J.g("tabBtnRegister"),
		LOGIN=new Login,
		REGISTER=new Register,
		tabLogin.on("click", function() {
			LOGIN.show()
		}
		),
		tabRegister.on("click", function() {
			REGISTER.show()
		}
		)
	}
	function postJSONP(e) {
		var t="J__ID"+J.getTime().toString(16),
		n=D.createElement("div"),
		r=D.createElement("form"),
		i=[],
		s=e.data;
		GUID&&GUID.parentElement.removeChild(GUID),
		GUID=n;
		var o=document.head||document.getElementsByTagName("head")[0];
		n.innerHTML='<iframe id="'+t+'" name="'+t+'"></iframe>',
		n.style.display="none";
		for(var u in s)i.push("<input type='hidden' name='"+u+"' value='"+s[u]+"' />");
		e.callback&&i.push("<input type='hidden' name='callback' value='"+e.callback+"' />"),
		r.innerHTML=i.join(""),
		r.action=e.url,
		r.method="post",
		r.target=t,
		n.appendChild(r),
		o.insertBefore(n, o.firstChild),
		r.submit(),
		r=null
	}
	function showLogin(e) {
		for(var t in e)e[t]&&(customEvent[t]=e[t]);
		isLogin=!0,
		show()
	}
	function showRegister() {
		isRegister=!0,
		show()
	}
	function show() {
		html='<div class="dialog_c register_c" style="border: 1px solid #999"><div class="t">\u60a8\u5c1a\u672a\u767b\u5f55<a class="close"></a></div><div class="l"><div class="tab clearfix"><span '+(isLogin?'class="on"': "")+'id="tabBtnLogin">\u767b\u5f55</span><span id="tabBtnRegister" class="'+(isRegister?"on":"")+'" style="margin-left: -1px;">\u6ce8\u518c</span></div><ul '+(isLogin?'style="display:block"':'style="display:none"')+'id="tab_Login">'+'<li><label>\u767b\u5f55\u540d\uff1a</label><input maxlength="40" type="text" id="iptLoginName" placeholder="\u8bf7\u8f93\u5165\u90ae\u7bb1/\u624b\u673a\u53f7/\u7528\u6237\u540d" name="userName"/><span style="display: none" class="v_tooltip v_success"></span>'+'<div class="li_error" style=""><label class="v_error" id="info_iptLoginName" style="display: none">\u7528\u6237\u540d\u6216\u5bc6\u7801\u9519\u8bef</label></div></li>'+'<li style=""><label>\u5bc6\u7801\uff1a</label><input name="pwd" maxlength="50" placeholder="\u8bf7\u8f93\u5165\u5bc6\u7801" id="iptLoginPwd" type="password"/><span style="display: none" class="v_tooltip v_success"></span>'+'<div style="height: 25px;position: relative;"><label id="info_iptLoginPwd" style="display: none" class="v_error">\u5bc6\u7801\u4e0d\u80fd\u4e3a\u7a7a</label></div></li>'+'<li id="codeBox" style="display:none"  class="clearfix codeHeight"><label>\u9a8c\u8bc1\u7801\uff1a</label> <div class="clearfix"><input type="hidden" name="source" value="pc_web" /><input type="text" id="iptLoginCode" maxlength="5" name="logincode" class="captcha_txt"  /><img class="captcha_img" id="iptLoginCodeImg" src="" width="90" height="26"><a class="captcha_click" id="iptLoginCodeBtn">\u6362\u4e00\u5f20</a></div>'+'<div style="height: 25px;position: relative;"><label id="info_iptLoginCode" style="display: none" class="v_error">dddd</label></div></li>'+'<p style="height:0px; border:0px; line-height:1px; overflow:hidden;zoom:0.08;"><p><li class="clearfix" style="clear:both"><input class="btnLogin" type="button" value="\u7acb\u5373\u767b\u5f55"/><a style="margin-left: 12px;line-height: 32px;display: inline-block;" href="'+opts.userDomain+"/pass?type=forget"+'">\u5fd8\u8bb0\u5bc6\u7801\uff1f</a></li>'+"</ul><ul "+(isRegister?'style="display:block"':'style="display:none"')+' id="tab_Register">'+'<li style="z-index: 10"><label>\u767b\u5f55\u540d\uff1a</label><input type="text" maxlength="50" id="iptUserName" name="userName"><span style="display: none" class="v_tooltip v_success"></span></li>'+'<li  class="li_error"><label id="info_userName" style="display: none" class="v_error">\u7528\u6237\u540d\u6216\u5bc6\u7801\u9519\u8bef</label></li><li><label>\u8bbe\u7f6e\u5bc6\u7801\uff1a</label><input maxlength="50" type="password" id="iptPassWord"><span style="display: none" class="v_tooltip v_success"></span></li>'+'<li class="li_error"><label id="info_PassWord" style="display: none" class="v_error">\u8bf7\u8f93\u5165\u5bc6\u7801</label></li>'+'<li class="li_code" id="b_mail" style="display: none"><label>\u9a8c\u8bc1\u7801\uff1a</label><input id="verify_pic" type="text" maxlength="5" name="code"><img id="iptRegCodeImg" style="display:inline;height: 32px;width: 93px;cursor:pointer;vertical-align: top;" src=""/><a style="line-height: 32px;" href="#" onclick="return false;">\u4e0b\u4e00\u5f20</a><span style="display:none" class="v_tooltip v_success"></span><div style="position: relative;left:0;height: 25px;" class="mail_error">'+'<label class="v_error" style="display: none;left: 0">\u9a8c\u8bc1\u7801\u4e0d\u80fd\u4e3a\u7a7a</label></div></li>'+'<li class="li_code" id="b_tel" style="display: none" ><label>\u9a8c\u8bc1\u7801\uff1a</label><input type="text" maxlength="5" name="code"><input class="cik_code" type="button" value="\u83b7\u53d6\u9a8c\u8bc1\u7801"/><div style="height: 25px;position: relative">'+'<label class="v_error" style="display: none;left: 0">\u9a8c\u8bc1\u7801\u4e0d\u80fd\u4e3a\u7a7a</label></div></li>'+'<li style="height: 16px;position: static"><label>&nbsp;</label><input id="ipt_ckb" class="ipt_ckb" checked="checked" type="checkbox" name="ckb"/> \u6211\u5df2\u9605\u8bfb\u5e76\u63a5\u53d7\u300a<a href="'+opts.userDomain+'/user-agreement.html">\u7528\u6237\u670d\u52a1\u534f\u8bae</a>\u300b</li>'+'<li class="li_error"><label id="info_agg" style="display: none" class="v_error">\u8bf7\u52fe\u9009\u62a5\u52a1\u534f\u8bae</label></li>'+'<li><input class="btnLogin" type="button" value="\u63d0\u4ea4\u6ce8\u518c"></li>'+"</ul></div>"+'<div class="r"><div class="r_t">\u60a8\u4e5f\u53ef\u4ee5\u7528\u5408\u4f5c\u7f51\u7ad9\u5e10\u53f7\u767b\u5f55\uff1a</div><div class="r_c"><a class="qq" href="'+opts.qq+'">QQ</a><a class="twitter" href="'+opts.weibo+'">\u65b0\u6d6a\u5fae\u535a</a></div></div></div>', objDialog=new J.ui.panel( {
			autoClose:"", scroll:!1, mask:!1, modal:!0, title:"", content:html, close:!0, ok:"", cancel:"", width:620, height:"", position: {}
			, drag:!1, fixed:"", onClose:null, onOk:null, onCancel:null, custom:null, tpl:"panel_login"
		}
		),
		init()
	}
	function Login() {
		function UserName() {
			function n() {
				e.val().trim()?e.val().trim().length<4?(t.html("\u8bf7\u8f93\u5165\u81f3\u5c114\u4e2a\u5b57\u7b26").show(), USERNAME.success=!1): (USERNAME.success=!0, (!saveUsername||saveUsername!=e.val())&&codeBox.hide(), e.next().show()):(t.html("\u8bf7\u8f93\u5165\u90ae\u7bb1/\u624b\u673a\u53f7/\u7528\u6237\u540d").show(), USERNAME.success=!1)
			}
			var e=J.g("iptLoginName"),
			t=J.g("info_iptLoginName");
			return e.on("blur", n),
			e.on("focus", function() {
				e.next().hide(), t.hide()
			}
			),
			{
				dom: e, validate:n
			}
		}
		function Pwd() {
			function n() {
				if(!e.val()) {
					t.html("\u8bf7\u8f93\u5165\u5bc6\u7801").show(),
					PWD.success=!1;
					return
				}
				PWD.success=!0,
				e.next().show()
			}
			var e=J.g("iptLoginPwd"),
			t=J.g("info_iptLoginPwd");
			return e.on("blur", n),
			e.on("focus", function() {
				e.next().hide(), t.hide()
			}
			),
			{
				dom: e, dom_info:t, validate:n
			}
		}
		function Code() {
			var e=J.g("iptLoginCodeBtn");
			e.on("click", function() {
				codeDom_img.attr("src", opts.memberDomain+"/captcha?r="+Math.random())
			}
			),
			codeDom.on("focus", function() {
				codeDom_info.hide()
			}
			)
		}
		function show() {
			tabRegister.removeClass("on"),
			tabLogin.addClass("on"),
			cRegister.hide(),
			cLogin.show()
		}
		function submitHandler() {
			USERNAME.validate(),
			PWD.validate(),
			USERNAME.success&&PWD.success&&(global.loginDailog.callbackLoginSuccess=function(ret) {
				ret.error=="402"&&(codeDom_info.html("\u9a8c\u8bc1\u7801\u4e0d\u80fd\u4e3a\u7a7a").show(), codeBox.show()), ret.error=="403"&&(codeDom_img.attr("src", opts.memberDomain+"/captcha?r="+Math.random()), codeDom_info.html("\u9a8c\u8bc1\u7801\u4e0d\u6b63\u786e").show(), codeBox.show());
				if(!ret.result) {
					var data=ret.data;
					if(data) {
						var userid=data.USERID, usertype=data.USERTYPE;
						typeof customEvent.callback=="string"?eval(customEvent.callback): customEvent.callback(data), objDialog.close(), loginObj&&loginObj.refresh()
					}
				}
				else USERNAME.dom.next().hide(), PWD.dom.next().hide(), PWD.dom_info.html("\u767b\u9646\u540d\u6216\u5bc6\u7801\u9519\u8bef\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165").show()
			}
			, saveUsername=USERNAME.dom.val(), postJSONP( {
				type:"jsonp", data: {
					url: opts.base64UrlLogin, history:opts.url, sid:"anjuke", isp:1, username:USERNAME.dom.val(), password:PWD.dom.val(), source:"pc_web", captcha:codeDom.val(), callback:"window.parent.global.loginDailog.callbackLoginSuccess"
				}
				, url:opts.memberDomain+"/login"
			}
			))
		}
		var USERNAME,
		PWD,
		CODE,
		saveUsername,
		codeBox=J.g("codeBox"),
		codeDom=J.g("iptLoginCode"),
		codeDom_info=J.g("info_iptLoginCode"),
		codeDom_img=J.g("iptLoginCodeImg");
		return cLogin.s(".btnLogin").eq(0).on("click", submitHandler),
		USERNAME=new UserName,
		PWD=new Pwd,
		CODE=new Code,
		codeDom_img.attr("src", opts.memberDomain+"/captcha?r="+Math.random()),
		{
			show: show
		}
	}
	function Register() {
		function Stack(e) {
			function r(e) {
				!s(e)&&t.push(e)
			}
			function i(e) {
				t.unshift(e)
			}
			function s(e) {
				var n=0,
				r=t.length;
				for(;
				n<t.length;
				n++)if(t[n]===e)return!0;
				return!1
			}
			function o(e) {
				var n=0,
				r=t.length;
				for(;
				n<r;
				n++)t[n]===e&&(delete t[n], t.splice(n, 1));
				return!1
			}
			function u(e) {
				t.length&&t.shift()(e)!==!1&&u()
			}
			var t=[],
			n= {
				duplicate:!1,
				callback:function() {}
			}
			;
			return {
				run: u, push:r, unShift:i, remove:o, stack:t
			}
		}
		function show() {
			tabLogin.removeClass("on"),
			tabRegister.addClass("on"),
			cLogin.hide(),
			cRegister.show()
		}
		function submitHandler() {
			BTN.get().disabled=!0,
			setTimeout(function() {
				BTN.get().disabled=!1
			}
			, 2e3);
			var data= {
				formhash: "3bd8bc0a", useraction:1, referer:"index.php", history:opts.url, reg:0, register:1, type:"register", cityid:J.getCookie("ctid")||11, sid:"anjuke", url:opts.base64Register, service_term:1, history:opts.url, isp:1, from_register_page:"ok"
			}
			;
			stack=new Stack;
			var timer=(new Date).getTime(),
			funName="beforeRegister"+timer;
			global.loginDailog[funName]=function(e) {
				stack.run(e)
			}
			,
			global.loginDailog.callbackRegisterSuccess=function(ret) {
				if(!ret.result) {
					if(typeof customEvent.callback=="string") {
						var data=ret.data,
						userid=data.USERID;
						eval(customEvent.callback)
					}
					else customEvent.callback(ret.data);
					objDialog.close();
					try {
						loginObj&&loginObj.refresh()
					}
					catch(e) {}
				}
				else alert("\u6ce8\u518c\u5931\u8d25");
				delete global.loginDailog[funName]
			}
			,
			stack.push(USERNAME.validate);
			if(submitType=="mail") {
				data.registerfrom="anjuke_email",
				data.email=USERNAME.dom.val(),
				data.password=PWD.dom.val(),
				data.verifycode=J.g("b_mail").s("input").eq(0).val(),
				stack.push(function() {
					return J.get( {
						type:"jsonp", url:opts.userDomain+"/register", data: {
							chktype: "email", email:USERNAME.dom.val(), r:Math.random()
						}
						, callback:"global.loginDailog."+funName
					}
					), stack.unShift(function(e) {
						var t=J.g("iptUserName"), n=J.g("info_userName");
						return e.result=="norepeat_email"?(t.next().show(), n.hide(), !0): e.result=="repeat_email"?(n.html("\u8be5\u90ae\u7bb1\u5df2\u6ce8\u518c\uff0c<a href="+opts.userDomain+"/my/login"+">\u70b9\u51fb\u767b\u5f55</a>"), n.show(), !1):(n.html("\u8f93\u5165\u5185\u5bb9\u683c\u5f0f\u6709\u8bef"), n.show(), !1)
					}
					), !1
				}
				),
				stack.push(PWD.validate),
				stack.push(function() {
					return J.get( {
						type:"jsonp", url:opts.validateSuccessMail, data: {
							action: "ajax_times", r:Math.random(), callback:"global.loginDailog."+funName
						}
					}
					), stack.unShift(function(e) {
						if(e.code==-1) {
							var t=J.g("b_mail");
							t.show(), stack.unShift(function() {
								var e=J.g("b_mail").s("input").eq(0).val();
								return e?(stack.unShift(function(e) {
									if(e.result=="success")return!0;
									var t=J.g("b_mail").s("label").eq(1);
									return t.html("\u9a8c\u8bc1\u7801\u4e0d\u6b63\u786e").show(), cRegister.s(".li_code").eq(0).s("img").eq(0).attr("src", opts.imgMailCode.replace(/(?: r=).*/, "r="+Math.random())), !1
								}
								), J.get( {
									type:"jsonp", url:opts.validateSuccessMail, data: {
										action: "check_code", _r:Math.random(), code:e
									}
									, callback:"global.loginDailog."+funName
								}
								), !1):(J.g("b_mail").s("label").eq(1).html("\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801").show(), !1)
							}
							)
						}
					}
					), !1
				}
				),
				stack.push(AGREEMENT.validate),
				stack.push(function() {
					return postJSONP( {
						type: "jsonp", data:data, callback:"window.parent.global.loginDailog.callbackRegisterSuccess", url:opts.memberDomain+"/register"
					}
					), !1
				}
				),
				stack.run();
				return
			}
			data.registerfrom="anjuke_mobile",
			data.regtype="phone",
			data.tel=USERNAME.dom.val(),
			data.password=PWD.dom.val(),
			data.getcod=J.g("b_tel").s("input").eq(0).val(),
			stack.push(function() {
				return J.get( {
					type:"jsonp", url:opts.userDomain+"/register", data: {
						chktype: "mobile", phone:USERNAME.dom.val(), r:Math.random()
					}
					, callback:"global.loginDailog."+funName
				}
				), !1
			}
			),
			stack.push(function(e) {
				var t=J.g("iptUserName"), n=J.g("info_userName");
				return e.result=="normal"?(n.html('\u60a8\u7684\u624b\u673a\u5df2\u88ab\u6ce8\u518c\uff0c<a href="'+e.url+'">\u70b9\u51fb\u627e\u56de\u5bc6\u7801</a>').show(), t.next().hide(), !1): e.result=="broker"?(n.html('\u60a8\u5df2\u6ce8\u518c\u7ecf\u7eaa\u4eba\u5e10\u53f7\uff0c<a href="'+e.url+'">\u70b9\u6b64\u767b\u5f55</a>').show(), !1):e.result=="error"?(n.html("\u624b\u673a\u683c\u5f0f\u4e0d\u6b63\u786e\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165").show(), !1):e.result=="success"?(t.next().show(), J.g("b_mail").show(), J.g("b_tel").show(), !0):!1
			}
			),
			stack.push(PWD.validate),
			stack.push(function() {
				var e=J.g("b_tel").s("input").eq(0);
				return e.val()?(J.get( {
					type:"jsonp", url:opts.userDomain+"/register", data: {
						chktype: "checkVerifyCode", _r:Math.random(), verifycode:e.val(), referer:opts.url, phone:J.g("iptUserName").val()
					}
					, callback:"global.loginDailog."+funName
				}
				), !1):(J.g("b_tel").s(".v_error").eq(0).html("\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801").show(), !1)
			}
			),
			stack.push(function(e) {
				var t=J.g("b_tel").s(".v_error").eq(0);
				return e.result=="nocode"?(t.html("\u8bf7\u83b7\u53d6\u9a8c\u8bc1\u7801").show(), !1): e.result=="success"?!0:(t.html("\u9a8c\u8bc1\u7801\u4e0d\u6b63\u786e").show(), !1)
			}
			),
			stack.push(AGREEMENT.validate),
			stack.push(function() {
				return postJSONP( {
					type: "jsonp", data:data, callback:"window.parent.global.loginDailog.callbackRegisterSuccess", url:opts.memberDomain+"/register"
				}
				), !1
			}
			),
			stack.run();
			return
		}
		function getPosition(e, t) {
			var n= {
				x: 0, y:0
			}
			,
			r=e.currentStyle||document.defaultView.getComputedStyle(e, null);
			if(!t)r.position=="absolute"?(n.x=e.offsetLeft-(parseInt(r.marginLeft)||0), n.y=e.offsetTop-(parseInt(r.marginTop)||0)):r.position=="relative"&&(n.x=parseInt(r.left)||0, n.y=parseInt(r.top)||0);
			else {
				for(var i=e;
				i.offsetParent&&i!=t;
				i=i.offsetParent)n.x+=i.offsetLeft,
				n.y+=i.offsetTop;
				r.position=="static"&&e.currentStyle&&(n.x+=(parseInt(document.body.currentStyle.marginLeft)||0)*2, n.y+=(parseInt(document.body.currentStyle.marginTop)||0)*2)
			}
			return n
		}
		function UserName() {
			function l(t) {
				var n=t||eleUseName.val();
				return submitType=null,
				n?i.test(n)?(submitType="tel", J.g("b_tel").hide(), J.g("b_mail").show(), global.loginDailog.callbackTelValidate=h, !0): s.test(n)?(e.next().show(), submitType="mail", J.g("b_mail").show(), global.loginDailog.callbackMailValidate=c, !0):(VERIFICATION=null, r.html("\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u90ae\u7bb1\u6216\u624b\u673a\u53f7\u683c\u5f0f"), r.show(), !1):(VERIFICATION=null, r.html("\u8bf7\u8f93\u5165\u90ae\u7bb1\u6216\u624b\u673a\u53f7"), r.show(), !1)
			}
			function c(t) {
				return t.result=="norepeat_email"?(submitType="mail", e.next().show(), r.hide(), !0): t.result=="repeat_email"?(e.next().hide(), r.html("\u8be5\u90ae\u7bb1\u5df2\u6ce8\u518c\uff0c<a href="+opts.userDomain+"/my/login"+">\u70b9\u51fb\u767b\u5f55</a>"), r.show(), !1):(r.html("\u8f93\u5165\u5185\u5bb9\u683c\u5f0f\u6709\u8bef"), r.show(), !1)
			}
			function h(t) {
				var n=J.g("b_tel").s(".v_error").eq(0);
				n.hide().html("\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801");
				if(t.result=="normal")return r.html('\u60a8\u7684\u624b\u673a\u5df2\u88ab\u6ce8\u518c\uff0c<a href="'+t.url+'">\u70b9\u51fb\u627e\u56de\u5bc6\u7801</a>').show(),
				e.next().hide(),
				!1;
				if(t.result=="broker")return r.html('\u60a8\u5df2\u6ce8\u518c\u7ecf\u7eaa\u4eba\u5e10\u53f7\uff0c<a href="'+t.url+'">\u70b9\u6b64\u767b\u5f55</a>').show(),
				!1;
				if(t.result=="error")return r.html("\u624b\u673a\u683c\u5f0f\u4e0d\u6b63\u786e\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165").show(),
				!1;
				t.result=="success"&&(submitType="tel", r.html("\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u90ae\u7bb1\u6216\u624b\u673a\u53f7\u683c\u5f0f").hide(), e.next().show())
			}
			var e=eleUseName,
			t,
			n,
			r=J.g("info_userName").hide(),
			i=/^1[3|4|5|8][0-9]\d {
				4,
				8
			}
			$/,
			s=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9] {
				2, 4
			}
			)+$/,
			o=!1,
			u=!1,
			a="";
			e.autocomplete( {
				url:"", tpl:"autocomplete_ajk", width:"198", offset: {
					x: 65, y:0
				}
				, autoSubmit:!1, offsetTarget:J.g("body"), boxTarget:function() {
					return e.up(0)
				}
				, forceClear:!1, source:function(e, t) {
					var n=[ {
						mail: "@qq.com"
					}
					, {
						mail: "@163.com"
					}
					, {
						mail: "@126.com"
					}
					, {
						mail: "@hotmail.com"
					}
					, {
						mail: "@gmail.com"
					}
					, {
						mail: "@263.com"
					}
					, {
						mail: "@sina.com"
					}
					, {
						mail: "@sohu.com"
					}
					];
					/^\d+$/.test(e.userName)&&n.unshift( {
						mail: ""
					}
					), t(n)
				}
				, dataMap:function(e) {
					return e.l=e.mail, e.v=e.mail, e
				}
				, itemBuild:function(e) {
					var t=e.l, n=eleUseName.val(), r=n.indexOf("@");
					if(r>-1) {
						var i=n.substr(r+1), s=new RegExp("@"+i);
						if(!s.test(t))return {
							l: "", v:""
						}
						;
						n=n.replace(/@.*/g, "")
					}
					return {
						l: n+t, v:n+e.v
					}
				}
				, onFocus:function(t) {
					e.next().hide(), r.hide(), eleUseName.addClass("green_clolr")
				}
				, onBlur:function(t) {
					var n=e.val()!=a;
					a=n?e.val():a, J.on(document, "click", function() {
						l(), submitType=="mail"&&(J.g("b_mail").show(), J.g("b_tel").hide(), global.loginDailog.callbackMailValidate=c, J.get( {
							type:"jsonp", url:opts.userDomain+"/register", data: {
								chktype: "email", email:e.val(), r:Math.random()
							}
							, callback:"global.loginDailog.callbackMailValidate"
						}
						)), submitType=="tel"&&(J.g("b_mail").show(), J.get( {
							type:"jsonp", url:opts.userDomain+"/register", data: {
								chktype: "mobile", phone:e.val(), r:Math.random()
							}
							, callback:"global.loginDailog.callbackTelValidate"
						}
						)), J.un(document, "click", arguments.callee)
					}
					)
				}
				, onForceClear:function() {}
				, onSelect:function(t) {
					eleUseName.val(t.l);
					var n=e.val()!=a;
					a=n?e.val(): a, l(t.l);
					if(submitType=="mail") {
						var r=J.g("b_mail");
						r.hide(), J.g("b_tel").hide(), r.s(".v_error").eq(0).hide(), r.s("label").eq(0).html("\u9a8c\u8bc1\u7801\uff1a"), global.loginDailog.callbackMailValidate=c, J.get( {
							type:"jsonp", url:opts.userDomain+"/register", data: {
								chktype: "email", email:t.l, r:Math.random()
							}
							, callback:"global.loginDailog.callbackMailValidate"
						}
						)
					}
					n&&submitType=="tel"&&(J.g("b_tel").show(), J.get( {
						type:"jsonp", url:opts.userDomain+"/register", data: {
							chktype: "mobile", phone:t.l, r:Math.random()
						}
						, callback:"global.loginDailog.callbackTelValidate"
					}
					))
				}
				, onResult:function(e, t) {
					return
				}
			}
			);
			var f=getPosition(e.get());
			return {
				validate: l, success:t, dom:e, dom_info:r
			}
		}
		function PassWord() {
			function r() {
				var r=t.val();
				return r?r.length<6?(n.html("\u5bc6\u7801\u592a\u77ed\uff0c\u81f3\u5c11\uff16\u4e2a\u5b57\u7b26"), n.show(), !1): e.test(r)?r.length>32?(n.html("\u5bc6\u7801\u592a\u957f\uff0c\u6700\u591a32\u4e2a\u5b57\u7b26"), n.show(), !1):(t.next().show(), !0):(n.html("\u8bf7\u4e0d\u8981\u4f7f\u7528< \u201c > \u2018 &\u7b49\u5b57\u7b26\u548c\u7a7a\u683c"), n.show(), !1):(n.html("\u8bf7\u8f93\u5165\u5bc6\u7801").show(), !1)
			}
			var e=/^\s*[.A-Za-z0-9_-]+\s*$/,
			t=J.g("iptPassWord"),
			n=J.g("info_PassWord");
			return t.on("blur", r).on("focus", function() {
				n.hide(), t.next().hide()
			}
			),
			{
				dom: t, dom_info:n, validate:r
			}
		}
		function ImgCode() {
			function i(n) {
				var i=parseInt(n.code),
				s=n.msg;
				200===i?(t.html(""), t.hide(), e.next().next().next().show(), "tel"===submitType&&r.show()): 201===i&&(t.attr("class", "v_error"), t.html(s), r.hide()), t.show()
			}
			var e=J.g("verify_pic"),
			t=J.g("b_mail").s(".v_error").eq(0),
			n=J.g("b_mail"),
			r=J.g("b_tel");
			e.on("blur", function() {
				e.val().length>0?(t.hide(), J.get( {
					type:"jsonp", url:opts.memberDomain+"/checkcaptcha/", data: {
						captcha: J.g("b_mail").s("input").eq(0).val(), callback:"global.loginDailog.verifyCaptcha"
					}
				}
				)):(t.attr("class", "v_error"), t.html("\u9a8c\u8bc1\u7801\u4e0d\u80fd\u4e3a\u7a7a"), t.show())
			}
			),
			global.loginDailog.verifyCaptcha=i
		}
		function Agreement() {
			function n() {
				return e.get().checked?(t.hide(), !0): (t.show(), !1)
			}
			var e=J.g("ipt_ckb"),
			t=J.g("info_agg");
			return e.on("click", n),
			{
				dom: e, dom_info:t, validate:n
			}
		}
		function MailAuthCode() {
			function i() {
				t.attr("src", opts.imgMailCode.replace(/(?: r=).*/, "r="+Math.random()))
			}
			function s() {
				var e=n.val();
				if(!e) {
					r.html("\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801").show();
					return
				}
			}
			function o(e) {
				e.result=="success"?r.hide(): e.result=="fail"?(r.html("\u9a8c\u8bc1\u7801\u9519\u8bef").show(), i()):(r.html("\u672a\u77e5\u9519\u8bef").show(), i())
			}
			var e=cRegister.s(".li_code").eq(0),
			t=e.s("img").eq(0),
			n=e.s("input").eq(0),
			r=e.s(".v_error");
			return t.un("click", i).on("click", i),
			t.next().un("click", i).on("click", i),
			n.un("blur", s).on("blur", s),
			n.on("focus", function() {
				r.hide()
			}
			),
			{
				dom: n, dom_info:r, validate:s, changeIMG:i
			}
		}
		function TelAuthCode() {
			function r() {
				t.hide()
			}
			function i() {
				if(!e.val()) {
					t.html("\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801").show();
					return
				}
				global.loginDailog.verifyCodeTel=function(e) {
					if(e.result=="nocode") {
						t.html("\u8bf7\u83b7\u53d6\u9a8c\u8bc1\u7801").show();
						return
					}
					if(e.result=="success")return;
					t.html("\u9a8c\u8bc1\u7801\u4e0d\u6b63\u786e").show()
				}
				,
				J.get( {
					type:"jsonp", url:opts.userDomain+"/register", data: {
						chktype: "checkVerifyCode", _r:Math.random(), verifycode:e.val(), referer:opts.url, phone:J.g("iptUserName").val()
					}
					, callback:"global.loginDailog.verifyCodeTel"
				}
				),
				t.hide()
			}
			function s() {
				global.loginDailog.sendVerifyCodeTel=function(e) {
					var r=J.g("b_mail");
					r.s(".v_error").eq(0).hide();
					if(e.result=="success") {
						var i=60;
						n.val(i+"\u79d2\u540e\u53ef\u91cd\u65b0\u53d1\u9001"),
						n.get().disabled=!0;
						var s=setInterval(function() {
							if(i==1) {
								n.val("\u83b7\u53d6\u9a8c\u8bc1\u7801"), n.get().disabled=!1, clearInterval(s);
								return
							}
							i--, n.val(i+"\u79d2\u540e\u91cd\u65b0\u83b7\u53d6\u9a8c\u8bc1\u7801")
						}
						, 1e3)
					}
					else e.result=="nophone"?t.html("\u8bf7\u8f93\u5165\u624b\u673a\u53f7\u7801").show():e.result=="error"&&e.code==-1?(J.site.trackEvent("over_verify_d"), r.s("label").eq(0).html("\u6821\u9a8c\u7801\uff1a"), r.s(".v_error").eq(0).html("\u6821\u9a8c\u7801\u4e0d\u80fd\u4e3a\u7a7a").show(), r.show()):e.result=="error"&&e.code==-2?(J.site.trackEvent("over_verify_d"), r.s("label").eq(0).html("\u6821\u9a8c\u7801\uff1a"), r.s(".v_error").eq(0).html("\u6821\u9a8c\u7801\u6709\u8bef").show(), r.s("a").eq(0).get().click(), r.show()):t.html("\u9a8c\u8bc1\u7801\u5230\u8fbe\u4e0a\u9650").show()
				}
				,
				J.get( {
					type:"jsonp", url:opts.userDomain+"/register", data: {
						chktype: "verifyformat", r:Math.random(), phone:J.g("iptUserName").val(), referer:opts.history, captcha_user_id:J.getCookie("ajk_member_captcha"), code:J.g("b_mail").s("input").eq(0).val()
					}
					, callback:"global.loginDailog.sendVerifyCodeTel"
				}
				)
			}
			var e=J.g("b_tel").s("input").eq(0),
			t=J.g("b_tel").s(".v_error").eq(0),
			n=J.g("b_tel").s(".cik_code").eq(0);
			return n.on("click", s),
			e.on("blur", i),
			e.un("focus", r).on("focus", r),
			{
				dom: e, dom_info:t, validate:i
			}
		}
		var eleUseName=J.g("iptUserName"),
		elePwd,
		eleVerification,
		USERNAME,
		PWD,
		AGREEMENT,
		VERIFICATION,
		MAIL=new MailAuthCode,
		TEL=new TelAuthCode,
		submitType,
		stack;
		return J.g("iptRegCodeImg").attr("src", opts.memberDomain+"/captcha?r="+Math.random()),
		function() {
			USERNAME=new UserName,
			PWD=new PassWord,
			IMGCODE=new ImgCode,
			AGREEMENT=new Agreement;
			var e=!1;
			BTN=cRegister.s(".btnLogin").eq(0),
			BTN.on("click", submitHandler)
		}
		(),
		{
			show: show
		}
	}
	var defOptions= {
		url: "http://shanghai.anjuke.com", memberDomain:"http://member.anjuke.com", userDomain:"http://user.anjuke.com", QQ:"http://member.anjuke.com", weibo:"http://member.anjuke.com", base64UrlLogin:"aHR0cDovL3NoYW5naGFpLnJlbGVhc2UubHVuamlhbmcuZGV2LmFuanVrZS5jb20vYWNjb3VudC9sb2dpbnN1Y2Nlc3Mv", base64Register:"aHR0cDovL3NoYW5naGFpLnJlbGVhc2UubHVuamlhbmcuZGV2LmFuanVrZS5jb20vYWNjb3VudC9yZWdpc3RlcnN1Y2Nlc3Mv"
	}
	,
	opts= {}
	,
	optsData,
	objDialog,
	customEvent= {}
	,
	alwaysShowMail=!1,
	GUID,
	D=document,
	defData= {
		cityid: J.getCookie("ctid")||11, email:"", formhash:"3bd8bc0a", from_register_page:"ok", key:"", keytime:"", location:"", url:"", referer:"index.php", reg:"0", register:1, registerfrom:"anjuke_email", remember:0, service_term:1, sid:"anjuke", time:1411111, uid:"", useraction:"1", usertype:1, utype:1
	}
	;
	(function() {
		opts=J.mix(defOptions, option), opts.validateSuccessMail=opts.memberDomain+"/member/1.0/code", opts.imgMailCode=opts.memberDomain+"/captcha?r="+Math.random(), optsData=J.mix(defData, regster_data), function() {}
		.require([], ["ui.panel_login"], !0)
	}
	)();
	var html,
	tabLogin,
	tabRegister,
	LOGIN,
	REGISTER,
	isLogin,
	isRegister,
	cLogin,
	cRegister;
	return {
		showLogin: showLogin, showRegister:showRegister, close:close
	}
}

(function(e) {
	function V(e, t) {
		var n=0, r, i=e.length, s=i===w, o=!0;
		if(s) {
			for(r in e)if(t.call(e[r], r, e[r])===!1) {
				o=!1;
				break
			}
		}
		else for(;
		n<i;
		)if(t.call(e[n], n, e[n++])===!1) {
			o=!1;
			break
		}
		return o
	}
	function $(e) {
		return e===null?String(e): I[Object.prototype.toString.call(e)]||w
	}
	function J() {
		if(D)return;
		D=1;
		if(A===j)return Q();
		if(m[S])m[S](C, function() {
			m[x](C, arguments.callee, 0), Q()
		}
		, 0), e[S](O, function() {
			e[x](O, arguments.callee, 0), Q(1)
		}
		, 0);
		else if(F) {
			F(k, function() {
				A===j&&(m[N](k, arguments.callee), Q())
			}
			), e[T](M, function() {
				e[N](M, arguments.callee), Q(1)
			}
			);
			var t=!1;
			try {
				t=null==e.frameElement
			}
			catch(n) {}
			y.doScroll&&t&&function() {
				if(_)return;
				try {
					y.doScroll("left")
				}
				catch(e) {
					return P(arguments.callee, 1)
				}
				Q()
			}
			()
		}
	}
	function K(e) {
		J(), _?e.call(): h.push(e)
	}
	function Q(e) {
		e&&(l.PL=it());
		if(!_) {
			if(!m.body)return P(Q, 1);
			_=1, l.CL=it();
			if(h) {
				var t, n=0;
				while(t=h[n++])t.call();
				h=null
			}
			return 0
		}
	}
	function G(e, t, n) {
		var r;
		q.isFunction(t)&&(n=t), t=/\.(js|css)/g.exec(e.toLowerCase()), t=t?t[1]: z;
		if(z===t)r=m.createElement("script"), r.type="text/javascript", r.src=e, r.async="true", r.charset=B.c;
		else if(W===t) {
			r=m.createElement("link"), r.type="text/css", r.rel="stylesheet", r.href=e, g.appendChild(r);
			return
		}
		r.onload=r[k]=function() {
			var e=this[L];
			if(!e||"loaded"===e||A===e)n&&n(), r.onload=r[k]=null
		}
		, g.appendChild(r)
	}
	function Y(e, t) {
		return t||(t=z), B[t==z?"u": "s"]+e.join(B.m)+B.m+B.v+"."+t
	}
	function Z(e, t) {
		if(t==W)return tt(e, v)>-1;
		var n=e.split("."), r=n.length, i=f[n[0]];
		return r===1&&i?!0: r===2&&i&&i[n[1]]?!0:!1
	}
	function et(e, t) {
		var n=e.length, r=[], i=[], s, o;
		while(n--)o=e[n], /^\w+$/.test(o)&&r.push(o);
		n=e.length;
		while(n--)o=e[n], (s=o.match(/^(\w+)\.\w+$/))&&tt(s[1], r)!=-1&&e.splice(n, 1);
		n=e.length;
		while(n--)o=e[n], tt(o, i)==-1&&(t==W||!Z(o, t))&&i.push(o);
		return i.sort()
	}
	function tt(e, t) {
		var n=0, r;
		if(t) {
			r=t.length;
			for(;
			n<r;
			n++)if(t[n]===e)return n
		}
		return-1
	}
	function nt(e, t, n, r) {
		var i, s=[], o=[], u=0, a;
		n!=z&&n!=W&&(r=n, n=z), a=n==z;
		if(q.isArray(e))while(i=e[u++])(a?s: o).push(i);
		else q.isString(e)&&(a?s: o).push(e);
		s=et(a?s: o, n);
		if(q.isNumber(r))K(function() {
			var e, r=[], i=0;
			while((e=s[i++])&&!Z(e, n))r.push(e);
			r.length?G(Y(r, n), n, t): t&&t.call()
		}
		.delay(r));
		else if(!_&&!r) {
			u=0;
			while(i=s[u++])(a?d: v).push(i);
			t&&p.push(t)
		}
		else s.length?G(Y(s, n), n, t):t&&t.call()
	}
	function rt(e, t) {
		var n=m.createTextNode(e), r;
		if(t||!(r=m.getElementsByTagName("style")[0]))g.appendChild(r=m.createElement("style")), r.type="text/css";
		return r.styleSheet?r.styleSheet.cssText+=n.nodeValue: r.appendChild(n), r
	}
	function it() {
		return+(new Date)
	}
	function st() {
		function r(e, t) {
			return(t||"")+(q.isString(e)?e+": ": "")
		}
		function i(e, t) {
			var n=[];
			return t=t||"", V(e, function(e, o) {
				q.isObject(o)?n.push(r(q.isNumber(e)?"Object": e, t)+"{\n"+i(o, t+"    ")+"\n"+t+"}"):q.isFunction(o)?n.push(r(e, t)+s(o)):n.push(r(e, t)+o)
			}
			), n.join("\n")
		}
		function s(e) {
			return(e=e.toString().match(/^(.*)[\S\s]*\ {
				/))?e[1]: ""
			}
			var e=o.call(arguments), t;
			try {
				t=console
			}
			catch(n) {
				t=0
			}
			t&&t.log?t.log.apply(t, e):alert(i(e))
		}
		var t=+(new Date), n=e.PAGESTART||t, r="hasOwnProperty", i=function(e, t, n) {
			if(n) {
				var i= {}
				;
				for(var s in e)e[r](s)&&(i[s]=e[s]);
				for(var s in t)t[r](s)&&(i[s]=t[s]);
				return i
			}
			for(var o in t)t[r](o)&&(e[o]=t[o]);
			return e
		}
		, s= {}
		, o=Array.prototype.slice, u="//include.anjukestatic.com/usjs/", a="//include.anjukestatic.com/uscss/", f= {}
		, l= {
			PS: n, BS:t, CL:n
		}
		, c="126d15a9a199af25ba4ac04f2280c373", h=[], p=[], d=[], v=[], m=e.document, g=m.getElementsByTagName("head")[0], y=m.documentElement, b=arguments, w=b[2], E=b[1].split(","), S=E[0], x=E[1], T=E[2], N=E[3], C=E[4], k=E[5], L=E[6], A=E[7], O=E[8], M="on"+O, _=0, D=0, P=e.setTimeout, H=e.setInterval, B= {
			v: c, u:u, m:"/", c:"utf-8", s:a
		}
		, j=m[L], F=m[T], I= {}
		, q= {}
		, R=navigator.userAgent, U=RegExp, z="js", W="css", X= {
			aL: S, W:e, D:m, St:P, Si:H
		}
		;
		(function() {
			V("Boolean Number String Function Array Date RegExp Object".split(" "), function(e, t) {
				var n=t.toLowerCase();
				I["[object "+t+"]"]=n, q["is"+t]=function(e) {
					return $(e)===n
				}
			}
			), q.isWindow=function(e) {
				return e&&e==e.window
			}
			, q.isUndefined=function(e) {
				return e===w
			}
		}
		)(), i(s, {
			mix:i, add:function(e, t) {
				if(q.isFunction(t)) {
					f[e]=t;
					return
				}
				var n= {}
				;
				return f.mix(n, t), f.mix(f[e]=f[e]|| {}
				, n)
			}
			, ua: {
				ua: R, chrome:/chrome\/(\d+\.\d+)/i.test(R)?+U.$1:w, firefox:/firefox\/(\d+\.\d+)/i.test(R)?+U.$1:w, ie:/msie (\d+\.\d+)/i.test(R)?m.documentMode||+U.$1:w, opera:/opera(\/|)(\d+(\.\d+)?)(.+?(version\/(\d+(\.\d+)?)))?/i.test(R)?+(U.$6||U.$2):w, safari:/(\d+\.\d)?(?:\.\d)?\s+safari\/?(\d+\.\d+)?/i.test(R)&&!/chrome/i.test(R)?+(U.$1||U.$2):w
			}
		}
		), K(function() {
			function t() {
				var e, t=0;
				while(e=p[t++])e.call();
				d=p=null
			}
			var e=et(d, z);
			e.length?(G(Y(e, z), z, t), e=[]):t(), e=et(v, W), e.length&&(G(Y(e, W), W), v=[])
		}
		), Function.prototype.ready=function() {
			K.call(f, this)
		}
		, Function.prototype.require=function() {
			var e=arguments, t=o.call(e), n=t[1];
			(q.isArray(n)||q.isString(n))&&(nt.apply(f, [].concat([n], [null, W], o.call(e, 2))), t.splice(1, 1)), t.splice(1, 0, this, z), nt.apply(f, t)
		}
		, Function.prototype.delay=function(e) {
			var t=this, n=o.call(arguments, 1);
			P(function() {
				return t.apply(t, n)
			}
			, e||0)
		}
		, f.base=i(s, {
			ready: K, finish:Q, load:G, use:nt, rules:rt, each:V, type:$, getTime:it, times:l, slice:o, log:st
		}
		), f.data= {}
		, f.undef=w, i(f, s), i(f, q), i(f, X), e.J=f
	}
	)(window, "addEventListener,removeEventListener,attachEvent,detachEvent,DOMContentLoaded,onreadystatechange,readyState,complete,load", undefined),
	function(J) {
		function p() {
			return h
		}
		function d(e, t) {
			if(J.isString(e)) {
				if(t)return h=[e];
				h.push(e)
			}
			else if(J.isArray(e)) {
				if(t)return h=e;
				h=h.concat(e)
			}
		}
		function v(e, t) {
			var n=m(e, t);
			if(J.each(p(), function(e, t) {
				if((new RegExp(t, "g")).test(n))return false;
				else {}
			}
			)==0)return;
			var r="?tp=error&site="+f+"&v="+(J.W.PHPVERSION||"")+"&msg="+n;
			(new Image).src=o+r,
			c.onError&&c.onError(n)
		}
		function m(e, t) {
			t=t?"Custom:"+t+",": "";
			if(J.isString(e))return t+e;
			var n=[];
			return J.each(["name", "message", "description", "url", "stack", "fileName", "lineNumber", "number", "line"], function(t, r) {
				r in e&&(r=="stack"?n.push(r+":"+l(e[r].split(/\n/)[0])): n.push(r+":"+l(e[r])))
			}
			),
			t+n.join(",")
		}
		var e=".anjuke",
		t="soj.dev.aifang",
		n=".com",
		r=J.D.location.host,
		i=location.protocol+"//",
		s=/dev|test/.test(r),
		o=i+(s?t+n:"m"+e+n)+"/ts.html",
		u=i+(s?t+n:"s"+e+n)+"/stb",
		a=r.match(/^(\w+)\.(\w+)\./),
		f=/iPad/.test(J.ua.ua)?"pad":a?a[1]==="m"?"touch":a[2]==="fang"?"fang":"pc":"unknown",
		l=encodeURIComponent;
		J.add("logger", {
			site: f, logUrl:o, sojUrl:u, isDev:s, autoLogger:!0, onError:null, log:v, setBackList:d
		}
		);
		var c=J.logger,
		h=["Player",
		"baiduboxapphomepagetag",
		"onTouchMoveInPage"];
		J.W.onerror=function(e, t, n) {
			J.logger.autoLogger&&v( {
				message: e, url:t, line:n
			}
			)
		}
	}
	(J);
	try {
		var cl=console;
		cl&&cl.log&&(cl.log("%c\u8def\u6709\u591a\u8fdc\uff0c\u53ea\u6709\u5fc3\u77e5\u9053\uff0c\n\u6700\u7f8e\u7684\u65c5\u7a0b\uff0c\u662f\u4e0d\u65ad\u7684\u7ecf\u5386\uff0c\n\u575a\u6301\u8d70\u4e0b\u53bb\uff0c\u4e0e\u68a6\u60f3\u8005\u540c\u884c\uff01\n", "color:#f60"), cl.log("\u8bf7\u5c06\u7b80\u5386\u53d1\u9001\u81f3%c hanjunfeng@anjuke.com\uff08 \u90ae\u4ef6\u6807\u9898\uff1a\u201c\u59d3\u540d-\u5e94\u8058XX\u804c\u4f4d-\u6765\u81eaconsole\u201d \uff09\n\n", "color:red"))
	}
	catch(e) {}
	(function(J) {
		var e=J.W, t=J.D, n=J.logger, r;
		n.Tracker=function(r, i, s) {
			function f() {
				var n= {
					p:o.page, h:o.href||t.location.href, r:o.referrer||t.referrer||"", sc:o.screen||'{"w":"'+e.screen.width+'"'+',"h":"'+e.screen.height+'"'+',"r":"'+(e.devicePixelRatio>=2?1: 0)+'"'+"}", site:o.site||"", guid:u(o.nGuid||"aQQ_ajkguid")||"", ctid:u(o.nCtid||"ctid")||"", luid:u(o.nLiu||"lui")||"", ssid:u(o.nSessid||"sessid")||"", uid:s||u(o.nUid||"ajk_member_id")||"0", t:+(new Date)
				}
				;
				return o.method&&(n.m=o.method), o.cst&&/[0-9] {
					13
				}
				/.test(o.cst)&&(n.lt=n.t-parseInt(o.cst)), o.pageName&&(n.pn=o.pageName), o.customParam&&(n.cp=o.customParam), n
			}
			function l(e) {
				var t=f(), r=e||n.sojUrl;
				try {
					if(!o.sendType) {
						var i=r+(r.indexOf("?")>-1?"": "?")+c(t);
						o.sendType=i.length<2e3?"get": "post"
					}
					if(o.sendType==="get") {
						var s=document.createElement("script");
						s.src=i||r+"?"+c(t), s.async=!0;
						var u=document.getElementsByTagName("head")[0]||document.getElementsByTagName("body")[0];
						s.onload=function() {
							u.removeChild(s)
						}
						, u.appendChild(s)
					}
					else J.post( {
						url: r, type:"jsonp", data:t
					}
					)
				}
				catch(a) {
					n.log(a, "TrackError")
				}
			}
			function c(e) {
				function r(e, r) {
					t[t.length]=n(e)+"="+n(r)
				}
				var t=[], n=encodeURIComponent;
				for(var i in e)r(i, e[i]);
				return t.join("&").replace(/%20/g, "+")
			}
			var o= {}
			, u=J.getCookie, a= {
				track: l
			}
			;
			return r&&(o.site=r), i&&(o.page=i), o.referrer=t.referrer||"", J.each("Site Page PageName Referrer Uid Method NGuid NCtid NLiu NSessid NUid Cst CustomParam SendType Screen Href".split(" "), function(e, t) {
				var n=t.substring(0, 1).toLowerCase()+t.substring(1);
				a["set"+t]=function(e) {
					o[n]=e
				}
			}
			), a
		}
		, n.trackEvent=function(e) {
			r=r||new n.Tracker, r.setSendType("get"), r.setSite(e.site), e.page&&r.setPage(e.page), e.href&&r.setHref(e.href), e.page&&r.setPageName(e.page), e.referrer&&r.setReferrer(e.referrer), e.customparam?r.setCustomParam(e.customparam): r.setCustomParam(""), r.track()
		}
	}
	)(J),
	String.prototype.trim=function() {
		return this.replace(/(^[\s\t\xa0\u3000]+)|([\u3000\xa0\s\t]+$)/g, "")
	}
	,
	function(J, e, t) {
		function i(e) {
			e=e||0;
			var t=this[e===-1?this.length-1: e];
			return t?o(t): a()
		}
		function s(e) {
			var t=0,
			n=this.length;
			for(;
			t<n;
			)if(e.call(o(this[t]), t, o(this[t++]))===!1)break;
			return this
		}
		function o(e) {
			var t=new l(e);
			return!t.length&&(t=a(t)),
			t
		}
		function u(e, t) {
			var n=new N(e, t);
			return(n.length?f: a)(n)
		}
		function a(e) {
			e=e&&e.length>0?e: new l;
			for(var t in r)t!=="length"&&t!=="get"&&t!=="val"&&t!=="html"&&t!=="attr"&&t!=="hasClass"&&(e[t]=function() {
				return e
			}
			);
			return e
		}
		function f(e) {
			for(var t in r)(function(t) {
				t!=="length"&&t!=="get"&&t!=="eq"&&t!=="s"&&t!=="each"&&(e[t]=function() {
					var r=0, i=e.length, s=n, u=!1;
					for(;
					r<i;
					)s=o(e[r])[t].apply(e[r++], arguments), s&&(u=s);
					return u||t==="hasClass"?u: e
				}
				)
			}
			)(t);
			return e
		}
		function l(e) {
			var n=e;
			if(e==="body"&&t.body)return this[0]=t.body,
			this.length=1,
			this.selector=n,
			this;
			if(e instanceof l)return e;
			if(e=e&&e.nodeType?e: t.getElementById(e))this[0]=e, this.length=1;
			return this.selector=n,
			this
		}
		function w(e) {
			return J.isString(e)?p(e): e
		}
		function E(e, t, n) {
			for(var r=e.get()[n];
			r;
			r=r[t])if(r.nodeType==1)return o(r)
		}
		function S(e, t, n) {
			for(var r=e.get()[n];
			r;
			r=r[t])if(r.nodeType==1)return o(r);
			return a(e)
		}
		function x(e) {
			var t=e.get();
			if(e.visible())return {
				width: t.offsetWidth, height:t.offsetHeight
			}
			;
			var n=t.style,
			r,
			i,
			s= {
				visibility: n.visibility, position:n.position, display:n.display
			}
			;
			return r= {
				visibility: "hidden", display:"block"
			}
			,
			s.position!=="fixed"&&(r.position="absolute"),
			e.setStyle(r),
			i= {
				width: t.offsetWidth, height:t.offsetHeight
			}
			,
			e.setStyle(s),
			i
		}
		function T(e, n) {
			var r=t.createElement(e),
			i=p(r);
			return g(n)?i: i.attr(n)
		}
		function N(e, n) {
			this.selector=e;
			if(J.sizzle)return C(this, J.sizzle(e, n));
			var r=e?e.match(/^(\.)?([a-zA-Z0-9_-]+)(\s([a-zA-Z0-9_-]+))?/): null, i=[], s, o, u, a, f;
			n=n||t;
			if(r&&r[1]) {
				f=r[4]?r[4].toUpperCase(): "";
				if(n[h]) {
					u=n[h](r[2]),
					s=u.length;
					for(o=0;
					o<s;
					o++) {
						a=u[o];
						if(f&&a.tagName!=f)continue;
						i.push(a)
					}
				}
				else {
					var l=new RegExp("(^|\\s)"+r[2]+"(\\s|$)");
					u=f?n[c](f): n.all||n[c]("*"), s=u.length;
					for(o=0;
					o<s;
					o++)a=u[o],
					l.test(a.className)&&i.push(a)
				}
			}
			else i=n[c](e);
			return C(this, i)
		}
		function C(e, t) {
			var n=e.length,
			r,
			i=0;
			for(r=t.length;
			i<r;
			i++)e[n++]=o(t[i]);
			e.length=n
		}
		var n=J.undef,
		r= {
			show:function() {
				return this.get().style.display="",
				this
			}
			,
			hide:function() {
				return this.get().style.display="none",
				this
			}
			,
			visible:function() {
				return this.get().style.display!="none"
			}
			,
			remove:function() {
				var e=this.get();
				return e.parentNode&&e.parentNode.removeChild(e),
				this
			}
			,
			attr:function(e, t) {
				var r=this.get();
				if(!r)return arguments.length<=1?n: this;
				if("style"===e)return g(t)?r.style.cssText: (r.style.cssText=t, this);
				e=y[e]||e;
				if(J.isString(e)) {
					if(g(t))return r.getAttribute(e);
					t===null?this.removeAttr(e): r.setAttribute(e, t)
				}
				else for(var i in e)this.attr(i, e[i]);
				return this
			}
			,
			removeAttr:function(e) {
				return this.get().removeAttribute(e),
				this
			}
			,
			addClass:function(e) {
				var t=this.get();
				return this.hasClass(e)||(t.className+=(t.className?" ": "")+e), this
			}
			,
			removeClass:function(e) {
				var t=this.get();
				return t.className=t.className.replace(new RegExp("(^|\\s+)"+e+"(\\s+|$)"), " ").trim(),
				this
			}
			,
			hasClass:function(e) {
				var t=this.get();
				if(!t)return!1;
				var n=t.className;
				return n.length>0&&(n==e||(new RegExp("(^|\\s)"+e+"(\\s|$)")).test(n))
			}
			,
			getStyle:function(e) {
				var n=this.get(),
				r;
				e=e==d?v: e;
				var i=n.style[e];
				if(!i||i=="auto")J.ua.ie?r=n.currentStyle: r=t.defaultView.getComputedStyle(n, null), i=r?r[e]:null;
				return e==m?i?parseFloat(i): 1:i=="auto"?null:i
			}
			,
			setStyle:function(e, t) {
				var n=this.get(),
				r=n.style,
				i=arguments.length;
				i===2?r.cssText+=";"+e+":"+t: J.isString(e)&&(r.cssText+=";"+e, e.indexOf(m)>0&&this.setOpacity(e.match(/opacity:\s*(\d?\.?\d*)/)[1]));
				for(var s in e)s==m?this.setOpacity(e[s]): r[s==d||s==v?r.styleFloat?"styleFloat":v:s]=e[s];
				return this
			}
			,
			getOpacity:function() {
				return this.getStyle(m)
			}
			,
			setOpacity:function(e) {
				return this.get().style.opacity=e==1||e===""?"": e<1e-5?0:e, this
			}
			,
			append:function(e) {
				return this.get().appendChild(e.nodeType===1?e: e.get()), this
			}
			,
			appendTo:function(e) {
				return o(e).append(this.get()),
				this
			}
			,
			html:function(e) {
				var t=this.get(),
				r=arguments.length;
				return t?r>0?e&&e.nodeType===1?this.append(e): (t.innerHTML=e, this):t.innerHTML:r===0?n:this
			}
			,
			val:function(e) {
				var t=this.get(),
				r=arguments.length,
				i;
				return t?(i=b[t.tagName.toLowerCase()||t.type], i=i?i(t, e): n, r===0?i:this):r===0?n:this
			}
			,
			s:function(e) {
				return u(e, this.get())
			}
			,
			get:function(e) {
				var e=e||0,
				t=this[e];
				return t
			}
			,
			width:function() {
				return x(this).width
			}
			,
			height:function() {
				return x(this).height
			}
			,
			offset:function() {
				var e=this.get();
				e&&J.isUndefined(e.offsetLeft)&&(e=e.parentNode);
				var t=function(e) {
					var t= {
						x: 0, y:0
					}
					;
					while(e)t.x+=e.offsetLeft,
					t.y+=e.offsetTop,
					e=e.offsetParent;
					return t
				}
				(e);
				return {
					x: t.x, y:t.y
				}
			}
			,
			insertAfter:function(e) {
				var t=this.get(),
				n=t.parentNode;
				return n&&n.insertBefore(e.nodeType===1?e: e.get(), t.nextSibling), this
			}
			,
			insertBefore:function(e) {
				var t=this.get(),
				n=t.parentNode;
				return n&&n.insertBefore(e.nodeType===1?e: e.get(), t), this
			}
			,
			insertFirst:function(e) {
				var t=this.first(!0);
				return t?t.insertBefore(e): this.append(e), this
			}
			,
			insertFirstTo:function(e) {
				return w(e).insertFirst(this.get()),
				this
			}
			,
			insertLast:function(e) {
				return this.append(e)
			}
			,
			first:function(e) {
				return e?E(this, "nextSibling", "firstChild"): S(this, "nextSibling", "firstChild")
			}
			,
			last:function(e) {
				return e?E(this, "previousSibling", "lastChild"): S(this, "previousSibling", "lastChild")
			}
			,
			next:function(e) {
				return e?E(this, "nextSibling", "nextSibling"): S(this, "nextSibling", "nextSibling")
			}
			,
			prev:function(e) {
				return e?E(this, "previousSibling", "previousSibling"): S(this, "previousSibling", "previousSibling")
			}
			,
			up:function(e) {
				var t=this.get();
				if(arguments.length==0)return p(t.parentNode);
				var n=0,
				r=J.isNumber(e),
				i;
				r||(i=e.match(/^(\.)?(\w+)$/));
				while(t=t.parentNode) {
					if(t.nodeType==1) {
						if(r&&n==e)return o(t);
						if(i&&(i[1]&&i[2]==t.className||i[2].toUpperCase()==t.tagName))return o(t)
					}
					n++
				}
				return a(this)
			}
			,
			down:function(e) {
				var t=this.get();
				return arguments.length===0||e===0?this.first(): J.isNumber(e)?u("*", t).eq(e):u(e, t)
			}
			,
			submit:function() {
				this.get().submit()
			}
			,
			eq:i,
			empty:function() {
				return this.html("")
			}
			,
			each:s,
			length:0,
			splice:[].splice
		}
		,
		c="getElementsByTagName",
		h="getElementsByClassName",
		p=o,
		d="float",
		v="cssFloat",
		m="opacity",
		g=J.isUndefined,
		y=function() {
			var e= {}
			;
			return J.ua.ie<8?(e["for"]="htmlFor", e["class"]="className"): (e.htmlFor="for", e.className="class"), e
		}
		(),
		b=function() {
			function e(e, r) {
				switch(e.type.toLowerCase()) {
					case"checkbox": case"radio":return t(e, r);
					default: return n(e, r)
				}
			}
			function t(e, t) {
				if(g(t))return e.checked?e.value: null;
				e.checked=!!t
			}
			function n(e, t) {
				if(g(t))return e.value;
				e.value=t
			}
			function r(e, t) {
				if(g(t))return i(e)
			}
			function i(e) {
				var t=e.selectedIndex;
				return t>=0?s(e.options[t]): null
			}
			function s(e) {
				return g(e.value)?e.text: e.value
			}
			return {
				input: e, textarea:n, select:r, button:n
			}
		}
		();
		l.prototype=r,
		J.mix(p, {
			dom: p, create:T, fn:r, s:u, g:o
		}
		),
		N.prototype= {
			each:s,
			s:function(e) {
				return u(e, this.eq().get())
			}
			,
			eq:i,
			length:0,
			splice:[].splice
		}
		,
		J.mix(J, {
			dom: p, create:T, s:u, g:o
		}
		)
	}
	(J, window, document),
	function(e, t, n) {
		function r(e, t, n, r) {
			var i=0,
			s=t.length;
			for(;
			i<s;
			i++)it(e, t[i], n, r)
		}
		function i(e, t, n, i, s, o) {
			var u,
			a=st.setFilters[t.toLowerCase()];
			return a||it.error(t),
			(e||!(u=s))&&r(e||"*", i, u=[], s),
			u.length>0?a(u, n, o): []
		}
		function s(e, t, s, o, u) {
			var a,
			f,
			l,
			c,
			h,
			p,
			d,
			v,
			m=0,
			g=u.length,
			y=X.POS,
			b=new RegExp("^"+y.source+"(?!"+N+")", "i"),
			w=function() {
				var e=1,
				t=arguments.length-2;
				for(;
				e<t;
				e++)arguments[e]===n&&(a[e]=n)
			}
			;
			for(;
			m<g;
			m++) {
				y.exec(""),
				e=u[m],
				c=[],
				l=0,
				h=o;
				while(a=y.exec(e)) {
					v=y.lastIndex=a.index+a[0].length;
					if(v>l) {
						d=e.slice(l, a.index),
						l=v,
						p=[t],
						H.test(d)&&(h&&(p=h), h=o);
						if(f=R.test(d))d=d.slice(0, -5).replace(H, "$&*");
						a.length>1&&a[0].replace(b, w),
						h=i(d, a[1], a[2], p, h, f)
					}
				}
				h?(c=c.concat(h), (d=e.slice(l))&&d!==")"?r(d, c, s, o):x.apply(s, c)):it(e, t, s, o)
			}
			return g===1?s:it.uniqueSort(s)
		}
		function o(e, t, n) {
			var r,
			i,
			s,
			o=[],
			u=0,
			a=j.exec(e),
			f=!a.pop()&&!a.pop(),
			l=f&&e.match(B)||[""],
			c=st.preFilter,
			h=st.filter,
			p=!n&&t!==m;
			for(;
			(i=l[u])!=null&&f;
			u++) {
				o.push(r=[]),
				p&&(i=" "+i);
				while(i) {
					f=!1;
					if(a=H.exec(i))i=i.slice(a[0].length),
					f=r.push( {
						part: a.pop().replace(P, " "), captures:a
					}
					);
					for(s in h)(a=X[s].exec(i))&&(!c[s]||(a=c[s](a, t, n)))&&(i=i.slice(a.shift().length), f=r.push( {
						part: s, captures:a
					}
					));
					if(!f)break
				}
			}
			return f||it.error(e),
			o
		}
		function u(e, t, n) {
			var r=t.dir,
			i=E++;
			return e||(e=function(e) {
				return e===n
			}
			),
			t.first?function(t, n) {
				while(t=t[r])if(t.nodeType===1)return e(t, n)&&t
			}
			:function(t, n) {
				var s,
				o=i+"."+h,
				u=o+"."+c;
				while(t=t[r])if(t.nodeType===1) {
					if((s=t[T])===u)return t.sizset;
					if(typeof s=="string"&&s.indexOf(o)===0) {
						if(t.sizset)return t
					}
					else {
						t[T]=u;
						if(e(t, n))return t.sizset=!0,
						t;
						t.sizset=!1
					}
				}
			}
		}
		function a(e, t) {
			return e?function(n, r) {
				var i=t(n, r);
				return i&&e(i===!0?n: i, r)
			}
			:t
		}
		function f(e, t, n) {
			var r,
			i,
			s=0;
			for(;
			r=e[s];
			s++)st.relative[r.part]?i=u(i, st.relative[r.part], t): (r.captures.push(t, n), i=a(i, st.filter[r.part].apply(null, r.captures)));
			return i
		}
		function l(e) {
			return function(t, n) {
				var r,
				i=0;
				for(;
				r=e[i];
				i++)if(r(t, n))return!0;
				return!1
			}
		}
		var c,
		h,
		p,
		d,
		v,
		m=e.document,
		g=m.documentElement,
		y="undefined",
		b=!1,
		w=!0,
		E=0,
		S=[].slice,
		x=[].push,
		T=("sizcache"+Math.random()).replace(".", ""),
		N="[\\x20\\t\\r\\n\\f]",
		C="(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+",
		k=C.replace("w", "w#"),
		L="([*^$|!~]?=)",
		A="\\["+N+"*("+C+")"+N+"*(?:"+L+N+"*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|("+k+")|)|)"+N+"*\\]",
		O=":("+C+")(?:\\((?:(['\"])((?:\\\\.|[^\\\\])*?)\\2|((?:[^,]|\\\\,|(?:,(?=[^\\[]*\\]))|(?:,(?=[^\\(]*\\))))*))\\)|)",
		M=":(nth|eq|gt|lt|first|last|even|odd)(?:\\((\\d*)\\)|)(?=[^-]|$)",
		_=N+"*([\\x20\\t\\r\\n\\f>+~])"+N+"*",
		D="(?=[^\\x20\\t\\r\\n\\f])(?:\\\\.|"+A+"|"+O.replace(2, 7)+"|[^\\\\(),])+",
		P=new RegExp("^"+N+"+|((?:^|[^\\\\])(?:\\\\.)*)"+N+"+$", "g"),
		H=new RegExp("^"+_),
		B=new RegExp(D+"?(?="+N+"*,|$)", "g"),
		j=new RegExp("^(?:(?!,)(?:(?:^|,)"+N+"*"+D+")*?|"+N+"*(.*?))(\\)|$)"),
		F=new RegExp(D.slice(19, -6)+"\\x20\\t\\r\\n\\f>+~])+|"+_, "g"),
		I=/^(?:#([\w\-]+)|(\w+)|\.([\w\-]+))$/,
		q=/[\x20\t\r\n\f]*[+~]/,
		R=/:not\($/, U=/h\d/i, z=/input|select|textarea|button/i, W=/\\(?!\\)/g, X= {
			ID: new RegExp("^#("+C+")"), CLASS:new RegExp("^\\.("+C+")"), NAME:new RegExp("^\\[name=['\"]?("+C+")['\"]?\\]"), TAG:new RegExp("^("+C.replace("[-", "[-\\*")+")"), ATTR:new RegExp("^"+A), PSEUDO:new RegExp("^"+O), CHILD:new RegExp("^:(only|nth|last|first)-child(?:\\("+N+"*(even|odd|(([+-]|)(\\d*)n|)"+N+"*(?:([+-]|)"+N+"*(\\d+)|))"+N+"*\\)|)", "i"), POS:new RegExp(M, "ig"), needsContext:new RegExp("^"+N+"*[>+~]|"+M, "i")
		}
		, V= {}
		, $=[], J= {}
		, K=[], Q=function(e) {
			return e.sizzleFilter=!0, e
		}
		, G=function(e) {
			return function(t) {
				return t.nodeName.toLowerCase()==="input"&&t.type===e
			}
		}
		, Y=function(e) {
			return function(t) {
				var n=t.nodeName.toLowerCase();
				return(n==="input"||n==="button")&&t.type===e
			}
		}
		, Z=function(e) {
			var t=!1, n=m.createElement("div");
			try {
				t=e(n)
			}
			catch(r) {}
			return n=null, t
		}
		, et=Z(function(e) {
			e.innerHTML="<select></select>";
			var t=typeof e.lastChild.getAttribute("multiple");
			return t!=="boolean"&&t!=="string"
		}
		), tt=Z(function(e) {
			e.id=T+0, e.innerHTML="<a name='"+T+"'></a><div name='"+T+"'></div>", g.insertBefore(e, g.firstChild);
			var t=m.getElementsByName&&m.getElementsByName(T).length===2+m.getElementsByName(T+0).length;
			return v=!m.getElementById(T), g.removeChild(e), t
		}
		), J=Z(function(e) {
			return e.appendChild(m.createComment("")), e.getElementsByTagName("*").length===0
		}
		), nt=Z(function(e) {
			return e.innerHTML="<a href='#'></a>", e.firstChild&&typeof e.firstChild.getAttribute!==y&&e.firstChild.getAttribute("href")==="#"
		}
		), rt=Z(function(e) {
			return e.innerHTML="<div class='hidden e'></div><div class='hidden'></div>", !e.getElementsByClassName||e.getElementsByClassName("e").length===0?!1: (e.lastChild.className="e", e.getElementsByClassName("e").length!==1)
		}
		), it=function(e, t, n, r) {
			n=n||[], t=t||m;
			var i, s, o, u, a=t.nodeType;
			if(a!==1&&a!==9)return[];
			if(!e||typeof e!="string")return n;
			o=ut(t);
			if(!o&&!r)if(i=I.exec(e))if(u=i[1]) {
				if(a===9) {
					s=t.getElementById(u);
					if(!s||!s.parentNode)return n;
					if(s.id===u)return n.push(s), n
				}
				else if(t.ownerDocument&&(s=t.ownerDocument.getElementById(u))&&at(t, s)&&s.id===u)return n.push(s), n
			}
			else {
				if(i[2])return x.apply(n, S.call(t.getElementsByTagName(e), 0)), n;
				if((u=i[3])&&rt&&t.getElementsByClassName)return x.apply(n, S.call(t.getElementsByClassName(u), 0)), n
			}
			return ct(e, t, n, r, o)
		}
		, st=it.selectors= {
			cacheLength:50, match:X, order:["ID", "TAG"], attrHandle: {}
			, createPseudo:Q, find: {
				ID:v?function(e, t, n) {
					if(typeof t.getElementById!==y&&!n) {
						var r=t.getElementById(e);
						return r&&r.parentNode?[r]: []
					}
				}
				:function(e, t, r) {
					if(typeof t.getElementById!==y&&!r) {
						var i=t.getElementById(e);
						return i?i.id===e||typeof i.getAttributeNode!==y&&i.getAttributeNode("id").value===e?[i]: n:[]
					}
				}
				, TAG:J?function(e, t) {
					if(typeof t.getElementsByTagName!==y)return t.getElementsByTagName(e)
				}
				:function(e, t) {
					var n=t.getElementsByTagName(e);
					if(e==="*") {
						var r, i=[], s=0;
						for(;
						r=n[s];
						s++)r.nodeType===1&&i.push(r);
						return i
					}
					return n
				}
			}
			, relative: {
				">": {
					dir: "parentNode", first:!0
				}
				, " ": {
					dir: "parentNode"
				}
				, "+": {
					dir: "previousSibling", first:!0
				}
				, "~": {
					dir: "previousSibling"
				}
			}
			, preFilter: {
				ATTR:function(e) {
					return e[1]=e[1].replace(W, ""), e[3]=(e[4]||e[5]||"").replace(W, ""), e[2]==="~="&&(e[3]=" "+e[3]+" "), e.slice(0, 4)
				}
				, CHILD:function(e) {
					return e[1]=e[1].toLowerCase(), e[1]==="nth"?(e[2]||it.error(e[0]), e[3]=+(e[3]?e[4]+(e[5]||1): 2*(e[2]==="even"||e[2]==="odd")), e[4]=+(e[6]+e[7]||e[2]==="odd")):e[2]&&it.error(e[0]), e
				}
				, PSEUDO:function(e) {
					var t, n=e[4];
					return X.CHILD.test(e[0])?null: (n&&(t=j.exec(n))&&t.pop()&&(e[0]=e[0].slice(0, t[0].length-n.length-1), n=t[0].slice(0, -1)), e.splice(2, 3, n||e[3]), e)
				}
			}
			, filter: {
				ID:v?function(e) {
					return e=e.replace(W, ""), function(t) {
						return t.getAttribute("id")===e
					}
				}
				:function(e) {
					return e=e.replace(W, ""), function(t) {
						var n=typeof t.getAttributeNode!==y&&t.getAttributeNode("id");
						return n&&n.value===e
					}
				}
				, TAG:function(e) {
					return e==="*"?function() {
						return!0
					}
					:(e=e.replace(W, "").toLowerCase(), function(t) {
						return t.nodeName&&t.nodeName.toLowerCase()===e
					}
					)
				}
				, CLASS:function(e) {
					var t=V[e];
					return t||(t=V[e]=new RegExp("(^|"+N+")"+e+"("+N+"|$)"), $.push(e), $.length>st.cacheLength&&delete V[$.shift()]), function(e) {
						return t.test(e.className||typeof e.getAttribute!==y&&e.getAttribute("class")||"")
					}
				}
				, ATTR:function(e, t, n) {
					return t?function(r) {
						var i=it.attr(r, e), s=i+"";
						if(i==null)return t==="!=";
						switch(t) {
							case"=": return s===n;
							case"!=": return s!==n;
							case"^=": return n&&s.indexOf(n)===0;
							case"*=": return n&&s.indexOf(n)>-1;
							case"$=": return n&&s.substr(s.length-n.length)===n;
							case"~=": return(" "+s+" ").indexOf(n)>-1;
							case"|=": return s===n||s.substr(0, n.length+1)===n+"-"
						}
					}
					:function(t) {
						return it.attr(t, e)!=null
					}
				}
				, CHILD:function(e, t, n, r) {
					if(e==="nth") {
						var i=E++;
						return function(e) {
							var t, s, o=0, u=e;
							if(n===1&&r===0)return!0;
							t=e.parentNode;
							if(t&&(t[T]!==i||!e.sizset)) {
								for(u=t.firstChild;
								u;
								u=u.nextSibling)if(u.nodeType===1) {
									u.sizset=++o;
									if(u===e)break
								}
								t[T]=i
							}
							return s=e.sizset-r, n===0?s===0:s%n===0&&s/n>=0
						}
					}
					return function(t) {
						var n=t;
						switch(e) {
							case"only": case"first":while(n=n.previousSibling)if(n.nodeType===1)return!1;
							if(e==="first")return!0;
							n=t;
							case"last": while(n=n.nextSibling)if(n.nodeType===1)return!1;
							return!0
						}
					}
				}
				, PSEUDO:function(e, t, n, r) {
					var i=st.pseudos[e]||st.pseudos[e.toLowerCase()];
					return i||it.error("unsupported pseudo: "+e), i.sizzleFilter?i(t, n, r): i
				}
			}
			, pseudos: {
				not:Q(function(e, t, n) {
					var r=lt(e.replace(P, "$1"), t, n);
					return function(e) {
						return!r(e)
					}
				}
				), enabled:function(e) {
					return e.disabled===!1
				}
				, disabled:function(e) {
					return e.disabled===!0
				}
				, checked:function(e) {
					var t=e.nodeName.toLowerCase();
					return t==="input"&&!!e.checked||t==="option"&&!!e.selected
				}
				, selected:function(e) {
					return e.parentNode&&e.parentNode.selectedIndex, e.selected===!0
				}
				, parent:function(e) {
					return!st.pseudos.empty(e)
				}
				, empty:function(e) {
					var t;
					e=e.firstChild;
					while(e) {
						if(e.nodeName>"@"||(t=e.nodeType)===3||t===4)return!1;
						e=e.nextSibling
					}
					return!0
				}
				, contains:Q(function(e) {
					return function(t) {
						return(t.textContent||t.innerText||ft(t)).indexOf(e)>-1
					}
				}
				), has:Q(function(e) {
					return function(t) {
						return it(e, t).length>0
					}
				}
				), header:function(e) {
					return U.test(e.nodeName)
				}
				, text:function(e) {
					var t, n;
					return e.nodeName.toLowerCase()==="input"&&(t=e.type)==="text"&&((n=e.getAttribute("type"))==null||n.toLowerCase()===t)
				}
				, radio:G("radio"), checkbox:G("checkbox"), file:G("file"), password:G("password"), image:G("image"), submit:Y("submit"), reset:Y("reset"), button:function(e) {
					var t=e.nodeName.toLowerCase();
					return t==="input"&&e.type==="button"||t==="button"
				}
				, input:function(e) {
					return z.test(e.nodeName)
				}
				, focus:function(e) {
					var t=e.ownerDocument;
					return e===t.activeElement&&(!t.hasFocus||t.hasFocus())&&(!!e.type||!!e.href)
				}
				, active:function(e) {
					return e===e.ownerDocument.activeElement
				}
			}
			, setFilters: {
				first:function(e, t, n) {
					return n?e.slice(1): [e[0]]
				}
				, last:function(e, t, n) {
					var r=e.pop();
					return n?e: [r]
				}
				, even:function(e, t, n) {
					var r=[], i=n?1: 0, s=e.length;
					for(;
					i<s;
					i+=2)r.push(e[i]);
					return r
				}
				, odd:function(e, t, n) {
					var r=[], i=n?0: 1, s=e.length;
					for(;
					i<s;
					i+=2)r.push(e[i]);
					return r
				}
				, lt:function(e, t, n) {
					return n?e.slice(+t): e.slice(0, +t)
				}
				, gt:function(e, t, n) {
					return n?e.slice(0, +t+1): e.slice(+t+1)
				}
				, eq:function(e, t, n) {
					var r=e.splice(+t, 1);
					return n?e: r
				}
			}
		}
		;
		st.setFilters.nth=st.setFilters.eq, st.filters=st.pseudos, nt||(st.attrHandle= {
			href:function(e) {
				return e.getAttribute("href", 2)
			}
			, type:function(e) {
				return e.getAttribute("type")
			}
		}
		), tt&&(st.order.push("NAME"), st.find.NAME=function(e, t) {
			if(typeof t.getElementsByName!==y)return t.getElementsByName(e)
		}
		), rt&&(st.order.splice(1, 0, "CLASS"), st.find.CLASS=function(e, t, n) {
			if(typeof t.getElementsByClassName!==y&&!n)return t.getElementsByClassName(e)
		}
		);
		try {
			S.call(g.childNodes, 0)[0].nodeType
		}
		catch(ot) {
			S=function(e) {
				var t, n=[];
				for(;
				t=this[e];
				e++)n.push(t);
				return n
			}
		}
		var ut=it.isXML=function(e) {
			var t=e&&(e.ownerDocument||e).documentElement;
			return t?t.nodeName!=="HTML": !1
		}
		, at=it.contains=g.compareDocumentPosition?function(e, t) {
			return!!(e.compareDocumentPosition(t)&16)
		}
		:g.contains?function(e, t) {
			var n=e.nodeType===9?e.documentElement: e, r=t.parentNode;
			return e===r||!!(r&&r.nodeType===1&&n.contains&&n.contains(r))
		}
		:function(e, t) {
			while(t=t.parentNode)if(t===e)return!0;
			return!1
		}
		, ft=it.getText=function(e) {
			var t, n="", r=0, i=e.nodeType;
			if(i) {
				if(i===1||i===9||i===11) {
					if(typeof e.textContent=="string")return e.textContent;
					for(e=e.firstChild;
					e;
					e=e.nextSibling)n+=ft(e)
				}
				else if(i===3||i===4)return e.nodeValue
			}
			else for(;
			t=e[r];
			r++)n+=ft(t);
			return n
		}
		;
		it.attr=function(e, t) {
			var n, r=ut(e);
			return r||(t=t.toLowerCase()), st.attrHandle[t]?st.attrHandle[t](e): et||r?e.getAttribute(t):(n=e.getAttributeNode(t), n?typeof e[t]=="boolean"?e[t]?t:null:n.specified?n.value:null:null)
		}
		, it.error=function(e) {
			throw new Error("Syntax error, unrecognized expression: "+e)
		}
		, [0, 0].sort(function() {
			return w=0
		}
		), g.compareDocumentPosition?p=function(e, t) {
			return e===t?(b=!0, 0): (!e.compareDocumentPosition||!t.compareDocumentPosition?e.compareDocumentPosition:e.compareDocumentPosition(t)&4)?-1:1
		}
		:(p=function(e, t) {
			if(e===t)return b=!0, 0;
			if(e.sourceIndex&&t.sourceIndex)return e.sourceIndex-t.sourceIndex;
			var n, r, i=[], s=[], o=e.parentNode, u=t.parentNode, a=o;
			if(o===u)return d(e, t);
			if(!o)return-1;
			if(!u)return 1;
			while(a)i.unshift(a), a=a.parentNode;
			a=u;
			while(a)s.unshift(a), a=a.parentNode;
			n=i.length, r=s.length;
			for(var f=0;
			f<n&&f<r;
			f++)if(i[f]!==s[f])return d(i[f], s[f]);
			return f===n?d(e, s[f], -1): d(i[f], t, 1)
		}
		, d=function(e, t, n) {
			if(e===t)return n;
			var r=e.nextSibling;
			while(r) {
				if(r===t)return-1;
				r=r.nextSibling
			}
			return 1
		}
		), it.uniqueSort=function(e) {
			var t, n=1;
			if(p) {
				b=w, e.sort(p);
				if(b)for(;
				t=e[n];
				n++)t===e[n-1]&&e.splice(n--, 1)
			}
			return e
		}
		;
		var lt=it.compile=function(e, t, n) {
			var r, i, s, u=J[e];
			if(u&&u.context===t)return u;
			i=o(e, t, n);
			for(s=0;
			r=i[s];
			s++)i[s]=f(r, t, n);
			return u=J[e]=l(i), u.context=t, u.runs=u.dirruns=0, K.push(e), K.length>st.cacheLength&&delete J[K.shift()], u
		}
		;
		it.matches=function(e, t) {
			return it(e, null, null, t)
		}
		, it.matchesSelector=function(e, t) {
			return it(t, null, null, [e]).length>0
		}
		;
		var ct=function(e, t, n, r, i) {
			e=e.replace(P, "$1");
			var o, u, a, f, l, p, d, v, m, g=e.match(B), y=e.match(F), b=t.nodeType;
			if(X.POS.test(e))return s(e, t, n, r, g);
			if(r)o=S.call(r, 0);
			else if(g&&g.length===1) {
				if(y.length>1&&b===9&&!i&&(g=X.ID.exec(y[0]))) {
					t=st.find.ID(g[1], t, i)[0];
					if(!t)return n;
					e=e.slice(y.shift().length)
				}
				v=(g=q.exec(y[0]))&&!g.index&&t.parentNode||t, m=y.pop(), p=m.split(":not")[0];
				for(a=0, f=st.order.length;
				a<f;
				a++) {
					d=st.order[a];
					if(g=X[d].exec(p)) {
						o=st.find[d]((g[1]||"").replace(W, ""), v, i);
						if(o==null)continue;
						p===m&&(e=e.slice(0, e.length-m.length)+p.replace(X[d], ""), e||x.apply(n, S.call(o, 0)));
						break
					}
				}
			}
			if(e) {
				u=lt(e, t, i), h=u.dirruns++, o==null&&(o=st.find.TAG("*", q.test(e)&&t.parentNode||t));
				for(a=0;
				l=o[a];
				a++)c=u.runs++, u(l, t)&&n.push(l)
			}
			return n
		}
		;
		m.querySelectorAll&&function() {
			var e, t=ct, n=/'|\\/g,r=/\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g,i=[],s=[": active"],o=g.matchesSelector||g.mozMatchesSelector||g.webkitMatchesSelector||g.oMatchesSelector||g.msMatchesSelector;Z(function(e){e.innerHTML="<select><option selected></option></select>",e.querySelectorAll("[selected]").length||i.push("\\["+N+"*(?:checked|disabled|ismap|multiple|readonly|selected|value)"),e.querySelectorAll(":checked").length||i.push(":checked")}),Z(function(e){e.innerHTML="<p test=''></p>",e.querySelectorAll("[test^='']").length&&i.push("[*^$]="+N+"*(?:\"\"|'')"), e.innerHTML="<input type='hidden'>", e.querySelectorAll(":enabled").length||i.push(":enabled", ":disabled")
		}
		),
		i=i.length&&new RegExp(i.join("|")),
		ct=function(e, r, s, o, u) {
			if(!o&&!u&&(!i||!i.test(e)))if(r.nodeType===9)try {
				return x.apply(s, S.call(r.querySelectorAll(e), 0)),
				s
			}
			catch(a) {}
			else if(r.nodeType===1&&r.nodeName.toLowerCase()!=="object") {
				var f=r.getAttribute("id"),
				l=f||T,
				c=q.test(e)&&r.parentNode||r;
				f?l=l.replace(n, "\\$&"): r.setAttribute("id", l);
				try {
					return x.apply(s, S.call(c.querySelectorAll(e.replace(B, "[id='"+l+"'] $&")), 0)),
					s
				}
				catch(a) {}
				finally {
					f||r.removeAttribute("id")
				}
			}
			return t(e, r, s, o, u)
		}
		,
		o&&(Z(function(t) {
			e=o.call(t, "div");
			try {
				o.call(t, "[test!='']:sizzle"), s.push(st.match.PSEUDO)
			}
			catch(n) {}
		}
		), s=new RegExp(s.join("|")), it.matchesSelector=function(t, n) {
			n=n.replace(r, "='$1']");
			if(!ut(t)&&!s.test(n)&&(!i||!i.test(n)))try {
				var u=o.call(t, n);
				if(u||e||t.document&&t.document.nodeType!==11)return u
			}
			catch(a) {}
			return it(n, null, null, [t]).length>0
		}
		)
	}
	(),
	t.sizzle=it
}

(window, J),
function(e, t) {
	e&&t&&(e.find=t)
}

(J.dom, J.sizzle),
function(J, e) {
	function a(r, o, a) {
		function d() {
			p>0&&h&&clearTimeout(h)
		}
		function v(e, t) {
			s&&e&&(e=t||e, e&&e.parentNode&&s.removeChild(e), e=undefined)
		}
		function m(e, t) {
			e.onload=e.onreadystatechange=function(n, r) {
				if(r||!e.readyState||/loaded|complete/.test(e.readyState))d(),
				e.onload=e.onreadystatechange=null,
				r&&N("Failure"),
				setTimeout(function() {
					v(e, t)
				}
				, 500)
			}
			,
			p>0&&(h=setTimeout(function() {
				N("Timeout"), v(e, t)
			}
			, p))
		}
		function g() {
			var e=i.createElement("script");
			m(e),
			e.async=l.async,
			e.charset="utf-8",
			e.src=E(),
			s.insertBefore(e, s.firstChild)
		}
		function y() {
			var e="J__ID"+J.getTime().toString(16)+""+++u,
			t=i.createElement("div"),
			n=i.createElement("form"),
			r=[],
			o=l.data;
			t.innerHTML='<iframe id="'+e+'" name="'+e+'"></iframe>',
			t.style.display="none";
			for(var a in o)r.push("<input type='hidden' name='"+a+"' value='"+o[a]+"' />");
			l.callback&&r.push("<input type='hidden' name='callback' value='"+l.callback+"' />"),
			n.innerHTML=r.join(""),
			n.action=b(l.url),
			n.method="post",
			n.target=e,
			t.appendChild(n),
			s.insertBefore(t, s.firstChild);
			var f=i.getElementById(e);
			f&&m(f, t),
			n.submit(),
			n=null
		}
		function b(e) {
			return J.requestSessionId?e+=(e.indexOf("?")>0?"&": "?")+"__REQU_SESSION_ID="+J.requestSessionId:e
		}
		function w() {
			try {
				var e=l.async,
				t=l.headers,
				n=l.data,
				r;
				f=T(),
				t["X-Request-With"]="XMLHttpRequest",
				a=="GET"?(r=E(), n=null): (r=b(l.url), n&&!J.isString(n)&&(n=S(n))), f.open(a, r, e), e&&(f.onreadystatechange=x), a=="POST"&&f.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				for(var i in t)t.hasOwnProperty(i)&&f.setRequestHeader(i, t[i]);
				J.requestSessionId&&f.setRequestHeader("REQU_SESSION_ID", J.requestSessionId),
				N("Beforerequest"),
				p>0&&(h=setTimeout(function() {
					f.onreadystatechange=function() {}
					, f.abort(), N("Timeout")
				}
				, p)),
				f.send(n),
				e||x()
			}
			catch(s) {
				N("Failure", s)
			}
			return f
		}
		function E() {
			function n() {
				return t.indexOf("?")>0?"&": "?"
			}
			var e=l.data,
			t=l.url;
			return J.requestSessionId&&(t=t.replace(/__REQU_SESSION_ID=[^&]+/, "")),
			e&&!J.isString(e)&&(e=S(e)),
			a=="GET"&&(e&&(t+=n()+e), l.type=="jsonp"&&l.callback&&(t+=n()+"callback="+l.callback), l.cache||(t+=n()+"J"+J.getTime())),
			t=b(t),
			t
		}
		function S(e) {
			function r(e, r) {
				t[t.length]=n(e)+"="+n(r)
			}
			var t=[];
			for(var i in e)r(i, J.isFunction(e[i])?e[i]():e[i]);
			return t.join("&").replace(/%20/g, "+")
		}
		function x() {
			if(f.readyState==4) {
				d();
				try {
					var e=f.status
				}
				catch(t) {
					N("Failure", t);
					return
				}
				e>=200&&e<300||e==304||e==1223?N("Success"):N("Failure"),
				f.onreadystatechange=function() {}
				,
				l.async&&(f=null)
			}
		}
		function T() {
			if(e.ActiveXObject)try {
				return new ActiveXObject("Msxml2.XMLHTTP")
			}
			catch(t) {
				try {
					return new ActiveXObject("Microsoft.XMLHTTP")
				}
				catch(t) {}
			}
			if(e.XMLHttpRequest)return new XMLHttpRequest
		}
		function N(e, t) {
			e="on"+e;
			var n=c[e],
			r;
			if(n)if(e!="onSuccess")n(t||f);
			else {
				try {
					r=l.type=="json"?(new Function("return ("+f.responseText+")"))(): f.responseText
				}
				catch(i) {
					N("Failure", i)
				}
				try {
					n(r)
				}
				catch(i) {
					if(!c.onFailure)throw i;
					N("Failure", i)
				}
			}
		}
		var f,
		l=t,
		c= {}
		,
		h,
		p;
		J.isString(r)?l.url=r:l=J.mix(l, r|| {}
		, !0),
		J.isFunction(o)?l.onSuccess=o:l=J.mix(l, o|| {}
		, !0),
		p=parseInt(l.timeout);
		if(l.url=="")return null;
		a=a.toUpperCase(),
		J.each("onSuccess onFailure onBeforerequest onTimeout".split(" "), function(e, t) {
			c[t]=l[t]
		}
		);
		if(l.type!="jsonp")return w();
		a=="GET"?g():y()
	}
	var t= {
		url: "", async:!0, data:"", callback:"", headers:"", onSuccess:"", onFailure:"", onBeforerequest:"", onTimeout:"", cache:!0, timeout:5e3, type:""
	}
	,
	n=encodeURIComponent,
	r,
	i=document,
	s=i.head||i.getElementsByTagName("head")[0],
	o="about:blank",
	u=0;
	r=J.add("ajax"),
	J.each("get post".split(" "), function(e, t) {
		r[t]=function(e, n) {
			return new a(e, n, t)
		}
	}
	),
	J.mix(J, r)
}

(J, window),
function(J, e, t) {
	function f(e, t, n, r, i) {
		if(!e)return!1;
		var s="preventDefault",
		o="stopPropagation",
		u="currentTarget";
		return e[u]||(e[u]=t),
		e[s]||(e[s]=function() {
			e.returnValue=!1
		}
		),
		e[o]||(e[o]=function() {
			e.cancelBubble=!0
		}
		),
		e.stop=function() {
			e[s](),
			e[o]()
		}
		,
		r&&e[s](),
		i&&e[o](),
		e
	}
	function l(e, t, r, o, u, a) {
		return function(l) {
			if(t.indexOf(":")>-1&&l&&l.eventName!==t)return!1;
			if(!n.MMES&&(t===i||t===s)) {
				var c=l.currentTarget||e,
				h=l.relatedTarget;
				if(c==h||(c.contains?!!c.contains(h): !!(c.compareDocumentPosition(h)&16)))return!1
			}
			f(l, e, o, u, a),
			r.call(e, l, o)
		}
	}
	function c(e) {
		var t= {
			mouseenter: "mouseover", mouseleave:"mouseout"
		}
		;
		return t[e]||e
	}
	J.add("event", {
		DA:"dataavailable", LO:"losecapture", ME:"mouseenter", ML:"mouseleave", CACHE:[], fix:l, fixName:c, getKeyCode:function(e) {
			return e.which||e.keyCode
		}
		, g:function(n) {
			return n?J.isString(n)?t.getElementById(n): n&&(n===e||n===t||n.nodeType&&n.nodeType===1)?n:n.get(0):""
		}
	}
	);
	var n=J.event,
	r=J.dom,
	i=n.ME,
	s=n.ML,
	o="unload",
	u=t.documentElement,
	a=J.ua.ie;
	n.MMES="on"+i in u&&"on"+s in u,
	r&&r.fn&&J.each("on un once fire".split(" "), function(e, t) {
		r.fn[t]=function() {
			return n[t].apply(null, [this.get()].concat(J.slice.call(arguments))), this
		}
	}
	),
	a&&e.attachEvent("on"+o, function() {
		var e, t=J.event, n=t.CACHE, r=n.length, i="detachEvent";
		while(r--)e=n[r], e.e[i]("on"+e.t, e.r, !1), e.t.indexOf(":")>-1&&(e.e[i]("on"+t.DA, e.r), e.e[i]("on"+t.LO, e.r)), n.splice(r, 1)
	}
	)
}

(J, window, document),
J.fire=J.event.fire=function(e, t, n, r) {
	var i,
	s=J.event,
	o=s.DA,
	u=s.LO,
	a=document;
	return(e=s.g(e))?(r=r||!0, e==a&&a.createEvent&&!e.dispatchEvent&&(e=a.documentElement), a.createEvent?(i=a.createEvent("HTMLEvents"), i.initEvent(o, r, !0)):(i=a.createEventObject(), i.eventType=r?"on"+o: "on"+u), i.eventName=t, i.data=n|| {}
	, a.createEvent?e.dispatchEvent(i):e.fireEvent(i.eventType, i), i):!1
}

,
J.event.getPageX=function(e) {
	var t=document,
	n=t.documentElement,
	r=t.body|| {
		scrollLeft: 0
	}
	;
	return e.pageX||e.clientX+(n.scrollLeft||r.scrollLeft)-(n.clientLeft||0)
}

,
J.event.getPageY=function(e) {
	var t=document,
	n=t.documentElement,
	r=t.body|| {
		scrollTop: 0
	}
	;
	return e.pageY||e.clientY+(n.scrollTop||r.scrollTop)-(n.clientTop||0)
}

,
J.on=J.event.on=function(e, t, n, r, i, s) {
	var o=J.event,
	u=o.CACHE,
	a,
	f=t.indexOf(":")>-1,
	l="addEventListener",
	c="attachEvent",
	h=o.DA,
	p=o.LO;
	return(e=o.g(e))?(a=o.fix(e, t, n, r, i, s), o.MMES||(t=o.fixName(t)), e[l]?e[l](f?h: t, a, !1):f?(e[c]("on"+h, a), e[c]("on"+p, a)):e[c]("on"+t, a), u.push( {
		e:e, t:t, h:n, r:a
	}
	), e):!1
}

,
J.un=J.event.un=function(e, t, n) {
	var r=J.event,
	i=r.CACHE,
	s=r.DA,
	o=r.LO,
	u=i.length,
	a,
	f=!t,
	l=!n,
	c,
	h="removeEventListener",
	p="detachEvent";
	if(!(e=r.g(e)))return!1;
	e=r.g(e),
	!r.MMES&&!t&&(t=r.fixName(t));
	while(u--)a=i[u],
	a.e==e&&(f||a.t==t)&&(l||a.h==n)&&(c=a.t.indexOf(":")>-1, e[h]?e[h](c?s: t||a.t, a.r, !1):c?(e[p]("on"+s, a.r), e[p]("on"+o, a.r)):e[p]("on"+(t||a.t), a.r), i.splice(u, 1));
	return e
}

,
J.once=J.event.once=function(e, t, n) {
	function r(i) {
		n.call(e, i),
		J.event.un(e, t, r)
	}
	return J.event.on(e, t, r),
	e
}

,
J.add("ui"),
function() {
	function r() {
		return t.body
	}
	function i() {
		return t.compatMode=="BackCompat"?r(): n
	}
	var e=window,
	t=document,
	n=t.documentElement;
	J.add("page", {
		height:function() {
			return Math.max(n.scrollHeight, r().scrollHeight, i().clientHeight)
		}
		, width:function() {
			return Math.max(n.scrollWidth, r().scrollWidth, i().clientWidth)
		}
		, scrollLeft:function() {
			return e.pageXOffset||n.scrollLeft||r().scrollLeft
		}
		, scrollTop:function() {
			return e.pageYOffset||n.scrollTop||r().scrollTop
		}
		, viewHeight:function() {
			return i().clientHeight
		}
		, viewWidth:function() {
			return i().clientWidth
		}
	}
	)
}

(),
function(J) {
	function i(i) {
		function T(e) {
			v=setTimeout(M, (parseInt(e)-1)*1e3)
		}
		function N() {
			c=O(o, "footer");
			var e=h.ok,
			t=h.cancel;
			w=O(c, "button", "a").attr("href", "javascript:;").addClass(p+"_ok").html(e),
			t&&(E=O(c, "button", "a")).attr("href", "javascript:;").html(t),
			h.onOk&&w&&w.on("click", function() {
				if(b)return!1;
				h.onOk(s)
			}
			, null, !0, !0),
			h.onCancel&&E&&E.on("click", function() {
				h.onCancel(s)
			}
			, null, !0, !0)
		}
		function C() {
			c&&(J.s("."+h.tpl+"_button").each(function(e, t) {
				t.un()
			}
			), c.remove())
		}
		function k() {
			return J.create("div").addClass("panel_modal").setStyle( {
				backgroundColor: "#333", zIndex:1e4, width:d.width()+"px", height:d.height()+"px", position:"absolute", left:"0", top:"0"
			}
			).insertFirstTo(t)
		}
		function L(e, t) {
			var n=d.viewHeight(),
			r=d.viewWidth(),
			i=h.fixed?0:d.scrollTop(),
			s=h.fixed?0:d.scrollLeft(),
			a=h.position|| {}
			,
			l=e||o.width(),
			c=t||o.height()-2,
			p= {
				width: l+"px"
			}
			;
			J.each(a, function(e, t) {
				p[e]=t+"px"
			}
			),
			c>n&&(h.scroll?(f.setStyle("height:"+(n-140)+"px;overflow-y:auto;"), c=o.height()):p.top="0"),
			p.top||(p.top=n/2-c/2+i+"px"),
			p.left||(p.left=r/2-l/2+s+"px"),
			p.right&&(p.left="auto"),
			p.bottom&&(p.top="auto"),
			o.setStyle(p);
			if(h.fixed) {
				p= {}
				;
				if(J.ua.ie==6) {
					var v=document.getElementsByTagName("html")[0],
					m=o.get().style,
					g="(document.documentElement || document.body)",
					y=parseInt(m.top||0),
					b=parseInt(m.left||0);
					document.body.currentStyle.backgroundAttachment!=="fixed"&&(v.style.backgroundImage="url(about:blank)", v.style.backgroundAttachment="fixed"),
					m.setExpression("top", "eval("+g+".scrollTop + "+y+') + "px"'),
					m.setExpression("left", "eval("+g+".scrollLeft + "+b+') + "px"')
				}
				else p.position="fixed";
				o.setStyle(p)
			}
			u.setStyle( {
				width: o.width()+"px", height:o.height()-1+"px"
			}
			)
		}
		function A(e, t) {
			return J.create("div", t|| {}
			).insertFirstTo(e)
		}
		function O(e, t, n) {
			return J.create(n||"div", {
				"class": p+"_"+t
			}
			).appendTo(e)
		}
		function M() {
			v&&clearTimeout(v),
			l&&l.un("click"),
			o.remove(),
			h.modal&&n&&n.removeClass("panel_modal_mask").hide(),
			h.onClose&&h.onClose()
		}
		function _(e, t, n) {
			f.html(e),
			L(t, n)
		}
		function D(e) {
			a.html(e)
		}
		function P(e) {
			h=J.mix(h, e|| {}
			)
		}
		function H(e) {
			e?w.addClass(p+"_ok_disable"): w.removeClass(p+"_ok_disable"), b=e
		}
		var s,
		o,
		u,
		a,
		f,
		l,
		c,
		h,
		p,
		d=J.page,
		v,
		m,
		g="0 0",
		y="0 0",
		b=!1,
		w,
		E,
		S=d.width(),
		x=d.height();
		return t||(t=A("body", {
			style: "padding:0;margin:0"
		}
		)),
		function() {
			h=J.mix(e, i|| {}
			, !0),
			h.modal&&(n||(n=k()), n.show()),
			h.mask&&n.addClass("panel_modal_mask"),
			p=h.tpl,
			m=h.title,
			o=J.create("div", {
				style: "z-index:10001;position:absolute", "class":p, id:(p+Math.random()).replace(/\./, "")+ ++r
			}
			),
			u=J.create("iframe", {
				style: "z-index:-1;position:absolute;", scrolling:"no", frameborder:"0"
			}
			),
			o.append(u),
			h.mask&&o.addClass(p+"_mask"),
			m&&(a=O(o, "title").html(m)),
			h.close&&(l=O(o, "close", "a")).attr("href", "javascript:;").on("click", M, null, !0, !0),
			f=O(o, "box"),
			m||(f.setStyle("border-top:0"), g="5px 5px"),
			h.ok?N():(f.setStyle("border-bottom:0"), y="5px 5px"),
			f.setStyle("border-radius:"+g+" "+y),
			t.append(o);
			var s= {}
			;
			J.each(["width", "height"], function(e, t) {
				h[t]&&(s[t]=h[t]+"px")
			}
			),
			o.setStyle(s),
			h.content?_(h.content):L(),
			h.autoClose&&T(h.autoClose),
			h.custom&&h.custom(o)
		}
		(),
		s= {
			close: M, setTitle:D, setContent:_, setAutoClose:T, setOptions:P, setOkDisable:H, removeFooter:C
		}
		,
		s
	}
	var e= {
		autoClose:"",
		scroll:!1,
		mask:!0,
		modal:!0,
		title:"",
		content:"",
		close:!0,
		ok:"",
		cancel:"",
		width:360,
		height:"",
		position: {}
		,
		drag: !1, fixed:"", onClose:null, onOk:null, onCancel:null, custom:null, tpl:"panel_def"
	}
	,
	t,
	n,
	r=0;
	J.ui.panel=i
}

(J),
function(J, e) {
	function n(n, r) {
		function x(e) {
			c.placeholder=e
		}
		function T() {
			return Math.floor(Math.random()*16777216).toString(16)
		}
		function N() {
			function t() {
				J.g("body").first().insertBefore(v)
			}
			var e;
			v=J.create("div", {
				style: "position:absolute;z-index:10100;width:"+c.parentWidth+";"
			}
			).html('<div class="'+c.tpl+'" id="'+h+'" style="display:none; width:'+c.width+'px"></div>'),
			c.boxTarget?J.isFunction(c.boxTarget)&&(e=c.boxTarget())?e.append(v):(e=J.g(c.boxTarget))?e.append(v):t():t(),
			m=J.g(h)
		}
		function C() {
			var e=s.offset();
			v.setStyle( {
				top: e.y+n.height()+c.offset.y+"px", left:e.x+c.offset.x+"px"
			}
			)
		}
		function k() {
			J.on(n, J.ua.opera?"keypress": "keydown", L), J.on(n, "keyup", A), J.on(n, "blur", O), J.on(n, "focus", M), J.on(n, "click", function(e) {
				e&&e.stop()
			}
			),
			J.on(window, "resize", C)
		}
		function L(e) {
			if(i)return;
			c.onKeyPress&&c.onKeyPress(n);
			switch(e.keyCode) {
				case 27: n.val(a.trim()), K();
				break;
				case 9:case 13:if(u===-1) {
					K();
					return
				}
				R(null, u);
				break;
				case 38:z();
				break;
				case 40:W();
				break;
				default:y=!1;
				return
			}
			e.preventDefault()
		}
		function A(e) {
			if(i)return;
			c.onKeyUp&&c.onKeyUp(n);
			switch(e.keyCode) {
				case 38: case 40:case 13:case 27:return
			}
			if(y)return;
			!n.val().trim()&&!c.allowEmpty&&K(),
			clearTimeout(g),
			!w&&n.val().trim()&&(g=setTimeout(_, c.defer))
		}
		function O(t) {
			clearTimeout(g),
			clearInterval(b),
			c.onBlur&&c.onBlur(t),
			J.on(e, "click", function() {
				w=!1, c.forceClear&&(o==-1?(n.val(""), c.onForceClear&&c.onForceClear(n)): V(o)), K(), J.un(e, "click", arguments.callee)
			}
			),
			c.placeholder&&n.val().trim()===""&&(c.toggleClass&&n.removeClass(c.toggleClass), n.val(c.placeholder)),
			a=n.val()
		}
		function M() {
			w=!0;
			if(i)return;
			c.onFocus&&c.onFocus(n),
			c.placeholder==n.val().trim()&&(n.val(""), c.toggleClass&&n.addClass(c.toggleClass)),
			w&&(b=setInterval(function() {
				a!=n.val().trim()&&!y&&_()
			}
			, 30))
		}
		function _() {
			if(i||y) {
				y=!1;
				return
			}
			a=n.val().trim(),
			u=-1,
			X(u),
			H()
		}
		function P() {
			return encodeURIComponent(a.trim())
		}
		function H() {
			E=c.params[c.query]=a.trim();
			var e;
			if(c.cache&&(e=f[P()]))return F(e, "c");
			if(c.source) {
				J.isFunction(c.source)?c.source(c.params, F): F(c.source);
				return
			}
			J.get( {
				url: c.url, type:"json", data:c.params, onSuccess:F
			}
			)
		}
		function B(e) {
			var t=[];
			return J.isString(e)?t:(J.each(e, function(e, n) {
				t.push(j(e, n))
			}
			), t)
		}
		function j(e, t) {
			var n= {}
			;
			return J.isString(t)? {
				k: e, v:t, l:t
			}
			:(n=c.dataMap?c.dataMap(t):t, n.v||(n.v=I(t)), n.k||(n.k=n.v), n.l||(n.l=n.v), n)
		}
		function F(e, t) {
			var r,
			i,
			s,
			a=n.val(),
			h=0;
			o=-1,
			t?l=e: (e=c.dataKey&&e[c.dataKey]||e.data||e, l=B(e)), c.onResult&&c.onResult(n, l);
			if(!l||l.length===0) {
				K();
				return
			}
			t||(f[P()]=l),
			m.s("div").each(function(e, t) {
				t.un()
			}
			),
			m.empty(),
			J.each(l, function(e, n) {
				var s=c.itemBuild(n), f=!!s.isSkip;
				t||c.itemBuild&&J.mix(n, s|| {}
				), i=c.filterHtml?U(n.v):n.v, i==a&&(o=e), f?(S++, n.l&&(r=J.create("p", {
					"class": "ui_item"
				}
				).html(n.l).appendTo(m).on("click", function(e) {
					e&&e.stop()
				}
				)), delete l[e]):(e-=S, n.l&&(r=J.create("div", {
					"class": u===e?"ui_item ui_sel":"ui_item", title:i
				}
				).html(n.l).appendTo(m)).on("mouseover", q, e).on("click", function(e, t) {
					if(c.onItemClick&&c.onItemClick(t, n, r)===!1)return;
					R(e, t)
				}
				, e, !0, !0)), h=e
			}
			),
			S=0,
			J.each(l, function(e, t) {
				!t&&l.splice(e, 1)
			}
			),
			$(),
			d=m.s("div")
		}
		function I(e) {
			var t;
			return J.each(e, function(e, n) {
				return t=n, !1
			}
			),
			t
		}
		function q(e, t) {
			d.each(function(e, t) {
				t.removeClass("ui_sel")
			}
			),
			this.className="ui_item ui_sel"
		}
		function R(e, t) {
			e&&e.stop(),
			o=t;
			var r,
			i;
			y=!0,
			J.isUndefined(t)||(i=l[t], J.mix(i, V(t)|| {}
			), n.val(a=c.filterHtml?U(i.v): i.v)), K(), c.autoSubmit&&(r=n.up("form"))&&(c.placeholder==n.val().trim()&&n.val(""), r&&r.get().submit())
		}
		function U(e) {
			return e?e.trim().replace(/<\/?[^>]*>/g, ""): ""
		}
		function z() {
			if(!p)return;
			if(u<=0) {
				d.eq(u).removeClass("ui_sel"),
				u=d.length,
				n.val(E);
				return
			}
			var e;
			y=!0,
			d.each(function(e, t) {
				t.removeClass("ui_sel")
			}
			),
			n.val(a=U((e=d.eq(--u).addClass("ui_sel")).html())),
			X(u)
		}
		function W() {
			if(!p)return;
			if(u===d.length-1) {
				d.eq(u).removeClass("ui_sel"),
				u=-1,
				n.val(E);
				return
			}
			var e;
			y=!0,
			d.each(function(e, t) {
				if(t.hasClass("ui_sel"))return t.removeClass("ui_sel"), !1
			}
			),
			n.val(a=U((e=d.eq(++u).addClass("ui_sel")).html())),
			X(u)
		}
		function X(e) {
			c.onChange&&e!=-1&&c.onChange(l[e])
		}
		function V(e) {
			return c.onSelect&&e!=-1&&c.onSelect(l[e])
		}
		function $() {
			u=-1,
			p||(m.show(), p=!0),
			C()
		}
		function K() {
			u=-1,
			y=!1,
			p&&(m.empty().hide(), p=!1)
		}
		function Q() {
			i=!1
		}
		function G() {
			i=!0
		}
		function Y(e, t) {
			c.params=t?e: J.mix(c.params, e, !0)
		}
		var i=!1,
		n=J.g(n),
		s,
		o=-1,
		u=-1,
		a=n.val().trim(),
		f=[],
		l=[],
		c,
		h,
		p=!1,
		d,
		v,
		m,
		g=null,
		y=!1,
		b=null,
		w=!1,
		E="",
		S=0;
		return function() {
			n.attr("autocomplete", "off"),
			c=J.mix(t, r|| {}
			, !0),
			h="Autocomplete_"+T(),
			s=c.offsetTarget?J.isFunction(c.offsetTarget)?c.offsetTarget(): J.g(c.offsetTarget):n, c.width||(c.width=c.parentWidth?c.parentWidth:s.width()-2), c.query=c.query||n.attr("name")||"q", a===""&&c.placeholder&&(n.val(c.placeholder), c.toggleClass&&n.removeClass(c.toggleClass)), N(), k()
		}
		(),
		{
			setParams: Y, setPlaceholder:x, enable:Q, disable:G, hide:K, show:$
		}
	}
	var t= {
		url:"/",
		dataKey:"",
		filterHtml:!0,
		autoSubmit:!0,
		forceClear:!1,
		defer:100,
		width:0,
		allowEmpty:!1,
		params: {}
		,
		source:null,
		offset: {
			x: 0, y:-1
		}
		,
		offsetTarget:null,
		boxTarget:null,
		query:"",
		placeholder:"",
		toggleClass:"",
		cache:!0,
		onForceClear:null,
		onItemClick:null,
		onResult:null,
		onChange:null,
		onSelect:null,
		onFoucs:null,
		onKeyPress:null,
		onBlur:null,
		onKeyUp:null,
		dataMap:null,
		itemBuild:null,
		tpl:"autocomplete_def",
		parentWidth:null
	}
	;
	J.dom.fn.autocomplete=function(e) {
		return new n(this.get(), e)
	}
	,
	J.ui.autocomplete=n
}

(J, document),
function(J) {
	function Exposure(options) {
		function Dispatch() {
			function a() {
				p(),
				opts.autoStart&&l(J.s("a")),
				f()
			}
			function f() {
				J.ready(h),
				J.on(window, "scroll", h),
				J.on(window, "resize", p)
			}
			function l(e) {
				e&&e.length&&(e.each(function(e, n) {
					n&&n.attr(traceTag)&&function() {
						var e=n.offset().y;
						t.push( {
							elm: n, trace:n.attr(traceTag)
						}
						), n.attr("pos", n.offset().y)
					}
					()
				}
				), h())
			}
			function c(e) {
				e&&J.each(e, function(n, r) {
					t[n].elm.get()==e.get()&&t.splice(n, 1)
				}
				)
			}
			function h() {
				e&&clearTimeout(e),
				e=setTimeout(function() {
					r=page.scrollTop(), n=r+s;
					var e=[];
					for(var i in t) {
						var o=t[i];
						if(!o.elm) {
							delete t[i];
							continue
						}
						var u=o.elm.offset().y;
						o&&u>r&&u<n&&(e.push(o.trace), delete t[i])
					}
					if(!e.length)return;
					tasker.add(e)
				}
				, o)
			}
			function p() {
				i=J.page.viewWidth(),
				s=J.page.viewHeight()
			}
			var e=null,
			t=[],
			n,
			r,
			i,
			s,
			o=50,
			u= {}
			;
			return {
				add: l, remove:c, init:a
			}
		}
		function Tasker(options) {
			function setData(e) {
				for(var t in e)/^\d+$/.test(e[t])&&(Ret[t]||(Ret[t]=[]), Ret[t].push(e[t]))
			}
			function buildData() {
				var data=eval("(["+WAITEDDATA.join(",")+"])"),
				l=data.length;
				while(l--)setData(data[l]);
				var U=[];
				for(var item in Ret)U.push('"'+item+'":['+Ret[item].join(",")+"]");
				return Ret= {}
				,
				WAITEDDATA=[],
				'{"exposure":{'+U.join(",")+"}"+"}"
			}
			function add(e) {
				WAITEDDATA=WAITEDDATA.concat(e),
				timer&&clearTimeout(timer),
				timer=setTimeout(sendData, delay)
			}
			function sendData() {
				WAITEDDATA.length&&(tracker.setCustomParam(buildData()), tracker.track())
			}
			var timer=null,
			delay=1e3,
			Ret= {}
			,
			WAITEDDATA=[];
			return function() {
				J.on(window, "beforeunload", function() {
					sendData()
				}
				)
			}
			(),
			{
				add: add
			}
		}
		var opts,
		disPatch,
		tasker,
		traceTag,
		page=J.page,
		tracker;
		(function() {
			opts=J.mix(defaultOpts, options|| {}
			, !0), traceTag=opts.trackTag, tracker=new J.logger.Tracker(opts.site, opts.pageName), opts.trackType&&tracker.setSendType(opts.trackType), tasker=new Tasker(opts), disPatch=new Dispatch
		}
		)();
		var ret= {
			add: disPatch.add, remove:disPatch.remove, start:disPatch.init
		}
		;
		return J.mix(ret, tracker)
	}
	var defaultOpts= {
		trackTag: "data-trace", trackType:"", pageName:null, site:null, autoStart:!0
	}
	,
	data=0;
	J.ui.exposure=Exposure
}

(J),
function(J) {
	function i(e) {
		return J.isString(e)&&""!==e
	}
	function s(t, s, o, u, a, f) {
		e.cookie=r(t)+"="+String(n(s))+(o?";expires="+o.toGMTString(): "")+";path="+(i(a)?a:"/")+(i(u)?";domain="+u:"")+(f?";secure":"")
	}
	var e=document,
	t=864e5,
	n=encodeURIComponent,
	r=decodeURIComponent,
	o= {
		getCookie:function(t) {
			var n=null,
			s,
			o;
			if(i(t)) {
				s=new RegExp("(?:^|)"+r(t)+"=([^;]*)(?:;|$)", "ig");
				while((o=s.exec(e.cookie))!=null)n=r(o[1])||null
			}
			return n
		}
		,
		setCookie:function(e, n, r, i, o, u) {
			var a="";
			r&&(a=new Date, a.setTime(a.getTime()+r*t)),
			s(e, n, a, i, o, u)
		}
		,
		rmCookie:function(t, n, s, u) {
			o.getCookie(t)&&(e.cookie=r(t)+"="+";path="+(i(s)?s: "/")+(n?";domain="+n:"")+";expires=Thu, 01-Jan-1970 00:00:01 GMT")
		}
	}
	;
	J.add("cookie", o),
	J.mix(J, o)
}

(J),
J.add("site"),
function(J, e) {
	function t(e) {
		function d() {
			n.lessItems&&n.lessItems(r),
			y()
		}
		function v(e, t, i) {
			n.equalItems&&n.equalItems(e, t),
			l=0,
			r.s("ul").eq(0).html(b(l, n.items)),
			n.afterInsert&&n.afterInsert(l),
			g()
		}
		function m(e, t) {
			var r=e.ROOMNUM+"\u5ba4"+e.HALLNUM+"\u5385\uff0c"+e.AREANUM+"\u5e73\u7c73";
			return n.onChange&&n.onChange(e, t)||'<img title="'+e.TITLE+'" width="150" height="115" src="'+e.IMAGESRC+'"><a onclick="return false;" data-trace="{viewandview_'+(t+1)+":"+e.PROID+'}" title="'+e.TITLE+'" class="name" href="'+e.LINK+"?from=anjuke_page_rec"+tmp.SOJ+'">'+e.TITLE+'</a><div class="price">'+e.PROPRICE+'<span>\u4e07</span></div><div class="squ">'+r+"</div>"+'<div class="percent">'+tmp.COMMNAME+"</div>"
		}
		function g() {
			r.get().style.display=""
		}
		function y() {
			r.get().style.display="none"
		}
		function b(e, t) {
			var r=null,
			i="";
			for(;
			e<t;
			e++) {
				var r=n.data[e];
				i+="<li>"+m(r, e)+"</li>"
			}
			return i
		}
		function w() {
			r.innerHTML=i+o+s,
			g()
		}
		function E() {
			u.onclick=S,
			a.onclick=x;
			var e=J.g(n.id).s("li");
			e.each(function(e, t) {
				t.on("mouseenter", function() {
					t.addClass("hover")
				}
				), t.on("mouseleave", function() {
					t.removeClass("hover")
				}
				), t.on("click", function() {
					t.s("a").eq(0).get().click()
				}
				), t.s("a").each(function(e, t) {
					t.on("click", function(e) {
						e&&e.stopPropagation?e.stopPropagation(): window.event.cancelable=!0
					}
					)
				}
				)
			}
			)
		}
		function S(e) {
			var t=n.items;
			l==0&&(l=Math.ceil(n.data.length/t)*t),
			u.onclick=null;
			var r=l+c-t,
			i=n.data[r];
			f[c].style.visibility=i?(f[c].innerHTML=m(i, r), "visible"): "hidden", c++;
			if(c>=t) {
				u.onclick=S,
				c=0,
				l-=n.items,
				n.afterInsert&&n.afterInsert(l);
				return
			}
			p=setTimeout(S, i?50:0)
		}
		function x(e) {
			var t=n.items,
			r=Math.ceil(n.data.length/t);
			Math.ceil((l+t)/t)>=r&&(l=-t),
			a.onclick=null;
			var i=t+l+h,
			s=n.data[i];
			f[h].style.visibility=s?(f[h].innerHTML=m(s, i), "visible"): "hidden", h--;
			if(h<0) {
				h=t-1,
				l+=t,
				a.onclick=x,
				n.afterInsert&&n.afterInsert(l);
				return
			}
			p=setTimeout(x, s?50:0)
		}
		var t= {
			id: "", onChange:"", afterInsert:"", items:5, lessItems:"", equalItems:"", data:[], title:"", onMouseEnter:"", onMouseLeave:"", onItemClick:""
		}
		,
		n= {}
		,
		r,
		i="",
		s='</ul><a onclick="return false;" class="left" href="javascript:void(0)"/><a class="right" href="javascript:void(0)" onclick="return false;"></a></div></div></div>',
		o="",
		u,
		a,
		f,
		l,
		c=0,
		h,
		p;
		(function() {
			n=J.mix(t, e), i='<div class="ajax_prop"><div style="margin-top:10px;font: bold 16px/40px \u5b8b\u4f53">'+n.title+'</div> <div class="list_c"><ul class="clearfix">', h=n.items-1, r=J.g(n.id);
			if(!r) {
				console.log("the container have not found");
				return
			}
			y();
			if(n.data.length<n.items) {
				d();
				return
			}
			r.html(i+o+s), u=r.s("a").eq(0).get(), a=r.s("a").eq(1).get();
			if(n.data.length>=n.items) {
				n.data.length===n.items&&(u.style.display="none", a.style.display="none"), v(u, a), E(), f=r.get().getElementsByTagName("li");
				var l=[];
				l.push(0);
				for(var c=0;
				c<n.data.length;
				c++)(function(e) {
					var t=new Image;
					t.onload=function() {}
					, t.src=n.data[e].IMAGESRC
				}
				)(c)
			}
		}
		)()
	}
	J.ui.timerAni=t
}

(J, document),
function(J, e) {
	function t(e) {
		function a() {
			n=J.s(".glbR").eq(0),
			r=J.s(".R_user").eq(0),
			u=J.s(".appContainer").length&&f(J.s(".appContainer").eq(0).get());
			if(!r.length)return!1;
			t=r.attr("url"),
			o=r.s("a").eq(0).attr("href"),
			J.getCookie("aQQ_ajkauthinfos")&&g()||m()
		}
		function f(e) {
			var t=document.createElement("div");
			return t.appendChild(e.cloneNode(!0)),
			J.g(t).html()
		}
		function l(e) {
			var t=v(e.msgCount),
			n=e.isExpert?'<li><a href="'+e.expert_home+'">\u4e13\u5bb6\u4e3b\u9875</a></li>': "", r=e.isMananer?'<li><a href="'+e.ask_center+'">\u95ee\u7b54\u4e2d\u5fc3</a></li>':"", i=n+r;
			i=i?i+'<li class="sep"></li>': "";
			var s=e.showNotiy?'<div class="login_tip"> <a href="javascript:void(0);" url="'+e.qa_url+'" style="margin-left:5px;">'+e.msg_title+"</a>"+'<span class="login_close"></span><span class="t_d"></span></div>': "", o='<div class="login_info">'+d(e.msgCount)+s+'<div class="l" id="login_l"><div class="m"><a href="'+e.my_anjuke+'" class="usr">'+e.userName+"</a>"+'<span class="up_down_usr"></span></div><div class="o_b" style="display: none;"><ul>'+i+'<li><a href="'+e.my_favorite+'">\u6211\u7684\u6536\u85cf</a></li>'+'<li><a href="'+e.view_history+'">\u6d4f\u89c8\u5386\u53f2</a></li>'+'<li><a href="'+e.subscription_management+'">\u8ba2\u9605\u7ba1\u7406</a></li>'+'<li><a href="'+e.my_ask+'">\u6211\u7684\u95ee\u7b54</a></li>'+'<li><a href="'+e.my_msg+'">\u6211\u7684\u6d88\u606f'+t+"</a></li>"+'<li><a href="'+e.my_ugc+'">\u6211\u7684\u70b9\u8bc4</a></li>'+'<li class="sep"></li>'+'<li><a target="_blank" href="'+e.publish_sell+'?from=i_dhfa">\u6211\u8981\u53d1\u623f</a></li>'+'<li><a target="_blank" href="'+e.my_house+'?from=i_dhmge">\u6211\u7684\u623f\u6e90</a></li>'+'<li class="sep"></li>'+'<li class="exit"><a class="exit" href="'+e.exit+'">\u9000\u51fa</a></li>'+"</ul></div>  "+"</div>"+u+"</div>";
			p(o, "")
		}
		function c(e) {
			var t=v(e.msgCount),
			n=e.developUrl?'<li><a href="'+e.developUrl+'">\u65b0\u623f\u5206\u9500\u5e73\u53f0</a></li>': "";
			e.my_anjuke="http://my.anjuke.com/user/broker/brokerhome";
			var r='<div class="login_info">'+d(e.msgCount)+'<div class="l" id="login_l"><div class="m"><a href="'+e.my_anjuke+'" class="usr">'+e.userName+"</a>"+'<span class="up_down_usr"></span></div><div class="o_b" style="display: none;"><ul>'+'<li><a href="'+e.my_ask+'">\u6211\u7684\u95ee\u7b54</a></li>'+'<li class="sep"></li>'+'<li><a href="'+e.myanjuke+'">\u4e2d\u56fd\u7f51\u7edc\u7ecf\u7eaa\u4eba</a></li>'+n+'<li class="sep"></li>'+'<li class="exit"><a class="exit" href="'+e.exit+'">\u9000\u51fa</a></li>'+"</ul></div>  "+"</div>"+u+"</div>",
			i='<a class="u" href="'+e.myanjuke+'">\u4e2d\u56fd\u7f51\u7edc\u7ecf\u7eaa\u4eba</a>'+(e.developUrl?'<a class="u" href="'+e.developUrl+'">\u65b0\u623f\u5206\u9500\u5e73\u53f0</a>': "");
			p(r, i)
		}
		function h(e) {
			var t=v(e.msgCount),
			n=e.fytUrl?'<li><a href="'+e.fytUrl+'">\u623f\u6613\u901a</a></li>': "", r=e.developUrl?'<li><a href="'+e.developUrl+'">\u65b0\u623f\u5206\u9500\u5e73\u53f0</a></li>':"";
			e.my_anjuke="http://svip.fang.anjuke.com/login";
			var i='<div class="login_info">'+d(e.msgCount)+'<div class="l" id="login_l"><div class="m"><a href="'+e.my_anjuke+'" class="usr">'+e.userName+"</a>"+'<span class="up_down_usr"></span></div><div class="o_b" style="display: none;"><ul>'+'<li><a href="'+e.msgUrl+'">\u6211\u7684\u6d88\u606f'+t+"</a></li>"+'<li class="sep"></li>'+n+r+(n||r?'<li class="sep"></li>': "")+'<li class="exit"><a class="exit" href="'+e.exit+'">\u9000\u51fa</a></li>'+"</ul></div>  "+"</div>"+u+"</div>", s=(e.fytUrl?'<a class="u" href="'+e.fytUrl+'">\u623f\u6613\u901a</a>':"")+(e.developUrl?'<a class="u" href="'+e.developUrl+'">\u65b0\u623f\u5206\u9500\u5e73\u53f0</a>':"");
			p(i, s)
		}
		function p(e, t) {
			r.length&&r.html(e),
			n.length?n.html(t):(r.setStyle( {
				width: "auto"
			}
			), J.create("span", {
				className: "glbR"
			}
			).appendTo(r).html(t))
		}
		function d(e) {
			e*=1;
			var t=e>0?e>99?"25": e>9?"19":"14":0, n=e>0?e>99?"99+":e:0, r=e>0?'<span class="tip_d" style="width:'+t+'px">'+n+"</span>":'<span class="tip_d"></span>';
			return r
		}
		function v(e) {
			var t=e,
			n="z_count",
			r=t>0?t>99?"99+": t:0;
			return'<span class="'+n+'">'+r+"</span>"
		}
		function m() {
			var e=r.s(".o_b").eq(0);
			e.length&&J.g("login_l").on("mouseenter", function() {
				J.g("login_l").addClass("over"), e.show(), J.s(".up_down_usr").length&&(J.s(".up_down_usr").eq(0).get().style.backgroundPosition="0 -172px")
			}
			).on("mouseleave", function() {
				J.g("login_l").removeClass("over"), e.hide(), J.s(".up_down_usr").length&&(J.s(".up_down_usr").eq(0).get().style.backgroundPosition="0 -195px")
			}
			),
			J.g("login_r")&&J.g("login_r").on("click", function() {
				J.site.trackEvent("navigation_favorite_click")
			}
			);
			var n=J.s(".login_close").length?J.s(".login_close").eq(0):!1;
			n&&n.on("click", function() {
				var e=t+"ajax/usersetting/?key=shutNotify&value=1&_r="+Math.random();
				(new Image).src=e, n.up(0).remove()
			}
			);
			var i=n&&n.prev();
			i&&i.on("click", function() {
				var e=i.attr("url"), r=t+"ajax/usersetting/?key=viewNotify&value=1&callback=url_callback&url="+encodeURIComponent(e)+"&_r="+Math.random();
				n.up(0).remove();
				if(!window.attachEvent||navigator.userAgent.indexOf("Opera")!==-1)window.open(i.attr("url"), "_blank");
				else {
					var s=document.createElement("a");
					s.href=i.attr("url"), s.target="_blank", document.body.appendChild(s), s.click()
				}
				return J.load(r, "js"), !1
			}
			),
			J.s(".glbR").length&&J.s(".glbR").eq(0).show(),
			J.s(".R_user").length&&J.s(".R_user").eq(0).show()
		}
		function g() {
			return J.get( {
				url: t+"ajax/checklogin/"+"?r="+Math.random(), type:"jsonp", callback:" loginObj.successCallBack"
			}
			),
			!0
		}
		function y(e) {
			var t="";
			if(e.common.userid>0) {
				var n=e.common.usertype;
				if(n==1||n==9||n==10) {
					var r= {
						my_anjuke: e.righturl.myanjuke, showNotiy:!parseInt(e.shutNotify), isExpert:e.qamember.cons>-1||0, isMananer:e.qamember.admin||!1, msgCount:e.common.totalUnreadCount, userName:e.common.usernamestr?e.common.usernamestr.length>5?e.common.usernamestr.slice(0, 4)+"...":e.common.usernamestr:"", my_favorite:e.righturl.links.my_favorite, my_recommend:e.righturl.links.my_recommend, view_history:e.righturl.links.view_history, subscription_management:e.righturl.links.subscription_management, my_ask:e.righturl.links.my_ask, my_ugc:e.righturl.links.my_ugc, my_msg:e.lefturl.pmurl, qa_url:e.lefturl.qaurl, msg_title:e.lefturl.title, publish_sell:e.righturl.links.publish_sell||"#", publish_rent:e.righturl.links.publish_rent||"#", publish_shop:e.righturl.links.publish_shop||"#", exit:e.lefturl.logouturl, expert_home:e.righturl.links.expert_home||"#", ask_center:e.righturl.links.ask_center||"#", my_house:e.common.my_house||"#"
					}
					;
					this.my_favorite=r.my_favorite,
					t=l(r)
				}
				else if(n==2) {
					var e= {
						userName: e.common.usernamestr?e.common.usernamestr.slice(0, 5):"", exit:e.lefturl.logouturl||"#", myanjuke:e.righturl.myanjuke||"#", msgUrl:e.lefturl.pmurl||"#", my_ask:e.righturl.links.my_ask, msgCount:e.common.totalUnreadCount, my_house:e.common.my_house||"#", developUrl:e.common.developUrl||!1
					}
					;
					t=c(e)
				}
				else if(n==8) {
					var e= {
						userName: e.common.usernamestr?e.common.usernamestr.slice(0, 5):"", exit:e.lefturl.logouturl||"#", myanjuke:e.righturl.links.fang_anjuke||"#", msgUrl:e.lefturl.pmurl||"#", msgCount:e.common.totalUnreadCount, fytUrl:e.common.fytUrl||!1, developUrl:e.common.developUrl||!1
					}
					;
					t=h(e)
				}
			}
			m()
		}
		function b(e) {
			e.each(function(e, t) {
				t.un("mouseenter"), t.un("mouseleave"), t.s("a").each(function(e, n) {
					t.un("click")
				}
				)
			}
			)
		}
		var t=e.baseUrl||"",
		n,
		r,
		i=e.showSimple||!1,
		s=!1,
		o="",
		u="";
		return J.ready(a),
		{
			refresh: a, successCallBack:y
		}
	}
	function n(e) {
		var e=e.replace(/\?(.*)/, "");
		return!/\.anjuke\.(com|test)\/(community|ask)\/(view|props|trends|photos|photos2|round|qa|duibi|jiedu)/.test(e)&&!/\.(zu|xzl|sp)(\.dev)?.anjuke\.(com|test)\/((g)?fangyuan|zu|shou|xinpan|faq)(\/(xiangce|jiaotong|canshu))?\/(\d*)/.test(e)&&!/\.anjuke\.(com|test)\/(school|baike)\/(\d+)/.test(e)&&!/\.anjuke\.(com|test)\/rent/.test(e)&&(/\.(fang|zu|chat|xzl|sp)(\.dev)?.anjuke.(com|test)/.test(e)||/\.anjuke\.(com|test)\/(sale|list|school|community|tycoon|maifang|gujia|ask|baike|act|topic|ditie-sale)/.test(e))
	}
	J.site.isList=n(window.location.href),
	J.site.isList||function() {}
	.require([""], "ui.login", !0),
	J.ui.login=t
}

(J, document),
function(J, e) {
	function t(e) {
		function a() {
			n=J.s(".glbR").eq(0),
			r=J.s(".R_user").eq(0),
			u=J.s(".appContainer").length&&f(J.s(".appContainer").eq(0).get());
			if(!r.length)return!1;
			t=r.attr("url"),
			o=r.s("a").eq(0).attr("href"),
			J.getCookie("aQQ_ajkauthinfos")&&g()||m()
		}
		function f(e) {
			var t=document.createElement("div");
			return t.appendChild(e.cloneNode(!0)),
			J.g(t).html()
		}
		function l(e) {
			var t=v(e.msgCount),
			n=e.isExpert?'<li><a href="'+e.expert_home+'">\u4e13\u5bb6\u4e3b\u9875</a></li>': "", r=e.isMananer?'<li><a href="'+e.ask_center+'">\u95ee\u7b54\u4e2d\u5fc3</a></li>':"", i=n+r;
			i=i?i+'<li class="hr"></li>': "";
			var s=e.showNotiy?'<div class="login_tip"> <a href="javascript:void(0);" url="'+e.qa_url+'" style="margin-left:5px;">'+e.msg_title+"</a>"+'<span class="login_close"></span><span class="t_d"></span></div>': "", o='<div class="login_info">'+d(e.msgCount)+s+'<div class="dropdown user-login l" id="login_l"><div class="title m"><a href="'+e.my_anjuke+'" class="usr" alt="'+e.userName+'">'+e.userName+"</a>"+'<i class="icon arrow-down"></i></div><div class="js-headlogin-statuslist list" style="display: none;"><ul>'+i+'<li><a href="'+e.my_favorite+'">\u6211\u7684\u6536\u85cf</a></li>'+'<li><a href="'+e.view_history+'">\u6d4f\u89c8\u5386\u53f2</a></li>'+'<li><a href="'+e.subscription_management+'">\u8ba2\u9605\u7ba1\u7406</a></li>'+'<li><a href="'+e.my_ask+'">\u6211\u7684\u95ee\u7b54</a></li>'+'<li><a href="'+e.my_msg+'">\u6211\u7684\u6d88\u606f'+t+"</a></li>"+'<li><a href="'+e.my_ugc+'">\u6211\u7684\u70b9\u8bc4</a></li>'+'<li class="hr"></li>'+'<li><a target="_blank" href="'+e.publish_sell+'?from=i_dhfa">\u6211\u8981\u53d1\u623f</a></li>'+'<li><a target="_blank" href="'+e.my_house+'?from=i_dhmge">\u6211\u7684\u623f\u6e90</a></li>'+'<li class="hr"></li>'+'<li class="exit"><a class="exit" href="'+e.exit+'">\u9000\u51fa</a></li>'+"</ul></div>  "+"</div>"+u+"</div>";
			p(o, "")
		}
		function c(e) {
			var t=v(e.msgCount),
			n=e.developUrl?'<li><a href="'+e.developUrl+'">\u65b0\u623f\u5206\u9500\u5e73\u53f0</a></li>': "";
			e.my_anjuke="http://my.anjuke.com/user/broker/brokerhome";
			var r='<div class="login_info">'+d(e.msgCount)+'<div class="dropdown broker-login" id="login_l">'+'<div class="title m">'+'<span class="name">\u60a8\u597d\uff0c'+e.userName+'</span><a class="exit ie6" href="'+e.exit+'">[\u9000\u51fa]</a>'+'<a class="ie6" href="'+e.msgUrl+'"><span class="text">\u6d88\u606f</span>'+t+"</a>"+"</div>"+"</div>"+'<div class="dropdown menu '+(e.developUrl?"": "last-child")+'"><div class="title"><a href="'+e.my_ask+'">\u6211\u7684\u95ee\u7b54</a></div><div class="hr"></div><div class="title"><a class="u" href="'+e.myanjuke+'">\u4e2d\u56fd\u7f51\u7edc\u7ecf\u7eaa\u4eba</a></div></div>'+(e.developUrl?'<div class="dropdown menu last-child"><div class="title"><a class="u" href="'+e.developUrl+'">\u65b0\u623f\u5206\u9500\u5e73\u53f0</a></div></div>':"")+"</div>";
			p(r)
		}
		function h(e) {
			var t=v(e.msgCount),
			n=e.fytUrl?'<li><a href="'+e.fytUrl+'">\u623f\u6613\u901a</a></li>': "", r=e.developUrl?'<li><a href="'+e.developUrl+'">\u65b0\u623f\u5206\u9500\u5e73\u53f0</a></li>':"";
			e.my_anjuke="http://svip.fang.anjuke.com/login";
			var i='<div class="login_info">'+d(e.msgCount)+'<div class="dropdown developer-login" id="login_l">'+'<div class="title m"><span class="name">\u60a8\u597d\uff0c'+e.userName+'</span><a class="exit" href="'+e.exit+'">[\u9000\u51fa]</a></div>'+"</div>"+'<div class="dropdown notification last-child"><div class="title"><a href="'+e.msgUrl+'">\u6d88\u606f'+t+"</a></div></div>"+"</div>";
			p(i)
		}
		function p(e, t) {
			r.length&&r.html(e),
			n.length?n.html(t):J.create("span", {
				className: "glbR"
			}
			).appendTo(r).html(t)
		}
		function d(e) {
			e*=1;
			var t=e>0?e>99?"25": e>9?"19":"14":0, n=e>0?e>99?"99+":e:0, r=e>0?'<span class="tip_d" style="width:'+t+'px">'+n+"</span>":'<span class="tip_d"></span>';
			return r
		}
		function v(e) {
			var t=e,
			n="z_count",
			r=t>0?t>99?"99+": t:0;
			return'<span class="'+n+'">'+r+"</span>"
		}
		function m() {
			var e=r.s(".dropdown"),
			n=r.s(".dropdown").eq(0),
			i=J.s(".js-headlogin-statuslist").eq(0);
			n.on("mouseenter", function() {
				n.addClass("hover"), i.show()
			}
			).on("mouseleave", function() {
				n.removeClass("hover"), i.hide()
			}
			);
			var s=J.s(".login_close").length?J.s(".login_close").eq(0):!1;
			s&&s.on("click", function() {
				var e=t+"ajax/usersetting/?key=shutNotify&value=1&_r="+Math.random();
				(new Image).src=e, s.up(0).remove()
			}
			);
			var o=s&&s.prev();
			o&&o.on("click", function() {
				var e=o.attr("url"), n=t+"ajax/usersetting/?key=viewNotify&value=1&callback=url_callback&url="+encodeURIComponent(e)+"&_r="+Math.random();
				s.up(0).remove();
				if(!window.attachEvent||navigator.userAgent.indexOf("Opera")!==-1)window.open(o.attr("url"), "_blank");
				else {
					var r=document.createElement("a");
					r.href=o.attr("url"), r.target="_blank", document.body.appendChild(r), r.click()
				}
				return J.load(n, "js"), !1
			}
			),
			J.s(".glbR").length&&J.s(".glbR").eq(0).show(),
			J.s(".R_user").length&&J.s(".R_user").eq(0).show()
		}
		function g() {
			return J.get( {
				url: t+"ajax/checklogin/"+"?r="+Math.random(), type:"jsonp", callback:" loginObj.successCallBack"
			}
			),
			!0
		}
		function y(e) {
			var t="";
			if(e.common.userid>0) {
				var n=e.common.usertype;
				if(n==1||n==9||n==10) {
					var r= {
						my_anjuke: e.righturl.myanjuke, showNotiy:!parseInt(e.shutNotify), isExpert:e.qamember.cons>-1||0, isMananer:e.qamember.admin||!1, msgCount:e.common.totalUnreadCount, userName:e.common.usernamestr, my_favorite:e.righturl.links.my_favorite, my_recommend:e.righturl.links.my_recommend, view_history:e.righturl.links.view_history, subscription_management:e.righturl.links.subscription_management, my_ask:e.righturl.links.my_ask, my_ugc:e.righturl.links.my_ugc, my_msg:e.lefturl.pmurl, qa_url:e.lefturl.qaurl, msg_title:e.lefturl.title, publish_sell:e.righturl.links.publish_sell||"#", publish_rent:e.righturl.links.publish_rent||"#", publish_shop:e.righturl.links.publish_shop||"#", exit:e.lefturl.logouturl, expert_home:e.righturl.links.expert_home||"#", ask_center:e.righturl.links.ask_center||"#", my_house:e.common.my_house||"#"
					}
					;
					this.my_favorite=r.my_favorite,
					t=l(r)
				}
				else if(n==2) {
					var e= {
						userName: e.common.usernamestr, exit:e.lefturl.logouturl||"#", myanjuke:e.righturl.myanjuke||"#", my_ask:e.righturl.links.my_ask, msgUrl:e.lefturl.pmurl||"#", msgCount:e.common.totalUnreadCount, my_house:e.common.my_house||"#", developUrl:e.common.developUrl||!1
					}
					;
					t=c(e)
				}
				else if(n==8) {
					var e= {
						userName: e.common.usernamestr, exit:e.lefturl.logouturl||"#", myanjuke:e.righturl.links.fang_anjuke||"#", msgUrl:e.lefturl.pmurl||"#", msgCount:e.common.totalUnreadCount, fytUrl:e.common.fytUrl||!1, developUrl:e.common.developUrl||!1
					}
					;
					t=h(e)
				}
			}
			m()
		}
		function b(e) {
			e.each(function(e, t) {
				t.un("mouseenter"), t.un("mouseleave"), t.s("a").each(function(e, n) {
					t.un("click")
				}
				)
			}
			)
		}
		var t=e.baseUrl||"",
		n,
		r,
		i=e.showSimple||!1,
		s=!1,
		o="",
		u="";
		return J.ready(a),
		{
			refresh: a, successCallBack:y
		}
	}
	J.site.isList&&function() {}
	.require([""], "ui.loginNew", !0),
	J.ui.loginNew=t
}

(J, document),
function(e) {
	"use strict";
	function t(e, t) {
		var n=(e&65535)+(t&65535),
		r=(e>>16)+(t>>16)+(n>>16);
		return r<<16|n&65535
	}
	function n(e, t) {
		return e<<t|e>>>32-t
	}
	function r(e, r, i, s, o, u) {
		return t(n(t(t(r, e), t(s, u)), o), i)
	}
	function i(e, t, n, i, s, o, u) {
		return r(t&n|~t&i, e, t, s, o, u)
	}
	function s(e, t, n, i, s, o, u) {
		return r(t&i|n&~i, e, t, s, o, u)
	}
	function o(e, t, n, i, s, o, u) {
		return r(t^n^i, e, t, s, o, u)
	}
	function u(e, t, n, i, s, o, u) {
		return r(n^(t|~i), e, t, s, o, u)
	}
	function a(e, n) {
		e[n>>5]|=128<<n%32,
		e[(n+64>>>9<<4)+14]=n;
		var r,
		a,
		f,
		l,
		c,
		h=1732584193,
		p=-271733879,
		d=-1732584194,
		v=271733878;
		for(r=0;
		r<e.length;
		r+=16)a=h,
		f=p,
		l=d,
		c=v,
		h=i(h, p, d, v, e[r], 7, -680876936),
		v=i(v, h, p, d, e[r+1], 12, -389564586),
		d=i(d, v, h, p, e[r+2], 17, 606105819),
		p=i(p, d, v, h, e[r+3], 22, -1044525330),
		h=i(h, p, d, v, e[r+4], 7, -176418897),
		v=i(v, h, p, d, e[r+5], 12, 1200080426),
		d=i(d, v, h, p, e[r+6], 17, -1473231341),
		p=i(p, d, v, h, e[r+7], 22, -45705983),
		h=i(h, p, d, v, e[r+8], 7, 1770035416),
		v=i(v, h, p, d, e[r+9], 12, -1958414417),
		d=i(d, v, h, p, e[r+10], 17, -42063),
		p=i(p, d, v, h, e[r+11], 22, -1990404162),
		h=i(h, p, d, v, e[r+12], 7, 1804603682),
		v=i(v, h, p, d, e[r+13], 12, -40341101),
		d=i(d, v, h, p, e[r+14], 17, -1502002290),
		p=i(p, d, v, h, e[r+15], 22, 1236535329),
		h=s(h, p, d, v, e[r+1], 5, -165796510),
		v=s(v, h, p, d, e[r+6], 9, -1069501632),
		d=s(d, v, h, p, e[r+11], 14, 643717713),
		p=s(p, d, v, h, e[r], 20, -373897302),
		h=s(h, p, d, v, e[r+5], 5, -701558691),
		v=s(v, h, p, d, e[r+10], 9, 38016083),
		d=s(d, v, h, p, e[r+15], 14, -660478335),
		p=s(p, d, v, h, e[r+4], 20, -405537848),
		h=s(h, p, d, v, e[r+9], 5, 568446438),
		v=s(v, h, p, d, e[r+14], 9, -1019803690),
		d=s(d, v, h, p, e[r+3], 14, -187363961),
		p=s(p, d, v, h, e[r+8], 20, 1163531501),
		h=s(h, p, d, v, e[r+13], 5, -1444681467),
		v=s(v, h, p, d, e[r+2], 9, -51403784),
		d=s(d, v, h, p, e[r+7], 14, 1735328473),
		p=s(p, d, v, h, e[r+12], 20, -1926607734),
		h=o(h, p, d, v, e[r+5], 4, -378558),
		v=o(v, h, p, d, e[r+8], 11, -2022574463),
		d=o(d, v, h, p, e[r+11], 16, 1839030562),
		p=o(p, d, v, h, e[r+14], 23, -35309556),
		h=o(h, p, d, v, e[r+1], 4, -1530992060),
		v=o(v, h, p, d, e[r+4], 11, 1272893353),
		d=o(d, v, h, p, e[r+7], 16, -155497632),
		p=o(p, d, v, h, e[r+10], 23, -1094730640),
		h=o(h, p, d, v, e[r+13], 4, 681279174),
		v=o(v, h, p, d, e[r], 11, -358537222),
		d=o(d, v, h, p, e[r+3], 16, -722521979),
		p=o(p, d, v, h, e[r+6], 23, 76029189),
		h=o(h, p, d, v, e[r+9], 4, -640364487),
		v=o(v, h, p, d, e[r+12], 11, -421815835),
		d=o(d, v, h, p, e[r+15], 16, 530742520),
		p=o(p, d, v, h, e[r+2], 23, -995338651),
		h=u(h, p, d, v, e[r], 6, -198630844),
		v=u(v, h, p, d, e[r+7], 10, 1126891415),
		d=u(d, v, h, p, e[r+14], 15, -1416354905),
		p=u(p, d, v, h, e[r+5], 21, -57434055),
		h=u(h, p, d, v, e[r+12], 6, 1700485571),
		v=u(v, h, p, d, e[r+3], 10, -1894986606),
		d=u(d, v, h, p, e[r+10], 15, -1051523),
		p=u(p, d, v, h, e[r+1], 21, -2054922799),
		h=u(h, p, d, v, e[r+8], 6, 1873313359),
		v=u(v, h, p, d, e[r+15], 10, -30611744),
		d=u(d, v, h, p, e[r+6], 15, -1560198380),
		p=u(p, d, v, h, e[r+13], 21, 1309151649),
		h=u(h, p, d, v, e[r+4], 6, -145523070),
		v=u(v, h, p, d, e[r+11], 10, -1120210379),
		d=u(d, v, h, p, e[r+2], 15, 718787259),
		p=u(p, d, v, h, e[r+9], 21, -343485551),
		h=t(h, a),
		p=t(p, f),
		d=t(d, l),
		v=t(v, c);
		return[h,
		p,
		d,
		v]
	}
	function f(e) {
		var t,
		n="";
		for(t=0;
		t<e.length*32;
		t+=8)n+=String.fromCharCode(e[t>>5]>>>t%32&255);
		return n
	}
	function l(e) {
		var t,
		n=[];
		n[(e.length>>2)-1]=undefined;
		for(t=0;
		t<n.length;
		t+=1)n[t]=0;
		for(t=0;
		t<e.length*8;
		t+=8)n[t>>5]|=(e.charCodeAt(t/8)&255)<<t%32;
		return n
	}
	function c(e) {
		return f(a(l(e), e.length*8))
	}
	function h(e, t) {
		var n,
		r=l(e),
		i=[],
		s=[],
		o;
		i[15]=s[15]=undefined,
		r.length>16&&(r=a(r, e.length*8));
		for(n=0;
		n<16;
		n+=1)i[n]=r[n]^909522486,
		s[n]=r[n]^1549556828;
		return o=a(i.concat(l(t)), 512+t.length*8),
		f(a(s.concat(o), 640))
	}
	function p(e) {
		var t="0123456789abcdef",
		n="",
		r,
		i;
		for(i=0;
		i<e.length;
		i+=1)r=e.charCodeAt(i),
		n+=t.charAt(r>>>4&15)+t.charAt(r&15);
		return n
	}
	function d(e) {
		return unescape(encodeURIComponent(e))
	}
	function v(e) {
		return c(d(e))
	}
	function m(e) {
		return p(v(e))
	}
	function g(e, t) {
		return h(d(e), d(t))
	}
	function y(e, t) {
		return p(g(e, t))
	}
	function b(e, t, n) {
		return t?n?g(t, e): y(t, e):n?v(e):m(e)
	}
	typeof define=="function"&&define.amd?define(function() {
		return b
	}
	):e.md5=b
}

(this),
function() {
	function l(e) {
		return("00"+e).match(/\d {
			2
		}
		$/)[0]
	}
	function g() {
		var e=u?"I": "X";
		return b()+"-"+y()+"-"+y()+"-"+y()+"-C"+e+a
	}
	function y() {
		return((1+Math.random())*65536|0).toString(16).substring(1).toUpperCase()
	}
	function b() {
		var e=md5(J.ua.ua+s+(t.lastModified||"")),
		n=e.length;
		return n>=8?e.substring(n-8, n).toUpperCase(): y()+y()
	}
	function w(e) {
		return e.match(/\w+.(com|com.cn|cn|org|net|test)$/g)[0]
	}
	function E() {
		var e="",
		t=document.referrer;
		try {
			e=window.top.location.hostname
		}
		catch(n) {
			e=t.match(/([0-9a-zA-Z.]+)/g)[1]
		}
		return e
	}
	function S() {
		var e=["anjuke.com",
		"anjuke.test",
		"2345.com",
		"rising.cn",
		"hao123.com",
		"uc123.com"];
		return(new RegExp(w(E()))).test(e.join(","))
	}
	function x() {
		return"anjuke.com"===w(self.location.hostname)?self.location.href: "http://www.anjuke.com/"
	}
	var e=J.site,
	t=document,
	n=1825,
	r=t.location,
	i=r.host,
	s=r.href,
	o=/\.(dev\.|test)/.test(i),
	u=/aifang\.com/.test(i),
	a,
	f,
	c=new Date,
	h=c.getMonth()+1,
	p=c.getDate(),
	d=c.getHours(),
	v=c.getMinutes(),
	m=c.getSeconds();
	a=l(h)+l(p)+l(d)+l(v)+l(m),
	o?f=i.replace(/\w+\./, ""):f="."+(u?"aifang":"anjuke")+".com",
	e.info= {
		isNew: 0, baseDomain:f, time:c.getTime(), host:i, href:s, dev:o, ref:t.referrer, isAifang:u
	}
	,
	e.cookies= {
		ctid: "ctid", guid:"aQQ_ajkguid", ssid:"sessid", auid:"aQQ_ajkauthinfos", said:"aQQ_afsales_uid", moblieAd:"mobile_guide", twe:"twe"
	}
	,
	e.createGuid=g,
	e.init=function(t) {
		function d() {
			c(s)||(e.info.isNew=1, l(s, g(), n, f))
		}
		if(!S())return window.top.location.href=x(),
		!1;
		J.logger.isDev&&(J.logger.sojUrl="http://s.anjuke.test/stb"),
		t=t|| {}
		;
		var i=e.cookies,
		s=i.guid,
		o=i.ctid,
		u=i.ssid,
		a=t.city_id||"",
		l=J.setCookie,
		c=J.getCookie,
		h=i.twe,
		p=r.href.match(/[\?&]twe=(\w+)/);
		e.info.version=t.page_version||"",
		c(u)?d():(l(u, g(), 0, f), d()),
		a&&a!=c(o)&&l(o, a, n, f),
		e.info.ctid=a||c(o),
		t.cityAlias&&(e.info.cityAlias=t.cityAlias),
		p&&p[1].length>0&&l(h, p[1], n, f)
	}
	,
	e.trackEvent=function(e, t) {
		J.logger.trackEvent( {
			site: "anjuke-npv", page:e, customparam:t
		}
		)
	}
	,
	J.logger.onError=function(e) {
		/test/.test(i)&&alert(decodeURIComponent((e+"").replace(/, /g, "\n")))
	}
	,
	J.site.isList?window.loginObj=new J.ui.loginNew( {
		baseUrl: "", showSimple:!1
	}
	):window.loginObj=new J.ui.login( {
		baseUrl: "", showSimple:!1
	}
	),
	J.add("global"),
	J.global.registerNameSpace=function(e) {
		J.global[e]?alert("The namespace was existed"):J.global[e]= {}
	}
}

(),
J.add("utils"),
function() {
	function e(e) {
		var t="",
		n=0,
		i,
		s,
		o,
		u,
		a=r;
		while(n<e.length)i=e.charCodeAt(n),
		i<128?(t+=r.fromCharCode(i), n++): i>191&&i<224?(o=e.charCodeAt(n+1), t+=r.fromCharCode((i&31)<<6|o&63), n+=2):(o=e.charCodeAt(n+1), u=e.charCodeAt(n+2), t+=r.fromCharCode((i&15)<<12|(o&63)<<6|u&63), n+=3);
		return t
	}
	function t(e) {
		e=e.replace(/\r\n/g, "\n");
		var t="";
		for(var n=0;
		n<e.length;
		n++) {
			var i=e.charCodeAt(n);
			i<128?t+=r.fromCharCode(i): i>127&&i<2048?(t+=r.fromCharCode(i>>6|192), t+=r.fromCharCode(i&63|128)):(t+=r.fromCharCode(i>>12|224), t+=r.fromCharCode(i>>6&63|128), t+=r.fromCharCode(i&63|128))
		}
		return t
	}
	var n="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	r=String;
	J.utils.base= {
		encode:function(e) {
			var r="",
			i,
			s,
			o,
			u,
			a,
			f,
			l,
			c=0;
			e=t(e);
			while(c<e.length)i=e.charCodeAt(c++),
			s=e.charCodeAt(c++),
			o=e.charCodeAt(c++),
			u=i>>2,
			a=(i&3)<<4|s>>4,
			f=(s&15)<<2|o>>6,
			l=o&63,
			isNaN(s)?f=l=64: isNaN(o)&&(l=64), r=r+n.charAt(u)+n.charAt(a)+n.charAt(f)+n.charAt(l);
			return r
		}
		,
		decode:function(t) {
			var i="",
			s,
			o,
			u,
			a,
			f,
			l,
			c,
			h=0;
			t=t.replace(/[^A-Za-z0-9\+\/\=]/g, "");
			while(h<t.length)a=n.indexOf(t.charAt(h++)),
			f=n.indexOf(t.charAt(h++)),
			l=n.indexOf(t.charAt(h++)),
			c=n.indexOf(t.charAt(h++)),
			s=a<<2|f>>4,
			o=(f&15)<<4|l>>2,
			u=(l&3)<<6|c,
			i+=r.fromCharCode(s),
			l!=64&&(i+=r.fromCharCode(o)),
			c!=64&&(i+=r.fromCharCode(u));
			return i=e(i),
			i
		}
	}
}

()