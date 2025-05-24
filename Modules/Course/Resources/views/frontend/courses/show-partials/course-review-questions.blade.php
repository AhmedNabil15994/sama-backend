
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
