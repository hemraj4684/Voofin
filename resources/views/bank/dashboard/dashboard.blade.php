@extends('bank.layouts.default')
@section('content')
<!-- Row Start -->
<!-- <div class="row">
    <div class="col-lg-12 col-md-12">
            <div class="widget">
              <div class="widget-header">
                      <div class="title">
                        Recent Notifications
                      </div>	      
              </div>

              <div class="widget-body">                  
                      <p class="notifications_dashdoard"><b> PO : </b> You have Recived New PO of ৳5,000,000 that need your attention
                       <span class="tools pull-right">
                        <a href="#" class="btn btn-primary btn-sm"> Review </a>
                        <a href="#" class="btn btn-primary btn-sm">Hide </a>
                      </span>
                      </p>
                      <p><b> PO : </b> You have Recived New PO of ৳5,000,000 that need your attention
                       <span class="tools pull-right">
                        <a href="#" class="btn btn-primary btn-sm"> Review </a>
                        <a href="#" class="btn btn-primary btn-sm">Hide </a>
                      </span>
                      </p>
              </div>                
            </div>
    </div>
</div> -->
<!-- Row End -->

<!-- Row starts -->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col5">
        <div class="mini-widget">
            <div class="mini-widget-heading clearfix">
                <div class="pull-left">Buyers + Sellers</div>                     
            </div>
            <div class="mini-widget-body clearfix">
                <div class="pull-left">
                    <i class="fa fa-users"></i>
                </div>
                <div class="pull-right number"> {{$data['bankBuyerSeller']}}</div>
            </div>
        </div>
    </div>     
    <div class="col-lg-3 col-md-3 col-sm-6 col5">
        <div class="mini-widget">
            <div class="mini-widget-heading clearfix">
                <div class="pull-left">Approved Loans(Month to date)</div>
                   <!-- <div class="pull-right dropdown"><a href="#" id="nav-visitors" class="dropdown-toggle" data-toggle="dropdown">Last 7 days <i class="fa fa-angle-down"></i> </a>
                      <ul class="dropdown-menu boxmenu" role="menu" aria-labelledby="nav-visitors">
                        <li><a href="#">Last 7 days</a></li>
                        <li><a href="#">Last 30 days</a></li>
                      </ul>
                   </div> -->
            </div>
            <div class="mini-widget-body clearfix">
                <div class="pull-left">
                    <i class="fa fa-thumbs-up"></i>
                </div>
                <div class="pull-right number">৳ {{number_format(floor($data['approvedLoan']))}}</div>
            </div>
        </div>
    </div>    
    <div class="col-lg-3 col-md-3 col-sm-6 col5">
        <div class="mini-widget">
            <div class="mini-widget-heading clearfix">
                <div class="pull-left">Maturing Loans (In 7 Days)</div>
            </div>
            <div class="mini-widget-body clearfix">
                <div class="pull-left">
                    <i class="fa fa-money"></i>
                </div>
                <div class="pull-right number">৳ {{number_format(floor($data['maturityLoan']))}}</div>
            </div>
        </div>
    </div> 
    <div class="col-lg-3 col-md-3 col-sm-6 col5">
        <div class="mini-widget">
            <div class="mini-widget-heading clearfix">
                <div class="pull-left">Pending Loans</div>    
            </div>
            <div class="mini-widget-body clearfix">
                <div class="pull-left">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="pull-right number"> ৳ {{number_format(floor($data['pendingLoan']))}}</div>
            </div>
        </div>

    </div>
</div>
<!-- Row ends -->

<!-- Row Start -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    Last 10 Loan Requests
                </div>
                <span class="tools">
                    <a href="{{URL::route('seller.piListing.view')}}" class="btn btn-primary btn-sm" type="button"> View All </a>

                </span>
            </div>
            <div class="widget-body">                    

                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                            <tr>
                                <th>
                                    Invoice Number
                                </th>
                                <th>
                                    Seller
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
                                    PI Amount
                                </th>           
                                <th>
                                    Eligibility (%)
                                </th>          
                                <th>
                                    Bank Charges
                                </th>          
                                <th>
                                    Loan Amount
                                </th>          
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data['lastTenLoan'])
                            @foreach($data['lastTenLoan'] as $data)
                            <tr>
                                <td>
                                    <a href="javascript:void(0);" class="iDisModal link_A_blue" data-id="{{$data->pi_uuid}}" data-toggle="modal" >{{$data->invoiceNumber}}</a>
                                </td>
                                <td>{{$data->sellerName}}</td>
                                <td>{{$data->buyerName}}</td>
                                <td>{{date('d M Y',strtotime($data->discountingDate))}}</td>
                                <td>{{date('d M Y',strtotime($data->dueDate))}}</td>
                                <td style="text-align:right">
                                    ৳ {{number_format($data->net_pi_amount,2)}}
                                </td>
                                <td>{{$data->eligiblity}}</td>
                                <td style="text-align:right">
                                    ৳ {{number_format($data->bankCharge,2)}}
                                </td>
                                <td style="text-align:right">
                                    ৳ {{number_format($data->loanAmount,2)}}
                                </td>
                                <td>
                                @if($approveRejectButton == 'Y')
                                    <a class="btn btn-success btn-xs discounting" title="Approved">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs discounting" title="Rejected">
                                        <i class="fa fa-times fa-lg"></i>
                                    </a>
                                @endif    
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            
                        </tbody>
                    </table>       
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
           <!-- <form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" role="form" method="post" 
           @if(\Entrust::can('bank.iDiscounting.makerPostApprove')) action="{{route('bank.iDiscounting.makerPostApprove')}}" @elseif(\Entrust::can('bank.iDiscounting.postApprove')) action="{{route('bank.iDiscounting.postApprove')}}" @endif> -->
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
     <!--  <form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" role="form" method="post" 
       @if(\Entrust::can('bank.iDiscounting.makerPostApprove')) action="{{route('bank.iDiscounting.makerPostApprove')}}" @elseif(\Entrust::can('bank.iDiscounting.postApprove')) action="{{route('bank.iDiscounting.postApprove')}}" @endif> -->
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
   <!-- Approve PI Modal end -->
@stop