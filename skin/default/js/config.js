define(function(require, exports, module) {
	require('jquery');
	require('cookie');
	var alertM = require('alert');
	return{
		domain:'aijiacms.com',
		path:'/',
		pre:'aijiacms_',
		loginurl:'',
		islogin:function() {
			if($.cookie(module.exports.pre+"user"))
				return true;
			else
				return false;
		},
		oplogin:function(opt){
			if(module.exports.islogin())
				return true;
			else{
				opt = $.extend({
					of: function() {},
					cf: function() {},
					yf: function() {},
					nf: function() {},
					rf: function() {}
				}, opt || {});
				document.domain = module.exports.domain;
				alertM(module.exports.loginurl, {
					iframe: 1,
					time: "y",
					btnY: 0,
					width: 600,
					title: "登录",
					height: 200,
					of: opt.of,
					cf: opt.cf,
					yf: opt.yf,
					nf: opt.nf,
					rf: opt.rf
				});
				return false;
			}
		},
		needlogin:function(elm,el){
			if($.isArray(el))
				for(var i=0,l=el.length;i<l;i++){
					$(elm).on(el[i],function(){
						if(!module.exports.oplogin()){
							$(this).trigger("blur");
							return false;
						}
					})
				}
			else
				$(elm).on(el,function(){
					if(!module.exports.oplogin()){
						$(this).trigger("blur");
						return false;
					}
				})
		},
		loginafter:function(t, type, fun){
			if(typeof(window.lafCookie)=="undefined"){
				var hash = function(str) {
					var hash = 0;
					for (var i = str.length - 1; i >= 0; i--) {
						hash = hash * 31 + str.charCodeAt(i);
					}
					return (hash % 999983);
				};
				window.lafCookie = "e" + hash(window.location.href);
				$(function() {
					if($.cookie(lafCookie))
						setTimeout($.cookie(lafCookie)+';$.cookie(lafCookie, "")',9)
				});
			}
			$(t).on(type, function(e) {
				if(module.exports.oplogin({
					cf: function() {
						$.cookie(lafCookie, '');
					}
				})){
					fun.call(this,e);
				}else{
					$.cookie(lafCookie, '$("' + t + '").eq(' + $(this).index(t) + ').trigger("' + type + '")');
					return false;
				}
			})
		}
	}
});