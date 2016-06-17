<!DOCTYPE html>
<!--
BeyondAdmin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 1.5.0
Purchase: https://wrapbootstrap.com/theme/beyondadmin-adminapp-angularjs-mvc-WB06R48S4
-->
<style>
.customer-label{
   width:100px;
}
.customer-feedback{
   padding-bottom:7px; 
}
</style>
			<div class="col-lg-12 col-md-12">
               <div class="well">
                 <div class="well-body">
				  <div class="row">
				  <div class="col-lg-12 col-md-12">
				  <div class="row">
				  <div class="col-lg-8 col-md-8">
					
					 <form role="form" class="form-inline">
						
						<div class="row customer-feedback">
						 
						   <div class="col-lg-12 col-md-12">
							  <div class="form-group">
								 <label for="activity_module" class="customer-label">Select Module</label>
								 <input type="text" placeholder="" id="activity_module" name="activity_module" class="form-control ajx-control">
								 <button class="btn btn-default" type="submit">Search</button>
							  </div>
						   </div>
						   
						</div>
						
						<div class="row customer-feedback">
						   <div class="col-lg-12 col-md-12">
							  <div class="form-group">
								 <label for="activity_date" class="customer-label">Date</label>
								 
								 <label for="activity_to_date">To</label>
								 <input type="text" id="activity_to_date" name="activity_to_date" class="form-control ajx-control">
								 
								 <label for="activity_form_date">From</label>
								 <input type="text" id="activity_from_date" name="activity_from_date" class="form-control ajx-control">
							   </div>
						   </div>
						
						</div>
					 </form>
			         </div>
					 <div class="col-lg-4 col-md-4">
					 <div class="pull-right">
						<a class="btn btn-blue shiny" href="#" data-toggle="modal" data-target=".bs-example-modal-lg">Add New Item</a>
						
					<!--	<a href="javascript:void(0);" class="btn btn-default btn-lg shiny icon-only blue" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus"></i></a>-->
						
					 </div>
					 </div>
				    </div>
				  </div>
				  </div>
				<div class="clearfix"></div>	
				<hr class="wide">
                <div class="flip-scroll">
                  <table class="table table-bordered table-striped table-condensed flip-content">
                    <thead class="flip-content bordered-palegreen">
                        
                     <tr>
                        <th> Date & Time </th>
						<th> User </th>
						<th> IP </th>
                        <th> Activity Remark</th>
                       
                      </tr>
                      
                     
                      
                    </thead>
                    
                    <tbody>
                      <tr>
                        <td> AAC </td>
                        <td> AUSTRALIAN AGRICULTURAL COMPANY LIMITED. </td>
                        <td class="numeric"> $1.38 </td>
                        <td class="numeric"> -0.01 </td>
                       
						
                       </tr>
                    
                    </tbody>
                  </table>
					<div class="clearfix"></div>
					<br>
					<div class="pull-right">
						<ul class="pagination">
							<li class="disabled"><a href="#">«</a></li>
							<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li><a href="#">»</a></li>
						</ul>
					</div>
					<div class="clearfix"></div>

                </div>
			  </div>
            </div>
          </div>
        

<!--LArge Modal Templates-->
<!--<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">Partner</h4>
			</div>
			<div class="modal-body">
				
			<form role="form" id="partnerform" name="partnerform" action="{$ADMIN_PATH}/partners" enctype="multipart/form-data">
				
			   <div class="form-title">
					Partner
			   </div>
			   <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="title_input">Title</label>
						   <input type="text" id="partners_title" name="partners_title" placeholder="Enter Title" class="form-control ajx-control">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="image_upload">Image</label>
						   <input type="file" id="partners_image" name="partners_image" class="ajx-control">
						</div>
					</div>
			   </div>
			   <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="short_description">Short Description</label>
						   <textarea name="partners_short_description" id="partners_short_description" class="form-control ajx-control"></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
						   <label for="status_input">Status</label>
						   <input type="text" id="partners_status" name="partners_status" placeholder="status" class="form-control ajx-control">
						</div>
					</div>
			   </div>
			   
			  
			   <button class="btn btn-blue" type="submit">Update</button>
			   </form>
			</div>
		</div>
	</div>
</div>
-->
