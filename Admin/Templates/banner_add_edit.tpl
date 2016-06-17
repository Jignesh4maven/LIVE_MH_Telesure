<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">                

		
			<form role="form" id="bannerform" name="bannerform" action="{$ADMIN_ALIAS}/banner" data-before="validate_banner()" enctype="multipart/form-data">
				<input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
				<input type="hidden" name="banner_id" value="{$data_row.id}" class="ajx-control" />
				<textarea id="banner_short_description" name="banner_short_description" class="ajx-control" style="display: none;"></textarea>
				<div class="form-title mandatory">
					* fields are mandatory.
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
                           <label for="title_input">Title<sup class="mandatory">*</sup></label>
						   <input type="text" id="banner_title" name="banner_title" placeholder="Title"  value="{$data_row.title}" data-error="Please enter title." required class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
					</div>
                </div>
                
			<!--	<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
                            <label for="description_input"> Short Description</label>
							<textarea id="banner_short_description" name="banner_short_description" placeholder="Description" class="form-control ajx-control">{$data_row.short_description}</textarea>
						</div>
					</div>
                </div>-->
				
				<div class="row">
				   <div class="col-sm-12">
				   <div class="widget flat radius-bordered">
					   <div class="widget-body">
					   <label for="description">Short Description</label>
						 <div class="widget-main no-padding">
							 <div id="summernote_description">{$data_row.short_description|stripslashes}</div>
						 </div>
					   </div>
				   </div>
				   </div>
				</div>
				
				<div class="row">
<!--					<div class="col-sm-6">-->
<!--						<div class="form-group">-->
<!--                            <label for="order_display">Display Order<sup class="mandatory">*</sup></label>-->
<!--							<input type="text" id="banner_display_order" name="banner_display_order" required placeholder="" class="form-control ajx-control">-->
<!--							<div class="help-block with-errors"></div>-->
<!--						</div>-->
<!--					</div>-->
               
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label for="status_select">Status<sup class="mandatory">*</sup></label>
                            <div class="radio">
                              {if $data_row.status == "Inactive"}
									{assign var="status_inactive" value="checked"}
                              {else}
                                    {assign var="status_active" value="checked"} 
                              {/if}
                             <label>
                                <input type="radio"  id="status" name="status" value="1"  {$status_active} class="form-control ajx-control" required> 
                                <span class="text">Active</span>
                             </label>
                             
                              <label>
                                <input type="radio"  id="status" name="status" value="0"  {$status_inactive} class="form-control ajx-control" required>
                                <span class="text">Inactive</span>
                             </label>
                              
                            </div>
							<div class="help-block with-errors"></div>
						</div>
					</div>
                </div>
                
				
			</form>
		
		<!-- Image Upload Section Starts -->
		<div class="row">
			<div class="col-sm-12">
			<form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="banner">
				<input type="hidden" name="opcode" value="images_upload" class="ajx-control" />
				<div class="form-group fileUpload">
					 <p class="btn" ><i class="fa fa-upload" aria-hidden="true"></i><span>Choose a file…</span>
					
					<input type="hidden" name="image_form_submit" value="1"/>
					<input name="images[]" id="images" multiple  type="file" class="upload" />
				</div>
			</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<!-- <h2>Images Preview</h2><hr/>-->
				 <div class="gallery" id="images_preview1">
					{if isset($gallery_images)}
						<ul class="reorder_ul reorder-photos-list list-inline">
						{foreach from=$gallery_images item=image}
							<li id="{$image.imageid}" data-val="{$image.image}" class="ui-sortable-handle"><span>
							<img src="{$IMAGE_PATH}{$image.image}"/></span>
							 <button type="button" class="gallery-close-btn "  onclick="deleteImage(this);">×</button></li>
							</li>
						{/foreach}
						</ul>
					{/if}
				 </div>
			 </div>
		</div>
		<!-- Image Upload Section Ends -->
	
		<div class="col-sm-12">
		<div class="file-upload-center">
			{literal}
				<button type="button" id="btnSubmit" class="btn btn-primary"  onmouseup="parent.showLoading()" onclick='trigger_form({"frm":"bannerform","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
				 
				<button  class="btn btn-danger" type="button" onclick="parent.close_modal()" >Close</button>
			{/literal}
		</div>
		</div>
<!-- for image-->
<script src="{$TEMPLATE_JS}jquery.form.js"></script>
<!-- end for image -->

<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/jquery.hotkeys.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/prettify.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="{$COMMON_SCRIPTS}editors/summernote/summernote.js"></script>	
<script>
var admin_path 			= "{$ADMIN_PATH}";
var cache_path 			= "{$CACHE_IMG_PATH}";
var upload_path 		= "{$UPLOADS_PATH}";
var images_edit_mode	= "{$gallery_images}";

{literal}
jQuery(function () {
	   
	   $('#images').on('change',function(){
		
			  /*var attr = $('#images').attr('multiple');
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
	   
	   
	   
 //var rte = jQuery("#banner_short_description").wysihtml5();
 $('#summernote_description').summernote({ height: 100 });
});
/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
            $('#btnSubmit').hide();
        	$('#btnWait').show();
			//parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"bannerform","hidden":true});
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

function validate_banner(){
 
	jQuery("#banner_short_description").val($('#summernote_description').code());
	
  $('#bannerform').validator('validate');

  if ( $('#bannerform .has-error').length > 0 ) {
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
		var banner_id = $("[name='banner_id']").val();
		var img_location = "";
		var modal_action = $("[name='opcode']").val();
		
		console.log(img_location);
		console.log(image);
		
		$.ajax({
			type: "POST",
			url: admin_path + "banner",
			dataType: "json",
			data: {opcode:'delete_image',image:image,modal_action:modal_action,banner_id:banner_id},                        
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

  