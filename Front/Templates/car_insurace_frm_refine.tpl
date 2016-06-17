<style>
.self-medium-icon span{
 font-size:30px !important;
}
</style>
<div class="row">
<a href="javascript:void(0);" class="back-btn" onclick="stepnext(4,'')"><i class="fa fa-angle-left"></i> Back</a>
</div>
<form id="frm_vehicle_refined" name="frm_vehicle_refined" action="results" class="form-horizontal" data-before="refined_form_validation()">
 <input type="hidden" name="opcode" value="refine_quote" class="ajx-control" />
 <input type="hidden" id="insurance_customer_vehicle_id">
            	<div class="row">
                	<div class="step-four-wrap step-five-wrap">
                    	<div class="row">
                            <div class="col-md-4 col-xs-12 mob-border">
                                <div class="refine-block">
                                    <h3>Refine Selected Quote</h3>
                                    <p>Our refine quote option allows you to take control of your insurance and build your own cover according to what you need and what you can afford.</p>
                                </div>
                               
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="select-quote hidden-xs">
                                	<h4>Selected Quote</h4>
                                    <div class="selected-box">
                                    	<h2 id="selected_quote_value">R 0.00</h2>
                                        <div class="caption text-center">
                                        	<label class="selected_company_name"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mob-select-quote hidden-sm hidden-md hidden-lg">
                                    <div class="selected-box">
                                    	<h4>Selected</h4>
                                    	<h2 id="selected_quote_value">R 0.00</h2>
                                        <div class="caption text-center">
                                        	<button class="btn btn-blue">Select and Proceed</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="select-quote hidden-xs">
                                	<h4>Selected Quote</h4>
                                    <div class="selected-box refine-box">
                                    	<h2 id="refined_quote_value">R 0.00</h2>
                                        <div class="caption text-center">
                                        	<p>
                                            	Add in the features you want & leave out the ones that you don’t want.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						 
						<div class="quote-base">
                                    <small>These quotes are based on:</small>
                                    <h4 id="quotes_based_on">-</h4>
                        </div>
						 
						
                        <div class="s4-table-wrap s5-table-wrap hidden-xs hidden-sm">
                        	<table class="table table-striped">
                                <tbody>
                                	<tr>
										<td><strong>Cover Type</strong>
                                        <a class="tooltip-tag" for="covertype" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Comprehensive: Cover for accident damage and theft of your vehicle. Includes damage caused to other parties and their property." href="#"><i class="ques-tooltip"></i></a>

										</td>
                                        <td><span id="quote_covertype">Comprehensive</span></td>
                                        <td>
                                        	<select id="covertype" name="covertype" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Third Party Liability</strong></td>
                                        <td><span id="quote_thirdpartyliability"><i class="s4-check"></i></span></td>
                                        <td>
                                        	<select name="thirdpartyliability" id="thirdpartyliability"  class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Insured ValueType</strong>
                                        <a class="tooltip-tag" type="button" data-toggle="tooltip" data-placement="top" title="Insured ValueType" href="#"><i class="ques-tooltip"></i></a></td>
                                        <td><span id="quote_insuredvaluetype">Retail</span></td>
                                        <td>
                                        	<select name="insuredvaluetype" id="insuredvaluetype" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Excess</strong></td>
                                        <td><span id="quote_excess">R 4 600.00</span></td>
                                        <td>
                                     		<input type="text" class="form-control ajx-control"  id="excess" name="excess" required>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Hail Cover</strong></td>
                                        <td><span id="quote_hailcover"><i class="s4-check"></i></span></td>
                                        <td>
                                        	<select name="hailcover" id="hailcover" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Windscreen Cover</strong></td>
                                        <td><span id="quote_windscreencover"><i class="s4-check"></i></span></td>
                                        <td>
                                        	<select name="windscreencover" id="windscreencover" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Buy Up Assist Cover</strong></td>
                                        <td><span id="quote_assistcover">-</span></td>
                                        <td>
                                        	<select name="assistcover" id="assistcover" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Car Hire</strong></td>
                                         <td><span id="quote_carhire"><i class="s4-check"></i></span></td>
                                        <td>
                                        	<select name="carhire" id="carhire" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Car Hire Option*</strong></td>
                                        <td><span id="quote_carhireoption"><i class="s4-check"></i></span></td>
                                        <td>
                                        	<select name="carhireoption" id="carhireoption" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Radio Cover</strong></td>
                                        <td><span id="quote_radiocover"><i class="s4-check"></i></span></td>
                                        <td>
                                        	<select name="radiocover" id="radiocover" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Radio Cover Value*</strong></td>
                                        <td><span id="quote_radiocoveroption">-</span></td>
                                        <td>
                                        	<select name="radiocoveroption"  id="radiocoveroption" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Canopy Cover</strong></td>
                                        <td><span id="quote_canopycover">R1 200</span></td>
                                        <td>
                                        	<select name="canopycover" id="canopycover" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Voluntary Excess*</strong></td>
                                        <td><span id="quote_voluntaryexcess">-</span></td>
                                        <td>
                                        	<select name="voluntaryexcess" id="voluntaryexcess" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Intended Policy Holder Date of Birth*</strong></td>
                                           <td><span id="quote_holderdob">-</span></td>
                                        <td>
                                        	<div class="form-group">
                                            	<div class="input-group date" id="sandbox-container" data-provide="datepicker">
                                              		<input type="text"  name="holderdob"  class="form-control datepicker ajx-control" data-date-format="mm/dd/yyyy" required>
                                                    <div class="input-group-addon self-medium-icon">
                                                        <span  id="holderdob"></span>
                                                    </div>
                                            	</div>
                                          	</div>
										
										</td>
                                    </tr>
                                    <tr>
										<td><strong>Theft Excess Buster Product</strong></td>
                                        <td><span id="quote_theftexcessbuster">-</span></td>
                                        <td>
                                        	<select name="theftexcessbuster" id="theftexcessbuster" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Accident Cover (Saver Products)</strong></td>
										<td><span id="quote_accidentcover"><i class="s4-check"></i></span></td>
                                        <td>
                                        	<select name="accidentcover"  id="accidentcover" class="selectpicker show-tick form-control ajx-control" required>
                                                <option value="">Select</option>
                                              
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Accident Cover Option*</strong></td>
                                        <td><span id="quote_accident_cover">-</span></td>
                                        <td>
                                        	<select name="accidentcoveroption"  id="accidentcoveroption" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Total Loss (Saver Product)</strong></td>
                                        <td><span id="quote_totalloss">-</span></td>
                                        <td>
                                        	<select id="totalloss" name="totalloss" class="selectpicker show-tick form-control ajx-control" required>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
										<td><strong>Public Liability</strong></td>
                                        <td><span id="quote_publicliability">-</span></td>
                                        <td>
                                        	<select id="publicliability"  name="publicliability" class="selectpicker show-tick form-control ajx-control" required>
                                                <option value="">Select</option>
                                            </select>
                                        </td>
                                    </tr>
									<tr class="color-tables">
										<td class="col-tab-premium"><strong>Monthly Premium</strong></td>
                                        <td class="col-tab-pink"><span id="selected_quote_value_monthly">R 0.00</span></td>
                                        <td class="col-tab-black">
                                        	<span id="refined_quote_value_monthly">R 0.00</span>
                                        </td>
                                    </tr>
                                    <tr class="cmb-last">
										<td></td>
                                        <td class="cmb">
                                        	<label class="selected_company_name"></label>
                                            <button type="button" class="btn btn-blue" onmouseup="showLoading();" onclick="buy_insurance();" >Get quote</button>
                                            <a href="javascript:callme_nold();">Call me Back</a>
                                        </td>
                                         <td class="cmb">
                                        	<p>
                                            	Add in the features you want & leave out the ones that you don’t want.
                                            </p>
                                            
											{if $isGuest == 0}
											<button type="button" class="btn btn-blue" onclick="submit_quote();">Refine Quote</button>
											{else}
											<button type="button" class="btn btn-blue" onclick="signin_popup('Login to refine quote.');">Refine Quote</button>
											{/if}

											
                                            <button type="button" style="margin-top:10px;" onmouseup="showLoading();" onclick="buy_insurance();" class="btn btn-blue">Get quote</button>
                                        </td>
                                    </tr>
									<tr>
									 <td colspan="3">
									  <p style="color:#888888;text-align: center;">Quotes provided are indicative and are not guaranteed.</p>
									 </td>
									</tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Step 5 Mobile view -->
                        <div class="s4-table-wrap s5-table-wrap mob-s5-table-wrap hidden-md hidden-lg">
                        	<div class="row">
                            	<div class="col-xs-12">
                                	<div class="s5-mob s5-bg-grey">
                                    	<h4>Cover Type:</h4>
                                        <p>Comprehensive</p>
                                    </div>
                                    <div class="s5-mob">
                                    	<h4>Cover Type:</h4>
                                        <p>Comprehensive</p>
                                    </div>
                                    <div class="s5-mob s5-bg-grey">
                                    	<h4>Cover Type:</h4>
                                       <p>Comprehensive</p>
                                    </div>
                                    <div class="s5-mob">
                                    	<h4>Cover Type:</h4>
                                        <p>Comprehensive</p>
                                    </div>
                                    <div class="s5-mob s5-bg-grey">
                                    	<h4>Cover Type:</h4>
                                        <p>Comprehensive</p>
                                    </div>
                                    <div class="s5-mob">
                                    	<h4>Cover Type:</h4>
                                        <p>Comprehensive</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="s4-table-wrap s5-table-wrap mob-s5-table-wrap hidden-md hidden-lg">
                        	<div class="row">
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                                    <div class="mob-select-quote mob-select-quote-grey">
                                        <div class="selected-box">
                                            <h4>Selected</h4>
                                            <h2>R 578.20</h2>
                                            <div class="caption text-center">
                                                <button class="btn btn-blue">Select and Proceed</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        	<div class="row">
                            	<div class="col-xs-12">
                                	<div class="s5-mob s5-bg-grey">
                                    	<h4>Cover Type:</h4>
                                        <select id="basic" class="selectpicker show-tick form-control">
                                           
                                        </select>
                                    </div>
                                    <div class="s5-mob">
                                    	<h4>Cover Type:</h4>
                                        <select id="basic" class="selectpicker show-tick form-control">
                                           
                                        </select>
                                    </div>
                                    <div class="s5-mob s5-bg-grey">
                                    	<h4>Cover Type:</h4>
                                        <select id="basic" class="selectpicker show-tick form-control">
                                           
                                        </select>
                                    </div>
                                    <div class="s5-mob">
                                    	<h4>Cover Type:</h4>
                                        <select id="basic" class="selectpicker show-tick form-control">
                                           
                                        </select>
                                    </div>
                                    <div class="s5-mob s5-bg-grey">
                                    	<h4>Cover Type:</h4>
                                        <select id="basic" class="selectpicker show-tick form-control">
                                            
                                        </select>
                                    </div>
                                    <div class="s5-mob">
                                    	<h4>Cover Type:</h4>
                                        <select id="basic" class="selectpicker show-tick form-control">
                                          
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                            <a href="#" class="reset-link">Reset Selected Options</a>
                        </div>
                        <!-- End step 5 Mobile view -->
                    </div>
                </div>
<input type="hidden" id="refine_customer_vehicle_id">
<input type="hidden" id="refine_insurance_customer_lead_id">
<input type="hidden" id="insurace_quote_id">
</form>
<script type="text/javascript">
{literal}
  $('#holderdob').Zebra_DatePicker({
		direction: false
	});
 
  function callmeback_refine() {
   
	var vehicle_id = $("#refine_customer_vehicle_id").val();
	
	    if (vehicle_id != "" && vehicle_id != 0) {
		 
		 callmeback(vehicle_id);
		 
		}
   
  }
  
  function buy_insurance() {
 
    var quote_id = $("#insurace_quote_id").val();
	
	var lead_id =  $("#refine_insurance_customer_lead_id").val();
	
	if (quote_id != "" && lead_id !="") {
	 
	   var ajx_param = {
            "url": http_path+'/results',
            "sync": "false",
            "method": "POST",
            "data": { opcode:'submit_lead','quote_id':quote_id,'lead_id':lead_id},
            "ajxcallback":function(resdata){
			 
			    hideLoading();
                
				var ref_msg = "";
				
                if ( typeof(resdata.resultStatus) != "undefined") {
                        
                    if ( resdata.resultStatus == "Success") {
                        
                        if ( typeof(resdata.resultData) != "undefined") {
                            
                            if ( typeof(resdata.resultData.InsuranceLeadSubmissionResult) != "undefined") {
                            
								 if ( resdata.resultData.InsuranceLeadSubmissionResult.ErrorStatus == "E") {
                               
									var display_msg = resdata.resultData.InsuranceLeadSubmissionResult.ErrorDescriptions;
									$.msgGrowl ({
									   title: 'Error While Submitting quote' // Optional
									  ,text: display_msg
									  ,position: 'top-center'
									  ,msgtype: 'Error'
									});
									hideLoading();
									return;
								}
								else {
									ref_msg = resdata.resultData.InsuranceLeadSubmissionResult.LeadSubmissionReferenceNr;
									
									console.log("redirect to thank you page");
					
									window.location.href = http_path+'/thankyou?type=buy&msg='+ref_msg;
								
								}
                               
                            }
                        }
                        
                    }
                }
				
               
				
                hideLoading();
				
                }
            };
			console.log(ajx_param);
		 
            call_ajax(ajx_param);
	}
	else{
	 
		var message = "Quote id and lead id is incorrect.";
		parent.$.msgGrowl ({
		   title: 'Warning' // Optional
		  ,text: message
		  ,position: 'top-center'
		  ,msgtype: 'Warning'
		});
            
	}
  }
  
	function refined_form_validation() {
	
		showLoading("Refining Quote...");
		
		$('#frm_vehicle_refined').validator('validate');
		
		if ( $('#frm_vehicle_refined .has-error').length > 0 ) {
		
			hideLoading(0);
			
			return false;
		}
		else{
		
			return true;
		
		}
	}

	function submit_quote(){
		trigger_form({"frm":"frm_vehicle_refined",
			"ajxcallback":function( resdata ){
				if (resdata["resultStatus"] == "Success") {
					showLoading("Calculating Quote...");
					get_refined_quote();
				}
			}
		});
	}
	
	function get_refined_quote() {
		var ajx_param = {
		"url": http_path+'/results',
		"sync": "false",
		"method": "POST",
		"data": { opcode:'insurance_company_quote_submission'},
		"ajxcallback":function(response){
				console.log(response);
				if (response["resultStatus"] == "Success") {
					var refined_quote = "R "+response["resultData"]["TotalPremium"];
					$("#refined_quote_value_monthly").text(refined_quote);
					$("#refined_quote_value").text(refined_quote);
				}
				else if (response["resultStatus"] == "Warning") {
					
					var message = response["resultData"]["error_message"];
					parent.$.msgGrowl ({
					   title: 'Warning' // Optional
					  ,text: message
					  ,position: 'top-center'
					  ,msgtype: 'Warning'
					});
				}
				
				hideLoading();
			}
		};
		call_ajax(ajx_param);
	}
	var sort_description = {
		"A":"Comprehensive: Cover for accident damage and theft of your vehicle. Includes damage caused to other parties and their property.",
		"B":"Third party Fire and Theft: Cover only for certain specified damage and theft of your vehicle. Includes damage caused to other parties and their property.",
		"C":"Third Party Only: Cover only for damaged caused to other parties and their property.",
		"D":"Saver: The insured would be able to claim for the costs of repairing accident damages (including accident damage to an insured vehicle's engine, rear and side windows, and windscreen) to the insured vehicle, subject to the T&Cs of the policy. A customer would also be able to claim for damages caused by, fire, flood, storm, lightning, malicious damage (exclusive of damage resulting from a break in or attempted theft)"
	}
	
	$(document).ready(function(){
		
	 $('[data-toggle="tooltip"]').tooltip();
	 
		$("#covertype").change(function(){
  
			console.log($(this).val());
	
			var info = sort_description[$(this).val()];
  
			$(".tooltip-tag[for='covertype']").attr('data-original-title',info);
			
			$(".tooltip-tag[for='covertype']").tooltip();
				  
		});

	});
	
	
	



{/literal}
</script>