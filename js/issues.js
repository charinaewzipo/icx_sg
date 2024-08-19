 (function($){
	var url = "issues_process.php";
	var currentRow = null; 
	var deleteRowid = [];
	var updateRowid = [];
	  jQuery.issues = {
	    check: function(){
	  	    var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'check','data':formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
						
						console.log( data );
					     var  result =  eval('(' + data + ')'); 
					     if( result.result == "false"){
					    	 $('#errmsg').html('This group name is already taken. Please change to another name.');
					     }
						
						
						
					}//end success
					
	        })//end ajax
	    	
	    },
	    init: function(){
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'init' }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
	    	
					       var  result =  eval('(' + data + ')'); 
					   	
					       $('#totalbug').text('').text(result.bug.total);
					       $('#totalreq').text('').text(result.req.total);
					       $('#totalchreq').text('').text(result.chreq.total);
					       $('#totalidea').text('').text(result.idea.total);
					      
					       
					}
	        });//end ajax
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
								    var $table = $('#issues-table tbody'); 
									$table.find('tr').remove();
							
									 var seq = 0;
											 for( i=0 ; i<result.length ; i++){
											     seq++;
											     
								  					var sts = "";
								  					switch(  parseInt(result[i].sts) ){
									  					case 1 : sts = "New"; break;
									  					case 2 : sts = "Inprogress"; break;
									  					case 3 : sts = "Close"; break;
								  					}
								  					
								  					var cat1 = "";
								  					switch(  parseInt(result[i].cat1) ){ 
									  					case 1 : cat1 = "Admin"; break;
									  					case 2 : cat1 = "Home"; break;
									  					case 3 : cat1 = "Campaign"; break;
									  					case 4 : cat1 = "Call List"; break;
									  					case 5 : cat1 = "Manage List"; break;
									  					case 6 : cat1 = "Call Work"; break;
									  					case 7 : cat1 = "Report"; break;
									  					case 8 : cat1 = "Dash Board"; break;
									  					case 9 : cat1 = "Asterisk"; break;
									  					case 10 : cat1 = "Database"; break;
									  					case 11 : cat1 = "Other"; break;
									  				
								  					}
								  		
								  					var cat2 = "";
								  					switch(  parseInt(result[i].cat2) ){
									  					case 1 : cat2 = "Bug"; break;
									  					case 2 : cat2 = "Request"; break;
									  					case 3 : cat2 = "Change Request"; break;
									  					case 4 : cat2 = "Idea"; break;
								  					}
											     
											     $row = $("<tr id='"+result[i].isid+"'>"+
											    		 			"<td style='vertical-align:middle; text-align:center' >&nbsp;"+seq+"&nbsp;</td>"+
											    		 			"<td  style='vertical-align:middle; text-align:center'>"+cat1+"</td>"+
											    		 			"<td style='vertical-align:middle; text-align:center'>"+cat2+"</td>"+
											    		 			"<td > <a href='#' class='nav-issue-id' >"+result[i].sub+"</a> <br/> "+result[i].det+"  </td>"+
											    		 			"<td style='vertical-align:middle; text-align:center'>"+sts+"</td>"+
											    		 			"<td style='vertical-align:middle; text-align:center'>"+result[i].cred+"</td>"+
											    		 			"<td style='vertical-align:middle; text-align:center'>"+result[i].creu+"</td>"+
											    		 			"</tr>");	 
											     
												  $row.appendTo($table);
												  $.issues.gridSet($row);
											    } 
											
											 
											 //add event
											   $('.nav-issue-id').on('click',function(e){
										    	     e.preventDefault();
										    	     $.issues.detail( $(this).parent().parent().attr('id')  );
										    	     
										    	    	//$('#group-main-pane').hide();
										            	//$('#group-detail-pane').show();
									           })
											    
					                if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='7' class='text-center'>&nbsp; No issue  &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{
										var $table = $('#group-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='7'  style='border-top: 1px solid #EAEAEA; text-align:center' ><small> Total "+i+" Record"+s+" </small></td></tr>");
										$addRow.appendTo($table);
									}
									
							 }   
						});//end ajax 
	        
	        $.issues.init();
	    	
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
		                 
				         		$('[name=isid]').val(result.data.isid);
			                    $('[name=sub]').val(result.data.sub);
				                $('[name=det]').val(result.data.det);
				            	$('[name=sol]').val(result.data.sol);
			            	    $('[name=cat1]').val(result.data.cat1);
				                $('[name=cat2]').val(result.data.cat2);
				            	$('[name=status]').val(result.data.sts);
			                 	$('[name=credate]').val(result.data.cred);
			                    $('[name=creuser]').val(result.data.creu);
			            	
						}//end success
					});//end ajax 
			},	  
			 create:function(){

					$('[name=creuser]').val( "--system auto fill--" );	
                    $('[name=credate]').val( "--system auto fill--"	);	
                    
					$('[name=isid]').val("");	
                    $('[name=sub]').val("");	
	                $('[name=det]').val("");	
	            	$('[name=sol]').val("");	
            	    $('[name=cat1]').val("");	
	                $('[name=cat2]').val("");	
	            	$('[name=status]').val("");	
                 		
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.issues.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.issues.create();
						        $.issues.load();						    	
						    }
				 });
		    
		    },
			 cancel: function(){
				$.issues.detail(  $('[name=isid]').val() ); 
				 
			 },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=isid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        }).dblclick( function(e){
				    	 $.issues.detail( $row.attr('id') );
				    	 
				   //   	 $('#group-main-pane').hide();
				    //	 $('#group-detail-pane').show();				 
				    })
				  
			  },
			 

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
		 
	  $.issues.load(); 
	  $('.cancel_issue').click( function(e){
		  		e.preventDefault();
				$.issues.cancel();
	   });
	  $('.new_issue').click( function(e){
		  		e.preventDefault();
				$.issues.create();
	   });
	  $('.delete_issue').click( function(e){
		  e.preventDefault();
		  var confirm = window.confirm('Are you sure to delete');
		  if( confirm ){
				$.issues.remove();
		  }
	   });
	  $('.save_issue').click( function(e){
		  		e.preventDefault();
				$.issues.save();
	   });
	  

	  
  });
  