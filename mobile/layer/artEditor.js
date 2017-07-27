$("#editorup").hide();
var ardchooser = document.getElementById("artUpload");
$("#artimg").on("click", function() {
//imgnums = $("#imgslist li:not(#addpic)").size();
	  //if(imgnums>=maxnums){
	   //laymsg("您只能上传3张图片");
	  //return false;
//}

ardchooser.click();
});
$.fn.extend({
	_opt: {
		placeholader: '请输入正文内容',
		validHtml: [],
		limitSize: 3,
		showServer: false
	},
	artEditor: function(options) {
		var _this = this,
			styles = {
				"-webkit-user-select": "text",
				"user-select": "text",
				"overflow-y": "auto",
				"text-break": "brak-all",
				"outline": "none"
			};
		$(this).css(styles).attr("contenteditable", true);
		_this._opt = $.extend(_this._opt, options);
		try{
			$(_this._opt.imgTar).on('change', function(e) {
				var editpic = 20;
				editimgs = $("#content-e img").size();
	  if(editimgs>=editpic){
	   laymsg("手机版最多只能上传"+editpic+"张图片");
	  return false;
}

				var file  = e.target.files[0];
				if(Math.ceil(file.size/1024/1024) > _this._opt.limitSize) {
					console.error('文件太大');
					return;
				}
				laymsg("开始上传");
				$("#editorup").show();
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (f) {
                	//if(_this._opt.showServer) {
						var result = this.result;
                		_this.upload(result);
                		//return ;
                	//}
            		//var img = '<img src="'+ f.target.result +'" style="width:90%;" />';
            	    //_this.insertImage(img);
                };
			});
			_this.placeholderHandler();
			_this.pasteHandler();
		} catch(e) {
			console.log(e);
		}
	},
	upload: function(data) {
		var _this = this, filed = _this._opt.uploadField;
    lrz(data, {
        width: 880,
		quality: 0.5
    })
        .then(function (rst) {
            // 把处理的好的图片给用户看看呗
            var img = new Image();
            img.src = rst.base64;
			img.size = rst.fileLen;
            img.onload = function () {
            };
            return rst;
        })
        .then(function (rst) {
			var moduleid = _this._opt.artmid;
			var from = 'editor';
			var theimg = rst.base64;
			$.ajax({
		   type: "POST",
		   url: "upload.php",
		   data: {"moduleid":moduleid,"from":from,"base64":rst.base64,"size":rst.fileLen,"width":"160","height":"160"},
		   dataType:"json",
		   success: function(data){
			   if (data.status == 0) {
				 //if(data.url.indexOf('.thumb.') != -1) {bigimg = data.url.replace('.thumb.jpg', '');}
				 var img = '<img src="'+ data.url +'" style="width:90%;" />';
				 dataurl = data.url;
				 //alert(filed);
			    _this.insertImage(img);
				laymsg('上传成功');
				$("#editorup").hide();
				return false;
			 }else{
				laymsg(data.content);
				_this._opt.uploadError(data.content);
				//$(".imglist").append(attstr); 
			 }
		   }, 
			complete :function(XMLHttpRequest, textStatus){
			},
			error:function(XMLHttpRequest, textStatus, errorThrown){ //上传失败 
			   laymsg('上传失败，请重新上传');
			   $("#editorup").hide();
			}
		}); 
            return rst;
        })
		//alert(dataurl);
	},
	insertImage: function(src) {
	    $(this).focus();
		var selection = window.getSelection ? window.getSelection() : document.selection;
		//alert(selection);
		var range = selection.createRange ? selection.createRange() : selection.getRangeAt(0);
		if (!window.getSelection) {
		    range.pasteHTML(src);
		    range.collapse(false);
		    range.select();
		} else {
		    range.collapse(false);
		    var hasR = range.createContextualFragment(src);
		    var hasLastChild = hasR.lastChild;
		    while (hasLastChild && hasLastChild.nodeName.toLowerCase() == "br" && hasLastChild.previousSibling && hasLastChild.previousSibling.nodeName.toLowerCase() == "br") {
		        var e = hasLastChild;
		        hasLastChild = hasLastChild.previousSibling;
		        hasR.removeChild(e);
		    }
		    range.insertNode(range.createContextualFragment("</br>"));
		    range.insertNode(hasR);
		    if (hasLastChild) {
		        range.setEndAfter(hasLastChild);
		        range.setStartAfter(hasLastChild);
		    }
		    selection.removeAllRanges();
		    selection.addRange(range);
		}
	},
	pasteHandler: function() {
		var _this = this;
		$(this).on("paste", function() {
			/*var content = $(this).html();
			valiHTML = _this._opt.validHtml;
			content = content.replace(/_moz_dirty=""/gi, "").replace(/\[/g, "[[-").replace(/\]/g, "-]]").replace(/<\/ ?tr[^>]*>/gi, "[br]").replace(/<\/ ?td[^>]*>/gi, "&nbsp;&nbsp;").replace(/<(ul|dl|ol)[^>]*>/gi, "[br]").replace(/<(li|dd)[^>]*>/gi, "[br]").replace(/<p [^>]*>/gi, "[br]").replace(new RegExp("<(/?(?:" + valiHTML.join("|") + ")[^>]*)>", "gi"), "[$1]").replace(new RegExp('<span([^>]*class="?at"?[^>]*)>', "gi"), "[span$1]").replace(/<[^>]*>/g, "").replace(/\[\[\-/g, "[").replace(/\-\]\]/g, "]").replace(new RegExp("\\[(/?(?:" + valiHTML.join("|") + "|img|span)[^\\]]*)\\]", "gi"), "<$1>");
			if (!/firefox/.test(navigator.userAgent.toLowerCase())) {
			    content = content.replace(/\r?\n/gi, "<br>");
			}
			$(this).html(content);*/
		});
	},
	placeholderHandler: function() {
		var _this = this;
		$(this).on('focus', function() {
			if($.trim($(this).html()) === _this._opt.placeholader) {
				$(this).html('');
			}
		})
		.on('blur', function() {
			if(!$(this).html()) {
				$(this).html(_this._opt.placeholader);
			}
		});

		if(!$.trim($(this).html())) {
			$(this).html(_this._opt.placeholader);
		}
	},
	getValue: function() {
		return $(this).html();
	},
	setValue: function(str) {
		$(this).html(str);
	}
});
