@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">SELLER INWARDS REMITTANCES </a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Remittances Report
                    </div>
                  </div>
                  
                  <div class="widget-body">
                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <select name="buyer" class="form-control">
                                      <option selected> Currency</option>
                                      <option> All</option>
                                      <option> USD	</option>
                                      <option> Taka</option>
                                  </select>
                              </div>

                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <select name="buyer" class="form-control">
                                      <option selected> Discounted</option>
                                      <option> Yes	</option>
                                      <option> No</option>
                                  </select>
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
                            <th>PI Number</th>
                            <th>Invoice Number</th>
                            <th>Buyer Name</th>
                            <th>Currency</th>
                            <th>Invoice Amount</th>
                            <th>Discounted ?</th>
                            <th>Paid Amount</th>
                            <th>Payment Date</th>
                            <th>Maturity Date</th>
                            <th>Bank Charges</th>
                            <th>Remaining Payment</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>PI1234</td>
                          <td>IN52312</td>
                          <td>Alfa</td>
                          <td>USD</td>
                          <td style="text-align: right;">$ 112500</td>
                          <td>Yes</td>
                          <td style="text-align: right;">$ 95000</td>
                          <td>8 Feb 2016</td>
                          <td>28 Feb 2016</td>
                          <td style="text-align: right;">$ 2000</td>
                          <td style="text-align: right;">$ 5000</td>
                        </tr>
                        <tr>
                            <td>PI5834</td>
                            <td>IN26312</td>
                            <td>TATA</td>
                            <td>USD</td>
                            <td style="text-align: right;">$ 212500</td>
                            <td>Yes</td>
                            <td style="text-align: right;">$ 98000</td>
                            <td>12 Feb 2016</td>
                            <td>30 Feb 2016</td>
                            <td style="text-align: right;">$ 3000</td>
                            <td style="text-align: right;">$ 6000</td>
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