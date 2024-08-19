 (function($){
	var url = "dashboard_process.php";
	var currentRow = null; 
	var deleteRowid = [];
	var updateRowid = [];
	  jQuery.dashb = {
		init:function(){
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'init' }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
					 //    unblockUI(el);
									//remove image loading 
									//$('#loading').html('').append("Project Management Sheet");
									
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
								    var $table = $('#callmonitor-table tbody'); 
									$table.find('tr').remove();
									var i=0;
									var txt = "";
									
									
									
									/*
									 * 								/*
								    $row = $("<tr id='"+result.cmplist[i].impid+"'>"+
								    		   "<td style='vertical-align:middle'>"+result.cmplist[i].cmpname+"</td>"+	
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].total+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].newlist+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].cback+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].follow+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].dnd+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].blist+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].maxtry+"&nbsp;</td>"+
								    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.cmplist[i].sales+"&nbsp;</td>"+
											   "<td style='text-align:center;vertical-align:middle' >&nbsp;xxx&nbsp;</td></tr>");	 
								     */
									 */
									
											 for( i=0 ; i<result.length ; i++){
												
									   txt +=   '<tr>'+
										 			'<td style="width:15%; vertical-align:middle">'+ 
										 				'<div style="display:inline-block; position:relative; top:-20px;"> <img id="abc" class="avatar-title" src="'+result[i].aimg+' "> </div>'+
										 				'<div style="display:inline-block; text-indent:15px;">'+
										 						'<span style="display:block">   '+result[i].aname+' &nbsp;</span>'+
										 						'<span style="display:block">  '+result[i].agroup+' , '+result[i].ateam+' &nbsp;</span>'+
										 					   '<span style="display:block">  '+result[i].aext+' &nbsp;</span>'+
										 				'</div>'+
										 			'</td>'+
										 			'<td style="vertical-align:middle" class="text-center"> '+result[i].tcall+'</td>'+
										 			'<td style="vertical-align:middle" class="text-center"> '+result[i].tcallback+' </td>'+
										 			'<td style="vertical-align:middle" class="text-center"> '+result[i].tfollow+' </td>'+
										 			'<td style="vertical-align:middle" class="text-center">  '+result[i].tsuccess+' </td>'+
										 			'<td style="vertical-align:middle" class="text-center">'+
										 			
												 			'<span> 60% progress </span>'+
											 				'<div class="progress" style="height:6px; border-radius:3px; ">'+
																  '<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; height:10px; background-color:#23b7e5">'+
																  '</div>'+
															'</div>'+
													
														'</div>'+
										 			'</td>'+
										 		'</tr>';
											     
											  }
											 
											 $table.html( txt );
											
											 
											 //add event
											   $('.nav-team-id').on('click',function(e){
										    	     e.preventDefault();
										    	     $.team.detail( $(this).parent().parent().attr('id')  );
										    	     
										    	    	$('#team-main-pane').hide();
										            	$('#team-detail-pane').show();
									           })
											    
					                if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='4' class='text-center'>&nbsp;<img src='image/0.png'> &nbsp; Data not found &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{
										var $table = $('#team-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='4'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
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
		                    $('[name=teamid]').val(result.data.tid);
		                    $('[name=tname]').val(result.data.tname);
			            	$('[name=tdetail]').val(result.data.tdetail);
			            	$('[name=tgid]').val(result.data.gid);
			            	
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				 
				  $('[name=teamid]').val('');
				  $('[name=tname]').val('');
	              $('[name=tdetail]').val('');
	              $('[name=tgid]').val(''); 
	            	
	           	  $('#team-main-pane').hide();
		    	  $('#team-detail-pane').show();				
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.team.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	$.team.create();
						        $.team.load();						    	
						    }
				 });
		    
		    },
			 cancel: function(){
				$.team.detail(  $('[name=teamid]').val() ); 
				 
			 },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=teamid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        }).dblclick( function(e){
				    	 $.team.detail( $row.attr('id') );
				    	 
				      	 $('#team-main-pane').hide();
				    	 $('#team-detail-pane').show();				 
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
	
	  $.dashb.load();
	  
	  /*
	  $('#team-back-main').click( function(e){
			$('#team-main-pane').show();
			$('#team-detail-pane').hide();
	  })
	  
	  
	  $('.cancel_team').click( function(e){
		  		e.preventDefault();
				$.team.cancel();
	   });
	  $('.new_team').click( function(e){
		  		e.preventDefault();
				$.team.create();
	   });
	  $('.delete_team').click( function(e){
		  e.preventDefault();
		  var confirm = window.confirm('Are you sure to delete');
		  if( confirm ){
				$.team.remove();
		  }
	   });
	  $('.save_team').click( function(e){
		  		e.preventDefault();
				$.team.save();
	   });
	  */
	  
  });
  