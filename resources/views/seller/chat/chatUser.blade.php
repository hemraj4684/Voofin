@extends('seller.layouts.default')
@section('sidebar')
<ul>
  <li><a href="" class="heading">CHAT USERS <i class="fa fa-info-circle" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry."></i></a></li>
</ul>
@stop
@section('content')

<div class="table-responsive">
<div class="search-chat-user col-sm-3 pull-right">
    <form class="search-chat-user">
        <div class="form-group">
            <div class="icon-addon addon-md">
                <input type="text" placeholder="Select user" class="form-control select-chat-user ui-autocomplete-input" id="select-chat-user" autocomplete="off">
                <label for="chatuser" class="glyphicon glyphicon-search" rel="tooltip" title="Select Chat User"></label>
            </div>
        </div>
    </form>
</div>

  <table  id="example" class="display table table-condensed table-striped table-bordered table-hover no-margin">
	<thead>
      <tr>
		<th>Coampany</th>
        <th>Name</th>   
        <th>Last Interacted</th>
		<th>Action</th>							
      </tr>
	  
	  <!-- <tr id="filterrow">
		<th>Coampany</th>
		<th>Name</th>  
		<th>Last Interacted</th>
		<th>Action</th>	
	  </tr>
	</thead> -->

    <tbody>
    @foreach($users as $user)
      <tr>
	    <td>
          {{$user->companyName}}
        </td>
		<td>
          {{$user->userName}}
        </td>							
		<td>
          {{$user->last_interacted}}
        </td>
		<td>
          <a href="/seller/chat/{{$user->userUuid}}" title data-original-title="Chat Now">
          	<i class="fa fa-wechat iover" style="font-size:17px;"></i>
          </a>
        </td>                         
      </tr>	
      @endforeach					  
    </tbody>
  </table>
</div>
<style type="text/css">.dataTables_length{display: none;}</style>
@stop