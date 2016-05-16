@extends('seller.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading"> SELLER USERS <i class="fa fa-info-circle" title="Create users and match them with their respective roles."></i></a></li>
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
                      Create / Edit User
                    </div>
                  </div>
                  <div class="widget-body">
                    <form id="supplierUserForm" class="form-horizontal no-margin" onsubmit="return false" autocomplete="off">
                    {!! csrf_field() !!}
                      <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">Name<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="name" value="{{isset($user->name) ? $user->name : ''}}" class="form-control" id="userName" placeholder="Name" autocomplete="off">
                          <span id="nameErr" style="color:red"></span>
                        </div>
                      </div>
                      <!-- for UUID -->
                      <input type="hidden" name="uuid" value="{{isset($user->uuid) ? $user->uuid : ''}}">
                      
                      
                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="email" value="{{isset($user->email) ? $user->email : ''}}" class="form-control" id="email" placeholder="email e.g. xyz@xyz.com">
                          <span id="emailErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="role" class="col-sm-2 control-label">Role<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <select name="role" class="form-control">
                              <option>Please Select</option>
                            @foreach($roles as $id => $name)
                              <option value="{{$id}}" @if(isset($user->role_id) && $user->role_id == $id) {!! "selected" !!} @endif>{{$name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="rptPwd" class="col-sm-2 control-label">Status<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <select name="status" class="form-control">
                            <option value="1" @if(isset($user->status) && $user->status === "1") {!! "selected" !!} @endif>Yes</option>
                            <option value="0" @if(isset($user->status) && $user->status === "0") {!! "selected" !!} @endif>No</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-info" >Save</button>
                          <a class="btn btn-info" href="{{route('seller.user.view')}}">View All</a>
                        </div>
                      </div>
                      <div class="loader">
                         <center>
                             <img class="loading-image" src="{{asset('/public/img/loading-red.gif')}}" alt="loading..">
                         </center>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          
          @stop