<!--PO Modal Start-->
   <div class="modal fade" id="myModal_po" role="dialog">   
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if($poData->status == 3)
                 <button type="button" data-toggle="modal" data-target="#confirmFlipMoadal" class="btn btn-defult"><i class="fa fa-plus-circle fa-lg" style="color:#8BA870;"></i> Create Invoice</button>
                @endif 

                 <button type="button" class="btn btn-defult"><i class="fa fa-envelope fa-lg"></i> Send Message</button>
                 
                 <button type="button" id="view-attach" data-toggle="modal" data-target="#poAttachModal" class="btn btn-defult"><i class="fa fa-paperclip fa-lg"></i> Attachment</button>

                 <button type="button" class="btn btn-defult" id="print-po" ><i class="fa fa-print fa-lg"></i> Print</button>
                
                @if((\Entrust::can('seller.po.approve')) && ($poData->status != 3))
                 <button type="button" data-toggle="modal" data-target="#confirmPOApproveMoadal" class="btn btn-defult"><i class="fa fa-check-circle fa-lg"></i> Accept</button>
                @endif
                @if((\Entrust::can('seller.po.reject')) && ($poData->status != 4))
                 <button type="button" data-toggle="modal" data-target="#confirmPORejectMoadal" class="btn btn-defult"><i class="fa fa-times-circle fa-lg"></i> Decline</button>
                @endif 
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <h1 style="font-size:20px;">Purchase Order Details </h1>

                <table class="table popup_table">
                    <tbody>
                    <tr>
                        <th style="width:20%">PO No.</th>
                        <td style="width:20%">{{$poData->purchase_order_number or ''}}</td>
                        <td rowspan="3" style="vertical-align:top; width:30%"><b>Buyer</b><br>{{$buyerData->name or ''}}<br>
                            {{$buyerData->address or ''}}
                        <td rowspan="5" style="vertical-align:top; width:30%"><b>Delivery Address</b><br>
                            {{$poData->delivery_address or ''}}                         
                        </td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <?php $start_date = date("d M Y",strtotime($poData->start_date)) ?>
                        <td>{{$start_date or ''}}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <?php $end_date = date("d M Y",strtotime($poData->end_date)) ?>
                        <td>{{$end_date or ''}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                             {{$statusData['status'][$poData->status]}}
                        </td>
                        <td rowspan="3" style="vertical-align:top; width:30%"><b>Seller</b><br>{{$sellerData->name or ''}}<br>
                            {{$sellerData->address or ''}}
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{!!$symbol!!}{{number_format($poData->final_amount,2)}}</td>
                    </tr>

                    </tbody>
                </table>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                        <?php $i = 1 ?>
                        @if(isset($poItemData))
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
                            @foreach($poItemData as $poItemData)
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    {{ $poItemData->name }}
                                </td>
                                <td>
                                    {{ $poItemData->description }}
                                </td>
                                <td>
                                    {{ $poItemData->quantity }}
                                </td>
                                <td style="text-align: right;">
                                    {!!$symbol!!}{{ number_format($poItemData->unit_price,2) }}
                                </td>
                                <td style="text-align: right;">
                                   {!!$symbol!!} {{ number_format($poItemData->total,2) }}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        <!-- <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Subtotal</b>
                            </td>
                            <td class="hidden-phone">
                                {{ number_format($poData->amount,2) or ''}}
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Discount</b>
                            </td>
                            <td class="hidden-phone">
                                {{$poData->discount or ''}}
                            </td>
                        </tr> -->

                        <tr class="success">
                            <td class="total" colspan="5">
                                <b class="pull-right">Total</b>
                            </td>
                            <td class="hidden-phone" style="text-align: right;">
                                <b>{!!$symbol!!} {{ number_format($poData->final_amount,2) }}</b>
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
<!--PO Modal End-->
<!-- Attachment Invoice Modal Start  -->
     <div class="modal fade" id="poAttachModal" role="dialog" aria-labelledby="confirmAttachLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Attachments</h4>
          </div>
          <form action="{{route('seller.po.upload')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="file" name="po_attach[]" id="poAttach" multiple>
                <input type="hidden" name="po_uuid" value="{{$poData->uuid}}">
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
                                       <li>
                                         <a href="../uploads/purchase_order/{!!$attch->name!!}" class="btn btn-default fa fa-download" title="download" download></a>
                                       </li>
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
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <button type="submit" name="submit" class="btn btn-success" id="confirmApprove">Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          </form>
        </div>
       </div>
      </div>
     <!-- Attachment Invoice Modal end -->
<!-- Approve PO Modal Start -->
    <div class="modal fade" id="confirmPOApproveMoadal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Purchase Order</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure want to accept this purchase order?</p>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <a href="{{route('seller.po.approve',[$poData->uuid]) }}" class="btn btn-success" id="confirmApprove">Accept</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            
          </div>
        </div>
       </div>
      </div>

     <!-- Approve PO Modal End -->
     <!-- Reject Invoice Modal Start  -->
     <div class="modal fade" id="confirmPORejectMoadal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Decline Purchase Order</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure want to decline this purchase order?</p>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <a href="/seller/po/reject/{{$poData->uuid}}" class="btn btn-danger">Reject</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            
          </div>
        </div>
       </div>
      </div>
     <!-- Reject Invoice Modal end -->

     <!-- FlipToInvoiceConfirmation Modal Start -->
    <div class="modal fade" id="confirmFlipMoadal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Flip To Invoice</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure want to flip this purchase order to invoice?</p>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <a href="{{route('seller.invoice.flipToInvoice',[$poData->uuid]) }}" class="btn btn-success" id="confirmApprove">Yes</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            
          </div>
        </div>
       </div>
      </div>

    <!-- FlipToInvoiceConfirmation Modal End -->
