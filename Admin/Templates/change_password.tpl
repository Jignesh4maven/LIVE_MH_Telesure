<div id="modulename" data-modulename="changepassword"></div>
		 <div class="col-xs-12 col-md-12">
			<form role="form" id="changepwdform" name="changepwdform" action="{$ADMIN_ALIAS}/changepassword" data-before="validate_changepassword()">
			   <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
	          
			   <div class="form-title">
				   Change password
			   </div>
			   		<div class="row">
						<div class="col-sm-12">
						   <div class="alert alert-success" id="pass_success" style="display:none;">
								 Your password successfully changed.
							</div>
						</div>
					 </div>
				
					 <div class="row">
						<div class="col-sm-12">
						   <div class="form-group">
							  <label for="old_password">Old Password<sup class="mandatory">*</sup></label>
							  <input type="text" id="old_password" name="old_password" value="" required  placeholder="Enter old Password" data-error="Please enter your old password." class="form-control ajx-control">
							  <div class="help-block with-errors"></div>
						   </div>
						</div>
					 </div>
					 
					 <div class="row">
						<div class="col-sm-12">
						   <div class="form-group">
							  <label for="old_password">New Password<sup class="mandatory">*</sup></label>
							  <input type="text" id="new_password" name="new_password" value=""  required placeholder="Enter New Password" data-error="Please enter your new password." class="form-control ajx-control">
							  <div class="help-block with-errors"></div>
						   </div>
						   
						</div>
					 </div>
					 
					 <div class="row">
						<div class="col-sm-12">
						   <div class="form-group">
							  <label for="old_password">Retype New Password<sup class="mandatory">*</sup></label>
							  <input type="text" id="rtype_new_password" name="rtype_new_password" required  value="" placeholder="Retype New Password" data-error="Please retype your new password." class="form-control ajx-control">
							  <div class="help-block with-errors"></div>
						   </div>
						</div>
					 </div>
				
				{literal}
				<button type="button" class="btn btn-primary" onclick='trigger_form({"frm":"changepwdform","ajxcallback":function(resdata){action_response(resdata);}})'>Save</button>
				{/literal}
			</form>  
         </div>
<script>
{literal}
  
function action_response(resdata){
    
 
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
			/* var message = "Your password successfully changed.";
			  parent.$.msgGrowl ({
               text: message
              ,position: 'top-center'
              ,msgtype: 'Sucsess'
			  
            });
			//alert("Success");  */
			$("#pass_success").css('display','block');    
        }
        else if (resdata.resultStatus ==  "Warning") {
           
		   
			var old_pwd_frm_group = $("#old_password").parents('.form-group');
			
			
				  old_pwd_frm_group.addClass('has-error');
				  $(old_pwd_frm_group.find('.help-block')).text("Entered Wrong old password.");
				  $('#old_password').focus();
				  
				  /*setTimeout(function() {
							  $('.help-block').fadeOut();
							  $('#old_password').val('');
						   },2000 );*/


			  
            //alert("Failed"); 
            return false;
            
        }
    }
	
}

/*for compare password */
function validate_changepassword(){
  
   $('#changepwdform').validator('validate');

   var new_password=$('#new_password').val();
   var retype_new_password=$('#rtype_new_password').val();
  
   var pwd_frm_group = $("#rtype_new_password").parents('.form-group');
  
   
	  if (new_password != retype_new_password) {
		 pwd_frm_group.addClass('has-error');
		 $(pwd_frm_group.find('.help-block')).text("New password and Re-type password is not same.");
		 $('#rtype_new_password').val('');
		 
		 setTimeout(function() {
				   $('.help-block').fadeOut();
				   $('#rtype_new_password').val('');
				   $('#rtype_new_password').focus();
				  },2000 );
	  }
	  else{
			pwd_frm_group.removeClass('has-error');
			$(pwd_frm_group.find('.help-block')).text("");
	  }
  
   
   
    
   //for text,date,image only
  if ( $('#changepwdform .has-error').length > 0 ) {
	return false;
  }
  else{
	return true;
  }
}

{/literal}
</script>     

 