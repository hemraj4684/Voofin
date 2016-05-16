        <!-- Top Nav Start -->
        
<div id='cssmenu'>
    <ul>
        @foreach(getNavigation('seller',session('role_id')) as  $key =>$nav)
        <li><a href="{{$nav['url']}}"><i class="{{$nav['class']}}"></i>{{$key}}</a>
            @if($nav['Child'])
            <ul>
                @foreach($nav['Child'] as $k1=>$v1)
                @if(isset($v1['subChild']))
                <li class="has-sub"><span class="submenu-button"></span><a href="#" data-original-title="" title="">{{$v1['name']}}</a>
                    <ul>
                        @foreach($v1['subChild'] as $k2=>$v2)
                        <li><a href="{{$v2['url']}}">{{$v2['name']}}</a></li>
                        @endforeach
                    </ul>
                </li>
                @else
                <li class="topMenu"><a href="{{$v1['url']}}">{{$v1['name']}}</a></li>
                @endif
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
<!--        <li><a href='/seller/poListing'> <i class="fa fa-file-text-o"></i> Purchase Orders</a>
         <ul>
          <li><a href='/seller/poListing'>Purchase Orders</a></li>
         </ul>
        </li>
        <li><a href='/seller/invoice'> <i class="fa fa-file-text-o"></i> Invoices</a>
           <ul>
            <li><a href='/seller/invoice'>Invoices</a></li>
            <li><a href='/seller/invoice/add'>Create Invoice</a></li>
            <li><a href='/seller/piListing'>Payment Instructions</a></li>
          </ul>
        </li>
        <li><a href='/seller/iDiscounting'> <i class="fa fa-tag"></i> Cash Planner</a>
           <ul>
            <li><a href='/seller/iDiscounting'> Cash Planner</a></li>
            <li><a href='/seller/discountingRequest'> Discounting Requests</a></li>         
           </ul>
        </li>      
        <li><a href='/seller/remittances'><i class="fa fa-credit-card"></i>Payments</a>
          <ul>
            <li><a href='/seller/remittances'>Remittances</a></li>
          </ul>
        </li>      
        <li><a href='#'><i class="fa fa-pencil-square-o"></i>Reports</a>
            <ul>
                <li><a href='/seller/inwardRemittanceReport'>Inward Remittance Report</a></li>
                <li><a href='/seller/discountingUsageReport'>Discounting Usage Report</a></li>
                <li><a href='/seller/potentialDiscountingReport'>Potential Discounting Report<a/></li>
                <li><a href='/seller/discountingReport'>Seller Discounting Report</a></li>
            </ul>
        </li>      
        <li><a href='/seller/sellerConfiguration'><i class="fa fa-cog"></i>Configurations</a>
          <ul>
            <li class="topMenu"><a href='/seller/sellerConfiguration'>Configurations</a></li>
             <li><a href='#'>Auto Discounting</a></li> 
            <li class="has-sub"><span class="submenu-button"></span><a href="#" data-original-title="" title="">Masters</a>
              <ul>
                <li><a href="/seller/user">Seller Users</a></li>
                <li><a href="/seller/role">Seller Roles</a></li>
              </ul>
            </li>
          </ul>
        </li>-->
    </ul>
</div>  
  <!-- Top Nav End -->