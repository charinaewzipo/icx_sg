 (function($){
	var url = "tracking-pane_process.php";
	var currentRow = null; 
	var deleteRowid = [];
	var updateRowid = [];
	
	  jQuery.track = {
			 init: function(){
				   $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'init' }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
					
						},										
						'success' : function(data){ 
									//var el =  $('#trackingt-table');
				                    var  result =  eval('(' + data + ')'); 
				                        
								      //search campaign
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.cmp.length ; i++){
									  option += "<option value='"+ result.cmp[i].id +"'>"+ result.cmp[i].value +"</option>";									    										    
									 }								
									 $('[name=search_campaign]').text('').append(option);
									 
									 //list
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.list.length ; i++){
									  option += "<option value='"+ result.list[i].id +"'>"+ result.list[i].value +"</option>";									    										    
									 }								
									 $('[name=search_list]').text('').append(option);
									 
									 //group
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.group.length ; i++){
									  option += "<option value='"+ result.group[i].id +"'>"+ result.group[i].value +"</option>";									    										    
									 }								
									 $('[name=search_group]').text('').append(option);
									 
									 //team
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.team.length ; i++){
									  option += "<option value='"+ result.team[i].id +"'>"+ result.team[i].value +"</option>";									    										    
									 }								
									 $('[name=search_team]').text('').append(option);
									 
									 //agent
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.agent.length ; i++){
									  option += "<option value='"+ result.agent[i].id +"'>"+ result.agent[i].value +"</option>";									    										    
									 }								
									 $('[name=search_agent]').text('').append(option);
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
								    var $table = $('#agent-table tbody'); 
									$table.find('tr').remove();
									var i=0;
									var seq = 0;
									var active = 0;
									var disabled = 0;
									var locked = 0;
									  //if(  pmSheet[0].length !=0 ){
											 for( i=0 ; i<result.length ; i++){
											     seq++;
											     var $row;
											    var control = "";
											     if(result[i].level!="5"){
											    	  if( result[i].status == 1 ){
											    		   control += "<span class='ion-ios7-locked-outline size-16' ></span> <a href='#' class='lock-id' >Lock</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											    	  }
											    	  if( result[i].status == 0 ){
											    		   control += "<span class='ion-ios7-unlocked-outline size-16'></span> <a href='#' class='unlock-id' >Unlock</a>&nbsp;&nbsp;";
											    	  }
											    	       control +=  "&nbsp; <span class='ion-ios7-trash-outline size-16'></span> <a href='#' class='del-id'>Delete</a>";
											     }
											     
											     $row = $("<tr id='"+result[i].agentid+"'><td class='text-center'>&nbsp;"+seq+"&nbsp;</td>"+
											    		  "<td >&nbsp;<a href='#' class='nav-user-id' >"+result[i].fname+"&nbsp;"+result[i].lname+"</a></td>"+		
											    		   "<td>&nbsp;"+result[i].nickname+"&nbsp;</td>"+
											    		   "<td class='text-center'>&nbsp;"+result[i].groupname+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].teamname+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].login+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].level+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].accStatus+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].lastlogin+"&nbsp;</td>"+
											    		   "<td class='text-center' >&nbsp;"+control+"</td></tr>");	    	
											     
												     switch(+result[i].status){
													      case 0 : locked++;    break;
													      case 1 : active++; break;
													      case 5 : disabled++;   break;
											          }
												     
												  $row.appendTo($table);
												  $.agent.gridSet($row);
												  
											    } 
											 
											  $('.nav-user-id').on('click',function(e){
									
										    	   e.preventDefault();
										    	   $.agent.detail( $(this).parent().parent().attr('id') );
										    	   $('.delete_user').show();
										    	   
										    	 	$('#agent-main-pane').hide();
													$('#agent-detail-pane').show();
													
									           })
											   $('.unlock-id').bind('click',function(e){
											    	 e.preventDefault();
											    	 $.agent.takeaction( "unlock" , $(this).parent().parent().attr('id') );
											     })
											     $('.lock-id').bind('click',function(e){
											    	 e.preventDefault();
											    	 $.agent.takeaction( "lock" , $(this).parent().parent().attr('id'));
											     })
											    $('.del-id').bind('click',function(e){
											    	 e.preventDefault();
											    	 $('[name=aid]').val( $(this).parent().parent().attr('id') );	
											    	 $.agent.remove();
											     })
											 
											 
											  var s = "s";
											   if(i<1){	s = "";	}
											   $('#user_subtitle').text(" Total  "+i+" User"+s);
											   if(active>0){
												   $('#user_subtitle').append( " | "+active+" active " );
											   }
											   if(disabled>0){
												   $('#user_subtitle').append( " | "+disabled+" disabled " );
											   }
											   if(locked>0){
												   $('#user_subtitle').append( " | "+locked+" locked " );
											   }
										
								                if(i==0){   
												     $addRow = $("<tr id='nodata'><td colspan='10' class='listTableRow small center'>&nbsp;<img src='images/0.png'> &nbsp; No Data &nbsp;</td></tr>")
												     $addRow.appendTo($table);
												}else{
												
												var $table = $('#agent-table tfoot'); 
												$table.find('tr').remove();
												var s = "s";
												if(i<1){	s = "";	}
											    $addRow = $("<tr ><td colspan='10'  style='border-bottom: 1px solid #E2E2E2' ><small> Total "+i+" Record"+s+" </small></td></tr>");
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
		                 
		                    $('[name=aid]').val(result.data.aid);
			                $('[name=fname]').val(result.data.fname);
			            	$('[name=lname]').val(result.data.lname);
			            	$('[name=nname]').val(result.data.nickname);
			            	$('[name=mobilephone]').val(result.data.mobilePhone);
			            	$('[name=email]').val(result.data.email);
			              	$('[name=gid]').val(result.data.gid);
			            	$('[name=tid]').val(result.data.tid);
			            	$('[name=loginid]').val(result.data.loginid);
			            	$('[name=level]').val(result.data.level);
			            	$('[name=accstatus]').val(result.data.accStatus);
			            	 
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				 
			        $('[name=aid]').val('');
	                $('[name=fname]').val('');
	            	$('[name=lname]').val('');
	            	$('[name=nname]').val('');
	            	$('[name=mobilephone]').val('');
	            	$('[name=email]').val('');
	            	$('[name=gid]').val('');
	            	$('[name=tid]').val('');
	            	$('[name=loginid]').val('');
	            	$('[name=level]').val('');
	            	$('[name=accstatus]').val('');
	            	
	            	$('#user-pane').hide();
					$('#user-detail-pane').show();
					
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							   
							    	//  $.dept._new();
							          $.agent.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						        $.agent.create();
						        $.agent.load();				
						        
						    	$('#agent-main-pane').show();
								$('#agent-detail-pane').hide();
						    }
				 });
		    
		    },
			 cancel: function(){
				$.agent.detail(  $('[name=aid]').val() ); 
				 
			 },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=aid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        })
			        .click( function(){
			        	
			        	  $('[name=bookingid]').val( $row.attr('id') );	
			        	   $('#agent-table tr.selected-row').removeClass('selected-row');
			        	   $row.addClass('selected-row');
			        	
			        })			        
			        .dblclick( function(e){
				    	 	$.agent.detail( $row.attr('id') );
				    		$('#agent-main-pane').hide();
							$('#agent-detail-pane').show();
				  
				    })
				  
			  },
			  takeaction:function(action , aid ){
				   	 var confirm = window.confirm("Are you sure  to "+action+" this user ?");
					 if(confirm){ 
						  $.post(url , { "action" : action , "aid": aid  , "uid": $('[name=uid]').val() }, function( result ){
							    var response = eval('('+result+')'); 
							       if( response.result=="success"){
							    	   $.agent.load();
							       }
						 });
					   }	
				    },
	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  
	  $.track.init();
 
	   /*
	  $('#agent-back-main').click( function(e){
			$('#agent-main-pane').show();
			$('#agent-detail-pane').hide();
	  })
	  
	  $('.cancel_user').click( function(e){
		  		e.preventDefault();
				$.agent.cancel();
	   });
	  $('.new_user').click( function(e){
		  		e.preventDefault();
				$.agent.create();
	   });
	  $('.delete_user').click( function(e){
		  	 e.preventDefault();
			  var confirm = window.confirm('Are you sure to delete');
			  if( confirm ){
					$.agent.remove();
			  }
	   });
	  $('.save_user').click( function(e){
		  		e.preventDefault();
				$.agent.save();
	   });
	  */ 
		 
		 
	
  });
  