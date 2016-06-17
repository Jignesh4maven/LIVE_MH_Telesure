<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
                
				<form role="form" id="pagesform" name="pagesform" action="{$ADMIN_ALIAS}/pages" data-before="validate_pages()">
				<input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
                <input type="hidden" name="page_id" value="{$data_row.id}" class="ajx-control" />
				<textarea id="description" name="description" class="ajx-control" style="display: none;">
				</textarea>
				<div class="form-title mandatory">
					* fields are mandatory.
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
                            <label for="title_input">Title<sup class="mandatory">*</sup></label>
							<input type="text" id="title" name="title" placeholder="Title" value="{$data_row.title}" required  data-error="Please enter title." class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
					    
					</div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
						<div class="form-group">
                            <label for="title_input">Alias<sup class="mandatory">*</sup></label>
							<input type="text" readonly="readonly" id="title" name="alias" placeholder="alias" value="{$data_row.alias}" required  data-error="Please enter alias." class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
					    
					</div>
				</div>
                
                <div class="row">
					<div class="col-xs-12">
						<div class="form-group">
                            <label for="description_input">Description</label>
							<!--textarea id="description" name="description" placeholder="Description" class="form-control ajx-control" >
							{$data_row.description}	
							</textarea-->
						   <div class="help-block with-errors"></div>
						</div>
						
					</div>
					 
                </div>
				
				 <div class="row">
				<div class="widget flat radius-bordered">
    
					<div class="widget-body">
						<div class="widget-main no-padding">
							<div id="summernote">{$data_row.description|stripcslashes}	</div>
							
						</div>
					</div>
				</div>
				 </div>
							
			   {literal}
			   <button type="button" id="btnSubmit" class="btn btn-primary"  onmouseup="parent.showLoading()"   onclick='trigger_form({"frm":"pagesform","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
			   
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
  $('#summernote').summernote({ height: 300 });
  
  $("#title").focusout(function(){
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
		$("[name='alias']").val(output.toLowerCase());
  });
  
	//var rte = jQuery("#description").wysihtml5();
});
/*Ajax form submit callback*/
function action_response(resdata){
 
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
			
			
            //parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"pagesform","hidden":true});
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

function validate_pages(){
 
  jQuery("#description").val($('#summernote').code());
 
  $('#pagesform').validator('validate');

  if ( $('#pagesform .has-error').length > 0 ) {
    parent.hideLoading();
	return false;
  }
  else{
	return true;
  }
  
 }

{/literal}
</script>

  