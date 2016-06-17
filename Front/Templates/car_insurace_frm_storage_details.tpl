{* $data|@print_r *} 
<script>
/*var vehicle_night_parking       = "{$data.OvernightParking}";
var night_parking_address_type  = "{$data.NightAddressType}";
var night_parking_same          = "{$data.NightParkingSame}";
var night_parking_postcode      = "{$data.NightPostalCode}";
var night_parking_suburb        = "{$data.NightSuburbName}";
var night_access_type           = "{$data.NightAccessControl}";
var night_parking_area          = "{$data.NightAreaType}";

var day_parking_area            = "{$data.DayAreaType}";
var day_parking                 = "{$data.DayParking}";
var day_parking_sane            = "{$data.DayParkingSame}";
var day_parking_postcode        = "{$data.DayPostalCode}";
var day_parking_suburb          = "{$data.DaySuburbName}";
var day_parking_address_type    = "{$data.DayAddressType}";
var day_access_type             = "{$data.DayAccessControl}";
var insured_option              = "{$data.InsuredOption}";*/

    
</script>
<div class="row">
  <button class="btn btn-pink pull-right" onclick="stepnext(1,'');" style="width: 130px">Edit Details</button>
</div> 
<a href="javascript:void(0);" class="back-btn" onclick="stepnext(2,'')"><i class="fa fa-angle-left"></i> Back</a>
<form id="frm_storage_details"  name="frm_storage_details" action="vehicle-details" class="form-horizontal" data-before="storage_form_validation()">
    <input type="hidden" name="opcode" value="vehicle_storage_details" class="ajx-control" />
    <div class="form-group">
        <div class="col-sm-3">
            <label>Night Parking<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="vehicle_parking" name="vehicle_parking" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field." required>
                <option value=" "> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Night Address Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="night_address_type" name="night_address_type" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field." required >
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Night Address<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <label class="night-address-label">Same as Physical</label>
            <div class="radio">
                <input type="radio" name="night_address" value="0" class="ajx-control" checked>
                <label for="yes" >Yes</label>
                <input type="radio" name="night_address" value="1"  class="ajx-control">
                <label for="yes">No</label>
            </div>
            <div id="night_address_details" style="display:none;">
                <input type="text" id="steet_address" name="street_address" class="form-control ajx-control fill-address" placeholder="Street Address" data-error="Please fill out this field." required />
                <div class="help-block with-errors"></div>
                <input type="text" id="suburb" value="{$data.NightSuburbName}" name="suburb" class="form-control ajx-control fill-address" placeholder="Suburb" data-error="Please fill out this field." required/>
                <div class="help-block with-errors"></div>
                <input type="text" id="city"  name="city" class="form-control ajx-control fill-address" placeholder="City / Town" data-error="Please fill out this field." required />
                <div class="help-block with-errors"></div>
                <input type="text" id="postal_code" name="postal_code" value="{$data.NightPostalCode}" class="form-control medium-textbox ajx-control fill-address" placeholder="Postal Code" data-error="Please fill out this field." required />
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Night Address Access Control Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select  class="selectpicker show-tick form-control ajx-control" id="night_address_access_control_type" name="night_address_access_control_type" data-error="Please fill out this field." required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Night Parking Area Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select class="selectpicker show-tick form-control ajx-control" id="night_parking_area_type" name="night_parking_area_type" data-error="Please fill out this field." required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-3">
            <label>Day Parking Area Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="area_type"  name="area_type" class="selectpicker show-tick form-control ajx-control"  data-error="Please fill out this field" required >
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Day Parking Access Control<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="day_access_control"  name="day_access_control" class="selectpicker show-tick form-control ajx-control"  data-error="Please fill out this field" required>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Day Parking<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select class="selectpicker show-tick form-control ajx-control" id="day_parking" name="day_parking" data-error="Please fill out this field." required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Day Address Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select  class="selectpicker show-tick form-control ajx-control" id="day_address_type" name="day_address_type" data-error="Please fill out this field." required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Tracking Device<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <div class="radio">
                <input type="radio" name="tracking_device" value="0" class="tracking_device ajx-control">
                <label for="tracking_device">
                    Yes
                </label>
                <input type="radio" name="tracking_device" value="1" checked class="tracking_device ajx-control">
                <label for="tracking_device">
                    No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group" id="tracking_device_form">
        <div class="col-sm-3">
            <label>Tracking Device Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="tracking_device_type" name="tracking_device_type" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field">
               <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
            <!--<input type="text" id="tracking_device_type" name="tracking_device_type" class="form-control ajx-control fill-address" placeholder="Tracking Device Type" data-error="Please fill out this field." required />
             <div class="help-block with-errors"></div>-->
        </div>
    </div>
    <div class="form-group" style="display: none;">
        <div class="col-sm-3">
            <label>Include Motor Sasria<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <div class="radio">
                
                <input type="radio" name="motor_sarsia" class="ajx-control" value="true"  checked="checked">
                <label for="motor_sarsia">
                    Yes
                </label>
                <input type="radio" name="motor_sarsia" class="ajx-control" value="false">
                <label for="motor_sarsia">
                    No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Insure Option<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="insure_type" name="insure_type" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
               <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <!--- Default : HailCover =  Y -->
    <input type="hidden" class="form-control ajx-control" value="{$data.HailCover}" id="hail_cover" name="hail_cover" />
    
    <!--- Default : WindscreenCover =  Y -->
    <input type="hidden" class="form-control ajx-control" value="{$data.WindscreenCover}" id="windscreen_cover" name="windscreen_cover" />
    
    <!--- Default : CoverType =  A -->
    <input type="hidden" class="form-control ajx-control" value="{$data.CoverType}" id="cover_type" name="cover_type" />
    
    <!--- Default : CarHireIncluded =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.CarHireIncluded}" id="car_hire_included" name="car_hire_included" />
    
    <!--- Default : CarHireOption =  C-->
    <input type="hidden" class="form-control ajx-control" value="{$data.CarHireOption}" id="car_hire_option" name="car_hire_option" />
    
    <!--- Default : RadioCover =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.RadioCover}" id="radio_cover" name="radio_cover" />
    
    <!--- Default : RadioCoverValue =  0-->
    <input type="hidden" class="form-control ajx-control" value="{$data.RadioCoverValue}" id="radio_cover_value" name="radio_cover_value" />
    
    <!--- Default : CanopyCoverIncluded =  N-->
    <input type="hidden" class="form-control ajx-control" value="{$data.CanopyCoverIncluded}" id="canopy_included" name="canopy_included" />
    
    <!--- Default : IncludeTheftExcessBuster =  N-->
    <input type="hidden" class="form-control ajx-control" value="{$data.IncludeTheftExcessBuster}" id="theft_access_include" name="theft_access_include" />
    
    <!--- Default : PublicLiability =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.PublicLiability}" id="public_liability" name="public_liability" />
    
    <!--- Default : SaverTotalLoss =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.SaverTotalLoss}" id="saver_total_loss" name="saver_total_loss" />
    
    <!--- Default : SaverAccidentCover =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.SaverAccidentCover}" id="saver_accident_cover" name="saver_accident_cover" />
    
    <!--- Default : SaverAccidentOption =  A-->
    <input type="hidden" class="form-control ajx-control" value="{$data.SaverAccidentOption}" id="saver_accident_option" name="saver_accident_option" />
    
    <!--- Default : SaverAssist =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.SaverAssist}" id="saver_assist" name="saver_assist" />
 
    <!--- Default : SaverThirdPartyLiability =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.SaverThirdPartyLiability}" id="third_party_liability" name="third_party_liability" />
    
    <!--- Default : VoluntaryExcess =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.VoluntaryExcess}" id="voluntary_excess" name="voluntary_excess" />
    <!--- Default : VoluntaryExcess =  Y-->
    <input type="hidden" class="form-control ajx-control" value="{$data.MMCode}" id="mm_code" name="mm_code" />
    <input type="hidden" class="form-control ajx-control" value="{$data.InsuranceCustomeVehicleID}" id="insurance_customer_vehicle_id" name="insurance_customer_vehicle_id" />
    
    <div class="pull-right form-group form-steps-btn clearfix">
        <div class="checkbox chk-same">
            <input type="checkbox" class="ajx-control" name="correct_info" id="correct_info" value="correct_info" required>
            <label for="correct_info">Yes all information provided above is correct.<span class="mandatory">*</span></label>
            <div class="help-block with-errors"></div>
        </div>
        {literal}
            <button type="button" class="btn btn-pink" onclick="vehicle_callme_back();" style="width: 247px">Call Me Back</button>
            <button id="btn_vehicle_storage"  onmouseup="showLoading('Updating Vehicle Details...');" onclick='trigger_form({"frm":"frm_storage_details","ajxcallback":function(resdata){storage_response(resdata);}});' type="button" class="btn btn-blue">Next</button>
        {/literal}
    </div>
</form>
<script type="text/javascript">
    {literal}

    // Form validation
    function storage_form_validation(){
        
        
        //showLoading();
        
        //setTimeout(function() {
        
        if ( $('input[name="tracking_device"]:checked').val() == 0) {
            $("#tracking_device_type").attr('required');
        }
        else{
            $("#tracking_device_type").removeAttr('required');
        }
           
            $('#frm_storage_details').validator('validate');
        
            if ( $('#frm_storage_details .has-error').length > 0 ) {
                hideLoading();
                return false;
            }
            else{
                return true;
            } 
            
       // }, 1000);
       // 
        
    }

    // Hide-show night addreszs details
    var selected_night_address = $('[name="night_address"]:checked').val();

    if(selected_night_address == 'yes' || selected_night_address == '0')
    {
        $('#night_address_details').hide();
    }else{
        $('#night_address_details').show();
    }
    $('input:radio[name="night_address"]').change(
        function(){
            if ( $(this).is(':checked') && ($(this).val() == 'no' || $(this).val() == '1') ) {
                // append goes here
                $('#night_address_details').show();
            }else{
                $('#night_address_details').hide();
        }
    });

    // Enable-disable device tracking text box based on selection
    var selected_tracking_device = $('[name="tracking_device"]:checked').val();

    if(selected_tracking_device == '0')
    {        
        $('#tracking_device_type').attr('required',false);
    }else{
        $('#tracking_device_form').hide();
        $('#tracking_device_type').val('');
        $('#tracking_device_type').attr('required',true);
    }
    $('input:radio[name="tracking_device"]').change(
            function(){
                if ($(this).is(':checked') && $(this).val() == '1') {                   
                   $('#tracking_device_form').hide(500);
                    $('#tracking_device_type').val('');
                    $('#tracking_device_type').attr("required",false);
                }else{
                   $('#tracking_device_form').show(500);
                    $('#tracking_device_type').attr("required",true);
                }
            });


        
    // Call back function on Next click
    function storage_response(resdata){

     console.log(resdata);

        var status =  resdata['resultStatus'];

        if(status == "Warning"){
            
            console.log('Error in form');
            
            hideLoading();
            
            return false;
        }
        else if(status == "Success"){

            hideLoading();
            
            var data = resdata['resultData']['formData'];
            
            if ( typeof(resdata['resultData']['is_guest']) != "undefined") {
                var pop_message ="<div class='row text-center'>";
                pop_message += "<h2>Please make sure, All information provided is correct.</h2>";
                pop_message += "<h2>Once quote is submitted, you can not change any previous details.</h2>";
                pop_message += '<button style="width: 247px;margin:20px;" onclick="final_confirmation();" class="btn btn-blue" type="button">Click To Continue</button>';
                pop_message += "</div>";
                modal_params = {'id':'confirmDetails','class':'myClass',"content":pop_message,"title":"",width:"100px",height:"400px"};
                open_modal(modal_params);

            }
            else{
            
                if ( typeof(resdata['resultData']['vehicle_data']) != "undefined") {
                    if ( typeof(resdata['resultData']['vehicle_data']['CustomerVehicleAddResult']) != "undefined") {
                       
                       set_added_vehicle(resdata['resultData']['vehicle_data']['CustomerVehicleAddResult']); 
                        
                    }
                }
                
                stepnext(4,'load');
                
                bind_click_till(3);
                
                hideLoading()
                
                setTimeout(function() {
                    loadResultData();        
                }, 500);
            }
        }
        else{

            console.log('Error while performing action. please contact administrator');

            return false;
        }

    }
   
   function set_added_vehicle(add_result){
   
        var insurance_vehicle_data = add_result.InsuranceCustomerVehicle;
    
        $("#hail_cover").val(insurance_vehicle_data["HailCover"]);
        
        $("#windscreen_cover").val(insurance_vehicle_data["WindscreenCover"]);
        
        $("#cover_type").val(insurance_vehicle_data["CoverType"]);
        
        $("#car_hire_included").val(insurance_vehicle_data["CarHireIncluded"]);
        
        $("#car_hire_option").val(insurance_vehicle_data["CarHireOption"]);
        
        $("#radio_cover").val(insurance_vehicle_data["RadioCover"]);
        
        $("#radio_cover_value").val(insurance_vehicle_data["RadioCoverValue"]);
        
        $("#canopy_included").val(insurance_vehicle_data["CanopyCoverIncluded"]);
        
        $("#theft_access_include").val(insurance_vehicle_data["IncludeTheftExcessBuster"]);
        
        $("#voluntary_excess").val(insurance_vehicle_data["VoluntaryExcess"]);
        
        $("#mm_code").val(add_result.MMCode);
        
        $("#insurance_customer_vehicle_id").val(insurance_vehicle_data["InsuranceCustomeVehicleID"]) ;
    
   }
   
   function final_confirmation() {
    
        close_modal();
        showLoading("Updating Personal & Vehicle Information...");
        var ajx_param = {	
                    "url": http_path+"/personal-details",
                    "sync": false,
                    "method": "POST",
                    "data": { opcode:'guest_user' },
                    "ajxcallback":function(response){
                        hideLoading();
                        
                        if( response["resultStatus"] == "Success" ) {
                               stepnext(4,'load');
                               
                               bind_click_till(0);
                               
                               hideLoading()
                               
                               setTimeout(function() {
                                   loadResultData();        
                               }, 500);
                        }
                        else if(response["resultStatus"] == "Warning") {
                            var message = response["resultData"]["message"];
                            var patt = /An account already exists/;
                            if( patt.test(message) ){
                                var title = "";
                                hideLoading();
                                modal_params = {"id":"signin","modal_dialog_size" : "modal-lg",
                                           "iframe":http_path+"/signin?popup&msg="+message,
                                            "title":title,"width":"100%","height":"420px",
                                };
                                open_modal(modal_params);
                            }
                            else{
                                 $.msgGrowl ({
                                    title: 'Warning' // Optional
                                   ,text: message
                                   ,position: 'top-center'
                                   ,msgtype: 'Error'
                                 });
                                 hideLoading();
                                
                            }
                            
                        }
                        
                        
                       
                    }
                };
                call_ajax(ajx_param);
   }
    
    {/literal}
</script>