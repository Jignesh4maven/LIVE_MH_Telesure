	<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">	
		 <form role="form" id="planform" name="planform" action="{$ADMIN_ALIAS}/plans" data-before="set_description()">
			<input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
			<input type="hidden" name="plan_id" value="{$data_row.id}" class="ajx-control" />
			<textarea id="plans_short_description" name="plans_short_description" class="ajx-control" style="display: none;"></textarea>
			<textarea id="plans_full_description" name="plans_full_description" class="ajx-control" style="display: none;"></textarea>
			<textarea id="plans_need_description" name="plans_need_description" class="ajx-control" style="display: none;"></textarea>
			<textarea id="plans_covered_description" name="plans_covered_description" class="ajx-control" style="display: none;"></textarea>
			<textarea id="plans_faq" name="plans_faq" class="ajx-control" style="display: none;"></textarea>
			
			<div class="row">
			   <div class="col-lg-12 col-sm-12 col-xs-12">
				   <div class="widget flat radius-bordered">
					   
					   <div class="widget-body">
						   <div class="widget-main ">
							   <div class="tabbable">
								   <ul class="nav nav-tabs tabs-flat" id="myTab11">
									   <li class="active">
										   <a data-toggle="tab" href="#general">
											   General
										   </a>
									   </li>
									   <li id="tabs">
										   {if $data_row.id !="" }
											 <a data-toggle="tab" href="#details">
												 Details
											 </a>
										   {else}
											 <a  href="#details">
											   Details
											 </a>
										   {/if}
									   </li>
								   </ul>
								   <div class="tab-content tabs-flat">
									  
									   <div id="general" class="tab-pane in active">
										
										   <div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
													<label for="plan_type_input">Plan type<sup class="mandatory">*</sup></label>
													<select id="plan_type" name="plan_type"  required  data-error="Please  select plan type" class="form-control ajx-control">
														<option value="" disabled>Select Plan type</option>
														{foreach from=$plan_type_names key=k item=v}
															{if $v.plan_id == $data_row.plan_type}
																<option value="{$v.plan_id}" selected>{$v.plan_type}</option>
															{else}
																<option value="{$v.plan_id}">{$v.plan_type}</option>
															{/if}
														{/foreach}
													</select>
													<div class="help-block with-errors"></div>
												 </div>
											 </div>
										  </div>
										   
										  <div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
													<label for="title_input">Title<sup class="mandatory">*</sup></label>
													<input type="text" id="plans_title"  name="plans_title"  required  data-error="Please enter title." value="{$data_row.title}" placeholder="Enter Title" class="form-control ajx-control">
													<div class="help-block with-errors"></div>
												 </div>
											 </div>
										  </div>
										  
										  <div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
													<label for="alias_input">Alias<sup class="mandatory">*</sup></label>
													<input type="text" id="plans_alias" readonly="readonly" name="plans_alias" required data-error="Please enter alias." value="{$data_row.alias}" placeholder="Enter Alias" class="form-control ajx-control">
													<div class="help-block with-errors"></div>
												 </div>
											 </div>
										  </div>
										  <div class="row">
											 <div class="col-sm-12">
											 <div class="form-group">
												 <label for="status_select">Status<sup class="mandatory">*</sup></label>
												 <div class="radio">
												   {if $data_row.status == "Inactive"}
														 {assign var="status_inactive" value="checked"}
												   {else}
														 {assign var="status_active" value="checked"} 
												   {/if}
												  <label>
													 <input type="radio"  id="plans_status" name="plans_status" value="1"  {$status_active} class="form-control ajx-control"> 
													 <span class="text">Active</span>
												  </label>
												  
												   <label>
													 <input type="radio"  id="plans_status" name="plans_status" value="0"  {$status_inactive} class="form-control ajx-control">
													 <span class="text">Inactive</span>
												  </label>
												  </div>
											 </div>
											 </div>
										 
											 <!-- <div class="col-sm-6">
												  <div class="form-group">
													 <label for="image_upload">Image</label>
													 <input type="file" id="plans_image" name="plans_image" class="ajx-control">
												  </div>
											  </div>-->
										  </div>
										  
										  <!--div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
													<label for="short_description">Short Description</label>
													<textarea id="plans_short_description" name="plans_short_description" class="form-control ajx-control">{$data_row.short_description}</textarea>
												 </div>
											 </div>
										  </div-->
										  
										  <div class="row">
											<div class="col-sm-12"> 
											<div class="widget flat radius-bordered">
												  <div class="widget-body">
													<label for="short_description">Short Description</label>
													  <div class="widget-main no-padding">
														  <div id="summernote_short_description">{$data_row.short_description}</div>
													  </div>
												  </div>
											</div>
											</div>
										  </div>
											
							
										 <!-- <div class="row">
											  <div class="col-sm-12">
												 <div class="form-group">
													<label for="full_description">Full Description</label>
													<textarea id="plans_full_description" name="plans_full_description" class="form-control ajx-control">{$data_row.full_description}</textarea>
												 </div>
											  </div>
										  </div>-->
										  
										<div class="row">
											<div class="col-sm-12">  
											<div class="widget flat radius-bordered">
												<div class="widget-body">
												  <label for="full_description">Full Description</label>
													<div class="widget-main no-padding">
														<div id="summernote_full_description">{$data_row.full_description}</div>
													</div>
												</div>
											</div>
											</div>
										</div>
										  
										 {literal}
											 <button type="button" id="next" class="btn btn-primary" onclick='validate_plans()'>Next</button>
										 {/literal}
										
									   </div><!-- general tab close-->
									   
										<div id="details" class="tab-pane">
										
										  <!--<div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
												   <label for="need_description">Do I need</label>
												   <textarea id="plans_need_description" name="plans_need_description" class="form-control ajx-control">{$data_need.detail_value}</textarea>
												 </div>
											 </div>
										  </div>
										  -->
											<div class="row">
											<div class="col-sm-12">   
											<div class="widget flat radius-bordered">
											  <div class="widget-body">
												<label for="need_description">Do I need</label>
												  <div class="widget-main no-padding">
													  <div id="summernote_need">{$data_need.detail_value}</div>
												  </div>
											  </div>
											</div>
											</div>
											</div>
										 <!-- <div class="row">
											 <div class="col-sm-12">
												 <div class="form-group">
												   <label for="covered_description">Whats covered?</label>
												   <textarea id="plans_covered_description" name="plans_covered_description" class="form-control ajx-control">{$data_covered.detail_value}</textarea>
												 </div>
											 </div>
										  </div>-->
											
											<div class="row">
											<div class="col-sm-12">   
											<div class="widget flat radius-bordered">
											  <div class="widget-body">
												<label for="need_description">Whats covered?</label>
												  <div class="widget-main no-padding">
													  <div id="summernote_covered">{$data_covered.detail_value}</div>
												  </div>
											  </div>
											</div>
											</div>
											</div>
										  <!--<div class="row">
											  <div class="col-sm-12">
												 <div class="form-group">
												   <label for="faq_description">Faq</label>
												   <textarea id="plans_faq" name="plans_faq" class="form-control ajx-control">{$data_faq.detail_value}</textarea>
												 </div>
											  </div>
										  </div>-->
										  
											<div class="row">
											<div class="col-sm-12">    
											<div class="widget flat radius-bordered">
											  <div class="widget-body">
												<label for="need_description">Faq</label>
												  <div class="widget-main no-padding">
													  <div id="summernote_faq">{$data_faq.detail_value}</div>
												  </div>
											  </div>
											</div>
											</div>
											</div>
										  {literal}
											<button type="button" id="btnSubmit" class="btn btn-primary" onmouseup="parent.showLoading()"  onclick='trigger_form({"frm":"planform","ajxcallback":function(resdata){action_response(resdata);}})'>Save</button>
											
											<button  class="btn btn-danger" type="button" onclick="parent.close_modal()" >Close</button>
										 {/literal}
																   
										  
										</div>
									  
									   
								   </div>
							   </div>
						   </div>
					   </div>
				   </div>
			   </div>
			   <div class="col-lg-6 col-sm-6 col-xs-12">
			   </div>
			</div>
			</form>
		 
			<!-- for image-->
		
			<div class="row">
				<div class="col-sm-12">
				   <form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="plans" >
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
		 
	 
<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="{$COMMON_SCRIPTS}editors/wysiwyg/jquery.hotkeys.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/prettify.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="{$COMMON_SCRIPTS}editors/summernote/summernote.js"></script>

<!-- for image upload-->
<script src="{$TEMPLATE_JS}jquery.form.js"></script>
<!-- end-->
<script>
var admin_path 	= "{$ADMIN_PATH}";//for image need	
{literal}
jQuery(function () {
   
    $("#plans_title").focusout(function(){
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
		
		 $("[name='plans_alias']").val(output_text);
   });
   
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
   
$('#summernote_short_description').summernote({ height: 100 });
$('#summernote_full_description').summernote({ height: 100 });
$('#summernote_need').summernote({ height: 100 });
$('#summernote_covered').summernote({ height: 100 });
$('#summernote_faq').summernote({ height: 100 });

//var rte = jQuery("#plans_short_description").wysihtml5();
//var rte1 = jQuery("#plans_full_description").wysihtml5();
//var rte2 = jQuery("#plans_need_description").wysihtml5();
//var rte3 = jQuery("#plans_covered_description").wysihtml5();
//var rte4 = jQuery("#plans_faq").wysihtml5();


});

/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
            $('#btnSubmit').hide();
        	$('#btnWait').show();
			//parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"planform"});
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
function set_description(){
	
	jQuery("#plans_short_description").val($('#summernote_short_description').code());
	jQuery("#plans_full_description").val($('#summernote_full_description').code());
	
	jQuery("#plans_need_description").val($('#summernote_need').code());
	jQuery("#plans_covered_description").val($('#summernote_covered').code());
	jQuery("#plans_faq").val($('#summernote_faq').code());
	return true;
}

function validate_plans(){
   
	
	jQuery("#plans_short_description").val($('#summernote_short_description').code());
	jQuery("#plans_full_description").val($('#summernote_full_description').code());
	
	
    $('#planform').validator('validate');
	
	 //for text,date,image only
   if ( $('#planform .has-error').length > 0 ) {
		    
		
		$('.nav li').not('.active').addClass('disabled');
		$('.nav li').not('.active').find('a').removeAttr("data-toggle");
		parent.hideLoading();
	    return false;
   }
   else{
	
		$('.nav li.active').next('li').removeClass('disabled');
        $('.nav li.active').next('li').find('a').attr("data-toggle","tab");
		$('#tabs a[href="#details"]').tab('show'); 
		return true;
   }
   
    //for plan_type dropdown
  var plan_type=$('#plan_type').val();
  var cat_frm_group = $("#plan_type").parents('.form-group');
  
   if (plan_type == "") {
		  cat_frm_group.addClass('has-error');
		  $(cat_frm_group.find('.help-block')).text("Please Select Plan Type.");
   }
   else{
		 cat_frm_group.removeClass('has-error');
		 $(cat_frm_group.find('.help-block')).text("");
   }
}
//for delete image
function deleteImage(obj){
	if(confirm('Are you sure want to delete this image?')){
		//e.preventDefault();
        var image = $(obj).closest('li').data('val');
        var image_id = $(obj).closest('li').attr('id');
		var plan_id = $("[name='plan_id']").val();
		var img_location = "";
		var modal_action = $("[name='opcode']").val();
		
		console.log(img_location);
		console.log(image);
		
		$.ajax({
			type: "POST",
			url: admin_path + "plans",
			dataType: "json",
			data: {opcode:'delete_image',image:image,modal_action:modal_action,plan_id:plan_id},                        
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