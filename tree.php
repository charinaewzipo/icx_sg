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
<title> Tele Smile </title>

<link href="css/loading.css" rel="stylesheet">
<link href="css/ionicons.min.css" rel="stylesheet">
<link href="css/default.css" rel="stylesheet">

<style>

#div-head-tree-menu { width:230px; padding:10px 10px 10px 10px; text-align:center; background-color:#ddd; border:1px solid #ccc; border-bottom:5px solid #a8bfd7; }
#div-tree-menu { padding-left:20px; padding-bottom:10px; width:230px; background-color:#eee; overflow:hidden; border:1px solid #aaa; border-top:1px solid #FFF;   }
#tree-menu {  width:200px; float:left; margin:0; padding:0; margin-top:-1px;}
#tree-menu ul { margin:0; padding:8px;  }
#tree-menu li { list-style:none;  padding:8px; margin:0; border-bottom:1px solid #999; border-top:1px solid #fff; }
#menu-lv1 { display:none; }
#menu-lv1 li { border-bottom:none; border-top:none; }
#menu-lv2 { display:none; }
#menu-lv2 li { border-bottom:none; border-top:none; }
#menu-lv3 { display:none; }
#menu-lv3 li { border-bottom:none; border-top:none; }
#menu-lv4 { display:none; }
#menu-lv4 li { border-bottom:none;  border-top:none; }
 
a:link { text-decoration: none; color: #00F; }
a:visited { text-decoration: none; color: #0CF; }
a:hover { text-decoration: none; color: #F60; }
a:active { text-decoration: none; color: #F00; }
.txt-red { color:#F00 }

/*
#wtree{
	width:50%;
	list-style:none;
	margin:0;
	padding:0;
}
#wtree li{
	cursor:pointer;
	border:1px solid #000;
    cursor: pointer;
  	margin:0;
	padding:0;
}


#wtree li ul{ 
	list-style:none;
}
*/
 
ul.wtree , ul.wtree ul {
 list-style-type: none;
 background: url('images/wtree-vline.png')  repeat-y;  
 margin: 0; 
 padding: 0;
 cursor:pointer;
}

ul.wtree ul{
	 margin-left: 10px; 
} 


ul.wtree li{ 
	margin: 0; 
	padding: 0 12px; 
	 line-height: 22px; 
	 background: url('images/wtree-node.png') no-repeat; 
	 font-size:14px;
}

 ul.wtree li:last-child {
 	margin: 0; 
	padding: 0 12px; 
	 line-height: 22px; 
 	 background: url('images/wtree-lastnode.png') no-repeat; 
 	 font-size:14px;
 }



.tree,
.tree ul {
 cursor:pointer;
 background-color:#fff;
  margin:0;
  padding:0;
  list-style:none;
}

.tree ul {
  margin-left:1em; /* indentation */
  position:relative;
}

.tree ul ul {margin-left:.5em} /* (indentation/2) */

.tree ul:before {
  content:"";
  display:block;
  width:0;
  position:absolute;
  top:0;
  bottom:0;
  left:0;
  border-left:1px solid;
}

.tree li {
  margin:0;
  padding:0 1.5em; /* indentation + .5em */
  line-height:2em; /* default list item's `line-height` */
  color:#369;
  font-weight:bold;
  position:relative;
}

.tree ul li:before {
  content:"";
  display:block;
  width:10px; /* same with indentation */
  height:0;
  border-top:1px solid;
  margin-top:-1px; /* border top width */
  position:absolute;
  top:1em; /* (line-height/2) */
  left:0;
}

.tree ul li:last-child:before {
  background:white; /* same with body background */
  height:auto;
  top:1em; /* (line-height/2) */
  bottom:0;
}

</style>

 <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/pace.min.js"></script>
<script type="text/javascript" src="js/stack.datetime.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<script type="text/javascript" src="js/plugin/defiant.js"></script>
<script type="text/javascript" src="js/plugin/json.search.js"></script>
<script type="text/javascript" src="js/plugin/json.toXML.js"></script>
<script type="text/javascript" src="js/plugin/node.select.js"></script>
<script type="text/javascript" src="js/plugin/node.serialize.js"></script>
<script type="text/javascript" src="js/plugin/node.toJSON.js"></script>

<script>
/*
function DropDown(el) {
	this.dd = el;
	this.initEvents();
}
DropDown.prototype = {
	initEvents : function() {
		var obj = this;

		obj.dd.on('click', function(event){
			event.preventDefault();
			$(this).toggleClass('active');
			event.stopPropagation();
		});	
	}
}

 $(function(){
  
  	var x = { 3 : 'abc' , 5 : 'xyz' };
    x[1] = "hello";
    x[10] = 'testtttt';
  	//var abc = { "axd" :'test' };
	console.log( x[1] );
    
	console.log( x[10] );
	console.log( x[12] );
	delete x[3];
	console.log( x[3] );
		
	 	
	$('#test').fadeIn('slow');

	$('[name=campaign]').change( function(){
			console.log( $(this).val() );
			$('#smartpanel').text();
			var val = $(this).val();
			if(  val != ""){
				
				$('#smartpanel').fadeOut('slow' , function(){
					$('#smartpanel').text('');
					$(this).fadeIn('fast', function(){ $(this).html('<span> '+val+' </span>') });
				});
			}else{
				$('#smartpanel').fadeIn('slow' , function(){
						$(this).html('<span class="ion-ios7-telephone-outline size-24" ></span>TeleSmile');
				});
			
			}

			
	});

*/





	var wrapup = "";  //all wrapup data
	var currentwrapup = ""; //current wrapup is focus on = pcode
	
	var wnew = [];
	var wdel = [];
	var wupd = [];

	//var x = {'action':'new1' , 'data' : 'eiei' };

	
	//var y = {'action':'new2' , 'data' : 'eiei' };
	wnew.push(x);
	//wnew.push(y);

	//delete wnew[0].action;

	//console.log(wnew );

	var x = ['2','3','4',{'hello':'world'},{'abc':'test'}];
	//x.splice(0,1);


	a =  JSON.search( x , '//*[hello="world"]' );

	 x = $.grep(x, function(e){
		 //x.splice(1, 1); 
		 delete e.hello; 
		return x ;
	  	//console.log( e.hello );
	});
console.log( x );
	//console.log( x );

	

	 
	//x.splice(1, 3); 
	


	$(function(){
		
		   $.ajax({   'url' : 'tree_process.php' , 
			   'data' : { 'action' : 'init'}, 
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

            
 	   			/*
			             	var data = [
			        		            { "x": 2, "y": 0 },
			        		            { "x": 3, "y": 1 },
			        		            { "x": 4, "y": 1 },
			        		            { "x": 2, "y": 1 }
			        		         ]
			       */ 		         
			        		$('#wcfg').val('');
			        		//console.log( result.wrapup  )
			        	    wrapup =  result.wrapup ;
			        		res = JSON.search( result.wrapup , '//*[ pcode  = 0 ]' );
			        		var li = $('#wtree');
			        		for( i=0 ; i< res.length ; i++ ){
			        			li.append('<li data-id='+res[i].wcode+' data-parent='+res[i].pcode+'>'+res[i].wdtl+'</li>');
			        		}
			        	 

			               //  console.log(  wrapup[2]);

	console.log( $('ul.wtree li:last-child') );

						$('ul.wtree li:last-child').css('background','url(images/wtree-lastnode.png) no-repert') 
			                //$('ul.wtree li:last-child').css('background','url(images/wtree-lastnode.png) no-repeat'); 


				}//end success

		   })//end ajax

          // console.log( $('#wtree') );
		   $('#wtree').on('click' , 'li' , function(e){
			 	 e.stopPropagation();
	   			var self = $(this);


	   			//console.log( self.parents('ul').length );
	   			 	//test remove 
 	   			//console.log(  $('[data-upd=new]').remove() );
	   		
				//find self level of menu tree;
	   			//$('#trace').text('').text('click on level : '+self.parents('ul').length);


	   			var pcode =  self.attr('data-id');
				if( pcode != undefined ){
					currentwrapup = pcode;
				}else{
					console.log("New tree");
					return;
				}
	   			

	   			
	   			//show right info 
	   			res = JSON.search( wrapup , '//*[ wcode  = '+pcode+' ]' );
				console.log( res );
   				//console.log( res[0].wcode );
   			
   				$('[name=wcode]').val( res[0].wcode );
   				$('[name=wdtl]').val( res[0].wdtl );
   				$('[name=pcode]').val( res[0].pcode  );
   				$('[name=seq]').val( res[0].seq  );
   				$('[name=sts]').val( res[0].sts  );
   				$('[name=rmlist]').val( res[0].rmlist  );
   				$('[name=woptid]').val(res[0].optid  );

   				console.log( self.attr('rel') );
	   			if(self.attr('rel') != "open"){
		   			
				   				self.attr('rel','open');
					   		
					   			//console.log( pcode );
					   			res = JSON.search(wrapup , '//* [ pcode = '+pcode+' ]')
					   			//console.log( res );
					   			var txt = "<ul>";
					   			for( i=0 ; i< res.length ; i++ ){
					   				txt += '<li data-id='+res[i].wcode+' data-parent='+res[i].pcode+'>'+res[i].wdtl+'</li>';
					   			}
					   			txt += "</ul>"
					   			self.append( txt );	
		   		}else{

					console.log("remove");
			   		
		   			self.removeAttr('rel');
		   			console.log( self.children() );
		   			self.children().remove();
				//	console.log("else ");
			 	//	console.log(  );

			   	}
	   		
   
   		})
		
		
		

// test
	$('#tree-menu > li > a').click(function(){
		var next = $(this).next();
		if(next.is(':visible')){
			next.slideUp(300);
			$(this).find('span').html('+');
		}else{
			next.slideDown(300);
			$(this).find('span').html('-');
		}
	})
//test
$('#xx').on('click' , 'li' , function(e){
			e.stopPropagation();
		console.log( $(this) );

		
})


//same level of tree
$('#freind').click( function(){
	console.log("friend click");
	if( currentwrapup == ""){ return; }
	//console.log( currentwrapup );
	//console.log( $('#wtree li').attr('id') );

	console.log( $('[data-id='+currentwrapup+']')  );
	 $('[data-id='+currentwrapup+']').parent().append('<li data-upd="new"> NEw TEXT </li>');
})

//children level of tree
	$('#child').click( function(){
		console.log("children click");
		if( currentwrapup == ""){ return; }
	
		console.log( currentwrapup );

		console.log();
		 $('[data-id='+currentwrapup+']').children().append('<li data-upd="new"> Friend level </li>') ;

		//find self level of menu tree;
		console.log(  $('[data-id='+currentwrapup+']') );
		//$('#trace').text('').text('click on level : '+self.parents('ul').length);
		
		
	}); 



	

					   
	$('[name=save_tree]').click( function(){
			console.log("tree save");
	});
	
	$('[name=del_tree]').click( function(){
		console.log("tree del");
	  //res =  JSON.search( wrapup , '//*[ wcode  = '+currentwrapup+' ]' );
	 // delete res;

	
	  res =  JSON.search( wrapup , '//*[ wcode  = '+currentwrapup+' ]' );
	 console.log( res );

		//a =  JSON.search( x , '//*[hello="world"]' );

		wrapup = $.grep(wrapup, function( res ){
			 //x.splice(1, 1); 
		
			// delete res.wcode; 
			return wrapup;
		  	//console.log( e.hello );
		});
			
	
		 //var del = {'wcode': res[0].wcode , 'wdtl' : res[0].wdtl , 'pcode' : res[0].pcode  , 'seq' : res[0].seq, 'sts' : res[0].sts , 'rmlist' : res[0].rmlist  };
		 //wdel.push( del );

		console.log("---delete----");
		// console.log( res );
		
	});
	

	$('[name=wdtl]').change( function(){
			console.log("change ");
			console.log( $('[name=wdtl]').val() );
	});


	
	
 })

</script>

<body>
<?php  date_default_timezone_set('Asia/Bangkok');?>
<input type="hidden" name="servertime" value="<?php echo time() ?>">
<input type="hidden" name="serverdow" value="<?php echo date("w") ?>">
<input type="hidden" name="serverdate" value="<?php echo  date('d')."/".date('m')."/".date('Y') ?>">


<div class="navbar navbar-default navbar-fixed-top ">  

	<div class="navbar-inner  pull-left" style="margin-left:15px; ">
			<ul>
				<li style="width:140px; text-align:center; vertical-align:middle; "> 	
					<span style="font-size:21px; display:block; font-weight: 0; font-family: lato; margin-top:-20px;" id="smartpanel">
						<span class="ion-ios7-telephone-outline size-24" ></span>TeleSmile
					</span>
		 		</li>
				<li > 
				<span style="display:block; color:#fff; margin-top:5px;border-left:1px solid #fff; padding-left:10px;"> 
					<span id="show-name" class="header-user-profile">  Ext. 2001</span>
					<span id="show-passion"class="header-user-detail">  Phone. Status </span>
			 </span>
				</li>
			</ul>
	</div>
	
	 <div class="stack-date pull-right"></div>
	<div class="navbar-inner pull-right" >
		<span class="ion-ios7-arrow-down  dropdown-toggle" data-toggle="dropdown"  style="font-size:16px; font-weight:bold; cursor:pointer; display:block; margin-right: 8px; margin-top:16px;"></span>
		<ul class="dropdown-menu pull-right">
          <li class="text-center" style="margin:5px 0px;">
          		<img src="profiles/Xcode.png" id="abc" class="avatar-title"> 
          		<h3 style="color:#666666; display:block; margin-top:5px;">Arnon W </h3>
          </li>
          <li class="divider"></li>
          <li><a href="myprofile.php" ><i class="fa  fa-user"></i> &nbsp; My profile</a></li>
          <li><a href="mysetting.php"><i class="fa  fa-cog"></i> &nbsp; Settings </a></li>
          <li class="divider"></li>
          <li><a href="logout.php"> <i class="fa fa-lock"></i> &nbsp; Log out</a></li>
        </ul>
	</div>

	 
	<div class=" pull-right" style=" text-align:right;color:#fff; margin-top:3px; margin-right:4px;">
	 	<span id="show-name" class="header-user-profile"><?php echo  $pfile['uname']; ?></span>
		<span id="show-passion"class="header-user-detail"><?php echo  $pfile['dept']; ?></span>
	 </div>
	 
	 	<div class="pull-right" style="margin-top:-4px; margin-right:14px;"> 
			<div class="ion-ios7-alarm-outline size-38" style="color:#fff;cursor:pointer"></div>
			<div style="" class="stackbadge">
					9
			</div>
	  </div>
	
</div>

	<div class="header" style="margin-top:50px;">
			 <div class="bg-grayLighter metro header-menu">
			 	<?php include("subMenu.php");  ?>
			</div>
	</div>  
	
	<div style="padding:20px;">
	
  <table>
  	<tr style="border-bottom:3px double #000">
  		<td > TEST </td>
  		 		<td > TEST </td>
  		 		 		<td > TEST </td>
  	</tr>
  </table>
  
  <input type="text" name="test">
	
	 Please follow this concept : http://jaredly.github.io/treed/ <br/>
https://github.com/hbi99/defiant.js <br/>
http://msdn.microsoft.com/en-us/library/ms256122%28v=vs.110%29.aspx  <br/>

	 TEST Tree <br/>
	 Version 1.0 : update tree on right  <br/>
	Version 1.0.1 : add image ข้างหน้า tree เพื่อให้รู้ว่า tree มีลูกหรือไม่  <br/>
	
	 Version 1.1 :  double click for edit tree <br/>
	 Version 1.2 : drag and drop for order <br/>
	 
	 
	  <input type="button" value="create friend" id="freind"> | <input type="button" value="create children" id="child"><br/>
	 <span id="trace"></span>
	 <br/>
	 <br/>
	 <div style="float:left; width:50%">
	 <!-- 
	  	<ul id="wtree" class="wtree">
	    </ul>
	  -->
	  <ul class="tree">
		  	 <li> Start
		 		<ul id="wtree" >
		  	 	 </ul>
		    </li>
	   </ul>
	   
	 </div>
	 <div style="right:left; width:50%">
	 <table style="width:100%;">
	    			 			<thead>
	    			 				<tr>
	    			 					<td style="text-align:right"> Wrapup Code &nbsp;</td>
	    			 					<td> <input type="text" name="wcode"></td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td style="text-align:right"> Wrapup detail &nbsp;</td>
	    			 					<td> <input type="text" name="wdtl"></td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td style="text-align:right"> Wrapup parent code &nbsp;</td>
	    			 					<td> <input type="text" name="pcode"></td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td style="text-align:right"> Wrapup seq &nbsp;</td>
	    			 					<td> <input type="text" name="seq"></td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td style="text-align:right"> Wrapup sts &nbsp;</td>
	    			 					<td> <input type="text" name="sts"></td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td style="text-align:right"> Wrapup IS Remove from new list [ 0=no , 1=yes ] &nbsp;</td>
	    			 					<td> <input type="text" name="rmlist"></td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td style="text-align:right"> Wrapup option id &nbsp;</td>
	    			 					<td> <input type="text" name="woptid"></td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td colspan="2" style="text-align:center"><input type="button" name="save_tree" value="save">  |  <input type="button" name="del_tree" value="delete">     </td>
	    			 				</tr>
	    			 				<tr>
	    			 					<td colspan="2" style="text-align:center"> &nbsp; </td>
	    			 					</tr>
	    			 					<tr>
	    			 					<td colspan="2" style="text-align:center"> <input type="button" name="save_tree" value="cancel ( currently not support )">   </td>
	    			 				</tr>
	    			 			</thead>
	    			 		</table>
	    			 	
	    			 	
	 </div>
	
	    			 		
	    			 	
	    			 		
	 
	 <br/>
	<hr/>
		<ul>
			<li> Remove แม่ลูกหายหมด </li>
			<li> แก้ไขได้ตามสบาย กด save ทีเดียว</li>
			<li> แม้จะเพิ่มลูกแต่ลบแม่ ลูก็หายด้วย</li>
		</ul>	 

	 
	 <hr/>
	 
	 <div id="div-tree-menu">
	 <ul id="tree-menu">
			<li><a href="#"><span>+</span> menu-1</a>
			<ul id="menu-lv1">
			<li>&#8250; <a href="#">sub-menu-1-1</a></li>
			<li>&#8250; <a href="#">sub-menu-1-2</a></li>
			<li>&#8250; <a href="#">sub-menu-1-3</a></li>
			<li>&#8250; <a href="#">sub-menu-1-4</a></li>
			</ul>
</li>
<li><a href="#"><span>+</span> menu-2</a>
<ul id="menu-lv2">
<li>&#8250; <a href="#">sub-menu-2-1</a></li>
<li>&#8250; <a href="#">sub-menu-2-2</a></li>
<li>&#8250; <a href="#">sub-menu-2-3</a></li>
<li>&#8250; <a href="#">sub-menu-2-4</a></li>
</ul>
</li>
<li><a href="#"><span>+</span> menu-3</a>
<ul id="menu-lv3">
<li>&#8250; <a href="#">sub-menu-3-1</a></li>
<li>&#8250; <a href="#">sub-menu-3-2</a></li>
<li>&#8250; <a href="#">sub-menu-3-3</a></li>
<li>&#8250; <a href="#">sub-menu-3-4</a></li>
</ul>
</li>
<li><a href="#"><span>+</span> menu-4</a>
<ul id="menu-lv4">
<li>&#8250; <a href="#">sub-menu-4-1</a></li>
<li>&#8250; <a href="#">sub-menu-4-2</a></li>
<li>&#8250; <a href="#">sub-menu-4-3</a></li>
<li>&#8250; <a href="#">sub-menu-4-4</a></li>
</ul>
</li>
</ul>
	 </div>
	 
	 
	 
	</div>


</body>

</html>