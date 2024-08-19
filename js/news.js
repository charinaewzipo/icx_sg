 (function($){
	var url = "news-pane_process.php";
	var captionRow = null;
	var captionSelect = "";
	  jQuery.news = {
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
	    load: function( option ){
	    	
			var  formtojson =  JSON.stringify( $('form').serializeObject() );
			var page = $('#readmore').attr('data-read');
			
			 //set up page for read more
			/*
			 if( option == "current"){
				 console.log("reload current position ");
				 
			 }else{
				 console.log("reload  position +1 page ");
				 
			    page = parseInt(page) + 1;
			    $('#readmore').attr('data-read', page );
			    page = $('#readmore').attr('data-read');
			   	console.log("current page is : "+page);
				 
			 }
		   	*/
	
			//console.log("load page "+page+" option : "+option);
			//console.log("load data news ");
			
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query' , 'data' : formtojson , 'page' : page ,'option' : option  }, 
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
								    var $table = $('#news-table tbody'); 
								    
								   if(page == 1){
									   $table.find('tr').remove();
								   }
								   
									var owner = $('[name=uid]').val();
									var i=0;
							
									var txt = "";
											 for( i ; i<result.length ; i++){
												 
												txt += '<tr id="'+result[i].nid+'" style="background-color:#fff;">'+
												 				'<td style="width:10%;">'+
																'<img class="avatar-title" src="'+result[i].nim+'">'+
																'</td>'+
																	'<td style="width:90%"><div class="news-main-subject" style="width:100%">'+
																		'<div style="position:relative;">';
																		if( result[i].ncid == owner ){
																			txt += '<div style="position:absolute; top:0; right:10px; cursor:pointer; font-size:10px" class="icon-angle-down mypost">&nbsp;</div>';
																		}
																		txt += '</div>'+
																		'<span style="display:block;"><pre style="font-size:18px; border:0;  background-color:transparent; margin:0; padding:0"><a href="#" class="nav-news-id">'+result[i].nsubject+'</a></pre></span>'+
																		'<span style="display:block; color:#999; font-style:italic; font-size: 12px;" >'+result[i].ncreu+' &nbsp; '+$.timeago(result[i].ncred)+' </span>'+
																		'<span style="display:block; color:#777; font-size:14px;" class="nav-news-detail">'+result[i].ndetail+'</span> '+
																		'<a href="#" class="nav-news-comment"><span class="ion-ios-chatboxes-outline news-counter"></span></a> <span style="font-size:20px;color:#666">'+result[i].tment+'</span> '+
																		'&nbsp;';
																		
																	   if( result[i].tlike.islike=="Y"){
																			txt += '<span class="ion-ios-heart-outline news-counter like"  data-like="'+result[i].nid+'" ></span> <span style="font-size:20px;color:#666">'+result[i].tlike.like+'</span> ';
																		}else{
																			txt += '<span class="ion-ios-heart-outline news-counter ulike" data-ulike="'+result[i].nid+'" ></span> <span style="font-size:20px;color:#666">'+result[i].tlike.like+'</span> ';
																		}
																
														txt += '</div></td></tr>';
												 
											    }
											 
											 
											 //set up page for read more
											 if( option == "current"){
								
												 $table.html(txt);
												 
											 }else{
												    page = $('#readmore').attr('data-read');
												 	//console.log("current page is : "+page);
												 	$table.append(txt);
												 
											 }
										   	   
											   	/*
											  $table.text('').html(txt);
											  $('#readmore').attr('data-read','2');
											 */
											  
											 var p = "";
											  p += '<div class="news-dropdown-wrap"><div></div>'+
											  		   '<ul class="news-dropdown">'+
													   '<li class="edit_news"> <span class="ion-ios-compose-outline" style="font-size:18px;"></span> <span style="font-size:14px; text-indent:8px; display: inline-block; "> Edit </span></li>'+
													   '<li class="remove_news"> <span class="ion-ios-trash-outline" style="font-size:18px;"> </span> &nbsp;<span style="font-size:14px; text-indent:5px; display: inline-block;"> Remove </span></li>'+
													   '</ul></div>';
											  $('.mypost').append(p);
											 
											  //add like event
											  $('#news-table tbody tr td div').find('span.like').click( function(e){
												   e.preventDefault();
												   $.news.like( $(this).attr('data-like') );
											   })
											   
											   //add unlike event
											   $('#news-table tbody tr td div').find('span.ulike').click( function(e){
												   e.preventDefault();
												   $.news.ulike( $(this).attr('data-ulike') );
											   })
										
											   
											  // $('.nav-news-id').click(function(e){
											     $('#news-table tbody tr td  div span').find('a.nav-news-id').click( function(e){
										    	     e.preventDefault();
										    	   	//check is edit are active
										            	if( $('[data-edit=active]').length > 0 ){
										            		
										            		var confirm = window.confirm("Exit your last modifed ?");
										            		if(confirm){
										            			//close edit news before open news detail
										            			$('[data-edit=active]').prev().show(); 
										         				$('#news-myedit').remove(); 	//remove on the fly news-edit				         			
										         			    $('.mypost').show();    //show right popup
										         			    
										         			    //open post detail 
										            		     $.news.detail( $(this).closest('tr').attr('id') ); 
													    	     //overlay news detail
												            	$('#news-detail-pane').fadeIn('fast',function(){	
															   			$(this).css({'height':(($(document).height()))+'px'});
															   			window.scrollTo(0, 0);
																});
												            	
										            		}//end if
									         		
										            	}else{
										            			
										            		    //open post detail 
										            		     $.news.detail( $(this).closest('tr').attr('id') ); 
													    	     //overlay news detail
												            	$('#news-detail-pane').fadeIn('fast',function(){	
															   			$(this).css({'height':(($(document).height()))+'px'});
															   			window.scrollTo(0, 0);
																});
										            			
										            		}//end if 
									           })
									           
									           
									           
									            //add event for click comment icon
									       
											  // $('.nav-news-comment').click(function(e){
												   
											 $('#news-table tbody tr td  div').find('a.nav-news-comment').click( function(e){
										    	     e.preventDefault();
										    	     $.news.detail( $(this).closest('tr').attr('id') ); 
										    	     //overlay news detail
									            	$('#news-detail-pane').fadeIn('fast',function(){
												   			$(this).css({'height':(($(document).height()))+'px'});
												   			window.scrollTo(0, 0);
												   			
												   		  if($('#add-comment').attr('data-remark')=="true"){
									                		 $('#add-comment').attr('data-remark','false');
									                		 $('#add-comment-text').text('Remove Comment');
									                		 $('#write-post').fadeIn('fast' , function(){
										                		 $('[name=comment]').focus();
										                	 });
									                	 }else{
									                		 $('#add-comment').attr('data-remark','true');
									                		 $('#add-comment-text').text('Add Comment');
									                		 $('#write-post').hide();
									                	 }
												   			
													});
										            	 
									           })
									           
									           
									           
									          // console.log( $('#news-table tbody tr td div > div > ul').find('li.edit_news') );
									           
									     //       console.log( $('#news-table tbody tr td div > div > ul ').find('li.edit_news') );
											//  $('#news-table tbody tr td div > div > ul').find('li.edit_news').click( function(e){
												 
								    console.log( $('.edit_news') );
									    $('.edit_news').click( function(e){
									        	   e.preventDefault();
									        	   
									        	   //close popup
									        	   $('div.news-dropdown-wrap').removeClass('active') ;
										           e.stopPropagation();
									        
									        	   //hide arrowdown popup
										         	  $('.mypost').hide();
										         	  
											          //update news-id  
											          var nid = $(this).closest('tr').attr('id')
										        	  $('[name=nid]').val( nid );
											          
										         	   var tmp =  $(this).closest('td').find('div.news-main-subject');
										         	   tmp.hide(); 
										         	
										         		var subj = tmp.find('span a.nav-news-id').text(); 
										         		var detail = tmp.find('span.nav-news-detail').text();
										         	
										         		var txt = '<div style="width:100%" id="news-myedit" data-edit="active"><ul style="margin:0;padding:0; list-style:none;" >'+
																			'<li><input type="text" name="editnewssubj" style="width:100%" placeholder="subject" autocomplete="off" value="'+subj+'"></li>'+
																			'<li class="startnews" ><textarea name="editnewsdetail" style="width:100%; height:60px; border-top:0;" placeholder="detail" autocomplete="off">'+detail+'</textarea></li>'+
																			'<li class="startnews" style="padding: 10px 0 10px 10px; "><a href="#" style="font-size:10px;" id="save_myeditnews">Save</a> | <a href="#" style="color:#666; font-size:10px;" id="cancel_myeditnews">Cancel or Press ESC </a></li>'+
																		'</ul></div>';
										         
										         		$(txt).insertAfter(tmp);
										         		
										         		//focus then move cursor then capture key esc event	
									                	 $('[name=editnewssubj]')
									                	 .focus()
									                	 .focusEnd()
									                	 .keyup( function(e){
								                			  if (e.keyCode == 27){    $('#cancel_myeditnews').trigger('click');  } 
								                		 })
								                		  
								                		 $('[name=editnewsdetail]')
									                	 .keyup( function(e){
								                			  if (e.keyCode == 27){    $('#cancel_myeditnews').trigger('click');  } 
								                		 })
										        		
										         		$('#save_myeditnews').click( function(e){
										         				e.preventDefault();
										         				//set news-id to null
										         				$('[name=nid]').val("");
										         				$.news.save();
										         				$.news.load(); //reload content
										         				
										         		})
										         		
										         		$('#cancel_myeditnews').click( function(e){
										         				e.preventDefault();
										         				
										         			    tmp.show(); 		//show element that hide
										         				$('#news-myedit').remove(); 	//remove on the fly news-edit				         			
										         			    $('.mypost').show();    //show right popup
										         			 
										         		});
										         
										         		
									           })
								           	
									           /*
									           $('.remove_news').click( function(e){
									        	     e.preventDefault();
									        	     
									        	     //close popup
										        	 $('div.news-dropdown-wrap').removeClass('active') ;
											         e.stopPropagation();
											           
										          	 var confirm = window.confirm("Are you sure to delete this news ?");
								                	 if(confirm){
											        	   $('[name=nid]').val( $(this).closest('tr').attr('id') );
											        	    $.news.remove();
								                	 }
									           })
											    
												$('.mypost').click( function(e){
													if( $('.news-dropdown-wrap').hasClass('active') ){
														 $('.news-dropdown-wrap').removeClass('active');
													}
													$(this).children().addClass('active');
													e.stopPropagation();
												});
											   
											   $('.like').click( function(e){
												   console.log( 'like click ');
												   console.log( $(this) );
												   e.preventDefault();
												 
												   $.news.like( $(this).closest('tr').attr('id'));
											   })
											
								
											   
									           	$(document).click(function() {
													// clear all dropdowns
													 $('.news-dropdown-wrap').removeClass('active');
												});
									          
											   */
											    
					                if(i==0){   
					                	
				                			txt = '<tr>'+
								        			'<td style="width:100%; height:150px; text-align:center; vertical-align:middle">'+
													'<span class="ion-ios-chatboxes-outline" style="display:block;  font-size:60px; color:#A2A2A2"> </span>'+
													'<span  style="position:relative; top: -15px;display:block; font-size:20px; color:#A2A2A2"> No news today </span>'+
													'</td>';
								
					                	$table.text('').html(txt);
					                	
									   
									}else{
										/*
										var $table = $('#news-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='3'  style='border-top: 1px solid #EAEAEA' ><small> Total "+i+" Record"+s+" </small></td></tr>");
										$addRow.appendTo($table);
										*/
									}
									
							 }   
						});//end ajax 
	    	
	    },	   
	    detail:function( id ){
	    	
	    	var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			    $.ajax({   'url' : url, 
					   'data' : { 'action' : 'detail','id': id ,'data': formtojson }, 
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
		                 
		                 //update newsid
		                 $('[name=nid]').val(  $(this).closest('li').attr('id') ); 
		                 //owner
		             	var owner = $('[name=uid]').val();
		                 $list = $('#news-detail-panex');
		                 
			               txt =  '<ul class="news-detail" id="'+result.nid+'">'+
			     					'<li>'+
			     					'<div style="position:relative;">';
									if( result.ncid == owner ){
										txt += '<div style="position:absolute; top:0; right:10px; cursor:pointer;" class="ion-ios-arrow-down selfpost">&nbsp;</div>';
									}
							 txt += '</div>'+
										'<div class="news-avatar">'+
				     						'<img class="avatar-title" src="'+result.nim+'" />'+
				     					'</div>'+
				     					'<div class="news-title">'+
				     							'<span class="news-detail-subject" ><pre style="font-size:18px; border:0;  background-color:transparent; margin:0; padding:0"><a href="#" class="nav-news-id">'+result.nsubj+'</a></pre></span>'+
				     							'<span class="news-detail-creater">  '+result.ncreu+' &nbsp; '+result.ncred+' &nbsp; <span style="color:#e2e2e2">-</span> &nbsp;'+$.timeago(result.ncredate)+' </span>'+
				     							'<span class="news-detail-detail">'+result.ndetail+'</span>'+ 
				     							'<a href="#" class="self-nav-news-comment"><span class="ion-ios-chatboxes-outline news-counter"></span></a> <span style="font-size:20px;color:#666">'+result.tment+'</span> '+
				     							'&nbsp;';
							 
										if( result.tlike.islike=="Y"){
											txt += '<span class="ion-ios-heart-outline news-counter self-like"></span><span style="font-size:20px;color:#666"> '+result.tlike.like+' </span> ';
										}else{
											txt += '<span class="ion-ios-heart-outline news-counter self-ulike"></span><span style="font-size:20px;color:#666"> '+result.tlike.like+' </span> ';
										}  
							 
				     			txt +=	'</div>'+
			     					'</li>';
		     			//for loop comment
		               var i = 0;
		     			for(i; i < result.comment.length;i++){
		     				txt += '<li >'+
					     				'<ul  data-newsid="'+result.nid+'" class="news-comment" >'+
							     				'<li   id="'+result.comment[i].mid+'">';
		     									if( result.comment[i].mcid == owner ){
							     					txt += '<div style="position:relative; "><div style="position:absolute; top:-5px; right:-5px;  font-size:16px">  <span style="cursor:pointer;" class="ion-ios-compose-outline edit_comment" ></span>&nbsp;&nbsp;<span  style="cursor:pointer;"  class="ion-ios-close-empty remove_comment" ></span></div></div>';
		     									}
							     					txt +='<div class="news-avatar">'+
															'<img id="abc" class="avatar-title" src="'+result.comment[i].mim+'">'+
														'</div>'+
														'<div class="news-comment-postbox">'+
																'<span class="news-comment-postbox-agent">'+result.comment[i].muser+'</span>'+
																'<span class="news-comment-postbox-timestamp" >'+result.comment[i].mcred+' &nbsp; <span style="color:#e2e2e2">-</span>  &nbsp;'+$.timeago(result.comment[i].mdate)+'</span>'+
																'<span class="news-comment-postbox-detail" >'+result.comment[i].mdetail+'</span>'+
														'</div>'+
												'</li>'+
											'</ul>'+
									'</li>';
		     				
		     			}
		     			
		     			//add comment line
		     			txt += '<li >'+
				     			'<ul  class="news-comment">'+
				     					'<li id="'+result.nid+'" >'+
				     						//add comment btn
											'<div id="add-comment" data-remark="true" style="text-indent:5px;">'+
												'<a href="#" class="add-comment"> <span class="ion-ios-compose-outline" style="font-size:16px; margin-right:3px;"></span>  <span id="add-comment-text" > Add Comment <span></a>'+
											'</div>'+
											//add comment box
											'<div id="write-post" style="display:none">'+
												'<div class="news-comment-postbox-write">'+
													'<img id="abc" class="avatar-title" src="'+$('[name=uim]').val()+'">'+
												'</div>'+ 
												'<div class="news-comment-postbox-write" style="padding: 10px 10px; width:100%">'+
														'<textarea name="comment" style=""></textarea>'+
												'</div>'+
												'<div style="text-align:right; padding-right:10px;">'+
													'<button class="btn btn-primary comment_post"> Post </button> '
												'<div>'+
											'</div>'+
										'</li>'+
				     			'</ul>'+
				     	'</li>'+
		     			'</ul>';
		               
		                 $list.html(txt);
		                 
		                 //add edit/remove for owner
		                 var p = "";
						  p += '<div class="news-dropdown-wrap"><div></div>'+
						  		   '<ul class="news-dropdown">'+
								   '<li class="self-edit_news"> <span class="ion-ios-compose-outline" style="font-size:18px;"></span> <span style="font-size:14px; text-indent:8px; display: inline-block; "> Edit </span></li>'+
								   '<li class="self-remove_news"> <span class="ion-ios-trash-outline" style="font-size:18px;"> </span> &nbsp;<span style="font-size:14px; text-indent:5px; display: inline-block;"> Remove </span></li>'+
								   '</ul></div>';
					
						  $('.selfpost').append(p);
						   
						  
						  //action for edit news
				           $('.self-edit_news').click( function(e){
				        	   e.preventDefault();
				        	   
				        	   //hide arrowdown popup
				         	  $('.selfpost').hide();
				         	  
				         	 //clear popup
				         	  $('div.news-dropdown-wrap').removeClass('active') ;
					          e.stopPropagation();
					          
					          //update news-id  don't know why :(
					          var nid = $(this).closest('ul').parent().closest('ul').attr('id');
				        	  $('[name=nid]').val( nid );
				         	   var tmp = $(this).closest('ul').parent().closest('ul').find('div.news-title');
				        
				         		var subj = tmp.find('span.news-detail-subject').text();
				         		var detail = tmp.find('span.news-detail-detail').text();
				         	   
				         	   tmp.css('width','100%');
				         	   tmp.children().hide();
				         		var txt = '<ul style="margin:0;padding:0; list-style:none;" id="news-edit">'+
													'<li><input type="text" name="editnewssubj" style="width:100%" placeholder="subject" autocomplete="off" value="'+subj+'"></li>'+
													'<li class="startnews" ><textarea name="editnewsdetail" style="width:100%; height:60px; border-top:0;" placeholder="detail" autocomplete="off">'+detail+'</textarea></li>'+
													'<li class="startnews" style="padding: 10px 0 10px 10px; "><a href="#" style="font-size:10px;" id="save_editnews">Save</a> | <a href="#" style="color:#666; font-size:10px;" id="cancel_editnews">Cancel or Press ESC </a></li>'+
												'</ul>';
				         		tmp.append(txt);
				         		
				         		//focus then move cursor then capture key esc event	
			                	 $('[name=editnewssubj]')
			                	 .focus()
			                	 .focusEnd()
			                	 .keyup( function(e){
		                			  if (e.keyCode == 27){    $('#cancel_editnews').trigger('click');  } 
		                		 })
		                		  
		                		 $('[name=editnewsdetail]')
			                	 .keyup( function(e){
		                			  if (e.keyCode == 27){    $('#cancel_editnews').trigger('click');  } 
		                		 })
				         		
				         		
				         		$('#save_editnews').click( function(e){
				         				e.preventDefault();
				         				$.news.save();
				         				$.news.detail( nid ); //reload content
				         				
				         		})
				         		
				         		$('#cancel_editnews').click( function(e){
				         				e.preventDefault();
				         				
				         			    tmp.children().show(); 		//show element that hide
				         				$('#news-edit').remove(); 	//remove on the fly news-edit				         			
				         			    $('.selfpost').show();    //show right popup
				         			
				         		});
				        	 
				           })//end edit news
			           	
				           $('.self-remove_news').click( function(e){
				        	     e.preventDefault();
				        	     //clear popup
				        	     $('.news-dropdown-wrap').removeClass('active');
					          	 var confirm = window.confirm("Are you sure to delete this news ?");
			                	 if(confirm){
						        	   $('[name=nid]').val(  $(this).closest('ul').parent().closest('ul').attr('id') );
						        	   $.news.remove();
						        	   $('#news-detail-pane').fadeOut('slow');
			                	 }
			                
				           })
						   
				           //popup on the right cornor
							$('.selfpost').click( function(e){
								if( $('.news-dropdown-wrap').hasClass('active') ){
									 $('.news-dropdown-wrap').removeClass('active');
								}
								$(this).children().addClass('active');
								e.stopPropagation();
							});
				           
				           //click like or unlike
				           $('.self-like').click( function(e){
							   e.preventDefault();
							   var nid = $(this).closest('ul').attr('id'); 
							    $.news.like( nid );
								$.news.detail( nid );	//reload detail		
						
						   })
						   
						   $('.self-ulike').click( function(e){
							   e.preventDefault();
							   var nid = $(this).closest('ul').attr('id');
							   $.news.ulike( nid );
							   $.news.detail( nid );	//reload detail		
							   
						   })
						
						   
				           	$(document).click(function() {
								// clear all dropdowns
								 $('.news-dropdown-wrap').removeClass('active');
							});
				          //end action for news
				           
				           
				        
		                 //submit post comment
		                 $('.comment_post').click( function(e){
		                	 e.preventDefault();
		                	 var nid =  $(this).closest('li').attr('id');
		                	  $('[name=nid]').val(nid );
		                	 //console.log( $(this).closest('li').attr('id')   );
		               	     $.news.comment_save(nid);
		                	 
		                 })
		                 
		                 //animate when click add comment
		                 $('#add-comment').click( function(e){
		                	 e.preventDefault();
		                	 
		                	 //clear comment id 
		                	 $('[name=mid]').val('');
		                	 //check current edit
		                	 //if found remove it
		                	 var txt = $(this).closest('li').find('span.news-comment-postbox-detail');
		                	 var cur = txt.text();
		                	 
		                	 //check if other edit comment are found remove it
		                	 var check = $('.news-comment-postbox-detail[data-edit=active]');
		                	 if( $('.news-comment-postbox-detail[data-edit=active]').length != 0 ){
		                		 check.text( check.children().val() );
		                		 $('.news-comment-postbox-detail').removeAttr('data-edit');
		                   	 } 
		                	 
		                	 if($('#add-comment').attr('data-remark')=="true"){
		                		 $('#add-comment').attr('data-remark','false');
		                		 $('#add-comment-text').text('Hide Comment');
		                		 $('#write-post').fadeIn('fast' , function(){
			                		 $('[name=comment]').focus();
			                	 });
		                		 
		                	 }else{
		                		 
		                		 $('#add-comment').attr('data-remark','true');
		                		 $('#add-comment-text').text('Add Comment');
		                		 $('#write-post').hide();
		                		 
		                	 }
		                 })
		                 
		                 $('.edit_comment').click( function(e){
		                	 e.preventDefault();
		                	 
		                	 var txt = $(this).closest('li').find('span.news-comment-postbox-detail');
		                	 var cur = txt.text();
		                	 
		                	 //check if other edit comment are found remove it
		                	 var check = $('.news-comment-postbox-detail[data-edit=active]');
		                	 if( $('.news-comment-postbox-detail[data-edit=active]').length != 0 ){
		                		 check.text( check.children().val() );
		                		 $('.news-comment-postbox-detail').removeAttr('data-edit');
		                   	 } 
		                		var input = '<textarea name="editcomment" style="width:100%" >'+txt.text()+'</textarea><a href="#" style="font-size:10px;" id="save_editcomment">Save</a> | <a href="#" style="color:#666; font-size:10px;" id="cancel_editcomment">Cancel or Press ESC </a>';
			                	 txt.html(input);
			             
			                	//focus then move cursor then capture key esc event	
			                	 $('[name=editcomment]')
			                	 .focus()
			                	 .focusEnd()
			                	 .keyup( function(e){
		                			  if (e.keyCode == 27){    $('#cancel_editcomment').trigger('click');  } 
		                		 })
			                
			                   txt.attr('data-edit','active') ;
		                		 
		                	  $('#save_editcomment').click( function(e){
		                		  e.preventDefault();
		                			var nid =  $(this).closest('ul').attr('data-newsid');
		                			var mid = $(this).closest('li').attr('id');
		                			 $('[name=mid]').val(mid );
				                	 $('[name=nid]').val(nid );
				               	     $.news.comment_save(nid);
		                	  })
		                	  
		                	  $('#cancel_editcomment').click( function(e){
		                		  e.preventDefault();
		                		  txt.html( cur );
		                	  })
		              
		             
		                 })
		                 //end edit comment
		                 
		                 $('.remove_comment').click( function(e){
		                	 e.preventDefault();
		                	 var confirm = window.confirm("Are you sure to delete this comment ?");
		                	 if(confirm){
		                		  var id =  $(this).closest('li').attr('id');
		                		  var nid = $(this).closest('ul').attr('data-newsid');
		                		  $.post(url , { "action" : "deletement" , "mid": id  }, function( result ){
		                			  		var response = eval('('+result+')');  
				   						    if(response.result=="success"){
				   						    		//reload content
				   						    		$.news.detail( nid );				
				   						    		$.news.load();
				   						    }
		                		  	});
		                		 
		                	 }//end if
		                 })
		                 
		                 //click comment icon
		                   $('.self-nav-news-comment').click( function(e){
				        	   e.preventDefault();
				        	   $('#add-comment').trigger('click');
				           })
		                 
		     		  
						}//end success
					});//end ajax 
			},	  
			 create:function(){
				 
				  $('[name=nid]').val('');
				  $('[name=newssubj]').val('').focus();
				  $('[name=newsdetail]').val('');
	              
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							    	  $('#readmore').attr('data-read','1');
							          $.news.load();				
							          console.log("news load");
							          $.news.create();
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						  	    $('#readmore').attr('data-read','1');
						        $.news.load();						    	
						    }
				 });
		    
		    },
		    hide:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "hide" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						  	  $('#readmore').attr('data-read','1');
						        $.news.load();						    	
						    }
				 });
		    	
		    },
		    like:function( id ){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "like" , "id" : id , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						        $.news.load('current');
						    }
				 });
		    	
		    },
		    ulike:function( id ){
				   var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				   $.post(url , { "action" : "ulike" , "id" : id , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						
						         $.news.load('current');
						         console.log( "reload " );
						
						    }
				   });
	  		},
	  		comment_save:function( id ){
				   	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				   	$.post(url , { "action" : "savement" , "data": formtojson, "id" : id }, function( result ){
						  	$.news.detail( id );
						  	$.news.load();	
					});
		   	
		},
	}//end jQuery
	  
	  //util
	  /*
	  $.fn.selectRange = function(start, end) {
		    if(!end) end = start; 
		    return this.each(function() {
		        if (this.setSelectionRange) {
		            this.focus();
		            this.setSelectionRange(start, end);
		        } else if (this.createTextRange) {
		            var range = this.createTextRange();
		            range.collapse(true);
		            range.moveEnd('character', end);
		            range.moveStart('character', start);
		            range.select();
		        }
		    });
		};
		*/
		//crmstack po.js
		$.fn.focusEnd = function(){
		   if(this.length == 0)return this;
		   selectionStart = this.val().length;
		   selectionEnd =  this.val().length;
		    input = this[0];
			if(input.createTextRange){
			   var range = input.createTextRange();
			   range.collapse(true);
			   range.moveEnd('character',selectionEnd);
			   range.moveStart('character',selectionStart);
			   range.select();
			}else if( input.setSelectionRange){
			  input.focus();
			  input.setSelectionRange(selectionStart,selectionEnd);
			}
			return this;
		} 
	  
 })(jQuery)//end function
 
  $(function(){
	  
		$.news.load();
	  
		$(window).keydown(function(e){
			/*
	 	    if(e.keyCode == 13) {
	 	      e.preventDefault();
	 	      return false;
	 	    }
	 	    */
	 	  });
		
	  //check is edit are open
	  $('[name=newssubj],[name=newsdetail]').focus( function(){
		  $('.startnews').show();
		  //clear all current edit ( if open )
		 	if( $('[data-edit=active]').length > 0 ){
        			//close edit news before open news detail
        			$('[data-edit=active]').prev().show(); 
     				$('#news-myedit').remove(); 	//remove on the fly news-edit				         			
     			    $('.mypost').show();    //show right popup
     			    //clear newsid
     			    $('[name=nid]').val('');
		 	}
		  
	  })
	  
	  $('#news-close').click( function(){
		    //check is currently edit news subject
		  
		  /* notwork 
		  var check = $('.news-comment-postbox-detail[data-edit=active]');
		  console.log( check );
		  */
			$('#news-detail-pane').fadeOut('slow');
			
		});

	  //init calendar
	  /*
	  $('.calendar_en').datepicker({
	        dateFormat: 'dd/mm/yy'
	    });
	  */
	
	  
	  $('.cancel_news').click( function(e){
		  		e.preventDefault();
				$.news.cancel();
	   });
	  $('.new_news').click( function(e){
		  		e.preventDefault();
				$.news.create();
	   });
	  $('.delete_news').click( function(e){
		  e.preventDefault();
		  var confirm = window.confirm('Are you sure to delete');
		  if( confirm ){
				$.news.remove();
		  }
	   });
	  $('.save_news').click( function(e){
		  		e.preventDefault();
				$.news.save();
	   });
	  
	  $('#readmore').click( function(e){
		  		e.preventDefault();
		  		$.news.load('morepage');
	  });
	  
	  
	
	   

	  
	  
  });
  