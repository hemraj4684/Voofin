@extends('seller.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">SELLER REMITTANCES </a></li>
	</ul>
	
@stop
@section('content')
<!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Remittances List
                    </div>
                    
                  </div>
                  <div class="widget-body">

                    <div class="table-responsive">
                      <table  id="example" class="display table table-condensed table-striped table-bordered table-hover no-margin">
						<thead>
                          <tr>
							<th>Invoice No.</th>
                            <th>PI Number</th>   
                            <th>Invoice Amount</th>
							<th>Remited Amount</th>							
                          </tr>
						  
						  <tr id="filterrow">
							<th>Invoice No.</th>
							<th>PI Number</th>  
							<th>Invoice Amount</th>
							<th>Remited Amount</th>	
						  </tr>
						</thead>
						
						
                        <tbody>
                          <tr>
						    <td>
                              <a href="#" class="link_A_blue" data-toggle="modal" data-target="#myModal_invoice">AQW1526E12</a>
                            </td>
							<td>
                              <a href="#" class="link_A_blue" data-toggle="modal" data-target="#pi_modal">B697F12</a>
                            </td>							
							<td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 1,25,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 25,000
                            </td>                         
                          </tr>
						  
						  <tr>
                            <td>
                              <a href="#" class="link_A_blue">QW1526E12</a>
                            </td>
							<td>
                              <a href="#" class="link_A_blue">CD697F12</a>
                            </td>
							
                            <td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 2,00,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 1,50,000
                            </td>							                          
                          </tr>
						  
						  <tr>
                            <td>
                              <a href="#" class="link_A_blue">WE1526E12</a>
                            </td>
							<td>
                              <a href="#" class="link_A_blue">DV697F12</a>
                            </td>
							
                            <td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 1,22,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 1,22,000
                            </td>														
                          </tr>
						  
						  <tr>
                            <td>
                              <a href="#" class="link_A_blue">RQW1526E12</a>
                            </td>
						    <td>
                              <a href="#" class="link_A_blue">WB697F12</a>
                            </td>
							
                            <td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 1,30,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 1,00,000
                            </td>							                          
                          </tr>
						  
                          <tr>
						    <td>
                              <a href="#" class="link_A_blue">QW1526E12</a>
                            </td>
							<td>
                              <a href="#" class="link_A_blue">B697F12</a>
                            </td>
							
                            <td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 1,50,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 1,25,000
                            </td>							                         
                          </tr>
						  
						  <tr>
                            <td>
                              <a href="#" class="link_A_blue">WE1526E12</a>
                            </td>
							<td>
                              <a href="#" class="link_A_blue">CD697F12</a>
                            </td>
							
                            <td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 2,00,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 1,50,000
                            </td>							                         
                          </tr>
						  
						  <tr>
                            <td>
                              <a href="#" class="link_A_blue">RQW1526E12</a>
                            </td>
							<td>
                              <a href="#" class="link_A_blue">DV697F12</a>
                            </td>
							
                            <td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 1,22,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <b>&#2547;</b> 1,22,000
                            </td>														
                          </tr>
						  
						  <tr>
                            <td>
                              <a href="#" class="link_A_blue">QW1526E12</a>
                            </td>
						    <td>
                              <a href="#" class="link_A_blue">WB697F12</a>
                            </td>
							
                            <td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 1,30,000
                            </td>
							<td class="hidden-phone" style="text-align:right;">
                              <i class="fa fa-usd"></i> 1,00,000
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
<!--Invoice Modal Start-->
    <div class="modal fade" id="myModal_invoice" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button"><i class="fa fa-plus-circle fa-lg" style="color:#8BA870;"></i> Create Invoice</button> -->

                <button type="button" class="btn btn-defult"><i class="fa fa-envelope fa-lg"></i> Send Message</button>

                <button type="button" class="btn btn-defult"><i class="fa fa-paperclip fa-lg"></i> Attachment</button>

                <button type="button" class="btn btn-defult"><i class="fa fa-check-circle fa-lg"></i> Approve</button>

                <button type="button" class="btn btn-defult"><i class="fa fa-times-circle fa-lg"></i> Reject</button>

                <button type="button" class="btn btn-defult"><i class="fa fa-pencil-square-o fa-lg"></i> Edit</button>

                <button type="button" class="btn btn-defult"><i class="fa fa-trash-o fa-lg"></i> Delelte </button>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <h1 style="font-size:20px;">Invoice Details </h1>

                <table class="table popup_table">
                    <tbody>
                    <tr>
                        <th>Invoice No.</th>
                        <td>QW1526E12</td>


                        <td rowspan="3"><b>Buyer</b><br> Ashok Leyland<br> DieSachbearbeiter<br>
                            Schönhauser Allee 167c<br>
                            10435 Berlin<br>
                            Germany</td>
                        <td rowspan="3"><b>Delivery Address</b><br> AIDS Healthcare Foundation<br>
                            2141 K Street NW #606 <br>
                            Washington, DC 20037 <br>
                            (202) 293-8680<br>
                            Dale James

                        </td>
                    </tr>
                    <tr>
                        <th>PO No.</th>
                        <td>B697F12</td>
                    </tr>
                    <tr>
                        <th>Invoice Date</th>
                        <td>5 Oct 2015</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>Approved</td>
                        <td rowspan="3"><b>Seller</b><br> Ashok Leyland <br> 022 24335587 <br>AS@example.com</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td><i class="fa fa-usd"></i> 1,50,000</td>

                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <td>04 Nov 2015</td>
                    </tr>

                    </tbody>
                </table>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                        <tr>
                            <th>
                                No.
                            </th>
                            <th>
                                Item Name
                            </th>
                            <th>
                                Date
                            </th>
                            <th style="width:40%">
                                Description
                            </th>

                            <th>
                                Quantity
                            </th>
                            <th>
                                Price Per
                            </th>
                            <th>
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                1
                            </td>
                            <td>
                                Laptop
                            </td>
                            <td>
                                14-04-1213
                            </td>
                            <td>
                                Incentivize platforms Incentivize platforms user-contributed user-contributed...
                            </td>
                            <td>
                                4
                            </td>
                            <td>
                                2.24%
                            </td>
                            <td style="text-align:right;">
                                $ 50.00
                            </td>
                        </tr>
                        <tr>
                            <td>
                                2
                            </td>
                            <td>
                                TV
                            </td>
                            <td>
                                13-04-1213
                            </td>
                            <td>
                                Enable innovate leverage tagclouds Incentivize platforms user-contributed...
                            </td>
                            <td>
                                21
                            </td>
                            <td>
                                6.59%
                            </td>
                            <td style="text-align:right;">
                                $ 130.00
                            </td>
                        </tr>
                        <tr>
                            <td>
                                3
                            </td>
                            <td>
                                Mobile
                            </td>
                            <td>
                                18-04-1213
                            </td>
                            <td>
                                E-business front-end web services Enable innovate leverage tagclouds...
                            </td>
                            <td>
                                9
                            </td>
                            <td>
                                2.50%
                            </td>
                            <td style="text-align:right;">
                                $ 220.00
                            </td>
                        </tr>
                        <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Subtotal</b>
                            </td>
                            <td style="text-align:right;">
                                $ 400.00
                            </td>
                        </tr>
                        <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Tax (9.25%)</b>
                            </td>
                            <td style="text-align:right;">
                                $ 3000.00
                            </td>
                        </tr>
                        <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Discount</b>
                            </td>
                            <td style="text-align:right;">
                                400
                            </td>
                        </tr>
                        <tr class="success">
                            <td class="total" colspan="6">
                                <b class="pull-right">Total</b>
                            </td>
                            <td style="text-align:right;">
                                $ 3000.00
                            </td>
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
<!-- Invoice Modal End-->

<!--Payment Instruction Modal Start-->
    <div class="modal fade" id="pi_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-defult"><i class="fa fa-check-circle fa-lg"></i> Approve</button>

                <button type="button" class="btn btn-defult"><i class="fa fa-times-circle fa-lg"></i> Reject</button>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <h1 style="font-size:20px;">Payment Instruction </h1>

                <table class="table popup_table">
                    <tbody>
                    <tr>
                        <th>PI No.</th>
                        <td>B697F12</td>
                        <td rowspan="3"><b>Buyer</b><br> Ashok Leyland<br> DieSachbearbeiter<br>
                            Schönhauser Allee 167c<br>
                            10435 Berlin<br>
                            Germany</td>
                        <td rowspan="3"><b>Delivery Address</b><br> AIDS Healthcare Foundation<br>
                            2141 K Street NW #606 <br>
                            Washington, DC 20037 <br>
                            (202) 293-8680<br>
                            Dale James

                        </td>
                    </tr>
                    <tr>
                        <th>Invoice No.</th>
                        <td>QW1526E12</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>Approved</td>
                    </tr>
                    <tr>
                        <th>Invoice Amount</th>
                        <td><i class="fa fa-usd"></i> $ 2,00,000</td>
                        <td rowspan="3"><b>Seller</b><br> Ashok Leyland <br> 022 24335587 <br>AS@example.com</td>
                    </tr>
                    <tr>
                        <th>PI Amount</th>
                        <td><i class="fa fa-usd"></i> $ 1,80,000</td>
                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <td>5 Oct 2015</td>
                    </tr>
                    </tbody>
                </table>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                        <tr>
                            <th>
                                No.
                            </th>
                            <th>
                                Item Name
                            </th>
                            <th>
                                Date
                            </th>
                            <th style="width:40%">
                                Description
                            </th>

                            <th>
                                Quantity
                            </th>
                            <th>
                                Price Per
                            </th>
                            <th>
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                1
                            </td>
                            <td>
                                Laptop
                            </td>
                            <td>
                                14-04-1213
                            </td>
                            <td>
                                Incentivize platforms Incentivize platforms user-contributed user-contributed...
                            </td>
                            <td>
                                4
                            </td>
                            <td>
                                2.24%
                            </td>
                            <td style="text-align:right;">
                                $ 50.00
                            </td>
                        </tr>
                        <tr>
                            <td>
                                2
                            </td>
                            <td>
                                TV
                            </td>
                            <td>
                                13-04-1213
                            </td>
                            <td>
                                Enable innovate leverage tagclouds Incentivize platforms user-contributed...
                            </td>
                            <td>
                                21
                            </td>
                            <td>
                                6.59%
                            </td>
                            <td style="text-align:right;">
                                $ 130.00
                            </td>
                        </tr>
                        <tr>
                            <td>
                                3
                            </td>
                            <td>
                                Mobile
                            </td>
                            <td>
                                18-04-1213
                            </td>
                            <td>
                                E-business front-end web services Enable innovate leverage tagclouds...
                            </td>
                            <td>
                                9
                            </td>
                            <td>
                                2.50%
                            </td>
                            <td style="text-align:right;">
                                $ 220.00
                            </td>
                        </tr>
                        <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Subtotal</b>
                            </td>
                            <td style="text-align:right;">
                                $ 400.00
                            </td>
                        </tr>
                        <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Tax (9.25%)</b>
                            </td>
                            <td style="text-align:right;">
                                $ 3000.00
                            </td>
                        </tr>
                        <tr>
                            <td class="total" colspan="6">
                                <b class="pull-right">Discount</b>
                            </td>
                            <td style="text-align:right;">
                                400
                            </td>
                        </tr>
                        <tr class="success">
                            <td class="total" colspan="6">
                                <b class="pull-right">Total</b>
                            </td>
                            <td style="text-align:right;">
                                $ 3000.00
                            </td>
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
<!-- Payment Instruction Modal End-->
@stop
