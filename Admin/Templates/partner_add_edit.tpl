
<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
                
			   <form role="form" id="partnerform" name="partnerform" action="{$ADMIN_ALIAS}/partners" enctype="multipart/form-data" data-before="validate_partner()">
			   <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
			   <input type="hidden" name="partner_id" value="{$data_row.id}" class="ajx-control" />
			   <textarea id="partners_short_description" name="partners_short_description" class="ajx-control" style="display: none;"></textarea>
			   <div class="form-title mandatory">
					* fields are mandatory.
			   </div>
			   <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="title_input">Title<sup class="mandatory">*</sup></label>
						   <input type="text" id="partners_title" name="partners_title"  value = "{$data_row.title}"  data-error="Please enter title." required placeholder="Enter Title" class="form-control ajx-control">
						    <div class="help-block with-errors"></div>
						</div>
					</div>
					<!--<div class="col-sm-4">
						<div class="form-group">
						   <label for="image_upload">Image</label>
						   <input type="file" id="partners_image" name="partners_image" class="ajx-control" >
						</div>
					</div>-->
					<div class="col-sm-6">
						<div class="form-group">
							<label for="status_select">Status <sup class="mandatory">*</sup></label>
                            <div class="radio">
                              {if $data_row.status == "Inactive"}
									{assign var="status_inactive" value="checked"}
                              {else}
                                    {assign var="status_active" value="checked"} 
                              {/if}
                             <label>
                                <input type="radio"  id="partners_status" name="partners_status" value="1"  {$status_active} class="form-control ajx-control"> 
                                <span class="text">Active</span>
                             </label>
                             
                              <label>
                                <input type="radio"  id="partners_status" name="partners_status" value="0"  {$status_inactive} class="form-control ajx-control">
                                <span class="text">Inactive</span>
                             </label>
							 </div>
						</div>
					</div>
			   </div>
			  <!-- <div class="row">
					<div class="col-sm-11">
						<div class="form-group">
						   <label for="short_description">Short Description</label>
						   <textarea name="partners_short_description" id="partners_short_description" class="form-control ajx-control">{$data_row.short_description}</textarea>
						</div>
					</div>
					
			   </div>-->
			   <div class="row">
				   <div class="col-sm-12">
				   <div class="widget flat radius-bordered">
					   <div class="widget-body">
					   <label for="description">Description</label>
						 <div class="widget-main no-padding">
							 <div id="summernote_description">{$data_row.short_description|stripslashes}</div>
						 </div>
					   </div>
				   </div>
				   </div>
				</div>
			</form>
			   
				 <!-- for image-->
		
				<div class="row">
					<div class="col-sm-12">
					   <form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="partners" >
							 <input type="hidden" name="opcode" value="images_upload" class="ajx-control" />
							 <div class="form-group fileUpload">
								 <p class="btn" ><i class="fa fa-upload" aria-hidden="true"></i><span>Choose a file…</span>
								
								 <input type="hidden" name="image_form_submit" value="1"/>
								 <input name="images[]" id="images" type="file"  multiple class="upload"  />
							 </div>
						</form>
					</div> 
				</div>
					<div class="row">
						<div class="col-sm-12 ">
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
			   <button type="button" id="btnSubmit" class="btn btn-primary"  onmouseup="parent.showLoading()"  onclick='trigger_form({"frm":"partnerform","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
			  
			   <button  class="btn btn-danger" type="button" onclick="parent.close_modal()" >Close</button>
			   {/literal}
			</div>
			</div>
<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/jquery.hotkeys.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/prettify.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="{$COMMON_SCRIPTS}editors/summernote/summernote.js"></script>
<!-- for image upload-->
<script src="{$TEMPLATE_JS}jquery.form.js"></script>
<!-- end-->
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

//var rte = jQuery("#partners_short_description").wysihtml5();
  $('#summernote_description').summernote({ height: 100 });
  
});
/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
          
			//parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"partnerform"});
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

function validate_partner(){
    
	jQuery("#partners_short_description").val($('#summernote_description').code());
	
	 //for text,date,image only
  $('#partnerform').validator('validate');
  if ( $('#partnerform .has-error').length > 0 ) {
	 parent.hideLoading();
	 return false;
  }
  else{
	return true;
  }
}

/* for image delete*/
function deleteImage(obj){
	if(confirm('Are you sure want to delete this image?')){
		//e.preventDefault();
        var image = $(obj).closest('li').data('val');
        var image_id = $(obj).closest('li').attr('id');
		var partner_id = $("[name='partner_id']").val();
		var img_location = "";
		var modal_action = $("[name='opcode']").val();
		
		console.log(img_location);
		console.log(image);
		
		$.ajax({
			type: "POST",
			url: admin_path + "partners",
			dataType: "json",
			data: {opcode:'delete_image',image:image,modal_action:modal_action,partner_id:partner_id},                        
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
<!--End Item-->