<!-- Footer -->
<footer>
    <div class="mob-footer hidden-md hidden-lg">
        <ul class="list-unstyled">
            <li><a href="#">Service Plan</a></li>
            <li><a href="#">Maintenance Plan</a></li>
            <li><a href="#">Extended Warranties</a></li>
            <li><a href="#">Car Insurance</a></li>
        </ul>
    </div>
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-5 hidden-xs hidden-sm">
                    <h4>Products</h4>
                    <ul class="list-inline product-icon">
                        <li><a class="ico ico-service" href="#">Service Plan</a></li>
                        <li><a class="ico ico-maintenance" href="#">Service Plan</a></li>
                        <li><a class="ico ico-warranty" href="#">Service Plan</a></li>
                        <li><a class="ico ico-car-insurance" href="#">Service Plan</a></li>
                        <li><a class="ico ico-assistance" href="#">Service Plan</a></li>
                    </ul>
                </div>
                <div class="col-md-4 hidden-xs hidden-sm">
                    <h4>Company</h4>
                    <ul class="list-inline footer-company">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">News Room Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 mob-center text-right">
                    <h4>Connect with us</h4>
                    <ul class="list-inline footer-social">
                        <li><a class="ico ico-facebook" href="#"></a></li>
                        <li><a class="ico ico-twitter" href="#"></a></li>
                    </ul>
                    <span class="ph-no">0861 642 779</span>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <span class="copy-right">Copyright &copy;LiquidCapital. All right reserved.</span>
                    <ul class="list-inline footer-company">
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Disclaimer</a></li>
                        <li><a href="#">MotorHappy PAIA</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Conflict of Interest Policy</a></li>
                        <li><a href="#">Sitemap</a></li>
                    </ul>
                    <div class="footer-address">
                        <address>
                            MotorHappy (Pty) Ltd, an Authorised Financial Services Provider FSP 46123.<br>
                            140 Boeing Road East, Elma Park, Edenvale, 1609.<br>
                            PO Box 851, Edenvale, 1610, Gauteng, South Africa.
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
{literal}
<script>
    $(document).ready(function(){
        $("#mob-menu-open").click(function(){
            $(".main-menu-wrap").css("left", 0);
        });
        $("#mob-menu-close").click(function(){
            $(".main-menu-wrap").css("left", "-100%");
        });
        $(".search-btn").click(function(){
            $(".search-text").css({"width":"100%", "padding":"0 15px"});
        });
    });
</script>
{/literal}