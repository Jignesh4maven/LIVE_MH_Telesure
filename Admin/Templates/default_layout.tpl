<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
{include file="$T_HEADER"}
<!-- for padding body Added by laxman-->
<style>
.body-padding{
  padding-right: 0px !important;
}
</style>
<!-- end--->
<!-- Body -->
<body class="body-padding">

  <div class="loading-container">
	<div class="loader"></div>
  </div>

  {include file="$T_TOP"}
 
  <div class="main-container container-fluid">
	
	<div class="page-container">
	 {include file="$T_LEFT"}
	
	  <div class="page-content">
		
		<div class="page-breadcrumbs">
		  <ul class="breadcrumb">
			<li> <i class="fa fa-home"></i> <a href="#">Home</a> </li>
			<li class="active">{$page_name}</li>
		  </ul>
		</div>
	
		<!--<div class="page-header position-relative">
		  <div class="header-title">
			<h1> {$page_name} </h1>
		  </div>
		</div>-->
		
		<div class="page-body">
		  <div class="row">
			  {include file="$T_BODY"}
			</div>
		</div>
	  </div>
		
	</div>
	
  </div>

</div>

<!--Basic Scripts-->
<script src="{$TEMPLATE_JS}jquery.min.js"></script>
<script src="{$TEMPLATE_JS}bootstrap.min.js"></script>
<script src="{$TEMPLATE_JS}slimscroll/jquery.slimscroll.min.js"></script>

<script src="{$TEMPLATE_JS}beyond.js"></script>

 <!--Bootstrap Date Picker-->
<script src="{$TEMPLATE_PLUGINS}datetime/bootstrap-datepicker.js"></script>

<script src="{$TEMPLATE_PLUGINS}fastclick/fastclick.min.js"></script>
  <!-- Sparkline -->
<script src="{$TEMPLATE_PLUGINS}sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{$TEMPLATE_PLUGINS}jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{$TEMPLATE_PLUGINS}jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="{$COMMON_SCRIPTS}bootbox/bootbox.min.js"></script>

<!-- common script-->
<script src="{$COMMON_SCRIPTS}validator.js"></script>
<script src="{$COMMON_SCRIPTS}functions.js"></script>
<script src="{$COMMON_SCRIPTS}jquery.jpager.js"></script>
<!-- for msg box-->  
<link href="{$COMMON_SCRIPTS}msgGrowl/msgGrowl.css" type="text/css" rel="stylesheet" />
<script src="{$COMMON_SCRIPTS}msgGrowl/msgGrowl.js"></script>

<script>
   $('.date-picker').datepicker(); 
</script>
<script>
        // If you want to draw your charts with Theme colors you must run initiating charts after that current skin is loaded
        $(window).bind("load", function () {

            /*Sets Themed Colors Based on Themes*/
            themeprimary = getThemeColorFromCss('themeprimary');
            themesecondary = getThemeColorFromCss('themesecondary');
            themethirdcolor = getThemeColorFromCss('themethirdcolor');
            themefourthcolor = getThemeColorFromCss('themefourthcolor');
            themefifthcolor = getThemeColorFromCss('themefifthcolor');

        });

</script>


</body>
<!--  /Body -->
</html>
