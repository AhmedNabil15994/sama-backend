@inject('exams', 'Modules\Exam\Entities\Exam')

{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="first_{{$code}}">
      {!! field()->text('title['.$code.']',
      __('course::dashboard.lessoncontents.form.title').'-'.$code ,
      $model->getTranslation('title' , $code),
      ['data-name' => 'title.'.$code]
      ) !!}

    </div>
  @endforeach
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="lesson_id" class="col-md-2">{{__('course::dashboard.lessoncontents.datatable.course')}}</label>
      <div class="col-md-9">
        <select name="course_id" class="form-control select2">
          <option value="">Select</option>
          @foreach($courses as $course)
            <option value="{{$course->id}}">{{$course->title}}</option>
          @endforeach
        </select>
      </div>
    </div>

    {{--    {!! field()->select('lesson_id',__('course::dashboard.lessoncontents.form.lessons'),$courses) !!}--}}
  </div>
</div>
<div class="form-group ">
  <div class="col-md-10">
    <label for="lesson_id" class="col-md-3">{{__('course::dashboard.lessoncontents.form.lessons')}}</label>
    <div class="form-group">
      <div class="col-md-8">
        <select name="lesson_id" id="lesson_id" class="form-control select2">
          <option value="">Select</option>
        </select>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#extraLesson"><i class="icon-plus"></i></button>
  </div>
</div>




<div @if($model->id!==null) hidden @endif >
  {!! field()->select('type',__('course::dashboard.lessoncontents.form.type'),$model->availableTypes()) !!}
</div>



<div class="form-group  {{$model->id == null && $model->type !='exam' ? 'hidden' : ''}}" id="exam_id_wrap">
  <label for="exam_id" class="col-md-2" style="">{{__('course::dashboard.lessoncontents.form.exams')}}</label>
  <div class="col-md-9" style="">
    <select class="form-control select2" data-name="exam_id" id="exam_id" name="exam_id">
      <option value=" " disabled {{$model->id == null ? 'selected' : ''}}>{{__('course::dashboard.lessoncontents.form.exams')}}</option>
      @foreach($exams->get(['title','id']) as $one)
        <option value="{{$one->id}}" {{$model->exam_id == $one->id ? 'selected' : ''}}>{{$one->title}}</option>
      @endforeach
    </select>
    <span class="help-block" style=""></span>
  </div>
</div>

<div class="form-group  {{$model->id == null && $model->type !='video_link' ? 'hidden' : ''}}" id="video_id_wrap">
  <label for="video_link" class="col-md-2" style="">{{__('course::dashboard.lessoncontents.form.types.video')}}</label>
  <div class="col-md-9" style="">
    <input placeholder="{{__('course::dashboard.lessoncontents.form.types.video')}}" value="{{$model->id != null ? $model->video_link : ''}}" class="form-control" data-name="video_link" id="video_link" name="video_link" type="text">
    <span class="help-block" style=""></span>
  </div>
</div>

<div class="form-group {{$model->id == null && $model->type !='resource' ? 'hidden' : ''}}" id="resource_wrap">
  <label for="resource" class="col-md-2" style="">{{__('course::dashboard.lessoncontents.form.types.resource')}}</label>
  <div class="col-md-9" style="">
    <div class="file-input file-input-new"><div class="file-preview ">
        <div class="close fileinput-remove">×</div>
        <div class="file-drop-disabled">
          <div class="file-preview-thumbnails">
          </div>
          <div class="clearfix"></div>    <div class="file-preview-status text-center text-success"></div>
          <div class="kv-fileinput-error file-error-message" style="display: none;"></div>
        </div>
      </div>
      <div class="kv-upload-progress hide"><div class="progress">
          <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
            0%
          </div>
        </div></div>

      <button type="button" tabindex="500" title="Abort ongoing upload" class="btn btn-default hide fileinput-cancel fileinput-cancel-button"><i class="glyphicon glyphicon-ban-circle"></i> <span class="hidden-xs">Cancel</span></button>

      <div tabindex="500" class="btn btn-primary btn-file"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; <span class="hidden-xs">Browse …</span>
        <input placeholder="{{__('course::dashboard.lessoncontents.form.types.resource')}}" class="form-control hidden file_upload_preview" data-name="resource" data-preview-file-type="text" id="resource" name="resource" type="file"></div>
    </div>
    <span class="help-block" style=""></span>
  </div>
</div>



{!! field()->select('is_free',__('course::dashboard.lessoncontents.form.is_free'),[__('course::dashboard.lessoncontents.form.no'),__('course::dashboard.lessoncontents.form.yes')]) !!}
{!! field()->number('order', __('course::dashboard.lessoncontents.form.order'),) !!}


{{-- @if($model->type=='video') --}}
{{-- @include('course::dashboard.lessoncontents.forms.video') --}}
@if($model->type=='resource')
  @include('course::dashboard.lessoncontents.forms.resource')
@endif
{!! field()->checkBox('status', __('course::dashboard.courses.form.status')) !!}

<input type="hidden" class="set" name="model_type" value="{{ $model->type }}">

@section('scripts')
  <script>
    $("[name='type']").on('change',function(){
      const type=$(this).val();
      hideAll(["#resource_wrap","#exam_id_wrap",'#video_id_wrap'])
      $(`#${type}_wrap`).show().removeClass('hidden')
      $(`#${type}_id_wrap`).show().removeClass('hidden')
    }).change()

    function hideAll(hideItems){
      hideItems.forEach(function(item){
        $(item).hide()
      })
    }
  </script>
    <script>
      $(function (){
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        let url="{{ route('dashboard.lessons.store') }}"
        $(document).on('click','#extraLesson #extra-lesson-btn',function(e) {
          e.preventDefault();
          let formData = new FormData($('#new-reservation-modal-form')[0]);


          $.ajax({
            xhr: function () {
              var xhr = new window.XMLHttpRequest();
              xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  percentComplete = parseInt(percentComplete * 100);
                  $('.progress-bar').width(percentComplete + '%');
                  $('#progress-status').html(percentComplete + '%');
                }
              }, false);
              return xhr;
            },
            type: "post",
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
              $('#confirm').prop('disabled', true);
              $('.progress-info').show();
              $('.progress-bar').width('0%');
              resetErrors();
            },
            success:  (data)=> {
              $('#extraLesson').modal('hide')
              $('#extra-lesson-btn').prop('disabled', false);
              $('#submit').text();
              if (data[0] == true) {
                successfully(data);
                $("#lesson_id").select2("destroy");

                $.ajax({
                  type: "get",
                  url: "{{ route('dashboard.get-courses-ajax') }}",
                  data: "data",
                  dataType: "json",
                  success: function (response) {
                    let options='';
                    $('#lesson_id').html('')
                    $.each(response, function (index, course) {

                      if(course.id == $('select[name="course_id"]').val() ){
                        $('#lesson_id').append(`${
                          $.each(course['lessons'],function (index, lesson) {
                                options +=  `<option value="${lesson.id}"  ${course['lessons'].length-1 == index ? 'selected' : ''} >${lesson.title}</option>`
                          })
                        }
                        ${options}`)
                      }
                    });

                    $("#lesson_id").select2();
                  }

                });

                // $("#dropdown").select2();
              } else {
                displayMissing(data);
              };
            },
            error: function (data) {
              $('#extra-lesson-btn').prop('disabled', false);
              displayErrors(data);
            },
          });
        });

        let coursesArr = [];
        @foreach($courses as $course)
          coursesArr["{{$course->id}}"] = new Array(<?php echo implode(',', array($course->lessons)); ?>)
        @endforeach
        $('select[name="course_id"]').on('change',function (){
            let course_id = $(this).val();
            if(course_id){
              let courseLessons = coursesArr[course_id];
              let newOptions = '<option value="">Select</option>';
              $('select[name="lesson_id"]').empty().select2('destroy');
              $.each(courseLessons[0],function (index,item){
                  newOptions+= '<option value="'+item.id+'">'+item.title+'</option>';
              });
              $('select[name="lesson_id"]').append(newOptions).select2()
            }
        });

        $('button[data-target="#extraLesson"]').on('click',function (){
            let course_id = $('select[name="course_id"]').val();
            if(course_id){
              $('#extraLesson #course_id').val(course_id).trigger('change')
            }
        });

        @if($model?->lesson?->course_id)
        $('select[name="course_id"]').val("{{$model->lesson->course_id}}").trigger('change');
        $('select[name="lesson_id"]').val("{{$model->lesson_id}}").trigger('change');
        @endif
      });
    </script>
  @stop


