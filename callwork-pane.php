<!-- start agent-main-pane -->
<div id="callwork-main-pane">
<div id="select-calllist">
<div style="clear:both"></div>
	  <ul class="nav nav-tabs" role="tablist">
	  		<li id="t_diallist" class="active" style="vertical-align:bottom; font-size:16px;"> <a href="#tab1" role="tab" data-toggle="tab" id="tabinner1"><span class="icon-phone" style="font-size:26px; "></span>&nbsp; New List </a></li>
	  		<li id="t_nocontact" style="vertical-align:bottom; font-size:16px;"> <a href="#tab1x" role="tab" data-toggle="tab" id="tabinner1x"><span class="icon-phone" style="font-size:26px;  position:relative;"></span><span style="position:relative; left:-8px; font-size:14px; top:-10px;" class="icon-comments"></span>No Contact &nbsp;</a></li>
	  		<li id="t_callback" style="vertical-align:bottom; font-size:16px;"> <a href="#tab2" role="tab" data-toggle="tab" id="tabinner2"><span class="icon-phone" style="font-size:26px;"></span><span style="left:-5px; top:-3px; position:relative; font-size:20px;" class="icon-reply"></span> Call Back  </a></li>
	  		<li id="t_followup" style="vertical-align:bottom; font-size:16px;"> <a href="#tab3" role="tab" data-toggle="tab" id="tabinner3"><span class="icon-phone" style="font-size:26px;"></span><span style="position:relative; left:-8px; font-size:16px; top:-11px;" class="icon-refresh"></span> Follow up </a></li>
			<li id="t_reconfirm" style="vertical-align:bottom; font-size:16px;"> <a href="#tab4" role="tab" data-toggle="tab" id="tabinner4"><span class="icon-phone" style="font-size:26px;"></span><span style="position:relative; left:-8px; font-size:16px; top:-11px;" class="icon-dollar"></span> Reconfirm  </a></li>
	  		<li id="t_callhist" style="vertical-align:bottom; font-size:16px;"> <a href="#tab5" role="tab" data-toggle="tab" id="tabinner5"><span class="icon-time" style="font-size:26px;"></span> &nbsp;  Call History  </a></li>
			<li id="t_logout" style="vertical-align:bottom; font-size:16px;" class="pull-right"> <a href="#tab20" role="tab" data-toggle="tab" id="tabinner20"><span class="icon-signin"  style="font-size:28px; "></span>&nbsp;  Logout Campaign </a></li>
	</ul>
			<div class="tab-content" style="background-color:#fff; ">
	 			<!--  tab1 new call list -->
	    		<div id="tab1" class="tab-pane active"  style="border:1px solid #E2E2E2; border-top:0; position:relative;">
	    				<div style=" padding:10px; position:relative;">
	    					
				    				<table class="table table-bordered" id="calllist-table">
									</table>
								
								
								
						</div>
	    		</div>
	    		
	    		<!--  tab1x no contact call list -->
	    		<div id="tab1x" class="tab-pane"  style="border:1px solid #E2E2E2; border-top:0;">
	    		
	    				<div style=" padding:10px;">
			    				<table class="table table-bordered" id="nocontact-table">
								</table>
						</div>
	    		</div>
	    		
	    		<!-- tab2 call back -->
	    		<div id="tab2"  class="tab-pane" style="border:1px solid #E2E2E2; border-top:0;" >
	    				<div style=" padding:10px;">
				    			  <table class="table table-bordered" id="callback-table">
								  </table>
						</div>
	    		</div>
	    		
	    		<!-- tab3 follow up -->
	    		<div id="tab3"  class="tab-pane"  style="border:1px solid #E2E2E2; border-top:0;">
	    				<div style=" padding:10px;">
			    		  		<table class="table table-bordered" id="followup-table">
							  </table>
						</div>
	    		</div>
	    		<!-- end tab3 -->

				<!-- tab4 reconfirm -->
				<div id="tab4"  class="tab-pane"  style="border:1px solid #E2E2E2; border-top:0;">
	    				<div style=" padding:10px;">
			    		  		<table class="table table-bordered" id="reconfirm-table">
							  </table>
						</div>
	    		</div>
	    		<!-- end tab3 -->
	    		
	    			<!-- tab99 call history  -->
	    		<div id="tab5"  class="tab-pane"  style="border:1px solid #E2E2E2; border-top:0;">
	    				<div style=" padding:10px;">
				    		  		<table class="table table-bordered" id="callhistory-table">

								 </table>
						  </div>
	    		</div>
	    		<!-- end tab4 -->
	    		
	    		<!-- tab20 log out-->
	    		<div id="tab20"  class="tab-pane"   style="border:1px solid #E2E2E2; border-top:0;">
	    	
			    		<div style="padding:10px;display:block;">
			    		
			    					<div style="float:left; width:60%; display:inline-block; padding-right:10px; border:0px solid #E2E2e2;">
			    					<!-- 
			    						<table style="width:100%" id="callstatic-table">
			    							<tbody>
			    								<tr>
			    									<td style="height:60px; text-align:center;vertical-align:middle" ><h3>Telephony static </h3></td>
			    									<td>&nbsp;</td>
			    								</tr>
			    								<tr>
			    									<td style="width:80%"> Total Call </td>
			    									<td style="width:20%">N/A </td>
			    								</tr>
			    								<tr>
			    									<td style="width:80%">Average talk time </td>
			    									<td style="width:20%">N/A</td>
			    								</tr>
			    								<tr>
			    									<td style="width:80%">Max talk time duration</td>
			    									<td style="width:20%"> N/A</td>
			    								</tr>
			    								<tr>
			    									<td style="height:60px; text-align:center;vertical-align:middle" ><h3> List static </h3></td>
			    									<td>&nbsp;</td>
			    								</tr>
			    								<tr>
			    									<td> Total List </td>
			    									<td> N/A </td>
			    								</tr>
			    								<tr>
			    									<td> Call List </td>
			    									<td> N/A</td>
			    								</tr>
			    								<tr>
			    									<td> Sale List </td>
			    									<td> N/A </td>
			    								</tr>
			    								<tr>
			    									<td> List remain </td>
			    									 <td> N/A</td>
			    								</tr>
			    							</tbody>
			    						</table>
			    							   -->
			    							
			    					</div>
			    					<div style="float:right; width:40%; height: 400px; display:inline-block; border:1px dashed #E2E2E2; padding:10px; position:relative; text-align:center; ">
			    					
			    					
			    							<button class="btn btn-default" data-id="cmp-logoff" id="cmp-logoff" style="color:#999; border:0; width:100%; height:100%;"> 
			    							   
				    							<span class="ion-log-out" style="font-size:80px;"></span><br/>
				    							<span style="font-size:20px;"> process </span><br/>Logout Campaign 
			    							</button>
			    					
			    					
			    					</div>
			    					<div style="clear:both"></div>
								
									
		
			    		</div>
	    		</div>
	    		<!-- end tab5 -->
	    		
	    	</div>
		<!-- end div tab content -->
		</div>
<!--  end div calllist -->
	    
	    <!-- 
	    <h2> New List  </h2>
		<table class="table table-bordered" id="" style="background-color:#fff; ">
							<thead>
								<tr class="primary">
									<td style="text-align:center;vertical-align:middle; width:5%;"> # </td>
									
									<td style="width:40%;"> แสดง  field ที่โชว์ใน configuration ของแต่ละ  camapaign , First name , last name , tel</td>
									<td style="width:20%;"> จำนวนครั้งที่โทร  </td>
									<td style="width:20%;"> Last Call  </td>
									<td style="width:20%;"> Last Wrapup  </td>
								</tr>
							</thead>
							</table>
	    -->

</div>
<!--  end group-detail-pane -->

<script>
$(function(){

	//turn off  submit form when enter
	$("form").bind("keypress", function (e) {
	    if (e.keyCode == 13) {
	        return false;
	    }
	});

//-- call history
	$('#callhistory-search-btn').click( function(e){
		e.preventDefault();
	    $('#loadmore_historylist').attr('data-read','1');
	    $('#historylist_page').text('').text('0');
	    $.call.load_callhistory( $('[name=cmpid]').val() );
	});

	//search nocontact text
	$('[name=callhistory_search]').keypress(function(e){
	    if (e.keyCode == 13) {
	    	$('#callhistory-search-btn').trigger('click');
	    	e.preventDefault();
	    }
	});
	
	//clear nocontact search
	$('#callhistory-search-clear').click( function(e){
		  e.preventDefault(); 
		  $('[name=callhistory_search]').val('');
		  //clear current page before load
		  $('#loadmore_historylist').attr('data-read','1');
		  $('#historylist_page').text('').text('0');
		  $.call.load_callhistory( $('[name=cmpid]').val() );
	});

//--end search	
	

	//tab call history : load more call history list
	$('#loadmore_historylist').click( function(e){
		e.preventDefault();
		$.call.load_callhistory( $('[name=cmpid]').val() );
	});

	  	
//-- call history event
	//highlight row table when click     
		 $('#callhistory-table tbody').on('click','tr',function(){
			   $('#callhistory-table tr.selected-row').removeClass('selected-row')
			   $(this).addClass('selected-row');
		 });
		 
		//add action when double click on row
		/*
		$('#callhistory-table tbody').on('dblclick','tr', function(){
	    	   //load popup content
	    	   $.call.loadpopup_content();
	  	}) 
		*/

    //set default tab new list color
    $('#tabinner1').css('border-top','3px solid #8bc34a');
	//log off
	$('#cmp-logoff').click( function(e){
			e.preventDefault();
			$.call.cmplogoff();
			//hide callwork-monitor
			$('#callwork-mon').hide();
	});


//when click on each tab
//change color and reinitial table data
		 $('#t_diallist').click( function(e){
			  e.preventDefault();
			  //clear color all tab
			  $('#tabinner1,#tabinner1x,#tabinner2,#tabinner3,#tabinner4,#tabinner5').css('border-top','3px solid transparent');	
			  $('#tabinner1').css('border-top','3px solid #8bc34a');
			  $('#popup-title,#page-subtitle').text('').text('New list');
		
			  $('.popup-header').css('background-color','#8bc34a');
			  $('#page-subtitle').attr('data-page','diallist');
			  $.call.load_newlist( $('[name=cmpid]').val() );
			  
		 })
		 
		 $('#t_nocontact').click( function(e){
			  e.preventDefault();
			  //clear color all tab
			  $('#tabinner1,#tabinner1x,#tabinner2,#tabinner3,#tabinner4,#tabinner5').css('border-top','3px solid transparent');	
			  $('#tabinner1x').css('border-top','3px solid #F2B50F');
			  $('#popup-title,#page-subtitle').text('').text('No contact');
	
			  $('.popup-header').css('background-color','#F2B50F');
			  $('#page-subtitle').attr('data-page','diallist');
			  $.call.load_nocontact( $('[name=cmpid]').val() );
			  
		 })
	  	 $('#t_callback').click( function(e){
			  e.preventDefault();
			  $('#tabinner1,#tabinner1x,#tabinner2,#tabinner3,#tabinner4,#tabinner5').css('border-top','3px solid transparent');	
			  $('#tabinner2').css('border-top','3px solid #ef6c00');
			  $('#popup-title,#page-subtitle').text('').text('Call back');

			  $('.popup-header').css('background-color','#ef6c00');
			  $('#page-subtitle').attr('data-page','callback');
			  $.call.load_callback( $('[name=cmpid]').val() );
			  
		 })
		$('#t_followup').click( function(e){
			  e.preventDefault();
			  $('#tabinner1,#tabinner1x,#tabinner2,#tabinner3,#tabinner4,#tabinner5').css('border-top','3px solid transparent');	
			  $('#tabinner3').css('border-top','3px solid #2196f3');
			  
			  $('#popup-title,#page-subtitle').text('').text('Follow up');
			  $('#page-subtitle').attr('data-page','followup');
			  $('.popup-header').css('background-color','#2196f3');
			  $.call.load_followup( $('[name=cmpid]').val() );
			  
		 })
		 $('#t_reconfirm').click( function(e){
			  e.preventDefault();
			  $('#tabinner1,#tabinner1x,#tabinner2,#tabinner3,#tabinner4,#tabinner5').css('border-top','3px solid transparent');	
			  $('#tabinner4').css('border-top','3px solid #2196f3');
			  
			  $('#popup-title,#page-subtitle').text('').text('Reconfirm');
			  $('#page-subtitle').attr('data-page','reconfirm');
			  $('.popup-header').css('background-color','#2196f3');
			  $.call.load_reconfirm( $('[name=cmpid]').val() );
			  
		 })
		$('#t_callhist').click( function(e){
			  e.preventDefault();
			  $('#tabinner1,#tabinner1x,#tabinner2,#tabinner3,#tabinner4,#tabinner5').css('border-top','3px solid transparent');	
			  $('#tabinner5').css('border-top','3px solid #78909c');
			  
			  $('#popup-title,#page-subtitle').text('').text('Call history');
			  $('#page-subtitle').attr('data-page','callhistory');
			  $('.popup-header').css('background-color','#999');

			  //clear current page before load
			  $('#loadmore_historylist').attr('data-read','1');
			  $('#historylist_page').text('').text('0');
			  $.call.load_callhistory( $('[name=cmpid]').val() );
			  
		 })
		$('#t_logout').click( function(e){
			  e.preventDefault();
			  $('#tabinner1,#tabinner1x,#tabinner2,#tabinner3,#tabinner4,#tabinner5').css('border-top','3px solid transparent');	
			  $('#popup-title,#page-subtitle').text('').text('Logout');
		 })
	

 
	
})

</script>