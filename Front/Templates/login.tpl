<div>
    <!--div class="modal-header text-center">
        <h2 class="modal-title" id="myModalLabel">ID / Passport Number already exists</h2>
        <span class="sub-title">Please login or register to continue</span>
    </div-->
    <div class="modal-body login-body">
        <div class="row">
            <div class="col-md-6">
                <h4>Login</h4>
                <form class="form-horizontal login-form form-s1" id="login_form" action="login" {literal} data-before="login_validate_form()" {/literal}>
                    <input type="hidden" name="opcode" value="login" class="ajx-control" />
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Email</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="email" name="email"  value="{$data.Email}" class="form-control ajx-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Password</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="password" id="password" name="password" class="form-control ajx-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        {literal}
                        <div class="col-sm-12">
                            <button class="btn btn-blue" type="button" onclick='trigger_form({"frm":"login_form","ajxcallback":function(resdata){login_response(resdata);}});'>Login</button>
                        </div>
                        {/literal}
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h4>Register</h4>
                <form class="form-horizontal login-form form-s1" id="register_form" {literal} action="login" data-before="register_validate_form" {/literal}>
                    <input type="hidden" name="opcode" value="register" class="ajx-control" />
                    <input type="hidden" name="identification_no" id="identification_no" value="{$data.IdentificationNo}" class="ajx-control" />
                    <input type="hidden" name="passport_no" id="passport_no" value="{$data.PassportNo}" class="ajx-control" />
                    <input type="hidden" name="other_contact_no" id="other_contact_no" value="{$data.OtherContactNo}" class="ajx-control" />
                    <input type="hidden" name="title" id="title" value="{$data.Title}" class="ajx-control" />
                    <input type="hidden" name="dob" id="dob" value="{$data.BirthDate}" class="ajx-control" />
                    
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Name</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="name" name="name" value="{$data.FirstName}" class="form-control ajx-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Surname</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="surname" name="surname" value="{$data.SurName}" class="form-control ajx-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Contact No.</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="contact_no" name="contact_no" value="{$data.CellphoneNo}" class="form-control ajx-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Email</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="email" name="email" value="{$data.Email}" class="form-control ajx-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Conform Email</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" id="confirm_email" name="confirm_email" class="form-control ajx-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Password</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="password" id="password" name="password" class="form-control ajx-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <label>Conform Password</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        {literal}
                        <div class="col-sm-12">
                            <button class="btn btn-blue" type="button" onclick='trigger_form({"frm":"register_form","ajxcallback":function(resdata){register_response(resdata);}});'>Register</button>
                        </div>
                        {/literal}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{literal}
<script>
    $(document).ready(function(){
        if ( resLocalStorage.getItemObject("personal_details") != null ) {
            var details = resLocalStorage.getItemObject("personal_details");
            var personDetails = details.formData;
            $("#register_form #name").val(personDetails.person_name);
            $("#register_form #surname").val(personDetails.person_surname);
            $("#register_form #contact_no").val(personDetails.person_mobile);
            $("#register_form #email").val(personDetails.person_email);
            $("#register_form #confirm_email").val(personDetails.person_email);
            
            if ( personDetails.id_type == "id" ) {
                 $('#register_form #identification_no').val(personDetails.passport_number);
                 $('#register_form #passport_no').val("");
            }
            else if( personDetails.id_type == "passport" ){
                $('#register_form #identification_no').val("");
                $('#register_form #passport_no').val(personDetails.passport_number);
            }
            
            
            
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
    
    function login_validate_form(){
        
         parent.showLoading();
        
        setTimeout(function() {
           
            $('#login_form').validator('validate');
        
            if ( $('#login_form .has-error').length > 0 ) {
                parent.hideLoading();
                return false;
            }
            else{
                return true;
            } 
            
        }, 1000);
    }
    
    function register_validate_form(){
        
      parent.showLoading();
        
        setTimeout(function() {
           
            $('#register_form').validator('validate');
        
            if ( $('#register_form .has-error').length > 0 ) {
                parent.hideLoading();
                return false;
            }
            else{
                return true;
            } 
            
        }, 1000);
    }
    
    function register_response(resdata){
        
        logger.log(resdata);
        
        var status =  resdata['resultStatus'];

        if(status == "Warning"){
            
            var message = resdata['resultData']['message'];
            parent.$.msgGrowl ({
               title: 'Error While Registration' // Optional
              ,text: message
              ,position: 'top-center'
              ,msgtype: 'Error'
            });
            parent.hideLoading();
            
            return false;
        }
        else{
            logger.log('-----Success-----');
            localStorage.clear();
            parent.jQuery("#modal_login").modal('hide');
            parent.hideLoading();
            var redirect_str = resdata['resultData']['redirect'];
            login_redirect(redirect_str);
            parent.stepnext(2);
        }
        
        hideLoading();
    }

    function login_response( resdata ){

        logger.log(resdata);

        var status =  resdata['resultStatus'];

        if( status == "Success" ){
            var message = "Login Successful.";
            parent.$.msgGrowl ({
               title: 'Success' // Optional
              ,text: message
              ,position: 'top-center'
              ,msgtype: 'Success'
            });
            localStorage.clear();
            var redirect_str = resdata['resultData']['redirect'];
            login_redirect(redirect_str);
            
            //parent.stepnext(3);
        }
        if( status == "Warning" ){
            var message = resdata['resultData']['message'];
            if ( typeof(message) != "string") {
                message = "";
            }
            parent.$.msgGrowl ({
               title: 'Error While Login' // Optional
              ,text: message
              ,position: 'top-center'
              ,msgtype: 'Error'
            });
            parent.hideLoading();
            return false;
        }
    }
    
    function login_redirect(redirect_string) {
        
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
    {/literal}
</script>