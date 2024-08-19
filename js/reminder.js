 (function($){
	 var url = "reminder_process.php";	
	  jQuery.reminder = {
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
					var seq = 0;
					//test table
				    //$table = $('#reminder-table tbody');
					//$table.find('tr').remove();
					
					console.log("call init reminder.js");

									     //group location
										 // list = "<ul class='remind-list'>";
										 //var 	list = "<li  class='ch' style='text-align:center; color:#666; padding:5px; font-family:lato; border-bottom:1px dashed #E2E2E2;'  > You have reminder </li>";
										var list = '<ul class="dd" id="reminder-list">';
										 for( i ; i<result.length ; i++){
											 	
												  ischeck = "";
												  if( result[i].reminderStatus  == 1){
													  ischeck = "checked";
												  }
												  seq++;
												  list += "<li  class='ch' style='border-bottom: 1px dashed #E2E2E2; margin:0 8px; position:relative;'>"+
												  						"<div style='right:0;position:absolute; font-size:10px; color:#ccc; background-color:#fff; border-radius:50%; padding:2px 6px;'>"+seq+"</div>"+
															  			 "<div style='padding:12px 15px; vertical-align:middle; display:inline-block; font-size:30px; cursor:pointer' data-action='' class='ch ion-ios7-circle-outline circle-check' data-id=''></div>"+
															  			 "<div style='vertical-align:middle; display:inline-block; margin: 2px 0px;'>"+
																	  			"<span data-remind='"+ result[i].reminderid +"' class='reminder-hover' style='display:block; font-size:18px; font-family:raleway; font-weight:500; color:#ff0097;cursor:pointer;'>"+result[i].reminderTypeDesc+"<a  href='#' class='alink' style='font-family:raleway; color:#ff0097'> </a> </span> "+
																	  			"<span style='display:block;color:#777;font-size:14px;'>"+result[i].reminderDT+" </span>"+
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
										/*
										list +=  '<div style="border-top: 1px dashed #E2E2E2;padding:5px; text-indent:10px;">'+	
									  				'<span class="ion-ios7-trash-outline reminder_remove " style="cursor:pointer; font-size:24px; " id="reminder_remove"></span>'+
													'<span class="icon-circle" style="position:relative; margin-left:-8px; display:none" id="reminder_remove_count">0</span>'+
									  				'</div>';
										 */
										 $('#slimreminder').text('').append(list);
										 $('.total_reminder').text(i);
										 
								
										 //check reminder is empty or not
										 if( i > 0 ){
											 //show remove reminder at footer 
											 list = '<div style="border-top: 1px dashed #E2E2E2; padding:5px; text-indent:10px; margin:0 8px;" >'+
												 		'<div class="pull-left">'+	
											  				'<span class="ion-ios7-trash-outline reminder_remove " style="cursor:pointer; font-size:24px; " id="reminder_remove"></span>'+
															'<span class="icon-circle reminder_remove" style="cursor:pointer;position:relative; margin-left:-8px; display:none" id="reminder_remove_count">0</span>'+
										  				'</div>'+
											 			'<div  class="pull-right">'+	
											  				'<button class="btn btn-default" style="border-radius:3px;color:#777; border:1px solid #aaa; font-size:12px; "> Create Reminder</button>'+
										  				'</div>'+
											  			'</div>';
											  
											  $('#slimreminder').append(list);
										  
											 //show count reminder
											 $('#reminder_count').text("You have "+i+" reminders ");
											 
											//show count in badge
											 $('.stackbadge').show();
											 
											  //setup slim scroll
											  $('#reminder-list').slimScroll({
												    height: '260px' ,
												    size: '5px',
												});
											 
										 }else{
											 //if empty reminder show button create new reminder
											 $('#reminder_count').html("<button class='btn btn-default' style='border-radius:3px;color:#777; border:1px solid #999;'> Create Reminder</button> ");
											 //show icon no reminder
											 txt = '<div style="width:100%;  text-align:center; vertical-align:middle; padding:10px;">'+
														'<span class="ion-ios7-alarm-outline" style="display:block;  font-size:60px; color:#A2A2A2"> </span>'+
														'<span  style="position:relative; top: -15px;display:block; font-size:20px; color:#A2A2A2"> No Reminder </span>'+
													  '</div>';											
											 $('#slimreminder').append(txt);
											 //hide count in badge
											 $('.stackbadge').hide();
										 }
								
								$('.reminder_remove').click( function(){
									$.reminder.remove();
								})		 

						
							 $('.circle-check').click( function(){
										var self = $(this);
										var action =  $(this).attr('data-action');
						
										if( self.hasClass('ion-ios7-circle-outline') ){
											self.removeClass('ion-ios7-circle-outline');
											self.addClass('ion-ios7-checkmark-outline');
											self.attr('data-action','checked');
											self.val('1')
										}else{
											self.removeClass('ion-ios7-checkmark-outline');
											self.addClass('ion-ios7-circle-outline');
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
									console.log("click ee");
									console.log("wrapdd click" );
									$('.wrapdd').toggleClass('active');
									e.stopPropagation();
								});
								
								$('.ch').on('click' ,function(e){
									e.stopPropagation();
								});
								 
								
								$('.alink').on('click',function(e){
									e.preventDefault();
								
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
							 
							
						 
						/*
					  
							 $('.checkSwitch').mousedown( function(){
								// if (!$(this).is(':checked')) {
										 if(!$(this).hasClass('on')){
											 console.log( "on" );
										     console.log( $(this).find(':checkbox').attr('data-id') );
										}
										 if(!$(this).hasClass('off')){
											 console.log( "off" );
											   console.log( $(this).find('[data-id]').attr('data-id') );
										}

									//	console.log($(this) );
								// }
								 
								 });
							*/
					}//end success
				});//end ajax 
			
		},
		//not used ?
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
							
							    $table = $('#reminder-table tbody');
								$table.find('tr').remove();
								var i=0;
								var txt = "";
								     //group location
									 var list = "<ul></ul>";
									 for( i ; i<result.length ; i++){
										 
										 txt = txt+'<tr id="'+result[i].reminderid+'">'+
										 			'<td style="width:5%; vertical-align:middle;" >'+
										 				'<span class="'+result[i].reminderIcon+'" style="font-size:40px; color:#666"> </span>'+
										 			'</td>'+
										 			'<td style="width:20%; "> '+
										 				'<span style="display:block; font-size:22px; color:#4390df  "><a href="#" class="nav-reminder-id"> '+result[i].reminderTypeDesc+' </a><!-- <span style="font-size:12px; color:#666; font-style:italic; text-indent:15px;"> +2 hour ago </span> --></span>'+ 
										 				'<span class="ion-ios7-calendar-outline" style="color:#666; font-size:18px; "></span> <span style="color:#666;font-size:18px;"> '+result[i].reminderDate+' </span>'+
										 				 '&nbsp; '+
										 				'<span class="ion-ios7-clock-outline" style="color:#666; font-size:16px;"></span> <span style="color:#666;font-size:16px;">  '+result[i].reminderTime+'  </span>'+ 
										 			'</td>'+
										 			'<td style="width:45%; vertical-align:middle">'+
										 				'<span style="font-size:16px; display:block"> '+result[i].reminderSubj+' </span>'+
										 				'<span style="font-size:12px; display:block">'+result[i].reminderDesc+'</span>'+
										 			 '</td>'+
										 			'<td style="width:5%;vertical-align:middle">remove </td>'+
										 		'</tr>';
										 
									 }								
									 
									 $('#total-reminder').text('').text(result.length);
									// $('#remind-list').html( list );
									 $table.html( txt );
								
									   $('.nav-reminder-id').bind('click',function(e){
								    	     e.preventDefault();
								    	     $.reminder.detail( $(this).closest("td").parent().attr('id')  );
								    	     
								    	     $('[name=reminderid]').val( $(this).closest("td").parent().attr('id') );
								    	    // console.log( $(this).closest("td").parent().attr('id')  );
								    	   // $('#campaign-main-pane').hide();
								           // $('#campaign-detail-pane').show();
							           })

							
				}//end success
			});//end ajax 
		
	    	
	    },	   
	    //not used?
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
					        
					           $('[name=reminderStatus]').val( result.reminderStatus );
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
		 btn_create:function(){
			 
			 /*
			  $('[name=teamid]').val('');
			  $('[name=tname]').val('');
              $('[name=tdetail]').val('');
              $('[name=tgid]').val(''); 
            	
           	  $('#team-main-pane').hide();
	    	  $('#team-detail-pane').show();				
	    	  */
			  
		 },
		 //button save
		   btn_save:function(){
				   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							    	
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
		    //button delete 
		    //not used ?
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
		    	
		    	console.log("click checked reminder then remove ");
		    	
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
			alarm: function( opts , msg , reminderid ){
				  try{
					  if( opts.sound == "on" ){
								  var audio = new Audio('sounds/ticktac.mp3');
								 // var audio = new Audio('sounds/ChuToy.wav');
								  audio.play();
					  }
					}
					catch(e){}
				
				    var options = { 'distance': 12 , 'times' : 4 };
					$("#shake").effect( 'shake', options , 500 ).delay(500).effect( 'shake', options , 500 );
		
					var notify = '<div>'+
						'<div class="ns-box-inner">'+
					    '<div class="ns-thumb" style="display:none"></div>'+
					  	  '<div class="ns-content">'+
					  			'<div style=" float:left; margin-left:0px; padding-right:8px;  display:inline-block; font-family:roboto; font-weight:600; text-align:center; ">'+
					  					'<h3 style="margin:0;padding:0; font-weight:300; padding:2px">Today </h3>'+
					  					'<h3 style="margin:0;padding:0; font-weight:400" id="retime">'+msg.rt+'</h3>'+
					  	  		'</div>'+
					  	  		'<div style=" padding-left:8px; margin-right:12px; display:inline-block; border-left:1px solid rgba(255,255,255,0.55);  ">'+
					  	  			'<span style="display:block; font-family:roboto; font-weight:400; font-size:18px;" id="rcat">'+msg.rcat+'</span>'+
					        	    '<span style="display:block; font-family:roboto; font-weight:400; font-size:12px;"><a href="#" style="color:#fff" id="rsub">'+msg.rsub+'</a></span>'+
					        	    '<span style="display:block; font-family:roboto; font-weight:400; font-size:12px;" id="rdetail"> '+msg.rdtl+' </span>'+
					  	  		'</div>'+
					  	  		'<div style="clear:both"></div>'+
					  	  '</div>'+
					    '</div>'+
					    '<span class="ns-close" id="reminder-popup-close"></span>'+
					    '</div>';
					
					  $('#reminder-popup').text('').html(notify);
					  $('#reminder-popup').removeClass('fadeInDown').hide();
					  setTimeout(function(){ 
						  $('#reminder-popup').show().addClass('fadeInDown');
					  }, 200);
					  
					 $('#reminder-popup-close').click( function(e){
						 e.preventDefault();
						 console.log("click reminder popup close ");
						 $('#reminder-popup').removeClass('fadeInDown').hide();
					 });
				
					
					 //turn off reminder
					  setTimeout(function(){ 
						  $.reminder.nextalarm('off' , reminderid );
					  }, 1000);
				  
			  },
			  nextalarm: function( opt, reminderid  ){
				  
				  console.log("next alarm");
				  
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					$.ajax({   'url' : url, 
						   'data' : { 'action' : 'alarm','data' : formtojson , 'opt': opt , 'off_reminderid' : reminderid}, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
							'success' : function(data){ 
									var response =  eval('(' + data + ')');
									
									console.log(data);
									
									if(response.result=="success"){
										//show reminder icon
										//$('#reminder').fadeIn(1500);
											
										
										var sec = parseInt( response.data.alarm );
								       console.log( "return value "+sec);
									
										//sec = 5000;
										if( sec > 0 ){
											console.log( "set time out : "+ sec );
											 setTimeout(function() {
												   //console.log( sec );
												 console.log(response.remind );
												  var opts = { "sound":"on" };
												   $.reminder.alarm(opts ,  response.remind , response.data.remindid );
												  
													
										          //  doSomething();
										           // loop();  
										    }, sec);
										}
										
								    }//end if
									/*
									else	if( response.result=="miss"){
											//show popup when miss reminder
											var s = '';
											if(response.data.total > 1){
												  s = 's';
											}
											
											var notify ='<div>'+
																'<div class="ns-box-inner">'+
															    '<div class="ns-thumb" style="display:none"></div>'+
															  	  '<div class="ns-content">'+
															  			'<div style=" float:left; margin-left:0px; padding-right:8px;  display:inline-block; font-family:roboto; font-weight:600; text-align:center; ">'+										  				
															  			'<span class="ion-ios7-alarm-outline" style="font-size:46px; padding:0 6px; "></span>'+ 
															  	  		'</div>'+
															  	  		'<div style=" padding-left:8px; margin-right:12px; display:inline-block; border-left:1px solid rgba(255,255,255,0.55);  ">'+
															  	  			'<span style="display:block; font-family:roboto; font-weight:400; font-size:18px;">You miss '+response.data.total+' reminder'+s+'</span>'+
															        	    '<span style="display:block; font-family:roboto; font-weight:400; font-size:12px;">Your last reminder is on '+response.data.last_reminder+' '+response.data.last_re_time+'</span>'+
															        	    '<span style="display:block; font-family:roboto; font-weight:400; font-size:12px;"><a href="#" style="color:#fff" id="nav-reminder-detail"> click here</a> for detail  </span>'+
															  	  		'</div>'+
															  	  		'<div style="clear:both"></div>'+
															  	  '</div>'+
															    '</div>'+
															    '<span class="ns-close" id="reminder-misspopup-close"></span>'+
															'</div>';
											
											  $('#reminder-popup').text('').html(notify);
											  $('#reminder-popup').removeClass('fadeInDown').hide();
											  setTimeout(function(){ 
												  $('#reminder-popup').show().addClass('fadeInDown');
											  }, 200);
									
											//when click close button
											$('#reminder-misspopup-close').click( function(e){
												e.preventDefault();
												console.log("click close remidner ");
												//update miss reminder
												  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
												  $.post(url , { 'action' : 'alarm_off','data' : formtojson }, function( result ){
													    var response = eval('('+result+')');
														if(response.result=="success"){
															console.log("all alarm is already off");
															$('#reminder-popup').removeClass('fadeInDown').hide();
															
														}
												  });
											})
											
											//when click reminder miss detail
											$('#nav-reminder-detail').click( function(){
												console.log("click more detail on reminder");
												
											})
										 	
											
										}
									   //setTimeout( $.reminder.nextalarm() , 5000 );
									   */
										else{
										//if( response.result=="empty"){
										
											
										 	console.log( "no reminder " );
										}
										
								    	
							
				           
							}//end success
					});//end ajax
				
			  },
			  //after get miss from index process missing reminder info
			  missing_reminder:function(){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					$.ajax({   'url' : url, 
						   'data' : { 'action' : 'miss_reminder','data' : formtojson}, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
							'success' : function(data){ 
									var response =  eval('(' + data + ')');
									
									console.log(data);
									var s = '';
									if(response.data.total > 1){
										  s = 's';
									}
									//alert missing reminder
									var notify ='<div>'+
														'<div class="ns-box-inner" >'+
													    '<div class="ns-thumb" style="display:none"></div>'+
													  	  '<div class="ns-content">'+
													  			'<div style=" float:left; margin-left:0px; padding-right:8px;  display:inline-block; font-family:roboto; font-weight:600; text-align:center; ">'+										  				
													  			'<span class="ion-ios7-alarm-outline" style="font-size:46px; padding:0 6px; "></span>'+ 
													  	  		'</div>'+
													  	  		'<div style=" padding-left:8px; margin-right:12px; display:inline-block; border-left:1px solid rgba(255,255,255,0.55);  ">'+
													  	  			'<span style="display:block; font-family:roboto; font-weight:400; font-size:18px;">You miss '+response.data.total+' reminder'+s+'</span>'+
													        	    '<span style="display:block; font-family:roboto; font-weight:400; font-size:12px;"> Last reminder is on '+response.data.last_reminder+' '+response.data.last_re_time+'</span>'+
													        	    '<span style="display:block; font-family:roboto; font-weight:400; font-size:12px;"><a href="#" style="color:#fff" id="nav-reminder-detail"> click here</a> for detail  </span>'+
													  	  		'</div>'+
													  	  		'<div style="clear:both"></div>'+
													  	  '</div>'+
													    '</div>'+
													    '<span class="ns-close" id="reminder-misspopup-close"></span>'+
													'</div>';
									//console.log('.nsbox');
									$('#reminder-popup').css('background-color','rgba(156, 39, 176, 0.80)');
									
									  $('#reminder-popup').text('').html(notify);
									  $('#reminder-popup').removeClass('fadeInDown').hide();
									  setTimeout(function(){ 
										  $('#reminder-popup').show().addClass('fadeInDown');
									  }, 200);
							
									//when click close button
									$('#reminder-misspopup-close').click( function(e){
										e.preventDefault();
										console.log("click close remidner ");
										
										//set missing to empty when close
										console.log( $('[name=missing]').val() );
										$('[name=missing]').val('');
										console.log( $('[name=missing]').val() );
										//update miss reminder
										  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
										  $.post(url , { 'action' : 'alarm_off','data' : formtojson }, function( result ){
											    var response = eval('('+result+')');
												if(response.result=="success"){
													console.log("all alarm is already off");
													$('#reminder-popup').removeClass('fadeInDown').hide();
													
												}
										  });
									})
									
									//when click reminder miss detail
									$('#nav-reminder-detail').click( function(){
										console.log("click more detail on reminder");
										//open reminder
										  $('#reminder-pane').load('reminder-pane.php' , function(){
									    		$(this).fadeIn('fast',function(){
									    		 	//window.scrollTo(0, 0);
												   	$(this).css({'height':(($(document).height()))+'px'});
												   	$("html, body").animate({ scrollTop: 0 }, "fast");
												  
												});
									 	}); 
										
									})
									//end reminder miss detail
									
							}//end success function
					});//end ajax
				  
			  },
			  alarmoff: function( opt ){
				   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { 'action' : 'alarm','data' : formtojson , 'opt': opt  }, function( result ){
						    var response = eval('('+result+')');
							if(response.result=="success"){
								console.log("alarm off");
							}
					  });
			
			  }
			

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  

     // reinitial alarm
	  console.log("on load --- reinitial");
	  //check next alarm
	  $.reminder.nextalarm();
	  //show dropdown reminder
	  $.reminder.init();
	  
	

	  

		 //reminder popup close
	  /*
		 $('.ns-close').click( function(){
			 $('#reminder-popup').removeClass('fadeInDown').hide();
		 })
		*/
	
	  
	  // seesion test
	  /*
	  console.log( $('[name=remineme]').val() );
	  if( $('[name=remineme]').val() != 0  ){
		  console.log( "alert me at : "+$('[name=remineme]').val() );
		   sec = parseInt( $('[name=remineme]').val() );
			 setTimeout(function() {
				   //console.log( sec );
				  var opts = { "sound":"on" };
					$.reminder.alarm( opts );
		          //  doSomething();
		           // loop();  
		    }, sec);
		  
	  }
	  */
	  /*
	   init();
	    function doSomething() {
		    console.log("doing something");
		}

		function init() {
			
		    var myFunction = function() {
		        doSomething();
		       // var rand = Math.round(Math.random() * (3000 - 500)) + 500; // generate new time (between 3sec and 500"s)
		       // var rand = $.reminder.nextalarm();
		        var rand = 3000;
		        var rand = $.reminder.nextalarm();
		        console.log( rand );
		        //setTimeout(myFunction, rand);
		    }
		    myFunction();
		}

		*/
	
	  
	  
	 //  window.clearTimeout(t);
		
	
		
	  //test function
	  /*
	  $('.tsound').click( function(){
		  
		  try{
			//  var audio = new Audio('sounds/ticktac.mp3');
			  var audio = new Audio('sounds/ChuToy.wav');
			  audio.play()
			    setTimeout(function(){ 
			    var	audio = new Audio('sounds/ChuToy.wav');
			    	  audio.play()
			    },1100);
			  
			
		//	  var audio = $("#alarm-ring")[0];
			}
			catch(e){}
		
		
		     var options = { 'distance': 12 , 'times' : 4 };
			  $("#shake").effect( 'shake', options , 500 ).delay(500).effect( 'shake', options , 500 );
		   
		  //delay 2sec
		  
		  //$('.ns-thumb').fadeIn('slow',function(){
			 // $('#reminder-popupd').addClass('ns-effect-thumbslider');
		  //})
	
		
		  $('#reminder-popup').removeClass('fadeInDown').hide();
		  setTimeout(function(){ 
			  $('#reminder-popup').show().addClass('fadeInDown');
		  }, 200);
		
			  */
		
		  
		   // 
		
			 // $( "#shake" ).delay(1000).effect( 'shake', options , 500);
		  /*
		  var myVar;

		  function myFunction() {
		      myVar = setTimeout(function(){alert("Hello")}, 3000);
		  }

		  function myStopFunction() {
		      clearTimeout(myVar);
		  }
			  */
		 
	 // })
	  
	  
	
	
	  
	
		
	  //start reminder



		$('.reminder_remove').click( function(){
					var rem = [];
					/*
					$('#remind-list li > span').each(  function( index  , obj ){
							//console.log( $(obj).attr('data-action') );
							if( $(obj).attr('data-action') == "checked" ){
								rem.push( 	  $(obj).attr('data-id')  );
								//remove each 
								$(obj).parent().remove();

								//hide animate display total
								$('#reminder_remove_count').hide()
							}
					});
					*/
					

				

				 /*
						//update
						url = "reminder_process.php";
						  var  formtojson =  JSON.stringify( rem ); 
						  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
							    var response = eval('('+result+')');  
								    if(response.result=="success"){
								          //$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
								    	$('.stackbadge').fadeOut( 'slow', function(){
			    							$(this).fadeIn('slow');
								    	});
								    	
								    	
								    	
								    }
						 });
			 */
					
			});

			$('#reminder_save_test').click( function(){
				
				act = [];
				ina= [];
				/*
				$('input.checkSwitch:checkbox').each(  function( index  , obj ){
					if( $(this).attr('checked') ){
						act.push( $(this).attr('data-id') );
					}else{
						ina.push( $(this).attr('data-id') );
					}
				});
				*/
				
				  url = "reminder_process.php";
				  var  act =  JSON.stringify( act ); 
				  var  ina =  JSON.stringify( ina ); 
				  var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "update" , "data" : formtojson , "active":  act ,"inactive": ina }, function( result ){
					    var response = eval('('+result+')');  
						    if(response.result=="success"){
						          //$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
						    }
				 });

			});
			

	  
  });
  