<?php


include("../../function/StartConnect.inc");

$app_number = $_POST["app_number"];

 $SQL = "select  * from t_motor_app  where  app_number = '$app_number'" ;

 $result = mysql_query($SQL,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
 	while($row = mysql_fetch_array($result))
	{

			

			$data['issue_no'] = $row["issue_no"];
			$data['cust_name'] = $row["Title"].$row["Firstname"].' '.$row["Lastname"];
			$data['telephone1'] = $row["telephone1"];
			$data['Mobile1'] = $row["Mobile1"];
			
			$data['address_no'] = $row["AddressNo1"];
			$data['moo'] = $row["Moo1"];
			$data['soi'] = $row["Soi1"];
			$data['road'] = $row["Road1"];
			$data['Sub_district'] = $row["Sub_district1"];
			$data['district'] = $row["district1"];
			$data['province'] = $row["province1"];
			$data['zipcode'] = $row["zipcode1"];
			$data['telephone'] = $row["telephone1"];
			$data['Mobile'] = $row["Mobile1"];
			
			
			$insure_select = $row["insure_select"];
			$SQL_pk3= "select  * from t_motor_premium where id = '$insure_select' " ;
	 	     $result_pk3 = mysql_query($SQL_pk3,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	  		while($objResuut2 = mysql_fetch_array($result_pk3))
			 {
				
				// check การซ่อม
											$premium_type_1_DG = $objResuut2["premium_type_1_DG"];
											$premium_type_1_OG = $objResuut2["premium_type_1_OG"];
											$premium_type_2 = $objResuut2["premium_type_2"];
											$premium_type_2P = $objResuut2["premium_type_2P"];
											$premium_type_3 = $objResuut2["premium_type_3"];
											$premium_type_3P = $objResuut2["premium_type_3P"];
											
											if($premium_type_1_DG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'ซ่อมห้าง';
												$premium = $premium_type_1_DG;
												
											}elseif($premium_type_1_OG != ''){
												$insure_type = 'ชั้น 1';
												$clame_type = 'ซ่อมอู่';
												$premium = $premium_type_1_OG;
												
											}elseif($premium_type_2 != ''){
												$insure_type = 'ชั้น 2';
												$clame_type = '';
												$premium = $premium_type_2;
												
											}elseif($premium_type_2P != ''){
												$insure_type = 'ชั้น 2 Plus';
												$clame_type = '';
												$premium = $premium_type_2P;
												
											}elseif($premium_type_3 != ''){
												$insure_type = 'ชั้น 3';
												$clame_type = '';
												$premium = $premium_type_3;
												
											}elseif($premium_type_3P != ''){
												$insure_type = 'ชั้น 3 Plus';
												$clame_type = '';
												$premium = $premium_type_3P;
											}
											
											$cover_asset = $objResuut2["cover_asset"];
											if($cover_asset != ''){
												$cover_asset = ($cover_asset);
											}

											$cover_person = $objResuut2["cover_person"];
											if($cover_person != ''){
												$cover_person = ($cover_person);
											}
											
											$cover_bodylife = $objResuut2["cover_bodylife"];
											if($cover_bodylife != ''){
												$cover_bodylife = ($cover_bodylife);
											}
											
											$cover_bail_out = $objResuut2["cover_bail_out"];
											if($cover_bail_out != ''){
												$cover_bail_out = ($cover_bail_out);
											}
											
											$cover_xxx = $objResuut2["cover_medical_free"];
											if($cover_xxx != ''){
												$cover_xxx = ($cover_xxx);
											}
											
	
											$cover_pa = $objResuut2["cover_pa"];
											if($cover_pa != ''){
												$cover_pa = ($cover_pa);
											} 
											
											$insurer_name =  $objResuut2["insurer"];
											
											$car_type = $objResuut2["car_type"] ;
											switch ($car_type) {
												case "110":
													$premium_prb = "645.21";
													break;
												case "320":
													$premium_prb = "967.28";
													break;
												case "210":
													$premium_prb = "967.28";
													break;
												case "220":
													$premium_prb = "1182.35";
													break;
												case "230":
													$premium_prb = "2493.28";
													break;
											}
			 }
			 
			 $SQL_pk4= "select  * from t_motor_company where name = '$insurer_name' " ;
	 	     $result_pk4 = mysql_query($SQL_pk4,$Conn) or die ("ไม่สามารถเรียกดูข้อมูลได้");
	  		while($objResuut4 = mysql_fetch_array($result_pk4))
			 {
				 
				 $company_name =  $objResuut4["company_name"];
				 $address1 =  $objResuut4["address1"];
				 $address2 =  $objResuut4["address2"];
				 $phone =  $objResuut4["phone"];
				 $fax =  $objResuut4["fax"];
				 
			 }
			
			$data['Insure_name'] = $company_name;
			$data['Insure_address1'] = $address1;
			$data['Insure_address2'] = $address2.' '.$phone.' '.$fax  ;
			
			
			$data['car_type'] = $car_type;
			$data['car_brand'] = $row["car_brand"];
			$data['car_model'] = $row["car_model"];
			$data['car_license'] = $row["car_license"];
			$data['car_regit_year'] = $row["car_regit_year"];
			$data['body_no'] = $row["body_no"];
			$data['engine_no'] = $row["engine_no"];
			
			$data['cover_person'] = $cover_person ;
			$data['cover_bodylife'] = $cover_bodylife ;
			$data['cover_asset'] = $cover_asset ;
			$data['car_cover'] = $row["car_cover"];
			$data['cover_bail_out'] = $cover_bail_out;
			
			$data['insure_type'] = $clame_type;
			$data['premium_total'] = $premium;

				

            // if we got here, the data should be valid,
            // time to create our FDF file contents

            // need the function definition
            require_once 'createXFDF.php';

            // some variables to use

            // file name will be <the current timestamp>.fdf
            $fdf_file= $row["app_number"].'.fdf';

            // the directory to write the result in
            $fdf_dir=dirname(__FILE__).'/fdfFile';

            // need to know what file the data will go into
			 $pdf_doc='http://192.168.8.250/tubtim/app/motor/Application/Form/CoverNote.pdf';
			 //$pdf_doc='http://localhost/tubtim_temp/app/motor/Application/Form/CoverNote.pdf';

            // generate the file content
            $fdf_data=createXFDF($pdf_doc,$data);

            // this is where you'd do any custom handling of the data
            // if you wanted to put it in a database, email the
            // FDF data, push ti back to the user with a header() call, etc.

            // write the file out

            if($fp=fopen($fdf_dir.'/'.$fdf_file,'w')){
               fwrite($fp,$fdf_data,strlen($fdf_data));
              // echo $fdf_file,' written successfully.';
			   
			   echo "<a href='Download.php?filename=$fdf_file'>Download </a>";


           }else{
               die('Unable to create file: '.$fdf_dir.'/'.$fdf_file);
           }
           fclose($fp);



}


 ?>
