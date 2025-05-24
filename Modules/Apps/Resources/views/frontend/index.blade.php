@extends('apps::frontend.layouts.app')

@section('title', __('home'))
@push('css')
  <style>
    .mb-100{
      margin-bottom:100px;
    }
    .mx-20{
      margin-right: 20px;
      margin-left: 20px;
    }
    .packagesBtn:hover,
    .packagesBtn:active,
    .packagesBtn.active,
    .packagesBtn:focus,
    .notesBtn:hover,
    .notesBtn:active,
    .notesBtn.active,
    .notesBtn:focus{
      color: #FFF !important;
      background-color: #26b1cd !important;
      cursor: pointer;
    }
    .notesBtn,.packagesBtn{
      background-color: #FFF !important;
      color: #012237 !important;
    }
    .product-block{
      background: #FFFF;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    .product-block img{
      width: 100%;
    }
    .product-block .price_data h4{
      min-height: 56px;
    }
    .packages,.notes{
      display: flex;
    }
    .hidden{
      display: none;
    }
    .course-one__image,.course-one__image > img{
     min-height: 200px;
    }
    .course-one__title.title-name{
      min-height: 45px;
    }

  </style>
@endpush
@section('content')
<div class="banner-wrapper">
  <section class="banner-one banner-carousel__one no-dots owl-theme owl-carousel">
    @foreach($sliders as $slider)
    <div class="banner-one__slide banner-one__slide-one">
      <div class="container">
        <div class="banner-one__bubble-1"></div>
        <img src="{{ asset('frontend') }}/assets/images/slider-3-icon-1-2.png" class="slider-three__icon-2" alt="">
        <img src="{{ asset('frontend') }}/assets/images/slider-3-icon-1-4.png" class="slider-three__icon-4" alt="">
        <img src="{{ asset('frontend') }}/assets/images/slider-3-icon-1-5.png" class="slider-three__icon-5" alt="">
        <img src="{{ $slider->getFirstMediaUrl('images') }}" class="banner-one__person" alt="">
        <div class="row no-gutters text-slide">
          <div class="col-xl-12">
            <h3 class="banner-one__title banner-one__light-color"> {{ $slider->title }}</h3>
            <p class="banner-one__tag-line">{!! $slider->description !!}</p>
            <a href="{{$slider->url}}" class="thm-btn banner-one__btn">{{ __('Educational Stages') }}</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </section>
</div>

@php $userCourses = auth()->check() ? auth()->user()->my_courses->get() : []; @endphp
@if(auth()->check() && count($userCourses))
  <section class="course-category-one bg-color-dark-one">
    <img src="{{asset('frontend')}}/assets/images/circle-stripe.png" class="course-category-three__circle" alt="">
    <div class="container">
      <div class="block-title">
        <h2 class="block-title__title">{{ __('My Materials') }}</h2>
      </div>
      <div class="row">
        @foreach($userCourses as $course)
        <div class="col-lg-3">
          <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}">
            <div class="course-one__single">
              <div class="course-one__image">
                <img src="{{$course->image}}" alt="">
              </div>
              <div class="course-one__content">
                <div class="course-one__category">{{ $course->categories[0]?->title }} </div>
                <h2 class="course-one__title title-name">{{$course->title }}</h2>
              </div>
            </div>
          </a>
        </div>
        @endforeach

      </div>
      <div class="text-center">
        <a href="{{route("frontend.profile.my-courses")}}" class="thm-btn course-category-three__more-link">{{ __('View all My Materials') }}</a>
      </div>
    </div>
  </section>
@endif

<section class="course-category-one" id="offers">
  <img src="{{asset('frontend')}}/assets/images/circle-stripe.png" class="course-category-one__circle" alt="">
  <div class="container-fluid text-center">
    <div class="container">
      <div class="row packages">
        <div class="col-md-6">
          <div class="product-block">
            <a href="{{ route('frontend.packages.index') }}" class="img-block">
              <img class="img-fluid" src="{{asset('frontend/assets/images/packages.jpg')}}" alt="" />
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="product-block">
            <a href="{{ route('frontend.notes.index') }}" class="img-block">
              <img class="img-fluid" src="{{asset('frontend/assets/images/notes.jpg')}}" alt="" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="course-category-one" id="courses">
  <img src="{{asset('frontend')}}/assets/images/circle-stripe.png" class="course-category-one__circle" alt="">
  <div class="container-fluid text-center">
    <div class="container">
      <div class="block-title text-center">
        <h2 class="block-title__title">{{ __('Educational Stages') }} <br>
          {{ __('Join Thousands of Students') }}</h2>
      </div>
      <div class="course-category-one__items">
        <div class="row align-items-start">
          @foreach($mainCategories as $key => $category)
          <div class="col">
            <a href="{{ route('frontend.categories.show',['category'=>$category]) }}" class="items">
              <div class="course-category-one__single color-1">

                <img src="{{$category->getFirstMediaUrl('images')}}" width="125"/>
                <h3 class="course-category-one__title">{{ $category->title }}</h3>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>


@endsection
@push('js')
  <script>
    $(function(){
      $('#offers .thm-btn').on('click',function (){
        if(!$(this).hasClass('active')){
          $(this).addClass('active');
          $($(this).siblings('.thm-btn').data('target')).addClass('hidden').slideUp(250);
          $(this).siblings('.thm-btn').removeClass('active');
          $($(this).data('target')).removeClass('hidden').slideDown(250);
        }
      });
    })
  </script>
@endpush
