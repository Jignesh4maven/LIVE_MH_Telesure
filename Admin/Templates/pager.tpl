<style>
.jPager span {
	color: #fff;
}
</style>
<div class="clearfix cust-pagination">
	<div class="col-xs-12 jPager no-padding"> 
		<div class="input-group  pull-right"> 
		<button class="pagin-ctr btn btn-primary btn-flat pull-left" data-pager-action='first'><i class="fa fa-angle-left"></i> First</button>
		<button class="pagin-ctr btn btn-primary btn-flat pull-left" data-pager-action='previous'><i class="fa fa-angle-double-left"></i> Previous</button>
			<input type="text" class="pagin-ctr form-control" style="width:100px" data-pager-action='pagenum' />
			<button class="pagin-ctr btn btn-primary btn-flat pull-left" data-pager-action='next'><i class="fa  fa-angle-double-right"></i> Next</button>
			<button class="pagin-ctr btn btn-primary btn-flat pull-left" data-pager-action='last'><i class="fa  fa-angle-right"></i> Last</button>
		</div>
		<div class="input-group  col-lg-7">
			<div class="col-lg-4">
				<label> Records Per Page </label>
			</div>
			<div class="col-lg-3">
				<select class="form-control" data-pager-action='pagesize'>
					<option value="2"> 2 </option>
					<option value="5"> 5 </option>
					<option value="10" selected="selected"> 10 </option>
					<option value="15"> 15 </option>
					<option value="20"> 20 </option>
					<option value="25"> 25 </option>
					<option value="50"> 50 </option>
					<option value="100"> 100 </option>
				</select>
			</div>
		</div>
	</div>
</div>			