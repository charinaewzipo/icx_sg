 
(function($){
	var url = "app_project_process.php";
	
	  jQuery.app = {
				//reminder dropdown
			  init:function(){
				    $.ajax({   'url' : url, 
						   'data' : { 'action' : 'init','id': id }, 
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
			                 
			                 
			                 
							}//end success
				    })//end ajax
			  
			  },
			  load:function(){
				  var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
		  	  		$.ajax({   'url' : url, 
								   'data' : { 'action' : 'query','data' : formtojson }, 
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
						           
						           $('[name=firstname]').val( result.data.fname);
						           $('[name=lastname]').val( result.data.lname);
						           $('[name=mobile]').val( result.data.mobile);
						           $('[name=gender][value='+result.data.gender+']').attr('checked', 'checked');
						           $('[name=product][value='+result.data.product+']').attr('checked', 'checked'); 
						           
						           
						           
						           
									}//end success
		  	  		})//end ajax
			  },
			  save:function(){
				
					
				   var  formtojson =  JSON.stringify( $('form').serializeObject() ); 
					console.log("save to url ".url);
					  $.post(url , { "action" : "save" , "data": formtojson  }, function( result ){
						    var res = eval('('+result+')');  
								    		if(res.result="success"){
								    			alert("save success");
								    			
								    		}
					  });
			  },
	  		  
			 
	
	  }//end jQuery.app
	  
	  
})(jQuery)//end function

	$(function(){
			$('#save').click( function(e){
					e.preventDefault();
					$.app.save();
			})
		});


