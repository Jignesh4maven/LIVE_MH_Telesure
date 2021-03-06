<div id="modulename" data-modulename="test"></div>
<div class="row">
<div class="col-xs-12"></div>
<div class="col-xs-12">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"> {$page_name}</h3>
        <button type="button" id="addnew" class="btn btn-primary btn-flat pull-right" onclick="_add();">Add New</button>
      </div><!-- /.box-header -->
  </div>
  <div class="box">
	  <div class="box-body table-responsive no-padding">
        {include file="$T_PAGER"}
	     <table class="table table-hover table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Page Name</th>
              <th>Date</th>
              <th>Priority</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            
            </thead>
            <tbody id="data-list">
            {foreach from=$load_result key=k item=v}
            <tr id="row_{$v.id}">
              <td>{$v.id}</td>
              <td>{$v.name}</td>
              <td>{$v.date}</td>
              <td>{$v.display_order}</td>
              <td><span class="label label-success">{$v.status}</span></td>
              <td>
                <button class="btn btn-primary btn-sm btn-flat" data-module="blog" data-action="edit"  onclick="_edit('{$v.id}',this)">Edit</button>
                <button class="btn btn-danger btn-sm btn-flat"  data-module="blog" data-action="delete" onclick="delete_row_by_id('{$v.id}',this)">Delete</button>
              </td>
            </tr>
            {/foreach}
            </tbody>
       </table>
	  </div>	
   </div>
</div>
</div>
	 

<script>
var load_result_json    = {$load_result_json};
var total_record        = {$total_record};
var entries_per_page 	= 5;
var admin_alias = "{$ADMIN_ALIAS}";
{literal}
// get_record function is moved to common files
var module_properties = {};
module_properties["blog"] = {
	"template_id":"data-list","template_place_id":"data-list",
	"total_record":total_record,"entries_per_page":entries_per_page,
	"func_data_list_records":"get_data_records",
	"place_id":"data-list","template_id":"data-list"};
								
/*Pagination initialization */
jQuery(document).ready(function(){
 jQuery('.jPager').jPager({
        counts : total_record,
        callback: function (objpage) {
            smart_get_regord(objpage.pageno,objpage.pagesize);
        }
    });
});

/*Ajax call for pagination*/	

/*Refresh first page list on operations*/
/*pagesize,ajxdata,place_id,template_id,module name,*/
function refresh_list(){
	var pagesize = $("select[data-pager-action='pagesize']").val();
	var ajx_param = {	
        "url": "blog",
        "sync": "false",
        "method": "POST",
        "data": { page: 1, entries_per_page: pagesize, opcode:'get_data_records' },
        "ajxcallback":function(resobj){
			var dataobj = {"res":resobj,"place_id":"data-list","template_id":"data-list"};
			set_datalist(dataobj);
			total_record = resobj.resultData['total'];
			jQuery('.jPager').jPager({
				counts : total_record,
				callback: function (objpage) {
					smart_get_regord(objpage.pageno,objpage.pagesize);
				}
			});
		}
    };
    call_ajax(ajx_param);
	
}

function _add(){
	modal_params = {"id":"add_edit_","modal_dialog_size" : "modal-lg",
					"iframe":http_path+"/"+admin_alias+"/test?opcode=form_add_edit&popup",
					"title":"Add New test","width":"100%","height":"420px",
				};	
	open_modal(modal_params);
}

function _edit(id,el){
 
	modal_params = {"id":"add_edit_"+id,"modal_dialog_size" : "modal-lg",
					"iframe":http_path+"/"+admin_alias+"/test?opcode=form_add_edit&popup&blog_id="+id,
					"title":"Update test","width":"100%","height":"420px",
				};	
	open_modal(modal_params);
}
{/literal}
</script>
    