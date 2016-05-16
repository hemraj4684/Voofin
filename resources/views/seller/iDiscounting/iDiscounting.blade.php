@extends('seller.layouts.default')
@section('sidebar')
<ul>
    <li><a href="#" class="heading">CASH PLANNER </a></li>
</ul>	
@stop
@section('content')
<!-- Row Start -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    Cash Planner
                </div>
            </div>
            <div class="widget-body">

                <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">

                    <div class="form-group">
                        <label for="buyer" class="col-sm-2">I want Cash On</label>	

                        <div class="col-sm-2">
                            <input name="cashDate" type='text' class="form-control" id="datepicker" placeholder="Cash Date" value="@if(Input::has('cashDate')){!!Input::get('cashDate')!!}@else{!!date('d M Y')!!}@endif"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2">
                            <div class="radio">
                                <label><input type="radio" id="optCashEx" name="optCash" value="expected cash" @if(Input::get('optCash') == "expected cash")checked @endif><b>How much Cash</b></label>
                            </div> 
                        </div>							
                        <div class="col-sm-2">
                            <input @if((Input::get('optCash') == "all cash") || !Input::has('optCash')) disabled @endif type='text' class="form-control" placeholder="Cash Amount" name="cashAmt" id="cashAmt" value="{{Input::get('cashAmt')}}"/> 
                        </div>

                        <div class="col-sm-6">
                            <div class="radio">
                                <label><input type="radio" id="optCashAll" name="optCash" value="all cash" @if((Input::get('optCash') !== "expected cash"))checked @endif><b>I want Maximum Cash</b></label>
                            </div> 
                        </div>						
                    </div>					

                    <div class="form-group"> 	
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>			  


                </form>

                <div class="well">
                    <span style=" font-size:20px; text-align:center!important;">You Are Eligible for 
                        <span style=" font-size:22px; font-weight:bold;" id="eligibleAmtLabel"></span> on <span style=" font-size:22px; font-weight:bold;">@if(Input::has('cashDate')) {!!date('d M Y',strtotime(Input::get('cashDate')))!!} @else {!!date('d M Y')!!}@endif</span></span>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Row End -->
<!-- Row Start -->
@if(session()->get('message') == 'success')
<div class="alert alert-success" role="alert">
    Discounting records save successfully!!!
</div>
@endif
@if(session()->get('message') == 'error')
<div class="alert alert-danger" role="alert">
    Discounting records not save!!!
</div>
@endif
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    Approved Payment List
                </div>
                <span class="tools">
                    <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#iDescounting_remt"><i class="icon-envelope"></i> Request Payment </button>
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
                                    Days to Payment
                                </th>

                                <th>
                                    Invoice Amount
                                </th>

                                <th>
                                    PI Amount
                                </th>

                                <th>
                                    Eligibilty (%)
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
                            @if(isset($iDisData))
                            <?php $invoiceAmt = 0;
                            $piAmt = 0;
                            $bankCharges = 0;
                            $eligibleAmt = 0; ?>
                            @foreach($iDisData as $key => $iDisData)
                            <tr>
                                <td>
                                    <input data-id="{{$iDisData->pi_uuid}}" data-invoice-id="{{$iDisData->invoice_uuid}}" class="iDisCheck" type="checkbox" @if((Input::get('cashAmt') > $eligibleAmt) || Input::get('optCash') === "all cash") || ) checked @endif>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="iDisModal" data-id="{{$iDisData->pi_uuid}}" data-toggle="modal" >{{$iDisData->invoice_number}}</a>
                                </td>

                                <td>
                                    {{$iDisData->buyer_name}}
                                </td>
                                <td class="dueDate">
                                    {{date("d M Y",strtotime($iDisData->due_date))}}
                                </td>
                                <td>
                                    {{$iDisData->discounting_days}}
                                </td>

                                <td style="text-align: right;">
                                    {{$currencyData[$iDisData->invoice_currency]['symbol_native'] or ''}}<label class="invoiceAmt" style="font-weight:normal;">{{number_format($iDisData->invoice_final_amount,2)}}</label>
<?php $invoiceAmt+=$iDisData->invoice_final_amount; ?>
                                </td>

                                <td style="text-align: right;">
                                    {{$currencyData[$iDisData->invoice_currency]['symbol_native'] or ''}}<label class="piAmt" style="font-weight:normal;">{{number_format($iDisData->pi_net_amount,2)}}</label>
<?php $piAmt+=$iDisData->pi_net_amount; ?>
                                </td>

                                <td>
                                    {{$iDisData->discounting}}%
                                </td>	

                                <td style="text-align: right;">
                                    {{$currencyData[$iDisData->invoice_currency]['symbol_native'] or ''}}{{number_format($iDisBankChargeData[$key],2)}}
<?php $bankCharges+=$iDisBankChargeData[$key]; ?>
                                </td>							

                                <td style="text-align: right;">
                                    {{$currencyData[$iDisData->invoice_currency]['symbol_native'] or ''}}<label class="eligibleAmt" style="font-weight:normal;">{{ number_format($iDisData->discounted_amount,2)}}</label>
<?php $eligibleAmt+=$iDisData->discounted_amount; ?>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-success btn-xs padLR pi-modal" title="Pay Me Early" id="{{$iDisData->pi_uuid}}">
                                        <img src="../public/img/money_bag_icon.png" width="20" height="20">
                                    </a>                               							  
                                </td> 
                            </tr>
                            @endforeach
                            @endif

                            <tr>
                                <td class="hidden-phone">
                                    <button class="btn btn-primary btn-sm" id="requestPayment" type="button" data-toggle="modal" disabled><i class="icon-envelope"></i> Request Payment</button>	
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>							
                                <td>  
                                </td>	
                                <td>
                                    <b></b>
                                </td>
                                <td style="text-align: right;">
                                    <b>&#2547;{{number_format($invoiceAmt,2)}}</b>
                                </td>
                                <td style="text-align: right;">
                                    <b>&#2547;{{number_format($piAmt,2)}}</b>
                                </td>
                                <td>

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
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row End -->

<!-- Row Start -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    Payment Expected By @if(Input::has('cashDate')) {!!date('d M Y',strtotime(Input::get('cashDate')))!!} @else {!!date('d M Y')!!}@endif
                </div>				
            </div>
            <div class="widget-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                            <tr>
                                <th style="width:10%">
                                    Invoice Number
                                </th>
                                <th style="width:15%" class="hidden-phone">
                                    Buyer
                                </th>
                                <th style="width:10%" class="hidden-phone">
                                    Due Date
                                </th>
                                <th style="width:10%" class="hidden-phone">
                                    Invoice Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($iDisDateData))
<?php $invoiceApprAmt = 0 ?>
                            @foreach($iDisDateData as $key => $iDisDateData)
                            <tr>
                                <td class="hidden-phone">
                                    <a href="#" class="link_A_blue">{{$iDisDateData->invoice_number}}</a>
                                </td>
                                <td>
                                    {{$iDisDateData->buyer_name}}
                                </td>
                                <td class="hidden-phone">
                                    {{$iDisDateData->due_date}}
                                </td>
                                <td class="hidden-phone">
                                    {{$currencyData[$iDisDateData->invoice_currency]['symbol_native'] or ''}}{{$iDisDateData->invoice_amount}}
<?php $invoiceApprAmt+=$iDisDateData->invoice_amount; ?>
                                </td>						
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td class="hidden-phone">
                                    <b>Total</b>						  
                                </td>
                                <td class="hidden-phone">
                                    <b>&#2547;{{$invoiceApprAmt}}</b>						  
                                </td>
                            </tr>
                            @endif  
                        </tbody>
                    </table>
                </div>									
            </div>
        </div>
    </div>
</div>

<!--Payment Instruction Modal Start-->
<div id="iDisModalContainer"></div>
<!-- Payment Instruction Modal End-->

<!--Payment Instruction Modal Start-->
<div id="iAppPayContainer"></div>
<!-- Payment Instruction Modal End-->	

<!--Payment Instruction Modal Start-->
<div id="piModal"></div>
<!-- Payment Instruction Modal End-->






<!-- Date Slider Start -->	
<script type='text/javascript'>
    $(function () {
        $("#slider").slider({
            value: 1,
            min: 1,
            max: 30,
            step: 1,
            slide: function (event, ui) {
                $("#amount").val("Date " + ui.value);
            }
        });
        $("#amount").val("Date " + $("#slider").slider("value"));
    });
</script>
<!-- Date Slider End -->

<!-- Date Picker Start -->		
<script>
    $(function () {
        $('#datepicker').datepicker();
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });
</script>
<!-- Date Picker End -->	  
@stop
