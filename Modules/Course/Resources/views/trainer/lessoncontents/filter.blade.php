@inject('semesters', 'Modules\Semester\Entities\Semester')
@inject('courses', 'Modules\Course\Entities\Course')


<div class="col-md-3">
  {!! field()->select('semester_id',__('course::dashboard.lessons.form.semesters') ,$semesters->active()->pluck('title','id'),request('semester_id'), ) !!}
</div>


<div class="col-md-3">
  {!! field()->select('course_id',__('course::dashboard.lessons.form.courses') ,$courses->active()->trainer(auth()->user()->id)->pluck('title','id'),request('course_id'),
   ['id' => 'filter_course_id']) !!}
</div>


<div class="col-md-3">
  {!! field()->select('lesson_id',__('course::dashboard.lessons.routes.index'), [],null,
  ['id' => 'filter_lesson_id']) !!}
</div>

@push('scripts')
<script>



  if("{{ request('course_id') }}")
    getLessonsByCourseId();

  $('#filter_course_id').change(function () {
    getLessonsByCourseId();
  });

  function getLessonsByCourseId(){
    var url = '{!! route('trainer.courses.get-lessons-with-course-id',':courseId') !!}';
    url = url.replace(':courseId', $('#filter_course_id').val());

    $.ajax({
        url: url,
        type: 'get',
        success: function (data) {

            var builtSelectCategory = '<option value="" selected>قم بالاخيتار</option>';
            $.each(data, function (index, item) {
                var option = '<option value="' + item.id + '">' + item.title + '</option>';
                builtSelectCategory += option;
            });

            $('#filter_lesson_id').text('').append(builtSelectCategory);
        },
    });
  }
</script>
@endpush
