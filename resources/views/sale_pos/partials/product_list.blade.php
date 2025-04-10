<div class="row">
	<div class="col-md-12">
		
		@forelse($products as $product)
			<div class="product_cell col-md-3">
				<div class="product_cell_div bg-gray" 
					data-variation_id="{{$product->variation_id}}">
					{{$product->name}} 
					@if($product->type == 'variable')
						- {{$product->variation}}
					@endif
					<br/><span class="text-muted">({{$product->sub_sku}})</span>
				</div>
			</div>
		@empty
			<h4 class="text-center">
				@lang('lang_v1.no_products_to_display')
			</h4>
		@endforelse
	</div>
	<div class="col-md-12">
		{{ $products->links('sale_pos.partials.product_list_paginator') }}
	</div>
</div>