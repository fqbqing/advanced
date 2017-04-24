$(document).ready(function() {
	$('.tree').treegrid({
		//'initialState': 'collapsed',
		'saveState': true,
	});

	$(document).on("click",".treeTable-Operation",function(event) {
		$(this).next(".treeTable-updown").stop().slideToggle(500);
		event.stopPropagation();
	});
	$(document).on("click", function() {
		$(".treeTable-updown").fadeOut(500);
	});

});
      
function invoke(obj)
{
	$("span[id='"+obj+"']").fadeIn(500);//attr({"display":"block"});
	//$("input[id="+id+"]").parent().attr({"display":"block"});
	//$("input[id="+id+"]").parent().removeClass("treeEditInput");

}

      
      
      function open(id){
    	  $(id).treegrid('expand');
      }
        
      
      function reloadfunction() {
        	//$('.treegrid-13').treegrid('expand');
            $('.tree').treegrid({
                //'initialState': 'collapsed',
                'saveState': true,
              });   
        	
            //$('treegrid-13 treegrid-expanded').treegrid('');
        }
        
     
        function str_repeat(str, num){ 
    	  return new Array( num + 1 ).join( str ); 
    	}
    
    function addCancel(){
    	$("#addCancel").remove();
    	$(".treeInputBox").fadeOut(500);
    }
    
	function addFirstTr(fromid,fid,level,randnum,userid,exhibition_id,sendurl,locationUrl)		
	{
		//randnum = 'aaa';
		//open('.treegrid-'+fid);
		var id = 134678;
		var classname = 'treegrid-'+id;
		if (fid != '') {
			classname = classname + ' treegrid-parent-'+fid;
		}

		var str = '<tr id="addCancel" class="'+classname+'"><span class="treegrid-indent"></span><span class="treegrid-expander treegrid-expander-expanded"></span><td colspan="4"><form onsubmit="return false;" id="'+randnum+'" class="treeForm" >'+str_repeat('&nbsp;',level)+'<input type="text" class="form-control" name="TicketChannel[name]" /><input name="TicketChannel[pid]" type="hidden" value="'+userid+'" /><input name="TicketChannel[exhibition_id]" type="hidden" value="'+exhibition_id+'" /><input name="TicketChannel[fid]" type="hidden" value="'+fid+'" /><input type="button" class="btn btn-success addBtn" style="margin-left: 10px;" value="保存" onclick="doFind(\''+sendurl+'\',\'#'+randnum+'\',\'\',1,'+fid+')" /><input type="button" value="取消" onclick="addCancel()" id="treeCancel" class="btn btn-success huiBtn" style="margin-left: 10px;" /></form></td></tr>';
		$(fromid).after(str);
	}
		
    
        function addTr(fromid,fid,level,randnum,userid,exhibition_id,sendurl,locationUrl)		
		{
			//randnum = 'aaa';
		    open('.treegrid-'+fid);
			var id = 134678;
			var classname = 'treegrid-'+id;
			if (fid != '') {
				classname = classname + ' treegrid-parent-'+fid;
			}
		
			var str = '<tr id="addCancel"  class="'+classname+'"><span class="treegrid-indent"></span><span class="treegrid-expander treegrid-expander-expanded"></span><td colspan="4"><form onsubmit="return false;" id="'+randnum+'" class="treeForm" >'+str_repeat('&nbsp;',level)+'<input type="text" class="form-control" name="TicketChannel[name]" /><input name="TicketChannel[pid]" type="hidden" value="'+userid+'" /><input name="TicketChannel[exhibition_id]" type="hidden" value="'+exhibition_id+'" /><input name="TicketChannel[fid]" type="hidden" value="'+fid+'" /><input type="button" class="btn btn-success addBtn" style="margin-left: 10px;" value="保存" onclick="doFind(\''+sendurl+'\',\'#'+randnum+'\',\'\',1,'+fid+')" /><input type="button" value="取消" onclick="addCancel()" id="treeCancel" class="btn btn-success huiBtn" style="margin-left: 10px;" /></form></td></tr>';
			$(fromid).after(str);
		}
		
		function doFind(postUrl, formId, locationUrl, reload, fid) {

			//	console.log($(formId).serialize());
			var loading = document.getElementById("loading")
			$.ajax({
				cache: false,
				type: "POST",
				url: postUrl,
				data: $(formId).serialize(),
				async: false,
				beforeSend: function(XMLHttpRequest) {
					//			alert("加载开始");
//					$("body").append('<div id="loading"><div class="ToolTip">加载</div><div class="loader"></div></div>');

				},
				error: function(request) {
//					$("#loading").remove();
					//$.alerts.okButton = "确定";
					//jAlert("发送请求失败！", '提示');
					return false;

				},
				success: function(data) {
					if (reload == 1) {
						$(".tree").html(data);
						reloadfunction();
						if(fid!='') {
							open('.treegrid-'+fid);
						}
					} else {
						return true;
					}
				}
			});
		}