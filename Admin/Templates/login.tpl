<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
{include file="$T_HEADER"}

<body>
   <!-- for login--->
	<div id="loginform">
    <div class="login-container animated fadeInDown">
	  
	 <!-- <div id="loginmessage" class="label label-important label_message" style="color:#FF0000; display:none;"></div>-->
		<div class="row">
		  <div class="col-sm-12">
			 <div class="alert alert-success" id="login_success_message" style="display:none;">
				  
			  </div>
		  </div>
		</div>
		<div class="row">
		  <div class="col-sm-12">
			 <div class="alert alert-danger" id="login_error_message" style="display:none;">
				  
			  </div>
		  </div>
		</div>
        <div class="loginbox bg-white">
            <div class="loginbox-title">SIGN IN</div>
			
            <form method="post" action="{$ADMIN_ALIAS}/login.php" id="frmLogin" name="frmLogin" data-before="validate_login()">
			
            <div class="loginbox-textbox form-group">
                <input type="text" name="userid" id="userid"  required class="form-control ajx-control" placeholder="User ID"  data-error="Please enter userid."/>
				<div class="help-block with-errors"></div>
            </div>
            <div class="loginbox-textbox form-group">
                <input type="password" name="passwd" id="passwd"  required class="form-control ajx-control" placeholder="Password" data-error="Please enter password." />
				<div class="help-block with-errors"></div>
            </div>
            <div class="loginbox-forgot">
               <!-- <a href="../{$ADMIN_ALIAS}/forgotpassword">Forgot Password?</a>-->
				<a  onclick="open_forgotpassword()">Forgot Password?</a>
			</div>
            <div class="loginbox-submit">
				
               <!-- <input type="submit" class="btn btn-primary btn-block"  value="Login">-->
				<button type="button" class="btn btn-primary btn-block" id="btnLoginSave">Sign in</button>
            </div>
			</form>
            
        </div>
	 
    </div>
	</div>
	<!-- end login--->
	
	<!-- for forgot password--->
	  <div id="forgotpassword" style="display: none;">
	  <div class="login-container animated fadeInDown">
	  
		
		<div class="row">
		  <div class="col-sm-12">
			 <div class="alert alert-success" id="forgot_success_message" style="display:none;">
				  
			  </div>
		  </div>
		</div>
		<div class="row">
		  <div class="col-sm-12">
			 <div class="alert alert-danger" id="forgot_error_message" style="display:none;">
				  
			  </div>
		  </div>
		</div>
        <div class="loginbox bg-white">
            <div class="loginbox-title">Forgot password</div>
			
            <form method="post" action="{$ADMIN_ALIAS}/login.php" id="frmforgot" name="frmforgot" data-before="validate_forgot_password()">
			<input type="hidden" name="onform" value="forgotform" class="ajx-control" />
            <div class="loginbox-textbox form-group">
                <input type="text" name="username" id="username"  required class="form-control ajx-control" placeholder="User ID" data-error="please enter userid." />
				<div class="help-block with-errors"></div>
            </div>
            <div class="loginbox-textbox form-group">
                <input type="email" name="usermailid" id="usermailid" required class="form-control ajx-control" placeholder="Email ID" data-error="please enter emailid."/>
				<div class="help-block with-errors"></div>
            </div>
            
            <div class="loginbox-submit">
				
               <!-- <input type="submit" class="btn btn-primary btn-block"  value="Login">-->
				<button type="button" class="btn btn-primary btn-block" id="btnforgotSave">Submit</button>
            </div>
			</form>
            
        </div>
	 
	  </div>
	  </div>
	  
	<!-- end forgot password--->
	
<script src="{$COMMON_SCRIPTS}functions.js"></script>
<!--Basic Scripts-->
<script src="{$TEMPLATE_JS}jquery.min.js"></script>
<script src="{$TEMPLATE_JS}bootstrap.min.js"></script>
<script src="{$TEMPLATE_JS}slimscroll/jquery.slimscroll.min.js"></script>

<!-- for msg box-->  
<link href="{$COMMON_SCRIPTS}msgGrowl/msgGrowl.css" type="text/css" rel="stylesheet" />
<script src="{$COMMON_SCRIPTS}msgGrowl/msgGrowl.js"></script>

<!--Beyond Scripts-->
<script src="{$TEMPLATE_JS}beyond.js"></script>
<script src="{$TEMPLATE_JS}jquery.validate.js"></script>
<script src="{$TEMPLATE_JS}additional-methods.js"></script>

<script src="{$COMMON_SCRIPTS}/validator.js"></script>

<script>
{literal}

	
	jQuery(document).ready(function(){
	   jQuery("#btnLoginSave").click(function(){
	    trigger_form({"frm":"frmLogin","ajxcallback":function(resdata){action_response(resdata);}})	
	  });
	});
			
		
	function action_response(responseText)
	{
		
		
		console.log(responseText);

		window.setTimeout(function(){},3000);
		
		data=responseText.resultData;
		
		
		
		if(responseText.resultStatus=="Success")
		{
			jQuery("#login_success_message").html(data.message);
			jQuery("#login_success_message").show();
			jQuery("#login_error_message").hide();
			redirecturl = 'index.php/dashboard';  // livelocal
			window.location.href=serverurl+redirecturl;
		}
		else
		{
			jQuery("#login_error_message").html(data.message);
			jQuery("#login_error_message").show();
			jQuery("#btnLoginSave").removeAttr("disabled");
			jQuery('.loading-ajax').remove();
			//hidejQloading();
		}
	}
	
/* field validation*/
function validate_login(){
  
	$('#frmLogin').validator('validate');
		//for text,date,image only
	if ( $('#frmLogin .has-error').length > 0 ) {
	  return false;
	}
	else{
	  return true;
	}
}

function open_forgotpassword(){
 
  $('#forgotpassword').css('display','block');
  $('#loginform').css('display','none');
}

/* for forgot password*/
jQuery(document).ready(function(){
	   jQuery("#btnforgotSave").click(function(){
	    trigger_form({"frm":"frmforgot","ajxcallback":function(resdata){forgot_action_response(resdata);}})	
	  });
	});
			
		
	function forgot_action_response(responseText){
		
		console.log(responseText);
		
		 data=responseText.resultData;
	
		if(responseText.resultStatus=="Success"){
			jQuery("#forgot_success_message").html(data);
			jQuery("#forgot_success_message").show();
			jQuery("#forgot_error_message").hide();
			 
			
			setTimeout(function(){
					  redirecturl = 'login.php';  // livelocal
					  window.location.href=serverurl+redirecturl;
			}, 3000);
			
		}
		else{
			jQuery("#forgot_error_message").html(data);
			jQuery("#forgot_error_message").show();
			
			
			//jQuery("#btnforgotSave").removeAttr("disabled");
			//jQuery('.loading-ajax').remove();
			//hidejQloading();
		}
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

<div id="divjs" style="display:none">
	<script>
		var serverurl='{$serverurl}';	
	</script>
</div>

</body>

</html>
  
