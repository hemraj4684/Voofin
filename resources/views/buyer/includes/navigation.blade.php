
<!-- Top Nav Start -->
<div id='cssmenu'>
  <ul>
      @foreach(getNavigation('buyer',session('role_id')) as  $key =>$nav)
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
        
        
        
        
<!--    <li><a href='{{URL::route('buyer.poListing.view')}}'> <i class="fa fa-file-text-o"></i> Purchase Orders</a>
      <ul>
        <li><a href='{{URL::route('buyer.poListing.view')}}'>Purchase Orders</a></li>
        <li><a href='{{URL::route('buyer.po.add')}}'>Create PO</a></li>
      </ul>
		</li>
		<li><a href='{{URL::route('buyer.invoice.view')}}'> <i class="fa fa-file-text-o"></i> Invoices</a>
		<ul>
      <li><a href='{{URL::route('buyer.invoice.view')}}'>Invoices</a></li>
      <li><a href='{{URL::route('buyer.piListing.view')}}'>Payment Instruction</a></li>
    </ul>
		</li>
    <li><a href='{{URL::route('buyer.remittances.view')}}'><i class="fa fa-credit-card"></i>Payments</a>
      <ul>
        <li><a href='{{URL::route('buyer.remittances.view')}}'>Remittances</a></li>
      </ul>
    </li>


    <li><a href='#'><i class="fa fa-pencil-square-o"></i>Reports</a>
        <ul>
            <li><a href='{{URL::route('buyer.reports.piReportListing.view')}}'>Buyer PI Report</a></li>
            <li><a href='{{URL::route('buyer.reports.discountingUsageReportListing.view')}}'>Discounting Usage Report</a></li>
            <li><a href='{{URL::route('buyer.reports.limitUtilizationListing.view')}}'>Buyer Limit Utilization</a></li>
        </ul>
    </li>

		<li><a href='{{URL::route('buyer.buyerConfiguration.view')}}'><i class="fa fa-cog"></i>Configurations</a>
      <ul>
        <li><a href='{{URL::route('buyer.buyerConfiguration.view')}}'>Configurations</a></li>
        <li><a href='{{URL::route('buyer.buyerConfiguration.sellerSetting')}}'>Seller Settings</a></li>
				<li class="has-sub"><span class="submenu-button"></span><a href="#" data-original-title="" title="">Masters</a>
				  <ul>
            <li><a href="{{URL::route('buyer.user.view')}}">Buyer Users</a></li>
            <li><a href="{{URL::route('buyer.role.view')}}">Buyer Roles</a></li>
          </ul>
				</li>
      </ul>
    </li>-->
  </ul>
</div>
<!-- Top Nav End -->