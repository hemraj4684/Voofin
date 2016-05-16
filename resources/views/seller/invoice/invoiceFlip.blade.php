@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">CREATE INVOICE <i class="fa fa-info-circle" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."></i></a></li>
	</ul>
	
@stop
@section('content')
<!-- Row Start -->
@if(count($errors) > 0)
<div class="alert alert-danger">
<ul>
	@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
</ul>
</div>
@endif

<form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" id="invoiceForm" role="form" action="{{ route('seller.invoice.save') }}" method="post" enctype="multipart/form-data" confirm-on-exit="" novalidate="">
       {{ csrf_field() }}
				<div class="row">
					<div class="col-lg-12 col-md-12">					
					<div class="widget">
						<div class="widget-header">
							<div class="title">
								Create Invoice
							</div>
						</div>
						
					    <div class="widget-body dsk_mr80">
							<div class="form-group">
								<label for="invoice_no" class="col-sm-4 control-label">Invoice No<i class="fa fa-asterisk req_asterisk"></i></label>
								<div class="col-sm-5">
									<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="invoice_number" name="invoice_number" placeholder="Invoice No" value="{{old('invoice_number') or ''}}" autocomplete="off">
								    <div id="invoiceInfo"></div>
								</div>	
							</div>
							
							<div class="form-group autocomplete_input">
								<label for="buyer" class="col-sm-4 control-label">Buyer<i class="fa fa-asterisk req_asterisk"></i></label>
								<div class="col-sm-5" id="the-basics">
								<label class="control-label">{{ $buyerData->name }}</label>
									<input type="hidden" name="buyer_uuid" id="buyer_id" value="{{$buyerData->uuid or old('buyer_uuid')}}" autocomplete="off">
									<input type="hidden" name="buyer_name" value="{{$buyerData->name or old('buyer_name')}}">
								</div>									
							</div>
							
							<div class="form-group autocomplete_input">
								<label for="buyer" class="col-sm-4 control-label">Associated PO<i class="fa fa-asterisk req_asterisk"></i></label>
								<div class="col-sm-5" id="the-basics">
								<label class="control-label">{{ $poData->purchase_order_number }}</label>
									<input type="hidden" name="po_no" value="{{$poData->purchase_order_number or old('po_no')}}">
									<input type="hidden" name="po_id" id="po_id" value="{{$poData->uuid or old('po_id')}}">
								</div>									
							</div>
							
							
							<div id="hidden_div" style="display: none;">
							<div class="form-group">
								<label for="invoice_no" class="col-sm-4 control-label">New PO<i class="fa fa-asterisk req_asterisk"></i></label>
								<div class="col-sm-5">
									<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="invoice_no" name="invoice_no" placeholder="New PO">
								</div>	
							</div>
							</div>
							
							<div id="hidden_div">

							<div class="form-group">
								<label for="invoice_no" class="col-sm-4 control-label">Due Date<i class="fa fa-asterisk req_asterisk"></i></label>
								<div class="col-sm-5">
									<input type='text' name="in_due_date" id="in_due_date" class="form-control" placeholder="mm/dd/yyyy" readonly value="<?php if(isset($poData->payment_terms)&&!empty($poData->payment_terms)){ echo date("m/d/Y",strtotime("+".$poData->payment_terms." days"));}else{ echo old('in_due_date');}?>"/>
								</div>	
							</div>
							<div class="form-group" id="currencyText">
								<label for="invoice_no" class="col-sm-4 control-label">Currency<i class="fa fa-asterisk req_asterisk"></i></label>
								<div class="col-sm-5">
									<input type='text' name="currency" id="currency" class="form-control" readonly value="{{$poData->currency or old('currency')}}"/>
								</div>	
							</div>
							</div>
							
							<div class="form-group">
								<label for="buyer" class="col-sm-4 control-label">Remark</label>
								<div class="col-sm-5">									  	
									<textarea class="form-control" rows="5" name="remarks">{{old('remarks') or ''}}</textarea>									  
								</div>									
							</div>	
							<input type='hidden' class="form-control" name="invoice_uuid" value="" />							
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
								Description
							</div>
						</div>

						<div class="widget-body dsk_mr80">
							<div class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
								<div class="add_more_col" id="add_item">

								@if(isset($poItemData) && count($poItemData) > 0)
								  @foreach($poItemData as $key => $item)
									 <div class="form-group po_items">
									    <div class="col-sm-2">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item_0" name="item[]" placeholder="Item" value="{{$item->name or ''}}">
										</div>	
										
										<div class="col-sm-2">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description_0" name="description[]" placeholder="Description" value="{{$item->description or ''}}">
										</div>
										
										<div class="col-sm-2">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required quantity" id="quantity_0" name="quantity[]" placeholder="Quantity" value="{{$item->quantity or ''}}">
										</div>
										
										<div class="col-sm-2">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required price" id="priceper_0" name="price_per[]" placeholder="Price Per" value="{{$item->unit_price or ''}}">
										</div>
										
										<div class="col-sm-2">
											<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required total" id="total_0" name="total[]" placeholder="Total" value="{{$item->total or ''}}" readonly>
										</div>
										
										<div class="col-sm-1">
											@if($key!=0)
                                             <a href="javascript:void(0)" style="color:#f00; font-size:20px;" class="remove-item"><i class="fa fa-trash-o fa-lg"></i></a> 
                                           @endif
										</div>
									  </div>
								  @endforeach
								  @elseif(old('item')!==null) <!-- for validation faild old value-->
								    @foreach (old('item') as $i => $val)
									    <div class="form-group po_items">
											<div class="col-sm-2">
												<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item_0" name="item[]" placeholder="Item" value="{{old('item')[$i]}}">
											</div>	
											
											<div class="col-sm-2">
												<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description_0" name="description[]" placeholder="Description" value="{{old('description')[$i]}}">
											</div>
											
											<div class="col-sm-2">
												<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required quantity" id="quantity_0" name="quantity[]" placeholder="Quantity" value="{{old('quantity')[$i]}}">
											</div>
											
											<div class="col-sm-2">
												<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required price" id="priceper_0" name="price_per[]" placeholder="Price Per" value="{{old('price_per')[$i]}}">
											</div>
											
											<div class="col-sm-2">
												<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required total" id="total_0" name="total[]" placeholder="Total" value="{{old('total')[$i]}}" readonly>
											</div>
											
											<div class="col-sm-1">
												<!--<a href="#" style="color:#f00; font-size:20px;"><i class="fa fa-trash-o fa-lg"></i></a>-->
											</div>
										</div>
								   @endforeach
								  @endif 
                                 </div>

								<a id="add_more_btn" class="btn btn-primary">Add More</a>
								
                                <div class="clearfix"></div>

                                  
								<div class="form-group">
									<label for="invoice_no" class="col-sm-7 control-label">Sub Total</label>
									<div class="col-sm-4">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="subTotal" name="amount" placeholder="Sub Total" value="{{$poData->final_amount or old('amount')}}" readonly>
									</div>	
								</div>
								
								<div class="form-group">
									<label for="invoice_no" class="col-sm-7 control-label">Discount</label>
									<div class="col-sm-2">
								        <select class="form-control" name="discount_type" id="discountType">
									      <option value="0">Percentage</option>
									      <option value="1">Absolute</option>
								        </select>
									</div>
									<div class="col-sm-2">
								        <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" auto-complete="off" id="discount" name="discount" placeholder="Discount" value="0.00">
									</div>		
								</div>
								
								<div class="form-group">
									<label for="invoice_no" class="col-sm-7 control-label">Sub Total</label>
									<div class="col-sm-4">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="subTotalDis" name="sub_amount" placeholder="Sub Total" value="{{ $poData->final_amount or old('sub_amount') }}" readonly>
									</div>	
								</div>
								
								<div class="form-group tax-row" id="add_tax_row">
									<label for="invoice_no" class="col-sm-7 control-label tax-label">Tax 1
                                    </label>
									<div class="col-sm-1">
								        <select class="form-control tax-type" name="tax_type[]">
								        <option value="Tax">Select</option>
									      @if(isset($taxData))
                                            @foreach($taxData as $name=>$tax)
									          <option value="{{$name}}:{{$tax}}">{{$name}}</option>
									        @endforeach
									      @endif
								        </select>
									</div>
									<div class="col-sm-1">
								        <input type="text" class="form-control tax ng-pristine ng-untouched ng-invalid ng-invalid-required" name="tax[]" placeholder="Tax" value="" readonly>
									</div>
									<div class="col-sm-2">
								        <input type="text" class="form-control tax-val ng-pristine ng-untouched ng-invalid ng-invalid-required" name="tax_value[]" placeholder="Tax Value" value="0.00" readonly>
									</div>	
									<div class="col-sm-1">
									  <a href="javascript:void(0)" style="color:#337AB7;" id="add_more_tax" class="addTax"><i class="fa fa-plus-circle"></i></a>
									  <a href="javascript:void(0)" style="color:#f00;display:none;" class="deleteTax"><i class="fa fa-trash-o"></i></a> 
									</div>	
								</div>
								<div class="tax-row-container"></div>
								
								<div class="form-group">
									<label for="invoice_no" class="col-sm-7 control-label">Total</label>
									<div class="col-sm-4">
										<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="finalAmount" name="final_amount" placeholder="Total" value="{{ $poData->final_amount or old('final_amount') }}" readonly>
									</div>	
								</div>
								
								<div class="form-group">
								<label for="invoice_no" class="col-sm-2 control-label">Attachment <i class="fa fa-paperclip"></i></label>
							    <div class="col-sm-4">
							       <input type="file" name="invoice_attach[]" id="invoice_attach">
								     
								</div>
								  <div class="col-sm-6">
								   <span class="pull-right">
								  	 <button type="submit" class="btn btn-primary ">Save &amp; Send</button>
								   	 <a href="{{ route('seller.poListing.view') }}" class="btn btn-primary ">Cancel</a>
								   </span>
							      </div>
							    </div>
							    
							</div>	
						</div>
					 </div>
				  </div>
				</div>
				<!-- Row End -->
			
				<!-- Add Attachment Modal Start -->
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add Attachment <i class="fa fa-paperclip"></i></h4>
						  </div>
						  <div class="modal-body">
							
							<div class="input-group">
							<input type="text" class="form-control" readonly>
								<span class="input-group-btn">
									<span class="btn btn-primary btn-file">
										<i class="fa fa-folder-open"></i> Browse 
									</span>
								</span>								
							</div>
							 <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div>
					
				<!-- Add Attachment Modal End -->
		    </form>

		   <!-- Add Tax Modal Start -->
			<div id="serviceTaxModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">
               
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tax</h4>
				  </div>
				  <div class="modal-body">
					<div class="row">
					  <div class="col-sm-2">&nbsp;</div>
					  <label class="col-sm-4">Name</label>
					  <label class="col-sm-4">Percentage</label>
					</div>
				  @if(isset($taxData))
                     @foreach($taxData as $name=>$tax)
					 <div class="row">
					   <div class="col-sm-2"><input type="radio" class="tax-radio" name="invoice_tax" value="{{$tax}}"></div>
					   <label class="col-sm-4">{{$name}}</label>
					   <label class="col-sm-4">{{$tax}}</label>
					 </div>
					@endforeach
				   @endif 
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
				  </div>
				</div>

			  </div>
			</div>
			<!-- Add Tax Modal End -->	

    
@stop


