 @extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">REVENUE SHARING</a></li>
	</ul>	
@stop
@section('content')
<!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Revenue Sharing
                    </div>
                  </div>
                  <div class="widget-body">
                  <div class="table-responsive">
				    <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                          <thead>					  
                            <tr>                              
							  <th style="width:10%">
                                Organization Name
                              </th>							  
                              <th style="width:10%">
                                Applicable
                              </th>                              
                              <th style="width:10%">
                                Revenue Share
                              </th>
							  <th style="width:10%">
                                Action
                              </th>							  
                            </tr>
                          </thead>
                          <tbody>
                            <tr>							  
                              <td>
                                <b>Geometric</b>
                              </td>
                              <td>							     
                                <input type="checkbox" disabled> 
                              </td>
                              <td>
                                <input type="text" value="0.1" id="inputText" class="input_hide_border" readonly>
                              </td>	
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
                          <input type="text" name="buyersearch" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="buyerSearch">
                        </div>
						
						<!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">	<input type="text" id="config-demo" class="form-control date_filter">
							<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
						</div> -->
						
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
                          <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
						              <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><i class="fa fa-file-excel-o"></i></button>
                        </div>
                      </div>
                    </form>
                    @if (Session::has('revenueMessage'))
                         <div class="alert alert-danger">{{ Session::get('revenueMessage') }} 
                          
                         </div>
                      @endif
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
							                <th style="width:10%">
                                Organization Name
                              </th>							  
                              <th style="width:10%">
                                Applicable
                              </th>                              
                              <th style="width:10%">
                                Revenue Share
                              </th>
							                <th style="width:10%">
                                Action
                              </th>							  
                            </tr>
                          </thead>
                          <tbody>
                            @if(isset($getrevenue))
                            @foreach($getrevenue as $key=>$value)
							              <tr>
                              <td>
                                  <form name="revenueshare" method="POST" action="{{route('bank.revenueSharing.save')}}" id="form{{$key}}" class="form-horizontal ng-pristine ng-valid  frmrevenueshare">
                                 {{ csrf_field() }} 
                               <input type="text" name="company_name" class="input_hide_border" value="{{$value->name}}"></input>
                               
                             </td>
                              <td>

                                <input class="revenueshare" type="checkbox" name="revenueshare" value="1" @if(isset($value->applicable) && $value->applicable === 1) checked @endif> 
                              </td>
                              <td>

                               
                                <input type="text" name="sharepercent" value="{{$value->share_percent}}" id="inputText" class="input_hide_border" readonly> 
                                <input type="hidden" name="companyId" value="{{$value->comId}}"></input>
                                <input type="hidden" name="companyName" class="input_hide_border" value="{{$value->name}}"></input>
                           
                              </td>	
							                <td>                
                                <a class="btn btn-warning btn-xs hide_btn" id="hide_btn" title="Edit" href="javascript:void(0)"><i class="fa fa-pencil"></i></a>
                                <a data-id="form{{$key}}" class="btn btn-success btn-xs show_btn"  href="javascript:void(0)" id="show_btn" style="display:none;" title="Save"><i class="fa fa-floppy-o"></i></a>
                               
                              </td> 
                             
                            </tr>
                               </form>
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
