
<!DOCTYPE html>
<html>
  <head>
    <title>{{DEFAULT_TILE}}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <link rel="shortcut icon" href="/public/img/favicon.ico">
    
    <link href="{{asset('/public/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('/public/css/new.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('/public/css/custome_blue.css')}}" rel="stylesheet">  -->
    <!-- <link href="{{asset('/public/css/custome_yellow.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('/public/css/custome_Darkblue.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('/public/css/custome_orange.css')}}" rel="stylesheet"> -->

    <!-- Important. For Theming change primary-color variable in main.css  -->

    <link href="{{asset('/public/fonts/font-awesome.min.css')}}" rel="stylesheet">

    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    
  </head>

  <body class="loginBG">

    <!-- Main Container start -->
    <div class="dashboard-container">

      <div class="container">

        <!-- Row Start -->
        <div class="row">
          <div class="col-lg-4 col-md-4 col-md-offset-4">
            <div class="sign-in-container">
              <form method="POST" class="login-wrapper" action="/auth/login">
                {!! csrf_field() !!}
                <div class="header">
                  <div class="row">
                    <div class="col-md-12 col-lg-12">
					
					<!--Notifications Start-->
          @if(isset($error) && $error) 
					<div class="alert alert-danger">
					  <strong><i class="fa fa-times-circle fa-lg"></i></strong> {{$error}}
					</div>
					
					<!-- <div class="alert alert-warning">
					  <strong><i class="fa fa-exclamation-circle fa-lg"></i></strong> Email or password not matched
					</div>
					
					<div class="alert alert-info">
					  <strong><i class="fa fa-info-circle fa-lg"></i></strong> Email or password not matched
					</div> -->
          @endif
					<!--Notifications End-->
					
                      <h3>Powered By <img src="/public/img/veefinLogo.png" alt="Logo" style="width:170px;"></h3>
                      <!-- <p>Powered By</p> -->
                    </div>
                  </div>
                </div>
                <div class="content">
                  <div class="form-group">
                    <!-- <label for="userName">Email</label> -->
                    <input type="email" name="email" class="form-control" id="userName" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <!-- <label for="Password1">Password</label> -->
                    <input type="password" name="password" class="form-control" id="Password1" placeholder="Password">
                  </div>
                </div>
                <div class="actions">
                  <input class="btn btn-danger pull-left" name="Login" type="submit" value="Login" style="padding:5px 30px; font-size:16px;">
                  <!-- <a class="link" href="{{URL::route('admin.email.resetPassword')}}">Forgot Password email?</a> -->
                  <a class="link" href="{{URL::route('admin.user.resetPassword')}}">Forgot Password?</a>
                  <div class="clearfix"></div>
                </div>


                <div class="anti-logo">
                <div class="mcafee-holder"><img src="/public/img/McAfee-logo.png" alt="Logo" class="pull-left" style="width:100px;"></div>
                  
                  <div class="norton-holder"><img src="/public/img/norton-logo.gif" alt="Logo" class="pull-right" style="width:100px;"></div>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Row End -->
        
      </div>
    </div>
    <!-- Main Container end -->

    <script src="{{asset('/public/js/jquery.js')}}"></script>
    <script src="{{asset('/public/js/bootstrap.min.js')}}"></script>

  </body>
</html>
