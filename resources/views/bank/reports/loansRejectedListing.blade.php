@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">LOANS REJECTED</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Loans Rejected
                    </div>
                  </div>

                    <div class="widget-body">

                        <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Buyer Name">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Seller Name">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Invoice Number">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="PI Number">
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
                                    <th>Seller</th>
                                    <th>Buyer</th>
                                    <th>Limit Remaining at Payout</th>
                                    <th>Loan Applied Date</th>
                                    <th>Loan Rejection Date</th>
                                    <th>Invoice No</th>
                                    <th>PI Number</th>
                                </tr>

                                <tr id="filterrow">
                                    <th>Seller</th>
                                    <th>Buyer</th>
                                    <th>Limit Remaining at Payout</th>
                                    <th>Loan Applied Date</th>
                                    <th>Loan Rejection Date</th>
                                    <th>Invoice No</th>
                                    <th>PI Number</th>
                                </tr>
                                </thead>


                                <tbody>
                                <tr>
                                    <td>
                                        Alfa
                                    </td>
                                    <td>
                                        Atlas
                                    </td>
                                    <td style="text-align:right;">
                                        <b>&#2547;</b> 1,25,000
                                    </td>
                                    <td>
                                        10 Jan 2016
                                    </td>
                                    <td>
                                        18 Jan 2016
                                    </td>
                                    <td>
                                        <a href="#" class="link_A_blue" data-toggle="modal" data-target="#loans_rejected">ABC123</a>
                                    </td>
                                    <td>
                                        CAS12578
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        TATA
                                    </td>
                                    <td>
                                        MRF
                                    </td>
                                    <td style="text-align:right;">
                                        <b>&#2547;</b> 2,12,000
                                    </td>
                                    <td>
                                        05 Mar 2016
                                    </td>
                                    <td>
                                        21 Mar 2016
                                    </td>
                                    <td>
                                        <a href="#" class="link_A_blue">EBC123</a>
                                    </td>
                                    <td>
                                        FAS12578
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

    <!-- Loans Rejected Modal Start-->
    <div id="loans_rejected" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Details Remarks for Rejection	</h4>
                    <!--<button type="button"><i class="fa fa-check-circle fa-lg"></i> Approve</button>
                    <button type="button"><i class="fa fa-times-circle fa-lg"></i> Reject</button>-->
                </div>
                <div class="modal-body">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!--  Loans Rejected Modal End-->

          @stop