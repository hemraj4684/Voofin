@extends('seller.layouts.default')
@section('content')

<!-- Row Start -->
 <div class="row">
    <div class="col-lg-12 col-md-12">
    <div class="widget">
      <div class="widget-header">
      <div class="title">
        Recent Notifications
      </div>
      
      </div>
      <div class="widget-body">                    
        <?php 
          $lastInvoiceCount = count($invoiceNotification)-1;
          $lastPoCount = count($poNotification)-1;
        ?>
        @foreach($invoiceNotification as $key => $notification)                 
          <p class="notifications_dashdoard"><b> {{ strtoupper($notification->object_type) }} : </b> {{$notification->text}}
           <span class="tools pull-right">
            <a href="javascript:;" id="{{ $notification->invoice_uuid }}" class="btn btn-primary btn-sm invoice-modal"> Review </a>
            <a href="#" class="btn btn-primary btn-sm">Hide </a>
           </span>
        </p>
       @endforeach
       @foreach($poNotification as $key => $notification)                 
          <p class="@if($key != $lastPoCount) notifications_dashdoard @endif"><b> {{ strtoupper($notification->object_type) }} : </b> {{$notification->text}}
           <span class="tools pull-right">
            <a href="javascript:;" data-id="{{ $notification->po_uuid }}" class="btn btn-primary btn-sm poView"> Review </a>
            <a href="#" class="btn btn-primary btn-sm">Hide </a>
           </span>
        </p>
       @endforeach
      <!-- <p class="notifications_dashdoard"><b> PO : </b> You have Recived New PO of ৳5,000,000 that need your attention
       <span class="tools pull-right">
        <a href="#" class="btn btn-primary btn-sm"> Review </a>
        <a href="#" class="btn btn-primary btn-sm">Hide </a>
      </span>
      </p>

      <p><b> PO : </b> You have Recived New PO of ৳5,000,000 that need your attention
       <span class="tools pull-right">
        <a href="#" class="btn btn-primary btn-sm"> Review </a>
        <a href="#" class="btn btn-primary btn-sm">Hide </a>
      </span>
      </p> -->

      </div>                  
      
      </div>
    </div>
    </div>
<!-- Row End -->

<!-- Row starts -->
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-6 col5">
  <div class="mini-widget">
    <div class="mini-widget-heading clearfix">
      <div class="pull-left">Open Invoices</div>                     
    </div>
    <div class="mini-widget-body clearfix">
      <div class="pull-left">
        <i class="fa fa-eye"></i>
      </div>
      <div class="pull-right number"> ৳ {{number_format($openInvoiceSum)}}</div>
    </div>
<!-- <div class="mini-widget-footer center-align-text">
      <span>Better than last week</span>
    </div> -->
  </div>
</div>     
<div class="col-lg-3 col-md-3 col-sm-6 col5">
  <div class="mini-widget">
    <div class="mini-widget-heading clearfix">
      <div class="pull-left">Remittances</div>
         <div class="pull-right dropdown"><a href="#" id="nav-visitors" class="dropdown-toggle" data-toggle="dropdown">Last 7 days <i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu boxmenu" role="menu" aria-labelledby="nav-visitors">
              <li><a href="#">Last 7 days</a></li>
              <li><a href="#">Last 30 days</a></li>
            </ul>
         </div>
      </div>
      <div class="mini-widget-body clearfix">
        <div class="pull-left">
          <i class="fa fa-money"></i>
        </div>
        <div class="pull-right number">৳ 3,500,000,000</div>
      </div>
<!--<div class="mini-widget-footer center-align-text">
        <span>Better than last week</span>
      </div> -->
  </div>
</div>    

<div class="col-lg-3 col-md-3 col-sm-6 col5">
  <div class="mini-widget">
    <div class="mini-widget-heading clearfix">
      <div class="pull-left">Approved Invoices</div>
    </div>
    <div class="mini-widget-body clearfix">
      <div class="pull-left">
        <i class="fa fa-thumbs-up"></i>
      </div>
      <div class="pull-right number">৳ {{number_format($approvedInvoiceSum)}}</div>
    </div>
<!-- <div class="mini-widget-footer center-align-text">
      <span>Better than last week</span>
    </div> -->
  </div>
</div>  

<div class="col-lg-3 col-md-3 col-sm-6 col5">
  <div class="mini-widget">
    <div class="mini-widget-heading clearfix">
      <div class="pull-left">Available Cash</div>    
    </div>
    <div class="mini-widget-body clearfix">
      <div class="pull-left">
        <i class="fa fa-globe"></i>
      </div>
      <div class="pull-right number"> ৳{{number_format($availableCash)}}</div>
    </div>
  </div>
</div>
</div>
<!-- Row ends -->

<!-- Row Start -->
  <div class="row">
    <div class="col-lg-12 col-md-12">
    <div class="widget">
      <div class="widget-header">
      <div class="title">
        10 Approved Payment Instructions
      </div>
      <span class="tools">
      <a href="{{URL::route('seller.piListing.view')}}" class="btn btn-primary btn-sm" type="button"> View All </a>
        
      </span>
      </div>
      <div class="widget-body">                    

      <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered table-hover no-margin">
        <thead>
          <tr>
          <th>
            <input type="checkbox" id="checkAll">
          </th>
          <th>
            Invoice Number
          </th>
          <th>
            Buyer
          </th>
          <th>
            Due Date
          </th>       
          <th>
            Invoice Amount
          </th>          
          <th style="width:10%" class="hidden-phone">
            PI Amount
          </th>          
          <th>
            Bank Charges
          </th>          
          <th>
            Eligible Amount
          </th>          
          <th>
            Pay Me Early
          </th>
          </tr>
        </thead>
        <tbody>
        <?php $invoiceAmt = 0;$piAmt = 0;$bankCharges = 0;$eligibleAmt = 0; $i=0; $invAmt=0;$piAmount=0;$bankAmt=0;$elgAmt = 0;?>
        @if(isset($iDisData))
         @foreach($iDisData as $key => $iDisData)
          @if($key<=9)
          <tr>
          <td>
            <input data-id="{{$iDisData->pi_uuid}}" data-invoice-id="{{$iDisData->invoice_uuid}}" class="iDisCheck" type="checkbox" @if((Input::get('cashAmt') > $eligibleAmt) || Input::get('optCash') === "all cash") || ) checked @endif>
          </td>
          <td>
            <a href="javascript:void(0);" class="iDisModal link_A_blue" data-id="{{$iDisData->pi_uuid}}" data-toggle="modal" >{{$iDisData->invoice_number}}</a>
          </td>
          <td>
            {{$iDisData->buyer_name}}
          </td>
          <td class="dueDate">
            {{date("d M Y",strtotime($iDisData->due_date))}}
          </td>
          <!-- <td>
            -
          </td> -->


          <td style="text-align: right;">
             &#2547;<label class="invoiceAmt" style="font-weight:normal;">{{number_format($iDisData->invoice_final_amount,2)}}</label>
             <?php $invoiceAmt+=$iDisData->invoice_final_amount;?>
          </td>
          
          <td style="text-align: right;">
             &#2547;<label class="piAmt" style="font-weight:normal;">{{number_format($iDisData->pi_net_amount,2)}}</label>
             <?php $piAmt+=$iDisData->pi_net_amount;?>
          </td>
          
          <td style="text-align: right;">
             &#2547;{{number_format($iDisBankChargeData[$key],2)}}
             <?php $bankCharges+=$iDisBankChargeData[$key];?>
          </td>             
          
          <td style="text-align: right;">
             &#2547;<label class="eligibleAmt" style="font-weight:normal;">{{ number_format($iDisData->discounted_amount,2)}}</label>
             <?php $eligibleAmt+=$iDisData->discounted_amount;?>
          </td>
          <td>
            <!-- <a href="#" class="btn btn-success btn-xs padLR" title="Pay Me Early" data-toggle="modal" data-target="#iDescounting">
            <img src="../public/img/money_bag_icon.png" width="20" height="20">
            </a>  -->  
            <a href="javascript:void(0);" class="btn btn-success btn-xs padLR pi-modal" title="Pay Me Early" id="{{$iDisData->pi_uuid}}">

              <img src="../public/img/money_bag_icon.png" width="20" height="20">
            </a>                                           
          </td> 
          </tr>
          @endif
          @endforeach
        @endif
           
          <tr>
          <td>
           <button class="btn btn-primary btn-sm" id="requestPayment" type="button" disabled><i class="icon-envelope"></i> Request Payment</button>
          </td>                    
          <td>                       
          </td>                    
          <td>                      
          </td>       
          <!-- <td class="hidden-phone">                      
          </td> -->                    
          <td>
            
          </td>
          <td style="text-align: right;">
            <b>&#2547;{{number_format($invoiceAmt,2)}}</b>
          </td>
          <td style="text-align: right;">
            <b>&#2547;{{number_format($piAmt,2)}}</b>
          </td>
          <td style="text-align: right;">
           <b>&#2547;{{number_format($bankCharges,2)}}</b>
          </td>
          
          <td style="text-align: right;">
            <b>&#2547;{{number_format($eligibleAmt,2)}}</b> 
             <label id="eligibleAmt" style="display:none">&#2547;{{number_format($eligibleAmt,2)}}</label>             
          </td>
          <td>
              <a href="javascript:void(0);" class="btn btn-success btn-xs padLR" title="Pay All" id="payAll">
                <img src="../public/img/money_bag_icon.png" width="20" height="20"> Pay All
              </a>                             
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

          <!-- Row Start -->
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Latest Invoices
                    </div>
                    <span class="tools">
                     <a href="{{URL::route('seller.poListing.view')}}" class="btn btn-primary btn-sm"> View All </a>
                    </span>
                  </div>
                  <div class="widget-body">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                          <thead>
                            <tr>
                             <th>Buyer</th>
                             <th>Invoice Number</th>           
                             <th>PO Amount</th>             
                             <th>Status</th>
                           </tr>
                         </thead>
                         <tbody>  
                         @foreach($invoiceData as $invoice)        
                            <tr>
                              <td>{{$invoice->buyerName}}</td>
                              <td>
                                <a href="javascript:void(0);" id="{{$invoice->uuid}}" class="link_A_blue invoice-modal">{{$invoice->invoice_number}}</a>
                              </td>            
                              <td style="text-align: right;">
                                 ৳{{ number_format($invoice->poAmount,2) }}                                   
                              </td> 
                              <td style="text-align:left;">
                               <i class="{{$statusData['symbols'][$statusData['status'][$invoice->status]] or ''}} wight_ntf"></i>
                               {{ $statusData['status'][$invoice->status] or ''}}           
                              </td>                           
                            </tr> 
                         @endforeach                     
                     </tbody>
                   </table>
                  </div>
                </div>
              </div>
              </div>

              <div class="col-lg-6 col-md-6">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Latest Remittances
                    </div>
                    <span class="tools">
                     <a href="{{URL::route('seller.remittances.view')}}" class="btn btn-primary btn-sm"> View All </a>
                    </span>
                  </div>
                  <div class="widget-body">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                          <thead>
                            <tr>
                             <th>Buyer</th>
                             <th>Invoice Number</th>           
                             <th>PI Number</th>             
                             <th>Remited Amount</th>
                           </tr>
                         </thead>
                         <tbody>          
                          <tr>
                          <td>
                            Hindustan Levear
                          </td>
                          <td>
                            <a href="#" class="link_A_blue" data-toggle="modal" data-target="#pi_modal">B697F12</a>
                          </td>             
                          <td>
                            <a href="#" class="link_A_blue">PI2354</a>
                          </td>
                          <td style="text-align: right;">
                            <b>&#2547;</b> 25,000
                          </td>                         
                          </tr>

                          <tr>
                          <td>
                            TATA
                          </td>
                          <td>
                            -
                          </td>

                          <td>
                            <a href="#" class="link_A_blue">PI4354</a></td>
                          <td style="text-align: right;">
                            <i class="fa fa-usd"></i> 1,50,000
                          </td>                                       
                          </tr>

                          <tr>
                          <td>
                            Coca-Cola
                          </td>
                          <td>
                            <a href="#" class="link_A_blue">DV697F12</a>
                          </td>

                          <td>
                            <a href="#" class="link_A_blue">PI46667</a></td>
                          </td>
                          <td style="text-align: right;">
                            <i class="fa fa-usd"></i> 1,22,000
                          </td>                           
                          </tr>

                          <tr>
                          <td>
                            Hindustan Levear
                          </td>
                          <td>
                            <a href="#" class="link_A_blue">WB697F12</a>
                          </td>

                          <td>
                            <a href="#" class="link_A_blue">PI05067</a>
                          </td>
                          <td style="text-align: right;">
                            <b>&#2547;</b> 1,00,000
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

<!-- Row Start -->
            <!-- <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Mailbox 
                      <span class="mini-title"><a id="mailbox">Inspired by gmail</a></span>
                    </div>
                    <div class="tools pull-right">
                      <div class="btn-group">
                        <a class="btn btn-default btn-sm">
                          <i class="fa fa-mail-forward" data-original-title="Forward">
                          </i>
                        </a>
                        <a class="btn btn-default btn-sm">
                          <i class="fa fa-exclamation-circle" data-original-title="Report">
                          </i>
                        </a>
                        <a class="btn btn-default btn-sm">
                          <i class="fa fa-trash-o" data-original-title="Delete">
                          </i>
                        </a>
                      </div>
                      <div class="btn-group">
                        <a class="btn btn-default btn-sm">
                          <i class="fa fa-folder-o"  data-original-title="Move to">
                          </i>
                        </a>
                        <a class="btn btn-default btn-sm">
                          <i class="fa fa-tag" data-original-title="Tag">
                          </i>
                        </a>
                      </div>
                      <div class="btn-group">
                        <a class="btn btn-default btn-sm">
                          <i class="fa fa-chevron-left" data-original-title="Prev">
                          </i>
                        </a>
                        <a class="btn btn-default btn-sm btn-info" >
                          <i class="fa fa-chevron-right" data-original-title="Next">
                          </i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="widget-body">
                    <div class="mail table-responsive">
                      <table class="table table-condensed table-striped table-hover no-margin">
                        <thead>
                          <tr>
                            <th style="width:3%">
                              <input type="checkbox" class="no-margin">
                            </th>
                            <th style="width:17%">
                              Sent by
                            </th>
                            <th style="width:55%" class="hidden-phone">
                              Subject
                            </th>
                            <th style="width:12%" class="right-align-text hidden-phone">
                              Labels
                            </th>
                            <th style="width:12%" class="right-align-text hidden-phone">
                              Date
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <input type="checkbox" class="no-margin">
                            </td>
                            <td>
                              Mahendra Dhoni
                            </td>
                            <td class="hidden-phone">
                              <strong>
                                Compass, Sass
                              </strong>
                              <small class="info-fade">
                                Methodologies eyeball
                              </small>
                            </td>
                            <td class="right-align-text hidden-phone">
                              <span class="label label-info">
                                Read
                              </span>
                            </td>
                            <td class="right-align-text hidden-phone">
                              Valentine
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="checkbox" class="no-margin">
                            </td>
                            <td>
                              Michel Clar
                            </td>
                            <td class="hidden-phone">
                              <strong>
                                Senior Developer
                              </strong>
                              <small class="info-fade">
                                Platforms web-enabled cultivat
                              </small>
                            </td>
                            <td class="right-align-text hidden-phone">
                              <span class="label label-success">
                                New
                              </span>
                            </td>
                            <td class="right-align-text hidden-phone">
                              Valentine
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="checkbox" class="no-margin">
                            </td>
                            <td>
                              Rahul Dravid
                            </td>
                            <td class="hidden-phone">
                              <strong>
                                Bitbucket
                              </strong>
                              
                              <small class="info-fade">
                                Technologies content deploy ROI
                              </small>
                            </td>
                            <td class="right-align-text hidden-phone">
                              <span class="label label-danger">
                                Imp
                              </span>
                            </td>
                            <td class="right-align-text hidden-phone">
                              Yesterday
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="checkbox" class="no-margin">
                            </td>
                            <td>
                              Anthony Michell
                            </td>
                            <td class="hidden-phone">
                              <strong>
                                Verify your email
                              </strong>
                              
                              <small class="info-fade">
                                Less schemas seamless band
                              </small>
                            </td>
                            <td class="right-align-text hidden-phone">
                              <span class="label label-info">
                                Read
                              </span>
                            </td>
                            <td class="right-align-text hidden-phone">
                              15-02-2013
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="checkbox" class="no-margin">
                            </td>
                            <td>
                              Srinu Baswa
                            </td>
                            <td class="hidden-phone">
                              <strong>
                                Statement for December 2012
                              </strong>
                              <small class="info-fade">
                                Models seize 
                              </small>
                            </td>
                            <td class="right-align-text hidden-phone">
                              <span class="label label-success">
                                New
                              </span>
                            </td>
                            <td class="right-align-text hidden-phone">
                              10-02-2013
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="checkbox" class="no-margin">
                            </td>
                            <td>
                              Crazy Singh
                            </td>
                            <td class="hidden-phone">
                              <strong>
                                You're In!
                              </strong>
                              <small class="info-fade">
                                Tagclouds endwidth; morph; distr
                              </small>
                            </td>
                            <td class="right-align-text hidden-phone">
                              <span class="label label-warning">
                                Imp
                              </span>
                            </td>
                            <td class="right-align-text hidden-phone">
                              21-01-2013
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="checkbox" class="no-margin">
                            </td>
                            <td>
                              Sri Ram Raju
                            </td>
                            <td class="hidden-phone">
                              <strong>
                                Support
                              </strong>
                              <small class="info-fade">
                                Distributed incentivize enabl
                              </small>
                            </td>
                            <td class="right-align-text hidden-phone">
                              <span class="label label-info">
                                New
                              </span>
                            </td>
                            <td class="right-align-text hidden-phone">
                              19-01-2013
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <!-- Row End -->
            

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
                        <td rowspan="3"><b>Buyer</b><br> Hindustan Levear<br> DieSachbearbeiter<br>
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
                          <th width="30%">
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
                          <td style="text-align: right;">
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
                          <td style="text-align: right;">
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
                          <td style="text-align: right;">
                            $ 220.00
                          </td>
                        </tr>
                        <tr>
                          <td class="total" colspan="6">
                            <b class="pull-right">Subtotal</b>
                          </td>
                          <td style="text-align: right;">
                            $ 400.00
                          </td>
                        </tr>
                        <tr>
                          <td class="total" colspan="6">
                            <b class="pull-right">Tax (9.25%)</b>
                          </td>
                          <td style="text-align: right;">
                            $ 3000.00
                          </td>
                        </tr>
                        <tr>
                          <td class="total" colspan="6">
                            <b class="pull-right">Discount</b>
                          </td>
                          <td style="text-align: right;">
                            400
                          </td>
                        </tr>
                        <tr class="success">
                          <td class="total" colspan="6">
                            <b class="pull-right">Total</b>
                          </td>
                          <td style="text-align: right;">
                            <b>$ 3000.00</b>
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

          <!-- PI Modal -->
              <div id="iDescounting" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">

                      <!-- Modal content-->
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Payment Instruction</h4>
                          </div>
                          <div class="modal-body">

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
                                                                      <b>Days to Payment</b>
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
                                                          <div id="datepicker1"></div>
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

                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                      </div>

                  </div>
              </div>

         <!-- Request Payment  -->
              <div id="iDescounting_remt1" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">

                      <!-- Modal content-->
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Loan Details</h4>
                          </div>
                          <div class="modal-body">

                              <!-- Row Start -->
                              <form action="#" method="post">
                                  {!! csrf_field() !!}
                                  <div class="row">
                                      <div class="col-lg-12 col-md-12">
                                          <div class="widget">

                                              <div class="widget-body">
                                                  <div class="table-responsive">
                                                    <div class="col-sm-12">
                                                      <table class="table_borderNon">
                                                          <tr>
                                                              <td colspan="3">
                                                                  <h1>Step : 1 Review Invoice Details</h1>
                                                              </td>
                                                          </tr>                                                          
                                                          <tr>
                                                              <td class="hidden-phone">
                                                                  <b>Total Invoice Amount</b>
                                                              </td>
                                                              <td class="hidden-phone">
                                                                  $ 5,00,000
                                                              </td>

                                                              <td class="hidden-phone">
                                                                  <b>Total PI Amount (A)</b>
                                                              </td>
                                                              <td class="hidden-phone">
                                                                  $ 4,91,000
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                              <td class="hidden-phone">
                                                                  <b>Total Eligible Amount (B)</b>
                                                              </td>
                                                              <td class="hidden-phone">
                                                                  $ 4,00,000
                                                              </td>

                                                              <td class="hidden-phone">
                                                                 
                                                              </td>
                                                              <td class="hidden-phone">
                                                                 
                                                              </td>
                                                          </tr>

                                                      </table>
                                                    </div>  
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
                                                                      <b>Discount Rate</b>
                                                                  </td>
                                                                  <td class="hidden-phone">
                                                                      0.968%
                                                                  </td>
                                                              </tr>
                                                              <tr>
                                                                  <td class="hidden-phone">
                                                                      <b>Bank Charges (C)</b>
                                                                  </td>
                                                                  <td class="hidden-phone">
                                                                      $ 400.40
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                          <div id="datepicker2"></div>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="widget-body">
                                                  <div class="table-responsive">
                                                   <div class="col-md-12">
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
                                                              </td>                                                                                                                        </tr>
                                                            <tr>
                                                              <td class="hidden-phone">
                                                                  <b>Total Loan Amount</b>
                                                              </td>
                                                              <td class="hidden-phone">
                                                                  $ 4,00,000
                                                              </td>
                                                          </tr>

                                                          <tr>
                                                              <td class="hidden-phone">
                                                                  <b> Balance Invoice Amount Paid on Maturity (A - B - C)</b>
                                                              </td>
                                                              <td class="hidden-phone">
                                                                  $ 90,599.6
                                                              </td>
                                                          </tr>
                                                          
                                                          <!-- <tr>
                                                              <td class="hidden-phone" colspan="2">
                                                                  <hr>
                                                              </td>
                                                          </tr> -->

                                                          <td rowspan="5" valign="bottom">
                                                              <button type="submit" class="btn btn-primary">Submit</button>
                                                              <button type="submit" class="btn btn-primary">Cancel</button>
                                                          </td>
                                                          
                                                      </table>
                                                    </div>  
                                                  </div>
                                              </div>

                                          </div>
                                      </div>
                                  </div>
                              </form>
                              <!-- Row End -->

                          </div>
                         
                      </div>

                  </div>
              </div>
          <!-- Request Payment  -->

  <!--Payment Instruction Modal Start-->
    <div id="iDisModalContainer"></div>
  <!-- Payment Instruction Modal End-->

  <!--Payment Instruction Modal Start-->
    <div id="iAppPayContainer"></div>
  <!-- Payment Instruction Modal End--> 

  <!--Payment Instruction Modal Start-->
    <div id="piModal"></div>
  <!-- Payment Instruction Modal End-->
  <!--Invoice Modal Start-->
    <div id="allModals"></div>
  <!-- Invoice Modal End-->
   <div id="poModalContainer"></div>
@stop