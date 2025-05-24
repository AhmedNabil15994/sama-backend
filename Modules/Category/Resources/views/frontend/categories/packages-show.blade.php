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
    @if(count($packages))
      <h2 class="header-title">
        <div class="course-details__meta-icon flag-icon"> <i class="fas fa-flag"></i></div> {{ $category->title }}
      </h2>
      <div class="row">

        @foreach($packages as $package)
        <div class="col-lg-3">
          <a href="{{ route('frontend.packages.show',['package'=>$package->id]) }}">
            <div class="course-one__single">
              <div class="course-one__image">
                <img src="{{ $package->image }}" alt="">
              </div>
              <div class="course-one__content">
                <div class="course-one__category">{{ $category->title }} </div>
                <h2 class="course-one__title title-name">{{ $package->title }}</h2>
                <p>{{ $package->description }}</p>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    @endif

    @if(!count($packages))
      <div class="alert alert-danger" role="alert" style="text-align: center;">
        @lang("No Data Found")
      </div>
    @endif
  </div>
</section>

@endsection
