<link href="{$TEMPLATE_CSS}account.css" type="text/css" rel="stylesheet" />

<div class="modal-header text-center">
<div class="container">
   
    <div class="col-md-3">
<div class="box-style-nav">
    	<ul id="accordion" class="accordion">
		<li class="default open"><div class="link"><i class="fa fa-car"></i>My Plans</div>
			
		</li>
		<li>
			<div class="link"><i class="fa fa-user" aria-hidden="true"></i>My Account<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Personal Details</a></li>
				<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Change Password</a></li>
				<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Product Documentation</a></li>
				<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Account  Activity</a></li>
				<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>How would you like us to contact you ? </a></li>
				<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Cancel Plan/Policy</a></li>
				<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Add Vehical</a></li>
			</ul>
		</li>
	</ul>

	
<div class="btn-box">
	<button class=" btn btn-secondary">Get Quote Options</button>
	<br>
	<br>
	<button class=" btn btn-secondary">Log  Out</button>
</div>
</div>
</div>
<div class="col-md-9">
	<h2 class="plan-title">My Plans</h2>
	{if isset($data)}
		
		{foreach from=$data item=CustomerOfferLists}
			<div class="table-box">
					<div class="box-title">
						<div class="icon"></div>
						<div class="text">
							<h4>{$CustomerOfferLists.CustomerOfferLists.RegistrationNo}</h4>
								<h3>
									{assign var="str" value=""}
									{if isset($CustomerOfferLists.CustomerOfferLists.Year)}									
										{assign var="str" value=$CustomerOfferLists.CustomerOfferLists.Year}
										{$str}
									{/if}
									{if isset($CustomerOfferLists.CustomerOfferLists.Make)}
										{assign var="str" value=', '|cat:$CustomerOfferLists.CustomerOfferLists.MakeDesc}
										{$str}
									{/if}
									{if isset($CustomerOfferLists.CustomerOfferLists.Model)}
										{assign var="str" value=', '|cat:$CustomerOfferLists.CustomerOfferLists.ModelDesc}
										{$str}
									{/if}
									{if isset($CustomerOfferLists.CustomerOfferLists.Series)}
										{assign var="str" value=', '|cat:$CustomerOfferLists.CustomerOfferLists.SeriesDesc}
										{$str}
									{/if}
								</h3>
						</div>
					</div>
					<!--{$CustomerOfferLists.CustomerOfferLists.CustomerOffers|@print_r}-->
					{foreach from=$CustomerOfferLists.CustomerOfferLists.CustomerOffers item=CustomerOffer}
					  <!-- {$CustomerOffer|@print_r}-->
						<div class="content-detail">
							<i class="fa fa-chevron-right" aria-hidden="true"></i>
							{if $CustomerOffer.Status eq 'Pending'}
								{assign var="class" value='step-tag-disable'}
								{assign var="status" value=$CustomerOffer.Status}
							{else}
								{assign var="class" value='step-tag-active'}
								{assign var="status" value=$CustomerOffer.Status}
							{/if}
								<div class={$class}>{$status}</div>
								<div class="title">
									<a class="slider" id="accordion_toggle_{$CustomerOffer.CustomerOfferId}" href='javascirp:void(0);'>
										<h3 class="main-title">{$CustomerOffer.OfferDescription}({$CustomerOffer.CustomerProductLists|@count}){$CustomerOffer.AmountOfYearsToCover} / {$CustomerOffer.KmToCover}</h3>
										<h5 class="small-title">Purchase price	</h5>
										<h3 class="price-title">R {$CustomerOffer.TotalCostVAT|string_format:"%.2f"} once off</h3>
									</a>
								</div>	
						</div>
						<div class="accordion_toggle_{$CustomerOffer.CustomerOfferId} extra-info" id="collapse_{$CustomerOffer.CustomerOfferId}" style="display: none">
							<div class="panel panel-default">
								<div class="panel-heading bg-blue">
									<h4 class="panel-title">
										<a class="accordion-toggle inner-title-first" id="inner-first-a-{$CustomerOffer.CustomerOfferId}" href='javascript:void(0);' >
											<span class="fa fa-angle-right inner-angle-right"></span>
											<span class="inner-collapse-heading">Payment Details</span>
										</a>
									</h4>
								</div>
								<div class="inner-first-a-{$CustomerOffer.CustomerOfferId}" style="display:none;">
									<div class="content">
										<div class="col-lg-12 col-sm-12 col-xs-md-12 col-xs-12 payment-detail">
											<div class="row display-table">
												<div class="col-lg-6 col-sm-6 col-xs-md-6 col-xs-12 table-cell">
													<p> <strong class="txt-blue"> Bank Details</strong> </p>
													{if isset($CustomerOffer.BankAccountDetails)}
														{if $CustomerOffer.BankAccountDetails.PaymentMethod eq 'DebitOrder'}
															{if isset($CustomerOffer.BankAccountDetails.BankAccountHolder) && !empty($CustomerOffer.BankAccountDetails.BankAccountHolder)}
															<p><strong> Account Holder: </strong> {$CustomerOffer.BankAccountDetails.BankAccountHolder}</p>
															{/if}
															
															{if isset($CustomerOffer.BankAccountDetails.BankAccountNumber) && !empty($CustomerOffer.BankAccountDetails.BankAccountNumber)}
															{assign var="pattern" value="******"}
															<p><strong> Account Number: </strong> {$pattern}{$CustomerOffer.BankAccountDetails.BankAccountNumber|substr:-4}</p>
															{/if}
															
														{elseif $CustomerOffer.BankAccountDetails.PaymentMethod eq 'EFT'}
															{if isset($CustomerOffer.BankAccountDetails.EFTDetailed) && !empty($CustomerOffer.BankAccountDetails.EFTDetailed)}
																<p>{$CustomerOffer.BankAccountDetails.EFTDetailed|nl2br}</p>
															{/if}
														
														{/if}
													{/if}
												</div>
												<div class="col-lg-6 col-sm-6 col-xs-md-6 col-xs-12  table-cell payment-border">
													<p> <strong class="txt-blue"> Method</strong> </p>
													<p><strong> {$CustomerOffer.BankAccountDetails.PaymentMethod} </strong> </p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Payment Details Over -->
								<div class="panel-heading bg-blue">
									<h4 class="panel-title">
										<a class="accordion-toggle inner-second-a" id="inner-second-a" data-parent="#accordion2_<?php echo $CustomerOffer['CustomerOfferId']; ?>" href='javascript:void(0);' >
											<span class="fa fa-angle-right inner-angle-right"></span>
											<span class="inner-collapse-heading">Download Files</span>
										</a>
									</h4>
								</div>
								
								<!-- Download Files Over -->
								<div class="panel-heading bg-blue">
									<h4 class="panel-title">
										<a class="accordion-toggle inner-third-a" id="inner-third-a" data-parent="#accordion2_<?php echo $CustomerOffer['CustomerOfferId']; ?>" href='javascript:void(0);' >
											<span class="fa fa-angle-right inner-angle-right"></span>
											<span class="inner-collapse-heading">Plan Detail</span>
										</a>
									</h4>
								</div>
								<!-- Download Files Over -->
							</div>
						</div>
					{/foreach}	
			</div>
		{/foreach}
	{/if}	
</div>
</div>
</div>
<script type="text/javascript">
	$(function () {
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;
        var links = this.el.find('.link');
        links.on('click', {
            el: this.el,
            multiple: this.multiple
        }, this.dropdown);
    };
    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el;
        $this = $(this), $next = $this.next();
        $next.slideToggle();
        $this.parent().toggleClass('open');
        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        }
        ;
    };
    var accordion = new Accordion($('#accordion'), false);
	
	$(".slider").click(function(){
		var id = $(this).attr('id');
		console.log(id);
		$('.'+id).toggle('slow');
		return false;
	});
	
	
	$(".inner-title-first").click(function(){
		var id = $(this).attr('id');
		console.log(id);
		$('.'+id).toggle();
		return false;
	});
	
});

//# sourceURL=pen.js
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.min.js"></script>