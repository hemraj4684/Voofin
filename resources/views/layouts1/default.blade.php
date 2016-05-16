<!DOCTYPE html>
<html>
  <head>
    <title> Dashboard</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta name="description" content="Blue Moon - Responsive Admin Dashboard" />
    <meta name="keywords" content="Notifications, Admin, Dashboard, Bootstrap3, Sass, transform, CSS3, HTML5, Web design, UI Design, Responsive Dashboard, Responsive Admin, Admin Theme, Best Admin UI, Bootstrap Theme, Wrapbootstrap, Bootstrap, bootstrap.gallery" />
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="shortcut icon" href="img/favicon.ico">
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/new.css" rel="stylesheet"> 
    <link href="/public/css/charts-graphs.css" rel="stylesheet">
    <link href="/public/css/barIndicator.css" rel="stylesheet" />
    <link href="/public/fonts/font-awesome.min.css" rel="stylesheet">
	<script src="/public/js/jquery.js"></script>
    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="/public/js/html5shiv.js"></script>
      <script src="/public/js/respond.min.js"></script>
    <![endif]-->
    

  </head>

  <body>

    <!-- Header Start -->
    <header>
      @if (Auth::check())
        @include('admin.includes.header')
      @endif
    </header>
    <!-- Header End -->

    <!-- Main Container start -->
    <div class="dashboard-container">

      <div class="container">
        <!-- Top Nav Start -->
        @if (Auth::check())
          @include('admin.includes.navigation')
        @endif
        
        <!-- Sub Nav End -->

        <!-- Dashboard Wrapper Start -->
        <div class="dashboard-wrapper">

          @yield('content') 

        </div>
        <!-- Dashboard Wrapper End -->

        <footer>
          <p>© Geometric</p>
        </footer>

      </div>
    </div>
    <!-- Main Container end -->

    
    <script src="/public/js/bootstrap.min.js"></script>
    <script src="/public/js/jquery.scrollUp.js"></script>
    
    <!-- Flot Charts -->
    <script src="/public/js/flot/jquery.flot.js"></script>
    <script src="/public/js/flot/jquery.flot.pie.min.js"></script>
    <script src="/public/js/flot/jquery.flot.stack.min.js"></script>
    <script src="/public/js/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/public/js/flot/jquery.flot.orderBar.min.js"></script>
    <script src="/public/js/flot/jquery.flot.resize.min.js"></script>

    <script src="/public/js/flot/custom/index3-pie.js"></script>
    <script src="/public/js/flot/custom/index3-area.js"></script>
    <script src="/public/js/flot/custom/horizontal-index.js"></script>
    <script src="/public/js/flot/custom/realtime-index.js"></script>
    <script src="/public/js/flot/custom/index3-scatter.js"></script>
    
    <!-- Custom JS -->
    <script src="/public/js/menu.js"></script>

    <!-- Sparkline JS -->
    <script src="/public/js/sparkline.js"></script>
    
    <script src="/public/js/jquery.easing.1.3.js"></script>
    <script src="/public/js/jquery-barIndicator.js"></script>
    <script src="/public/js/custom-barIndicator.js"></script>

    <script type="text/javascript">
      //ScrollUp
      $(function () {
        $.scrollUp({
          scrollName: 'scrollUp', // Element ID
          topDistance: '300', // Distance from top before showing element (px)
          topSpeed: 300, // Speed back to top (ms)
          animation: 'fade', // Fade, slide, none
          animationInSpeed: 400, // Animation in speed (ms)
          animationOutSpeed: 400, // Animation out speed (ms)
          scrollText: 'Top', // Text for element
          activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        });
      });

      //Tooltip
      $('a').tooltip('hide');
      $('i').tooltip('hide');

      // SparkLine Bar
      $(function () {
        $("#emails").sparkline([3,2,4,2,5,4,3,5,2,4,6,9,12,15,12,11,12,11], {
        type: 'line',
        width: '200',
        height: '70',
        lineColor: '#3693cf',
        fillColor: '#e5f3fc',
        lineWidth: 3,
        spotRadius: 6
        });
      });

    </script>

  </body>
</html>