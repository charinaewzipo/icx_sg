 (function($){
	var url = "reminder_process.php";
	var currentRow = null; 
	var deleteRowid = [];
	var updateRowid = [];
	 
	  jQuery.reminder_pane = {
		//reminder dropdown
		init:function(){
			  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			 $.ajax({   'url' : url, 
				   'data' : { 'action' : 'init', 'data': formtojson }, 
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
					var i=0;
					//test table
				    //$table = $('#reminder-table tbody');
					//$table.find('tr').remove();

									     //group location
										 // list = "<ul class='remind-list'>";
										 //var 	list = "<li  class='ch' style='text-align:center; color:#666; padding:5px; font-family:lato; border-bottom:1px dashed #E2E2E2;'  > You have reminder </li>";
										var list = '<ul class="dd" id="reminder-list">';
										 for( i ; i<result.length ; i++){
											 	
												  ischeck = "";
												  if( result[i].reminderStatus  == 1){
													  ischeck = "checked";
												  }
		
												  list += "<li  class='ch' style='border-bottom: 1px dashed #E2E2E2;'>"+
															  			 "<div style='padding:12px 15px; vertical-align:middle; display:inline-block; font-size:30px; cursor:pointer' data-action='' class='ch ion-ios-circle-outline circle-check' data-id=''></div>"+
															  			 "<div style='vertical-align:middle; display:inline-block; margin: 2px 0px;'>"+
																	  			"<span data-remind='"+ result[i].reminderid +"' class='reminder-hover' style='display:block; font-size:18px; font-family:raleway; font-weight:500; color:#ff0097;cursor:pointer;'>"+result[i].reminderTypeDesc+"<a  href='#' class='alink' style='font-family:raleway; color:#ff0097'> </a> </span> "+
																	  			"<span style='display:block;color:#777;font-size:14px;'>"+ result[i].reminderDate +" "+ result[i].reminderTime +"</span>"+
															  			 "</div>"+
															  			  "<div style='vertical-align:middle; display:inline-block; margin-left:25px;'>"+
															  			    "<div class='onoffswitch'>"+
																				   "<input type='checkbox' name='onoffswitch"+ result[i].reminderid +"' class='onoffswitch-checkbox' id='myonoffswitch"+ result[i].reminderid +"' class='ch' "+ischeck+" >"+
																				    "<label class='onoffswitch-label' for='myonoffswitch"+ result[i].reminderid +"'>"+
																					    "<span class='onoffswitch-inner'></span>"+
																					    "<span class='onoffswitch-switch'></span>"+
																			   		 "</label>"+
																			    "</div>"+ 
															  			  "</div>"+
															  		"</li>";
										 }
										 
										list += '</ul>';
										list +=  '<div style="border-top: 1px dashed #E2E2E2;padding:5px; text-indent:10px;">'+	
									  				'<span class="ion-ios-trash-outline reminder_remove " style="cursor:pointer; font-size:24px; " id="reminder_remove"></span>'+
													'<span class="icon-circle" style="position:relative; margin-left:-8px; display:none" id="reminder_remove_count">0</span>'+
									  				'</div>';
										 
										 $('#slimreminder').text('').append(list);
										 $('.total_reminder').text(i);
										 
										 if( i==0 ){
											 txt = '<div style="width:100%; height:150px; text-align:center; vertical-align:middle">'+
														'<span class="ion-ios-alarm-outline" style="display:block;  font-size:60px; color:#A2A2A2"> </span>'+
														'<span  style="position:relative; top: -15px;display:block; font-size:20px; color:#A2A2A2"> No Reminder </span>'+
												'</div>';											
											 $('#slimreminder').append(txt);
										 }
										 
										 if( i>1 ){ 
											 $('#reminder_count').text("You have "+i+" reminders ");
										 }else{
											 $('#reminder_count').text("You have "+i+" reminder ");
										 }
								
										  //setup slim scroll
										  $('#reminder-list').slimScroll({
											    height: '200px' ,
											    size: '5px',
											});
										 
								///!!!!!	 
								$('.reminder_remove').click( function(){
									$.reminder.remove();
								})		 

						
							 $('.circle-check').click( function(){
										var self = $(this);
										var action =  $(this).attr('data-action');
						
										if( self.hasClass('ion-ios-circle-outline') ){
											self.removeClass('ion-ios-circle-outline');
											self.addClass('ion-ios-checkmark-outline');
											self.attr('data-action','checked');
											self.val('1')
										}else{
											self.removeClass('ion-ios-checkmark-outline');
											self.addClass('ion-ios-circle-outline');
											self.attr('data-action','');
											self.val('0');
										}

										//play animate
										if(  $('.circle-check[data-action=checked]').length > 0 ){
											  $('#reminder_remove_count').show().text( $('.circle-check[data-action=checked]').length );
										}else{
											 $('#reminder_remove_count').hide();
										}
											
								});
							
						 
							 //test
								$('.wrapdd').on('click', function(e){
									console.log("wrapdd click" );
									$('.wrapdd').toggleClass('active');
									e.stopPropagation();
								});
								
								$('.ch').on('click' ,function(e){
									e.stopPropagation();
								});
								 
								
								$('.alink').on('click',function(e){
									e.preventDefault();
									/*
									if( $(this).attr('data-open')=="open-reminder"){
										console.log("open page");
										//load reminder
   
										
										 $('#reminder-pane').load('reminder-pane.php' , function(){
												$(this).fadeIn('fast');
												 $('#reminder-pane').css({'height':(($(document).height()))+'px'});
										   		  window.scrollTo(0, 0);
										 }); 
										
										
									}//end if
								*/
									console.log("li click" );
									
									 $('.wrapdd').removeClass('active');
									//	$('.wrapdd').toggleClass('active');
									$('.dropdown').removeClass('open');
									e.stopPropagation();
								});
								
								$('.dd').on('click','li' ,function(e){
									console.log("li click" );
									
									 $('.wrapdd').removeClass('active');
									//	$('.wrapdd').toggleClass('active');
									$('.dropdown').removeClass('open');
									
								
									e.stopPropagation();
								});
								
								/*
								$('.dd').on('click','li' ,function(e){
									console.log("li click" );
									
									 $('.wrapdd').removeClass('active');
									//	$('.wrapdd').toggleClass('active');
									$('.dropdown').removeClass('open');
									e.stopPropagation();
								});
								*/
								$(document).click(function() {
									// all dropdowns
									 $('.wrapdd').removeClass('active');
								});
							 
							
					
					}//end success
				});//end ajax 
			
		},
	    load: function(){
	  	  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	  	  		$.ajax({   'url' : url, 
							   'data' : { 'action' : 'load','data' : formtojson }, 
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
					           
					           var ul = $('#reminder-ul-list');
					           var current = "";
					           var li = "";
					           for( i=0 ; i<result.length ; i++){
					        	   
					        	   if(current != result[i].reminderDate){
					        		   current = result[i].reminderDate;
					        		  li +=  '<li class="reminder-header-list" style="border-bottom:1px solid #A2A2A2; color:#666; font-size:22px; margin-top:15px;">'+ 
												'<div class="ion-ios-calendar-outline" style="display:inline-block;  margin-left:10px; font-size:22px; "> '+result[i].reminderDate+' </div>'+  
												'<div style="display:inline-block; float:right; margin-right:10px; font-size:18px; line-height:32px;"><span> </span> รายการ</div>'+
												'</li>';
					        	   }
					        	   
					        	   	  ischeck = "";
									  if( result[i].reminderStatus  == 1){
										  ischeck = "checked";
									  }
					        	   
							         li +='<li class="reminder-list-data" data-remind-id='+result[i].reminderid +'>'+
											'<div style="float:left; display:inline-block; width:10%; font-size: 40px; line-height:30px; margin:5px; padding:15px; border-right:1px solid #E2E2E2; " ><span class="ion-ios-circle-outline rm-circle-check" data-ischeck="ucheck" style="color:#777; cursor:pointer "></span></div>'+
												'<div style="float:left; display:inline-block; width:15%; font-size: 38px; line-height:30px; padding:25px 0; color:#0087e6"> '+result[i].reminderTime+'</div>'+
												'<div style="float:left; display:inline-block;width:50%; padding:5px;"> '+
													'<div ><h3 style="margin:0; padding:0; font-weight:300; color:#ff0097;font-family:raleway;">'+result[i].reminderTypeDesc+'</h3></div>'+
													'<div style="font-size:17px;"><a href="" style="color:#333" class="nav-reminder-list" >'+result[i].reminderSubj+'</a></div>  '+
													'<div style="font-size:14px; color:#555;">'+result[i].reminderTypeDesc+'</div>'+
												'</div>'+
												'<div style="float:left; display:inline-block;width:20%; padding:25px;">'+ 
													    "<div class='onoffswitch'>"+
														   "<input type='checkbox' data-remind-check='"+result[i].reminderid+"' name='onoffswitch"+ result[i].reminderid +"' class='onoffswitch-checkbox' id='onoffswitch"+ result[i].reminderid +"' ischecked='"+ischeck+"'   "+ischeck+" >"+
														    "<label class='onoffswitch-label' for='onoffswitch"+ result[i].reminderid +"'>"+
															    "<span class='onoffswitch-inner'></span>"+
															    "<span class='onoffswitch-switch'></span>"+
													   		 "</label>"+
													    "</div>"+ 
												'</div>'+
												'<div style="clear:both"></div>'+
											'</li>';
					           }
					           ul.html(li);
					           
					           	//if no reminder
					           if(result.result=="empty"){
					        	   li = '<li style="border:1px dashed #aaa; background-color:#fff; height:500px; text-align:center; "><div style="top:10%;position:relative; color:#666; font-size:15px"><span class="ion-ios-alarm-outline" style="color:#888;font-size:120px;"></span><p style="font-weight:400; color:#888; font-size:28px;"> No Reminder </p> Click New Reminder button for create reminder.</div></li>';
					        	   ul.html(li);
					           }else{
					           	//algorithm count total and display to top 
									var li = "";
									var count = 0;
									var rememberli = "";
									$('#reminder-ul-list li').each( function(key ,obj){
										li = $(obj);
										if( li.hasClass('reminder-header-list')){
												if(key!==0){
													rememberli.text(count);
												}
												rememberli =  li.find('div > span'); 
												count = 0;
										}else{
											count = count + 1;
										}
									})
									rememberli.text(count);
					        	   
					           }
					           
					         //add event check mark
					         $('.rm-circle-check').click( function(e){
					        	 e.preventDefault();
					        	 var self = $(this);
					        	 if( self.attr('data-ischeck')=="ucheck"){
					        		 self.attr('data-ischeck','check');
					        		 self.removeClass('ion-ios-circle-outline');
					        		 self.addClass('ion-ios-checkmark-outline');
					        	 }else{
					        		 self.attr('data-ischeck','ucheck');
					        		 self.addClass('ion-ios-circle-outline');
					        		 self.removeClass('ion-ios-checkmark-outline');
					        	 }
					         })
								
							//add event click	
						    $('.nav-reminder-list').click( function(e){
						    	e.preventDefault();
						    	var id = $(this).closest("li").attr('data-remind-id');
						    	$.reminder_pane.detail( id );
						    	$('[name=reminderid]').val(id);
						    	$('#btn-new-reminder').trigger('click');
						    })	
						    //add event double click
						    /*
							$('.reminder-list-data').dblclick( function(e){
									console.log(" dbl click ");
								     e.preventDefault();
								     var id = $(this).attr('data-remind-id');
								  	$.reminder.detail( id );
							    	$('[name=reminderid]').val(id);
						    	     $('#btn-new-reminder').trigger('click');
							});
					       */
						    
						    //all radio checkbox detail ( group off radio ) 
						     $('.onoffswitch-checkbox:not(#reminderStatus)').change( function(){
						    	//console.log("change");
						    	//console.log( $(this).attr('checked') );
						    	var self = $(this);
						    	var check =  self.attr('ischecked');
						    	var id = self.attr('data-remind-check');
						    	if( check != "" ){
						    		self.attr('ischecked','');  
						    		console.log("now is off");
						    		
						    		$.reminder_pane.changeStatus( id , '0' );						  
						    	}else{
						    		self.attr('ischecked','checked');
						    		console.log("now is on");
						    		
						    		$.reminder_pane.changeStatus( id , '1' );
						    	}
						    })
						    
						  
					           
				}//end success
			});//end ajax 
		
	    	
	    },	   
	    detail:function( id ){
	  	  		$.ajax({   'url' : url, 
							   'data' : { 'action' : 'detail','id' : id }, 
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
					        
					  console.log( "detail !!"+result.reminderStatus  );
					  
				
					           if( result.reminderStatus == 1){
					        	   	  console.log( "status = 1");
					        	   	  
					        //   	  $('[name=reminderStatus]').attr('checked',false);
					        	   	  
					        	   	  
					        		//  $('[name=reminderStatus]').attr('checked','checked');
					        		  $('[name=reminderStatus]').prop('checked',true);
					        	         $('[name=reminderStatus]').attr('ischecked','checked');
					        		 // $('[name=reminderStatus]').attr('checked');
					        		 
					        	    // $('[name=reminderStatus]').attr('checked','checked');
					           }else{
					        		  console.log( "status = 0");
					        		  $('[name=reminderStatus]').attr('checked',false);
					        	      $('[name=reminderStatus]').attr('ischecked','');
					        	   //$('[name=reminderStatus]').attr('checked','');
					           }
					         //  	$('[name=reminderStatus]').val('1'); 
					           //   $('[name=reminderStatus]').attr('ischecked','checked');
					         
					           
			  	 			   $('[name=reminderType]').val( result.reminderTypeID );
					        //   $('[name=reminderType]').val( result.reminderTypeDesc );
					           $('[name=reminderSubj]').val( result.reminderSubj );
					           $('[name=reminderDesc]').val( result.reminderDesc );
							  
					           $('[name=reminderDate]').val( result.reminderDate );
					           $('[name=reminderMonth]').val( result.reminderMonth );
					           $('[name=reminderYear]').val( result.reminderYear );
					           
					           $('[name=reminderHH]').val( result.reminderHH );
					           $('[name=reminderMM]').val( result.reminderMM);
					             
					           
				}//end success
			});//end ajax 
	  	  		
		},
		//when change status on/off  on radio button
		changeStatus:function( remid , value ){
			console.log( remid +"|"+ value );
			  $.post(url , { "action" : "update_status" , "reminderid": remid , "value" : value  }, function( result ){
				  
		
				   	var response = eval('('+result+')');  
				    if(response.result=="success"){
				    		$.reminder.nextalarm();
				    		$.reminder.init();
				    }
			    
			  });
		},
		//when click remove list btn icon on top 
		remove_reminder_list: function(){
		         var ul = $('#reminder-ul-list');
		    	 var rem = [];
		    
		    	$('.rm-circle-check[data-ischeck=check]').each(  function( index  , obj ){
					rem.push( $(obj).closest("li").attr('data-remind-id'));
				});
		    	
		    	if( rem.length > 0 ){
		    		 rem = JSON.stringify(rem);
		    	//	  var  formtojson =  JSON.stringify( rem.serializeObject() ); 
					  $.post(url , { "action" : "remove_list" , "data": rem  }, function( result ){
						    	var response = eval('('+result+')');  
							    if(response.result=="success"){
							    	
							    	 //update reminder main pane 
							    	 $.reminder.init();
							 
							    	  $.reminder_pane.load();
							    	  $.reminder.nextalarm();
							    }
					 });
		    		
		    		
		    	}//end if
		    	
		    	
		    
			
		},
		 btn_create:function(){
			 
			 
			 $('[name=reminderDate]').val('');
			 $('[name=reminderMonth]').val('');
			 $('[name=reminderYear]').val('');
			 
			 $('[name=reminderHH]').val('');
			  $('[name=reminderMM]').val('');
			 
              $('[name=reminderType]').val('');
              $('[name=reminderSubj]').val(''); 
              
              $('[name=reminderDesc]').val(''); 
              
              $('[name=reminderStatus]').val('1'); 
              
        	  $('[name=reminderStatus]').prop('checked',true);
              $('[name=reminderStatus]').attr('ischecked','checked');
    
		 },
		 //button save
		   btn_save:function(){
			   
			   //update reminder stauts
			   	var check = $('[name=reminderStatus]').attr('ischecked')
			   	if( check != "" ){
			   		$('[name=reminderStatus]').val('1');
			   	}else{
			   		$('[name=reminderStatus]').val('0');
			   	}
			   	
				   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							      
							 
							    	
							    	   	  $.reminder.init();
								    	  $.reminder_pane.load();
								    	  
								    	  $.reminder.nextalarm();
								    	  
								    		//update badge
								    	  /*
						    				$('.stackbadge').fadeOut( 'slow', function(){
						    							$(this).fadeIn('slow');
						    				});
								    	   */
								    	  
								    	  //check next alarm
								    	
							    }
					 });
						
		    },
		    //button delete 
		    btn_remove:function(){
				   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "btn_delete" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							        // $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							          
							     	  $.reminder.init();
							    	  $.reminder.load();

							    		//update badge
					    				$('.stackbadge').fadeOut( 'slow', function(){
					    							$(this).fadeIn('slow');
					    				});
					    	
							    	  //check next alarm
							    	  $.reminder.nextalarm();
							    	  
							    }
					 });
						
		    },
		    
		    //remove from checkbox
		    remove:function(){
		    	var rem = [];
		    	var isrem = 0;
		    	$('.circle-check[data-action=checked]').each(  function( index  , obj ){
					rem.push( $(obj).attr('data-id')  );
					$(obj).parent().remove();
					isrem++;
				});
				
		    	//if remove item
		    	 if(isrem>0){
		    			//count total reminder
				    	var total =  $('#reminder-list > li[data-id]').length;
				    	if( total > 0 ){
				    		//if > 0 display count
							$('.stackbadge').fadeOut( 'fast', function(){
								 $('.total_reminder').text( total );
								$(this).fadeIn('fast');
							});
				    	}else{
				    		//if < 0 hide from header 
				    		$('.total_reminder').text( total );
				    		$('.stackbadge').parent().fadeOut(1200 , 'easeInOutExpo');
				    	}
				    	//clear reminder count
				    	 $('#reminder_remove_count').hide();
		    	 }
			
		    },
		    
			 cancel: function(){
			
				 
			 },
			  gridSet:function($row){
	
				 
				  
			  },
			  alarm: function( opts  ){
				  
				  try{
					  if( opts.sound == "on" ){
								  var audio = new Audio('sounds/ticktac.mp3');
								 // var audio = new Audio('sounds/ChuToy.wav');
								  audio.play();
								 // var audio = $("#alarm-ring")[0];
					  }
					}
					catch(e){}
					
				//  options = { 'distance': 12 , 'times' : 3 };
				 // $("#shake").effect( 'shake', options , 400 );//.delay(400).effect( 'shake', options , 300 );
				  
					  $('#reminder-popup').removeClass('fadeInDown').hide();
					  setTimeout(function(){ 
						  $('#reminder-popup').show().addClass('fadeInDown');
					  }, 200);
				
				  
					     var options = { 'distance': 12 , 'times' : 4 };
						  $("#shake").effect( 'shake', options , 500 ).delay(400).effect( 'shake', options , 500 );
						  
					
			
				 $.reminder.nextalarm('off');
				  
				  
			  },
			  nextalarm: function( opt ){
				  
				  console.log("next alarm");
				  
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					$.ajax({   'url' : url, 
						   'data' : { 'action' : 'alarm','data' : formtojson , 'opt': opt }, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
							'success' : function(data){ 
									var response =  eval('(' + data + ')'); 
									if(response.result=="success"){
										var sec = parseInt( response.data );
								       console.log( "return value "+sec);
									
										//sec = 5000;
										if( sec > 0 ){
											console.log( "set time out : "+ sec );
											 setTimeout(function() {
												   //console.log( sec );
												  var opts = { "sound":"on" };
													$.reminder.alarm( opts );
										          //  doSomething();
										           // loop();  
										    }, sec);
										}else{
										 	console.log( "no reminder "+sec );
										 	console.log( response.result );
										 	if(response.result == "miss"){
										 		
										 		response.data = "";
										 		
										 	}
										 	
											
										}
									   //setTimeout( $.reminder.nextalarm() , 5000 );
								    	
								    }//end if
				           
							}//end success
					});//end ajax
				
			  }
			  
			

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  
	  
		    $.reminder_pane.load();
		    
		    //button close page 
			$('#reminder-close').click( function(){
				$('#reminder-pane').fadeOut('slow');
			});
			//button new reminder
			 $('.create_reminder').click( function(e){ 
					e.preventDefault();  
					$.reminder_pane.btn_create();
			  });
			//button save reminder
			  $('.save_reminder').click( function(e){ 
					e.preventDefault();  
					$.reminder_pane.btn_save();
			  });
			//button delete reminder
			$('.delete_reminder').click( function(e){
				e.preventDefault();
				$.reminder_pane.btn_remove();
			})
			//icon btn on top 
			$('#btn-new-reminder').click( function(e){
				e.preventDefault();
				$('#reminder-main-layout').hide();
				$('#reminder-detail-layout').show();
				$('#reminder-detail-layout').addClass('fadeInLeft');
				
				$.reminder_pane.btn_create();
				console.log("new click");
			})
			
			//icon btn on top
			$('#btn-rem-reminder').click( function(e){
					e.preventDefault();
					$.reminder_pane.remove_reminder_list();
			})
			
			$('#back-to-reminder-main').click( function(e){
				e.preventDefault();
				console.log("back");
				
				$('#reminder-main-layout').fadeIn('slow'); 
				$('#reminder-detail-layout').hide();
				$('#reminder-detail-layout').removeClass('fadeInLeft');
				
			})
			
			//reminder status detail
			$('#reminderStatus').change( function(){
    	 
			    	//console.log("change");
			    	//console.log( $(this).attr('checked') );
			    	var self = $(this);
			    	var check =  self.attr('ischecked');
			    	if( check != "" ){
			    		self.attr('ischecked','');  
			    		console.log("now is off aaaa");
			    	}else{
			    		self.attr('ischecked','checked');
			    		console.log("now is on bbbb");
			    	}
			    })

	  
  });
  