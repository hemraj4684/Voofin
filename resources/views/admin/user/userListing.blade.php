@extends('admin.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading"> ADMIN USER LIST</a></li>
	</ul>
	<div class="pull-right" style="margin: 0 20px 0 0;">
		<a href="{{route('admin.user.add')}}"><button type="submit" class="btn btn-info">Create New User</button></a>
	</div>
@stop
@section('content')

<script type="text/javascript" src="{{asset('/public/module/bankChangeStatus.js')}}"></script>
            
        <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Bank Users
                    </div>
                    <span class="tools">
                      <i class="fa fa-cogs"></i>
                    </span>
                  </div>
                  <div class="widget-body">
                  <div class="form-group">
              		  <form id="" class="form-horizontal no-margin" method="get">
                      <div class="row">
                        <div class="col-sm-4">
                          {!! csrf_field() !!}
                          <div class="input-group">
                          <input name="search_box" id="search_box" type="text" class="form-control" placeholder="Search by Name or Email" value="{{Input::get('search_box')}}" aria-describedby="basic-addon1">
                          <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <select id="user_type_search" name="user_type_search" class="form-control">
                          	<option value="">All User Type</option>
                          	<option value="bank" @if(Input::get('user_type_search') === 'bank') {!! "selected" !!} @endif>Bank</option>
                          	<option value="company" @if(Input::get('user_type_search') === 'company') {!! "selected" !!} @endif>Company</option>
                          </select>
                        </div>
                        
                        <div class="col-sm-2">
                          <select id="status" name="status" class="form-control">
                          	<option value="">All Status</option>
                          	<option value="1" @if(Input::get('status') === "1") {!! "selected" !!} @endif>Active</option>
                          	<option value="0" @if(Input::get('status') === "0") {!! "selected" !!} @endif>Inactive</option>
                          </select>
                        </div>

                        <div class="col-sm-1">
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>

                      </div>
                      </form>
                  </div>
                  
                    <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                      <thead>
                        <tr><!-- <th style="width:5%"> -->
                          <th style="width:30%">Name</th>
                          <th style="width:30%" class="hidden-xs">Email</th>
                          <th style="width:10%" class="hidden-xs">User Type</th>
                          <th style="width:10%" class="hidden-xs">Role</th>
                          <!-- <th style="width:10%" class="hidden-xs">Status</th> -->
                          <th style="width:10%" class="hidden-xs">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(isset($users))
                           @foreach($users as $user)
                            <tr>
                              <td><span class="name">{{$user->user_name}}</span></td>
                              <td>{{$user->email}}</td>
                              <td>{{$user->user_type}}</td>
                              <td>
                                @if(isset($roles))
                                  @foreach($roles as $id => $name) 
                                    @if($user->role_id == $id) 
                                      {{$name}} 
                                    @endif 
                                  @endforeach
                                @endif
                              </td>
                              <!-- <td>@if($user->status === "1") {!! "Active" !!} @else {!! "Inactive" !!} @endif</td> -->
                              <td class="hidden-xs">
                                <a href="{{route('admin.user.edit',[$user->uuid])}}" class="btn btn-warning btn-xs"><i class="fa fa-edit" title="Edit"></i></a>
                                @if($user->status === "1")
                                  <a href="" class="btn btn-info btn-xs change_status" id="{{$user->uuid}}"><i class="fa fa-thumbs-down" title="Make Inactive"></i></a>
                                @elseif($user->status === "0")
                                  <a href="" class="btn btn-success btn-xs change_status" id="{{$user->uuid}}"><i class="fa fa-thumbs-up" title="Make active"></i></a>
                                @endif
                              </td>
                            </tr>
                           @endforeach
                        @else
                          <tr>
                              <td colspan="7" style="text-align:center;">No Data found</td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                    @if($users)
                    <div style="text-align:right">{!! $users->render() !!}</div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
		<!-- Row End -->
       
          @stop
          