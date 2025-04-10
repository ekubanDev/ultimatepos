@extends('layouts.app')
@section('title', 'Purchase Details')

@section('content')
  <!-- Main content -->
  <section class="content">

    <div class="row no-print">
      <div class="col-xs-12">
        <a href="{{action('PurchaseController@index')}}" 
          class="btn btn-sm btn-primary pull-left">
          <i class="glyphicon glyphicon-arrow-left"></i> 
            {{ __('messages.go_back') }}
        </a>

        <button class="btn btn-sm btn-info pull-right no-print" onclick="window.print()">
          <i class="fa fa-print" aria-hidden="true"></i> 
            {{ __('messages.print') }}
        </button>

        <a href="{{action('PurchaseController@edit', [$purchase->id])}}" 
          class="btn btn-sm btn-primary pull-right">
          <i class="glyphicon glyphicon-edit"></i> 
            {{ __('messages.edit') }}
        </a>
        
        
      </div>
    </div>
    
    @include('purchase.partials.show_details')
  </section>
  <!-- /.content -->
@endsection