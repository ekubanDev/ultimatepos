@extends('layouts.app')
@section('title', __( 'sale.drafts'))
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('sale.drafts')
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">
	<div class="box">
        <div class="box-header">
        	
        	<div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{action('SellPosController@create')}}">
				<i class="fa fa-plus"></i> @lang('messages.add')</a>
            </div>
        </div>
        <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="input-group">
                      <button type="button" class="btn btn-primary" id="daterange-btn">
                        <span>
                          <i class="fa fa-calendar"></i> Filter By Date
                        </span>
                        <i class="fa fa-caret-down"></i>
                      </button>
                    </div>
                  </div>
            </div>
        </div>
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="sell_table">
        		<thead>
        			<tr>
        				<th>@lang('messages.date')</th>
                        <th>@lang('purchase.ref_no')</th>
						<th>@lang('sale.customer_name')</th>
                        <th>@lang('sale.location')</th>
						<th>@lang('messages.action')</th>
        			</tr>
        		</thead>
        	</table>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
$(document).ready( function(){
    sell_table = $('#sell_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        ajax: '/sells/draft-dt?is_quotation=0',
        columnDefs: [ {
            "targets": 4,
            "orderable": false,
            "searchable": false
        } ],
        columns: [
            { data: 'transaction_date', name: 'transaction_date'  },
            { data: 'invoice_no', name: 'invoice_no'},
            { data: 'name', name: 'contacts.name'},
            { data: 'business_location', name: 'bl.name'},
            { data: 'action', name: 'action'}
        ],
        "fnDrawCallback": function (oSettings) {
            __currency_convert_recursively($('#purchase_table'));
        }
    });
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#daterange-btn span').html(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            sell_table.ajax.url( '/sells/draft-dt?is_quotation=0&start_date=' + start.format('YYYY-MM-DD') +
                '&end_date=' + end.format('YYYY-MM-DD') ).load();
        }
    );
    $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
        sell_table.ajax.url( '/sells/draft-dt?is_quotation=0').load();
        $('#daterange-btn span').html('<i class="fa fa-calendar"></i> Filter By Date');
    });
});
</script>
	
@endsection