@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">DISCOUNTING USAGE</a></li>
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

                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search">
                              </div>
                          
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
                      <thead>
                        <tr>
                            <th>Seller Name</th>
                            <th>Currency</th>
                            <th>Approved Invoice Amoun</th>
                            <th> Actual Discounted Amount</th>
                            <th>Eligible Discounting Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>MRF </td>
                          <td>USD</td>
                          <td style="text-align:right;">$ 1,30,000</td>
                          <td style="text-align:right;">$ 2300</td>
                          <td style="text-align:right;">$ 2300</td>
                        </tr>
                        <tr>
                            <td>Alfa</td>
                            <td>TAKA</td>
                            <td style="text-align:right;"><b>&#2547;</b> 2,30,000</td>
                            <td style="text-align:right;"><b>&#2547;</b> 1000</td>
                            <td style="text-align:right;"><b>&#2547;</b> 1000</td>
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