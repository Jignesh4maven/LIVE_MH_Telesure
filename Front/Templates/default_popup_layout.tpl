<!DOCTYPE html>
<html>
  {include file="$T_HEADER"}
  <style>
	.modal-body.login-body .col-md-6 {
	  float: left;
	  width: 50%;
	}
  </style>
  <body class="hold-transition skin-blue ">
 
        <!-- Main content -->
        <section class="content">
				{include file="$T_BODY"}
		</section><!-- /.content -->
		
        <!-- Bootstrap CSS -->
        <link href="{$TEMPLATE_CSS}/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="{$TEMPLATE_CSS}/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />
		
        <!-- Custom CSS -->
        <link href="{$TEMPLATE_CSS}/custom.css" type="text/css" rel="stylesheet" />
        <link href="{$TEMPLATE_CSS}/responsive.css" type="text/css" rel="stylesheet" />		
		<link href="{$COMMON_SCRIPTS}msgGrowl/msgGrowl.css" type="text/css" rel="stylesheet" />
		
        <!-- FontAwesome CSS -->
        <link href="{$TEMPLATE_CSS}/font-awesome.min.css" type="text/css" rel="stylesheet" />
        <script src="{$TEMPLATE_JS}/jquery.min.js"></script>
        <script src="{$TEMPLATE_JS}/bootstrap.min.js"></script>
        <script src="{$TEMPLATE_JS}/bootstrap-select.js"></script>
		
		<script src="{$COMMON_SCRIPTS}msgGrowl/msgGrowl.js"></script>
        <script src="{$COMMON_SCRIPTS}validator.js"></script>
        <script src="{$COMMON_SCRIPTS}functions.js"></script>
		
  </body>
</html>
