@extends('apps::frontend.layouts.app')
@section('content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }} </a></li>
      <li><a href="{{ route('frontend.categories.show',['category'=>$category->parent->id]) }}"> {{ $category->parent->title }}</a></li>
      <li class="active"><a href="{{ route('frontend.categories.show',['category'=>$category->id]) }}">{{ $category->title }}</a></li>
    </ul>
  </div>
</section>


<section class="course-one course-page bg-color-dark">
  <div class="container">

    @if(count($courses))
      <h2 class="header-title">
        <div class="course-details__meta-icon video-icon"> <i class="fas fa-play"></i></div> {{ $category->title }}
      </h2>
      <div class="row">
        @foreach($courses as $course)
          <div class="col-lg-3">
            <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}">
              <div class="course-one__single">
                <div class="course-one__image">
                  <img src="{{ asset($course->image) }}" alt="">
                </div>
                <div class="course-one__content">
                  <div class="course-one__category">{{ $category->title }} </div>
                  <h2 class="course-one__title title-name">{{ $course->title }}</h2>
                  <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}" class="course-one__link">{{ __('Show') }}</a>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @endif

    @if(!count($courses))
      <div class="alert alert-danger" role="alert" style="text-align: center;">
        @lang("No Data Found")
      </div>
    @endif
  </div>
</section>

@endsection
