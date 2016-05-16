
<!DOCTYPE html>
<html>
    <head>
        <title>{{DEFAULT_TILE}}</title>
        <meta charset="UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <link rel="shortcut icon" href="/public/img/favicon.ico">
        
        <link href="/public/css/bootstrap.min.css" rel="stylesheet">
        
        <link href="/public/css/charts-graphs.css" rel="stylesheet">
        <link href="/public/css/barIndicator.css" rel="stylesheet" />
        <link href="/public/fonts/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/public/css/datepicker.css">
        <link href="/public/css/pricing.css" rel="stylesheet">
        <link href="/public/css/bootstrap-multiselect.css" rel="stylesheet">
        <link href="/public/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="all" href="/public/css/daterangepicker.css" />
        <link rel="stylesheet" type="text/css" media="all" href="/public/css/jquery-ui.css"> 
        <link rel="stylesheet" type="text/css" media="all" href="/public/css/filler/jquery.filer.css">  	
        <link rel="stylesheet" type="text/css" media="all" href="/public/css/chosen.min.css">  	

        <!-- IDLC Bank CSS Start -->
            <link href="/public/css/new.css" rel="stylesheet"> 
        <!-- IDLC Bank CSS End -->

        <!-- YES Bank CSS Start -->
            <!-- <link href="/public/css/custome_blue.css" rel="stylesheet"> --> 
        <!-- YES Bank CSS End -->

        <!-- EASTERN Bank CSS Statrt -->
             <!--<link href="/public/css/custome_yellow.css" rel="stylesheet"> -->
        <!-- EASTERN Bank CSS Statrt -->

        <!-- DHAKA Bank CSS Statrt -->
             <link href="/public/css/custome_Darkblue.css" rel="stylesheet">
        <!-- DHAKA Bank CSS Statrt -->

        <!-- CITY Bank CSS Statrt -->
              <!--<link href="/public/css/custome_orange.css" rel="stylesheet">  -->
        <!-- CITY Bank CSS Statrt -->

        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">--> 

        <script src="/public/js/jquery.js"></script>
        <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="/public/js/html5shiv.js"></script>
          <script src="/public/js/respond.min.js"></script>
        <![endif]-->
        <style>	
            .dataTables_filter{ display:none;}
            input[placeholder="Search Approve / Reject"]{ display:none;}
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{ vertical-align:middle;}
        </style>

    </head>

    <body>
        <div id="loaderDiv" style="display: none">
            <img src="/public/client/images/animated-overlay.gif" class="ajax-loader"/>
        </div>
        <!-- Header Start -->
        <header>
            @if (Auth::check())
            @include('buyer.includes.header')
            @endif
        </header>
        <!-- Header End -->

        <!-- Main Container start -->
        <div class="dashboard-container pullbox_rel">

            <!-------- BODY TOGGLE START------>	
            <!-- <div class="pullbox"> 
                <div class="pullbtn"><i class="fa fa-link"></i> Quick Links</div>
                <ul>
                    <li><a href="#"><i class="fa fa-link"></i> My POs</a></li>
                    <li><a href="#"><i class="fa fa-file-text-o"></i> My Invoice</a></li>
                    <li><a href="#"><i class="fa fa-pencil-square-o"></i> Create Invoice</a></li>
                    <li><a href="#"><i class="fa fa-credit-card"></i> My Payments</a></li>			
                    <li><a href="#"><i class="fa fa-money"></i> Cash Planner</a></li>			
                </ul>
            </div> -->
            <!-------- BODY TOGGLE END------>

            <div class="container">
                <!-- Top Nav Start -->
                @if (Auth::check())
                @include('buyer.includes.navigation')
                @endif

                <!-- Top Nav end -->

                <!-- Sub Nav start -->
                <div class="sub-nav hidden-sm hidden-xs">
                    @section('sidebar')
                    <ul>
                        <li><a href="" class="heading"> DASHBOARD</a></li>
                    </ul>
                    @show
                </div>
                <!-- Sub Nav End -->

                <!-- Dashboard Wrapper Start -->
                <div class="dashboard-wrapper">

                    @yield('content') 

                </div>
                <!-- Dashboard Wrapper End -->

                <footer>
                    <p>Powered By &nbsp;<img src="/public/img/veefin-logo.png"></p>
                </footer>

            </div>
        </div>
        <!-- Main Container end -->

        <script type="text/javascript" src="/public/js/moments.js"></script>
        <script type="text/javascript" src="/public/js/daterangepicker.js"></script>
        <script src="/public/js/jquery.dataTables.min.js"></script>
        <script src="/public/js/jquery.scrollUp.js"></script>
        <script src="/public/js/typeahead.min.js"></script>

        <script src="/public/js/flot/jquery.flot.js"></script>
        <script src="/public/js/flot/jquery.flot.orderBar.min.js"></script>
        <script src="/public/js/flot/jquery.flot.pie.min.js"></script>
        <script src="/public/js/flot/jquery.flot.stack.min.js"></script>
        <script src="/public/js/flot/jquery.flot.tooltip.min.js"></script>
        <script src="/public/js/flot/jquery.flot.resize.min.js"></script>

        <script src="/public/js/flot/custom/pie.js"></script>
        <script src="/public/js/flot/custom/donut_buyer.js"></script>
        <!-- Menu JS -->
        <script src="/public/js/menu.js"></script>

        <!-- UI Custom JS -->
        <script src="/public/js/custom.js"></script>
        <script src="/public/js/jquery-ui-v1.10.3.js"></script>
        <script src="/public/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="/public/js/filler/jquery.filer.min.js?v=1.0.5"></script>


        <script type="text/javascript" src="/public/js/bootstrap-multiselect.js"></script>
        <script type="text/javascript" src="{{asset('/public/js/chosen.jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/public/module/buyerModule.js')}}"></script>
        <script type="text/javascript" src="{{asset('/public/module/customPlugin.js')}}"></script>
        <script type="text/javascript" src="{{asset('/public/module/commonModule.js')}}"></script>
        <!-- code for active the selected menu starts here -->
        <script type="text/javascript">
            $(function() {
                // this will get the full URL at the address bar
                var url = window.location.href;
                // passes on every "a" tag
                $("#cssmenu a").each(function() {
                    // checks if its the same on the address bar
                    if (url == (this.href)) {
                      $(this).parentsUntil().addClass("active");
                    }
                    else{
                        //$("#cssmenu a").find("active").addClass("active");
                    }
                });
            });   

        </script>
        <!-- code for active the selected menu ends here -->
    </body>
</html>