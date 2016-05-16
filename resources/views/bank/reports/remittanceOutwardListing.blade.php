@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">REMITTANCE OUTWARD</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Remittance Outward
                    </div>
                  </div>
                  
                  <div class="widget-body">
                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Seller Name">
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Invoice ID">
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Loan ID">
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
                            <th>Loan ID</th>
                            <th>Loan Amount</th>
                            <th>Invoice Amount</th>
                            <th>Invoice ID</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>                          
                          <td>MRF</td>
                          <td>#CDF15</td>
                          <td style="text-align:right;">$ 1,30,000</td>
                          <td style="text-align:right;">$ 1,75,000</td>
                          <td>#TF123</td>
                        </tr>
                        <tr>
                            <td>Alfa</td>
                            <td>#AS785</td>
                            <td style="text-align:right;">$ 2,30,000</td>
                            <td style="text-align:right;">$ 2,50,000</td>
                            <td>#AAD25</td>
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