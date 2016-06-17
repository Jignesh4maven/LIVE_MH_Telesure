<div class="mh-steps-wrap text-center">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="main-title">
                    <h1>Get a Car Insurance Quote in 5 easy steps</h1>
                </div>
                <div class="stepwizard">
                    <div class="steps-section-wrap clearfix stepwizard">
                        <div class="steps-number-cols text-center stepwizard-step">
                            <div class="s-number">
                                <a href="#step-1" data-step="1"  >1</a>
                            </div>
                            <h4>Personal & Driver Details</h4>
                            <p class="stepwizard-subtitle">Enter your personal details.</p>
                        </div>
                        <div class="steps-number-cols text-center stepwizard-step">
                            <div class="s-number">
                                <a href="#step-2"  data-before="load_vehicle_formfeeds()"  data-step="2">2</a>
                            </div>
                            <h4>Vehicle Details</h4>
                            <p class="stepwizard-subtitle">Insert vehicle registration number to automatically receive vehicle details or enter details manually.</p>
                        </div>
                        <div class="steps-number-cols text-center stepwizard-step">
                            <div class="s-number">
                                <a href="#step-3" data-before="load_storage_formfeeds()" data-step="3" >3</a>
                            </div>
                            <h4>Vehicle Storage Details</h4>
                            <p class="stepwizard-subtitle">Enter your address and tell us where you park your car during the day and at night.</p>
                        </div>
                        <div class="steps-number-cols text-center stepwizard-step">
                            <div class="s-number">
                                <a href="#step-4"  data-step="4" >4</a>
                            </div>
                            <h4>Results</h4>
                            <p class="stepwizard-subtitle">Receive multiple Car Insurance Quote options, tailored to your motoring needs.</p>
                        </div>
                        <div class="steps-number-cols text-center stepwizard-step">
                            <div class="s-number">
                                <a href="#step-5"  data-step="5"  data-before="load_refine_formfeeds()">5</a>
                            </div>
                            <h4>Refine and Submit</h4>
                            <p class="stepwizard-subtitle"> Refine and/or submit your chosen quote and we’ll get back to you to confirm.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade active in padding20 text-center" id="step-0" >
                    <button class="btn btn-blue start-q" onclick="start_quote();">Start Quote Process Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Steps -->
<!-- mobile steps -->
<div class="mobile-steps-wrap hidden-sm hidden-md hidden-lg">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="steps-section-wrap clearfix">
                    <div class="steps-number-cols text-center">
                        <h4>1. Personal & Driver Details</h4>
                        <p>Enter your personal details.</p>
                    </div>
                    <div class="steps-number-cols text-center">
                        <h4>2. Vehicle Details</h4>
                        <p>Insert vehicle registration number to automatically receive vehicle details or enter details manually.</p>
                    </div>
                    <div class="steps-number-cols text-center">
                        <h4>3. Vehicle Storage Details</h4>
                        <p>Enter your address and tell us where you park your car during the day and at night.</p>
                    </div>
                    <div class="steps-number-cols text-center">
                        <h4>4. Results</h4>
                        <p>Receive multiple Car Insurance Quote options, tailored to your motoring needs.</p>
                    </div>
                    <div class="steps-number-cols text-center">
                        <h4>5. Refine and Submit</h4>
                        <p>Refine and/or submit your chosen quote and we’ll get back to you to confirm.</p>
                    </div>
                </div>
                <button class="btn btn-blue start-q" onclick="stepnext(1)">Start Quote Process Now</button>
            </div>
        </div>
    </div>
</div>
<!-- end mobile steps -->
<div class="clearfix"></div>
<!-- steps form -->
<div class="steps-form">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="rate-updates">
                    <div class="tab-content margintop0" style="border:none !important;">

                        <div class="tab-pane fade padding20" id="step-1" >
                            {include file="$T_FRM_PERSONAL"}
                        </div>

                        <div class="tab-pane fade padding20 " id="step-2">
                            {include file="$T_FRM_DETAILS"}
                        </div>

                        <div class="tab-pane fade padding20 " id="step-3" >
                            {include file="$T_FRM_STORAGE"}
                        </div>

                        <div class="tab-pane fade padding20 " id="step-4" >
                            {include file="$T_FRM_REUSLT"}
                        </div>

                        <div class="tab-pane fade padding20 " id="step-5" >
                            {include file="$T_FRM_REFINE"}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end steps form -->

       
<script>
var step_name = "{$step_name}";
if(jQuery(".integer")){
    jQuery(".integer").keydown(fun_Integer);
    jQuery(".integer").focusout(fun_Integer_keyup);
}
function start_quote() {
    if( resLocalStorage.getItemObject("isGuest") == 1) {
        var ajx_param = {
            "url": http_path+'/logout',
            "sync": "false",
            "method": "POST",
            "data": { opcode:'clear_session' },
            "ajxcallback":function(response){
                hideLoading();
                stepnext(1,'');
            }
        };
        call_ajax(ajx_param);
    }
    else{
        stepnext(1,'');
    }
    
    
}


</script>
<script src="{$COMMON_SCRIPTS}typeahead/bootstrap-typeahead.js?{$version}"></script>
<script src="{$COMMON_SCRIPTS}car_insurance.js?{$version}"></script>