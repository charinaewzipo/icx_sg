(function($){
	$.fn.stacktime = function(){
			return this.each(function(){
				// do something
				var el = $(this);
				servertime = parseFloat( $('[name=servertime]').val()) * 1000;
				serverdate = $('[name=serverdate]').val();
				serverdow = $('[name=serverdow]').val();

				  serverTime = new Date(servertime);
			      localTime = new Date();
			      timeDiff = serverTime - localTime;
			      var addleadingzero = function(i){
				         if (i<10){i="0" + i;}
				         return i;    
				   }
	
			     // var dayColor = [ {'mon' : '#FFC40D'}, {'tue' : '#F778A1'},{'wed' : '#128023'},{'thu' : '#FA6800'},{'fri' : '#009CEA'},{'sat' : '#A903B3'},		{'sun' : '#E51400'}];
			     //dayColor  0 (for Sunday) through 6 (for Saturday
			    // var dayColor = ['#E51400','#FFC40D','#F778A1','#128023','#FA6800','#009CEA','#A903B3'];
			     var dayColor = ['#E51400','#FFC40D','#F778A1','#393','#FA6800','#009CEA','#A903B3'];
			     
			  
			      var d = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
			   
			 updateTime();
			 function updateTime(){
			  	   tstamp = new Date();
			  	   tstamp = tstamp.getTime();
			  	   tstamp = tstamp + timeDiff;
			       tstamp = new Date(tstamp);
			       
				    var h=tstamp.getHours(),
				          m=tstamp.getMinutes(),
				           s=tstamp.getSeconds()

				        h=addleadingzero(h);
				        m=addleadingzero(m);
				        s=addleadingzero(s);
				        
			        if(s%2==0){			
			        	 //update new day background color 
						 if(h==0 && m==0 && s==0){
						    	if(serverdow==6){ serverdow=0}
						    	serverdow++;
						 }
			        	 var _cal = $('<div class="stack-time"><strong>'+d[serverdow]+'</strong> &nbsp;&nbsp;'+serverdate+'</div>')
			        	 var _time = $('<div >'+h+'<span style="font-family:lato;visibility:hidden;padding-left:1px;">:</span>'+m+'</div>', {class: 'stack-time'}).css({'font-family':'lato'});
			        	 el.html( [_time,_cal] ).css({'background': dayColor[serverdow]}); 
			         }else{					    
			        	  var _cal = $('<div class="stack-time"><strong>'+d[serverdow]+'</strong> &nbsp;&nbsp;'+serverdate+'</div>')
			        	  var _time = $('<div>'+h+'<span style="font-family:lato;visibility:visible; position:relative; top:-4px; color:rgba(255,255,255,0.6);padding-left:1px;">:</span>'+m+'</div>', {class: 'stack-time'}).css({'font-family':'lato'});
			        	  el.html( [_time,_cal] ).css({'background': dayColor[serverdow]});
			         }
				        setTimeout(function() { updateTime( ) }, 1000);      
			  	 }

			}); 
		};
		
		
 })(jQuery)//end function
 
 $(function(){
	 
	 	$('.stack-date').stacktime();		
		//initail page
	 	
	 	//prevent submit in textbox
	 	/*
	 	$(window).keydown(function(e){
	 	    if(e.keyCode == 13) {
	 	      e.preventDefault();
	 	      return false;
	 	    }
	 	  });
	 	*/
	 	
	 	 //disable default firefox image drag
		$(document).on("dragstart", function() {
		     return false;
		});
	 
	
	 	//header menu
		$("a[data-role='logout']").click( function(e){
					e.preventDefault();
					var confirm = window.confirm('Are you sure to logout?');
					if(confirm){ window.location = "logout.php" };
		});
		
		//highlight menu by hidden app name
		$("a[data-role='"+$('[name=appname]').val()+"']").addClass('info');
		 
		
		//all page link profile and reminder
		/***/
		 $('#loadprofile,#profile-dd-img').click( function(e){
				e.preventDefault();
				 $('#profile-pane').load('myprofile.php' , function(){
						$(this).fadeIn('fast',function(){
							  // window.scrollTo(0, 0);
							   $(this).css({'height':(($(document).height()))+'px'});
							   $("html, body").animate({ scrollTop: 0 }, "fast");
							});
				 });
		 });
		 
		 //open reminder
		 $('#loadreminder,#reminder_count').click( function(e){
				e.preventDefault();
			    $('#reminder-pane').load('reminder-pane.php' , function(){
			    		$(this).fadeIn('fast',function(){
			    		 	//window.scrollTo(0, 0);
						   	$(this).css({'height':(($(document).height()))+'px'});
						   	$("html, body").animate({ scrollTop: 0 }, "fast");
						  
						});
			 	}); 
		  });
		 
		 $('.dropdown').click( function(){
			 $('#reminder-popup').fadeOut('fast');
		 })
 
		 /* not use move to reminder.js
	 $('#loadreminder').click( function(e){
			e.preventDefault();
		    $('#reminder-pane').load('reminder-pane.php' , function(){
		    		$(this).fadeIn('fast',function(){
		    		 	//window.scrollTo(0, 0);
					   	$(this).css({'height':(($(document).height()))+'px'});
					   	$("html, body").animate({ scrollTop: 0 }, "fast");
					  
					});
		 	}); 
	  });
	 */
	 
	 /* cookie current join campaign */
	 var currcamp = $.cookie("cur-cmp");
	  if( currcamp != undefined ){
		  
		    var tmp = currcamp.split("|");
		    var uid = $('[name=uid]').val();
		   // console.log( uid +"|"+tmp[2] );
		    if( tmp[2] == uid ){
		    	$('#smartpanel-detail').text(tmp[1]);		
		    }
		  
		    /*
		    var tmp =  currcamp.indexOf("|");
		  	var cmpid = currcamp.substring(0,tmp);
		    var cmpname = currcamp.substring( tmp+1 , currcamp.length );
		    //set header to campagin
			$('#smartpanel-detail').text(cmpname);		
			*/
	  }
	 
    
	  var sess = $('[name=token]').val();
	  var sessuid = $('[name=uid]').val();
	  //console.log( "session line 156 : "+sess +"|"+ sessuid );
	   
	     $.ajax({   'url' : 'session.php', 
	    	   'data' : { 'session' : sess  ,'uid' :  sessuid }, 
			   'dataType' : 'html',   
			   'type' : 'POST' ,  
			   'success' : function(data){ 
						  
		                        var  res =  eval('(' + data + ')'); 
		                       // console.log( "result "+res.result )
		                   
		                        if(res.result=="expire"){
		                        	window.location = "expire.php";
		                        }
		               
				}   
			});//end ajax 

		  
	/*
	  if( $('[name=tokenid]').val()  != "" ){
		  console.log( "current tokenid : "+$('[name=tokenid]').val() );
		  
	  }
	 // var token = $.cookie("token")
	  /*
	   if( $.cookie("tokenid") != undefined ){
		   
	   }
		
	  */
	 
		/***/
		
		/*
		//hightlight nav menu left
		 $('.nav-pills li').click( function(){
	         $(this).parent().find('li').removeClass('active');
	         $(this).addClass('active');
		});
		 */
			//side bar cookie
		/*
		   var bar;
			var leftbar = $.cookie('bar');
			if(leftbar=="open"){
				//do default action
				
	         bar = "semi";
			}else if(leftbar=="semi"){

				var $tip = $('.stack-nav li a');
		    	$tip.mouseenter( function(){
		    		var txt = $(this).text(); 
		    		$('.stack-nav li a').append( $('<span class="tips">'+txt+'</span>'));
		    	}).mouseleave( function(){
		    		$('.tips').remove();
		    	}).addClass('tooltips');
				
			   // $('.stack-nav li span').hide();
			    $('.collapsible').css({"marginLeft": "-150px"})
			    
			    $('#side-partition').html('&laquo;').css({'cursor':'w-resize'}) 
			    $('.stack-nav li i').addClass('pull-right');   
				
				bar = "close";
			}else if(leftbar=="close"){

			      $('.stack-nav li span').hide();
		          $('.collapsible').css({ "marginLeft": "-250px" });
		          $('#side-partition').html('&raquo;').css({'cursor':'e-resize'});
		          $('.stack-nav li i').addClass('pull-right');  
		          //unattach event mouseenter
		        	$('.stack-nav li a').unbind('mouseenter');
				bar = "open";
			}else{
				//if leftbar is undefined bar will do next event == semi
				bar = "semi";
			}

			*/
		 
			 
			 //side bar high light
	
				$('.stack-nav li').hover(
						function() {
							var div = $( this ).find( "span:last" ).next();
							if( div.attr('class') != "nav-circle-selected" ){
								$( this ).append("<div class='nav-circle'></div>");
							}
						}, function() {
							var div = $( this ).find( "span:last" ).next();
							if( div.attr('class') != "nav-circle-selected" ){
								$( this ).find( "span:last" ).next().remove();
							}
						}
				).click( function(){
						$('.nav-circle-selected').remove();
						$( this ).append("<div class='nav-circle-selected' ></div>");
					    $(this).siblings().find("span").css({'color':'#aaa'}); 
						$(this).find( "span").css({'color':'#0087e6'});
				});
	
				/* deprecate
				   //side bar high light
				 $('.stack-nav li').click( function(){
			         $(this).parent().find('li').removeClass('active');
			         $(this).addClass('active');
				});
				 */
				 
			   var bar = "semi";
			 //side bar action
			  $('#side-partition').click(function(){
			   
			    	  //if bar status == semi to this
					    if(bar=="semi"){
						  
						    $.cookie('bar', 'semi'); //remember current status
					        //$('.stack-nav li span').fadeOut('medium');
				        	$('.collapsible,.rightpanel,.leftpanel').animate({ "marginLeft": "-=150px" }, 500, "easeInOutQuart" ,  function(){ $('#side-partition').html('&laquo;').css({'cursor':'w-resize'}) ;  $('.stack-nav li i').addClass('pull-right');   });
				        	//$('.rightpanel').animate({ "marginLeft": "-=150px" }, 500, "easeInOutQuart" ,  function(){});
				        	var $tip = $('.stack-nav li a');
				        	$tip.mouseenter( function(){
				        		var txt = $(this).text(); 
				        		$('.stack-nav li a').append( $('<span class="tips">'+txt+'</span>'));
				        	}).mouseleave( function(){
				        		$('.tips').remove();
				        	}).addClass('tooltips');
				        	
					       	bar = "close"; //do next event
					
				        }else  if(bar=="close"){
				        	
				            $.cookie('bar', 'close'); //current status
				            $('.stack-nav li span').fadeOut('medium');
				        	$('.collapsible,.rightpanel,.leftpanel').animate({ "marginLeft": "-=50px" }, 500, "easeInOutQuart" ,  function(){ $('#side-partition').html('&raquo;').css({'cursor':'e-resize'}) ;    });
				        	
				        	
				        	
				        	 bar = "open"; //do next event
				        
				        	//unattach event mouseenter
				        	$('.stack-nav li a').unbind('mouseenter');
					     
					     }else if(bar=="open"){
				         	$.cookie('bar', 'open'); // current status
				         	
				         	//unattach event mouseenter
				         	$('.stack-nav li a').unbind('mouseenter');
				        
				            $('.stack-nav li i').removeClass('pull-right');
				            $('.stack-nav li span').show();
				            $('.collapsible,.rightpanel,.leftpanel').animate({ "marginLeft": "+=200px" }, 500, "easeInOutQuart",  function(){ $('#side-partition').html('&laquo;').css({'cursor':'w-resize'});   });
				            bar = "semi"; //do next event
				     
				        }//end if else
			 
			    });
			  
			  
			  // test on develope redminder
             /*
					 function reminderMe( sec ){
						 console.log( "reminder"+sec );
							if( sec != undefined && sec != "" && sec > 0 ){
								startReminder( sec );
							}
						
							function startReminder( sec ){
								setTimeout(function(){ reminder() }, sec );
								stopReminder();
							}

							function stopReminder(){
									 clearTimeout(reminder);
						  }

							function reminder(){
								 $( ".shake" )
								 	.effect( "shake",  {times: 3, distance: 13}, 400)
								 	.delay(600)
								 	.effect( "shake",  {times: 3, distance: 13}, 400)
								 try{
										$('#alarm-ring')[0].play();
									}
									catch(e){}
									//startReminder(6000);
									
							}

						 }
						 //end plugin 
					 if( $('[name=activeremine]').val()!="" && $('[name=activeremine]').val()!=undefined){
						 reminderMe($('[name=activeremine]').val());
					 }
				
					*/
		

		
		
	 
 })
 
 
 //jQuery blockUI
 function blockUI(el) {		
		    $(el).block({
		        message: '<div class="loading-animator"></div>',
		        css: {
		            border: 'none',
		            padding: '2px',
		            backgroundColor: 'none'
		        },
		        overlayCSS: {
		            backgroundColor: '#eee',
		            opacity: 0.3,
		            cursor: 'wait'
		        }
		    });
		}

// wrapper function to  un-block element(finish loading)
function unblockUI(el) {
    $(el).unblock();
}