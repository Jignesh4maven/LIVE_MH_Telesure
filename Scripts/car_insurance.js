// step name object
var setup_forms = { "personal_details":"1","vehicle_details":"2",
    "vehicle_storage":"3","result":"4","refine_submit":"5" };

if (step_name=='default') {
    $(".steps-form").css("display","none");
   
}
var vehicle_details = {};
vehicle_details["overnight_parking"] = "";
vehicle_details["night_address_type"] = "";
vehicle_details["night_access_control"] = "";
vehicle_details["night_area_type"] = "";
vehicle_details["night_parking_same"] = "";
vehicle_details["night_parking_postcode"] = "";
vehicle_details["night_parking_suburb"] = "";
vehicle_details["day_area_type"] = "";
vehicle_details["day_access_control"] = "";
vehicle_details["day_parking_same"] = "";
vehicle_details["day_parking_postcode"] = "";
vehicle_details["day_parking_suburb"] = "";
vehicle_details["day_parking_address_type"] = "";
vehicle_details["insured_option"] = "";
vehicle_details["tracking_device_type"] = "";
vehicle_details["year"] = "";
vehicle_details["make"] = "";
vehicle_details["model"] = "";
vehicle_details["series"] = "";
vehicle_details["driver_access_control"] = "";
var overnight_parking           = "";
var night_address_type          = "";
var night_access_control        = "";
var night_area_type             = "";

var night_parking_same          = "";
var night_parking_postcode      = "";
var night_parking_suburb        = "";

var day_area_type               = "";
var day_access_control          = "";
var day_parking                 = "";
                        
var day_parking_same            = "";
var day_parking_postcode        = "";
var day_parking_suburb          = "";
var day_parking_address_type    = "";
var insured_option              = "";
// load step baes on url call
if( typeof(setup_forms[step_name]) != "undefined"){

    stepnext(setup_forms[step_name],'')
}

// step navication function
function stepnext(n,a){
    
    var call_before = undefined;

    var call_after = undefined;

    if ( a != "" ) {
    
        if( $(".s-number [data-step='"+ n +"']").length ){
    
            call_before = $(".s-number [data-step='"+ n +"']").attr('data-before');
    
            call_after = $(".s-number [data-step='"+ n +"']").attr('data-after');
    
            if(typeof(call_before) == "string"){
    
                var t = eval(call_before);
    
                if(t === false){
    
                    return false;
    
                }
    
            }
    
        }
    }
    
    if(n != 0){
     
        /* Hide the sub titles of the first step*/
        $("#step-0").hide();
        $(".mobile-steps-wrap").css("display","none");
        $(".stepwizard-subtitle").css("display","none");
        /* End*/

        $(".steps-form").css("display","block");
        //$(".stepwizard-row a").switchClass('btn-primary','btn-default');
        $(".stepwizard-row a").removeClass('btn-primary');
        $(".stepwizard-row a").addClass('btn-default');

        /* Make ajax call for localstorage on submission of 1st step */
        if(n != 1){
            /*var personalDetails = [{'id_type':$('input[name=id_type_personal]:checked', '#personal-details').val()},
                                    {'id_type':$('input[name=id_type_personal]:checked', '#personal-details').val()}];
            localStorage.setItem('personalDetails', JSON.stringify(personalDetails));
            var details = localStorage.getItem('personalDetails');
            console.log(details);*/
            //trigger_form({"frm":"frm_personal_details","ajxcallback":function(resdata){service_response(resdata);}});
        }
        /* End */

        $('.stepwizard a[href="#step-'+n+'"]').tab('show');
        $(".s-number").removeClass('active');
        $('.stepwizard a[href="#step-'+n+'"]').parent('.s-number').addClass('active');
        //$('.stepwizard-row a[href="#step-'+n+'"]').switchClass('btn-default','btn-primary');
        $('.stepwizard-row a[href="#step-'+n+'"]').removeClass('btn-default');
        $('.stepwizard-row a[href="#step-'+n+'"]').addClass('btn-primary');
    }
}
//--------------------------------- step 5 ----------------------------------
function load_refine_formfeeds() {
              
				//code
					var ajx_param = {
					"url": http_path+'/results',
					"sync": "false",
					"method": "POST",
					"data": { opcode:'get_last_step_data' },
					"ajxcallback":function(response){
						console.log(response);
                        resLocalStorage.setItem("refine_feeds",response);
						data = resLocalStorage.getItemObject("refine_feeds");
					    fill_refine_form(data);
                        load_selected_quote();
                        bind_click_till(5);
						hideLoading();
                        }
                    };
                    call_ajax(ajx_param);
			
}

function load_selected_quote(){
    
    var res = resLocalStorage.getItemObject("refine_feeds");

    var quote_company = res.selected_company;
    
    var selected_company_ifo = res.selected_company_info;

    var vehicle = res.requested_vehicle.InsuranceCustomerVehicle;

    var selected_data = {};
    
    var hodler_dob = "";
    if ( typeof(vehicle.DriverDateOfBirth) != "undefined" && vehicle.DriverDateOfBirth != "" ) {
        hodler_dob = (vehicle.DriverDateOfBirth).split('T')[0];
    }
    
    
    selected_data["total_premium"]              = quote_company.TotalPremium;
    selected_data["quote_covertype"]            = "-";
    selected_data["quote_thirdpartyliability"]  = "-";
    selected_data["quote_insuredvaluetype"]     = "-";
    selected_data["quote_excess"]               = "R "+quote_company.TotalExcess;
    selected_data["quote_hailcover"]            = "-";
    selected_data["quote_windscreencover"]      = "-";
    selected_data["quote_assistcover"]          = "-";
    selected_data["quote_carhire"]              = "-";
    selected_data["quote_carhireoption"]        = "-";
    selected_data["quote_radiocover"]           = "-";
    selected_data["quote_radiocoveroption"]     = "-";
    selected_data["quote_canopycover"]          = "-";
    selected_data["quote_voluntaryexcess"]      = "-";
    selected_data["quote_holderdob"]            = hodler_dob;
    selected_data["quote_theftexcessbuster"]    = "-";
    selected_data["quote_accidentcover"]        = "-";
    selected_data["quote_accident_cover"]       = "-";
    selected_data["quote_totalloss"]            = "-";
    selected_data["quote_publicliability"]      = "-";
    selected_data["quotes_based_on"]      = res.car_description;
    selected_data["selected_quote_value"]       = "R "+quote_company.TotalPremium;
    selected_data["refined_quote_value"]        = "R "+quote_company.TotalPremium;
    selected_data["selected_quote_value_monthly"]  = "R "+quote_company.TotalPremium;
    selected_data["refined_quote_value_monthly"]  = "R "+quote_company.TotalPremium;
    
    var img_id = quote_company.InsuranceCalculationCompanyId;
    var img_title = selected_company_ifo.InsuranceCompanyName;
    var img = '<img src="'+http_path+'/results?opcode=company_logo&id='+img_id+'" title="'+img_title+'"/>';

    $(".selected_company_name").html(img);
    
    $("#insurance_customer_vehicle_id").val(vehicle.InsuranceCustomeVehicleID);
    
    $("#refine_customer_vehicle_id").val(res.requested_vehicle.CustomerVehicleID);
    $("#refine_insurance_customer_lead_id").val(quote_company.InsuranceCustomerLeadId);
    $("#insurace_quote_id").val(quote_company.InsuranceQuoteId);
    
     
   $("#refine_customer_vehicle_id").val(res.requested_vehicle.CustomerVehicleID);
   $("#refine_insurance_customer_lead_id").val(quote_company.InsuranceCustomerLeadId);
   $("#insuredvaluetype").val(quote_company.InsuranceQuoteId);
   
   $("#covertype").val(vehicle.CoverType).selectpicker('refresh');
   $("#thirdpartyliability").val(vehicle.SaverThirdPartyLiability).selectpicker('refresh');
   $("#insuredvaluetype").val(vehicle.InsuredOption).selectpicker('refresh');
   $("#excess").val(quote_company.TotalExcess);
   $("#hailcover").val(vehicle.HailCover).selectpicker('refresh');
   $("#windscreencover").val(vehicle.WindscreenCover).selectpicker('refresh');
   $("#assistcover").val(vehicle.SaverAssist).selectpicker('refresh');
   $("#carhire").val(vehicle.CarHireIncluded).selectpicker('refresh');
   $("#carhireoption").val(vehicle.CarHireOption).selectpicker('refresh');
   $(".datepicker[name='holderdob']").val(hodler_dob);
   
   $("#radiocover").val(vehicle.RadioCover).selectpicker('refresh');
   $("#radiocoveroption").val(vehicle.RadioCoverValue).selectpicker('refresh');
   $("#canopycover").val(vehicle.CanopyCoverIncluded).selectpicker('refresh');
   $("#voluntaryexcess").val(vehicle.VoluntaryExcess).selectpicker('refresh');
   $("#holderdob").val(hodler_dob).selectpicker('refresh');
   $("#theftexcessbuster").val(vehicle.IncludeTheftExcessBuster).selectpicker('refresh');
   $("#accidentcover").val(vehicle.SaverAccidentCover).selectpicker('refresh');
   $("#accidentcoveroption").val(vehicle.SaverAccidentOption).selectpicker('refresh');
   $("#totalloss").val(vehicle.SaverTotalLoss).selectpicker('refresh');
   $("#publicliability").val(vehicle.PublicLiability).selectpicker('refresh');




    var yes_html = '<i class="s4-check"></i>';

    if( typeof(res.CoverTypeItems) != "undefined"){
    
       var cover_list = jQuery.parseJSON(data.CoverTypeItems).value;
      
       var cover_type_des = get_value_from_json(cover_list,"Value","Description",vehicle.CoverType);
      
       if( typeof(cover_type_des) != "undefined" ){
      
        selected_data["quote_covertype"] = cover_type_des;
         
       }
      
    }
    
    if(vehicle.SaverThirdPartyLiability == "Y"){
      selected_data["quote_thirdpartyliability"] = yes_html;
    }
    
    if( typeof(res.MotorInsuredItems) != "undefined"){

        var list = jQuery.parseJSON(data.MotorInsuredItems).value;
       
        var des = get_value_from_json(list,"Value","Description",vehicle.InsuredOption);
       
        if( typeof(des) != "undefined" ){
          
         selected_data["quote_insuredvaluetype"] = des;
          
        }
       
     }
     
    if(vehicle.HailCover == "Y"){
        selected_data["quote_hailcover"] = yes_html;
    }
 
    if(vehicle.WindscreenCover == "Y"){
        selected_data["quote_windscreencover"] = yes_html;
    }
    
    if(vehicle.SaverAssist == "Y"){
        selected_data["quote_assistcover"] = yes_html;
    }
    
    if(vehicle.CarHireIncluded == "Y"){
        selected_data["quote_carhire"] = yes_html;
    }
    
    if( typeof(res.CarHireOptions) != "undefined"){
    
       var list = jQuery.parseJSON(data.CarHireOptions).value;
      
       var des = get_value_from_json(list,"Value","Description",vehicle.CarHireOption);
      
       if( typeof(des) != "undefined" ){
         
         console.log(des);
      
        selected_data["quote_carhireoption"] = des;
         
       }
      
    }
    
    if(vehicle.RadioCover == "Y"){
        selected_data["quote_radiocover"] = yes_html;
    }
    
    if( typeof(res.SoundSystemInsuredValues) != "undefined"){

        var list = jQuery.parseJSON(data.SoundSystemInsuredValues).value;
       
        var des = get_value_from_json(list,"Value","Description",vehicle.RadioCoverValue);
       
        if( typeof(des) != "undefined" ){
          
            console.log(des);
       
            selected_data["quote_radiocoveroption"] = des;
          
        }
       
    }
    
    if(vehicle.CanopyCoverIncluded == "Y"){
        selected_data["quote_canopycover"] = yes_html;
    }
    if(vehicle.IncludeTheftExcessBuster == "Y"){
        selected_data["quote_theftexcessbuster"] = yes_html;
    }
    
    if(vehicle.SaverAccidentCover == "Y"){
        selected_data["quote_accidentcover"] = yes_html;
    }
    
    if(vehicle.SaverTotalLoss == "Y"){
        selected_data["quote_totalloss"] = yes_html;
    }
    
    if(vehicle.PublicLiability == "Y"){
        selected_data["quote_publicliability"] = yes_html;
    }
    
    if( typeof(res.VoluntaryExcessItems) != "undefined"){

        var list = jQuery.parseJSON(data.VoluntaryExcessItems).value;
       
        var des = get_value_from_json(list,"Value","Description",vehicle.VoluntaryExcess);
       
        if( typeof(des) != "undefined" ){
       
            selected_data["quote_voluntaryexcess"] = des;
          
        }
       
    }
    
    if( typeof(res.SaverAccidentCoverOptions) != "undefined"){

        var list = jQuery.parseJSON(data.SaverAccidentCoverOptions).value;
       
        var des = get_value_from_json(list,"Value","Description",vehicle.SaverAccidentOption);
       
        if( typeof(des) != "undefined" ){
       
            selected_data["quote_accident_cover"] = des;
          
        }
       
    }
    
    for( k in selected_data){
        
        if ( $("#"+k).length > 0) {
            
            $("#"+k).html(selected_data[k]);
            
        }
    }

    
}


  function get_value_from_json(json, search_key, get_value, search_for){

    //console.log(json);
    
    for(k in json){
    
      //console.log(k+"--"+search_for); 
      if ( json[k][search_key] == search_for){
        
        return json[k][get_value];
      
      }
    }

  }

// step-5: fill and bind chnage event on drop drop down 
function fill_refine_form(data){
    
    if( typeof(data.CoverTypeItems) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.CoverTypeItems)) == "object") {
                var cover_list = jQuery.parseJSON(data.CoverTypeItems).value;
                pickerObj = {"dataList":cover_list,"ctrlId":"covertype","key":"Value","val":"Description"};
                fill_selectpicker(pickerObj);
              
            }
        }
   if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"assistcover","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }
        
    if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"thirdpartyliability","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }
        
    if( typeof(data.MotorInsuredItems) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.MotorInsuredItems)) == "object") {
                var insuredvaluetype_list = jQuery.parseJSON(data.MotorInsuredItems).value;
               
                pickerObj = {"dataList":insuredvaluetype_list,"ctrlId":"insuredvaluetype","key":"Value","val":"Description"};
                fill_selectpicker(pickerObj);
            }
        }   
    
    if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"hailcover","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }
        
    if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"windscreencover","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }
    
     if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"carhire","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }  
     
    if( typeof(data.CarHireOptions) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.CarHireOptions)) == "object") {
                var carhireoption_list = jQuery.parseJSON(data.CarHireOptions).value;
               
                pickerObj = {"dataList":carhireoption_list,"ctrlId":"carhireoption","key":"Value","val":"Description"};
                fill_selectpicker(pickerObj);
            }
        } 
     
    if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"radiocover","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }     
     
    if( typeof(data.SoundSystemInsuredValues) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.SoundSystemInsuredValues)) == "object") {
                var carhireoption_list = jQuery.parseJSON(data.SoundSystemInsuredValues).value;
               
                pickerObj = {"dataList":carhireoption_list,"ctrlId":"radiocoveroption","key":"Value","val":"Description"};
                fill_selectpicker(pickerObj);
            }
        }
        
    if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"canopycover","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }    
        
    if( typeof(data.VoluntaryExcessItems) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.VoluntaryExcessItems)) == "object") {
                var voluntaryexcess_list = jQuery.parseJSON(data.VoluntaryExcessItems).value;
               
                pickerObj = {"dataList":voluntaryexcess_list,"ctrlId":"voluntaryexcess","key":"Value","val":"Description"};
                fill_selectpicker(pickerObj);
            }
        }
        
    if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"accidentcover","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }
        
     if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"totalloss","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
        }
        
      if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"publicliability","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
       }
       
       if( typeof(data.YsNo) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.YsNo)) == "object") {
                var yes_no = jQuery.parseJSON(data.YsNo);
                yesnoObj = {"dataList":yes_no,"ctrlId":"theftexcessbuster","key":"Value","val":"Description"};
                fill_selectpicker(yesnoObj);
              
            }
       }
      
      if( typeof(data.SaverAccidentCoverOptions) != "undefined" ){
            if ( typeof(jQuery.parseJSON(data.SaverAccidentCoverOptions)) == "object") {
                var accident_cover_options = jQuery.parseJSON(data.SaverAccidentCoverOptions).value;
                console.log( accident_cover_options );
                accident_coverObj = {"dataList":accident_cover_options,"ctrlId":"accidentcoveroption","key":"Value","val":"Description"};
                fill_selectpicker(accident_coverObj);
              
            }
        }  
        
  }
// -------------------------------- Step - 1 --------------------------------
// load vehicle form ( step - 2 ) common data and store to local storage
function load_vehicle_formfeeds(){
    console.log("Fetch customer vehicle details from iscript");
    
    setTimeout(function(){
        showLoading();
      }, 500);   
    setTimeout(function(){
        
        if ( resLocalStorage.getItemObject("vehicle_feeds") == null ) {
             var ajx_param = {
                "url": http_path+'/vehicle-details',
                "sync": false,
                "method": "POST",
                "data": { opcode:'get_vehicle_formfeed' },
                "ajxcallback":function(response){
                    console.log(response);
                    resLocalStorage.setItem("vehicle_feeds",response);
                    data = resLocalStorage.getItemObject("vehicle_feeds");
                    fill_vehicle_form(data);
                    load_storage_formfeeds();
                    hideLoading(0);
                }
            };
            call_ajax(ajx_param);
        }
        else{
            //console.log(resLocalStorage.getItemObject("vehicle_feeds"));
            data = resLocalStorage.getItemObject("vehicle_feeds");
            fill_vehicle_form(data);
            hideLoading(0);
        }
   }, 1000);
}

// step-2 : fill and bind chnage event on drop drop down
var vehicle_form_data_loaded = false;
function fill_vehicle_form(data){
   
   if ( vehicle_form_data_loaded == true ) {
    return false;
   }
   
   
   var selected_driver_access_control = "";
    
    if ( typeof( vehicle_details['driver_access_control']  ) != "undefined") {
        
        selected_driver_access_control = vehicle_details['driver_access_control'];
    }
    
    if( typeof(data.AccessControlType) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.AccessControlType)) == "object") {
            var access_type_list = jQuery.parseJSON(data.AccessControlType).value;
            console.log(1);
            pickerObj = {"dataList":access_type_list,"ctrlId":"driver_access_control","key":"Value","val":"Description","selected":selected_driver_access_control};
            fill_selectpicker(pickerObj);
        }
    }
    
    
    var selected_driver_area_type = "";
    
    if ( typeof( vehicle_details['driver_area_type'] ) != "undefined") {
        
        selected_driver_area_type = vehicle_details['driver_area_type'];
        
    }
    if( typeof(data.TelesureAreaTypeItems) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.TelesureAreaTypeItems)) == "object") {
            var area_type_list = jQuery.parseJSON(data.TelesureAreaTypeItems).value;
            pickerObj = {"dataList":area_type_list,"ctrlId":"driver_area_type","key":"Value","val":"Description","selected":selected_driver_area_type};
            fill_selectpicker(pickerObj);
        }
    }
           
           
    //fill customer vehicle dropdown
    if( typeof(data.VehiclesList) != "undefined" ){
        if ( typeof(data.VehiclesList) == "object") {
            //var customer_vehicle_list = [{"RegistrationNo":"Add New"},{"RegistrationNo":"GJ5HC8844"},{"RegistrationNo":"GJ5777"},{"RegistrationNo":"GJ05MH0800","CustomerVehicleID":"866","Make":"66","Model":"2993","Series":"8228"},{"RegistrationNo":"0800","CustomerVehicleID":"863","Make":"66","Model":"2993","Series":"8243"}];
            customer_vehicle_list = data.VehiclesList;
            customer_vehicle_list.unshift({"RegistrationNo":"Add New"});
           pickerObj = {"dataList":customer_vehicle_list,"ctrlId":"customer_vehicle","key":"RegistrationNo","val":"RegistrationNo","select_label":"Select Vehicle"};
           fill_selectpicker(pickerObj);
        }
    }
    
    if( typeof(data.VehicleYearData) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.VehicleYearData)) == "object") {
            var year_list = jQuery.parseJSON(data.VehicleYearData).value;
            var selected_year = "";
            if ( typeof(vehicle_year_of_reg) != "undefined") {
                selected_year = vehicle_year_of_reg;
            }
            pickerObj = {"dataList":year_list,"ctrlId":"year_of_registration","key":"Year","val":"Year","selected":selected_year};
            fill_selectpicker(pickerObj);
        }
    }
    
    /*if( typeof(data.VehicleMakeData) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.VehicleMakeData)) == "object") {
            var car_make_list = jQuery.parseJSON(data.VehicleMakeData).value;
            var selected_make = "";
            if ( typeof(vehicle_make) != "undefined") {
                selected_make = vehicle_make;
            }
            pickerObj = {"dataList":car_make_list,"ctrlId":"car_make","key":"ID","val":"Name","selected":selected_make};
            fill_selectpicker(pickerObj);
        }
    }*/
    
    if( typeof(data.VehiclePaintTypes) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.VehiclePaintTypes)) == "object") {
            var paint_type_list = jQuery.parseJSON(data.VehiclePaintTypes).value;
            var selected_paint = "";
            if ( typeof(vehicle_paint_type) != "undefined") {
                selected_paint = vehicle_paint_type;
            }
            pickerObj = {"dataList":paint_type_list,"ctrlId":"vehicle_paint_type","key":"Value","val":"Description","selected":selected_paint};
            fill_selectpicker(pickerObj);
        }
    }
    
    if( typeof(data.VehicleUseItems) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.VehicleUseItems)) == "object") {
            var car_useitem_list = jQuery.parseJSON(data.VehicleUseItems).value;
            var selected_use = "";
            if ( typeof(vehicle_use) != "undefined") {
                selected_use = vehicle_use;
            }
            pickerObj = {"dataList":car_useitem_list,"ctrlId":"vehicle_use","key":"Value","val":"Description","selected":selected_use};
            fill_selectpicker(pickerObj);
        }
    }
    if( typeof(data.MotorNCBItems) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.MotorNCBItems)) == "object") {
            var motor_ncb_item = jQuery.parseJSON(data.MotorNCBItems).value;
            var selected_ncb = "";
            if ( typeof(vehicle_ncb) != "undefined") {
                selected_ncb = vehicle_ncb;
            }
            pickerObj = {"dataList":motor_ncb_item,"ctrlId":"no_claim_bonus","key":"Value","val":"Description","selected":selected_ncb};
            fill_selectpicker(pickerObj);
        }
    }
        
    if( typeof(data.VehicleColours) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.VehicleColours)) == "object") {
            var vehicle_color_item = jQuery.parseJSON(data.VehicleColours).value;
            var selected_color = "";
            if ( typeof(vehicle_color) != "undefined") {
                selected_color = vehicle_color;
            }
            pickerObj = {"dataList":vehicle_color_item,"ctrlId":"vehicle_colour","key":"Value","val":"Description","selected":selected_color};
            fill_selectpicker(pickerObj);
        }
    }
    
    if( typeof(data.DriverLicenceType) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.DriverLicenceType)) == "object") {
            var driver_license_type = jQuery.parseJSON(data.DriverLicenceType).value;
            var selected_licence_type = "";
            if ( typeof(driver_licence_type) != "undefined") {
                selected_licence_type = driver_licence_type;
            }
            pickerObj = {"dataList":driver_license_type,"ctrlId":"vehicle_license_issue_type","key":"Value","val":"Description","selected":selected_licence_type};
            fill_selectpicker(pickerObj);
        }
    }
    
    /*if ( typeof(vehicle_make) != "undefined" && typeof(vehicle_model) != "undefined" ) {
        var make_val = $("#car_make option:selected").text();
        if ( typeof(data.VehicleModelData) == "object") {
            var car_model_list = data.VehicleModelData;
            if ( typeof(car_model_list[make_val]) != "undefined") {
                pickerObj = {"dataList":car_model_list[make_val],"ctrlId":"car_model","key":"ID","val":"Name","selected":vehicle_model};
                fill_selectpicker(pickerObj);
            }
            
        }
    }
    if ( typeof(vehicle_make) != "undefined" && typeof(vehicle_model) != "undefined"  && typeof(vehicle_series) != "undefined") {
        var model_val = $("#car_model option:selected").text();
        if ( typeof(data.VehicleSeriesData) == "object") {
            var model_series_list = data.VehicleSeriesData;
            if ( typeof(model_series_list[model_val]) != "undefined") {
                pickerObj = {"dataList":model_series_list[model_val],"ctrlId":"car_series","key":"ID","val":"Name","selected":vehicle_series};
                fill_selectpicker(pickerObj);
            }
            
        }
    }*/
    //$("#year_of_registration").off('change');
    $("#year_of_registration").change(function(){
        
        var year = $("#year_of_registration option:selected").text();
        
        if (year != "") {
       
            $("div[for='car_make'] .bootstrap-select").addClass("spin-loader");
            
            $("#car_make").html('<option>Loading...</option>');
            
            $("#car_make").selectpicker('refresh');
            
            
            //var match_staging = http_path.match(/staging.motorhappy.co.za\/telesure/g);

            //var AJAX_CALL_URL_LOAD 		= http_path+'/ajax_data.php';

            //if ( match_staging != null) {
                AJAX_CALL_URL_LOAD 		= http_path+'/personal-details';
            //}
            
            var ajx_param = {
                
                    "url": AJAX_CALL_URL_LOAD,
                    
                    "sync": false,
                    
                    "method": "POST",
                    
                    "data": { opcode:'vehicle_data', ty:"make", yr:year },
                    
                    "ajxcallback":function(response){
                        
                       $("div[for='car_make'] .bootstrap-select").removeClass("spin-loader");
                       // Reset make 
                       $("#car_make").html('<option>Select</option>');
                       $("#car_make").selectpicker('refresh');
                       
                       // Reset Model
                       $("#car_model").html('<option>Select</option>');
                       $("#car_model").selectpicker("refresh");
                       
                       //Reset series
                       $("#car_series").html('<option>Select</option>');
                       $("#car_series").selectpicker("refresh");
                                 
                        if( typeof(response) == "object"){
                     
                            if( typeof(response.resultData) == "object"){
                                
                                if( typeof(response.resultData.value) == "object"){
                                    
                                    var make_list = response.resultData.value;
                                    
                                    var selected_make = "";
                                    if (vehicle_details["make"] != "") {
                                        selected_make = vehicle_details["make"];
                                    }
             
                                    pickerObj = {"dataList":make_list,"ctrlId":"car_make","key":"ID","val":"Name","selected":selected_make};
             
                                    fill_selectpicker(pickerObj);
           
                                 }
                            }
                            else{
                                 $("#car_make").html('<option>Select</option>');
                                 $("#car_make").selectpicker("refresh");
                            }
                        }
                    }
                };
                call_ajax(ajx_param);
        }
        
    });
    
   // $("#car_make").off('change');
    $("#car_make").change(function(){
        
        var make_id = $("#car_make option:selected").val();
        
        var year = $("#year_of_registration option:selected").text();
        
        if (make_id != "" && year != "") {
            
            $("div[for='car_model'] .bootstrap-select").addClass("spin-loader");
            
            $("#car_model").html('<option>Loading...</option>');
            $("#car_model").selectpicker('refresh');
            
            //Reset series
            $("#car_series").html('<option>Select</option>');
            $("#car_series").selectpicker("refresh");
            
            //var match_staging = http_path.match(/staging.motorhappy.co.za\/telesure/g);

            //var AJAX_CALL_URL_LOAD 		= http_path+'/ajax_data.php';

            //if ( match_staging != null) {
                AJAX_CALL_URL_LOAD 		= http_path+'/personal-details';
            //}
            
            var ajx_param = {
                
                    "url": AJAX_CALL_URL_LOAD,
                    
                    "sync": false,
                    
                    "method": "POST",
                    
                    "data": { opcode:'vehicle_data', ty:"model", yr:year,mk:make_id },
                    
                    "ajxcallback":function(response){
                        
                        $("div[for='car_model'] .bootstrap-select").removeClass("spin-loader");
                        
                        $("#car_model").html('<option>Select</option>');
                        
                        $("#car_model").selectpicker("refresh");
                        
                        if( typeof(response) == "object"){
                     
                            if( typeof(response.resultData) == "object"){
                                
                                if( typeof(response.resultData.value) == "object"){
                                    
                                    var model_list = response.resultData.value;
                                    
                                    var selected_model = "";
                                    if (vehicle_details["model"] != "") {
                                        selected_model = vehicle_details["model"];
                                    }
             
                                    pickerObj = {"dataList":model_list,"ctrlId":"car_model","key":"ID","val":"Name","selected":selected_model};
             
                                    fill_selectpicker(pickerObj);
           
                                }
                            }
                            else{
                                
                                 $("#car_model").html('<option>Select</option>');
                                 $("#car_model").selectpicker("refresh");
                            }
                        }
                    }
                };
                call_ajax(ajx_param);
        }
        
        
    });
    
    $("#car_series").change(function(){
        fill_vehicle_description();
    });
   // $("#car_model").off('change');
    $("#car_model").change(function(){
        
        var make_id = $("#car_make option:selected").val();
        
        var year = $("#year_of_registration option:selected").text();
        
        var model_id = $("#car_model option:selected").val();
        
        if (make_id != "" && year != "" && model_id !="") {
        
            $("div[for='car_series'] .bootstrap-select").addClass("spin-loader");
            
            $("#car_series").html('<option>Loading...</option>');
            
            $("#car_series").selectpicker('refresh');
            
            //var match_staging = http_path.match(/staging.motorhappy.co.za\/telesure/g);

            //var AJAX_CALL_URL_LOAD 		= http_path+'/ajax_data.php';

            //if ( match_staging != null) {
                AJAX_CALL_URL_LOAD 		= http_path+'/personal-details';
            //}
            
            var ajx_param = {
                
                    "url": AJAX_CALL_URL_LOAD,
                    
                    "sync": false,
                    
                    "method": "POST",
                    
                    "data": { opcode:'vehicle_data', ty:"series", yr:year,mk:make_id ,mo:model_id},
                    
                    "ajxcallback":function(response){
                        
                        $("div[for='car_series'] .bootstrap-select").removeClass("spin-loader");
                        
                        $("#car_series").html('<option>Select</option>');
                        
                        $("#car_series").selectpicker("refresh");
                        
                        if( typeof(response) == "object"){
                     
                            if( typeof(response.resultData) == "object"){
                                
                                if( typeof(response.resultData.value) == "object"){
                                    
                                    var series_list = response.resultData.value;
                                    
                                    var selected_series = "";
                                    if ( vehicle_details["series"] != "" ) {
                                        selected_series = vehicle_details["series"];
                                    }
             
                                    pickerObj = {"dataList":series_list,"ctrlId":"car_series","key":"ID","val":"Name","selected":selected_series};
             
                                    fill_selectpicker(pickerObj);
           
                                }
                            }
                            else{
                                 $("#car_series").html('<option>Select</option>');
                                 $("#car_series").selectpicker("refresh");
                            }
                        }
                    }
                };
                call_ajax(ajx_param);
        }
        
    });
}
// -------------------------------- Step - 3 --------------------------------

function load_storage_formfeeds(){
    showLoading();
    setTimeout(function(){
        if ( resLocalStorage.getItemObject("storage_feeds") == null ) {
             var ajx_param = {
                "url": http_path+'/vehicle-details',
                "sync": "false",
                "method": "POST",
                "data": { opcode:'get_storage_formfeed' },
                "ajxcallback":function(response){
                    resLocalStorage.setItem("storage_feeds",response);
                    data = resLocalStorage.getItemObject("storage_feeds");
                    bind_vehicle_storage(data);
                    hideLoading();
                }
            };
            call_ajax(ajx_param);
        }
        else{
            data = resLocalStorage.getItemObject("storage_feeds");
            bind_vehicle_storage(data);
            hideLoading();
        }
        
    }, 500);
    
}

// step-3: fill and bind chnage event on drop drop down 
function bind_vehicle_storage(data){
    console.log(data);
    
     //var vehicle_feeds = resLocalStorage.getItemObject("vehicle_feeds");
     
    if( typeof(data.ParkingFacility) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.ParkingFacility)) == "object") {
            var parking_list = jQuery.parseJSON(data.ParkingFacility).value;
            
            var selected_overnight_parking = "";
            if ( typeof( vehicle_details['overnight_parking'] ) != "undefined") {
                selected_overnight_parking = vehicle_details['overnight_parking'];
            }
            pickerObj = {"dataList":parking_list,"ctrlId":"vehicle_parking","key":"Value","val":"Description","selected":selected_overnight_parking};
            fill_selectpicker(pickerObj);
            
            var selected_day_parking = "";
            if ( typeof( vehicle_details['day_parking'] ) != "undefined") {
                selected_day_parking = vehicle_details['day_parking'];
            }
            pickerObj = {"dataList":parking_list,"ctrlId":"day_parking","key":"Value","val":"Description","selected":selected_day_parking};
            fill_selectpicker(pickerObj);
            
        }
    }
    
    var address_type_list = [{"key":"RESIDENTIAL","val":"RESIDENTIAL"},{"key":"POSTAL","val":"POSTAL"},
                             {"key":"NIGHT","val":"NIGHT"},{"key":"DAY","val":"Day"}];
    
    
    var selected_night_address_type = "";
    
    if ( typeof( vehicle_details['night_address_type'] ) != "undefined") {
        
        selected_night_address_type = vehicle_details['night_address_type'];
    }
    
    pickerObj = {"dataList":address_type_list,"ctrlId":"night_address_type","key":"key","val":"val","selected":selected_night_address_type};
    
    fill_selectpicker(pickerObj);
    
    
    var selected_day_parking_address_type = "";
    
    if ( typeof(  vehicle_details['day_parking_address_type']  ) != "undefined") {
        
        selected_day_parking_address_type = vehicle_details['day_parking_address_type'];
    }
    
    pickerObj = {"dataList":address_type_list,"ctrlId":"day_address_type","key":"key","val":"val","selected":selected_day_parking_address_type};
    
    fill_selectpicker(pickerObj);
            
    /*if( typeof(data.AddressType) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.AddressType)) == "object") {
            var address_type_list = jQuery.parseJSON(data.AddressType).value;
            pickerObj = {"dataList":address_type_list,"ctrlId":"night_address_type","key":"Name","val":"Name"};
            fill_selectpicker(pickerObj);
            
            pickerObj = {"dataList":address_type_list,"ctrlId":"day_address_type","key":"Name","val":"Name"};
            fill_selectpicker(pickerObj);
        }
    }*/
    
    var selected_night_access_control = "";
    
    if ( typeof( vehicle_details['night_access_control']  ) != "undefined") {
        
        selected_night_access_control = vehicle_details['night_access_control'];
    }
    
    if( typeof(data.AccessControlType) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.AccessControlType)) == "object") {
            var access_type_list = jQuery.parseJSON(data.AccessControlType).value;
            pickerObj = {"dataList":access_type_list,"ctrlId":"night_address_access_control_type","key":"Value","val":"Description","selected":selected_night_access_control};
            fill_selectpicker(pickerObj);
        }
    }
    
    var selected_day_access_control = "";
    
    if ( typeof( vehicle_details['day_access_control']  ) != "undefined") {
        
        selected_day_access_control = vehicle_details['day_access_control'];
    }
    
    if( typeof(data.AccessControlType) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.AccessControlType)) == "object") {
            var access_type_list = jQuery.parseJSON(data.AccessControlType).value;
            pickerObj = {"dataList":access_type_list,"ctrlId":"day_access_control","key":"Value","val":"Description","selected":selected_day_access_control};
            fill_selectpicker(pickerObj);
        }
    }
           
    var selected_night_area_type = "";
    
    if ( typeof( vehicle_details['night_area_type'] ) != "undefined") {
        
        selected_night_area_type = vehicle_details['night_area_type'];
        
    }
    if( typeof(data.TelesureAreaTypeItems) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.TelesureAreaTypeItems)) == "object") {
            var area_type_list = jQuery.parseJSON(data.TelesureAreaTypeItems).value;
            pickerObj = {"dataList":area_type_list,"ctrlId":"night_parking_area_type","key":"Value","val":"Description","selected":selected_night_area_type};
            fill_selectpicker(pickerObj);
        }
    }
    
    var selected_day_area_type = "";
    
    if ( typeof( vehicle_details['day_area_type'] ) != "undefined") {
        
        selected_day_area_type = vehicle_details['day_area_type'];
    }
    
    if( typeof(data.TelesureAreaTypeItems) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.TelesureAreaTypeItems)) == "object") {
            var area_type_list = jQuery.parseJSON(data.TelesureAreaTypeItems).value;
            pickerObj = {"dataList":area_type_list,"ctrlId":"area_type","key":"Value","val":"Description","selected":selected_day_area_type};
            fill_selectpicker(pickerObj);
        }
    }
    
    var selected_tracking_type = "";
     if ( typeof( vehicle_details['tracking_device_type'] ) != "undefined") {
        
        selected_tracking_type = vehicle_details['tracking_device_type'];
    }
    
    if( typeof(data.MotorTrackerOptions) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.MotorTrackerOptions)) == "object") {
            var access_motor_tracker_option = jQuery.parseJSON(data.MotorTrackerOptions).value;
            pickerObj = {"dataList":access_motor_tracker_option,"ctrlId":"tracking_device_type","key":"Value","val":"Description","selected":selected_tracking_type};
            fill_selectpicker(pickerObj);
        }
    }

    var selected_insure_option = "";
    if ( typeof( vehicle_details['insured_option']  ) != "undefined") {
        selected_insure_option = vehicle_details['insured_option'] ;
    }
    
    if( typeof(data.MotorInsuredItems) != "undefined" ){
        if ( typeof(jQuery.parseJSON(data.MotorInsuredItems)) == "object") {
            var motor_insured_item = jQuery.parseJSON(data.MotorInsuredItems).value;
            var insured_info ={"T":"TRADE - Trade value is the amount you can get for your car if you trade it in toward the purchase of another car","M":" MARKET - Market value is the general value the Autodealers guide allocates to it.","R":"RETIAL - Retail value is the amount for which a recognized dealership would sell your car."};
            for( k in motor_insured_item){
              motor_insured_item[k]["Description"] = insured_info[motor_insured_item[k]["Value"]];
              
            }
            
            pickerObj = {"dataList":motor_insured_item,"ctrlId":"insure_type","key":"Value","val":"Description","selected":selected_insure_option};
            fill_selectpicker(pickerObj);
        }
    }

}

$(document).ready(function(){
    
    //set_dreiver_from_localstorage();
    
    $(".ajx-control").on('change',function(){
      $(this).addClass('changed');
    });
    $("#mob-menu-open").click(function(){
        $(".main-menu-wrap").css("left", 0);
    });
    $("#mob-menu-close").click(function(){
        $(".main-menu-wrap").css("left", "-100%");
    });
    $(".search-btn").click(function(){
        $(".search-text").css({"width":"100%", "padding":"0 15px"});
    });
    
    /*$('#suburb').typeahead({
                    ajax: {
                        url: http_path+'/ajax_data.php',
                        timeout: 500,
                        displayField: "Suburb",
                        valueField: 'Name',
                        limit :1000,
                        triggerLength: 1,
                        method: "post",
                        loadingClass: "loading-circle",
                        preDispatch: function (query) {
                            show_loading_inline("suburb");
                            return {
                                q: query, opcode:'get_address',w:'suburb',
                            }
                        },
                        preProcess: function (data) {
                            hide_loading_inline("suburb");
                            if (data.resultStatus != "Success") {
                                // Hide the list, there was some error
                                return false;
                            }
                            // We good!
                            
                            return  data.resultData;
                        }
                    },
                    onSelect: function(item) {
						console.log("selected");
						console.log(item.value);
                        var personal_address = item.value;
                        var personal_address_array = personal_address.split(",");                        
                        $("#personal_address_id").val(personal_address_array[0]);
                        $("#city").val(personal_address_array[4]);
                        $("#postal_code").val(personal_address_array[1]);
                        
					},
                });
    
    $('#postal_code').typeahead({
                    ajax: {
                        url: http_path+'/ajax_data.php',
                        timeout: 500,
                        displayField: "Code",
                        valueField: 'Name',
                        triggerLength: 3,
                        method: "post",
                        loadingClass: "loading-circle",
                        preDispatch: function (query) {
                            show_loading_inline("postal_code");
                            return {
                                q: query, opcode:'get_address',w:'postal_code',
                            }
                        },
                        preProcess: function (data) {
                            hide_loading_inline("postal_code");
                            console.log(data);
                            if (data.resultStatus != "Success") {
                                // Hide the list, there was some error
                                return false;
                            }
                            // We good!
                            
                            return  data.resultData;
                        }
                    },
                    onSelect: function(item) {
						console.log("selected");
						console.log(item.value);
                        var personal_address = item.value;
                        var personal_address_array = personal_address.split(",");                        
                        $("#personal_address_id").val(personal_address_array[0]);
                        $("#city").val(personal_address_array[4]);
                        $("#suburb").val(personal_address_array[3]);
                        
					},
                });
    
    $('#driver_suburb').typeahead({
                    ajax: {
                        url: http_path+'/ajax_data.php',
                        timeout: 500,
                        displayField: "Suburb",
                        valueField: 'Name',
                        triggerLength: 1,
                        method: "post",
                        loadingClass: "loading-circle",
                        preDispatch: function (query) {
                            show_loading_inline("driver_suburb");
                            return {
                                q: query, opcode:'get_address',w:'suburb',
                            }
                        },
                        preProcess: function (data) {
                            hide_loading_inline("driver_suburb");
                            console.log(data);
                            if (data.resultStatus != "Success") {
                                // Hide the list, there was some error
                                return false;
                            }
                            // We good!
                            
                            return  data.resultData;
                        }
                    },
                    onSelect: function(item) {
						console.log("selected");
						console.log(item.value);
                        var driver_address = item.value;
                        var driver_address_array = driver_address.split(",");                        
                        $("#driver_address_id").val(driver_address_array[0]);
                        $("#driver_city").val(driver_address_array[4]);
                        $("#driver_postal_code").val(driver_address_array[1]);
                        
					},
                });
    
    $('#driver_postal_code').typeahead({
                    ajax: {
                        url: http_path+'/ajax_data.php',
                        timeout: 500,
                        displayField: "Code",
                        valueField: 'Name',
                        triggerLength: 3,
                        method: "post",
                        loadingClass: "loading-circle",
                        preDispatch: function (query) {
                            show_loading_inline("driver_postal_code");
                            return {
                                q: query, opcode:'get_address',w:'postal_code',
                            }
                        },
                        preProcess: function (data) {
                            hide_loading_inline("driver_postal_code");
                            console.log(data);
                            if (data.resultStatus != "Success") {
                                // Hide the list, there was some error
                                return false;
                            }
                            // We good!
                            
                            return  data.resultData;
                        }
                    },
                    onSelect: function(item) {
						console.log("selected");
						console.log(item.value);
                        var driver_address = item.value;
                        var driver_address_array = driver_address.split(",");                        
                        $("#personal_address_id").val(driver_address_array[0]);
                        $("#driver_city").val(driver_address_array[4]);
                        $("#driver_suburb").val(driver_address_array[3]);
                        
					},
                });*/
});

function refresh_car_details() {
    
        $('#vehicle_id').val('');
        
        $('#registration_number').val('');
        
        $('#year_of_registration').val('');
        
        $('#year_of_registration').selectpicker('refresh');
        
        $('#car_model').val('');
        
        $('#car_model').selectpicker('refresh');
        
        $('#car_make').val('');
        
        $('#car_make').selectpicker('refresh');
        
        $('#car_series').val('');
        
        $('#car_series').selectpicker('refresh');
        
        $('#vehicle_colour').val('');
        
        $('#vehicle_colour').selectpicker('refresh');
        
        $('#vehicle_paint_type').val('');
        
        $('#vehicle_paint_type').selectpicker('refresh');
        
        $('#service_history').prop('checked',false);
        
        $('#current_mileage').val('');
        
        $('#vehicle_license_issue_date').val('');
        
        $('#vehicle_license_issue_type').val('');
        
        $('#vehicle_license_issue_type').selectpicker('refresh');
        
        $('input[name=vehicle_finance]').prop('checked',false);
        
        $('#no_claim_bonus').val('');
        $('#no_claim_bonus').selectpicker('refresh');
        
        $('#vehicle_use').val('');
        $('#vehicle_use').selectpicker('refresh');
        
        $('#driver_access_control').val('');
        $('#driver_access_control').selectpicker('refresh');
        
        $('#driver_area_type').val('');
        $('#driver_area_type').selectpicker('refresh');
        
        /*reset an hidden fields*/
        $('#hail_cover').val('');
        $('#windscreen_cover').val('');
        $('#cover_type').val('');
        $('#car_hire_included').val('');
        $('#car_hire_option').val('');
        $('#radio_cover').val('');
        $('#radio_cover_value').val('');
        $('#canopy_included').val('');
        $('#theft_access_include').val('');
        $('#voluntary_excess').val('');
        $('#mm_code').val('');
        $('#insurance_customer_vehicle_id').val('');
        
        
        vehicle_details = {};
        overnight_parking  =  night_address_type = night_access_control = night_area_type = night_parking_same = night_parking_postcode = "";
        night_parking_suburb = day_area_type  = day_access_control = day_parking  = day_parking_sane = day_parking_postcode  = day_parking_suburb = "";
        day_parking_address_type = insured_option  = "";
        
    }
    
function fetch_car_details(reg_no,type){
    try{
        showLoading();
        
        if (reg_no != "") {
            
            if (reg_no == 'Add New') {
                
                refresh_car_details();
                
                load_storage_formfeeds();
                
                hideLoading();
                
                return false;
            }
            
            var ajx_param = {	
                "url": http_path+"/vehicle-details",
                "sync": "false",
                "method": "POST",
                "data": { opcode:'get_car_details','registration_number': reg_no,'type':type},
                "ajxcallback":function(resobj){
                 if ( resobj.resultStatus== "Success" ) {
                    
                    var vehicle_data = resobj.resultData;
                    
                    if ( resobj.resultAction == "All" ) {
                        
                         refresh_car_details();
                         
                         $("#registration_number").val(vehicle_data.VehicleRegistrationNo);
                         
                         if ( typeof(vehicle_data.Year) != "undefined") {
                            if ( vehicle_data.Year != "" ) {
                                console.log("Year:"+vehicle_data.Year);
                                $('#year_of_registration').val( vehicle_data.Year );
                                vehicle_details["year"] = vehicle_data.Year;
                                $('#year_of_registration').selectpicker('refresh').change();
                                
                            }
                        }
                        
                        if ( typeof(vehicle_data.Make) != "undefined") {
                            if ( vehicle_data.Make != "" ) {
                                console.log("Make:"+vehicle_data.Make);
                                $('#car_make').val( vehicle_data.Make );
                                vehicle_details["make"] = vehicle_data.Make;
                                $('#car_make').selectpicker('refresh').change();
                               
                            }
                        }
                        
                        
                        if ( typeof(vehicle_data.Model) != "undefined") {
                            if ( vehicle_data.Model != "" ) {
                                console.log("Model:"+vehicle_data.Model);
                                $('#car_model').val( vehicle_data.Model );
                                vehicle_details["model"] = vehicle_data.Model;
                                $('#car_model').selectpicker('refresh').change();
                             
                            }
                        }
                        
                        if ( typeof(vehicle_data.Series) != "undefined") {
                            if ( vehicle_data.Series != "" ) {
                                console.log("Series:"+vehicle_data.Series);
                                $('#car_series').val( vehicle_data.Series );
                                vehicle_details["series"] = vehicle_data.Series;
                                $('#car_series').selectpicker('refresh').change();
                                
                            }
                        }
                        
                        
                    }
                    else{
                        
                       
                        
                        if ( typeof(vehicle_data.CustomerVehicleID) != "undefined") {
                            if ( vehicle_data.CustomerVehicleID != "" ) {
                                $('#vehicle_id').val( vehicle_data.CustomerVehicleID );
                            }
                        }
                   
                        if ( typeof(vehicle_data.RegistrationNo) != "undefined") {
                            if ( vehicle_data.RegistrationNo != "" ) {
                                $('#registration_number').val( vehicle_data.RegistrationNo );
                            }
                        }
                       
                        if ( typeof(vehicle_data.Year) != "undefined") {
                            if ( vehicle_data.Year != "" ) {
                                $('#year_of_registration').val( vehicle_data.Year );
                                vehicle_details["year"] = vehicle_data.Year;
                                $('#year_of_registration').selectpicker('refresh').change();
                                
                            }
                        }
                        
                        if ( typeof(vehicle_data.Make) != "undefined") {
                            if ( vehicle_data.Make != "" ) {
                                $('#car_make').val( vehicle_data.Make );
                                vehicle_details["make"] = vehicle_data.Make;
                                $('#car_make').selectpicker('refresh').change();
                                //$('#car_make').change();
                            }
                        }
                         
                        if ( typeof(vehicle_data.Model) != "undefined") {
                            if ( vehicle_data.Model != "" ) {
                                $('#car_model').val( vehicle_data.Model );
                                vehicle_details["model"] = vehicle_data.Model;
                                $('#car_model').selectpicker('refresh').change();
                                //$('#car_model').change();
                            }
                        }
                         
                        if ( typeof(vehicle_data.Series) != "undefined") {
                            if ( vehicle_data.Series != "" ) {
                                $('#car_series').val( vehicle_data.Series );
                                vehicle_details["series"] = vehicle_data.Series;
                                $('#car_series').selectpicker('refresh').change();
                                //$('#car_series').change();
                            }
                        }
                        
                        if ( typeof(vehicle_data.ServiceHistory) != "undefined") {
                            if ( vehicle_data.ServiceHistory == "true" || vehicle_data.ServiceHistory == 1) {
                               //$(".service_history[value='true']").attr('checked', 'checked');
                               $(".service_history[value='true']").prop('checked', true);
                            }
                            else{
                               $(".service_history[value='false']").prop('checked', true);
                            }
                        }
                        
                        if ( typeof(vehicle_data.InsuranceCustomerVehicle) != "undefined") {
                            
                            console.log(vehicle_data.InsuranceCustomerVehicle);
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DriverAccessControl) != "undefined") {
                                if ( vehicle_data.InsuranceCustomerVehicle.DriverAccessControl != "" ) {
                                    $('#driver_access_control').val( vehicle_data.InsuranceCustomerVehicle.DriverAccessControl );
                                    $('#driver_access_control').selectpicker('refresh');
                                }
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DriverAreaType) != "undefined") {
                                if ( vehicle_data.InsuranceCustomerVehicle.DriverAreaType != "" ) {
                                    $('#driver_area_type').val( vehicle_data.InsuranceCustomerVehicle.DriverAreaType );
                                    $('#driver_area_type').selectpicker('refresh');
                                }
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.VehicleColour) != "undefined") {
                                $('#vehicle_colour').val( vehicle_data.InsuranceCustomerVehicle.VehicleColour );
                                $('#vehicle_colour').selectpicker('refresh');
                            }
                        
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.VehiclePaintType) != "undefined") {
                                $('#vehicle_paint_type').val( vehicle_data.InsuranceCustomerVehicle.VehiclePaintType );
                                $('#vehicle_paint_type').selectpicker('refresh');
    
                            }
                        
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.CurrentMileage) != "undefined") {
                                $('#current_mileage').val( vehicle_data.InsuranceCustomerVehicle.CurrentMileage );
                            }
                        
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DriverLicenseDate) != "undefined") {
                                var license_date = (vehicle_data.InsuranceCustomerVehicle.DriverLicenseDate).split("T")[0];
                                $('#vehicle_license_issue_date').val( license_date );
                            }
                        
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DriverLicenseType) != "undefined") {
                                $('#vehicle_license_issue_type').val( vehicle_data.InsuranceCustomerVehicle.DriverLicenseType );
                                $('#vehicle_license_issue_type').selectpicker('refresh');
    
                            }
                         
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.VehicleFinanced) != "undefined") {
                                if ( vehicle_data.InsuranceCustomerVehicle.VehicleFinanced == "true" ) {
                                    $(".vehicle_finance[value='true']").prop('checked',true);
                                }
                                else{
                                   $(".vehicle_finance[value='false']").prop('checked', true);
                                } 
                            }
                        
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.NCB) != "undefined") {
                                  $('#no_claim_bonus').val( vehicle_data.InsuranceCustomerVehicle.NCB );
                                  $('#no_claim_bonus').selectpicker('refresh');
    
                            }
                        
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.VehicleUse) != "undefined") {
                                  $('#vehicle_use').val( vehicle_data.InsuranceCustomerVehicle.VehicleUse );
                                  $('#vehicle_use').selectpicker('refresh');
    
                            }
                        }
                        
                        console.log("fill storage form feed");
                        //vehicle storage data
                        if ( typeof(vehicle_data.InsuranceCustomerVehicle) != "undefined") {
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.OvernightParking) != "undefined") {
                                  //$('#vehicle_parking').val( vehicle_data.InsuranceCustomerVehicle.OvernightParking )
                                  overnight_parking = vehicle_data.InsuranceCustomerVehicle.OvernightParking;
                                  vehicle_details["overnight_parking"] = vehicle_data.InsuranceCustomerVehicle.OvernightParking;;
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.NightAddressType) != "undefined") {
                                  //$('#night_address_type').val( vehicle_data.InsuranceCustomerVehicle.NightAddressType )
                                  night_address_type = vehicle_data.InsuranceCustomerVehicle.NightAddressType;
                                  vehicle_details["night_address_type"] = vehicle_data.InsuranceCustomerVehicle.NightAddressType;
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.NightAccessControl) != "undefined") {
                                  //$('#night_address_access_control_type').val( vehicle_data.InsuranceCustomerVehicle.NightAccessControl )
                                  night_access_control = vehicle_data.InsuranceCustomerVehicle.NightAccessControl;
                                  vehicle_details["night_access_control"] = vehicle_data.InsuranceCustomerVehicle.NightAccessControl;
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.NightAreaType) != "undefined") {
                                  //$('#night_parking_area_type').val( vehicle_data.InsuranceCustomerVehicle.NightAreaType )
                                  night_area_type = vehicle_data.InsuranceCustomerVehicle.NightAreaType;
                                  vehicle_details["night_area_type"] = vehicle_data.InsuranceCustomerVehicle.NightAreaType;
    
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DayAreaType) != "undefined") {
                                  //$('#area_type').val( vehicle_data.InsuranceCustomerVehicle.DayAreaType )
                                  day_area_type = vehicle_data.InsuranceCustomerVehicle.DayAreaType;
                                  vehicle_details["day_area_type"] = vehicle_data.InsuranceCustomerVehicle.DayAreaType;
    
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DayAccessControl) != "undefined") {
                                  //$('#day_access_control').val( vehicle_data.InsuranceCustomerVehicle.DayAccessControl )
                                  day_access_control = vehicle_data.InsuranceCustomerVehicle.DayAccessControl;
                                  vehicle_details["day_access_control"] = vehicle_data.InsuranceCustomerVehicle.DayAccessControl;
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DayParking) != "undefined") {
                                  //$('#day_parking').val( vehicle_data.InsuranceCustomerVehicle.DayParking )
                                  day_parking = vehicle_data.InsuranceCustomerVehicle.DayParking;
                                  vehicle_details["day_parking"] = vehicle_data.InsuranceCustomerVehicle.DayParking;
    
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.DayAddressType) != "undefined") {
                                  //$('#day_parking').val( vehicle_data.InsuranceCustomerVehicle.DayParking )
                                  day_address_type = vehicle_data.InsuranceCustomerVehicle.DayAddressType;
                                  vehicle_details["day_parking_address_type"] = vehicle_data.InsuranceCustomerVehicle.DayAddressType;
    
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.InsuredOption) != "undefined") {
                                  //$('#insure_type').val( vehicle_data.InsuranceCustomerVehicle.InsuredOption )
                                  insured_option = vehicle_data.InsuranceCustomerVehicle.InsuredOption;
                                  vehicle_details["insured_option"] = vehicle_data.InsuranceCustomerVehicle.InsuredOption;
                            }
                            
                            console.log("TrackingDeviceInstalled:"+vehicle_data.InsuranceCustomerVehicle.TrackingDeviceInstalled);
                            console.log("TrackerDeviceType:"+vehicle_data.InsuranceCustomerVehicle.TrackerDeviceType);
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.TrackingDeviceInstalled) != "undefined") {
                                   
                                if ( vehicle_data.InsuranceCustomerVehicle.TrackingDeviceInstalled == "Y") {
                                    
                                    $(".tracking_device[value='0']").prop('checked',true);
                                    
                                    $("#tracking_device_form").show();
                                     
                                    if ( typeof(vehicle_data.InsuranceCustomerVehicle.TrackerDeviceType) != "undefined") {
                                        
                                        vehicle_details['tracking_device_type'] = vehicle_data.InsuranceCustomerVehicle.TrackerDeviceType;
                                        
                                        //$('#tracking_device_type').val( vehicle_data.InsuranceCustomerVehicle.TrackerDeviceType );
                                        //$('#tracking_device_type').selectpicker('refresh');
                                    }
                                }
                                else{
                                    
                                     $(".tracking_device[value='1']").attr('checked','checked');
                                     $(".tracking_device[value='1']").prop('checked',true);
                                    
                                }
    
                            }
                          
                            // vehicle storage hidden fields
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.InsuranceCustomeVehicleID) != "undefined") {
                                  $('#insurance_customer_vehicle_id').val( vehicle_data.InsuranceCustomerVehicle.InsuranceCustomeVehicleID )
                            }
                            
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.HailCover) != "undefined") {
                                  $('#hail_cover').val( vehicle_data.InsuranceCustomerVehicle.HailCover )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.WindscreenCover) != "undefined") {
                                  $('#windscreen_cover').val( vehicle_data.InsuranceCustomerVehicle.WindscreenCover )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.CoverType) != "undefined") {
                                  $('#cover_type').val( vehicle_data.InsuranceCustomerVehicle.CoverType )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.CarHireIncluded) != "undefined") {
                                  $('#car_hire_included').val( vehicle_data.InsuranceCustomerVehicle.CarHireIncluded )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.CarHireOption) != "undefined") {
                                  $('#car_hire_option').val( vehicle_data.InsuranceCustomerVehicle.CarHireOption )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.RadioCover) != "undefined") {
                                  $('#radio_cover').val( vehicle_data.InsuranceCustomerVehicle.RadioCover )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.RadioCoverValue) != "undefined") {
                                  $('#radio_cover_value').val( vehicle_data.InsuranceCustomerVehicle.RadioCoverValue )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.CanopyCoverIncluded) != "undefined") {
                                  $('#canopy_included').val( vehicle_data.InsuranceCustomerVehicle.CanopyCoverIncluded )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.IncludeTheftExcessBuster) != "undefined") {
                                  $('#theft_access_include').val( vehicle_data.InsuranceCustomerVehicle.IncludeTheftExcessBuster )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.VoluntaryExcess) != "undefined") {
                                  $('#voluntary_excess').val( vehicle_data.InsuranceCustomerVehicle.VoluntaryExcess )
                            }
                            if ( typeof(vehicle_data.InsuranceCustomerVehicle.MMCode) != "undefined") {
                                  $('#mm_code').val( vehicle_data.InsuranceCustomerVehicle.MMCode )
                            }
                            
                        }
                        
                    }
                    
                    // Set vehicle Details
                    fill_vehicle_description();
                    
                    hideLoading(0);
                    
                    load_storage_formfeeds();
                 }
                 hideLoading(0);
                 
                 
                }
            };
            call_ajax(ajx_param);
         }
         else{
             hideLoading();
            
         }
       
    }
    catch(e){
        alert("Error@fetch_car_details"+e);
    }
}

function store_driver_to_localstorage(){
    
    var driver_details = {};
    
    $("#driver_details .ajx-control").each(function(){
    
      key_name = $(this).attr('name');
      
      value = $(this).val();
      
      if( typeof(key_name) != "undefined" ){
        
        driver_details[key_name] = value;
        
      }
      
    });
    
    resLocalStorage.setItem("driver_details",driver_details);
    
}

function set_dreiver_from_localstorage() {
    
    var driver_from_feed = resLocalStorage.getItemObject("driver_details");
    
    for( key in driver_from_feed){
    
        if( $("input[name='"+key+"']").length ){
          
            var input_type = $("input[name='"+key+"']").prop('type');
            
            if(input_type == "text" || input_type == "email" || input_type == "hidden"){
              
              $("input[name='"+key+"']").val(driver_from_feed[key]);
              
            }
            else if(input_type == "radio"){
            
              $("input[name='"+key+"'][value='"+driver_from_feed[key]+"']").prop('checked',true)
              
            }
        }
      
        if( $("select[name='"+key+"']").length ){
      
             $("select[name='"+key+"']").val(driver_from_feed[key]);
        }
      
    }
}


//var match_staging = http_path.match(/staging.motorhappy.co.za\/telesure/g);

//var AJAX_CALL_URL_LOAD 		= http_path+'/ajax_data.php';

//if ( match_staging != null) {
    AJAX_CALL_URL_LOAD 		= http_path+'/personal-details';
//}

    var options_autocomplete = {
        minLength: 0,
        source: function (request, response) {
            var addressType;
            var calling_element = jQuery(this.element).prop("id");
            if ( calling_element == "suburb" ||  calling_element == "driver_suburb") {
                addressType = "suburb";
            }
            else if ( calling_element == "postal_code" ||  calling_element == "driver_postal_code") {
                addressType = "postal_code";
                
            }
            search_term = request.term;
            
            if ($.trim(search_term) == "") {
                return false;
            }
            
            show_loading_inline(calling_element);
            
            jQuery.ajax({
                url: AJAX_CALL_URL_LOAD,
                type: "POST",
                dataType: "json",
                data:{'w': addressType, 'q' : search_term, 'opcode': 'get_address'},
                success: function (data) {
                    response(data.resultData);
                    hide_loading_inline(calling_element);
                },
                error: function (xhr, status, result) {
                    //generate('danger',ERR_AJAX);
                    console.log("Ajax Error:"+result);
                    var message = "Suburb not found.Please try other";
                    $.msgGrowl ({
                        title: 'Warning' // Optional
                       ,text: message
                       ,position: 'top-center'
                       ,msgtype: 'Error'
                     });
                }
            });
        },
        select: function (event, ui) {

            var calling_element = jQuery(this).prop("id");
           
            console.log(ui.item);
            
            if ( calling_element == "suburb" ) {
                $("#personal_address_id").val(ui.item.ID);
                $("#city").val(ui.item.City);
                $("#postal_code").val(ui.item.Code);
            }
            else if ( calling_element == "postal_code" ) {
                $("#personal_address_id").val(ui.item.ID);
                $("#city").val(ui.item.City);
                $("#postal_code").val(ui.item.Code);
                $("#suburb").val(ui.item.Suburb);
            }
            else if ( calling_element == "driver_suburb") {
                $("#driver_city").val(ui.item.City);
                $("#driver_postal_code").val(ui.item.Code);
                $("#driver_address_id").val(ui.item.ID);
            }
             else if ( calling_element == "driver_postal_code") {
                $("#driver_city").val(ui.item.City);
                $("#driver_postal_code").val(ui.item.Code);
                $("#driver_address_id").val(ui.item.ID);
                $("#driver_suburb").val(ui.item.Suburb);
            }
            
            
        },
        change: function( event, ui ) {

            /*if(ui.item == null)
            {
                jQuery(this).val("");
                return false;
            }*/
        },
        messages: {
            noResults: '',
            results: function() {}
        },
        delay: 100
    };

   jQuery('#suburb').autocomplete(options_autocomplete);
   jQuery('#postal_code').autocomplete(options_autocomplete);
   
   jQuery('#driver_suburb').autocomplete(options_autocomplete);
   jQuery('#driver_postal_code').autocomplete(options_autocomplete);
   
   function callme_nold(objcallme) {
    
            var param_data = {};
            
            if( typeof(objcallme) == "object" ){
                
                param_data = objcallme;
            }
            
            param_data["opcode"] = "callme_nold";
            
            console.log(param_data);
            
            showLoading();
            var ajx_param = {
            "url": http_path+'/results',
            "sync": "false",
            "method": "POST",
            "data": param_data,
            "ajxcallback":function(resdata){
          
                var ref_msg = "";
                
                if ( typeof(resdata.resultStatus) != "undefined") {
                        
                    if ( resdata.resultStatus == "Success") {
                        
                        if ( typeof(resdata.resultData) != "undefined") {
                            
                          if ( typeof(resdata.resultData.InsuranceCallMeNoIdSubmissionResult) != "undefined") {
                            
                                if ( resdata.resultData.InsuranceCallMeNoIdSubmissionResult.ErrorStatus == "E") {
                               
                                    var display_msg = resdata.resultData.InsuranceCallMeNoIdSubmissionResult.ErrorDescriptions;
                                    $.msgGrowl ({
                                       title: 'Error While Requesting Call Me Back' // Optional
                                      ,text: display_msg
                                      ,position: 'top-center'
                                      ,msgtype: 'Error'
                                    });
                                    hideLoading();
                                    return;
                                }
                                else{
                                    
                                    ref_msg = resdata.resultData.InsuranceCallMeNoIdSubmissionResult.LeadSubmissionReferenceNr;
                                
                                    console.log("redirect to thank you page"+ref_msg);
                                
                                    window.location.href = http_path+'/thankyou?type=callme&msg='+ref_msg;
                                    
                                }
                                
                                
                            }
                            
                        }
                        
                    }
                    else{
                        
                        var display_message = "";

                        if( typeof(resdata.resultData['result']) == "object"){
                        
                          var msges = resdata.resultData['result'];
                          
                          console.log(msges);
                          
                          for( msg in msges){
                          
                            display_message += msges[msg]+"<br/>";
                          }              
                          
                        }
                        
                        $.msgGrowl ({
                            title: resdata['resultData']['error_message']
                           ,text: display_message
                           ,position: 'top-center'
                           ,msgtype: 'Error'
                         });
                         hideLoading();
                         return; 
                    }
                }    
                
                hideLoading();
                }
            };
            call_ajax(ajx_param);
   }
   
function bind_click_till(n){
    $("a[data-step]").unbind('click');    
    for(i=1;i<=n;i++){    
        $("a[data-step='"+i+"']").click(function(){    
            console.log( $(this).attr('data-step'));
            var step_id = $(this).attr('data-step');
            stepnext(step_id,'')
        });
    }  
}



function fill_vehicle_description(){
    if( !$.trim($("#vehicle_info").val()).length ) {

        var v_data = [];
        
        if( jQuery("#year_of_registration option:selected").text() != "" ){
          
          v_data.push(jQuery("#year_of_registration option:selected").text());
          
        }
        if( jQuery("#car_make option:selected").text() != "" ){
          
          v_data.push(jQuery("#car_make option:selected").text());
          
        }
        if( jQuery("#car_model option:selected").text() != "" ){
          
          v_data.push(jQuery("#car_model option:selected").text());
          
        }
        if( jQuery("#car_series option:selected").text() != "" ){
          
          v_data.push(jQuery("#car_series option:selected").text());
          
        }
        
        $("#vehicle_info").val(v_data.join(' '));
    
    }
}