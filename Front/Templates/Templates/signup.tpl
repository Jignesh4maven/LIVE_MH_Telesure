<div class="container">
    
    <div class="modal-body login-body">
        <div class="row">
            <div class="col-md-12 col-lg-12 center-block text-center">
                <h2 class="modal-title" id="myModalLabel">To continue please register</h2>
            </div>            
        </div>
        <div class="row">
            <form class="form-horizontal login-form form-s1" id="register_form" action="signup" data-before="register_validate_form()">
                <input type="hidden" name="opcode" value="register" class="ajx-control" />
                <input type="hidden" name="other_contact_no" id="other_contact_no" value="{$data.OtherContactNo}" class="ajx-control" />
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        <label class="col-lg-5 col-xs-12 control-label" for="idNo">&nbsp;</label>
                        <div class="col-lg-7 col-xs-12">
                            {if $data.id_type != "id"}
                                  {assign var="passport_check" value="checked"}
                                  {assign var="passport_show" value=""}
                                  {assign var="id_show" value="display:none"}
                              {else}
                                    {assign var="id_check" value="checked"}
                                    {assign var="id_show" value=""}
                                    {assign var="passport_show" value="display:none;"}
                              {/if}
                            <div>
                                <label class="lbl-content">
                                    ID Number
                                    <input type="radio" value="0" {$id_check} class="ajx-control" id="chkIdNoPassport_IDNO" name="chkIdNoPassport" data-prompt-position="inline">
                                    <span></span>
                                </label>
                                <label class="lbl-content">
                                    Passport Number
                                    <input type="radio" value="1" id="chkIdNoPassport_PASS" {$passport_check} class="ajx-control" name="chkIdNoPassport" data-prompt-position="inline">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="id_number">
                        <div class="col-sm-4">
                            <label>ID Number<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="identification_no" id="identification_no" value="{$data.IdentificationNo}" maxlength="13" class="form-control ajx-control integer" data-error="Please fill out this field." required />
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    <div class="form-group" id="pass_number" style="display:none;">
                        <div class="col-sm-4">
                            <label>Passport Number<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="passport_no" id="passport_no" value="{$data.PassportNo}" class="form-control ajx-control" data-error="Please fill out this field." required />
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Password<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8 pass-content">
                            <input type="password" id="password" name="password" class="form-control ajx-control" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors text-left"></div>
                            <i data-content="Password to adhere to the following password policy requirements:&lt;br/&gt;1.Minimum length of 8 characters&lt;br/&gt;2.At least one uppercase letter&lt;br/&gt;3.At least one lowercase letter&lt;br/&gt;4.At least one number (0-9)&lt;br/&gt;5.At least one special character" data-placement="right" data-toggle="popover" data-html="true" class="fa fa-question-circle hidden-xs pass-ques" data-original-title="" title=""></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Confirm Password<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Title<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <select class="selectpicker show-tick form-control ajx-control" name="title" id="title" data-error="Please fill out this field." required data-prompt-position="inline">
                                {foreach from=$title_data item=record}
                                    <option value="{$record->ID}"> {$record->Name} </option>    
                                {/foreach}
                            </select>
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Name<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="name" name="name" value="{$data.FirstName}" class="form-control ajx-control" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Surname<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="surname" name="surname" value="{$data.SurName}" class="form-control ajx-control" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Email<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="email" name="email" value="{$data.Email}" class="form-control ajx-control" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Confirm Email<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="confirm_email" name="confirm_email" class="form-control ajx-control" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Contact No.<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="contact_no" name="contact_no" value="{$data.CellphoneNo}" class="form-control ajx-control" data-error="Please fill out this field." required/>
                            <div class="help-block with-errors text-left"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Date of Birth<span class="mandatory">*</span></label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date " id="person-dob-container">
                              <input type="text" id="dob" name="dob" value="{$data.BirthDate}"  class="form-control   ajx-control" data-date-format="yy-mm-dd" data-error="Please fill out this field" required/>
                              <div class="help-block with-errors text-left"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {literal}
                        <div class="col-sm-6 center-block text-center">
                            <button class="btn btn-blue" type="button" onclick='trigger_form({"frm":"register_form","ajxcallback":function(resdata){register_response(resdata);}});'>Register</button>
                        </div>
                        {/literal}
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 center-block text-center">
                <h2 class="modal-title" id="myModalLabel">Or Continue As Guest</h2>
            </div>            
        </div>
        <div class="row">
            <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <button class="btn btn-blue" style="width:500px;"
                        id="btnGuest" name="btnGuest" type="button"
                        onmouseup="parent.showLoading();"
                        onclick="fn_guest_user()" >Continue as Guest</button>
            </div>
            </div>
        </div>    
    </div>
</div>
{literal}
<script>
    $(document).ready(function(){        
        
        if(jQuery(".integer")){
            jQuery(".integer").keydown(fun_Integer);
            jQuery(".integer").focusout(fun_Integer_keyup);
        }

        jQuery("[data-toggle='popover']").popover({ trigger: "hover" });
        
        $('#dob').Zebra_DatePicker({
            direction: false
        });
            
        //change the text for label
        jQuery("#chkIdNoPassport_IDNO").on('click',function(){
            jQuery("#pass_number").val("").hide();
            jQuery("#id_number").show();
        });
        jQuery("#chkIdNoPassport_PASS").on("click",function(){
            jQuery("#pass_number").show();
            jQuery("#id_number").val("").hide();
        });
        
        $("input[name='chkIdNoPassport']:checked").click()
        
        if ( resLocalStorage.getItemObject("personal_details") != null ) {
            var details = resLocalStorage.getItemObject("personal_details");
            var personDetails = details.formData;
            $("#register_form #name").val(personDetails.person_name);
            $("#register_form #surname").val(personDetails.person_surname);
            $("#register_form #contact_no").val(personDetails.person_mobile);
            $("#register_form #email").val(personDetails.person_email);
            $("#register_form #confirm_email").val(personDetails.person_email);
            
            /*if ( personDetails.id_type == "id" ) {
                 $('#register_form #identification_no').val(personDetails.passport_number);
                 $('#register_form #passport_no').val("");
            }
            else if( personDetails.id_type == "passport" ){
                $('#register_form #identification_no').val("");
                $('#register_form #passport_no').val(personDetails.passport_number);
            }*/
            
            
            
            $('#register_form #other_contact_no').val(personDetails.person_telephone);
            $('#register_form #title').val(personDetails.person_title);
            $('#register_form #dob').val(personDetails.person_dob);
        }
    });
</script>
{/literal}
<script type="text/javascript">

    var http_path = "{$HTTP_PATH}";
    
    {literal}
    
    function register_validate_form(){
      
        parent.showLoading();
        $('#register_form').validator('validate');
        
        var selected_radio= $("input[name='chkIdNoPassport']:checked").val()

        var invalid_id = false;

        if (selected_radio == '0') {
                    
          if( validateRSAidnumber( $('#identification_no').val() ) ){
          
             console.log("Invalid ID Number");
             
             invalid_id = true;
          }
        
        }
        
        var frm_group = $("#identification_no").parents('.form-group');
        
        if(invalid_id){
          
          frm_group.addClass('has-error');
          
          $(frm_group.find('.help-block')).text("Invalid ID Number")
          
        }
        else{
            
          frm_group.removeClass('has-error');
          
          $(frm_group.find('.help-block')).text("")
          
        }
        

        if ( $('#register_form .has-error').length > 0 ) {
            parent.hideLoading();
            return false;
        }
        else{
            return true;
        }
    }
    
    function register_response(resdata){
        
        logger.log(resdata);
        
        var status =  resdata['resultStatus'];

        if(status == "Warning"){
            
            var message = "";
            
            display_message = "";

            if( typeof(resdata['resultData']['message']) == "object"){
            
              var msges = resdata['resultData']['message'];
              
              for( msg in msges){
              
                display_message += msges[msg]+"<br/>";
              }              
              
            }
            else if( typeof(resdata['resultData']['message']) == "string"){
                
                display_message = resdata['resultData']['message'];
            }
            
            parent.$.msgGrowl ({
               title: 'Error While Registration' // Optional
              ,text: display_message
              ,position: 'top-center'
              ,msgtype: 'Error'
            });
            parent.hideLoading();
            
            return false;
        }
        else{
            logger.log('-----Success-----');
            resLocalStorage.setItem("isGuest",0);
            parent.jQuery("#modal_login").modal('hide');
            parent.hideLoading();
            var redirect_str = resdata['resultData']['redirect'];
            console.log('------- Redirect URL ---------'+redirect_str);
            register_redirect(redirect_str);
            parent.stepnext(2);
        }
        
        hideLoading();
    }

    function register_redirect(redirect_string) {
        
        console.log(http_path+"/"+redirect_string);
        
        if ( redirect_string != "" ) {
            
            var parent_location = http_path+"/"+redirect_string
            
            parent.jQuery("#modal_login").modal('hide');
            
            parent.window.location.href = parent_location;
            
            parent.hideLoading();
            
        }
        else{            
             
            var parent_location = parent.window.location.href;
            
            parent.jQuery("#modal_login").modal('hide');
            
            parent.window.location.reload();
            
            parent.hideLoading();
            
        }
        
    }
    
    
     function fn_guest_user(){
        var ajx_param = {	
            "url": http_path+"/personal-details",
            "sync": false,
            "method": "POST",
            "data": { opcode:'guest_user' },
            "ajxcallback":function(response){
                console.log(response);
                $('#frm_personal_details .ajx-control').removeClass('changed');
                hideLoading();
                
                if( response["resultStatus"] == "Success" ) {
                    if( typeof(response["resultData"]["redirect"] != "undefined") ){
                        if ( response["resultData"]["redirect"] != "" ) {
                                register_redirect(response["resultData"]["redirect"]);
                        }
                    }
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