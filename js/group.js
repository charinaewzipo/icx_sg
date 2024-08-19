 (function($){
	var url = "group-pane_process.php";
	var currentRow = null; 
	var deleteRowid = [];
	var updateRowid = [];
	  jQuery.group = {
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
								    var $table = $('#group-table tbody'); 
									$table.find('tr').remove();
									var i=0;
							
											 for( i=0 ; i<result.length ; i++){
												 seq = i;
											     seq++;
											     
											     $row = $("<tr id='"+result[i].gid+"'><td style='vertical-align:middle; text-align:right' >&nbsp;"+seq+"&nbsp;</td>"+
											    		   "<td ><a href='#' class='nav-group-id'><strong>&nbsp;"+result[i].gname+"</strong></a><br/><span style='color:#777777;'>&nbsp;"+result[i].gdetail+"</span></td>"+		
														   "<td >&nbsp;&nbsp;</td></tr>");	 
											     
												  $row.appendTo($table);
												  $.group.gridSet($row);
											    } 
											
											 
											 //add event
											   $('.nav-group-id').on('click',function(e){
										    	     e.preventDefault();
										    	     $.group.detail( $(this).parent().parent().attr('id')  );
										    	     
										    	    	$('#group-main-pane').hide();
										            	$('#group-detail-pane').show();
									           })
											    
					                if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='3' class='listTableRow small center'>&nbsp;<img src='image/0.png'> &nbsp; Data not found &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{
										var $table = $('#group-table tfoot'); 
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
		                    $('[name=groupid]').val(result.data.gid);
			                $('[name=gname]').val(result.data.gname);
			            	$('[name=gdetail]').val(result.data.gdetail);
			            	
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				 
				  $('[name=groupid]').val('');
	              $('[name=gname]').val('');
	              $('[name=gdetail]').val(''); 
	            	
	           	  $('#group-main-pane').hide();
		    	  $('#group-detail-pane').show();				
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.group.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.group.create();
						        $.group.load();						    	
						    }
				 });
		    
		    },
			 cancel: function(){
				$.group.detail(  $('[name=pid]').val() ); 
				 
			 },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=gid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        }).dblclick( function(e){
				    	 $.group.detail( $row.attr('id') );
				    	 
				      	 $('#group-main-pane').hide();
				    	 $('#group-detail-pane').show();				 
				    })
				  
			  },
			  _rtl:function( alluser ){
				  
				   //remove all member
					var li = "";  		
					var i = 0;
				   //display all member
				    $('#member').find('li').remove();
					$.dept._countPerson( $('#count_member'), $('#member li') );
					
				   //display all user  	
				   li="";
				   i=0;
				   $.dept._countPerson( $('#count_user'), alluser);
				   if(alluser.length!=0){
				           for( i=0;i<alluser.length;i++){
				               li +='<li class="stack-ltr"><input type="checkbox" value='+alluser[i].aid+' class="list-user"> '+alluser[i].fname+' '+alluser[i].lname+'</li>'; 	   
				           }
				   }else{
					   li = "No user";
				   }
		           $('#users').html(li);
		           
		           $('.stack-ltr , .stack-rtl').on( 'click' , function(e){
			       		if(e.target==this){
			       				$check = $(this).find('input');
			       				$check.trigger('click');
						}
	           })
	           
	           $('#btn-ltr').on( 'click', function(){
	        	     list = $('#users li');
	        	     $.each( list , function( index , obj ){
	        	     li = $(obj);
	        	     chbox = li.find('input');
	        	    	 if(chbox.is(':checked')){
	        	    		  $('#member').append(  li )
	        	    	 }
	        	     })
	        	  	 $.dept._countPerson( $('#count_user'), $('#users li') );
	        	     $.dept._countPerson( $('#count_member'), $('#member li') );
	           })
	           
	           $('#btn-rtl').on( 'click', function(){
	        	     list = $('#member li');
	        	     $.each( list , function( index , obj ){
	        	     li = $(obj);
	        	     chbox = li.find('input');
	        	    	 if(chbox.is(':checked')){
	        	    		  $('#users').append(  li );
	        	    	 }
	        	     })
	        	  	 $.dept._countPerson( $('#count_user'), $('#users li') );
	        	     $.dept._countPerson( $('#count_member'), $('#member li') );
	           })
				  
			  },
			  
			  _ltr:function( member , nomember ){
				  
					var li = "";  		
					var i = 0;
				   //display all member
					$.dept._countPerson( $('#count_member'), member);
					if( member.length!=0){
					    for( i=0;i< member.length;i++){
				               li +='<li class="stack-rtl"><input type="checkbox" value='+ member[i].aid+' class="list-member"> '+member[i].fname+' '+member[i].lname+'</li>'; 	  
				        }
					}else{
						li = "No member";
					}
				    $('#member').html(li);
				    
					//display no member  	
				   li="";
				   i=0;
				   $.dept._countPerson( $('#count_user'), nomember);
				   if(nomember.length!=0){
				           for( i=0;i<nomember.length;i++){
				               li +='<li class="stack-ltr"><input type="checkbox" value='+nomember[i].aid+' class="list-user"> '+nomember[i].fname+' '+nomember[i].lname+'</li>'; 	   
				           }
				   }else{
					   li = "No user";
				   }
		           $('#users').html(li);
		         
		           $('.stack-ltr , .stack-rtl').on( 'click' , function(e){
				       		if(e.target==this){
				       				$check = $(this).find('input');
				       				$check.trigger('click');
							}
		           })
		           
		           $('#btn-ltr').on( 'click', function(){
		        	     list = $('#users li');
		        	     $.each( list , function( index , obj ){
		        	     li = $(obj);
		        	     chbox = li.find('input');
		        	    	 if(chbox.is(':checked')){
		        	    		  $('#member').append(  li )
		        	    	 }
		        	     })
		        	  	 $.dept._countPerson( $('#count_user'), $('#users li') );
		        	     $.dept._countPerson( $('#count_member'), $('#member li') );
		           })
		           
		           $('#btn-rtl').on( 'click', function(){
		        	     list = $('#member li');
		        	     $.each( list , function( index , obj ){
		        	     li = $(obj);
		        	     chbox = li.find('input');
		        	    	 if(chbox.is(':checked')){
		        	    		  $('#users').append(  li );
		        	    	 }
		        	     })
		        	  	 $.dept._countPerson( $('#count_user'), $('#users li') );
		        	     $.dept._countPerson( $('#count_member'), $('#member li') );
		           })
				  
			  },
			  
			  _countPerson:function( $id , sizeOful ){
				  
	        	   switch( sizeOful.length ){
		        	   case 0 : $id.text(''); break;
		        	   case 1 : $id.text('').text(sizeOful.length+' person'); break;
		        	   case 2 : $id.text('').text(sizeOful.length+' persons'); break;
		        	   default : $id.text('').text(sizeOful.length+' persons');
	        	   
	        	   }
	        	   
	        	   if(sizeOful.length > 12){
			        	   $('#slim-user, #slim-member').slimScroll({
					   	        height: '320px',
					   	        size: '5px',
					   	        railVisible: true,
				           });
	               	}
				   
			  },

	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
		 
	  $.group.load();
	  $('[name=gname]').blur( function(){
		  $.group.check();
		  
	  })
	  $('#group-back-main').click( function(e){
			$('#group-main-pane').show();
			$('#group-detail-pane').hide();
	  })
	  
	  $('.cancel_group').click( function(e){
		  		e.preventDefault();
				$.group.cancel();
	   });
	  $('.new_group').click( function(e){
		  		e.preventDefault();
				$.group.create();
	   });
	  $('.delete_group').click( function(e){
		  e.preventDefault();
		  var confirm = window.confirm('Are you sure to delete');
		  if( confirm ){
				$.group.remove();
		  }
	   });
	  $('.save_group').click( function(e){
		  		e.preventDefault();
				$.group.save();
	   });
	  

	  
  });
  