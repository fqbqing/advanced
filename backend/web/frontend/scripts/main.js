
$(function() {


	/*弹窗关闭*/
	$(document).on("click",".record-close, .mask", function() {
		$(".record-Box").addClass('fadeOutUp');
		$(".mask").addClass('fadeOut');
		setTimeout(function(){
			$("body").removeClass('body-overflow');
			$(".mask, .record-Box").remove();
		},600);
	});

	$(".pzsz-content-left").hover(function(){
		$("#adImg, #BgImg, #zhengImg").css({"z-index":"1"});
		$(".saveBtn",".pzsz-picdes",".pzsz-picdes1",".pzsz-picdes2").css({"z-index":"2"});
	},
	function(){
		$(".saveBtn",".pzsz-picdes",".pzsz-picdes1",".pzsz-picdes2").css({"z-index":"1"});
		$("#adImg, #BgImg, #zhengImg").css({"z-index":"2"});
	});
	
	
	$(".themeListBox li, .themeSet-mbthumb li").click(function(){
		$(this).addClass("active").siblings("li").removeClass("active");
	})
	
$(".pzsz-typedet").bind("change",function(){ 
	    if($(this).val()==1){
	      $(".pzsz-left4").css("top","110px"); 
	      $(".pzsz-left5").css("top","370px");
	      $(".pzsz-left6").css("top","440px");
	    } 
	     if($(this).val()==0){
	      $(".pzsz-left4").css("top","155px"); 
	      $(".pzsz-left5").css("top","415px");
	      $(".pzsz-left6").css("top","490px");
	    } 
}); 	
	
	//  ========== 
	//  = 基础表单选项 = 
	//  ========== 
	$("#addformSelect").on("change",function(){
		var addvla = $(this).val();
//		alert(addvla);
		if( addvla == 1 || addvla == 2 ){
			$("#addformText").delay(1000).fadeIn(500);
			$("#addform-select").fadeOut(500);
		}
		if( addvla == 3 || addvla == 4 ){
			$("#addformText").fadeOut(500);
			$("#addform-select").delay(1000).fadeIn(500);
		}
	})
	
	$(".addQt").click(function(){
		var str = '<div class="formDiv"><input type="text" class="form-control" name="vote_answer[]" id="" value="" placeholder="输入选项问题" /> <input type="button" class="btn grayBtn deleteForm" name="" id="" value="移除"/></div>';
		$(this).before(str);
	})
	
	
	$("body").on("click",".deleteForm", function(){
		$(this).parent(".formDiv").remove();
	})


	/*批量分发输入手机号携带信息*/
	$(document).on('input propertychange', '#batchmobile', function(event) {
		var mobile=$(this).val();
		mobile=mobile.replace(/-|\s|\+86/g,'');
		$(this).val(mobile);
		if(!(/^0?(13|15|17|18)[0-9]{9}$/.test(mobile))){
			return;
		}
		console.log(mobile);
		$.ajax({
			type:'post',
			url:'/index.php?r=ticketout/send-ticket/ajax-get-user-info&mobile='+mobile,
			success:function(json){
				console.log(json);
				if( !json.lqdw == ''){
					$(".lqdw_box").hide();
					$(".lqdw").html(json.lqdw);
					}else{
					$(".lqdw_box").show();
					$(".lqdw").html('');
				}
				if ( !json.qcpp == "") {
                    //获取品牌，匹配option的text，选中
                    var brand = json.qcpp;
                    var text = document.getElementById('brand-select').options;
                    for (var i = 0; i < text.length; i++) {
                        //console.log(text[i]);
                        if ( text[i].text == brand) {
                            text[i].selected = true;
                        }
                    }
                } else {
                    $("#brand-select").find('option').prop('selected', false);
                }
				if (json.status == 0) {
					if (!json.lxr == "") {
						$("#lxr").val(json.lxr).attr("readonly","readonly");
						$("#zw").val(json.zw).attr("readonly","readonly");
					}else{
						$("#lxr").removeAttr('readonly');
						$("#zw").removeAttr('readonly');
					}
					return;
				}
				if (json.status == 1) {
					$("#lxr").val(json.lxr).attr("readonly",'readonly');
					$("#zw").val(json.zw).attr("readonly",'readonly');
					$("#sms_username").val(json.username);
					$("#sms_pwd").val(json.pwd);
					$("#sms_mobile").val(mobile);
					$("#sms_name").val(json.lxr);

					//获取品牌，匹配option的text，选中
					var brand = json.qcpp;
					var text = document.getElementById('brand-select').options;
					for (var i = 0; i < text.length; i++) {
						//console.log(text[i]);
						if ( text[i].text == brand) {
							text[i].selected = true;
						}
					}
					//传url值
					$("#bach-send-url").val("/index.php?r=ticketout/batch-send/update&from=add&id="+json.rmcid)
				}
				if (json.status == 2) {
					$.alerts.okButton = "确定";
					jAlert(json.message, '提示');
					return false;
				}
			}
		})
	});


	// 创建品牌数组
	var brandArray = new Array();
	// 品牌显示隐藏
	$(".av-options").click(function(event) {
		var showcss = $(".letter-nav").is(':hidden');
		if( showcss == true){
			$(".letter-nav").show(300);
			$(".av-options a").html('收起');
			$("#values").css({
				height: '270px',
				overflow: 'auto'
			});
			// 将品牌存入数组
			$("#values li a").each(function() {
				brandValues = $(this).html();
				brandArray.push(brandValues);
				//console.log(brandArray);
			});
		}else{
			$(".letter-nav").hide(300);
			$(".av-options a").html('更多');
			$("#values").css({
				height: '50px',
				overflow: 'hidden'
			}).scrollTop(0);
		}
	});
	$(document).on('keyup', '#searchbrand', function(event) {
		var schVal = $(this).val();
		searchBrand(brandArray,schVal);
		//console.log(brandArray);
	});
	$("#letter-search li a").click(function() {
		$(this).each(function() {
			var letterVal = $(this).html();
			if(letterVal == "全部"){
				searchBrand(brandArray,'');
				console.log(brandArray);
			}else{
				searchBrand(brandArray,letterVal);
			}
			//console.log(letterVal);
		});
	});
	// 品牌筛选
	$(document).on("click", "#values li a", function(event) {
		var thisUrl = document.location.href;
		//替换url参数
		thisUrl = thisUrl.replace(/&page=\d{1,}&per-page=\d{1,}/,'');
		console.log(thisUrl);
		$(this).each(function() {
			var brandValues = $(this).html();
			$.get(thisUrl+'&brand='+brandValues, function(data) {
				window.location.href = thisUrl+'&brand='+brandValues;
			});
		});
	});

	//  ========== 
	//  = vi导航操作特效 = 
	//  ========== 
	$("#sidebarNav li").hover(function() {
		$(this).each(function() {
			$(this).find(".viNavfunction").fadeIn(500);
		});
	}, function() {
		$(this).each(function() {
			$(this).find(".viNavfunction").fadeOut(500);
		});
	});

	/*营销管理-商机匹配-协助编辑*/
	$(document).on('click', '.bianji', function(event) {
		$(this).each(function() {
			var sms = $(this).parent().siblings(".sms-content").html();
			var id = $(this).next().val()
			console.log(id);
			jMtext('', '编辑', sms, function(r){
				$.ajax({
					cache: false,
					type: "POST",
					url: "index.php?r=mod/business-opp/edit-sms",
					data: {'id':id,'sms_content':r},
					async: false,
					error: function(request) {
						jAlert("您的网络不给力。。", '提示');
					},
					success: function(json) {
						if (json.status == 1) {
							window.location.reload();
							return true;
						} else {
							jAlert(json.message, '提示');
							return false;
						}
					}
				});
			});
		});

	});

	/*留言回复*/
	$('.btn-rp').on('click', function() {
		$(this).each(function() {
			//var b = $(this).next().find('.message').html();
			//console.log(b);
			var reply = $(this).next().find('.reply-info');
			var message = $(this).next().find('.message');
			var inputBox = $(this).next('.inputBox');
			var a = reply.is(':hidden');
			var b = message.is(':hidden');
			if ( a == true ) {
				if ( b == true ) {
					inputBox.show();
					message.show();
					$(this).html('收起回复');
				} else {
					inputBox.hide();
					message.hide();
					$(this).html('回复');
				}
			} else {
				if ( b == true ) {
					message.show();
					$(this).html('收起回复');
				} else {
					message.hide();
					$(this).html('回复');
				}
			}
		});
	});

	/*fancybox 弹窗调用*/
	$(".various").fancybox({
		maxWidth	: 1000,
		fitToView	: false,
		width		: '70%',
		autoSize	: true,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});

});

/*品牌搜索循环展现*/
function searchBrand(array,value){
	var str = '';
	for (var i = 0; i < array.length; i++) {
		if (array[i].indexOf(value) !== -1) {
			//console.log(array[i].indexOf(value));
			str +='<li><a href="javascript:;">'+array[i]+'</a></li>';
			$("#values").html(str);
			//console.log(array[i]);
		}
	}
}


//ajax即使图片上传  新增flag,postUrl参数
function filesUp(id,source,url,item,bar,percent,showimg,progress,files,filetxt,pid,postUrl,level){
//var bar = $('.bar');
//var percent = $('.percent');
//var showimg = $('#showimg');
//var progress = $(".progress");
//var files = $(".files");
//var btn = $(".filetxt");
var bar = $(bar);
var percent = $(percent);
var showimg = $(showimg);
var progress = $(progress);
var files = $(files);
var btn = $(filetxt);
//var id = Math.floor(Math.random()*10+1);
$(source).wrap("<form id='"+id+"' class='upload_del_"+level+"' action='"+url+"' method='post' enctype='multipart/form-data' ></form>");
$(source).change(function() {
	var imgPath = $(source).val();
	var pageid = 0;
	
	var strExtension = imgPath.substr(imgPath.lastIndexOf('.') + 1);
	if (strExtension != 'jpg' && strExtension != 'gif' && strExtension != 'png' && strExtension != 'bmp') {
		alert("请选择图片文件");
		return;
	}
	$("#"+id).ajaxSubmit({
		dataType: 'json',
		beforeSend: function() {
			showimg.empty();
			progress.show();
			var percentVal = '0%';
			bar.width(percentVal);
			percent.html(percentVal);
			btn.html("上传中...");
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal);
			percent.html(percentVal);
		},
		success: function(data) {
			var img = data.pic;				
			if(pid!="" && typeof(pid)!="undefined" && pid!=0 && postUrl!="" && typeof(postUrl)!="undefined" && postUrl!=0){					
				//start 加载上传图片
				showimg.html("<img src='" + img + "' width='100%'>");
				$.ajax({
					cache: false,
					type: "POST",
					url: postUrl,
					data: {"id":pid,"logo":img},
//					async: false,
					beforeSend: function(XMLHttpRequest) {
//						$("body").append('<div id="loading"><div class="ToolTip">加载</div><div class="loader"></div></div>');
////						sleep(10);
					},
					error: function(request) {
						$("#loading").remove();
						$.alerts.okButton = "确定";
						jAlert("您的网络不给力，请稍后再试。", '提示');
						return false;
					},
					success: function(json) {
						//var json=JSON.parse(json);
						//			 loading.parentNode.removeChild(loading);
						$("#loading").remove();						
						if (json.status == 1) {                            							
							return true;
/*							if(locationUrl == 'reload') {
							    window.location.reload();
							} else if (json.status == '') {
								return true;
							} else {
								window.location.href = locationUrl;
							}*/
						} else {	
							$.alerts.okButton = "确定";
							jAlert('json.message', '提示');
							return false;
						}
					}
				});
				//end
			}else
			{			
//				files.html("<b>"+data.name+"("+data.size+"k)</b> <span class='delimg' rel='"+data.pic+"'>删除</span>");
	if(level==1){
	$(".upload_del_"+1).remove();
	$(".fileBox").html("<input type=\"file\" id=\"exhibition-pic\" style=\"display: inline;\" name=\"Exhibition[pic]\" onclick=\"filesUp('87720f2cc067a9e1bbfb50b5ec3a1312','#exhibition-pic','/index.php?r=exhibition%2Fexhibition%2Fajax-upload-pic','Exhibition[pic]','.bar_1','.percent_1','.showimg_1','.progress_1','.files_1','.filetxt_1','','','1')\"><span class=\"filetxt filetxt_1\">添加图片</span>");}
	
	if(level==2){
	$(".upload_del_"+2).remove();
	$(".fileBox1").html("<input type=\"file\" id=\"exhibition-logo\" style=\"display: inline;\" name=\"Exhibition[pic]\" onclick=\"filesUp('87720f2cc067a9e1bbfb50b5ec3a1312','#exhibition-logo','/index.php?r=exhibition%2Fexhibition%2Fajax-upload-pic','Exhibition[logo]','.bar_2','.percent_2','.showimg_2','.progress_2','.files_2','.filetxt_2','','','2')\"><span class=\"filetxt filetxt_2\">添加图片</span>");}
	

				showimg.html("<img src='" + img + "'><input type='hidden' name='"+item+"' value= '" + img + "' />");
				btn.html("上传完成");
			}
		},
		error: function(xhr) {
			btn.html("上传失败");
			bar.width('0')
			files.html(xhr.responseText);
		}
	});
});
}
//主办方审核参展方商机匹配短信，驳回
function bh(id){
	jPrompt('驳回原因', '提示', '', function(r){
		$.ajax({
			cache: false,
			type: "POST",
			url: "index.php?r=mod/business-opp/check-reject",
			data: {'id':id,'reason_text':r},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					window.location.reload();
					return true;
				} else {
					jAlert(json.message, '提示');
					return false;
				}
			}
		});
	});
}
//主办方审核参展方商机匹配短信，通过
function pass(id){
	$.ajax({
		cache: false,
		type: "POST",
		url: "index.php?r=mod/business-opp/check-pass",
		data: {"id":id},
		async: false,
		error: function(request) {
			jAlert("您的网络不给力。。", '提示');
		},
		success: function(json) {
			if (json.status == 1) {
				window.location.reload();
				return true;
			} else {
				jAlert(json.message, '提示');
				return false;
			}
		}
	});
}


//--------------------线上推广渠道
var liao_i=2;
//生成div
function add_div(){
var div_id='div_'+liao_i;//
var url_id='url_'+liao_i;
var par_id='par_'+liao_i;
var kk='<div id="'+div_id+'"><div class="formDiv"><div class="form-group formFloat" style="width: 40%;"><label for="">参数：</label><input id="'+par_id+'" onblur='+'url_cre("'+liao_i+'")'+' name="parameter[]" type="text"  class="form-control"/></div>'+
	'<div class="form-group formFloat" ><label for="">渠道名称：</label><input name="remark[]" type="text"  class="form-control" style="width: 40%;"/>'+
	'<input type="button" value="删除" onclick='+'javascript:document.getElementById("'+div_id+'").style.display="none"; ' +'class="btn btn-success addBtn" style="margin-left: 42px;padding: 8px 30px;color: white;background: darkgray;">'+
	'</div></div>'+
'<!--<div class="form-group formFloat" style="width: 100%;"><label for="">地址：</label><input id="'+url_id+'" name="url[]" type="text" readonly="readonly"  class="form-control" />-->'+
'<!--<input type="button" value="复制地址" onclick='+'js_copy("'+url_id+'");'+' class="btn btn-success addBtn" style="margin-left: 42px;padding: 8px 16px;"></div></div>-->';
	document.getElementById('div_1').insertAdjacentHTML('beforeBegin',kk);
	liao_i++;
}
//点击复制
function js_copy(id){
    document.getElementById(id).select();
    document.execCommand("Copy"); //执行浏览器复制命令
    jAlert('复制成功');
}
//用户输入参数后自动填充URL输入框
function url_cre(k){
	document.getElementById('url_'+k).value=document.getElementById('par_'+k).value;
}
//--------------------
//--------------------启用停用删除购票页面
//启用、停用
function stoporstart(pid,s,url){
	s=(s==1)?0:1;
	$.ajax({
		type: "POST",
		url: url,
		data: {"pid":pid,"s":s},
		async: false,
		error: function(request) {
			jAlert("您的网络不给力。。", '提示');
		},
		success: function(json) {
			if (json.status == 1) {
				jAlert(json.message, '提示');
				window.location.reload();
				return true;
			} else {
				jAlert(json.message, '提示');
				return false;
			}
		}
	});
}
//删除
function deletepage(pid,url){
	if(confirm("是否确认删除")){
		$.ajax({
			type: "POST",
			url: url,
			data: {"pid":pid},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					jAlert(json.message, '提示');
					window.location.reload();
					return true;
				} else {
					jAlert(json.message, '提示');
					return false;
				}
			}
		});
	}
}
//编辑
function f_bj(url,pid){
	jPrompt('修改名称（8个字以内）', '提示', '', function(r){
		$.ajax({
			cache: false,
			type: "POST",
			url: url,
			data: {'pid':pid,'s':r},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					jAlert(json.message, '提示');window.location.reload();
					return true;
				} else {
					jAlert(json.message, '提示');
					return false;
				}
			}
		});
	});
}
//保存页脚
function savepf(pid,url){
	var da = document.getElementById('txtpf').value;
	$.ajax({
		type: "POST",
		url: url,
		data: {"pid":pid,"data":da},
		async: false,
		error: function(request) {
			jAlert("您的网络不给力。。", '提示');
		},
		success: function(json) {
			if (json.status == 1) {
				jAlert(json.message, '提示');
				window.location.reload();
				return true;
			} else {
				jAlert(json.message, '提示');
				return false;
			}
		}
	});
}
//移除表单属性
function removeform(url,id){
	if(confirm("是否确定删除？")){
		$.ajax({
			type: "POST",
			url: url,
			data: {"f":id},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					jAlert(json.message, '提示');
					window.location.reload();
					return true;
				} else {
					jAlert(json.message, '提示');
					return false;
				}
			}
		});
	}
}
//----------------------

function doFind(postUrl, formId, locationUrl) {

	//	console.log($(formId).serialize());
	var loading = document.getElementById("loading");
	$.ajax({
		cache: false,
		type: "POST",
		url: postUrl,
		data: $(formId).serialize(),
//		async: false,
		beforeSend: function(XMLHttpRequest) {
			//			alert("加载开始");
			
			$("body").append('<div id="loading"><div class="ToolTip">加载</div><div class="loader"></div></div>');
//			sleep(10);
		},
		error: function(request) {
			$("#loading").remove();
			$.alerts.okButton = "确定";
			jAlert("您的网络不给力，请稍后再试。", '提示');
			return false;

		},
		success: function(json) {
			//var json=JSON.parse(json);
			//			 loading.parentNode.removeChild(loading);
			$("#loading").remove();
			if (json.status == 1) {
				if(locationUrl == 'reload') {
				    window.location.reload();
				} else if (json.status == '') {
					return true;
				} else {
					window.location.href = locationUrl;
				}
			} else {
				
			$.alerts.okButton = "确定";
			jAlert(json.message, '提示');

				return false;

			}

		}
	});
}

/*批量分发*/
function doFindBatchSend(postUrl, formId, locationUrl) {
	var loading = document.getElementById("loading");
	$.ajax({
		cache: false,
		type: "POST",
		url: postUrl,
		data: $(formId).serialize(),
//		async: false,
		beforeSend: function(XMLHttpRequest) {
			$("body").append('<div id="loading"><div class="ToolTip">加载</div><div class="loader"></div></div>');
//			sleep(10);
		},
		error: function(request) {
			$("#loading").remove();
			$.alerts.okButton = "确定";
			jAlert("您的网络不给力，请稍后再试。", '提示');
			return false;
		},
		success: function(json) {
			$("#loading").remove();
			if (json.status == 1) {
				if(locationUrl == 'reload') {
				    window.location.reload();
				} else if (json.status == '') {
					return true;
				} else {
					jAlert("发送成功", '提示',function(){
						window.location.href = locationUrl;
					});
				}
			} else {
				
			$.alerts.okButton = "确定";
			jAlert(json.message, '提示');

				return false;

			}

		}
	});
}

/*单张生成*/
function doFindSendTicket(postUrl, formId, locationUrl) {

	//	console.log($(formId).serialize());
	var loading = document.getElementById("loading")
	$.ajax({
		cache: false,
		type: "POST",
		url: postUrl,
		data: $(formId).serialize(),
//		async: false,
		beforeSend: function(XMLHttpRequest) {
			$("body").append('<div id="loading"><div class="ToolTip">加载</div><div class="loader"></div></div>');
//			sleep(10);
		},
		error: function(request) {
			$("#loading").remove();
			$.alerts.okButton = "确定";
			jAlert("您的网络不给力，请稍后再试。", '提示');
			//window.location.href = locationUrl;
			return false;
		},
		success: function(json) {
			//var json=JSON.parse(json);
			//			 loading.parentNode.removeChild(loading);
			$("#loading").remove();
			if (json.status == 1) {
				if(locationUrl == 'reload') {
				    window.location.reload();
				} else if (json.status == '') {
					return true;
				} else {
					jAlert("发送成功", '提示',function(){
						window.location.href = locationUrl;
					});
				}
			} else {
				
			$.alerts.okButton = "确定";
			jAlert(json.message, '提示');

				return false;

			}

		}
	});
}

//搜索框
function searchOnblur(){
	document.getElementById("searClk").click();
}
function searchKey(){
	if(event.keyCode ==13)   
		{   
			document.getElementById("searClk").click();
		}   
}



function addTabletree(treeUrl,treeID){
	$.ajax({
		type:"get",
		url:"",
		async:false,
		success:function(data){
			$(".tree").append('<tr class="treegrid-1">'+
				'<td>name</td>'+'<td>操作</td>'+
			'</tr>');
		}
	});
}





//票面设置
function Preview(tcUrl){
	var str ='<div class="ToolTip"></div>'
			+'<div class="tk-wrap">'
			+'<div class="tc-close" onclick="close0()"></div>'
			+'<div class="tk-content1">'
			+'<iframe src="'+tcUrl+'" width="100%" height="100%"></iframe>'
			+'</div>'
			+'</div>'
	$("body").append(str);
}

function close0(){
	$(".ToolTip, .tk-wrap").remove();
}


//票面上传
var adImg= new Image(),bgImg = new Image(),ckImg=new Image() ,zhengImg = new Image(), endImgAd = document.getElementById("adImg"), endImgBg = document.getElementById("BgImg"), endImgZh = document.getElementById("zhengImg");


//  var sx = $("#sx").val();
    
    
  
    	adImg.onload = function () {
    		
    		var Imgwidth=this.width;
			var Imgheight=this.height;
			if( !((610< Imgwidth) && (Imgwidth< 615)) || !((280< Imgheight) && (Imgheight< 300))){
				$.alerts.okButton = "确定";
				jAlert("请上传612*295像素的广告图！", '提示');
				return false;
			}
					
	       drawImgAd();
	    }
	    
	    bgImg.onload = function () {
	    	
	    		var Imgwidth=this.width;
					var Imgheight=this.height;

					if( !((630< Imgwidth) && (Imgwidth< 650)) || !((610< Imgheight) && (Imgheight< 620))){
							$.alerts.okButton = "确定";
							jAlert("请上传640*616像素的背景图！", '提示');
							
							return false;

						}
	    	
         drawImgBg();
    	}
    
    	zhengImg.onload = function () {
    		
    		var Imgwidth=this.width;
					var Imgheight=this.height;

					if( !((630< Imgwidth) && (Imgwidth< 650)) || !((950< Imgheight) && (Imgheight< 970))){
							$.alerts.okButton = "确定";
							jAlert("请上传640*960像素的背景图！", '提示');
							return false;

						}
    		
	         drawImgZh();
	    }
   

//
//	ckimg.onload = function () {
//	    
//	    
//	    }


	//ad
	 $("#ad").on('change',function(e){
//		 console.log("#ad change");
			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.readAsDataURL(file);
				
				if(file.size>800*1024){
					$.alerts.okButton = "确定";
					jAlert("请上传小于800KB的广告图。", '提示');
					$("#ad").val("");
					return false;
				}

				reader.onload = function () {
					adImg.src = $("#adBase64").val(reader.result).val();
//					console.log($("#adBase64").val(reader.result).val());
					e.target.value = null;
				};
			}
			else {
				return false;
			}


	 });

	 $("#bg").on('change',function(e){

			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.readAsDataURL(file);
				
				if(file.size>100*1024){
					$.alerts.okButton = "确定";
					jAlert("请上传小于100KB的背景图。", '提示');
					$("#bg").val("");
					return false;
				}
				
				reader.onload = function () {

					bgImg.src = $("#bgBase64").val(reader.result).val();
					e.target.value = null;
				};
			}
			else {
				return false;
			}
	 });
	 
	 $("#zheng").on('change',function(e){

			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.readAsDataURL(file);
				
				if(file.size>350*1024){
					$.alerts.okButton = "确定";
					jAlert("请上传小于350KB的背景图。", '提示');
					$("#zheng").val("");
					return false;
				}
				
				reader.onload = function () {
					zhengImg.src = $("#zhengBase64").val(reader.result).val();
					e.target.value = null;
					
				};
			}
			else {
				return false;
			}
	 });

    //画图
    function drawImgAd() {
            var c = document.createElement("canvas");

           		c.width = 612;
            	c.height = 295;
            var cxt = c.getContext("2d");
            cxt.drawImage(adImg, 0, 0, 612, 295);
			var value = c.toDataURL("image/png");
			endImgAd.src = value ;
    };
	function drawImgBg() {
			
            var c = document.createElement("canvas");

           		c.width = 640;
            	c.height = 616;
            var cxt = c.getContext("2d");
			cxt.drawImage(bgImg, 0, 0, 640, 616);
			var value = c.toDataURL("image/png");
			endImgBg.src = value ;
		
    };
	
	function drawImgZh() {
            var c = document.createElement("canvas");

           		c.width = 640;
            	c.height = 960;
            var cxt = c.getContext("2d");
            cxt.drawImage(zhengImg, 0, 0, 640, 960);
			var value = c.toDataURL("image/png");
			endImgZh.src = value ;
		
    };



//补充票仓
$("#tcBtn").click(function(){
	$("body").append('<div id="loading"><div class="ToolTip">加载</div><div class="loader"></div></div>');
})


//  ========== 
//  = 模版上传背景图片 = 
//  ========== 

var pcimg = new Image(), 
mbimg = new Image(),
logoimg = new Image(),
pcBg = document.getElementById("pcShowImg"), 
mbBg = document.getElementById("mbShowImg"),
logoBg = document.getElementById("LogoPic");

//PC
	 $("#PCup").on('change',function(e){
			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.readAsDataURL(file);
				if(file.size>500*1024){
					$.alerts.okButton = "确定";
					jAlert("请上传小于500KB的广告图。", '提示');
					$("#PCup").val("");
					return false;
				}
				reader.onload = function () {
					pcimg.src = $("#pcBase64").val(reader.result).val();
					$("#pcidentifi").val("1");
					e.target.value = null;
				};
			}
			else {
				return false;
			}
	 });
	 
	 //Logo编辑
	 $("#logo-pic").on('change',function(e){
			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.readAsDataURL(file);
				if(file.size>80*1024){
					$.alerts.okButton = "确定";
					jAlert("请上传小于80KB的广告图。", '提示');
					$("#LogoPic").val("");
					return false;
				}
				reader.onload = function () {
					logoimg.src = $("#logoBase64").val(reader.result).val();
					e.target.value = null;
				};
			}
			else {
				return false;
			}
	 });

//MOBILE
	$("#MBup").on('change',function(e){
			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.readAsDataURL(file);
				if(file.size>500*1024){
					$.alerts.okButton = "确定";
					jAlert("请上传小于500KB的广告图。", '提示');
					$("#MBup").val("");
					return false;
				}
				reader.onload = function () {
					mbimg.src = $("#mbBase64").val(reader.result).val();
					$("#moidentifi").val("1");
					e.target.value = null;
				};
			}
			else {
				return false;
			}
	});

	pcimg.onload = function () {
    		
    		var Imgwidth=this.width;
			var Imgheight=this.height;	
	       drawPcImg();
	    }
	mbimg.onload = function () {
    		
    		var Imgwidth=this.width;
			var Imgheight=this.height;	
	       drawMbImg();
	    }
	logoimg.onload = function(){
		var Imgwidth=this.width;
		var Imgheight=this.height;	
		drawLogoImg();
	}
	
	//画图
    function drawPcImg() {
            var c = document.createElement("canvas");

           		c.width = 640;
            	c.height = 344;
            var cxt = c.getContext("2d");
            cxt.drawImage(pcimg, 0, 0, 640, 344);
			var value = c.toDataURL("image/png");
			pcBg.src = value ;
    };
    function drawMbImg() {
            var c = document.createElement("canvas");

           		c.width = 640;
            	c.height = 344;
            var cxt = c.getContext("2d");
            cxt.drawImage(mbimg, 0, 0, 640, 344);
			var value = c.toDataURL("image/png");
			mbBg.src = value ;
    };
    function drawLogoImg() {
        var c = document.createElement("canvas");

       		c.width = 160;
        	c.height = 130;
        var cxt = c.getContext("2d");
        cxt.drawImage(logoimg, 0, 0, 160, 130);
		var value = c.toDataURL("image/png");
		logoBg.src = value ;
	};


/***pc模板页设置**/
function pcbg(elementId,title,src) {
	$("#template_title").text(title);
	$("#"+elementId).html("<img id='pcShowImg' src='"+src+"' width='100%'>");
//	$.get(src);
}

/***mobile模板页设置**/
function mbbg() {
	var pcbg = document.getElementById("mbShowImg");

//	$.ajax({
//		type:"post",
//		url:"",
//		async:false,
//		success: function(json){
//
//		}
//	});
}



//  ========== 
//  = vi导航页面添加 = 
//  ========== 

function addVipage(){

	jViselect('', '提示', '', function(title,vote){
		$.ajax({
			cache: false,
			type: "POST",
			url: "index.php?r=mod/form/add-page",
			data: {'page_name':title,'is_vote':vote},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					jAlert(json.message, '提示');window.location.reload();
					return true;
				} else {
					jAlert(json.message, '提示');
					return false;
				}
			}
		});
	});
	
}





//  ========== 
//  = 滚动 = 
//  ========== 
var $slider = $('.themeListBox ul');
var $slider_child_l = $('.themeListBox ul li').length;
var $slider_width = $('.themeListBox ul li').width()+24;
$slider.width($slider_child_l * $slider_width);

var slider_count = 0;

if ($slider_child_l < 4) {
	$('#btn-right').css({cursor: 'auto'});
	$('#btn-right').removeClass("dasabled");
}

$('#btn-right').click(function() {
	if ($slider_child_l < 4 || slider_count >= $slider_child_l - 4) {
		return false;
	}
	
	slider_count++;
	$slider.animate({left: '-=' + ($slider_width) + 'px'}, 'slow');
	slider_pic();
});

$('#btn-left').click(function() {
	if (slider_count <= 0) {
		return false;
	}
	
	slider_count--;
	$slider.animate({left: '+=' + ($slider_width) + 'px'}, 'slow');
	slider_pic();
});

function slider_pic() {
	if (slider_count >= $slider_child_l - 4) {
		$('#btn-right').css({cursor: 'auto'});
		$('#btn-right').addClass("dasabled");
	}
	else if (slider_count > 0 && slider_count <= $slider_child_l - 4) {
		$('#btn-left').css({cursor: 'pointer'});
		$('#btn-left').removeClass("dasabled");
		$('#btn-right').css({cursor: 'pointer'});
		$('#btn-right').removeClass("dasabled");
	}
	else if (slider_count <= 0) {
		$('#btn-left').css({cursor: 'auto'});
		$('#btn-left').addClass("dasabled");
	}
}



//  ========== 
//  = 添加协议 = 
//  ========== 
function Protocol(pid,url){
	var protocol = $("#Protocol").next().html();
	console.log(protocol);
	jMtext('', '编辑购票协议', protocol, function(e){
		$.ajax({
			cache: false,
			type: "POST",
			url: url,
			data: {'pid':pid,'data':e},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					jAlert(json.message, '提示');window.location.reload();
					return true;
				} else {
					jAlert(json.message, '提示');
					return false;
				}
			}
		});
	});
}

//  ========== 
//  = 设置票价 = 
//  ========== 
function Setticket(pid,url,price){
	jPrompt('票价(元)', '设置票价', price, function(r){
		$.ajax({
			cache: false,
			type: "POST",
			url: url,
			data: {'pid':pid,'data':r},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					jAlert(json.message, '提示');window.location.reload();
					return true;
				} else {
					jAlert(json.message, '提示');
					return false;
				}
			}
		});
	});
}
//========== 
//= 保存页面 = 
//========== 
//1 pid
//2 logo64
//3 pcbg64
//4 bg64
//5 logo
//6 pcbg
//7 bg
//8 theme
//9 action url
//10 title
//11 flag
//12 src
//13 pcbgdefined
//14 bgdefined
function Savepage(pid,logo64,pcbg64,bg64,logo,pcbg,bg,theme,url,title,flag,src,pcbgdefined,bgdefined,tid,csshref){
	$("#template_title").text(title);
//	var pcbgdefined = $("#pcidentifi").val();//PC端
//	var bgdefined = $("#moidentifi").val();//移动端
	if(tid<1){
		alert("请添加购票页面，后再进行操作！");return;
	}
	if(flag=="pc"){		
		//$("#themeShowimg").html("<img id='pcShowImg' src='"+src+"' width='100%'>");
		$("#pcShowImg").attr("src",src);
	}else if(flag=="mobile"){		
		$("#mbShowImg").attr("src",src);
	}
//	alert("PC端自定义："+pcbgdefined+" 移动端自定义："+bgdefined+" flag:"+flag+" src:"+src);
//	var str = "pid:"+pid+" logo:"+logo+" pcbg:"+pcbg+" bg:"+bg+" theme:"+theme+" url:"+url+" title:"+title+" flag:"+flag;
//	alert(str);
	$.ajax({
		cache: false,
		type: "POST",
		url: url,
		data: {'pid':pid,'logo64':logo64,"pcbg64":pcbg64,"bg64":bg64,'logo':logo,'pcbg':pcbg,'bg':bg,'theme':theme,"url":url,"flag":flag,"pcbgdefined":pcbgdefined,"bgdefined":bgdefined},
		async: false,
		error: function(request) {
			jAlert("您的网络不给力。。", '提示');
		},
		success: function(json) {
			if (json.status == 1) {
				if(flag==""){
					jAlert(json.message, '提示');
				}
				$("#copyInput").val(json.url);
				$("#themeid").val(theme);
				$("#ymyl").attr("href",json.url);
				//window.location.reload();
				//return true;
			} else {
				jAlert(json.message, '提示');
				//return false;
			}
		}
	});
}

function setTicketPage()
{
	var ticket_type = $('.pzsz-typedet option:selected') .val();
	if (ticket_type == 1) {
		$('.pzsz-left3').hide();
		$('.pzsz-left-content3-left-money').show();
	} else {
		$('.pzsz-left3').show();
		$('.pzsz-left-content3-left-money').hide();
	}
}


/*批量赠票*/
function tickesUp(url){
	$('#uploadform-file').wrap("<form id='tickets' action='"+url+"' method='post' enctype='multipart/form-data'></form>");
}

/*票证统计-发票记录*/
function record(exhibitionId, member_id){
	$("body").addClass('body-overflow').append('<div class="mask"></div><div class="record-Box"><div class="record-close"></div><div class="container-fluid row">分发记录：</div>\
		<table id="tb" class="table table-bordered" style="margin-top:20px;">\
        <thead>\
        <tr>\
            <th>姓名</th>\
            <th>电话</th>\
            <th>身份</th>\
            <th>票证</th>\
        </tr>\
        </thead>\
        <tbody></tbody>\
    </table>\
		<div class="container-fluid" id="dvPager"></div></div>');

	loadData(1, 6, exhibitionId, member_id);
    //分页条点击事件
    $(document.body).on('click', '.pageNav', function() {
        var pageSize = Number(getQueryString('pageSize', $(this).attr('href')));
        // var pageIndex = Number(getQueryString('pageIndex', $(this).attr('href')));
        var pageIndex= $(this).attr('data-pageindex');
        loadData(pageIndex, pageSize, exhibitionId, member_id);
        return false; //不跳转页面
    });
}
/**
* pageSize,  每页显示数
* pageIndex, 当前页数  
* pageCount  总页数
* url  连接地址
* pager(10, 1, 5, 'Index')使用方法示例
*/
function pager(pageSize, pageIndex, pageCount, url) {
    var intPage = 8;  //数字显示
    var intBeginPage = 0;//开始的页数
    var intEndPage = 0;//结束的页数
    var intCrossPage = parseInt(intPage / 2); //显示的数字

    var strPage = "<nav class='text-center'><ul class='pagination'>";

    if (pageIndex > 1) {
        // strPage = strPage + "<li><a class='pageNav' href='" + url + "?pageIndex=1&pageSize=" + pageSize + "'><span>首页</span></a></li>";
        strPage = strPage + "<li class='prev'><a class='pageNav' href='" + url + "?pageIndex=" + (pageIndex - 1) + "&pageSize=" + pageSize + "'><span>上一页</span></a></li>";
    }
    if (pageCount > intPage) {//总页数大于在页面显示的页数

        if (pageIndex > pageCount - intCrossPage) {//当前页数>总页数-3
            intBeginPage = pageCount - intPage + 1;
            intEndPage = pageCount;
        }
        else {
            if (pageIndex <= intPage - intCrossPage) {
                intBeginPage = 1;
                intEndPage = intPage;
            }
            else {
                intBeginPage = pageIndex - intCrossPage;
                intEndPage = parseInt(pageIndex) + parseInt(intCrossPage);
            }
        }
    } else {
        intBeginPage = 1;
        intEndPage = pageCount;
    }
    if (pageCount > 0) {

        for (var i = intBeginPage; i <= intEndPage; i++) {
            {
                if (i == pageIndex) {//当前页
                    strPage = strPage + "<li class='active'><a href='javascript:void(0);'>" + i + "</a></li> ";
                }
                else {
                    strPage = strPage + "<li><a class='pageNav' href='" + url + "?pageIndex=" + i + "&pageSize=" + pageSize + "' data-pageindex='"+i+"' title='第" + i + "页'>" + i + "</a></li> ";
                }
            }
        }
    }
    if (pageIndex < pageCount) {
        strPage = strPage + "<li><a class='pageNav' href='" + url + "?pageIndex=" + (pageIndex + 1) + "&pageSize=" + pageSize + "'><span>下一页</span></a></li> ";
        // strPage = strPage + "<li><a class='pageNav' href='" + url + "?pageIndex=" + pageCount + "&pageSize=" + pageSize + "'><span>尾页</span></a></li> ";
    }
    return strPage+"</ul><span style='display: inline-block;vertical-align: top; margin: 30px 0 0 10px;'>第 <font color='#FF0000'>" + pageIndex + "/" + pageCount + "</font> 页 </span></nav>";

}

//加载数据
        function loadData(pageIndex, pageSize, exhibitionId, member_id) {
            $.getJSON('/index.php?r=report%2Fpkdata%2Fget-detail-joiner&exhibitionId='+exhibitionId+'&member_id='+member_id+'', { pageIndex: pageIndex, pageSize: pageSize }, function (data) {
                var tbodyHtml = '';
                for (var i = 0; i < pageSize; i++) {
                    if (!data.Rows[i]) {
                        continue;
                    }
                    var tbody = '<tr><td>{0}</td><td>{1}</td><td>{2}</td><td>{3}</td></tr>';
  
                    tbody = tbody.format(data.Rows[i].uname, data.Rows[i].mobile, data.Rows[i].identity, data.Rows[i].tickets);
                    tbodyHtml += tbody;
                }
                $('#tb').find('tbody').first().html(tbodyHtml);
                var pageCount = parseInt((data.Total / pageSize)) + (data.Total % pageSize ? 1 : 0);
                $('#dvPager').html(pager(pageSize, pageIndex, pageCount, '/index.php?r=report%2Fpkdata%2Fget-detail-joiner&exhibitionId='+exhibitionId+'&member_id='+member_id+''));
            }
            );
        }

//字符串格式化
        String.prototype.format = function (args) {
            var result = this;
            var reg;
            if (arguments.length > 0) {
                if (arguments.length == 1 && typeof (args) == "object") {
                    for (var key in args) {
                        if (args[key] !== undefined) {
                            reg = new RegExp("({" + key + "})", "g");
                            result = result.replace(reg, args[key]);
                        }
                    }
                } else {
                    for (var i = 0; i < arguments.length; i++) {
                        if (arguments[i] !== undefined) {
                            reg = new RegExp("({)" + i + "(})", "g");
                            result = result.replace(reg, arguments[i]);
                        }
                    }
                }
            }
            return result;
        };
//获取url参数
function getQueryString(name, url) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    url = url && url.indexOf('?') >= 0 ? url.substring(url.indexOf('?'), url.length) : window.location.search;
    var r = url.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

/*分发轨迹树形详情*/
function tree_info(id,receiver_unit) {
	$("body").append('<div class="mask"></div><div class="record-Box"><div class="record-close"></div><div id="treeinfo"></div></div>').addClass('body-overflow');
	$.ajax({
		url: '/index.php?r=report%2Fpkdata%2Fget-send-detail&id='+id,
		type: 'POST',
		beforeSend: function(){
			$("#treeinfo").append('<div class="loader"></div>');
		},
		success: function(json){
			$(".loader").remove();
			console.log(json);
			var str ="", table = "", list = "";
			if( json.status == 1 ){
				str += '<div class="container-fluid row" style="margin-top:25px; padding-left:0;"><div class="col-md-2">姓名：<b>'+json.data.uname+'</b></div>\
				<div class="col-md-8">手机：'+json.data.mobile+'<span style="padding-left: 50px;">领取单位：'+receiver_unit+'</span></div></div>';
				var tk_umb = json.data.data;
				for (var i = 0; i < tk_umb.length; i++) {
					if ( tk_umb[i].has_sent == 0 ) {
						list += '<tr><td>'+tk_umb[i].type_name+'</td><td>'+tk_umb[i].total+'</td><td>'+tk_umb[i].has_sent+'</td><td>'+tk_umb[i].left+'</td></tr>';
					} else {
						list += '<tr><td>'+tk_umb[i].type_name+'</td><td>'+tk_umb[i].total+'</td><td><a href="'+tk_umb[i].url+'" class="various" data-fancybox-type="iframe">'+tk_umb[i].has_sent+'</a></td><td>'+tk_umb[i].left+'</td></tr>';
					}
					
				}
				table += '<p class="container-fluid row" style="margin-top:20px;">票证数量：</p><table id="tb" class="table table-bordered">\
						        <thead>\
						        <tr>\
						            <th>类型</th>\
						            <th>总数</th>\
						            <th>已发</th>\
						            <th>剩余</th>\
						        </tr>\
						        </thead>\
						        <tbody>'+list+'</tbody>\
						    </table>';
				$("#treeinfo").append(str + table);
			}
		}
	})
	
}
//主办方审核，驳回
function c_reject(id, url){
	jMtext('驳回原因', '提示', '请输入驳回原因', function(r){
		$.ajax({
			cache: false,
			type: "POST",
			url: url,
			data: {'id':id,'reject_reason':r},
			async: false,
			error: function(request) {
				jAlert("您的网络不给力。。", '提示');
			},
			success: function(json) {
				if (json.status == 1) {
					if (json.message && typeof(json.message)!="undefined" && json.message!=0){
						jAlert(json.message, '提示', function(res){
							window.location.reload();
						});
					}else{
						return true;
					}
				} else if (json.message && typeof(json.message)!="undefined" && json.message!=0) {
					jAlert(json.message, '提示', function(res){
						return true;
					});
					return false;
				} else {
					return false;
				}
			}
		});
	});
}
//主办方审核，通过
function c_pass(id, url){
	jConfirm("确定通过？", "提示", function(res){
		if(res){
			$.ajax({
				cache: false,
				type: "POST",
				url: url,
				data: {"id":id},
				async: false,
				error: function(request) {
					jAlert("您的网络不给力。。", '提示');
				},
				success: function(json) {
					if (json.status == 1) {
						if (json.message && typeof(json.message)!="undefined" && json.message!=0){
							jAlert(json.message, '提示', function(res){
								window.location.reload();
							});
						}else{
							return true;
						}
					} else if (json.message && typeof(json.message)!="undefined" && json.message!=0) {
						jAlert(json.message, '提示', function(res){
							return true;
						});
						return false;
					} else {
						return false;
					}
				}
			});
		}
	});
}
//删除发布的信息
function c_delete(id, url){
	jConfirm("确定删除？", "提示", function(res){
		if(res){
			$.ajax({
				cache: false,
				type: "POST",
				url: url,
				data: {"id":id},
				async: false,
				error: function(request) {
					jAlert("您的网络不给力。。", '提示');
				},
				success: function(json) {
					if (json.status == 1) {
						if (json.message && typeof(json.message)!="undefined" && json.message!=0){
							jAlert(json.message, '提示', function(res){
								window.location.reload();
							});
						}else{
							return true;
						}
					} else if (json.message && typeof(json.message)!="undefined" && json.message!=0) {
						jAlert(json.message, '提示', function(res){
							return true;
						});
						return false;
					} else {
						return false;
					}
				}
			});
		}
	});
}
//弹出驳回理由
function c_alert(msg){
	jAlert(msg, '驳回理由');
}
//优惠活动/产品发布上传图片---开始
var adImg_test= new Image();endImgAd_test = document.getElementById("adImg")
adImg_test.onload = function () {
	 var Imgwidth=this.width;
	 var Imgheight=this.height;
//	 if( !((610< Imgwidth) && (Imgwidth< 615)) || !((215< Imgheight) && (Imgheight< 225))){
//		 $.alerts.okButton = "确定";
//		 jAlert("请上传612*220像素的活动图片！", '提示');
//		 return false;
//	 }
	 drawImgAd_test();
}
$("#ad_test").on('change',function(e){
	var file = this.files[0];
	if (file) {
		var reader = new FileReader();
		reader.readAsDataURL(file);
		
		if(file.size>80*1024){
			$.alerts.okButton = "确定";
			jAlert("请上传小于80KB的广告图。", '提示');
			$("#ad_test").val("");
			return false;
		}
		
		reader.onload = function () {
			adImg_test.src = $("#adBase64").val(reader.result).val();
			e.target.value = null;
		};
	}else {
		return false;
	}
});
function drawImgAd_test() {
	var c = document.createElement("canvas");
	c.width = 612;
	c.height = 295;
	var cxt = c.getContext("2d");
    cxt.drawImage(adImg_test, 0, 0, 612, 295);
    var value = c.toDataURL("image/png");
    endImgAd_test.src = value ;
};
//优惠活动/产品发布上传图片---结束

//修改展商数据
function modifyJoiner() {
	$('#pm').hide();
    $('#brand_id').show();
	$('#dwmc').hide();
	$('#joiner_name').show();
	$('#edit').hide();
	$('#save_but').show();
}

//取消修改展商数据
function CancelModifyJoiner() {
	$('#pm').show();
	$('#brand_id').hide();
	$('#dwmc').show();
	$('#joiner_name').hide();
	$('#edit').show();
	$('#save_but').hide();
}

//保存展商数据
function saveModifyJoiner(url,joiner_id) {
	var rel_id = $('#rel_id').val();
	var joiner_name = $('#joiner_name').val();
	var brand_id = $('#brand_id').val();
	$.ajax({
		cache: false,
		type: "POST",
		url: url,
		data: {"rel_id":rel_id,"joiner_name":joiner_name,"brand_id":brand_id},
		async: false,
		error: function(request) {
			jAlert("您的网络不给力。。", '提示');
		},
		success: function(json) {
			if (json.status == 1) {
				if (json.message && typeof(json.message)!="undefined" && json.message!=0){
					$('#pm').html(json.brand_name);
					$('#dwmc').html(json.joiner_name);
					$('#big_title').html(json.joiner_name);
					$('#dwmc_'+joiner_id).html(json.joiner_name);
					CancelModifyJoiner();
					jAlert(json.message, '提示', function(res){
						return true;
					});
				}else{
					return true;
				}
			} else if (json.message && typeof(json.message)!="undefined" && json.message!=0) {
				jAlert(json.message, '提示', function(res){
					return true;
				});
				return false;
			} else {
				return false;
			}
		}
	});
}

/*根据颜色数组循环添加背景颜色*/
function bgcolor(){
	var arr = [ '#e7505a', '#ef9226', '#f3c200', '#36d7b7', '#32c5d2', 
    '#3598dc', '#b15fd3', '#cbd046', '#5c9bd1', '#44b6ae', 
    '#95a5a6', '#f36a5a'];
    var num = $(".ticket-sent-num"), bar = $(".progress-bar");
    for (var i = 0; i < num.length; i++) {
    	num[i].style.background = arr[i];
    	bar[i].style.background = arr[i];
    }
}


/*展商管理-详情展示*/
function joiner(url){
	$("body").append('<div class="mask"></div><div class="record-Box"><div class="record-close"></div><div id="joiner"></div></div>').addClass('body-overflow');
	$.ajax({
		url: url,
		type: 'POST',
		beforeSend: function(){
			$("#joiner").append('<div class="loader"></div>');
		},
		success: function(json){
			$(".loader").remove();
			$("#joiner").append(json);
		}
	})
	
}




/*票证统计 数字滚动特效   开始*/
$.fn.countTo = function (options) {
	options = options || {};
	
	return $(this).each(function () {
		// set options for current element
		var settings = $.extend({}, $.fn.countTo.defaults, {
			from:            $(this).data('from'),
			to:              $(this).data('to'),
			speed:           $(this).data('speed'),
			refreshInterval: $(this).data('refresh-interval'),
			decimals:        $(this).data('decimals')
		}, options);
		
		// how many times to update the value, and how much to increment the value on each update
		var loops = Math.ceil(settings.speed / settings.refreshInterval),
			increment = (settings.to - settings.from) / loops;
		
		// references & variables that will change with each update
		var self = this,
			$self = $(this),
			loopCount = 0,
			value = settings.from,
			data = $self.data('countTo') || {};
		
		$self.data('countTo', data);
		
		// if an existing interval can be found, clear it first
		if (data.interval) {
			clearInterval(data.interval);
		}
		data.interval = setInterval(updateTimer, settings.refreshInterval);
		
		// initialize the element with the starting value
		render(value);
		
		function updateTimer() {
			
			value += increment;
			loopCount++;
			
			render(value);
			
			if (typeof(settings.onUpdate) == 'function') {
				settings.onUpdate.call(self, value);
			}
			
			if (loopCount >= loops) {
				// remove the interval
				$self.removeData('countTo');
				clearInterval(data.interval);
				value = settings.to;
				
				if (typeof(settings.onComplete) == 'function') {
					settings.onComplete.call(self, value);
				}
			}
		}
		
		function render(value) {
			var formattedValue = settings.formatter.call(self, value, settings);
			$self.html(formattedValue);
		}
	});
};

$.fn.countTo.defaults = {
	from: 0,               // the number the element should start at
	to: 0,                 // the number the element should end at
	speed: 1000,           // how long it should take to count between the target numbers
	refreshInterval: 100,  // how often the element should be updated
	decimals: 0,           // the number of decimal places to show
	formatter: formatter,  // handler for formatting the value before rendering
	onUpdate: null,        // callback method for every time the element is updated
	onComplete: null       // callback method for when the element finishes updating
};

function formatter(value, settings) {
	return value.toFixed(settings.decimals);
}
// custom formatting example
$('#count-number').data('countToOptions', {
formatter: function (value, options) {
  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
}
});

// start all the timers
$('.timer').each(count);  

function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
}

/*票证统计 数字滚动特效   结束*/





// 申请试用
function toSubmit(postUrl, Id){
	var company = $("#company").val();
	var job = $("#job").val();
	var name = $("#name").val();
	var mobile = $("#mobile").val();
	var message = $("#message").val();
	if(company == "" || job =="" || name == "" || mobile == "" || message == ""){
		jAlert("表单不能为空","提示");
		return;
	}
	$.ajax({
		cache: false,
		type:"POST",
		url:postUrl,
		data: $(Id).serialize(),
		success: function(json){
			if(json.status == 1){
				jAlert("您的资料已提交成功，我们会尽快联系您！","提示");
				
			}else {
				jAlert(json.message,"提示");
				return false;
			}
		},
		error: function(request){
			jAlert("发送请求失败","提示");
			return false;
		}
	});
	
	return;
}