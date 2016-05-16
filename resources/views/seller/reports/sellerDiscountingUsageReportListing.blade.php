@extends('seller.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading">DISCOUNTING USAGE </a></li>
  </ul>
@stop
@section('content')
          
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Discounting Usage Report
                    </div>
                  </div>
                  
                  <div class="widget-body">
                      <form class="form-horizontal" role="form" name="search_poi">
                          <div class="form-group">

                             <!--<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search">
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">

                                  <select name="buyer" class="form-control">
                                      <option selected> Currency</option>
                                      <option> All</option>
                                      <option> USD  </option>
                                      <option> Taka</option>
                                  </select>
                              </div> -->

                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control" id="serch" placeholder="Buyer Name" value="{{$querystringArray['search'] or ''}}">
                              </div>

                              <div class="input-group-btn">
                                  <button type="submit" class="btn btn-sm btn-info mr10" ><span class="fa fa-search"></span></button>
                                  <input type="submit" name="excelBtn" class="btn btn-sm btn-info" style="margin:0 0 0 10px; font-family: FontAwesome;" value="&#xf1c3;">
                              </div>
                          </div>
                      </form>
                  <div class="table-responsive">
                    <table class="display table table-condensed table-striped table-bordered table-hover no-margin">
                      <thead>
                        <tr>
                            <th>Buyer Name</th>
                            <th>Currency</th>
                            <th>Approved PI Amount</th>
                            <th>Actual Discounted Amount</th>
                            <th>Eligible Discounting Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                      @forelse($discountingData as $discounting)
                          @if(!empty($discounting->invoice_currency))
                            <?php 
                             $code=$discounting->invoice_currency;
                             $symbol=$currencyData[$code]['symbol_native'];
                            ?>
                          @else
                            <?php $symbol=""; ?>
                          @endif
                        <tr>
                          <td>{{ $discounting->buyer_name }}</td>
                          <td>{{ $discounting->invoice_currency }}</td>
                          <td style="text-align: right;">&#2547;{{ number_format($discounting->total_pi_amount,2) }}</td>
                          <td style="text-align: right;">&#2547;{{ number_format($discounting->total_loan_amount,2) }}</td>
                          <td style="text-align: right;">&#2547;{{ number_format($discounting->total_eligible_amount,2) }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" style="text-align:center"><strong>No More Records</strong></td>
                        </tr>
                      @endforelse
                      </tbody>
                    </table>
                   </div>
                   {!! $discountingData->appends($querystringArray)->render() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->

          @stop