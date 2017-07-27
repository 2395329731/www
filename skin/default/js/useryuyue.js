define(function(require, exports, module) {
	require('jquery');
	require('../css/yuyue.css');
	var alertM=require('alert');
	return function(opt){
		opt = $.extend({
			elm: "#gzlist a.fybtnYY",
			type:"esf",
			sendurl:"",
			url:"",
			name:"",
			mobile:""
		}, opt || {});
		$(opt.elm).on("click",function(){
			var $t=$(this),
				html='<div id="FCYY"><div class="yiyuyue">您要预约去看的房源是：<br><p>'+$t.data("info")+'</p></div><form action=""><input type="hidden" name="itemid" value="'+$t.data("val")+'"/><input type="hidden" name="title" value="'+$t.data("info")+'"/><input type="hidden" name="linkurl" value="'+$t.data("url")+'"/><input type="hidden" name="touser" value="'+$t.data("touser")+'"/><input type="hidden" name="fromuser" value="'+opt.fromuser+'"/><input type="hidden" name="housetype" value="'+$t.data("housetype")+'"/><h2>本次预约您特别要说明的：<em>(可输入4-30个汉字)</em></h2><textarea name="content" style="height:50px" class="txt"></textarea><h2>您的联系方式是：</h2><ul><li><span> 联 系 人： </span><input name="truename" id="fcyyun" value="'+opt.truename+'" type="text" class="txt"';
			if(opt.name.length)
				html+='readonly>';
			html+='</li><li><span> 手机号码： </span><input name="telephone" id="fcyym" value="'+opt.mobile+'" type="text" class="txt"';
		
				
			html+='</li><li id="fcyyinfo"></li></ul></form></div>';
			alertM(html,{
				time:"y",
				title:"预约看房",
				width:"500",
				btnYT:"提交预约申请",
				of:function(){
					if(!opt.mobile.length){
						var $m=$("#fcyym"),
							$i=$("#fcyyinfo")
						var $s1=$("#FCbtn2").on("click","a",function(){
							if(!/^1[3458]\d{9}$/.test($m.val())){
								$i.html("请填写正确的手机号码")
							}else{
								$i.html("")
								$s1.html("<em>正在发送……</em>")
								$.ajax({
									url: opt.sendurl,
									dataType: "jsonp",
									data: {mobile:$m.val()}
								}).done(function(data) {
									if (data.state == "succ") {
										$s1.html("<em>120秒后重新获取</em>")
										var i = 119;
										var setin = setInterval(function() {
											$s1.html("<em>" + i + "秒后重新获取</em>")
											if (--i < 0) {
												$s1.html('<a href="javascript:">获取验证码</a>')
												clearInterval(setin);
											}
										}, 999)
									}else{
										$i.html(data.alert)
										$s1.html('<a href="javascript:">获取验证码</a>')
									}
								}).fail(function() {
									$s1.html('<a href="javascript:">获取验证码</a>')
								});
							}
						})
					}
				},
				yf:function(){
					var $n=$("#fcyyun"),
						$m=$("#fcyym"),
						$s=$("#fcyymc"),
						$s1=$("#FCbtn2"),
						$i=$("#fcyyinfo")
					$i.html("正在提交，请稍候……");
					if(!$.trim($n.val()).length){
						$i.html("联系人不得为空")
						return false;
					}
					else if(!/^1[3458]\d{9}$/.test($m.val())){
						$i.html("请填写正确的手机号码")
						return false;
					}
					
					$.ajax({
						url:opt.url,
						type:"post",
						data:$("#FCYY form").serialize(),
						dataType:"json"
					}).done(function(data){
						if(data.state=="succ"){
							var html='<div class="FC"><div class="okh"><div class="big succ"><b>预约申请提交成功！</b><p>稍后我将在线查看您的预约申请，<br> 我会尽快与您联系，请耐心等待~</p>';
							if(data.url)
								html+='<i id="FCbtn2"></i>';
							alertM(html+'</div></div></div>',{
								time:"y",
								title:"预约申请提交成功！",
								width:450,
								btnY:0
							})
						}else{
							$i.html(data.alert);
						}
					})
					return false;
				}
			})
		})
	}
});