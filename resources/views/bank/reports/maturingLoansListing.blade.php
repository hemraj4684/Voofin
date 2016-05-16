@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">MATURING LOANS</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Maturing Loans List
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

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">	<input type="text" id="config-demo" class="form-control date_filter">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                </div>

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button>
                                    <button type="button" class="btn btn-sm btn-success" ng-click="reset()" style="margin:0 0 0 10px;" title="Export to Excel"><i class="fa fa-file-excel-o"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" ng-click="reset()" style="margin:0 0 0 10px;" title="Export to PDF"><i class="fa fa-file-pdf-o"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table  id="example" class="display table table-condensed table-striped table-bordered table-hover no-margin">
                                <thead>
                                <tr>
                                    <th>Loan ID</th>
                                    <th>Seller</th>
                                    <th>Buyer</th>
                                    <th>PI Amount</th>
                                    <th>Bank Charges</th>
                                    <th>Loan Amount</th>
                                    <th>Maturity Date</th>
                                </tr>

                                <tr id="filterrow">
                                    <th>Loan ID</th>
                                    <th>Seller</th>
                                    <th>Buyer</th>
                                    <th>PI Amount</th>
                                    <th>Bank Charges</th>
                                    <th>Loan Amount</th>
                                    <th>Maturity Date</th>

                                </tr>
                                </thead>


                                <tbody>
                                <tr>
                                    <td>
                                        <a href="#" class="link_A_blue" data-toggle="modal" data-target="#bank_loan">AQW1526E12</a>
                                    </td>
                                    <td>
                                        Atlas
                                    </td>
                                    <td>
                                        Alfa
                                    </td>
                                    <td style="text-align:right;">
                                        <b>&#2547;</b> 1,25,000
                                    </td>
                                    <td style="text-align:right;">
                                        <b>&#2547;</b> 25,000
                                    </td>
                                    <td style="text-align:right;">
                                        <b>&#2547;</b> 25,000
                                    </td>
                                    <td>
                                        10 Jan 2016
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        <a href="#" class="link_A_blue">ZASE1526E12</a>
                                    </td>
                                    <td>
                                        Samsung
                                    </td>
                                    <td>
                                        Sony
                                    </td>
                                    <td style="text-align:right;">
                                        <i class="fa fa-usd"></i> 2,00,000
                                    </td>
                                    <td style="text-align:right;">
                                        <i class="fa fa-usd"></i> 1,50,000
                                    </td>
                                    <td style="text-align:right;">
                                        <b>&#2547;</b> 25,000
                                    </td>
                                    <td>
                                        15 Feb 2016
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
<!-- Loan Details Modal Start-->
    <div id="bank_loan" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bank Loan Payout Details :</h4>
                    <!--<button type="button"><i class="fa fa-check-circle fa-lg"></i> Approve</button>
                    <button type="button"><i class="fa fa-times-circle fa-lg"></i> Reject</button>-->
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table popup_table">
                            <tbody>
                            <tr>
                                <th>Supplier Name :</th>
                                <td>Atlas</td>
                                <th>Buyer Name :</th>
                                <td>Alfa</td>
                            </tr>
                            <tr>
                                <th>Loan Amount  :</th>
                                <td>$ 1,00,000</td>
                                <th>Eligibility Percentage :</th>
                                <td>20%</td>
                            </tr>
                            <tr>
                                <th>Interest Amount :</th>
                                <td>$ 1,25,000	</td>
                                <th>Bank Other Charges :</th>
                                <td>$ 25,000</td>
                            </tr>
                            <tr>
                                <th>Buffer Amount[Payble on Maturity] :</th>
                                <td>$ 25,000</td>
                                <th>Total Interest Rate :</th>
                                <td>11%</td>
                            </tr>
                            <tr>
                                <th>Loan Start Date :</th>
                                <td>18 Feb 2016</td>    
                                <th>&nbsp;</th>
                                <td>&nbsp;</td>                               
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">Supplier Info :</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table popup_table">
                            <tbody>
                            <tr>
                                <th>Name :</th>
                                <td>Atlas</td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td>
                                    DieSachbearbeiter,
                                    Schönhauser, Allee, Berlin
                                    Germany</td>
                            </tr>
                            <tr>
                                <th>Contact Person :</th>
                                <td>Mr. Prashant Patil</td>
                            </tr>
                            <tr>
                                <th>Account No :</th>
                                <td>SBIN1024582000</td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">Buyer Info :</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table popup_table">
                            <tbody>
                            <tr>
                                <th>Name :</th>
                                <td>Alfa</td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td>2141 K Street NW #606,
                                    Washington, DC 20037
                                    (202) 293-8680,
                                    Dale James</td>
                            </tr>
                            <tr>
                                <th>Contact Person</th>
                                <td>Mr. Anil Sathe</td>
                            </tr>
                            <tr>
                                <th>Account No</th>
                                <td>BAS12504820</td>
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