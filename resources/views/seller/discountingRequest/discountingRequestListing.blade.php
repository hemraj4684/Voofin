@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">DISCOUNTING REQUEST </a></li>
  </ul>
@stop
@section('content')
 <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                 
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
						         Discounting Request
                    </div>
                    <!--<span class="tools">
                      <button class="btn btn-primary btn-sm" type="button"><i class="icon-envelope"></i> Request Payment </button>
                    </span>-->
                  </div>
                   <div class="widget-body">
                    <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                      <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                          <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2"> 
                          <select name="invoiceStatus[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required lstFruits" multiple="multiple">
                            <option value="Created" @if(Input::get('invoiceStatus')!=null) @if(in_array("Created",Input::get('invoiceStatus'))) selected @endif @endif>Created</option>
                            <option value="Submitted" @if(Input::get('invoiceStatus')!=null) @if(in_array("Submitted",Input::get('invoiceStatus'))) selected @endif @endif>Submitted</option>
                            <option value="Internal Reject" @if(Input::get('invoiceStatus')!=null) @if(in_array("Internal Reject",Input::get('invoiceStatus'))) selected @endif @endif>Internal Reject</option>
                            <option value="Rejected" @if(Input::get('invoiceStatus')!=null) @if(in_array("Rejected",Input::get('invoiceStatus'))) selected @endif @endif>Rejected</option>
                            <option value="Approved" @if(Input::get('invoiceStatus')!=null) @if(in_array("Approved",Input::get('invoiceStatus'))) selected @endif @endif>Approved</option>
                            <option value="Disbursed" @if(Input::get('invoiceStatus')!=null) @if(in_array("Disbursed",Input::get('invoiceStatus'))) selected @endif @endif>Disbursed</option>
                            <option value="Closed" @if(Input::get('invoiceStatus')!=null) @if(in_array("Closed",Input::get('invoiceStatus'))) selected @endif @endif>Closed</option>
                          </select>             
                        </div>
                        
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo"> <input type="text" name="invoiceDate" id="config-demo" class="form-control date_filter" value="{{ Input::get('invoiceDate')}}">
                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        </div>

                        <div class="input-group-btn col-lg-1">
                          <button type="submit" class="btn btn-sm btn-info mr10"><span class="fa fa-search"></span></button> 
                        </div>
                        </form>

                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 pull-right" style="border-left:1px solid #ccc;"> 
                          <i class="fa fa-info-circle fa-lg" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."></i>
                          <span class="col-sm-11 pull-right">
                            @if($approveRejectButton === "Y")
                            <select name="buyer" class="form-control changeDiscountingStatus">
                              <option>Submit / Reject Request</option>
                              <option value="1">Submit Request</option>
                              <option value="2">Reject Request</option>                                                          
                            </select>
                            @endif
                          </span>
                        </div>

                        </div>  
                      </div>


                  <div class="widget-body">                 
                    <div class="table-responsive">
                      <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                          <tr>
                            <th>
                              <input type="checkbox" id="disReqcheckAll">
                            </th>
              							<th>
                              Invoice Number
                            </th>
                            <th>
                              Buyer
                            </th>
              							<th>
                              Discount Date
                            </th>
              							<th>
                              Due Date
                            </th>
                            <th>
                              Days to Payment
                            </th>
                            <th>
                              PI Amount
                            </th>
							              <th>
                              Eligibilty (%)
                            </th>
							              <th>
                              Bank Charges
                            </th>
                            <th>
                              Loan Amount
                            </th>
							              <th>
                              Status
                            </th>
                            <th>
                              Action
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(isset($iReqData))
                          @foreach($iReqData as $key => $valiReqData)
                          <tr>
                            <td>
                              <input type="checkbox" class="discountingChk" @if(in_array($valiReqData->status, array(2,4,6))) disabled @endif>
                            </td>
						                <td>
                              <a href="javascript:void(0);" class="iDisModal link_A_blue" data-id="{{$valiReqData->pi_uuid}}" data-toggle="modal" >{{$valiReqData->invoiceNumber}}</a>
                            </td>
                            <td>{{$valiReqData->buyerName}}</td>
						                <td>{{date('d M Y',strtotime($valiReqData->discountingDate))}}</td>
							              <td>{{date('d M Y',strtotime($valiReqData->dueDate))}}</td>
                            <td>{{(strtotime($valiReqData->dueDate)- strtotime($valiReqData->discountingDate))/(60*60*24)}}</td><!-- days to payment is pending -->
                            <td style="text-align:right;">
                              ৳ {{number_format($valiReqData->piAmount,2)}}
                            </td>
							              <td>{{$valiReqData->eligiblity}}</td>
							              <td style="text-align:right;">
                               ৳ {{number_format($bankCharge[$key],2)}}
                            </td>
                            <td style="text-align:right;">
                               ৳ {{number_format($valiReqData->loanAmount,2)}}
                            </td>
							              <td style="text-align:left;">
                               <i class="{{$statusData['symbols'][$statusData['status'][$valiReqData->status]]}}"></i>
                               {{$statusData['status'][$valiReqData->status]}}
                            </td>
                            <td>
                            @if($approveRejectButton === "Y")
                            <a @if(in_array($valiReqData->status, array(1,3,2,4,6))) style="display:none" @endif href="javascript:void(0);" class="btn btn-success btn-xs discounting" data-original-title="Submit Request" data-disId="{{$valiReqData->uuid}}" data-statusId="1">
                              <i class="fa fa-check"></i>
                            </a>
                            <a @if(in_array($valiReqData->status, array(1,2,4,6))) style="display:none" @endif href="javascript:void(0);" class="btn btn-danger btn-xs discounting" data-original-title="Reject Request" data-disId="{{$valiReqData->uuid}}" data-statusId="2">
                              <i class="fa fa-times fa-lg"></i>
                            </a>
                            @endif
                            </td>
                          </tr>
                          @endforeach
                         @else
                         <tr>
                          <td colspan="11">
                            No Record found
                          </td>
                         </tr>
                         @endif                      
                        </tbody>
                      </table>
                      {!!$iReqData->render()!!}
                    </div>
		              </div>
                </div>
              </div>
            </div>
<!-- Row End -->

 <!--Payment Instruction Modal Start-->
    <div id="iDisModalContainer"></div>
 <!-- Payment Instruction Modal End-->

<!-- Reject PI Modal Start  -->
     <div class="modal fade" id="confirmRejectMoadal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Reject Payment Instruction</h4>
          </div>
          <form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" role="form" method="post" action="{{route('seller.iDiscounting.postApprove')}}">
          {{ csrf_field() }}
          <div class="modal-body">
            <p>Are you sure want to reject this payment instructions?</p>
            <div class="row">
             <!--  <label for="remarks" class="col-sm-4 control-label">Remark</label> -->
              <div class="col-sm-12">
                <textarea class="form-control" rows="4" id="remarks" name="remarks" placeholder="Remark"></textarea>
                <input type="hidden" name="discountingId" class="discountingId" value="">
                <input type="hidden" name="statusId" class="statusId" value="">
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
<!-- Reject PI Modal Start  -->

   <!-- Approve PI Modal end -->
    <div class="modal fade" id="confirmApproveMoadal" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
      <form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" role="form" method="post" action="{{route('seller.iDiscounting.postApprove')}}">
          {{ csrf_field() }}
          <input type="hidden" name="discountingId" class="discountingId" value="">
          <input type="hidden" name="statusId" class="statusId" value="">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Approve Discouting Request</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure want to approve this Discouting Request?</p>
          </div>
          <div class="modal-footer">
          <input type="hidden" class="route_url">
            <button type="submit"  class="btn btn-default" id="confirmAccept">Approve</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
        </form>
       </div>
      </div>
   <!-- Approve PI Modal end -->
@stop
