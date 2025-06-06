 (function($){
	var url = "call-pane_process.php";
	var popup = { list: [] , current : 0 };
	
	
	var sys_dial =  { list: [] , current : 0 , called : []};
	var sys_callback =  { list: [] , current : 0 , called : []};
	var sys_follow =  { list: [] , current : 0 , called : []};
	var sys_hist =  { list: [] , current : 0 , called : []};	
	
	var channelid = "";
	var uniqueid = "";
	var callsts = "";  //variable for check is oncall ( prevent double click make call twice )
	
	jQuery.call = {
		init:function(){
			  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'init' , 'data' : formtojson }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					},										
					'success' : function(data){ 
						
						   var  result =  eval('(' + data + ')'); 
						    var $table = $('#campaign-table tbody'); 
							$table.find('tr').remove();
							var seq = 0;
									 for( i=0 ; i<result.length ; i++){
										  seq++;
									       $row = $("<tr id='"+result[i].cmpid+"' data-name='"+result[i].cmpName+"' >"+
											    		 	"<td style='border-left:1px solid #E2E2E2; border-bottom:1px solid #E2E2E2; vertical-align:middle; text-align:center;' >"+seq+"</td>"+
											    		    "<td style='border-bottom:1px solid #E2E2E2;'><strong>&nbsp;"+result[i].cmpName+"</strong><br/><span style='color:#777777;'>&nbsp;"+result[i].cmpDetail+"</span></td>"+		
											    		    "<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>"+result[i].total+"</td>" +
											    		    "<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>"+result[i].nlist+"</td>" +
											    		    "<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>"+result[i].ncont+"</td>" +
														    "<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>"+result[i].clsit+"</td>" +
														    "<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>"+result[i].flist+"</td>" +														    
														    "<td  class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:14px; font-family:lato; font-weight: 600; '>"+result[i].jdate+"</td>" +
														    "<td style='border-bottom:1px solid #E2E2E2;border-right:1px solid #E2E2E2;  vertical-align:middle' class='text-center'><button class='btn cmp_selected' style=' color:#fff;background-color:#f0ad4e; border-radius:3px;'> Join campaign </button></td>" +
														   	"</tr>");	 
										  $row.appendTo($table);
										
									    } 
									 
										var camp = "Campaign";
										if(seq>1){
											camp = "Campaigns";
										} 
									 
										 var txt = "<tr><td colspan='9' style='border:1px solid #E2E2E2;  border-top:0; text-align:center;color:#676a6c;'>Total "+seq+" "+camp+" &nbsp;</td></tr>";
										 $('#campaign-table tfoot').html(txt);
									  
										 //init event
										 //add event dblclick to  tr
										 //prevent duplicate event move to callcampaign-pane
										 /*
										 $('#campaign-table tbody').on('dblclick','tr',function(){
											
												var cmpid = $(this).attr('id');
												var cmpname = $(this).attr('data-name');
												$.call.cmp_initial( cmpid  );
												$.call.cmp_joinlog(cmpid , cmpname );
										 });
										 */
										 
										 //add event to button  join campaign
										 $('.cmp_selected').click( function(e){
											 	e.preventDefault();
											 	var tr = $(this).parent().parent();
											 	var cmpid = tr.attr('id');
											 	var cmpname =  tr.attr('data-name');
											 
											 	$.call.cmp_initial( cmpid  );
												$.call.cmp_joinlog(cmpid , cmpname ); 
											 	
										 })//end campaign click ( select campaign )
					 
					}//end success
			   })//end ajax			 
			
		},
		cmp_joinlog : function( cmpid , cmpname ){
			
			 //log agent join campaign
		 	  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
		 	  $.post(url , { "action" : "cmp_joinlog" , "cmpid": cmpid , "data": formtojson }, function( result ){
		 		
			       var response = eval('('+result+')');  
				    if(response.result=="success"){
				    	
				    	//console.log( cmpid +"|"+ cmpname ); 
				    	// set selected campaign
					 	$('[name=cmpid]').val( cmpid );
					 	//animate select campaign
					 	$('#smartpanel').slideUp('slow' , function(){
					 		$('#smartpanel-detail').text(cmpname);										 	
					 		$('#smartpanel').slideDown('slow');
					 	});
					 	
					 	var uid = $('[name=uid]').val();
				 		//keep to cookie for next incoming
						$.cookie("cur-cmp", cmpid+"|"+cmpname+"|"+uid , { path: '/', expires: 10 });
						//hide campaign select table
						$('#callcampaign-pane').hide();
						//load callwork pane
						$('#callwork-pane').load('callwork-pane.php' , function(){
								$(this).fadeIn('slow');
								//load call list agent
								$.call.load_newlist( cmpid );
								//start monitor
								$('#callwork-mon').fadeIn( 1000 );
						 });
						
				    	
				    }
				  
		 	  });
			
		},
		cmp_initial: function( cmpid ){
		  	 //log join campaign
		 	  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.ajax({   'url' : url, 
				        	   'data' : {  "action" : "cmp_initial" , "cmpid": cmpid , "data": formtojson  }, 
							   'dataType' : 'html',   
							   'type' : 'POST' ,  
							   'beforeSend': function(){
								},										
								'success' : function(data){ 
									
									  var  result =  eval('(' + data + ')'); 
									
									  
									   //campaign setup both popup-page and callwork-page
									  
										//initial campaign profile
										//campaign info
										$('#show-cmp').text('').text( result.cmp.cmpName );
										$('#show-cmp-dtl').text('').text( result.cmp.cmpDetail);
									
										$("#extweb").attr( 'href' , result.cmp.exturl).text('app name');
										$("[name=salescript]").val( result.cmp.saleScript);
										
										 //campaign profile ( popup profile pane )
										 txt = "";
										 for( i=0 ; i<result.pfield.length ; i++){
											 	txt = txt + "<tr><td style='vertical-align:middle; text-align:right; color:#676a6c;'>&nbsp;"+result.pfield[i].cn+" : </td>"+
											 					 "<td style='vertical-align:middle;'><input type='text' name='"+result.pfield[i].fn+"'  autocomplete='off' style='width:100%'></td><tr/>";
										    } 
										$('#cmpprofile-table tbody').text('').append(txt); 
										
										//load call summary to dashboard
										$.call.load_dashboard(cmpid)
										//setup dynamic header for this campaign
										
										
										
										
								}//end success
						   })//end ajax
		 	  
			
		},
		load_dashboard : function( cmpid ){
	  	 	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query_dashboard','cmpid': cmpid , 'data':formtojson   }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
				   },
					'success' : function(data){ 
                        var  result =  eval('(' + data + ')'); 
                        
                        $('#total_diallist').text(result.tnewlist);
                        $('#total_nocontact').text( result.tnocont);
                        $('#total_callback').text(result.tcallback);
                        $('#total_followup').text(result.tfollowup);
          
					}
	        })
			
		},
		load_newlist : function( cmpid ){
	  	 	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
	    	var  page = $('#loadmore_newlist').attr('data-read');
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query_newlist','cmpid': cmpid , 'data':formtojson , 'page' : page  }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
				
					     
					},										
					'success' : function(data){ 
									//remove image loading 
							
									
			                        var  result =  eval('(' + data + ')'); 
			               		 	var headerlength = parseInt( result.cfield.length ) + 1; //add system field ( seq ) //get header field length
			               		 
								    //tab new list 
									//new list dynamic field header
								    var txt = "<tr class='primary'>";
								    	 txt = txt + "<td style='vertical-align:middle; text-align:center; width:5%;'>&nbsp; # &nbsp;</td>";
									 for( i=0 ; i<result.cfield.length ; i++){
										 	txt = txt + "<td style='vertical-align:middle; text-align:center;'>&nbsp;"+result.cfield[i].cn+"&nbsp;</td>";
									 }								
									 txt = txt + "<tr/>";
									 $('#calllist-table thead').attr('headerlength', headerlength);
									 $('#calllist-table thead').text('').append(txt); 
									
								    var $table = $('#calllist-table tbody'); 
								    if(page == 1){
								    	$table.find('tr').remove();
									 }
								    
									 var seq = parseInt($('#newlist_page').text());
									 var listlength = result.clist.length;
										 
							
									//popup.list =[]; //clear popup list array length
									
									txt = "";
									var i = 0 , f = 0 , lastfield = headerlength -1;
									 for( i=0 ; i< listlength ; i++){
										 //	popup.list.push( result.clist[i].f0 );  //update popup list array length
										 	seq++;		 
										 	txt += "<tr id='"+result.clist[i].f0+"'><td style='vertical-align:middle; text-align:center' >"+seq+"</td>";
									 		var row = "";
												  for( f=1 ; f< headerlength ; f++){
														var dynvar = eval("result.clist["+i+"].f"+f );
														if( f==1){
															 row+="<td ><a href='#' class='nav-newcall-id'><strong>"+dynvar+"</strong></a></td>";
														}else{
															 row+="<td >&nbsp;"+dynvar+"&nbsp;</td>";
														}
														
												  }
										     txt += row;
										     txt += "</tr>";
									  }
									$table.append(txt);
										
									page = parseInt(page) + 1;
									$('#loadmore_newlist').attr('data-read', page );
										
									 if( i != 0){
										 
												//set total new list on dashboard
												$('#total_diallist').text('').text( result.totalnewlist );
										 
										 		//click nav link
												 $('.nav-newcall-id').click( function(e){
													  e.preventDefault();
													  var listid = $(this).closest('tr').attr('id');
													  $('[name=listid]').val( listid );
											    	   //load popup content
											    	   $.call.loadpopup_content( listid );
												 })
												
												   var $curpage = $('#newlist_page');
												   var $ofpage   = $('#newlist_ofpage');
												   var $loadmorelist = $('#loadmore_newlist');
												   //dynamic footer colspan
													
												   $curpage.closest('td').attr('colspan', headerlength );
												   
													var total = parseInt($curpage.text()) + i;
													$curpage.text('').text( total );
													$ofpage.text('').text( result.totalnewlist );	
												
													if( total == parseInt(result.totalnewlist) ){
														$loadmorelist.hide();
													}else{
														$loadmorelist.show();
													}
									
											}else{
												
												//data not found
												var txt = "<tr  ><td colspan='"+headerlength+"' class='text-center' style='border:1px solid #e2e2e2'><h4 style='font-family:raleway; color:#; font-weight:300;'>&nbsp; <i class='icon-fire' style='color:#8bc34a;'></i> &nbsp; No new calllist found &nbsp;</h4></td></tr>";
												$('#calllist-table thead').append(txt);
												$('#calllist-table tfoot').hide();
											
											}//end if else
										 
							 }   
						});//end ajax 
			
		},
		load_nocontact : function( cmpid ){
			
		 	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
	    	var  page = $('#loadmore_nocontactlist').attr('data-read');
	    	var orderby =$('#nocontact-table').attr('data-order');
	    	
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query_nocontact','cmpid': cmpid , 'data':formtojson , 'page' : page  , 'orderby' : orderby  }, 
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
								    
								    //profile page
									 //campaign profile ( popup profile pane )
			                        /*
									 txt = "";
									 for( i=0 ; i<result.pfield.length ; i++){
										 	txt = txt + "<tr><td style='vertical-align:middle; text-align:right; color:#676a6c;'>&nbsp;"+result.pfield[i].cn+" : </td>"+
										 					 "<td style='vertical-align:middle;'><input type='text' name='"+result.pfield[i].fn+"'  autocomplete='off' style='width:100%'></td><tr/>";
									    } 
									$('#cmpprofile-table tbody').text('').append(txt); 
									*/
			                        
			                        
								    //tab new list 
									//callback system field header
								    var txt = "<tr class='primary'>";
								    	 txt = txt + "<td style='vertical-align:middle; text-align:center; width:5%'>&nbsp; # &nbsp;</td>";
									 for( i=0 ; i<result.cfield.length ; i++){
										 	txt = txt + "<td style='vertical-align:middle; text-align:center'>&nbsp;"+result.cfield[i].cn+"&nbsp;</td>";
									 }								
					
								 //nocontact system field
									txt = txt + '<td style="text-align:center;vertical-align:middle"> Last wrapup  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Detail  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Number of call  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Call date/time <span id="nocontact-orderby"  style="cursor:pointer"></span></td>';
									 txt = txt + "<tr/>";
									
									 $('#nocontact-table thead').text('').append(txt); 
									
								    var $table = $('#nocontact-table tbody'); 
								    if(page == 1){
								    	$table.find('tr').remove();
									 }
								    
								    //setup caret
									if( orderby == "desc" ){
							   			var display = $('#nocontact-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-down");
							   		}else if(  orderby == "asc" ){
							   			var display = $('#nocontact-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-up");
							   		}
								     //add action to carret
								    $('#nocontact-orderby').click( function(e){
								    	e.preventDefault();
								    	var order = $('#nocontact-table')
								    	if( order.attr('data-order') == "desc" ){
								    		order.attr('data-order','asc');
								    	}else if( order.attr('data-order') == "asc"){
								    		order.attr('data-order','desc');
								    	}
								   	//	$.call.load_nocontact( $('[name=cmpid]').val() );
								   		
								   		$('#nocontact-search-btn').trigger('click');
								   		
								    })
								    /*
									 var p = "";
									  p += '<div class="news-dropdown-wrap">'+
									  		   '<ul class="news-dropdown">'+
											   '<li class="edit_news"> <span class="icon-sort-by-attributes" style="font-size:18px;"></span> <span style="font-size:14px; text-indent:8px; display: inline-block; "> ASC </span></li>'+
											   '<li class="remove_news"> <span class="icon-sort-by-attributes-alt" style="font-size:18px;"> </span> &nbsp;<span style="font-size:14px; text-indent:5px; display: inline-block;"> DESC </span></li>'+
											   '</ul></div>';
									  $('#nocontact-orderby').append(p);
									  
								    //add event to order
								    $('#nocontact-orderby').click( function(e){
								    	   //close popup
							        	   $('div.news-dropdown-wrap').removeClass('active') ;
								           e.stopPropagation();
							        
							        	   //hide arrowdown popup
								         	  $('.mypost').hide();
								    	
								    })
								    */
										var seq = parseInt($('#nocontactlist_page').text());
							
										 //sys_dial.list = []; //clear list
										 var x = "";
										 var headerlength = parseInt( result.cfield.length ) + 5; //add seq
										 
										 var listlength = result.cnocontact.length;
										 for( i=0 ; i< listlength ; i++){
											 seq++;
											 
											 //sys_dial.list.push(result.clist[i].f0); //what ?
											 
										     x += "<tr id='"+result.cnocontact[i].f0+"'><td style='vertical-align:middle; text-align:center' >"+seq+"</td>";
										 	var row = "";
													  for( f=1 ; f< headerlength ; f++){
															var dynvar = eval("result.cnocontact["+i+"].f"+f ); 	
															if( f==1){
																 row+="<td ><a href='#' class='nav-nocontact-id'><strong>"+dynvar+"</strong></a></td>";
															}else{
																 row+="<td >&nbsp;"+dynvar+"&nbsp;</td>";
															}
													  }
											     x += row;
											     x += "</tr>";
											  
										  }
										$table.append(x);
										
									  	//arrange column table
										//rearange table
										$table.find('tr td:nth-last-child(2)').addClass('text-center');
										$table.find('tr td:last-child').addClass('text-center');
										
										page = parseInt(page) + 1;
										$('#loadmore_nocontactlist').attr('data-read', page );
											
										 if( i != 0){
											 
												//set total new list on dashboard
												$('#total_nocontact').text('').text(  result.totalnocontact );
										 
										 		//click nav link
												 $('.nav-nocontact-id').click( function(e){
													  e.preventDefault();
													  var listid = $(this).closest('tr').attr('id');
													  $('[name=listid]').val( listid );
											    	   //load popup content
											    	   $.call.loadpopup_content( listid );
												 })
												
												   var $curpage = $('#nocontactlist_page');
												   var $ofpage   = $('#nocontactlist_ofpage');
												   var $loadmorelist = $('#loadmore_nocontactlist');
												   //dynamic footer colspan
													
												   $curpage.closest('td').attr('colspan', headerlength );
												   
													var total = parseInt($curpage.text()) + i;
													$curpage.text('').text( total );
													$ofpage.text('').text( result.totalnocontact );
													
												
													if( total == parseInt(result.totalnocontact) ){
														$loadmorelist.hide();
													}else{
														$loadmorelist.show();
													}
											
									
											}else{
												 
												//data not found
												var txt = "<tr ><td colspan='"+headerlength+"' class='text-center' style='border:1px solid #e2e2e2'><h4 style='font-family:raleway; color:#777; font-weight:300;'>&nbsp; <i class='icon-fire' style='color:#F2B50F'></i> &nbsp; No no contact list found &nbsp;</h4></td></tr>";
												$('#nocontact-table thead').append(txt); 
												$('#nocontact-table tfoot').hide();
												
											}//end if else
										 
							 }   
						});//end ajax 
			
			
		},
		load_callback : function(cmpid){
			
		 	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
	    	var  page = $('#loadmore_callbacklist').attr('data-read');
	    	var orderby =$('#callback-table').attr('data-order');
	    	
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query_callback','cmpid': cmpid , 'data':formtojson , 'page' : page , 'orderby' : orderby   }, 
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
								    
								    //profile page
									 //campaign profile ( popup profile pane )
			                        /*
									 txt = "";
									 for( i=0 ; i<result.pfield.length ; i++){
										 	txt = txt + "<tr><td style='vertical-align:middle; text-align:right; color:#676a6c;'>&nbsp;"+result.pfield[i].cn+" : </td>"+
										 					 "<td style='vertical-align:middle;'><input type='text' name='"+result.pfield[i].fn+"'  autocomplete='off' style='width:100%'></td><tr/>";
									    } 
									$('#cmpprofile-table tbody').text('').append(txt); 
									*/
			                     
									//callback system field header
								    var txt = "<tr class='primary'>";
								    	 txt = txt + "<td style='vertical-align:middle; text-align:center; width:5%'>&nbsp; # &nbsp;</td>";
									 for( i=0 ; i<result.cfield.length ; i++){
										 	txt = txt + "<td style='vertical-align:middle; text-align:center'>&nbsp;"+result.cfield[i].cn+"&nbsp;</td>";
									 }								
					
								 //call back system field
									txt = txt + '<td style="text-align:center;vertical-align:middle"> Last wrapup  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Detail  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Number of call  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Call date/time <span id="callback-orderby" style="cursor:pointer"></span></td>';
									 txt = txt + "<tr/>";
									
									 $('#callback-table thead').text('').append(txt); 
									
								    var $table = $('#callback-table tbody'); 
								    if(page == 1){
								    	$table.find('tr').remove();
									 }
								     
								    //setup caret
									if( orderby == "desc" ){
							   			var display = $('#callback-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-down");
							   		}else if(  orderby == "asc" ){
							   			var display = $('#callback-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-up");
							   		}
									
								     //add action to carret
								    $('#callback-orderby').click( function(e){
								    	e.preventDefault();
								    	var order = $('#callback-table')
								    	if( order.attr('data-order') == "desc" ){
								    		order.attr('data-order','asc');
								    	}else if( order.attr('data-order') == "asc"){
								    		order.attr('data-order','desc');
								    	}
								   
								      	$('#callback-search-btn').trigger('click');
								   		//$.call.load_callback( $('[name=cmpid]').val() );
								    })
								    
								    
										var seq = parseInt($('#callbacklist_page').text());
										
							
										 //sys_dial.list = []; //clear list
										 var x = "";
										 var headerlength = parseInt( result.cfield.length ) + 5; //add seq
										 
										 var listlength = result.cback.length;
										 for( i=0 ; i< listlength ; i++){
											 seq++;
									
										     x += "<tr id='"+result.cback[i].f0+"'><td style='vertical-align:middle; text-align:center' >"+seq+"</td>";
										 	var row = "";
													  for( f=1 ; f< headerlength ; f++){
															var dynvar = eval("result.cback["+i+"].f"+f ); 	
															if( f==1){
																 row+="<td ><a href='#' class='nav-cback-id'><strong>"+dynvar+"</strong></a></td>";
															}else{
																 row+="<td >&nbsp;"+dynvar+"&nbsp;</td>";
															}
													  }
											     x += row;
											     x += "</tr>";
											  
										  }
										$table.append(x);
										
									  	//arrange column table
										//rearange table
										$table.find('tr td:nth-last-child(2)').addClass('text-center');
										$table.find('tr td:last-child').addClass('text-center');
										
										
										page = parseInt(page) + 1;
										$('#loadmore_callbacklist').attr('data-read', page );
											
										 if( i != 0){
											 
												//set total new list on dashboard
												$('#total_callback').text('').text(  result.totalcallback );
										 
										 		//click nav link
												 $('.nav-cback-id').click( function(e){
													  e.preventDefault();
												
													  var listid = $(this).closest('tr').attr('id');
													  $('[name=listid]').val( listid );
											    	   $.call.loadpopup_content( listid );
												 })
												
												   var $curpage = $('#callbacklist_page');
												   var $ofpage   = $('#callbacklist_ofpage');
												   var $loadmorelist = $('#loadmore_callbacklist');
												   //dynamic footer colspan
													
												   $curpage.closest('td').attr('colspan', headerlength );
												   
													var total = parseInt($curpage.text()) + i;
													$curpage.text('').text( total );
													$ofpage.text('').text( result.totalcallback );
													
												
													if( total == parseInt(result.totalcallback) ){
														$loadmorelist.hide();
													}else{
														$loadmorelist.show();
													}
													
											}else{
										
												//data not found
												var txt = "<tr ><td colspan='"+headerlength+"' class='text-center' style='border:1px solid #e2e2e2'><h4 style='font-family:raleway; color:#777; font-weight:300;'>&nbsp; <i class='icon-fire' style='color:#ef6c00'></i> &nbsp; No call back list found &nbsp;</h4></td></tr>";
												$('#callback-table thead').append(txt); 
												$('#callback-table tfoot').hide();
												 
											}//end if else
										 
							 }   
						});//end ajax 
			
		},
		
		
		load_followup: function(cmpid){
		 	var  formtojson =  JSON.stringify( $('form').serializeObject() );  
	    	var  page = $('#loadmore_followuplist').attr('data-read');
	    	var orderby =$('#followup-table').attr('data-order');
	 
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query_followup','cmpid': cmpid , 'data':formtojson , 'page' : page  , 'orderby' : orderby  }, 
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
			               		 	var headerlength = parseInt( result.cfield.length ) + 5; //add system field ( seq ) //get header field length
			               		 
								    //tab new list 
									//followup list dynamic field header
								    var txt = "<tr class='primary'>";
								    	 txt = txt + "<td style='vertical-align:middle; text-align:center; width:5%;'>&nbsp; # &nbsp;</td>";
									 for( i=0 ; i<result.cfield.length ; i++){
										 	txt = txt + "<td style='vertical-align:middle; text-align:center;'>&nbsp;"+result.cfield[i].cn+"&nbsp;</td>";
									 }								
									 //followup system field
									txt = txt + '<td style="text-align:center;vertical-align:middle"> Last wrapup  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Detail  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Number of call  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Call date/time  <span id="followup-orderby" style="cursor:pointer"></span></td>';
									 txt = txt + "<tr/>";
									 
									 $('#followup-table thead').attr('headerlength', headerlength);
									 $('#followup-table thead').text('').append(txt); 
									
								    var $table = $('#followup-table tbody'); 
								    if(page == 1){
								    	$table.find('tr').remove();
									 }
								    
								    //setup caret
									if( orderby == "desc" ){
							   			var display = $('#followup-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-down");
							   		}else if(  orderby == "asc" ){
							   			var display = $('#followup-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-up");
							   		}
								     //add action to carret
								    $('#followup-orderby').click( function(e){
								    	e.preventDefault();
								    	var order = $('#followup-table')
								    	if( order.attr('data-order') == "desc" ){
								    		order.attr('data-order','asc');
								    	}else if( order.attr('data-order') == "asc"){
								    		order.attr('data-order','desc');
								    	}
								    	$('#followup-search-btn').trigger('click');
								   		//$.call.load_followup( $('[name=cmpid]').val() );
								   		
								    })
								    
								    
									 var seq = parseInt($('#followuplist_page').text());
									 var listlength = result.cfollowup.length;
							
									popup.list =[]; //clear popup list array length
									
									txt = "";
									var i = 0 , f = 0 ;
									 for( i=0 ; i< listlength ; i++){
										 	popup.list.push( result.cfollowup[i].f0 );  //update popup list array length
										 	seq++;		 
										 	txt += "<tr id='"+result.cfollowup[i].f0+"'><td style='vertical-align:middle; text-align:center' >"+seq+"</td>";
									 		var row = "";
												  for( f=1 ; f< headerlength ; f++){
														var dynvar = eval("result.cfollowup["+i+"].f"+f ); 	
														if( f==1){
															 row+="<td ><a href='#' class='nav-followup-id'><strong>"+dynvar+"</strong></a></td>";
														}else{
															 row+="<td >&nbsp;"+dynvar+"&nbsp;</td>";
														}
												  }
										     txt += row;
										     txt += "</tr>";
									  }
									$table.append(txt);
									
									//rearange table
									$table.find('tr td:nth-last-child(2)').addClass('text-center');
									$table.find('tr td:last-child').addClass('text-center');
							
										
									page = parseInt(page) + 1;
									$('#loadmore_followuplist').attr('data-read', page );
									
										
									 if( i != 0){
										 
												//set total new list on dashboard
												$('#total_followup').text('').text( result.totalfollowup );
										 
										 		//click nav link
												 $('.nav-followup-id').click( function(e){
													  e.preventDefault();
													  var listid =  $(this).closest('tr').attr('id') 
													  $('[name=listid]').val( listid);
											    	   $.call.loadpopup_content( listid );
												 })
												
												   var $curpage = $('#followuplist_page');
												   var $ofpage   = $('#followuplist_ofpage');
												   var $loadmorelist = $('#loadmore_followuplist');
												   //dynamic footer colspan
													
												   $curpage.closest('td').attr('colspan', headerlength );
												   
													var total = parseInt($curpage.text()) + i;
													$curpage.text('').text( total );
													$ofpage.text('').text( result.totalfollowup );
													
												
													if( total == parseInt(result.totalfollowup) ){
														$loadmorelist.hide();
													}else{
														$loadmorelist.show();
													}
									
											}else{
												
												var txt = "<tr ><td colspan='"+headerlength+"' class='text-center' style='border:1px solid #e2e2e2'><h4 style='font-family:raleway; color:#777; font-weight:300;'>&nbsp; <i class='icon-fire' style='color:#2196f3'></i> &nbsp; No follow up list found &nbsp;</h4></td></tr>";
												$('#followup-table thead').append(txt); 
												$('#followup-table tfoot').hide();
									 
											}//end if else
										 
							 }   
						});//end ajax 
	        
		},
		load_callhistory: function( cmpid ){
			
			var  formtojson =  JSON.stringify( $('form').serializeObject() );  
	    	var  page = $('#loadmore_historylist').attr('data-read');
	      	var orderby =$('#callhistory-table').attr('data-order');
	      	
	        $.ajax({   'url' : url, 
	        	   'data' : { 'action' : 'query_callhistory','cmpid': cmpid , 'data':formtojson , 'page' : page , 'orderby' : orderby  }, 
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
			               		 	var headerlength =  parseInt( result.cfield.length ) + 6; //add system field ( seq ) //get header field length
			               		 
								    //tab new list 
									//new list dynamic field header
								    var txt = "<tr class='primary'>";
								    	 txt = txt + "<td style='vertical-align:middle; text-align:center; width:5%;'>&nbsp; # &nbsp;</td>";
								    	 txt = txt + "<td style='text-align:center;vertical-align:middle'> Call Date/Time <span id='callhistory-orderby' style='cursor:pointer'></td>";
									 for( i=0 ; i<result.cfield.length ; i++){
										 	txt = txt + "<td style='vertical-align:middle; text-align:center;'>&nbsp;"+result.cfield[i].cn+"&nbsp;</td>";
									 }								
									 //callhistory system field
									txt = txt + '<td style="text-align:center;vertical-align:middle"> Last Wrapup  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Detail  </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Call Duration </td>'+
						  							 '<td style="text-align:center;vertical-align:middle"> Call Type </td>';
						  						
									 txt = txt + "<tr/>";
									 
									 $('#callhistory-table thead').attr('headerlength', headerlength);
									 $('#callhistory-table thead').text('').append(txt); 
									
								    var $table = $('#callhistory-table tbody'); 
								    if(page == 1){
								    	$table.find('tr').remove();
									 }
								    

								    //setup caret
									if( orderby == "desc" ){
							   			var display = $('#callhistory-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-down");
							   		}else if(  orderby == "asc" ){
							   			var display = $('#callhistory-orderby');
							   			display.removeAttr('class');
							   			display.addClass("icon-caret-up");
							   		}
								     //add action to carret
								    $('#callhistory-orderby').click( function(e){
								    	e.preventDefault();
								    	var order = $('#callhistory-table')
								    	if( order.attr('data-order') == "desc" ){
								    		order.attr('data-order','asc');
								    	}else if( order.attr('data-order') == "asc"){
								    		order.attr('data-order','desc');
								    	}
								    	$('#callhistory-search-btn').trigger('click');
								   
								   		
								    })
								    
									 var seq = parseInt($('#historylist_page').text());
									 var listlength = result.chistory.length;
							
									//popup.list =[]; //clear popup list array length
									
									txt = "";
									var i = 0 , f = 0 ;
									 for( i  ; i< listlength ; i++){
										 
										 
										 	//popup.list.push( result.chistory[i].f0 );  //update popup list array length
										 	seq++;		 
										 	txt += "<tr call_transid='"+result.chistory[i].f0+"'>"+
										 			   "<td style='vertical-align:middle; text-align:center' >"+seq+"</td>"+
										 			   "<td style='vertical-align:middle; text-align:center' >"+result.chistory[i].credt+"</td>";
										 	
									 		var row = "";
												  for( f=1 ; f< headerlength ; f++){
														var dynvar = eval("result.chistory["+i+"].f"+f ); 	
														if( f==1){
															 row+="<td ><a href='#' class='nav-callhistory-id'><strong>"+dynvar+"</strong></a></td>";
														}else{
															if(dynvar!=undefined ){
																 row+="<td >&nbsp;"+dynvar+"&nbsp;</td>";
															}
														}
												  }
										     txt += row;
										     txt += "</tr>";
									  }
									$table.append(txt);
									//rearange table
									$table.find('tr td:nth-last-child(2)').addClass('text-center');
									$table.find('tr td:last-child').addClass('text-center');
									
								
							
										
									page = parseInt(page) + 1;
									$('#loadmore_historylist').attr('data-read', page );
									
				
										
									 if( i != 0){
										 
												//set total new list on dashboard
												$('#total_callhistory').text('').text( result.totalhistory );
										 
										 		//click nav link
												/*
												 $('.nav-callhistory-id').click( function(e){
													  e.preventDefault();
													  $('[name=listid]').val( $(this).closest('tr').attr('id') );
											    	   //load popup content
											    	   $.call.loadpopup_content();
												 })
												*/
												   var $curpage = $('#historylist_page');
												   var $ofpage   = $('#historylist_ofpage');
												   var $loadmorelist = $('#loadmore_historylist');
												   //dynamic footer colspan
													
												   $curpage.closest('td').attr('colspan', headerlength );
												   
													var total = parseInt($curpage.text()) + i;
													$curpage.text('').text( total );
													$ofpage.text('').text( result.totalhistory );
													
												
													if( total == parseInt(result.totalhistory) ){
														$loadmorelist.hide();
													}else{
														$loadmorelist.show();
													}
									
											}else{
												
												//data not found
												var txt = "<tr  ><td colspan='"+headerlength+"' class='text-center' style='border:1px solid #e2e2e2'><h4 style='font-family:raleway; color:#; font-weight:300;'>&nbsp; <i class='icon-fire' style='color:#212c21;'></i> &nbsp; No call history found &nbsp;</h4></td></tr>";
												$('#callhistory-table thead').append(txt);
												$('#callhistory-table tfoot').hide();
												
										    
											}//end if else
										 
							 }   
						});//end ajax 
			
		},
		gridSet:function($row){
	
				  $row 
					.hover( function(){
						 $row.addClass('row-hover');
					}, function() {
					    $row.removeClass('row-hover');
			        })
			        .click( function(){
			        	
			        	//  $('[name=lid]').val( $row.attr('id') );	
			        	   $('#calllist-table tr.selected-row').removeClass('selected-row');
			        	   $row.addClass('selected-row');
			        	
			        })			        
			        .dblclick( function(e){
			        	
			  	      
			        	 $('.nav-call-id').trigger('click');
			        	//$.callList.detail( $row.attr('id') );
				    	 
				      	 //$('#calllist-main-pane').hide();
				    	 //$('#calllist-detail-pane').show();				 
				  
				    })
				  
			  },
			  cmplogoff:function(){
				  
		
				 	//animate select campaign
				 	$('#smartpanel').slideUp('slow' , function(){
				 		$('#smartpanel-detail').html('<i class="icon-fire"></i><span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">Tubtim </span>');								 	
				 		$('#smartpanel').slideDown('slow');
				 	});
				 	
				 	$('#page-subtitle').text('Call Work');
				 	

			 	    $('#callcampaign-pane').load('callcampaign-pane.php' , function(){
						$(this).fadeIn('slow');
					});
					
			 	   $('#callwork-pane').hide();
					//delete to cookie
					$.removeCookie('cur-cmp', { path: '/' });
				
					
			  },
			  initWrapup : function(){
				  
				   $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'initwrapup' }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
						   //set image loading for waiting request
						   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
						},										
						'success' : function(data){ 
									
										
				                      var  result =  eval('(' + data + ')'); 
				                      
				                    
				                      var txt =  "<li id=''><a href='#'>&nbsp;</a></li>";
				                      for( i=0 ; i<result.length ; i++){
				                    	   txt = txt+"<li id='"+result[i].wcode+"'><a href='#'>"+result[i].wdtl+"</a></li>";
				                      }
				                      $('#wrapup1').html(txt);
				                      
				                      $('#wrapup1 > li').click( function(e){
					          			 e.preventDefault();
				          				 e.stopPropagation();
				          				 
				          				 $('#wrapup2').prev().html('&nbsp;');
		          		    	    	 $('#wrapup3').prev().html('&nbsp;');
				          			 
				          				  var self = $(this);
				          				  $('.wrapper-dropdown-5').removeClass('active');

				          					
				          					self.closest('ul').parent().removeClass('active');
				          					self.closest('ul').prev().text( $(this).text()   );
				          			
				          			  	  //set to hidden value
				          		    	    $('[name=wrapup1]').val(self.attr('id'))
				          		    	    if( self.attr('id') != "" ){
				          		    	    	$.call.queryWrapup(2,self.attr('id'));
				          		    	    }
				          		    	    
				          		    	    
				                      });
				                      
				                      /*
				                     var opt = "<option value=''></option>";
				                   	 for( i=0 ; i<result.length ; i++){
				                   		opt = opt + "<option value='"+result[i].wcode+"'>"+result[i].wdtl+"</option>";
				                   	 }
				                    
				                        $('[name=wrapup1]').html( opt );
				                     
										//wrapup change
										$('[name=wrapup1]').change( function(){
											   $('[name=wrapup2]').html("");
											   $('[name=wrapup3]').html("");
											   var val = $(this).val();
												$.call.queryWrapup(2,val )
										});
										  */  
						}//end success
						
				   })//end ajax
				  
			  },
			  queryWrapup : function( lv , wrapupcode ){
				  
				  $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'querywrapup','wrapupcode' : wrapupcode }, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
						   //set image loading for waiting request
						   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
						},										
						'success' : function(data){ 
									
										
							  var  result =  eval('(' + data + ')'); 
								
							  
							    var txt =  "<li id=''><a href='#'>&nbsp;</a></li>";
			                      for( i=0 ; i<result.length ; i++){
			                    	   txt = txt+"<li id='"+result[i].wcode+"'><a href='#'>"+result[i].wdtl+"</a></li>";
			                      }
			                  
			                    if(lv === 2){
			            
			                        $('#wrapup2').html(txt);
			                    	$('#wrapup3').prev().html('&nbsp;');
			                        
			                        //set wrapup lv2 action
			                        $('#wrapup2 > li').click( function(e){
						          			 e.preventDefault();
					          				 e.stopPropagation();
					          				 //clear lv3
					          			   $('#wrapup3').prev().html('&nbsp;');
					          				 var self = $(this);
				          					$('.wrapper-dropdown-5').removeClass('active');
	
				          					self.closest('ul').parent().removeClass('active');
				          					self.closest('ul').prev().text( $(this).text());
				          		    	   
				          		    	    //set to hidden value
				          		    	    $('[name=wrapup2]').val(self.attr('id'))
				          		    	    if( self.attr('id') != "" ){
				          		    	    	$.call.queryWrapup(3,self.attr('id'));
				          		    	    }
				                    });//end function click
			                    }//end if lv==2
							  
							  if(lv === 3){
								  //set wrapup lv3 data
			                        $('#wrapup3').html(txt);
			                        //set wrapup lv2 action
			                        $('#wrapup3 > li').click( function(e){
						          			 e.preventDefault();
					          				 e.stopPropagation();
					          				 var self = $(this);
				          					$('.wrapper-dropdown-5').removeClass('active');
				          					self.closest('ul').parent().removeClass('active');
				          					self.closest('ul').prev().text( $(this).text());
				          					
				          			  	    //set to hidden value
				          		    	    $('[name=wrapup3]').val(self.attr('id'))
				          					
				                    });//end function click
								  
							  }//end if lv3
							  
						}//end success
				   })//end ajax
				   
				  
			  },
			  saveWrapup : function(){
				 // console.log("save wrapup");
				  
				  //check is wrapup is empty 
				  if( $('[name=wrapup1]').val() == "" || $('[name=wrapup2]').val() == ""  || $('[name=wrapup3]').val() == "" ){
					  		$('#wrapup-require').fadeOut('fast' , function(){						    		   
					  				$(this).fadeIn('slow');
				    	   })
				    	   return;
				  }else{
						$('#wrapup-require').fadeOut('fast');
				  }
					
				  var impid = $('#cmpprofile-table thead > tr').attr('data-lead');
						  
				  var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post(url , { "action" : "savewrapup" , "data": formtojson , "uniq" : uniqueid , "impid" : impid }, function( result ){
					       var response = eval('('+result+')');  
						    if(response.result=="success"){
						    	
				  
						    	   //remember last called id 
						    		var sys = $('#page-subtitle').attr('data-page');
						    		var currentrow = 0;	 
						    		var totalrow = 0
								  
						    		/*
									 if( sys=="diallist"){
											sys_dial.called.push( sys_dial.list[sys_dial.current-1] )
											currentrow = sys_dial.current;
											totalrow =  sys_dial.list.length;
											
									 }else if( sys=="callback"){ 
											sys_callback.called.push( sys_callback.list[sys_callback.current-1])
											currentrow = sys_callback.current;
											totalrow =  sys_callback.list.length;
											
									 }else if(sys=="followup"){
											sys_follow.called.push( sys_follow.list[sys_follow.current-1])
											currentrow = sys_follow.current;
											totalrow =  sys_follow.list.length;
											
									 }else if(sys=="callhistory"){
											sys_hist.called.push( sys_hist.list[sys_hist.current-1])
											currentrow = sys_hist.current;
											totalrow =  sys_hist.list.length;
									 }
						    		 */
						    	  //show link to reminder
							 //  $('#reminder-link').fadeIn('slow');
						    	   
						    	   //show wrapup save msg & set attr data-status to saved ( for check with hangup )
							   /*
						    	   $('#wrapup-msg').fadeOut('fast' , function(){
						    		  $(this).fadeIn('slow');
						    	   }).attr('data-status','saved')
						    	   
						    	   
						    	   
						    	   
						    	   //display phone status on header
						    	   //check if agent is on call do nothing 
						    	   if( $('#makecall').attr('data-status') != "active" ){
						    		  // console.log("make call not active");
						    		   $('#phone-status').fadeOut('slow', function(){ 
										    $(this).text('Wrapup saved...') 
							    		   	$(this).fadeIn('fast');
							    	   });						    		 
						    		   
						    		   //show left right call list ( delay 3 sec )
						    		   setTimeout(function(){
											//visible left right arrow 
						    			   
										//  if( currentrow == 1  ){
										//		$('#turn-left').css('visibility','hidden'); 
										 //  }else{
										//	   $('#turn-left').css('visibility','visible'); 
										 //  }
										 // if( currentrow >= totalrow  ){
										 //		$('#turn-right').css('visibility','hidden'); 
										 //  }else{
										//	   $('#turn-right').css('visibility','visible'); 
										 //  }
										 
											//show close button
											$('#popup-close').css('visibility','visible');
										 
									 }, 300);
						    		   
						    		   
						    	   }else{
						    		   //animate show wrapup saved and return to on call
						    		   var msg = $('#phone-status').text();
						    		   $('#phone-status').fadeOut('slow', function(){ 
										    $(this).text('Wrapup saved...') 
							    		   	$(this).fadeIn('slow', function(){
							    		   		
							    		   			$('#phone-status').fadeOut('slow', function(){ 
							    		   				$(this).text( msg );
							    		   				$(this).fadeIn('fast');
							    		   			});
							    		   			
							    		   	});
							    	   });
						    		   
						    	   }
						    	   */
								
						           //animate show wrapup saved and return to on call
					    		   var msg = $('#phone-status').text();
					    		   $('#phone-status').fadeOut('slow', function(){ 
									$(this).text('Wrapup saved...') 
						    		   	$(this).fadeIn('slow', function(){
						    		   		
						    		   			$('#phone-status').fadeOut('slow', function(){ 
						    		   				$(this).text( msg );
						    		   				$(this).fadeIn('fast');
						    		   			});
						    		   			
						    		   	});
						    	   });
					    		   
					    			//show close button
									$('#popup-close').css('visibility','visible');
									$('#popup-close').trigger('click')
						    	   
						    	   //set wrapup id for update
						    	   //$('[name=wrapupid]').val()
						    	   
						    	   
						    	   $.call.load( $('[name=cmpid]').val() );
						    	     
						    	
									  
									
						    }
				  });
				  
			  },
			  clearWrapup: function(){
				    //clear hidden value
				    $('[name=wrapup1],[name=wrapup2],[name=wrapup3]').val("");  
					$('#wrapup1').prev().html('&nbsp;');
					$('#wrapup2').prev().html('&nbsp;');
					$('#wrapup3').prev().html('&nbsp;');
					$('[name=wrapupdtl]').val("");
					
				  //clear global parameter 
				   channelid = "";
				   uniqueid = "";
				   callsts = "";
				  
			  },
			 loadpopup_content : function( listid ){ 
				  $.call.clearWrapup();
				  if( listid == "" ){
					  alert( "calllist id is empty ");
					  return;
				  }
				  
				
				  /*
				  if( $('[name=listid]').val() == "" ){
					  console.log( "calllist id is empty ");
					  alert( "calllist id is empty ");
					  return;
				  }
				  */
				  
				  /*
				  console.log("check call popup from system ?");
				  console.log("check current length popup list "+popup.list.length );
				  console.log("check all popup length ")
				  */
				  
				 // console.log( "calllist id : "+ $('[name=listid]').val() );
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				  $.ajax({   'url' : url, 
		        	   'data' : { 'action' : 'loadpopup_content' , 'data' : formtojson , 'listid' : listid}, 
					   'dataType' : 'html',   
					   'type' : 'POST' ,  
					   'beforeSend': function(){
						   //set image loading for waiting request
						   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
						},										
						'success' : function(data){ 
									
							//clear current popup
							//check this is called list
							
				                      var  result =  eval('(' + data + ')');			
				                      
				                      //call script url
				                      $('#open-callscriptfull').attr('data-script', result.script );
				                      
				                 
				               //call external app
				                      if( result.exapp.length != undefined ){
				                    	   	  var ul = $('#campaign-exapp');
						                      var callid = $('[name=listid]').val();
						                      var aid = $('[name=uid]').val();
						                      var imid = result.impid.id;
						                      var cmpid = $('[name=cmpid]').val();
						                      var txt = "";
						                      for( i=0 ; i< result.exapp.length  ; i++){
						                		  
						                		    txt += '<li style="width:100px; text-align:center; border-radius:8px; color:#666; cursor:pointer; padding:2px 5px 2px 5px; margin:2px;" >'+
								                      				'<span class="'+result.exapp[i].appi+'" style="font-size:26px; "></span> '+
									 					 			'<a href="'+result.exapp[i].appu+'?campaign_id='+cmpid+'&calllist_id='+callid+'&agent_id='+aid+'&import_id='+imid+'" target="_blank" style="font-size:12px; display:block;  color:#666;">'+result.exapp[i].appn+'</a>'+
									 					 		'</li>';
						                	  }
						                	  ul.append( txt )
				                        
				                      }
				             
				                      
				                      //show list name for this calllist
				                      /*
				                      var $thead = $('#cmpprofile-table thead');
				                      $thead.find('tr').remove();
				                      $thead.append('<tr data-lead="'+result.imp.impid+'"><td colspan="2" style="text-align:right; font-size:12px; color:#999; font-style:italic;"> Lead Source : '+result.imp.impname+'</td></tr>');
				                      */
				                      
				                      
				                      //phone popup
				                      var cp = $('#calllistphone');
				                      cp.find('li').remove();
				                      var def = true; //set first number to default value 
				                      var size = result.calllist.length;
			                    	  for( i=0 ; i<size ; i++){
			                    		 
			                    		 		var tmp = result.calllist[i].key.split("|");
			                    		 
					                    		// console.log( tmp[0]  );
			                    		 		
			                    		 		//  console.log( tmp[0] );
		                    		 			 // console.log( result[i].value );
			                    		 		 
			                    		 		  if(tmp[0]=="phone"){
			                    		 			  var val = result.calllist[i].value;
			                    		 			  var self = val;
			                    		 
			                    		 			  if(tmp[2]!=""){
			                    		 				 //val = tmp[2];
			                    		 				 val =   mask( result.calllist[i].value , tmp[2] );
			                    		 			  }
			                    		 			
			                    		 			  //setup value to campaign
			                    		 			  $('[name='+tmp[1]+']').val( val );
			                    		 		
			                    		 			  //console.log( i+"|"+tmp[1]);
			                    		 			  //set popup phone
			                    		 			  if(def){
			                    		 				  def = false;
			                    		 			      cp.append("<li  style='cursor:pointer' data-id='"+self+"' class='active-number' >"+ val+"</li>");
			                    		 			  }else{
			                    		 				   cp.append("<li  style='cursor:pointer' data-id='"+self+"' >"+ val +"</li>");
			                    		 			  }
			                    		 			   
			                    		 		  }else 
			                    		 		  if( tmp[0]=="status"){
			                    		 		
			                    		 			  if(tmp[0] == "status" && result.calllist[i].value =="3"){
					                    	    		  $('#calllistmsg').text('').text('Do NOT Call list');
					                    	    	  }else{
					                    	    		  $('#calllistmsg').text('');
					                    	    	  }
			                    		 			  
			                    		 		  }else{
			                    		 		
			                    		 			  $('[name='+tmp[1]+']').val( result.calllist[i].value )
			                    		 			  
			                    		 		  }
			                    		 		  
					                    
							                   	//	opt = opt + "<option value='"+result[i].wcode+"'>"+result[i].wdtl+"</option>";
					                   	 }//end loop for
			                    	  
			                    	/*
			                    	  $('#lastwrapup_dt').text('').text('This call list last recently wrapup on '+result.wrapuphist.lastwrapupdt);
			                    	  $('#lastreminderdt').text('').text('!! Reminder call back on '+result.wrapuphist.lastreminderdt);
			                    	  */
			                    	  
			                    	  //show recently call & reminder on sub top of header
			                    	  //console.log(result.wrapuphist.result );
			                    	  if( result.wrapuphist.result != undefined ){
			                           	  $('#lastwrapup_dt').text('');
					                  }else{
						               	  $('#popup-recently-calls').show();
			                    		  $('#lastwrapup_dt').text('').html('This call list last recently wrapup on <span style="color:#999"> '+result.wrapuphist.lastwrapupdt_th+' </span><span style="color:#999; font-style: italic;"> - '+  $.timeago(result.wrapuphist.lastwrapupdt)  +'</span>' );
					                 }
			                    	  
			                    	  $('#lastreminder_dt').text('').html('This call list set reminder on '+result.wrapuphist.lastreminderdt_th+' <span style="color:#999; font-style: italic;">'+  $.timeago('2014-10-29 18:08:18')  +'</span>' );

			                    	  
			                    	  //popup call  history 
			                    	    var $table = $('#popup_history-table tbody'); 
										$table.find('tr').remove();
										var size = result.listhist.length;
										var seq = 0;
										 for( i=0 ; i< size ; i++){
										      seq++;
											   $row = $("<tr id='"+result.listhist[i].cid+"'><td style='vertical-align:middle; text-align:right' >"+seq+"</td>"+
										    		   "<td class='text-center' style='font-size:12px;'>"+result.listhist[i].cred+"</td>"+		
/*
										    		   "<td class='text-center' style='font-size:12px;'>"+result.listhist[i].disp+"</td>"+

										    		   "<td class='text-center' style='font-size:12px;'>"+result.listhist[i].bill+"</td>"+
*/
												  "<td  style='font-size:12px;'>"+result.listhist[i].wup+"</td>"+
										    		   "<td  style='font-size:12px;'>"+result.listhist[i].note+"</td></tr>");	 
												  $row.appendTo($table);
											 
											 }
										 
										  if(i==0){   
											     $row = $("<tr id='nodata'><td colspan='6' class='text-center'>&nbsp; No Call History Record &nbsp;</td></tr>")
											     $row.appendTo($table);
											}else{
												$table = $('#popup_history-table tfoot'); 
												$table.find('tr').remove();
												var s = "s";
												if(i<1){	s = "";	}
											    $addRow = $("<tr ><td colspan='6'  style='border-top: 1px solid #EAEAEA' ><small> Total <span style='color:blue'>"+i+"</span> record"+s+" </small></td></tr>");
												$addRow.appendTo($table);

												$('#call-history_popup_total_calls').text(i)
												
												  //highlight row table when click     
												 $('#callhistory-table tbody').on('click','tr',function(){
													   $('#callhistory-table tr.selected-row').removeClass('selected-row')
													   $(this).addClass('selected-row');
												 });
												
											}
									 //end popup call  history
			                    	  
							
			                    	 //add event action to list phone number 
			                    	 $('#calllistphone li').on( 'click' , function(){
			                    	     $('#calllistphone li.active-number').removeClass('active-number');
			                    	     $(this).addClass('active-number');
			                    	     
			                    	 }).on( 'dblclick' ,  function(){
			                    		 $('#makecall').trigger('click');
			                    	 })
			                    	 
			                    
			                    	 
			                    	 //show history call
			                    	 
			                    	 /*
				                     var opt = "<option value=''></option>";
				                
				                        
				                        $('[name=wrapup1]').html( opt );
				                        
										//wrapup change
										$('[name=wrapup1]').change( function(){
											   $('[name=wrapup2]').html("");
											   $('[name=wrapup3]').html("");
											   var val = $(this).val();
												$.call.queryWrapup(2,val )
										});
										*/
			                    	 
			                    	 
						}//end success
						
				   })//end ajax
				   
				   
				   //clear global parameter; 
				   channelid = "";
				   uniqueid = "";
				   
 				    //clear current wrapup  status saved
				   $('#wrapup-msg').removeAttr('data-status');
				   
				   $('#phone-status').text('Ready to call...');  //show ready to call status on header
				   $('#wrapup-msg').hide();  // hide wrapup save msg				   
				   $('#reminder-msg').hide();  // hide reminder save msg
				   
				   //action reset popupcall vertical menu				
				   $('#popup-menu li').removeClass('active');
				   $('#popup-menu li:first').addClass('active');
				 
				   //show call popup-box
				   $('#call-box').show();
					$('#wrapup-box').hide();
					$('#history-box').hide();
					$('#reminder-box').hide();

					$('#panel-wrapup-header').hide();
					$('#panel-history-header').hide();
					$('#panel-popup-header').show();
					$('#panel-reminder-header').hide();
					  
					//action check recently called 
					$.call.show_recently_called();
					
				   //action check recently called
					/*
				   var sys = $('#page-subtitle').attr('data-page');
					var current = 0;
					var id = 0;
					var max = 0;
					 if( sys=="diallist"){
						 //check is called
						 id = sys_dial.list[sys_dial.current - 1];
						 if(  sys_dial.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if( sys=="callback"){ 
						//check is called
						 id = sys_callback.list[sys_callback.current -1];
						 if(  sys_callback.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if(sys=="followup"){
						//check is called
						 id = sys_follow.list[sys_follow.current -1];
						 if(  sys_follow.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if(sys=="callhistory"){
						 //check is called
						 id = sys_hist.list[sys_hist.current -1];					
						 if(  sys_hist.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
					 }
					 //end check recently called
				   */
				    //action before load content
					 $('#popup').fadeIn('fast',function(){
						  // window.scrollTo(0, 0);
						   $(this).css({'height':(($(document).height()))+'px'});
						   $("html, body").animate({ scrollTop: 0 }, "fast");
					});
			  		
		    		$('#popup-close').click( function(){
						$('#popup').fadeOut('slow');
						
						
						//reload window
				    	location.reload();
						
						//clear all value;
						//sys_dial.list = []; 
					//	sys_dial.current = 0;
						sys_dial.called = [];
						
						//sys_callback.list = [];
						//sys_callback.current = 0;
						//sys_callback.called = [];
						
						//sys_follow.list = [];
						//sys_follow.current = 0;
						//sys_follow.called = [];
						
						//sys_hist.list = [];
						//sys_hist.current = 0;
						//sys_hist.called = [];
						
					});
					
				  
			  },
			  makeCall:function( call , callnumber ){
				  
		
				   if( callsts != ""  ){  return;  }else{ callsts = "oncall" }
				    
				   //socket test
				   /*
				      socket  = io.connect('http://192.168.0.101:8888');	
				      socket.on('connect', function(){
				                     console.log("client connected");
				                    // $('#chat').show();
				                     //socket.emit('uregist', 'a'  , 'test' );
				
				                     //send register msg
				                     var uid = jQuery('[name=uid]').val();
				                     var uext = jQuery('[name=uext]').val();
				                     socket.emit('ureg', { 'uid' : uid , 'ext' : uext });
									 socket.on('ureg', function( data ){
									var msg =  "agent id ["+data.uid+"] on extension ["+data.ext+"] register : "+data.msg+"<br/>"; 

											// jQuery('#msg').append(msg)
									 
											console.log( data.msg );
									});
									//recieved hangup msg 
									socket.on('hangup', function(data){
											console.log( data.msg );
											 jQuery('#msg').append(data.msg)
											 if( data.action == "hangup"){
													jQuery('#msg').append("Hangup....<br/>");

													jQuery('#hangup').fadeOut('fast', function(){
														jQuery('#makecall').fadeIn('fast');
													});
											}
									});
									 
									 
				      });
				     //end socket
				    */
				   
				   //clear current wrapup saved status 
				   $('#wrapup-msg').removeAttr('data-status');
				    
				   //action can't do when make call
					$('#turn-right').css('visibility','hidden'); 
					$('#turn-left').css('visibility','hidden'); 
					
					//hide close button
					$('#popup-close').css('visibility','hidden');
					
					//display animate on popup header
					//real
		
					
					$('#phone-status').text('Make Call... '+callnumber).addClass('blink');
				    
					
						  var uid = $('[name=uid]').val();
				 		  var src = $('[name=uext]').val();
					      $.post('sys_ami.php',{"action":"makecall","src": src ,"dst": call ,"uid": uid },function(data){
					
					    	var result =  eval('(' + data + ')'); 		
					    	
					    	if(result.status == 'x' ){
					    		alert("WARNNING !!  your phone is : "+result.statusdtl);
					    	
					    			//set animate to initial 
					    		   $('#phone-status').fadeOut('slow', function(){ 
									   $(this).text('Ready to call...') 
						    		   	$(this).fadeIn('fast');
						    	   }).removeClass('blink');
					    		return ;
					    	}
					    	
							//global uniqueid
				    		 channel = result.channel;    //set channel id for hangup
				    		 uniqueid = result.uniqueid;  //set unique id for link with telephony system 
					 			
				    		 //console.log( "ast ami channel : "+channel );
				    		 //console.log( "ast ami uniqueid : "+uniqueid)
					    	
				    		 
					    	  $('#phone-status').fadeOut('slow', function(){ 
								    $(this).text('On Call... '+callnumber); 
					    		   	$(this).fadeIn('fast');
					    	  })
							   
							   	//change button to hangup
								//can change after recieved hangup channel
								  $('#makecall').fadeOut( 'medium' , function(){
									  $('#hangup').fadeIn('fast');
								  });
							   
								//show wrapup when click make call delay after chang button
					    	   //recieved channel then show wrapup
							    setTimeout(function(){
									$('.panel-heading,#wrapup-box,#wrapup-click').addClass('fadeInUp');
									$('#wrapup-click').trigger('click');
					    		},1000);
					    
							
			 		 
					    		//remove class blink ( as shown on header )
					    	   $('#phone-status').removeClass('blink');
					    		 
				    })//end post
				
				
			
					// test no asterisk
				/*
			 		 var max = 1000;
			 		var min = 3000;
			 		 var random_unique_id = Math.floor(Math.random() * (max - min + 1)) + min;
			 		 
			 		 
			 		var max = 4000;
				 	var min = 2000;
				   var rand = Math.floor(Math.random() * (max - min + 1)) + min;
			 		$('#phone-status').text('Make Call... '+callnumber).addClass('blink');
					 setTimeout(function(){
						 
							//action change button makecall to hangup
						  $('#phone-status').fadeOut('slow', function(){ 
							    $(this).text('On Call... '+callnumber); 
				    		   	$(this).fadeIn('fast');
				    	   })
							//show wrapup when click make call
				    	   //recieved channel then show wrapup
				    		$('.panel-heading,#wrapup-box,#wrapup-click').addClass('fadeInUp');
				    		$('#wrapup-click').trigger('click');
				    		
				    		//global uniqueid
				    		 channel = "";    //set channel id for hangup
				    		 uniqueid = random_unique_id;  //set unique id for link with telephony system 
				    		
						   	//change button to hangup
							//can change after recieved hangup channel
							  $('#makecall').fadeOut( 'medium' , function(){
								  $('#hangup').fadeIn('fast');
							  });
							   
				    	   
				    		//remove class blink ( as shown on header )
				    	   $('#phone-status').removeClass('blink');
					 
					 }, rand );
				 */
					//end test
					 
			  },
			  hangupCall : function(){

					var uid = $('[name=uid]').val();
					
					//hangup test
					/*
				    callsts = "";
					  
		        	//display phone status on header
					   $('#phone-status').fadeOut('slow', function(){ 
						   $(this).text('Hangup...') 
			    		   	$(this).fadeIn('fast');
			    	   });
		    		
					 //if hangup not return success , button not change to make call 
		        	//change hangup button to make call button
		        	 $('#hangup').fadeOut('medium' , function(){
						  $('#calllistphone').fadeIn('fast');
						  $('#makecall').fadeIn('fast' , function(){ });
					  });
					  */
					//end hangup test
					
		        	 
					$.post('sys_ami.php',{"action":"hangup","channel":channel ,"uid": uid },function(data){
					        var result = eval('('+data+')');	
						
					        if(result.data=="Success"){
					    
								//console.log("success"+result.data);
							   //set global status to empty ( ava for next retry call );
							    callsts = "";
				  
					        	//display phone status on header
								   $('#phone-status').fadeOut('slow', function(){ 
									   $(this).text('Hangup...') 
						    		   	$(this).fadeIn('fast');
						    	   });
					    		
								 //if hangup not return success , button not change to make call 
					        	//change hangup button to make call button
					        	 $('#hangup').fadeOut('medium' , function(){
									  $('#calllistphone').fadeIn('fast');
									  $('#makecall').fadeIn('fast' , function(){ });
								  });
					        	
					        	 
					        }//end if
				       });
				
					
					//remove wrapup action
		    		//$('.panel-heading,#wrapup-box,#wrapup-click').removeClass('fadeInUp');
		        	// console.log( $('#wrapup-msg').attr('data-status') );
				  //check is wrapup already save
				  if( $('#wrapup-msg').attr('data-status') == "saved" ){
					  
					  //remember last called id 
			    		var sys = $('#page-subtitle').attr('data-page');
			    		var currentrow = 0;	 
			    		var totalrow = 0
					  
						 if( sys=="diallist"){
								sys_dial.called.push( sys_dial.list[sys_dial.current-1] )
								currentrow = sys_dial.current;
								totalrow =  sys_dial.list.length;
								
						 }else if( sys=="callback"){ 
								sys_callback.called.push( sys_callback.list[sys_callback.current-1])
								currentrow = sys_callback.current;
								totalrow =  sys_callback.list.length;
								
						 }else if(sys=="followup"){
								sys_follow.called.push( sys_follow.list[sys_follow.current-1])
								currentrow = sys_follow.current;
								totalrow =  sys_follow.list.length;
								
						 }else if(sys=="callhistory"){
								sys_hist.called.push( sys_hist.list[sys_hist.current-1])
								currentrow = sys_hist.current;
								totalrow =  sys_hist.list.length;
						 }
			    		 
					   //show left right call list ( delay 3 sec )
		    		   setTimeout(function(){
							//visible left right arrow 
						  if( currentrow == 1  ){
								$('#turn-left').css('visibility','hidden'); 
						   }else{
							   $('#turn-left').css('visibility','visible'); 
						   }
						  if( currentrow >= totalrow  ){
								$('#turn-right').css('visibility','hidden'); 
						   }else{
							   $('#turn-right').css('visibility','visible'); 
						   }
						 
							//show close button
							$('#popup-close').css('visibility','visible');
						 
					 }, 300);
		    		   
					  
				  }
				  
			  },
			  show_recently_called : function(){
				  
				   var sys = $('#page-subtitle').attr('data-page');
				   var current = 0;
					var id = 0;
					var max = 0;
					
					
					//test
					//  console.log( "on system : "+sys);
					 if( sys=="diallist"){
						 //check is diallist
						 id = sys_dial.list[sys_dial.current - 1];
						 if(  sys_dial.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 //test
						// console.log( "current list "+sys_dial.current );
						 
					 }else if( sys=="callback"){ 
						//check is callback
						 id = sys_callback.list[sys_callback.current -1];
						 if(  sys_callback.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if(sys=="followup"){
						//check is followup
						 id = sys_follow.list[sys_follow.current -1];
						 if(  sys_follow.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if(sys=="callhistory"){
						 //check is callhistory
						 id = sys_hist.list[sys_hist.current -1];					
						 if(  sys_hist.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
					 }
					 
			
				  
				  
			  },
			  nextlist: function(){
				
				 //remove wrapup action
		    	$('.panel-heading,#wrapup-box,#wrapup-click').removeClass('fadeInUp');
		    		
				//get system
				var sys = $('#page-subtitle').attr('data-page');
				var current = 0;
				var id = 0;
				var max = 0;
				 if( sys=="diallist"){
					 sys_dial.current++;
					 current = sys_dial.current;
					 id = sys_dial.list[sys_dial.current - 1];
					 max = sys_dial.list.length;
					 //check is called
					 if(  sys_dial.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 } 
					 
				 }else if( sys=="callback"){ 
					 sys_callback.current++;
					 current = sys_callback.current;
					 id = sys_callback.list[sys_callback.current -1];
					 max = sys_callback.list.length;
					 //check is called
					 if(  sys_callback.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 }
					 
				 }else if(sys=="followup"){
					 sys_follow.current++;
					 current = sys_follow.current;
					 id = sys_follow.list[sys_follow.current -1];
					 max = sys_follow.list.length;
					//check is called
					 if(  sys_follow.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 }
					 
				 }else if(sys=="callhistory"){
					 sys_hist.current++;
					 current = sys_hist.current;
					 id = sys_hist.list[sys_hist.current -1];
					 max = sys_hist.list.length;
					 
					 //check is called
					 if(  sys_hist.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 }
					 
				 }
				 
				 //display on popup
				   if( current >= max ){
						$('#turn-right').css('visibility','hidden'); 
				   }
				  $('#popup-current-row').text('').text( current);
				  $('#turn-left').css('visibility','visible'); 
			  
					//load after increase 
				   $('[name=listid]').val(id);
				   //effect
		    	   $('#popup-body').fadeOut('fast', function(){
		    		   $.call.loadpopup_content("");
		    		   $(this).fadeIn('fast');
		    	   })
					  
			  },
			  prevlist : function(){
				    //remove wrapup action
		    		$('.panel-heading,#wrapup-box,#wrapup-click').removeClass('fadeInUp');
				  				  
				//get system
					var sys = $('#page-subtitle').attr('data-page');
					var current = 0;
					var id = 0;
					var max = 0;
					 if( sys=="diallist"){
						 sys_dial.current--;
						 current = sys_dial.current;
						 id = sys_dial.list[sys_dial.current - 1];
						 max = sys_dial.list.length;
						 //check is called
						 if(  sys_dial.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if( sys=="callback"){ 
						 sys_callback.current--;
						 current = sys_callback.current;
						 id = sys_callback.list[sys_callback.current -1];
						 max = sys_callback.list.length;
						//check is called
						 if(  sys_callback.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if(sys=="followup"){
						 sys_follow.current--;
						 current = sys_follow.current;
						 id = sys_follow.list[sys_follow.current -1];
						 max = sys_follow.list.length;
						//check is called
						 if(  sys_follow.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }else if(sys=="callhistory"){
						 sys_hist.current--;
						 current = sys_hist.current;
						 id = sys_hist.list[sys_hist.current -1];
						 max = sys_hist.list.length;
						 //check is called
						 if(  sys_hist.called.indexOf(id) != -1  ){
								$('#popup-recently-call').show();
						 }else{
								$('#popup-recently-call').hide();
						 }
						 
					 }
					 
					 //display on popup header
					   if( current  == 1){
						   $('#turn-left').css('visibility','hidden'); 
					   }
					  $('#popup-current-row').text('').text( current);
					  $('#turn-right').css('visibility','visible'); 
				  
						//load after increase 
					   $('[name=listid]').val(id);
					   //effect
			    	   $('#popup-body').fadeOut('fast', function(){
			    		   $.call.loadpopup_content("");
			    		   $(this).fadeIn('fast');
			    	   })
			    	   
			   
			  },
			  save_reminder:function(){
				 var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				 $.post(url, { "action" : "save_reminder" , "data": formtojson  }, function( result ){
					       var res = eval('('+result+')');  
						    if(res.result=="success"){
						    	
						    	 $('[name=pop_reminderid]').val(  res.remid );
						    	 $('#reminder-msg').fadeOut('fast',function(){
						    		 $(this).fadeIn('slow');
						    	 })
						   	   
						    }
				 });
				 
			  },
			  alarm: function( opts  ){
				  console.log("alarm");
					     var options = { 'distance': 12 , 'times' : 4 };
						  $("#shake").effect( 'shake', options , 500 ).delay(400).effect( 'shake', options , 500 );
						  
						  if( opts.sound == "on" ){
							  var audio = $("#alarm-ring")[0];
							  audio.play();
						  }
					
			
				 $.reminder.nextalarm('off');
				  
				  
			  },
			  nextalarm: function( opt ){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					$.ajax({   'url' : url, 
						   'data' : { 'action' : 'alarm','data' : formtojson , 'opt': opt }, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
							'success' : function(data){ 
									var response =  eval('(' + data + ')'); 
									if(response.result=="success"){
										var sec = parseInt( response.data );
								       console.log( "return value "+sec);
									
										//sec = 5000;
										if( sec > 0 ){
											console.log( "set time out : "+ sec );
											 setTimeout(function() {
												   //console.log( sec );
												  var opts = { "sound":"on" };
													$.reminder.alarm( opts );
										          //  doSomething();
										           // loop();  
										    }, sec);
										}else{
										 	console.log( "no reminder "+sec );
											
										}
									   //setTimeout( $.reminder.nextalarm() , 5000 );
										
										
								    	
								    }//end if
				           
							}//end success
					});//end ajax
				
			  },
			  search_calllist: function(){
				  
				  var  formtojson =  JSON.stringify( $('form').serializeObject() );  
				  $.post("call-pane_process.php" , { "action" : "search_calllist" , "data": formtojson  }, function( result ){
					       var result = eval('('+result+')');  
						    if( result.result=="success"){

								
						    	//** DIAL LIST **//
							    var $table = $('#calllist-table tbody'); 
								$table.find('tr').remove();
								var x = "";
								var range = parseInt( result.fieldlength );
								//load agent call list  
								var seq = 1;
								//clear list
								 sys_dial.list = [];

								// console.log( result.clist.length );
								 for( i=0 ; i<result.clist.length ; i++){
									 sys_dial.list.push(result.clist[i].f0);
								     x += "<tr id='"+result.clist[i].f0+"'><td style='vertical-align:middle; text-align:center' >"+seq+"</td>";
								 	var row = "";
											  for( f=1 ; f< range ; f++){
													var dynvar = eval("result.clist["+i+"].f"+f ); 	
													if( f==1){
														 row+="<td ><a href='#' class='nav-call-id'><strong>"+dynvar+"</strong></a></td>";
													}else{
														 row+="<td >&nbsp;"+dynvar+"&nbsp;</td>";
													}
											  }
									     x += row;
									     x += "</tr>";
									     seq++;
								  }
								 
								 $table.html(x);
								 
								 //dial list tfooter
								    if(i==0){   
									     $row = $("<tr id='nodata'><td colspan='"+range+"' class='text-center' >&nbsp; No Call Record  &nbsp;</td></tr>")
									     $row.appendTo($table);
									}else{											
										$table = $('#calllist-table tfoot'); 
										$table.find('tr').remove();
										var s = "s";
										if(i<1){	s = "";	}
									    $addRow = $("<tr ><td colspan='"+range+"'  style='border-top: 1px solid #EAEAEA' ><small> Total <span style='color:blue'>"+i+"</span> record"+s+" </small></td></tr>");
										$addRow.appendTo($table);
										
										$('#total_diallist').text('').text(i);
										
										  //highlight row table when click     
										 $('#calllist-table tbody').on('click','tr',function(){
											   $('#calllist-table tr.selected-row').removeClass('selected-row')
											   $(this).addClass('selected-row');
										 });
										 
											//add action when double click on row
										  $('#calllist-table tbody').on('dblclick','tr', function(){
										     
												//set current click list
											     sys_dial.current = $(this).children().first().text();
												 $('#popup-current-row').text('').text(sys_dial.current);
												 $('#popup-total-row').text('').text( sys_dial.list.length );	
												 
												  if( sys_dial.current == 1  ){
														$('#turn-left').css('visibility','hidden'); 
												   }else{
													   $('#turn-left').css('visibility','visible'); 
												   }
												  if( sys_dial.current >= sys_dial.list.length  ){
														$('#turn-right').css('visibility','hidden'); 
												   }else{
													   $('#turn-right').css('visibility','visible'); 
												   }
												
												  $('[name=listid]').val( $(this).attr('id') );
										    	   
										    	   //load popup content
										    	   $.call.loadpopup_content("");
										    
										   }) 
										 
									}
							       //end if list footer
								       
							    
						   	    	
						    }
				  	});
				  
				  
				  
			  }
			  
			  
			 
	}//end jQuery
	  
	 function mask( input , pattern ){
		  
		  var res = "";
		  for( i=0 ; i< pattern.length; i++){
			  var m = pattern.charAt(i);
			  if(m==0){
				  res = res + input.charAt(i);
			  }else{
				  res = res + m
			  }
		  }
		  
		 // input.replace(/blue/g, "red"); 
		  
		  return res;
	  } 
	  
 })(jQuery)//end function
 
 
 
  $(function(){

	
		
	  //test wrapup
	  $.call.initWrapup();
	  
	 // console.log( "cookie campaign : "+$.cookie("cur-cmp")  );
	  var currcamp = $.cookie("cur-cmp");
	  if( currcamp == undefined ){
		  //if no cookie load campaign for join
		  $('#callcampaign-pane').load('callcampaign-pane.php' , function(){
				$(this).fadeIn('slow');
			});
		  
	  }else{
		  /*
		    var tmp =  currcamp.indexOf("|");
		  	var cmpid = currcamp.substring(0,tmp);
		    var cmpname = currcamp.substring( tmp+1 , currcamp.length );

		    //load campaign dynamic 
		 	$.call.cmp_initial( cmpid );
		 	*/
		  
		  	var uid = $('[name=uid]').val();
		    var tmp = currcamp.split("|");
		    //check if user not match in cookie
		    if( tmp[2] != uid ){
		    	
		    	  $('#callcampaign-pane').load('callcampaign-pane.php' , function(){
						$(this).fadeIn('slow');
		    	  });
		    	  
		    }else{
	
				 	$.call.cmp_initial( tmp[0] );
				 	$('[name=cmpid]').val( tmp[0] );
				    $('#callwork-mon').fadeIn( 1000 );
				    
				    $('#callwork-pane').load('callwork-pane.php' , function(){
						$(this).fadeIn('slow');
						$.call.load_newlist( tmp[0] );
					});
		    }//end else
	
		  
	  }
	  
	  

	  
	  //check campaign from cookie
	  /*
	  console.log( "cookie campaign : "+$.cookie("cur-cmp")  );
	  var currcamp = $.cookie("cur-cmp");
	  if( currcamp == "" ||  currcamp == undefined ){
		  
		  console.log("if");
		  
		  //get campaign
	
		  $('#cmp-logoff').hide();
		  
		  //$('#select-campaign').show();
		  
			

		  
	  }else{
		  console.log("esle");
		  
		  var tmp =  currcamp.indexOf("|");
		  var cmpid = currcamp.substring(0,tmp);
		 var cmpname = currcamp.substring( tmp , currcamp.length );
		  
		  	//load current campaign
		 	//$.call.selectCmp( cmpid , cmpname );
		 	$('#cmp-logoff').show();
		 	
		
	  }
	  */
	  
	  //init action
	  //show campaign on menu bar
	  /* not use ?
		$('.cmp_selected').on( 'click', function(e){
				
				e.preventDefault();
				$.call.init();
				//if logoff show current menu
	 			$('#smartpanel-detail').html('<span class="ion-ios7-telephone-outline size-24"></span>TeleSmile');
	 			$('#cmp-logoff').hide();
	 			 
	 			//delete to cookie
				$.removeCookie('cur-cmp');
				$('#select-campaign').show();
		});
		*/

	     //save wrapup
		 $('.save_wrapup').click( function(e){
			 e.preventDefault();
			 $.call.saveWrapup();
			 
		 })
		 
		 
		$('.save_reminder_onpopup').click( function(e){
				e.preventDefault();
			
				//save reminder
				$.call.save_reminder();
				
				//if save success 
				$('#backto-wrapup').fadeIn('slow');
				 
				$('#wrapup-link').fadeIn('slow');
				$('#backto-wrapup').click( function(e){
					e.preventDefault();
					$('#wrapup-box').show();
					$('#call-box').hide();
					$('#history-box').hide();
					$('#reminder-box').hide();

					$('#panel-wrapup-header').show();
					$('#panel-history-header').hide();
					$('#panel-popup-header').hide();
					$('#panel-reminder-header').hide();
				})
		});
	 
		 /*
		//fruits.push("Kiwi");
		 var x = { calllist: [1,2,3,4] , current : 3 , called : [1,2,3]}
		 console.log( "total calllist"+ x.calllist.length );
		 var focus =  x.current 
		 console.log( "current "+ x.current );
		 var y = $.inArray(  focus , x.called )
		 console.log( "jq : "+y );
		 var z = x.called.indexOf(focus);
		 console.log( "java : "+z);
		 
		 if( x.called.indexOf(focus) != -1 ){
			 console.log("found");
		 }else{
			 console.log("not found");
		 }
	  */
	
	  
  });
  
