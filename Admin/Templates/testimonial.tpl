<div id="modulename" data-modulename="testimonial"></div>
<div class="col-xs-12 col-md-12">
               <div class="well">
                 <div class="well-body">
			        <div>
					<div class="pull-left">
					
					 <form role="form"  id="frm_search" name="frm_search" class="form-inline" action="{$ADMIN_ALIAS}/testimonial" data-before="validate_search()">
						<input type="hidden" name="opcode" value="{$form_action}" class="ajx-control" />
						<input type="hidden" name="action" value="search" class="ajx-control" />
						<input type="hidden" id="srch_entries_par_page" name="srch_entries_par_page" value="" class="ajx-control" /> 
						<div class="form-group">
							<!--<label for="exampleInputEmail2" class="sr-only">Title</label>-->
						   <input type="text" placeholder="Enter Title" id="srch_testimonial_title"  name="srch_testimonial_title" class="form-control ajx-control">
						   <select name="search_testimonial_status" id="search_testimonial_status" class="form-control ajx-control" >
								<option value="" disabled="disabled" selected="selected">Select Status</option>
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option> 
						   </select>  
						</div>
						{literal}
						<button type="button" class="btn btn-primary btn-flat margin-top" onclick='_search(this)'>Search</button>
						<button type="button" class="btn btn-primary btn-flat margin-top" id="srch_all" onclick='_show_all(this)'>Show All</button>
						{/literal}
					</form>
					
					</div>
					<div class="pull-right">
						<a class="btn btn-blue shiny" href="#" data-toggle="modal" data-target=".bs-example-modal-sm"  onclick="_add();">Add New</a>
					
					</div>
				    </div>
				<div class="clearfix"></div>	
				<hr class="wide">
                <div class="flip-scroll">
				 
                  <table class="table table-bordered table-striped table-condensed flip-content">
                    <thead class="flip-content bordered-palegreen">
                        
                      <tr>
                        <th>Title</th>
                        <th class="col-center" width="10%">Status</th>
                      <!--  <th class="col-center">Order</th>-->
                      <!--  <th>Created By</th>-->
                       <!-- <th class="col-center">Created On</th>-->
                       <!-- <th>Modified By</th>-->
                        <th colspan="2" class="col-center" width="12%">Action</th>
                      </tr>
                    
                    </thead>
                    
                    <tbody id="data-list">
				    {foreach from=$load_result key=k item=v}
                     <tr id="row_{$v.id}">
                        <td> {$v.title} </td>
						<td class="col-center">
						{if $v.status=='Active'}
							  <span class="success"> {$v.status} </span>
						{else}
							  <span class="danger"> {$v.status} </span>
						{/if}
						</td>
                      <!--  <td class="col-center"> {$v.display_order} </td>-->
                      <!--  <td> {$v.createdby} </td>-->
                       <!-- <td class="col-center"> {$v.date}</td>-->
                      <!--  <td> {$v.modifiedby}</td>-->
                       
						<td class="col-center">
						  <button class="btn btn-primary btn-sm btn-flat" data-module="testimonial" data-action="edit"  onclick="_edit('{$v.id}',this)">Edit</button>
						
						  <button class="btn btn-danger btn-sm btn-flat"  data-module="testimonial" data-action="delete" onclick="delete_row_by_id('{$v.id}',this)">Delete</button>
						  <!-- <a class="btn btn-danger btn-xs delete" href="#"><i class="fa fa-trash-o"></i> Delete</a>-->
						</td>
                     </tr>
                    {/foreach}
                    </tbody>
                  </table>
				  <hr class="wide">
				  {include file="$T_PAGER"}
				   
				  <script data-tmpl="data-list" type="text/html">
				  <tr id="row_<@=id@>">
					 <td><@=title@></td>
					 <td class="col-center">
						 <span class="<@=status_class[status]@>"> <@=status@> </span>
					 </td>
					 <!--<td class="col-center"><@=display_order@></td>-->
					<!-- <td><@=createdby@></td>-->
					<!-- <td class="col-center"><@=date@></td>-->
					<!-- <td><@=modifiedby@></td>-->
					 <td class="col-center">
						<button class="btn btn-primary btn-sm btn-flat" data-module="testimonial" data-action="edit" onclick="_edit('<@=id@>',this)">Edit</button>
					 
						<button class="btn btn-danger btn-sm btn-flat"  data-module="testimonial" data-action="delete" onclick="delete_row_by_id('<@=id@>',this)">Delete</button>
					 </td>
				  </tr>
				  </script>
					<div class="clearfix"></div>
					<br>
					
					<div class="clearfix"></div>

                </div>
			  </div>
            </div>
          </div>
        

 
<script>
var load_result_json    = {$load_result_json};
var total_record        = {$total_record};
var entries_per_page 	= 10;
var admin_path 			= "{$ADMIN_PATH}";
var admin_alias 		= "{$ADMIN_ALIAS}";

{literal}
/* for tmpl for data change*/
var status_class		= {"Active":"success","Inactive":"danger"};

/* for getting limit for search from hidden field*/
function validate_search() {
   $("#srch_entries_par_page").val($("select[data-pager-action='pagesize']").val());
   
}

function _search(el){
	 
	$(el).addClass("spin-loader");		   
	trigger_form({	"frm":"frm_search",
					"ajxcallback":function(resdata){
						search_response(resdata);
						$(el).removeClass("spin-loader");
					}
				})
}

function _show_all(el){
   $(el).addClass("spin-loader");		   
   $("#srch_testimonial_title").val("");
   $("#search_testimonial_status").val("");
   trigger_form({	"frm":"frm_search",
					"ajxcallback":function(resdata){
						search_response(resdata);
						$(el).removeClass("spin-loader");
					}
				 });
}

function _add(){
	modal_params = {"id":"add_edit_","modal_dialog_size" : "modal-lg",
					"iframe":admin_path+"testimonial?opcode=form_add_edit&popup",
					"title":"Testimonial","width":"100%","height":"450px",
				};	
	open_modal(modal_params);
}

function _edit(id,el){
 
	modal_params = {"id":"add_edit_"+id,"modal_dialog_size" : "modal-lg",
					"iframe":admin_path+"testimonial?opcode=form_add_edit&popup&testimonial_id="+id,
					"title":"Update Testimonial","width":"100%","height":"450px",
				};	
	open_modal(modal_params);
}

// get_record function is moved to common files
var module_properties = {};
module_properties["testimonial"] = {
	"template_id":"data-list","template_place_id":"data-list",
	"total_record":total_record,"entries_per_page":entries_per_page,
	"func_data_list_records":"get_data_records","search_controlls":['srch_testimonial_title','search_testimonial_status'],
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

/* opeartion  like insert,update,delete effect you can see*/
function refresh_list(){
	var pagesize = $("select[data-pager-action='pagesize']").val();
	var ajx_param = {	
        "url": "testimonial",
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

 /* searching data */
 function search_response(resdata){
	console.log(resdata);
	total_record =  resdata['resultData']['total'];
	var dataobj = {"res":resdata,"template_place_id":"data-list","template_id":"data-list"};
	set_datalist(dataobj);
	jQuery('.jPager').jPager({
        counts : total_record,
        callback: function (objpage) {
            smart_get_regord(objpage.pageno,objpage.pagesize);
        }
    });  
}
//for display all button



{/literal}
</script>
