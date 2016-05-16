<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table class="table table-condensed table-striped table-bordered table-hover no-margin">
      <thead>
        <tr>
            <th>PI Number</th>
            <th>Invoice Number</th>
            <th>Buyer Name</th>
            <th>Discounting Date</th>
            <th>Currency</th>
            <th>Invoice Amount</th>
            <th>PI Amount</th>
            <th>Discounting Amount</th>
            <th>Bank Charges</th>
            <th>Discounting Status</th>
            <th>Paid Amount</th>
            <th>Payment Date</th>
            <th>Maturity Date</th>
            <th>Remaining Payment</th>
            <th>Bank Loan Number</th>
        </tr>
      </thead>
      <tbody>
      @if(isset($iReqData))
       @foreach($iReqData as $key => $iReqDataVal)
        <tr>                          
          <td>{{$iReqDataVal->pi_number}}</td>
          <td>{{$iReqDataVal->invoiceNumber}}</td>
          <td>{{$iReqDataVal->buyerName}}</td>
          <td>{{date('d M Y',strtotime($iReqDataVal->discountingDate))}}</td>
          <td>{{$iReqDataVal->currency}}</td>
          <td style="text-align: right;">{{$iReqDataVal->invoiceAmt}}</td>
          <td style="text-align: right;">{{$iReqDataVal->piAmount}}</td>
          <td style="text-align: right;">{{$iReqDataVal->loanAmount}}</td>
          <td style="text-align: right;">{{number_format($bankCharge[$key],2)}}</td>
          <td>{{$statusData['status'][$iReqDataVal->status]}}</td>
          <td style="text-align: right;">-</td>
          <td>{{date('d M Y',strtotime($iReqDataVal->loan_date))}}</td>
          <td>{{date('d M Y',strtotime($iReqDataVal->dueDate))}}</td>
          <td style="text-align: right;">$ </td>
          <td>{{$iReqDataVal->discountingId}}</td>
        </tr>
        @endforeach
       @else
        <tr>
          <td colspan="15">No Data Found</td>
        </tr>
       @endif
      </tbody>
    </table>
  
</html>