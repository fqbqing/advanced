jQuery(document)
		.ready(
				function() {
					jQuery('#w0')
							.gtreetable(
									{
										"source" : function(id) {
											return {
												type : 'GET',
												url : URI('/index.php?r=ticketout/ticket-channel/ajax-get-tree').addSearch({'id':id}).toString(),
												//url : "./json1.json",
												dataType : 'json',
												error : function(XMLHttpRequest) {
													alert(XMLHttpRequest.status
															+ ': '
															+ XMLHttpRequest.responseText);
												}
											};
										},
										"onSave" : function(oNode) {
											return {
												type : 'POST',
												url : !oNode.isSaved() ? '/index.php?r=site%2FnodeCreate'
														: URI(
																'/index.php?r=site%2FnodeUpdate')
																.addSearch(
																		{
																			'id' : oNode
																					.getId()
																		})
																.toString(),
												data : {
													parent : oNode.getParent(),
													name : oNode.getName(),
													position : oNode
															.getInsertPosition(),
													related : oNode
															.getRelatedNodeId()
												},
												dataType : 'json',
												error : function(XMLHttpRequest) {
													alert(XMLHttpRequest.status
															+ ': '
															+ XMLHttpRequest.responseText);
												}
											};
										},
										"onDelete" : function(oNode) {
											return {
												type : 'POST',
												url : URI(
														'/index.php?r=site%2FnodeDelete')
														.addSearch(
																{
																	'id' : oNode
																			.getId()
																}).toString(),
												dataType : 'json',
												error : function(XMLHttpRequest) {
													alert(XMLHttpRequest.status
															+ ': '
															+ XMLHttpRequest.responseText);
												}
											};
										},
										"onMove" : function(oSource,
												oDestination, position) {
											return {
												type : 'POST',
												url : URI(
														'/index.php?r=site%2FnodeMove')
														.addSearch(
																{
																	'id' : oSource
																			.getId()
																}).toString(),
												data : {
													related : oDestination
															.getId(),
													position : position
												},
												dataType : 'json',
												error : function(XMLHttpRequest) {
													alert(XMLHttpRequest.status
															+ ': '
															+ XMLHttpRequest.responseText);
												}
											};
										},
										"language" : "zh-CN",
										"manyroots" : true,
										"draggable" : true,
										"inputWidth" : "300px",

										defaultActions :

										[
												{
													name : '${createLastChild}',
													event : function(oNode,
															oManager) {
														oNode.add('lastChild',
																'default');
													}
												},
												{
													name : '${createLastChild}',
													event : function(oNode,
															oManager) {
														oNode.makeEditable();
													}
												},
												{
													name : '${createLastChild}',
													event : function(oNode,
															oManager) {
														if (confirm(oManager.language.messages.onDelete)) {
															oNode.remove();
														}
													}
												}

										]

									});
				});