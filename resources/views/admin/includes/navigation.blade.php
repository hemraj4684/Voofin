        <div id='cssmenu'>
          <ul>
            <li class='active' style="width:200px;"><a href='#'> <i class="fa fa-file-text-o"></i> Portfolio Management</a>
              <ul>
                <li><a href='#'>Discounting Requests</a></li>
              </ul>
            </li>
            
            <!--<li><a href='#'><i class="fa fa-credit-card"></i>Payments</a>
              <ul>
                <li><a href='#'>Payment Instruction</a></li>
                <li><a href='#'>Remittances</a></li>
              </ul>
            </li>-->

            <li><a href='#'><i class="fa fa-pencil-square-o"></i>Reports</a></li>

            <li style="width:130px;"><a href='#'><i class="fa fa-cog"></i>Configurations</a>
              <ul>
                <li><a href='#'>Configurations</a></li>
                <li><a href='#'>Users</a></li>
                <li><a href='#'>Buyers</a></li>
                <li><a href='#'>Suppliers</a></li>
                <li><a href='#'>Band Master</a></li>
                <li><a href='{{URL::route('bank.band.bandMapping.view')}}'>Band Mapping</a></li>
                <li><a href='#'>Revenue Sharing</a></li>
                <li><a href='#'>Bank Fees</a></li>
                <li><a href='#'>Funding Limits</a></li>
              </ul>
            </li>

            <li><a href='#'><i class="fa fa-book"></i>Masters</a>
              <ul>
                <li><a href="{{URL::route('admin.role.view')}}">Roles</a></li>
                <li><a href="{{URL::route('admin.permission.view')}}">Permissions</a></li>
                <li><a href="{{URL::route('bank.company.view')}}">Buyers / Suppliers</a></li>
                <li><a href="{{URL::route('admin.user.view')}}">Admin Users</a></li>
                <li><a href="{{URL::route('bank.user.view')}}">Bank Users</a></li>
                <li><a href="{{URL::route('bank.band.view')}}">Bands</a></li>
                <!-- <li><a href="{{URL::route('buyer.user.view')}}">Buyers Users Master</a></li>
                <li><a href="{{URL::route('seller.user.view')}}">Suppliers Users Master</a></li> -->
                <li><a href='#'>Bank Fees</a></li>
                <li><a href='#'>Country</a></li>
                <li><a href='#'>State</a></li>
                <li><a href='#'>City</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- Top Nav End -->
