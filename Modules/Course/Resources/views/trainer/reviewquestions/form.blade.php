{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.reviewquestions.form.title').'-'.$code ,
    $model?->question,
    ['data-name' => 'title.'.$code, 'disabled' => true]
    ) !!}
  </div>
  @endforeach
</div>








{!! field()->checkBox('status', __('course::dashboard.reviewquestions.form.status')) !!}

@if ($model?->trashed())
{!! field()->checkBox('trash_restore', __('course::dashboard.reviewquestions.form.restore')) !!}
@endif
@if($model)
  <input type="hidden" name="review_question_id" value="{{$model->id}}">
  {!! field()->textarea('answer', __('course::dashboard.coursereviews.form.answers')) !!}
@endif
