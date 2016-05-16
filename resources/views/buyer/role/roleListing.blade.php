@extends('buyer.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading"> BUYER ROLE LIST</a></li>
	</ul>
	<div class="pull-right" style="margin: 0 20px 0 0;">
		<a href="{{route('buyer.role.add')}}"><button type="submit" class="btn btn-primary btn-sm">Create New Role</button></a>
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
                      Role Listing
                    </div>                    
                  </div>
                  
                  <div class="widget-body">
                  <div class="form-group">
                    <div class="row">
                          <div class="col-sm-4">
                            {!! csrf_field() !!}
                            <!-- <div class="input-group"> -->
                            <input name="search_box" id="search_box" type="text" class="form-control" placeholder="Search by Role" value="{{Input::get('search_box')}}" aria-describedby="basic-addon1">
                            <!-- <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                            </div> -->
                          </div>
                          <!-- <div class="col-sm-3">
                            <select id="user_type_search" name="user_type_search" class="form-control">
                              <option value="">All User Type</option>
                              <option value="buyer" @if(Input::get('user_type_search') === 'buyer') {!! "selected" !!} @endif>Buyer</option>
                              <option value="supplier" @if(Input::get('user_type_search') === 'supplier') {!! "selected" !!} @endif>Supplier</option>
                            </select>
                          </div> -->
                          
                          <!--  <div class="col-sm-2">
                            <select id="status" name="status" class="form-control">
                              <option value="">All Role Type</option>
                              <option value="1" @if(Input::get('status') === "1") {!! "selected" !!} @endif>Bank</option>
                              <option value="0" @if(Input::get('status') === "0") {!! "selected" !!} @endif>Buyer</option>
                              <option value="0" @if(Input::get('status') === "0") {!! "selected" !!} @endif>Supplier</option>
                              <option value="0" @if(Input::get('status') === "0") {!! "selected" !!} @endif>Buyer+Supplier</option>
                            </select>
                          </div> --> 

                          <div class="col-sm-1">
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                          </div>
                          
                    </div>
                  </div>
                    <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                      <thead>
                        <tr>
                          <th style="width:20%" class="hidden-xs">Role Name</th>
                          <th style="width:20%" class="hidden-xs">Role Type</th>
                          <th style="width:10%" class="hidden-xs">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($roles as $role)
                        <tr>                          
                          <td>{{$role->display_name}}</td>
                          <td><span class="name">{{roleType($role->type)}}</span></td>
                          <td class="hidden-xs">
                            <a href="{{route('buyer.role.edit',[$role->uuid])}}" id="{{$role->uuid}}" class="btn btn-warning btn-xs"><i class="fa fa-edit" title="Edit"></i></a>
                            @if($role->status === "1")
                              <a href="#" class="btn btn-warning btn-xs" id="{{$role->uuid}}"><i class="fa fa-thumbs-down" title="Make Inactive"></i></a>
                            @else
                              <a href="#" class="btn btn-success btn-xs" id="{{$role->uuid}}"><i class="fa fa-thumbs-up" title="Make active"></i></a>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->

          @stop