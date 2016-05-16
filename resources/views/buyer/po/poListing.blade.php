@extends('buyer.layouts.default')
@section('sidebar')
<ul>
  <li><a href="" class="heading">BUYER PO LISTING</a></li>
</ul>
<div class="pull-right" style="margin: 0 20px 0 0;">		
  <a href="{{URL::route('buyer.po.add')}}"><button type="submit" class="btn btn-primary btn-sm">Create PO</button></a>		
</div>
@stop
@section('content')
<!-- Row Start -->
@if(session()->has('nonEditMsg'))
    <div class="alert alert-danger" role="alert">
    {{session('nonEditMsg')}}
    </div>
@endif
@if(session()->has('message'))
<div class="alert alert-success" role="alert">
    {{session()->get('message')}}
</div>
@endif
@if(session()->get('message') == 'error')
<div class="alert alert-danger" role="alert">
    Discounting records not save!!!
</div>
@endif
<div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="widget">
      <div class="widget-header">
        <div class="title">
          Buyer PO List
        </div>                    
      </div>
      <div class="widget-body">

        <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
          <div class="form-group">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
              <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search" value="{{Input::get('search')}}">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">                          
              <select name="buyer[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required lstFruits" multiple="multiple">
               <option value="0" @if((Input::get('buyer'))!=null) @if((in_array('0',Input::get('buyer')))) selected @endif @endif> Created</option>
               <option value="1" @if((Input::get('buyer'))!=null) @if((in_array('1',Input::get('buyer')))) selected @endif @endif> Pending</option>
               <option value="2" @if((Input::get('buyer'))!=null) @if((in_array('2',Input::get('buyer')))) selected @endif @endif> Internal Reject</option>
               <option value="3" @if((Input::get('buyer'))!=null) @if((in_array('3',Input::get('buyer')))) selected @endif @endif> Accepted</option>
               <option value="4" @if((Input::get('buyer'))!=null) @if((in_array('4',Input::get('buyer')))) selected @endif @endif> Declined</option>
               <option value="5" @if((Input::get('buyer'))!=null) @if((in_array('5',Input::get('buyer')))) selected @endif @endif> Completed</option>
             </select>
           </div>
           <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">	<input type="text" id="config-demo" class="form-control date_filter" name="dateRange" value={{ Input::get('dateRange')}}>
             <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
           </div>
           <div class="input-group-btn">
            <button name="searchButton" type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
            <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
            <input name="excelSearchButton" type="submit" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;font-family: FontAwesome;" value="&#xf1c3;">
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-responsive table-striped table-bordered table-hover no-margin">
          <thead>
            <tr>
             <th>Seller</th>
             <th>PO Number</th> 					
             <th>PO Amount</th>  
             <th>Amount Invoiced</th>
             <th>Amount Remaining</th>
             <th>PO Status</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
          @if(isset($poList))
            @foreach($poList as $valpolist)
            <tr>
              <td>{{ $valpolist->compName }}</td>
              <td>
                <a href="javascript:void(0)" data-id="{{$valpolist->uuid}}" data-toggle="modal" 
                class="poView link_A_blue" >{{ $valpolist->purchase_order_number }}</a>
              </td>
              
              <?php $cur = $valpolist->currency;?>
              @if(!empty($cur))
                  <?php $symbol=$currencyData[$cur]['symbol_native']; ?>
              @else
                  <?php $symbol=""; ?>
              @endif

              <td style="text-align:right;">
                {!!$symbol!!}
                {{ number_format($valpolist->final_amount,2)}}
              </td>
              <td style="text-align:right;">
                {!!$symbol!!}
                {{ number_format($valpolist->sum,2) }}
              </td>
              <td style="text-align:right;">
                {!!$symbol!!}
                {{ number_format($valpolist->minus,2) }} 
              </td>
              <td style="text-align:left;">
              <i class="{{$statusData['symbols'][$statusData['status'][$valpolist->status]]}}"></i>
                {{$statusData['status'][$valpolist->status]}} 
              </td>   
              <td  style="padding:0 1%">
              @if(in_array($valpolist->status,array(0,1,2)))
                <a href="{{route('buyer.po.edit',[$valpolist->uuid]) }}" class="btn btn-warning btn-xs" title="Edit">
                  <i class="fa fa-pencil"></i>
                </a>
               
                <button class="btn btn-xs btn-danger delete_po" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" 
                data-message="Are you sure you want to delete this user ?" data-url="{{route('buyer.po.delete',[$valpolist->uuid])}}">
                  <i class="fa fa fa-trash-o" ></i>
                </button>
              @endif
                <a href="#" class="btn btn-success btn-xs" title="Communications">
                  <i class="fa fa-envelope-o"></i>
                </a>                
              </td>                           
            </tr>
             @endforeach

     </tbody>
   </table>
   {!! $poList->appends(Request::only('search'))->render() !!}
   @endif

</div>

</div>
</div>
</div>
</div>
<!-- Row End -->
<div id="poModalContainer"></div>
@include('buyer.includes.deleteModal')

@stop
