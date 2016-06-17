<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
{include file="$T_HEADER"}

<body>
   
    <div class="login-container animated fadeInDown">
	  
		<div id="loginmessage" class="label label-important label_message" style="color:#FF0000; display:none;"></div>
	  
        <div class="loginbox bg-white">
            <div class="loginbox-title">Forgot password</div>
			
            <form method="post" action="{$ADMIN_ALIAS}/forgotpassword" id="frmforgot" name="frmforgot" data-before="validate_forgot_password()">
			<input type="hidden" name="opcode" value="get_user_records" class="ajx-control" />
            <div class="loginbox-textbox form-group">
                <input type="text" name="userid" id="userid"  required class="form-control ajx-control" placeholder="User ID" />
				<div class="help-block with-errors"></div>
            </div>
            <div class="loginbox-textbox form-group">
                <input type="email" name="usermailid" id="usermailid" required class="form-control ajx-control" placeholder="Email ID" />
				<div class="help-block with-errors"></div>
            </div>
            
            <div class="loginbox-submit">
				
               <!-- <input type="submit" class="btn btn-primary btn-block"  value="Login">-->
				<button type="button" class="btn btn-primary btn-block" id="btnforgotSave">Submit</button>
            </div>
			</form>
            
        </div>
	 
    </div>
    <script src="{$COMMON_SCRIPTS}functions.js"></script>
    <!--Basic Scripts-->
    <script src="{$TEMPLATE_JS}jquery.min.js"></script>
    <script src="{$TEMPLATE_JS}bootstrap.min.js"></script>
    <script src="{$TEMPLATE_JS}slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="{$TEMPLATE_JS}beyond.js"></script>
	<script src="{$TEMPLATE_JS}jquery.validate.js"></script>
	<script src="{$TEMPLATE_JS}additional-methods.js"></script>
	
	<script src="{$COMMON_SCRIPTS}/validator.js"></script>


<script>
{literal}

	
	
	jQuery(document).ready(function(){
	   jQuery("#btnforgotSave").click(function(){
	    trigger_form({"frm":"frmforgot","ajxcallback":function(resdata){action_response(resdata);}})	
	  });
	});
			
		
	function action_response(responseText)
	{
		
		
		console.log(responseText);

		window.setTimeout(function(){},3000);
		
		data=responseText.resultData;
		
		jQuery("#loginmessage").html(data.message);
		jQuery("#loginmessage").show();
		
		/*if(responseText.resultStatus=="Success")
		{
			redirecturl = 'login.php';  // livelocal
			window.location.href=serverurl+redirecturl;
		}
		else
		{
			jQuery("#btnforgotSave").removeAttr("disabled");
			jQuery('.loading-ajax').remove();
			//hidejQloading();
		}*/
	}

/* field validation*/
function validate_forgot_password(){
  
	$('#frmforgot').validator('validate');
		//for text,date,image only
	if ( $('#frmforgot .has-error').length > 0 ) {
	  return false;
	}
	else{
	  return true;
	}
}	
{/literal}
</script>

<div id="divjs" style="display:none;">
	<script>
		var serverurl='{$serverurl}';	
	</script>
</div>

</body>

</html>
  
