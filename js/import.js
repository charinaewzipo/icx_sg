 (function($){
	var url = "import_process.php";
	var currentRow = null; 
	var deleteRowid = [];
	var updateRowid = [];

	  jQuery.imp = {
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
										//remove image loading 
										//$('#loading').html('').append("Project Management Sheet");
										
				                        var  result =  eval('(' + data + ')'); 
				                        
									      //position location
				             
										 var option = "<select><option value='0'>  --- Do not map this field --- </option>";
										 for( i=0 ; i<result.init.length ; i++){
										  option += "<option value='"+ result.init[i].id +"'>"+ result.init[i].alias+"</option>";									    										    
										 }								
										 option += "</select>";
										 //$('[name=mapping]').text('').append(option);
										// var select = "";
										// select.html( $('[name=mapping]').text() );
										// console.log( select );
										 
										 //list header field
										    var $table = $('#import-table tbody'); 
											$table.find('tr').remove();
											var i=0;
									
													 for( i=0 ; i<result.header.length ; i++){
														 seq = i;
													     seq++;
													     
													     $row = $("<tr ><td >&nbsp;"+seq+"&nbsp;</td>"+
													    		   "<td seq='"+result.header[i].seq+"' >&nbsp;"+result.header[i].value+"&nbsp;</td>"+
													    		   "<td >&nbsp;"+option+"&nbsp;</td>"+
													     		   "</tr>");	 
													     
														  $row.appendTo($table);
														//  $.issue.gridSet($row);
													    } 
													 
										 
										 //department
										 /*
										 var option = "<option value=''> &nbsp; </option>";
										 for( i=0 ; i<result.dept.length ; i++){
										  option += "<option value='"+ result.dept[i].id +"'>"+ result.dept[i].value +"</option>";									    										    
										 }								
										 $('[name=dept]').text('').append(option);
										 */
						}
				   })//end ajax		
			 },
				import:function(){
					
					
				},
				//not use
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
					                		var $table = $('#cust-table tbody');
											$table.find('tr').remove();
													 for( i=0 ; i<result.length ; i++){
														 seq = i;
													     seq++;
													     
													     
													     $row = $("<tr id='"+result[i].cid+"'><td>&nbsp;"+seq+"&nbsp;</td>"+
													    		   "<td ><a href='#' class='nav-cust-id'>"+result[i].nname+" <strong>&nbsp;"+result[i].fname+"</strong></a></span></td>"+		
																   "<td >&nbsp;"+result[i].lname+"&nbsp;</td>"+
																   "<td >&nbsp;"+result[i].jtitle+"&nbsp;</td>"+
																   "<td >&nbsp;"+result[i].aid+"&nbsp;</td>"+
																   "<td >&nbsp;"+result[i].email1+"&nbsp;</td>"+
																   "<td >&nbsp;"+result[i].mphone+"&nbsp;</td>"+
																   "<td >&nbsp;"+result[i].ato+"&nbsp;</td>"+
																   "</tr>");	 
													     
														  $row.appendTo($table);
														  $.cust.gridSet($row);
													    } 
													
													 
													 //add event
													   $('.nav-cust-id').bind('click',function(e){
												    	     e.preventDefault();
												    	     $.cust.detail( $(this).parent().parent().attr('id')  );
												    	     
												    	  	$('#customer-main-pane').hide();
											            	$('#customer-detail-pane').show();
												    
											           })
													    
							                if(i==0){   
											     $row = $("<tr id='nodata'><td colspan='3' class='text-center'>&nbsp; <span class='fa fa-times-circle fa-lg'></span> &nbsp; Data not found &nbsp;</td></tr>")
											     $row.appendTo($table);
											}else{
												var $table = $('#dept-table tfoot'); 
												$table.find('tr').remove();
												var s = "s";
												if(i<1){	s = "";	}
											    $addRow = $("<tr ><td colspan='3'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
												$addRow.appendTo($table);
											}
											
									 }   
								});//end ajax 
			    	
			    },	   
			    // not use
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
				                
				                    $('[name=cid]').val(result.data.cid);
					                $('[name=pname]').val(result.data.pname);
					            	$('[name=fname]').val(result.data.fname);
					            	$('[name=lname]').val(result.data.lname);
					            	$('[name=nname]').val(result.data.nname);
					            	$('[name=ophone]').val(result.data.ophone);
					            	$('[name=mphone]').val(result.data.mphone);
					            	$('[name=hphone]').val(result.data.hphone);
					            	$('[name=otphone]').val(result.data.otphone);
					            	$('[name=fax]').val(result.data.fax);
					            	$('[name=bdate]').val(result.data.bdate);
					            	$('[name=aid]').val(result.data.aid);
					            	$('[name=lid]').val(result.data.lid);
					            	$('[name=jtitle]').val(result.data.jtitle);
					            	$('[name=dept]').val(result.data.dept);
					            	$('[name=email1]').val(result.data.email1);
					            	$('[name=email2]').val(result.data.email2);
					            	$('[name=cstatus]').val(result.data.cstatus);
					            	$('[name=assignto]').val(result.data.ato);
					             	$('[name=cdesc]').val(result.data.cdesc);
					         
					            	$('[name=daddno]').val(result.data.daddno);
					            	$('[name=dbuilding]').val(result.data.dbuilding);
					            	$('[name=droom]').val(result.data.droom);
					            	$('[name=dfloor]').val(result.data.dfloor);
					            	$('[name=dvillage]').val(result.data.dvillage);
					            	$('[name=dmoo]').val(result.data.dmoo);
					            	$('[name=dsoi]').val(result.data.dsoi);
					            	$('[name=droad]').val(result.data.droad);
					            	$('[name=dtumbon]').val(result.data.dtumbon);
					            	$('[name=damphur]').val(result.data.damphur);
					            	$('[name=dprovince]').val(result.data.dprovince);
					            	$('[name=dcountry]').val(result.data.dcountry);
					            	$('[name=dpostcode]').val(result.data.dpostcode);
					            	
					             	$('[name=iaddno]').val(result.data.iaddno);
					            	$('[name=ibuilding]').val(result.data.ibuilding);
					            	$('[name=iroom]').val(result.data.iroom);
					            	$('[name=ifloor]').val(result.data.ifloor);
					            	$('[name=ivillage]').val(result.data.ivillage);
					            	$('[name=imoo]').val(result.data.imoo);
					            	$('[name=isoi]').val(result.data.isoi);
					            	$('[name=iroad]').val(result.data.iroad);
					            	$('[name=itumbon]').val(result.data.itumbon);
					            	$('[name=iamphur]').val(result.data.iamphur);
					            	$('[name=iprovince]').val(result.data.iprovince);
					            	$('[name=icountry]').val(result.data.icountry);
					            	$('[name=ipostcode]').val(result.data.ipostcode);
					            	
					             	//$('#group-pane').hide();
					            	//$('#group-detail-pane').show();
							         
								}//end success
							});//end ajax 
					},	  
					//not use
					 create:function(){
						 	 //clear all input
						     $( ":input" ).val("");
			            	
						  	 $('#customer-main-pane').hide();
				             $('#customer-detail-pane').show();		
			            	
						  
					 },
					 //not use
					   save:function(){
							  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
							  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
								    var response = eval('('+result+')');  
									    if(response.result=="success"){
									  
									          $.cust.load();				
									          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
									    }
							 });
							
								
				    },
				    //not use
				    remove:function(){
				    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
						  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
							       var response = eval('('+result+')');  
								    if(response.result=="success"){
								        $.cust.create();
								        $.cust.load();		
								        
								      	 $('#customer-main-pane').show();
							             $('#customer-detail-pane').hide();			 
								        
								    }
						 });
				    
				    },
					 cancel: function(){
						$.dept.detail(  $('[name=did]').val() ); 
						 
					 },
					  gridSet:function($row){
			
						    $row 
							.find('td').click( function(e){
								$('[name=cid]').val( $row.attr('id') );	
							})
							.hover( function(){
								 $row.addClass('row-hover');
							}, function() {
							    $row.removeClass('row-hover');
					        }).dblclick( function(e){
						    	 $.cust.detail( $row.attr('id') );
						    	 $('#customer-main-pane').hide();
					             $('#customer-detail-pane').show();			 
						    })
						  
					  },
					  
			}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  /*
	  //initial calendar
	 $('.calendar_en').datepicker({
	      dateFormat: 'dd/mm/yy'
	 });

	 $.cust.load();
	  $('.cancel_cust').click( function(e){
		  		e.preventDefault();
				$.cust.cancel();
	   });
	  $('.new_cust').click( function(e){
		  		e.preventDefault();
				$.cust.create();
	   });
	  $('.delete_cust').click( function(e){
		  	 e.preventDefault();
			  var confirm = window.confirm('Are you sure to delete');
			  if( confirm ){
					$.cust.remove();
			  }
	   });
	  $('.save_cust').click( function(e){
		  		e.preventDefault();
				$.cust.save();
	   });
	  
		

			$('.back-to-main').click( function(){
			 	 $('#customer-main-pane').show();
	             $('#customer-detail-pane').hide();			 
			})
		*/
		 
	
  });
  