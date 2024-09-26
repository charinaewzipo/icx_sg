 (function($){
	var url = "distribute_process.php";
	  jQuery.dst = {
			  init:function(){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				   $.ajax({   'url' :  url ,
		        	   'data' : { 'action' : 'init' ,'data' : formtojson }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
					
						},										
						'success' : function(data){ 
							//clear current value
							$('[name=transfer_source]').val('');
							$('[name=selected_agent]').val('');
							$('[name=total_selected_agent]').val('');
							$('[name=transfer_max_amount]').val('');
							$('[name=transfer_amount]').val('');
							
							
							var  result =  eval('(' + data + ')'); 
							
							//set default user teamid
							$('[name=uteamid]').val( result.teamid );
							
							//prepare campaign
							 var camp = "<option value=''> &nbsp; </option>";
							 for( i=0 ; i<result.cmp.length ; i++){
								 camp += "<option value='"+ result.cmp[i].id +"'>"+ result.cmp[i].value +"</option>";									    										    
							 }
							 //lead source select campaign
							 $('[name=leadsource_campaign]').html( camp );
							 
							 //prepare group
							 var g = "<option value=''> &nbsp; </option>";
							 for( i=0 ; i<result.group.length ; i++){
								 	g += "<option value='"+ result.group[i].id +"'>"+ result.group[i].value +"</option>";									    										    
							 }						
							 	//agent to agent
								$('[name=agentssource_fromgroup]').html(g);
								$('[name=agentssource_togroup]').html(g);
								//db to agent
								$('[name=leadsource_togroup]').html(g);
								
						
							 
							 //prepare team
							 var t = "<option value=''> &nbsp; </option>";
							 for( i=0 ; i<result.team.length ; i++){
								 	t += "<option value='"+ result.team[i].id +"'>"+ result.team[i].value +"</option>";									    										    
							 }						
							 //agent to agent
							$('[name=agentssource_fromteam]').text('').html(t);
							$('[name=agentssource_toteam]').text('').html(t);
							//db to agent
							$('[name=leadsource_toteam]').text('').html(t);
							
						
						}//end success
				   })//end ajax			
				
			},
			 showteam:function( groupid , panel ){
				 
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				   $.ajax({   'url' :  url ,
		        	   'data' : { 'action' : 'searchteam' ,'groupid' : groupid }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
					
						},										
						'success' : function(data){ 
						
							var  result =  eval('(' + data + ')'); 
							
							 //prepare team
							 var t = "<option value=''> &nbsp; </option>";
							 for( i=0 ; i<result.team.length ; i++){
								 	t += "<option value='"+ result.team[i].id +"'>"+ result.team[i].value +"</option>";									    										    
							 }						
							 
							 if( panel == "agent_fromteam" ){
									$('[name=agentssource_fromteam]').text('').html(t);
							 }
							if( panel == "agent_toteam" ){
									$('[name=agentssource_toteam]').text('').html(t);
							}
							
							if( panel == "lead_toteam"){
								$('[name=leadsource_toteam]').text('').html(t);
							}
							
						}
				   });
			 },
			 cal_leadtransfer: function(){
				 
					var count = 0;
					$("#leadsource_team-table tbody tr.selected-row").each(function(){
						 	var self =$(this);
							count = count + 1; //parseInt($.trim( self.find('td:nth-child(2)').text() ));
					});
			
					$('[name=selected_agent]').val(count); 
					$('#leadagent_selecting-total').text('').text( count );
					
					//check
					if( $('[name=selected_agent]').val() != "" ){
						
						var maxlead   = parseInt( $('[name=transfer_source]').val() );
						var agent		 = parseInt( $('[name=selected_agent]').val() );
						var maxtransfer = 0;
						if( agent != 0 ){
							maxtransfer = Math.floor(maxlead / agent);
						}
						$('[name=transfer_max_amount]').val(maxtransfer);
						$('#max_transfer_lead').text('').text( maxtransfer );
						
					}
			
					//clear transfer amount
					$('[name=transfer_amount]').val('');
					
				 
			 },
			  leadsource_team_select: function( teamid ){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				    $.ajax({   'url' : url, 
			        	   'data' : { 'action' : 'selectteam','data':formtojson, 'teamid' : teamid  }, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
						   'beforeSend': function(){
							   //set image loading for waiting request
							   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
							},										
							'success' : function(data){ 
								
							       var  result =  eval('(' + data + ')'); 
							       
							       //show select all and uncheck select all
			                        $('#show_selectall-lead_transfer_toagent').show();
			                        $('[name=selectalllead_transfer_toagent]').removeAttr('checked');
							
							        var $table = $('#leadsource_team-table tbody'); 
									$table.find('tr').remove();
									
									var  row = "", i=0 ,  txt = "";
									var size = result.callsts.length; 
								
									if( result.callsts.result != "empty"){
										
														for( i ; i<size ; i++){ 
																	   txt +=   '<tr class="strip-onhover line">'+
															 			'<td style=" vertical-align:middle">'+ 
															 				'<div style="display:inline-block; float:left; margin-top:5px;"> <input type="checkbox" name="lead_transfer_toagent" style="width:20px; height:20px;" value="'+result.callsts[i].aid+'"></div>'+
															 				'<div style="float:left; text-indent:15px;">'+
															 						'<span style="display:block">'+result.callsts[i].aname+' &nbsp;</span>'+
															 						'<span style="display:block; color:#777;" ><span class="'+result.callsts[i].isonline+'">&nbsp;'+result.callsts[i].isonline+'&nbsp;</span></span>'+
															 				'</div>'+
															 				'<div style="clear:both"></div>'+
															 			'</td>'+
															 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tnew+' </td>'+
															 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tnoc+'</td>'+
															 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center">  '+result.callsts[i].tcallback+'</td>'+
															 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center">'+result.callsts[i].tfollow+'</td>'+
															 			'<td style=" vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tcall+'</td>'+
															 		'</tr>';
																  }
														 $table.html( txt );
														 
														 //count total agent
														 $('[name=total_selected_agent]').val( i );
														 $('#leadagent_selected-total').text('').text(i);
														 
														 //add default select status to new
														 $table.each(function(){
															 var self =$(this);
														 	 self.find('td:nth-child(2)').css({'color':'#8bc34a;','background-color':'rgba(1,1,1,0.05'});
														 });
													
														 $table.find('tr.line').click(function(){
															 var self = $(this);
															 var chkbox =  self.find('td:first > div > input[name=lead_transfer_toagent]');
															
															 //is some checkbox is uncheck remove checked all too
															 if( chkbox.is(':checked') != 0 ){ 
															    $('[name=selectalllead_transfer_toagent]').removeAttr('checked');
															 }
															 //then trigger checkbox
															 chkbox.trigger('click');
														 })
														 
														 	//check on checkbox obj
															 $('[name=lead_transfer_toagent]').click( function(){
																 var self = $(this);
																 if( !self.is(':checked')){ 
																	    $('[name=selectalllead_transfer_toagent]').removeAttr('checked');
																	 }
															 })
														
														 
														 /*
														 $('#leadsource_team-table tbody').on('click','tr.line',function(){
															 var self = $(this);
															 var chkbox =  self.find('td:first > div > input[name=lead_transfer_toagent]')
															 chkbox.trigger('click');
															
														 })
														  */
					
													$('[name=lead_transfer_toagent]').click( function(e){
															e.stopPropagation();
															var self = $(this);
															var tr = self.parent().closest('tr');
															if( self.is(':checked') ){
																tr.addClass("selected-row");
																 // tr.addClass("agent-from");
																// 	tr.children().first().css('color','#2196f3');
															}else{
																tr.removeClass("selected-row");
																//	tr.removeClass("agent-from");
																//	tr.children().first().css('color','#000');
															}
																   
															//recalculate total list transfer
															$.dst.cal_leadtransfer();
													})
												
											  
									}else{
									//no agent found	
									
									}
								
									
							}//end success
				    })//end ajax
			  },
			  lead_transferprocess:function(){
				  
						   var totalagent = $('[name=lead_transfer_toagent]:checked').length ;
						   var amount = $('[name=transfer_amount]').val(); 
						   
						   if(  $('[name=lead_transfer_toagent]:checked').length != 0 ){
							  var d = "{\"data\":[";
							  $('[name=lead_transfer_toagent]:checked').each( function(){
								  var self = $(this);
									d = d+"{\"aid\":\""+self.val()+"\"},"; 
									//d = d+"\"tlist\":\""+$.trim(amount)+"\"},"; 
									i++;
							  })
								if(i!=0){
									 d = d.substr( 0, d.lastIndexOf(",") );
									 d += "]}"; 
								}
						   }
							  
						$('.transferlead').attr('disabled','disabled').text('').text('Transfering List... ');
						  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
							  $.post(url , { "action" : "lead_transferprocess" , "data": formtojson , "totalagent": totalagent ,  "desc" : d }, function( result ){
								    var response = eval('('+result+')');  
									    if(response.result=="success"){
									    	
									          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'});
									          
									          //reload left panel 
										      	var id = $('[name=leadsource_list]').val();
											 	$.dst.lead_gettotallist( id );
										 	
											 	//reload right panel
												$.dst.leadsource_team_select( $('[name=leadsource_toteam]').val() );
									
									    	  $('.transferlead').removeAttr('disabled').text('').text('Transfer List');
									          
									    }
							 });
				  
			  },
			  lead_getlist: function( id ){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				   $.ajax({   'url' :  url  ,
		        	   'data' : { 'action' : 'list' , 'data':formtojson , 'id' : id }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
						'success' : function(data){ 
										
							var  result =  eval('(' + data + ')'); 
							
							 var option = "<option value=''> &nbsp; </option>";
							 if( id != "" ){
								   option += "<option value='all'> --- All --- </option>";
							 }
							 for( i=0 ; i<result.list.length ; i++){
								   option += "<option value='"+ result.list[i].id +"'>"+ result.list[i].value +"</option>";									    										    
							 }								
							 $('[name=leadsource_list]').text('').append(option);
							 
						}//end success
				   });
				   
			  },
			  lead_gettotallist: function(){
				  
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				    $.ajax({   'url' : url, 
			        	   'data' : { 'action' : 'getnewlist','data':formtojson }, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
						   'beforeSend': function(){
							   //set image loading for waiting request
							   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
							},										
							'success' : function(data){ 
							       var  result =  eval('(' + data + ')'); 
							       
							       //hidden value
							       $('[name=transfer_source]').val(result.indb.dbtotal);
							       
							       //show on top right 
							       $('#total_trasfer_lead').text('').text(result.indb.dbtotal );
							       
							       //show in lead
							      $('#newlist-db').text( result.indb.dbtotal );
							      
							      //calculate transfer
							      $.dst.cal_leadtransfer();
							       
							}
				    });
				  
			  },
			  //load agent working list on left and right
			  agentworking_list:function(){
				    var fromteamid = "";
					 if( $('[name=ulvl]').val() == 2 ){
						 fromteamid = $('[name=uteamid]').val();
					 }else{
						 fromteamid = $('[name=agentssource_fromteam]').val();
					 }
					
					  if( fromteamid != "" ){
						  $.dst.agentsource_fromteam_select( fromteamid );
					  }
				
					  var toteamid = $('[name=agentssource_toteam]').val();
					  if( $('[name=ulvl]').val() == 2 ){
						 toteamid = $('[name=uteamid]').val();
					  }else{
						 toteamid =   $('[name=agentssource_toteam]').val();
					  }
					  if( toteamid != ""){
						  $.dst.agentsource_toteam_select( toteamid );
					  }
				  
			  },
			  
			  //agentsource show lead name when select team
			  getlead_byteam:function(teamid){
				  
				   $.ajax({   'url' :  url  ,
		        	   'data' : { 'action' : 'workinglead' , 'teamid' : teamid }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
						'success' : function(data){ 
										
							var  result =  eval('(' + data + ')'); 
							
							 var option = "<option value=''> --- All --- </option>";
							 for( i=0 ; i<result.list.length ; i++){
							  option += "<option value='"+ result.list[i].impid +"'>"+ result.list[i].impname +"</option>";									    										    
							 }								
							 $('[name=agentssource_fromlead]').text('').append(option);
							
						}//end success
				   });
				  
			  },
	
			  //select by agent source select by lead 
			  //is used?
			  agentsource_fromlead_select: function( leadid ){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
						 $.ajax({   'url' : url , 
							        	   'data' : { 'action' : 'workingagent' , 'data' : formtojson ,'leadid' : leadid}, 
										   'dataType' : 'html',   
										   'type' : 'POST' ,  
										   'beforeSend': function(){
											   //set image loading for waiting request
											   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
											},										
											'success' : function(data){ 
									                        var  result =  eval('(' + data + ')'); 
									                        
														    var $table = $('#agentsource-fromagent-table tbody'); 
															$table.find('tr').remove();
															var i=0;
															var txt = "";
															var size = result.callsts.length; 
															if( result.callsts.result != "empty"){
															for( i ; i<size ; i++){ 
																	   txt +=   '<tr class="strip-onhover line">'+
																		 			'<td style=" vertical-align:middle">'+ 
																		 				'<div style="display:inline-block; float:left; margin-top:5px;"> <input type="checkbox" name="transfer_fromagent" style="width:20px; height:20px;" value="'+result.callsts[i].aid+'"></div>'+
																		 				'<div style="float:left; text-indent:15px;">'+
																		 						'<span style="display:block">'+result.callsts[i].aname+' &nbsp;</span>'+
																		 						'<span style="display:block; color:#777;"> lead : falcon &nbsp;</span>'+
																		 				'</div>'+
																		 				'<div style="clear:both"></div>'+
																		 			'</td>'+
																		 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tnew+' </td>'+
																		 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tnoc+'</td>'+
																		 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center">  '+result.callsts[i].tcallback+'</td>'+
																		 			'<td style="vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center">'+result.callsts[i].tfollow+'</td>'+
																		 			'<td style=" vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tcall+'</td>'+
																		 		'</tr>';
																	 }//end for
																	 $table.html( txt );
																	 
																	 //add default select status to new
																	 var hightlight = $('[name=transfer_liststatus]').val();
																	 if( hightlight != "" ){
																		 $.dst.transferstatus_selected(hightlight);
																	 }else{
																		 $.dst.transferstatus_selected(2);
																	 }
																	 
																	 $table.find('tr.line').click( function(){
																		 var self = $(this);
																		 var chkbox =  self.find('td:first > div > input[name=transfer_fromagent]');
																		 
																		 //is some checkbox is uncheck remove checked all too
																		 if( chkbox.is(':checked') != 0 ){ 
																		    $('[name=selectall_fromagent]').removeAttr('checked');
																		 }
																		 //then trigger checkbox
																		 chkbox.trigger('click');
																		 
																	 })
																	
																$('[name=transfer_fromagent]').click( function(e){
																		e.stopPropagation();
																		var self = $(this);
																		var tr = self.parent().closest('tr');
																		if( self.is(':checked') ){
																			tr.addClass("selected-row");
																		}else{
																			tr.removeClass("selected-row");
																		}
																			   
																		//recalculate total list transfer
																		$.dst.cal_agenttransfer();
																})
	
																	 
															}else{
															    var $table = $('#callmonitor-table tbody'); 
																		$table.find('tr').remove();
																		   txt +=   '<tr><td style="vertical-align:middle; text-align:center;color:#666" colspan="6"><i class="icon-info-sign"></i> No call list assigned to me </td></tr>';
																		 $table.html( txt );
															}
															 
													 }   
												});//end ajax 
				  
				  
			  },
		
			  //agent source FROM team
			  agentsource_fromteam_select: function( teamid ){ 
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					 $.ajax({   'url' : url , 
						        	   'data' : { 'action' : 'workingagent' , 'data' : formtojson ,'teamid' : teamid}, 
									   'dataType' : 'html',   
									   'type' : 'POST' ,  
									   'beforeSend': function(){
										   //set image loading for waiting request
										   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
										},										
										'success' : function(data){ 
								                        var  result =  eval('(' + data + ')'); 
								                        
								                        //show  select all and uncheck select all
								                        $('#show_selectall-fromagent').show();
								                        $('[name=selectall_fromagent]').removeAttr('checked');
								                        
													    var $table = $('#agentsource-fromagent-table tbody'); 
														$table.find('tr').remove();
														var i=0;
														var txt = "";
														var size = result.callsts.length; 
														if( result.callsts.result != "empty"){
														for( i ; i<size ; i++){ 
																   txt +=   '<tr class="strip-onhover line">'+
																	 			'<td style="margin:4px 1px; padding:4px 1px; vertical-align:middle">'+ 
																	 				'<div style="display:inline-block; float:left; margin-top:5px;"> <input type="checkbox" name="transfer_fromagent" style="width:20px; height:20px;" value="'+result.callsts[i].aid+'"></div>'+
																	 				'<div style="float:left; text-indent:15px;">'+
																	 				'<span style="display:block">'+result.callsts[i].aname+' &nbsp;</span>'+
															 						'<span style="display:block;"> <span class="'+result.callsts[i].isonline+'">&nbsp;'+result.callsts[i].isonline+'&nbsp;</span></span>'+
																	 				'</div>'+
																	 				'<div style="clear:both"></div>'+
																	 			'</td>'+
																	 			'<td style="margin:4px 1px; padding:4px 1px; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tnew+' </td>'+
																	 			'<td style="margin:4px 1px; padding:4px 1px; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tnoc+'</td>'+
																	 			'<td style="margin:4px 1px; padding:4px 1px; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center">  '+result.callsts[i].tcallback+'</td>'+
																	 			'<td style="margin:4px 1px; padding:4px 1px; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center">'+result.callsts[i].tfollow+'</td>'+
																	 			'<td style="margin:4px 1px; padding:4px 1px; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center"> '+result.callsts[i].tcall+'</td>'+
																	 		'</tr>';
																		  }
																 $table.html( txt );
																 
																 $('#fromagent_selected-total').text('').text(i);
																 
																 //add default select status to new
																 var hightlight = $('[name=transfer_liststatus]').val();
																 if( hightlight != "" ){
																	 $.dst.transferstatus_selected(hightlight);
																 }else{
																	 $.dst.transferstatus_selected(2);
																 }
																 
																 
																 $table.find('tr.line').click( function(){
																	 var self = $(this);
																	 var chkbox =  self.find('td:first > div > input[name=transfer_fromagent]');
																	 
																	 //is some checkbox is uncheck remove checked all too
																	 if( chkbox.is(':checked') != 0 ){ 
																	    $('[name=selectall_fromagent]').removeAttr('checked');
																	 }
																	 //then trigger checkbox
																	 chkbox.trigger('click');
																	 
															})
															
															//check on checkbox obj
															 $('[name=transfer_fromagent]').click( function(){
																 var self = $(this);
																 if( !self.is(':checked')){ 
																	    $('[name=selectall_fromagent]').removeAttr('checked');
																	 }
															 })
														 
															$('[name=transfer_fromagent]').click( function(e){
																	e.stopPropagation();
																	var self = $(this);
																	var tr = self.parent().closest('tr');
																	if( self.is(':checked') ){
																		tr.addClass("selected-row");
																		 // tr.addClass("agent-from");
																		// 	tr.children().first().css('color','#2196f3');
																	}else{
																		tr.removeClass("selected-row");
																		//	tr.removeClass("agent-from");
																		//	tr.children().first().css('color','#000');
																	}
																		   
																	//recalculate total list transfer
																	$.dst.cal_agenttransfer();
															})
																															 
														}else{
														    var $table = $('#callmonitor-table tbody'); 
																	$table.find('tr').remove();
																	   txt +=   '<tr><td style="vertical-align:middle; text-align:center;color:#666" colspan="6"><i class="icon-info-sign"></i> No call list assigned to me </td></tr>';
																	 $table.html( txt );
														}
														 
												 }   
								});//end ajax 
			  },
		
			  //agent source TO team
			  agentsource_toteam_select: function( teamid ){
				  
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					 $.ajax({   'url' : url , 
						        	   'data' : { 'action' : 'workingagent' , 'data' : formtojson , 'teamid' : teamid}, 
									   'dataType' : 'html',   
									   'type' : 'POST' ,  
									   'beforeSend': function(){
										   //set image loading for waiting request
										   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
										},										
										'success' : function(data){ 
								                        var  result =  eval('(' + data + ')'); 
								                    
								                        //show select all and uncheck select all
								                        $('#show_selectall-toagent').show();
								                        $('[name=selectall_toagent]').removeAttr('checked');
								                        
													    $table = $('#agentsource-toagent-table tbody');
														$table.find('tr').remove();
													      var txt = "";
													  	 for( i=0 ; i<result.callsts.length ; i++){
													  		 
													  	   txt +=   '<tr class="strip-onhover line">'+
															 			'<td style="margin:4px 1px; padding:4px 1px; vertical-align:middle">'+ 
															 				'<div style="display:inline-block; float:left; margin-top:5px;"> <input type="checkbox" name="transfer_toagent" style="width:20px; height:20px;" value="'+result.callsts[i].aid+'"></div>'+
															 				'<div style="float:left; text-indent:15px;">'+
															 						'<span style="display:block">'+result.callsts[i].aname+' &nbsp;</span>'+
															 						'<span style="display:block;"> <span class="'+result.callsts[i].isonline+'">&nbsp;'+result.callsts[i].isonline+'&nbsp;</span></span>'+
															 				'</div>'+
															 				'<div style="clear:both"></div>'+
															 			'</td>'+
															 			'<td style="margin:4px 1px; padding:4px 1px; color:#8bc34a; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;font-weight:600" class="text-center col2"> '+result.callsts[i].tnew+' </td>'+
															 			'<td style="margin:4px 1px; padding:4px 1px; color:#8bc34a; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa; font-weight:600;" class="text-center col3"> '+result.callsts[i].tnoc+'</td>'+
															 			'<td style="margin:4px 1px; padding:4px 1px; color:#8bc34a; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa; font-weight:600;" class="text-center col4">  '+result.callsts[i].tcallback+'</td>'+
															 			'<td style="margin:4px 1px; padding:4px 1px; color:#8bc34a; vertical-align:middle; font-size:20px; font-family:lato; color:#aaa;  font-weight:600;" class="text-center col5">'+result.callsts[i].tfollow+'</td>'+
															 			'<td style="margin:4px 1px; padding:4px 1px; color:#8bc34a;  vertical-align:middle; font-size:20px; font-family:lato; color:#aaa; font-weight:600;" class="text-center colx"> '+result.callsts[i].tcall+'</td>'+
																  	   '</tr>';
													  	   
														 }				
													  	 
													  	 $table.html( txt );
													  	 
													  	 //count total agent
													  	 $('[name=total_selected_agent]').val( i );
													  	 $('#toagent_selected-total').text('').text(i);
													  	 
													  	 
													  	 //add default select status to new
														 var hightlight = $('[name=transfer_liststatus]').val();
														 if( hightlight != "" ){
															 $.dst.transferstatus_selected(hightlight);
														 }else{
															 $.dst.transferstatus_selected(2);
														 }
												 
													  	 /*
														 $table.each(function(){
															 var self =$(this);
														 	 self.find('td:nth-child(2)').css({'color':'#8bc34a;','background-color':'rgba(1,1,1,0.05)'});
														 });
														 */
												
														 $table.find('tr.line').click( function(){
															// console.log("click");
															 var self = $(this);
															 var chkbox =  self.find('td:first > div > input[name=transfer_toagent]')
															 
															 //is some checkbox is uncheck remove checked all too
															 if( chkbox.is(':checked') != 0 ){ 
															    $('[name=selectall_toagent]').removeAttr('checked');
															 }
															 //then trigger checkbox
															 chkbox.trigger('click');
															
														 })
														 
														 //check on checkbox obj
														 $('[name=transfer_toagent]').click( function(){
															 var self = $(this);
															 if( !self.is(':checked')){ 
																    $('[name=selectall_toagent]').removeAttr('checked');
																 }
														 })
														 
														 
													
													  	 
													 	$('[name=transfer_toagent]').click( function(e){
																e.stopPropagation();
																var self = $(this);
																var tr = self.parent().closest('tr');
																if( self.is(':checked') ){
																	tr.addClass("selected-row");
																	 // tr.addClass("agent-from");
																	// 	tr.children().first().css('color','#2196f3');
																}else{
																	tr.removeClass("selected-row");
																	//	tr.removeClass("agent-from");
																	//	tr.children().first().css('color','#000');
																}
																	   
																//recalculate total list transfer
																$.dst.cal_agenttransfer();
														})
												
												 }  //end success 
											});//end ajax 
			  },
			  //recalculate total list transfer
			  transferstatus_selected: function( val ){
				  	   //add value;
				  
					  $('[name=transfer_liststatus]').val( val );
						//form table
						$("#agentsource-fromagent-table tr td").not(':nth-child(1)').css({'color':'#aaa','background-color':'transparent'});
						$("#agentsource-fromagent-table").each(function(){
							 var self =$(this);
							 		self.find('td:nth-child('+val+')').css({'color':'#2196f3','background-color':'rgba(1,1,1,0.05'});
						});
						//to table
						$("#agentsource-toagent-table tr td").not(':nth-child(1)').css({'color':'#aaa','background-color':'transparent'});
						$("#agentsource-toagent-table").each(function(){
							 var self =$(this);
							 		self.find('td:nth-child('+val+')').css({'color':'#8bc34a','background-color':'rgba(1,1,1,0.05'});
						});
				
					
					//recalculate total transfer list
					$.dst.cal_agenttransfer();
			  },
			  cal_agenttransfer:function(){
					var count = 0;
					//sum from agent
					var total = 0;
					$("#agentsource-fromagent-table tbody tr.selected-row").each(function(){
						 	var self =$(this);
							total = total + parseInt($.trim( self.find('td:nth-child('+$('[name=transfer_liststatus]').val()+')').text()));
						 	count = count + 1;
					});
					
					$('[name=transfer_source]').val(total); //hiden value 
					$('#total_trasfer_lead').text('').text( total ); //show info
					
					$('#fromagent_selecting-total').text('').text(count); 
				
					
					//sub to agent
					count = 0;
					$("#agentsource-toagent-table tbody tr.selected-row").each(function(){
					 	//var self =$(this);
						count = count + 1; //parseInt($.trim( self.find('td:nth-child(2)').text() ));
					});
					$('[name=selected_agent]').val(count); //not used
					$('#toagent_selecting-total').text('').text(count); 
					
					//check
					if( $('[name=selected_agent]').val() != "" ){
						var maxlead   = parseInt( $('[name=transfer_source]').val() );
						var agent		 = parseInt( $('[name=selected_agent]').val() );
						var maxtransfer = 0;
						if( agent != 0 ){
							maxtransfer = Math.floor(maxlead / agent);
						}
						$('[name=transfer_max_amount]').val(maxtransfer); //hidden value
						$('#max_transfer_lead').text('').text( maxtransfer );
					}
			
					//clear transfer amount
					$('[name=transfer_amount]').val('');
					
			  },
			 agent_transferprocess:function(){
				  
				 var totalagent = $('[name=transfer_toagent]:checked').length ;
				//   var amount = $('[name=transfer_amount]').val(); 
				   
				   if(  $('[name=transfer_fromagent]:checked').length != 0 ){
						  var s = "{\"data\":[";
						 var i = 0;
						  $('[name=transfer_fromagent]:checked').each( function(){
							  var self = $(this);
								s = s+"{\"aid\":\""+$.trim( self.val() )+"\"},"; 
								i++;
						  })
							if(i!=0){
								 s = s.substr( 0, s.lastIndexOf(",") );
								 s += "]}"; 
							}
				   }//end if
			   
				if(  $('[name=transfer_toagent]:checked').length != 0 ){
							  var d = "{\"data\":[";
							  var i = 0;
							  $('[name=transfer_toagent]:checked').each( function(){
								  var self = $(this);
									d = d+"{\"aid\":\""+$.trim( self.val() )+"\"},"; 
									i++;
							  })
								if(i!=0){
									 d = d.substr( 0, d.lastIndexOf(",") );
									 d += "]}"; 
								}
						   
				  }//end if
					  
				$('.transferagent').attr('disabled','disabled').text('').text('Transfering List... ');
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				  $.post(url , { "action" : "agent_transferprocess" , "data": formtojson , "totalagent": totalagent , "source" : s ,  "desc" : d }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							    	
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'});
							          
							      		$.dst.agentworking_list();
							          /*
							     	 if( $('[name=ulvl]').val() == 2 ){
										 //load pane
							     		$.dst.agentworking_list();
									 }else{
										 $.dst.agentworking_list();
									 }
							     	 */
			
							          //reload left panel
							        //  $.dst.agentsource_fromteam_select( $('[name=agentssource_fromteam]').val() );
							          
							          //reload right panel
									//  $.dst.agentsource_toteam_select( $('[name=agentssource_toteam]').val() );
									  
							    	  $('.transferagent').removeAttr('disabled').text('').text('Transfer List');
							          
							    }
					 });
				  
	  
		  
			 },
			  
	  }
	
 })(jQuery);