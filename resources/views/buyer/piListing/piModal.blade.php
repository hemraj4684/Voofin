<div class="modal fade" id="pi_modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
      @permission('buyer.piListing.approve')
        @if($piData->pi_status == 0 || $piData->pi_status == 2)
           <button type="button" data-toggle="modal" data-target="#confirmApproveMoadal" class="btn btn-defult"><i class="fa fa-check-circle fa-lg"></i> Approve</button>
        @endif

        @if($piData->pi_status == 0 || $piData->pi_status == 1)
          <button type="button" data-toggle="modal" data-target="#confirmRejectMoadal" class="btn btn-defult"><i class="fa fa-times-circle fa-lg"></i> Reject</button>
        @endif
      @endpermission
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <div class="modal-body">
      @if(!empty($piData->invoice_currency))
       <?php 
       $code = $piData->invoice_currency;
       $symbol = $currencyData[$code]['symbol_native'];
       ?>
      @else
       <?php $symbol = "";?>
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
          <td rowspan="3"><b>Delivery Address</b><br>
                         {{ $piData->delivery_address }}
          </td>
          </tr> 
          @if(!empty($piData->invoice_id))

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
          @endif
              <tr>
              <th>PI Amount</th>
              <td>{{ $symbol }}{{ number_format($piData->pi_net_amount ,2) }}</td>                 
              </tr>
              <tr>
              <th>Due Date</th>
              <td>{{ date('d M Y',strtotime($piData->due_date)) }}</td>
              </tr>
        
        </tbody>
        </table>
        @if(!empty($piData->invoice_id))
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
              <?php $i = 1; ?>
               @foreach($piData->items as $item)
                <tr>
                  <td >
                    {{ $i++ }}
                  </td>
                  <td>
                    {{$item->name}}
                  </td>
                  <td>
                    {{$item->description}}
                  </td>
                  <td>
                    {{$item->quantity}}
                  </td>
                  <td style="text-align:right;">
                    {{number_format($item->unit_price,2)}}
                  </td>
                  <td style="text-align:right;">
                    {{number_format($item->total,2)}}
                  </td>
                </tr>
               @endforeach 
                <tr>
                  <td class="total" colspan="4">
                    <b class="pull-right">Subtotal</b>
                  </td>
                  <td>&nbsp;</td>
                  <td style="text-align:right;">
                    {{ number_format($piData->invoice_amount,2) }}
                  </td>
                </tr>
                <tr>
                  <td class="total" colspan="4">
                    <b class="pull-right">Discount</b>
                  </td>
                  
                  @if($piData->discount_type==1)
                   <td colspan="2" style="text-align:right;">
                    {{ $symbol." ".number_format($piData->invoice_discount,2)}}
                   </td>
                  @else
                  <td style="text-align:right;">
                  {{ $piData->invoice_discount }}%
                  </td>
                  <td style="text-align:right;">
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
                    <td style="text-align:right;">
                      {{$tax->percentage}}%
                    </td>
                    <td style="text-align:right;">
                      {{ $symbol }}
                      {{number_format($tax->value,2)}}
                    </td>
                  </tr>
                  @endforeach
                @else
                   <tr>
                    <td class="total" colspan="4">
                      <b class="pull-right">Tax</b>
                    </td>
                    <td style="text-align:right;">
                      0.00%
                    </td>
                    <td style="text-align:right;">
                      0.00
                    </td>
                  </tr>
                 @endif
                <tr class="success">
                  <td class="total" colspan="4">
                    <b class="pull-right">Total</b>
                  </td>
                  <td>&nbsp;</td>
                  <td style="text-align:right;">
                    <b>{{ $symbol }} {{ number_format($piData->invoice_final_amount,2) }}</b>
                  </td>
                </tr>
                           
                </tbody>
              </table>
            </div>
        @endif                    
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
    </div>
   <!-- Approve PI Modal end -->
    <div class="modal fade" id="confirmApproveMoadal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Approve Payment Instruction</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure want to approve this payment instructions?</p>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <a href="{{route('buyer.piListing.approve',[$piData->pi_uuid])}}" class="btn btn-success" id="confirmApprove">Approve</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            
          </div>
        </div>
       </div>
      </div>

     <!-- Approve PI Modal end -->
     <!-- Reject PI Modal Start  -->
     <div class="modal fade" id="confirmRejectMoadal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Reject Payment Instruction</h4>
          </div>
          <form class="form-horizontal" role="form" method="post" action="/piListing/reject">
          {{ csrf_field() }}
          <div class="modal-body">
            <p>Are you sure want to reject this payment instructions?</p>
            <div class="row">
             <!--  <label for="remarks" class="col-sm-4 control-label">Remark</label> -->
              <div class="col-sm-12">
                <textarea class="form-control" rows="4" id="remarks" name="remarks" placeholder="Remark"></textarea>
                <input type="hidden" name="pi_id" value="{{$piData->pi_uuid}}">
              </div>  
            </div>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <button type="submit"  class="btn btn-danger" id="confirmReject">Reject</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          </form>
        </div>
       </div>
      </div>