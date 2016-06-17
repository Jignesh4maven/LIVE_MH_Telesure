<div class="container modal-content">
                    <div class="row">
                        <div class="section-title text-center">
                            <h3>Get a Car Insurance Quote in 5 easy steps</h3>
                            
                            
                                <div class="stepwizard">
                                    <div class="stepwizard-row">
                                        <div class="stepwizard-step">
                                        <a class="btn btn-default btn-circle" href="#step-1" data-toggle="tab" onclick="stepnext(1)" >1</a>
                                        <p>Personal & Driver Details</p>
                                        </div>
                                        
                                        <div class="stepwizard-step">
                                        <a class="btn btn-default btn-circle"  href="#step-2" onclick="stepnext(2)" data-toggle="tab">2</a>
                                        <p>Vehicle Details</p>
                                        </div>
                                        
                                        <div class="stepwizard-step">
                                        <a class="btn btn-default btn-circle" href="#step-3" onclick="stepnext(3)" data-toggle="tab">3</a>
                                        <p>Vehicle Storage Details</p>
                                        </div>
                                        
                                        <div class="stepwizard-step">
                                        <a class="btn btn-default btn-circle" href="#step-4" onclick="stepnext(4)" data-toggle="tab">4</a>
                                        <p>Results</p>
                                        </div>
                                        
                                        <div class="stepwizard-step">
                                        <a class="btn btn-default btn-circle"  href="#step-5" onclick="stepnext(5)" data-toggle="tab">5</a>
                                        <p>Refine and Submit</p>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <div class="clearfix">
                                    <div class="rate-updates">
                                        <div class="tab-content margintop0" style="border:none !important;">
                                        
                                            <div class="tab-pane fade active in padding20" id="step-1" >
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
                                </div> <!-- stepwizard -->
                             
                        </div>
                    </div>
                 
                </div>

<script>
    
function stepnext(n){

    if(n != 0){
        //$(".stepwizard-row a").switchClass('btn-primary','btn-default');
        $(".stepwizard-row a").removeClass('btn-primary');
        $(".stepwizard-row a").addClass('btn-default');
        $('.stepwizard a[href="#step-'+n+'"]').tab('show');
        //$('.stepwizard-row a[href="#step-'+n+'"]').switchClass('btn-default','btn-primary');
        $('.stepwizard-row a[href="#step-'+n+'"]').removeClass('btn-default');
        $('.stepwizard-row a[href="#step-'+n+'"]').addClass('btn-primary');
    }
}
//stepnext(1);

</script>