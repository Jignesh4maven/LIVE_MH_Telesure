	<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">	
	
		
		<form role="form" id="planoptionform" name="planoptionform" action="{$ADMIN_ALIAS}/planoption"  data-before="Validate_planoption()">
			<input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
			<input type="hidden" name="planoption_id" value="{$data_row.id}" class="ajx-control" />
			<textarea id="plan_option_description" name="plan_option_description" class="ajx-control" style="display: none;"></textarea>
			
			
			
				 
					 
										<div class="row">
											 <div class="col-sm-6">
												 <div class="form-group">
													<label for="plan_type_input">Plan type<sup class="mandatory">*</sup></label>
													<select id="plan_option_type" name="plan_option_type"  required  data-error="Please  select plan type" class="form-control ajx-control">
														<option value="" disabled>Select Plan type</option>
														{foreach from=$plan_type_names key=k item=v}
															{if $v.plan_id == $data_row.plan_ref_id}
																<option value="{$v.plan_id}" selected>{$v.plan_type}</option>
															{else}
																<option value="{$v.plan_id}">{$v.plan_type}</option>
															{/if}
														{/foreach}
													</select>
													<div class="help-block with-errors"></div>
												 </div>
											 </div>
									
											 <div class="col-sm-6">
												 <div class="form-group">
													<label for="plan_name_input">Title<sup class="mandatory">*</sup></label>
													<input type="text" id="plan_option_title" name="plan_option_title"  required  data-error="please enter plan title." class="form-control ajx-control" value="{$data_row.title}">
													<div class="help-block with-errors"></div>
												 </div>
											 </div>
										</div>
										
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
											
										
				
			
		</form>
		
		 <!-- for image-->
		
			<div class="row">
				<div class="col-sm-12">
				   <form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="planoption" >
						 <input type="hidden" name="opcode" value="images_upload" class="ajx-control" />
						 <div class="form-group fileUpload">
							 <p class="btn" ><i class="fa fa-upload" aria-hidden="true"></i><span>Choose a file…</span>
							 <input type="hidden" name="image_form_submit" value="1"/>
							 <input name="images[]" id="images" type="file" class="upload"  />
						 </div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					 
					  <div class="gallery" id="images_preview1">
						 {if isset($gallery_images)}
							 <ul class="reorder_ul reorder-photos-list list-inline">
							 {foreach from=$gallery_images item=image}
								 <li id="{$image.imageid}" data-val="{$image.image}" class="ui-sortable-handle"><span><img src="{$IMAGE_PATH}{$image.image}"/></span>
								 <button type="button" class="gallery-close-btn "  onclick="deleteImage(this);">×</button></li>
								<!-- <a href="javascript:void(0);" class="close" onclick="deleteImage(this);">x</a></li>-->
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
			<button type="button" id="btnSubmit" class="btn btn-primary" onmouseup="parent.showLoading()"  onclick='trigger_form({"frm":"planoptionform","ajxcallback":function(resdata){action_response(resdata);}})'>Save</button>
			
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
 
   
   //for image upload
   $('#images').on('change',function(){
	 
			
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
						  var img = '<ul class="reorder_ul reorder-photos-list list-inline"><li id="'+data[i]['imageid']+'" data-val="'+data[i]['image']+'" class="ui-sortable-handle"><span><img src='+data[i]['imageData']+' title="image'+i+'" id="img'+i+'" /></span> <button type="button" class="gallery-close-btn"  onclick="deleteImage(this);">×</button></li></ul>';
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
            cleanup_ajax_form({"frm":"planoptionform"});
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
function Validate_planoption() {
	
	 
	jQuery("#plan_option_description").val($('#summernote_description').code());
	
	$('#planoptionform').validator('validate');
	
	 //for text,date,image only
	if ( $('#planoptionform .has-error').length > 0 ) {
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
		var planoption_id = $("[name='planoption_id']").val();
		var img_location = "";
		var modal_action = $("[name='opcode']").val();
		
		console.log(img_location);
		console.log(image);
		
		$.ajax({
			type: "POST",
			url: admin_path + "planoption",
			dataType: "json",
			data: {opcode:'delete_image',image:image,modal_action:modal_action,planoption_id:planoption_id},                        
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