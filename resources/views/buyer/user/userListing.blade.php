@extends('buyer.layouts.default')
<script type="text/javascript" src="{{asset('/public/module/bankModule.js')}}"></script>
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BUYER USER LIST</a></li>
	</ul>
	<div class="pull-right" style="margin: 3px 20px 0 0;">
		<a href="{{route('buyer.user.add')}}"><button type="submit" class="btn btn-primary btn-sm">Create New User</button></a>
	</div>
@stop
@section('content')


            
	<!-- Row Start -->
	<div class="row">
	  <div class="col-lg-12 col-md-12">
		<div class="widget">
		  <div class="widget-header">
			<div class="title">
			  Buyer Users
			</div>			
		  </div>
		  <div class="widget-body">
		  <div class="form-group">
			  <form id="" class="form-horizontal no-margin" method="get">
			  <div class="row">
				<div class="col-sm-4">
				  {!! csrf_field() !!}
				  <!-- <div class="input-group"> -->
				  <input name="search_box" id="search_box" type="text" class="form-control" placeholder="Search by Name or Email" value="{{Input::get('search_box')}}" aria-describedby="basic-addon1">
				  <!-- <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span> 
				  </div>-->
				</div>
				<!-- <div class="col-sm-3">
				  <select id="user_type_search" name="user_type_search" class="form-control">
					<option value="">All User Type</option>
					<option value="buyer" @if(Input::get('user_type_search') === 'buyer') {!! "selected" !!} @endif>Buyer</option>
					<option value="supplier" @if(Input::get('user_type_search') === 'supplier') {!! "selected" !!} @endif>Supplier</option>
				  </select>
				</div> -->
				
				<div class="col-sm-4">
				  <select id="status" name="status" class="form-control lstFruits" multiple="multiple">
					<option value="1" @if(Input::get('status') === "1") {!! "selected" !!} @endif>Active</option>
					<option value="0" @if(Input::get('status') === "0") {!! "selected" !!} @endif>Inactive</option>
				  </select>
				</div>

				<div class="col-sm-1">
	                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
	              </div>

			  </div>
			  </form>
		  </div>
		  <div class="table-responsive">
			<table class="table table-responsive table-striped table-bordered table-hover no-margin">
			  <thead>
				<tr>
				  <th style="width:30%">Name</th>
				  <th style="width:30%">Email</th>
				  <th style="width:20%">Role</th>
				  <!-- <th style="width:10%" class="hidden-xs">Status</th> -->
				  <th style="width:10%">Actions</th>
				</tr>
			  </thead>
			  <tbody>
				@if(isset($users))
				   @foreach($users as $user)
					<tr>
					  <td><span class="name">{{$user->user_name}}</span></td>
					  <td>{{$user->email}}</td>
					  <td>{{$user->name}}</td>
					  <!-- <td>@if($user->status === "1") {!! "Active" !!} @else {!! "Inactive" !!} @endif</td> -->
					  <td>
						<a href="{{route('buyer.user.edit',[$user->uuid])}}" class="btn btn-warning btn-xs"><i class="fa fa-edit" title="Edit"></i></a>
						@if($user->status === "1")
						  <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-thumbs-down" title="Make Inactive"></i></a>
						@else($user->status === "0")
						  <a href="#" class="btn btn-success btn-xs"><i class="fa fa-thumbs-up" title="Make active"></i></a>
						@endif                 
					  </td>
					</tr>
				   @endforeach
				@endif
			  </tbody>
			</table>
		  </div>
			  <div style="text-align:right">{!! $users->render() !!}</div>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Row End -->
          
@stop
          