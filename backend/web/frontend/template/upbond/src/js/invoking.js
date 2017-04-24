$(document).ready(function(){

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

});