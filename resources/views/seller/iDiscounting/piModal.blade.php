@if(isset($piData))
<div class="modal fade" id="iDisModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button"><i class="fa fa-check-circle fa-lg"></i> Approve</button>
        <button type="button"><i class="fa fa-times-circle fa-lg"></i> Reject</button> -->
        <!-- <button type="button" id="<?php //$piData->pi_uuid ?>" class="pi-modal btn btn-defult"><i class="fa fa-credit-card fa-lg"></i>  Cash Planner</button> -->
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      @if(!empty($piData->invoice_currency))
       <?php 
        $code=$piData->invoice_currency;
        $symbol=$currencyData[$code]['symbol_native'];
       ?>
      @else
       <?php $symbol=""; ?>
      @endif
      <h1 style="font-size:20px;">Payment Instruction </h1>
        <table class="table popup_table">
        <tbody>
          <tr>
            <th>PI No.</th>
          <td>{{ $piData->pi_number }}</td>        
          <td rowspan="3"><b>Buyer</b><br> {{ $piData->buyer_name }}<br> 
            {{ $piData->buyer_address }}<br>
          </td>
          <td rowspan="3"><b>Delivery Address</b><br> {{$piData->delivery_address }}
          
          </td>
          </tr> 
          <tr>
          <th>Invoice No.</th>
          <td>{{ $piData->invoice_number }}</td>
          </tr>   
          <tr>
          <th>Status</th>
          <td>{{$statusData['status'][$piData->invoice_status]}}</td>         
          </tr>         
          <tr>
          <th>Invoice Amount</th>
          <td>{{ $symbol }}
            {{ number_format($piData->invoice_final_amount ,2) }}  
          </td> 
          <td rowspan="3"><b>Seller</b><br> 
          {{ $piData->seller_name }} <br>
          {{ $piData->seller_address }}
          </td>         
          </tr>
          <tr>
          <th>PI Amount</th>
          <td>{{$symbol}}{{number_format($piData->pi_net_amount ,2)}}</td>                 
          </tr>
          <tr>
          <th>Due Date</th>
          <td>{{ date('d M Y',strtotime($piData->due_date)) }}</td>
          </tr>
        </tbody>
        </table>
         <div class="table-responsive">
          <table class="table table-condensed table-striped table-bordered table-hover no-margin">
            <thead>
              <tr>
                <th>
                  No.
                </th>
                <th>
                  Item Name
                </th>
                <!-- <th style="width:15%">
                  Date
                </th>  -->              
                <th>
                  Description
                </th>
                <th>
                  Quantity
                </th>
                <th>
                  Price Per Quantity
                </th>
                <th>
                  Total
                </th>
              </tr>
            </thead>
             <tbody>
               @foreach($piData->items as $item)
                <tr>
                  <td >
                    1
                  </td>
                  <td>
                    {{$item->name}}
                  </td>
                <!--<td>
                    {{date('d M, Y',strtotime($item['created_at']))}}
                  </td> -->
                  <td>
                    {{$item->description}}
                  </td>
                  <td>
                    {{$item->quantity}}
                  </td>
                  <td>
                    {{number_format($item->unit_price,2)}}
                  </td>
                  <td>
                    {{number_format($item->total,2)}}
                  </td>
                </tr>
               @endforeach 
                <tr>
                  <td class="total" colspan="4">
                    <b class="pull-right">Subtotal</b>
                  </td>
                  <td>&nbsp;</td>
                  <td>
                    {{ number_format($piData->invoice_amount,2) }}
                  </td>
                </tr>
                <tr>
                  <td class="total" colspan="4">
                    <b class="pull-right">Discount</b>
                  </td>
                  
                  @if($piData->discount_type==1)
                   <td colspan="2">
                    {{ $symbol." ".number_format($piData->invoice_discount,2)}}
                   </td>
                  @else
                  <td>
                  {{ $piData->invoice_discount }}%
                  </td>
                  <td >
                  <?php $discountAmount = ($piData->invoice_amount*$piData->invoice_discount)/100; ?>
                  {{ $symbol." ".number_format($discountAmount,2) }}
                  </td>
                  @endif
                  
                </tr>
                
                @if(isset($piData->tax_details) && !empty($piData->tax_details))
                @foreach(json_decode($piData->tax_details) as $tax)
                  <tr>
                    <td class="total" colspan="4">
                      <b class="pull-right">{{$tax->name}}</b>
                    </td>
                    <td>
                      {{$tax->percentage}}%
                    </td>
                    <td>
                      {{$symbol}}{{number_format($tax->value,2)}}
                    </td>
                  </tr>
                  @endforeach
                @else
                   <tr>
                    <td class="total" colspan="4">
                      <b class="pull-right">Tax</b>
                    </td>
                    <td>
                      0.00%
                    </td>
                    <td>
                      0.00
                    </td>
                  </tr>
                 @endif
                <tr class="success">
                  <td class="total" colspan="4">
                    <b class="pull-right">Total</b>
                  </td>
                  <td>&nbsp;</td>
                  <td>
                    {{ $symbol }}{{ number_format($piData->invoice_final_amount,2) }}
                  </td>
                </tr>
                           
          </tbody>
        </table>
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
    </div>
@endif

@if(isset($finalData))  
     <!-- Request Payment  -->
    <div id="iDescounting_remt" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Loan Details</h4>
                </div>
                <div class="modal-body">

                    <!-- Row Start -->
                    <form action="/seller/iDiscounting/requestPayment/iDisModal" method="post">
                        {!! csrf_field() !!}
                        
                        @foreach($finalData['piId'] as $key => $piId)
                          <input type="hidden" name="pi_id[]" value="{{$piId}}"/>
                          <input type="hidden" name="invNumber[]" value="{{$finalData['invNumber'][$key]}}"/>
                        @endforeach
                          <input type="hidden" name="payment_date" id="paymentDate" value="{{date('d M Y')}}"/>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="table-responsive">
                                          <div class="col-sm-12">
                                            <table class="table_borderNon">
                                                <tr>
                                                    <td colspan="3">
                                                       <h1>Step : 1 Review Invoice Details</h1>
                                                    </td>
                                                </tr>                                                          
                                                <tr>
                                                    <td>
                                                       <b>Total Invoice Amount</b>
                                                    </td>
                                                    <td>
                                                       &#2547;{{number_format($finalData['invoiceAmt'],2)}}
                                                    </td>
                                                    <td>
                                                        <b>Total PI Amount (A)</b>
                                                    </td>
                                                    <td>
                                                        &#2547;{{number_format($finalData['piAmt'],2)}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>Total Eligible Amount (B)</b>
                                                    </td>
                                                    <td>
                                                        &#2547;{{number_format($finalData['eligibleAmt'],2)}}
                                                    </td>

                                                    <td>
                                                       
                                                    </td>
                                                    <td>
                                                       
                                                    </td>
                                                </tr>

                                            </table>
                                          </div>  
                                        </div>
                                    </div>

                                    <div class="widget-body">

                                        <div class="table-responsive">
                                            <div class="col-sm-6">
                                                <table class="table_borderNon">
                                                    <tr>
                                                        <td colspan="3">
                                                            <h1>Step : 2 Select Early Payment Date</h1>
                                                            <p>Select Different dates to see different discount rates.</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Early Payment Date</b>
                                                        </td>
                                                        <td>
                                                            <label class="earlyPayDate">{{date("d M Y")}}</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Discount Rate</b>
                                                        </td>
                                                        <td>
                                                            <span id="discountRateSum">{{$finalData['discountRateSum'] or ''}}% </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Bank Charges (C)</b>
                                                        </td>
                                                        <td>
                                                            &#2547;<span id="bankChargeSum">{{number_format($finalData['bankChargeSum'],2)}}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                             <div class="col-sm-6">
                                                <div class="datepicker" data-date-end-date="{{$finalData['minDisDays']}}"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="widget-body">
                                        <div class="table-responsive">
                                         <div class="col-md-12">
                                            <table class="table_borderNon">
                                                <tr>
                                                    <td colspan="3">
                                                       <h1>Step : 3 Review Offer and Submit Request</h1>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                       <b>Early Payment Date</b>
                                                    </td>
                                                    <td>
                                                       <label class="earlyPayDate">{{date("d M Y")}}</label>
                                                    </td>                                                                                                                        </tr>
                                                  <tr>
                                                    <td>
                                                      <b>Total Loan Amount</b>
                                                    </td>
                                                    <td>
                                                      &#2547;{{number_format($finalData['eligibleAmt'],2)}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                      <b>Balance Invoice Amount Paid on Maturity (A - B - C)</b>
                                                    </td>
                                                    <td>
                                                      &#2547;<span id="balanceAmt">{{number_format(($finalData['piAmt'] - $finalData['eligibleAmt'] - $finalData['bankChargeSum']),2)}}</span>
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td colspan="2">
                                                        <hr>
                                                    </td>
                                                </tr> -->

                                                <td rowspan="5" valign="bottom">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    <button type="cancel" class="btn btn-primary">Cancel</button>
                                                </td>
                                                
                                            </table>
                                          </div>  
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Row End -->
                </div>
            </div>
        </div>
    </div>
<!-- Request Payment  -->
@endif

 