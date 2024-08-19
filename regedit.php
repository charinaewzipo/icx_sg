
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title> Tubtim </title>
<link rel="shortcut icon" type="image/x-icon" href="fonts/fav.ico">
<link href="css/default.css" rel="stylesheet">
<style>

</style>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.easypiechart.min.js"></script>
<script type="text/javascript" src="js/dropzone.min.js"></script>	
<script>
(function($){
	var url = "regedit_process.php";
	  jQuery.lic = {
		  setLicense:function(){
			  	var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
				$.post(url , { "action" : "setLicense" , "data": formtojson  }, function( result ){
				    var response = eval('('+result+')');  
					    if(response.result=="success"){
					    	window.location = "dw.php?p=profiles/attach/tubtim.cer&o=y";
					    }
		 		});
		  },
		  
	  }//end .lic
})(jQuery)//end function


$(function(){
		console.log("jquery work");

		$('#btn-setLicense').click( function(e){
	 		e.preventDefault();
	 		$.lic.setLicense();
	 	})

		$('#upload-link').click( function(e){
			e.preventDefault();
	 		$("#updateLicense-pane").trigger('click');
	 	})
		 	
	 	//drop license file
	    $("#upload-license").dropzone({		 
	    	    params: {
	    	 	   'action' : 'uploadlicense' ,
	    	    },	    
	    		   url: "regedit_process.php", 
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
	    			
	    			    	var res = eval('('+response+')');  
								$('[name=cust_comp]').val(res.data.comp);
								$('[name=cust_ip]').val(res.data.ip);
								$('[name=cust_mac]').val(res.data.mac);
								
	    			}
	    	});
		
	});	  
</script>

<body>
<form>
<center>
<div style="width:80%;margin-top:50px;">
<div style="width:44%;float:left;height:1200px;margin-right:2px;" >
	<table class="table table-border">
	  	<thead>
	  		<tr>
	  			<td colspan="2" style="text-align:center"> Register License  </td>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<tr>
	  			<td style="width:50%; height:350px;">
	  				<div id="upload-license" style="border: 1px dashed #666; background-color:#E2E2E2; width:100%; height:100%; text-align:center; padding-top:100px;">
						Drop License <br/>
						*.lic , *.cer <br/>
						OR <br/>
						<a href="#" id="upload-link">Click here</a> for upload.
					</div>
	  			</td>
	  			<td style="width:50%;">
	  				<ul style="list-style:none;margin:0;padding:0">
	  					<li style="border-bottom:1px solid #E2E2E2; margin-bottom:20px;padding:4px 0;"> License Info </li>
	  					<li> License To  </li>
	  					<li> <input type="text" name="cust_comp" autocomplete="off" placeholder="Company Name" style="width:300px"></li>
	  					<li> Server IP </li>
	  					<li> <input type="text" name="cust_ip" autocomplete="off" placeholder="Web Server IP" style="width:300px"></li>
	  					<li> Server Mac Address  </li>
	  					<li> <input type="text" name="cust_mac" autocomplete="off" placeholder="Web Server Mac Address" style="width:300px"></li>
	  				</ul>
	  			</td>
	  		</tr>
	  	</tbody>
	  </table>
	
</div>
<div style="width:54%;float:right;margin-left:2px;" >
		<table class="table table-border">
	  	<thead>
	  		<tr>
	  			<td colspan="4" style="text-align:center"> Register License / Update License  </td>
	  		</tr>
	  		<tr>
	  			<td colspan="2" style="text-align:center"> Current License </td>
	  			<td colspan="2" style="text-align:center">Update License  </td>
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<tr>
	  			<td style="width:30%;text-align:right;vertical-align:middle"> Agent : </td>
	  			<td style="width:30%;"><input type="text" name="from_lagent" value="2" autocomplete="off" placeholder="total current license" style="width:200px;"></td>
	  			<td style="width:5%;"><span class="icon-chevron-right icon-2x" style="padding:0 5px;color:#777;"></span></td>
	  			<td style="width:35%;"><input type="text" name="lagent" autocomplete="off" placeholder="total numer of update license" style="width:250px;"></td>
	  		</tr>
	  		<tr>
	  			<td style="text-align:right;vertical-align:middle"> SuperVisor : </td>
	  			<td> <input type="text" name="from_lsup" value="1" autocomplete="off" placeholder="total current license" style="width:200px;"></td>
	  			<td style="width:5%;"><span class="icon-chevron-right icon-2x" style="padding:0 5px; color:#777;"></span></td>
	  			<td><input type="text" name="lsup" autocomplete="off" placeholder="total numer of update license" style="width:250px;"></td>
	  		</tr>
	  	
	  			<tr>
	  			<td style="text-align:right;vertical-align:middle"> Manager : </td>
	  			<td> <input type="text" name="from_lqc" value="0" autocomplete="off" placeholder="total current license" style="width:200px;"></td>
	  			<td style="width:5%;"><span class="icon-chevron-right icon-2x" style="padding:0 5px;color:#777;"></span></td>
	  			<td><input type="text" name="lqc" autocomplete="off" placeholder="total numer of update license" style="width:250px;"></td>
	  		</tr>
	  		<tr>
	  			<td style="text-align:right;vertical-align:middle"> QcQa : </td>
	  			<td> <input type="text" name="from_lmanager" value="0" autocomplete="off" placeholder="total current license" style="width:200px;"></td>
	  			<td style="width:5%;"><span class="icon-chevron-right icon-2x" style="padding:0 5px;color:#777;"></span></td>
	  			<td><input type="text" name="lmanager" autocomplete="off" placeholder="total numer of update license" style="width:250px;"></td>
	  		</tr>
	  		<tr>
	  			<td style="text-align:right;vertical-align:middle"> Project Manager : </td>
	  			<td> <input type="text" name="from_lproj" value="0" autocomplete="off" placeholder="total current license" style="width:200px;"></td>
	  			<td style="width:5%;"><span class="icon-chevron-right icon-2x" style="padding:0 5px;color:#777;"></span></td>
	  			<td><input type="text" name="lproj" autocomplete="off" placeholder="total numer of update license" style="width:250px;"></td>
	  		</tr>
	  		 <tr>
	  			<td style="text-align:right;vertical-align:middle"> Admin : </td>
	  			<td> <input type="text" name="from_ladmin" value="1" autocomplete="off" placeholder="total current license" style="width:200px;"></td>
	  			<td style="width:5%;"><span class="icon-chevron-right icon-2x" style="padding:0 5px;color:#777;"></span></td>
	  			<td> <input type="text" name="ladmin" autocomplete="off" placeholder="total numer of update license" style="width:250px;"></td>
	  		</tr>
	  		<tr>
	  			<td colspan="3" style="text-align:left">*If update license is blank.<br/>The current license will use for generate.</td>
	  			<td style="text-align:right;"> <button class="btn btn-success" id="btn-setLicense" >Generate License</button> </td>
	  		</tr>
	  		
	  	</tbody>
	  </table>
</div>
<div style="clear:both"></div>
</div>

  </center>	




</form>
</body>
</html>
	  

		