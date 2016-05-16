@extends('bank.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading">CREATE BAND</a></li>
  </ul> 
@stop
@section('content')
            <!-- Row Start -->
          @if(!isset($band))
            <script type="text/javascript" src="{{asset('/public/module/bankModule.js')}}"></script>
          @endif
           <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Create Band 
                    </div>
                  </div>
                  
                  <div class="widget-body">
                    @if(count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif              
                @if(isset($band))
                  <form id="bandForm" class="form-horizontal no-margin" method = "post" action="{{ $action }}">
                @else
                  <form id="bandForm" class="form-horizontal no-margin" method = "post" action="{{route('bank.band.save')}}">
                @endif
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="bandName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-6">
                      <input type="text" name="name" value="{{$band->name or ''}}" class="form-control" id="bandName" placeholder="Name">
                    </div>
                  </div>
                  <!-- for UUID -->
                  <!-- @if(isset($band))
                
                  @endif --> 
                  <input type="hidden" name="uuid" value="{{isset($user->uuid) ? $user->uuid : ''}}">
                  <div class="form-group">
                    <label for="discounting" class="col-sm-2 control-label">Discount Eligibility (%)</label>
                    <div class="col-sm-6">
                      <input type="text" name="discounting" value="{{$band->discounting or ''}}" class="form-control" id="discounting" placeholder="Discounting">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="discounting" class="col-sm-2 control-label">Manual Discounting (%)</label>
                    <div class="col-sm-6">
                      <input type="text" name="manualDiscounting" value="{{$band->manualDiscounting or ''}}" class="form-control" id="manualDiscounting" placeholder="Manual Discounting">
                      <span id="manualDiscountingErr" style="color:red"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="configurations" class="col-sm-2 control-label">Auto Discounting (%)</label>
                    <div class="col-sm-6">
                      <input type="text" name="autoDiscounting" value="{{$band->autoDiscounting or ''
                    }}" class="form-control" id="configurations" placeholder="Auto Discounting">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="rptPwd" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-6">
                      <select name="status" class="form-control">
                        <option value="1" @if(isset($band->status) && $band->status == "1") {!! "selected" !!} @endif>active</option>
                        <option value="0" @if(isset($band->status) && $band->status == "0") {!! "selected" !!} @endif>in-active</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
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
          </div>
        </div>
      
          @stop