<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
                
			   <form role="form" id="buzzcategoryform" name="buzzcategoryform" action="{$ADMIN_ALIAS}/buzzcategory" enctype="multipart/form-data" data-before="validate_buzz_category()">
			   <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
			   <input type="hidden" name="buzz_category_id" value="{$data_row.id}" class="ajx-control" />
			    <textarea id="buzz_category_description" name="buzz_category_description" class="ajx-control" style="display: none;"></textarea>
			
				
			   <div class="form-title mandatory">
					* fields are mandatory.
			   </div>
			  
			   <div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						   <label for="title_input">Title<sup class="mandatory">*</sup></label>
						   <input type="text" id="buzz_category_title" name="buzz_category_title" value="{$data_row.title}" required  data-error="Please enter title." placeholder="Enter Title" class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
					</div>
			   </div>
			   <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="alias_input">Alias<sup class="mandatory">*</sup></label>
						   <input type="text" id="buzz_category_alias" readonly="readonly" name="buzz_category_alias" value="{$data_row.alias}"  required  data-error="Please enter alias." placeholder="Enter Alias" class="form-control ajx-control">
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
                                <input type="radio"  id="buzz_catrgory_status" name="buzz_catrgory_status" value="1"  {$status_active} class="form-control ajx-control"> 
                                <span class="text">Active</span>
                             </label>
                             
                              <label>
                                <input type="radio"  id="buzz_catrgory_status" name="buzz_catrgory_status" value="0"  {$status_inactive} class="form-control ajx-control">
                                <span class="text">Inactive</span>
                             </label>
                              
                            </div>
						  
						</div>
					</div>
			   </div>
			   
			
				<div class="row">
				   <div class="col-sm-12">
				   <div class="widget flat radius-bordered">
					   <div class="widget-body">
					   <label for="description"> Description</label>
						 <div class="widget-main no-padding">
							 <div id="summernote_description">{$data_row.description|stripslashes}</div>
						 </div>
					   </div>
				   </div>
				   </div>
				</div>
				
				{literal}
				<button type="button" id="btnSubmit" class="btn btn-primary" onmouseup="parent.showLoading()" onclick='trigger_form({"frm":"buzzcategoryform","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
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



jQuery(function () {

$("#buzz_category_title").focusout(function(){
	    var string              = $(this).val();
		var strReplaceAll       = string;
		var intIndexOfMatch     = strReplaceAll.indexOf(' ');
		while(intIndexOfMatch != -1){
			strReplaceAll       = strReplaceAll.replace(' ', '-');
			intIndexOfMatch     = strReplaceAll.indexOf(' ');
		}
		string = strReplaceAll;
		for(var i = 0, output = '', valid='-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; i < string.length; i++) {
			if(valid.indexOf(string.charAt(i)) != -1) {
				output += string.charAt(i);
			}
		}
		
		$("[name='buzz_category_alias']").val(output.toLowerCase());
  });

 
 
$('#summernote_description').summernote({ height: 100 });

});
/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
          
			//parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"buzzcategoryform"});
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
 function validate_buzz_category(){
 
	jQuery("#buzz_category_description").val($('#summernote_description').code());
	
  
  $('#buzzcategoryform').validator('validate');

  //for category dropdown
  var categroy=$('#buzz_categroy').val();
  var cat_frm_group = $("#buzz_categroy").parents('.form-group');
  
   if (categroy == "") {
		  cat_frm_group.addClass('has-error');
		  $(cat_frm_group.find('.help-block')).text("Please Select Categroy.");
   }
   else{
		 cat_frm_group.removeClass('has-error');
		 $(cat_frm_group.find('.help-block')).text("");
   }
   
  
   
   //for text,date,image only
  if ( $('#buzzcategoryform .has-error').length > 0 ) {
		parent.hideLoading();
		return false;
  }
  else{
	return true;
  }
  
  
    
   
}
//on change of dropdown
function check_input(){
 
 var frm_group = $("#buzz_categroy").parents('.form-group');
		 frm_group.removeClass('has-error');
		 $(frm_group.find('.help-block')).text("");
}




{/literal}
</script>
<!--End Item-->