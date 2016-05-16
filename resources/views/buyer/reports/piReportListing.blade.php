@extends('buyer.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BUYER PI REPORT </a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Buyer PI Report
                    </div>
                  </div>
                  
                  <div class="widget-body">
                    <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                      <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                          <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search" value="{{$querystringArray['search'] or ''}}">
                        </div>
            
                       <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                        <select name="piStatus[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required lstFruits" multiple="multiple">
                          <option value="Paid" @if(Input::get('piStatus')!=null) @if(in_array("Paid",Input::get('piStatus'))) selected @endif @endif>Paid</option>
                          <option value="Unpaid" @if(Input::get('piStatus')!=null) @if(in_array("Unpaid",Input::get('piStatus'))) selected @endif @endif>Unpaid</option>
                        </select>             
                       </div>
                  
                       <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">  <input type="text" name="piDate" id="config-demo" class="form-control date_filter" value="{{$querystringArray['invoiceDate'] or ''}}">
                         <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                       </div>
            
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
                        <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='/buyer/buyerPIReport';" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
                        <input name="excelButton" type="submit" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;font-family: FontAwesome;" value="&#xf1c3;">
                      </div>
                    </div>
                  </form>
                  <div class="table-responsive">
                    <table class="display table table-condensed table-striped table-bordered table-hover no-margin">
                      <thead>
                        <tr>
                            <th>PI Number</th>
                            <th>Invoice Number</th>
                            <th>Seller Name</th>
                            <th>Currency</th>
                            <th>PI Amount</th>
                            <th>Maturity Date</th>
                            <th>Payment Status</th>
                            <th>Approval Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(isset($piData))
                        @foreach($piData as $key => $val)
                        <tr>                          
                          <td>{{$val->pi_number}}</a> </td>
                          <td>{{$val->invoice_number}}</a></td>
                          <td>{{$val->seller_name}}</td>
                          <td>{{$val->invoice_currency}}</td>
                          <td style="text-align:right;">{{$val->pi_net_amount}}</td>
                          <td>{{date('d M Y',strtotime($val->due_date))}}</td>
                          <td>{{$statusData['status'][$val->pi_status]}}</td>
                          <td>{{date('d M Y',strtotime($val->pi_approval_date))}}</td>
                        </tr>
                        @endforeach
                      @endif  
                      </tbody>
                    </table>
                    {!!$piData->render()!!}
                   </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->

          @stop