@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">PAYMENT INSTRUCTION <i class="fa fa-info-circle" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."></i></a></li>
	</ul>
@stop
@section('content')
 <!-- Row Start -->
        <form action="#" method="post">
            {!! csrf_field() !!}
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">

                  <div class="widget-body">
                      <div class="table-responsive">
                          <table class="table_borderNon">
                              <tr>
                                  <td colspan="3">
                                      <h1>Step : 1 Review Invoice Details</h1>
                                  </td>
                              </tr>
                              <tr>
                                  <td class="hidden-phone">
                                      <b>Invoice Number</b>
                                  </td>
                                  <td class="hidden-phone">
                                      ASDERF1526
                                  </td>
                                  <td>
                                      <b>Current Payment Terms</b>
                                  </td>
                              </tr>
                              <tr>
                                  <td class="hidden-phone">
                                      <b>Invoice Amount</b>
                                  </td>
                                  <td class="hidden-phone">
                                      $ 41,360,50
                                  </td>
                                  <td>
                                      <b>60 Days net</b>
                                  </td>
                              </tr>
                              <tr>
                                  <td class="hidden-phone">
                                      <b>Invoice Due Date</b>
                                  </td>
                                  <td class="hidden-phone">
                                      26 Jun 2016
                                  </td>
                                  <td>

                                  </td>

                          </table>
                      </div>
		          </div>

                  <div class="widget-body">

                        <div class="table-responsive">
                            <div class="col-sm-6">
                            <table class="table_borderNon">
                                <tr>
                                    <td colspan="3">
                                        <h1>Step : 2 Select Early Payment Date</h1>
                                        <p>Select Different dates to see different discount rates.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Early Payment Date</b>
                                    </td>
                                    <td class="hidden-phone">
                                        26 Feb 2016
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Day Accelerated</b>
                                    </td>
                                    <td class="hidden-phone">
                                        55
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Discount Rate</b>
                                    </td>
                                    <td class="hidden-phone">
                                        0.968%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Discount Amount</b>
                                    </td>
                                    <td class="hidden-phone">
                                        $ 400.40
                                    </td>
                                </tr>
                            </table>
                            </div>
                            <div class="col-sm-6">
                                <div id="datepicker"></div>
                            </div>
                        </div>
                    </div>

                  <div class="widget-body">
                        <div class="table-responsive">
                            <table class="table_borderNon">
                                <tr>
                                    <td colspan="3">
                                        <h1>Step : 3 Review Offer and Submit Request</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Early Payment Date</b>
                                    </td>
                                    <td class="hidden-phone">
                                        26 Feb 2016
                                    </td>
                                    <td rowspan="5" valign="bottom">
                                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Original Invoice Amount</b>
                                    </td>
                                    <td class="hidden-phone">
                                        $ 41,360,50
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Discount Amount</b>
                                    </td>
                                    <td class="hidden-phone">
                                        -$ 400.40
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone" colspan="2">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="hidden-phone">
                                        <b>Total Payment Amount</b>
                                    </td>
                                    <td class="hidden-phone">
                                        <b>$ 40,963.60</b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
              </div>
            </div>
        </form>
<!-- Row End -->
@stop
