@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BANK LOAN MATIRITY PENDING</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Bank Loan Matirity Pending
                    </div>
                  </div>
                  
                  <div class="widget-body">
                  <div class="form-group">
                    <div class="row">
                          <div class="col-sm-4">
                            <div class="input-group">
                            <input name="search_box" id="search_box" type="text" class="form-control" placeholder="Search by Role" value="{{Input::get('search_box')}}" aria-describedby="basic-addon1">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                            </div>
                          </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table  id="example" class="display table table-condensed table-striped table-bordered table-hover no-margin">
                      <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Supplier Name</th>
                            <th>Buyer Name</th>
                            <th>Amount</th>
                            <th>Loan Amount</th>
                            <th>Maturity Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>                          
                          <td><a href="#" class="link_A_blue" data-toggle="modal" data-target="#loan_id">#AB258</a></td>
                          <td>Atlas</td>
                          <td>Alfa</td>
                          <td>$ 1,30,000</td>
                          <td>$ 1,00,000</td>
                          <td>1 Jan 2015</td>
                        </tr>
                        <tr>
                            <td><a href="#" class="link_A_blue" data-toggle="modal" data-target="#invc_no">#XY258</a></td>
                            <td>Tata</td>
                            <td>MRF</td>
                            <td>$ 1,25,000</td>
                            <td>$ 75,000</td>
                            <td>21 Jan 2015</td>
                        </tr>
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
<!-- Loan ID Modal Start-->
    <div id="loan_id" class="modal fade" role="dialog">
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
                            <th>Loan  :</th>
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
                            <th>Interest Base Rate :</th>
                            <td>$ 1,30,000</td>
                        </tr>
                        <tr>
                            <th>Interest Buffer Rate :</th>
                            <td>$ 30,000</td>
                            <th>Total Interest Rate :</th>
                            <td>$ 2,30,000</td>
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
<!-- Loan ID Modal End-->
          @stop