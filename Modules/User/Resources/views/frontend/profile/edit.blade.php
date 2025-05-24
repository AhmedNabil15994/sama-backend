@extends('apps::frontend.layouts.app')
@section('title', __('Update Profile') )
@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <style>
    .select2-container .select2-selection--single .select2-selection__rendered{
      padding: 0 !important;
      color: #000 !important;
    }
  </style>
@endpush
@section('content')
  <section class="inner-banner">
    <div class="container">
      <ul class="list-unstyled thm-breadcrumb">
        <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
        <li class="active"><a href="#">@lang("Update Profile")</a></li>
      </ul>
    </div>
  </section>

  <section class="course-details account print-file bg-color-dark">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <section class="contact-one items">
            <div class="container">
              @include('apps::frontend.layouts._alerts')
              {!! Form::open([
                  'url'=> route('frontend.profile.update'),
                  'method'=>'POST',
                  'class'=>'contact-one__form',
                  'files' => true,
                  'novalidate' => ''
                  ])!!}
              <div class="row low-gutters">
                {!! field('auth')->text('name',__('Name'),auth()->user()->name)!!}
                {!! field('auth')->email('email',__('Email'),auth()->user()->email)!!}

                <div class="col-lg-12">
                  <label>@lang("Address")</label>
                </div>

                <div class="col-lg-12 ">
                  @inject('states','Modules\Area\Entities\State')
                  <select class="form-control select2" name="state_id" id="state_id">
                    <option value=" " disabled selected>{{__('State')}}</option>
                    @foreach($states->get() as $state)
                      <option value="{{$state->id}}" {{$state->id == optional(auth()->user()->address)->state_id ? 'selected' : ''}}>{{$state->title}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-lg-12">
                  <input type="text" name="widget" placeholder="{{ __('Block') }}" value="{{optional(auth()->user()->address)->widget}}">
                </div>
                <div class="col-lg-12">
                  <input type="text" name="street" placeholder="{{ __('Street') }}" value="{{optional(auth()->user()->address)->street}}">
                </div>
{{--                <div class="col-lg-6">--}}
{{--                  <input type="text" name="gada" placeholder="{{ __('Gada') }}" value="{{optional(auth()->user()->address)->gada}}">--}}
{{--                </div>--}}
                <div class="col-lg-12">
                  <input type="text" name="building" placeholder="{{ __('House') }}" value="{{optional(auth()->user()->address)->building}}">
                </div>
{{--                <div class="col-lg-6">--}}
{{--                  <input type="text" name="floor" placeholder="{{ __('Floor') }}" value="{{optional(auth()->user()->address)->floor}}">--}}
{{--                </div>--}}
{{--                <div class="col-lg-6">--}}
{{--                  <input type="text" name="flat" placeholder="{{ __('Flat') }}" value="{{optional(auth()->user()->address)->flat}}">--}}
{{--                </div>--}}
                <div class="col-lg-12">
                  <input type="hidden" name="type" value="{{optional(auth()->user()->address)->widget ?? 'house'}}">
                  <textarea style="height: auto;" placeholder="@lang("More Details")" name="details">{{optional(auth()->user()->address)->details}}</textarea>
                </div>

                <div class="col-lg-12">
                  <div class="text-center">
                    <button type="submit" class="contact-one__btn thm-btn">@lang("Save")</button>
                  </div>
                </div>
              </div>
              {!! Form::close() !!}
              <div class="result text-center"></div>
            </div>
          </section>
        </div>


        <div class="col-lg-4">
          @include("user::frontend.profile.components.sidebar")
        </div>
      </div>
    </div>
  </section>

@stop
@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    $('.select2').select2();
  </script>
@endpush
