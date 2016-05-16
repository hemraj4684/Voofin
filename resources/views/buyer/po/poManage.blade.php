@extends('buyer.layouts.default')
@section('sidebar')
<ul>
    <li><a href="" class="heading">BUYER CREATE PO</a></li>
</ul>	
@stop
@section('content')
<!-- Row Start -->
<?php $i = 0 ?>
<form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" 
      id="addPO" role="form" confirm-on-exit="" novalidate="" method="post" enctype="multipart/form-data" onsubmit="return false">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-12 col-md-12">					
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        Create PO
                    </div>
                </div>
                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <input type='hidden' class="form-control" name="txtuuid" value="{{$poData->uuid or ''}}" /> 
                <div class="widget-body dsk_mr80">
                    <div class="form-group">
                        <label for="buyer" class="col-sm-4 control-label">PO No.
                            <i class="fa fa-asterisk req_asterisk"></i>
                        </label>
                        <div class="col-sm-5">
                            @if(isset($poData->uuid) && $poData->uuid)
                              <label for="buyer" class="control-label">{{$poData->purchase_order_number or ''}} </label>  
                            @else
                              <input type='text' id="purOrderNumber" class="form-control" placeholder="PO Number" name="purchase_order_number" value="{{$poData->purchase_order_number or ''}}" />
                            @endif
                            <span id="purchase_order_numberErr" style="color:red"></span>
                            

                        </div>
                    </div>

                    <div class="form-group autocomplete_input">
                        <label for="buyer" class="col-sm-4 control-label">Seller<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-5">
                            <input type='text' name="sellerName" id="sellerName" class="form-control typeahead typeahead tt-query" placeholder="Seller" autocomplete="on" spellcheck="false" value="{{$sellerData->name or ''}}"/> 
                            <input type="hidden" name="seller_id" id="sellerId" value="{{$sellerData->id or ''}}"/>
                            <span id="sellerNameErr" style="color:red"></span>   
                        </div>	
                    </div>

                    <div class="form-group">
                        <label for="type" class="col-sm-4 control-label">Type<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-5">
                            <select name="type" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required chosen-select" id="test">
                                <option selected>Select Type</option>
                                <option value="Recurring" @if(isset($poData->type) && $poData->type === "Recurring") {!! "selected" !!} @endif> Recurring</option>
                                <option value ="One Time" @if(isset($poData->type) && $poData->type === "One Time") {!! "selected" !!} @endif >One Time</option>										  
                            </select>										
                            <span id="typeErr" style="color:red"></span>
                        </div>									
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-4 control-label">Currency<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-5">
                            <select name="currency" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="currency">
                                <option selected>Select Currency</option>
                                @foreach($currencyData as $key => $val)
                                <option value="{{$key}}" @if(isset($poData->type) && $poData->currency === $key) {!! "selected" !!} @elseif(isset($configuration['currency']) && $configuration['currency'] === $key) {!! "selected" !!} @endif>{{$val->name}}</option>
                                @endforeach
                            </select>
                            <span id="currencyErr" style="color:red"></span>										
                        </div>									
                    </div>									

                    <div class="form-group">
                        <label for="buyer" class="col-sm-4 control-label">Duration<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-2">
                            <input type="text" name="start_date" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="datepicker1" placeholder="From" value = "{{$poData->start_date or ''}}">
                            <span id="start_dateErr" style="color:red"></span>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="end_date" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="datepicker2" placeholder="To" value = "{{$poData->end_date or ''}}">
                            <span id="end_dateErr" style="color:red"></span>
                        </div>									
                    </div>							

                    <div id="hidden_div" style="display: none;">
                        <div class="form-group">
                            <label for="buyer" class="col-sm-4 control-label">Delivery Date<i class="fa fa-asterisk req_asterisk"></i></label>
                            <div class="col-sm-5">
                                <input type='text' class="form-control" id="datepicker3" placeholder="Delivery Date" /> 

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="buyer" class="col-sm-4 control-label">Delivery Address<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-5">									  	
                            <textarea class="form-control" rows="5" name="delivery_address">{{$poData->delivery_address or ''}}</textarea>									  
                             <span id="delivery_addressErr" style="color:red"></span>
                        </div>									
                    </div>

                    <div class="form-group">
                        <label for="buyer" class="col-sm-4 control-label">Payment Terms (Days)<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-5">
                            <input type='text' id="paymentTerms" name="payment_terms" class="form-control" placeholder="Payment Terms (Days)" value="{{$poData->payment_terms or $configuration['paymentTerms']}}"/> 
                            <span id="payment_termsErr" style="color:red"></span>
                        </div>								
                    </div>

                    <div class="form-group">
                        <label for="buyer" class="col-sm-4 control-label">Remark</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" rows="5" name="remarks">{{$poData->remarks or ''}}</textarea>											
                            <span id="remarksErr" style="color:red"></span>
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
                        Description
                    </div>
                </div>

                <div class="widget-body dsk_mr80">
                    <div class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate=""> 

                        @if(isset($poItemData) && count($poItemData) > 0)
                        @foreach($poItemData as $poItemVal)
                        <div class="form-group" id="add_item">

                            <div class="col-sm-2">
                                <input type="text" name="item[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"  placeholder="Item" value="{{$poItemVal->name or ''}}">
                            </div>	

                            <div class="col-sm-2">
                                <input type="text" name="description[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"  placeholder="Description" value="{{$poItemVal->description or ''}}">
                            </div>

                            <div class="col-sm-2">
                                <input type="text" name="quantity[]" class="quantity form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"  placeholder="Quantity" value="{{$poItemVal->quantity or ''}}">

                            </div>

                            <div class="col-sm-2">
                                <input type="text" name="pricePer[]" class="form-control pricePer"  placeholder="Price Per Quantity" value="{{$poItemVal->unit_price or ''}}">
                            </div>

                            <div class="col-sm-2">
                                <input type="text" name="total[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required total"  placeholder="Total" value="{{$poItemVal->total or ''}}">
                            </div>


                            <div class="col-sm-2">
                                <a href="#" style="color:#f00; font-size:20px; @if($i == 0) display:none; @endif" class="deleteItemDes"><i class="fa fa-trash-o fa-lg"></i></a>
                            </div>
                            <?php $i++ ?>
                        </div>
                        @endforeach
                        @else
                        <div class="form-group" id="add_item">
                            <div class="col-sm-2">
                                <input type="text" name="item[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"  placeholder="Item" value="{{$poItemVal->name or ''}}">
                            </div>	

                            <div class="col-sm-2">
                                <input type="text" name="description[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"  placeholder="Description" value="{{$poItemVal->description or ''}}">
                            </div>

                            <div class="col-sm-2">
                                <input type="text" name="quantity[]" class="quantity form-control ng-pristine ng-untouched ng-invalid ng-invalid-required"  placeholder="Quantity" value="{{$poItemVal->quantity or ''}}">
                            </div>

                            <div class="col-sm-2">
                                <input type="text" name="pricePer[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required pricePer"  placeholder="Price Per Quantity" 
                                       value="{{$poItemVal->unit_price or ''}}" onchange="calculateSum($(this));">
                            </div>

                            <div class="col-sm-2">
                                <input type="text" name="total[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required total"  placeholder="Total" value="{{$poItemVal->total or ''}}" readonly="true">
                            </div>

                            <div class="col-sm-2">
                                <a href="#" class="deleteItemDes" style="display:none;"><i class="fa fa-trash-o fa-lg"></i></a>
                            </div>

                        </div>
                        @endif

                        <div class="add_more_col"></div>

                        <a id="add_more_btn" class="btn btn-primary">Add More</a>

                        <div class="clearfix"></div>

                        <!-- <div class="form-group">
                                <label for="invoice_no" class="col-sm-8 control-label">Sub Total</label>
                                <div class="col-sm-4">
                                        <input type="text" name="amount" id="amount" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="taxt_percent" placeholder="Sub Total" value="{{$poData->amount or ''}}" readonly="true">
                                </div>	
                        </div>

                        <div class="form-group">
                                <label for="invoice_no" class="col-sm-8 control-label">Discount</label>
                                <div class="col-sm-4">
                                        <input type="text" name="discount" id="discount" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="taxt_percent" placeholder="Discount" value="{{$poData->discount or ''}}">
                                </div>	
                        </div> -->

                        <div class="form-group">
                            <label for="invoice_no" class="col-sm-8 control-label">Total</label>
                            <div class="col-sm-4">
                                <input type="text" name="final_amount" id="amount" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="total" placeholder="Total" value="{{$poData->final_amount or ''}}" readonly="true">
                            </div>	
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="invoice_no" class="col-sm-4">Add Attachment&nbsp;<i class="fa fa-paperclip"></i></label>
                                <div class="col-sm-8">
                                    <input type="file" name="attachFile[]" id="filer_input" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required">
                                    @if(isset($poAttachData) && count($poAttachData)>0)
                                    <div class="jFiler-items jFiler-row">
                                        <ul class="jFiler-items-list jFiler-items-default">
                                            @foreach($poAttachData as $attch)
                                            <li class="jFiler-item" data-jfiler-index="0" style="">
                                                <div class="jFiler-item-container">
                                                    <div class="jFiler-item-inner">
                                                        <div class="jFiler-item-icon pull-left">
                                                            <i class="icon-jfi-file-image jfi-file-ext-jpg"></i>
                                                        </div>
                                                        <div class="jFiler-item-info pull-left">
                                                            <div class="jFiler-item-title" title="{{$attch->name}}">{{$attch->name}}</div>
                                                            <div class="jFiler-item-others"></div>
                                                            <div class="jFiler-item-assets">
                                                                <ul class="list-inline">
                                                                    <li><a class="icon-jfi-trash jFiler-item-trash-action delete-attach" id="{{$attch->id}}"></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach

                                        </ul>
                                    </div> 
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <a href="{{URL::route('buyer.poListing.view')}}" style="float:right; margin:0 0 0 20px;" class="btn btn-primary pull-right">Cancel </a>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>		
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->



</form>



@stop
