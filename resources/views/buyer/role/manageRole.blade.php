@extends('buyer.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading"> CREATE ROLE</a></li>
  </ul>
@stop
@section('content')
     <!-- Row Start -->
     <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="widget">
            <div class="widget-header">
              <div class="title">
                Create Role 
              </div>
            </div>
            <div class="widget-body">
              <form id="roleForm" class="form-horizontal no-margin" onsubmit="return false">
              {!! csrf_field() !!}
                 <div class="form-group">
                  <label for="userName" class="col-sm-2 control-label">Name (temp)</label>
                  <div class="col-sm-6">
                    <input type="text" name="name" value="{{isset($role->name) ? $role->name: ''}}" class="form-control" id="userName" placeholder="Name">
                    <span id="nameErr" stylesheet="color:red"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="display_name" class="col-sm-2 control-label">Role Name</label>
                  <div class="col-sm-6">
                    <input type="text" name="display_name" value="{{isset($role->display_name) ? $role->display_name: ''}}" class="form-control" id="display_name" placeholder="Role Name">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Role Description</label>
                  <div class="col-sm-6">
                    <textarea name="description" class="form-control" placeholder="Role Description">{{isset($role->description) ? $role->description: ''}}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="rptPwd" class="col-sm-2 control-label">Role Type</label>
                  <div class="col-sm-6">
                    <select name="type" class="form-control">
                      
                      <option value="{{roleId('Buyer')}}" {{isset($role->type) && $role->type == roleId('Buyer') ? 'selected' : ''}}>Buyer</option>
                      
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="rptPwd" class="col-sm-2 control-label">Manage Access Rights</label>
                    <div class="col-sm-10">
                      <div class="panel panel-default"><!-- Buyer Permissions -->
                        <div class="panel-heading">Buyer Permissions
                          <label for="buyCheckAll" class="pull-right"><input type="checkbox" id="buyCheckAll" value="1"> Check All</label>
                        </div>
                        <div class="panel-body">
                        @foreach($permissions as $perm)
                          @if(strpos($perm->name, "buyer.") !== false && strpos($perm->name, "API.") === false)
                          <div class="col-sm-3 col-xs-3 col-md-3">
                              <label for="perm{{ $perm->id }}" class=""><input type="checkbox" class="buyer-per" {{ in_array($perm->id, array_flatten($role->perms()->get(['id'])->toArray())) ? 'checked' : ''  }}  value="{{ $perm->id }}" id="perm{{ $perm->id }}" name="chk[]"> {{ $perm->display_name }}</label>
                          </div>
                          @endif
                        @endforeach
                        </div>
                      </div><!-- Buyer Permissions -->
                    </div>
                </div>

                <div class="form-group">
                      <input type="hidden" name="uuid" value="{{isset($role->uuid) ? $role->uuid : ''}}">
                      <input type="hidden" name="id" value="{{isset($role->id) ? $role->id : ''}}">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-info">Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @stop