@extends('bank.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading">RESET PASSWORD </a></li>
  </ul>  
@stop
@section('content')
            <!-- Row Start -->
            <script type="text/javascript" src="{{asset('/public/module/bankModule.js')}}"></script>
           <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Reset Password
                    </div>
                  </div>
                  <div class="widget-body">
                    <form id="resetPassword" class="form-horizontal no-margin" autocomplete="off" onsubmit="return false">
                    {!! csrf_field() !!}
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Old Password</label>
                        <div class="col-sm-6">
                          <input type="password" name="oldPassword" value="" class="form-control" id="old_password" placeholder="Old Password">
                          <span id="oldPasswordErr" stylesheet="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-6">
                          <input type="password" name="password" value="" class="form-control" id="new_password" placeholder="New Password">
                          <span id="passwordErr" stylesheet="color:red"></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="confirmPassword" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-6">
                          <input type="password" name="password_confirmation" value="" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                          <span id="password_confirmationErr" stylesheet="color:red"></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                            <input type="hidden" name="uuid" value="">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-info">Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          
          @stop