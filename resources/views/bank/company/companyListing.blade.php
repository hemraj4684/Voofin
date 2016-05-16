@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">COMPANY LIST</a></li>
	</ul>
	<div class="pull-right" style="margin: 0 20px 0 0;">
		<a href="{{route('bank.company.add')}}"><button type="submit" class="btn btn-primary btn-sm">Add New Company</button></a>
	</div>
@stop
@section('content')            
	<!-- Row Start -->
	<div class="row">
	  <div class="col-lg-12 col-md-12">
		<div class="widget">
		  <div class="widget-header">
			<div class="title">
			  Company Listing
			</div>
		  </div>
		  <div class="widget-body">
		  <div class="form-group">
			  <form id="" class="form-horizontal no-margin" method="get">
			  <div class="row">
				<div class="col-sm-4">
				  {!! csrf_field() !!}
				 <!--  <div class="input-group"> -->
				  <input name="search_box" id="search_box" type="text" class="form-control" placeholder="Search by Name" value="{{Input::get('search_box')}}" aria-describedby="basic-addon1">
				  <!-- <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
				  </div> -->
				</div>
				<div class="col-sm-3">
				  <select id="company_type_search" name="company_type_search" class="form-control">
					<option value="">All Company</option>
					<option value="{{roleId('Buyer')}}" @if(Input::get('company_type_search') === roleId('Buyer')) {!! "selected" !!} @endif>Buyer</option>
					<option value="{{roleId('Seller')}}" @if(Input::get('company_type_search') === roleId('Seller')) {!! "selected" !!} @endif>Seller</option>
					<option value="{{roleId('Both')}}" @if(Input::get('company_type_search') === roleId('Both')) {!! "selected" !!} @endif>Both</option>
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
				  <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
				</div>

			  </div>
			  </form>
		  </div>
		  <div class="table-responsive">
			<table class="table table-responsive table-striped table-bordered table-hover no-margin">
			  <thead>
				<tr>
				  <th style="width:15%">Org Name</th>
				  <th style="width:20%">State</th>
				  <th style="width:10%">City</th>
				  <th style="width:10%">Pin Code</th>
				  <th style="width:20%">Address</th>
				  <th style="width:10%">Actions</th>
				</tr>
			  </thead>
			  <tbody>
				@if(isset($comps))
				   @foreach($comps as $comp)
					<tr>
					  <td><span class="name">{{$comp->name}}</span></td>
					  <td>{{$comp->state}}</td>
					  <td>{{$comp->city}}</td>
					  <td>{{$comp->pincode}}</td>
					  <td>{{$comp->address}}</td>
					  <td>
						<a href="{{route('bank.company.edit',[$comp->uuid])}}" class="btn btn-warning btn-xs"><i class="fa fa-edit" title="Edit"></i></a>                 
						@if($comp->status === "1")
						  <a href="" class="btn btn-danger btn-xs change_status" id="{{$comp->uuid}}"><i class="fa fa-thumbs-down" title="Make Inactive"></i></a>
						@else($comp->status === "0")
						  <a href="" class="btn btn-success btn-xs change_status" id="{{$comp->uuid}}"><i class="fa fa-thumbs-up" title="Make active"></i></a>
						@endif
						<a href="{{route('bank.company.user.view',[$comp->uuid])}}" class="btn btn-info btn-xs"><i class="fa fa-users" title="View Users"></i></a>
					  </td>
					</tr>
				   @endforeach
				@else
				  <tr>
					  <td colspan="7">No Data found</td>
				  </tr>
				@endif
			  </tbody>
			</table>
	      </div>
			  <div style="text-align:right">{!! $comps->render() !!}</div>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Row End -->
          @stop
          