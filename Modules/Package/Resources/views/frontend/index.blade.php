@extends('apps::frontend.layouts.app')
@section( 'title',__('packages'))
@push('css')
  <style>
    .p-50{
      padding:50px;
    }
    .mt-15{
      margin-top: 15px;
    }
  </style>
@endpush
@section( 'content')
<div class="inner-page bg-color-dark-one">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="products-container p-50">
          <div class="row">
            @foreach($packages as $key => $package)
            <div class="col-md-4 col-12">
              @include('package::frontend.partials.item')
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
  <script>
    $(function (){
      $('.price_data .select2_package').on('change',function (){
        $(this).parents('.price_data').find('.the_price').empty().html($(this).children('option:selected').data('item'))
        let newPriceId = $(this).val();
        let oldHref = $(this).parents('.price_data').find('.addto-cart').attr('href',"{{route('frontend.cart.add',["package",":id"])}}".replace(':id',newPriceId));
      })
    });
  </script>
@endpush
