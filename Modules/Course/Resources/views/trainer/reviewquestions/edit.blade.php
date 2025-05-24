@extends('apps::trainer.layouts.app')
@section('title', __('apps::dashboard._layout.aside.review_questions'))
@section('css')
  <style>
    .answers{
      border: 1px solid #ddd;
      border-radius: 2px;
      padding: 10px;
    }
    .answers .answer{
      border: 1px solid #ddd;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 5px;
    }
  </style>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('trainer.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('trainer.reviewquestions.index')) }}">
                        {{__('apps::dashboard._layout.aside.review_questions')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('course::dashboard.reviewquestions.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            {!! Form::model($model,[
            'url'=> route('trainer.reviewquestions.update',$model->id),
            'id'=>'updateForm',
            'role'=>'updateForm',
            'method'=>'PUT',
            'class'=>'form-horizontal form-row-seperated',
            'files' => true
            ])!!}




            <div class="col-md-12">

                {{-- RIGHT SIDE --}}
                <div class="col-md-3">
                    <div class="panel-group accordion scrollable"
                        id="accordion2">
                        <div class="panel panel-default">

                            <div id="collapse_2_1"
                                class="panel-collapse in">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="active">
                                            <a href="#global_setting"
                                                data-toggle="tab">
                                                {{ __('course::dashboard.reviewquestions.form.tabs.general') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="answers panel panel-default">
                      <div class="panel-body">
                        @foreach($model?->answers as $oneAsnwer)
                          <div class="row answer">
                            <div class="col-xs-6">{{$oneAsnwer->user->name}}</div>
                            <div class="col-xs-6">{{$oneAsnwer->created_at ? date('Y,M d A h:i',strtotime($oneAsnwer->created_at)) : ''}}</div>
                            <div class="col-xs-12">{!! $oneAsnwer->answer !!}</div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                </div>

                {{-- PAGE CONTENT --}}
                <div class="col-md-9">
                    <div class="tab-content">

                        {{-- UPDATE FORM --}}
                        <div class="tab-pane active fade in"
                            id="global_setting">

                                <div class="col-md-10">
                                    @include('course::trainer.reviewquestions.form')
                                </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::trainer.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit"
                                        id="submit"
                                        class="btn btn-lg green">
                                        {{__('apps::dashboard.buttons.edit')}}
                                    </button>
                                    <a href="{{url(route('trainer.reviewquestions.index')) }}"
                                        class="btn btn-lg red">
                                        {{__('apps::dashboard.buttons.back')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop


@section('scripts')

<script type="text/javascript">
    $(function() {
    $('#jstree').jstree();

    $('#jstree').on("changed.jstree", function(e, data) {
        $('#root_category').val(data.selected);
    });
});
</script>

<script>
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      startDate: '0d'
    });

</script>

<script>
    // GALLERY FORM / ADD NEW UPLOAD BUTTON
$(document).ready(function() {
    var html = $("div.getGalleryForm").html();
    $(".addGallery").click(function(e) {
        e.preventDefault();
        $(".galleryForm").append(html);
        $('.lfm').filemanager('image');
    });
});

// DELETE UPLOAD BUTTON & IMAGE
$(".galleryForm").on("click", ".delete-gallery", function(e) {
    e.preventDefault();
    $(this).closest('.form-group').remove();
});
</script>

@stop
