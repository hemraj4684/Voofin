@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">SELLER CONFIGURATION </a></li>
	</ul>	
@stop
@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12">
		@if(Session::has('success'))
		<div class="alert alert-success" role="alert">
			{{Session::get('success')}}
		</div>
		@elseif(Session::has('alert'))
		<div class="alert alert-danger" role="alert">
			{{Session::get('alert')}}
		</div>
		@endif
	</div>
</div>



<!-- Row Start -->
<form method="POST" action="{{route('seller.sellerconfiguration.store')}}" class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
<div class="row">
	<div class="col-lg-12 col-md-12">					
	<div class="widget">
		<div class="widget-header">
			<div class="title">
				Bank Details
			</div>
		</div>
		
		<div class="widget-body dsk_mr80">
			
			{{ csrf_field() }}
			<div class="form-group">

					<label for="buyer" class="col-sm-2">Bank Name<i class="fa fa-asterisk req_asterisk"></i> 
					</label>
					<div class="col-sm-5">
						<input type='text' class="form-control" name="bank_name" placeholder="Bank Name" value="{{$getid->bank_name or ''}}"/> 
					</div>
			</div>
			
			<div class="form-group">
					<label for="buyer" class="col-sm-2">Branch<i class="fa fa-asterisk req_asterisk"></i>
					</label>
					<div class="col-sm-5">
						<input type='text' class="form-control" name="branch" placeholder="Branch" value="{{$getid->branch or ''}}" /> 
					</div>								
			</div>
				
			<div class="form-group">
					<label for="buyer" class="col-sm-2">Account No.<i class="fa fa-asterisk req_asterisk"></i>
					</label>
					<div class="col-sm-5">
						<input type='text' class="form-control" name="account_no" placeholder="Account No." value="{{$getid->account_no or ''}}"/> 
					</div>								
			</div>									
				
			<div class="form-group">
					<label for="buyer" class="col-sm-2">IFSC Code<i class="fa fa-asterisk req_asterisk"></i>
					</label>
					<div class="col-sm-5">
						<input type='text' class="form-control" name="ifsc_code" placeholder="IFSC Code" value="{{$getid->ifsc_code or ''}}" /> 
					</div>								
			</div>							
				
		</div>
	</div>
</div>
</div>
<!-- Row End -->

<!-- Row Start -->
<div class="row">
	<div class="col-lg-12 col-md-12">					
	<div class="widget">
		<div class="widget-header">
			<div class="title">
				Tax Details
			</div>
		</div>
		
		<div class="widget-body dsk_mr80">
			<span class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
				@if(isset($json_data['tax_configuration']))
				 {{--*/  $i = 0; /*--}}	
				 @foreach($json_data['tax_configuration'] as $key=>$val)
				<div class="form-group" id="add_item_conf">
					<div class="col-sm-3">
						<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="name[]" placeholder="Tax Name" value="{{$key or ''}}">
					</div>	
					
					<div class="col-sm-3">
						<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="" placeholder="Tax Number" value="">
					</div>

					<div class="col-sm-3">
						<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description" name="percentage[]" placeholder="Tax value" value="{{$val or ''}}">
					</div>
					
					<div class="col-sm-1">
						<a href="#" style="color:#f00; font-size:20px;@if($i==0) display:none; @endif" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
					</div>
					{{--*/  $i++; /*--}}
				</div>
				@endforeach
				@else
				<div class="form-group" id="add_item_conf">
					<div class="col-sm-5">
						<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="name[]" placeholder="Tax Name" value="">
					</div>	
					
					<div class="col-sm-5">
						<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description" name="percentage[]" placeholder="Tax value" value="">
					</div>
					<div class="col-sm-1">
						<a href="#" style="color:#f00; font-size:20px; display:none" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
					</div>
				</div>
				@endif
				<div class="add_more_col_conf"></div>
					<a id="add_more_btn_conf" class="btn btn-primary">Add More</a>
				</span>
		</div>
		
	</div>
</div>
</div>
<!-- Row End -->

<!-- Row Start -->
<div class="row">
	<div class="col-lg-12 col-md-12">					
	<div class="widget">
		<div class="widget-header">
			<div class="title">
				Configurations
			</div>
		</div>
		
		<div class="widget-body dsk_mr80">
			<span class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
				<div class="form-group">
					<label for="Seller" class="col-sm-6">Discounting
					<span class="help-block" style="font-weight:normal;">Auto - <b style="color:#000;">All</b> buyer approved invoices will be sent to bank for discounting <br>Manual - Choose <b style="color:#000;">individual</b> approved invoice(s) for discounting</span></label>
					<div class="col-sm-5">
					  <div class="cd-pricing-switcher clearfix">
						  <p class="fieldset pull-left">
							<input type="radio" name="autodiscounting" value="1" id="yes" checked @if(isset($json_data['other_configuration']['auto_discounting']) && $json_data['other_configuration']['auto_discounting']=='1') {{"checked"}} @endif>
							<label for="yes">Auto</label>
							<input type="radio" name="autodiscounting" value="0" id="no"  @if(isset($json_data['other_configuration']['auto_discounting']) && $json_data['other_configuration']['auto_discounting']=='0') {{"checked"}} @endif>
							<label for="no">Manual</label>
							<span class="cd-switch"></span>
						  </p>
						</div>										
					</div>									
				</div>
				
				<div class="form-group">
					<label for="Seller" class="col-sm-6">PO Acceptance
					<span class="help-block" style="font-weight:normal;">Auto - <b style="color:#000;">All</b> buyer sent POs will be approved <br>Manual - Choose <b style="color:#000;">individual</b> PO for approval</span></label>
					<div class="col-sm-5">
					  <div class="cd-pricing-switcher clearfix">
						  <p class="fieldset pull-left">
							<input type="radio" name="autoacceptpo" value="1" id="accept_po_y"  checked @if(isset($json_data['other_configuration']['auto_accept_po']) && $json_data['other_configuration']['auto_accept_po']=='1') {{"checked"}} @endif>
							<label for="accept_po_y">Auto</label>
							<input type="radio" name="autoacceptpo" value="0" id="accept_po_n" @if(isset($json_data['other_configuration']['auto_accept_po']) && $json_data['other_configuration']['auto_accept_po']=='0') {{"checked"}} @endif>
							<label for="accept_po_n">Manual</label>
							<span class="cd-switch"></span>
						  </p>
					   </div>										
					</div>									
				</div>			
			</span>					
			
		</div>
		
	</div>
</div>
</div>

<!-- Row End -->

<!-- Row Start -->
<div class="row">
	<div class="col-lg-12 col-md-12">					
	<div class="widget">
		<div class="widget-header">
			<div class="title">
				Maker / Checker <i class="fa fa-info-circle" title="Select ‘Yes’ for Two levels of authorization."></i>
			</div>
		</div>
		
		<div class="widget-body dsk_mr80">
			<span class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
				
				<div class="form-group">
					<label for="Seller" class="col-sm-6">Invoice Creation / Updation. </label>
					<div class="col-sm-5">
					  <div class="cd-pricing-switcher clearfix">
						  <p class="fieldset pull-left">
							<input type="radio" name="invoicecreation" value="1" id="in_cre_y" checked @if(isset($json_data['maker_checker']['invoice_creation']) && $json_data['maker_checker']['invoice_creation']=='1') {{"checked"}} @endif>
							<label for="in_cre_y">Yes</label>
							<input type="radio" name="invoicecreation" value="0" id="in_cre_n" @if(isset($json_data['maker_checker']['invoice_creation']) && $json_data['maker_checker']['invoice_creation']=='0') {{"checked"}} @endif >
							<label for="in_cre_n">No</label>
							<span class="cd-switch"></span>
						  </p>
						</div>										
					</div>									
				</div>
				
				<div class="form-group">
					<label for="Seller" class="col-sm-6">Manual Discounting
						<span class="help-block" style="font-weight:normal;">If selected ‘Yes’, the discounting request will goto Checker for authorization.</span>
					</label>
					<div class="col-sm-5">
					  <div class="cd-pricing-switcher clearfix">
						  <p class="fieldset pull-left">
							<input type="radio" name="manualdiscoutning" value="1" id="man_disc_y" checked @if(isset($json_data['maker_checker']['manual_discoutning']) && $json_data['maker_checker']['manual_discoutning']=='1') {{"checked"}} @endif>
							<label for="man_disc_y">Yes</label>
							<input type="radio" name="manualdiscoutning" value="0" id="man_disc_n" @if(isset($json_data['maker_checker']['manual_discoutning']) && $json_data['maker_checker']['manual_discoutning']=='0') {{"checked"}} @endif>
							<label for="man_disc_n">No</label>
							<span class="cd-switch"></span>
						  </p>
						</div>										
					</div>									
				</div>

				<div class="form-group">
					<div class="col-sm-12">					
						<button type="submit" class="btn btn-primary pull-right">Send</button>
					</div>		
				</div>
				
			</span>	
		</div>
		
	</div>
</div>
</div>
</form>
<!-- Row End -->
		
<!-------- ADD MORE FILD JS START------>		
	<script type="text/javascript">
	$(document).ready(function(){
		$("#add_more_btn").click(function(){
		console.log('jk');
			$("#add_item").clone().appendTo(".add_more_col");
		});
	});
	</script>
<!-------- ADD MORE FILD JS END------>
@stop
