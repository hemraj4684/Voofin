@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">FUNDING LIMITS</a></li>
	</ul>
	
@stop
@section('content')
<?php $AL = 0; $CE = 0; $PR = 0;?>
<!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Funding Limits List
                    </div>
                  </div>
                  <div class="widget-body">
                 <div class="table-responsive">
				  <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                          <thead>
						  
                            <tr>                              
                              <th style="width:10%">
                                Type
                              </th>
							  <th style="width:10%">
                                Organization Name
                              </th>							  
                              <th style="width:10%" class="hidden-phone">
                                Approved Limit
                              </th>                              
                              <th style="width:10%" class="hidden-phone">
                                Current Exposure
                              </th> 
							  <th style="width:10%" class="hidden-phone">
                                Pipeline Requests
                              </th>   
							 <th style="width:10%" class="hidden-phone">
								Available Limit
                              </th> 							  
                              <th style="width:10%" class="hidden-phone">
                                Action
                              </th> 							  
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
							                <td>
                                Selfs
                              </td>
                              <td>
                                ICICI
                              </td>
                              <td style="text-align:right;">							     
                                <input type="text" value="$ 500,000,000" id="inputText" class="input_hide_border" readonly>
                              </td>
                              <td style="text-align:right;">
                                <i class="fa fa-usd"></i> 100,000,000
                              </td>
							                 <td style="text-align:right;">
                                <i class="fa fa-usd"></i> 200,000
                              </td>
							                 <td style="text-align:right;">
                               <i class="fa fa-usd"></i> 39,980,000</td>
                                <td>							  
                              <a class="btn btn-warning btn-xs" id="hide_btn" title="Edit" href="javascript:toggle();"><i class="fa fa-pencil"></i></a>
								              <a class="btn btn-success btn-xs"  id="show_btn" style="display:none;" title="Save" href="javascript:toggleupdate();"><i class="fa fa-floppy-o"></i></a>							
                              </td>                              
                            </tr>							
                          </tbody>
                        </table>				  
				 </div>
				    <br>
				  
					<form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                      <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                          <input type="text" name="rolesearch" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search">
                        </div>
						
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">	<input type="text" id="config-demo" class="form-control date_filter">
							<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
						</div>
						
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
                          <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
						  <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><i class="fa fa-file-excel-o"></i></button>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
					<table class="table table-responsive table-striped table-bordered table-hover no-margin">
                          <thead>
						  <!-- <tr>                              
                              <th style="width:10%">
                                <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Buyer">
                              </th>
							  <th style="width:10%">
                                <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Seller">
                              </th>							  
                              <th style="width:10%" class="hidden-phone">
                                <select name="buyer" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required">
									  <option selected="">Not Mapped</option>
									  <option> Band A</option>
									  <option> Band B	</option>
									  <option> Band C</option>
								  </select>
                              </th>                              
                              <th style="width:10%" class="hidden-phone">
                                
                              </th>                              
                            </tr> -->
							
                            <tr>                              
                              <th>
                                Type
                              </th>
                              <th>
                                Organization Name
                              </th>
                                <th>
                                Approved Limit
                              </th>
                                <th>
                                Current Exposure
                              </th>
                                <th>
                                Pipeline Requests
                              </th>
                                <th>
								                Available Limit
                              </th>
                                <th>
                                Action
                              </th> 							  
                            </tr>
                          </thead>
                          <tbody>
                          
                            @if(isset($fundinglimits))
                            @foreach($fundinglimits as $key=>$val)
                             @if(roleId('Both') == $val->type)
                              <tr>
                                <td>{{roleType($val->type)}}</td>
                                <td>{{$val->name}} (Buyer)</td>
                                <td style="text-align:right;">  
                                  <form name="fundinglimit" method="POST" id="form{{$key}}" class="form-horizontal ng-pristine ng-valid frmfundinglimits" action="{{route('bank.fundingLimits.save')}}">  
                                    {{ csrf_field() }}               
                                    <?php $AL = $val->buyer_limit;?>
                             <input type="text" style="text-align:right;" name="buyer_approved_limit" id="inputtext" value="&#2547;{{ number_format($val->buyer_limit,2)}}" class="input_hide_border approved_limit" placeholder="Buyer Approved Limit" readonly>
                                    <input type="hidden" name="companyId" value="{{$val->compID}}"></input>
                                    <input type="hidden" name="roleType" value="{{$val->type}}"></input>
                                 </td>
                                 <td style="text-align:center;">
                                  <?php $CE = $val->Total;?>
                                 <input type="text" name="current_exposure" style="text-align:right;" value="&#2547;{{number_format($val->Total,2)}}" class="input_hide_border" readonly></input>
                                 </td>
                                 
                
                                 <td style="text-align:center;">  
                                      @foreach($req_pipeline as $req=>$value)
                                       @if($value->compID == $val->compID)
                                       <?php $PR = $value->total;?>
                                       <input type="text" name="pipeline_request" style="text-align:right;" class="input_hide_border" value="&#2547;{{number_format($value->total,2)}}" readonly>
                                       @endif
                                      @endforeach
                                 </td>
                                 <td style="text-align:center;">
                                 <?php $total = $AL-$CE-$PR ?>
                                   <input type="text" name="available_limit" class="input_hide_border" style="text-align:right;" value="&#2547;{{number_format($total,2)}}" readonly> </input>
                                 </td>
                                 <td>                
                                    <a  class="btn btn-warning btn-xs edit" id="hide_btn" title="Edit" href="javascript:toggle();"><i class="fa fa-pencil"></i></a>
                                    <a data-id="form{{$key}}" class="btn btn-success btn-xs save"  id="show_btn" style="display:none;" title="Save" href="javascript:toggleupdate();"><i class="fa fa-floppy-o"></i></a>          
                                  </td>                              
                              </tr>
                              </form>
                              <tr>
                                <td>{{roleType($val->type)}}</td>
                                <td>{{$val->name}} (Seller)</td>
                                <td style="text-align:right;">  
                                  <form name="fundinglimit" method="POST" id="form{{$key}}" class="form-horizontal ng-pristine ng-valid frmfundinglimits" action="{{route('bank.fundingLimits.save')}}">  
                                    {{ csrf_field() }} 
                                    <?php $AL = $val->seller_limit;?> 
                                    <input type="text" style="text-align:right;" name="seller_approved_limit" id="inputtext" value="&#2547;{{number_format($val->seller_limit)}}" class="input_hide_border approved_limit" placeholder="Buyer Approved Limit" readonly>
                                    <input type="hidden" name="companyId" value="{{$val->compID}}"></input>
                                    <input type="hidden" name="roleType" value="{{$val->type}}"></input>
                                 </td>
                                 <td style="text-align:center;"> 
                                 <?php $CE= $val->Total;?>       
                                   <input type="text" name="current_exposure" style="text-align:right;" value="&#2547;{{number_format($val->Total)}}" class="input_hide_border" placeholder="current_exposure" readonly></input> 
                                 </td>
                                 <td style="text-align:center;"> 
                                   @foreach($req_pipeline as $req=>$value)
                                   @if($value->compID == $val->compID)
                                   <?php $PR= $value->total;?>
                                 <input type="text" name="pipeline_request" style="text-align:right;" class="input_hide_border"  @if($value->compID == $val->compID) value="&#2547;{{number_format($value->total)}}" @endif readonly>
                                   @endif
                                   @endforeach 
                                   </td>
                                 <td style="text-align:center;">
                                 <?php $total = $AL-$CE-$PR ?>
                                    <input type="text" name="available_limit" style="text-align:right;" class="input_hide_border" value="&#2547;{{number_format($total,2)}}" readonly></input>
                                 </td>
                                 <td>                
                                    <a  class="btn btn-warning btn-xs edit" id="hide_btn" title="Edit" href="javascript:toggle();"><i class="fa fa-pencil"></i></a>
                                    <a data-id="form{{$key}}" class="btn btn-success btn-xs save"  id="show_btn" style="display:none;" title="Save" href="javascript:toggleupdate();"><i class="fa fa-floppy-o"></i></a>          
                                  </td>                              
                              </tr> 
                              </form>
                               
                                   
                              @else
							             <tr>
							                <td>
                             {{roleType($val->type)}}
                              </td>
                              <td>
                                {{$val->name}}
                              </td>
                              <td style="text-align:right;">	
                              <form name="fundinglimit" method="POST" id="form{{$key}}" class="form-horizontal ng-pristine ng-valid frmfundinglimits" action="{{route('bank.fundingLimits.save')}}">	
                                {{ csrf_field() }} 					     
                                <?php $AL = $val->buyer_limit;?>
                                <input type="text" style="text-align:right;" id="inputtext" @if(roleId('Buyer') == $val->type) value=" &#2547;{{$val->buyer_limit}}" name="buyer_approved_limit" @elseif (roleId('Seller') == $val->type)  value= &#2547;{{number_format($val->seller_limit,2)}} name="seller_approved_limit"  @endif class="input_hide_border approved_limit" readonly>
                                <input type="hidden" name="companyId" value="{{$val->compID}}"></input>
                                <input type="hidden" name="roleType" value="{{$val->type}}"></input>
                              </td>
                              <td style="text-align:center;">
                                <?php $CE= $val->Total;?>
                              <input type="text" name="current_exposure" style="text-align:right;" value="&#2547;{{number_format($val->Total,2)}}" class="input_hide_border" readonly></input>
                               <!-- @if($val->compID == $val->seller_id)  
                               <input type="text" name="current_exposure" value=""></input>
                               @elseif($val->compID == $val->buyer_id) 
                               <input type="text" name="current_exposure" value=""></input>
                               @endif -->
                             
                              </td>
							                <td style="text-align:center;"> 
                                @foreach($req_pipeline as $req=>$value)
                                @if($value->compID == $val->compID)
                                <?php $PR= $value->total;?>
                                <input type="text" name="pipeline_request" style="text-align:right;" class="input_hide_border" @if($value->compID == $val->compID) value="&#2547;{{number_format($value->total,2)}}" @endif readonly>
                                @endif
                                @endforeach
                              </td>
							                <td style="text-align:center;">
                                 <?php $total = $AL-$CE-$PR; ?>                             
                                <input type="text" class="input_hide_border" name="available_limit" style="text-align:right;" value="&#2547;{{number_format($total,2)}}" readonly></input>
                              </td>
                              <td>							  
                                <a  class="btn btn-warning btn-xs edit" id="hide_btn" title="Edit" href="javascript:toggle();"><i class="fa fa-pencil"></i></a>
                              <a data-id="form{{$key}}" class="btn btn-success btn-xs save"  id="show_btn" style="display:none;" title="Save" href="javascript:toggleupdate();"><i class="fa fa-floppy-o"></i></a>					
                              </td>                              
                              </tr>
                    
							               </form>
						                  @endif
                              @endforeach
                              @endif
                          </tbody>

                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
@stop
