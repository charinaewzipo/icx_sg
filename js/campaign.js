(function($){
	var url = "campaign-pane_process.php";
	var currentRow = null; 
	var captionRow = null;
	var captionSelect = "";
	  jQuery.campaign = {
		//init info for create new campaign	  
		init:function(){
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'init' }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
									
			                        var  result =  eval('(' + data + ')'); 
			                        
								      //sale script
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.script.length ; i++){
									  option += "<option value='"+ result.script[i].id +"'>"+ result.script[i].value +"</option>";									    										    
									 }
									 $('[name=nscriptname]').text('').append(option);
									 
									 //external application
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.app.length ; i++){
									  option += "<option value='"+ result.app[i].id +"'>"+ result.app[i].value +"</option>";									    										    
									 }								
									 $('[name=ncmpApp]').text('').append(option);
									
					}
			   })//end ajax			
					
			
		},
	    load: function(){
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query' }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
									//remove image loading 
									//$('#loading').html('').append("Project Management Sheet");
									
			                        var  result =  eval('(' + data + ')'); 
								    var $table = $('#campaign-table tbody'); 
									$table.find('tr').remove();
									var i=0;
							
											 for( i=0 ; i<result.length ; i++){
												 seq = i;
											     seq++;
											     
											     $row = $("<tr id='"+result[i].cmpid+"'><td style='vertical-align:middle; text-align:right' >&nbsp;"+seq+"&nbsp;</td>"+
											    		   "<td ><a href='#' class='nav-cmp-id'><strong>"+result[i].cmpName+"</strong></a><br/>"+result[i].cmpDetail+"</td>"+	
											    		   "<td class='text-center' style='vertical-align:middle'>&nbsp;"+result[i].cmpStartDate+"&nbsp;</td>"+
											    		   "<td class='text-center' style='vertical-align:middle'>&nbsp;"+result[i].cmpEndDate+"&nbsp;</td>"+
														   "<td class='text-center' style='vertical-align:middle;' ><span style='width:100px; display:inline-block; padding:3px 6px; border-radius:3px; color:#fff; background-color:"+result[i].cmpStatusColor+";font-size:12px; '> "+result[i].cmpStatusDetail+" </span></td></tr>");	 
											     
												  $row.appendTo($table);
												  $.campaign.gridSet($row);
												  
											    } 
											
											 //add event
											   $('.nav-cmp-id').off('click').bind('click',function(e){
										    	     e.preventDefault();
										    	     $.campaign.detail( $(this).parent().parent().attr('id')  );
										    	     
										    	    	$('#campaign-main-pane').hide();
										            	$('#campaign-detail-pane').show();
										            	 
									           })
											    
					                if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='5' class='text-center'>&nbsp; No Campaign &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{
										var $table = $('#campaign-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='5'  style='border-bottom:1px solid #E2E2E2' ><small> Total "+i+" Campaign"+s+" </small></td></tr>");
										$addRow.appendTo($table);
									}
									
							 }   
						});//end ajax 
	    	
	    },	   
	    detail:function( id ){
			    $.ajax({   'url' : url, 
					   'data' : { 'action' : 'detail','id': id }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
						   //set image loading for waiting request
						   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
						},										
						'success' : function(data){ 
							//remove image loading 
							//$('#loading').html('').append("Project Management Sheet");
							
							var  result =  eval('(' + data + ')'); 
		                 
		                 //reset current checkbox
		                 $('[name=confirm_stop_cmp]').attr('checked', false);
		                 $('[name=confirm_delete_cmp]').attr('checked', false);
		            
		             		//select sale script
			                var option = "<option value=''> &nbsp; </option>";
							 for( i=0 ; i<result.callscript.length ; i++){
							  option += "<option value='"+result.callscript[i].id +"'>"+ result.callscript[i].value +"</option>";									    										    
							 }								
							 $('[name=scriptname]').text('').append(option);
							 
							//select sale script
			                 option = "<option value=''> &nbsp; </option>";
							 for( i=0 ; i<result.app.length ; i++){
							  option += "<option value='"+result.app[i].id +"'>"+ result.app[i].value +"</option>";									    										    
							 }								
							 $('[name=cmpApp]').text('').append(option);

							//select cmptype
							$("select[name=cmpType]").val(result.data.cmpType);
							//select cmpStatus
							$("select[name=cmpStatus]").val(result.data.cmpStatus);

							
		
			           	  $('[name=cmpid]').val(result.data.cmpid);
						  $('[name=cmpName]').val(result.data.cmpName);
			              $('[name=cmpDetail]').val(result.data.cmpDetail);
			              $('[name=cmpStartDate]').val(result.data.cmpStartDate); 
			              $('[name=cmpEndDate]').val(result.data.cmpEndDate); 
			            //   $('[name=cmpStatus]').val(result.data.cmpStatus); 
						  $('[name=scriptname]').val(result.data.callscriptid);
						  $('[name=scriptdtl]').val(result.data.callscriptdtl);
						  $('[name=cmpApp]').val(result.data.cmpApp);
						  $('[name=cmpMaxCall]').val(result.data.maxCall);
						  $('[name=cmpGeneQueue]').val(result.data.cmpGeneQueue);
						  $('[name=cmpGeneCampaign]').val(result.data.cmpGeneCampaign);
					
						  
						  $('#cmpCreateu').text('').text( result.data.createu ); 
						  $('#cmpCreated').text('').text( result.data.created );
						  $('#cmp-detail-name').text('').text( result.data.cmpName );
				
						  //clear current status action
						  $('#cmp-startdelete-pane,#cmp-delete-pane,#cmp-stop-pane').hide();
						  //$('#cmp-delete-pane').hide();
						  //$('#cmp-stop-pane').hide();
						  
						
						  //check status for display rightbox
						  var check = parseInt( result.data.cmpStatus );
						  if(check==4){ 
							  //status 4 is stop add blink effect
							  $('#cmpStatus').text('').text( result.data.cmpStatusDtail ).css('background-color',  result.data.cmpStatusColor ).addClass('blink');
						  }else{
							  $('#cmpStatus').text('').text( result.data.cmpStatusDtail ).css('background-color',  result.data.cmpStatusColor ).removeClass('blink');
						  }
						
						  switch( check ){
						  		case 1 : $('#cmp-delete-pane').show();  break;
						  		case 2 : $('#cmp-stop-pane').show(); break;
						  		case 3 : $('#cmp-stop-pane').show(); break;
						  		case 4 : $('#cmp-startdelete-pane').show(); break;
						 		case 5 : $('#cmp-stop-pane').show(); break;
						  }
						
							 $('#cmplist-campaign-not-ready-pane,#cmplist-listexp-pane,#cmplist-pause-pane, #cmplist-resume-pane').hide();
							 $('#cmplist-start-pane,#cmplist-nolist-pane,#cmplist-mapping-pane,#cmplist-delete-pane').hide();
							 $('.cmplist-remove').removeAttr('data-listid');  //remove current list id;
							 
							   var $table = $('#cmplist-mapped-table tbody'); 
								$table.find('tr').remove();
								var seq=0;
								var listava=0;
								
								var rightbox = $('#rightbox-ul');
								rightbox.find('li').remove();
								
								//console.log("cmplist : "+result.cmplist.length );
								//console.log("impid : "+result.cmplist[0].impid );
								
								//left box ( match list )
								//if(result.cmplist.impid != "empty" ){
							    if( result.cmplist[0].impid != "" ){
									//display match list
									var seq = 0;
									for( i=0 ; i<result.cmplist.length ; i++){
										seq++;
										if( result.cmplist[i].isexpireid == 4 ){
											result.cmplist[i].joinstausid = result.cmplist[i].isexpireid;
											result.cmplist[i].joinstausdtl = result.cmplist[i].isexpiredtl;
											result.cmplist[i].stscolor =  result.cmplist[i].isexpirecolor;
										}
									    $row = $("<tr data-listid='"+result.cmplist[i].impid+"' data-liststatus='"+result.cmplist[i].joinstausid+"' >"+
											    		 "<td style='vertical-align:middle; text-align:center'>"+seq+"</td>"+	
											    		 "<td style='vertical-align:middle'>"+result.cmplist[i].lname+"<br/><span style='font-style:italic; color#666; font-weight:400; font-family:lato; font-size:12px;'>Join campaign date "+result.cmplist[i].jdate+"</span></td>"+
											    		 "<td style='text-align:center;vertical-align:middle; font-size:20px; color:#555;'>"+result.cmplist[i].total+"</td>"+
											    		 "<td style='text-align:center;vertical-align:middle; font-size:20px; color:#555;'>"+result.cmplist[i].unassign+"</td>"+
											    		 "<td style='text-align:center;vertical-align:middle; font-size:20px; color:#555;'>"+result.cmplist[i].assign+"</td>"+
											    		 "<td style='text-align:center;vertical-align:middle; font-size:20px; color:#555;'>"+result.cmplist[i].other+"</td>"+
											    		 "<td style='text-align:center;vertical-align:middle' ><span style='background-color:"+result.cmplist[i].stscolor+"; color:#fff; padding:2px 8px 2px 8px; border-radius:3px; font-size:12px;'>"+result.cmplist[i].joinstausdtl+"</span></td></tr>");	 
									    $row.appendTo($table);
									}
								
							
								}else{
									// no match list found
								 	$table = $('#cmplist-mapped-table tbody'); 
						 			$table.find('tr').remove();
						 			txt = "<tr data-listava='0'><td colspan='7' style='text-align:center;border:1px solid #E2E2E2'> No list mapped to this campaign </td></tr>";
						 			$table.html(txt)
									
								}
								
								//right box ( ava list )
								//first check condition campaign status must have 2 and over 
				
								if( result.data.cmpStatus != 1 ){
											if( result.listava.result != "empty"){
													for( i=0 ; i<result.listava.length ; i++){
															$list = $('<li data-listid="'+result.listava[i].impid+'" data-class="chbox" data-check="uncheck"  >'+
																	 '<div  style="float:left; display:inline-block; font-size:24px; padding:2px 4px 2px 4px" class="ion-ios-circle-outline ucheck"></div>'+ 
																	 '<div style="float:left; display:inline-block; font-size:16px; padding:6px; color:#555">'+result.listava[i].lname+'</div> '+
																	 '<div style="float:right; display:inline-block;text-align:right; padding:6px;">'+
																	'<span style="font-size:12px; color:#fff; background-color:#ed5565; padding:2px 8px 2px 8px; border-radius:3px;">'+result.listava[i].total+' call lists</span> '+
																	 '</div>'+
																	 '<div style="clear:both"></div>'+
																	 '</li>');
															$list.appendTo(rightbox);
													}
											}
											
											$('.cmplist_ava').text('').text(result.listava.length);
											 
									    	//check for show right cmp
											console.log( "check list ava : "+result.listava.length );
											
											if( result.listava.length > 0){
											 	$('#cmplist-start-pane').show();
											 	$('.back-to-mapping-pane').show();
											}else{
												$('#cmplist-nolist-pane').show();
												$('.back-to-mapping-pane').hide();
											}
											
											 //check 
											if( seq == 0 && listava > 0){
												  var s = "";
												   if(listava >=2){
													   var s = "s"
												   }
												}
											
								              if(seq==0){
								            		 $table = $('#cmplist-mapped-table tfoot'); 
													$table.find('tr').remove();
								               }else{
													 $table = $('#cmplist-mapped-table tfoot'); 
													$table.find('tr').remove();
													var s = "s";
													if(i<1){	s = "";	}
												    $addRow = $("<tr ><td colspan='7'  style='border-bottom: 1px solid #EAEAEA' ><small> Total "+seq+" List"+s+" </small></td></tr>");
													$addRow.appendTo($table);
												}
								
								}//end if check campaign status 
								else{
									//show plese set campaign field first pane 
									$('#cmplist-campaign-not-ready-pane').show();
									
								}
								
								// $('#cmplist-start-pane').show(); //default list pane
								 //check total list before enable
								
							
					      
						
			   		
			   		
			   		
							   	  //tab campaign field
					          	  //load field list
								 //when click campaign already
					          	  $.campaign.load_field();
	 
						
								
			              
						}//end success
					});//end ajax 
			},	  
			 create:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "create" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							    	
							    	  $('[name=cmpuniqueid]').val( response.cmpuniqueid ) //remember last save
							          $.campaign.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
		    },
			 update:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "update" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							          $.campaign.load();	
									  $.campaign.detail( $('[name=cmpid]').val() );			
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
		    },
		    //campaign action button
		    //remove
		    cmpremove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "removecmp" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						        $.campaign.load();						
						    	$('#campaign-main-pane').show();
				            	$('#campaign-detail-pane').hide();
						    }
				 });
		    
		    },
		    //stop
		    cmpstop:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "stopcmp" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	  $.campaign.detail( $('[name=cmpid]').val() );				
							       $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
						    }
				 });
		    	
		    },
		    //start
		    cmpstart:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "startcmp" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	   $.campaign.detail( $('[name=cmpid]').val() );				
							       $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
						    }
				 });
		    },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=teamid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        })
			         .click( function(){
			        	
			        	  $('[name=cmpid]').val( $row.attr('id') );	
			        	   $('#campaign-table tr.selected-row').removeClass('selected-row');
			        	   $row.addClass('selected-row');
			        	
			        })			        
			        .dblclick( function(e){
				    	 $.campaign.detail( $row.attr('id') );
				    	 
				      	 $('#campaign-main-pane').hide();
				    	 $('#campaign-detail-pane').show();				 
				    })
				  
			  },
			  //cmp list
			  //save list
			  cmplist_save: function(){
				  console.log("save campaign list ");
				  
					var listid = [];
					$('#rightbox-ul [data-check=check]').each( function(){
						var self = $(this).attr('data-listid');
						listid.push( self );
					})
			  
					 var listid = JSON.stringify(listid);
					 var formtojson =  JSON.stringify( $('form').serializeObject() );  
					  $.post(url , { "action" : "savelist" , "data": formtojson , "list":listid }, function( result ){
						       var response = eval('('+result+')');  
							    if(response.result=="success"){
							    	$.campaign.detail( $('[name=cmpid]').val() );
							    }
					 });
			  },
			  //remove list
			  cmplist_remove: function(){
				  var listid = $('.cmplist-remove').attr('data-listid');
				  if( listid == ""){  alert("ERR: no list found to delete "); }
				  var formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "removelist" , "data": formtojson , "list":listid }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.campaign.detail( $('[name=cmpid]').val() );
						    }
				 });
				  
			  },
			  //tab campaign field
	    load_field: function(){
	      	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
	        $.ajax({   'url' : url, 
				   'data' : { 'action' : 'loadcaption' , 'data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
					//remove image loading 
					//$('#loading').html('').append("Project Management Sheet");
		
	                   var  result =  eval('(' + data + ')'); 
	             		//select field 
	                 	var option = "<select name='cmpf[]'>";
	                 		   option = option + "<option value=''> &nbsp; </option>";
						 for( i=0 ; i<result.caption.length ; i++){
						  option += "<option value='"+result.caption[i].id +"'>"+ result.caption[i].value +"</option>";									    										    
						 }								
						 	  option = option + "</select>";
			
						 	  //set global parameter
						 	 captionSelect = option;
						 //load current field in campaign
						var table =  $('#cmp-captionfield-table tbody');
						table.find('tr').remove();
						var i = 0;
						 for( i=0;i< result.data.length; i++){
							var seq = i;
							seq++;
							
							var ch1 = "";
							var ch2 = "";
							if( result.data[i].callwork == 1){
									ch1 = "checked";
							}
							if( result.data[i].profile == 1){
								    ch2 = "checked";
							}
							 
						     $row = $("<tr id='"+result.data[i].id+"'><td style='vertical-align:middle; text-align:center' >&nbsp;"+seq+"<input type='hidden' name='seq[]' value='"+seq+"'>&nbsp;</td>"+
						    		   "<td >&nbsp;<input type='text' name='cmpn[]' value='"+result.data[i].capn+"'></td>"+	
						    		   "<td class='text-center' style='vertical-align:middle' data-option='option' >"+option+"</td>"+
						    		   "<td class='text-center' style='vertical-align:middle' >&nbsp;<input type='text' name='cmpo[]' value='"+result.data[i].capopt+"'></td>"+
						    		   "<td class='text-center' style='vertical-align:middle'>&nbsp;<input type='checkbox' name='cmpsw[]' value='"+seq+"' "+ch1+">&nbsp;</td>"+
									   "<td class='text-center' style='vertical-align:middle'>&nbsp;<input type='checkbox' name='cmpsp[]' value='"+seq+"' "+ch2+" >&nbsp;</td></tr>");	 
						     
						     //selected value in select option
						     $row.find('[data-option]').children().val(  result.data[i].fieldn );
					 
						     $row.appendTo(table);
							 $.campaign.gridset_caption( $row );
						 }
						 
						    if(i==0){   
							     $row = $("<tr id='nodata'><td colspan='6' class='text-center'>&nbsp No Campaign Field Configuration  &nbsp;</td></tr>")
							     $row.appendTo(table);
							}
						 
					}
	        })//end ajax
	    	
	    },
		add_caption:function(){
			
			var $table = $('#cmp-captionfield-table tbody');
	
				if(  String( $table.find('tr').attr('id')) =="nodata"){ 
					  $table.find('tr').remove(); 
			     }       
				
			
			var $row = $("<tr><td class='text-center' style='vertical-align:middle'> </td><td><input type='text' name='cmpn[]'></td><td class='text-center' style='vertical-align:middle' data-option='option'>"+captionSelect+"</td><td class='text-center' style='vertical-align:middle'>&nbsp;<input type='text' name='cmpo[]'></td><td class='text-center' style='vertical-align:middle'> <input type='checkbox' name='cmpsw[]' value='1' checked='true' ></td><td class='text-center' style='vertical-align:middle'><input type='checkbox' name='cmpsp[]' value='1' checked='true' ></td></tr>");
			 $.campaign.gridset_caption( $row );
			 $table.append( $row );
			 
				//reindex 
				$.campaign.grid_reIndex();
		},
		remove_caption:function(){
			
			   //remove  row 
			$('#cmp-captionfield-table tbody tr.selected-row').remove();

		    if( $('#cmp-captionfield-table  tbody tr').length==0){
			     $row = $("<tr id='nodata'><td colspan='6' class='text-center'>&nbsp No Campaign Field Configuration  &nbsp;</td></tr>");
			 	 var table = $('#cmp-captionfield-table tbody');
			     $row.appendTo(table);
			 }else{
				   //reindex
					$.campaign.grid_reIndex();
			 }
		
		},
		gridset_caption: function( $row ){
		    $row 
			.find('td').click( function(e){
				$('[name=teamid]').val( $row.attr('id') );	
			})
			.hover( function(){
				 $row.addClass('row-hover');
			}, function() {
			    $row.removeClass('row-hover');
	        })
	         .click( function(){
	        	
	        	 // $('[name=cmpid]').val( $row.attr('id') );	
	        	   $('#cmp-captionfield-table  tr.selected-row').removeClass('selected-row');
	        	   $row.addClass('selected-row');
	        	
	        })			        
	        .dblclick( function(e){
	        	/*
		    	 $.campaign.detail( $row.attr('id') );
		      	 $('#campaign-main-pane').hide();
		    	 $('#campaign-detail-pane').show();
		    	 */				 
		    })
			
		},
		 grid_reIndex : function(){
	          
				var $seq = $('#cmp-captionfield-table tbody tr');
				var count =0;
				var seq = "";
				$seq.each( function( index ){
				     	   count++;  
						    $(this).find('td').first().text('').html("&nbsp;"+count+"<input type='hidden' name='seq[]' value='"+count+"'>&nbsp;");
							$(this).find('input[name="cmpsw[]"]').val(count);
							$(this).find('input[name="cmpsp[]"]').val(count);
				}); //end each
				
		  },		
		save_caption:function(){
		   	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
		   	$.post(url , { "action" : "savecaption" , "data": formtojson  }, function( result ){
				  	$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
				  	$.campaign.detail( $('[name=cmpid]').val());
			});
		
		},
		joinList :function(){
			
		   	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
		   	$.post(url , { "action" : "joinList" , "data": formtojson }, function( result ){
				  	$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
			});
			
		},
		unjoinList:function(){
			
		   	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
		   	$.post(url , { "action" : "unjoinList" , "data": formtojson }, function( result ){
				  	$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
			});
		},
		summary:function(){
		  		var  formtojson =  JSON.stringify( $('form').serializeObject() );  
			   $.ajax({   'url' : url, 
				   'data' : { 'action' : 'summary' , 'data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
				
						
	                   var  result =  eval('(' + data + ')');  
	                   console.log("🚀 ~ result:", result.cmp)
	                   
	                   //campaign detail
	                   $('#cmname').text('').text( result.cmp.cmpname );
	                   $('#cmname').text('').text( result.cmp.cmpdtl );
	                   $('#cmsdate').text('').text( result.cmp.startdate );
	                   $('#cmedate').text('').text( result.cmp.enddate );
	                   $('#cmstst').text('').html('<span style="border-radius:3px; background-color:#000; color:#fff; padding:2px 8px; position:relative; display:inline-block ">'+result.cmp.statusdtl+'</span>' );
	                   $('#cmdate').text('').text( result.cmp.cred );
	                   $('#cmcre').text('').text( result.cmp.cname );
	                   
	                   //campaign list
	                   var $tbody = $('#campaign-list-summary tbody');
	                   $tbody.find('tr').remove();
	                   var i = 0;
	                   
	                   var total = 0;
	                   var bad = 0;
	                   var listdup = 0;
	                   var indbdup = 0;
	                   
	                   for( i ; i<result.data.length ; i++){
					 
					     $row = $("<tr id='"+result.data[i].impid+"'>"+
					    		   "<td ><a href='#' class='nav-list-id'><strong>"+result.data[i].lname+"</strong></a><br/>"+result.data[i].ldtl+" | list create date , list create by , last join campaign date | list status NEW </td>"+	
					    		   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+result.data[i].total+"&nbsp;</td>"+
					    		   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+result.data[i].bad+"&nbsp;</td>"+
					    		   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+result.data[i].listdup+"&nbsp;</td>"+
					    		   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+result.data[i].indbdup+"&nbsp;</td>"+
								   "<td style='text-align:center;vertical-align:middle; font-size:20px;' >&nbsp;"+result.data[i].listdup+"&nbsp;</td></tr>");	 
					     
					     		total = total + parseInt(result.data[i].total);
					     		bad = bad + parseInt(result.data[i].bad);
					     		listdup = listdup + parseInt(result.data[i].listdup);
					     		indbdup = indbdup + parseInt(result.data[i].indbdup);
					     
					     
						  $row.appendTo($tbody);
						  
					    } 
	                   
	                   console.log( "result.length",result.data.length );
	                   if(  result.data.length  != 0 ){
	                	    var $tfoot = $('#campaign-list-summary tfoot');
	                	    $tfoot.find('tr').remove();
		 	                
			 	      	     $row = $("<tr >"+
			 	      	    		 		  "<td style='text-align:right;vertical-align:middle'>&nbsp; Total &nbsp;</td>"+
							 	      	   	   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+total+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+bad+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+listdup+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle; font-size:20px;'>&nbsp;"+indbdup+"&nbsp;</td>"+
											   "<td style='text-align:center;vertical-align:middle; font-size:20px;' >&nbsp;"+listdup+"&nbsp;</td></tr>");	 
		 	      	     
			 	      	     $row.appendTo($tfoot);
	                	   
	                   }else{
	                	
	                	   
	                   }
	                   
	                   
	                   
	                   
					}//end success
			   });
			
		},
		wrapup:function(){
			
				var  formtojson =  JSON.stringify( $('form').serializeObject() );  
			   $.ajax({   'url' : url, 
				   'data' : { 'action' : 'wrapup' , 'data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
						
				
						var  result =  eval('(' + data + ')');  
	                   

				            //start wrapup tree
						 		
						 		   wrapup =  result.wrapup ;
					        		res = JSON.search( result.wrapup , '//*[ pcode  = 0 ]' );
					        		var $ul = $('#wtree');
					        		$ul.find('li').remove();
					        		for( i=0 ; i< res.length ; i++ ){
					        			$ul.append('<li data-id='+res[i].wcode+' data-parent='+res[i].pcode+'>'+res[i].wdtl+'</li>');
					        		}
				
					               //  console.log(  wrapup[2]);
				
					        	console.log( $('ul.wtree li:last-child') );
				
								$('ul.wtree li:last-child').css('background','url(images/wtree-lastnode.png) no-repert') 
						
								
				
				
							
							//tab wrapup config
							//console.log( result.wrapup );
						   /* tree test  		   
							var data = [
							            { "x": 2, "y": 0 },
							            { "x": 3, "y": 1 },
							            { "x": 4, "y": 1 },
							            { "x": 2, "y": 1 }
							         ]
							         
							$('#wcfg').val('');
							//console.log( result.wrapup  )
							         
							res = JSON.search( result.wrapup , '//*[ pcode  = 0 ]' );
							var li = $('#wtree');
							for( i=0 ; i< res.length ; i++ ){
								li.append('<li data-id='+res[i].wcode+' data-parent='+res[i].pcode+'><label>'+res[i].wdtl+'</label></li>');
							}
						 	
							$('#wtree').on('click' , 'li' , function(){
								var self = $(this);
								var p = self.find('label');
								console.log( self );
								var pcode =  self.attr('data-id');
								
						
								
									res = JSON.search( result.wrapup , '//*[ wcode  = '+pcode+' ]' );
									console.log( res[0].wcode );
									
									$('[name=wcode]').val( res[0].wcode );
									$('[name=wdtl]').val( res[0].wdtl );
									$('[name=pcode]').val( res[0].pcode  );
									$('[name=seq]').val( res[0].seq  );
									$('[name=sts]').val( res[0].sts  );
									$('[name=rmlist]').val( res[0].rmlist  );
									$('[name=woptid]').val(res[0].optid  );
								
								
								res = JSON.search( result.wrapup , '//* [ pcode = '+pcode+' ]')
								var txt = "<ul>";
								for( i=0 ; i< res.length ; i++ ){
									txt += '<li data-id='+res[i].wcode+' data-parent='+res[i].pcode+'><label>'+res[i].wdtl+'</label></li>';
								}
								txt += "</ul>"
								p.append( txt );	
							   return;
							})
							
							*/
					//end wrapup tree
					}//end success
			   })//end ajax
			
		},
		save_wrapup: function(){
			var self = this;
			var  formtojson =  JSON.stringify( $('form').serializeObject() );  
			$.ajax({   'url' : url, 
				'data' : { 'action' : 'saveWrapup' , 'data' : formtojson }, 
				'dataType' : 'html',   
				'type' : 'POST' ,  
				'beforeSend': function(){
					//set image loading for waiting request
					//$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
				 },										
				 'success' : function(result){ 
					var response = eval('('+result+')');  
					if(response.result=="success"){
						wrapup =  response.wrapup ;
						$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
					}
				 }
			});
		}
		

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  
	  $('#wtree').on('click' , 'li' , function(e){
		 	 e.stopPropagation();
				var self = $(this);
	
	
				//console.log( self.parents('ul').length );
				 	//test remove 
				//console.log(  $('[data-upd=new]').remove() );
			
			//find self level of menu tree;
				//$('#trace').text('').text('click on level : '+self.parents('ul').length);
	
	
				var pcode =  self.attr('data-id');
				if( pcode != undefined ){
					currentwrapup = pcode;
				}else{
					console.log("New tree");
					return;
				}
				
	
				
				//show right info 
				res = JSON.search( wrapup , '//*[ wcode  = '+pcode+' ]' );
				//console.log( res );
				//console.log( res[0].wcode );
			
				$('[name=wcode]').val( res[0].wcode );
				$('[name=wdtl]').val( res[0].wdtl );
				$('[name=pcode]').val( res[0].pcode  );
				$('[name=seq]').val( res[0].seq  );
				$('[name=sts]').val( res[0].sts  );
				$('[name=rmlist]').val( res[0].rmlist  );
				$('[name=woptid]').val(res[0].woptid  );
				$('[name=genewid]').val(res[0].genewid  );
	
				console.log( self.attr('rel') );
				if(self.attr('rel') != "open"){
	 			
			   				self.attr('rel','open');
				   		
				   			//console.log( pcode );
				   			res = JSON.search(wrapup , '//* [ pcode = '+pcode+' ]')
				   			//console.log( res );
				   			var txt = "<ul>";
				   			for( i=0 ; i< res.length ; i++ ){
				   				txt += '<li data-id='+res[i].wcode+' data-parent='+res[i].pcode+'>'+res[i].wdtl+'</li>';
				   			}
				   			txt += "</ul>"
				   			self.append( txt );	
	 		}else{
	
				console.log("remove");
		   		
	 			self.removeAttr('rel');
	 			console.log( self.children() );
	 			self.children().remove();
			//	console.log("else ");
		 	//	console.log(  );
	
		   	}
		})

		//add action to map list table
		 $('#cmplist-mapped-table tbody').on('click' ,'tr', function(){
			 
			 //check if no list available 
			 //do nothing after.
			 if( $(this).attr('data-listava') == 0 ){
				 return;
			 }
			
			 		//add row highlight
				   $('#cmplist-mapped-table tr.selected-row').removeClass('selected-row')
				   $(this).addClass('selected-row');
				   
			 
				  //clear confirm checkbox
				  $('[name=confirm_delete_cmplist]').attr('checked', false);
				
					//data-liststatus == 0 ava
					//reset the current pane
					$('#cmplist-nolist-pane,#cmplist-start-pane,#cmplist-mapping-pane,#cmplist-delete-pane').hide();
					var liststatus = $(this).attr('data-liststatus');
					var listid = $(this).attr('data-listid');
				
					//set pk for remove to button
					$('.cmplist-remove').attr('data-listid', listid );
				
					if( liststatus == 0 ){
						$('#cmplist-start-pane').fadeIn('fast');
					}else if( liststatus == 4 ){
						//expire
					}else{
						$('#cmplist-delete-pane').fadeIn('fast');
					}
					
					
		});//end click
		 
		//change sale script in detail page
		 $('[name=scriptname]').change( function(){
			 var id = $(this).val();
			 if( id != "" ){
				    $.ajax({   'url' : "saleScript-pane_process.php", 
					   'data' : { 'action' : 'detail','id': id }, 
				
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
						   'beforeSend': function(){
							   //set image loading for waiting request
							   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
							},										
							'success' : function(data){ 
							//remove image loading 
							//$('#loading').html('').append("Project Management Sheet");
				
			                 var  result =  eval('(' + data + ')'); 
			
			                 $('[name=scriptdtl]').val(result.data.sdetail);
			                 
							}//end success
						});//end ajax 
			 }else{
				  $('[name=scriptdtl]').val("");
				}
		 })
	 
	  
	  //click add caption btn
	  $('.add_cmp_field').click( function(e){
		  e.preventDefault();
		  $.campaign.add_caption();
	  })
	  
	   //click add caption btn
	  $('.remove_cmp_field').click( function(e){
		  e.preventDefault();
		  $.campaign.remove_caption();
	  })
	   
	  //save caption btn
	    $('.save_cmp_field').click( function(e){
		  e.preventDefault();
		  $.campaign.save_caption();
	  })
	  
	  
	  //back to main campaign page
	  $('#campaign-back-main').click( function(e){
		  		$.campaign.load();
		  		$('#campaign-main-pane').show();
		  		$('#campaign-detail-pane').hide();
	  })

	  $.campaign.load();
	  //not use
	  $('.cancel_campaign').click( function(e){
		  		e.preventDefault();
				$.campaign.cancel();
	   });
	  
	  
	  
	 //new campaign button 
	  $('.new_campaign').click( function(e){
		  		e.preventDefault();
		  		
		  		//clear current value
		  	  $('[name=cmpuniqueid]').val('');
	  		  $('[name=ncmpName]').val('');
			  $('[name=ncmpName]').val('');
              $('[name=ncmpDetail]').val('');
              $('[name=ncmpStatDate]').val(''); 
              $('[name=ncmpEndDate]').val(''); 
              $('[name=ncmpExpire]').val(''); 
              //load page
         	 $('#new-campaign-pane').load('campaign-new.php' , function(){
					$(this).fadeIn('fast',function(){
						   $(this).css({'height':(($(document).height()))+'px'});
						   $("html, body").animate({ scrollTop: 0 }, "fast");
						});
			 });
				
	   });
	  
	  //update campaign button
	  $('.update_campaign').click( function(e){
	  		e.preventDefault();
			$.campaign.update();
	  });
	  
	  //campaign action
	  $('.stopcmp').click( function(e){
		  	e.preventDefault();
		  	//check is confirm checkbox is checked
			if( $('[name=confirm_stop_cmp]').is(':checked')){
				$.campaign.cmpstop();
				$('#cmp-stop-pane').fadeOut('fast',function(){
					$('#cmp-startdelete-pane').fadeIn('fast');
				})
			}else{
				alert('Please confirm the stop operation by checked the check box above button ')
			}
		  
	  })
	  
	  $('.startcmp').click( function(e){
		  e.preventDefault();
		  $.campaign.cmpstart();
	  })
	  
	  //delete campaign button
	  $('.deletecmp').click( function(e){
		  e.preventDefault();
		  	//check is confirm checkbox is checked
			if( $('[name=confirm_delete_cmp]').is(':checked')){
				$.campaign.cmpremove();
			}else{
				alert('Please confirm the delete operation by checked the check box above button ')
			}
	   });
	
	  //map list action [ tab mapping list ]
	  $('.cmplist-start').click( function(e){
		  e.preventDefault();
		  $('#cmplist-start-pane').fadeOut('fast',function(e){
			  $('#cmplist-mapping-pane').fadeIn('fast');
		  })
	  })
	  
	  //campaign list button 
	  $('.cmplist-save').click( function(e){
		  e.preventDefault();
		  //check is checked
		  if( $('[data-check=check]').length==0){
			  return;
		  } 
		  $.campaign.cmplist_save();	
	  })
	  
	    $('.cmplist-remove').click( function(e){
		  e.preventDefault();
		  if($('[name=confirm_delete_cmplist]').is(':checked')){
			  $.campaign.cmplist_remove();	
		  }else{
			  alert('Please confirm the delete operation by checked the check box above button ');
		  }

	  })
	  
	  //
	  $('.back-to-mapping-pane').click( function(e){
		  e.preventDefault();
		  $('#cmplist-nolist-pane,#cmplist-start-pane,#cmplist-mapping-pane,#cmplist-delete-pane').hide();
		  $('#cmplist-start-pane').fadeIn('slow');
	  })
	  
	  
	  	//action right box
		 $('#rightbox-ul').on('click' , 'li' , function(){
		 		self = $(this);
				var $check = self.find('div.ucheck');
				if(self.attr('data-check') == "uncheck" ){
					self.attr('data-check','check') 
					$check
					.removeClass('ion-ios-circle-outline')
					.addClass('ion-ios-checkmark-outline');
				}else{
					self.attr('data-check','uncheck') 
					$check
					.removeClass('ion-ios-checkmark-outline')
					.addClass('ion-ios-circle-outline');
				}
				
					//count selected
					var c = $('[data-check=check]').length;
					if( c==0 ){
						$('#mapping-total-msg').text('');
					}else{
						$('#mapping-total-msg').text('').text(c);
					}
	 })
	  
	  
	  
  });
  