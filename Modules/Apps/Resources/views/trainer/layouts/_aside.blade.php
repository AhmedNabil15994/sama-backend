<div class="page-sidebar-wrapper">

  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>
      <li class="nav-item {{ active_menu('home') }}">
        <a href="{{ url(route('trainer.home')) }}" class="nav-link nav-toggle">
          <i class="icon-home"></i>
          <span class="title">{{ __('apps::dashboard.index.title') }}</span>
          <span class="selected"></span>
        </a>
      </li>

      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
      </li>


      @can('show_orders')
        <li class="nav-item open  {{active_slide_menu(['orders','course_orders','note_orders'])}}">
          <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-briefcase"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside._tabs.orders')}}</span>
            <span class="arrow {{active_slide_menu(['orders'])}}"></span>
            <span class="selected"></span>
          </a>
          <ul class="sub-menu" style="display: block;">
            @can('show_orders')
              <li class="nav-item {{ active_menu('course_orders') }}">
                <a href="{{ route('trainer.orders.course_orders') }}" class="nav-link nav-toggle">
                  <i class="fa fa-building"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.course_orders') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
            @can('show_orders')
              <li class="nav-item {{ active_menu('note_orders') }}">
                <a href="{{ route('trainer.orders.note_orders') }}" class="nav-link nav-toggle">
                  <i class="fa fa-building"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.note_orders') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcan

      @can('statistics_trainers')
        <li class="nav-item  {{ active_slide_menu('statistics') }}">
          <a href="{{ url(route('trainer.trainers.statistics')) }}" class="nav-link nav-toggle">
            <i class="icon-users"></i>
            <span class="title">{{ __('order::dashboard.orders.trainer_stats.title') }}</span>
          </a>
        </li>
      @endcan

      @canany($coursesPermissions=['show_courses','show_lessons','show_lessoncontents','show_coursereviews'])
      <li class="nav-item open  {{active_slide_menu(['courses','lessons','lessoncontents','coursereviews'])}}">
        <a href="javascript:;" class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside._tabs.courses')}}</span>
          <span class="arrow {{active_slide_menu(['courses','lessons','lessoncontents','coursereviews'])}}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu" style="display: block;">
          @can('show_courses')
          <li class="nav-item {{ active_menu('courses') }}">
            <a href="{{ route('trainer.courses.index') }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.courses') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_lessons')
          <li class="nav-item {{ active_menu('lessons') }}">
            <a href="{{ route('trainer.lessons.index') }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.lessons') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_lessoncontents')
          <li class="nav-item {{ active_menu('lessoncontents') }}">
            <a href="{{ route('trainer.lessoncontents.index') }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.lesson_contents') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_coursereviews')
          <li class="nav-item {{ active_menu('show_coursereviews') }}">
            <a href="{{ route('trainer.coursereviews.index') }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.coursereviews') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcan

      @can('show_notes')
      <li class="nav-item {{ active_menu('notes') }}">
        <a href="{{ route('trainer.notes.index') }}" class="nav-link nav-toggle">
          <i class="fa fa-building"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.notes') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @can('show_review_questions')
        <li class="nav-item {{ active_menu('reviewquestions') }}">
          <a href="{{ route('trainer.reviewquestions.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-building"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.review_questions') }}</span>
            <span class="selected"></span>
          </a>
        </li>
      @endcan
{{--      @can('show_exams')--}}
{{--      <li class="nav-item {{ active_menu('exams') }}">--}}
{{--        <a href="{{ route('trainer.exams.index') }}" class="nav-link nav-toggle">--}}
{{--          <i class="fa fa-building"></i>--}}
{{--          <span class="title">{{ __('apps::dashboard._layout.aside.exams') }}</span>--}}
{{--          <span class="selected"></span>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      @endcan--}}
{{--      @can('show_questions')--}}
{{--      <li class="nav-item {{ active_menu('questions') }}">--}}
{{--        <a href="{{ route('trainer.questions.index') }}" class="nav-link nav-toggle">--}}
{{--          <i class="fa fa-building"></i>--}}
{{--          <span class="title">{{ __('apps::dashboard._layout.aside.questions') }}</span>--}}
{{--          <span class="selected"></span>--}}
{{--        </a>--}}
{{--      </li>--}}
{{--      @endcan--}}

    </ul>
  </div>

</div>
