(function($){
	var url = "index_process.php";
    
	  jQuery.idx = {
	    init : function( token ){
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'init' , 'token' : token }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
					'success' : function(data){ 
                        var  res =  eval('(' + data + ')'); 
					   //  console.log( res.uname );
					     if(res.result!="empty"){
					    	 $('#uname').text('').text( res.uname );
					    	 $('#uimg').attr('src',res.uimg);
					     }
					   
					}//end success
	        })//end ajax
	    	
	    },
	    login:function(){
	    		var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	    		$.post( url , { 'action' : 'login' , 'data' : formtojson  }, function( data ){ 
	    				   var res =  eval('(' +data+ ')');
	  	
				  		   switch( res.result ){
					  		case "dberror"  :  	$('#error').text( res.message );
													  		$('#error').show();
													  		$('#stack-msg').show();
													  		break;
													  		
					  		case "success" :   	$.cookie('tokenid',  res.data.uid  ,  { path: "/;SameSite=None", secure: true , expires: 10 });
					  										window.location = "home.php";  break;
					  										
					  		case "fail"		   :  	 $('#loginStatus').html(res.message); 
														  	 $('[name=passwd]').val('');
															 $('[name=uid]').focus();
															 break;
												  
					  		case "warning" :    $('#loginStatus').html(res.message); 
					  										$.idx.kick( res );
					  										break;
					  									 
					  		case "disable" :  $.idx.disable(res.time);
					  									break;
					  									
					  		case "locked" :  $('#loginStatus').html(res.message); 
					  									$('#login').attr('disabled', 'disabled').css('color','#E2E2E2');
					  									break;
					  									
					  		case "cererror"  :  $('#stack-msg-dtl').text( res.message );
												  		 $('#error').show();
												  		 $('#stack-msg').show();
												  		 break;
					  									
				  		   }
	  			 
	  			 
	    	   });
	    	
	    },
	     kick:function( response ){
	    	
	    	 
	    	 	$('.show_login').hide();
	    	 
	    	 	
	    	    $('#loginStatus').html('');
		  		$("<p>"+response.message+"</p>").appendTo('#loginStatus');
		  		$('<input type="button" class="button-submit" name="kick" value="  Kick session  ">').click( function(){
		  			$('[name=kicking]').val('kick');
		  			$.idx.login();
		  			/*
		  			 $.post('index_process.php' , { "login" :  $('[name=uid]').val() ,  "passwd" :  $('[name=passwd]').val()  }, function( data ){ 
		  				       var response =  eval('(' +data+ ')'); 
								if(response.result=="success"){
									//keep to cookie;
							  	    window.location = "home.php";
								}  
		  			 });
		  			 */
			
			    }).appendTo('#loginStatus');
			    $('.show_login').hide();
			 
			    $('#loginStatus').append('&nbsp;&nbsp;');
		  		$('<input type="button" class="button-cancel" name="cancelKick" value="  Cancel  ">').click( function(){
	
				    $('#userid').show();
				    $('#iuserid').show();
				    $('#password').show();
				    $('#ipassword').show();
				    $('#blogin').show();
				    $('#loginStatus').text('');
				    $('[name=uid]').val('');
				    $('[name=passwd]').val('');

				    $('[name=uid]').focus();

				    $('.show_login').show();
				    
			    }).appendTo('#loginStatus');
	    	 
	     },
	    disable:function( time ){
	   
	    	   var seconds = Math.ceil(time / 1000);
	    	   var elem = $('#login');
	    	   elem.val( 'Delay login '+' (' + seconds + ')');
	    	   $( document ).off('keypress',$('[name=passwd],[name=uid]'));
	    	   $('#login,#logout').attr('disabled', 'disabled');
	   	   
	    	    var interval = setInterval(function() {
	    	    	
	    	    	elem.val( 'Delay login '+' (' + --seconds + ')');
	                if (seconds === 0) {
	                	elem.val(' Login ');
	                    clearInterval(interval);
	                    
	                    $('#login,#logout').removeAttr('disabled');
	                    $( document ).on('keypress',$('[name=passwd],[name=uid]'), function(e){
	              		  if(e.keyCode==13){ 
	              			   $('#login').trigger('click');
	              		   }
	              	 });
	                    
	                }
	            }, 1000);
	            
	    	
	    },
	    
	    
	}//end jQuery
 })(jQuery)//end function
 
 $(function(){
	 
	
		 //initial page 
	 	$('[name=kicking]').val('');
	    $('.clock').stacktime();
		
		
		$('#stack-msg-close').click( function(){
	 		$('#stack-msg').fadeOut('slow');
	    });
		 
		$('[name=passwd],[name=uid],[name=extension]').on('keypress', function(e) {
			   if(e.keyCode==13){ 
				   $('#login').trigger('click');
			   }
		});
		
		
		$('[name=extension]').keyup(function() {
		  	 if(/[^0-9]/g.test(this.value)){
		  		this.value = this.value.replace(/[^0-9]/g,'')
		  	 } 
	  })
	  
  
		var token = $.cookie('tokenid');
		if( token != undefined ){
			$.idx.init( token );
			$('.show_session').show();
			$('.show_user').hide();
			$('[name=passwd]').focus();
			
		}else{
	
			$('.show_session').hide();
			$('.show_user').show();
			$('[name=uid]').focus();
			
		}
		
		 $('#login').click( function(){ 
	
				 if( token == undefined ){
					if( $('[name=uid]').val() == "" ){
				 		  $('#loginStatus').text('Please enter your user id.').fadeIn('slow');  
						  $('[name=uid]').focus();
						  return;
				 	}
				 }
				
			 	if( $('[name=passwd]').val() == "" ){
			 		  $('#loginStatus').text('Please enter your password.').fadeIn('slow');  
					  $('[name=passwd]').focus();
					  return;
			 	}
			 
		 		$.idx.login();
		 })
		 
		 $('#logout').click( function(){
			 	$.removeCookie('tokenid' , { path: '/' } );
				//window.location="index.php";
		  	    window.location = "logout.php?logout=true";
		});
	
	  
  });
  