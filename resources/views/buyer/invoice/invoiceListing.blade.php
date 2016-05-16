@extends('buyer.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BUYER INVOICE LIST </a></li>
	</ul>
	<!--<div class="pull-right" style="margin: 0 20px 0 0;">
		<a href="{{URL::route('buyer.po.add')}}"><button type="submit" class="btn btn-info">Create PO</button></a>
	  </div>
	  <div class="pull-right" style="margin: 0 20px 0 0;">
		<a href="#"><button type="submit" class="btn btn-info">Upload Invoice</button></a>
	  </div> -->
@stop
@section('content')
<!-- Row Start -->
<div class="row">
<div class="collapse in" id="collapsible"> 
  <div class="col-lg-4 col-md-6">
    <div class="widget">
      <div class="widget-header">
        <div class="title">
          Payments
        </div>
      </div>
      <div class="widget-body">
        <div id="payment-chart" class="chart-height"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="widget">
      <div class="widget-header">
        <div class="title">
          Status
        </div>
      </div>
      <div class="widget-body">
        <div id="pie-chart" class="chart-height"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
      <div class="widget">
        <div class="widget-header">
          <div class="title">
            Details
          </div>
        </div>
        <div class="widget-body">
          <p style="font-size:22px; color:#999; font-weight:100; font-family: Calibri;">TOTAL OUTSTANDING PAYMENTS <i class="fa fa-question-circle" title="Sum of your outstanding payments across all currencies, converted to your default currency of BDT"></i></a></p>
          <p style="font-size:32px; color:#666; font-weight:100; font-family: Calibri;"> ৳ {{ number_format($outstandingAmount) }}</p> <hr style=" margin:33px 0px; border-bottom:1px solid #cfcfcf; border-top:none;">
          <p style="font-size:22px; color:#999; font-weight:100; font-family: Calibri;">AVERAGE DAYS TO PAYMENT</p>
          <p style="font-size:32px; color:#666; font-weight:100; font-family: Calibri;"> 24-63</p>
        </div>
      </div>
    </div>
    </div>
    <div class="clearfix"></div>
    <div class="btn-group btn-toggle show_hide_btn col-lg-12 col-md-6">       
      <button class="btn btn-primary active" data-toggle="collapse" data-target="#collapsible">Show Charts</button>
      <button class="btn btn-default" data-toggle="collapse" data-target="#collapsible">Hide Charts</button>
    </div>
</div>
<!-- Row End -->

<!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
               @if(count($errors) > 0)
                <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
                @endif
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Invoice List
                    </div>
                  </div>
                  <div class="widget-body">

                    <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                      <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                          <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Search" value="{{$querystringArray['search']}}">
                        </div>
						
      						     <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
      						      <select name="invoiceStatus[]" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required lstFruits" multiple="multiple">
        							    <option value="Submitted" @if(Input::get('invoiceStatus')!=null) @if(in_array("Submitted",Input::get('invoiceStatus'))) selected @endif @endif>Submitted</option>
        								  <option value="Pending Approval" @if(Input::get('invoiceStatus')!=null) @if(in_array("Pending Approval",Input::get('invoiceStatus'))) selected @endif @endif>Pending Approval</option>
        								  <option value="Approved" @if(Input::get('invoiceStatus')!=null) @if(in_array("Approved",Input::get('invoiceStatus'))) selected @endif @endif>Approved</option>
                          <option value="Rejected" @if(Input::get('invoiceStatus')!=null) @if(in_array("Rejected",Input::get('invoiceStatus'))) selected @endif @endif>Rejected</option>
                          <option value="Partially Paid" @if(Input::get('invoiceStatus')!=null) @if(in_array("Partially Paid",Input::get('invoiceStatus'))) selected @endif @endif>Partially Paid</option>
        								  <option value="Paid" @if(Input::get('invoiceStatus')!=null) @if(in_array("Paid",Input::get('invoiceStatus'))) selected @endif @endif>Paid</option>
        						    </select>						  
                       </div>
      						
        						   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 demo">	<input type="text" name="invoiceDate" id="config-demo" class="form-control date_filter" value="{{$querystringArray['invoiceDate']}}">
        							   <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
        						   </div>
						
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button> 
                        <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='/buyer/invoice';" style="margin:0 0 0 10px;"><span class="fa fa-refresh"></span></button>
					              <button type="button" class="btn btn-sm btn-info" ng-click="reset()" style="margin:0 0 0 10px;"><i class="fa fa-file-excel-o"></i></button>
                      </div>
                    </div>
                  </form>
                  @if(session()->has('message'))
                    <div class="alert alert-success" role="alert">
                        {{session()->get('message')}}
                    </div>
                  @endif
                    <div class="table-responsive">
                      <table class="display table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                          <tr>
                            <th>Seller</th>
                            <th>PO Number</th>
                            <th>Invoice Number</th>
                            <th>Amount </th>              
                            <th>Invoice Date</th>             
                            <th>Due Date</th>                         
                            <th>Invoice Status </th>
                            <th>Payment Date </th>  
                          </tr>
            
                        </thead>
                        <tbody>
                          @forelse($invoiceData as $invoice)
                            <tr>
                              <td>
                               {{$invoice->sellerName}} 
                              </td>
                              <td>
                               <a href="javascript:void(0);" data-id="{{$invoice->poUuid}}" class="link_A_blue poView">{{$invoice->purchase_order_number}} <!-- <i class="fa fa-envelope faa-shake animated"></i> --></a>
                              </td>
                              <td>
                                <a href="javascript:void(0);" id="{{$invoice->uuid}}" class="link_A_blue invoice-modal">{{$invoice->invoice_number}}</a>
                              </td>
                              <td style="text-align:right;">
                                <?php $cur=$invoice->currency;?>
                                @if(!empty($invoice->currency))
                                  {!!$currencyData[$cur]['symbol_native']!!} 
                                @endif
                                {{number_format($invoice->final_amount,2)}}
                              </td>
                
                              <td>
                               {{ date('d M Y', strtotime($invoice->created_at)) }}
                              </td>
                
                              <td>
                               {{ date('d M Y', strtotime($invoice->due_date)) }}       
                              </td>  
                  
                              <td style="text-align:left;">
                                 <i class="{{$statusData['symbols'][$statusData['status'][$invoice->status]]}} wight_ntf"></i>
                                 {{$statusData['status'][$invoice->status]}}                                
                              </td>
                              <td>
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
                     {!! $invoiceData->appends($querystringArray)->render() !!}

                  </div>
                </div>
              </div>
            </div>
            <!-- Row End -->
			
<!--PO Modal Start-->
	  <div id="poModalContainer"></div>
<!--PO Modal End-->
	  
<!--Invoice Modal Start-->
	  <div id="allModals"></div>
<!-- Invoice Modal End-->
<?php 
     $pieArray = array();
    ?>
    @foreach($pieChartData as $key=>$value)
       <?php 
         $pieArray[$key]['label'] = "<b>".$value->status_count."</b> ".$statusData['status'][$value->status];
         $pieArray[$key]['data'] = round($value->percentage_of_status,2);
         $pieArray[$key]['amount'] = number_format($value->invoice_amount,2);
       ?>
    @endforeach
    <!-- Delete Invoice Modal end -->
    <script type="text/javascript">
     $(document).ready(function(){
        var $border_color = "#efefef";
        var $grid_color = "#ddd";
        var $default_black = "#666";
        var $green = "#8ecf67";
        var $yellow = "#fac567";
        var $orange = "#F08C56";
        var $blue = "#1e91cf";
        var $red = "#f74e4d";
        var $teal = "#28D8CA";
        var $grey = "#999999";
        var $dark_blue = "#0D4F8B";
        
      $(function () {
         //alert(Math.random());
        var data, chartOptions;
        data = <?php echo json_encode($pieArray);?>;
        /*data = [
          { label: "<b>05</b> Created", data: Math.floor (Math.random() * 100 + 150) }, 
          { label: "<b>12</b> Submitted", data: Math.floor (Math.random() * 100 + 390) }, 
          { label: "<b>0</b> Internal Reject", data: Math.floor (Math.random() * 100 + 530) }, 
          { label: "<b>05</b> Approved", data: Math.floor (Math.random() * 100 + 90) },
          { label: "<b>16</b> Rejected", data: Math.floor (Math.random() * 100 + 320) },
          { label: "<b>20</b> Partially Paid", data: Math.floor (Math.random() * 100 + 90) },
          { label: "<b>40</b> Paid", data: Math.floor (Math.random() * 100 + 320) },
        ];*/
     
        chartOptions = {        
          series: {
            pie: {
              show: true,  
              innerRadius: .5, 
              stroke: {
                width: 1,
              }
            }
          }, 
          shadowSize: 0,
          legend: {
            position: 'se'
          },
          
          tooltip: true,

          tooltipOpts: {
            //content: '%s: %y '
            content: '%s: %y%', // show value to 0 decimals
            
          },
          
          grid:{
            hoverable: true,
            clickable: false,
            borderWidth: 1,
            tickColor: $border_color,
            borderColor: $grid_color,
          },
          shadowSize: 0,
          colors: [$yellow, $yellow, $red, $green, $red, $green],
        };


        var holder = $('#pie-chart');

        if (holder.length) {
          $.plot(holder, data, chartOptions );
        }   
          
      });
     });

    $(function () {

          var data, chartOptions;
          
          data = [
            { label: "৳ <?php echo number_format($receivedAmount);?><br> Received", data: <?php echo $receivedAmount;?> },      
            { label: "৳ <?php echo number_format($outstandingAmount);?><br> Outstanding", data: <?php echo $outstandingAmount;?> }, 
            /*{ label: "Pinaples", data: Math.floor (Math.random() * 100 + 530) }, 
            { label: "Grapes", data: Math.floor (Math.random() * 100 + 90) },
            { label: "Bananas", data: Math.floor (Math.random() * 100 + 320) }*/
          ];

          chartOptions = {        
            series: {
              pie: {
                show: true,  
                innerRadius: .5, 
                stroke: {
                  width: 1,
                }
              }
            }, 
            shadowSize: 0,
            legend: {
              position: 'se'
            },
            
            tooltip: true,

            tooltipOpts: {
              //content: '%s: %y'
              content: "%s", // show value to 0 decimals
              shifts: {
                  x: 20,
                  y: 0
              },
              
            },
            
            grid:{
              hoverable: true,
              clickable: false,
              borderWidth: 1,
            tickColor: $border_color,
              borderColor: $grid_color,
            },
            shadowSize: 0,
            colors: [$green, $grey, $yellow, $teal, $yellow, $green],
          };


          var holder = $('#payment-chart');

          if (holder.length) {
            $.plot(holder, data, chartOptions );
          }   
            
        });
    </script>
@stop
