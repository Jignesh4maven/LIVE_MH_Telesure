<div class="page-sidebar" id="sidebar">
    <div class="sidebar-header-wrapper"> </div>
      <ul class="nav sidebar-menu">
      
          <li class="active"> <a href="{$ADMIN_PATH}dashboard"> <i class="menu-icon glyphicon glyphicon-home"></i> <span class="menu-text"> Dashboard </span> </a> </li>
         
          <li class="active open"> <a href="#" class="menu-dropdown"> <i class="menu-icon fa fa-desktop"></i> <span class="menu-text"> General </span> <i class="menu-expand"></i> </a>
            <ul class="submenu">
              <li id="pages"> <a href="{$ADMIN_PATH}pages"> <span class="menu-text">Pages</span> </a> </li>
              <li id="testimonial"> <a href="{$ADMIN_PATH}testimonial"> <span class="menu-text">Testimonial</span> </a> </li>
              <li id="social"> <a href="{$ADMIN_PATH}social"> <span class="menu-text">Social</span> </a> </li>
              <!--<li id="mhbuzz"> <a href="{$ADMIN_PATH}mhbuzz"> <span class="menu-text">Latest Buzz/MH Buzz</span> </a> </li>-->
              <li id="partners"> <a href="{$ADMIN_PATH}partners"> <span class="menu-text">Partners</span> </a> </li>
              <li id="banner"> <a href="{$ADMIN_PATH}banner"> <span class="menu-text">Banner/Gallery</span> </a> </li>
            <!--  <li id="plans"> <a href="{$ADMIN_PATH}plans"> <span class="menu-text">Plans</span> </a> </li>-->
            </ul>
          </li>
          <li class="active open"> <a href="#" class="menu-dropdown"> <i class="menu-icon fa fa-desktop"></i> <span class="menu-text"> Motoring Plans </span> <i class="menu-expand"></i> </a>
            <ul class="submenu">
              <li id="plan_type"> <a href="{$ADMIN_PATH}plantype"> <span class="menu-text">Plan Types</span></a> </li>
              <li id="plans"> <a href="{$ADMIN_PATH}plans"> <span class="menu-text">Plans</span> </a> </li>
              <li id="plans"> <a href="{$ADMIN_PATH}planoption"> <span class="menu-text">Plan Options</span> </a> </li>
            </ul>
          </li>
          <li class="active open"> <a href="#" class="menu-dropdown"> <i class="menu-icon fa fa-newspaper-o"></i> <span class="menu-text"> MH Buzz </span> <i class="menu-expand"></i> </a>
            <ul class="submenu">
              <li id="buzz_category"> <a href="{$ADMIN_PATH}buzzcategory"> <span class="menu-text">Buzz Category</span></a> </li>
              <li id="buzz"> <a href="{$ADMIN_PATH}mhbuzz"> <span class="menu-text">Latest Buzz</span> </a> </li>
              <li id="buzz_subscriber"> <a href="{$ADMIN_PATH}subscriber"> <span class="menu-text">Subscribers</span> </a> </li>
            </ul>
          </li>
          
          <li class="active open"> <a href="#" class="menu-dropdown"> <i class="menu-icon fa fa-newspaper-o"></i> <span class="menu-text"> Job At MH </span> <i class="menu-expand"></i> </a>
            <ul class="submenu">
              <li id="job_positions"> <a href="{$ADMIN_PATH}positions"> <span class="menu-text">Positions</span></a> </li>
              <li id="job_applications"> <a href="{$ADMIN_PATH}applications"> <span class="menu-text">Job Applications</span> </a> </li>
            </ul>
          </li>
          
          <!--li id="activitylog"> <a href="{$ADMIN_PATH}activitylog"> <i class="menu-icon glyphicon glyphicon-list-alt"></i> <span class="menu-text">Activity Log</span> </a> </li>
          <li> <a href="#"> <i class="menu-icon glyphicon glyphicon-cog"></i> <span class="menu-text">Setting</span> </a> </li-->
      </ul>
</div>

<script>
  $(document).ready( function(){
    
  });
 
     $('ul .sidebar-menu li').click(function (){
        
         $('.nav li.active').removeClass('active');
          var $this = $(this);
          $this.addClass('active');
          e.preventDefault();
       
     });
 
</script>

      