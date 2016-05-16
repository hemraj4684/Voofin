<div id='cssmenu'>
  <ul>
    <li><a href='{{URL::route('bank.discountingRequest.view')}}'> <i class="fa fa-file-text-o"></i> Portfolio Management</a>
	  <ul>
        <li><a href='{{URL::route('bank.discountingRequest.view')}}'>Discounting Requests</a></li>
      </ul>
	</li>
	
    <li class=""><a href='#'><i class="fa fa-pencil-square-o"></i>Reports</a>
		<ul>
			<li><a href='{{URL::route('bank.reports.bankLoanListing.view')}}'>Bank Loans</a></li>
			<li><a href='{{URL::route('bank.reports.maturingLoansListing.view')}}'>Maturing Loans</a></li>
			<li><a href='{{URL::route('bank.reports.loansRejectedListing.view')}}'>Loans Rejected</a></li>
			<li><a href='{{URL::route('bank.reports.bankMaturedLoansListing.view')}}'>Bank Matured Loans</a></li>
			<li><a href='{{URL::route('bank.reports.remittancesInwardListing.view')}}'>Remittances Inward</a></li>
			<li><a href='{{URL::route('bank.reports.remittanceOutwardListing.view')}}'>Remittance Outward</a></li>
			<li><a href='{{URL::route('bank.reports.treasaryFundingListing.view')}}'>Treasary Funding</a></li>
			<li><a href='{{URL::route('bank.reports.sellerLimitUtilizationListing.view')}}'>Seller Limit Utilization</a></li>
			<li><a href='{{URL::route('bank.reports.bankDiscountingUsageReportListing.view')}}'>Discounting Usage Report</a></li>
			<li><a href='{{URL::route('bank.reports.potentialDiscountingListing.view')}}'>Potential Discounting Report</a></li>
			<li><a href='{{URL::route('bank.reports.buyerBehaviourReport.view')}}'>Buyer Behaviour Report</a></li>
		</ul>
	</li>
	<li><a href="{{URL::route('bank.company.view')}}"><i class="fa fa-user"></i>Buyers / Seller</a></li>
	<li><a href='{{URL::route('bank.configurations.view')}}'><i class="fa fa-cog"></i>Configurations</a>
      <ul>
        <li><a href="{{URL::route('bank.configurations.view')}}">Configurations</a></li>
		<li><a href="{{URL::route('bank.user.view')}}">Bank Users</a></li>
		<li><a href='{{URL::route('bank.band.bandMapping.view')}}'>Band Mapping</a></li>
		<li><a href='{{URL::route('bank.revenueSharing.view')}}'>Revenue Sharing</a></li>
		<li><a href='{{URL::route('bank.fundingLimits.view')}}'>Funding Limits</a></li>				
		<li class="has-sub"><span class="submenu-button"></span><a href="#" data-original-title="" title="">Masters</a>
		  <ul>
			<li><a href="{{URL::route('bank.role.view')}}">Roles</a></li>
			<li><a href="{{URL::route('bank.permission.view')}}">Permissions</a></li>
			<!-- <li><a href="{{URL::route('bank.company.view')}}">Buyers / Suppliers</a></li> -->
			<li><a href="{{URL::route('bank.band.view')}}">Bands</a></li>
			<!-- <li><a href="{{URL::route('buyer.user.view')}}">Buyers Users Master</a></li>
			<li><a href="{{URL::route('seller.user.view')}}">Suppliers Users Master</a></li> -->
			<li><a href='{{URL::route('bank.country.view')}}'>Country / State</a></li>
		  </ul> 
		</li>
      </ul>
    </li>
  </ul>
</div>
<!-- Top Nav End -->