@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">SELLER LIMIT UTILIZATION</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Seller Limit Utilization
                    </div>
                  </div>
                  
                  <div class="widget-body">
                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Seller Name">
                              </div>

                              <div class="input-group-btn">
                                  <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button>
                              </div>
                          </div>
                      </form>
                      <div class="table-responsive">
                          <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                              <thead>
                              <tr>
                                  <th>
                                      Type
                                  </th>
                                  <th>
                                      Organization Name
                                  </th>
                                  <th>
                                      Approved Limit
                                  </th>
                                  <th>
                                      Current Exposure
                                  </th>
                                  <th>
                                      Pipeline Requests
                                  </th>
                                  <th>
                                      Available Limit
                                  </th>
                                  <th>
                                      Limit Utilized Percentage
                                  </th>
                              </tr>
                              </thead>
                              <tbody>

                              <tr>
                                  <td>
                                      Buyer
                                  </td>
                                  <td>
                                      Navneet
                                  </td>
                                  <td style="text-align:right;">
                                      &#2547; 10,000,000
                                  </td>
                                  <td style="text-align:right;">
                                      &#2547; 200,000
                                  </td>
                                  <td style="text-align:right;">
                                      &#2547; 10,000
                                  </td>
                                  <td style="text-align:right;">&#2547; 97,90,000</td>
                                  <td>
                                      50%
                                  </td>
                              </tr>

                              <tr>
                                  <td>
                                      Buyer
                                  </td>
                                  <td>
                                      First Economy
                                  </td>
                                  <td style="text-align:right;">
                                      &#2547; 20,000,000
                                  </td>
                                  <td style="text-align:right;">
                                      &#2547; 100,000
                                  </td>
                                  <td style="text-align:right;">
                                      -
                                  </td>
                                  <td style="text-align:right;">&#2547; 19,900,000</td>
                                  <td>
                                      47%
                                  </td>
                              </tr>

                              <tr>
                                  <td>
                                      Supplier
                                  </td>
                                  <td>
                                      Infini Systems
                                  </td>
                                  <td style="text-align:right;">
                                      <i class="fa fa-usd"></i> 30,000,000
                                  </td>
                                  <td style="text-align:right;">
                                      <i class="fa fa-usd"></i> 1,000,000
                                  </td>
                                  <td style="text-align:right;">
                                      <i class="fa fa-usd"></i> 500,000
                                  </td>
                                  <td style="text-align:right;"><i class="fa fa-usd"></i> 28,500,000</td>
                                  <td>
                                     60%
                                  </td>
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