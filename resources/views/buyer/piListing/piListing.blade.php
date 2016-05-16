@extends('buyer.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading">PAYMENT INSTRUCTION </a></li>
  </ul>
  <div class="pull-right" style="margin: 0 20px 0 0;">
    <a href="../uploads/sample_csv/pi-format.csv" class="btn btn-primary btn-sm" download>Download PI</a>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#upload_pi">Upload PI</button>
  </div>
  
@stop
@section('content')
<!-- Row Start -->

       @if(count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div>
        @endif

        @if (Session::has('uplaodMessage'))
           <div class="alert alert-info">{{ Session::get('uplaodMessage') }} 
            @if(Session::has('filename'))
              <a href="../uploads/invalid_pi/{{ Session::get('filename') }}" download>Click Here</a> To Download Errors File
            @endif
           </div>
        @endif

        @if (Session::has('piStatusMessage'))
           <div class="alert alert-info">
            {{ Session::get('piStatusMessage') }} 
           </div>
        @endif
        @if(session()->has('message'))
          <div class="alert alert-success" role="alert">
              {{session()->get('message')}}
          </div>
        @endif

       @if(isset($success)&& $success)
          <div class="alert alert-success">
            <strong><i class="fa fa-check"></i>Invoice approved suuccessfully.</strong>
          </div>
       @endif
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Payment Instruction List
                    </div>

                  </div>
                  <div class="widget-body">                    
                    <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                      <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                          <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search" value="{{$querystringArray['search'] or ''}}">
                        </div>
            
                       <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                        <select name="piStatus[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required lstFruits" multiple="multiple">
                          <option value="Created" @if(Input::get('piStatus')!=null) @if(in_array("Created",Input::get('piStatus'))) selected @endif @endif>Created</option>
                          <option value="Approved" @if(Input::get('piStatus')!=null) @if(in_array("Approved",Input::get('piStatus'))) selected @endif @endif>Approved</option>
                          <option value="Rejected" @if(Input::get('piStatus')!=null) @if(in_array("Rejected",Input::get('piStatus'))) selected @endif @endif>Rejected</option>
                          <option value="Paid" @if(Input::get('piStatus')!=null) @if(in_array("Paid",Input::get('piStatus'))) selected @endif @endif>Paid</option>
                        </select>             
                       </div>
                  
                       <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">  <input type="text" name="piDate" id="config-demo" class="form-control date_filter" value="{{$querystringArray['invoiceDate'] or ''}}">
                         <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                       </div>
            
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
                        <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='/buyer/piListing';" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
                        <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><i class="fa fa-file-excel-o"></i></button>
                      </div>
                    </div>
                  </form>
                    <div class="table-responsive">
                      <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                          <tr>
                              <th>
                                <input type="checkbox">
                              </th>
                              <th>
                                PI Number
                              </th>
                              <th>
                                Invoice Number
                              </th>
                              <th>
                                Buyer
                              </th>
                              <th>
                                Due Date
                              </th>                            
                              <th>
                                Invoice Amount
                              </th>             
                              <th>
                                PI Amount
                              </th>
                              <th>
                                Status
                              </th>
                          </tr>
                        </thead>
                        <tbody>
                        @forelse($piData as $pi)
                           @if(!empty($pi->invoice_currency))
                            <?php 
                             $code=$pi->invoice_currency;
                             $symbol=$currencyData[$code]['symbol_native'];
                            ?>
                          @else
                            <?php $symbol=""; ?>
                          @endif
                            <tr>
                              <td>
                                <input type="checkbox">
                              </td>
                              <td>
                                 <a href="javascript:void(0);" id="{{$pi->pi_uuid}}" class="link_A_blue pi-modal">{{$pi->pi_number}}</a>
                              </td>
                              <td>
                              @if($pi->invoice_number)
                                <a href="javascript:void(0);" id="{{$pi->invoice_uuid}}" class="link_A_blue invoice-modal">{{$pi->invoice_number }}</a>
                              @else
                                ----
                              @endif
                              </td>
                              <td>
                               {{$pi->buyer_name}}
                              </td>
                              <td>
                                {{date('d M Y',strtotime($pi->due_date))}}
                              </td>
                              <td style="text-align:right;">
                                {{ $symbol }}
                                 {{number_format($pi->invoice_final_amount,2)}}
                              </td>
                              <td style="text-align:right;">
                                  {{ $symbol }}
                                  {{number_format($pi->pi_net_amount,2)}}
                              </td>
                               <td style="text-align:left;">
                                 <i class="{{$statusData['symbols'][$statusData['status'][$pi->pi_status]] or ''}} wight_ntf"></i>
                                 {{ $statusData['status'][$pi->pi_status] or ''}}
                                                               
                              </td>
                            </tr>         
                        @empty
                            <tr>
                              <td colspan="9" style="text-align:center"><strong>No More Records</strong></td>
                            </tr>
                        @endforelse
                        </tbody>
                      </table>
                    </div>
                    {!! $piData->appends($querystringArray)->render() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
      
<!-- Upload PI Modal Start -->
  <div id="upload_pi" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Upload PI </h4>
      </div>
      <form action="{{route('buyer.piListing.uploadPi')}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="modal-body">
          <div class="input-group">
          <input type="text" class="form-control" readonly>
            <span class="input-group-btn">
              <span class="btn btn-primary btn-file">
                <i class="fa fa-folder-open"></i> Browse <input type="file" name="pi_file">
              </span>
            </span>               
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Upload</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

    </div>
  </div>
<!-- Upload PI Modal End -->

<!--Payment Instruction Modal Start-->
  <div id="piModal"></div>
<!-- Payment Instruction Modal End-->

<!--Invoice Modal Start-->
  <div id="allModals"></div>
<!-- Invoice Modal End-->
@stop
