@extends('apps::frontend.layouts.app')
@section('title', $course->title)
@push('css')
  <link rel="stylesheet" href="{{asset('frontend/assets/css/style-exam-'.locale().'.css')}}">
  <style>
    .course-details__content.exam{
      display: none;
    }
    .m-20{
      margin: 20px !important;
    }
    .hidden{
      display: none !important;
    }
    .textareaContainer{
      position: relative;
    }
    .textareaContainer .fa-paperclip{
      position: absolute;
      cursor: pointer;
      font-size: 24px;
      bottom: 10px;
      @if(locale() == 'ar')
      left: 10px;
      @else
      right: 10px;
      @endif
    }
    .answers-list img{
      height: auto;
      width: 100%;
    }
    .course-details__curriculum-list-left {
      cursor: pointer;
    }
    .course-details__curriculum-list-left.active a{
      color:#2da397;
      font-size: 15px;
    }
    .lesson-title {
      color: #81868a;
      font-size: 15px;
      font-weight: 250;
      padding: 5px;
    }

    .correct_answer {
      background-color: #00AF80;
      color: white;
      border: #00AF80 solid 1px;
      border-radius: 7px;
      padding-top: 5px;
      padding-bottom: 5px;
    }
    .failed_answer {
      background-color: #C10000;
      color: #FFFFFF;
      border: #C10000 solid 1px;
      border-radius: 7px;
      padding-top: 5px;
      padding-bottom: 5px;
    }
  </style>
@endpush
@section('content')

<div class="page-wrapper course-details-new">
  @include('apps::frontend.layouts._alerts')

  <div class="topbar-one course-d">
    <div class="container">
      <div class="topbar-one__right ">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ route('frontend.courses.show',
            ['slug'=>$course->slug,'semester_id'=>$currentSemester->id]) }}" role="button" data-toggle="dropdown" aria-expanded="false">
              {{ $currentSemester->title }}
            </a>
            <div class="dropdown-menu">
              @foreach($semesters as $key => $semester)
              <a class="dropdown-item" href="{{ route('frontend.courses.show',['slug'=>$course->slug,'semester_id'=>$semester->id]) }}">
                {{ $semester->title}}
              </a>
              @endforeach
            </div>
          </li>
        </ul>
        <div class="links__topbar">
          @if(!$has_access)
          <a href="{{ route('frontend.cart.add',['id'=>$course->id,'type'=>'course']) }}" class="thm-btn banner-one__btn">{{ __('Add to Cart') }}</a>
          @endif

          @include('apps::frontend.layouts.lang-bar')
        </div>
      </div>
      <div class="logo-box clearfix">
        <a class="navbar-brand" href="{{ route('frontend.home') }}">
          <img src="{{setting('logo')?asset(setting('logo')): asset('frontend/assets/images/mlogo-dark.png') }}" class="main-logo" alt="Awesome Image" />
        </a>
      </div>
    </div>
  </div>

  <section class="course-details details-parts bg-color-dark">
    <div class="container-fluid">
      <div class="playlists">
        <div class="row basic">
          <div class="col-lg-3">
            <div class="playlists-part">
              <div class="pill-header">
                <div class="card">
                  <h5 class="mb-0">
                    <div class="course-details__meta-icon file-icon"> <i class="fas fa-folder"></i></div>
                    {{ $course->title }}
                  </h5>
                  @if(!$has_access)
                  <a href="{{ route('frontend.cart.add',['id'=>$course->id,'type'=>'course']) }}" class="thm-btn banner-one__btn">{{ __('Add to Cart') }}</a>
                  @endif
                </div>
              </div>
              <div id="accordion" class="course-details__curriculum-list list-unstyled">
                @foreach($lessons as $key => $lesson)
                  <div class="card">
                    <div class="card-header" id="heading-{{ $lesson->id }}">
                      <h5 class="mb-0">
                        <a role="button" data-toggle="collapse" href="#collapse-{{ $lesson->id }}" class="collapsed" aria-controls="collapse-{{ $lesson->id }}">
                          <div class="course-details__meta-icon">
                            <i class="far fa-flag"></i>
                          </div>
                          {{ $lesson->title  }}
                        </a>
                      </h5>
                    </div>
                    <div id="collapse-{{ $lesson->id }}" class="collapse tab {{$key == 0 ? 'show' : ''}}" data-parent="#accordion" aria-labelledby="heading-{{ $lesson->id }}">
                      <div class="card-body">
                        <ul class="course-details__curriculum-list list-unstyled">
                          @foreach($lesson->lessonContents as $lessonContent)
                          @include('course::frontend.courses.lesson-content-type.'.$lessonContent->type,['parent'=>$loop->parent->iteration,'course' => $course])
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <div class="col-lg-9">
            <div class="course-details__content main">
              @if($lesson_content && $lesson_type !== 'exam')
                @include('course::frontend.courses.show-partials.show_lesson_content')
              @elseif($lesson_type !== 'exam')
                <div id="course-details__content">
                  <div class="course-one__vide video-select tabcontent" id="vidcontent">
                    <iframe class="videos-iframe" src="{{ $course->intro_video }}"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                  </div>
                </div>
              @endif
            </div>

            @if($lesson_type == 'exam')
              <div class="course-details__content main"
                @include('course::frontend.courses.lesson-content-type.exam_questions')
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>


  @endsection
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{asset('frontend/assets/js/script-exam-'.locale().'.js')}}"></script>
<script>

$('.quiz').on('click',function (){
  $('.course-details__content.main').slideUp(250);
  $('.course-details__content.exam').slideUp(250);
  $('.course-details__content.exam'+$(this).attr('href')).slideDown(250);
  $('.scroll-to-target').click()
});

$('.tablinks').on('click',function (){
  $('.course-details__content.exam').slideUp(250);
  $('.course-details__content.main').slideDown(250);
});

$('.accordion .accordion-toggle').on('click',function (e){
  e.preventDefault();
  e.stopPropagation();
  let itemId = $(this).attr('href');
  $(this).parents('.accordion').find($(itemId)).slideToggle(250)
});

$('.textareaContainer .fa-paperclip').on('click',function (){
  $(this).siblings('input[type="file"]')[0].click()
})


</script>
@endpush
