@extends('apps::frontend.layouts.app')
@section('title', __('cart::frontend.show.title') )
@push('css')
{{--  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet" />--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" rel="stylesheet">
  <style>
    .contact-one{
      padding: 0 15px !important;
    }
    .ladda-button:hover{
      color: #000;
    }
    .select2-selection span{
      color: #81868a !important;
    }
  </style>
@endpush
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{route('frontend.home')}}">{{ __('Home') }}</a></li>
      <li class="active"> {{ __('Shopping Cart') }}</li>
    </ul>
  </div>
</section>
<section class="course-one course-page cart bg-color-dark ">
  @include('apps::frontend.layouts._alerts')
  @php $hasPaperNote=1; @endphp
  @if (count($items))
    <div class="container">
      <h2 class="header-title">
        <div class="course-details__meta-icon flag-icon"> <i class="fas fa-shopping-bag"></i></div>
        {{ __('Shopping Cart') }}
      </h2>
      <div class="row justify-content-center">
          @foreach ($items as $item)
            <div class="col-lg-4">
              <div class="course-one__single shap">
                <div class="course-one__image">
                  <img src="{{ $item->attributes->image }}" alt="">
                </div>
                <div class="course-one__content">
                  <div class="course-one__category"> {{$item->attributes->product['category']}} </div>
                  <h2 class="course-one__title title-name">{{$item->attributes->product['title']}}</h2>
                  <h2 class="pricing-one__price">{{ $item->price }} {{ __('KWD') }} </h2>
                  <p class="pricing-one__name">{{$item->attributes->product['sub_title'] }}</p>
                </div>
              </div>
              <span class="cartSpan"><a class="link-dark" style="color: white" href="{{route('frontend.cart.remove',[$item->attributes->type, $item->attributes->item_id])}}">x</a></span>
            </div>
          @endforeach


      </div>
      <hr>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          {!! Form::open([
            'url'=> route('frontend.order.create'),
            'role'=>'form',
            'class'=>'course-details__comment-form copon_code',
            'id'=>'cart_form',
            'method'=>'POST',
            ])!!}
              <div class="row justify-content-center">
                <div class="col-lg-12">
                  <input type="text" name="coupon_code" placeholder="{{ __('Enter the Coupon Code') }}" value="{{session()->get('old_data.coupon_code') ?? ''}}">
                </div>
              </div>
              @if($hasPaperNote)
              <div class="addressForm">
                @if(auth()->check() && auth()->user()->name == '')
                  <div class="row justify-content-center">
                    <div class="col-lg-12">
                      <input type="text" name="name" value="" placeholder="{{ __('Name') }}">
                    </div>
                  </div>
                @endif
                <div class="row justify-content-center">
                  <div class="col-lg-12 contact-one ">
                    @inject('states','Modules\Area\Entities\State')
                    <select class="form-control select2" name="state_id" id="state_id" required>
                      <option value=" " disabled selected>{{__('State')}}</option>
                      @foreach($states->get() as $state)
                        <option value="{{$state->id}}" {{($state->id == (optional(auth()->user()?->address)->state_id ?? session()->get('old_data.state_id')) )? 'selected' : ''}}>{{$state->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-lg-12">
                    <input type="hidden" value="{{$hasPaperNote}}" name="hasPaperNote">
                    <input type="text" name="widget" value="{{optional(auth()->user()?->address)->widget ?? session()->get('old_data.widget')}}" placeholder="{{ __('Block') }}" required>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-lg-12">
                    <input type="text" name="street" value="{{optional(auth()->user()?->address)->street ?? session()->get('old_data.street')}}" placeholder="{{ __('Street') }}" required>
                  </div>
                </div>
                <div class="row justify-content-center">
{{--                  <div class="col-lg-6">--}}
{{--                    <input type="text" name="gada" value="{{optional(auth()->user()?->address)->gada}}" placeholder="{{ __('Gada') }}">--}}
{{--                  </div>--}}
                  <div class="col-lg-12">
                    <input type="text" name="building" value="{{optional(auth()->user()?->address)->building ?? session()->get('old_data.building')}}" placeholder="{{ __('House') }}" required>
                  </div>
                </div>
{{--                <div class="row justify-content-center">--}}
{{--                  <div class="col-lg-6">--}}
{{--                    <input type="text" name="floor" value="{{optional(auth()->user()?->address)->floor}}" placeholder="{{ __('Floor') }}" required>--}}
{{--                  </div>--}}
{{--                  <div class="col-lg-6">--}}
{{--                    <input type="text" name="flat" value="{{optional(auth()->user()?->address)->flat}}" placeholder="{{ __('Flat') }}" required>--}}
{{--                  </div>--}}
{{--                </div>--}}
                <div class="row justify-content-center">
                  <div class="col-lg-12">
                    <input type="hidden" name="type" value="{{optional(auth()->user()?->address)->widget ?? 'house'}}">
                    <textarea name="details" id="details"  placeholder="{{__('Address Details')}}">{{optional(auth()->user()?->address)->details ?? session()->get('old_data.details')}}</textarea>
                  </div>
                </div>
              </div>
             @endif
            {!! Form::close()!!}
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="pricing-one__single text-center">
            <div class="pricing-one__inner">
              <h2 class="pricing-one__price">{{ Cart::getTotal() }} {{ __('KWD') }} </h2>
              <p class="pricing-one__name">{{ __('Total Cost') }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <a onclick="submitCourseForm(this,'cart_form')" class="thm-btn banner-one__btn ladda-button"  data-style="expand-left" style="color: white;cursor:pointer"><span class="ladda-label">{{ __('Payment') }}</span></a>
        </div>
      </div>
    </div>
  @else
    <div class="alert alert-danger" role="alert" style="text-align: center;">
      @lang("No Data Found")
    </div>
  @endif
</section>
@include("course::frontend.courses.components.buy-course-script")
@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    Ladda.bind( '.ladda-button' );
    function submitCourseForm(btn,id){
      $(btn).prop('disabled',true);
      var l = Ladda.create($(btn));
      l.start();
      $(`#${id}`).submit();
    }
    $('.select2').select2();
  </script>
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>--}}
{{--  <script>--}}
{{--    $(function (){--}}
{{--        $('.select2').selectpicker()--}}
{{--    });--}}
{{--  </script>--}}
@endpush
@stop
