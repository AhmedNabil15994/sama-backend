@extends('apps::frontend.layouts.app')
<style>
  .course-one__title.title-name{
    height: 45px;
  }
</style>
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
      @php $has_data = false @endphp
      @php $courses = $category->courses()->active()->orderBy('order','asc')->get() @endphp
      @php $notes = $category->notes()->active()->get() @endphp
      @php $packages = $category->packages()->active()->get() @endphp

      <div class="row">
        @if(count($courses))
          @php $has_data = true @endphp
          @foreach($courses ??[] as $course)
            <div class="col-lg-3">
              <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}">
                <div class="course-one__single">
                  <div class="course-one__image">
                    <img src="{{ asset($course->image) }}" alt="">
                  </div>
                  <div class="course-one__content" style="height: 215px">
                    <div class="course-one__category">{{ $category->title }} </div>
                    <h2 class="course-one__title title-name">{{ $course->title }}</h2>
                    <p style="height: 20px"></p>
                    <a href="{{ route('frontend.courses.show',['slug'=>$course->slug]) }}" class="course-one__link">{{ __('Show') }}</a>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        @endif
        @if(count($packages))
          @php $has_data = true @endphp
          @foreach($packages as $package)
            <div class="col-lg-3">
              <a href="{{ route('frontend.packages.show',['package'=>$package->id]) }}">
                <div class="course-one__single">
                  <div class="course-one__image">
                    <img src="{{ asset($package->image) }}" alt="">
                  </div>
                  <div class="course-one__content" style="height: 215px">
                    <div class="course-one__category">{{ $package->title }} </div>
                    <h2 class="course-one__title title-name">{{ $package->title }}</h2>
                    <p style="height: 20px">{{ $package->description }}</p>
                    <a href="{{ route('frontend.packages.show',['package'=>$package->id]) }}" class="course-one__link">{{ __('Show') }}</a>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        @endif
        @if(count($notes))
          @php $has_data = true @endphp
          @foreach($notes as $note)
            <div class="col-lg-3">
              <div class="course-one__single">
                <div class="course-one__image">
                  <img src="{{ asset($note->image) }}" alt="">
                </div>
                <div class="course-one__content" style="height: 215px">
                  <div class="course-one__category">{{ $note->title }} </div>
                  <h2 class="course-one__title title-name">{{ $note->title }}</h2>
                  <p style="height: 20px">{{ __('Includes :notes_count notes',['notes_count'=> count($note->getMedia('pdf'))]) }} </p>
                  @if($note->is_free)
                    <a class="course-one__link" href="{{$note->getFirstMediaUrl('pdf')}}">@lang("Show")</a>
                  @else
                    @if(!auth()->check()||(auth()->id() && !auth()->user()->can('dashboard_access')))
                      <a href="{{ route('frontend.cart.add',['id'=>$note->id,'type'=>'note']) }}" class="course-one__link">{{ __('Add To Cart') }}</a>
                    @endif
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>

      @if(!$has_data)
        <div class="alert alert-danger" role="alert" style="text-align: center;">
          @lang("No Data Found")
        </div>
      @endif
    </div>
  </section>

@endsection
