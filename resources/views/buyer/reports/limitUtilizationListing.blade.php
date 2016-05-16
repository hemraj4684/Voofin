@extends('buyer.layouts.default')
@section('sidebar')
<ul>
    <li><a href="" class="heading">BUYER LIMIT UTILIZATION</a></li>
</ul>
@stop
@section('content')

<!-- Row Start -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    Buyer Limit Utilization
                </div>
            </div>

            <div class="widget-body">

                <div class="table-responsive">
                    <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                        <tbody>
                        <tr>
                            <th> Organization Name</th>
                            <th> :</th>
                            <td>Navneet</td>
                        </tr>
                            <th>Approved Limit</th>
                            <th> :</th>
                            <td>৳ 10,000,000</td>
                        </tr>
                            <th>Current Exposure</th>
                             <th> :</th>
                             <td>৳ 200,000</td>
                        </tr>
                            <th>Pipeline Requests</th>
                            <th> :</th>
                             <td>৳ 10,000</td>
                        </tr>
                            <th>Available Limit</th>
                              <th> :</th>
                             <td>৳ 97,90,000</td>
                        </tr>
                        <tr>
                            <th>Limit Utilized Percentage</th>
                            <th> :</th>
                            <td> 50%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row End -->

@stop