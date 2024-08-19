 (function($){
	var url = "agent-pane_process.php";
	  jQuery.agent = {
			 init: function(){
				   $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'init' }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
					
						},										
						'success' : function(data){ 
									var el =  $('#agent-table');
				                    var  result =  eval('(' + data + ')'); 
				                        
								      //group location
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.group.length ; i++){
									  option += "<option value='"+ result.group[i].id +"'>"+ result.group[i].value +"</option>";									    										    
									 }								
									 $('[name=gid]').text('').append(option);
									 $('[name=search_group]').text('').append(option);
									 
									 
									 //team
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.team.length ; i++){
									  option += "<option value='"+ result.team[i].id +"'>"+ result.team[i].value +"</option>";									    										    
									 }								
									 $('[name=tid]').text('').append(option);
									 $('[name=search_team]').text('').append(option);

									//team
									var option = "<option value=''> &nbsp; </option>";
									for( i=0 ; i<result.role.length ; i++){
										option += "<option value='"+ result.role[i].lv +"'>"+ result.role[i].label +"</option>";									    										    
									}
									$('[name=level]').text('').append(option);				
										 
						}
				   })//end ajax			
			},
			loadteam:function(gid){
				   $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'queryteam' , 'gid' : gid }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
						
						},										
						'success' : function(data){ 
				                    var  result =  eval('(' + data + ')'); 
				                    
				           		 //team
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.team.length ; i++){
									  option += "<option value='"+ result.team[i].id +"'>"+ result.team[i].value +"</option>";									    										    
									 }	
									 $('[name=search_team]').text('').append(option);
				                   
						}
				   })//end ajax			
				
			},
	    load: function(){
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query' , 'data' : formtojson }, 
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
									var i=0 , seq = 0 , active = 0 ,  disabled = 0 , locked = 0;
									var temp = "" , total_online = 0 , total_offline = 0 , total_agent = 0;
									var $row;
								
											 for( i=0 ; i<result.length ; i++){
											     seq++;
											  
											    var control = "";
											     if(result[i].level!="5"){
											    	  if( result[i].status == 1 ){
											    		   control += "<span class='ion-ios-locked-outline size-16' ></span> <a href='#' class='lock-id' >Lock</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											    	  }
											    	  if( result[i].status == 0 ){
											    		   control += "<span class='ion-ios-unlocked-outline size-16'></span> <a href='#' class='unlock-id' >Unlock</a>&nbsp;&nbsp;";
											    	  }
											    	       control +=  "&nbsp; <span class='ion-ios-trash-outline size-16'></span> <a href='#' class='del-id'>Delete</a>";
											     }
											
											    // console.log( result[i].teamid ); rgba(12,121,34,0.1)
											     //style='border-top:1px solid #3498db; position:relative; background-color:rgba(0,0,0,0.1)
											    if(  temp != result[i].tid  ){
											    
											          $row = $("<tr  ><td colspan='10'  style='background-color:#eee; border-bottom:1px solid #aaa;' >"+
											        		  				"<p style='display:inline-block; color:#666; margin:0; padding:4px 10px;  float-left; font-size:15px;'>"+
											        		  					"<span style='color:#009688'>Group: </span> "+result[i].groupname+" "+
											        		  					"<span style='margin-left:30px;  color:#009688'>Team: </span> "+result[i].teamname+" "+
											        		  				"</p>"+
											        		  				"<p data-tid='"+result[i].tid+"' style='text-align:center; width:175px; display:inline-block; color:#666; border-radius:3px; margin:0; padding:4px 10px; float:right; background-color: rgba(0,0,0,0.1)'>"+
										        		  					"Online : <span class='online' style='font-size:12px;'></span> &nbsp;&nbsp;"+
										        		  				//	"Offline : <span class='offline' style='font-size:12px;'></span> &nbsp;&nbsp;"+
										        		  					" Total  : <span class='offline' style='font-size:12px; background-color:#3498db;'></span>"+
										        		  					"</p>"+
											        		  				"</td></tr>"+
														         		   "<tr class='strip-onhover' id='"+result[i].agentid+"'><td class='text-center'>&nbsp;"+seq+"&nbsp;</td>"+
															    		   "<td >&nbsp; <span class='"+result[i].isonline+"'>"+result[i].isonline+"</span> &nbsp; <a href='#' class='nav-user-id' >"+result[i].fname+"&nbsp;"+result[i].lname+"</a></td>"+		
															    		   "<td class='text-center'>&nbsp;"+result[i].groupname+"&nbsp;</td>"+   
															    		   "<td class='text-center'>&nbsp;"+result[i].teamname+"&nbsp;</td>"+   
															    		   "<td class='text-center'>&nbsp;"+result[i].login+"&nbsp;</td>"+   
															    		   "<td class='text-center'>&nbsp;"+result[i].level+"&nbsp;</td>"+   
															    		   "<td class='text-center'>&nbsp;"+result[i].accStatus+"&nbsp;</td>"+   
															    		   "<td class='text-center'>&nbsp;"+result[i].lastlogin+"&nbsp;</td>"+
															    		   "<td class='text-center' >&nbsp;"+control+"</td></tr>");	   
											          
											          $row.appendTo($table);
											          
											          $('[data-tid='+temp+']').children().first().text( total_online ) 
											          $('[data-tid='+temp+']').children().first().next().text( total_offline ) 
											          $('[data-tid='+temp+']').children().first().next().next().text( total_agent ) 
											          
											          temp =  result[i].tid;
											          total_online = 0;
											          total_offline = 0;
											          total_agent = 0;
											          
											          if( result[i].isonline == "online" ){
															total_online = total_online + 1;
														}else if( result[i].isonline == "offline"){
															total_offline = total_offline + 1;
														}
														total_agent = total_agent + 1;
											          
											     }else{
											     
												     $row = $("<tr id='"+result[i].agentid+"' class='strip-onhover' ><td class='text-center'>&nbsp;"+seq+"&nbsp;</td>"+
												    		  "<td >&nbsp;  <span class='"+result[i].isonline+"'>"+result[i].isonline+"</span> &nbsp; <a href='#' class='nav-user-id' >"+result[i].fname+"&nbsp;"+result[i].lname+"</a> </td>"+		
												    		   "<td class='text-center'>&nbsp;"+result[i].groupname+"&nbsp;</td>"+   
												    		   "<td class='text-center'>&nbsp;"+result[i].teamname+"&nbsp;</td>"+   
												    		   "<td class='text-center'>&nbsp;"+result[i].login+"&nbsp;</td>"+   
												    		   "<td class='text-center'>&nbsp;"+result[i].level+"&nbsp;</td>"+   
												    		   "<td class='text-center'>&nbsp;"+result[i].accStatus+"&nbsp;</td>"+   
												    		   "<td class='text-center'>&nbsp;"+result[i].lastlogin+"&nbsp;</td>"+
												    		   "<td class='text-center' >&nbsp;"+control+"</td></tr>");	    
												     $row.appendTo($table);
												     
												       if( result[i].isonline == "online" ){
															total_online = total_online + 1;
														}else if( result[i].isonline == "offline"){
															total_offline = total_offline + 1;
														}
														total_agent = total_agent + 1;
												     
												     
												     
											     }
											     switch(+result[i].status){
												      case 0 : locked++;    break;
												      case 1 : active++; break;
												      case 5 : disabled++;   break;
										          }
												     
												
												  $.agent.gridSet($row);
												  
											    } //end loop for
											 
										      $('[data-tid='+temp+']').children().first().text( total_online ) 
									          $('[data-tid='+temp+']').children().first().next().text( total_offline ) 
									          $('[data-tid='+temp+']').children().first().next().next().text( total_agent ) 
											 
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
												     $addRow = $("<tr id='nodata'><td colspan='10' class='listTableRow small center'>&nbsp; No Data &nbsp;</td></tr>")
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
		                 
		                    $('#user-detail-header').text('').text( result.data.fname+" "+result.data.lname);
		                 
		                    $('[name=aid]').val(result.data.aid);
			                $('[name=fname]').val(result.data.fname);
			            	$('[name=lname]').val(result.data.lname);
							$('[name=fname_th]').val(result.data.fname_th);
			            	$('[name=lname_th]').val(result.data.lname_th);
			            	$('[name=genesysid]').val(result.data.genesysid);
			            	$('[name=nname]').val(result.data.nickname);
			            	$('[name=mobilephone]').val(result.data.mobilePhone);
			            	$('[name=email]').val(result.data.email);
			              	$('[name=gid]').val(result.data.gid);
			            	$('[name=tid]').val(result.data.tid);
			            	$('[name=loginid]').val(result.data.loginid);
			            	$('[name=sess_loginid]').val(result.data.loginid);
			            	$('[name=level]').val(result.data.level);
			            	$('[name=accstatus]').val(result.data.accStatus);
			            	
			            	$('[name=level]').val(result.data.level);
			            	$('[name=accstatus]').val(result.data.accStatus);
			            	$('[name=level]').val(result.data.level);
			            	$('[name=accstatus]').val(result.data.accStatus);
			            	
			            	$('[name=sagent_code]').val( result.data.sacode);
			            	$('[name=sagent_name]').val( result.data.saname );
			            	$('[name=slicense_code]').val( result.data.slcode);
			            	$('[name=slicense_name]').val( result.data.slname );
			            	 
			            	 $('[name=passwd]').attr('placeholder','รหัสผ่านไม่ถูกแสดงให้เห็น');
			            	
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				 
			        $('[name=aid]').val('');
			        $('[name=sess_loginid]').val('');
			        
	                $('[name=fname]').val('');
	            	$('[name=lname]').val('');
					$('[name=fname_th]').val('');
	            	$('[name=lname_th]').val('');
	            	$('[name=genesysid]').val('');
	            	$('[name=nname]').val('');
	            	$('[name=mobilephone]').val('');
	            	$('[name=email]').val('');
	            	$('[name=gid]').val('');
	            	$('[name=tid]').val('');
	            	$('[name=loginid]').val('');
	            	$('[name=passwd]').val('');
	            	$('[name=repasswd]').val('');
	            	$('[name=level]').val('');
	            	$('[name=accstatus]').val('1');
	            	
	            	$('#agent-main-pane').hide();
					$('#agent-detail-pane').show();
					
				    $('#user-detail-header').text('').text('Create New User');
				    $('[name=passwd]').attr('placeholder','รหัสผ่าน');
					
			 },
			 check:function(){
				 
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				  $.post(url , { "action" : "check" , "data": formtojson  }, function( result ){
					    var response = eval('('+result+')');  
					    console.log( response.check );
						    if(response.check=="duplicate"){
						        $('#err-loginid').fadeIn('slow').text('** This Login ID already taken, Please change to another name.');
						    }else
						    if(response.check=="pass"){
						    	  $('#err-loginid').fadeIn('slow').html(''); //<i class="icon-ok-circle"></i>')
						    }
				 });
				 
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							   
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
			        .click( function(){
			        	$row.each( function(){
				        		var self = $(this);
				        		if( self.attr('id')!=undefined){
				        	    	 $('[name=aid]').val( self.attr('id') );	
				        	    	 $('#agent-table tr.selected-row').removeClass('selected-row');
						        	 self.addClass('selected-row');
				        		}
			        	})
			        })			        
			        .dblclick( function(e){
				        	$row.each( function(){
				        		var self = $(this);
				        		if( self.attr('id')!=undefined){
				        		 	$.agent.detail( self.attr('id') );
				        		}
				        	})
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
	  
	  $.agent.init();
	  $.agent.load();
	  
		//search name text
		$('[name=search_name]').keydown(function(e){
		    if (e.keyCode == 13) {
		    	$('#search-btn').trigger('click');
		    	e.preventDefault();
		    }
		});
		
	  $("input:text,input:password" ).keypress(function(event){
	 	    if(event.keyCode == 13) {
		 	      event.preventDefault();
		 	    }
		 });
	
	  $('#agent-back-main').click( function(e){
			$('#agent-main-pane').show();
			$('#agent-detail-pane').hide();
	  })
	  
	  $('.cancel_user').click( function(e){
		  		e.preventDefault();
				$.agent.cancel();
	   });
	  $('.new_agent').click( function(e){
		  		e.preventDefault();
				$.agent.create();
	   });
	  $('.delete_agent').click( function(e){
		  	 e.preventDefault();
			  var confirm = window.confirm('Are you sure to delete user '+$('#user-detail-header').text());
			  if( confirm ){
					$.agent.remove();
			  }
	   });
	  
	  
	  //save button
	  $('.save_user').click( function(e){
		  	e.preventDefault();
		  	//check
		  	if( $('[name=fname]').val() == "" ){
		  		alert("Please insert First Name Enlish");
		  		$('[name=fname]').focus();
		  		return;
		  	}
			if( $('[name=lname]').val() == "" ){
				alert("Please insert Last Name Enlish");
				$('[name=lname]').focus();
				return;
			}
			if( $('[name=fname_th]').val() == "" ){
				alert("Please insert First Name Thai");
				$('[name=fname_th]').focus();
				return;
			}
			if( $('[name=lname_th]').val() == "" ){
				alert("Please insert Last Name Thai");
				$('[name=lname_th]').focus();
				return;
			}
			if( $('[name=genesysid]').val() == "" ){
				alert("Please insert Genesys Id");
				$('[name=genesysid]').focus();
				return;
			}
			if( $('[name=loginid]').val() == "" ){
					alert("Please insert Login ID");
					$('[name=loginid]').focus();
			}
		  //check password
	 	 	var rp = $('[name=passwd]').val();
 	 	 	var p =  $('[name=repasswd]').val();
		  	
			if( p.length != 0  && rp.length == 0 ){
				alert("Please fill Retype password");
				$('[name=repasswd]').focus();
				return;
			}
			//check repassword input
			if( rp.length != 0 && p.length == 0 ){
				alert("Please fill password");
				$('[name=passwd]').focus();
				return;
			}

	 	 	//check password is match
	 	 	if(rp.length !=0 && p.length != 0 ){
				//check 
				if( rp != p ){
					alert("Password word not match. Please check again");
				 	return;
				}
	 	 	}
		  
		  //check agent level
		  if( $('[name=level]').val()==""){
			  alert("Please select user level");
			  $('[name=level]').focus();
			  return;
		  }
		  //check agent status
		  if( $('[name=accstatus]').val()==""){
			  alert("Please select user status");
			  $('[name=accstatus]').focus();
			  return;
		  }
          	$.agent.save();
	   });
	  
	  //select box search group
	  $('[name=search_group]').change( function(e){
		  var self = $(this).val();
		  $.agent.loadteam( self );
		  if( self != ""){
			  $.agent.load();
		  }
	  })
	  
	  //select box search team
	  $('[name=search_team]').change( function(e){
		  var self = $(this).val();
		  if( self != ""){
			  $.agent.load();
		  }
	  })
	  
	  $('#search-clear').click(function(e){
		  e.preventDefault();
		  $('[name=search_name]').val('');
		  $.agent.load();
	  });
		 

		
 	$('#search-btn').click( function(e){
 		e.preventDefault();
 		$.agent.load();
 	})
 	
 	//check duplicate login
 	$('[name=loginid]').blur( function(){
 		var self = $(this);
 		if( self.val() != $('[name=sess_loginid]').val()){
 			$.agent.check();
 		}else{
 			$('#err-loginid').text('');
 		}
 	}).keyup( function(){
 		$('#err-loginid').text('');
 	})
 	
 	$('[name=passwd]').blur( function(){
 		var self = $(this);
 		if( self.val() != "" && $('[name=repasswd]').val() != ""){
	 			if( self.val() != $('[name=repasswd]').val()){
	 				$('#err-passwd').text('').text('Password not match. Please check again.');
	 			}
 		}
 	}).keyup( function(){
 		$('#err-passwd').text('');
 	});
		 
 	$('[name=repasswd]').blur( function(){
 		var self = $(this)
 		if( self.val() != "" ){
 			if( self.val() != $('[name=passwd]').val()){
 				$('#err-passwd').text('').text('Password not match. Please check again.');
 			}
 		}
 	}).keyup( function(){
 		$('#err-passwd').text('');
 	});

 	
	
  });
  