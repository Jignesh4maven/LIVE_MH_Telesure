<!DOCTYPE html>
<!--
BeyondAdmin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 1.5.0
Purchase: https://wrapbootstrap.com/theme/beyondadmin-adminapp-angularjs-mvc-WB06R48S4
-->

			<div class="col-xs-12 col-md-12">
               <div class="well">
                 <div class="well-body">
			        <div>
					<div class="pull-left">
					
					<form role="form" class="form-inline">
						<div class="form-group">
							<label for="exampleInputEmail2" class="sr-only">Field 1</label>
							<input type="text" placeholder="Enter Field 1" id="exampleInputEmail2" class="form-control">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword2" class="sr-only">Field 2</label>
							<input type="text" placeholder="Enter Field 2" id="exampleInputPassword2" class="form-control">
						</div>
						<button class="btn btn-default" type="submit">Search</button>
					</form>
					
					</div>
					<div class="pull-right">
						<a class="btn btn-blue shiny" href="#" data-toggle="modal" data-target=".bs-example-modal-sm">Add New Item</a>
						
						<a href="javascript:void(0);" class="btn btn-default btn-lg shiny icon-only blue" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus"></i></a>
						
					</div>
				    </div>
				<div class="clearfix"></div>	
				<hr class="wide">
                <div class="flip-scroll">
                  <table class="table table-bordered table-striped table-condensed flip-content">
                    <thead class="flip-content bordered-palegreen">
                      <tr>
                        <th> Code </th>
                        <th> Company </th>
                        <th class="numeric"> Price </th>
                        <th class="numeric"> Change </th>
                        <th class="numeric"> Change % </th>
                        <th class="numeric"> Open </th>
                        <th class="numeric"> High </th>
                        <th class="numeric"> Low </th>
                        <th class="numeric"> Volume </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> AAC </td>
                        <td> AUSTRALIAN AGRICULTURAL COMPANY LIMITED. </td>
                        <td class="numeric"> $1.38 </td>
                        <td class="numeric"> -0.01 </td>
                        <td class="numeric"> -0.36% </td>
                        <td class="numeric"> $1.39 </td>
                        <td class="numeric"> $1.39 </td>
                        <td class="numeric"> $1.38 </td>
                        <td class="numeric"> 9,395 </td>
                      </tr>
                      <tr>
                        <td> AAD </td>
                        <td> ARDENT LEISURE GROUP </td>
                        <td class="numeric"> $1.15 </td>
                        <td class="numeric"> +0.02 </td>
                        <td class="numeric"> 1.32% </td>
                        <td class="numeric"> $1.14 </td>
                        <td class="numeric"> $1.15 </td>
                        <td class="numeric"> $1.13 </td>
                        <td class="numeric"> 56,431 </td>
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
          </div>
        </div>
   
			</div>
		</div>
	  </div>
		
	</div>
<!--LArge Modal Templates-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">New Item</h4>
			</div>
			<div class="modal-body">
				
				<form role="form" id="signupForm" name="signupForm">
				
				<div class="form-title">
					Fillup form to proceed
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" id="first_name" name="first_name" placeholder="First Name" class="form-control">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" id="phone" name="phone" placeholder="Phone" class="form-control">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<span class="input-icon icon-right">
								<input type="text" id="mobile" name="mobile" placeholder="Mobile" class="form-control">
								
							</span>
						</div>
					</div>
				</div>
				
				<button class="btn btn-blue" type="submit">Register</button>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!--End Large Modal Templates-->	
 <!--Add Item-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="mySmallModalLabel">New Item</h4>
			</div>
			<div class="modal-body">
			
			</div>
		</div>
	</div>
</div>
<!--End Item-->