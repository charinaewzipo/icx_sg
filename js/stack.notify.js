(function($){
	 /*
	<div id="stack-notify" class="shadow" style="position:fixed; padding-left: 8px; display:none; background-color:#B3C833; color:#ffffff; width:100%; height:53px;  z-index:2000" >
	   <span  class="icon-checkmark" style="padding-left:6px; margin-top: 16px; padding-left:15px;" ></span> 
	  <span style="padding-left:10px; font-size:20px;   font-weight: 860;">  Save Success  </span>
	  <span style=" display: block; font-size: 10px; margin-left: 44px; margin-top: -2px;"> message save success </span>
	</div>

	<div id="stack-msg" class="shadow" style="position:fixed; padding-left: 8px; display:block; background-color:#9A1616; color:#ffffff; width:100%; height:52px;  z-index:+2000" >
	 <span  class="icon-cancel-2" style="padding-left:6px; margin-top: 16px; padding-left:15px;  " ></span>
	  <span style="padding-left:10px; font-size:20px;   font-weight: 860;">  Save Fail  </span>
	  <span style=" display: block; font-size: 10px; margin-left: 44px; margin-top: -2px;"> message save fail </span>
	</div>
	 */
	

	$.fn.stacknotify = function(arg){
		return this.each(function(){
		    //$(this).addClass('stack-notify');
		
		   // notify = $('<span  class="icon-checkmark" style="padding-left:6px; margin-top: 10px; padding-left:15px;" ></span>'); 
		  //  notify = $('<i  class="fa fa-check" style="padding-left:6px; margin-top: 10px; padding-left:15px;" ></i>'); 
          //  notify.append('<span style="padding-left:10px; font-size:20px;   font-weight: 860;">  Save Success  </span>');
          //  notify.append('<span style=" display: block; line-height: 12px; font-size: 10px; margin-left: 32px; "> message save success </span>');
		   var type = (arg.hasOwnProperty('type') && arg['type']!="")?arg['type']:"success";
           var message = (arg.hasOwnProperty('message') && arg['message']!="")?arg['message']:"message test success";
		   var detail = (arg.hasOwnProperty('detail') && arg['detail']!="")?arg['detail']:"Save Success";
        
        	var notify = '<div style="padding-left:6px; margin-top: 5px;  padding-left:15px; position:relative; display:inline-block" >'
				notify += '<i class="'+((type == "success")?"icon-ok-circle":"icon-remove-circle")+'" style="font-size:30px; position:relative;top:4px;"></i></div>'
        		notify += '<div style="padding-left:10px; font-size:22px; line-height:12px; top:-6px; display:table-cell; position:relative; display:inline-block">'+detail+'</div>'
        	    notify += '<div style="line-height: 1px; font-size: 12px; text-indent: 56px;  "> '+message+' </div>';
		    
		    $('#stacknotify').html(notify);

			$('#stacknotify').css("background-color", (type == "success")?"#B3C833":"#EE7373");
		    
		    $('#stacknotify').fadeIn('slow' , function(){
				 $(this).delay(1000).fadeOut('slow');
		    }); 
   
		   
	   })
	}
	

	
})(jQuery)

$(function(){
	$('<div id="stacknotify" class="stack-notify"></div>').insertAfter('body');
})