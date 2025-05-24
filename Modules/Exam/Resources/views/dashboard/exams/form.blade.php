{!! field()->langNavTabs() !!}
@inject('trainers','Modules\Trainer\Entities\Trainer')
@inject('courses','Modules\Course\Entities\Course')
<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('area::dashboard.cities.form.title').'-'.$code ,
        $model->getTranslation('title' , $code),
        ['data-name' => 'title.'.$code]
        ) !!}
    </div>
    @endforeach
</div>

{!! field()->select('trainer_id', __('order::dashboard.orders.datatable.trainer'),$trainers->pluck('name','id')  ) !!}
{!! field()->select('course_id', __('course::dashboard.coursereviews.datatable.course'), $model ? $courses->pluck('title','id')  : []  ) !!}
{{--where('trainer_id',$model->trainer_id)--}}
{!! field()->number('degree', __('exam::dashboard.exams.form.degree')) !!}
{!! field()->number('success_degree', __('exam::dashboard.exams.form.success_degree')) !!}
{!! field()->number('duration', __('exam::dashboard.exams.form.duration')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('exam::dashboard.exmas.form.restore')) !!}
@endif


@section('scripts')
  <script>
    $(function (){
        $('select[name="trainer_id"]').on('change',function (){
            let trainer_id = $(this).val();
            $.ajax({
              type:'get',
              url: "{{route('dashboard.exams.getTrainerCourses',['trainer_id'=>":trainer_id"])}}".replace(':trainer_id',trainer_id),
            }).success(function (data){
              $('select[name="course_id"]').empty().select2('destroy');
              $.each(data.courses,function (index,item){
                $('select[name="course_id"]').append('<option value="'+item.id+'">'+item.title+'</option>')
              });
              $('select[name="course_id"]').select2()
              console.log(data)
            }).error(function (data){

            })
        });
    });
  </script>
@endsection
