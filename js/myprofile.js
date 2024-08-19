 (function($){
	var url = "myprofile_process.php";
	  jQuery.myprofile = {
	    load: function(){
	  	  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'detail','data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					 
					     
					},										
					'success' : function(data){ 
							
			                        var  result =  eval('(' + data + ')'); 
			                        
			                        //profile
			                        $('[name=ufirstname]').val( result.profile.ufirstname );
			                        $('[name=ulastname]').val( result.profile.ulastname );
			                        $('[name=unickname]').val( result.profile.unickname );
			                        $('[name=ulogin]').val( result.profile.ulogin );
			                        $('[name=umobile]').val( result.profile.umobile );
			                        $('[name=uquote]').val( result.profile.uquote );
			                        
			                        $('#myimg').attr('src', result.profile.uimg )
			                        
			                        $('#preview_nname').text('').text( result.profile.unickname);
			                        $('#preview_uname').text('').text( result.profile.ufirstname+" "+result.profile.ulastname);
			                        $('#preview_group').text('').text( result.profile.uteam+" "+result.profile.ugroup);
			                        $('#preview_email').text('').text("Email : "+result.profile.uemail);
			                        $('#preview_mobile').text('').text("Mobile : "+result.profile.umobile );
			                        $('#preview_extension').text('').text("Extension : "+result.profile.uext);
			                        
			                        //my settings tab
			                        $('[name=uextension]').val( result.profile.uext );
			                        $('[name=upasswd]').val("");
			                        $('[name=re-upasswd]').val("");
			                        
			                        if( result.uquote != "" ){
			                        	$('#preview_quote').text('').text(result.profile.uquote) //show text
			                        	$('#preview_quote').parent().show()				 //show tag
			                        }else{
			                        	$('#preview_quote').parent().hide(); // hide tag
			                        }
			                        
			                        //logon report
			                        var $table = $('#logon-report-table tbody');
									$table.find('tr').remove();
									 for( i=0 ; i<result.logon.length ; i++){
									
									     
									     $row = $("<tr><td>&nbsp;"+result.logon[i].date+"&nbsp;</td>"+
									    		   "<td class='text-center' style='vertical-align:middle'>&nbsp;"+result.logon[i].login+"&nbsp;</td>"+
									    		   "<td class='text-center' style='vertical-align:middle'>&nbsp;"+result.logon[i].logout+"&nbsp;</td>"+
												   "<td class='text-center' style='vertical-align:middle'>&nbsp;"+result.logon[i].logon+"&nbsp;</td></tr>");	 
									     
										  $row.appendTo($table);
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
		                    $('[name=pid]').val(result.data.pid);
			                $('[name=pname]').val(result.data.pname);
			            	$('[name=pdesc]').val(result.data.pdesc);
			            	
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				 
				  $('[name=pid]').val('');
	              $('[name=pname]').val('');
	              $('[name=pdesc]').val(''); 
	            	
	           	  $('#position-main-pane').hide();
		    	  $('#position-detail-pane').show();				
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.myprofile.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.position.create();
						        $.position.load();						    	
						    }
				 });
		    
		    },
			 cancel: function(){
				$.position.detail(  $('[name=pid]').val() ); 
				 
			 },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=pid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        }).dblclick( function(e){
				    	 $.position.detail( $row.attr('id') );
				    	 
				      	 $('#position-main-pane').hide();
				    	 $('#position-detail-pane').show();				 
				    })
				  
			  },
			

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  
	  var require_reload = true;
	  $.myprofile.load();
	  $('.save_myprofile').click( function(e){
	  		e.preventDefault();
			$.myprofile.save();
	  });
	  
	  //close profile button
	  $('#profile-close').click( function(){
		    if(require_reload){
		    	location.reload();
		    }
			$('#profile-pane').fadeOut('slow');
		});
	  
		$('[name=uextension]').keyup(function() {
		  	 if(/[^0-9]/g.test(this.value)){
		  		this.value = this.value.replace(/[^0-9]/g,'')
		  	 } 
	  })
	   
	  $('#myimg,#myimg-edit').mouseenter( function(){
		  $('#myimg').css('background-color','rgba(0, 0, 0, 0.5)')
		  $('#myimg-edit').show();
		// self.prepend("<div id='myimg-edit' class='ion-ios7-upload-outline' style='font-size:65px; position:absolute;left:45%; z-index:21;color:#fff; cursor:pointer '></div>")
		
	  }).mouseout( function(){
		  $('#myimg-edit').hide();
		  $('#myimg').css('background-color','#fff')
		  
	  })
	  
	  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	   $('#myimg,#myimg-edit').dropzone({		 
		       params: {
		    	      'action' : 'avatar',
		    		   'data':formtojson,
		    		   'uid': $('[name=uid]').val()
		       },	       
		 	   url: "myprofile_process.php", 
		 	   createImageThumbnails : false ,
		 	   acceptedFiles: "image/*",
		 	   success: function( file ,result ){
		 	
		 				 var  res =  eval('(' + result + ')'); 
		 				 if( res.result =="success"){ 
		 					 
		 					d = new Date();
		 					
		 					//refresh tag without reload 
		 					$("#myimg").fadeOut(1200, function(){
		 						$(this).attr('src', res.path+"?"+d.getTime()).fadeIn(1200, function(){});
		 					})
		 					
		 					$("#abc").fadeOut(1500, function(){
		 						$(this).attr('src','');
		 						$(this).attr('src', res.path+"?"+d.getTime()).fadeIn(1200, function(){});
		 					})
		 					
		 					require_reload = true;
		 				 }//end if
		 		   }//end success
	      });
	  
	 $('.drop').click( function(e){
			e.preventDefault();
			$('.wrapper-dropdown-5').removeClass('active');
			$(this).toggleClass('active');
			e.stopPropagation();
	 });
	  $('#umonth > li').click( function(e){
			 e.preventDefault();
			 e.stopPropagation();
			 var self = $(this);
			 $('.wrapper-dropdown-5').removeClass('active');
			 self.parent().parent().removeClass('active');
			 self.parent().parent().children('span').removeClass('span-placeholder').text( $(this).text() );
			 
			 $('[name=umm]').val( self.attr('id') );
       });
	  
	  $('#gender > li').click( function(e){
			 e.preventDefault();
			 e.stopPropagation();
			 var self = $(this);
			 $('.wrapper-dropdown-5').removeClass('active');
			 self.parent().parent().removeClass('active');
			 self.parent().parent().children('span').removeClass('span-placeholder').text( $(this).text() );
			 
			 $('[name=ugender]').val( self.attr('id') );
    });
	  
		$(document).click(function(){
			$('.wrapper-dropdown-5').removeClass('active');
		});
	  
	  
  });
  