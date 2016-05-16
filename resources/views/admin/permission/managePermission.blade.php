@extends('admin.layouts.default')
@section('content')
            <!-- Row Start -->
            <script type="text/javascript" src="{{asset('/public/module/adminUserModule.js')}}"></script>
           <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Create Permission 
                      <span class="mini-title">
                        Simple form for new Accoun <a id="create-account">t</a>
                      </span>
                    </div>
                  </div>
                  <div class="widget-body">
                    <form id="permissionForm" class="form-horizontal no-margin" onsubmit="return false">
                    {!! csrf_field() !!}
                      <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">Permission Code</label>
                        <div class="col-sm-6">
                          <input type="text" name="name" value="{{isset($permission->name) ? $permission->name: ''}}" class="form-control" id="userName" placeholder="Permission Code">
                          <span id="nameErr" stylesheet="color:red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="display_name" class="col-sm-2 control-label">Permission Name</label>
                        <div class="col-sm-6">
                          <input type="text" name="display_name" value="{{isset($permission->display_name) ? $permission->display_name: ''}}" class="form-control" id="display_name" placeholder="Permission Name">
                        </div>
                      </div>

                      
                      <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-6">
                          <textarea name="description" class="form-control" placeholder="Description">{{isset($permission->description) ? $permission->description: ''}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="rptPwd" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                          <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                            <input type="hidden" name="uuid" value="{{isset($permission->uuid) ? $permission->uuid : ''}}">
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