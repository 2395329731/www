$(function(){
	var $cutoverUl = $("#oneSwitch ul"),
		$cutoverLi = $("#oneSwitch li"),
		$oneBox = $("#oneBox"),
		$onetit = $("#onetit"),
		$resultLi = $("#result li");
	
	cutoverJump();
	cutoverNext();
	resultVal();
	$cutoverLi.click(function(){
		cutover($(this), $oneBox, "on");
	});
	$(".rest").click(function(){
		cutover($cutoverLi.eq(0), $oneBox, "on");
		$resultLi.children("dd").html("");
		clearSql(0);
	});
	
	function cutover(self, $oneBox, on){//切换
		var _index = $cutoverLi.index(self);
		self.addClass(on).siblings().removeClass(on);
		$oneBox.children().eq(_index).show().siblings().hide();
		$onetit.children("h3").eq(_index).show().siblings().hide();
	}
	
	function cutoverJump(){//无所谓和下一步
		$("a.jump,a.next").click(function(){
			var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
			cutover($cutoverLi.eq(_index+1), $oneBox, "on");
			removeSql(_index);
		});
	}
	
	function cutoverNext(){//下一步获取价格
		$("a.next").click(function(){
			var minPrice = $("#amount").text(),
			maxPrice = $("#amount2").text();
			$resultLi.eq(1).children("dd").html(minPrice+"-"+maxPrice+"元/平米");
		});
	}
	
	function resultVal(){//点击a选值
		$(".b1 li a,.b3 li a,.b4 li a,.b5 li a,.b6 li a").live('click',function(){
			var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
			cutover($cutoverLi.eq(_index+1), $oneBox, "on");
			$resultLi.eq(_index).children("dd").html($(this).text());
		});
	}
		
	$cutoverLi.eq(4).click(function(){
		loadBusiArea();
	})
	$(".b4 a.jump").click(function(){
		loadBusiArea();
		var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
		$resultLi.eq(_index-1).children("dd").html("");
	});
	$cutoverLi.eq(6).click(function(){
		loadHouseView();
	})
	$(".b6 a.jump").click(function(){
		loadHouseView();
		var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
		$resultLi.eq(_index-1).children("dd").html("");
	});
	
	$(".b1 a.jump").click(function(){
		var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
		$resultLi.eq(_index-1).children("dd").html("");
	});
	$(".b2 a.jump").click(function(){
		var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
		$resultLi.eq(_index-1).children("dd").html("");
	});
	$(".b3 a.jump").click(function(){
		var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
		$resultLi.eq(_index-1).children("dd").html("");
	});
	$(".b5 a.jump").click(function(){
		var _index = $cutoverLi.index($cutoverUl.children("li[class='on']"));
		$resultLi.eq(_index-1).children("dd").html("");
	});
	
	$("a.next").click(function(){
		var minPrice = $("#amount").html();
		var maxPrice = $("#amount2").html();
		minPrice = minPrice.replace("-","");
		maxPrice = maxPrice.replace("元/平米","");
		addSql(1,minPrice+","+maxPrice);
	});
})