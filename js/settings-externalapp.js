 (function($){
	var url = "setting-pane_process.php";
	  jQuery.exapp = {
		init:function(){
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'exapp_init' }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
			                        var  result =  eval('(' + data + ')'); 
			                        var $table = $('#exapp-table tbody'); 
									$table.find('tr').remove();
									var i=0;
									var seq = 0;
				
											 for( i=0 ; i<result.exapp.length ; i++){
												seq++;
											     
												var sts = "active";
												if(result.exapp[i].exappsts != 1){
													sts = "inactive";
												}
												
											     $row = $("<tr id='"+result.exapp[i].exappid+"'><td style='vertical-align:middle; text-align:right' >&nbsp;"+seq+"&nbsp;</td>"+
											    		  "<td class='text-center'>&nbsp;"+result.exapp[i].exappcname+"&nbsp;</td>"+
											    		   "<td ><a href='#' class='nav-exapp-id'>"+result.exapp[i].exappname+"</a></td>"+		
														   "<td class='text-center'>&nbsp;"+result.exapp[i].exappurl+"&nbsp;</td>"+
														   "<td class='text-center'>&nbsp;"+sts+"&nbsp;</td>"+
														   "<td class='text-center'>&nbsp;"+result.exapp[i].cuser+"&nbsp;</td>"+
														   "<td class='text-center'>&nbsp;"+result.exapp[i].cdate+"&nbsp;</td>"+
														//   "<td class='text-center'>&nbsp;"+result.sysfield[i].uuser+"&nbsp;</td>"+
														//   "<td class='text-center'>&nbsp;"+result.sysfield[i].udate+"&nbsp;</td>"+
														   "</tr>");	 
											     
												  $row.appendTo($table);
											
											    } 
											
											  
											 //add event
											   $('.nav-exapp-id').on('click',function(e){
										    	        e.preventDefault();
										    	        $.exapp.detail( $(this).closest('tr').attr('id')  );
										    	     
										    	        $('#exapp-main-pane').hide();
										    		    $('#exapp-detail-pane').fadeIn('slow');
									           })
									      
									           
						                if(result.total==0){   
						            		 $table = $('#exapp-table tfoot'); 
						 					 $table.find('tr').remove();
										     $row = $("<tr><td colspan='7' class='text-center'>&nbsp; No External Application Found &nbsp;</td></tr>");
										     $row.appendTo($table);
										}else{
											$table = $('#exapp-table tfoot'); 
											$table.find('tr').remove();
											var s = "s";
											if(i<1){	s = "";	}
											$row = $("<tr ><td colspan='7'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
											$row.appendTo($table);
										}
									
											  
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.cmp.length ; i++){
									  option += "<option value='"+ result.cmp[i].id +"'>"+ result.cmp[i].value +"</option>";									    										    
									 }								
									 $('[name=exapp_campaign]').text('').append(option);
									
					}
			   })//end ajax			
			
		},
	    detail:function( id ){
	    	if( id == ""){
	    		alert("id is empty ");
	    		return;
	    	}
	  
			    $.ajax({   'url' : url, 
					   'data' : { 'action' : 'exapp_detail','exappid': id }, 
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
		                 
		                 	$('[name=exappid]').val(result.data.exappid);
		                    $('[name=exapp_campaign]').val(result.data.exappcmpid);
		                    $('[name=exapp_name]').val(result.data.exappname);
			            	$('[name=exapp_url]').val(result.data.exappurl);
			            	$('[name=exapp_icon]').val(result.data.exappicon);
			            	$('[name=exapp_sts]').val(result.data.exappsts);
			            	
			            	
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				  
				  $('[name=fid]').val('');
				  $('[name=exappid]').val('');
				  $('[name=exapp_campaign]').val('');
	              $('[name=exapp_name]').val('');
	              $('[name=exapp_url]').val('');
	              $('[name=exapp_icon]').val('');
	              $('[name=exapp_sts]').val('1');
	              
	            	
	              $('#exapp-main-pane').hide();
	              $('#exapp-detail-pane').fadeIn('slow');
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "exapp_save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.exapp.init();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "exapp_delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.exapp.create();
						        $.exapp.init();
						        //back to main menu
						        $('#exapp-main-pane').fadeIn('slow');
							    $('#exapp-detail-pane').hide();
						    }
				 });
		    
		    },
		

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  
	  
	  //start user defined setting
	  $.exapp.init();
	  
	  $('#exapp-table tbody').on('click','tr', function(e){
		    e.preventDefault();
	  })
	  
	   $('#exapp-table tbody').on('dblclick','tr', function(e){
		   e.preventDefault();
		   $.exapp.detail( $(this).closest('tr').attr('id'));
	       $('#exapp-main-pane').hide();
	       $('#exapp-detail-pane').fadeIn('slow');
	  })
	  
	  $('#exapp-back-main').click( function(){
		   $('#exapp-main-pane').fadeIn('slow');
	       $('#exapp-detail-pane').hide();
	  })
	  
	  
	  
	  
	  $('#exapp-back-main').click( function(e){
			$('#exapp-main-pane').show();
			$('#exapp-detail-pane').hide();
	  })
	  
	  $('.cancel_exapp').click( function(e){
		  		e.preventDefault();
				$.exapp.cancel();
	   });
	  $('.new_exapp').click( function(e){
		  		e.preventDefault();
				$.exapp.create();
	   });
	  $('.delete_exapp').click( function(e){
			  e.preventDefault();
			  var confirm = window.confirm('Are you sure to delete');
			  if( confirm ){
					$.exapp.remove();
			  }
	   });
	  $('.save_exapp').click( function(e){
		  		e.preventDefault();
		  		if( $('[name=exapp_name]').val() == "" ){
		  			alert("Field External Application Name Can't Blank. Please fill External Application Name");
		  			$('[name=exapp_name]').focus();
		  			return;
		  		}
		  		
		  		if( $('[name=exapp_url]').val() == "" ){
		  			alert("Field External Application URL Can't Blank. Please fill External Application URL");
		  			$('[name=exapp_url]').focus();
		  			return;
		  		}
		  		
				$.exapp.save();
	   });
	  
	  
  });
  