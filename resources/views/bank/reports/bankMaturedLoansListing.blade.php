@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BANK MATURED LOANS</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Bank Matured Loans
                    </div>
                  </div>

                  <div class="widget-body">
                      <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                          <div class="form-group">
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Buyer Name">
                              </div>
                              <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                  <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Seller Name">
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
                            <th>Buyer Name</th>
                            <th>Seller Name</th>
                            <th>Loan ID</th>
                            <th>Loan Amount</th>
                            <th>Interest Earned</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Tata</td>
                          <td>TVS</td>
                          <td>#TF123</td>
                          <td style="text-align:right;">$ 1,30,000</td>
                          <td style="text-align:right;">$ 1,50,000</td>
                        </tr>
                        <tr>
                            <td>Atlas</td>
                            <td>Alfa</td>
                            <td><a href="#" class="link_A_blue" data-toggle="modal" data-target="#loan_details">#AAD25</a></td>
                            <td style="text-align:right;">$ 2,30,000</td>
                            <td style="text-align:right;">$ 2,50,000</td>
                        </tr>
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
<!-- Loan Details Modal Start-->
    <div id="loan_details" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Loan Details</h4>
                    <!--<button type="button"><i class="fa fa-check-circle fa-lg"></i> Approve</button>
                    <button type="button"><i class="fa fa-times-circle fa-lg"></i> Reject</button>-->
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table popup_table">
                            <tbody>
                                <tr>
                                    <th>Interest Rate :</th>
                                    <td>11%</td>
                                </tr>
                                <tr>
                                    <th>Interest Amount  :</th>
                                    <td>$ 20,000</td>
                                </tr>
                                <tr>
                                    <th>Loan Paid :</th>
                                    <td>$ 1,00,000</td>
                                </tr>
                                <tr>
                                    <th>Other Charges :</th>
                                    <td>$ 5,000</td>
                                </tr>
                                <tr>
                                    <th>Additional Payout :</th>
                                    <td>$ 10,000</td>
                                </tr>
                                <tr>
                                    <th>Matured Date :</th>
                                    <td>18 Feb 2016</td>
                                </tr>
                                <tr>
                                    <th>Loan Date :</th>
                                    <td>17 Jan 2016</td>
                                </tr>
                                <tr>
                                    <th>Period of Loan :</th>
                                    <td>32 Days</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<!-- Loan Details Modal End-->

          @stop