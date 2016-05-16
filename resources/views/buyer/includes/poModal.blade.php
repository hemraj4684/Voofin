<!--PO Modal Start-->
 <div class="modal fade" id="myModal_po" role="dialog">   
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button"><i class="fa fa-plus-circle fa-lg" style="color:#8BA870;"></i> Flip to Invoice</button> -->
                <button type="button" class="btn btn-defult"><i class="fa fa-envelope fa-lg"></i> Send Message</button>
                <button type="button" id="view-attach" data-toggle="modal" data-target="#poAttachModal" class="btn btn-defult"><i class="fa fa-paperclip fa-lg"></i> Attachment</button>
                <button type="button" class="btn btn-defult" id="print-po" ><i class="fa fa-print fa-lg"></i> Print</button>

                @if((\Entrust::can('buyer.po.approve')) && isset($poData->status) && in_array($poData->status,array(0,2))) 
                 <button type="button" data-toggle="modal" data-target="#confirmPOApproveMoadal" class="btn btn-defult"><i class="fa fa-check-circle fa-lg"></i> Approve</button>
                @endif
                @if((\Entrust::can('buyer.po.reject')) && isset($poData->status) && in_array($poData->status,array(0,1)))
                 <button type="button" data-toggle="modal" data-target="#confirmPORejectMoadal" class="btn btn-defult"><i class="fa fa-times-circle fa-lg"></i> Reject</button>
                @endif
                @if(isset($poData->status) && in_array($poData->status,array(0,1,2)))
                 <button type="button" onclick="window.location.href='{{route('buyer.po.edit',[$poData->uuid])}}'" class="btn btn-defult"><i class="fa fa-pencil-square-o fa-lg"></i> Edit</button>
                 <button type="button" class="delete_po btn btn-defult" data-toggle="modal" data-target="#confirmDelete" data-title="Delete PO" 
                data-message="Are you sure you want to delete this PO ?" data-url="{{route('buyer.po.delete',[$poData->uuid])}}"><i class="fa fa-trash-o fa-lg"></i> Delete </button>
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
                          <?php 
                              if(isset($poData->start_date))
                                $start_date = date("d M Y",strtotime($poData->start_date));
                          ?>
                        <td>{{$start_date or ''}}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                          <?php 
                            if(isset($poData->start_date))
                             $end_date = date("d M Y",strtotime($poData->end_date));
                          ?>
                        <td>{{$end_date or ''}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                        @if(isset($poData->status))
                           {{$statusData['status'][$poData->status]}}
                        @endif 
                        </td>
                        <td rowspan="3" style="vertical-align:top; width:30%"><b>Seller</b><br>{{$sellerData->name or ''}}<br>
                            {{$sellerData->address or ''}}
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td><i class="fa fa-usd"></i>{{$poData->final_amount or ''}}</td>
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
                                <td style="text-align:right;">
                                    {{ number_format($poItemData->unit_price,2) }}
                                </td>
                                <td style="text-align:right;">
                                    {{ number_format($poItemData->total,2) }}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        <tr class="success">
                            <td class="total" colspan="5">
                                <b class="pull-right">Total</b>
                            </td>
                            <td style="text-align:right;">
                              @if(isset($poData->final_amount))
                                <b>{{number_format($poData->final_amount,2)}}</b>
                              @endif
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
          <form action="{{route('buyer.po.upload')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="file" name="po_attach[]" id="poAttach" multiple>
                <input type="hidden" name="po_uuid" value="{{$poData->uuid or ''}}">
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
                                   <div class="jFiler-item-title" title="{{$attch->name}}">{{$attch->name or ''}}</div>
                                   <div class="jFiler-item-others"></div>
                                   <div class="jFiler-item-assets">
                                     <ul class="list-inline">
                                       <li>
                                         <a href="../uploads/purchase_order/{!!$attch->name!!}" class="btn btn-default fa fa-download" title="download" download></a>
                                       </li>
                                        <li>
                                         <a class="btn btn-default fa fa-trash-o delete-attach" id="{{$attch->id}}"></a>
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
            <p>Are you sure want to approve this purchase order?</p>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <a href="@if(isset($poData->uuid)){{URL::to('buyer/po/approve',[$poData->uuid]) }}@endif" class="btn btn-success" id="confirmApprove">Approve</a>
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
            <h4 class="modal-title">Reject Purchase Order</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure want to reject this purchase order?</p>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <a href="@if(isset($poData->uuid)){{route('buyer.po.reject',[$poData->uuid])}}@endif" class="btn btn-danger" id="confirmReject">Reject</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            
          </div>
        </div>
       </div>
      </div>
     <!-- Reject Invoice Modal end -->
