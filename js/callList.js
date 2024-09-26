 (function($){
	var url = "callList_process.php";
	var currentRow = null; 
	
	//var deleteRowid = [];
	//var updateRowid = [];
	
	var n = [];
	var d =[];
	
	  jQuery.callList = {
	    search: function(){
	    	var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	 	   $.ajax({   'url' : url, 
        	   'data' : { 'action' : 'search' , 'data' : formtojson }, 
			   'dataType' : 'html',   
			   'type' : 'POST' ,  
			   'beforeSend': function(){
			
				},										
				'success' : function(data){ 
	
		                        var  result =  eval('(' + data + ')'); 
		                        
		                        var $table = $('#calllist-maintain-table thead');
								$table.find('tr').remove();
								var txt = "<tr><td style='text-align:center;vertical-alig	n:middle' >#</td>";
								for( i=0 ; i<result.header.length ; i++){
									txt += "<td style='text-align:center;vertical-align:middle' >"+result.header[i].header+"</td>";
								}
								txt += "</tr>";
								$table.html(txt);
								
								
								//dynamic body
							    $table = $('#calllist-maintain-table tbody');
								$table.find('tr').remove();
								var txt = "";
								var seq = 1;
								var range = result.header.length;
								for( i=0 ; i<result.data.length ; i++){
									//txt += "<tr ><td >"+seq+"</td>";
									
										for( f=0 ; f<range;f++ ){
												var dynvar = eval("result.data["+i+"].f"+f ); 	
												if(f==0){
													txt += "<tr id='"+dynvar+"'><td class='text-center' >"+seq+"</td>";
												}else{
													txt+="<td>"+dynvar+"</td>";
												}
											
										}
									txt +="<td>DND</td></tr>";
									seq++;
								}
								$table.html(txt);
								
								var $table = $('#calllist-maintain-table tfoot');
								
								//add double click event 
						
								  $('#calllist-maintain-table tbody ').on('dblclick','tr', function(){
								     console.log("tr click ");
										//set current click list
									
									 //    sys_callback.current = $(this).children().first().text();
									//	 $('#popup-current-row').text('').text(sys_callback.current);
									//	 $('#popup-total-row').text('').text( sys_callback.list.length );	
								  });
								//be continue
		                        
		                        
				}//end success
	 	   });//end ajax
	    	
	    },
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
	    	var  page = $('#loadmorelist').attr('data-read');
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query' , 'page' : page }, 
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
								    var $table = $('#calllist-table tbody'); 
							
								   if(page == 1){
									   $table.find('tr').remove();
								   }
									
									var seq = parseInt($('#page').text());
									var txt = "";
											 for( i=0 ; i<result.imp.length ; i++){
											     seq++;
											     
										        var cmp = "";
											    for( j=0; j<result.imp[i].incamp.length;j++){ 
											    	cmp = cmp + " <span style='font-size:12px; padding:2px 5px; border-radius:3px; background-color:#ff9500; color:#fff;'>"+result.imp[i].incamp[j].cmpname+"</span>"
											    }
											     
											    txt = txt+"<tr id='"+result.imp[i].impid+"'><td style='vertical-align:middle; text-align:center' >&nbsp;"+seq+"&nbsp;</td>"+
												    		   "<td ><a href='#' class='nav-list-id'><strong>"+result.imp[i].lname+"</strong></a><br/>"+result.imp[i].ldetail+"</td>"+	
												    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.imp[i].cdate+"&nbsp;</td>"+
												    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.imp[i].cuser+"&nbsp;</td>"+
												    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.imp[i].total+"&nbsp;</td>"+
															   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.imp[i].start_date+"&nbsp;</td>"+
															   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.imp[i].end_date+"&nbsp;</td>"+
															   "<td style='text-align:center;vertical-align:middle;' >&nbsp;"+cmp+" &nbsp;</td></tr>";	 
											    } //end for
											 
											   	$table.append(txt);
											   	
											    page = parseInt(page) + 1;
											   	$('#loadmorelist').attr('data-read', page );
								
											
									           
									    //check if no record
						                if(i != 0){   
						                	 
						                		//add event click on link
											   $('.nav-list-id').bind('click',function(e){
										    	     e.preventDefault();
										    	     $.callList.detail( $(this).parent().parent().attr('id')  );
										    	     
										    	    	$('#calllist-main-pane').hide();
										            	$('#calllist-detail-pane').show();
									           })
									           	 //add event dblclick to  tr
												 $('#calllist-table tbody').on('dblclick','tr',function(){													 
													    $.callList.detail( $(this).attr('id'));
													   	$('#calllist-main-pane').hide();
										            	$('#calllist-detail-pane').show();
												 });
						              
							                 	$('#calllist-table tfoot').show();
												
												var total = parseInt($('#page').text()) + i;
												$('#page').text('').text( total );
												$('#ofpage').text('').text( result.totallist );
												
												//don't show more list if  last page
								        		if( total == parseInt(result.totallist) ){
													$('#loadmorelist').hide();
												}
										 
										}else{
											
										         $('#calllist-table tfoot').hide();
											     $row = $("<tr><td colspan='6' class='text-center'>&nbsp;  No Call List &nbsp;</td></tr>");
											     $row.appendTo($table);
											     
										    
										}//end if else
								
							 }  //end success
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

		                 //check cmpid is empty or not
		                if( result.listcmp[0].cmpid != "" ){
		                 
								    var $table = $('#listcamp-table tbody'); 
									$table.find('tr').remove();
									for( i=0 ; i<result.listcmp.length ; i++){
								
									    $row = $("<tr id='"+result.listcmp[i].impid+"'>"+
									    		   "<td style='vertical-align:middle'>"+result.listcmp[i].cmpname+"<br/><span style='font-size:12px; color:#777; font-style:italic'>Join this campaign since "+result.listcmp[i].jdate+"</span></td>"+	
									    		  "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listcmp[i].total+"&nbsp;</td>"+
									    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listcmp[i].newlist+"&nbsp;</td>"+
									    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listcmp[i].cback+"&nbsp;</td>"+
									    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listcmp[i].follow+"&nbsp;</td>"+
									    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listcmp[i].blist+"&nbsp;</td>"+
									    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listcmp[i].dnd+"&nbsp;</td>"+
									    		   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listcmp[i].maxtry+"&nbsp;</td>"+
									    		   "</tr>");	 
									     
										  $row.appendTo($table);
									
									}
							
		                }//end if 
						else{
						        var $table = $('#listcamp-table tbody'); 
							    $table.find('tr').remove();
		                	    $row = $("<tr><td colspan='8' style='text-align:center'> <span style='color:#666'>No campaign use this list</span> OR <span style='color:#666'>No list transfer to any agent.</span></td></tr>");
		                		$row.appendTo($table);
		                	
		                }
		                
							//list detail
							$('[name=impid]').val( result.listdtl.impid );
							$('[name=calllist_name]').val( result.listdtl.lname );
							$('[name=calllist_detail]').val( result.listdtl.ldtl );
							$('[name=calllist_note]').val( result.listdtl.lnote );
							$('[name=calllist_status]').val( result.listdtl.lsts );
							$('[name=genesys_campaign_name]').val( result.listdtl.genesys_campaign_name );
							$('[name=genesys_campaign_id]').val( result.listdtl.genesys_campaign_id );
							$('[name=genesys_list_name]').val( result.listdtl.genesys_list_name );
							$('[name=genesys_list_id]').val( result.listdtl.genesys_list_id );
							$('[name=genesys_queue_name]').val( result.listdtl.genesys_queue_name );
							$('[name=genesys_queue_id]').val( result.listdtl.genesys_queue_id );
							if(result.listdtl.is_count == 1){
								document.getElementById('is_count').checked = true;
							}
							else{
								document.getElementById('is_count').checked = false;
							}
							$('[name=import_id]').val( result.listdtl.impid );
							var selectElement = document.getElementById('leadtype');
							selectElement.innerHTML = '';
							var option = document.createElement('option');
							option.value = result.listdtl.genesys_list_id;
							option.text = result.listdtl.genesys_list_name;
							selectElement.appendChild(option);

					
							//file detail
							 $('#clist_status').text('').text( result.listdtl.lstsdtl).css('background-color',  result.listdtl.lstscolor);
							$('#clist_fname').text('').text( result.listdtl.fname);
							$('#clist_fsize').text('').text( result.listdtl.fsize );
							$('#clist_ftype').text('').text( result.listdtl.ftype );
							$('#clist_fimpd').text('').text( result.listdtl.cred );
							$('#clist_fimpu').text('').text ( result.listdtl.creu );
							
							var fext = result.listdtl.fname.replace(/^.*\./, '');
					
							$('#clist_ftype_dtl').text('').text(fext);
							if( fext == "xls" ){ $('#clist_ftype_dtl').css('background-color','#006B3C');
							}else if( fext == "xlsx"){ $('#clist_ftype_dtl').css('background-color','#006B3C');
							}else if( fext == "csv"){ 	$('#clist_ftype_dtl').css('background-color','#f39c12');
							}else if( fext == "text"){ 	$('#clist_ftype_dtl').css('background-color','#bdc3c7');
							}else if( fext == "txt"){	$('#clist_ftype_dtl').css('background-color','#bdc3c7');
							}else{	$('#clist_ftype_dtl').text('').text('unknow'); }
						
							//import list used field
					
							   // if( result.usedfield.result != "" ){
						    $table = $('#import-field-table tbody');
							$table.find('tr').remove();
							var txt = "";
							var seq = 1;
							for( i=0 ; i<result.usedfield.length ; i++){
										txt += "<tr>"+
													"<td style='text-align:center;vertical-align:middle' >"+seq+"</td>"+
													"<td >"+result.usedfield[i].caption+"</td>"+
													"<td >"+result.usedfield[i].fieldn+"</td>"+
													"</tr>";
										seq++;
								}
							$table.html(txt);
				
						
							//list summary
							var newlist =  parseInt(result.listdtl.total) -  parseInt(result.listdtl.blist ) + parseInt(result.listdtl.listdup) + parseInt(result.listdtl.dbdup);
							var alllist    = newlist + parseInt(result.listdtl.manlist);
							$('#total-newlist').text('').text( newlist );
							$('#total-badlist').text('').text( result.listdtl.blist);
							$('#total-inlistdup').text('').text( result.listdtl.listdup );
							$('#total-indbdup').text('').text( result.listdtl.dbdup );
							$('#total-manlist').text('').text( result.listdtl.manlist );
							$('#total-alllist').text('').text( alllist );
							
							
		               
						}//end success
					});//end ajax 
			},	  
			detailExport: function(){
				var id = $('[name=impid]').val();
				$.ajax({   'url' : url, 
				'data' : { 'action' : 'detailExport','id': id }, 
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

				  //check cmpid is empty or not
				 if( result.listexport[0].impid != "" ){
				  
							 var $table = $('#listgenesys-table tbody'); 
							 $table.find('tr').remove();
							 for( i=0 ; i<result.listexport.length ; i++){
						 
								 $row = $("<tr id='"+result.listexport[i].impid+"'>"+
											"<td style='vertical-align:middle'>"+result.listexport[i].lsname+"<br/><span style='font-size:12px; color:#777; font-style:italic'>Import date "+result.listexport[i].cdate+"</span></td>"+	
										   "<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listexport[i].total+"&nbsp;</td>"+
											"<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listexport[i].newenv+"&nbsp;</td>"+
											"<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listexport[i].pvtenv+"&nbsp;</td>"+
											"<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listexport[i].nonspon+"&nbsp;</td>"+
											"<td style='text-align:center;vertical-align:middle'>&nbsp;"+result.listexport[i].remain+"&nbsp;</td>"+
											"</tr>");	 
								  
								   $row.appendTo($table);
							 
							 }
					 
				 }//end if 
				 else{
						 var $table = $('#listcamp-table tbody'); 
						 $table.find('tr').remove();
						 $row = $("<tr><td colspan='8' style='text-align:center'> <span style='color:#666'>No campaign use this list</span> OR <span style='color:#666'>No list transfer to any agent.</span></td></tr>");
						 $row.appendTo($table);
					 
				 }
				 }//end success
			 });//end ajax 

			},
			detailMaintain: function(){
				   var id = $('[name=impid]').val();
				   var page = $('#loadmoremnlist').attr('data-read');
				   console.log("send page"+page);
				   $.ajax({   'url' : url, 
					   'data' : { 'action' : 'detailMaintain','id': id ,'page':page}, 
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

		             	//calllist maintenance
		                 
		             	//dynamic search field
		             	var txt = "";
		                 var $ul = $('#search-ul');
		                 $ul.find('li').remove();
		                 var size = result.searchfield.length;
		                 for( i=0 ; i<size ; i++){
		             
		                	 if( i%2==0){
		                	   	txt = txt +'<li style="margin:5px 0; border:0px solid red">';
		                		txt = txt+'<div style="float:left; width:50%; text-align:center;">'+
				 							   '<span style="margin:0 10px; font-size:16px; line-height:30px;">'+result.searchfield[i].searchcaption+' : </span>'+
				 							   '<span style="margin:0 10px;"> <input type="text" name="search" class="input_box" data-field="'+result.searchfield[i].searchfieldsys+'"  name="search_'+result.searchfield[i].searchfieldname+'"></span>'+
				 							   '</div>';
		                	 }else{
		                		txt = txt+'<div style="float:right; width:50%; text-align:left">'+
						 						'<span style="margin:0 10px; font-size:16px; line-height:30px;">'+result.searchfield[i].searchcaption+' : </span>'+
						 						'<span style="margin:0 10px;"> <input type="text" name="search" class="input_box" data-field="'+result.searchfield[i].searchfieldsys+'"  name="search_'+result.searchfield[i].searchfieldname+'"></span>'+
									 			'</div>'+
									 			'<div style="clear:both"></div>';
		                		txt = txt+'</li>';
		                	 }
						}//end loop for
		                 
		                 if( i%2==1){
		                		txt = txt+'<div style="float:right; width:50%; text-align:left">'+
						 						'<span style="margin:0 10px; font-size:16px; line-height:30px;">&nbsp;</span>'+
						 						'<span style="margin:0 10px;">&nbsp;</span>'+
									 			'</div>'+
									 			'<div style="clear:both"></div>';
		                		txt = txt+'</li>';
		                 }
		                 //append search and clear button
		                //  txt = txt+'<li style="margin:30px 0 0 10px;">'+
						// 	 				'<div style="float:left; width:50%; text-align:right;">'+
						// 	 					'<button class="btn btn-success search_mnlist" style="width:100px"> Search </button>&nbsp;'+
						// 	 				'</div>'+
						// 	 				'<div style="float:right; width:50%; text-align:left">&nbsp;'+
						// 	 					'<button class="btn btn-default clear_mnlist"  style="width:100px"> Clear </button>'+
						// 	 				'</div>'+
						// 	 				'<div style="clear:both"></div>'+
						// 	 			'</li>';
		                 
						$ul.html(txt); 
						
						/*
							var txt = "";
						    var $table = $('#search-table tbody');
						    //if(page == 1){
						    	$table.find('tr').remove();
						    	var size = result.searchfield.length;
								for( i=0 ; i<size ; i++){
										txt += "<tr>";
										txt += "<td style='text-align:right;vertical-align:middle' >"+result.searchfield[i].searchcaption+"</td>";
										txt += "<td style='vertical-align:middle' ><input type='text' data-field='"+result.searchfield[i].searchfieldsys+"' name='search_"+result.searchfield[i].searchfieldname+"' ></td>";
										txt += "</tr>";
								}
								$table.html(txt); 
						   // }
							*/
							
							//dynamic header
						    var $table = $('#calllist-maintain-table thead');
						    //if(page == 1){
						    	$table.find('tr').remove();
						        $table.attr('fieldlength',result.mnheader.length); // add field length attr to thead
						    	var txt = "<tr class='primary'><td style='text-align:center;vertical-alig	n:middle' >#</td>";
								for( i=0 ; i<result.mnheader.length ; i++){
									txt += "<td style='text-align:center;vertical-align:middle' >"+result.mnheader[i].caption+"</td>";
								}
								txt += "</tr>";
								$table.html(txt);
						   // }
							
							
							//dynamic body data
						    $table = $('#calllist-maintain-table tbody');
						    console.log(""+page);
							if(page == 1){
									$table.find('tr').remove();
							}
						
							var txt = "";
							var seq = parseInt($('#calllistPage').text()); //set seq start = 0
							var range = result.mnheader.length;
							for( i=0 ; i<result.mndata.length ; i++){
								seq++;
									for( f=0 ; f<range;f++ ){
											var dynvar = eval("result.mndata["+i+"].f"+f ); 	
											if(f==0){
												txt += "<tr id='"+dynvar+"'><td class='text-center' style='width:10%; '>"+seq+"</td>";
											}else{
												txt+="<td class='editable' style='vertical-align:middle; width:18%;padding-left:12px;' autocomplete='off'>"+dynvar+"</td>";
											}
									}
								txt +="<td><input type='checkbox' ></td></tr>";
							}
							$table.append(txt);
							
							page = parseInt(page) + 1;
							$('#loadmoremnlist').attr('data-read', page );
							
							var $table = $('#calllist-maintain-table tfoot');
							range = range+1;  // cal dynamic range
							$table.find('tr').children().attr('colspan',range);
							
							
							//add double click event 
								
							  $('#calllist-maintain-table tbody tr').off('dblclick').on('dblclick','td', function( e ){
								  console.log("maintain default active");
								  var tr = $(this).parent();
								  var self = $(this);
								  
								
								  //editable
								  if( self.hasClass('editable')){
									  		self.css('padding','0');
									  		cellval = $.trim(self.text()); 
									  		$(this).html("<input type='text' id='xedit' value='"+cellval+"' style='width:100%; margin:0; padding:0;' autocomplete='off'>")
									
									  		$('#xedit')
									  		.keypress(function(e){
									  
									  			 if(e.which==13){ //enter
										  			  var content = $(this).val();
										  			  $(this).parent().text(content);
										  			  self.css('padding-left','12px');
										  			  tr.attr('sts','u');
										  		  }
									  			 //detect data change
									  			 $(this).change( function(){
									  				  tr.attr('sts','u');
									  			 });
									  			 
									  		})
									  		.keyup(function(e){
									  		  if(e.which==27){ //esc
									  			  $(this).parent().text( cellval );
									  			  self.css('padding-left','12px');
									  		  }
									  		})
									  		.keydown(function(e){
									  			 if(e.which==9){ //tab
									  				 e.preventDefault();
										  			  $(this).parent().text( $(this).val());
										  			  self.css('padding-left','12px');
										  			  self.next().trigger('dblclick');
										  			  tr.attr('sts','u');
									  			 }
									  		})
									  		.focusEnd();
									  	
									  		self.children().first().blur( function(){
									  			 var content = $(this).val();
									  			 console.log( "on blur content : "+content );
									  			 
												 $(this).parent().text( content );		
												 self.css('padding-left','12px');
											 })
									  	
								  }
							  });
							  
							  $('#calllist-maintain-table tbody ').on('click','tr', function(){
								   $('#calllist-maintain-table tr.selected-row').removeClass('selected-row')
								   $(this).addClass('selected-row');
							  });
							//be continue
						

						   if(i==0){   
							   
			                     $('#calllist-maintain-table tfoot').hide();
							     $row = $("<tr id='nodata'><td class='text-center'>&nbsp; No List Found&nbsp;</td></tr>");
							     $row.appendTo($table);
							 
							}else{
							    	$('#calllist-maintain-tabletfoot').show();
								
									var total = parseInt($('#calllistPage').text()) + i;
									$('#calllistPage').text('').text( total );
									$('#calllistOfpage').text('').text( result.totaldata );
									
									//don't show more list if  last page
					        		if( total == parseInt(result.totaldata) ){
										$('#loadmoremnlist').hide();
									}
							}//end if else


						
		         
		                
						}//end success
				   });//end ajax
				
			},
			save_cmpmap: function(){
				//find campaignid on leftbox
				var impid = $('.calllistbox-ul [data-check=check]').attr('data-impid');
				//find cmp id on rightbox
				var cmpid = [];
				$('.cmpbox-ul [data-check=check]').each( function(){
					var self = $(this).attr('data-cmpid');
					cmpid.push( self );
				})
				//check  cmpid is selected
				if( cmpid.length == 0 ){
					$('#msg_cmp_mapped_result').css('visibility','visible');
					$('#msg_cmp_mapped_result').text('').html('<span style="color:red; font-size:15px;">Please select campagin on right of the box.</span>');
					return;
				}else{
					$('#msg_cmp_mapped_result').css('visibility','hidden');
					$('#msg_cmp_mapped_result').html('&nbsp;');
				}
				
				var cmpid = JSON.stringify(cmpid);
				var uncmpid = [];
				$('.cmpbox-ul [data-check=uncheck]').each( function(){
					var self = $(this).attr('data-cmpid');
					uncmpid.push( self );
				})
				var uncmpid = JSON.stringify(uncmpid);
				
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				  $.post(url , { "action" : "save_cmpmap" , "data": formtojson , "cmpid" : cmpid , "uncmpid" :  uncmpid , "impid" : impid }, function( result ){
					    var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	
						    	//  $.callList.load();
						    	 // if( $('[name=impid]').val() != "" ){
							       //   $.callList.detail( $('[name=impid]').val() );		
						    	 // }
						    	  
						          //$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
						          $('.next').trigger('click');
						          
						    }
				 });
 	
			 
			},
			updateList:function(){
				
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				  $.post(url , { "action" : "updatelist" , "data": formtojson  }, function( result ){
					    var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	  $.callList.load();
						          $.callList.detail( $('[name=impid]').val() );				
						          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
						    }
				 });
				
				  
			},
			genesysExport:function(){
				var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				$.post(url , { "action" : "genesysexport" , "data": formtojson  }, function( result ){
					var response = eval('('+result+')');
					if(response.result=="success"){
						$.callList.detailExport();			
						$('#stacknotify').stacknotify({'message':response.message,'detail':'Export success'} );
					}else{
						$('#stacknotify').stacknotify({'message':response.message,'detail':'Error','type':'error'} );
					}
				});
			},
			genesysClear:function(){
				var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				$.post(url , { "action" : "genesysclear" , "data": formtojson  }, function( result ){
					var response = eval('('+result+')');  
					if(response.result=="success"){
						$.callList.detailExport();			
						$('#stacknotify').stacknotify({'message':response.message,'detail':'Clear success'} );
					} else {
						$('#stacknotify').stacknotify({'message':response.message,'detail':'Error','type':'error'} );
					}
				});

			},
			query_importList:function(){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				   $.ajax({   'url' : url, 
					   'data' : { 'action' : 'queryimportlist','data':formtojson }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
						   //set image loading for waiting request
						   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
						},										
						'success' : function(data){ 
							
						
							
							var  result =  eval('(' + data + ')'); 
						    var $table = $('#list-import-table tbody'); 
							$table.find('tr').remove();
							var i=0;
					
									 for( i=0 ; i<result.length ; i++){
										 seq = i;
									     seq++;
								
									     $row = $("<tr id='"+result[i].impid+"'><td style='vertical-align:middle; text-align:right' >&nbsp;"+seq+"&nbsp;</td>"+
									    		   "<td ><a href='#' class='nav-list-id'><strong>&nbsp;"+result[i].fname+"</strong></a></td>"+	
									    		   "<td class='text-center' style='vertical-align:middle'>&nbsp;"+result[i].fsize+"&nbsp;</td>"+
									    		   "<td class='text-center' style='vertical-align:middle'>&nbsp;"+result[i].impid+"&nbsp;</td>"+
									    		   "<td >&nbsp;"+result[i].fname+"&nbsp;</td>"+
									    		   "<td >&nbsp;"+result[i].fname+"&nbsp;</td>"+
												   "<td >&nbsp;"+result[i].cdate+"&nbsp;</td></tr>");	 
									     
										  $row.appendTo($table);
										  $.callList.list_gridSet($row);
										  
									    } 
									
									 
									 //add event
								 
									   $('.nav-list-id').bind('click',function(e){
										   
										  // console.log( $(this).parent().parent().attr('id')  );
										    
								    	     e.preventDefault();
								    	     $('[name=impid]').val( $(this).parent().parent().attr('id')   );
								    	     	
								    	     $.callList.detail_importList();
								    	     
								    	    	//$('#calllist-main-pane').hide();
								            	//$('#calllist-detail-pane').show();
							           })
							        
							 
			              
		               
						}//end success
					});//end ajax 
				
				
			},
			list_gridSet:function( $row ){
				
				  $row 
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        })
			        .click( function(){
			        	/*
			        	   $('[name=lid]').val( $row.attr('id') );	
			        	   $('#list-table tr.selected-row').removeClass('selected-row');
			        	   $row.addClass('selected-row');
			        	*/
			        })			        
			        .dblclick( function(e){
			        	/*
			        	$.callList.detail( $row.attr('id') );
				      	 $('#calllist-main-pane').hide();
				    	 $('#calllist-detail-pane').show();			
				    	 */	 
				  
				    })
				
			},
			detail_importList:function( key ){
			
				   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				   
				   $('[name=key]').val(key);
				   //$.ajax({   'url' : 'import_process.php', 
					   $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'afterupload' , 'data' : formtojson , 'key' : key }, 
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
				             
										 var field = "<select data-col=''><option value='0'>  --- Do not map this field --- </option>";
										 for( i=0 ; i<result.init.length ; i++){
											 field += "<option value='"+ result.init[i].id +"' data-type='"+result.init[i].type+"'>"+ result.init[i].alias+"</option>";									    										    
										 }								
										 field += "</select>";
										 
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
													    		   "<td >&nbsp;"+field+"&nbsp;</td>"+
													    		   "<td >&nbsp;</td>"+
													     		   "</tr>");	
													     //add data attribute for mapping field
													     $row.find('select').attr('data-col',i) 
													     
														  $row.appendTo($table);
														//  $.issue.gridSet($row);
													    } 
													 
													
						}
				   })//end ajax		
				 
			},			
			 create:function(){
				 
				 $('[name=lid]').val('');
				  $('[name=listName]').val('');
				  $('[name=listDesc]').val('');
	              $('[name=listStatus]').val('1');
	              $('[name=key]').val('');
	              
	              /*
	              $('[name=cmpStatDate]').val(''); 
	              $('[name=cmpEndDate]').val(''); 
	              $('[name=cmpStatus]').val(''); 
	              */
	              
	           	  $('#calllist-main-pane').hide();
		    	  $('#calllist-detail-pane').show();				
				  
			 },
			   save:function(){
					  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var response = eval('('+result+')');  
							    if(response.result=="success"){
							  
							          $.callList.load();				
							          $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
							    }
					 });
					
						
		    },
		    remove:function(){
		    	 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "delete" , "data": formtojson  }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	 $('#stacknotify').stacknotify({'message':'Delete success','detail':'Delete success'} );
						    	 
						    	 setTimeout(function(){
						 	    	location.reload();
						    	 },400)
						    }
				 });
		    
		    },
			  gridSet:function($row){
	
				  $row 
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        })
			        .click( function(){
			        	
			        	  $('[name=lid]').val( $row.attr('id') );	
			        	   $('#list-table tr.selected-row').removeClass('selected-row');
			        	   $row.addClass('selected-row');
			        	
			        })			        
			        .dblclick( function(e){
			        	$.callList.detail( $row.attr('id') );
				    	 
				      	 $('#calllist-main-pane').hide();
				    	 $('#calllist-detail-pane').show();				 
				  
				    })
				    
			  },
			  stepstart: function(){
				  
				  
			  },
			  step1: function(){
					$('#stepper1').show();
					$('#stepper2').hide();
					$('#stepper3').hide();
					$('#stepper4').hide();
					$('#stepper_end').hide();
						 
			 },
			  step2: function(){
					$('#stepper1').hide();
					$('#stepper2').show();
					$('#stepper3').hide();
					$('#stepper4').hide();
					$('#stepper_end').hide();
					 
			 },
			  step3: function(){
					$('#stepper1').hide();
					$('#stepper2').hide();
					$('#stepper3').show();
					$('#stepper4').hide();
					$('#stepper_end').hide();
					
					
			    	 var comma = $.animateNumber.numberStepFactories.separator(',')
			    	 //animate number
			    	 var num1 = parseInt($('#view-indb').text());
			       	 var num2 = parseInt($('#view-inlist').text());
			       	 var num3 = parseInt($('#view-badlist').text());
			       	 var num4 = parseInt($('#view-newlist').text());
			       	 var num5 = parseInt($('#view-totallist').text());
			       	 
					$('#view-indb').animateNumber({number: num1 , numberStep: comma},700);
					$('#view-inlist').animateNumber({number: num2, numberStep: comma},700);
					$('#view-badlist').animateNumber({number:num3, numberStep: comma},700);
					$('#view-newlist').animateNumber({number:num4, numberStep: comma},700);
					$('#view-totallist').animateNumber({number: num5, numberStep: comma},700);
					 
			  },
			  step4: function(){
					$('#stepper1').hide();
					$('#stepper2').hide();
					$('#stepper3').hide();
					$('#stepper4').show();
					$('#stepper_end').hide();
						 
			 },
			 stepend : function(){
					$('#stepper1').hide();
					$('#stepper2').hide();
					$('#stepper3').hide();
					$('#stepper4').hide();
					$('#stepper_end').show();
			 },
			 /* list maintenance */
			 new_mnlist : function(){
				 console.log("new list");
				 //click new row
				 
			     $table = $('#calllist-maintain-table tbody');
			     var fieldlength = parseInt($('#calllist-maintain-table thead').attr('fieldlength'));
			     var i = 0;
			     var txt = "<tr sts='n'><td style='text-align:center'>#</td>";
			     var size = fieldlength - 1;
			     
			     for(i;i<size;i++){
					 txt = txt +"<td class='editable' style='vertical-align:middle; width:18%;padding-left:12px;' autocomplete='off'></td>";
			     }
			     txt = txt +"<td><input type='checkbox' ></td></tr>";
			     $table.prepend(txt);
		
			 	//add double click event ( but selector is not same as main function ) cause duplicate event handler
				 $('#calllist-maintain-table tbody tr[sts=n]').off('dblclick').on('dblclick','td', function( e ){
				
					  var self = $(this);
					  //editable
					  if( self.hasClass('editable')){
						  		self.css('padding','0');
						  		cellval = $.trim(self.text()); 
						  		$(this).html("<input type='text' id='xedit' value='"+cellval+"' style='width:100%; margin:0; padding:0;' autocomplete='off'>")
						
						  		$('#xedit')
						  		.keypress(function(e){
						  			 if(e.which==13){
							  			  var content = $(this).val();
							  			  $(this).parent().text(content);
							  			  self.css('padding-left','12px');
							  		  }
						  			 
						  		})
						  		.keyup(function(e){
						  		  if(e.which==27){
						  			  $(this).parent().text( cellval );
						  			  self.css('padding-left','12px');
						  		  }
						  		})	
						  		.keydown(function(e){
						  			 if(e.which==9){ //tab
						  				 e.preventDefault();
							  			  $(this).parent().text( $(this).val());
							  			  self.css('padding-left','12px');
							  			  self.next().trigger('dblclick');
							  			  tr.attr('sts','u');
						  			 }
						  		})
						  		.focusEnd();
						  	
						  		self.children().first().blur( function(){
						  			 var content = $(this).val();
									 $(this).parent().text( content );		
									 self.css('padding-left','12px');
								 })
						  	
					  }
				  });
				
			
				  /*
				  
				  $('#calllist-maintain-table tbody ').on('click','tr', function(){
					   $('#calllist-maintain-table tr.selected-row').removeClass('selected-row')
					   $(this).addClass('selected-row');
				  });
			   
				//  console.log(  $('#calllist-maintain-table tbody tr').find('td:first-child').next() );
		
				 // $('#calllist-maintain-table tbody tr').find('td:first-child').next().trigger('dblclick');
				 
				 /*
			
           	  //updateRowid.push( $('#callList-table tbody tr:eq('+currentRow+')').attr('id') );
					//remove row highlight
					//$('#customerDetail tbody tr').removeClass('datahighlight-click');  
					if(  String( $table.find('tr').attr('id')) =="nodata"){ 
							// delete row nodata
							$table.find('tr').remove(); 
					  }       
					
			
			        $.quotation.gridSet( $row ); 
					$.quotation._reIndex();
				 */
				 
				 
			 },
			 delete_mnlist : function(){
					console.log("delete click");
					
				console.log( $('.selected-row').attr('id') );
			
				if( $('.selected-row').attr('id') != undefined ){
					d.push( $('.selected-row').attr('id') );
				}
				$('.selected-row').remove();
					
			
					
					
					 //$table = $('#calllist-maintain-table tbody');
					/*
					 * 
			     var $table = $('#quo-item-table tbody');
				 // console.log( currentRow );
				 // console.log( $('#callList-table tbody tr:eq('+currentRow+')'));
				 console.log( "get row i "+ $('#quo-item-table tbody tr:eq('+currentRow+')').attr('id') );
				 
				 if(  $('#quo-item-table tbody tr:eq('+currentRow+')').attr('id')==undefined){
			
				 }
				 
				 if(  $('#quo-item-table tbody tr:eq('+currentRow+')').attr('status')!='n'){
	              //if record == new not memory this row to delete		     
  				 deleteRowid.push( $('#quo-item-table tbody tr:eq('+currentRow+')').attr('id') );
				 }
				 //check is record is update [ not found = -1 ]
				 if( $.inArray( $('#quo-item-table tbody tr:eq('+currentRow+')').attr('id') ,updateRowid)==0  ){
				       // if row use to update 
					   updateRowid.splice( updateRowid.indexOf( $('#quo-item-table tbody tr:eq('+currentRow+')').attr('id') ),1);
					    console.log("update row id : "+updateRowid  );
				 } 
				 
				 $('#quo-item-table tbody tr:eq('+currentRow+')').remove();
			
				 //stack row id for delete
		
				 console.log( deleteRowid );
				 
				//re sequence	
				 $.quotation._reIndex();
					 */
				
			 },
			 cancel_mnlist : function(){
				 console.log("cancel click");
			 },
			 save_mnlist : function(){
					console.log("save click");
					//example see.... devstack/admin.js
				
				     if( d.length != 0 ){
				    	 console.log("delete  ");
						 var del = "{\"data\": \""+d.toString()+"\"}";  //this d is local variable not d[]
						console.log( del );
					  }
				
				       //field length
				      //not incloud seq
				     //	console.log("field length : "+ $('#calllist-maintain-table thead').attr('fieldlength') );
				     
						//find new row
						//console.log( "new row ");

					//	console.log( $('#calllist-maintain-table tbody tr[sts=n]').length );
						var fieldlength =  $('#calllist-maintain-table thead').attr('fieldlength');
						
			
						//console.log( 	$('#quo-item-table tbody tr[status=n]').length  );
						
						var insertfield = fieldlength - 1;
						if( $('#calllist-maintain-table tbody tr[sts=n]').length  != 0 ){
								var n = "{\"data\":[";
								$('#calllist-maintain-table tbody tr[sts=n]').each( function(){
									//loop all td but not seq
									$(this).find('td').not(':first').each( function( key ){ 
										console.log( "field : "+key);
										if(key==0){
											n = n+"{\"f"+key+"\":\""+$.trim($(this).text())+"\","; //1
										}
										else{
											if(key!=insertfield){
												n = n+"\"f"+key+"\":\""+$.trim($(this).text())+"\","; //2
											}else{
												n = n+"\"f"+key+"\":\"1\"},";//3
											}
										}
								
									})//end each td
								})//end each tr
								
								 n = n.substr( 0, n.lastIndexOf(",") );
								 n += "]}"; 
								 console.log("new ");
								console.log( n );
						 
						}//end if n
						
						
						console.log( $('#calllist-maintain-table tbody tr[sts=u]') );
						
						if( $('#calllist-maintain-table tbody tr[sts=u]').length  != 0 ){
								var u = "{\"data\":[";
							
								$('#calllist-maintain-table tbody tr[sts=u]').each( function(){
									var id = $(this).attr('id');
									$(this).find('td').not(':first').each( function( key ){ 
										//console.log( "key : "+key+" | "+fieldlength );
										if(key==0){
											//u = u+"{\"id\":\""+id+"\",";
											u = u+"{\"f"+key+"\":\""+$.trim($(this).text())+"\","; //1
										}
										else{
											if(key!=insertfield){
												u = u+"\"f"+key+"\":\""+$.trim($(this).text())+"\",";
											}else{
												u = u+"\"DND"+key+"\":\""+$.trim($(this).text())+"\",";
												u = u+"\"id\":\""+id+"\"},";
											}
										}
								
									})//end each td
								})//end each tr
								
								 u = u.substr( 0, u.lastIndexOf(",") );
								 u += "]}"; 
								 console.log("update ");
								console.log( u );
						}//end if u
						
						/*
						$('#calllist-maintain-table tbody tr[sts=n]').each( function( index ){
						$(this).find('td').each( function( key ){ 
													  switch(key){       
													//		case 0  :  n+="{\"seq\":\""+$.trim($(this).text())+"\","; break;
															case 0  :  n+="{\"item\":\""+$.trim($(this).text())+"\","; break;
															case 1  :  n+="\"desc\":\""+$.trim($(this).text())+"\","; break;
															case 2  :  n+="\"pNo\":\""+$.trim($(this).text().replace(/,/g,''))+"\","; break;
															case 3  :  n+="\"qty\":\""+$.trim($(this).text())+"\","; break;
															case 4  :  n+="\"uPrice\":\""+$.trim($(this).text())+"\" },"; break;		 
													  }    
											 })//end each td
							})//end each tr
						 
							 n = n.substr( 0, n.lastIndexOf(",") );
							 n += "]}"; 
							 
						}	 
						//find update row 
						console.log( "update row ");
						console.log( 	$('#quo-item-table tbody tr[status=u]').length  );
						
						
						
						if( $('#quo-item-table tbody tr[status=u]').length != 0 ){
						var u = "{\"data\":[";
						$('#quo-item-table tbody tr[status=u]').each( function( index ){
							$(this).find('td').each( function( key ){ 
													  switch(key){       
															case 0  :  u+="{\"id\":\""+$.trim($(this).parent().attr('id'))+"\","; 
															                 u+="\"item\":\""+$.trim($(this).text())+"\","; break;
															case 1  :  u+="\"desc\":\""+$.trim($(this).text())+"\","; break;
															case 2  :  u+="\"pNo\":\""+$.trim($(this).text().replace(/,/g,''))+"\","; break;
															case 3  :  u+="\"qty\":\""+$.trim($(this).text())+"\","; break;
															case 4  :  u+="\"uPrice\":\""+$.trim($(this).text())+"\" },"; break;		 	 
													  }    
											 })//end each td
							})//end each tr
							 u = u.substr( 0, u.lastIndexOf(",") );
							 u += "]}"; 
						   
							console.log( u );
						} 
						 
						 */
						var  formtojson =  JSON.stringify( $('form').serializeObject() );  
						$.post( url , { "action" : "dynsave" , "data": formtojson, "d":del , "u":u , "n":n  }, function( result ){
							var response = eval('('+result+')');  
						    if(response.result=="success"){
						    
						        $('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
						    //	$('#list-maintain-tab').trigger('click');
						    			/*
						    			click( function(e){
											e.preventDefault();
											$('#loadmoremnlist').attr('data-read','1');  //reset page 
											$('#calllistPage').text('0');								//reset seq
											$.callList.detailMaintain();
								
										
											
											
										});
										*/
						   
						        
						    }
						
						 });
						 
					
						// end example
			 },
			 //use for match campaign
			 match_cmp : function(){
					var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					console.log( "token : "+$('[name=token]').val() );
		    	    $.ajax({   'url' : "callList_process.php", 
			        	   'data' : { 'action' : 'match_cmp' ,  'data': formtojson  }, 
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
											console.log( result );

											//start right box
											//show campaign
											var cmpbox = $('.cmpbox-ul');
											cmpbox.find('li').remove();
							
											if( result.cmp.result != "empty"){
												for(i=0;i<result.cmp.length;i++){
													
													 var $row =	$('<li  data-cmpid="'+result.cmp[i].cmpid+'" data-class="chbox" data-check="uncheck"  >'+
																			 '<div style="float:left; display:inline-block; font-size:24px; padding:2px 6px 2px 6px" class="ion-ios-circle-outline ucheck"></div>'+ 
																			 '<div style="float:left; display:inline-block; font-size:16px; padding:6px; color:#555">'+result.cmp[i].cmpname+'</div> '+
																			 '<div style="float:right; display:inline-block;text-align:right; padding:6px; ">'+
																			 '<span style="font-size:12px;"></span> '+
																			 '</div>'+
																			 '<div style="clear:both"></div>'+
																			 '</li>');
														$row.appendTo(cmpbox);
															
												}							
												$('#cmp_ava').text('').text(result.cmp.length);
												$('.no-cmpbox').hide();
											}
											//end right box


											//start left box
											//new list

											var calllistbox = $('.calllistbox-ul');
											calllistbox.find('li').remove();
							
											if( result.newlist.result != "empty"){
												for(i=0;i<result.newlist.length;i++){

													 var $row =	$('<li  data-impid="'+result.newlist[i].impid+'" data-class="chbox" data-check="check"  >'+
															 '<div style="float:left; display:inline-block; font-size:24px; padding:2px 6px 2px 6px" class="ucheck ion-ios-checkmark-outline ucheck"></div>'+ 
															 '<div style="float:left; display:inline-block; font-size:16px; padding:6px; color:#555">'+result.newlist[i].lname+'</div> '+
															 '<div style="float:right; display:inline-block;text-align:right; padding:6px; ">'+
															 '<span style="font-size:12px;"></span> '+
															 '</div>'+
															 '<div style="clear:both"></div>'+
															 '</li>');
													$row.appendTo(calllistbox);
										
												}
												$('.no-calllistbox').hide();
											}
											//end left box
											

							}//end success
		    	    })//end ajax
		    	    
				 
			 }
	}//end jQuery
	  
	  $.fn.setCursorPosition = function(position){
		   if(this.length ==0) return this;
		    return $(this).setSelection(position,position);
		}
		$.fn.setSelection = function(selectionStart,selectionEnd){
		   if(this.length == 0)return this;
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
		
		$.fn.focusEnd = function(){
		   this.setCursorPosition(this.val().length);
		    return this;
		} 
		
	
 })(jQuery)//end function
 
  $(function(){
	  
	
	  
		//add action
	  //not used
	  /*
		 $('.rightbox-ul').on('click' , 'li' , function(){
			
					var self = $(this);
					var $check = self.find('div.ucheck');
					if(self.attr('data-check') == "uncheck" ){
								self.attr('data-check','check') 
								$check
								.removeClass('ion-ios7-circle-outline')
								.addClass('ion-ios7-checkmark-outline');
					}else{
								self.attr('data-check','uncheck'); 
								$check
								.removeClass('ion-ios7-checkmark-outline')
								.addClass('ion-ios7-circle-outline');
						
					}
					
		 })
		 

	
		$('#toright').on('click',  function(){
			
			 var li = $('#leftbox-ul li[data-check=check]');
			 
			 li.clone().prependTo('#rightbox-ul');
			 li.remove();
			 
				if( $('#leftbox-ul li').length == 0){
					$('#leftbox').show();						
				}else{
					$('#leftbox').hide();			
				}
		 
				if($('#rightbox-ul li').length ==0){
					$('#rightbox').show();	
				}else{
					$('#rightbox').hide();	
				}
				
				$('#cmp_ava').text('').text($('#leftbox-ul li').length );
				$('#cmp_mapped').text('').text( $('#rightbox-ul li').length );
				
				//show msg
				$('.msg_cmp_mapping_result').fadeIn('fast',function(){
					var txt = "campaign";
					if( $('#rightbox-ul li').length >1){
						txt = "campaigns";
					}
					$('#cmp_now_mapping_header').text('').text('Process mapping for '+$('#rightbox-ul li').length+' '+txt);
					
					$('#cmp_now_mapping').children().remove();
					$('#cmp_now_mapping').append("<div class='ion-ios7-checkmark-empty msg_cmp_mapping_result' style='font-size:16px;'>"+li.text()+"</div>");
				})
				
		})
		
		$('#toleft').on('click',  function(){
			 var li = $('#rightbox-ul li[data-check=check]');
	
			 li.clone().prependTo('#leftbox-ul');
			 li.remove();
			 
				if( $('#leftbox-ul li').length == 0){
					$('#leftbox').show();						
				}else{
					$('#leftbox').hide();			
				}
		 
				if($('#rightbox-ul li').length ==0){
					$('#rightbox').show();	
				}else{
					$('#rightbox').hide();	
				}
				
				$('#cmp_ava').text('').text($('#leftbox-ul li').length );
				$('#cmp_mapped').text('').text( $('#rightbox-ul li').length );
		});
		*/
	  
	

	  $('.new_list').click( function(e){
	  		e.preventDefault();
			$.callList.create();
	  });
	  
	  
	  $('.cancel_campaign').click( function(e){
		  		e.preventDefault();
				$.callList.cancel();
	   });
	 
	  $('.delete_campaign').click( function(e){
		  e.preventDefault();
		  var confirm = window.confirm('Are you sure to delete');
		  if( confirm ){
				$.callList.remove();
		  }
	   });
	  $('.save_list').click( function(e){
		  		e.preventDefault();
				$.callList.save();
	   });
	
	  
  });
  