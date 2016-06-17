<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<form id="frm-blogs"  class="form-horizontal" role="form" method="post" action="{$ADMIN_ALIAS}/blog">

   <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
   <input type="hidden" name="blog_id" value="{$data_row.blog_id}" class="ajx-control" />
<div class="box-body">
    <div class="form-group">
    <label for="blogname" class="col-sm-2 control-label">Blog Name</label>
        <div class="col-sm-10">
            <input name="blogname" required class="form-control ajx-control" value="{$data_row.blog_name}" id="blogname" placeholder="Type your blog name here.">
        </div>
    </div>
    
    <div class="form-group">
        <label for="blogcontent" class="col-sm-2 control-label">Blog Content</label>
        <div class="col-sm-10">
            <textarea id="blogcontent"  name="blogcontent" class="form-control ajx-control" style="height: 180px">
                {$data_row.blog_content}
            </textarea>
        </div>
    </div>

</div><!-- /.box-body -->
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left modal_close" data-dismiss="modal">Close</button>
    {literal}
    <button type="button" class="btn btn-primary" onclick='trigger_form({"frm":"frm-blogs","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
    {/literal}
</div>
</form>
<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
{literal}
jQuery(function () {


var rte = jQuery("#blogcontent").wysihtml5();
 
  
});

/*Ajax form submit callback*/
function action_response(resdata){

    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
            //parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"frm-blogs"});
            parent.jQuery("[id^='modal_add_edit']").modal("hide");
            parent.refresh_list();        
        }
        else if (resdata.resultStatus ==  "Warning") {
            
            alert(""+resdata.resultMessage);
            return false;
            
        }
    }
    
    
}
{/literal}
</script>