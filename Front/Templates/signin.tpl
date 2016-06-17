<div>
    <div class="modal-header text-center">
        <h2 class="modal-title" id="myModalLabel">
             
            {if $data.msg != ""}
                {$data.msg}
            {else}
            Thanks for the interest there.<br/>To continue please register or log-in
            {/if}
        </h2>
    </div
    <div class="modal-body login-body">
        <div class="container">
            <div class="row">
                 <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block">
                     <form class="form-horizontal login-form form-s1" id="signin_form" action="signin" data-before="signin_validate_form()">
                         <input type="hidden" name="opcode" value="login" class="ajx-control" />
                         <div class="form-group">
                             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                                 <label>E-mail address<span class="mandatory">*</span></label>
                             </div>
                             <div class="col-lg-8 col-md-8 col-sm-8 col-sm-8 col-xs-12 col-xs-12">
                                 <input type="text" id="email" name="email"  value="{$data.Email}" class="form-control ajx-control" data-error="Please fill out this field." required />
                                 <div class="help-block with-errors"></div>
                             </div>
                         </div>
                         <div class="form-group">
                             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                                 <label>Password<span class="mandatory">*</span></label>
                             </div>
                             <div class="col-lg-8 col-md-8 col-sm-8 col-sm-8 col-xs-12 col-xs-12">
                                 <input type="password" id="password" name="password" class="form-control ajx-control" data-error="Please fill out this field." required />
                                 <div class="help-block with-errors"></div>
                             </div>
                         </div>
                         <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hidden-xs control-label">&nbsp;</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-sm-8 col-xs-12 col-xs-12 text-right">
                                <a class="forgot-pass" id="reset_password" href="javascript:void(0);" onclick="reset_pwd_redirect()">Forgot password?</a>
                            </div>
                        </div>
                         <div class="form-group">
                             
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <a class="btn btn-secondary sign-in-register col-lg-7 col-md-7 col-sm-7 col-xs-12" id="btnSignUpPopup" href="javascript:void(0);" onclick="signup_redirect()">Register</a>
                             </div>
                             {literal}
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                 <button class="btn btn-blue col-lg-7 col-md-7 col-sm-7 col-xs-12" id="btnSubmitPopup" name="btnSubmitPopup" type="button" onmouseup="parent.showLoading();"  onclick='trigger_form({"frm":"signin_form","ajxcallback":function(resdata){signin_response(resdata);}});'>Log In</button>
                             </div>
                             {/literal}
                         </div>
                     </form>
                 </div>
             </div>
        </div>   
    </div>
</div>

<script type="text/javascript">

    var http_path = "{$HTTP_PATH}";
    
    {literal}
    function signin_validate_form(){
 
       $('#signin_form').validator('validate');
        
            if ( $('#signin_form .has-error').length > 0 ) {
                parent.hideLoading();
                return false;
            }
            else{
                return true;
            } 
    }
    
    
    
    function signin_response( resdata ){

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
            
            resLocalStorage.setItem("isGuest",0);
            var redirect_str = resdata['resultData']['redirect'];
            signin_redirect(redirect_str);
            
            //parent.stepnext(3);
        }
        if( status == "Warning" ){
            var message = resdata['resultData']['message'];
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
    
    function signin_redirect(redirect_string) {
        
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
    
    function reset_pwd_redirect() {
        
        //console.log(http_path+"/"+);
        
        var parent_location = http_path+"/signin?opcode=reset_password"
            
        parent.jQuery("#modal_login").modal('hide');
        
        parent.window.location.href = parent_location;
    }
    {/literal}
</script>
