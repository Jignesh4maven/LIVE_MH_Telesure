<!DOCTYPE html>
<html>
  {include file="$T_HEADER"}
  <script>
  var http_path = "{$HTTP_PATH}";
  </script>
  
  <body class="hold-transition skin-blue">
 
        <!-- Main content -->
        <section class="content">
				{include file="$T_BODY"}
		</section><!-- /.content -->
 
  <!-- add for tab popup-->
  
  <script src="{$TEMPLATE_JS}bootstrap.min.js"></script>
 
 
 
  <!-- FastClick -->
  <script src="{$TEMPLATE_PLUGINS}fastclick/fastclick.min.js"></script>
  <!-- AdminLTE App -->
   <!-- <script src="{$TEMPLATE_JS}app.min.js"></script>-->
    <!-- Sparkline -->
    <script src="{$TEMPLATE_PLUGINS}sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="{$TEMPLATE_PLUGINS}jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{$TEMPLATE_PLUGINS}jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{$TEMPLATE_PLUGINS}slimScroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <!--<script src="{$TEMPLATE_PLUGINS}chartjs/Chart.min.js"></script>-->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--<script src="{$TEMPLATE_JS}pages/dashboard2.js"></script>-->
    <!-- AdminLTE for demo purposes -->
  <!--  <script src="{$TEMPLATE_JS}demo.js"></script>-->
  	<script src="{$COMMON_SCRIPTS}functions.js"></script>
	<!-- Frontend Validator -->
    <script src="{$COMMON_SCRIPTS}/validator.js"></script>

	 <!--Bootstrap Date Picker-->
	<script src="{$TEMPLATE_PLUGINS}datetime/bootstrap-datepicker.js"></script>
	
	
	<script>
	$('.date-picker').datepicker(); 
	</script>
    <!-- end-->
	
  </body>
</html>
