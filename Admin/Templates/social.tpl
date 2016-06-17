<div id="modulename" data-modulename="social"></div>
		 <div class="col-xs-12 col-md-12">
			<form role="form" id="socialform" name="socialform" action="{$ADMIN_ALIAS}/social">
			   <input type="hidden" name="opcode" value="edit_data" class="ajx-control" />
			   
			   <div class="row">
				  <div class="col-sm-12">
					 <div class="alert alert-success" id="success_message" style="display:none;">
						  Update Successfully.
					  </div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-sm-12">
					 <div class="alert alert-danger" id="error_message" style="display:none;">
						  Not update Successfully.
					  </div>
				  </div>
				</div>
				<div class="form-title">
					Social Links
				</div>
				{foreach from=$load_result key=k item=v }
					 <div class="row">
						<div class="col-sm-12">
						   <div class="form-group">
							   <label for="twitterlink_input">{$v.social_network}</label>
							   <input type="text" id="{$v.social_network}" name="{$v.social_network}" value="{$v.social_url}" placeholder="Type Social Media Url" class="form-control ajx-control">
						   </div>
						</div>
					 </div>
				{/foreach}
	
				{literal}
				<button type="button"  id="btnSubmit" class="btn btn-primary" onmouseup="parent.showLoading()" onclick='trigger_form({"frm":"socialform","ajxcallback":function(resdata){action_response(resdata);}})'>Update</button>
				
				{/literal}
			</form>  
         </div>
<script>
{literal}
  
function action_response(resdata){
    
 
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
			$('#success_message').show();
			
			setTimeout(function(){
			   $('#success_message').fadeOut();
			 
			},2000);
			//alert("Success");      
        }
        else if (resdata.resultStatus ==  "Warning") {
            
            $('#error_message').show();
			//alert("Failed"); 
            return false;
            
        }
    }
	parent.hideLoading();
}
{/literal}
</script>     

 