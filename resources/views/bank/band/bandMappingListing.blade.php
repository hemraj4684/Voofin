@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BAND MAPPING</a></li>
	</ul>
	<div class="pull-right" style="margin: 0 20px 0 0;">		
		<button type="submit" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#band_info">View Band Info</button>		
	</div>
@stop
@section('content')
<style>
.ui-autocomplete {
z-index: 100;
}
</style>
<!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Band Mapping List
                    </div>
                  </div>
                  <div class="widget-body">
                  <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi" action="" method="">
                      <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                          <input type="text" name="buyerSearch" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="BuyerSearch">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                          <input type="text" name="sellersearch" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="SellerSearch">
                        </div>
						
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">  
						 <select name="bandSearch" class="form-control">
							  <option value="">Change Bands</option>
							  <option value="notmapped">Not Mapped</option>
							  @if(isset($bands))
						          @foreach($bands as $band)
								  <option value="{{$band->id}}"> {{$band->name}}</option>
								  @endforeach
							  @endif
						  </select>
						</div>
						
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-1">  
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
                          <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
                        </div>
						</div>
						
						
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 pull-right" style="border-left:1px solid #ccc;"> 
						
						<i class="fa fa-info-circle fa-lg" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."></i>
						
						<span class="col-sm-11 pull-right">
						  <select name="buyer" class="form-control changebands">
							  <option selected="">Change Bands</option>
							  <option>Not Mapped</option>
							  @if(isset($bands))
						          @foreach($bands as $band)
								  <option value="{{$band->id}}"> {{$band->name}}</option>
								  @endforeach
							  @endif
						  </select>
						</span>
						</div>
						
                      </div>
					  
				 </form>	  
                

				<div class="table-responsive">
					<form class="form-horizontal ng-pristine ng-valid" role="form" id="bandSubmitForm" action="{{route('bank.band.bandmapping.display')}}" method="POST">
					 <input type="hidden" name="band_Id" id="band_Id">
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
							  <th width="2%">
                               <input type="checkbox" value="" name="allchk" id="allchk"/>
                              </th>		
                              <th style="width:10%">
                                Buyer Name
                              </th>
							  <th style="width:10%">
                                Seller Name
                              </th>							  
                              <th style="width:10%" class="hidden-phone">
                                Band
                              </th>                              
                              <th style="width:10%" class="hidden-phone" >
                                Change Band
                              </th>                              
                            </tr>
                          </thead>
                          <tbody>
                      	  @if(isset($data))
                      	  	{{ csrf_field() }}
                  
                            @foreach($data as $key=>$dataVal)
                            
                            <tr>
							  <td><input type="checkbox" name="bandmaplist[]"  class="bandmaplist" value="{{$key}}"/></td>
							  <td>{{$dataVal->buyerName}}</td>
                              <td>{{$dataVal->sellerName}}</td>
                              <td>{{$dataVal->bandName}} <i class="fa fa-info-circle fa-lg" data-html="true" title="{{ 'Discounting:'.$dataVal->discounting.',<br>
                              	                                                                       Manual Discounting:'.$dataVal->manualDiscounting.',<br>
                              	                                                                       Autodiscounting:'.$dataVal->autoDiscounting }}"></i></td>
                              <td>
                              	<input type="hidden" name="buyerId_{{$key}}" value="{{$dataVal->buyerId}}" class="buyerID">
                              	<input type="hidden" name="sellerId_{{$key}}" value="{{$dataVal->sellerId}}" class="sellerID">
                              	
                             	<div class="col-xs-8" >
                             	 	
	                            	<select name="bandId" class="form-control bandChange">
										<option selected>Change Band</option>
										@foreach($bands as $band)
										<option @if(isset($dataVal->bandId) && ($dataVal->bandId == $band->id)) selected @endif value={{$band->id}}>{{$band->name}}</option>
										@endforeach
									 </select>
								</div>
							  </td>   

                                <!--<div class="btn-group">
								  <button data-toggle="dropdown" class="btn btn-default btn-md dropdown-toggle" aria-expanded="true">
									Change Band 
									<span class="caret"></span>
								  </button>

								   <ul class="dropdown-menu pull-right">
								  	@if(isset($bands))
									  	@foreach($bands as $band)
										<li>
										  <a href="#" data-original-title="" title="">{{$band->name}}</a>
										</li>
										@endforeach
									@endif
								  </ul> 
								</div>-->
                                                        
                            </tr>
                            @endforeach
                         @else
                          <tr>
                         	<td colspan="5">No Record Found</td>
                          </tr>
                         @endif
                          </tbody>
                        </table>

                         @if(isset($data))
                        	{!! $data->render() !!}
                    	 @endif
                    	</form>
					</div>
                     <br>
					 <div class="row row-centered">
						<div class="col-xs-7 col-centered">	
							<button type="submit" class="btn btn-info pull-right" data-toggle="modal" data-target="#add_band">Add Band Mapping</button>		
						</div>
					 </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
			
<!--Add Band Modal Start-->
	  <div class="modal fade" id="add_band" role="dialog">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
			<div class="modal-header">
			  <b>Add Band Mapping</b>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  
			</div>
			<div class="modal-body">				
				<div class="widget-body"> 
				<form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" id="bandMapForm" role="form" confirm-on-exit="" novalidate="" action="{{route('bank.band.bandMapping.save')}}" method="POST">				
					{{ csrf_field() }}
					<div class="form-group">
						<label for="invoice_no" class="col-sm-4 control-label">Buyer Name</label>
						<div class="col-sm-5">
							<input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" id="buyerName" name="buyername" placeholder="Buyer Name">
							<input type="hidden" name="buyerId" id="buyerId" value="" />
						</div>	
					</div>
					<div class="form-group autocomplete_input">
						<label for="invoice_no" class="col-sm-4 control-label">Seller Name</label>
						<div class="col-sm-5 ">
							<input type='text' name="sellerName" id="sellerName" class="form-control typeahead typeahead tt-query" placeholder="Seller name" autocomplete="on" spellcheck="false"/>
							<input type="hidden" name="sellerId" id="sellerId" value="" />
						</div>	
					</div>
					
					
					<div class="form-group">
						<label for="invoice_no" class="col-sm-4 control-label">Change Band</label>
						<div class="col-sm-5">
							<select name="bandId" class="form-control">
								<option selected>Change Band</option>
								@foreach($bands as $band)
								<option value="{{$band->id}}">{{$band->name}}</option>
								@endforeach
							 </select>
						</div>	
					</div>

					<div class="form-group">
					 <div class="col-sm-6">					
					   <button type="submit" class="btn btn-primary pull-right">Send</button>
					 </div>  
					</div>
				</form>	
				</div>				 
			</div>
			
			<div class="clearfix"></div>
			
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		</div>
	  </div>
<!--Add Band Modal End-->
			
<!--Band Info Modal Start-->
	  <div class="modal fade" id="band_info" role="dialog">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
			<div class="modal-header">
			  <b>View Band Info</b>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  
			</div>
			<div class="modal-body">
			
			
			<div class="widget-body">                    

				<form class="form-horizontal no-margin ng-valid-parse ng-invalid ng-invalid-required ng-valid-min ng-valid-pattern ng-pristine" name="addPoi" role="form" confirm-on-exit="" novalidate="">
								
						<div class="form-group">
							<div class="col-sm-3">
								<span style="font-weight:bold;">Band<span/>
							</div>	
							
							<div class="col-sm-3">
								<span style="font-weight:bold;">Discounting<span/>
							</div>
							
							<div class="col-sm-3">
								<span style="font-weight:bold;">Manual Discounting<span/>
							</div>
							
							<div class="col-sm-2">
								<span style="font-weight:bold;">Auto Discounting<span/>
							</div>
							
						</div>
						
						<div class="form-group">
						  <hr style="margin:0px; border-top:2px solid #ccc;">
						</div>
						@if(isset($bands))
						@foreach($bands as $band)
						<div class="form-group">
							<div class="col-sm-3">
								{{$band->name}}
							</div>	
							
							<div class="col-sm-3">
								{{$band->discounting}}
							</div>
							
							<div class="col-sm-3">
								{{$band->manualDiscounting}}
							</div>
							
							<div class="col-sm-2">
								{{$band->autoDiscounting}}
							</div>
							
						</div>
						@endforeach
						@endif
						
					</form>
                  </div>		 
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		</div>
	  </div>
<!--Band Info Modal End-->
@stop
