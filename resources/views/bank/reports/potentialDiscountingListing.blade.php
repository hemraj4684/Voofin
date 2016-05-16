@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">POTENTIAL DISCOUNTING</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Potential Discounting Report
                    </div>
                  </div>
                  
                  <div class="widget-body">

                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search">
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
                            <th>Approved Invoice Amount <i class="fa fa-info-circle" title=" Shows total of all approved invoices that are eligible for discounting based on the min and max discounting set as per Bank configuration."></i></th>
                            <th>Eligible Discounting Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Abul Khair Group </td>
                          <td>TAKA</td>
                          <td style="text-align:right;"><b>&#2547;</b> 200,345,660</td>
                          <td style="text-align:right;"><b>&#2547;</b> 180,311,094</td>
                        </tr>
                        <tr>
                            <td>Kenpark Bangladesh (Pvt) Ltd</td>
                            <td>TAKA</td>
                            <td style="text-align:right;"><b>&#2547;</b> 130,000,000</td>
                            <td style="text-align:right;"><b>&#2547;</b> 117,000,000</td>
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