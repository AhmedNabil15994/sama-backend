@extends('apps::frontend.layouts.app')

@section('title',$category->title)
@section( 'content')
<section class="inner-banner">
  <div class="container">
    <ul class="list-unstyled thm-breadcrumb">
      <li><a href="{{ route('frontend.home') }}">{{ __('Home') }}</a></li>
      <li class="active"><a href="{{ route('frontend.categories.show',['category'=>$category->id]) }}">{{ $category->title }}</a></li>
    </ul>
  </div>
</section>

<section class="course-one course-page bg-color-dark">
  <div class="container">
    <div class="row">
        <div class="col">
          <a href="{{ route('frontend.categories.show',['category'=>$category->id, 'type' => 'packages']) }}">
            <div class="course-one__single course-category-one__single color-1">

              <div class="course-one__content">
                <h2 class="course-one__title">{{ __('Packages') }}</h2>
              </div>
            </div>
          </a>
        </div>

        <div class="col">
          <a href="{{ route('frontend.categories.show',['category'=>$category->id, 'type' => 'courses']) }}">
            <div class="course-one__single course-category-one__single color-1">
              <div class="course-one__content">
                <h2 class="course-one__title">{{ __('Materials') }}</h2>
              </div>
            </div>
          </a>
        </div>

        <div class="col">
          <a href="{{ route('frontend.categories.show',['category'=>$category->id, 'type' => 'notes']) }}">
            <div class="course-one__single course-category-one__single color-1">
              <div class="course-one__content">
                <h2 class="course-one__title">{{ __('Printed Notes') }}</h2>
              </div>
            </div>
          </a>
        </div>
    </div>
  </div>
@endsection
