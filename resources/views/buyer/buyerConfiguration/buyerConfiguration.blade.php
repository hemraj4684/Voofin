
@extends('buyer.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BUYER CONFIGURATIONS </a></li>
	</ul>	
@stop
@section('content')
<!-- Row Start -->

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

<!--djn code -->
<form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="" method="POST" action="{{route('buyer.config.save')}}">
<!--code ends here-->
				<div class="row">
					<div class="col-lg-12 col-md-12">					
					<div class="widget">
						<div class="widget-header">
							<div class="title">
								Bank Details
							</div>
						</div>
						
						<div class="widget-body dsk_mr80">
							
							{!! csrf_field() !!}
							<div class="form-group">
									<label for="buyer" class="col-sm-2">Bank Name<i class="fa fa-asterisk req_asterisk"></i></label>
									<div class="col-sm-5">
										<input type='text' class="form-control" placeholder="Bank Name" name="bank_name" 
										value="{{$getid->bank_name or ''}}"/> 
									</div>
							</div>
							
							<div class="form-group">
									<label for="buyer" class="col-sm-2">Branch<i class="fa fa-asterisk req_asterisk"></i></label>
									<div class="col-sm-5">
										<input type='text' class="form-control" placeholder="Branch" name="branch" value="{{ $getid->branch or '' }}" /> 
									</div>								
							</div>
								
							<div class="form-group">
									<label for="buyer" class="col-sm-2">Account No.<i class="fa fa-asterisk req_asterisk"></i></label>
									<div class="col-sm-5">
										<input type='text' class="form-control" placeholder="Account No." name="account_no" value="{{ $getid->account_no or ''}}" /> 
									</div>								
							</div>									
								
							<div class="form-group">
									<label for="buyer" class="col-sm-2">IFSC Code<i class="fa fa-asterisk req_asterisk"></i></label>
									<div class="col-sm-5">
										<input type='text' class="form-control" placeholder="IFSC Code" name="ifsc_code" value="{{  $getid->ifsc_code or '' }}"/> 
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
								Tax Details
							</div>
						</div>
						
						<div class="widget-body dsk_mr80">
							<span class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
                             	{{--*/  $i = 0; /*--}}	

                                

                             	@if(isset($data['tax_configuration']))

								@foreach($data['tax_configuration'] as $key=>$val)								
								<div class="form-group" id="add_item1">
									<div class="col-sm-3">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="name[]" placeholder="Tax Name" value="{{$key}}">
									</div>	

									<div class="col-sm-3">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="" placeholder="Tax Number" value="">
									</div>
									
									<div class="col-sm-3">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description" name="value[]" placeholder="Tax value" value="{{$val}}" >
									</div>
									
									<div class="col-sm-1">
										<a href="" style="color:#f00; font-size:20px; @if($i==0) display:none @endif" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
									</div>
									{{--*/  $i++; /*--}}
								</div>
								@endforeach
								@else
								<div class="form-group" id="add_item1">
									<div class="col-sm-5">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="name[]" placeholder="Tax Name" value="">
									</div>	
									
									<div class="col-sm-5">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description" name="value[]" placeholder="Tax value" value="" >
									</div>
									
									<div class="col-sm-1">
										<a href="" style="color:#f00; font-size:20px;display:none;" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
									</div>
								</div>
								@endif
								<div class="add_more_col1"></div>
                                 
								<a id="add_more_btn1" class="btn btn-primary">Add More</a>									
							
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
								Price Band <i class="fa fa-info-circle" title="Define PO / PI limits for various roles"></i>
							</div>
						</div>
						<div class="widget-body dsk_mr80">
							<span class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
							@if(isset($data['price_band']))						
								{{--*/  $i = 0; /*--}}	
								@foreach($data['price_band'] as $key => $val)
								<div class="form-group" id="add_item">
									
									
									<span class="col-sm-5">
										<input type='text' class="form-control" name="priceBandAmt[]" value="{{$key}}"> 
									</span>
									
									<div class="col-sm-5">
									<select name="priceBandRole[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required">
								        <option value="">Select Role</option>
								       	 @foreach($roles as $role)
											<option value="{{$role->id}}" @if($role->id == $val) selected @endif>{{$role->name}}</option>
										 @endforeach							  
									  </select>
									</div> 
									<div class="col-sm-2">
										<a href="#" style="color:#f00; font-size:20px; @if($i==0) display:none @endif" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
										{{--*/  $i++; /*--}}	
									</div> 
								</div>
								@endforeach
							@else
								<div class="form-group" id="add_item">
									<span class="col-sm-5">
										<input type='text' class="form-control" name="priceBandAmt[]" value=""> 
									</span>
									<div class="col-sm-5">
									<select name="priceBandRole[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required">
								        <option value="">Select Role</option>
								       	 @foreach($roles as $role)
											<option value="{{$role->id}}">{{$role->name}}</option>
										 @endforeach							  
									  </select>
									</div> 
									<div class="col-sm-2">
										<a href="#" style="color:#f00; font-size:20px; display:none;" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
									</div> 
								</div>
							@endif
								
								<div class="add_more_col"></div>
								<a id="add_more_btn" class="btn btn-primary">Add More</a>							
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
										<label for="buyer" class="col-sm-6">Default Terms (Days)<i class="fa fa-asterisk req_asterisk"></i></label>
										<div class="col-sm-5">
											<input type="text" name="paymentTermsDays" class="form-control" placeholder="Payment Terms (Days)" value="{{$data['other_configuration']['payment_terms'] or ''}}"> 
										</div>								
									</div>
												
									<div class="form-group">
										<label for="Seller" class="col-sm-6">ERP Integration											
											<span class="help-block" style="font-weight:normal;">If selected, all information pertaining to PO/Invoice/PI/Remittances will be picked up from ERP.</span>
										</label>
										<div class="col-sm-5">
										  <div class="cd-pricing-switcher clearfix">
											  <p class="fieldset pull-left">
												<input type="radio" name="erpIntegration" value="1" id="yes"  data-id="close" @if(isset($data['other_configuration']['erp_integration']) && $data['other_configuration']['erp_integration']=='1') {{"checked"}} @endif>
												<label for="yes">Yes</label>
												<input type="radio" name="erpIntegration" value="0" id="no"data-id="open" @if(isset($data['other_configuration']['erp_integration']) && $data['other_configuration']['erp_integration']=='0') {{"checked"}} @endif>
												<label for="no">No</label>
												<span class="cd-switch"></span>
											  </p>
											</div>										
										</div>									
									</div>
									<div class="form-group">
									  <label for="buyer" class="col-sm-6">Default Currency<i class="fa fa-asterisk req_asterisk"></i></label>
									  <div class="col-sm-5">
										<select name="currency" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="currency">
											<option selected>Select Currency</option>
											@foreach($currencyData as $key => $val)
												<option value="{{$key}}" @if(isset($data['other_configuration']['currency']) && $data['other_configuration']['currency'] == $key) {!! "selected" !!} @endif>{{$val['name']}}</option>
											@endforeach
										</select>
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
										<label for="Seller" class="col-sm-3">POs Creation / Updation</label>
										<div class="col-sm-5">
										  <div class="cd-pricing-switcher clearfix">
											  <p class="fieldset pull-left">
												<input type="radio" name="po_creation" checked value="1" id="po_cre_y" @if(isset($data['maker_checker']['po_creation']) && $data['maker_checker']['po_creation']=='1') {{"checked"}} @endif>
												<label for="po_cre_y">Yes</label>
												<input type="radio" name="po_creation" value="0" id="po_cre_n" @if(isset($data['maker_checker']['po_creation']) && $data['maker_checker']['po_creation']=='0') {{"checked"}} @endif>
												<label for="po_cre_n">No</label>
												<span class="cd-switch"></span>
											  </p>
											</div>										
										</div>									
									</div>
									
									<div class="form-group">
										<label for="Seller" class="col-sm-3"> Invoice / Payment Instruction Approval</label>
										<div class="col-sm-5">
										  <div class="cd-pricing-switcher clearfix">
											  <p class="fieldset pull-left">
												<input type="radio" name="invoice_approval" checked value="1" id="in_apr_y" @if(isset($data['maker_checker']['invoice_approval']) && $data['maker_checker']['invoice_approval']=='1') {{"checked"}} @endif>
												<label for="in_apr_y">Yes</label>
												<input type="radio" name="invoice_approval" value="0" id="in_apr_n" @if(isset($data['maker_checker']['invoice_approval']) && $data['maker_checker']['invoice_approval']=='0') {{"checked"}} @endif>
												<label for="in_apr_n">No</label>
												<span class="cd-switch"></span>
											  </p>
											</div>										
										</div>									
									</div>
																		
									<div class="clearfix"></div>
								
									<div id="open" class="none"></div>								
									
									<div id="close" @if(isset($data['other_configuration']['erp_integration']) && $data['other_configuration']['erp_integration']=='1')class="none"@endif>									
										<div class="form-group">
											<label for="Seller" class="col-sm-3">PI Upload</label>
											<div class="col-sm-5">
											  <div class="cd-pricing-switcher clearfix">
												  <p class="fieldset pull-left">
													<input type="radio" name="pi_upload" value="1" checked id="pi_cre_y" @if(isset($data['maker_checker']['pi_upload']) && $data['maker_checker']['pi_upload']=='1') {{"checked"}} @endif>
													<label for="pi_cre_y">Yes</label>
													<input type="radio" name="pi_upload" value="0" id="pi_cre_n" @if(isset($data['maker_checker']['pi_upload']) && $data['maker_checker']['pi_upload']=='0') {{"checked"}} @endif>
													<label for="pi_cre_n">No</label>
													<span class="cd-switch"></span>
												  </p>
												</div>										
											</div>									
										</div>
									</div>
									
									<!-- <div class="form-group">
										<label for="Seller" class="col-sm-6">PI Approval
										<span class="help-block" style="font-weight:normal;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </span></label>
										<div class="col-sm-5">
										  <div class="cd-pricing-switcher clearfix">
											  <p class="fieldset pull-left">
												<input type="radio" name="pi_approval" value="1" id="pi_apr_y">
												<label for="pi_apr_y">Yes</label>
												<input type="radio" name="pi_approval" value="0" id="pi_apr_n" checked="">
												<label for="pi_apr_n">No</label>
												<span class="cd-switch"></span>
											  </p>
											</div>										
										</div>									
									</div> -->
																
									<div class="form-group">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-primary pull-right" style="margin:0 0 0 20px;">Cancel</button>
										<button type="submit" class="btn btn-primary pull-right">Save</button> 
									</div>		
									</div>
													
								
							</div>
							
						</div>
					</div>
					</div>
				</form>
				<!-- Row End -->
@stop
