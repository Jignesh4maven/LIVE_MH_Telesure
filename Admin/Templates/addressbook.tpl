<div class="row">
<div class="col-xs-12">
    
    <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"> {$page_name}</h3>
      <button type="button" id="addnew" class="btn btn-primary btn-flat pull-right" onclick="add_page();">Add New</button>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" name="frm_search" id="frm_search">
	  <input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
	  <input type="hidden" name="action" value="search" class="ajx-control" />
      <div class="box-body">
        <div class="form-group col-xs-4 no-padding">
          <label for="txtname">Name</label>
          <input type="txtname" class="form-control ajx-control" name="txtname" id="txtname" placeholder="Type page name">
        </div>
       
       <div class="form-group col-xs-4 no-padding">
         {literal}
        <button type="button" class="btn btn-primary btn-flat margin-top" onclick='trigger_form({"frm":"frm_search","ajxcallback":function(resdata){search_response(resdata);}})'>Search</button>
		{/literal}
       </div>
        
      </div><!-- /.box-body -->
    </form>
  </div><!-- /.box -->

  
  <div class="box">
     
    <div class="box-body table-responsive no-padding">
        {include file="$T_PAGER"}
        <table class="table table-hover table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Action</th>
            </tr>
            
            </thead>
            <tbody id="data-list">
            {foreach from=$load_result key=k item=v}
            <tr id="row_{$v.id}">
              <td>{$v.id}</td>
              <td>{$v.name}</td>
              <td>{$v.phone}</td>
              <td>{$v.address}</td>
              <td>
                <button class="btn btn-primary btn-sm btn-flat" onclick="edit_page('{$v.id}')">Edit</button>
                <button class="btn btn-danger btn-sm btn-flat" onclick="delete_page('{$v.id}')">Delete</button>
              </td>
            </tr>
            {/foreach}
            </tbody>
       </table>
    
        <script data-tmpl="data-list" type="text/html">
		<tr id="row_<@=id@>">
            <td><@=id@></td>
            <td><@=name@></td>
            <td><@=phone@></td>
			<td><@=address@></td>
            <td><span class="label label-success">Active</span></td>
            <td>
              <button class="btn btn-primary btn-sm btn-flat" onclick="edit_page('<@=id@>')">Edit</button>
              <button class="btn btn-danger btn-sm btn-flat" onclick="delete_page('<@=id@>')">Delete</button>
            </td>
        </tr>
		</script>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>
</div>
<script>
var load_result_json    = {$load_result_json};
var total_record        = {$total_record};

{literal}
/*Pagination initialization */
jQuery(document).ready(function(){
 jQuery('.jPager').jPager({
        counts : total_record,
        callback: function (objpage) {
            get_regord(objpage.pageno,objpage.pagesize);
        }
    });
});

/*Ajax call for pagination*/	
function get_regord(page, limit){
    var ajx_param = {	
        "url": "pages",
        "sync": "false",
        "method": "POST",
        "data": { page: page, entries_per_page: limit, opcode:'get_list' },
        "ajxcallback":function(resobj){
            set_datalist(resobj);
		}
    };
    call_ajax(ajx_param);
}

/*Prepare data-list*/
function set_datalist(res){
            
    if( res ){

        if( res['resultData'] ){

            var rows = res['resultData']['list'];

            jQuery("#data-list").html('');

            for(var i = 0; i < rows.length; i++){

                jQuery("#data-list").jTmpl("data-list", rows[i],'append');

            }
        }
    }

}

/* form validation */
function validate(){
    alert("validated");
    return true;
}

/*Refresh first page list on operations*/
function refresh_list(){
    jQuery("#add-roomtype").modal('hide');
    var pagesize = $("select[data-pager-action='pagesize']").val();
    //get_regord(1,pagesize);
	
	var ajx_param = {	
        "url": "pages",
        "sync": "false",
        "method": "POST",
        "data": { page: 1, entries_per_page: pagesize, opcode:'get_list' },
        "ajxcallback":function(resobj){
            set_datalist(resobj);
			total_record = resobj.resultData['total'];
			jQuery('.jPager').jPager({
				counts : total_record,
				callback: function (objpage) {
					get_regord(objpage.pageno,objpage.pagesize);
				}
			});
		}
    };
    call_ajax(ajx_param);
	
}

/*Add page modal*/
function add_page(){
	modal_params = {"id":"add_edit_","modal_dialog_size" : "modal-lg",
					"iframe":"pages&opcode=add_edit&popup",
					"title":"Add New Page","width":"100%","height":"420px",};	
	open_modal(modal_params);
}

function edit_page(id){
	modal_params = {"id":"add_edit_"+id,"modal_dialog_size" : "modal-lg",
					"iframe":"pages&opcode=add_edit&popup&page_id="+id,
					"title":"Add New Page","width":"100%","height":"420px",
				};	
	open_modal(modal_params);
}

function delete_page(id){
	
	if ( id != "" ) {
		var ajx_param = {
			"url": "pages",
			"sync": "false",
			"method": "POST",
			"data": { 'opcode':'delete','page_id': id},
			"ajxcallback":function(resobj){
				if ( resobj.resultStatus == "Success" ) {
					jQuery("#row_"+id).remove();
					refresh_list();
				}
			}
		};
		call_ajax(ajx_param);
	}
	
}

function search_response(resdata){
	
	total_record =  resdata['resultData']['total'];
	set_datalist(resdata);
	jQuery('.jPager').jPager({
        counts : total_record,
        callback: function (objpage) {
            get_regord(objpage.pageno,objpage.pagesize);
        }
    });  
}

{/literal}
</script>
    