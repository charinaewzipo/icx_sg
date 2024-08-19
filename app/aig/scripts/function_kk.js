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
    		var monthStr = today.getMonth()+ 1;
     		var yearStr = today.getFullYear()+ 543;
			
			if (dob_mm == monthStr)
				{
				if (dob_dd <= dateStr)
					{
				 		var age = yearStr - dob_yyyy  ;
					}else{
				 		var age = yearStr - dob_yyyy -1  ;
					}
				}
			
			if (dob_mm < monthStr) var age = yearStr - dob_yyyy ;
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
			var valYear = parseInt(date_str_arr[2],10)-543;

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
				
				//if( month  < 6){
					var show_age = nowYear - valYear   ;
				//}else{
				//	var show_age = nowYear - valYear  ;
				//	}	
					
				document.getElementById("age").value = show_age;
				
				document.getElementById("xxx").value = show_age;
				
				//document.getElementById('age').innerHTML = years+" ปี "+ month+" เดือน "+day+" วัน"  
					//document.getElementById('txtAge').value=years   // แสดงแค่ ปี
					
			}else{
				document.getElementById('age').value = '';
			}
	    }
		
		
function calPremium(){
	var COVERAGE_NAME = document.App.COVERAGE_NAME.value;
	var BILLING_FREQUENCY = document.App.BILLING_FREQUENCY.value;
	var ADE_AT_RCD = document.App.ADE_AT_RCD.value;
	document.App.SUM_INSURED.value='';
	document.App.INSTALMENT_PREMIUM.value = '';
	if(COVERAGE_NAME=='Plan 1'){
	  document.App.SUM_INSURED.value='100000';
	  document.App.INSTALMENT_PREMIUM.value = '';
	   if(BILLING_FREQUENCY=='Annually'){
		   if(ADE_AT_RCD<='35'){
	    document.App.INSTALMENT_PREMIUM.value = '18812';
		   }else if((ADE_AT_RCD>'35')&&(ADE_AT_RCD<='50')){
	    document.App.INSTALMENT_PREMIUM.value = '19852';
		   }else if((ADE_AT_RCD>'50')&&(ADE_AT_RCD<='59')){
	    document.App.INSTALMENT_PREMIUM.value = '21700';
		   }

	  }else if(BILLING_FREQUENCY=='Monthly'){
	    if(ADE_AT_RCD<='35'){
	    document.App.INSTALMENT_PREMIUM.value = '1656';
		   }else if((ADE_AT_RCD>'35')&&(ADE_AT_RCD<='50')){
	    document.App.INSTALMENT_PREMIUM.value = '1747';
		   }else if((ADE_AT_RCD>'50')&&(ADE_AT_RCD<='59')){
	    document.App.INSTALMENT_PREMIUM.value = '1910';
		   }

	  }

	}else if(COVERAGE_NAME=='Plan 2'){
	  document.App.SUM_INSURED.value='125000';
	  document.App.INSTALMENT_PREMIUM.value = '';

	   if(BILLING_FREQUENCY=='Annually'){
		   if(ADE_AT_RCD<='35'){
	    document.App.INSTALMENT_PREMIUM.value = '23135';
		   }else if((ADE_AT_RCD>'35')&&(ADE_AT_RCD<='50')){
	    document.App.INSTALMENT_PREMIUM.value = '24435';
		   }else if((ADE_AT_RCD>'50')&&(ADE_AT_RCD<='59')){
	    document.App.INSTALMENT_PREMIUM.value = '26740';
		   }

	  }else if(BILLING_FREQUENCY=='Monthly'){
	    if(ADE_AT_RCD<='35'){
	    document.App.INSTALMENT_PREMIUM.value = '2036';
		   }else if((ADE_AT_RCD>'35')&&(ADE_AT_RCD<='50')){
	    document.App.INSTALMENT_PREMIUM.value = '2150';
		   }else if((ADE_AT_RCD>'50')&&(ADE_AT_RCD<='59')){
	    document.App.INSTALMENT_PREMIUM.value = '2353';
		   }

	  }
	  
	  }else if(COVERAGE_NAME=='Plan 3'){
	  document.App.SUM_INSURED.value='150000';
	  document.App.INSTALMENT_PREMIUM.value = '';

	  if(BILLING_FREQUENCY=='Annually'){
		   if(ADE_AT_RCD<='35'){
	    document.App.INSTALMENT_PREMIUM.value = '27456';
		   }else if((ADE_AT_RCD>'35')&&(ADE_AT_RCD<='50')){
	    document.App.INSTALMENT_PREMIUM.value = '29016';
		   }else if((ADE_AT_RCD>'50')&&(ADE_AT_RCD<='59')){
	    document.App.INSTALMENT_PREMIUM.value = '31782';
		   }

	  }else if(BILLING_FREQUENCY=='Monthly'){
	    if(ADE_AT_RCD<='35'){
	    document.App.INSTALMENT_PREMIUM.value = '2416';
		   }else if((ADE_AT_RCD>'35')&&(ADE_AT_RCD<='50')){
	    document.App.INSTALMENT_PREMIUM.value = '2553';
		   }else if((ADE_AT_RCD>'50')&&(ADE_AT_RCD<='59')){
	    document.App.INSTALMENT_PREMIUM.value = '2796';
		   }

	  }
	    
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
	
	
function chk_payment(pay){
if (pay =="CASH"){
	document.getElementById('PayeeName').required = '' ;
	document.getElementById('AccountNo').required = '' ;
	document.getElementById('Bank').required = '' ;
	document.getElementById('CREDIT_CARD_EXPIRY_DATE').required = '' ;
	document.getElementById('CREDIT_CARD_EXPIRY_YEAR').required = '' ;
	
	document.App.PayeeName.value = '' ;
	document.App.AccountNo.value = '' ;
	document.App.Bank.value = '' ;
	document.App.CREDIT_CARD_EXPIRY_DATE.value = '' ;
	document.App.CREDIT_CARD_EXPIRY_YEAR.value = '' ;
	
    document.getElementById('PayeeName').style.display='none';
	document.getElementById('AccountNo').style.display='none';
	document.getElementById('Bank').style.display='none';
	document.getElementById('card_expire').style.display='none';
	
}else if (pay =="DD"){
	 document.getElementById('PayeeName').required = true ;
	 document.getElementById('AccountNo').required = true ;
	 document.getElementById('Bank').required = true ;
	 document.getElementById('CREDIT_CARD_EXPIRY_DATE').required = '' ;
	 document.getElementById('CREDIT_CARD_EXPIRY_YEAR').required = '' ;
	 
	 document.App.CREDIT_CARD_EXPIRY_DATE.value = '' ;
	 document.App.CREDIT_CARD_EXPIRY_YEAR.value = '' ;
	 
	 document.getElementById('PayeeName').style.display='block';
	 document.getElementById('AccountNo').style.display='block';
	 document.getElementById('Bank').style.display='block';
	 document.getElementById('card_expire').style.display='none';

}else {
	 document.getElementById('PayeeName').required = true ;
	 document.getElementById('AccountNo').required = true ;
	 document.getElementById('Bank').required = true ;
	 document.getElementById('CREDIT_CARD_EXPIRY_DATE').required = true ;
	 document.getElementById('CREDIT_CARD_EXPIRY_YEAR').required = true ;
	 
	 document.getElementById('PayeeName').style.display='block';
	 document.getElementById('AccountNo').style.display='block';
	 document.getElementById('Bank').style.display='block';
	 document.getElementById('card_expire').style.display='block';

}
}