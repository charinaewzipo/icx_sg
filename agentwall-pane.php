<?php 
	$aid = "";
	if( isset($_POST['aid'])){
		$aid = $_POST['aid'];
	}
	if( isset($_POST['cmp'])){
		$cmp = $_POST['cmp'];
	}
	
?>
<div id="agentwall-outer" style=" top:0; left:0; right: 0; bottom:0; position:fixed; background-color:rgba(0,0,0,0.8); z-index:998; ">
	<div  id="agentwall" data-display="<?php echo $aid; ?>"  data-cmp="<?php echo $cmp; ?>" style="position:relative; width:75%; height:80%; top: 10%; left:12%;z-index:999; background-color:#f2f2f2; overflow:hidden; border-radius:2px">
	 		<!--  inner  -->
	 	<div style="border:0px solid #000; padding:10px; ">
				<div id="awall-close" class="ion-ios-close-outline close-model" style="position:absolute; right:10px; top:0"></div>
				<div style="position:relative; margin:30px 20px;">
			
						<div style="position:relative; width:100%; border:0px solid #000;">
							<div style="">
								<div style="display:inline-block; float:left; padding:0 15px;">
									<img  src="profiles/agents/no_profile.png" id="awall-img" class="avata-big"  style="height:75px; width:75px; position:relative;">
								</div>
								<div style="display:inline-block; float:left">
									<ul style="list-style:none; margin:0; padding:0; border:0px solid #000">
										<li style=""><h3 style="margin:0; padding:0; font-family:raleway; font-weight:300; color:#666; font-size:26px;"> <span id="awall-agent" ></span> </h3> </li>
										<li style="font-size:14px; font-weight:300; color:#666; padding-top:5px;">Status : <span id="awall-asts" ></span> &nbsp; Last login <span  id="awall-lastlogin"></span> &nbsp; <span style="font-style:italic"  id="awall-timeago"></span> </li> <!-- is online stauts -->
										<li style="font-size:14px;  font-weight:300; color:#777;">Team <span id="awall-group-team" ></span> &nbsp; Ext. <span  id="awall-ext"></span> </li>
										<li style="font-size:14px; font-weight:300; color:#777;"></li>
									</ul>
								</div>
							</div>
						</div>
					
						<div style="clear:both"></div>
						
				<!--  wrapper all  -->		
				<div id="" style="margin-top:35px;">
							<div style="float:left;margin-top:0px; text-align:left;  width:40%;font-size:13px; color:#777; padding:5px; border:0px solid #E2E2E2; border-bottom:0;">
								Campaign Name : <span id="awall-cmpid" style="background-color:#2196f3; padding:3px 4px; color: #fff; border-radius:3px; font-size:13px; " ></span>
							</div>
							<!--  warpper new box -->
							<div style="float:right;margin-top:0px; text-align:right;  width:60%; font-size:13px; color:#777; padding:5px; border:0px solid #E2E2E2; border-bottom:0;"> <!-- background-color:#f7f9fa; -->
								<ul id="awall-condition" style="list-style:none;margin:0;padding:0">
										<li class="link" data-cond="yesterday"> Yesterday </li>
										<li>|</li>
										<li class="link active" data-cond="onhands"> On Hands </li>
										<li>|</li>
										<li class="link" data-cond="today"> Today </li>
										<li>|</li>
										<li class="link" data-cond="thisweek"> This Week </li>
										<li>|</li>
										<li class="link" data-cond="thismonth"> This Month </li>
								</ul>
						</div>
						<div style="clear:both"></div>
						<!--  new box -->
							<div style="height:330px; border:1px solid #E2E2E2; background-color:#fff;  ">
							<!-- 
										 <div style="float:left; width:25%; border:0px solid #000; padding:15px;">  
										 	<div style="text-align:center; font-size:15px; color:#666"> 
										 		<i class="icon-time"></i>
										 			Average Talk Time  
										 	</div>
										 	 	<div style="text-align:center; font-size:15px; color:#666; margin-top:50px;">
										 	 		 <span style="font-size:28px; color:#62cb31;" id="awall-talktime-hr"></span><span id="awall-talktime-hr-unit"></span>
										 	 		 &nbsp;<span style="font-size:30px; color:#62cb31;" id="awall-talktime-min"></span><span id="awall-talktime-min-unit"></span>
										 	 		 &nbsp;<span style="font-size:30px; color:#62cb31;" id="awall-talktime-sec"></span><span id="awall-talktime-sec-unit"></span>
										 	 	</div>
										 	 	<div style="text-align:center; font-size:12px; color:#666; margin-top:50px;"> 
										 	 		Call statistic on  
										 	 		<span class="awall-stat-ondate"> </span>
										 	 	</div>
										 </div>
										  -->
										 <div style="float:left; width:76%;  border:0px solid #000; padding:10px; position:relative; "> 
											 <div style="background-color:#fafafa; margin-top:5px;  padding:5px 15px; border-radius:4px; ">
										  		<div style="text-align:left; font-size:18px; color:#666; text-indent:10px; "> 
										 	 		<span class="icon-share"></span> Call Assign
										 	 	</div>
										 		<ul style="list-style:none; width:100%; border:0px solid #000; margin-top:5px;  padding:0; position:relative; ">
										 	 			<li style="float:lefts; display:inline-block; width:19%; border:0px solid #000; position:relative;  background-color:#8bc34a;" class="shadow">
															<div style="font-size:24px; color:#fff;  border:0px solid #fff; text-align:center; " class="animateNum" id="awall-trans-total-newlist"> 0 </div>
															<div style="font-size:14px; font-family:raleway;color:#fff; margin-bottom:2px; text-align:center; ">  New List  </div>
														</li>
														<li style="float:lefts; display:inline-block; width:19%; border:0px solid #000; position:relative; background-color:#F2B50F" class="shadow">
															<div style="font-size:24px; color:#fff; border:0px solid #fff; text-align:center; " class="animateNum" id="awall-trans-total-nocontact"> 0 </div>
															<div style="font-size:14px; font-family:raleway; color:#fff; margin-bottom:2px; text-align:center; ">  No Contact  </div>
														</li>
															<li style="float:lefts; display:inline-block; width:19%; border:0px solid #000; position:relative; background-color:#ef6c00" class="shadow">
															<div style="font-size:24px; color:#fff; border:0px solid #fff; text-align:center; " class="animateNum" id="awall-trans-total-callback"> 0 </div>
															<div style="font-size:14px; font-family:raleway;color:#fff;  margin-bottom:2px; text-align:center; ">  Call Back  </div>
														</li>
															<li style="float:lefts; display:inline-block; width:19%; border:0px solid #000; position:relative; background-color:#2196f3; " class="shadow">
															<div style="font-size:24px; color:#fff; border:0px solid #fff; text-align:center; " class="animateNum" id="awall-trans-total-followup"> 0 </div>
															<div style="font-size:14px; font-family:raleway;color:#fff;  margin-bottom:2px; text-align:center; ">  Follow up </div>
														</li>
												</ul>
											</div>
												
											 <div style="background-color:#fafafa; margin-top:20px; padding:5px 15px; border-radius:4px;">	
										 		<div style="text-align:centers; font-size:18px; color:#666; text-indent:10px;  "> 
										 	 		<span class="icon-comments"></span> Call Static
										 	 	</div>
										 	 	
												  <ul style="list-style:none; width:100%; border:0px solid #000; margin-top:5px; padding:0; position:relative;  ">
														<li style="float:lefts; display:inline-block; text-align:center; width:19%; border:0px solid #fff; background-color:#8bc34a; position:relative; height:120px;">
														 	<div style="font-size:20px; color:#fff; margin-top:15px;  " class="icon-phone" ></div>
															<div style="font-size:24px; color:#fff; border:0px solid #fff; margin:10px;" class="animateNum" id="awall-total-newlist"> 0 </div>
															<div style="font-size:15px; font-family:raleway; color:#fff; text-align:center; "> New List </div>
														</li>
													<li style="float:lefts; display:inline-block; text-align:center; width:19%; border:0px solid #fff; background-color:#F2B50F; position:relative; height:120px;">
														<div style="font-size:20px; color:#fff; margin-top:15px;" class="icon-phone" ><span class="icon-comments" style="position:relative; left:-8px; font-size:14px; top:-10px;"></span></div> 
															<div style="font-size:24px; color:#fff; border:0px solid #fff; margin:10px;" id="awall-total-nocontact"> 0 </div> 
															<div style="font-size:15px; font-family:raleway; color:#fff; text-align:center; "> No Contact </div>
														</li>
														<li style="float:lefts; display:inline-block; text-align:center; width:19%; border:0px solid #fff; background-color:#ef6c00; position:relative; height:120px;">
															<div style="font-size:20px; color:#fff; margin-top:15px;" class="icon-phone" ><span class="icon-reply" style="left:-5px; top:-3px; position:relative; font-size:20px;"></span></div> 
															<div style="font-size:24px; color:#fff; border:0px solid #fff; margin:10px;" id="awall-total-callback"> 0 </div>
															<div style="font-size:15px; font-family:raleway; color:#fff; text-align:center; "> Call Back </div>
														</li>
													<li style="float:lefts; display:inline-block; text-align:center; width:19%; border:0px solid #fff; background-color:#2196f3; position:relative; height:120px;">
														<div style="font-size:20px; color:#fff; margin-top:15px;" class="icon-phone" ><span class="icon-refresh" style="position:relative; left:-8px; font-size:16px; top:-11px;"></span></div> 
														
															<div style="font-size:24px; color:#fff; border:0px solid #fff; margin:10px;" id="awall-total-followup"> 0 </div>
															<div style="font-size:15px; font-family:raleway; color:#fff;  text-align:center; "> Follow up </div>
														</li>
														
														<li style="float:lefts; display:inline-block; text-align:center; width:19%; border:0px solid #fff; background-color:#9c27b0; position:relative; height:120px;">
															<div style="font-size:20px; color:#fff; margin-top:15px;" class="icon-tag" ></div> 
																<div style="font-size:24px; color:#fff; border:0px solid #fff; margin:10px;" id="awall-total-sales"> 0 </div>
																<div style="font-size:15px; font-family:raleway; color:#fff"> Sales </div>
														</li>
														<li style="display:inline-block"></li>
														
													</ul>
											 </div>
										 </div>
										 
										 
										<div style="float:right; width:24%;border:0px solid #000;  padding:15px; display:table"> 
											<div style="display:table-cell; vertical-align:middle">
												<br/>
												<br/>
											 	<div style="text-align:center; font-size:15px; color:#666; "> 
											 		<i class="icon-phone"></i>
											 			Total Calls
											 	</div>
											 	 	<div style="text-align:center; font-size:15px; color:#666; margin-top:50px;">
											 	 		 <span style="font-size:28px; color:#62cb31;" id="awall-talktime-hr"></span><span id="awall-talktime-hr-unit"></span>
											 	 		 &nbsp;<span style="font-size:30px; color:#62cb31;" id="awall-talktime-min">N/A</span><span id="awall-talktime-min-unit"></span>
											 	 		 &nbsp;<span style="font-size:30px; color:#62cb31;" id="awall-talktime-sec"></span><span id="awall-talktime-sec-unit"></span>
											 	 	</div>
											 	 	<div style="text-align:center; font-size:12px; color:#666; margin-top:50px;"> 
											 	 		Call statistic on  
											 	 		<span class="awall-stat-ondate"> </span>
											 	 	</div>
										 	 	</div>
										 	 	
										<!-- 
										  	<div style="text-align:center; font-size:15px; color:#666; "> 
										 	 		<span class="icon-bolt"></span> Call Progress
										 	 			 <div style=" margin-top:25px;">
										 	 			  	 <div style="position:relative;  ; text-align:center"  class="chart">
										 	 			 	     	<div style="position:absolute;  top:25%; left:42%;  margin:0; padding:0; ">
										 	 			 	     		<div style="position:relative; text-align:center">
										 	 			 	     			 <span style="font-size:30px; color:#62cb31" id="awall-callprogress">0</span><span>%</span>
										 	 			 	     		 </div>
										 	 			 	     	</div>
										 	 			 	 </div>
										 	 			 
										 	 			 </div>
										 	 			
										 	 			<div style="text-align:center; font-size:12px; color:#666; margin-top:12px;" id="awall-callprogress-dt"> 
												 	 		Call statistic on
												 	 		<span class="awall-stat-ondate"> </span>
												 	 	</div>
										 	 		  
										 	 	</div>
										 	 	 -->
									</div>
							</div>
							<!-- end div new box -->
					
				<!-- 
							<div style="border:1px solid #E2E2E2; border-top:0px; padding:5px; background-color:#f7f9fa; font-size:13px; color:#777">
										
										
							</div>
							-->
							<!--  end idv new box -->
					</div>
					<!-- end wrapper all-->	
					
				</div>
			<!--  end inside inner-->
	 	</div>
	 	<!--  end inner -->
	 
 
	</div>
	<!-- end agent wall -->
</div>
<!--  end agent outer wall -->
 
 <script>
 

 
 $(function(){

	var awall = { 
				init:function( condition ){
					  var aid   = $('#agentwall').attr('data-display');
					  var cmp = $('#agentwall').attr('data-cmp');
 
					   $.ajax({   'url' :  "home_process.php" ,
			     	   	   'data' : { 'action' : 'agentwall' , 'aid' :  aid , 'cmp' : cmp , 'condition' : condition }, 
						   'dataType' : 'html',   
						   'type' : 'POST' ,  
						   'beforeSend': function(){
						
							},										
							'success' : function(data){ 
											
								var  result =  eval('(' + data + ')');

								$('#awall-agent').text('').text( result.awall.aname  );
								$('#awall-group-team').text('').text( result.awall.agroup+" "+result.awall.ateam);
								$('#awall-ext').text('').text( result.awall.aext  );
								$('#awall-lastlogin').text('').text( result.awall.alastjoin );
								$('#awall-timeago').text('').text( $.timeago(result.awall.alastjointime) );
								
								$('#awall-asts').text('').text( result.awall.isonline );
								$('#awall-asts').addClass(result.awall.isonline);
								$('#awall-cmpid').text('').text( result.awall.acmp); 
								//$('#awall-impid').text('').text(result.awall.alastjoin);
								$('#awall-img').attr('src', result.awall.aimg  );
								if(  result.awall.acmp != ""){
									$('#awall-cmpid').text('').text( result.awall.acmp );
								}else{
									$('#awall-cmpid').text('').text(" Agent not join this campaign yet. ").css({'background-color':'transparent','color':'#666'}); 
								}
								$('.awall-stat-ondate').text('').text( result.awall.acurdate );

								if( result.astat.result == "empty" ){
									result.astat.tsales = 0;
									result.astat.tnew = 0;
									result.astat.tnocont = 0;
									result.astat.tfollow = 0;
									result.astat.tcallback = 0;
								} 
								
								var comma = $.animateNumber.numberStepFactories.separator(',')
								$('#awall-total-newlist').animateNumber({number: result.astat.tnew , numberStep: comma},200);
								$('#awall-total-nocontact').animateNumber({number:  result.astat.tnocont  , numberStep: comma},200);
								$('#awall-total-callback').animateNumber({number:  result.astat.tcallback , numberStep: comma},200);
								$('#awall-total-followup').animateNumber({number:  result.astat.tfollow  , numberStep: comma},200);
								$('#awall-total-sales').animateNumber({number:  result.astat.tsales  , numberStep: comma},200);
								/*
								if( condition=='thisweek' || condition=='thismonth'){
									$('#awall-total-sales').text('X');
								}else{
									
								}
*/
								/*
								$('#awall-today-totalassign').text('').text( result.atrans.transtotal );
								$('#awall-today-revoke').text('').text( result.arevoke.revoketotal  );
								$('#awall-today-totalassign-date').text('').text("on "+ result.atrans.transdate );
								$('#awall-today-totalrevoke-date').text('').text( "on "+result.arevoke.revokedate );
								*/
 
						  		
								//transfer list
								if( condition=='onhands'){
									$('#awall-trans-total-newlist').text('X');
									$('#awall-trans-total-nocontact').text('X');
									$('#awall-trans-total-callback').text('X');
									$('#awall-trans-total-followup').text('X');
								}else{
									$('#awall-trans-total-newlist').animateNumber({number: result.atrans.ne , numberStep: comma},200);
									$('#awall-trans-total-nocontact').animateNumber({number:  result.atrans.no , numberStep: comma},200);
									$('#awall-trans-total-callback').animateNumber({number:  result.atrans.call, numberStep: comma},200);
									$('#awall-trans-total-followup').animateNumber({number:  result.atrans.foll , numberStep: comma},200);
								}
					
								
						

								/*
								if( result.alist != "" ){
									var txt = "";
									for( i=0; i< result.alist.length; i++ ){
										txt += '<span style="background-color:#009688; padding:1px 4px; color: #fff; border-radius:3px; font-size:13px;">'+result.alist[i].lname+'</span> ';
									}
									$('#awall-impid').text('').append(txt);
								}
								*/

								/*
								var avgtalktime = 0  ; 

								if( avgtalktime != 0 ){

									//var avgtalktime = new Date().getTime() / 1000;
									var hours = parseInt( avgtalktime / 3600 ) % 24;
									var minutes = parseInt( avgtalktime / 60 ) % 60;
									var seconds = avgtalktime % 60;
									
									if( hours != 0 ){
										$('#awall-talktime-hr').animateNumber({number: hours , numberStep: comma},200);
										$('#awall-talktime-hr-unit').text('hr.');
									}			
				
									if( minutes != 0 ){
										$('#awall-talktime-min').animateNumber({number: minutes , numberStep: comma},200);
										$('#awall-talktime-min-unit').text('min.');
									}
									if( seconds != 0 ){
										$('#awall-talktime-sec').animateNumber({number: seconds , numberStep: comma},200);
										$('#awall-talktime-sec-unit').text('sec.');
									}
									*/
									/*
									//not used
									var decimal_places = 2;
									var decimal_factor = decimal_places === 0 ? 1 : decimal_places * 10;
									$('#awall-talktime-min').animateNumber({
									      number: avg * decimal_factor,
									      numberStep: function(now, tween) {
									          var floored_number = Math.floor(now) / decimal_factor,
									              target = $(tween.elem);
									          if (decimal_places > 0) {
									            // force decimal places even if they are 0
									            floored_number = floored_number.toFixed(decimal_places);
									          }
									        //  target.text(floored_number);
									          target
									          .prop('number', now) // keep current prop value
									          .text(floored_number);
									        } 
									    },200);
									$('#awall-talktime-min-unit').text('min.');
									*/

									/*
								}else{
									$('#awall-talktime-min').text('').text('N/A');
								} 
							
									//init chart
								  $('.chart').easyPieChart({
									  'scaleColor' : false,
									  'trackColor' : '#E2E2E2' ,
									  'animate' : 300 ,
									  'lineWidth' : 7 ,
									  'size' : 100 , 
									  'barColor' : '#62cb31', 
							       });

							 
				
								var pgress = 0;
								if(!isNaN( result.astat.pgress )){ parseInt( result.astat.pgress )};
								//initial piechart
								 $('.chart').data('easyPieChart').update( pgress );
								 $('#awall-callprogress').animateNumber({number: pgress , numberStep: comma},200);
								*/
							}
							
					   })//end ajax
		}
	}
	
	   var refresh;
	   var condition = $('#awall-condition').find('li.active').attr('data-cond');

	    awall.init(condition);
		function stopRefresh(){
			clearInterval(refresh);
		}
	   	function refresh(){
					refresh = setInterval(function(){
						awall.init( condition );
					}, 5000);
	     }
		refresh();

	$(document).keyup(function(e) {
	  		if(e.keyCode == 27){ 
	  			 $('.close-model').trigger('click');
		    }  
	});
	
	 
	 $('#agentwall-outer,.close-model').click( function(e){
		 	//console.log("outer wall click");
		 	stopRefresh();
		 	 $('#agentwall-pane').fadeOut('fast');
	 });
	 
	 $('#agentwall').click( function(e){
		 	e.stopPropagation()
		 	//console.log("inner wall click");
	});

	//condition
	$('#awall-condition > .link').click( function(e){
			e.preventDefault();
			var self = $(this);
			self.parent().find('li').removeClass('active');
			self.addClass('active');
			condition = self.attr('data-cond') 
			awall.init(condition);
	})

	

	 
		
 	//welcome intro
 	/*
 	$('#q0').fadeIn(900, function(){
 			$('#q3').fadeIn(3000,'easeInExpo');
 			$('#q2').fadeIn(3500,'easeInOutExpo');
 			$('#q1').fadeIn(2500, function(){
 					$('#q4').fadeIn(3000);
 			});
 	});
	*/

 });
 
 </script>