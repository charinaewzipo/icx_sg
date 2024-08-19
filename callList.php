<?php
    session_start();
    if(!isset($_SESSION["uid"])){
       header('Location:index.php');
	}else{
		$uid = $_SESSION["uid"];
		$pfile = $_SESSION["pfile"];
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title> Tubtim </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">
<link href="css/default.css" rel="stylesheet">
<style>

table { -moz-user-select: none; } 

.summary-list{
				list-style:none; 
				margin:0; 
				padding:0;
				width:100%; 
				text-align:center;
			 font-size: 0;
}
			
.summary-list li{
	display:inline-block; 
	width:19%; 
	border:1px solid #bdbdbd; 
	margin:0 2px; 
	padding:0;
	position:relative
}
.excel-dw{
	position:absolute; 
	top:-1px;
	right:5px;
	width:40px;
	height:35px; 
	font-size:30px;
	margin:0;
	padding:0; 
	color:rgba(0,0,0,0.35); 
	cursor:pointer

}
.excel-dw:hover{
	color:rgba(0,0,0,0.85);
	 
}	



.easyPieChart > div {
    position: relative;
    z-index: 1;
}


.percentage, .label {
    color: #333;
    font-size: 2.2em;
    font-weight: 100;
    text-align: center;
}




/* test font only in this page */
.font{ 
	font-family: "open sans","Helvetica Neue",Helvetica,Arial,sans-serif;
	font-size:13px;	
}

#summary-list li{
	margin:0;
	padding:0;

}

.cf:before,
.cf:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.cf:after {
    clear: both;
}

/**
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */
.cf {
    *zoom: 1;
}


/* left right box */
.noorder{
	list-style:none;
	margin:0;
	padding:0;
}
.noorder li{
	padding:8px 5px 5px 5px;
	margin:5px 2px 5px 2px;
	border:1px dashed #bbb;
	vertical-align:middle;
}

.noorder li:hover{
	background-color:#f2f2f2;
	cursor:pointer;
}


#stepper li {
	margin:2px; 
	border-left:4px solid #aeea00;
	 padding-bottom:5px;
	 color:#aaa;
}

#stepper li:hover{
	
	cursor:pointer;
	
}

#stepper li:hover div{
	color:#2196f3;
}


#calllist-table tbody tr:hover{
	background-color:#e2e2e2;
	cursor:pointer;

}

#calllist-maintain-table tbody tr:hover{
	background-color:#e2e2e2;
	cursor:pointer;
}


</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/dropzone.min.js"></script>
<script type="text/javascript" src="js/stack.notify.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<!-- <script type="text/javascript" src="js/import.js"></script> -->
<!-- <script type="text/javascript" src="js/reminder.js"></script> -->


<script type="text/javascript" src="js/jquery.easypiechart.min.js"></script>
<script type="text/javascript" src="js/jquery.animateNumber.min.js"></script>
<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>


<script type="text/javascript" src="js/callList.js"></script>
<script>
 $(function(){

	//init page
	//load callist pane detail
	$('#calllist-pane').load('callList-pane.php' , function(){
		$(this).fadeIn('slow');
	});

	//import pane back button
	$('#impcalllist-back-main').click( function(){
		 	$('#calllist-import-wizard').hide();
			$('#calllist-pane').text('');
			$('#calllist-pane').load('callList-pane.php' , function(){
				$(this).fadeIn('slow');
			});
	});

	//save map campaign
	$('.save_cmpmap').click( function(e){
			e.preventDefault();
			$.callList.save_cmpmap();
	});
	 
	//init chart
	  $('.chart').easyPieChart({
		  'trackColor' : false ,
		  'animate' : 900
       });

	
	//initial piechart
	 $('.chart').data('easyPieChart').update(0);
		 $('#view-newlist').click( function(e){
			e.preventDefault();
			//ajax
			
		})

		//begin
	     //import action
        $('#import-msg').click( function(e){
        		e.preventDefault();
        		$('#import-file').trigger('click');
        	});
 
        $("#import-file").dropzone({		 
        	    params: {
        	 	   'action' : 'upload' ,
        	 	   'uid' : $('[name=uid]').val(),
        	 	   'lid' : $('[name=lid]').val() , 
        	    },	    
        		   url: "callList_process.php", 
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

							var accept = 1
							if (file.type == "text/plain") {
								 accept = 1;
				            } else if (file.type == "text/csv") {
				           		 accept = 1;
				            }else if(file.type == "application/vnd.ms-excel") {
				            	 accept = 1;
				            }else if(file.type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") { 	 //xlsx
				            	 accept = 1;
				            }else{
				           		 accept = 0; 
				       		 	$('#upload-msg').fadeOut('fast',function(){
										$(this).fadeIn('fast');
					       		});
					        }
						        
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

						 $('#import-progress-status').text('').text( p+'%' );
						 $('.chart').data('easyPieChart').update(p);

            	    
						//console.log( "file "+file );
						//console.log( "progress "+progress );
						//console.log( "bytesSent "+bytesSent );
				
	      			  },
	      		
        		   success: function( file ,response ){
        			   // alert("import file success");
        			   //console.log("import file success!!");
        			   //console.log( response );


        			   //stopAnimate();
        			

        	
        			    	var res = eval('('+response+')');  

        			    	//call after upload
        			  		//$.callList.detail_importList( res.key  );

        			  		$('#result_fname').text('').text( res.fname );
							$('#result_ftype').text('').text( res.ftype );
							$('#result_fsize').text('').text( res.fsize );
							$('#result_record').text('').text( res.key );

						
					      //  $('.chart').data('easyPieChart').update(100);
				
						    //timeout 1 sec then change page
					        setTimeout(function(){
						        
							    //show upload detail
					        	if( res.fext == "xls" ){
									$('#csv','#unknow').hide();
									$('#xls').show();
								}else if( res.fext == "text"){
									$('#xls','#unknow').hide();
									$('#csv').show();
								}else{
									$('#csv','#xls').hide();
									$('#unknow').show();
								}
								
								$('.upload-pane').fadeOut('medium',function(){
									$('.upload-result').fadeIn();
								});
						
					        }, 900);

        			   }
        	});

        var animate;
		function stopAnimate(){
			clearInterval(animate);
		}
    	function startAnimiate(){
		
				var x = 0;
				var tmp =0;
				animate = setInterval(function(){
					console.log(tmp);
					/*
					if(p==100){
						console.log("p100");
						 $('.chart').data('easyPieChart').update(100);
					}
					*/
					x = x +3.3;
				
					if( x > tmp ){
						tmp = x;
						tmp = Math.ceil(tmp);
						$('.chart').data('easyPieChart').update(tmp);
						$('#import-progress-status').text('').text( tmp+'%' );
					}
					 
				}, 1000);
    		
      }
        

		 //save mapping
		$('.save_mapping_field').click( function(e ){
			e.preventDefault();
			//$('.save_mapping_field').prop("disabled", true);
			
			//console.log("save mapping "+$('[name=key]').val());
			key = $('[name=key]').val();
		
			 var xmapp = [];
			// var chdup = [];
			 var phone = []; //field for cleansing data
			 var txt = []; //field for cleansing data

			 var issame = []; //check mapping same field
			 var empty = 0;
			 var isphonemap = 0;
			 var err = "";
			 var pass = true;

					$('#import-table tbody > tr').each(function() {
						 $('td', this).each(function (){
								var self = $(this);
								//var checkdup = false;
						
							 	if( self.children().is('select') ){
										  //console.log( self.find("select").attr('data-col') );
										 var x = self.find("select").attr('data-col') 
										 var val =  self.find("select option:selected").val();
										 var valtype =self.find("select option:selected").attr('data-type');
										 var cap = $.trim(self.prev().text());
										
										//check is mapping same field
										if( val != 0){
											empty++;
												// console.log("val != 0");
												// console.log("index of : "+ issame.indexOf(val) );
												 
													 if(  issame.indexOf(val) == -1  ){
														 //console.log(" array push :  "+val);
														  issame.push( val );
													 }else{
														 pass = false;
														 err = "You can not mapping field with same other field. Please change mapping field";
														 //console.log("found map same field");
													}
														
														
										}//end if
										
										//check is telephone field is mapped
										if( valtype == "phone"){
											isphonemap = 1;
											phone.push( val );
										}
										if( valtype == "text"){
											txt.push( val );
										}
												
										 var test = {"key": x ,"cap": cap ,"value" : val };
										 xmapp.push( test );
										 //console.log( "after check : "+checkdup );

										 //if  mapp field is selected
										 /*
										if( val != 0){
											//check next el is checkbox
											 if( self.next().children().is(':checkbox')){
												 //check is checkbox is checked
													 checkdup =  self.next().children().is(":checked");
													if(checkdup){
														var y = {"check": val};  
														 chdup.push(y);
													}
											 }
										}//end if val
										*/	 
									}//end if self.children
									
						 })//end for each td
				})//end for each tr

			if( !pass){

					var self = $('#err-mapping-fields');
					self.text('').html("<i class='icon-warning-sign' style='font-weight:400; font-size:18px;'></i> "+err); 
					$('#err-mapping-fields').fadeIn('fast');
 					return;
 					
			}else{
				//check is empty mapping field
				if(empty==0){
					var self = $('#err-mapping-fields');
					err = "Mapping field is empty. Please select mapping field.";
					self.text('').html("<i class='icon-warning-sign' style='font-weight:400; font-size:18px;'></i> "+err); 
					self.fadeIn('fast');
					return;
				}

				//check is some telephone is mapping
				if( isphonemap==0){
					var self = $('#err-mapping-fields');
					err = "No phone number field is mapped. Please select at least one phone number field.";
					self.text('').html("<i class='icon-warning-sign' style='font-weight:400; font-size:18px;'></i> "+err); 
					self.fadeIn('fast');
					return;
				}

			}

			var xmapp = JSON.stringify( xmapp );
			//var chdup	= JSON.stringify( chdup ); 
			var phone = JSON.stringify( phone );
			var txt = JSON.stringify( txt );
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			

			$('.save_mapping_field').attr('disabled','disabled').text('').text('Please wait... ');
		
		   $.post("callList_process.php" , { "action" : "mappingfield" , "data": formtojson , "mapping" : xmapp , "key" : key , "phone" : phone , "txt" : txt }, function( result ){
				    var response = eval('('+result+')');  
					    if(response.result=="success"){

					  	  		$('.save_mapping_field').removeAttr('disabled').text('').html(' Next &gt; ');
					  	  
					    		$('#view-inlist').text('').text( response.inlist );
					    		$('#view-indb').text('').text( response.indb );
					    		$('#view-totallist').text('').text( response.total );
					    		$('#view-badlist').text('').text( response.bad );
					    		$('#view-newlist').text('').text( response.newlist );

					    		if( response.inlist == 0 ){
					    			$('#duplist-dw').css({'color':'#E2E2E2','cursor':'auto'})
						    	}else{
						    	
							    }

					    		if( response.indb == 0 ){
										$('#dupdb-dw').css({'color':'#E2E2E2','cursor':'auto'})
						    	}

					    		if( response.bad == 0 ){
										$('#badlist-dw').css({'color':'#E2E2E2','cursor':'auto'})
						    	}

					    		if( response.newlist == 0 ){
										$('#newlist-dw').css({'color':'#E2E2E2','cursor':'auto'})
										$('#onlynew-check').css('color','#E2E2E2');
										$('#onlynew-check').children().attr('disabled',true);
						    	}else{
							    		$('#onlynew-check').css('color','#888');
										$('#onlynew-check').children().removeAttr('disabled');
							    }
								$('.next').trigger('click');
					           
					    }
			 });
		
			
	})

	
	//check list name
	$('[name=lname]').focusout( function(){

		if( $('[name=lname]').val() == "" ){
				$('#lname-msg').css('color','red').text('').text('List name can not empty. Please fill the list name.');
				$('[name=lname]').focus();
				return;
		}
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
		    $.ajax({   'url' : "callList_process.php", 
	        	   'data' : { 'action' : 'checklname' ,  'data': formtojson  }, 
				   'dataType' : 'html',   
				   'type' : 'POST' ,  
				   'beforeSend': function(){
					   //set image loading for waiting request
					   //$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
					},										
					'success' : function(data){ 
			             var  result =  eval('(' + data + ')'); 
			             if(result.data == "pass"){
								$('#lname-msg').attr('data-list','true');
								$('#lname-msg').css('color',' #8bc34a').text('').html('&nbsp;');
				         }else{
								$('#lname-msg').attr('data-list','false');
								$('#lname-msg').css('color','red').text('').text('This list name already taken. Please change to another name');
								$('[name=lname]').focus();
					     }
					}
		    });

	});

    $('.importtodb').click( function(e){
			e.preventDefault();

			//check 
			//is not null
			//can't duplicate name
			if( $('[name=lname]').val() == ""){
				$('#lname-msg').css('color','red').text('').text('List name can not empty. Please fill the list name.');
				$('[name=lname]').focus();
			  return;
			} 
		
			if($('#lname-msg').attr('data-list')=="false"){
				$('#lname-msg').text('').text('This list name already taken. Please change to another name');
				return;
			}
			//if all is ok
			
				key = $('[name=key]').val();
				e.preventDefault();
				 var xmapp = [];
						$('#import-table tbody > tr').each(function() {
							 $('td', this).each(function (){
									var self = $(this);
								 	if( self.children().is('select') ){
									 		var cap = $.trim(self.prev().text());
											 var x = self.find("select").attr('data-col') 
											 var val =  self.find("select option:selected").val();
											 var t = {"key": x , "cap": cap ,"value" : val };
											 xmapp.push( t );
									 }
								
							 })//end for each td
					})//end for each tr

				xmapp = JSON.stringify( xmapp );
				var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
	
			   $.post("callList_process.php" , { "action" : "importtodb" , "data": formtojson , "mapping" : xmapp , "key" : key  }, function( result ){
				    var response = eval('('+result+')');  
				
					    if(response.result=="success"){
					           //$('#stacknotify').stacknotify({'message':'Save success','detail':'Save success'} );
					           //call next process
					           $.callList.match_cmp();
					           //then go to next step
					           $('.next').trigger('click');
					    }
				 });
				 
     });



	 //add function for match new campaign 
	 	//add action
		//var lasthit = "";
		 $('.cmpbox-ul').on('click' , 'li' , function(){
											 
				var self = $(this);
				var tmp = self.attr('data-cmpid')
					//if(lasthit == tmp ){ return; }
					//lasthit = tmp;
					/*
					$('.cmpbox-ul li').attr('data-check','uncheck'); 
					$('.cmpbox-ul li').find('div.ucheck')
					.removeClass('ion-ios-checkmark-outline')
					.addClass('ion-ios-circle-outline');
					*/
					var $check = self.find('div.ucheck');
					if(self.attr('data-check') == "uncheck" ){
								self.attr('data-check','check') 
								$check
								.removeClass('ion-ios-circle-outline')
								.addClass('ion-ios-checkmark-outline');
					}else{
							self.attr('data-check','uncheck'); 
							$check
							.removeClass('ion-ios-checkmark-outline')
							.addClass('ion-ios-circle-outline');
			
						}
											
		 })
		
		
		
		$('[name=check1]:checked').each( function(){
				//	console.log( $(this) );
			});


		$('#testtab tbody > tr').each(function() {
			 $('td', this).each(function (){
					var self = $(this);
					//console.log( self );
					if( self.children().is(':checkbox')){
					
						var checkbox =  self.children().is(":checked");
							//console.log( checkbox.is(":checked") );
					}

			 });

		});//end each

		//initial stepper
		var li = $('#stepper li').eq(0);
		li.attr('data-check','current');
		li.css('color','#2196f3');
		li.find('div').css('visibility','visible').addClass('ion-ios7-arrow-right');
		//end
		
		$('#t1').click( function(){

			var li = $('#stepper [data-check=current]');
			//current : change color , change icon
			li.css('color','#000');
			li.attr('data-check','pass');
			li.find('div').css('visibility','hidden').removeClass('ion-ios-checkmark-empty').addClass('ion-ios-arrow-right');

			var nextli = li.prev();
			nextli.attr('data-check','current');
			nextli.css('color','#2196f3');
			nextli.find('div').css('visibility','visible').removeClass('ion-ios-checkmark-empty').addClass('ion-ios-arrow-right');
			var idx = nextli.index(); 
			switch(idx){
			case 0 :  		$.callList.step1();  break;
			case 1 :  		$.callList.step2();  break;
			case 2 : 		$.callList.step3();  break;
			case 3 :		$.callList.step4();  break;
			case -1 :		$.callList.stepstart();  break;
	
			}

			
		});

		$('#t2').click( function(){
			
			var li = $('#stepper [data-check=current]');
			//current : change color , change icon
			li.css('color','#000');
			li.attr('data-check','pass');
			li.find('div').css('visibility','visible').removeClass('ion-ios-arrow-right').addClass('ion-ios-checkmark-empty');

			var nextli = li.next();
			nextli.attr('data-check','current');
			nextli.css('color','#2196f3');
			nextli.find('div').css('visibility','visible').addClass('ion-ios-arrow-right');
			
			var idx = nextli.index(); 
			switch(idx){
					case 0 :  		$.callList.step1();  break;
					case 1 :  		$.callList.step2();  break;
					case 2 : 		$.callList.step3();  break;
					case 3 :		$.callList.step4();  break;
					case -1 :		$.callList.stepend();  break;
			}
			
		});

		//test next
		$('.next').click( function(e){
			e.preventDefault();
			$('#t2').trigger('click');
	
		});
		
		//test back
		$('.back').click( function(e){
			e.preventDefault();
			$('#t1').trigger('click');
		});
	

		//click on stepper
		$('#stepper li').click( function(){
				//check is pass
				var li = $(this);
				if( li.attr('data-check') != "pass" ){
						return; // do nothing
				}

				//get li index
				var idx = li.index();
		
				$('#stepper li:lt('+idx+')').each( function(){
					$(this).css('color','#000');
					$(this).attr('data-check','pass');
					$(this).find('div').css('visibility','visible').removeClass('ion-ios-arrow-right').addClass('ion-ios-checkmark-empty');
				});
				
				
				$('#stepper li:gt('+idx+')').each( function(){
						if( $(this).attr('data-check') != undefined ){
							$(this).css('color','#000');
							$(this).attr('data-check','pass');
							$(this).find('div').css('visibility','hidden').removeClass('ion-ios-checkmark-empty').addClass('ion-ios-arrow-right');
						}else if( $(this).attr('data-check') == "pass" ){
							$(this).css('color','#000');
							$(this).attr('data-check','pass');
							$(this).find('div').css('visibility','visible').removeClass('ion-ios-checkmark-empty').addClass('ion-ios-arrow-right');
						}
				});

				li.attr('data-check','current');
				li.css('color','#2196f3');
				li.find('div').css('visibility','visible').removeClass('ion-ios-checkmark-empty').addClass('ion-ios-arrow-right');
				
				switch(idx){
						case 0 :  		$.callList.step1();  break;
						case 1 :  		$.callList.step2();  break;
						case 2 : 		$.callList.step3();  break;
						case 3 :		$.callList.step4();  break;
						case -1 :		$.callList.stepend();  break;
				}
				
		});
		
		//dw click
		$('#newlist-dw').click( function(){
			if( $('#view-newlist').text() == 0 ){ return; }
				var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				   $.post("callList_process.php" , { "action" : "newlistdw" , "data": formtojson  }, function( result ){
					    var response = eval('('+result+')');  
					    if(response.result=="success"){
					    	window.location = "dw.php?p=/temp/exportlist.xlsx&o=y";
					    }
				 });
		});
		$('#badlist-dw').click( function(){
			if( $('#view-badlist').text() == 0 ){ return; }
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.post("callList_process.php" , { "action" : "badlistdw" , "data": formtojson  }, function( result ){
				    var response = eval('('+result+')');  
					    if(response.result=="success"){
					    	window.location = "dw.php?p=/temp/exportlist.xlsx&o=y";
					    }
			 });
		});
		$('#duplist-dw').click( function(){
			if($('#view-inlist').text() == 0 ){ return; }
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.post("callList_process.php" , { "action" : "duplistdw" , "data": formtojson  }, function( result ){
				    var response = eval('('+result+')');  
					    if(response.result=="success"){
					    	window.location = "dw.php?p=/temp/exportlist.xlsx&o=y";
					    }
			 });
		});
		$('#dupdb-dw').click( function(){
			if( $('#view-indb').text() == 0 ){ return; }
			var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
			   $.post("callList_process.php" , { "action" : "dupdbdw" , "data": formtojson  }, function( result ){
				    var response = eval('('+result+')');  
					    if(response.result=="success"){
					    	window.location = "dw.php?p=/temp/exportlist.xlsx&o=y";
					    }
			 });
		});


	    //add event 
	    //sup of step1
		$('.backto1').click( function(e){
				e.preventDefault();
				var conf = confirm('Current import file will be Ignore.\r\nAre you want to import again?');
				if(conf){
						//clear current status
						$('#import-progress-status').text('');
						$('#import-progress').hide();
						$('#import-file').show();
						$('#import-msg').show();
						$('.chart').data('easyPieChart').update(0);
					
						$('.upload-result').fadeOut('medium',function(){
							$('.upload-pane').fadeIn();
						});
				}
			
				
		});
		$('.nextto2').click( function(e){
				e.preventDefault();
				console.log("send key"+$('#result_record').text()  );
				$.callList.detail_importList( $('#result_record').text() );
				//$.callList.step2();
				$('.next').trigger('click');
				
		});

		$('[name=delimiter_other]').focus( function(){
				$('[name=field_delimiter]').attr('checked', true);
		});
	
		$('[name=field_delimiter]').click( function(){
				if( $(this).val() == "other"){
					$('[name=delimiter_other]').focus();
				}
		});


		$('#restart_import').click( function(e){
			e.preventDefault();
			location.reload();
		});

		$('#finished_import').click( function(e){
			e.preventDefault();
			location.reload();
		});

		
	 
 })//end 

</script>

<body>
<form>
<input type="hidden" name="appname" value="calllist">
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">
<input type="hidden" name="uid"  value="<?php echo $uid;  ?>">
<input type="hidden" name="token" value="<?php echo $pfile['tokenid']; ?>">

<input type="Hidden" name="impid">
<input type="hidden" name="key">


<div class="navbar navbar-default navbar-fixed-top navbar-header" style="z-index:100;">  
	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul class="header-profile">
				<li style="text-align:center; vertical-align:middle;padding-right:2px;"> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span id="smartpanel-detail">
								<i class="icon-fire" ></i> <span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">Tubtim </span>	
						</span>
					</span>
		 		</li>
				<li >
				<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;"> 
					<span id="show-name" class="header-user-profile">Ext <?php echo  $pfile['uext']; ?></span>
					<span id="show-passions"class="header-user-detail"> Session ID : <?php echo  $pfile['tokenid']; ?> </span>
			 	</span>
				</li>
			</ul>
	</div>
	 <div class="stack-date pull-right"></div>
	<div class="navbar-inner pull-right" >
		<span class="ion-ios-arrow-down  dropdown-toggle profile-arrow" data-toggle="dropdown"></span>
		<ul class="dropdown-menu pull-right">
          <li class="text-center" style="padding:10px 10px 20px 10px;">
          		<img src="<?php echo $pfile['uimg']; ?>" id="profile-dd-img" class="avatar-title"> 
          </li>
          <li class="divider"></li>
          <li ><a href="#" id="loadprofile" ><span class="ion-ios-contact-outline size-21"></span> &nbsp; My profile</a></li>
          <!-- <li><a href="#" id="loadreminder"><span class="ion-ios-alarm-outline size-21"></span> &nbsp; Reminder </a></li> -->
          <li  class="divider"></li>
          <li ><a href="logout.php"> <span class="ion-ios-locked-outline size-21"></span> &nbsp; Log out</a></li>
        </ul>
	</div>

	<div class="pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
	 	<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
		<span id="show-passion"class="header-user-detail"><?php echo  $pfile['team']; ?></span>
	 </div>
	  <!--
	 	<div class="pull-right" style="margin-top:-4px; margin-right:15px; "> 
			<ul class="nav navbar-nav" style="margin:0;padding:0" >
				<li class="dropdown " style="height:50px;" id="reminder">
				<a class="dropdown-toggle " data-toggle="dropdown" style="padding:8px 8px; ">
					    <span id="shake" class="ion-ios-alarm-outline size-38 shake" style="color:#fff;cursor:pointer;"></span>
						<span class="stackbadge total_reminder"></span>
			    </a>
			    <ul class="dropdown-menu wrapdd">
			    	<li>
			    	   <div style='text-align:center; color:#666; padding:5px; font-family:roboto; font-weight: 500;  border-bottom:1px dashed #ccc; margin:5px 8px;'  > 
			    	   				<span id="reminder_count" style="cursor:pointer" class="alink" data-open="open-reminder"></span>
			    	   </div>
				    	    <div id="slimreminder" class="" ></div>
			    	</li>
			    </ul>
			    </li>
			</ul>
	  </div> 
	  -->
</div>

	<div class="header" style="margin-top:50px;">
			 <div class="metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  

	<div style="padding:0 20px;">
	<div id="calllist-pane" style="display:none"></div>
	<div id="calllist-delete-pane" style="display:none">
	    Message : List is in use 
	    Warning : All list 
		
		<input type="checkbox" > Delete Agent Call Log 
		
		check box delete  agent call log 
check box delete this log list 
	
	</div>
	<!--  step wizard -->
	<div style=" border:0px solid #000; display:none" id="calllist-import-wizard">
	<div style="position:relative;">
				<div id="impcalllist-back-main" style="float:left; display:inline-block;cursor:pointer; ">
						<i style="color:#666;  " class="icon-circle-arrow-left icon-3x" ></i>
					</div>
					<div  style="display:inline-block; float:left; margin-left:5px;">
						 <h2 style="font-family:raleway; color:#666666;  margin:0; padding:0"> Import New List</h2>
					 	<div class="stack-subtitle" style="color:#777777; ">Import New List </div>
					</div> 
				<div style="clear:both"></div>
		</div>
		<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px"> 
		
		<div style="background-color:#fff">
				<div id="wiz-left" style="float:left; width:250px; margin-left:0px; border:0px solid #000; height: 400px; display:table; " >
					<div style="display:table-cell;vertical-align:top;">
					<ul style="list-style:none; margin:0; padding:0px" id="stepper">
						<li ><div style="visibility:hidden;  top:5px; margin-left:10px; position:relative; display:inline;  font-size:35px; color: ;line-height:20px;"></div> <span style="display:inline; padding:5px; font-family:raleway; font-size:16px;  ">Step1 : Import File </span></li>
						<li ><div class="ion-ios7-arrow-right" style="visibility:hidden;  top:5px; margin-left:10px; position:relative; display:inline;  font-size:35px; line-height:20px;"></div> <span style="display:inline; padding:5px; font-family:raleway; font-size:16px; "> Step2 : Mapping Fields </span></li>
						<li ><div class="ion-ios7-arrow-right"  style="visibility:hidden;  top:5px; margin-left:10px; position:relative; display:inline;  font-size:35px;line-height:20px;"></div> <span style="display:inline; padding:5px; font-family:raleway; font-size:16px; ">Step3 : Named List  </span></li>
						<li ><div class="ion-ios7-arrow-right"  style="visibility:hidden;  top:5px; margin-left:10px; position:relative; display:inline;  font-size:35px; line-height:20px;"></div><span style="display:inline; padding:5px; font-family:raleway; font-size:16px; "> Step4 : Match Campaigns </span></li>
					</ul>
				
					<input type="button" value="back" id="t1" style="visibility:hidden">
					<input type="button" value="next" id="t2" style="visibility:hidden">
				 	
					</div>
				</div>
		
				<div id="wiz-right" style="margin-left:250px; max-width:100%; background-color:#fff;  border:1px solid #fff; ">
					<div style="position:relative; margin:10px; padding:0 20px 20px 20px; background-color:#f1f1f1; border-radius:3px;">
				<!--  step 1 -->
						<div style="" id="stepper1">
								<h2 style="display:inline-block;font-family:raleway; color:#666666;"> Step1 : Import Call List  </h2>
								<div style="position:relative; top:-10px; font-family:raleway;color:#777777; font-size:16px;"> Import call list file. </div>
								<hr style="position:relative;border-bottom: 1px dashed #777777; top:-10px;"> 
									<div style="width:100%;">
										<!--  float left -->
										<div style="float:left; width:22%; vertical-align:top; color:#666666; border:0px solid #999; padding:5px; border-radius:2px;">
												<div class="upload-pane">
														Allow Import Data Format
														<ul style="margin-left:0;padding:0px">
															<li style="margin-left:20px; padding-top:10px;">CSV file ( *.csv )</li>
															<li style="margin-left:20px; ">Text file (*.txt )</li>
															<li style="margin-left:20px; ">Spreadsheet( *.xlsx , xls )</li>
														</ul>
												</div>	
												<div class="upload-result" style="display:none;">
													<div style=""> File Name <span style="font-size:14px" class="ion-ios-arrow-right" ></span></div>
													<p style="color:#2196f3" id="result_fname"></p>
													<div style=""> File Type <span style="font-size:14px" class="ion-ios-arrow-right"></span></div>
													<p style="color:#2196f3" id="result_ftype"></p>
													<div style=""> File Size <span style="font-size:14px" class="ion-ios-arrow-right"></span></div>
													<p style="color:#2196f3" id="result_fsize"></p>
													<div style=""> Import Key <span style="font-size:14px" class="ion-ios-arrow-right"></span></div>
													<p style="color:#2196f3" id="result_record"></p>
											  </div>
									  
										</div>
										<!--  end float left -->
										<!-- float right -->
										<div style="float:right; width:78%;">
										
													<!--  step 1.0 -->
													<div style="color:#f44336; display:none" id="upload-msg">Error : This file type is not supported </div>
													<div style="width:100%;" class="upload-pane">
														
															 <div id="import-file" style="position:relative; border:1px dashed #E2E2E2; margin: 0 auto; height:150px; background-color:#fff;">
															 	<div id="import-progress" style="position:absolute; top:-15%; left:50%; display:none" class="percentage chart" data-percent="0" data-scale-color="false"><div style="position:relative; top:75px" id="import-progress-status">&nbsp;</div></div>
															     <div id="import-msg" style="position:relative; left:37%; top:35%;" >
															     		<div class="ion-ios7-upload-outline" style="margin-top:-25px; display:inline-block; font-size:48px; font-weight:bold; color:#666666;cursor:pointer; "></div>
															     		<div style="position:relative; margin-top:20px; display:inline-block;color:#666666; cursor:pointer; font-size:16px; top:-1px;" >&nbsp;&nbsp;   Drop file  for import or <span style="color:#2196f3;cursor:pointer; "> click here </span></div>
															     </div>
															</div>
												</div>
												<!--  end step 1.0 -->
												
												<!--  step 1.1 -->
												<div style="display:none; width:100%; margin-bottom:20px; background-color:#fff; border:1px dashed #E2E2E2;  border-radius:2px;" class="upload-result">
												
														<!--  start div csv -->
														<div id="csv" style="padding:20px; display:none">
															<p style="font-size:22px; font-weight:300";> Choose field delimiter , Record Separator </p>
															<span  style="font-size:15px; font-weight:300";>Field Delimiter</span> 
															<ul style="list-style:none; margin-top:5px;">
																<li style="padding:2px;"> <input type="radio" name="field_delimiter" value="tab"> Tab </li>
																<li style="padding:2px;"><input type="radio" name="field_delimiter" value="semicolon" checked> SemiColon (;) </li>
																<li style="padding:2px;"><input type="radio" name="field_delimiter" value="comma"> Comma (,) </li>
																<li style="padding:2px;"><input type="radio" name="field_delimiter" value="space"> Space 'Not support'</li>
																<li style="padding:2px;"><input type="radio" name="field_delimiter" value="other"> Other Symbol : <input type="text" name="delimiter_other" style="position:relative; top:-6px;"  autocomplete="off"> </li>
															</ul>
														  
															<span  style="font-size:15px; font-weight:300";>Record Delimiter</span> 
															<ul style="list-style:none">
																<li> <input type="radio"  name="record_delimiter" value="lf"> LF </li>
																<li><input type="radio"  name="record_delimiter" value="cr"> CR </li>
																<li><input type="radio"  name="record_delimiter" value="crlf" checked> CRLF</li>
															</ul>
															
																<button class="btn btn-default backto1"> &lt;  Back </button>
																<button class="btn btn-success nextto2"> Next &gt; </button>
															 
														</div>
														<!--  end div csv -->
												
														<!-- start div xls -->  
														<div id="xls" style="padding:20px;  display:none; text-align:center">
																<h3 style="color:#888; font-weight:400;">  Import List Successful </h3>
																<button class="btn btn-default backto1"> &lt;  Back </button>
																<button class="btn btn-success nextto2"> Next &gt; </button>
														</div>
														<!--  end div xls -->
												
														<!--  start div csv -->
														<div id="unknow" style="padding:20px;  display:none">
																<h2> This file Not support :/</h2>
														</div>
												
												</div>
												<!--  end step1.1 -->
										</div>
										<!-- end float right -->
										<div style="clear:both"></div>
										<!--  clear float -->
									</div>
								 
									
						</div>
					<!-- end step1 -->
				
					<!--  start step2 -->
						<div style="" id="stepper2">
								<h2 style="display:inline-block;font-family:raleway; color:#666;"> Step2 : Mapping Fields </h2>
								<div style="position:relative; top:-10px; font-family:raleway;color:#777777; font-size:16px;"> Check list data integrity. </div>
								<hr style="position:relative;border-bottom: 1px dashed #777777; top:-10px; margin-bottom:0; "> 
								
								<div id="err-mapping-fields" style="display:none;font-family:raleway; padding:5px; background-color:#e51400 ;color:#fff; border-radius:2px; text-indent:5px;" >
										 Error Mapping
								</div>
																	<!-- 
														 			<div class="progress" style="height:20px; width:300px; border-radius:3px;  border:1px solid #E2E2E2; margin-top:5px;">
																			  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height:20px; background-color:#23b7e5">
																			 		 <div style="font-size:15px; color:#fff; position:absolute;"> Progress  100%  </div>
																			  </div>
																		</div>
					
																rule.. <br/>
																verify 1.ต้อง mapfield  (ห้ามเว้นว่างแล้วกด next ) <br/>
																verify 2.ห้าม map field ซ้ำกัน !! <br/>
																verify 3 check ด้วยว่ามีการ set telephone field ไว้หรือไม่ ถ้าไม่มี alert เตือนด้วย   <br/>
														
																	Option เอาไว้ทำอะไร ?
																<br/>
																สามารถ add custom field ได้หรือไม่ ? ได้แต่ต้องทำเป็นแบบ on the fly
																<br/>-->
																		
									 <span style="display:inline-block;padding:8px 0; font-family:raleway;"><input type="checkbox" name="ignore_header" value="1" checked> Ignore Import header field </span>
									<table class="table table-bordered" id="import-table">
										<thead>
											<tr class="primary">
												<td style="font-size:12px;"> Seq </td>
												<td>  Header </td>
												<td> Mapping </td>
												<td> Option </td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td> First Name </td>
												<td> 
														<select name="mapping">
															<option> --- This field is not map ---</option>
														</select> 
												</td>
											</tr>
										</tbody>
									</table>
									
											<button class="btn btn-default back"> &lt;  Back </button>
											<button class="btn btn-success save_mapping_field"> Next &gt; </button>
											<br/>
											
									<!-- <button class="btn btn-success save_mapping_field" > Save Mapping Field </button>  -->
								
								
						</div>
					<!--  end step2 -->
					
					
						<!--  start step3 -->
						<div style="" id="stepper3">
								<h2 style="display:inline-block;font-family:raleway; color:#666666;"> Step3 : Create List Name</h2>
								<div style="position:relative; top:-10px; font-family:raleway;color:#777777; font-size:16px;"> Create name of this import list. </div>
								<div class="stack-subtitle" style="position:relative; color:#777777;top:-10px; text-indent:5px; "> </div>
								<hr style="position:relative;border-bottom: 1px dashed #777777; top:-10px;"> 
								
										<!--  wrapper -->
											<div style="width:100%;">
											
												<!--  left pane -->
												<div style="float:left; width:60%; vertical-align:top; color:#555; " >
												<h3 style="font-family:'Segoe UI Light','Helvetica Neue'; font-weight:300; text-align:center"> Summary Result </h3>
													
															<ul style="list-style:none; marign:0; padding:0; margin-right:0px;">
																	<li style="border-bottom:1px solid #E2E2E2; padding:8px;">
																	<div  style="float:left; font-family:'Segoe UI Light','Helvetica Neue'; font-weight:200; line-height:1.5;  font-size:22px;"> New List </div>
																		<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  margin-left:20px; padding-left:20px; border-left:1px dashed #aaa">
																					<div class="ion-ios-download-outline" style="font-size:30px; cursor:pointer" id="newlist-dw"> </div>
																			</div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:right;font-weight:100; line-height:1.1;  font-size:26px;">
																					<span class="animateNum" id="view-newlist">0</span> <span style="font-size:14px;"> records </span>
																			</div>
																			<div style="clear:both"></div>
																</li>
																
																<li style="border-bottom:1px solid #E2E2E2; padding:8px;">
																	<div  style="float:left; font-family:'Segoe UI Light','Helvetica Neue'; font-weight:200; line-height:1.5;  font-size:22px;"> Bad List </div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  margin-left:20px; padding-left:20px; border-left:1px dashed #aaa">
																					<div class="ion-ios-download-outline" style="font-size:30px; cursor:pointer " id="badlist-dw"> </div>
																			</div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  font-size:26px;">
																						<span class="animateNum" id="view-badlist">0</span> <span style="font-size:14px;"> records </span>
																			</div>
																			<div style="clear:both"></div>
																</li>
																
																<li style="border-bottom:1px solid #E2E2E2; padding:8px;">
																	<div  style="float:left; font-family:'Segoe UI Light','Helvetica Neue';font-weight:200; line-height:1.5;  font-size:22px;"> In Database Duplicate </div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  margin-left:20px; padding-left:20px; border-left:1px dashed #aaa">
																					<div class="ion-ios-download-outline" style="font-size:30px; cursor:pointer "  id="dupdb-dw"> </div>
																			</div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  font-size:26px;">
																					<span class="animateNum" id="view-indb">0</span> <span style="font-size:14px;"> records </span>
																			</div>
																			<div style="clear:both"></div>
																</li>
																
															<li style="border-bottom:1px solid #555; padding:8px;">
																	<div  style="float:left; font-family:'Segoe UI Light','Helvetica Neue'; font-weight:200; line-height:1.5;  font-size:22px;"> In List Duplicate </div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  margin-left:20px; padding-left:20px; border-left:1px dashed #aaa">
																					<div class="ion-ios-download-outline" style="font-size:30px; cursor:pointer " id="duplist-dw"> </div>
																			</div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  font-size:26px;">
																						<span class="animateNum" id="view-inlist">0</span> <span style="font-size:14px;"> records </span>
																			</div>
																			<div style="clear:both"></div>
																</li>
													
																<li style="border-bottom:1px solid #555; padding:8px;">
																			<div  style="float:left; font-family:'Segoe UI Light','Helvetica Neue'; font-weight:200; line-height:1.1;  font-size:22px;">  </div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  margin-left:20px; padding-left:20px; ">
																					<div class="ion-ios-download-outline" style="font-size:30px; visibility:hidden"></div>
																			</div>
																			<div style="float:right;font-family:'Segoe UI Light','Helvetica Neue'; text-align:center;font-weight:100; line-height:1.1;  font-size:26px;">
																				<span style="font-family:'Segoe UI Light','Helvetica Neue'; font-weight:100; line-height:1.1; font-size:16px;"> Total </span>&nbsp;<span class="animateNum" id="view-totallist" style="color:#00695c;font-weight:300; ">0</span><!-- #2196f3 --> <span style="font-size:14px;"> records </span>
																			</div>
																			<div style="clear:both"></div>
																</li>
														</ul>
												</div>
												<!--  end left pane -->
												<!--  right pane -->
												<div style="float:right; width:38%; border:1px dashed #E2E2E2; background-color:#fff; height: 300px; display:table; padding-left:10px ">
													
														<div style="display:table-cell; text-align:center; vertical-align:middle; position:relative; width:inherit;">
																	<h3 style="font-family:'Segoe UI Light','Helvetica Neue'; font-weight:300; text-align:center"> Create  list name </h3>
																	<ul style="margin:0px; padding:0px 10px; list-style:none; width:100%;" >
																		<li style="text-align:left;padding:5px 0 3px 0; color:#888; font-size:15px;">
																			<input type="radio" name="optimp" value="alldb" checked>&nbsp; Import all list to database 
																		</li>
																			<li style="text-align:left;padding:0px 0 5px 0; color:#888; font-size:15px;">
																			<span id="onlynew-check"><input type="radio" name="optimp" value="onlynew">&nbsp; Import only New list to database </span> 
																		</li>
																			<li style="text-align:left;padding:15px 0 5px 0;">
																				<p style="font-size:12px;visibility:visible" id="lname-msg" > &nbsp;</p>
																				 <input type="text" name="lname" placeholder="List Name * " autocomplete="off" style="width:100%">
																		</li>
																		<li style="text-align:left;padding:5px 0 10px 0;">
																			<textarea name="ldesc" placeholder="List Detail" autocomplete="off"  style="width:100%; height:100px;"></textarea>
																		</li>
																	</ul>
																
													<button class="btn btn-default back"> &lt;  Back </button>
													<button class="btn btn-success importtodb"> Next &gt; </button>
													<br/><br/>
																	<!--  <button class="btn btn-success importtodb"> Start Import List </button>   -->
														</div>
												</div>
												<div style="clear:both"></div>
												<!--  end right pane -->
											</div>
								<!--  end wrapper -->
						</div>
					<!--  end step3 -->
					
					<!-- start step4 -->
						<div style="" id="stepper4">
						
								<h2 style="display:inline-block;font-family:raleway; color:#666666;"> Step4 : Match Campaigns </h2>
								<div style="position:relative; top:-10px; font-family:raleway;color:#777777; font-size:16px;"> Match new list with campaigns OR skip.</div>
								<hr style="position:relative;border-bottom: 1px dashed #777777; top:-10px;"> 
					
							<!--  left pane  -->
							<div style="float:left; width:64%; margin-bottom:20px ">
					
									<div style="width:46%; min-width:250px; display:inline-block; top:0; float:left; ">
									
										<div style="border-top:2px solid #E2E2E2; border-bottom:0px solid #E2E2E2; padding:8px; background-color:#fff;">
											<span style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#555; font-size:16px;"> New Call List </span>
											<span style="float:right; background-color:#f8ac59; color:#fff; padding:2px 8px 2px 8px; border-radius:3px; font-size:12px;" id="cmp_mapped"> 0 </span>
										</div>
										<div class="no-calllistbox" style="height:380px; border:1px dashed #999; position:relative; ">
											<div style="position:relative; display:block; top:15%; text-align:center;vertical-align:middle">
													<span class="ion-ios-information-outline" style="font-size:80px; text-align:center; display:block;color:#bbb"> </span>
													<span style="text-align:center; display:block; font-size:22px; color:#999"> No new call list found</span>
													<span style="text-align:center; display:block; font-size:12px; color:#999"> Someting went wrong :/ <br/> Please contact administrator.</span>
											</div>
										</div>
										<ul class="noorder calllistbox-ul"></ul>
							</div>
							<!--  end left pane -->
							
							<!--  center1 pane -->
							<div style="height:425px; width:8%; float:left; display:inline-block;top:0; display:table; margin-bottom:20px">
								<div style="display:table-cell; text-align:center; vertical-align:middle">
										<span class="icon-chevron-right icon-2x" style="font-size:30px;"></span>
								</div>
							</div>
						  <!-- end center1 pane -->
						  
						  <!--  center2 pane -->
							<div style="width:46%; min-width:250px; display:inline-block;top:0; float:right; margin-bottom:20px">
							
								<div style=" border-top:2px solid #E2E2E2; border-bottom:0px solid #E2E2E2; padding:8px; background-color:#fff;">
									<span style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#555; font-size:16px;"> Select Campaign  </span>
									<span style="float:right; background-color:#f8ac59; color:#fff; padding:2px 8px 2px 8px; border-radius:3px; font-size:12px;" id="cmp_ava">0</span>
								</div>
								<div class="no-cmpbox" style="height:380px; border:1px dashed #999; position:relative; ">
									<div style="position:relative; display:block; top:15%; text-align:center;vertical-align:middle">
											<span class="ion-ios-information-outline" style="font-size:80px; text-align:center; display:block;color:#bbb"> </span>
											<span style="text-align:center; display:block; font-size:22px; color:#999"> No Campaign found </span>
											<span style="text-align:center; display:block; font-size:12px; color:#999"> You can add campaign on campaign page.</span>
									</div>
								</div>
								
								<ul class="noorder cmpbox-ul"></ul>	
								</div>
								
								<div style="clear:both"></div>
				
					</div>
					<!--  end center2 pane -->
	
				<!--  right pane  -->
					<div style="float:right; width:34%; display:table; margin-bottom:20px;" >
					
							 <div style="position:relative; display:table-cell; text-align:center; vertical-align:middle; height:425px;background-color:#fff; border:1px dashed #E2E2E2; ">
									<div style="font-size:20px; color:#555;display:none" class="msg_cmp_mapping_result" id="cmp_now_mapping_header"> </div> 
									<div style="font-size:16px; color:blue;"  id="cmp_now_mapping"></div>
									<div style="font-size:12px; color:#999;visibility:hidden" id="msg_cmp_mapped_result">&nbsp;</div>
							 		<br/>
							 		<button class="btn btn-success save_cmpmap"> Save Changes</button>
							 		<button class="btn btn-default next"> SKIP this step</button>
							 </div>
							
						</div>
						<!--  end right pane -->
					<div style="clear:both"></div>
					</div>
					<!--  end step4 -->
					
					<div style="" id="stepper_end">
						<div style="width:100%; display:table;">
						
								<div style="display:table-cell;  height:550px;  text-align:center; vertical-align:middle;  "> 
											<h2 style="display:inline-block;font-family:raleway; color:#666666;"> Import List Finished </h2>
											<div style="position:relative; color:#777777;top:-10px; text-indent:5px; "> List name is imported successfully.</div>
											<br/>
											<br/>
										<!-- 	<button class="btn btn-success" id="restart_import"> Import New List again </button>  -->
											<button class="btn btn-success" id="finished_import"> Finished , go to call list page</button>
								</div>
						
						</div>
					</div>
					
					</div>
					<!-- end padding -->
				</div>
				<!--  end div float right -->
		</div>
		<!-- end div wrapper -->
	</div>
	<div style="clear:both"></div>
	<!--  end step wizard -->


</div>
	

 <div id="profile-pane" class="content-overlay" style="display:none"></div>
</form>
</body>
</html>