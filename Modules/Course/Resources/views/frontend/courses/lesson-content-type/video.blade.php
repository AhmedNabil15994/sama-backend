@if($lessonContent->status)
  @php
  $video = \Modules\Course\Entities\UserVideo::query()->where('lesson_content_id', $lessonContent->id)->where('user_id', auth()->id())->first();
  $percent = $video ? round($video->percent, 2) : 0;
  @endphp
<li style="border-bottom: none">
  <div class="course-details__curriculum-list-left {{request('lesson-content-id') == $lessonContent?->id ? 'active' : ''}}" style="{{$has_access ? 'cursor: pointer' : 'cursor: default'}}">
    <div class="course-details__meta-icon video-icon">
      @if($has_access || $lessonContent->is_free)
        <i class="fas fa-play"></i>
      @else
        <i class="fas fa-lock"></i>
      @endif
    </div>
    @if($has_access || $lessonContent->is_free)
      <a class="tablinks" href="{{ route('frontend.courses.show',['slug'=>$course->slug, 'lesson-content-id' => $lessonContent->id]) }}">
        {{$lessonContent->title }}
      </a>
    @else
      <a class="tablinks" style="pointer-events: none; cursor: default" aria-disabled="true">
        {{$lessonContent->title }}
      </a>
    @endif
  </div>
</li>
  <div class="progress" style="height: 2px;">
{{--    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100">{{$percent}}%</div>--}}
    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
@endif
