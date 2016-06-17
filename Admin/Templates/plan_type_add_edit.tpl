	<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">	
		 <form role="form" id="plantypeform" name="plantypeform" action="{$ADMIN_ALIAS}/plantype"  data-before="Validate_plantype()">
			<input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
			<input type="hidden" name="plantype_id" value="{$data_row.id}" class="ajx-control" />
			<textarea id="plan_type_description" name="plan_type_description" class="ajx-control" style="display: none;"></textarea>
			
			<div class="row">
				<div class="col-lg-12 col-sm-12 col-xs-12">
				 
					 
										<div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
													<label for="plan_name_input">Plan type name<sup class="mandatory">*</sup></label>
													<input type="text" id="plan_name" name="plan_name"  required  data-error="please enter plan name" class="form-control ajx-control" value="{$data_row.title}">
													<div class="help-block with-errors"></div>
												 </div>
											 </div>
										</div>
										   
									
										<div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
													<label for="alias_input">Alias<sup class="mandatory">*</sup></label>
													<input type="text" id="plan_type_alias" name="plan_type_alias" required data-error="Please enter alias." value="{$data_row.alias}" placeholder="Enter Alias" class="form-control ajx-control" readonly="readonly" value="{$data_row.alias}">
													<div class="help-block with-errors"></div>
												 </div>
											 </div>
										</div>
										<div class="row">
											<div class="col-sm-6">
											 <div class="form-group">
												 <label for="status_select">Status<sup class="mandatory">*</sup></label>
												 <div class="radio">
												   {if $data_row.status == "Inactive"}
														 {assign var="status_inactive" value="checked"}
												   {else}
														 {assign var="status_active" value="checked"} 
												   {/if}
												  <label>
													 <input type="radio"  id="plan_type_status" name="plan_type_status" value="1"  {$status_active} class="form-control ajx-control"> 
													 <span class="text">Active</span>
												  </label>
												  
												   <label>
													 <input type="radio"  id="plan_type_status" name="plan_type_status" value="0"  {$status_inactive} class="form-control ajx-control">
													 <span class="text">Inactive</span>
												  </label>
												  </div>
											</div>
											</div>
										
											<div class="col-sm-6">
												<label for="short_description">Allow at home</label>
												<div class="checkbox">
													{if $data_row.allow == "N"}
														 {assign var="not_allowed" value="checked"}
												   {else}
														 {assign var="allowed" value="checked"} 
												   {/if}
													<label>
													<input type="radio"  id="plan_allow_at_home" name="plan_allow_at_home" value="Y" class="form-control ajx-control" {$allowed} >
													<span class="text">Yes</span>
													</label>
													<label>
													<input type="radio"  id="plan_allow_at_home" name="plan_allow_at_home" value="N" class="form-control ajx-control"  {$not_allowed}>
													<span class="text">No</span>
													</label>
												</div>
                                            </div>
											  
										</div>
										<!--<div class="row">
											<div class="col-sm-6">
												  <div class="form-group">
													 <label for="image_upload">Image</label>
													 <input type="file" id="plan_type_image" name="plan_type_image" class="ajx-control">
												  </div>
											  </div>
										</div>-->
										
										
										<div class="row">
											<div class="col-sm-12">
											<div class="widget flat radius-bordered">
												<div class="widget-body">
												<label for="description">Description</label>
												  <div class="widget-main no-padding">
													  <div id="summernote_description">{$data_row.description}</div>
												  </div>
												</div>
											</div>
											</div>
										</div>
										
							
				</div>	
			</div>
		</form>
		 <!-- for image-->
		<div class="row">
			<div class="col-sm-12">
			<form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="plantype">
				 <input type="hidden" name="opcode" value="images_upload" class="ajx-control" />
				 <div class="form-group fileUpload">
					 <p class="btn" ><i class="fa fa-upload" aria-hidden="true"></i><span>Choose a file…</span>
					 <input type="hidden" name="image_form_submit" value="1"/>
					 <input name="images[]" id="images" type="file" class="upload" />
				 </div>
			</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				 <!-- <h2>Image Preview</h2><hr/>-->
				  <div class="gallery" id="images_preview1">
					 {if isset($gallery_images)}
						 <ul class="reorder_ul reorder-photos-list list-inline">
						 {foreach from=$gallery_images item=image}
							<li id="{$image.imageid}" data-val="{$image.image}" class="ui-sortable-handle">
								<span><img src="{$IMAGE_PATH}{$image.image}"/></span>
								<!--<p class="img-delete"><a href="javascript:void(0);" onclick="deleteImage(this);">Delete</a></p>-->
								<button type="button" class="gallery-close-btn "  onclick="deleteImage(this);">×</button>
							</li>
						 {/foreach}
						 </ul>
					 {/if}
				  </div>
			</div>
		</div>
		<!-- end image-->
		<div class="col-sm-12">
		<div class="file-upload-center">
			{literal}
				<button type="button" id="btnSubmit" class="btn btn-primary" onmouseup="parent.showLoading()"  onclick='trigger_form({"frm":"plantypeform","ajxcallback":function(resdata){action_response(resdata);}})'>Save</button>
				
				<button  class="btn btn-danger" type="button" onclick="parent.close_modal()" >Close</button>
			{/literal}
		</div>
		</div>

<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- for image upload-->
<script src="{$TEMPLATE_JS}jquery.form.js"></script>
<!-- end-->
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/jquery.hotkeys.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/prettify.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="{$COMMON_SCRIPTS}editors/summernote/summernote.js"></script>
<script>
var admin_path 	= "{$ADMIN_PATH}";	
{literal}
jQuery(function () {
   $("#plan_name").focusout(function(){
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
		 var output_text = output.toLowerCase();
		
		 $("[name='plan_type_alias']").val(output_text);
   });
   
   //for image upload
   $('#images').on('change',function(){
	 
			/*  var attr = $('#images').attr('multiple');
			  alert('attr : '+attr);
			  return;*/
		  
			  $('#multiple_upload_form').ajaxForm({
				  target:'',
				  contentType: "application/json",
				  dataType: "json",
				  beforeSubmit:function(e){
					  $('.uploading').show();
				  },
				  success:function(e){
					  console.log(e.resultData);
					  var data = e.resultData;
					  for(var i=0; i<data.length;i++)
					  {
						  var img = '<ul class="reorder_ul reorder-photos-list list-inline"><li id="'+data[i]['imageid']+'" data-val="'+data[i]['image']+'" class="ui-sortable-handle"><span><img src='+data[i]['imageData']+' title="image'+i+'" id="img'+i+'" /></span><button type="button" class="gallery-close-btn "  onclick="deleteImage(this);">×</button></li></ul>';
						  $('#images_preview1').append(img);
						  
					  }
					  
					  $('.uploading').hide();
				  },
				  error:function(e){
				  }
			  }).submit();
});

$('#summernote_description').summernote({ height: 100 });

});
/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
           //parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"plantypeform"});
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
function Validate_plantype() {
	
	 
	jQuery("#plan_type_description").val($('#summernote_description').code());
	
	$('#plantypeform').validator('validate');
	
	 //for text,date,image only
	if ( $('#plantypeform .has-error').length > 0 ) {
		parent.hideLoading();
		return false;
	}
	else{
		return true;
   }
}

function deleteImage(obj){
	if(confirm('Are you sure want to delete this image?')){
		//e.preventDefault();
        var image = $(obj).closest('li').data('val');
        var image_id = $(obj).closest('li').attr('id');
		var plantype_id = $("[name='plantype_id']").val();
		var img_location = "";
		var modal_action = $("[name='opcode']").val();
		
		console.log(img_location);
		console.log(image);
		
		$.ajax({
			type: "POST",
			url: admin_path + "plantype",
			dataType: "json",
			data: {opcode:'delete_image',image:image,modal_action:modal_action,plantype_id:plantype_id},                        
			success: function(response) {			
				alert(response.resultData.resultMessage);
				console.log(response.resultData.resultImages);
				$('#'+image_id).remove();				
			}
        }); 
	}else{
		return false;
	}
	
}

{/literal}
</script>