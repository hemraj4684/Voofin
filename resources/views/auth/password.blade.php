@extends('admin.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading">RESET EMAIL <i class="fa fa-info-circle" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."></i></a></li>
  </ul>
  <div class="pull-right" style="margin: 0 20px 0 0;">    
    <a href='{{url('/login')}}'><button type="submit" class="btn btn-primary btn-sm">Back</button></a>
  </div>
@stop
@section('content')
<div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="widget">
      <div class="widget-header">
        <div class="title">
          Reset Email
        </div>
      </div>
      <div class="widget-body">
        <div class="row">
          <div class="col-sm-12 col-md-12">
            <form method="POST" action="{{route('admin.email.resetPassword.save')}}">
                {!! csrf_field() !!}

                @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group">
                    <label for="email" class="col-sm-1 control-label">Email</label>
                    <div class="col-sm-6">
                      <input type="email" name="email" value="{{ old('email') }}" class="form-control form-group" id="email" placeholder="email">
                    </div>
                </div>

              <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                  <button type="submit" class="btn btn-info">Send Mail</button>
                </div>
              </div>
            </form>
         </div>
        </div>
      </div>
    </div>
</div>
</div>
@stop