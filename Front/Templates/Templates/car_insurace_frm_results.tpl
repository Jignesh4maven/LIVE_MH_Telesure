<div class="row">
{if $isGuest == 0}
<a href="javascript:void(0);" class="back-btn" onclick="stepnext(3,'')"><i class="fa fa-angle-left"></i> Back</a>
{else}
<a href="javascript:void(0);" class="back-btn" onclick="signin_popup('Login to update previous data.');"><i class="fa fa-angle-left"></i> Back</a>
{/if}

</div>

<div class="row" id="quote_list">
    <div class="col-xs-12">
        <div class="step-four-wrap">
            <div class="main-title">
                <h3>Almost Done</h3>
                <i id="almost_done"></i>
            </div>
            <div class="edit-section">
                <small>These quotes are based on:</small>
                <div class="clearfix edit-title">
                    <h4 class="pull-left" id="car_desc"></h4>
                    
                    {if $isGuest == 0}
                     <button class="btn btn-pink pull-right" onclick="stepnext(2,'');">Edit Car</button>
                    {else}
                     <button class="btn btn-pink pull-right" onclick="signin_popup('Login to Edit Car Details.');">Edit Car</button>
                    {/if}
                   
                </div>
            </div>
            <div class="s4-table-wrap hidden-xs hidden-sm">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Insure</th>
                            <th>Premium</th>
                            <th>Excess</th>
                            <!--th>Sasria</th-->
                            <th>Financed</th>
                            <th>Hail Cover</th>
                            <th>Public Liability</th>
                            <th>Widescreen<br> Protection</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="data-list"></tbody>                        
                    <script data-tmpl="data-list" type="text/html">
                        <tr id="row">
                            <td><img src="{$TEMPLATE_IMAGES}/no_image.jpg" alt="<@=Insure@>"/></td>
                            <td class="s4-price-td"><strong>R <@=Premium@></strong><br> <small>per month</small></td>
                            <td class="s4-price-td">R <@=Excess@><br><small>compulsary</small></td>
                            <!--td></td-->
                            <td><@=VehicleFinanced@></td>
                            <td><@=HailCover@></td>
                            <td><@=PublicLiability@></td>
                            <td><@=WidescreenProtection@></td>
                            <td class="cmb"><button class="btn btn-blue" onclick="select_quote('<@=CompanyId@>')" ><@=ButtonText@></button><br><a href="javascript:callme_nold()">Call me Back</a></td>
                        </tr>
                    </script>
                </table>
            </div>
            <!-- Step 4 Mobile view -->
            <!--<div class="s4-mobile-wrap hidden-md hidden-lg">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="thumbnail">
                            <tbody id="data-list"></tbody>
                            <script data-tmpl="data-list" type="text/html">
                                <div class="m-s4-logo">
                                    <img src="{$TEMPLATE_IMAGES}<@=Insure@>" alt="<@=Insure@>"/>
                                </div>
                                <div class="m-s4-price">
                                <div class="m-s4-premium">R <@=Premium@><span>per month premium</span></div>
                                <div class="m-s4-excess">Excess R <@=Excess@> compulsory</div>
                            </div>
                            <div class="m-s4-benefits">
                                <h4>Included Benefits</h4>
                                <ul class="list-unstyled">
                                    <li><@=RoadsideAssistance@></li>
                                    <li><@=TowingandStorage@></li>
                                    <li><@=HailDamage@> (if financed) </li>
                                    <li><@=FixedPremiums@></li>
                                    <li><@=WidescreenProtection@></li>
                                </ul>
                                <button class="btn btn-blue"><@=ButtonText@></button><br><a href="#">Call me Back</a>
                            </div>                                
                            </script>
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- End step 4 Mobile view -->
        </div>
    </div>
</div>
<script type="text/javascript">
    var  isGuest = "{$isGuest}";
    {literal}
   
    function loadResultData() {
        $("#quote_list").hide();
        showLoading('Requesting insurance quotes...');
      
        $.ajax({
            url: http_path+'/results',
            type: "POST",
            dataType: 'json',
            data:{opcode:'load_data'},
            success:function(resdata) {
                
                    if ( typeof(resdata.faultstring) != "undefined") {
                        var message = resdata.faultstring;
                        parent.$.msgGrowl ({
                           title: 'Error While Fetching Quote' // Optional
                          ,text: message
                          ,position: 'top-center'
                          ,msgtype: 'Error'
                        });
                        hideLoading();
                        return;
                    }
                   
                    if ( typeof(resdata.resultStatus) != "undefined") {
                        
                        if ( resdata.resultStatus == "Success") {
                            
                            var no_list_found = (resdata.resultData.list).length;
                            
                            $("#no_of_quotes_found").text(no_list_found);
                            
                            $("#car_desc").html(resdata.carDescription);
                            
                            $("#almost_done").html(resdata.almostDone);
                             
                            var dataobj = {"res":resdata,"template_place_id":"data-list","template_id":"data-list"};
                             
                            set_datalist(dataobj);
                            
                            hideLoading(0);
                            
                            if (isGuest == "1") {
                                bind_click_till(0);
                            }
                            else{
                                bind_click_till(4);  
                            }
                            
                            
                            $("#quote_list").show();
                        }
                        else if ( resdata.resultStatus == "Warning") {
                            
                            hideLoading(0);
                            
                            if ( typeof(resdata.resultData.error_message) != "undefined" ) {
                                
                                console.log(resdata.resultData.error_message);
                                
                                display_msg = resdata.resultData.error_message;
                                
                                if ( typeof(resdata.resultData.error_message) == "object" ) {
                                    display_msg = resdata.resultData.error_message[0];
                                }
                                
                                var pop_message ="<div class='row text-center'>";
                                pop_message += "<h2>Error occur while requesting a quotes</h2>";
                                pop_message += "<p>"+display_msg+"</p>";
                                pop_message += '<button style="width: 247px" onclick="retry_quote();" class="btn btn-blue" type="button">Try Again</button>';
                                pop_message += "</div>";
                                modal_params = {'id':'retryQuote','class':'myClass',"content":pop_message,"title":"",width:"100px",height:"400px"};
                                open_modal(modal_params);
                                /*$.msgGrowl ({
                                   title: 'Error While Fetching Quote' // Optional
                                  ,text: display_msg
                                  ,position: 'top-center'
                                  ,msgtype: 'Error'
                                });*/
                                hideLoading();
                                return;
                            }
                        }                        
                        else if( resdata.resultStatus == "Error") {
                             $.msgGrowl ({
                                title: 'Error While Fetching Quote' // Optional
                               ,text: ""
                               ,position: 'top-center'
                               ,msgtype: 'Error'
                             });
                             hideLoading();
                            hideLoading(0);
                        }
                    }
                    else{
                        hideLoading(0);
                    }
                    
                }
        });
    }
    
    function select_quote(company_id){
 
        if (company_id != "") {
            var ajx_param = {
            "url": http_path+'/results',
            "sync": "false",
            "method": "POST",
            "data": { opcode:'select_quote' , "company_id":company_id},
            "ajxcallback":function(response){
                console.log(response);
                stepnext(5);
                hideLoading();
                }
            };
            call_ajax(ajx_param);
        }
       
        
    }
    function retry_quote(){
        close_modal();
        setTimeout(function() {
            loadResultData();        
        }, 500);
        
    }
    
    function callmeback(vehicle_id) {
        
        /*if (vehicle_id != "") {
            showLoading();
            var ajx_param = {
            "url": http_path+'/results',
            "sync": "false",
            "method": "POST",
            "data": { opcode:'callme_back','vehicle_id':vehicle_id},
            "ajxcallback":function(resdata){
                console.log(resdata);
                var ref_msg = "";
                if ( typeof(resdata.resultStatus) != "undefined") {
                        
                    if ( resdata.resultStatus == "Success") {
                        
                        if ( typeof(resdata.resultData) != "undefined") {
                            
                          if ( typeof(resdata.resultData.InsuranceCallMeSubmissionResult) != "undefined") {
                            
                                if ( resdata.resultData.InsuranceCallMeSubmissionResult.ErrorStatus == "E") {
                               
                                    var display_msg = resdata.resultData.InsuranceCallMeSubmissionResult.ErrorDescriptions;
                                    $.msgGrowl ({
                                       title: 'Error While Requesting Call Me Back' // Optional
                                      ,text: display_msg
                                      ,position: 'top-center'
                                      ,msgtype: 'Error'
                                    });
                                    hideLoading();
                                    return;
                                }
                                else{
                                    
                                    ref_msg = resdata.resultData.InsuranceCallMeSubmissionResult.LeadSubmissionReferenceNr;
                                
                                    console.log("redirect to thank you page");
                                
                                    //window.location.href = http_path+'/thankyou?type=callme&msg='+ref_msg;
                                    
                                }
                                
                                
                            }
                            
                        }
                        
                    }
                }    
                        
                        
                
                hideLoading();
                }
            };
            call_ajax(ajx_param);
        }*/
    }
    {/literal}
</script>    