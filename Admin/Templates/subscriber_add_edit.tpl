<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
                
			   <form role="form" id="subsciberform" name="buzzcategoryform" action="{$ADMIN_ALIAS}/subscriber" enctype="multipart/form-data" data-before="validate_subscriber()">
			   <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
			   <input type="hidden" name="subscriber_id" value="{$data_row.id}" class="ajx-control" />
			   
			
				
			   <div class="form-title mandatory">
					* fields are mandatory.
			   </div>
			  
			   <div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						   <label for="title_input">Name<sup class="mandatory">*</sup></label>
						   <input type="text" id="subsciber_name" name="subsciber_name" value="{$data_row.name}" required  data-error="Please enter name." placeholder="Enter Name" class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
					</div>
			   </div>
			   <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="alias_input">Email<sup class="mandatory">*</sup></label>
						   <input type="email" id="subsciber_email"  name="subsciber_email" value="{$data_row.email}"  required  data-error="Please enter email." placeholder="Enter Email" class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="status_input">Status<sup class="mandatory">*</sup></label>
						   <div class="radio">
                             {if $data_row.status == "Inactive"}
                                  {assign var="status_inactive" value="checked"}
                              {else}
                                    {assign var="status_active" value="checked"} 
                              {/if}
                             <label>
                                <input type="radio"  id="subsciber_status" name="subsciber_status" value="1"  {$status_active} class="form-control ajx-control"> 
                                <span class="text">Active</span>
                             </label>
                             
                              <label>
                                <input type="radio"  id="subsciber_status" name="subsciber_status" value="0"  {$status_inactive} class="form-control ajx-control">
                                <span class="text">Inactive</span>
                             </label>
                              
                            </div>
						  
						</div>
					</div>
			   </div>
			   
			
				
				
				{literal}
				<button type="button" id="btnSubmit" class="btn btn-primary" onmouseup="parent.showLoading()" onclick='trigger_form({"frm":"subsciberform","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
				<button  class="btn btn-danger" type="button" onclick="parent.close_modal()" >Close</button>
				{/literal}
				</form>
		
<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/jquery.hotkeys.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/prettify.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="{$COMMON_SCRIPTS}editors/summernote/summernote.js"></script>
<script>

{literal}

/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
          
			//parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"subsciberform"});
            parent.jQuery("[id^='modal_add_edit']").modal("hide");
            parent.refresh_list();        
        }
        else if (resdata.resultStatus ==  "Warning") {
            
            alert(""+resdata.resultMessage);
            return false;
            
        }
    }
    parent.hideLoading();
 }
 //on submit called
 function validate_subscriber(){
 
	$('#subsciberform').validator('validate');

  
   //for text,date,image only
  if ( $('#subsciberform .has-error').length > 0 ) {
		parent.hideLoading();
		return false;
  }
  else{
	return true;
  }
  
  
    
   
}



{/literal}
</script>
<!--End Item-->