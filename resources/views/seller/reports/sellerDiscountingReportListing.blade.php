@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">SELLER DISCOUNTING</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Seller Discounting Report
                    </div>
                  </div>
                  
                  <div class="widget-body">
                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <!-- <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                  <select name="buyer" class="form-control">
                                      <option selected> Currency</option>
                                      <option> All</option>
                                      <option> USD	</option>
                                      <option> Taka</option>
                                  </select>
                              </div> -->
                              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search" value="{{Input::get('search')}}">
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo"> <input type="text" name="invoiceDate" id="config-demo" class="form-control date_filter" value="{{ Input::get('invoiceDate')}}">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                  <select name="invoiceStatus[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required lstFruits" multiple="multiple">
                                    <option value="Paid" @if(Input::get('invoiceStatus')!=null) @if(in_array("Paid",Input::get('invoiceStatus'))) selected @endif @endif>Paid</option>
                                    <option value="Submitted" @if(Input::get('invoiceStatus')!=null) @if(in_array("Submitted",Input::get('invoiceStatus'))) selected @endif @endif>Submitted</option>
                                    <option value="Approved" @if(Input::get('invoiceStatus')!=null) @if(in_array("Approved",Input::get('invoiceStatus'))) selected @endif @endif>Approved</option>
                                    <option value="Rejected" @if(Input::get('invoiceStatus')!=null) @if(in_array("Rejected",Input::get('invoiceStatus'))) selected @endif @endif>Rejected</option>
                                  </select>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-1 col-lg-1">
                                  <input type="text" name="searchLoanNo" class="form-control ng-pristine ng-untouched ng-valid" placeholder="Loan No">
                              </div>
                              <div class="input-group-btn">
                                  <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button>
                                  <input name="excelButton" type="submit" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;font-family: FontAwesome;" value="&#xf1c3;">
                              </div>
                          </div>
                      </form>
                  <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                      <thead>
                        <tr>
                            <th>PI Number</th>
                            <th>Invoice Number</th>
                            <th>Buyer Name</th>
                            <th>Discounting Date</th>
                            <th>Currency</th>
                            <th>Invoice Amount</th>
                            <th>PI Amount</th>
                            <th>Discounting Amount</th>
                            <th>Bank Charges</th>
                            <th>Discounting Status</th>
                            <th>Paid Amount</th>
                            <th>Payment Date</th>
                            <th>Maturity Date</th>
                            <th>Remaining Payment</th>
                            <th>Bank Loan Number</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(isset($iReqData))
                       @foreach($iReqData as $key => $iReqDataVal)
                        <tr>                          
                          <td>{{$iReqDataVal->pi_number}}</td>
                          <td>{{$iReqDataVal->invoiceNumber}}</td>
                          <td>{{$iReqDataVal->buyerName}}</td>
                          <td>{{date('d M Y',strtotime($iReqDataVal->discountingDate))}}</td>
                          <td>{{$iReqDataVal->currency}}</td>
                          <td style="text-align: right;">{{$currencyData[$iReqDataVal->currency]['symbol_native'] or ''}}{{$iReqDataVal->invoiceAmt}}</td>
                          <td style="text-align: right;">{{$currencyData[$iReqDataVal->currency]['symbol_native'] or ''}}{{$iReqDataVal->piAmount}}</td>
                          <td style="text-align: right;">{{$currencyData[$iReqDataVal->currency]['symbol_native'] or ''}}{{$iReqDataVal->loanAmount}}</td>
                          <td style="text-align: right;">{{$currencyData[$iReqDataVal->currency]['symbol_native'] or ''}}{{number_format($bankCharge[$key],2)}}</td>
                          <td>{{$statusData['status'][$iReqDataVal->status]}}</td>
                          <td style="text-align: right;">-</td>
                          <td>{{date('d M Y',strtotime($iReqDataVal->loan_date))}}</td>
                          <td>{{date('d M Y',strtotime($iReqDataVal->dueDate))}}</td>
                          <td style="text-align: right;">$ </td>
                          <td>{{$iReqDataVal->discountingId}}</td>
                        </tr>
                        @endforeach
                       @else
                        <tr>
                          <td colspan="15">No Data Found</td>
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

          @stop