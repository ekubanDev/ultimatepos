@extends('layouts.app')
@section('title', __('sale.sell_details'))

@section('content')
  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">
        <a href="{{action('SellController@index')}}" 
          class="btn btn-sm btn-primary pull-left">
          <i class="glyphicon glyphicon-arrow-left"></i> 
            {{ __('messages.go_back') }}
        </a>

        <a href="{{action('SellPosController@edit', [$sell->id])}}" 
          class="btn btn-sm btn-primary pull-right">
          <i class="glyphicon glyphicon-edit"></i> 
            {{ __('messages.edit') }}
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          {{ __('sale.sell_details') }}
          <small class="pull-right"><b>Date:</b> {{ @format_date($sell->transaction_date) }}</small>
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <b>{{ __('sale.invoice_no') }}:</b> #{{ $sell->invoice_no }}<br>
        <b>{{ __('sale.status') }}:</b> 
          @if($sell->status == 'draft' && $sell->is_quotation == 1)
            {{ __('lang_v1.quotation') }}
          @else
            {{ ucfirst( $sell->status ) }}
          @endif
        <br>
        <b>{{ __('sale.payment_status') }}:</b> {{ ucfirst( $sell->payment_status ) }}<br>
      </div>
      <div class="col-sm-4">
        <b>{{ __('sale.customer_name') }}:</b> {{ $sell->contact->name }}<br>
        <b>{{ __('business.address') }}:</b><br>
        @if($sell->contact->landmark)
            {{ $sell->contact->landmark }}
        @endif

        {{ ', ' . $sell->contact->city }}

        @if($sell->contact->state)
            {{ ', ' . $sell->contact->state }}
        @endif
        <br>
        @if($sell->contact->country)
            {{ $sell->contact->country }}
        @endif
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <h4>{{ __('sale.products') }}:</h4>
      </div>

      <div class="col-sm-12 col-xs-12">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr class="bg-green">
              <th class="col-sm-1">#</th>
              <th class="col-sm-3">{{ __('sale.product') }}</th>
              <th class="col-sm-1">{{ __('sale.qty') }}</th>
              <th class="col-sm-1">{{ __('sale.unit_price') }}</th>
              <th class="col-sm-2">{{ __('sale.tax') }}</th>
              <th class="col-sm-1">{{ __('sale.price_inc_tax') }}</th>
              <th class="col-sm-1">{{ __('sale.subtotal') }}</th>
            </tr>
            @foreach($sell->sell_lines as $sell_line)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  {{ $sell_line->product->name }}
                  @if( $sell_line->product->type == 'variable')
                    - {{ $sell_line->variations->product_variation->name}}
                    - {{ $sell_line->variations->name}},
                   @endif
                   {{ $sell_line->variations->sub_sku}}
                    @php
                      $brand = $sell_line->product->brand;
                    @endphp
                    @if(!empty($brand->name))
                      , {{$brand->name}}
                    @endif
                </td>
                <td>{{ $sell_line->quantity }}</td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $sell_line->unit_price }}</span>
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $sell_line->item_tax }}</span> 
                  @if(!empty($taxes[$sell_line->tax_id]))
                    ( {{ $taxes[$sell_line->tax_id]}} )
                  @endif
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $sell_line->unit_price_inc_tax }}</span>
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $sell_line->quantity * $sell_line->unit_price_inc_tax }}</span>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <h4>{{ __('sale.payment_info') }}:</h4>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr class="bg-green">
              <th class="col-sm-1">#</th>
              <th class="col-sm-3">{{ __('messages.date') }}</th>
              <th class="col-sm-3">{{ __('sale.amount') }}</th>
              <th class="col-sm-2">{{ __('sale.payment_mode') }}</th>
              <th class="col-sm-3">{{ __('sale.payment_note') }}</th>
            </tr>
            @php
              $total_paid = 0;
            @endphp
            @foreach($sell->payment_lines as $payment_line)
              @php
                $total_paid += $payment_line->amount;
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ @format_date($payment_line->paid_on) }}</td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $payment_line->amount }}</span></td>
                <td>{{ ucfirst($payment_line->method) }}</td>
                <td>@if($payment_line->note) 
                  {{ ucfirst($payment_line->note) }}
                  @else
                  --
                  @endif
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
      <div class="col-sm-6 col-xs-12">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr>
              <th>{{ __('sale.total') }}: </th>
              <td></td>
              <td><span class="display_currency pull-right">{{ $sell->total_before_tax }}</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.order_tax') }}:</th>
              <td><b>(+)</b></td>
              <td><span class="display_currency pull-right">{{ $sell->tax_amount }}</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.discount') }}:</th>
              <td><b>(-)</b></td>
              <td><span class="pull-right">{{ $sell->discount_amount }} @if( $sell->discount_type == 'percentage') {{ '%'}} @endif</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.total_payable') }}: </th>
              <td></td>
              <td><span class="display_currency pull-right">{{ $sell->final_total }}</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.total_paid') }}:</th>
              <td></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $total_paid }}</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.total_remaining') }}:</th>
              <td></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $sell->final_total - $total_paid }}</span></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <strong>{{ __( 'sale.sell_note')}}:</strong><br>
        <p class="well well-sm no-shadow bg-gray">
          @if($sell->additional_notes)
            {{ $sell->additional_notes }}
          @else
            --
          @endif
        </p>
      </div>
      <div class="col-sm-6">
        <strong>{{ __( 'sale.staff_note')}}:</strong><br>
        <p class="well well-sm no-shadow bg-gray">
          @if($sell->staff_note)
            {{ $sell->staff_note }}
          @else
            --
          @endif
        </p>
      </div>
    </div>
  </section>
  <!-- /.content -->
@endsection