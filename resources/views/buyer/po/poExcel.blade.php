<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
         <thead>
            <tr>
             <th><b>Seller</b></th>
             <th><b>PO Number</b></th> 					
             <th><b>PO Amount</b></th>  
             <th><b>Amount Invoiced</b></th>
             <th><b>Amount Remaining</b></th>
             <th><b>PO Status</b></th>
           </tr>
         </thead>
         <tbody>
          @if(isset($poList))
            @foreach($poList as $valpolist)
            <tr>
              <td>{{ $valpolist->compName }}</td>
              <td style="text-align:right;font-weight:bold;">
               {{ $valpolist->purchase_order_number }}
              </td>
              <?php $cur = $valpolist->currency;?>
              @if(!empty($cur))
                  <?php $symbol=$currencyData[$cur]['symbol']; ?>
              @else
                  <?php $symbol=""; ?>
              @endif
              <td>
                {!!$symbol!!}
                {{ number_format($valpolist->final_amount,2)}}
              </td>
              <td>
                {!!$symbol!!}
                {{ number_format($valpolist->sum,2) }}
              </td>
              <td>
                {!!$symbol!!}
                {{ number_format($valpolist->minus,2) }} 
              </td>
              <td>
                {{$statusData['status'][$valpolist->status]}} 
              </td>   
            </tr>
             @endforeach
             @endif
     </tbody>
   </table>
</html>