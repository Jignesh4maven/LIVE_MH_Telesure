<form id="frm_personal_details"  name="frm_personal_details" action="personal-details" class="form-horizontal form-s1" data-before="personal_form_validation()">
    <input type="hidden" name="opcode" value="personal_details" class="ajx-control" />
    <input type="hidden" name="customer_id" value="{$data.CustomerID}" class="ajx-control" />
    <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h3 class="form-title text-left">Billing Details</h3>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Select One</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="radio">
                              {if $data.PassportNo != ""}
                                  {assign var="passport_check" value="checked"}
                                  {assign var="passport_show" value=""}
                                   {assign var="id_show" value="display:none"}
                              {else}
                                    {assign var="id_check" value="checked"}
                                    {assign var="id_show" value=""}
                                    {assign var="passport_show" value="display:none;"}
                              {/if}
                              
                              {if $user ne 'Guest'}
                              {assign var="disable_for_user" value="disabled"}
                              {/if}
                                <input type="radio" {$disable_for_user} name="id_type_personal" value="id" class="ajx-control" {$id_check}  onclick="getbox()">
                                <label for="id">
                                    ID
                                </label>
                                <input type="radio" {$disable_for_user} name="id_type_personal" value="passport" class="ajx-control" {$passport_check}  onclick="getbox()">
                                <label for="passport">
                                    Passport
                                </label>
                            </div>
                        </div>
                    </div>
                  
                    <div class="form-group" >
                        <div class="col-sm-4 text-left">
                            {if $data.PassportNo != ""}
                            <label id="identity_label">Passport Number<span class="mandatory">*</span></label>
                            {else}
                            <label id="identity_label">ID Number<span class="mandatory">*</span></label>
                            {/if}
                            
                            <!--label id="pass_port_number">Passport Number<span class="mandatory">*</span></label>
                            <label id="id_number">ID Number<span class="mandatory">*</span></label-->
                        </div>
                        <div class="col-sm-8">
                            {* if $data.PassportNo != "" *}
                                <input type="text" {$disable_for_user} class="form-control ajx-control" style="{$passport_show}" value="{$data.PassportNo}" id="passport_number" name="passport_number" data-error="Please fill out this field" required/>
                            {* else *}
                                <input type="text"  {$disable_for_user} class="form-control ajx-control integer"  style="{$id_show}" maxlength="13" value="{$data.IdentificationNo}" id="identity_number" name="identity_number" data-error="Please fill out this field" required/>
                            {*/if*}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Title<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <select id="person_title" name="person_title" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field" required>
                            {foreach from=$title_data item=record}
                                {if $record->ID != "" && $record->ID == $data.Title}
                                    <option selected="selected" value="{$record->ID}"> {$record->Name} </option> 
                                {else}
                                    <option value="{$record->ID}"> {$record->Name} </option>    
                                {/if}
                                
                            {/foreach}

                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Name<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="name" name="name" value="{$data.FirstName}" class="form-control ajx-control" data-error="Please fill out this field" required/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Surname<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="surname" name="surname" value="{$data.SurName}" class="form-control ajx-control" data-error="Please fill out this field" required/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Date of Birth<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date " id="person-dob-container">
                              <input type="text" id="dob" name="dob" value="{$data.BirthDate}"  class="form-control   ajx-control" data-date-format="yy-mm-dd" data-error="Please fill out this field" required/>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>                     
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Email Address<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="email" id="email" name="email" value="{$data.Email}"  class="form-control ajx-control" data-error="This field seems invalid." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Mobile<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="mobile" name="mobile" value="{$data.CellphoneNo}" class="form-control ajx-control integer" data-fv-field="number" data-error="This field seems invalid." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Telephone<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="telephone" name="telephone" value="{$data.OtherContactNo}" class="form-control ajx-control integer" data-fv-field="number" data-error="This field seems invalid." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Fax</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="fax" name="fax" value="{$data.FaxNo}"  class="form-control ajx-control integer"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Physical Address<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="street_address" value="{$data.AddressLine1}" name="street_address" class="form-control ajx-control fill-address" placeholder="Street Address" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                            <input type="text" id="street_address2" value="{$data.AddressLine2}" name="street_address2" class="form-control ajx-control fill-address" placeholder="Address 1" />
                            <input type="text" id="street_address3" value="{$data.AddressLine3}" name="street_address3" class="form-control ajx-control fill-address" placeholder="Address 2" />
                            
                            <div for="suburb" class="">
                            <input type="text" id="suburb" value="{$data.Suburb}" name="suburb" class="form-control ajx-control fill-address" placeholder="Suburb" autocomplete="off" data-error="Please fill out this field." required/>
                            </div>
                            
                            <input type="hidden" value="{$data.PostCodeId}" id="personal_address_id" name="personal_address_id" class="ajx-control" />
                            <div class="help-block with-errors"></div>
                            <input type="text" id="city" value="{$data.City}" readonly="readonly" name="city" class="form-control ajx-control fill-address" placeholder="City / Town" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                            <div for="postal_code" class="">
                            <input type="text" id="postal_code" value="{$data.PostCode}" name="postal_code" class="integer form-control  ajx-control fill-address" placeholder="Postal Code" data-error="Please fill out this field." required />
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Gender<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <div class="radio">
                                <input type="radio" name="gender" value="M" class="ajx-control" checked>
                                <label for="radio2">
                                    Male
                                </label>
                                <input type="radio" name="gender" value="F" class="ajx-control">
                                <label for="radio1">
                                    Female
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Marital Status<span class="mandatory">*</span></label>
                        </div>
                       
                        <div class="col-sm-8">
                            <select id="marital_status" name="marital_status" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field." required>
                                <option value="">SELECT</option>
                                {foreach from=$marital_status  item=record}
                                  {if $record->Value == $data.MaritalStatus}
                                     <option value="{$record->Value}" selected="selected"> {$record->Description} </option>
                                  {else}
                                     <option value="{$record->Value}"> {$record->Description} </option>
                                  {/if}
                                {/foreach}
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Employment Status<span class="mandatory">*</span></label>
                        </div>
                        
                        <div class="col-sm-8">
                            <select id="employment_status" name="employment_status" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field." required>
                                <option value="">SELECT</option>
                                {foreach from=$employment_status item=record}
                                  {if $record->Value == $data.EmploymentStatus}
                                      <option value="{$record->Value}" selected="selected"> {$record->Description} </option>
                                  {else}
                                      <option value="{$record->Value}"> {$record->Description} </option>
                                  {/if}
                                {/foreach}
                               
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="row">
                        <div class="col-sm-4 text-left">
                            <h3 class="form-title text-left">Driver Details</h3>
                        </div>
                        <div class="col-sm-8">
                             {if $personal.same_as_billing == "true"}
                                  {assign var="same_as_billing" value="checked"}
                                  
                              {else}
                                   {assign var="same_as_billing" value=""}
                              {/if}
                            <div class="checkbox chk-same">
                                <input type="checkbox" class="ajx-control" {$same_as_billing} name="same_as_billing" id="same_as_billing" value="same_as_billing" data-error="Please fill out this field." required>
                                <label for="same_as_billing">Same as Billing Details</label>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <span id="driver_details">
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Select One<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <div class="radio">
                                <input type="radio" name="driver_id_type" value="id" class="ajx-control" {$id_check}  onclick="getboxdriver()">
                                <label for="id">
                                    ID
                                </label>
                                <input type="radio" name="driver_id_type" class="ajx-control" value="passport" {$passport_check}  onclick="getboxdriver()">
                                <label for="passport">
                                    Passport
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="col-sm-4 text-left">
                            {if $data.PassportNo != ""}
                            <label id="driver_identity_label">Passport Number<span class="mandatory">*</span></label>
                            {else}
                            <label id="driver_identity_label">ID Number<span class="mandatory">*</span></label>
                            {/if}
                            
                            <!--label id="pass_port_number">Passport Number<span class="mandatory">*</span></label>
                            <label id="id_number">ID Number<span class="mandatory">*</span></label-->
                        </div>
                        <div class="col-sm-8">
                            {* if $data.PassportNo != "" *}
                                <input type="text" class="form-control ajx-control" style="{$passport_show}" value="{$driver.driver_passport_number}" id="driver_passport_number" name="driver_passport_number" data-error="Please fill out this field" required/>
                            {* else *}
                                <input type="text" class="form-control ajx-control integer"  style="{$id_show}" value="{$driver.driver_identity_number}" maxlength="13" value="" id="driver_identity_number" name="driver_identity_number" data-error="Please fill out this field" required/>
                            {*/if*}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label id="driver_identity">Passport Number<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control ajx-control" id="driver_passport_number" name="driver_passport_number" data-error="Please fill out this field." required />
                            <input style="display: none;" type="text" class="form-control ajx-control integer" maxlength="13" id="driver_identity_number" name="driver_identity_number" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Title<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <select id="driver_title" name="driver_title" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field." required>
                                 {foreach from=$title_data item=record}
                                 {if $driver.driver_title == $record->ID}
                                 <option value="{$record->ID}" selected> {$record->Name} </option>
                                 {else}
                                 <option value="{$record->ID}"> {$record->Name} </option>
                                 {/if}
                                 
                                 {/foreach}
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Name<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" value="{$driver.driver_name}" class="form-control ajx-control" id="driver_name" name="driver_name" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Surname<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" value="{$driver.driver_surname}" class="form-control ajx-control" id="driver_surname" name="driver_surname" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Date of Birth<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="person-dob-container">
                                <input type="text" value="{$driver.driver_dob}" id="driver_dob" name="driver_dob" class="form-control ajx-control" data-date-format="yy-mm-dd" data-error="Please fill out this field" required/>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Email Address<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="email" value="{$driver.driver_email}" id="driver_email" name="driver_email"  class="form-control ajx-control" data-error="This field seems invalid." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Mobile<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="driver_mobile" value="{$driver.driver_email}" name="driver_mobile" class="integer form-control ajx-control" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Telephone<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="driver_telephone" value="{$driver.driver_telephone}" name="driver_telephone" class="integer form-control ajx-control" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Fax</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="driver_fax" value="{$driver.driver_fax}" name="driver_fax" class="integer form-control ajx-control" />
                             
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Physical Address<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="driver_street_address"  value="{$driver.driver_street_address}" name="driver_street_address" class="form-control fill-address ajx-control" placeholder="Street Address" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                            <input type="text" id="driver_street_address2"  value="{$driver.driver_street_address2}" name="driver_street_address2" class="form-control fill-address ajx-control" placeholder="Address 1" />
                            <input type="text" id="driver_street_address3"  value="{$driver.driver_street_address3}" name="driver_street_address3" class="form-control fill-address ajx-control" placeholder="Address 2" />

                           
                            <input type="text" id="driver_suburb" name="driver_suburb" value="{$driver.driver_suburb}" class="form-control fill-address ajx-control" placeholder="Suburb" data-error="Please fill out this field." required/>
                           

                            <div class="help-block with-errors"></div>
                            <input type="hidden" id="driver_address_id" value="{$driver.driver_address_id}" name="driver_address_id" value="" class="ajx-control" />
                            <input type="text" id="driver_city" value="{$driver.driver_city}" name="driver_city" readonly="readonly" class="form-control fill-address ajx-control" placeholder="City / Town" data-error="Please fill out this field." required />
                            <div class="help-block with-errors"></div>
                            <div for="driver_postal_code" class="">
                            <input type="text" id="driver_postal_code"  value="{$driver.driver_postal_code}" name="driver_postal_code" class="integer form-control  ajx-control fill-address" placeholder="Postal Code" data-error="Please fill out this field." required />
                            </div>

                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Gender<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                              
                              {if $driver.driver_gender != "M"}
                                  {assign var="male_check" value="checked"}
                                  {assign var="female_check" value=""}
                                  
                             {else if $driver.driver_gender != "G"}
                                  {assign var="female_check" value="checked"}
                                  {assign var="male_check" value=""}
                             {else}
                                 {assign var="male_check" value="checked"}
                                 {assign var="female_check" value=""}
                              {/if}
                              
                            <div class="radio">
                                <input type="radio" name="driver_gender"  value="M" class="ajx-control" {$male_check}>
                                <label for="radio2">
                                    Male
                                </label>
                                <input type="radio" name="driver_gender" value="F" class="ajx-control" {$female_check}>
                                <label for="radio1">
                                    Female
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Marital Status<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <select id="driver_marital_status" name="driver_marital_status" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field." required>
                                <option value="">SELECT</option>
                                {foreach from=$marital_status item=record}
                                 {if $driver.driver_marital_status == $record->Value}
                                 <option value="{$record->Value}" selected> {$record->Description} </option>
                                 {else}
                                 <option value="{$record->Value}"> {$record->Description} </option>
                                 {/if}
                                {/foreach}
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-left">
                            <label>Employment Status<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <select id="driver_employment_status" name="driver_employment_status" class="selectpicker show-tick form-control ajx-control" data-error="Please fill out this field." required>
                                <option value="">SELECT</option>
                                {foreach from=$employment_status item=record}
                                {if $driver.driver_employment_status == $record->Value}
                                <option value="{$record->Value}" selected> {$record->Description} </option>
                                {else}
                                <option value="{$record->Value}"> {$record->Description} </option>
                                {/if}
                                {/foreach}
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    </span>
            </div>
    </div>
    <div class="row">
        {literal}
            <div class="col-xs-12">
                <div class="text-center form-steps-btn clearfix">
                    <button class="btn btn-blue" type="button" onclick='trigger_form({"frm":"frm_personal_details","ajxcallback":function(resdata){personal_details_response(resdata);}});'>Next</button>
                </div>
            </div>
        {/literal}
    </div>
</form>
<script type="text/javascript">

    var http_path = "{$HTTP_PATH}";
    var login_user = "{$user}";
    
    {literal}

    $('#dob,#cal_icon,#driver_dob').Zebra_DatePicker({
        direction: false
    });

    function personal_form_validation(){
        
        showLoading();
        
        $('#frm_personal_details').validator('validate');
        
        var selected_radio= $("input[name='id_type_personal']:checked").val()

        var invalid_id = false;
             
        if (selected_radio == 'id') {
                    
          var inputed_id = $('#passport_number').val();
          
          if( validateRSAidnumber( $('#identity_number').val() ) ){
          
             console.log("Invalid ID Number");
             
             invalid_id = true;
          }
          
          if( validateRSAidnumber( $('#driver_identity_number').val() ) ){
          
             console.log("Invalid ID Number");
             
             invalid_id = true;
          }
        
        }
        
        var frm_group = $("#passport_number").parents('.form-group');
        var frm_group_driver = $("#driver_passport_number").parents('.form-group');
        
        if(invalid_id){
          
          frm_group.addClass('has-error');
          frm_group_driver.addClass('has-error');
          
          $(frm_group.find('.help-block')).text("Invalid ID Number")
          $(frm_group_driver.find('.help-block')).text("Invalid ID Number")
          
        }
        else{
            
          frm_group.removeClass('has-error');
          frm_group_driver.removeClass('has-error');
          
          $(frm_group.find('.help-block')).text("")
          $(frm_group_driver.find('.help-block')).text("")
          
        }
        
        
        if ( $('#frm_personal_details .has-error').length > 0 ) {
            
            hideLoading(0);
                  
                //var message = "Please fill required field";
                // parent.$.msgGrowl ({
                //    title: 'Warning' // Optional
                //   ,text: message
                //   ,position: 'top-center'
                //   ,msgtype: 'Error'
                // });
             
            return false;
        }
        else{
            
            console.log("changed:"+$('#frm_personal_details .changed').length);
            
             if ( $('#frm_personal_details .changed').length > 0 ) {
                
                return true;
            
             }
             else{
                hideLoading(0);
                
                stepnext(2,'load');
                
                return false;
             }
        } 
        
    }
    
    $('#same_as_billing').change(function() {

        if($(this).is(":checked")) {
            $("input[name=driver_id_type][value=" + $("input[name=id_type_personal]:checked").val() + "]").prop('checked',true);
            
            $("#driver_identity").html( $("#identity_label").html() );
            
            var selected_radio = $("input[name='driver_id_type']:checked").val();
            if ( selected_radio == "id") {
                $("#driver_passport_number").hide("");
                $("#driver_identity_number").val( $("#identity_number").val() ).show();
            }
            else{
                $("#driver_passport_number").val( $("#passport_number").val() ).show();
                $("#driver_identity_number").hide("");
            }
            
            
            $('#driver_title').selectpicker('val', $('#person_title :selected').val());
            $("#driver_name").val($("#name").val());
            $("#driver_surname").val($("#surname").val());
            $("#driver_dob").val($("#dob").val());
            $("#driver_email").val($("#email").val());
            $("#driver_mobile").val($("#mobile").val());
            $("#driver_telephone").val($("#telephone").val());
            $("#driver_fax").val($("#fax").val());
            //Address Details
            $("#driver_street_address").val($("#street_address").val());
            $("#driver_street_address2").val($("#street_address2").val());
            $("#driver_street_address3").val($("#street_address3").val());
            
            $("#driver_suburb").val($("#suburb").val());
            $("#driver_city").val($("#city").val());
            $("#driver_postal_code").val($("#postal_code").val());

            $("input[name=driver_gender][value=" + $("input[name=gender]:checked").val() + "]").prop('checked', true);
            $('#driver_marital_status').selectpicker('val', $('#marital_status :selected').val());
            $('#driver_employment_status').selectpicker('val', $('#employment_status :selected').val());
            
            $('#driver_address_id').val( $('#personal_address_id').val() );
            
            
        }

    });
    function personal_details_response( resdata ){

        var status =  resdata['resultStatus'];

        if(status == "Warning"){
            
            display_message = "";

            if( typeof(resdata['resultData']['message']) == "object"){
            
              var msges = resdata['resultData']['message'];
              
              for( msg in msges){
              
                display_message += msges[msg]+"<br/>";
              }
              
            }
                                                       
            parent.$.msgGrowl ({
               title: 'Error While Registration' // Optional
              ,text: display_message
              ,position: 'top-center'
              ,msgtype: 'Error'
            });
            
           
           hideLoading();
           
           return false;
        }
        else if(status == "Success"){

            var data = resdata['resultData'];       
                      
            var is_customer_exist = resdata['resultData']['isCustomerExist'];
            
            $('#frm_personal_details .ajx-control').removeClass("has-changed");
            
            resLocalStorage.setItem("personal_details",data);
            
            store_driver_to_localstorage();

            if( login_user == "Guest" ){
                hideLoading();
                if (is_customer_exist == true) {
                    var title = "";//resdata['resultData']['message'];
                    modal_params = {"id":"signin","modal_dialog_size" : "modal-lg",
                        "iframe":http_path+"/signin?popup",
                        "title":title,"width":"100%","height":"420px",
                    };
                    open_modal(modal_params);
                }else{
                    //var redirect_str = resdata['resultData']['redirect'];
                    //window.location.href = http_path+"/"+redirect_str;
                    var content = '<div class="row text-center">';
                    content += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-6"><a onclick="guest_user()" href="javascript:void(0);" id="btnSignUpPopup" class="btn btn-secondary sign-in-register col-lg-7 col-md-7 col-sm-7 col-xs-12">Continue as Guest</a></div>';
                    content += '<div class="col-lg-12"><h2 style="margin:20px"> OR </h2></div>';
                    content += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><a onclick="signup_redirect()" href="javascript:void(0);" id="btnSignUpPopup" class="btn btn-secondary sign-in-register col-lg-7 col-md-7 col-sm-7 col-xs-12">Register</a></div>';
                    content += '</div>';
                    modal_params = {'id':'myModal','class':'myClass',"content":content,"title":"",width:"100px",height:"400px"};
                    open_modal(modal_params);
                }
            }
            else{
                    update_customer();
                    bind_click_till(1);
            }


        }
        else{
            hideLoading();
            console.log('Error while performing action. please contact administrator');

            return false;
        }
        
       

    }
    
    function update_customer(){
        console.log("update_customer_information to iscript");
        var ajx_param = {	
            "url": http_path+"/personal-details",
            "sync": false,
            "method": "POST",
            "data": { opcode:'update_customer' },
            "ajxcallback":function(resobj){
                console.log(resobj);
                $('#frm_personal_details .ajx-control').removeClass('changed');
                hideLoading();
                setTimeout(function(){
                stepnext(2);
                }, 500);
            }
        };
        call_ajax(ajx_param);
    }
    
   
   
    // for  id/passport select based-
    function getbox(){
        
       //var form = document.getElementById("frm_personal_details");
       
       //var selected_radio=form.elements["id_type_personal"].value;
       
       var selected_radio= $("input[name='id_type_personal']:checked").val()
       
       if (selected_radio=='id') {
           
           $("#identity_label").html('ID Number <span class="mandatory">*</span>');
           
           $("#passport_number").hide();
           
           $("#identity_number").show();
           
           id_to_date();
       }
       else{
           $("#passport_number").show();
           
           $("#identity_number").hide();
          
          $("#identity_label").html('Passport Number <span class="mandatory">*</span>' );
          
          $('#dob').val('');
       }
       
    }
    
    function getboxdriver(){
        
       //var form = document.getElementById("frm_personal_details");
       
       //var selected_radio=form.elements["id_type_personal"].value;
       
       var selected_radio= $("input[name='driver_id_type']:checked").val()
       
       if (selected_radio=='id') {
           
           $("#driver_identity_label").html('ID Number <span class="mandatory">*</span>');
           
           $("#driver_passport_number").hide();
           
           $("#driver_identity_number").show();
           
           id_to_date();
       }
       else{
           $("#driver_passport_number").show();
           
           $("#driver_identity_number").hide();
          
          $("#driver_identity_label").html('Passport Number <span class="mandatory">*</span>' );
          
          $('#dob').val('');
       }
       
    }
    
   /*$(document).ready(function(){
    
        getbox();
        
    });*/
   
   //for getting birthday from  id Number
   $(document).ready(function(){
        $('#identity_number').on('change',function(){
            
            var selected_radio = $("#frm_personal_details input[name='id_type_personal']:checked").val();
            
             if (selected_radio == 'id') {
                  
                  var inputed_id = $('#identity_number').val();
                      
                      id_to_date();
             }
        });
   });
   
   
   
   function id_to_date(){
       
        var inputed_id = $('#identity_number').val();
        
        console.log("id_to_date:"+inputed_id.length);
        
        if(inputed_id.length == 13 ) {
            
            var year=inputed_id.substr(0,2);
             
            var month=inputed_id.substr(2,2);
             
            var day=inputed_id.substr(4,2);
           
            var dob="19"+year+"-"+month+"-"+day;
             
            $('#dob').val(dob);
        
        }
   }
   
   function valid_id() {
    
     
    var a=c=c2=d=z=0;
    var b='';
      
    
      
    var inputed_id = $('#passport_number').val();
      
    for(var i=0; i<inputed_id.length-1; i=i+2){
           
         a = parseInt(a) + parseInt(inputed_id[i]);
         
    }
      
    for(var j=1; j<inputed_id.length-1; j=j+2){
           
          b = b + "" + inputed_id[j];
                   
    }
    
    console.log("a-->"+a);  
    
    console.log("b-->"+b);
        
    c=b*2;
    
    var c1 = "" + c;
        
        
        
    for(var i=0; i<c1.length; i++){
      
        c2 = parseInt(c2) + parseInt(c1[i]);
    
    }
    
    console.log("c2-->"+c2);
    
    d=a+c2;
    
    
    
    z = 10 -(d%10);
    
    console.log("z-->"+z);
    
    var ans_value=inputed_id.substr(inputed_id.length-1,1);
    
     console.log("ans -->"+ans_value);
    
        if(ans_value == z){
          
          console.log(" id is valid");
          return 1;
          
        }
        else{
            
          console.log(" not valid");
          return 0;
          
       }
}

function guest_user() {
    resLocalStorage.setItem("isGuest",1);
    close_modal();
    stepnext(2);
    
}

    
   {/literal}
</script>
