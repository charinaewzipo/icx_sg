 (function($){
	var url = "saleScript-pane_process.php";
	var currentRow = null; 
	var deleteRowid = [];
	var updateRowid = [];
	  jQuery.script = {
		init:function(){
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'init' }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
			                        var  result =  eval('(' + data + ')'); 
			                        
								      //group location
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.group.length ; i++){
									  option += "<option value='"+ result.group[i].id +"'>"+ result.group[i].value +"</option>";									    										    
									 }								
									 $('[name=tgid]').text('').append(option);
									 
									 //team
									 /*
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.team.length ; i++){
									  option += "<option value='"+ result.team[i].id +"'>"+ result.team[i].value +"</option>";									    										    
									 }								
									 $('[name=tid]').text('').append(option);
									 */
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
								    var $table = $('#callscript-table tbody'); 
									$table.find('tr').remove();
									var i=0;
							
											 for( i=0 ; i<result.length ; i++){
												 seq = i;
											     seq++;
											     
											     $row = $("<tr id='"+result[i].scriptid+"'><td style='vertical-align:middle; text-align:right' >&nbsp;"+seq+"&nbsp;</td>"+
											    		   "<td ><a href='#' class='nav-script-id'><strong>&nbsp;"+result[i].sname+"</strong></a></td>"+	
											    		   "<td >&nbsp;"+result[i].sdetail+"&nbsp;</td>"+
														   "<td >&nbsp;&nbsp;</td></tr>");	 
											     
												  $row.appendTo($table);
												  $.campaign.gridSet($row);
												  
											    } 
											
											 
											 //add event
											   $('.nav-script-id').bind('click',function(e){
										    	     e.preventDefault();
										    	     $.script.detail( $(this).parent().parent().attr('id')  );
										    	     
										    	    	$('#callscript-main-pane').hide();
										            	$('#callscript-detail-pane').show();
									           })
											    
					                if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='3' class='text-center'>&nbsp;<img src='image/0.png'> &nbsp; Data not found &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{
										var $table = $('#callscript-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='3'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
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
		
			           	  $('[name=scriptid]').val(result.data.scriptid);
						  $('[name=sname]').val(result.data.sname);
			              $('[name=sdetail]').val(result.data.sdetail);
			     
		               
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				 
				  $('[name=scriptid]').val('');
				  $('[name=sname]').val('');
	              $('[name=sdetail]').val('');
	            
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.script.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.script.create();
						        $.script.load();						    	
						    }
				 });
		    
		    },
			 cancel: function(){
				$.script.detail(  $('[name=teamid]').val() ); 
				 
			 },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=scriptid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        }).dblclick( function(e){
				    	 $.campaign.detail( $row.attr('id') );
				    	 
				      	 $('#callscript-main-pane').hide();
				    	 $('#callscript-detail-pane').show();				 
				    })
				  
			  },
		

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){

	  $.script.load();
	  $('.cancel_callscript').click( function(e){
		  		e.preventDefault();
				$.script.cancel();
	   });
	  $('.new_callscript').click( function(e){
		  		e.preventDefault();
				$.script.create();
	   });
	  $('.delete_callscript').click( function(e){
		  e.preventDefault();
		  var confirm = window.confirm('Are you sure to delete');
		  if( confirm ){
				$.script.remove();
		  }
	   });
	  $('.save_callscript').click( function(e){
		  		e.preventDefault();
				$.script.save();
	   });
	  
	  
  });
  