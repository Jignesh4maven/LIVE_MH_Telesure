{literal}
<form id="frm-customers"  class="form-horizontal" role="form" method="post" data-before='validate_form({"frm":"frm-customers"})'>
    {/literal}
    <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
    <input type="hidden" name="page_id" value="{$data_row.page_id}" class="ajx-control" />
    <div class="box-body">
        <div class="form-group">
            <label for="customername" class="col-sm-2 control-label">Customer Name</label>
            <div class="col-sm-10">
                <input name="customername" required class="form-control ajx-control" value="{$data_row.name}" id="customername" placeholder="Type customer name here.">
            </div>
        </div>

        <div class="form-group">
            <label for="customeraddress" class="col-sm-2 control-label">Customer Address</label>
            <div class="col-sm-10">
            <textarea id="customeraddress"  name="customeraddress" class="form-control ajx-control" style="height: 180px">
                {$data_row.address}
            </textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="customergender" class="col-sm-2 control-label">Gender</label>
            <div class="col-sm-10" style="padding-top:5px;">
                <input name="customergender" type="radio" required class="ajx-control" value="M" {if $data_row.gender != ""}checked{/if} id="customergender">&nbsp;Male
                <input name="customergender" type="radio" required class="ajx-control" value="F" {if $data_row.gender != ""}checked{/if} id="customergender">&nbsp;Female
            </div>
        </div>

    </div><!-- /.box-body -->
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left modal_close" data-dismiss="modal">Close</button>
        {literal}
            <button type="button" class="btn btn-primary" onclick='trigger_form({"frm":"frm-customers","ajxcallback":function(resdata){action_response(resdata);}})'>Save changes</button>
        {/literal}
    </div>
</form>
<script>
    {literal}
    /*Ajax form submit callback*/
    function action_response(resdata){

        if( typeof(resdata) != "undefined"){

            if( resdata.resultStatus ==  "Success"){
                //parent.jQuery("#modal_add_edit").modal("hide");
                cleanup_ajax_form({"frm":"frm-customers"});
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