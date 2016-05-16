@extends('seller.layouts.default')
@section('sidebar')
    <ul>
        <li><a href="" class="heading">CREATE INVOICE </a></li>
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

<form class="form-horizontal" name="invoiceForm" id="invoiceForm" role="form" enctype="multipart/form-data" onsubmit="return false">
      
                <div class="row">
                    <div class="col-lg-12 col-md-12">                    
                    <div class="widget">
                        <div class="widget-header"> 
                            <div class="title">
                                Invoice Details
                            </div>
                        </div>
                        
                        <div class="widget-body dsk_mr80">
                            <div class="form-group">
                                <label for="invoice_no" class="col-sm-4 control-label">Invoice No<i class="fa fa-asterisk req_asterisk"></i></label>
                                <div class="col-sm-5">
                                    @if(isset($invData->invoice_number))
                                       <label class="control-label">{{$invData->invoice_number}}</label>
                                    @else
                                     <input type="text" class="form-control" required id="invoice_number" name="invoice_number" id="invoice_number" placeholder="Invoice No" value="{{old('invoice_number') or ''}}" autocomplete="off">
                                     <span id="invoice_numberErr"></span>
                                     <div id="invoiceInfo"></div>
                                    @endif
                                </div>    
                            </div>
                            
                            <div class="form-group autocomplete_input">
                                <label for="buyer" class="col-sm-4 control-label">Buyer<i class="fa fa-asterisk req_asterisk"></i></label>
                                <div class="col-sm-5" id="the-basics">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required typeahead typeahead tt-query" id="buyer_name" name="buyer_name" placeholder="Buyer" autocomplete="on" spellcheck="false" value="{{$invData->buyerName or old('buyer_name')}}" autocomplete="off" required>                                      
                                    <span id="buyer_nameErr"></span>
                                    <input type="hidden" name="buyer_uuid" id="buyer_id" value="{{$invData->buyerUuid or old('buyer_uuid')}}">
                                    
                                  <!-- <select name="buyer_uuid" class="form-control chosen-select">
                                    <option value="">Select Buyer</option>
                                    <?php /*foreach($buyerData as $key => $val)
                                       echo '<option value=""></option>';*/
                                   ?>
                                  </select> -->

                                </div>                                    
                            </div>
                            
                            <div class="form-group autocomplete_input">
                                <label for="buyer" class="col-sm-4 control-label">Associated PO </label>
                                <div class="col-sm-5" id="the-basics">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required typeahead typeahead tt-query" id="po_no" name="po_no" placeholder="Associated PO" autocomplete="on" spellcheck="false" value="{{$invData->purchase_order_number or old('po_no')}}" autocomplete="off">                                      
                                    <input type="hidden" name="po_id" id="po_id" value="{{$invData->poUuid or old('po_id')}}">
                                </div>                                    
                            </div>
                            
                            
                            <div id="hidden_div" style="display: none;">
                            <div class="form-group">
                                <label for="invoice_no" class="col-sm-4 control-label">New PO<i class="fa fa-asterisk req_asterisk"></i></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="invoice_no" name="invoice_no" placeholder="New PO" autocomplete="off">
                                </div>    
                            </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="invoice_no" class="col-sm-4 control-label">Due Date </label>
                                <div class="col-sm-5">
                                    <input type='text' name="in_due_date" id="in_due_date" class="form-control" placeholder="mm/dd/yyyy"  value="<?php if(isset($invData->due_date)){ echo date('m/d/Y',strtotime($invData->due_date));}else{ echo old('in_due_date');}?>" readonly autocomplete="off" required/>
                                </div>    
                            </div>

                            <div class="form-group" id="currencyText" style="display:none">
                                <label for="invoice_no" class="col-sm-4 control-label">Currency<i class="fa fa-asterisk req_asterisk"></i></label>
                                <div class="col-sm-5">
                                    <input type='text' name="currency" id="currency" class="form-control" readonly value="{{$invData->currency or old('currency')}}" autocomplete="off"/>
                                </div>    
                            </div>
                            
                            <div class="form-group" id="currencyDrop">
                                <label for="type" class="col-sm-4 control-label">Currency<i class="fa fa-asterisk req_asterisk"></i></label>
                                <div class="col-sm-5">
                                   @if(isset($invData->currency) && !empty($invData->currency))
                                     <input type='text' name="currency" id="currency" class="form-control" readonly value="{{$invData->currency or ''}}"/>
                                    @else
                                      <select name="currency" class="form-control" id="curDrop">
                                        <option value="">Select Currency</option>
                                        @foreach($currencyData as $key => $val)
                                           @if($key == "BDT")
                                            <option value="{{$key}}" selected>{{$val['name']}}</option>
                                           @else
                                            <option value="{{$key}}">{{$val['name']}}</option>
                                           @endif
                                        @endforeach
                                      </select>
                                    @endif                                    
                                </div>                                    
                            </div>
                                
                            <div class="form-group">
                                <label for="buyer" class="col-sm-4 control-label">Remark</label>
                                <div class="col-sm-5">                                          
                                    <textarea class="form-control" rows="5" name="remarks">{{$invData->remarks or old('remarks')}}</textarea>                                      
                                </div>                                    
                            </div>    
                            <input type='hidden' class="form-control" name="invoice_uuid" value="{{$invData->uuid or ''}}" />                            
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

                                @if(isset($invData->invoiceItems) && count($invData->invoiceItems)>0) <!-- for edit-->
                                <?php
                                  if($invData->discount_type == 0){
                                    $subTotal = $invData->amount-($invData->discount*$invData->amount/100);
                                  }else{
                                    $subTotal = $invData->amount-$invData->discount;
                                  }
                                ?>
                                 @forelse($invData->invoiceItems as $key=>$item)
                                    <div class="form-group po_items">
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item_0" name="item[]" placeholder="Item" value="{{$item->name}}">
                                        </div>    
                                        
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description_0" name="description[]" placeholder="Description" value="{{$item->description}}">
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required quantity" id="quantity_0" name="quantity[]" placeholder="Quantity" value="{{$item->quantity}}">
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required price" id="priceper_0" name="price_per[]" placeholder="Price Per Quantity" value="{{$item->unit_price}}">
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required total" id="total_0" name="total[]" placeholder="Total" value="{{$item->total}}" readonly>
                                        </div>
                                        
                                        <div class="col-sm-1">
                                           @if($key!=0)
                                             <a href="javascript:void(0)" style="color:#f00; font-size:20px;" class="remove-item"><i class="fa fa-trash-o fa-lg"></i></a> 
                                           @endif
                                            <!--<a href="#" style="color:#f00; font-size:20px;"><i class="fa fa-trash-o fa-lg"></i></a>-->
                                        </div>
                                    </div>
                                  @endforeach
                                  @elseif(old('item')!==null) <!-- for validation faild old value-->
                                    @foreach (old('item') as $i=>$val)
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
                                                <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required price" id="priceper_0" name="price_per[]" placeholder="Price Per Quantity" value="{{old('price_per')[$i]}}">
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required total" id="total_0" name="total[]" placeholder="Total" value="{{old('total')[$i]}}" readonly>
                                            </div>
                                            
                                            <div class="col-sm-1">
                                                @if($key!=0)
                                                 <a href="javascript:void(0)" style="color:#f00; font-size:20px;" class="remove-item"><i class="fa fa-trash-o fa-lg"></i></a> 
                                                @endif
                                            </div>
                                        </div>
                                   @endforeach
                                   @else
                                      <div class="form-group po_items"><!-- for default-->
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="item_0" name="item[]" placeholder="Item">
                                            </div>    
                                            
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="description_0" name="description[]" placeholder="Description">
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required quantity" id="quantity_0" name="quantity[]" placeholder="Quantity">
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required price" id="priceper_0" name="price_per[]" placeholder="Price Per Quantity">
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required total" id="total_0" name="total[]" placeholder="Total" readonly>
                                            </div>
                                            
                                            <div class="col-sm-1">
                                                <!--<a href="#" style="color:#f00; font-size:20px;"><i class="fa fa-trash-o fa-lg"></i></a>-->
                                            </div>
                                        </div>
                                  @endif
                                 </div>

                                <a id="add_more_btn" class="btn btn-primary">Add More</a>
                                
                                <div class="clearfix"></div>

                                  
                                <div class="form-group">
                                    <label for="invoice_no" class="col-sm-7 control-label">Sub Total</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="subTotal" name="amount" placeholder="Sub Total" value="{{$invData->amount or old('amount')}}" readonly required>
                                        <span id="amountErr"></span>
                                    </div>    
                                </div>
                                
                                <div class="form-group">
                                    <label for="invoice_no" class="col-sm-7 control-label">Discount</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="discount_type" id="discountType">
                                          <option value="0" @if(isset($invData)) @if($invData->discount_type==0) selected @endif @endif>Percentage</option>
                                          <option value="1" @if(isset($invData)) @if($invData->discount_type==1) selected @endif @endif>Absolute</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="discount" name="discount" placeholder="Discount" value="{{$invData->discount or old('discount')}}">
                                    </div>        
                                </div>
                                
                                <div class="form-group">
                                    <label for="invoice_no" class="col-sm-7 control-label">Sub Total</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" auto-complete="off" id="subTotalDis" name="sub_amount" placeholder="Sub Total" value="{{ $subTotal or old('sub_amount')}}" readonly>
                                    </div>    
                                </div>
                                
                                @if(isset($invData->tax_details) && !empty($invData->tax_details))
                                 @foreach(json_decode($invData->tax_details) as $key=>$taxDet)
                                 
                                    <div class="form-group tax-row" id="add_tax_row">
                                    <label for="invoice_no" class="col-sm-7 control-label tax-label">Tax {{$key+1}}</label>
                                        <div class="col-sm-1">
                                            <select class="form-control tax-type" name="tax_type[]">
                                            <option value="Tax">Select</option>
                                              @if(isset($taxData))
                                                @foreach($taxData as $name=>$tax)
                                                  <option value="{{$name}}:{{$tax}}" @if($tax==$taxDet->percentage) selected @endif>{{$name}}</option>
                                                @endforeach
                                              @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control tax ng-pristine ng-untouched ng-invalid ng-invalid-required" name="tax[]" placeholder="Tax" value="{{$taxDet->percentage or ''}}" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control tax-val ng-pristine ng-untouched ng-invalid ng-invalid-required" name="tax_value[]" placeholder="Tax Value" value="{{$taxDet->value or ''}}" readonly>
                                        </div>    
                                        <div class="col-sm-1">

                                        @if($key==0)
                                         <a href="javascript:void(0)" style="color:#337AB7;" id="add_more_tax" class="addTax"><i class="fa fa-plus-circle"></i></a>
                                         <a href="javascript:void(0)" style="color:#f00;display:none;" class="deleteTax"><i class="fa fa-trash-o"></i></a> 
                                        @else 
                                         <a href="javascript:void(0)" style="color:#f00;display:block;" class="deleteTax"><i class="fa fa-trash-o"></i></a> 
                                        @endif
                                        </div>    
                                    </div>
                                  @endforeach
                                  @else
                                    <div class="form-group tax-row" id="add_tax_row">
                                    <label for="invoice_no" class="col-sm-7 control-label tax-label">Tax 1</label>
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
                                            <input type="text" class="form-control tax-val ng-pristine ng-untouched ng-invalid ng-invalid-required" name="tax_value[]" placeholder="Tax Value" value="" readonly>
                                        </div>    
                                        <div class="col-sm-1">
                                          <a href="javascript:void(0)" style="color:#337AB7;" id="add_more_tax" class="addTax"><i class="fa fa-plus-circle"></i></a>
                                          <a href="javascript:void(0)" style="color:#f00;display:none;" class="deleteTax"><i class="fa fa-trash-o"></i></a> 
                                        </div>    
                                    </div>
                                  @endif

                                <div class="tax-row-container"></div>
                                
                                <div class="form-group">
                                    <label for="invoice_no" class="col-sm-7 control-label">Total</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="finalAmount" name="final_amount" placeholder="Total" value="{{$invData->final_amount or old('final_amount')}}" readonly required>
                                        <span id="final_amountErr"></span>
                                    </div>    
                                </div>
                                
                                <div class="form-group">
                                <label for="invoice_no" class="col-sm-1 control-label" style="text-align:left!important;"> Attachment <!-- <i class="fa fa-paperclip"></i>  --></label>
                                <div class="col-sm-4">
                                   <input type="file" name="invoice_attach[]" id="invoice_attach">
                                     @if(isset($invData->invoiceAttachments) && count($invData->invoiceAttachments)>0)
                                    <div class="jFiler-items jFiler-row">
                                     <ul class="jFiler-items-list jFiler-items-default">
                                       @foreach($invData->invoiceAttachments as $attch)
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
                                  <div class="col-sm-6">
                                   <a href="/seller/invoice" style="float:right; margin:0 0 0 20px;" class="btn btn-primary pull-right">Cancel </a>
                                   <button type="submit" class="btn btn-primary pull-right">Submit</button>
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
