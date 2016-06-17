<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
                
			   <form role="form" id="mhbuzzform" name="mhbuzzform" action="{$ADMIN_ALIAS}/mhbuzz" enctype="multipart/form-data" data-before="validate_mhbuzz()">
			   <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
			   <input type="hidden" name="buzz_id" value="{$data_row.id}" class="ajx-control" />
			    <textarea id="mhbuzz_short_description" name="mhbuzz_short_description" class="ajx-control" style="display: none;"></textarea>
				<textarea id="mhbuzz_full_description" name="mhbuzz_full_description" class="ajx-control" style="display: none;"></textarea>
				
			   <div class="form-title mandatory">
					* fields are mandatory.
			   </div>
			   <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="title_input">Title<sup class="mandatory">*</sup></label>
						   <input type="text" id="mh_buzz_title" name="mh_buzz_title" value="{$data_row.title}" required  data-error="Please enter title." placeholder="Enter Title" class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
						
					</div>
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="category_select">Category<sup class="mandatory">*</sup></label>
						   <select id="mh_buzz_categroy" name="mh_buzz_categroy"  class="form-control ajx-control" onchange="check_input()">
								  <option value="">Select Categroy</option>
							{foreach from=$buzz_category_list key=k  item=v}
							   {if $v.id!= "" && $v.id == $data_row.category}
								   <option value="{$v.id}" selected="selected"> {$v.title} </option>
							   {else}
								   <option value="{$v.id}"> {$v.title} </option>
							   {/if}
							{/foreach}
							
						   </select>
						    <div class="help-block with-errors"></div>
						</div>
					</div>
			   </div>
			   <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="alias_input">Alias<sup class="mandatory">*</sup></label>
						   <input type="text" id="mh_buzz_alias" readonly="readonly" name="mh_buzz_alias" value="{$data_row.alias}"  required  data-error="Please enter alias." placeholder="Enter Alias" class="form-control ajx-control">
						   <div class="help-block with-errors"></div>
						</div>
					</div>
					<!--<div class="col-sm-3">
						<div class="form-group">
						   <label for="ADMIN_ALIAS">Date<sup class="mandatory">*</sup></label>
						   <div class="input-group">
								 <input class="form-control date-picker ajx-control" id="mh_buzz_date" name="mh_buzz_date" required value="{$data_row.buzzdate}" type="text" data-date-format="dd-mm-yyyy">
								 <span class="input-group-addon">
									 <i class="fa fa-calendar"></i>
								 </span>
						   </div>
						   <div class="help-block with-errors"></div>
						</div>
					</div>-->
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
                                <input type="radio"  id="mhbuzz_status" name="mhbuzz_status" value="1"  {$status_active} class="form-control ajx-control"> 
                                <span class="text">Active</span>
                             </label>
                             
                              <label>
                                <input type="radio"  id="mhbuzz_status" name="mhbuzz_status" value="0"  {$status_inactive} class="form-control ajx-control">
                                <span class="text">Inactive</span>
                             </label>
                              
                            </div>
						  
						</div>
					</div>
			   </div>
			   
			 <!--  <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="short_description">Short Description</label>
						   <textarea id="mhbuzz_short_description" name="mhbuzz_short_description" class="form-control ajx-control">{$data_row.short_description}</textarea>
						</div>
					</div>
			  
					 <div class="col-sm-6">
						<div class="form-group">
						   <label for="full_description">Full Description</label>
						   <textarea id="mhbuzz_full_description" name="mhbuzz_full_description"  required class="form-control ajx-control">{$data_row.full_description}</textarea>
						</div>
										 
					 </div>
					 
			   </div>-->
				
				<div class="row">
				   <div class="col-sm-12">
				   <div class="widget flat radius-bordered">
					   <div class="widget-body">
					   <label for="description"> Short Description</label>
						 <div class="widget-main no-padding">
							 <div id="summernote_short_description">{$data_row.short_description|stripslashes}</div>
						 </div>
					   </div>
				   </div>
				   </div>
				</div>
				<div class="row">
				   <div class="col-sm-12">
				   <div class="widget flat radius-bordered">
					   <div class="widget-body">
					   <label for="description">Full Description</label>
						 <div class="widget-main no-padding">
							 <div id="summernote_full_description">{$data_row.full_description|stripslashes}</div>
						 </div>
					   </div>
				   </div>
				   </div>
				</div>
				
				</form>
			  
					
					<div class="row">
					<div class="col-sm-12">
						
						<form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="mhbuzz">
							  <input type="hidden" name="opcode" value="images_upload" class="ajx-control" />
						
							
							<div class="form-group fileUpload">
								<p class="btn" ><i class="fa fa-upload" aria-hidden="true"></i><span>Choose a file…</span>
								<input type="hidden" name="image_form_submit" value="1"/>
								<input name="images[]" id="images" type="file" class="upload" /></p>
							</div>
							
						</form>
						
					</div>
					</div>
					<div class="row">
						<div class="col-sm-12 ">
							 <!--  <h2>Image Preview</h2><hr/>-->
							   <div class="gallery" id="images_preview1">
								  {if isset($gallery_images)}
									  <ul class="reorder_ul reorder-photos-list list-inline">
									  {foreach from=$gallery_images item=image}
										  <li id="{$image.imageid}" data-val="{$image.image}" class="ui-sortable-handle"><span><img src="{$IMAGE_PATH}{$image.image}"/></span>
										  <!--<p class="img-delete"><a href="javascript:void(0);" onclick="deleteImage(this);">Delete</a></p>-->
										   <button type="button" class="gallery-close-btn "  onclick="deleteImage(this);">×</button>
										  </li>
									  {/foreach}
									  </ul>
								  {/if}
							   </div>
						</div>
					</div>
			  
		
		<div class="col-sm-12">
			<div class="file-upload-center">
			{literal}
			<button type="button" id="btnSubmit" class="btn btn-primary" onmouseup="parent.showLoading()" onclick='trigger_form({"frm":"mhbuzzform","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
		
			<button  class="btn btn-danger" type="button" onclick="parent.close_modal()" >Close</button>
			{/literal}
			</div>
		</div>
		
<!-- for image-->		
<script src="{$TEMPLATE_JS}jquery.form.js"></script>
<!-- end for image-->
<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/jquery.hotkeys.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/prettify.js"></script>
<script src="{$COMMON_SCRIPTS}editors/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="{$COMMON_SCRIPTS}editors/summernote/summernote.js"></script>
<script>
var admin_path 			= "{$ADMIN_PATH}";
{literal}



jQuery(function () {

$("#mh_buzz_title").focusout(function(){
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
		
		$("[name='mh_buzz_alias']").val(output.toLowerCase());
  });

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
						  var img = '<ul class="reorder_ul reorder-photos-list list-inline"><li id="'+data[i]['imageid']+'" data-val="'+data[i]['image']+'"class="ui-sortable-handle"><span><img src='+data[i]['imageData']+' title="image'+i+'" id="img'+i+'" /></span><button type="button" class="gallery-close-btn "  onclick="deleteImage(this);">×</button></li></ul>';
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
//var rte = jQuery("#mhbuzz_short_description").wysihtml5();
//var rte1 = jQuery("#mhbuzz_full_description").wysihtml5();
  
});
/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
           
			cleanup_ajax_form({"frm":"mhbuzzform"});
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
 function validate_mhbuzz(){
 
	jQuery("#mhbuzz_short_description").val($('#summernote_short_description').code());
	jQuery("#mhbuzz_full_description").val($('#summernote_full_description').code());
  
  $('#mhbuzzform').validator('validate');

  //for category dropdown
  var categroy=$('#mh_buzz_categroy').val();
  var cat_frm_group = $("#mh_buzz_categroy").parents('.form-group');
  
   if (categroy == "") {
		  cat_frm_group.addClass('has-error');
		  $(cat_frm_group.find('.help-block')).text("Please Select Categroy.");
   }
   else{
		 cat_frm_group.removeClass('has-error');
		 $(cat_frm_group.find('.help-block')).text("");
   }
   
   // for radio button
   //var radio_frm_group=$("#mhbuzz_status").parents('.form-group');
   //var status=$("input[name=mhbuzz_status]:checked").val();
   //alert(status);
   
   //for text,date,image only
  if ( $('#mhbuzzform .has-error').length > 0 ) {
		parent.hideLoading();
		return false;
  }
  else{
	return true;
  }
  
  
    
   
}
//on change of dropdown
function check_input(){
 
 var frm_group = $("#mh_buzz_categroy").parents('.form-group');
		 frm_group.removeClass('has-error');
		 $(frm_group.find('.help-block')).text("");
}



function deleteImage(obj){
	if(confirm('Are you sure want to delete this image?')){
		//e.preventDefault();
        var image = $(obj).closest('li').data('val');
        var image_id = $(obj).closest('li').attr('id');
		var buzz_id = $("[name='buzz_id']").val();
		var img_location = "";
		var modal_action = $("[name='opcode']").val();
		
		console.log(img_location);
		console.log(image);
		
		$.ajax({
			type: "POST",
			url: admin_path + "mhbuzz",
			dataType: "json",
			data: {opcode:'delete_image',image:image,modal_action:modal_action,buzz_id:buzz_id},                        
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