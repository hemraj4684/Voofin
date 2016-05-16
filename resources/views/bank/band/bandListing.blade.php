@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BAND LIST</a></li>
	</ul>
	<div class="pull-right" style="margin: 0 20px 0 0;">		
		<!-- <button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-info">Create New Band</button> -->
		<a href="{{route('bank.band.add')}}"><button type="submit" class="btn btn-primary btn-sm">Create New Band</button></a>		
	</div>
	
<!-- POPUP Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Band </h4>
      </div>
      <div class="modal-body">
        @if(!isset($band))
            <script type="text/javascript" src="{{asset('/public/module/bankBandModule.js')}}"></script>
          @endif
           
		  <div class="widget-body">
						  
			@if(isset($band))
			  <form id="bandForm" class="form-horizontal no-margin" method = "post" action="{{ $action }}">
			@else
			  <form id="bandForm" class="form-horizontal no-margin" onsubmit="return false">
			@endif
			  {!! csrf_field() !!}
			  <div class="form-group">
				<label for="bandName" class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8">
				  <input type="text" name="name" value="manual_discounting" class="form-control" id="bandName" placeholder="Name">
				  <input type="text" name="name" value="" class="form-control" id="bandName" placeholder="Name">
				  <span id="nameErr" style="color:red"></span>
				</div>
			  </div>
			  <!-- for UUID -->
			  <input type="hidden" name="uuid" value="{{isset($user->uuid) ? $user->uuid : ''}}">
			  <div class="form-group">
				<label for="discounting" class="col-sm-4 control-label">Discouting</label>
				<div class="col-sm-8">
				  <input type="text" name="discounting" value="{{isset($band->discounting) ? $band->discounting : ''}}" class="form-control" id="discounting" placeholder="Discounting">
				  <span id="discountingErr" style="color:red"></span>
				</div>
			  </div>
			  <div class="form-group">
				<label for="discounting" class="col-sm-4 control-label">Manual Discounting</label>
				<div class="col-sm-8">
				  <input type="text" name="manualDiscounting" value="{{isset($band->manual_discounting) ? $band->configurations : ''}}" class="form-control" id="discounting" placeholder="Discounting">
				  <span id="manualDiscountingErr" style="color:red"></span>
				</div>
			  </div>
			  <div class="form-group">
				<label for="configurations" class="col-sm-4 control-label">Auto Discounting</label>
				<div class="col-sm-8">
				  <input type="text" name="autoDiscounting" value="{{isset($band->configurations) ? $band->configurations : ''}}" class="form-control" id="configurations" placeholder="Configuration">
				  <span id="autoDiscountingErr" style="color:red"></span>
				</div>
			  </div>

			  <div class="form-group">
				<label for="rptPwd" class="col-sm-4 control-label">Status</label>
				<div class="col-sm-8">
				  <select name="status" class="form-control">
					<option value="1" @if(isset($user->status) && $user->status === "1") {!! "selected" !!} @endif>Yes</option>
					<option value="0" @if(isset($user->status) && $user->status === "0") {!! "selected" !!} @endif>No</option>
				  </select>
				</div>
			  </div>

			  <div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
				  <button type="submit" class="btn btn-info" >Save</button>
				  <a class="btn btn-info" href="{{route('bank.band.view')}}">View All</a>
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
              
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->

@stop
@section('content')

<script type="text/javascript" src="{{asset('/public/module/bankChangeStatus.js')}}"></script>
            
<!-- Row Start -->
<div class="row">
  <div class="col-lg-12 col-md-12">
	<div class="widget">
	  <div class="widget-header">
		<div class="title">
		  Bands
		</div>
	  </div>
	  <div class="widget-body">
	  <div class="table-responsive">
		<table class="table table-responsive table-striped table-bordered table-hover no-margin">
		  <thead>
			<tr>
			  <th style="width:20%">Band Name</th>
			  <th style="width:20%">Discount Eligibility (%)</th>
			  <th style="width:20%">Manual Discounting (%)</th>
			  <th style="width:20%">Auto Discounting (%)</th>
			  <th style="width:20%">Actions</th>
			</tr>
		  </thead>
		  <tbody>
			@if(isset($bands))
			   @foreach($bands as $band)
				<tr>
				  <td><span class="name">{{$band->name}}</span></td>
				  <td>{{$band->discounting}}</td>
				  <td>{{$band->manualDiscounting}}</td>
				  <td>{{$band->autoDiscounting}}</td> 
				  <td>
					<a href="{{route('bank.band.edit',[$band->id])}}" class="btn btn-warning btn-xs"><i class="fa fa-edit" title="Edit"></i></a>
					@if($band->status === "1")
					  <a href="" class="btn btn-info btn-xs change_status" id="{{$band->id}}"><i class="fa fa-thumbs-down" title="Make Inactive"></i></a>
					@elseif($band->status === "0")
					  <a href="" class="btn btn-success btn-xs change_status" id="{{$band->id}}"><i class="fa fa-thumbs-up" title="Make active"></i></a>
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
      </div>
	  </div>
	</div>
  </div>
</div>
<!-- Row End -->          
@stop
          