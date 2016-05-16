<!-- POPUP Modal -->
<div id="sellerSettingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Seller Setting</h4>
      </div>
      <div class="modal-body">
		  <div class="widget-body">
			@if(isset($data))
			  <form id="bandForm" class="form-horizontal no-margin" method = "post" action="{{route('buyer.sellerSetting.save')}}">
			  {!! csrf_field() !!}
			  <div class="form-group">
				<label for="sellerName" class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8">
				  <input type="text" name="name" value="{{isset($data->name) ? $data->name : ''}}" class="form-control" id="bandName" placeholder="Name">
				</div>
			  </div>
			  <!-- for UUID -->
			  <input type="hidden" name="id" value="{{isset($data->id) ? $data->id : ''}}">
			  <div class="form-group">
				<label for="discounting" class="col-sm-4 control-label">TDS Percentage</label>
				<div class="col-sm-8">
				  <input type="text" name="taxPercentage" value="{{isset($data->tax_percentage) ? $data->tax_percentage : ''}}" class="form-control" id="discounting" placeholder="Tax Percentage">
				</div>
			  </div>
			  <div class="form-group">
				<label for="discounting" class="col-sm-4 control-label">Manual Discounting</label>
				<div class="col-sm-8">
				  <input type="text" name="paymentTerms" value="{{isset($data->payment_terms) ? $data->payment_terms : ''}}" class="form-control" id="discounting" placeholder="Discounting">
				</div>
			  </div>
			 @endif
			  <div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
				  <button type="submit" class="btn btn-info" >Save</button>
				</div>
			  </div>
			  
			</form>
		  </div>
		</div>
              
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->