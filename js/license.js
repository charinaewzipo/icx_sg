 (function($){
	var url = "license-pane_process.php";
	var currentRow = null; 
	  jQuery.lic = {
			 init: function(){
				   $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'query' }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
					
						},										
						'success' : function(data){ 
									var el =  $('#agent-table');
				                    var  result =  eval('(' + data + ')'); 
				                        
								      //group location
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.group.length ; i++){
									  option += "<option value='"+ result.group[i].id +"'>"+ result.group[i].value +"</option>";									    										    
									 }								
									 $('[name=gid]').text('').append(option);
									 
									 //team
									 var option = "<option value=''> &nbsp; </option>";
									 for( i=0 ; i<result.team.length ; i++){
									  option += "<option value='"+ result.team[i].id +"'>"+ result.team[i].value +"</option>";									    										    
									 }								
									 $('[name=tid]').text('').append(option);
										 
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
			                        console.log("start load license");
			                        
			                        $('#lvl_agent').text('').text(   result.systemu.agent+" / "+result.online.agent+ " / "+result.lic.agent );
			                        $('#lvl_sup').text( result.systemu.sup+" / "+result.online.sup+ " / "+result.lic.sup );
			                        $('#lvl_qc').text(  result.systemu.qc+" / "+result.online.qc+ " / "+result.lic.qc );
			                        $('#lvl_mgm').text(  result.systemu.mgm+" / "+result.online.mgm+ " / "+result.lic.mgm );
			                        $('#lvl_proj').text(  result.systemu.proj+" / "+result.online.proj+ " / "+result.lic.proj );
			                        $('#lvl_admin').text(  result.systemu.adm+" / "+result.online.adm+ " / "+result.lic.adm );
			                        /*
								    var $table = $('#agent-table tbody'); 
									$table.find('tr').remove();
									var i=0;
									var seq = 0;
									var active = 0;
									var disabled = 0;
									var locked = 0;
									  //if(  pmSheet[0].length !=0 ){
											 for( i=0 ; i<result.length ; i++){
											     seq++;
											     var $row;
											    var control = "";
											     if(result[i].level!="5"){
											    	  if( result[i].status == 1 ){
											    		   control += "<span class='ion-ios7-locked-outline size-16' ></span> <a href='#' class='lock-id' >Lock</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											    	  }
											    	  if( result[i].status == 0 ){
											    		   control += "<span class='ion-ios7-unlocked-outline size-16'></span> <a href='#' class='unlock-id' >Unlock</a>&nbsp;&nbsp;";
											    	  }
											    	       control +=  "&nbsp; <span class='ion-ios7-trash-outline size-16'></span> <a href='#' class='del-id'>Delete</a>";
											     }
											     
											     $row = $("<tr id='"+result[i].agentid+"'><td class='text-center'>&nbsp;"+seq+"&nbsp;</td>"+
											    		  "<td >&nbsp;<a href='#' class='nav-user-id' >"+result[i].fname+"&nbsp;"+result[i].lname+"</a></td>"+		
											    		   "<td>&nbsp;"+result[i].nickname+"&nbsp;</td>"+
											    		   "<td class='text-center'>&nbsp;"+result[i].groupname+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].teamname+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].login+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].level+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].accStatus+"&nbsp;</td>"+   
											    		   "<td class='text-center'>&nbsp;"+result[i].lastlogin+"&nbsp;</td>"+
											    		   "<td class='text-center' >&nbsp;"+control+"</td></tr>");	    	
											     
												     switch(+result[i].status){
													      case 0 : locked++;    break;
													      case 1 : active++; break;
													      case 5 : disabled++;   break;
											          }
												     
												  $row.appendTo($table);
												  $.agent.gridSet($row);
												  
											    } 
											 
											  $('.nav-user-id').on('click',function(e){
									
										    	   e.preventDefault();
										    	   $.agent.detail( $(this).parent().parent().attr('id') );
										    	   $('.delete_user').show();
										    	   
										    	 	$('#agent-main-pane').hide();
													$('#agent-detail-pane').show();
													
									           })
											   $('.unlock-id').bind('click',function(e){
											    	 e.preventDefault();
											    	 $.agent.takeaction( "unlock" , $(this).parent().parent().attr('id') );
											     })
											     $('.lock-id').bind('click',function(e){
											    	 e.preventDefault();
											    	 $.agent.takeaction( "lock" , $(this).parent().parent().attr('id'));
											     })
											    $('.del-id').bind('click',function(e){
											    	 e.preventDefault();
											    	 $('[name=aid]').val( $(this).parent().parent().attr('id') );	
											    	 $.agent.remove();
											     })
											 
											 
											  var s = "s";
											   if(i<1){	s = "";	}
											   $('#user_subtitle').text(" Total  "+i+" User"+s);
											   if(active>0){
												   $('#user_subtitle').append( " | "+active+" active " );
											   }
											   if(disabled>0){
												   $('#user_subtitle').append( " | "+disabled+" disabled " );
											   }
											   if(locked>0){
												   $('#user_subtitle').append( " | "+locked+" locked " );
											   }
										
								                if(i==0){   
												     $addRow = $("<tr id='nodata'><td colspan='10' class='listTableRow small center'>&nbsp;<img src='images/0.png'> &nbsp; No Data &nbsp;</td></tr>")
												     $addRow.appendTo($table);
												}else{
												
												var $table = $('#agent-table tfoot'); 
												$table.find('tr').remove();
												var s = "s";
												if(i<1){	s = "";	}
											    $addRow = $("<tr ><td colspan='10'  style='border-bottom: 1px solid #E2E2E2' ><small> Total "+i+" Record"+s+" </small></td></tr>");
												$addRow.appendTo($table);
												}
									*/
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
		                 
		                    $('[name=aid]').val(result.data.aid);
			                $('[name=fname]').val(result.data.fname);
			            	$('[name=lname]').val(result.data.lname);
			            	$('[name=nname]').val(result.data.nickname);
			            	$('[name=mobilephone]').val(result.data.mobilePhone);
			            	$('[name=email]').val(result.data.email);
			              	$('[name=gid]').val(result.data.gid);
			            	$('[name=tid]').val(result.data.tid);
			            	$('[name=loginid]').val(result.data.loginid);
			            	$('[name=level]').val(result.data.level);
			            	$('[name=accstatus]').val(result.data.accStatus);
			            	 
						}//end success
					});//end ajax 
			},	  
			 getLicense:function(){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					$.post(url , { "action" : "getLicense" , "data": formtojson  }, function( result ){
					    var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	window.location = "dw.php?p=temp/tubtim.lic&o=y";
						    }
			 		});
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							   
							    	//  $.dept._new();
							          $.agent.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						        $.agent.create();
						        $.agent.load();				
						        
						    	$('#agent-main-pane').show();
								$('#agent-detail-pane').hide();
						    }
				 });
		    
		    },
			 cancel: function(){
				$.agent.detail(  $('[name=aid]').val() ); 
				 
			 },
			  gridSet:function($row){
	
				    $row 
					.find('td').click( function(e){
						$('[name=aid]').val( $row.attr('id') );	
					})
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        })
			        .click( function(){
			        	
			        	  $('[name=bookingid]').val( $row.attr('id') );	
			        	   $('#agent-table tr.selected-row').removeClass('selected-row');
			        	   $row.addClass('selected-row');
			        	
			        })			        
			        .dblclick( function(e){
				    	 	$.agent.detail( $row.attr('id') );
				    		$('#agent-main-pane').hide();
							$('#agent-detail-pane').show();
				  
				    })
				  
			  },
			  takeaction:function(action , aid ){
				   	 var confirm = window.confirm("Are you sure  to "+action+" this user ?");
					 if(confirm){ 
						  $.post(url , { "action" : action , "aid": aid  , "uid": $('[name=uid]').val() }, function( result ){
							    var response = eval('('+result+')'); 
							       if( response.result=="success"){
							    	   $.agent.load();
							       }
						 });
					   }	
			  },
			
	}//end jQuery
 })(jQuery)//end function
 
  $(function(){
	  
	  $.lic.load();
	 
	  
	 var banner = 1;
	 var c = 0;
	 var x = setInterval(function(){
			if( banner == 1){
				banner = 0;
				$('#coreval_en').fadeOut('slow' , function(){
					$('#coreval_th').fadeIn('slow');
				})
				if(c==1){
					clearInterval(x);
				}
			
			}else
			if( banner == 0){
				banner = 1;
				c++;
				$('#coreval_th').fadeOut('slow' , function(){
					$('#coreval_en').fadeIn('slow');
				})
			}
	  },10000);
	  

	 	$('#getLicense').click( function(){
	 		$('#coreval-pane,#updateLicense-pane').hide();
	 		$('#getLicense-pane').fadeIn('fast');
	 		$('[name=licensefor]').focus();
	 	})
	 	
	 	$('#updateLicense').click( function(){
	 		$('#coreval-pane,#getLicense-pane').hide();
	 		$('#updateLicense-pane').fadeIn('fast');
	 		
	 	})
	 	
	 	$('#btn-getlicense').click( function(e){
	 		e.preventDefault();
	 		if($('[name=licensefor]').val()==""){
	 			alert("Company name can not blank.Please fill in company name.");
	 			$('[name=licensefor]').focus()
	 		}else{
	 			$.lic.getLicense();
	 		}
	 	})
	 	
	 	
		 
	 $('[name=licensefor]').keypress( function(e){
		
		 if(e.which==13){
			 //prevent text box auto submit form
			 e.preventDefault();
			 if( $('[name=licensefor]').val() != ""){
				 $.lic.getLicense();
			 }else{
				 alert("Company name can not blank.Please fill in company name.");
		 		 $('[name=licensefor]').focus();
			 }
		 }
	 });
	 	
 	$('#upload-link').click( function(e){
 		 $("#updateLicense-pane").trigger('click');
 	})
	 	
 	//drop license file
    $("#upload-license").dropzone({		 
    	    params: {
    	 	   'action' : 'updateLicense' ,
    	 	  //'uid' : $('[name=uid]').val(),
    	 	 // 'lid' : $('[name=lid]').val() , 
    	    },	    
    		   url: "license-pane_process.php", 
    		   createImageThumbnails : false ,
    		   maxFilesize: 20, 
    		   init: function() {
    			    this.on("addedfile", function() {
    			      if (this.files[1]!=null){
    			    	  //  console.log("remove file : "+this.files[0].name);
    			        this.removeFile(this.files[0]);   
    			    
    			      }
    			    });
    			  },
    		   accept: function(file, done){
    			   		console.log( file.type );
						var accept = 1
						/*
						if (file.type == "text/plain") {
							 accept = 1;
			            }else{
			           		 accept = 0; 
			       		 	$('#upload-msg').fadeOut('fast',function(){
								$(this).fadeIn('fast');
				       		});
				        }
					      */  
						//console.log( "all accept : "+accept );
						//all accept then done;
						if(accept==1){
						 	$('#upload-msg').fadeOut('fast');
							done();
						}
				     
    		   },
        	    uploadprogress : function( file, progress, bytesSent ){
			
        	    	p = parseInt( progress );
        	    	$('#import-progress-status').text('').html('<span style="display:block; position:relative; top:-5px;font-size:14px; font-weight:300">processing upload.</span> <p  style="font-size:14px; font-weight:300">Please Wait.</p>');
        	    	$('#import-progress').show();
					$('#import-msg').hide();
				
        	        /*
					console.log( "file "+file );
					console.log( "progress "+progress );
					console.log( "bytesSent "+bytesSent );
					*/
      			  },
      		
    		   success: function( file ,response ){
    			   // alert("import file success");
    			   //console.log("import file success!!");
    			   //console.log( response );


    			

    	
    			    	var res = eval('('+response+')');  

    			    	//call after upload
    			  		//$.callList.detail_importList( res.key  );

    			    	/*
    			  		$('#result_fname').text('').text( res.fname );
						$('#result_ftype').text('').text( res.ftype );
						$('#result_fsize').text('').text( res.fsize );
						$('#result_record').text('').text( res.key );

					
						console.log( res.fext );
					*/
						
    			   }
    	});
		 
	
  });
  