<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<table class="display table table-condensed table-striped table-bordered table-hover no-margin">
  <thead>
    <tr>
        <th>PI Number</th>
        <th>Invoice Number</th>
        <th>Seller Name</th>
        <th>Currency</th>
        <th>PI Amount</th>
        <th>Maturity Date</th>
        <th>Payment Status</th>
        <th>Approval Date</th>
    </tr>
  </thead>
  <tbody>
  @if(isset($piData))
    @foreach($piData as $key => $val)
    <tr>                          
      <td>{{$val->pi_number}}</a> </td>
      <td>{{$val->invoice_number}}</a></td>
      <td>{{$val->seller_name}}</td>
      <td>{{$val->invoice_currency}}</td>
      <td style="text-align:right;">{{$val->pi_net_amount}}</td>
      <td>{{date('d M Y',strtotime($val->due_date))}}</td>
      <td>{{$statusData['status'][$val->pi_status]}}</td>
      <td>{{date('d M Y',strtotime($val->pi_approval_date))}}</td>
    </tr>
    @endforeach
  @endif  
  </tbody>
</table>
</body>
</html>