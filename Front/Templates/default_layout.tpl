<!DOCTYPE html>
<html lang="en">
{nocache}
  {include file="$T_HEADER"}
  <body>
  <script type='text/javascript'>
(function (d, t) {
  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
  bh.type = 'text/javascript';
  bh.src = 'https://www.bugherd.com/sidebarv2.js?apikey=zqitlrgpnx4a3foixykehg';
  s.parentNode.insertBefore(bh, s);
  })(document, 'script');
</script>

  <!-- header -->
  <header>
	<script>
	var http_path = "{$HTTP_PATH}";
    var login_user = "{$user}";
	</script>
      <div class="container">
          <div class="row">
              <div class="col-md-3 col-lg-3 col-sm-5 col-xs-7">
                  <a href="#" id="mob-menu-open" class="hidden-lg hidden-md"><i class="mob-menu-bar"></i></a>
                  <a href="/"><img src="{$TEMPLATE_IMAGES}logo.jpg" alt="Motor Happy" class="img-responsive hidden-xs hidden-sm" /></a>
                  <a href="/"><img src="{$TEMPLATE_IMAGES}logo-mobile.jpg" alt="Motor Happy" class="img-responsive mobile-logo hidden-md hidden-lg" /></a>
              </div>
              <div class="col-md-6 col-sm-7 col-lg-5 col-xs-5 pos-inherit col-md-offset-3 col-lg-offset-4 clearfix">
                  <div class="header-login mobile-login-right clearfix">
                      <div class="login-icon pull-left">
                          <ul class="list-inline">
                              <li>
								{if $user eq 'Guest' || $user eq ''}
								<a class="ico ico-login" href="javascript:signin_popup()"></a>
								{else}
									<a class="" href="{$HTTP_PATH}/logout/">Logout</a>
								{/if}
							  
							  </li>
                              <li><a class="ico ico-signup" href="#"></a></li>
                              <li><a class="ico ico-cart" href="#"></a></li>
                          </ul>
                      </div>
                      <div class="search-box pull-right">
                          <input type="text" class="form-control search-text" placeholder="Search" />
                          <button class="btn search-btn"><i class="ico ico-search"></i></button>
                      </div>
                       
                  </div>
              </div>
          </div>
      </div>
  </header>
  <!-- end header -->
    <div class="clearfix"></div>
    <!-- Main menu -->
	
    {include file="$T_TOP"}

    <!-- end Main Menu -->
   
    <div class="clearfix"></div>
    <!-- Steps -->
    {include file="$T_BODY"}
    <!-- End Steps -->
    <div class="clearfix"></div>
    
	{include file="$T_FOOTER"}
	
</body>
{/nocache}
</html>