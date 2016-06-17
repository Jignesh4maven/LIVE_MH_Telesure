<link rel="stylesheet" href="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<form id="frm-pages"  class="form-horizontal" role="form" method="post">
   <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
   <input type="hidden" name="page_id" value="{$data_row.page_id}" class="ajx-control" />
<div class="box-body">
    <div class="form-group">
    <label for="pagename" class="col-sm-2 control-label">Page Name</label>
        <div class="col-sm-10">
            <input name="pagename" class="form-control ajx-control" value="{$data_row.page_name}" id="pagename" placeholder="Type your page name here.">
        </div>
    </div>
    
    <div class="form-group">
        <label for="pagecontent" class="col-sm-2 control-label">Page Content</label>
        <div class="col-sm-10">
            <textarea id="pagecontent"  name="pagecontent" class="form-control ajx-control" style="height: 180px">
                {$data_row.page_content}
            </textarea>
        </div>
    </div>

</div><!-- /.box-body -->
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left modal_close" data-dismiss="modal">Close</button>
    {literal}
    <button type="button" class="btn btn-primary" onclick='trigger_form({"frm":"frm-pages","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
    {/literal}
</div>
</form>
<script src="{$TEMPLATE_PLUGINS}bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
{literal}
jQuery(function () {


var rte = jQuery("#pagecontent").wysihtml5();
 
  
});

/*Ajax form submit callback*/
function action_response(resdata){
    
    if( typeof(resdata) != "undefined"){
        
        if( resdata.resultStatus ==  "Success"){
            //parent.jQuery("#modal_add_edit").modal("hide");
            cleanup_ajax_form({"frm":"frm-pages"});
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