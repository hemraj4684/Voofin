@extends('bank.layouts.default')
@section('content')
            <!-- Row Start -->
           
           <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Create Role 
                      <span class="mini-title">
                        Simple form for new Accoun <a id="create-account">t</a>
                      </span>
                    </div>
                  </div>
                  <div class="widget-body">
                    <form id="roleForm" class="form-horizontal no-margin" onsubmit="return false">
                    {!! csrf_field() !!}
                       <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">Name (temp)
						<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="name" value="{{isset($role->name) ? $role->name: ''}}" class="form-control" id="userName" placeholder="Name">
                          <span id="nameErr" stylesheet="color:red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="display_name" class="col-sm-2 control-label">Role Name
						<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="display_name" value="{{isset($role->display_name) ? $role->display_name: ''}}" class="form-control" id="display_name" placeholder="Role Name">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Role Description
						<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <textarea name="description" class="form-control" placeholder="Role Description">{{isset($role->description) ? $role->description: ''}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="rptPwd" class="col-sm-2 control-label">Role Type
						<i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <select name="type" class="form-control">
                            <option value="{{roleId('Bank')}}" {{isset($role->type) && $role->type == roleId('Bank') ? 'selected' : ''}}>Bank</option>
                            <option value="{{roleId('Buyer')}}" {{isset($role->type) && $role->type == roleId('Buyer') ? 'selected' : ''}}>Buyer</option>
                            <option value="{{roleId('Seller')}}" {{isset($role->type) && $role->type == roleId('Seller') ? 'selected' : ''}}>Seller</option>
                            <option value="{{roleId('Both')}}" {{isset($role->type) && $role->type == roleId('Both') ? 'selected' : ''}}>Buyer+Seller</option>
                          </select>                        
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="rptPwd" class="col-sm-2 control-label">Manage Access Rights
						<i class="fa fa-asterisk req_asterisk"></i></label>
                          <div class="col-sm-10">
                            <div class="panel panel-default">
                              <div class="panel-heading">Bank Permissions
                                <label for="bankCheckAll" class="pull-right"><input type="checkbox" id="bankCheckAll" value="1"> Check All</label>
                              </div>

                              <div class="panel-body">
                              @foreach($permissions as $perm)
                              @if(strpos($perm->name, "bank.") !== false && strpos($perm->name, "API.") === false)
                              <div class="col-sm-3 col-xs-3 col-md-3">
                                  <label for="perm{{ $perm->id }}" class=""><input type="checkbox" class="bank-per" {{ in_array($perm->id, array_flatten($role->perms()->get(['id'])->toArray())) ? 'checked' : ''  }}  value="{{ $perm->id }}" id="perm{{ $perm->id }}" name="chk[]"> {{ $perm->display_name }}</label>
                              </div>
                              @endif
                              @endforeach
                              </div>
                            </div><!-- Bank permissions -->

                            <div class="panel panel-default">
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

                            <div class="panel panel-default">
                              <div class="panel-heading">Seller Permissions 
                                <label for="sellCheckAll" class="pull-right"><input type="checkbox" id="sellCheckAll" value="1"> Check All</label>
                              </div>
                              <div class="panel-body">
                              @foreach($permissions as $perm)
                              @if(strpos($perm->name, "seller.") !== false && strpos($perm->name, "API.") === false)
                              <div class="col-sm-3 col-xs-3 col-md-3">
                                  <label for="perm{{ $perm->id }}" class=""><input type="checkbox" class="seller-per" {{ in_array($perm->id, array_flatten($role->perms()->get(['id'])->toArray())) ? 'checked' : ''  }}  value="{{ $perm->id }}" id="perm{{ $perm->id }}" name="chk[]"> {{ $perm->display_name }}</label>
                              </div>
                              @endif
                              @endforeach
                              </div>
                            </div><!-- Supplier Permissions -->

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