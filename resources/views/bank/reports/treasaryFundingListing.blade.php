@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">TREASARY FUNDING</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Treasary Funding
                    </div>
                  </div>
                  
                  <div class="widget-body">
                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">	<input type="text" id="config-demo" class="form-control date_filter">
                                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                              </div>
                              <div class="input-group-btn">
                                 <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button>
                              </div>
                          </div>
                      </form>
                  <div class="table-responsive">
                    <table  id="example" class="display table table-condensed table-striped table-bordered table-hover no-margin">
                      <tbody>
                        <tr>
                            <th>Currency</th>
                            <td>:</td>
                            <td>TAKA</td>
                        </tr>
                        <tr>
                            <th>Payments Receipts</th>
                            <td>:</td>
                            <td>৳ 20,000,00</td>
                        </tr>
                        <tr>
                            <th>Loans Disbursed</th>
                            <td>:</td>
                            <td>৳ 18,000,00</td>
                        </tr>
                        <tr>
                            <th>Fees Received</th>
                            <td>:</td>
                            <td>৳ 20,000</td>
                        </tr>
                        </tr>
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->

          @stop