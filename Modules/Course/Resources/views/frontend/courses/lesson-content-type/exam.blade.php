@if($lessonContent->status)
<li>
  <div class="course-details__curriculum-list-left">
    <div class="course-details__meta-icon exam-icon">
      @if($has_access)
      <i class="fas fa-folder"></i>
      @else
        <i class="fas fa-lock"></i>
      @endif
    </div>
    @if($has_access)
    <a class="" href="{{ route('frontend.courses.show',['slug'=>$course->slug, 'lesson-content-id' => $lessonContent->id]) }}">{{$lessonContent->exam?->title}}</a>
    @else
      <a class="" style="pointer-events: none; cursor: default" aria-disabled="true">
        {{$lessonContent->exam?->title }}
      </a>
    @endif
  </div>
</li>
@endif
