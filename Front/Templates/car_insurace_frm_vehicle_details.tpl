<script>
    var vehicle_year_of_reg = "{$data.Year}";
    var vehicle_make        = "{$data.Make}";
    var vehicle_model       = "{$data.Model}";
    var vehicle_series      = "{$data.Series}";
    var vehicle_color       = "{$data.VehicleColour}";
    var vehicle_paint_type  = "{$data.VehiclePaintType}";
    var vehicle_ncb = "{$data.NCB}";
    var vehicle_use = "{$data.VehicleUse}";
    var driver_licence_type = "{$data.DriverLicenseType}";
</script>
<a href="javascript:void(0);" class="back-btn" onclick="stepnext(1,'')"><i class="fa fa-angle-left"></i> Back</a>
<form id="frm_vehicle_details" name="frm_vehicle_details" action="vehicle-details" class="form-horizontal" data-before="vehicle_form_validation()">
    <input type="hidden" name="opcode" value="vehicle_details" class="ajx-control" />
    <input type="hidden" readonly="true" id="vehicle_id" name="vehicle_id" value="{$data.CustomerVehicleID}" class="ajx-control" />
      
    <div class="form-group">
        <div class="col-sm-3">
            <label>Customer vehicle</label>
        </div>
        <div class="col-sm-9">
           <select id="customer_vehicle" name="customer_vehicle"  onchange="fetch_car_details(document.getElementById('customer_vehicle').value,'Individual')" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field">
                <option value="">Select Vehicle</option>
           </select>
           <div class="help-block with-errors"></div>            
        </div>
    </div>    
    <div class="form-group">
        <div class="col-sm-3">
            <label>Registration Number<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9 step-registration">
            <input type="text" style="width:317px;" value="{$data.RegistrationNo}" class="form-control ajx-control" id="registration_number" name="registration_number"  data-error="Please fill out this field" required />
            <button type="button" class="btn btn-pink" onclick="fetch_car_details(document.getElementById('registration_number').value,'All');" >Fetch Car Details</button>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    
    
    <div class="form-group">
        <div class="col-sm-3">
            <label>Year of First registration<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            
            <select id="year_of_registration"  name="year_of_registration" class="selectpicker show-tick form-control ajx-control"  data-error="Please fill out this field" required >
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Car Make<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9" for="car_make">
            <select id="car_make" name="car_make" class="selectpicker show-tick form-control ajx-control"  data-error="Please select any value from this field" required>
               <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Car Model<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9" for="car_model">
            <select id="car_model" name="car_model" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Car Series<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9" for="car_series">
            <select id="car_series" name="car_series" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
               <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Vehicle Color<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <!--<input type="text" class="form-control ajx-control" id="vehicle_colour" name="vehicle_colour"  data-error="Please fill out this field" required />
            <div class="help-block with-errors"></div>-->
            <select id="vehicle_colour" name="vehicle_colour" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Vehicle Paint Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="vehicle_paint_type" name="vehicle_paint_type" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Full Service History<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <div class="radio">
                 {if $data.ServiceHistory == "1"}
                     {assign var="yes_checked" value="checked"}
                 {else}
                    {assign var="no_checked" value="checked"}
                 {/if}
                <input type="radio" name="service_history"  id="service_history" class="service_history ajx-control" value="true" {$yes_checked}>
                <label for="radio3">
                    Yes
                </label>
                <input type="radio" name="service_history"  id="service_history" class="service_history ajx-control" value="false" {$no_checked}>
                <label for="radio4">
                    No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Current Mileage<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <input type="text" value="{$data.CurrentMileage}" class="integer form-control ajx-control" id="current_mileage" name="current_mileage"  data-error="Please fill out this field" required />
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Driver Licence Date<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <div class="input-group date" id="person-dob-container">
                <input type="text" value="{$data.DriverLicenseDate}" id="vehicle_license_issue_date" name="vehicle_license_issue_date" class="form-control ajx-control" data-date-format="yy-mm-dd" data-error="Please fill out this field" required/>
            </div>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Driver Licence Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <!--<input type="text" class="form-control ajx-control" id="vehicle_license_issue_type" name="vehicle_license_issue_type" data-error="Please fill out this field" required />
            <div class="help-block with-errors"></div>-->
            <select id="vehicle_license_issue_type" name="vehicle_license_issue_type" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
                <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>            
            
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-3">
            <label>Driver Access Control<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
           <select id="driver_access_control" name="driver_access_control"  class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
                <option value="">Select</option>
           </select>
           <div class="help-block with-errors"></div>            
        </div>
    </div>
   
   <div class="form-group">
        <div class="col-sm-3">
            <label>Driver Area Type<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
           <select id="driver_area_type" name="driver_area_type"  class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
                <option value="">Select</option>
           </select>
           <div class="help-block with-errors"></div>            
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Vehicle Finance<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            {if $data.VehicleFinanced == "1" || $data.VehicleFinanced == "true"}
                {assign var="finance_yea" value="checked"}
            {else}
                {assign var="finance_no" value="checked"}
            {/if}
            <div class="radio">
                <input type="radio" name="vehicle_finance" class="vehicle_finance ajx-control" value="true" {$finance_yea}>
                <label for="radio5">
                    Yes
                </label>
                <input type="radio" name="vehicle_finance" class="vehicle_finance ajx-control" value="false" {$finance_no}>
                <label for="radio6">
                    No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>No Claim Bonus<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="no_claim_bonus" name="no_claim_bonus" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
               <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
            <!--<div class="radio">
                <input type="radio" name="no_claim_bonus"  class="ajx-control" value="yes" >
                <label for="radio7">
                    Yes
                </label>
                <input type="radio" name="no_claim_bonus" class="ajx-control" value="no" checked>
                <label for="radio8">
                    No
                </label>
            </div>-->
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3">
            <label>Vehicle Use<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <select id="vehicle_use" name="vehicle_use" class="selectpicker show-tick form-control ajx-control" data-error="Please select any value from this field" required>
               <option value=""> Select </option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-3">
            <label>Vehicle Details<span class="mandatory">*</span></label>
        </div>
        <div class="col-sm-9">
            <input type="text" value="" class="form-control ajx-control" placeholder="Ex: 2015 AUDI A1 SPORTBACK"  id="vehicle_info" name="vehicle_info" data-error="Please select any value from this field" required />
            <div class="help-block with-errors"></div>
        </div>
    </div>
    {literal}
    <div class="pull-right form-steps-btn clearfix">
        <button type="button" class="btn btn-pink" onclick="vehicle_callme_back();" style="width: 247px">Call Me Back</button>

        <button class="btn btn-blue" onmouseup="showLoading();" type="button" onclick='trigger_form({"frm":"frm_vehicle_details","ajxcallback":function(resdata){vehicle_detail_response(resdata);}});'>Next</button>
    </div>
    {/literal}
</form>
<script type="text/javascript">

    var http_path = "{$HTTP_PATH}";
    
    var login_user = "{$user}";
   
    {literal}
    
    $('#vehicle_license_issue_date').Zebra_DatePicker({
        
        direction: false
        
    });
    

    function vehicle_form_validation(){
        
        
        
        //setTimeout(function() {
           
            $('#frm_vehicle_details').validator('validate');
        
            if ( $('#frm_vehicle_details .has-error').length > 0 ) {
                hideLoading();
                
                return false;
            }
            else{
                vehicle_form_data_loaded = true;
                return true;
            } 
            
        //}, 1000);
        
        
    }
    
    function vehicle_detail_response(resdata){

       // console.log(resdata);

        var status =  resdata['resultStatus'];

        if(status == "Warning"){
            
            console.log('Error in form');
            
            if (typeof(resdata.resultData.message) != "undefined") {
                
                var msgs = resdata.resultData.message;
                
                var display_messages = [];
            
                for (k in msgs){
                    
                  display_messages.push(msgs[k]+"<br/>");
                  
                }
                
                var message = display_messages.join('');
                parent.$.msgGrowl ({
                   title: 'Fill The Required Fields' // Optional
                  ,text: message
                  ,position: 'top-center'
                  ,msgtype: 'Error'
                });
                
            }
            
            hideLoading();
            
            return false;
        }
        else if(status == "Success"){

            var data = resdata['resultData']['formData'];
            
            
            stepnext(3,'');
            // console.log(data);
            //if(resLocalStorage.getItemObject("storage_feeds") != null){
            //    stepnext(3,'');
            //}
            //else{
            //    
            //}
            bind_click_till(2);
            hideLoading()
        }
        else{

            console.log('Error while performing action. please contact administrator');

            return false;
        }

    }
    
   function vehicle_callme_back(){
    
        var vechile_descriptoin = { year:"","vehicle details":""}
        vechile_descriptoin["year"]    = $("#year_of_registration").val();
        vechile_descriptoin["vehicle details"]    = $("#vehicle_info").val();
        
        var message = "";
        for (k in vechile_descriptoin){
                
            if( vechile_descriptoin[k]  == "" || vechile_descriptoin[k] == "undefined" ){
                
                message  += k+" <br/>";    
            }
        }
        
        if (message != "") {
            $.msgGrowl ({
                   title: 'Following fields are required for Call Me back' // Optional
                  ,text: message
                  ,position: 'top-center'
                  ,msgtype: 'Error'
                });
            return false;
        }
        else{
            showLoading();
            var objcallme = {"year":vechile_descriptoin["year"],
                            "desc":vechile_descriptoin["vehicle details"]};
            callme_nold(objcallme);
        }
     
   }
    {/literal}
</script>