 (function($){
	var url = "report_process.php";
	  jQuery.rpt = {
		getcmp:function(){
			   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'getcmp' , 'data' : formtojson  }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
			                        var  result =  eval('(' + data + ')'); 
								      //group location
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.length ; i++){
									  option += "<option value='"+ result[i].id +"'>"+ result[i].val +"</option>";									    										    
									 }								
									 
									 $('[name=listconv_search_campaign]').text('').append(option);
									 $('[name=agentp_search_campaign]').text('').append(option);
									 $('[name=campaign_id]').text('').append(option);
									
					}
			   })//end ajax			
			
		},
		getlead:function( cmpid ){
			   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'getlead' , 'data' : formtojson , 'cmpid' : cmpid  }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
			                        var  result =  eval('(' + data + ')'); 
								      //group location
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.length ; i++){
									  option += "<option value='"+ result[i].id +"'>"+ result[i].val +"</option>";									    										    
									 }								
									 $('[name=listconv_search_lead]').text('').append(option);
								
									
									 
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
		getgroup:function(){
			   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'getgroup' , 'data' : formtojson  }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
			                        var  result =  eval('(' + data + ')'); 
								      //group location
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.length ; i++){
									  option += "<option value='"+ result[i].id +"'>"+ result[i].val +"</option>";									    										    
									 }								
									 $('[name=agentp_search_group]').text('').append(option);
					
								
					}
			   })//end ajax			
			
		},
		getteam:function( groupid ){
			   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'getteam' , 'data' : formtojson , 'groupid' : groupid  }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				
					},										
					'success' : function(data){ 
		
			                        var  result =  eval('(' + data + ')'); 
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.length ; i++){
									  option += "<option value='"+ result[i].id +"'>"+ result[i].val +"</option>";									    										    
									 }								
									 $('[name=agentp_search_team]').text('').append(option);
								
					}
			   })//end ajax			
			
		},
	    agent_performance_report: function(){
	    	
	    	var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'agent_performance_report' , 'data':formtojson}, 
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
								    var $table = $('#agent-performance-table tbody'); 
									$table.find('tr').remove();
									var i=0 , txt = "";
							
											 for( i=0 ; i<result.length ; i++){
											
											      txt += "<tr><td style='vertical-align:middle; text-align:center' >&nbsp;"+result[i].cred+"&nbsp;</td>"+
											      			 "<td style='vertical-align:middle; text-align:center' >"+result[i].gname+"</td>"+
											    		     "<td style='vertical-align:middle; text-align:center'  >"+result[i].tname+"</td>"+		
														   "<td >"+result[i].aname+"</td>"+		
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].transfertotal+"</td>"+
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].revoketotal+"</td>"+		
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].lonhand+"</td>"+
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].lnew+"</td>"+		
													
														   "<td style='vertical-align:middle; text-align:center'  >"+result[i].callback+"</td>"+		
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].followup+"</td>"+
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].followdoc+"</td>"+		
														   
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].nocont+"</td>"+
														   "<td style='vertical-align:middle; text-align:center'  >"+result[i].donotcall+"</td>"+
														   
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].callbadlist+"</td>"+		
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].closedsales+"</td>"+
														   "<td style='vertical-align:middle; text-align:center' >"+result[i].unclosedsales+"</td>"+		
														  // "<td >"+result[i].overlimit+"</td>"+
														   "</tr>";
											      
											    } 
											 
									 $table.html(txt);
											    
					                if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='17' class='text-center'>&nbsp; No data found &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{
										var $table = $('#agent-performance-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='17'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
										$addRow.appendTo($table);
									}
									
							 }   
						});//end ajax 
	    	
	    },	   
	    agent_performance_export(){
	    	
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.post( url , { "action" : "agent_performance_report_export" , "data": formtojson  }, function( result ){
				    var response = eval('('+result+')');  
					    if(response.result=="success"){
					    	window.location = "dw.php?p=/temp/agent_performance.xlsx&o=y";
					    }
			 });
	    	
	    },
	    list_conversion_report:function(){
	    	
	     	var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'list_conversion_report' , 'data':formtojson}, 
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
								    var $table = $('#list-conversion-table tbody'); 
									$table.find('tr').remove();
									var i=0 , txt = "";
							
											 for( i=0 ; i<result.length ; i++){
											
											      txt += "<tr><td style='vertical-align:middle;' >"+result[i].lanme+"</td>"+
											    		   "<td >"+result[i].lload+"</td>"+		
														   "<td >"+result[i].lused+"</td>"+
														   "<td >"+result[i].lusedp+"</td>"+		
														   "<td >"+result[i].lremain+"</td>"+
														   "<td >"+result[i].lremainp+"</td>"+		
														   "<td >"+result[i].ldmc+"</td>"+
														   "<td >"+result[i].ldmcp+"</td>"+	
														   "<td >"+result[i].lsuccess+"</td>"+
														   "<td >"+result[i].lsuccessp+"</td>"+		
														   "<td >"+result[i].lunsuccess+"</td>"+
														   "<td >"+result[i].lunsuccessp+"</td>"+		
														   "<td >"+result[i].lapp+"</td>"+
														   "<td >"+result[i].lappp+"</td>"+
														   "<td >"+result[i].lineff+"</td>"+
														   "<td >"+result[i].lineffp+"</td>"+		
														   "<td >"+result[i].linp+"</td>"+
														   "<td >"+result[i].linpp+"</td>"+
														   "<td >"+result[i].lcback+"</td>"+
														   "<td >"+result[i].lcbackp+"</td>"+		
														   "<td >"+result[i].lfollow+"</td>"+
														   "<td >"+result[i].lfollowp+"</td>"+
														   "<td >"+result[i].lbad+"</td>"+
														   "<td >"+result[i].lbadp+"</td>"+
														   "</tr>";
											    } 
											 
									 $table.html(txt);
										
					                if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='24' class='text-center'>&nbsp; No data found &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{
										var $table = $('#list-conversion-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='24'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
										$addRow.appendTo($table);
									}
									
							 }   
						});//end ajax 
	    	
	    },
	    list_conversion_export(){
	    	
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.post( url , { "action" : "list_conversion_report_export" , "data": formtojson  }, function( result ){
				    var response = eval('('+result+')');  
					    if(response.result=="success"){
					    	window.location = "dw.php?p=/temp/list_conversion.xlsx&o=y";
					    }
			 });
	    	
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
  