<div class="reset-password-wrapper">
    <div class="your-detail col-lg-5 col-xs-12 col-sm-7 col-md-5 center-block text-left">
        <h1>Reset Password</h1>
        <h4>Fill in your details below to proceed.</h4>
    </div>
    <div class="clearfix"></div>
    <form class="form-horizontal login-form form-s1" action="signin" method="post" id="frmResetPassword" name="frmResetPassword" data-before="reset_pwd_validate_form()">
        <input type="hidden" name="opcode" value="process_reset_password" class="ajx-control" />
        <div class="sign-in sign-in-frm col-lg-6 col-xs-12 col-sm-9 col-md-9 center-block">
            <div class="clearfix"></div>
            <div class="form-group">
                <label class="label-sign-in col-lg-3 col-sm-4 control-label">Email Address<span class="mandatory">*</span></label>
                <div class="col-lg-9 col-sm-8">
                    <input type="text" placeholder="Enter email address" class="form-control ajx-control" value="" maxlength="90" id="email" name="email" data-error="Please fill out this field." required>
                    <div class="help-block with-errors"></div>
                    <div class="go-back-link-wrapper">
                        <label>Go back to login?</label> <a href="{$HTTP_PATH}/login/"> <label>Click here</label></a>
                    </div>
                </div>
            </div>
            <div class="form-group proceed-checkout">
                <label class="col-lg-3 col-sm-4 hidden-xs control-label">&nbsp;</label>
                <div class="col-lg-9 col-sm-8">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">

                        </div>
                        {literal}
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-blue col-lg-7 col-md-7 col-sm-7 col-xs-12" type="button" onclick='trigger_form({"frm":"frmResetPassword","ajxcallback":function(resdata){reset_pwd_response(resdata);}});'>Reset Password</button>
                        </div>
                        {/literal}
                    </div>

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
<script type="text/javascript">
    var http_path = "{$HTTP_PATH}";
    
    {literal}
    function reset_pwd_validate_form(){
        
         parent.showLoading();
        
        setTimeout(function() {
           
            $('#frmResetPassword').validator('validate');
        
            if ( $('#frmResetPassword .has-error').length > 0 ) {
                parent.hideLoading();
                return false;
            }
            else{
                return true;
            } 
            
        }, 1000);
    }
    
    function reset_pwd_response( resdata ){

        logger.log(resdata);

        var status =  resdata['resultStatus'];
        
        if (typeof(resdata['resultData']) != "undefined") {
            
            var message = resdata['resultData']['message'];
            
            if( status == "Success" ){
                
                $("#email").val('');
                var title = "Confirm Reset Password";//resdata['resultData']['message'];
                modal_params = {"id":"reset_password","modal_dialog_size" : "modal-lg",
                    "iframe":"",
                    "content":message,
                    "title":title,"width":"100%","height":"420px","buttons":{"OK":"<button class='btn btn-pink col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right' id='btn-reset' data-dismiss='modal'>Ok</button>"}
                };
                open_modal(modal_params);
                parent.hideLoading();
            }
            if( status == "Warning" ){
                
                parent.$.msgGrowl ({
                   title: 'Error While Reset Password' // Optional
                  ,text: message
                  ,position: 'top-center'
                  ,msgtype: 'Error'
                });
                parent.hideLoading();
                return false;
            }
            
        }
        
    }
    {/literal}
</script>