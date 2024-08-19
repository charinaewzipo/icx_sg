(function($){
	
		$.fn.stacktime = function(  ) {
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
			     var dayColor = ['#E51400','#FFC40D','#F778A1','#128023','#FA6800','#009CEA','#A903B3'];
			      var d = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
			     
			      var _cal = $('<div class="stack-time "><strong>'+d[serverdow]+'</strong> &nbsp;&nbsp;'+serverdate+'</div>')
			   
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
			        	 el.html( $('<div>'+h+'<span style="font-family:lato;visibility:hidden">:</span>'+m+'</div>') );
			         }else{
			        	 el.html($('<div>'+h+'<span style="font-family:lato;visibility:visible">:</span>'+m+'</div>'));
			        	  //el.html( [_time,_cal] ).css({'background': dayColor[serverdow]});
			         }
				        setTimeout(function() { updateTime( ) }, 1000);      
			  	 }

			}); 
		};

 })(jQuery)//end function
 
 $(function(){
	    $('.clock').stacktime();
 })