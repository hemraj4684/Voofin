@extends('bank.layouts.default')
@section('content')
            <!-- Row Start -->
            
           <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Create User Account 
                    </div>
                  </div>
                  <div class="widget-body">
                    <form id="userForm" class="form-horizontal no-margin" onsubmit="return false" autocomplete="off">
                    {!! csrf_field() !!}
                      <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-6">
                          <input type="text" name="name" value="{{isset($user->user_name) ? $user->user_name : ''}}" class="form-control" id="userName" placeholder="Name" autocomplete="off">
                          <span id="nameErr" style="color:red"></span>
                        </div>
                      </div>
                      <!-- for UUID -->
                      <input type="hidden" name="uuid" value="{{isset($user->uuid) ? $user->uuid : ''}}">
                      
                      
                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-6">
                          <input type="text" name="email" value="{{isset($user->email) ? $user->email : ''}}" class="form-control" id="email" placeholder="email e.g. xyz@xyz.com">
                          <span id="emailErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="display_name" class="col-sm-2 control-label">User Type</label>
                        <div class="col-sm-6">
                          <select name="user_type" id="user_type" class="form-control">
                            <option>Please Select</option>
                            <option value="bank" @if(isset($user->user_type) && $user->user_type === "bank") {!! "selected" !!} @endif >Bank</option>
                            <option value="company" @if(isset($user->user_type) && $user->user_type === "company") {!! "selected" !!} @endif >Company</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="rptPwd" class="col-sm-2 control-label">Role</label>
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
                        <label for="rptPwd" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                          <select name="status" class="form-control">
                            <option value="1" @if(isset($user->status) && $user->status === "1") {!! "selected" !!} @endif>Active</option>
                            <option value="0" @if(isset($user->status) && $user->status === "0") {!! "selected" !!} @endif>Inactive</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-info" >Save</button>
                          <a class="btn btn-info" href="{{route('bank.user.view')}}">View All</a>
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