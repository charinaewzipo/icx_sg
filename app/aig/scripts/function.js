// JavaScript Document

function fncShow(ctrl){ // ฟังก์ชั่นสำหรับ แสดง (Show) ส่งค่า id ของ DIV หรือ Table TD TR
	document.getElementById(ctrl).style.display = ''; //สั่งให้แสดง
	}

	function fncHide(ctrl){ // ฟังก์ชั่นสำหรับ ซ่อน ส่งค่า id ของ DIV หรือ Table TD TR
	document.getElementById(ctrl).style.display = 'none'; //สั่งให้แสดง
	}

	function stopRKey(evt) {
  	var evt = (evt) ? evt : ((event) ? event : null);
 	 var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  	if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
	}
	document.onkeypress = stopRKey;



    function ageCount() {
        var today = new Date();
        var  dob = document.getElementById("dob").value;

		var dob_dd = dob.substr(0,2);
		var dob_mm = dob.substr(3,2);
		var dob_yyyy = dob.substr(6,4);

        var pattern = /^\d{2,2}\/\d{2,2}\/\d{4}$/; //Regex to validate date format (dd/mm/yyyy)

        if (pattern.test(dob)) {

			var dateStr = today.getDate();
    		var monthStr = today.getMonth();
     		var yearStr = today.getFullYear()+ 543;

			if (dob_mm == monthStr)
				{
				if (dob_dd >= dateStr)
					{
				 		var age = yearStr - dob_yyyy   ;
					}else{
				 		var age = yearStr - dob_yyyy  - 1 ;
					}
				}

			if (dob_mm < monthStr) var age = yearStr - dob_yyyy  ;
			if (dob_mm > monthStr) var age = yearStr - dob_yyyy - 1 ;

			document.getElementById("age").value = age ;
            return true;
        } else {
            alert("กรุณาใ่สข้อมูลให้ถูกต้องด้วยครับ เป็น วัน/เดือน/ปี  ต.ย.(03/09/2525)");
            return false;
        }

    }


	function verify() {
		frm=document.App;

			if (frm.Salutation.value==""){
				alert("กรุณาระบุคำนำหน้าผู้เอาประกัน");
				frm.Salutation.focus();
				return false;
				}
				else{
				frm.submit();
				}


			if (frm.First_Name.value==""){
				alert("กรุณาระบุชื่อผู้เอาประกัน");
				frm.First_Name.focus();
				return false;
				}
				else{
				frm.submit();
				}

			if (frm.Last_Name.value==""){
				alert("กรุณาระบุชื่อสกุลผู้เอาประกัน");
				frm.Last_Name.focus();
				return false;
				}
				else{
				frm.submit();
				}

			if (frm.Client_Sex.value==""){
				alert("กรุณาระบุเพศผู้เอาประกัน");
				frm.Client_Sex.focus();
				return false;
				}
				else{
				frm.submit();
				}
			}


			function getAge(obj){
			var offset = new Date();
			var nowDate =offset.getDate();
			var nowMonth =offset.getMonth();
			var nowYear = offset.getFullYear();

			var date_str = obj.value;
			var date_str_arr = date_str.split('/');
			var valDate = parseInt(date_str_arr[0],10);
			var valMonth = parseInt(date_str_arr[1],10)-1;
			var valYear = parseInt(date_str_arr[2],10);

			//var bDate =document.getElementById('new_Date');
			//var valDate = '6';
			//var valDate =bDate.options[bDate.selectedIndex].value;
			//var bMonth =document.getElementById('new_Month');
			//var valMonth = '3';
			//var valMonth =bMonth.options[bMonth.selectedIndex].value;
			//var bYear =document.getElementById('new_Years');
			//var valYear = '1980';
			//var valYear =bYear.options[bYear.selectedIndex].value;
			if(valDate!='null' && valMonth!='null' && valYear!='null'){
				offset.setFullYear(nowYear-valYear);
				offset.setMonth(nowMonth-valMonth);
				offset.setDate(nowDate-valDate);
				var years = offset.getFullYear();
				var month = offset.getMonth();
				var day = offset.getDate();

				//if( month  < 6) {
				//var show_age = (nowYear - valYear) -543   ;
				//}else{
				//	var show_age = nowYear - valYear  ;
				//	}
				
				
				if (nowMonth == valMonth)
				{
				if (nowDate >= valDate)
					{
				 		var show_age = nowYear - valYear   ;
					}else{
				 		 var show_age = nowYear - valYear ; // วันชนวัน
						 //var show_age = nowYear - valYear - 1 ; // ปีชนปี
					}
				}

			if (nowMonth < valMonth) var show_age = nowYear - valYear  ; // วันชนวัน
			//if (nowMonth < valMonth) var show_age = nowYear - valYear - 1  ; // ปีชนปี
			if (nowMonth > valMonth) var show_age = nowYear - valYear  ;

				document.getElementById("age").value = show_age;

				//document.getElementById('age_text').innerHTML = nowYear+" ปี "+ valYear +" เดือน "+day+" วัน"
				//document.getElementById('txtAge').value=years   // แสดงแค่ ปี

			}else{
				document.getElementById('age').value = '';
			}
	    }


 function get_address(){
	 var address = document.App.add_bill.value;
	 if(address == '1'){
		 var AddressNo3 = document.App.AddressNo1.value;
		 var building3 = document.App.building1.value;
		 var Moo3 = document.App.Moo1.value;
		 var Soi3 = document.App.Soi1.value;
		 var Road3 = document.App.Road1.value;
		 var Sub_district3 = document.App.Sub_district1.value;
		 var district3 = document.App.district1.value;
		 var province3 = document.App.province1.value;
		 var zipcode3 = document.App.zipcode1.value;
		 var telephone3 = document.App.telephone1.value;
		 var Mobile3 = document.App.Mobile1.value;

		 document.App.AddressNo3.value = AddressNo3 ;
		 document.App.building3.value = building3 ;
		 document.App.Moo3.value = Moo3 ;
		 document.App.Soi3.value = Soi3 ;
		 document.App.Road3.value = Road3 ;
		 document.App.Sub_district3.value = Sub_district3 ;
		 document.App.district3.value = district3 ;
		 document.App.province3.value = province3 ;
		 document.App.zipcode3.value = zipcode3 ;
		 document.App.telephone3.value = telephone3 ;
		 document.App.Mobile3.value = Mobile3 ;

	 }else if (address == '2'){
		 var AddressNo3 = document.App.AddressNo2.value;
		 var building3 = document.App.building2.value;
		 var Moo3 = document.App.Moo2.value;
		 var Soi3 = document.App.Soi2.value;
		 var Road3 = document.App.Road2.value;
		 var Sub_district3 = document.App.Sub_district2.value;
		 var district3 = document.App.district2.value;
		 var province3 = document.App.province2.value;
		 var zipcode3 = document.App.zipcode2.value;
		 var telephone3 = document.App.telephone2.value;

		 document.App.AddressNo3.value = AddressNo3 ;
		 document.App.building3.value = building3 ;
		 document.App.Moo3.value = Moo3 ;
		 document.App.Soi3.value = Soi3 ;
		 document.App.Road3.value = Road3 ;
		 document.App.Sub_district3.value = Sub_district3 ;
		 document.App.district3.value = district3 ;
		 document.App.province3.value = province3 ;
		 document.App.zipcode3.value = zipcode3 ;
		 document.App.telephone3.value = telephone3 ;


	 }else {
		 document.App.AddressNo3.value = '' ;
		 document.App.building3.value = '' ;
		 document.App.Moo3.value = '' ;
		 document.App.Soi3.value = '' ;
		 document.App.Road3.value = '' ;
		 document.App.Sub_district3.value = '' ;
		 document.App.district3.value = '' ;
		 document.App.province3.value = '' ;
		 document.App.zipcode3.value = '' ;
		 document.App.telephone3.value = '' ;
		 document.App.Mobile3.value = '' ;
	 }

 }


function fncShow(ctrl){ // ฟังก์ชั่นสำหรับ แสดง (Show) ส่งค่า id ของ DIV หรือ Table TD TR
	document.getElementById(ctrl).style.display = ''; //สั่งให้แสดง
	}

	function fncHide(ctrl){ // ฟังก์ชั่นสำหรับ ซ่อน ส่งค่า id ของ DIV หรือ Table TD TR
	document.getElementById(ctrl).style.display = 'none'; //สั่งให้แสดง
	}


function calBMI(){
	var Weight = document.App.WEIGHT.value;
	var Height = document.App.HEIGHT.value;
	var Height = Height/100;
	var BMI = Weight /(Height * Height)
	document.App.BMI_SHOW.value = BMI.toFixed(2);
}

function getPremiumFamily() {
	//alert("I am an alert box!");

  var PRODUCT_NAME = document.getElementsByName('PRODUCT_NAME')[0].value;
  var COVERAGE_NAME = document.getElementsByName('COVERAGE_NAME')[0].value;
  var PAYMENTFREQUENCY = document.getElementsByName('PAYMENTFREQUENCY')[0].value;

  var url = "AjaxGetPrmiumFamily.php?PRODUCT_NAME="+PRODUCT_NAME+"&COVERAGE_NAME="+COVERAGE_NAME+"&PAYMENTFREQUENCY="+PAYMENTFREQUENCY;

  //alert(url);

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
   //  document.getElementById("plan_insure").innerHTML=

    document.getElementsByName('INSTALMENT_PREMIUM')[0].value = xmlhttp.responseText;
		 console.log( );
	     }
  }

  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function getPremiumD2C() {
	//alert("I am an alert box!");

  var PRODUCT_NAME = document.getElementsByName('PRODUCT_NAME')[0].value;
  var COVERAGE_NAME = document.getElementsByName('COVERAGE_NAME')[0].value;
  var PAYMENTFREQUENCY = document.getElementsByName('PAYMENTFREQUENCY')[0].value;
  var AGE = document.getElementsByName('ADE_AT_RCD')[0].value;
  var C_PREMIUM = 0;
  var CAMPAIGN_ID = document.getElementsByName('campaign_id')[0].value;

  var url = "AjaxGetPrmiumD2C.php?PRODUCT_NAME="+PRODUCT_NAME+"&COVERAGE_NAME="+COVERAGE_NAME+"&PAYMENTFREQUENCY="+PAYMENTFREQUENCY+"&AGE="+AGE+"&CAMPAIGN_ID="+CAMPAIGN_ID;

  //alert(url);

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
	var response = JSON.parse(xmlhttp.responseText);

   	console.log("AjaxGetPrmiumD2C",response);
	C_PREMIUM = response.premium_payment;
	if(PAYMENTFREQUENCY == 'รายเดือน'){
		C_PREMIUM = parseInt(C_PREMIUM)*2;
	}
	else{
		C_PREMIUM = parseInt(C_PREMIUM);
	}
    document.getElementById('INSTALMENT_PREMIUM').value = response.premium_payment;
	document.getElementById('INSTALMENT_COPY').value = C_PREMIUM;
	document.getElementById('PLAN_LAYER_CODE').value = response.PLAN_LAYER_CODE;
	}
  }

  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}

function show_DISTRICT(str) {
    if (str == "") {
       // document.getElementById("result_car_model").innerHTML = "";
        return;
    } else { 
	    
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("district1").innerHTML = this.responseText;
            }
        };

        //alert("I am an alert box!");
        xmlhttp.open("GET","get_DISTRICT.php?q="+str,true);
        xmlhttp.send();
    }
}

function show_SUBDISTRICT(str,str2) {
    if (str == "") {
       // document.getElementById("result_car_model").innerHTML = "";
        return;
    } else { 
	    
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("Sub_district1").innerHTML = this.responseText;
            }
        };

        //alert(str,str2);
        xmlhttp.open("GET","get_SUBDISTRICT.php?q="+str+"&q2="+str2,true);
        xmlhttp.send();
    }
}

function show_ZIPCODE(str,str2,str3) {
    if (str == "") {
       // document.getElementById("result_car_model").innerHTML = "";
        return;
    } else { 
	    
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("zipcode1").innerHTML = this.responseText;
            }
        };

        //alert("I am an alert box!");
        xmlhttp.open("GET","get_ZIPCODE.php?q="+str+"&q2="+str2+"&q3="+str3,true);
        xmlhttp.send();
    }
}

function show_ZIPCODE_Value(str,str2,str3) {
    if (str == "") {
       // document.getElementById("result_car_model").innerHTML = "";
        return;
    } else { 
	    
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("zipcode1").value = this.responseText;
            }
        };

        //alert("I am an alert box!");
        xmlhttp.open("GET","get_ZIPCODE_Value.php?q="+str+"&q2="+str2+"&q3="+str3,true);
        xmlhttp.send();
    }
}








