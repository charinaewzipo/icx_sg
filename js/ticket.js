(function($){
	var url = "ticket_process.php";
	var currentRow = null; 
	  jQuery.ticket = {
			 init: function(){
			       var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				   $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'init' , 'data' : formtojson }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
					
						},										
						'success' : function(data){ 
									//var el =  $('#trackingt-table');
				                    var  result =  eval('(' + data + ')'); 
				                        
				                    //count category
				                    //qc inbox -new reload every 1min
				                    
				                    //agent load other not new every 1min
				                    
				                    //inbox
				                    var  result =  eval('(' + data + ')');
								    var $table = $('#inbox-table tbody'); 
									$table.find('tr').remove();
				                    
								      //search campaign
									 var option = "<option value='all'> All Campaign </option>";
									 for( i=0 ; i<result.cmp.length ; i++){
									  option += "<option value='"+ result.cmp[i].id +"'>"+ result.cmp[i].value +"</option>";									    										    
									 }								
									 $('[name="ticket_campaign"]').text('').append(option);
									 
									 //remember in cookie
									 $('[name="ticket_campaign"]').change( function(){
										 	var cmpid = $(this).val();
										 	if( cmpid == "all"){
										 		$.removeCookie('ticket-cmp', { path: '/' });
										 	}else{
												$.cookie("ticket-cmp", cmpid+"|"+$('[name=uid]').val() , { path: "/;SameSite=None", secure: true, expires: 10 });
										 	}
										 	$.ticket.load( $('[name=curnav]').val() );
									 })
									 
									 
								  
						}
				   })//end ajax			
			},
	    load: function( action ){
	    	var  formtojson =  JSON.stringify( $('form').serializeObject() );
			$('[name=curnav]').val(action); //remember current session
	
			//header caption
			var nav = action.slice( action.indexOf('-')+1 , action.length);
			$('#inbox-caption').text(nav).hide().fadeIn('medium');
			
			//clear current action if(action)
			$('#inbox-main-pane').show();
			$('#inbox-detail-pane').hide();
			$('.ticket_nav-back').hide();
			
			
		
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query' , 'view' : action , 'data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					    $('#inbox-table tbody').hide().fadeIn('medium');
					    
					 /*
					    $('#inbox-table tbody').fadeOut('fast', function(){
					    	$(this).fadeIn('fast');
					    })
					/*
					     var $table = $('#inbox-table tbody'); 
					    $table.find('tr').remove();
					     $addRow = $("<tr id='nodata'><td colspan='6' style='text-align:center'>&nbsp; Loading &nbsp;</td></tr>")
					     $addRow.appendTo($table);
					    */
					     
					},										
					'success' : function(data){ 
									//remove image loading 
									//$('#loading').html('').append("Project Management Sheet");
									
									console.log("loading....."+action);
						
			                        var  result =  eval('(' + data + ')');
								    var $table = $('#inbox-table tbody'); 
									$table.find('tr').remove();
									
									 var i=0;
									 var size = result.data.length;
									 for( i=0 ; i< size ; i++){
											     $row = $("<tr ><td style='text-align:center'><input type='checkbox' name='chk' data-id='"+result.data[i].tid+"'></td>"+
													    		 "<td style='text-align:center'>&nbsp;"+result.data[i].creu+"&nbsp;</td>"+   
													  		   	 "<td ><a id='"+result.data[i].tid+"' appid='"+result.data[i].appid+"' cmpid='"+result.data[i].cmpid+"' class='nav-inbox-cust'>"+result.data[i].cust+"</a></td>"+   
													  		   	 "<td style='text-align:center' >&nbsp;"+result.data[i].cmp+"&nbsp;</td>"+   
													  		   	 "<td style='text-align:center'>&nbsp;"+result.data[i].cred+"&nbsp;</td>"+
													  		   	 "<td style='text-align:center'>&nbsp;"+result.data[i].tstsdtl+"</td></tr>");
												  $row.appendTo($table);
									 }
											 
									$('[name=chk]').on('click',function(e){
											e.stopPropagation();
											var self = $(this);
											if( self.attr('data-check') != undefined ){
												self.removeAttr('data-check');
											}else{
												self.attr('data-check','checked');
											}
									})
									
									$('.nav-inbox-cust').click( function(e){
										e.preventDefault();
										e.stopPropagation();
										//$.ticket.detail( $(this).attr('id'))
										console.log( $(this).attr('id')+"|"+$(this).attr('appid') );
										$.ticket.detail( $(this).attr('id') , $(this).attr('cmpid') );
									})
									
								
								//total count left navigation	
									$('#total-new').text('').text( result.cnav.tnew );
									$('#total-submit').text('').text( result.cnav.tsub  );
									$('#total-inbox').text('').text( result.cnav.tnew  );
									$('#total-inprogress').text('').text( result.cnav.tinp );
									$('#total-reconfirm').text('').text( result.cnav.treconf  );
									$('#total-approved').text('').text( result.cnav.tappr );
									$('#total-reject').text('').text( result.cnav.trej  );
									$('#total-trash').text('').text( result.cnav.tnew );
								
									
									
								//next status navigate 
									//level desc 
									//1 = agent
									//2 = Supervisor
									//3 = QC/QA
									//4 = Manager
									//5 = Project Manager
									//6 = admin 
									
									$('.btn-action').hide();
									
									var lvl = $('[name=uid]').val();
									if( lvl == 1 ){
										switch( nav){
											case "new" : $('.ticket_submit').show(); break;
											case "submit" :  	break;
											case "inprogress" : break;
											case "reconfirm" : $('.ticket_submit').show(); break;
											case "approved" : break;
											case "reject" : break;
										}
									}
									else if( lvl == 2){
										switch( nav ){
												case "new" : 	$('.ticket_submit').show(); break;
												case "submit" :  	break;
												case "inprogress" : break;
												case "reconfirm" : $('.ticket_submit').show(); break;
												case "approved" : break;
												case "reject" : break;
										}
									}
									else if( lvl == 3 ){
										switch( nav ){ 
										case "new" : 	$('.ticket_submit').show(); break;
										case "submit" :  	break;
										case "inprogress" : break;
										case "reconfirm" : $('.ticket_submit').show(); break;
										case "approved" : break;
										case "reject" : break;
										}
									}
								
									
								//	if(lvl==1){ 	//(agent lv )
										
											/*
											switch( nav ){
										
											}
											*/
									//}else{
										
										
										
									//}
									
									
									
							 //
							 
							// $('.ticket_takeowner').show();
							 /*
							 ticket_submit
							 ticket_reconf
							 ticket_approved
							 ticket_reject
							 ticket_transfer
									*/
							 
										
											 
							//footer detail		
								$footer = $('#inbox-table tfoot'); 
								$footer.find('tr').remove();
								
				                if(i==0){
								    $row = $("<tr id='nodata'><td colspan='6' style='text-align:center; border-bottom:1px solid #E2E2E2'>&nbsp;  No Data &nbsp;</td></tr>");
								    $row.appendTo($table);
								}else{
								
									$row = $("<tr>"+
							    					"<td colspan='2'><a href='#' id='test'><span class=''></span>View more...</a></td>"+
							    					"<td colspan='6' style='text-align:right'> "+i+"  of "+result.cnav.tnew+"</td>"+
							    					"</tr>");
									$row.appendTo($footer);
								
								}
									 
							 }   
						});//end ajax 
	    	
	    },	   
	    detail:function( id , cmpid ){
			    $.ajax({   'url' : url, 
					   'data' : { 'action' : 'detail','id': id, 'cmpid' : cmpid }, 
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
		                 
		                 //step1 find url for open
		                 //step2 
		      
		                 
		                 $('.ticket_nav-back').show();
		                 console.log(   $('#exapp') );
		             
		                 //call external app
		                 $.ticket.externalapp_load(  result.app.appurl , result.data.uniqueid );
		                 
		                 //remark
		                 $('[name=tid]').val( id );
		                 $.ticket.remark_load( id );
		                 
		                 //ticket header
		                 $('#creu').text('').text( result.data.creu );
		                 $('#cred').text('').text( result.data.cred );
		                 $('#owner').text('').text( result.data.owner );
		                 $('#tstatus').text('').text( result.data.tstsdtl );
		                 
		                 //voice record
		                 
		                 
						}//end success
					});//end ajax 
			},	  
			externalapp_load:function( url , id  ){
				

			 		$('#inbox-main-pane').hide();
					$('#inbox-detail-pane').show();
					

					//default paramter of inapp
					//var app = "";
					//var id = "";
					
					$('#ex-app').attr('src', url+'?id='+id);
					
					setTimeout(function(){ autoResize( 'ex-app' ); }, 200);
					
			
					//$('#ex-app').iframeAutoHeight({debug:true});
			        //$('#ex-app').text('').load('Inapp/app_project.php');
			        
			 		var pane = $('#inbox-detail-pane');
			 		pane.removeClass('fadeInLeft');
					  setTimeout(function(){ 
						  pane.addClass('fadeInLeft');
					  }, 200);

			
				
				
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
			   save:function( saveaction ){
				
					 var id = [];
					 $('[data-check=checked]').each( function(){
						var self = $(this).attr('data-id');
						id.push( self );
					 });
					 
					if(id.length>0){
						  var id = JSON.stringify(id);
						  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
						  $.post(url , { "action" : "save" , "saveaction" : saveaction ,"data": formtojson , "id" : id }, function( result ){
							    var response = eval('('+result+')');  
								    if(response.result=="success"){
								    	//reload 
								   		$.ticket.load($('[name=curnav]').val());
								    }
						 });
					}
		    },
		    remark_load:function(id){
		   	 	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
		    	 $.ajax({   'url' : url, 
					   'data' : { 'action' : 'load_remark','id': id ,'data' : formtojson }, 
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
		                 
		                 
		                 var ul = $('#ticket-remark-ul')
		                 	   ul.text('');
		                 var size =  result.rem.length;
		         
		                 var li = "";
		                 for(i=0;i<size;i++){
		                	 li = li+"<li id='"+result.rem[i].msgid+"'>"+
		                	 		"<div style='position:relative;'>"+
		                	 			"<div style='position:absolute; top:0; right:10px; cursor:pointer; ' class='ion-ios7-arrow-down remark-act'>&nbsp;</div>"+
		                	 		"</div>"+
		                	 		"<div class='remark-title'>"+
		                	 			"<img class='remark-avatar' src='"+result.rem[i].creimg+"'>"+
			 						"</div>"+
			 						"<div class='remark-comment-postbox' style='width:100%;'>"+
					 				"<div class='remark-comment-postbox-agent'>"+result.rem[i].creu+"</div>"+
					 				"<div class='remark-comment-postbox-timestamp'> "+result.rem[i].cred+" "+
					 					"<span style='color:#000; margin-left:5px;'> - </span> "+$.timeago(result.rem[i].timstamp)+"</div>"+
					 				"<div class='remark-comment-postbox-detail' >"+result.rem[i].msgdtl+"</div>"+
					 				"</div>"+
					 				"</li>";
		                 }
		                 
		                 ul.html(li);
		            	 var p = "";
						  p += '<div class="remark-dropdown-wrap" style="z-index:2;">'+
								   '<div class="edit_remark" style="margin-bottom:5px;"> <span class="ion-ios7-compose-outline" style="font-size:18px; line-height:12px;"></span> <span style="font-size:14px; text-indent:8px; "> Edit </span></div>'+
								   '<div class="remove_remark" style="margin-top:8px;"> <span class="ion-ios7-trash-outline" style="font-size:18px; line-height:12px;"></span> <span style="font-size:14px; text-indent:5px; "> Remove </span></div>'+
								   '</div>';
						  $('.remark-act').text('').append(p);
						  $('.remark-act').click( function(e){
								if( $('.remark-dropdown-wrap').hasClass('active') ){
									 $('.remark-dropdown-wrap').removeClass('active');
								}
								$(this).children().addClass('active');
								e.stopPropagation();
							});
						  
						  $('.edit_remark').click( function(e){
								e.stopPropagation();
				
							  	//hide mini popup edit
								 $('.remark-dropdown-wrap.active').removeClass('active');
								 
								  var li = $(this).closest('li')
								  var msgid =  li.attr('id');
								  var x = li.find('.remark-comment-postbox-detail');
								  var curr = x.text();
								  
								  var edit_pane = $('[data-edit=remark-edit-active]');
								  	//check other remark is open
								 if( edit_pane.length == 1){
									 var conf = window.confirm("Cancel last edit operation ?");
									 if(conf){
										 var txt = edit_pane.find('textarea').text();
										 edit_pane.parent().text(txt);
										 edit_pane.remove();
									 }
								 }
						
								 //if not found show edit pane
								 var txt = "<div data-edit='remark-edit-active' style='margin-top:5px;'><textarea name='edit_remark_msg'  style='width:100%; height:60px;'>"+curr+"</textarea></div>"+
					  				 			 "<button class='btn btn-success repost_remark' style='margin:8px 5px 0px 0; border-radius:2px; '> Post </button> <button class='btn btn-default cancel_remark'  style='margin:8px 5px 0px 0; border-radius:2px; '> Cancel </button></span>";
												 x.text('').html(txt);
								  
								 $('[name=edit_remark_msg]')
			                	 .focus()
			                	 .focusEnd()
			                	 .keyup( function(e){
		                			  if (e.keyCode == 27){   edit_pane.remove(); x.text(curr);  } 
		                		 })
		                		 
		                		 $('.repost_remark').click( function(e){
		                			 e.preventDefault();
		                			 console.log("repost remark")
		                			 $.ticket.remark_update( msgid );
		                		 })
		                		 
		                		 $('.cancel_remark').click( function(e){
		                			 e.preventDefault();
		                			 console.log("cancel remark")
		                			 $('#remark-edit-active').remove(); x.text(curr); 
		                		 })
		                		 
						  })//end edit remark
						   
						  $('.remove_remark').click( function(e){
								  var confirm = window.confirm("Are you sure to delete this remark ?");
								  if(confirm){
									  var li = $(this).closest('li')
									  var msgid =  li.attr('id');
									  $.ticket.remark_delete(msgid);
								  }
						  })//end remove remark
						  
			            	 
						}//end success
					});//end ajax 
		    },
		    remark_save:function(){
		    
		    	//check blank remark
		    	if( $('[name=remark]').length != 0 ){
		    		if( $('[name=remark]').val() == "" ){
		    			alert("Please leave a note before post.");
		    			$('[name=remark]').focus();
		    			return;
		    		}
		    		
		    	}else
	    	  	if( $('[name=edit_remark_msg]').length != 0 ){
	    	  		if( $('[name=edit_remark_msg]').val() == "" ){
	    	  			alert("Please leave a note before post.");
	    	  			 $('[name=edit_remark_msg]').focus();
	    	  			return;
		    		}
		    	}
		    	
		    	
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "save_remark" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$('[name=remark]').val('');
						    		$.ticket.remark_load( $('[name=tid]').val() );
						    }
				 });
		    },
		    remark_update:function( msgid ){
		    
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "update_remark" , "msgid" : msgid , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.ticket.remark_load( $('[name=tid]').val() );
						    }
				 });
		    	
		    },
		    remark_delete:function( msgid ){
		    	
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "remove_remark" , "msgid" : msgid , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    		$.ticket.remark_load( $('[name=tid]').val() );
						    }
				 });
		    	
		    },
		
			
	}//end jQuery
	  
	  //util function
	  $.fn.focusEnd = function(){
		   if(this.length == 0)return this;
		   selectionStart = this.val().length;
		   selectionEnd =  this.val().length;
		    input = this[0];
			if(input.createTextRange){
			   var range = input.createTextRange();
			   range.collapse(true);
			   range.moveEnd('character',selectionEnd);
			   range.moveStart('character',selectionStart);
			   range.select();
			}else if( input.setSelectionRange){
			  input.focus();
			  input.setSelectionRange(selectionStart,selectionEnd);
			}
			return this;
		} 
	  

	  function autoResize(id){
		   
	     var newheight;
	     var newwidth;

	     if(document.getElementById){
	         newheight=document.getElementById(id).contentWindow.document.body.scrollHeight;
	         newwidth=document.getElementById(id).contentWindow.document.body.scrollWidth;
	     }

	     document.getElementById(id).height = (newheight+50) + "px";
	     //document.getElementById(id).width= (newwidth) + "px";
	 }

 })(jQuery)//end function
 
  $(function(){
	 
     
		//check cookie last select campaign
		var ticket_cmp = $.cookie("ticket-cmp");
		$.ticket.init();
		if( ticket_cmp != undefined ){
		    	var tmp = ticket_cmp.split("|");
		    	if( tmp[1] == $('[name=uid]').val() ){
		    		$('[name=cmpid]').val( tmp[0] ); 
		    		// set selected campaign
		    		//$('[name=ticket_campaign]').val( tmp[0] );
		    	}
		}
		

	
		
		
		
	    $.ticket.load('inbox-new');
	  	$('[name=curnav]').val('inbox-new');
	  	
	  	
		$('#inbox-table tbody').on('click','tr',function(e){
			 if(e.altKey){
				 console.log("click and alt key");
					var self = $(this).children().first().children();
					if(self.is(':checked')){
						self.attr('data-check','checked');
					}else{
						self.removeAttr('data-check');
					}
					self.trigger('click');
			 }
		 })
		 
		 $('#inbox-table tbody').on('dblclick','tr',function(e){
			 e.stopPropagation();
			 console.log("dblclick");
			 var self = $(this).find('.nav-inbox-cust');
			 console.log(  self.attr('id') +"|"+ self.attr('cmpid') );
			 $.ticket.detail( self.attr('id'), self.attr('cmpid'));
			 
		 })
 
//ticket action
		 $('.ticket_nav-back').click( function(e){
			e.preventDefault();
			$('#inbox-main-pane').show();
			$('#inbox-detail-pane').hide();
			$('.ticket_nav-back').hide();
		 });

		 	$('.ticket_submit').click( function(e){
				e.preventDefault();
				$.ticket.save('submit');
			});

			$('.ticket_takeowner').click( function(e){
				e.preventDefault();
				$.ticket.save('takeowner');
			});

			$('.ticket_reconf').click( function(e){
				e.preventDefault();
				$.ticket.save('reconf');
			});
	    	
			$('.ticket_conf').click( function(e){
				e.preventDefault();
				$.ticket.save('conf');
			});
			
			$('.ticket_reject').click( function(e){
				e.preventDefault();
				$.ticket.save('reject');
			});
	    	
	    	

//end ticket action
		 
		 
	
  });
  