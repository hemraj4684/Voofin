@extends('bank.layouts.default')
@section('sidebar')
	<ul>
		<li><a href="" class="heading">BUYER BEHAVIOUR REPORT</a></li>
	</ul>
@stop
@section('content')
            
            <!-- Row Start -->
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                        Buyer Behaviour Report
                    </div>
                  </div>

                  <div class="widget-body">
                        <form class="form-horizontal ng-pristine ng-valid" role="form" name="search_poi">
                            <div class="form-group">

                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <input type="text" name="search" class="form-control ng-pristine ng-untouched ng-valid" id="serch" ng-model="search" placeholder="Buyer Name">
                                </div>

                               <!-- <div class="col-xs-12 col-sm-6 col-md-1 col-lg-1">
                                    <label class="pull-right">Start</label>
                                </div>-->

                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <label>Start </label> <select style="width: 160px; display: inline;" class="ui-datepicker-month form-control"><option selected="selected">Select Month</option><option value="0">Jan</option><option value="1">Feb</option><option value="2">Mar</option><option value="3">Apr</option><option value="4">May</option><option value="5">Jun</option><option value="6">Jul</option><option value="7">Aug</option><option value="8">Sep</option><option value="9">Oct</option><option value="10">Nov</option><option value="11">Dec</option></select>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <select class="ui-datepicker-year form-control"><option selected="selected">Select Year</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option></select>
                                </div>

                                <!-- <div class="col-xs-12 col-sm-6 col-md-1 col-lg-1">
                                <label class="pull-right">End</label>
                                </div>-->

                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <label>End</label> <select style="width: 170px; display: inline;" class="ui-datepicker-month form-control"><option selected="selected">Select Month</option><option value="0">Jan</option><option value="1">Feb</option><option value="2">Mar</option><option value="3">Apr</option><option value="4">May</option><option value="5">Jun</option><option value="6">Jul</option><option value="7">Aug</option><option value="8">Sep</option><option value="9">Oct</option><option value="10">Nov</option><option value="11">Dec</option></select></span>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                    <select class="ui-datepicker-year form-control"><option selected="selected">Select Year</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option></select>
                                </div>

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-info mr10" ng-click="searchPoi()"><span class="fa fa-search"></span></button>
                                </div>
                            </div>
                        </form>
                      <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="table-responsive">
                              <div class="widget">
                                  <div class="widget-body">
                                      <div id="area-chart" class="chart-height"></div>
                                  </div>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
                    </div>
                </div>
            </div>
            <!-- Row End -->

          @stop