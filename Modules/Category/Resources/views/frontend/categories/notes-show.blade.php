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
    @if(count($notes))
      <h2 class="header-title">
        <div class="course-details__meta-icon file-icon"> <i class="fas fa-folder"></i></div> {{ $category->title }}
      </h2>
      <div class="row">
        @foreach($notes as $note)
          <div class="col-lg-3">
           @include("course::frontend.courses.notes.note-card")
          </div>
        @endforeach
      </div>
    @endif

    @if(!count($notes))
      <div class="alert alert-danger" role="alert" style="text-align: center;">
        @lang("No Data Found")
      </div>
    @endif
  </div>
</section>

@endsection
