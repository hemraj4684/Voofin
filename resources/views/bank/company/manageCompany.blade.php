@extends('bank.layouts.default')
@section('sidebar')
  <ul>
    <li><a href="" class="heading">CREATE COMPANY</a></li>
  </ul>
@stop
@section('content')
           <!-- Row Start -->
           
           <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="widget">
                  <div class="widget-header">
                    <div class="title">
                      Create Company 
                    </div>
                  </div>
                  <div class="widget-body">
                    <form id="companyForm" class="form-horizontal no-margin" onsubmit="return false" autocomplete="off">
                    {!! csrf_field() !!}
                    <div class="panel panel-default"><!-- Company Details Panel started -->
                      <div class="panel-heading">Company Details</div>
                      <div class="panel-body">
                      <div class="form-group">
                        <label for="compName" class="col-sm-2 control-label">
                        Organisation Name <i class="fa fa-asterisk req_asterisk"></i>
                        </label>
                        <div class="col-sm-6">
                          <input type="text" name="compName" value="{{$comp->compName or ''}}" class="form-control" id="compName" autocomplete="off">
                          <span id="compNameErr" style="color:red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="compType" class="col-sm-2 control-label">
                        Organisation Type  <i class="fa fa-asterisk req_asterisk"></i></label>
                        
                        <div class="col-sm-6">
                          <div>
                              <label>
                                  <input type="radio" id="q128" name="compType" value="Company" @if(isset($comp->organisation_type) && $comp->organisation_type === "Company") checked @endif/>&nbsp;&nbsp;Company&nbsp;&nbsp; 
                              </label> 
                              <label>
                                  <input type="radio" id="q129" name="compType"  value="Proprietor" @if(isset($comp->organisation_type) && $comp->organisation_type === "Proprietor") checked @endif/>&nbsp;&nbsp;Proprietor&nbsp;&nbsp;
                              </label> 
                              <label>
                                  <input type="radio" id="q130" name="compType" value="LLP" @if(isset($comp->organisation_type) && $comp->organisation_type === "LLP") checked @endif/>&nbsp;&nbsp;LLP&nbsp;&nbsp;
                              </label> 
                              <label>
                                  <input type="radio" id="q131" name="compType" value="Partnership" @if(isset($comp->organisation_type) && $comp->organisation_type === "Partnership") checked @endif/>&nbsp;&nbsp;Partnership&nbsp;&nbsp;
                              </label> 
                              <label>
                                  <input type="radio" id="q132" name="compType" value="Others" @if(isset($comp->organisation_type) && $comp->organisation_type === "Others") checked @endif/>&nbsp;&nbsp;Others&nbsp;&nbsp;
                              </label>
                          </div>
                          <span id="compTypeErr" style="color:red"></span>
                        </div>
                      </div>
                      <!-- for UUID -->
                      <input type="hidden" name="uuid" value="{{$comp->compuuid or ''}}">
                              
                      <div class="form-group"><!-- this part is dynamic according to company type -->
                        <label for="company_details" class="col-sm-2 control-label">
                        Identification Number  <i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="company_details" value="{{$comp->identification_no or ''}}" class="form-control" id="company_details">
                          <span id="company_detailsErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="compRegNum" class="col-sm-2 control-label">
                        Company Registration Number <i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="compRegNum" value="{{$comp->registration_no or ''}}" class="form-control" id="compRegNum">
                          <span id="compRegNumErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pan" class="col-sm-2 control-label">
                        PAN Number  <i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="panNum" value="{{$comp->pan or ''}}" class="form-control" id="panNum">
                          <span id="panErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="display_name" class="col-sm-2 control-label">
                        Type <i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <select name="comp_type" id="comp_type" class="form-control">
                            <option>Please Select</option>
                            <option value="{{roleId('Buyer')}}" @if(isset($comp->industry) && $comp->industry === roleId('Buyer')) {!! "selected" !!} @endif >Buyer</option>
                            <option value="{{roleId('Seller')}}" @if(isset($comp->industry) && $comp->industry === roleId('Seller')) {!! "selected" !!} @endif >Seller</option>
                            <option value="{{roleId('Both')}}" @if(isset($comp->industry) && $comp->industry === roleId('Both')) {!! "selected" !!} @endif >Both</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                          <select name="status" class="form-control" id="status">
                            <option>Please select</option>
                            <option value="1" @if(isset($comp->status) && $comp->comStatus === "1") {!! "selected" !!} @endif>Active</option>
                            <option value="0" @if(isset($comp->status) && $comp->comStatus === "0") {!! "selected" !!} @endif>Inactive</option>
                          </select>
                        </div>
                      </div>
                      </div><!-- Company Panel body closed -->
                    </div><!-- Company Panel closed -->

                    <div class="panel panel-default"><!-- Company Address Details Panel started -->
                      <div class="panel-heading">Company Address Details</div>
                      <div class="panel-body">
                      <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-6">
                          <textarea name="address" class="form-control">{{$comp->address or ''}}</textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="state" class="col-sm-2 control-label">State</label>
                        <div class="col-sm-6">
                          <select name="state" class="form-control">
                              <option>Please Select</option>
                              <option value='Andaman and Nicobar Islands'>Andaman and Nicobar Islands</option>
                              <option value='Andhra Pradesh'>Andhra Pradesh</option>
                              <option value='Arunachal Pradesh'>Arunachal Pradesh</option>
                              <option value='Assam'>Assam</option>
                              <option value='Bihar'>Bihar</option>
                              <option value='Chandigarh'>Chandigarh</option>
                              <option value='Chhattisgarh'>Chhattisgarh</option>
                              <option value='Dadra and Nagar Haveli'>Dadra and Nagar Haveli</option>
                              <option value='Daman and Diu'>Daman and Diu</option>
                              <option value='Dhaka'>Dhaka</option>
                              <option value='Delhi'>Delhi</option>
                              <option value='Goa'>Goa</option>
                              <option value='Gujarat'>Gujarat</option>
                              <option value='Haryana'>Haryana</option>
                              <option value='Himachal Pradesh'>Himachal Pradesh</option>
                              <option value='Jammu and Kashmir'>Jammu and Kashmir</option>
                              <option value='Jharkhand'>Jharkhand</option>
                              <option value='Karnataka'>Karnataka</option>
                              <option value='Kerala'>Kerala</option>
                              <option value='Lakshadweep'>Lakshadweep</option>
                              <option value='Madhya Pradesh'>Madhya Pradesh</option>
                              <option value='Maharashtra'>Maharashtra</option>
                              <option value='Manipur'>Manipur</option>
                              <option value='Meghalaya'>Meghalaya</option>
                              <option value='Mizoram'>Mizoram</option>
                              <option value='Nagaland'>Nagaland</option>
                              <option value='Odisha'>Odisha</option>
                              <option value='Puducherry'>Puducherry</option>
                              <option value='Punjab'>Punjab</option>
                              <option value='Rajasthan'>Rajasthan</option>
                              <option value='Sikkim'>Sikkim</option>
                              <option value='Tamil Nadu'>Tamil Nadu</option>
                              <option value='Telengana'>Telengana</option>
                              <option value='Tripura'>Tripura</option>
                              <option value='Uttar Pradesh'>Uttar Pradesh</option>
                              <option value='Uttarakhand'>Uttarakhand</option>
                              <option value='West Bengal'>West Bengal</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="city" class="col-sm-2 control-label">City</label>
                        <div class="col-sm-6">
                          <input type="text" name="city" value="{{$comp->city or ''}}" class="form-control" id="city">
                          <span id="cityErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pincode" class="col-sm-2 control-label">Pin Code</label>
                        <div class="col-sm-6">
                          <input type="text" name="pincode" value="{{$comp->pincode or ''}}" class="form-control" id="city">
                          <span id="pincodeErr" style="color:red"></span>
                        </div>
                      </div>

                      

                      </div><!-- Company Address Details body end here -->  
                      </div><!-- Company Address Details end here -->  
                      

                      <div class="panel panel-default"><!-- Contact User Details Panel started -->
                      <div class="panel-heading">Contact User Details </div>
                      <div class="panel-body">
                      <div class="form-group">
                        <label for="contactUser" class="col-sm-2 control-label">Contact User <i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="text" name="contactUser" value="{{$comp->name or ''}}" class="form-control" id="contactUser">
                          <span id="contactUserErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email <i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <input type="email" name="email" value="{{isset($comp->email) ? $comp->email : ''}}" class="form-control" id="email">
                          <span id="emailErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="rptPwd" class="col-sm-2 control-label">Role <i class="fa fa-asterisk req_asterisk"></i></label>
                        <div class="col-sm-6">
                          <select name="role" class="form-control">
                              <option>Please Select</option>
                            @foreach($roles as $id => $name)
                              <option value="{{$name->id}}" @if(isset($comp->roleId) && $comp->roleId == $id) {!! "selected" !!} @endif>{{$name->display_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                      </div><!-- Contact User Details Body Panel ended here -->
                      </div><!-- Contact User Details Panel ended here -->

                      <div class="panel panel-default"><!-- Bank Details Panel started -->
                      <div class="panel-heading">Bank Details</div>
                      <div class="panel-body">

                      <div class="form-group">
                        <label for="accNo" class="col-sm-2 control-label">Account Name</label>
                        <div class="col-sm-6">
                          <input type="text" name="accName" value="" class="form-control" id="accNo">
                          <span id="accNoErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="accNo" class="col-sm-2 control-label">Account No</label>
                        <div class="col-sm-6">
                          <input type="text" name="accNo" value="{{$comp->account_no or ''}}" class="form-control" id="accNo">
                          <span id="accNoErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="bankName" class="col-sm-2 control-label">Bank Name</label>
                        <div class="col-sm-6">
                          <input type="text" name="bankName" value="{{ $comp->bank_name or ''}}" class="form-control" id="bankName">
                          <span id="bankNameErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="bankName" class="col-sm-2 control-label">Branch</label>
                        <div class="col-sm-6">
                          <input type="text" name="branch" value="{{$comp->branch or ''}}" class="form-control" id="branch">
                          <span id="bankNameErr" style="color:red"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ifscCode" class="col-sm-2 control-label">IFSC Code</label>
                        <div class="col-sm-6">
                          <input type="text" name="ifscCode" value="{{$comp->ifsc_code or ''}}" class="form-control" id="ifscCode">
                          <span id="ifscCodeErr" style="color:red"></span>
                        </div>
                      </div> 

                      </div><!-- Bank Details Body Panel ended here -->
                      </div><!-- Banks Details Panel ended here -->

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-info" id="d">Save</button>
                          <a class="btn btn-info" href="{{route('bank.company.view')}}">Cancel</a>
                        </div>
                      </div>
                      <div class="loader">
                         <center>
                             <img class="loading-image" src="{{asset('/public/img/loading-red.gif')}}" alt="loading..">
                         </center>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @stop