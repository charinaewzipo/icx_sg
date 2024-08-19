 (function($){
	var url = "setting-pane_process.php";
	  jQuery.ufield = {
		init:function(){
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'ufeld_init' }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
			                        var  result =  eval('(' + data + ')'); 
			                        var $table = $('#user-field-table tbody'); 
									$table.find('tr').remove();
									var i=0;
									var seq = 0;
				
											 for( i=0 ; i<result.sysfield.length ; i++){
												seq++;
											     
												var sts = "active";
												if(result.sysfield[i].status != 1){
													sts = "inactive";
												}
												
											     $row = $("<tr id='"+result.sysfield[i].fid+"'><td style='vertical-align:middle; text-align:right' >&nbsp;"+seq+"&nbsp;</td>"+
											    		   "<td ><a href='#' class='nav-udefine-id'><strong>"+result.sysfield[i].fname+"</strong></a></td>"+		
														   "<td class='text-center'>&nbsp;"+result.sysfield[i].ftype+"&nbsp;</td>"+
														   "<td class='text-center'>&nbsp;"+sts+"&nbsp;</td>"+
														   "<td class='text-center'>&nbsp;"+result.sysfield[i].cuser+"&nbsp;</td>"+
														   "<td class='text-center'>&nbsp;"+result.sysfield[i].cdate+"&nbsp;</td>"+
														//   "<td class='text-center'>&nbsp;"+result.sysfield[i].uuser+"&nbsp;</td>"+
														//   "<td class='text-center'>&nbsp;"+result.sysfield[i].udate+"&nbsp;</td>"+
														   "</tr>");	 
											     
												  $row.appendTo($table);
												  //$.team.gridSet($row);
											    } 
											
											  
											 //add event
											   $('.nav-udefine-id').on('click',function(e){
										    	        e.preventDefault();
										    	        $.ufield.detail( $(this).closest('tr').attr('id')  );
										    	     
										    	        $('#user-field-main-pane').hide();
										    		    $('#user-field-detail-pane').fadeIn('slow');
									           })
									            
						                if(i==0){   
						            		 $table = $('#user-field-table tfoot'); 
										     $row = $("<tr><td colspan='6' class='text-center'>&nbsp; No User Defined Field &nbsp;</td></tr>");
										     $row.appendTo($table);
										}else{
											$table = $('#user-field-table tfoot'); 
											$table.find('tr').remove();
											var s = "s";
											if(i<1){	s = "";	}
										    $addRow = $("<tr ><td colspan='6'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
											$addRow.appendTo($table);
										}
							
					}
			   })//end ajax			
			
		},
	    detail:function( id ){
	    	if( id == ""){
	    		alert("id is empty ");
	    		return;
	    	}
	  
			    $.ajax({   'url' : url, 
					   'data' : { 'action' : 'ufield_detail','fid': id }, 
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
		                 
		                    $('[name=fid]').val(result.data.fid);
		                    $('[name=userdefine]').val(result.data.faname);
			            	$('[name=fieldstatus]').val(result.data.fstatus);
			            	
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				  
				  $('[name=fid]').val('');
				  $('[name=userdefine]').val('');
	              $('[name=fieldstatus]').val('1');
	            	
	              $('#user-field-main-pane').hide();
	              $('#user-field-detail-pane').fadeIn('slow');
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "ufield_save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.ufield.init();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "ufield_delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.ufield.create();
						        $.ufield.init();
						        //back to main menu
						        $('#user-field-main-pane').fadeIn('slow');
							    $('#user-field-detail-pane').hide();
						    }
				 });
		    
		    },
		

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	
	  
	  //start user defined setting
	  $.ufield.init();
	  
	  $('#user-field-table tbody').on('click','tr', function(e){
		    e.preventDefault();
	  })
	   $('#user-field-table tbody').on('dblclick','tr', function(e){
		   e.preventDefault();
		   $.ufield.detail( $(this).closest('tr').attr('id'));
	       $('#user-field-main-pane').hide();
	       $('#user-field-detail-pane').fadeIn('slow');
	  })
	  
	  $('#user-defined-back-main').click( function(){
		   $('#user-field-main-pane').fadeIn('slow');
	       $('#user-field-detail-pane').hide();
	  })
	  
	  //text restrict
	  $('[name=userdefine]').keyup(function() {
		  	if(/[^a-zA-Z0-9_]/g.test(this.value)){
		  		this.value = this.value.replace(/[^a-zA-Z0-9_]/g,'')
		  	} 
		});
	  
	  
	  $('#ufield-back-main').click( function(e){
			$('#setting-main-pane').show();
			$('#setting-detail-pane').hide();
	  })
	  
	  $('.cancel_ufield').click( function(e){
		  		e.preventDefault();
				$.ufield.cancel();
	   });
	  $('.new_ufield').click( function(e){
		  		e.preventDefault();
				$.ufield.create();
	   });
	  $('.delete_ufield').click( function(e){
			  e.preventDefault();
			  var confirm = window.confirm('Are you sure to delete');
			  if( confirm ){
					$.ufield.remove();
			  }
	   });
	  $('.save_ufield').click( function(e){
		  		e.preventDefault();
		  		if( $('[name=userdefine]').val() == "" ){
		  			alert("Field Defined Name Can't Blank. Please fill user define");
		  			$('[name=userdefine]').focus();
		  			return;
		  		}
				$.ufield.save();
	   });
	  
	  
  });
  