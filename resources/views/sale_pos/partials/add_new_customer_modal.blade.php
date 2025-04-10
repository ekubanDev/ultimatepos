<div class="modal fade add_new_customer_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
	  	<div class="modal-content">
		    {!! Form::open(['url' => action('ContactController@store'), 'method' => 'post', 'id' => 'add_new_customer_form' ]) !!}
		    {!! Form::hidden('type','customer'); !!}
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <h4 class="modal-title">@lang('contact.add_new_customer')</h4>
		    </div>

		    <div class="modal-body">
		      <div class="row">
		      <div class="col-md-12">
		        <div class="form-group">
		            {!! Form::label('name', __('contact.name') . ':*') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-user"></i>
		                </span>
		                {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('contact.name'), 'required']); !!}
		            </div>
		        </div>
		      </div>
		      <div class="clearfix"></div>
		      <div class="col-md-4">
		        <div class="form-group">
		            {!! Form::label('mobile', __('contact.mobile') . ':*') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-mobile"></i>
		                </span>
		                {!! Form::text('mobile', null, ['class' => 'form-control', 'required']); !!}
		            </div>
		        </div>
		      </div>
		      <div class="col-md-4">
		        <div class="form-group">
		            {!! Form::label('landline', __('contact.landline') . ':') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-phone"></i>
		                </span>
		                {!! Form::text('landline', null, ['class' => 'form-control']); !!}
		            </div>
		        </div>
		      </div>
		      <div class="col-md-4">
		        <div class="form-group">
		            {!! Form::label('alternate_number', __('contact.alternate_contact_number') . ':') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-phone"></i>
		                </span>
		                {!! Form::text('alternate_number', null, ['class' => 'form-control', 'placeholder' => __('contact.alternate_contact_number')]); !!}
		            </div>
		        </div>
		      </div>
		      <div class="clearfix"></div>
		      <div class="col-md-4">
		        <div class="form-group">
		            {!! Form::label('city', __('business.city') . ':*') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-map-marker"></i>
		                </span>
		                {!! Form::text('city', null, ['class' => 'form-control', 'required', 'placeholder' => __('business.city')]); !!}
		            </div>
		        </div>
		      </div>
		      <div class="col-md-4">
		        <div class="form-group">
		            {!! Form::label('state', __('business.state') . ':') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-map-marker"></i>
		                </span>
		                {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('business.state')]); !!}
		            </div>
		        </div>
		      </div>
		      <div class="col-md-4">
		        <div class="form-group">
		            {!! Form::label('country', __('business.country') . ':') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-globe"></i>
		                </span>
		                {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('business.country')]); !!}
		            </div>
		        </div>
		      </div>
		      <div class="clearfix"></div>
		      <div class="col-md-12">
		        <div class="form-group">
		            {!! Form::label('landmark', __('business.landmark') . ':') !!}
		            <div class="input-group">
		                <span class="input-group-addon">
		                    <i class="fa fa-map-marker"></i>
		                </span>
		                {!! Form::text('landmark', null, ['class' => 'form-control', 'required', 
		                'placeholder' => __('business.landmark')]); !!}
		            </div>
		        </div>
		      </div>

		    </div>
		    </div>
		    <div class="modal-footer">
		      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
		      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
		    </div>

		    {!! Form::close() !!}
		  
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->	
</div>