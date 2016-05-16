@extends('buyer.layouts.default')
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
                    <form id="resetPassword" class="form-horizontal no-margin" autocomplete="off">
                    {!! csrf_field() !!}
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-6">
                          <input type="password" name="password" value="" class="form-control" id="password" placeholder="Password">
                          <span id="passwordErr" stylesheet="color:red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="confirmPassword" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-6">
                          <input type="password" name="confirmPassword" value="" class="form-control" id="confirmPassword" placeholder="Confirm Password">
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