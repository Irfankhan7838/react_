<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header('location:login.php');
die();
}
include '../include/connection.php';
include '../include/global-function.php';
include_once '../security-check.php';

?>
<!doctype html>
<html lang="en">
<head>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  <?php include 'head.php';?>

  	<?php include 'header.php';?> 	

	<title>Add treatment</title>
	<style type="text/css">
		.container {
		  margin: 50px auto;
		}

		.card {
		  margin: 0 auto;
		  width: 100%;
		  /*max-width: 1000PX;*/
		}

		table {
		  margin-top: 20px;
		}

		th {
		  text-align: center;
		}

		.modal-dialog {
		  max-width: 90%;
		}
	/*	#editpatientModal{

		}*/
		.patient_details_div{
	        margin-top: 2rem!important;
		}

		#treatment {
		  max-height: 300px;
		  overflow-y: auto;
		}
		#add_treatment_modal .modal-dialog{
			max-width: 50%;
		}
		#add_payment_modal .modal-dialog{
			max-width: 50%;
		}
		.table_max_width td{
    		max-width: 30%;
    		font-weight: 500;
    		color: #000;
		}
		span#span_P_Name, span#span_P_Email, span#span_P_Phone, span#span_P_DOB, span#span_P_relation, span#span_P_patient_source, span#span_P_Address, span#span_P_Comment, span#span_P_Register_date {
	    font-weight: 400;
	 }
		.my_row_dash {
			background: #fff;
			border-top: 5px solid #2a80b9;
			box-shadow: rgb(99 99 99 / 13%) 0px 2px 8px 0px;
		}
		span.float-right.mb-2 {
			display: flex;
	    justify-content: space-between;
	    width: 32%;
	    align-items: center;;
		}
		.mdl_header {
	    align-items: center;
	    height: 52px;
	    background: #2a80b9;
	    color: #fff;
	  }
		.modal-header .close span {
			font-size: 20px;
		}
		.addess_only {
			height: 85px;
		}
		#add_patient_modal .form-control:focus {
	    border: 1px solid #2a80b9 !important;
	    box-shadow: none !important;
	}

	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		background: #1196CC;
		color: #fff;
	}
	.nav-tabs .nav-link {
    font-size: 18px;
  }
	.dropdown-item:focus, .dropdown-item:hover {
	    color: #16181b;
	    text-decoration: none;
	    background-color: #2a80b9;
	 }
	 #overview_list table tr {
	 	border-top: 1px solid #dee2e6;
	 }
	 #add_patient_modal .modal-dialog {
	 	width: 50%;
	 }
	 .row_4_tab_b {
	 	background: #1196cc;
    padding: 10px 0px 10px 11px;
    color: #fff;
    border-radius: 5px;
	 }
	 .row_4_tab_b b {
	 	font-size: 18px;
	 }
	 .tab_content_dtaa {
	 	 max-height: 500px; 
	 	 overflow: auto;
	 }
	 .editpatientModal_header{
	 	    float: right;
    /* margin-left: 72px; */
    position: absolute;
    right: 50px;   
}
.editpatientModal_header span{
	margin:0px 2px 0px 2px;
}


		@media screen and (max-width: 768px) {
			
			.my_row_dash .col-lg-4, .col-lg-8 {
				margin-top: 20px;
				width: 100%;
				overflow: auto;
			}
			span.float-right.mb-2 {
				float: left !important;
			}
			.table-bordered td, .table-bordered th {
		    border: 1px solid #dee2e6;
		    font-size: 13px;
		    line-height: 17px;
		  }
		  .patient_details_div {
		    margin-top: 1rem!important;
		  }
		  #add_patient_modal .modal-dialog {
			 	width: 96%;
			 }
			 #add_payment_modal .modal-dialog{
				max-width: 100%;
			}
			.modal-dialog {
			  max-width: 100% !important;
			}
			.row_4_tab_b b {
		 	font-size: 16px;
		 }
		 #payment_list h4 {
		 	font-size: 22px !important;
		 }
		 #treatment_list h4 {
		 	font-size: 22px !important;
		 }
		 .tab_content_dtaa {
		    height: 395px;
		    overflow: auto;
		 }
		}
		@media screen and (max-width: 575px) {
			.tab_content_dtaa {
		    height: 395px;
		    overflow: auto;
		 }
		}
		@media screen and (max-width: 375px) {
			.tab_content_dtaa {
		    height: 395px;
		    overflow: auto;
		 }
		} 
	</style>
</head>
<?php
$treatment_name = array('Fillings','Root canal therapy ','Crowns','Bridges','Dentures','Braces');
$treatment_id = array('1','2','3','4','5','6','7','8');
?>

<body>


	<div class="container-fluid patient_details_div">
	  <div class="row justify-content-center">
	    <div class="col-lg-12">
	      <div class="">
	      	<div class="card-body table-bordered mb-4 mx-1 row my_row_dash">

	      		<div class="col-lg-4">
	      			<div id="revenueChart"></div>
	      		</div>
	      		<div class="col-lg-4">
	      			<div id="patientChart"></div>
	      		</div>
	      		<div class="col-lg-4">
	      			<div id="paymentChart"></div>
	      		</div>

			    </div>
	        <div class="card-body table-bordered my_row_dash">

	        	<div class="form-group ">
	        		<button class="btn btn-primary btn-sm float-right mb-3" onclick="open_add_patient_modal()">Add Patient</button>
	        	</div>
	        	<div class="container-fluid px-0">
	        		<div class="row m-0 w-100">
		        		<div class="col-lg-4 ">
		        			<table class="table table-striped table-bordered  mt-4">
		        				<span class="mb-0 text-bold"><strong>Amount Due Report</strong></span>
		        			
		        			    <thead style="line-height: 0.5;">
		        			    	
					              <tr>
					              	<th>Sr.</th>
					                <th>Name</th>
					                <th>Amount Due</th>			                
					              </tr>
					            </thead>
					            <tbody style="line-height: 0.5;">
					            	<?php 
					            	

						            	$amount_due_sql = "SELECT P_id, P_Name,((SELECT COALESCE(SUM(T_cost), 0) AS treat_cost FROM Treatment WHERE T_patient_id = Patient.P_id AND T_status = '0') - (SELECT COALESCE(SUM(Pay_payment), 0) AS Payment_amt FROM Payment WHERE Pay_patient_id = Patient.P_id AND Pay_status = '0') ) AS dues FROM Patient HAVING dues != 0 ORDER BY dues DESC";
										$amount_due_result = sqlQuery($amount_due_sql,"select");
										$sr =1;
										while ($row = mysqli_fetch_assoc($amount_due_result)) {
											echo '<tr><td>'.$sr.'</td>
									            	<td style="color: #3674d1;cursor:pointer;" onclick="open_add_details_modal('.$row['P_id'].')">'.$row['P_Name'].'</td>
									            	<td>'.$row['dues'].'</td></tr>';
									            	$sr++;
										}
										
					            	?>
					            	
					            </tbody>
		        			</table>
		        		</div>
		        		<div class="col-lg-8 pr-0">
			        		<div id="all_patient_div"></div>
		        		</div>

	        		</div>
	        	</div>        		        

	        </div>

	      </div>
	    </div>
	  </div>
	</div>


	<!-- Edit Modal -->
	<div class="modal blur " style="background: #00000082;" id="editpatientModal" tabindex="-1" aria-hidden="true" >
	  <div class="modal-dialog" role="document ">
	    <div class="modal-content" style="background-image: linear-gradient(to right,#fff 11%,#1196cc0f 60%);">
	      <div class="modal-header ">
	        <span class="modal-title" id="editpatientLabel" class="float-left"></span><div class="editpatientModal_header"><span id="edit_overview_span" class="float-right"></span><span id="" class="float-right"><button class="btn btn-primary float-right mb-1 btn-sm" onclick="add_treatment_modal()">Add Treatment</button></span><span id="" class="float-right"><button class="btn btn-primary float-right mb-1 btn-sm" onclick="add_payment_modal()">Add Payment</button></span></div>
	        <button type="button" class="close" onclick="close_add_details_modal()">
	          <span aria-hidden="true"><img src="images/close_black.png"></span>
	        </button>
	      </div>
	      <div class="modal-body" style="border-bottom: 1px solid #1196CC;">
	        <ul class="nav nav-tabs" role="tablist">
	        	<li class="nav-item">
	            <a class="nav-link active" data-toggle="tab" href="#overview" id="overview_tab">Overview</a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link " data-toggle="tab" href="#treatment" id="treatment_tab">Treatment</a>
	          </li>
	          <li class="nav-item">
	            <a class="nav-link" data-toggle="tab" href="#payment" id="Payment_tab">Payment</a>
	          </li>
	        </ul>
	        <div class="tab-content tab_content_dtaa">

	        	<div id="overview" class="tab-pane fade show active mt-2">
	        	<div class="row m-y-3 row_4_tab_b">
	        		<div class="col-lg-3"><b>Total Treatment:</b> <span id="total_treatment"></span></div>
	        		<div class="col-lg-4"><b>Total Treatment Cost:</b> Rs. <span id="total_treatment_cost"></span></div>
	      			<div class="col-lg-3"><b>Total Payment: </b>Rs. <span id="total_payment"></span></div>
	      			<div class="col-lg-2"><b>Total Due: </b>Rs. <span id="total_total_due"></span></div>
	      			
	      		</div>

	          		<div id="overview_list"></div>
	          		
				 <!-- overview Tab Content Goes Here -->	            				    
	            </div>

	          <div id="treatment" class="tab-pane fade show mt-2">
	          	

	          	<div id="treatment_list"></div>
				<!-- Treatment Tab Content Goes Here -->
	            
				    
	          </div>
	          <div id="payment" class="tab-pane fade mt-2">
	          	
	          	<div id="payment_list"></div>

	            <!-- Payment Tab Content Goes Here -->


	            
	          </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	       
	      </div>
	    </div>
	  </div>
	</div>


	<!-- //add treatment -->
	<div id="add_treatment_modal" class="modal blur " style="background: #00000082;"  tabindex="-1" aria-hidden="true" >
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="">Add-Edit treatment</h5>
	        <button type="button" class="close" onclick="close_add_treatment_modal()">
	          <span aria-hidden="true"><img src="images/close_black.png"></span>
	        </button>
	      </div>
	      <div class="modal-body">
	            <div id="" class="tab-pane fade show active">
					<div class="centered-form mt-2">
					  <form id="add_treatment_form" class="send_user_email">

					  	<input type="hidden" name="patient_id" id="patient_id" >	
					    <div class="form-group">
					      <label for="treatment_name" style="font-weight: 500;">Treatment name</label>
					      <select  name="treatment_name" class="form-control"  id="treatment_name">
					      	<option value ="">Treatment Name</option>
					      	<?php
					      	foreach ($treatment_name as $key => $value) {
					      		echo "<option> $value</option>";
					      	}
					      	?>
					      	
					       </select>       
					      <p id="treatment_nameError" class="error-msg"></p>
					    </div>
					    <div class="form-group">
					    	<label for="appointment_date" style="font-weight: 500;">Date</label>
					      <input type="date" class="form-control" name="appointment_date"  id="appointment_date">
					      <p id="appointment_dateError" class="error-msg"></p>
					      
					    </div>

					    <div class="form-group">
						<label for="treatment_cost" style="font-weight: 500;">Treatment cost</label>
					      <input type="number" class="form-control" name="treatment_cost" placeholder="Enter Treatment Cost" id="treatment_cost">
					      <p id="treatment_costError" class="error-msg"></p>
					    </div>					   
					    
					    <input type="hidden" name="action" value="add_treatment">			
					    <input type="hidden" name="treatment_id" id="treatment_id" >			
					    <input type="submit" value="Save" name="add_treatment" class="btn btn-primary mt-2" id="add_treatment">
					    <p id="treatment_error" class="error-msg"></p>
					    <p class="success-msg" id="treatment_success"></p>
					  </form>
					</div>				    
	            </div>
	      </div>
	      <div class="modal-footer">
	       
	      </div>
	    </div>
	  </div>
	</div>


	<!-- //add payment -->
	<div id="add_payment_modal" class="modal blur " style="background: #00000082;"  tabindex="-1" aria-hidden="true" >
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="">Add-Edit Payment</h5>
	        <button type="button" class="close" onclick="close_add_payment_modal()">
	          <span aria-hidden="true"><img src="images/close_black.png"></span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="centered-form mt-2">
			    <form id="add_payment_form" class="send_user_email">

				    <div class="form-group">
				    	<label for="payment_input" style="font-weight: 500;">Amount</label>
				      <input type="number" class="form-control" name="payment"  id="payment_input" placeholder="Enter amount">
				      <p id="paymentError" class="error-msg"></p>
				      
				    </div>	
				    <div class="form-group">
				    	<label for="Payment_datetime" style="font-weight: 500;">Payment datetime</label>
				      <input type="date" class="form-control" name="Payment_datetime"  id="Payment_datetime" >
				      <p id="Payment_datetimeError" class="error-msg"></p>
				      
				    </div>	
				     <div class="form-group">
				     <label for="Payment_method" style="font-weight: 500;">Payment Method</label>
				      <select  name="Payment_method" class="form-control"  id="Payment_method">
				      	<option value ="">Payment Method</option>
				      	<option value ="UPI">UPI</option>
				      	<option value ="Debit card">Debit card</option>
				      	<option value ="Credit card">Credit card</option>
				      	<option value ="Cash">Cash </option>
				      	<option value ="Paytm">Paytm</option>				      	      	
				       </select> 
				      <p id="Payment_methodError" class="error-msg"></p>
				      
				    </div>			   
				    
				    <input type="hidden" name="action" value="add_payment">			
				    <input type="hidden" name="payment_id" id="payment_id" value="">			
				    <input type="hidden" name="payment_patient_id" value="" id="payment_patient_id">			
				    <input type="submit" value="Save" name="add_payment" class="btn btn-primary mt-2" id="add_payment">
				    <p id="add_payment_error" class="error-msg"></p>
				    <p class="success-msg" id="add_payment_success"></p>
				</form>
			</div>


	      </div>
	      <div class="modal-footer">
	       
	      </div>
	    </div>
	  </div>
	</div>

	<!-- //add patient -->
	<div id="add_patient_modal" class="modal blur " style="background: #00000082;"  tabindex="-1" aria-hidden="true" >
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header mdl_header">
	        <h5 class="modal-title" id="" style="font-size: 18px;letter-spacing: .3px;"><span style="margin: 0px 10px 0px 0px;"><img src="images/patient.png"></span>Add-Edit Patient</h5>
	        <button type="button" class="close" onclick="close_add_patient_modal()">
	          <span aria-hidden="true"><img src="images/close.png"></span>
	        </button>
	      </div>
	      <div class="modal-body" style="border-bottom: 1px solid #2a80b9;">
	        <div class="centered-form mt-2">
		        <form id="add_patient" class="send_user_email" >
	              <div class="row mt-3">
	                <div class="col">
	                  <input type="text" class="alphaOnlyWithSpaces form-control inpuuts" name="Name"  placeholder="Name*" id="patient_Name" required>
	                  <p id="patient_Name_error" style="display:none;position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
	                </div>
	                <div class="col">
	                  <input type="text" class="form-control inpuuts" placeholder="Email" id="patient_Email" name="email">
	                  <p id="patient_Email_error" style="display:none;position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
	                </div>
	              </div>
	              <div class="row mt-4">
	                <div class="col">
	                  <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');"  class="form-control inpuuts" placeholder="Phone Number*" id="patient_Phone" name="phone_number" maxlength ="10">
	                <p id="patient_Phone_error" style="display:none;position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
	                </div>
	                 <div class="col">
	                  <input type="date" class="form-control inpuuts" max="<?php echo date('Y-m-d'); ?>" placeholder="DOB*" id="patient_DOB" name="dob">
	                  <p id="patient_DOB_error" style="display:none;position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
	                </div>
	              </div>
	              <div class="row mt-4">
	                <div class="col">
		                 <select class="form-control inpuuts" name="patient_source" id="patient_source">
		                 	<option value=" ">Select Patient source</option>
		                 	<option value="Patient Reference">Patient Reference</option>
		                 	<option value="Family & Friends">Family & Friends</option>
		                 	<option value="Online">Online</option>
		                 	<option value="Social">Social</option>
		                 	<option value="WalkIn">WalkIn</option>   
		                 	<option value="Other">Other</option>   
   	
		                  </select>
		                  <p id="patient_source_error" style="position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
	                </div>
	                <div class="col">
	                 <select class="form-control inpuuts" name="relation" id="patient_relation">
	                 	<option value="Self">Self</option>
	                 	<option value="Spouse">Spouse</option>
	                 	<option value="Child">Child</option>
	                 	<option value="Parent">Parent</option>
	                 	<option value="Others">Others</option>            	
	                 </select>
	                  <p id="patient_relation_error" style="display:none;position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
	                </div>
	              </div>
	              <div class="row mt-4">
	              	 <div class="col">
	                  <input type="text" class="form-control inpuuts " class="addressonly" placeholder="Address" id="Address" name="Address">
	                  <p id="patient_Address_error" style="display:none;position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
	                </div>

	              </div>
	              	<div class="row mt-4">
		                <div class="col-12">
		                  <textarea class="form-control inpuuts " id="patient_Messsage" rows="3" placeholder="Treatment plan" name="Comment"></textarea>
		                  <p id="patient_Messsage_error" style="display:none;position:absolute;color:red;font-size: 12px;margin-bottom: 0px;"></p>
		                </div>
		            </div>
	                <p style="color:green" id="msg"></p>
	              <button type="button" class="btn_submit btn btn-primary" onclick="Addpatient()" id="Addpatient_button">Save</button>
	              
	            

	              <input type="hidden" name="action" value="add_updt_patient"> 
	              <input type="hidden" name="updtpatient_id" id="updtpatient_id" value=""> 

	            </form>
			</div>

	      </div>
	      <div class="modal-footer">
	       
	      </div>
	    </div>
	  </div>
	</div>	



</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script type="text/javascript">

	$('#patient_page_option').change(function(){
		 var url = $(this).val();
        window.location.href = url;
	
	})

	function close_add_payment_modal(){
	   $('#add_payment_modal').hide();
	}

	function add_payment_modal(){
		$('#add_payment_form')[0].reset(true);
		$('#payment_id').val('');
	 	$('#add_payment_modal').show();
	}

	function close_add_treatment_modal(){
	   $('#add_treatment_modal').hide();
	}

	function add_treatment_modal(treatmentid=''){
		$('#add_treatment_form')[0].reset(true);
		$('#treatment_id').val('');
		
		 $('#add_treatment_modal').show();
	}

	function edit_treatment_modal(treatmentid=''){
		if (treatmentid != '') {
			
			$('#treatment_id').val(treatmentid);
			$.ajax({
				url:"patient_webservice.php",
				type:"post",
				dataType:'json',
		      	data:{treatmentid:treatmentid,action:"get_single_treatment_data"} ,					
				success:function(res){
					if (res.code == 1) {	
						$('#treatment_name').val(res.data.T_treatment_name);
						var datetimeStr = res.data.T_appointment_datetime;
						
						var [dateStr, timeStr] = datetimeStr.split(' ');
						
						$('#appointment_date').val(dateStr);
						$('#treatment_cost').val(res.data.T_cost);						
						 $('#add_treatment_modal').show();

					}else{
						
					}
				
				}
			})
			
			
		}
	}
	
	function edit_payment_modal(paymentid=''){
		if (paymentid != '') {
			
			$('#payment_id').val(paymentid);

			$.ajax({
				url:"patient_webservice.php",
				type:"post",
				dataType:'json',
		      	data:{paymentid:paymentid,action:"get_single_payment_data"} ,					
				success:function(res){
					if (res.code == 1) {	
						$('#payment_input').val(res.data.Pay_payment);
						
						var datetimeStr = res.data.Pay_datetime;
					
						var [dateStr, timeStr] = datetimeStr.split(' ');

						
						$('#Payment_datetime').val(dateStr);
						$('#Payment_method').val(res.data.Pay_method);								
						 $('#add_payment_modal').show();

					}else{
						
					}
				
				}
			})
			
			
		}
	}

	function delete_payment_detail(paymentid=''){

		if (paymentid != '') {
			var conf = confirm('Do you really want to delete this payment');
			if (conf) {
				$.ajax({
					url:"patient_webservice.php",
					type:"post",
					dataType:'json',
			      	data:{paymentid:paymentid,action:"remove_payment"} ,					
					success:function(res){
						if (res.code == 1) {
							$('#delete_res_' + paymentid).text('Deleted');
							$('#delete_icon_' + paymentid).hide();
						
							

						}else{
							
						}
					
					}
				})	
			}

		}
	}

	function delete_treatment_detail(treatmentid=''){
		if (treatmentid != '') {
			var conf = confirm('Do you really want to delete this treatment');
			if (conf) {
				$.ajax({
					url:"patient_webservice.php",
					type:"post",
					dataType:'json',
			      	data:{treatmentid:treatmentid,action:"remove_treatment"} ,					
					success:function(res){
						if (res.code == 1) {
							
							$('#delete_res_' + treatmentid).text('Deleted');
							$('#delete_icon_' + treatmentid).hide();

						}else{
							
						}
					
					}
				})
			}
		}

	}


	function close_add_details_modal(patient_id){
		$('#editpatientModal').hide();
	}



	$(document).ready(function(){
		$(document).on('change', '#treatment_page_option', function(){
			
			get_patient_treatment($('#patient_id').val());
		});

		$(document).on('change', '#payment_page_option', function(){
			
			get_patient_payment($('#patient_id').val());
		});

	})

	//getting all patient data
	function get_all_patient(page='',Search=''){
		var Page = page ;	
		var search = Search ;	

		$.ajax({
	 		url:"patient_webservice.php",
	 		type:"post",
	 		dataType:'json',
	      	data:{action:"get_all_patient",page:Page,search:search} ,	
	      	success: function(res){
	      		if (res.code == 1) {
	      			
	      			$('#all_patient_div').html(res.data);
	      			$('#search_patient').val(search);
	      		}else{

	      		}     		    		
	   		 }

		})

	}


	$(document).ready(function(){
		get_all_patient();

	})

    $(document).on('click','#search_patient_btn',function(){
		var search = $('#search_patient').val();
		
		get_all_patient('',search);

		return false;
	})

	$(document).on('change','#patient_page_option',function(){
		var  Page = $('#patient_page_option').val();
		
		get_all_patient(Page);
	})


	function open_add_details_modal(patient_id){
		$('#patient_id').val(patient_id);
		$('#payment_patient_id').val(patient_id);

		$('#treatment_list').html('');
		$('#payment_list').html('');


		get_patient_overview(patient_id);

		get_patient_treatment(patient_id);

        get_patient_payment(patient_id);

		$('#editpatientModal').show();
	}

	function open_add_patient_modal(){
		$('#add_patient').trigger('reset');
		$('#updtpatient_id').val('');

		$('#add_patient_modal').show();
	}
	function close_add_patient_modal(){
		$('#add_patient_modal').hide();
	}

	function open_update_patient_modal(){
		// $('#update_patient').trigger('reset');
		$('#add_patient').trigger('reset');
		$('#updtpatient_id').val('');
		$('#updtpatient_id').val($('#patient_id').val());
		$('#patient_Name').val($('#span_P_Name').text());
		$('#patient_Email').val($('#span_P_Email').text());
		$('#patient_Phone').val($('#span_P_Phone').text());
		$('#patient_DOB').val($('#span_P_DOB').text());
		$('#patient_relation').val($('#span_P_relation').text());
		$('#Address').val($('#span_P_Address').text());
		$('#patient_Messsage').val($('#span_P_Comment').text());
		$('#patient_source').val($('#span_P_patient_source').text());
		$('#add_patient_modal').show();
	}








	function get_patient_treatment(patient_id){
		var Page = 0 ;
	 	Page = $('#treatment_page_option').val();
		$.ajax({
			url:"patient_webservice.php",
			type:"post",
			dataType:'json',
	      	data:{patient_id:patient_id,action:"get_patient_treatment",page:Page} ,					
			success:function(res){
				if (res.code == 1) {
					$('#treatment_list').html(res.data);

				}else{
					$('#treatment_list').html(res.msg);
				}
			
			}
		})
	}

	function get_patient_payment(patient_id){
		var Page = 0 ;
		Page = $('#payment_page_option').val();
		$.ajax({
			url:"patient_webservice.php",
			type:"post",
			dataType:'json',
	      	data:{patient_id:patient_id,action:"get_patient_payment",page:Page} ,					
			success:function(res){
				if (res.code == 1) {

					$('#payment_list').html(res.data);

				}else{
					$('#payment_list').html(res.msg);
				}
			
			}
		})
	}

	function get_patient_overview(patient_id){
		$.ajax({
			url:"patient_webservice.php",
			type:"post",
			dataType:'json',
	      	data:{patient_id:patient_id,action:"get_patient"} ,					
			success:function(res){
				if (res.code == 1) {					
					$('#editpatientLabel').text(res.extra.name);			
					$('#edit_overview_span').html(res.extra.edit_overview);			
					$('#overview_list').html(res.data);					
					$('#total_payment').html(res.total_data.total_payment);
					$('#total_treatment').html(res.total_data.total_treatment);
					$('#total_treatment_cost').html(res.total_data.total_treatment_cost);
					$('#total_total_due').html(res.total_data.total_due);

				}else{
					$('#treatment_error').text(res.msg);
				}
			
			}
		})
	}



	function Addpatient(){ 
        
          var phone_number_regex = /^[6-9]\d{9}$/;
           $('#patient_Name_error').css({display:'block', color:'red'}).empty();

           $('#patient_Email_error').css({display:'block', color:'red'}).empty();
           $('#patient_Phone_error').css({display:'block', color:'red'}).empty();
           $('#patient_Messsage_error').css({display:'block', color:'red'}).empty();
           $('#patient_DOB_error').css({display:'block', color:'red'}).empty();
           $('#patient_Address_error').css({display:'block', color:'red'}).empty();
           $('#patient_relation_error').css({display:'block', color:'red'}).empty();
           $('#patient_source_error').css({display:'block', color:'red'}).empty();
           
           var fname= $('#patient_Name').val();
          
			var nameRegex = /^[a-zA-Z\s]+(?: [a-zA-Z\s]+)*$/;
           if(fname=='')
           {
            $('#patient_Name_error').html("Please Enter Name");
              $('#patient_Name').focus();
            return false;

            }else if (!nameRegex.test(fname)) {
			        $('#patient_Name_error').html("Please Enter Name");
			         $('#patient_Name').focus();
			         return false;
			} else {
			         $('#patient_Name_error').html(" ");	      
			}



           
           // var email= $('#patient_Email').val();
           // if(email=='')
           // {
           //  $('#patient_Email_error').html("Please Enter Emailid");
           //    $('#patient_Email').focus();
           //  return false;

           // }
           // if(!email.match(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/)) {
           //   $('#patient_Email_error').html("Invalid Email");
           //    $('#patient_Email').focus();
           //    return false;
           //   }


             var phone= $('#patient_Phone').val();
              if(phone=='')
           {
            $('#patient_Phone_error').html("Please Enter Phone No");
              $('#patient_Phone').focus();
            return false;

           }
            if (!phone_number_regex.test(phone))
               {
              $('#patient_Phone_error').html("Please Enter valid phone no");
              $('#patient_Phone').focus();
            return false;
                  } 

			var dobRegex = /^\d{4}-\d{2}-\d{2}$/;
            var DOB= $('#patient_DOB').val();
            if(DOB=='')
           {
            $('#patient_DOB_error').html("Please Enter DOB");
              $('#patient_DOB').focus();
            return false;

           } 
		    else if (!dobRegex.test(DOB)) {
		        $('#patient_DOB_error').text('Please enter a valid date of birth in the format YYYY-MM-DD.');
		         return false;
		    } else {
		        $('#patient_DOB').html('');
		    }





            var patient_source= $('#patient_source').val();
           if(patient_source.length < 3)
           {
            $('#patient_source_error').html("Please select patient source");
              $('#patient_source').focus();
            return false;

           }

            var relation= $('#patient_relation').val();
           if(subject=='')
           {
            $('#patient_relation_error').html("Please select relation");
              $('#patient_relation').focus();
            return false;

           }

            var Address= $('#Address').val();
           if(Address=='')
           {
            $('#patient_Address_error').html("Please Enter Address");
              $('#Address').focus();
            return false;

           }

           var subject= $('#patient_Messsage').val();
           if(subject=='')
           {
            $('#patient_Messsage_error').html("Please Enter Message");
              $('#patient_Messsage').focus();
            return false;

           }

           var formdata = new FormData($('#add_patient')[0]);     
            $.ajax({
              	url:"patient_webservice.php",
              	type:"post",
              	processData: false,
                contentType: false,
                data: formdata,         
              	success:function(res){
             	 	var obj=JSON.parse(res);
              
	                if(obj.status=="fail"){
	             		$('#msg').html('<span style="color:red;">' + obj.msg + '</span>');
	             		console.log(obj.msg);
	                }
	                if(obj.status=="success"){
	                  $('#msg').html(obj.msg);
	                    	$('#add_patient').trigger('reset'); 	                    	
	                    	get_all_patient();     	
	                }

                    setTimeout(function() {
					    $('#msg').html('');
					    $('#add_patient_modal').hide(); 
					}, 3000);
              } 
          })
    }

	// $(document).ready(function(){
	// 	$('#Payment_tab').click(function(){
	// 		$('#editpatientLabel').text('Edit Patient Payment');
	// 	})
			
		
	// 	$('#treatment_tab').click(function(){
	// 		$('#editpatientLabel').text('Edit Patient Treatment');
	// 	})

	// 	$('#overview_tab').click(function(){
	// 		$('#editpatientLabel').text('Edit Patient Details');
	// 	})
	// })

	

	$(document).ready(function(){

		$('#add_treatment').click(function(event){
			event.preventDefault();

			var treatment_name = $('#treatment_name').val();
		
		    if (treatment_name.length < 1) {

		        $('#treatment_nameError').text('Please select treatment name.').addClass('text-danger').show();
		    } else {
		        $('#treatment_nameError').hide();		      
		    }
	    

		    var appointment_date = $('#appointment_date').val();
			var datetimeRegex = /^(\d{4})-(\d{2})-(\d{2})$/;
			if (!datetimeRegex.test(appointment_date)) {
			    $('#appointment_dateError').text('Please enter a valid appointment date in the format YYYY-MM-DDTHH:MM.').addClass('text-danger').show();
			} else {
			    $('#appointment_dateError').hide();
			}

		    var amount = $('#treatment_cost').val();
			var amountRegex = /^\d+(\.\d{1,2})?$/;

			if (!amountRegex.test(amount)) {
			    $('#treatment_costError').text('Please enter a valid amount.').addClass('text-danger').show();
			} else {
			    $('#treatment_costError').hide();
			}
    	    
    
		    // continue with form submission if there are no errors
		    if ($('#appointment_dateError').is(':hidden') && $('#treatment_nameError').is(':hidden') && $('#treatment_costError').is(':hidden')) {
		    	var formdata = new FormData($('#add_treatment_form')[0]);			
				$.ajax({
					url:"patient_webservice.php",
					type:"post",
					processData: false,
			      	contentType: false,
			      	data: formdata,	
			      	dataType: "json", 				
					success:function(res){
						if(res.code == 1){					
							$('#add_treatment_form')[0].reset(true);

							$('#treatment_id').val('');
							$('#treatment_success').html(res.msg);
							get_patient_treatment($('#patient_id').val());
							setTimeout(function(){
							    $('#treatment_success').html('');
							    get_patient_overview($('#patient_id').val());
							    
	 							 $('#add_treatment_modal').hide();
							}, 2000);

						}else{
							$('#treatment_error').text(res.msg);
							setTimeout(function(){
							    $('#treatment_error').text('');
							}, 2000);
							
						}

					}
				})
		       
		    }
						
		})


		$('#add_payment').click(function(event){
			event.preventDefault();  


		    var payment = $('#payment_input').val();

			if (payment.length < 1) {
			    $('#paymentError').text('Please enter a valid payment.').addClass('text-danger').show();
			} else {
			    $('#paymentError').hide();
			}



			var paymentmethod = $('#Payment_method').val();

			if (!/^[a-zA-Z\s]+(?: [a-zA-Z\s]+)*$/.test(paymentmethod) || paymentmethod.length < 1) {
			    $('#Payment_methodError').text('Please select payment method.').addClass('text-danger').show();
			} else {
			    $('#Payment_methodError').hide();
			}

		    var Payment_datetime = $('#Payment_datetime').val(); 
			var datetimeRegex = /^(\d{4})-(\d{2})-(\d{2})$/;
			if (!datetimeRegex.test(Payment_datetime)) {
			    $('#Payment_datetimeError').text('Please enter a valid payment date in the format YYYY-MM-DDTHH:MM.').addClass('text-danger').show();
			} else {
			    $('#Payment_datetimeError').hide();
			}


		    // continue with form submission if there are no errors
		    if ($('#Payment_methodError').is(':hidden') &&  $('#paymentError').is(':hidden')) {
		    	var formdata = new FormData($('#add_payment_form')[0]);			
				$.ajax({
					url:"patient_webservice.php",
					type:"post",
					processData: false,
			      	contentType: false,
			      	data: formdata,		
			      	dataType: "json", 			
					success:function(res){
						if(res.code == 1){					
							$('#add_payment_form')[0].reset(true);
							$('#payment_id').val('');
							$('#add_payment_success').html(res.msg);

       						get_patient_payment($('#patient_id').val());

       						setTimeout(function(){
							   $('#add_payment_success').html('');
							    get_patient_overview($('#patient_id').val());
							    $('#add_payment_modal').hide();
							}, 2000);
							
						}else{
							$('#add_payment_error').text(res.msg);
							setTimeout(function(){
							   $('#add_payment_error').text('');
							}, 2000);
							
						}

					}
				})
		       
		    }
						
		})		
	})





</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

	  google.charts.load('current', {packages: ['corechart', 'bar']});
  	  google.charts.setOnLoadCallback(drawpaymentChart);
  	  google.charts.setOnLoadCallback(drawrevenueChart);
  	  google.charts.setOnLoadCallback(drawpatientChart);



		<?php
			 $revenueChartsql = "SELECT MONTH(T_appointment_datetime) AS month,YEAR(T_appointment_datetime) AS year, sum(T_cost) AS total_revenue FROM Treatment WHERE T_status = '0' and T_appointment_datetime >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY year,month  order by year,month";

			$revenue_result = sqlQuery($revenueChartsql,"select");
			
			// Storing results in array
			$revenues = array();
			while ($row = mysqli_fetch_assoc($revenue_result)) {
			    $revenues[$row['month']] = $row['total_revenue'];
			}

			$revenueyValues = array();
			$monthyValues = array();

			foreach ($revenues as $month => $total_revenue) {
			    $index = (int)$month - 1; 
			    $revenueyValues[$index] = (int)$total_revenue;
			    $monthyValues[$index] = $index;
			}


			$revenueyValuesString = implode(",", $revenueyValues);
			$monthyValuesString = implode(",", $monthyValues);


  		?>
	function drawrevenueChart() {
	    var revenuexValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
	    var revenueyValues = [<?php echo $revenueyValuesString; ?>];
	    var monthyValues = [<?php echo $monthyValuesString; ?>];
	    
		var colors = ["#FF6384", "#36A2EB", "#FFCE56", "#7CB342", "#8E24AA", "#00BFA5", "#FF5722", "#673AB7", "#CDDC39", "#F44336", "#03A9F4", "#FF9800"];
	    var data = google.visualization.arrayToDataTable([
	      ['Month', 'Revenue', { role: 'style' }],
	      [revenuexValues[monthyValues[0]], revenueyValues[0],colors[0]],
	      [revenuexValues[monthyValues[1]], revenueyValues[1],colors[1]],
	      [revenuexValues[monthyValues[2]], revenueyValues[2],colors[2]],
	      [revenuexValues[monthyValues[3]], revenueyValues[3],colors[3]],
	      [revenuexValues[monthyValues[4]], revenueyValues[4],colors[4]],
	      [revenuexValues[monthyValues[5]], revenueyValues[5],colors[5]],
	      [revenuexValues[monthyValues[6]],revenueyValues[6],colors[6]],
	      [revenuexValues[monthyValues[7]], revenueyValues[7],colors[7]],
	      [revenuexValues[monthyValues[8]], revenueyValues[8],colors[8]],
	      [revenuexValues[monthyValues[9]], revenueyValues[9],colors[9]],
	      [revenuexValues[monthyValues[10]], revenueyValues[10],colors[10]],
	      [revenuexValues[monthyValues[11]], revenueyValues[11],colors[11]]
	    ]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
           { calc: "stringify",
             sourceColumn: 1,
             type: "string",
             role: "annotation" },2
        ]);

	  	var options = {
	        title: "Revenue of last 12 months",
	        width: 400,
	        height: 200,
	        bar: {groupWidth: "95%"},
	        legend: { position: "none" },
        };

		var chart = new google.visualization.ColumnChart(document.getElementById("revenueChart"));
		chart.draw(view, options);
	}

		<?php
			$paymentChartsql = "SELECT MONTH(Pay_datetime) AS month,YEAR(Pay_datetime) AS year, SUM(Pay_payment) AS total_payment FROM Payment WHERE Pay_status = '0' and Pay_datetime >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY year,month  order by year,month;";

		$payment_result = sqlQuery($paymentChartsql,"select");
		
		// Storing results in array
		$payments = array();
		while ($row = mysqli_fetch_assoc($payment_result)) {
		    $payments[$row['month']] = $row['total_payment'];
		}


		$paymentyValues = array();
		$monthyValues = array();

		foreach ($payments as $month => $total_payment) {
		    $index = (int)$month - 1; 
		    $paymentyValues[$index] = (int)$total_payment;
		    $monthyValues[$index] = $index;
		}


		$paymentyValuesString = implode(",", $paymentyValues);
		$monthyValuesString = implode(",", $monthyValues);


		?>

	function drawpaymentChart() {
	    var paymentxValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
	    var paymentyValues = [<?php echo $paymentyValuesString; ?>];
	    var monthyValues = [<?php echo $monthyValuesString; ?>];
	    var colors = ["#FF6384", "#36A2EB", "#FFCE56", "#7CB342", "#8E24AA", "#00BFA5", "#FF5722", "#673AB7", "#CDDC39", "#F44336", "#03A9F4", "#FF9800"];

	    var data = google.visualization.arrayToDataTable([
	      ['Month', 'Payment', { role: 'style' }],
	      [paymentxValues[monthyValues[0]], paymentyValues[0],colors[0]],
	      [paymentxValues[monthyValues[1]], paymentyValues[1],colors[1]],
	      [paymentxValues[monthyValues[2]], paymentyValues[2],colors[2]],
	      [paymentxValues[monthyValues[3]], paymentyValues[3],colors[3]],
	      [paymentxValues[monthyValues[4]], paymentyValues[4],colors[4]],
	      [paymentxValues[monthyValues[5]], paymentyValues[5],colors[5]],
	      [paymentxValues[monthyValues[6]], paymentyValues[6],colors[6]],
	      [paymentxValues[monthyValues[7]], paymentyValues[7],colors[7]],
	      [paymentxValues[monthyValues[8]], paymentyValues[8],colors[8]],
	      [paymentxValues[monthyValues[9]], paymentyValues[9],colors[9]],
	      [paymentxValues[monthyValues[10]], paymentyValues[10],colors[10]],
	      [paymentxValues[monthyValues[11]], paymentyValues[11],colors[11]]
	    ]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
           { calc: "stringify",
             sourceColumn: 1,
             type: "string",
             role: "annotation" },2
        ]);

	  	 var options = {
	        title: "Payment of last 12 months",
	        width: 400,
	        height: 200,
	        bar: {groupWidth: "95%"},
	        legend: { position: "none" },
	      };

		var chart = new google.visualization.ColumnChart(document.getElementById("paymentChart"));
		chart.draw(view, options);
	}


  		<?php
			 $patientChartsql = "SELECT 
			    MONTH(P_Timestamp) AS month,
			    YEAR(P_Timestamp) AS year,
			    COUNT(*) AS total_Patient
			FROM
			    Patient
			WHERE
			    P_Timestamp >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
			GROUP BY year,month  order by year,month";

			$patient_result = sqlQuery($patientChartsql,"select");
			
			// Storing results in array
			$patients = array();
			while ($row = mysqli_fetch_assoc($patient_result)) {
			    $patients[$row['month']] = $row['total_Patient'];
			}

			//print_r($patients);
			$patientyValues = array();
			$monthyValues = array();
			$temp_arr = array();
			foreach ($patients as $month => $total_patient) {
			    $index = (int)$month - 1; 
			    $patientyValues[$index] = (int)$total_patient;
			    $monthyValues[$index] = $index;
			    $temp_arr[] = array();
			}

			// Convert array to string for use in JavaScript
			$patientyValuesString = implode(",", $patientyValues);
			$monthyValuesString = implode(",", $monthyValues);

  		?>
	function drawpatientChart() {
	  var patientxValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
	  var patientyValues = [<?php echo $patientyValuesString; ?>];
	  var monthyValues = [<?php echo $monthyValuesString; ?>];
	 
	  var colors = ["#FF6384", "#36A2EB", "#FFCE56", "#7CB342", "#8E24AA", "#00BFA5", "#FF5722", "#673AB7", "#CDDC39", "#F44336", "#03A9F4", "#FF9800"];

	  var data = google.visualization.arrayToDataTable([    ['Month', 'Patient', { role: 'style' }],
	    [patientxValues[monthyValues[0]], patientyValues[0], colors[0]],
	    [patientxValues[monthyValues[1]], patientyValues[1], colors[1]],
	    [patientxValues[monthyValues[2]], patientyValues[2], colors[2]],
	    [patientxValues[monthyValues[3]], patientyValues[3], colors[3]],
	    [patientxValues[monthyValues[4]], patientyValues[4], colors[4]],
	    [patientxValues[monthyValues[5]], patientyValues[5], colors[5]],
	    [patientxValues[monthyValues[6]], patientyValues[6], colors[6]],
	    [patientxValues[monthyValues[7]], patientyValues[7], colors[7]],
	    [patientxValues[monthyValues[8]], patientyValues[8], colors[8]],
	    [patientxValues[monthyValues[9]], patientyValues[9], colors[9]],
	    [patientxValues[monthyValues[10]], patientyValues[10], colors[10]],
	    [patientxValues[monthyValues[11]], patientyValues[11], colors[11]],
	  ]);

	  var view = new google.visualization.DataView(data);
	     view.setColumns([0, 1,
	           { calc: "stringify",
	             sourceColumn: 1,
	             type: "string",
	             role: "annotation" },
	           2]);

	 	var options = {
	       title: "Patient of last 12 months",
	        width: 400,
	        height: 200,
	        bar: {groupWidth: "95%"},
	        legend: { position: "none" },
	      };
	  
	  var chart = new google.visualization.ColumnChart(document.getElementById("patientChart"));
	  chart.draw(view, options);
	}


</script>