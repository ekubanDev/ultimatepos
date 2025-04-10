<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title"><b>@lang('product.product_name'):</b> {{$purchase_line->name}}, <b>@lang('purchase.ref_no'):</b> {{$purchase_line->ref_no}}</h4>
    </div>
    <form id="stock_exp_modal_form" method="post" action="{{route('updateStockExpiryReport')}}">
    <input type="hidden" value="{{$purchase_line->id}}" name="purchase_line_id">
    <div class="modal-body">
      <div class="row">
      <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('stock_left', __( 'report.stock_left' ) . ':*') !!}
        {!! Form::text('stock_left', $purchase_line->stock_left, ['class' => 'form-control', 'required']); !!}
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          {!! Form::label('exp_date', __( 'product.exp_date' ) . ':*') !!}
          {!! Form::text('exp_date', $purchase_line->exp_date, ['class' => 'form-control', 'required', 'id' => 'exp_date_expiry_modal', 'readonly']); !!}
        </div>
      </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang('messages.update')</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.cancel')</button>
    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->