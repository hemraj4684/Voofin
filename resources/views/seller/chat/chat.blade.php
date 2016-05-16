@extends('seller.layouts.default')
@section('sidebar')
<ul>
  <li><a href="" class="heading">CHAT <i class="fa fa-info-circle" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."></i></a></li>
</ul>
@stop
@section('content')
<ul class="mychatsdetails">
    @foreach($chats as $chat)
    @if($chat->from_id == $fromId)
    <li style="color:black">{{$chat->userName}} ({{date('d M Y H:i:s',strtotime($chat->created_at))}}) : {{urldecode($chat->text)}}</li>
    @else
    <li style="color:green"> {{session('userName')}} ({{date('d M Y H:i:s',strtotime($chat->created_at))}}) : {{urldecode($chat->text)}}</li>
    @endif
    @endforeach
    <li id="placeChat" style="display: none">{{session('userName')}} ({{date('d M Y H:i:s',strtotime(date('Y-m-d H:i:s')))}})</li>
    <li id="placeChatWithText"></li>
</ul>
<form id="chatForm" onsubmit="return false">
    {!! csrf_field() !!}
    <div class="col-sm-12">
    <input class="form-control"  placeholder="Write a Reply" type="text" name="text" class="form-control" id="userChat">
    <input type="hidden" name="uuid" value="{{$uuid}}">
    </div>
    <div class="col-sm-12 mar-top20">
    <input type="submit" class="btn Cbtn btn-danger btn-send" value="Send">
    </div>
</form>

@stop
