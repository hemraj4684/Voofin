@extends('buyer.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">SELLER SETTING </a></li>
	</ul>
	<!-- <div class="pull-right" style="margin: 0 20px 0 0;">		
		<a href="{{route('bank.band.add')}}"><button type="submit" class="btn btn-info">Create New Band</button></a>		
	</div> -->
	


@stop
@section('content')

<script type="text/javascript" src="{{asset('/public/module/bankChangeStatus.js')}}"></script>
            
<!-- Row Start -->
<div class="row">
  <div class="col-lg-12 col-md-12">
	<div class="widget">
	  <div class="widget-header">
		<div class="title">
		  Seller Settings
		</div>
	  </div>
	  <div class="widget-body">
	  <div class="table-responsive">
		<table class="table table-responsive table-striped table-bordered table-hover no-margin">
		  <thead>
			<tr>
			  <th style="width:20%">Seller Name</th>
			  <th style="width:20%">TDS Amount(%)</th>
			  <th style="width:20%">Payment Terms(Days)</th>
			  <th style="width:20%">Actions</th>
			</tr>
		  </thead>
		  <tbody>
			@if(isset($data))
			   @foreach($data as $data)
				<tr>
				  <td><span class="name">{{$data->name}}</span></td>
				  <td><span class="name"><input type="hidden" name="_token" value="{{csrf_token()}}"><input type="text" name="taxPercentage" value="{{$data->tax_percentage}}" class="seller_hide_border" id="inputText" readonly></span></td>
				  <td><span class="name"><input type="text" name="paymentTerms" value="{{$data->payment_terms}}" class="seller_hide_border" id="inputText" readonly></span></td>
				  <td>
				    <a class="btn btn-warning btn-xs hide_btn" id="hide_btn" title="Edit" href="javascript:void(0)"><i class="fa fa-pencil"></i></a>
					<a data-id="{{$data->id}}" class="btn btn-success btn-xs show_btn"  id="show_btn" style="display:none;" title="Save" href=""><i class="fa fa-floppy-o"></i></a>
					<!-- <a data-toggle="modal" data-id="{{$data->id}}" data-target="#sellerSettingModal" href="javascript:void(0)" class="btn btn-warning btn-xs sellerSetting"><i class="fa fa-edit" title="Edit"></i></a> -->
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
		  @if(isset($bands) && $bands)
		  <div style="text-align:right">{!! $bands->render() !!}</div>
		  @endif
	  </div>
	</div>
  </div>
</div>
<div id="sellerSettingContainer"></div>
<!-- Row End -->          
@stop
          