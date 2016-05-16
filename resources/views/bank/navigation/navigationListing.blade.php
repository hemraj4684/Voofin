@extends('bank.layouts.default')
@section('content')
<div class="left-sidebar">
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Tables
                    </div>
                    <span class="tools">
                      <i class="fa fa-cogs"></i>
                    </span>
                  </div>
                  <div class="widget-body">
                    <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                      <thead>
                        <tr><th style="width:5%"><input type="checkbox" class="no-margin" /></th>
                          <th style="width:20%">Name</th>
                          <th style="width:20%" class="hidden-xs">Display Name</th>
                          <th style="width:30%" class="hidden-xs">Description</th>
                          <th style="width:10%" class="hidden-xs">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($navigations as $navigation)
                        <tr>
                          <td><input type="checkbox" class="no-margin" /></td>
                          <td><span class="name">{{$navigation->name}}</span></td>
                          <td>{{$navigation->display_name}}</td>
                          <td>{{$navigation->description}}</td>
                          <td class="hidden-xs">
                            <a href="/bank/navigation/edit/{{$navigation->uuid}}">Edit</a>                 
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
                  </div>
          <!-- Left Sidebar End -->

          <!-- Right Sidebar Start -->
          <div class="right-sidebar">
            <div class="wrapper">
              <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                <thead>
                  <tr>
                    <th style="width:10%">
                      <input type="checkbox" class="no-margin" />
                    </th>
                    <th style="width:70%">
                      Name
                    </th>
                    <th style="width:20%">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Mahendra Singh Dhoni
                      </span>
                    </td>
                    <td>
                      <span class="label label-info">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Michel Clark
                      </span>
                    </td>
                    <td>
                      <span class="label label-success">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Rahul Dravid
                      </span>
                    </td>
                    <td>
                      <span class="label label-warning">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Anthony Michell
                      </span>
                    </td>
                    <td>
                      <span class="label label-info">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Srinu Baswa
                      </span>
                    </td>
                    <td>
                      <span class="label label-success">
                        New
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <hr class="hr-stylish-1">
            
            <div class="wrapper">
              <div class="btn-toolbar no-margin">
                <div class="btn-group">
                  <a href="#" class="btn btn-success">
                    <i class="fa fa-headphones">
                    </i>
                  </a>
                  <a href="#" class="btn btn-warning">
                    <i class="fa fa-thumbs-down">
                    </i>
                  </a>
                  <a href="#" class="btn btn-danger">
                    <i class="fa fa-signal">
                    </i>
                  </a>
                  <a href="#" class="btn btn-info">
                    <i class="fa fa-share">
                    </i>
                  </a>
                </div>
                <div class="btn-group">
                  <a href="#" class="btn btn-default">
                    <i class="fa fa-leaf"></i>
                  </a>
                </div>
              </div>
            </div>
            
            <hr class="hr-stylish-1">
            
            <div class="wrapper">
              <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                <thead>
                  <tr>
                    <th style="width:10%">
                      <input type="checkbox" class="no-margin" />
                    </th>
                    <th style="width:70%">
                      Name
                    </th>
                    <th style="width:20%">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="success">
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Mahendra Singh Dhoni
                      </span>
                    </td>
                    <td>
                      <span class="label label-info">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr class="error">
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Michel Clark
                      </span>
                    </td>
                    <td>
                      <span class="label label-success">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr class="success">
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Rahul Dravid
                      </span>
                    </td>
                    <td>
                      <span class="label label-warning">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr class="warning">
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Anthony Michell
                      </span>
                    </td>
                    <td>
                      <span class="label label-info">
                        New
                      </span>
                    </td>
                  </tr>
                  <tr class="info">
                    <td>
                      <input type="checkbox" class="no-margin" />
                    </td>
                    <td>
                      <span class="name">
                        Srinu Baswa
                      </span>
                    </td>
                    <td>
                      <span class="label label-success">
                        New
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          @stop