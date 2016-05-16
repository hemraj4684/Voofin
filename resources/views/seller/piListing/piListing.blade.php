@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">PAYMENT INSTRUCTION </a></li>
  </ul>
@stop
@section('content')
 <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                 @if(session()->has('errorMessage'))
                  <div class="alert alert-danger" role="alert">
                  {{session('errorMessage')}}
                  </div>
                 @endif
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
						         Payment Instruction List
                    </div>
                    <!--<span class="tools">
                      <button class="btn btn-primary btn-sm" type="button"><i class="icon-envelope"></i> Request Payment </button>
                    </span>-->
                  </div>
                   
                  <div class="widget-body">
                   <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                      <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                          <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search" value="{{$querystringArray['search'] or ''}}">
                        </div>
            
                       <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                        <select name="piStatus[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required lstFruits" multiple="multiple">
                          <option value="Approved" @if(Input::get('piStatus')!=null) @if(in_array("Approved",Input::get('piStatus'))) selected @endif @endif>Approved</option>
                          <option value="Partially Paid" @if(Input::get('piStatus')!=null) @if(in_array("Partially Paid",Input::get('piStatus'))) selected @endif @endif>Partially Paid</option>
                          <option value="Paid" @if(Input::get('piStatus')!=null) @if(in_array("Paid",Input::get('piStatus'))) selected @endif @endif>Paid</option>
                        </select>             
                       </div>
                  
                       <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">  <input type="text" name="piDate" id="config-demo" class="form-control date_filter" value="{{$querystringArray['invoiceDate'] or ''}}">
                         <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                       </div>
            
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
                        <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='/seller/piListing';" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
                        <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><i class="fa fa-file-excel-o"></i></button>
                      </div>
                    </div>
                  </form>
                    <div class="table-responsive">
                      <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                          <tr>
              							<th>
              								<input type="checkbox">
              							</th>
              							<th>
                              Invoice Number
                            </th>
              							<th>
                              Buyer
                            </th>
              							<th>
                              Due Date
                            </th>
                            <th>
                              Discounting Days
                            </th>

                            <th>
                              PI Amount
                            </th>

							              <th>
                              Eligibilty Percentage
                            </th>

							              <th>
                              Bank Charges
                            </th>

                            <th>
                              Eligible Amount
                            </th>

							              <th>
                              Status
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                     
                        @forelse($piData as $k => $pi)

                          @if(!empty($pi->invoice_currency))
                            <?php 
                             $code=$pi->invoice_currency;
                             $symbol=$currencyData[$code]['symbol_native'];
                            ?>
                          @else
                            <?php $symbol=""; ?>
                          @endif

                          <tr>
						                <td>
                              <input type="checkbox">
                            </td>
						                <td class="hidden-phone">
                              <!-- <a href="#" class="link_A_blue" data-toggle="modal" data-target="#pi_Modal">B697F12</a> -->
                              <a href="javascript:void(0);" data-id="{{$pi->pi_uuid}}" class="link_A_blue iDisModal">{{$pi->invoice_number}}</a>
                            </td>
						                <td>
                             {{ $pi->buyer_name }} 
                            </td>
							              <td>
                             {{ date('d M Y',strtotime($pi->due_date)) }}
                            </td>
                            <td>
                            @if($pi->discounting_days>0)
                               {{ $pi->discounting_days }}
                            @else
                               0
                            @endif 
                            </td>

                            <td style="text-align: right;">
                               {{$symbol}} {{number_format($pi->pi_net_amount,2)}}
                            </td>

							              <td>
                               {{ $pi->discounting }}%
                            </td>

							              <td style="text-align: right;">
                               {{ $symbol }}{{number_format($bankChargeData[$k],2)}}
                            </td>

                            <td style="text-align: right;">
                               {{ $symbol }}{{ number_format($pi->discounted_amount,2) }}
                            </td>
							              <td style="text-align:left;">
                                 <i class="{{$statusData['symbols'][$statusData['status'][$pi->pi_status]] or ''}} wight_ntf"></i>
                                 {{ $statusData['status'][$pi->pi_status] or ''}}
                                                               
                            </td>
                          </tr>
                          @empty
                            <tr>
                              <td colspan="9" style="text-align:center"><strong>No More Records</strong></td>
                            </tr>
                        @endforelse

                        </tbody>
                      </table>
                    </div>
                   
		              </div>
                </div>
              </div>
            </div>
<!-- Row End -->

<!-- PI Modal -->
<div id="iDisModalContainer"></div>
<div id="piModal"></div>


@stop
