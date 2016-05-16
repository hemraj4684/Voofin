<div id="pi_Modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Payment Instruction</h4>
            </div>
            <div class="modal-body">
              @if(!empty($piData->invoice_currency))
               <?php 
                $code=$piData->invoice_currency;
                $symbol=$currencyData[$code]['symbol_native'];
               ?>
              @else
               <?php $symbol="";?>
              @endif
                <!-- Row Start -->
                <form action="/seller/iDiscounting/storeDiscounting" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="widget">

                                <div class="widget-body">
                                    <div class="table-responsive">
                                        <table class="table_borderNon">
                                            <tr>
                                                <td colspan="3">
                                                    <h1>Review Invoice Details</h1>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="hidden-phone">
                                                    <b>Invoice Number</b>
                                                </td>
                                                <td class="hidden-phone">
                                                    {{ $piData->invoice_number }}
                                                </td>
                                                <td>
                                                    <b>Current Payment Terms</b>
                                                </td>
                                                <td>
                                                   <b>{{$piData->payment_terms}}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="hidden-phone">
                                                    <b>Invoice Due Date</b>
                                                </td>
                                                <td class="hidden-phone">
                                                    {{ date('d M Y', strtotime($piData->due_date)) }}
                                                    
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td class="hidden-phone">
                                                    <b>Invoice Amount</b>
                                                </td>
                                                <td class="hidden-phone">
                                                    {{ $symbol." ".number_format($piData->invoice_final_amount,2) }}
                                                </td>
                                                <td class="hidden-phone">
                                                    <b>PI Amount (A)</b>
                                                </td>
                                                <td class="hidden-phone">
                                                    {{ $symbol." ".number_format($piData->pi_net_amount,2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="hidden-phone">
                                                    <b>Eligible/Loan Amount (B)</b>
                                                </td>
                                                <td class="hidden-phone">
                                                    {{ $symbol." ".number_format($piData->discounted_amount,2) }}
                                                </td>
                                                <td>

                                                </td>
                                            <tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="widget-body">

                                    <div class="table-responsive">
                                        <div class="col-sm-6">
                                            <table class="table_borderNon">
                                                <tr>
                                                    <td colspan="3">
                                                        <h1>Select Early Payment Date</h1>
                                                        <p>Select Different dates to see different discount rates.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="hidden-phone">
                                                        <b>Early Payment Date</b>
                                                    </td>
                                                    <td class="hidden-phone earlyPayment" id="earlyPayment">
                                                        {{ date('d M Y') }}
                                                    </td>
                                                    <input type="hidden" name="payment_date" id="paymentDate" value="{{ date('d M Y') }}">
                                                </tr>
                                                <tr>
                                                    <td class="hidden-phone">
                                                        <b>Day(s) Accelerated</b>
                                                    </td>
                                                    <td class="hidden-phone" id="dayAccelerated">
                                                        55
                                                    </td>
                                                    <input type="hidden" name="day_accelerated" id="diffDays">
                                                </tr>
                                                <tr>
                                                    <td class="hidden-phone">
                                                        <b>Discount Rate</b>
                                                    </td>
                                                    <td class="hidden-phone">
                                                        <span id="discountRate">{{ $piData->interestPercentage }}</span>%
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="hidden-phone">
                                                        <b>Bank Charge (C)</b>
                                                    </td>
                                                    <td class="hidden-phone">
                                                        {{ $symbol }}<span id="bankCharge">{{ number_format($bankCharge,2) }}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="datepicker"></div>
                                        </div>
                                    </div>
                                </div>
                               <?php // A-B-C= Balance Invoice Amount Paid on Maturity
                                $finalAmt=$piData->pi_net_amount-$piData->discounted_amount-$bankCharge;
                               ?>
                                <div class="widget-body">
                                    <div class="table-responsive">
                                        <table class="table_borderNon">
                                            <tr>
                                                <td colspan="3">
                                                    <h1>Review Offer and Submit Request</h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="hidden-phone">
                                                    <b>Early Payment Date</b>
                                                </td>
                                                <td class="hidden-phone earlyPayment">
                                                    {{ date('d M Y') }}
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="hidden-phone">
                                                    <b>Loan Amount</b>
                                                </td>
                                                <td class="hidden-phone">
                                                     {{ $symbol." ".number_format($piData->discounted_amount,2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="hidden-phone">
                                                    <b>Balance Invoice Amount Paid on Maturity (A - B - C)</b>
                                                </td>
                                                <td class="hidden-phone">
                                                    <b>{{ $symbol }}<span id="balance">{{ number_format($finalAmt ,2) }}</span></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td rowspan="5" valign="bottom">
                                                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="minDays" id="minDays" value="{{$bankData['basic_configuration']['min_dis_days']}}">
                    <input type="hidden" name="maxDays" id="maxDays" value="{{$bankData['basic_configuration']['max_dis_days']}}">
                    <input type="hidden" name="invoice_id" value="{{$piData->invoice_uuid}}">
                    <input type="hidden" name="pi_id" id="pi_id" value="{{$piData->pi_uuid}}">
                    <input type="hidden" name="due_date" id="due_date" value="{{ date('d M Y', strtotime($piData->due_date)) }}">
                </form>
                <!-- Row End -->

            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
        </div>

    </div>
</div>
