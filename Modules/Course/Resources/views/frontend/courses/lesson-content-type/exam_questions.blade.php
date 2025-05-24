<div class="course-details__content exam" id="course_details{{$lesson_content->id}}">
  <div class="exam__space position-relative">
    <div class="exam__title">
      <h3>{{$lesson_content->exam->title}}</h3>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-12 m-auto">
          <form class="multisteps_form" id="wizard" method="POST" action="{{route('frontend.courses.quizAnswers',['slug'=>$course->title])}}">
            <input type="hidden" name="exam_id" value="{{$lesson_content->exam->id}}">
            @foreach($lesson_content->exam->questions as $key => $question)
            <!--------------- Step-1 -------------->
            <div class="multisteps_form_panel step {{locale()=='ar' ? 'active' : ''}}" data-area="{{$question->id}}">
              <div class="form_content position-relative">
                <div class="content_box bg-white">
                  <div class="question_title ps-3 pt-3">
                    <h6>{{$key+1}}. {{$question->question}}</h6>
                  </div>
                  <div class="form_items ps-5 pt-4 row">
                    <div class="col-12" style="text-align: center">
                      @if($question->image)<img src="{{asset($question->image)}}" style="margin-bottom: 5px" alt="question_image{{$question->id}}">@endif
                    </div>
                    @foreach($question->answers as $answerKey => $answer)
                        <div class="col-6">
                          <label for="opt_{{$answer->id}}" id="answer_label_{{$answer->id}}" class="step_answer position-relative animate__animated animate__fadeInRight animate_25ms answer_label_{{$question->id}} answer_label_{{$answer->is_correct}}" data-area="{{$answer->id}}" data-question-id="{{$answer->question_id}}" data-is-correct="{{$answer->is_correct}}">
                            {{$answer->answer}}
                            <input id="opt_{{$answer->id}}" type="radio" name="answers[{{$lesson_content->exam_id}}][{{$question->id}}][{{$answer->id}}]" value="{{$answer->degree}}">
                          </label>
                          <div>
                            @if($answer->image)<img src="{{asset($answer->image)}}" class="answer_image_{{$question->id}} answer_image_{{$answer->is_correct}} hidden" style="margin-bottom: 3px; width: 300px; height: 150px;" alt="question_image{{$answer->id}}">@endif
                          </div>
                        </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            <!-- Form-Button -->
            <div class="button__exam">
              @csrf
              <button type="button" class="f_btn prev_btn border-0 text-white" id="prevBtn" end-text-btn="{{__('course::frontend.End Quiz')}}" text-btn="{{__('course::frontend.Previous Question')}}" onclick="nextPrev(-1)">{{__('course::frontend.Previous Question')}}</button>
              <button type="button" class="f_btn next_btn border-0 text-white" id="nextBtn" is-correct="" answer-id="" question-id="" text-btn="{{__('course::frontend.Next Question')}}" correct-answer="{{__('course::frontend.Correct Answer')}}" failed-answer="{{__('course::frontend.Failed Answer')}}" onclick="nextPrev(1)">{{__('course::frontend.Next Question')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
