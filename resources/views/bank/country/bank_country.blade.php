@extends('bank.layouts.default')

@section('sidebar')
	<ul>
		<li><a href="" class="heading">COUNTRY LIST</a></li>
	</ul>
	<div class="pull-right" style="margin: 0 20px 0 0;">
		<button type="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_country">Add Country</button>
	</div>
	<!-- Add Country Modal Start-->
	<div class="modal fade" id="add_country" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Add Country</h4>
		  </div>
		  <form action="#">
		  <div class="modal-body">
			<input type="text" class="form-control " name="po_no" placeholder="Country Name">
		  </div>
		  <div class="modal-footer">        
			<button type="submit" class="btn btn-primary">Save</button>
		  </div
		  </form>
		</div>
	  </div>
	</div>
<!-- Add Country Modal End-->

@stop

@section('content')
  <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Country List
                    </div>
                  </div>
                  <div class="widget-body">
                   

                    <div class="table-responsive">
                      <table  id="example" class="display table table-condensed table-striped table-bordered table-hover no-margin">
						<thead>
                          <tr>
							<th width="10%">No.</th>
                            <th>Country Name</th>   
                            <th width="30%">Action</th>														
                          </tr>						  
						</thead>
						
						
                        <tbody>
						
                          <tr>
						    <td>
                              1
                            </td>
							<td>
                              <a href="{{URL::route('bank.state.view')}}" class="link_A_blue">India</a>
                            </td>							
							<td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						    <td>
                              2
                            </td>
							<td>
                              Afghanistan	
                            </td>							
							<td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						    <td>
                              3
                            </td>
							<td>
                              Albanie	
                            </td>							
							<td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						    <td>
                              4
                            </td>
							<td>
                              Algérie
                            </td>							
							<td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						    <td>
                              5
                            </td>
							<td>
                              France	
                            </td>							
							<td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						    <td>
                              6
                            </td>
							<td>
                              Grèce	
                            </td>							
							<td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						    <td>
                              7
                            </td>
							<td>
                              Hong-Kong	
                            </td>							
							               <td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						                <td>
                              8
                            </td>
							               <td>
                              Kenya
                            </td>							
							               <td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                          <tr>
						                <td>
                              9
                            </td>
							               <td>
                              Qatar
                            </td>							
							               <td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
                          <tr>
						                <td>
                              10
                            </td>
							               <td>
                              Zimbabwe
                            </td>							
							               <td class="hidden-phone">
                              <a href="#" class="btn btn-warning btn-xs" title="" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                              </a> 
                              <a href="#" class="btn btn-danger btn-xs" title="" data-original-title="Delete">
                                <i class="fa fa fa-trash-o"></i>
                              </a>							  
                            </td>							 							
                          </tr>
						  
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
<style>	
	  .dataTables_filter{ display:block  !important;}
</style>
@stop

    
		
	
  