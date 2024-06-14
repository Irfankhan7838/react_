<?php
include '../include/connection.php';
include '../include/global-function.php';
include_once '../security-check.php';

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	// Filter POST data for harmful code (sanitize)
	foreach($_POST as $key => $value) 
	{
		$data[$key] = filter($value);
	}
}

function validation(){
	$_SESSION['error'] = array();
	

	// if(isset($data['email']) && $data['email']!="" || isset($data['Udtemail']) && $data['Udtemail']!="")
	// {
	// 	if(!preg_match("^[a-zA-Z0-9._-]+[@]{0,1}$^",$data['email']))
	// 	{
	// 		$_SESSION['error']['email']= 'Please Enter Correct Email Address';
	// 	}
	// }

	
	if(isset($data['pwd']) && $data['pwd']!="" )
	{
		if(!preg_match('^[A-Za-z0-9._-]$^',$data['pwd']))
		{
			$_SESSION['error']['pwd']= 'Please Enter your password';
		}
	}

	if(isset($data['phone_number']) && $data['phone_number']!=""  || isset($data['Udtphone_number']) && $data['Udtphone_number']!="")
	{
		if(!preg_match("/^[6-9]{1}[0-9]{9}$/",$data['phone_number']))
		{
			$_SESSION['error']['phone_number']= 'Please enter phone number correctly.';
		}
	}

	if(isset($data['Name'])  && $data['Name']!=""  || isset($data['UdtName']) && $data['UdtName']!="")
	{
		if(!preg_match ("/^[a-zA-Z\s]+(?: [a-zA-Z\s]+)*$/",$data['Name']))
		{
			$_SESSION['error']['Name']= 'Please enter name correctly.';
		}
	}

	if(isset($data['dob']) && $data['dob']!=""  || isset($data['Udtdob']) && $data['Udtdob']!="") {
	    if(!preg_match ("/^\d{4}-\d{2}-\d{2}$/", $data['dob'])) {
	        $_SESSION['error']['dob'] = 'Please enter a valid date of birth in the format YYYY-MM-DD.';
	    }
	}

	if(isset($data['Address']) && $data['Address']!=""  || isset($data['UdtAddress']) && $data['UdtAddress']!="") {
	    if(!preg_match ("/^[a-zA-Z0-9\s,'-]+$/", $data['Address'])) {
	        $_SESSION['error']['Address'] = 'Please enter a valid address.';
	    }
	}

	return $_SESSION['error'];
}

//add update  patient 
if ($data['action'] == 'add_updt_patient') {

	$err= validation($data);		
	if(!empty($err)){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>$err));
		die();
	 
	}else{
		if(empty($data['updtpatient_id'])){
			 $existing_patient_sql = "SELECT * FROM Patient where P_Phone ='".$data['phone_number']."' and P_relation ='".$data['relation']."'";
			
			$existing_patient_query = sqlQuery($existing_patient_sql,"select");
			$patient_count = mysqli_num_rows($existing_patient_query);
			if ($patient_count >0) {
				echo json_encode(array('status'=>'fail','code'=>'0','msg'=>'patient already exist'));
				die();
			}

			$sql = "insert into Patient (P_User_id,P_Name,P_Phone,P_Email,P_Address,P_DOB,P_Comment,P_relation,P_patient_source) values('".$_SESSION['user_id']."','".$data['Name']."','".$data['phone_number']."','".$data['email']."','".$data['Address']."','".$data['dob']."','".$data['Comment']."','".$data['relation']."','".$data['patient_source']."')";
			
			$insert = sqlQuery($sql,"insert"); 
			if ($insert) {
				echo json_encode(array('status'=>'success','code'=>'1','msg'=>'Patient added successfully'));
			}
			
		}else{

			 $sql = "update Patient set  P_User_id = '".$_SESSION['user_id']."' ,  P_Name = '".$data['Name']."' , P_Email = '".$data['email']."' , P_Phone = '".$data['phone_number']."' , P_DOB = '".$data['dob']."' , P_Address = '".$data['Address']."' , P_Comment = '".$data['Comment']."' , P_relation = '".$data['relation']."', P_patient_source = '".$data['patient_source']."' where P_id ='".$data['updtpatient_id']."'";
			
			$update = sqlQuery($sql,"update"); 

			if (!$update) {
				echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"Details not updated"));
				die();
			}else{
				echo json_encode(array('status'=>'success','code'=>'1','msg'=>"<span style='color:green;'>Details updated successfully</span>"));
			}
		}

	}
} 



//get single patient detail
if ($data['action'] == 'get_patient') {
		
	if(empty($data['patient_id'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select patient"));
		die();
	 
	}else{

		$total_treatment = array();
		setlocale(LC_MONETARY, 'en_IN');

		//total treatment
		$total_treatment_sql = "SELECT count(*) as total_treatment FROM Treatment where T_status = '0' and T_patient_id ='".$data['patient_id']."'";
		$total_treatment = sqlQuery($total_treatment_sql,"select");
		$total['total_treatment'] =  mysqli_fetch_assoc($total_treatment)['total_treatment'];

		//total payment
		$total_payment_sql = "SELECT sum(Pay_payment) as total_payment FROM Payment where Pay_status = '0' and  Pay_patient_id ='".$data['patient_id']."'";
		$total_payment = sqlQuery($total_payment_sql,"select");
		$total['total_payment'] = money_format('%!i', mysqli_fetch_assoc($total_payment)['total_payment']); 
		if (empty($total['total_payment'])) {
			$total['total_payment'] = 0;
		}

		//total treatment cost
		$total_treatment_cost_sql = "SELECT sum(T_cost) as total_treatment_cost FROM Treatment where T_status = '0' and T_patient_id ='".$data['patient_id']."'";
		$total_treatment_cost = sqlQuery($total_treatment_cost_sql,"select");
		$total['total_treatment_cost'] = money_format('%!i', mysqli_fetch_assoc($total_treatment_cost)['total_treatment_cost']); 
		if (empty($total['total_treatment_cost'])) {
			$total['total_treatment_cost'] = 0;
		}

		//total due of this patient
		$total_due_sql = "SELECT P_id, P_Name,((SELECT COALESCE(SUM(T_cost), 0) AS treat_cost FROM Treatment WHERE T_patient_id = Patient.P_id AND T_status = '0') - (SELECT COALESCE(SUM(Pay_payment), 0) AS Payment_amt FROM Payment WHERE Pay_patient_id = Patient.P_id AND Pay_status = '0') ) AS dues FROM Patient where P_id= '".$data['patient_id']."' HAVING dues != 0 ORDER BY dues DESC";
		$total_due = sqlQuery($total_due_sql,"select");
		$total['total_due'] = money_format('%!i', mysqli_fetch_assoc($total_due)['dues']); 

		if (empty($total['total_due'])) {
			$total['total_due'] = 0;
		}

		$sql = "select P_Name,P_Phone,P_Email,P_Address,P_DOB,P_relation,P_patient_source,P_Comment,P_Timestamp from Patient where P_id ='".$data['patient_id']."'";
		$query = sqlQuery($sql,"select"); 
		$patient_data = mysqli_fetch_assoc($query);
		$num_row = mysqli_num_rows($query);
		$data = "";
		if ($num_row < 1) {
			echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"No patient found"));
			die();
		}else{
			$data .= '<div class="row m-3">
	          			<div class="col-sm-12 table-responsive">
							<table class="table table_max_width">
								<tr>
																			
									<td >
										<div class="row">
										  <div class="col-lg-4">Name: </div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_Name">'.$patient_data['P_Name'].'</span>
										  </div>
										</div>
									</td>

									<td >
										<div class="row">
										  <div class="col-lg-4">Email: </div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_Email">'.$patient_data['P_Email'].'</span>
										  </div>
										</div>
									</td>

									<td >
										<div class="row">
										  <div class="col-lg-4">Phone: </div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_Phone">'.$patient_data['P_Phone'].'</span>
										  </div>
										</div>
									</td>
								</tr>
					
							
								<tr  >

								    <td >
										<div class="row">
										  <div class="col-lg-4">DOB: </div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_DOB">'.$patient_data['P_DOB'].'</span>
										  </div>
										</div>
									</td>

									<td >
										<div class="row">
										  <div class="col-lg-4">Relation: </div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_relation">'.$patient_data['P_relation'].'</span>
										  </div>
										</div>
									</td>

									<td >
										<div class="row">
										  <div class="col-lg-4">Source:</div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_patient_source">'.$patient_data['P_patient_source'].'</span>
										  </div>
										</div>
									</td>
								</tr>
			
								<tr >

								    <td >
										<div class="row">
										  <div class="col-lg-4">Address: </div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_Address">'.$patient_data['P_Address'].'</span>
										  </div>
										</div>
									</td>

									<td >
										<div class="row">
										  <div class="col-lg-4">Register Date: </div>
										  <div class="col-lg-8">
										    <span class=" mr-1" id="span_P_Register_date">'.date('j M Y', strtotime($patient_data['P_Timestamp'])).'</span>
										  </div>
										</div>
									</td>
								</tr>
								<tr>
									<td >
										<div class="row">
										  <div class="col-lg-6">Treatment plan: </div>
										  <div class="col-lg-6">
										    <span class=" mr-1" id="span_P_Comment">'.$patient_data['P_Comment'].'</span>
										  </div>
										</div>
									</td>
								</tr>

								
							</table>
						</div>
	          		</div>';
	          		$extra = array();
	          		$extra['edit_overview'] = '<button onclick="open_update_patient_modal()" class="btn btn-primary btn-sm">Update Detail</button>';
	          		$extra['name'] = $patient_data['P_Name'];

			echo json_encode(array('status'=>'success','code'=>'1','data'=>$data, 'total_data' => $total, 'tsql' => $total_due_sql,'extra'=>$extra));
		}
		
	}
}

//get all patient
if ($data['action'] == 'get_all_patient') {
	$html = "";
 	$html .= '<table class="table table-striped table-bordered  mt-4">
	            <thead style="line-height: 0.5;">
	              <tr>
	              	<th>Sr.</th>
	                <th>Name</th>
	                <th>Phone</th>
	                <th>Email</th>
	                <th>DOB</th>
	                <th>Edit</th>
	              </tr>
	            </thead>
	            <tbody style="line-height: 0.5;">';
	            	
	            	if (isset($data['search']) && !empty($data['search'])) {
	            		$search_cond = "where P_Name like '%".$data['search']."%' or P_Phone like '%".$data['search']."%' or P_Email like '%".$data['search']."%'";
	            		
	            	}else{
	            		$search_cond = " ";
	            	}

	               $pagin ="";

	            	$records_per_page = 50;

	             	// current page number from the URL
					if (isset($data['page']) && is_numeric($data['page'])) {
					    $current_page = (int) $data['page'];
					} else {
					    $current_page = 1;
					}

					//  offset for the current page
					$offset = ($current_page - 1) * $records_per_page;

					// number of records

					$sql1 = "SELECT COUNT(*) FROM Patient $search_cond";
					$result1 = sqlQuery($sql1,"select");
					$row = mysqli_fetch_row($result1);
					$total_records = $row[0];

        			 // Calculate the total number of pages
					$total_pages = ceil($total_records / $records_per_page);

					// Retrieve the records for the current page
					$sql2 = "SELECT * FROM Patient $search_cond order by P_Updated_timestamp desc LIMIT $offset, $records_per_page";
					$result2 = sqlQuery($sql2,"select");



					if ($total_pages > 1) {

						$pagin .= "<b>Patient list </b>&nbsp;&nbsp;&nbsp;<select id='patient_page_option'>";

						for ($i = 1; $i <= $total_pages; $i++) {
							$qstr = preg_replace("/&page=[0-9]+/","",$_SERVER['QUERY_STRING']);
							$selected = ($data['page'] == $i)?"selected='selected'":"";
							$pagin .= "<option value= '".$i."' $selected>$i</option>";
						}
						$pagin .= "</select> of ".$total_pages;
				   	}
															        
					$html .= '<span class="float-right mb-2"><input type="text"  placeholder="Search" id="search_patient" >
	            		<button id="search_patient_btn" class="btn btn-success btn-sm">Search </button></span>';
	            	$sr =1;
	            	$total_record = mysqli_num_rows($result2);
	            	if ($total_record > 0) {
	            		while ($fetch = mysqli_fetch_assoc($result2)) {	
				            $html .= "<tr>
				               <td>".$sr.".</td>
				               <td>".$fetch['P_Name']."</td>
				               <td>".$fetch['P_Phone']."</td>
				               <td>".$fetch['P_Email']."</td>
				               <td>".$fetch['P_DOB']."</td>
				          
				                <td><i class='fa fa-pencil' onclick='open_add_details_modal(".$fetch['P_id'].")' style='cursor:pointer;'></i></td>
				             </tr>";	
				             $sr ++;
		            	 }
	            	}else{
	            		$html .= "<tr><td colspan='6' class='text-center'>No Patient found<td></tr>";
	            	}


	            	
	            	                          
	            $html .= " </tbody>    
	        </table>";
	        echo json_encode(array('status'=>'success','code'=>'1','data'=>$pagin.$html , 'query'=>$sql2));

}



// get_single_treatment_data
if ($data['action'] == 'get_single_treatment_data') {
	if(empty($data['treatmentid'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select treatment"));
		die();
	 
	}else{

		$sql = "select * from Treatment where T_id ='".$data['treatmentid']."' and T_status = '0'";
			$result = sqlQuery($sql,"select");
			$row = mysqli_fetch_assoc($result);
			echo json_encode(array('status'=>'success','code'=>'1','data'=>$row));
			

	}
}


// get_single_payment_data
if ($data['action'] == 'get_single_payment_data') {
	if(empty($data['paymentid'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select Payment"));
		die();
	 
	}else{

		$sql = "select * from Payment where Pay_id ='".$data['paymentid']."' and Pay_status = '0'";
			$result = sqlQuery($sql,"select");
			$row = mysqli_fetch_assoc($result);
			echo json_encode(array('status'=>'success','code'=>'1','data'=>$row));
			

	}
}


//get single patient treatment
if ($data['action'] == 'get_patient_treatment') {
		
	if(empty($data['patient_id'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select patient"));
		die();
	 
	}else{

			$pagin ="";

			  $records_per_page = 10;

	    	// current page number from the URL
			if (isset($data['page']) && is_numeric($data['page'])) {
			    $current_page = (int) $data['page'];
			} else {
			    $current_page = 1;
			}

			//  offset for the current page
			$offset = ($current_page - 1) * $records_per_page;

			// number of records


			$sql1 = "select COUNT(*) from Treatment where T_patient_id ='".$data['patient_id']."' and T_status ='0'";
			$result1 = sqlQuery($sql1,"select");
			$row = mysqli_fetch_row($result1);
			$total_records = $row[0];

			 // Calculate the total number of pages
			$total_pages = ceil($total_records / $records_per_page);

			if ($total_pages > 1) {

				$pagin .= "<select id='treatment_page_option'>";

					for ($i = 1; $i <= $total_pages; $i++) {
						$qstr = preg_replace("/&page=[0-9]+/","",$_SERVER['QUERY_STRING']);
						$selected = ($data['page'] == $i)?"selected='selected'":"";
						$pagin .= "<option value= '".$i."' $selected>$i</option>";
					}
				$pagin .= "</select> of ".$total_pages;
			}

			$sql = "select T_id,T_patient_id,T_cost,T_treatment_name,T_appointment_datetime from Treatment where T_patient_id ='".$data['patient_id']."' and T_status ='0' order by T_appointment_datetime LIMIT $offset, $records_per_page";
			$query = sqlQuery($sql,"select"); 
			
			$num_row = mysqli_num_rows($query);
		if ($num_row < 1) {
			echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"<h4 style='color:red;'><center>No Treatment found</h4><center>"));
			die();
		}else{
			$data = "";
			$data .= '
			    <table class="table table-striped table-bordered  mt-4">
		            <thead>
		              <tr>
		              	<th>Sr.</th>
		              	<th>Appointment Date</th>
		                <th>Treatment Name</th>		                		                
		                <th>Cost</th>
		                <th>Action</th>
     
		              </tr>
		            </thead>
		        <tbody>';
		        $sr = 1;

			    while ($treatment_data = mysqli_fetch_assoc($query)) {
			             	$data .= " <tr>
					               <td>".$sr.".</td>
					               <td>".date('j M Y', strtotime($treatment_data['T_appointment_datetime']))."</td>
					               <td>".$treatment_data['T_treatment_name']."</td>					
					               <td>".$treatment_data['T_cost']."</td>
					               <td ><i class='fa fa-pencil' style=' cursor:pointer;' onclick='edit_treatment_modal(".$treatment_data['T_id'].")'></i>&nbsp; &nbsp;&nbsp;<i id='delete_icon_".$treatment_data['T_id']."' class='fa fa-trash' style='color:red ; cursor:pointer;' onclick='delete_treatment_detail(".$treatment_data['T_id'].")'></i>&nbsp;<span class='text-danger' id='delete_res_".$treatment_data['T_id']."'></span></td>
					                
					             </tr>";
			             $sr ++;
			    }        
			    $data .= "</tbody>
	            			</table>";  
			echo json_encode(array('status'=>'success','code'=>'1','data'=>$pagin.$data));
		}
		
	}
}

//get single patient payment
if ($data['action'] == 'get_patient_payment') {
		
	if(empty($data['patient_id'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select patient"));
		die();
	 
	}else{
		$pagin = "";
	    	$records_per_page = 10;

	    	// current page number from the URL
			if (isset($data['page']) && is_numeric($data['page'])) {
			    $current_page = (int) $data['page'];
			} else {
			    $current_page = 1;
			}

			//  offset for the current page
			$offset = ($current_page - 1) * $records_per_page;

			// number of records

			$sql1 = "select COUNT(*) from Patient RIGHT JOIN Payment ON Patient.P_id = Payment.Pay_patient_id where P_id ='".$data['patient_id']."' and Pay_status ='0'";
			$result1 = sqlQuery($sql1,"select");
			$row = mysqli_fetch_row($result1);
			$total_records = $row[0];

			 // Calculate the total number of pages
			$total_pages = ceil($total_records / $records_per_page);

			if ($total_pages > 1) {
				$pagin .= "<select id='payment_page_option'>";

				for ($i = 1; $i <= $total_pages; $i++) {
					$qstr = preg_replace("/&page=[0-9]+/","",$_SERVER['QUERY_STRING']);
					$selected = ($data['page'] == $i)?"selected='selected'":"";
					$pagin .= "<option value= '".$i."' $selected>$i</option>";
				}
				$pagin .= "</select> of ".$total_pages;
			}

			
			


	    $sql = "select Pay_id,P_id ,Pay_method,Pay_datetime,Pay_patient_id,Pay_payment from Patient RIGHT JOIN Payment ON Patient.P_id = Payment.Pay_patient_id where P_id ='".$data['patient_id']."' and Pay_status ='0' order by Pay_datetime LIMIT $offset, $records_per_page";
		$query = sqlQuery($sql,"select"); 
		
		$num_row = mysqli_num_rows($query);
		if ($num_row < 1) {
			echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"<h4 style='color:red;'><center>No Payment found</h4><center>"));
			die();
		}else{
			$data = "";
			$data .= '
			    <table class="table table-striped table-bordered  mt-4">
		            <thead>
		              <tr>
		              	<th>Sr.</th>
		              	<th>Payment Date</th>		                
		                <th>Payment method</th>	 
		                <th>Amount</th>             	                	
		                <th>Action</th>              
		                             
     
		              </tr>
		            </thead>
		            <tbody> ';
		        $sr = 1;

			    while ($payment_data = mysqli_fetch_assoc($query)) {
			             	$data .= " <tr>
				               <td>".$sr.".</td>
				               <td>".date('j M Y', strtotime($payment_data['Pay_datetime']))."</td>
				               <td>".$payment_data['Pay_method']."</td> 
				               <td>".$payment_data['Pay_payment']."</td>			                              			               
				               <td ><i class='fa fa-pencil' style=' cursor:pointer;' onclick='edit_payment_modal(".$payment_data['Pay_id'].")'></i>&nbsp; &nbsp;&nbsp;<i class='fa fa-trash' id='delete_icon_".$payment_data['Pay_id']."' style='color:red ; cursor:pointer;' onclick='delete_payment_detail(".$payment_data['Pay_id'].")'></i>&nbsp;<span class='text-danger' id='delete_res_".$payment_data['Pay_id']."'></span></td>        

				                           
				             </tr>";	
			             $sr ++;
			    }        
			    $data .= "</tbody>
	            			</table>";  
			echo json_encode(array('status'=>'success','code'=>'1','data'=>$pagin.$data));
		}
		
	}
}

//add patient treatment
if ($data['action'] == 'add_treatment') {
		
	if(empty($data['patient_id'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select patient"));
		die();
	 
	}else{

		if (!empty($data['treatment_id'])) {
			 $sql = "update Treatment set T_treatment_name = '".$data['treatment_name']."',T_appointment_datetime = '".$data['appointment_date'].' '.date('h:i:s')."' ,T_cost= '".$data['treatment_cost']."' where T_id = '".$data['treatment_id']."'";
			$update = sqlQuery($sql,"update"); 

			if (!$update) {
				echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"Treatment not updated"));
				die();
			}else{
				echo json_encode(array('status'=>'success','code'=>'1','msg'=>"<span style='color:green;'>Treatment updated successfully</span>"));
			}			
		}else{
			$sql = "insert into Treatment (T_patient_id,T_userid,T_treatment_name,T_appointment_datetime,T_cost) values('".$data['patient_id']."','".$_SESSION['user_id']."','".$data['treatment_name']."','".$data['appointment_date'].' '.date('h:i:s')."','".$data['treatment_cost']."')";
			$insert = sqlQuery($sql,"insert"); 

			if (!$insert) {
				echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"Treatment not added"));
				die();
			}else{
				echo json_encode(array('status'=>'success','code'=>'1','msg'=>"<span style='color:green;'>Treatment added successfully</span>"));
			}
		}
		

		
	}
}
	

//add patient payment
if ($data['action'] == 'add_payment') {
		
	if(empty($data['payment_patient_id'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select patient"));
		die();
	 
	}else if(empty($data['payment'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please enter payment"));
		die();

	}else if(empty($data['Payment_method'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select payment method"));
		die();

	}else{

		if (!empty($data['payment_id'])) {
			 $sql = "update Payment set Pay_userid = '".$_SESSION['user_id']."',Pay_payment = '".$data['payment']."' ,Pay_datetime= '".$data['Payment_datetime'].' '.date('h:i:s')."' ,Pay_method = '".$data['Payment_method']."' where Pay_id = '".$data['payment_id']."'";
			$update = sqlQuery($sql,"update"); 

			if (!$update) {
				echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"Payment not updated"));
				die();
			}else{
				echo json_encode(array('status'=>'success','code'=>'1','msg'=>"<span style='color:green;'>Payment updated successfully</span>"));
			}
		}else{
			$sql = "insert into Payment (Pay_userid,Pay_patient_id,Pay_payment,Pay_method,Pay_datetime) values('".$_SESSION['user_id']."','".$data['payment_patient_id']."','".$data['payment']."','".$data['Payment_method']."','".$data['Payment_datetime'].' '.date('h:i:s')."')";
			$insert = sqlQuery($sql,"insert"); 

			if (!$insert) {
				echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"payment not added"));
				die();
			}else{
				echo json_encode(array('status'=>'success','code'=>'1','msg'=>"<span style='color:green;'>Payment added successfully</span>"));
			}
		}
		

		
	}
}


//remove patient treatment	
if ($data['action'] == 'remove_treatment') {
	if(empty($data['treatmentid'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select treatment"));
		die();

	}else{
		$sql = "update Treatment set  T_status = '1' where T_id ='".$data['treatmentid']."'";
		$update = sqlQuery($sql,"update");
		if (!$update) {
			echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"treatment not deleted"));
			die();
		}else{
			echo json_encode(array('status'=>'success','code'=>'1','msg'=>"<span style='color:green;'>treatment deleted successfully</span>"));
		} 
	}
}


//remove patient payment	
if ($data['action'] == 'remove_payment') {
	if(empty($data['paymentid'])){
		echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"please select payment"));
		die();

	}else{
		$sql = "update Payment set  Pay_status = '1' where Pay_id ='".$data['paymentid']."'";
		$update = sqlQuery($sql,"update");
		if (!$update) {
			echo json_encode(array('status'=>'fail','code'=>'0','msg'=>"Payment not deleted"));
			die();
		}else{
			echo json_encode(array('status'=>'success','code'=>'1','msg'=>"<span style='color:green;'>Payment deleted successfully</span>"));
		} 
	}
}
