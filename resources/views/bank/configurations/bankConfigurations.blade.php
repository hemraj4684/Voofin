@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">CONFIGURATIONS</a></li>
	</ul>	
@stop
@section('content')
			<script type="text/javascript" src="{{asset('/public/module/bankModule.js')}}"></script>			
			<!-- Row Start -->
			<form method="POST" action="{{route('bank.configurations.save')}}" class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">			
				<div class="row">
					<div class="col-lg-12 col-md-12">					
					<div class="widget">
						<div class="widget-header">
							<div class="title">
								Basic Configurations
							</div>
						</div>
			
						<div class="widget-body dsk_mr80">
								{!! csrf_field()!!}
								<div class="form-group">
									<label for="bank_base_rate" class="col-sm-6">Bank Base Rate</label>
									
									<div class="col-sm-5">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="bank_base_rate" name="bank_base_rate" placeholder="Bank Base Rate" value="{{$json['basic_configuration']['bank_base_rate'] or ''}}">
									</div>									
								</div>
								<div class="clearfix"></div>
																
								<div class="form-group">
									<label for="tax_no" class="col-sm-6"> Auto Approve Discounting Request
									<span class="help-block" style="font-weight:normal;">Select ‘Yes’ for straight through processing</span>
									</label>
									<div class="col-sm-5">
									  <div class="cd-pricing-switcher clearfix">
										  <p class="fieldset pull-left">
											<input type="radio" name="auto_approve_finance" value="1" id="yes1" @if(isset($json['basic_configuration']['auto_approve_finance']) && $json['basic_configuration']['auto_approve_finance'] == '1') {{"checked"}} @endif>
											<label for="yes1">Yes</label>
											<input type="radio" name="auto_approve_finance" value="0" id="no1" @if(isset($json['basic_configuration']['auto_approve_finance']) && $json['basic_configuration']['auto_approve_finance'] == '0') {{"checked"}} @endif>
											<label for="no1">No</label>
											<span class="cd-switch"></span>
										  </p>
										</div>										
									</div>	
								</div>
								<div class="clearfix"></div>
								
								<div class="form-group">
									<label for="tax_no" class="col-sm-6"> Change Maturity Date
									<span class="help-block" style="font-weight:normal;">Select ‘Yes’ if bank will allow buyer to change ‘Maturity date’ post receipt of discounting request</span>
									</label>
									<div class="col-sm-5">
									  <div class="cd-pricing-switcher clearfix">
										  <p class="fieldset pull-left">
											 <input type="radio" name="edit_maturity_date" value="1" id="yes2" data-id="open" @if(isset($json['basic_configuration']['edit_maturity_date']) && $json['basic_configuration']['edit_maturity_date']==='1') checked @endif> 
											<label for="yes2">Yes</label>
											<input type="radio" name="edit_maturity_date" value="0" id="no2" data-id="close" @if(isset($json['basic_configuration']['edit_maturity_date']) && $json['basic_configuration']['edit_maturity_date']==='0') checked @endif>
											<label for="no2">No</label>
											<span class="cd-switch"></span>
										  </p>
										</div>										
									</div>	
								</div>
								<div class="clearfix"></div>
								
								<div id="open" class="none"></div>								
								
								<div id="close" @if(!isset($json['basic_configuration']['no_of_days'])) class="none" @endif]>
									<div class="form-group">
										<label for="invoice_no" class="col-sm-6">No. of Days</label>
										<div class="col-sm-5">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="invoice_no" name="no_of_days" placeholder="No. of Days" value="{{$json['basic_configuration']['no_of_days'] or ''}}">
										</div>	
									</div>
									<div class="form-group">
										<label for="invoice_no" class="col-sm-6">Compound Frequency</label>
										<div class="col-sm-5">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="invoice_no" name="compoundFrequency" placeholder="Compound Frequency" value="{{$json['basic_configuration']['compoundFrequency'] or ''}}">
										</div>	
									</div>
									<div class="form-group">
										<label for="minDisDays" class="col-sm-6">Minimum Discounting Days
											<span class="help-block" style="font-weight:normal;">Seller will not be able to request discounting for PI(s) maturing within the specified days from the date of request. </span>
										</label>
										<div class="col-sm-5">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="invoice_no" name="minDisDays" placeholder="Min Dis Days" value="{{$json['basic_configuration']['min_dis_days'] or ''}}">
										</div>	
									</div>
									<div class="form-group">
										<label for="maxDisDays" class="col-sm-6">Maximum Discounting Days
										<span class="help-block" style="font-weight:normal;">Seller will not be able to request discounting for PI(s) maturing beyond the specified days from the date of request. </span>
										</label>
										<div class="col-sm-5">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="invoice_no" name="maxDisDays" placeholder="Max Dis Days" value="{{$json['basic_configuration']['max_dis_days'] or ''}}">
										</div>	
									</div>
								</div>
							<div class="clearfix"></div>
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
									<label for="Seller" class="col-sm-3">Discounting Request Approval</label>
									<div class="col-sm-5">
									  <div class="cd-pricing-switcher clearfix">
										  <p class="fieldset pull-left">
											<input type="radio" name="disc_req_appr" value="1" id="disc_req_appr_y" @if(isset($json['maker_checkers']['discounting_request_approval']) && $json['maker_checkers']['discounting_request_approval']=='1') {{"checked"}} @endif>
											<label for="disc_req_appr_y">Yes</label>
											<input type="radio" name="disc_req_appr" value="0" id="disc_req_appr_n" @if(isset($json['maker_checkers']['discounting_request_approval']) && $json['maker_checkers']['discounting_request_approval']=='0') {{"checked"}} @endif>
											<label for="disc_req_appr_n">No</label>
											<span class="cd-switch"></span>
										  </p>
										</div>										
									</div>									
								</div>
								
								<!-- <div class="form-group">
									<label for="Seller" class="col-sm-3">Buyer / Supplier Creation</label>
									<div class="col-sm-5">
									  <div class="cd-pricing-switcher clearfix">
										  <p class="fieldset pull-left">
											<input type="radio" name="buyer_supplier_creation" value="1" id="man_disc_y" @if(isset($json['maker_checkers']['buyer_supplier_creation']) && $json['maker_checkers']['buyer_supplier_creation']=='0') {{"checked"}} @endif>
											<label for="man_disc_y">Yes</label>
											<input type="radio" name="buyer_supplier_creation" value="0" id="man_disc_n" @if(isset($json['maker_checkers']['buyer_supplier_creation']) && $json['maker_checkers']['buyer_supplier_creation']=='0') {{"checked"}} @endif>
											<label for="man_disc_n">No</label>
											<span class="cd-switch"></span>
										  </p>
										</div>										
									</div>									
								</div> -->
								
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
								Bank Fees & Charges
							</div>
						</div>
						
					<div class="widget-body dsk_mr80">
					<span class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
                     @if(isset($json['discounting_fees']))
                     {{--*/  $i = 0; /*--}}	
                     @foreach($json['discounting_fees'] as $key=>$val)
					 <div class="form-group" id="add_item1">
						<div class="col-md-3">
							<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="name[]" placeholder="Name" value="{{$val['name'] or ''}}">
						</div>	
						
						<div class="col-md-2">
							<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description" name="value[]" placeholder="Value" value="{{$val['value'] or ''}}">
						</div>
						
						<div class="col-md-2">
							<select  class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" name="type[]"  > 
 								<option value="">Select Type</option>
 								<option <?php if($val['type']=="percentage") echo "selected";?> value="percentage">percentage</option>
 								<option <?php if($val['type']=="value") echo "selected";?> value="value">value</option>
							</select>
						</div>
						
						<div class="col-md-4">
							<textarea name="description[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" placeholder="Description" >{{$val['description'] or ''}}</textarea>
						</div>	

						<div class="col-sm-1">
							<a href="javascript:;" style="color:#f00; font-size:20px;@if($i==0) display:none; @endif" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
						</div> 
						{{--*/  $i++; /*--}}
					</div>
					@endforeach
					@else
					<div class="form-group" id="add_item1" class="add_more_col1">
						<div class="col-md-3">
							<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item" name="name[]" placeholder="Name" value="">
						</div>	
						
						<div class="col-md-2">
							<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description" name="value[]" placeholder="Value" value="">
						</div>
						
						<div class="col-md-2">
							<select  class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" name="type[]"  > 
 								<option value="">Select Type</option>
 								<option value="percentage">percentage</option>
 								<option value="value">value</option>
							</select>
						</div>
						
						<div class="col-md-4">
							<textarea name="description[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" placeholder="Description" ></textarea>
						</div>	

						<div class="col-sm-1">
							<a href="javascript:;" style="color:#f00; font-size:20px; display:none" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
						</div> 
					</div>
                   
                   @endif
					<div class="add_more_col1"></div>

					<a id="add_more_btn1" class="btn btn-primary">Add More</a>									

					</span>							
					</div>
						
					</div>
					
					<div class="form-group">
						<div class="col-sm-6">
							<button type="submit" class="btn btn-primary pull-right">Submit</button>
						</div>		
					</div>
					
					</span>
					</form>
				</div>
	<!-- Row End -->

			</div>

@stop


