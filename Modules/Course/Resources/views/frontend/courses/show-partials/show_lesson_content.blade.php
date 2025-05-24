  @if($has_access || $lesson_content->is_free)
   <div id="lesson_content_section">
    <div class="course-one__vide video-select tabcontent" id="vidcontent">
      <iframe class="videos-iframe" src="{{ $lesson_content->video_link }}"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
    </div>
    <span class="label label-primary lesson-title">{{$lesson_content->title}}</span>
    <ul class="course-details__tab-navs list-unstyled nav nav-tabs" role="tablist">
      @auth
        <li>
          <a class="active" role="tab" data-toggle="tab" href="#q-a">{{ __('Q & A') }}</a>
        </li>
      @endauth
      <li>
        <a role="tab" data-toggle="tab" href="#overview-1">{{ __('Course summary') }}</a>
      </li>
    </ul>
    <div class="tab-content course-details__tab-content ">
      <div class="tab-pane show  animated fadeInUp" role="tabpanel" id="overview-1">
        <p class="course-details__tab-text">
          {!! $course->description !!}
        </p>
      </div>
      @auth
        <div class="tab-pane animated active fadeInUp" role="tabpanel" id="q-a">
          <form enctype="multipart/form-data" action="{{route('frontend.courses.storeReviewQuestion',['id'=>$course->id])}}" method="post" class="course-details__comment-form">
            @csrf
            <input type="hidden" id="lesson_content_id" name="lesson_content_id" value="{{$lesson_content->id}}">
            <div class="row">
              <div class="col-lg-12">
                <div class="textareaContainer">
                  <textarea name="question" placeholder="{{ __('Write a question') }}"></textarea>
                  <input type="file" name="image" class="hidden">
                  <i class="fa fa-paperclip"></i>
                </div>
                <button type="submit" class="thm-btn course-details__comment-form-btn" data-send-question="{{ __('Send Question') }}" data-loading-text="{{ __('loading') }}">{{ __('Send Question') }}</button>
              </div>
            </div>
          </form>
          <div class="course-details__comment">
            <h3> {{ __('questions in this course') }}</h3>
            <div id="course_reviews">
              @foreach($reviewQuestions as $question)
                <div class="answers-list">
                  <div class="course-details__comment-single">
                    <div class="course-details__comment-top">
                          <span class="course-details__meta-icon">
                            <i class="far fa-user-circle"></i>
                          </span>
                      <div class="course-details__comment-right">
                        <h2 class="course-details__comment-name">{{$question->user?->name?? $question->user?->mobile}}</h2>
                        <div class="course-details__comment-meta">
                          <p class="course-details__comment-date">{{date('d/m/Y',strtotime($question->created_at))}}</p>
                        </div>
                      </div>
                    </div>
                    @if($question->image)
                      <img src="{{asset($question->image)}}" alt="questionImage{{$question->id}}">
                    @endif
                    <p class="course-details__comment-text m-20">
                      {{$question->question}}
                    </p>
                  </div>
                  <div class="accordion">
                    <div class="accordion-group reply">
                      <div class="accordion-heading area">
                        <a class="accordion-toggle" data-toggle="collapse" href=".replyDiv">
                          <div class="course-details__meta-icon">
                            <i class="far fa-flag"></i>
                          </div>
                          {{__('Add a reply')}}
                        </a>
                        <a class="accordion-toggle" data-toggle="collapse" href=".answersDiv">
                          <div class="course-details__meta-icon">
                            <i class="far fa-comment"></i>
                          </div>
                          {{__('Replies')}}
                        </a>
                      </div>

                      <div class="accordion-body collapse replyDiv" id="">
                        <div class="accordion-inner">
                          <form enctype="multipart/form-data" action="{{route('frontend.courses.storeReviewQuestionAnswer',['question_id'=>$question->id])}}" method="post" class="course-details__comment-form">
                            @csrf
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="textareaContainer">
                                  <textarea name="answer" placeholder="{{__('Write your Reply')}}"></textarea>
                                  <input type="file" name="image" class="hidden">
                                  <i class="fa fa-paperclip"></i>
                                </div>
                                <button type="submit" class="thm-btn course-details__comment-form-btn">
                                  {{__('Send Reply')}}</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>

                      <div class="accordion-body collapse answersDiv" id="">
                        <div class="accordion-inner">
                          @foreach($question->answers as $answer)
                            <div class="course-details__comment-single answers__style">
                              <div class="course-details__comment-top">
                                  <span class="course-details__meta-icon">
                                    <i class="far fa-user-circle"></i>
                                  </span>
                                <div class="course-details__comment-right">
                                  <h2 class="course-details__comment-name">{{$answer->user->name}} </h2>
                                  <div class="course-details__comment-meta">
                                    <p class="course-details__comment-date">{{date('d/m/Y',strtotime($answer->created_at))}}</p>
                                  </div>
                                </div>
                              </div>
                              @if($answer->image)
                                <img src="{{asset($answer->image)}}" alt="answerImage{{$answer->id}}">
                              @endif
                              <p class="course-details__comment-text">
                                {!! $answer->answer !!}
                              </p>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div><!-- /accordion -->
                  @endforeach
            </div>
          </div>

        </div>
      @endauth
    </div>
  </div>
  @else
  <div class="course-one__vide video-select tabcontent" id="lesson_subscribe" style="text-align: center;">
    <div style="padding: 10px; background: #f4f4f4;">
      {{ $course->title }} <a href="{{ route('frontend.cart.add',['id'=>$course->id,'type'=>'course']) }}" class="thm-btn banner-one__btn">{{ __('Add to Cart') }}</a>
    </div>
  </div>
  @endif



@push('scripts')
{{--       <script src="https://player.vimeo.com/api/player.js"></script>--}}
{{--       <script>--}}
{{--         var iframe = document.querySelector('iframe');--}}
{{--         var player = new Vimeo.Player(iframe);--}}
{{--         var video_duration = 0;--}}
{{--         player.getDuration().then(function(duration) {--}}
{{--           // duration = the duration of the video in seconds--}}
{{--           video_duration = duration;--}}
{{--         }).catch(function(error) {--}}
{{--           // an error occurred--}}
{{--         });--}}
{{--         var currentTime = '{{$user_video ? $user_video->totalPlayed : 0}}'--}}
{{--         player.setCurrentTime(currentTime).then(function(seconds) {--}}
{{--           // `seconds` indicates the actual time that the player seeks to--}}
{{--         }).catch(function(error) {--}}

{{--         });--}}

{{--         var lesson_content_id = '{{$lesson_content->id}}';--}}
{{--         var onPlay = function(data) {--}}
{{--           console.log(data.duration);--}}
{{--           console.log(data.percent);--}}
{{--           console.log(data.seconds);--}}
{{--           var _token = '{{csrf_token()}}'--}}
{{--           handeLessonContentView(_token, data.seconds, data.percent, data.duration, lesson_content_id)--}}
{{--         };--}}
{{--         player.on('timeupdate', onPlay);--}}


{{--         function handeLessonContentView(_token, totalPlayed, percent, video_duration,lesson_content_id){--}}
{{--           $.ajax({--}}
{{--             type: "post",--}}
{{--             url: "{{ route('course.make.view') }}",--}}
{{--             data: {_token, totalPlayed, percent, video_duration,lesson_content_id},--}}
{{--             dataType: "json",--}}
{{--             success: function (response) {}--}}

{{--           });--}}
{{--         }--}}
{{--       </script>--}}
@endpush
