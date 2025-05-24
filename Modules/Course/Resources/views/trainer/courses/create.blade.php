@extends('apps::trainer.layouts.app')
@section('title', __('course::dashboard.courses.routes.create'))
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
                    <a href="{{ url(route('trainer.courses.index')) }}">
                        {{__('course::dashboard.courses.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('course::dashboard.courses.routes.create')}}</a>
                </li>
            </ul>
        </div>


        <h3 class="page-title"></h3>
        <div class="row">
            {!! Form::model($model,[
            'url'=> route('trainer.courses.store'),
            'id'=>'form',
            'role'=>'form',
            'method'=>'POST',
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
                                            <a href="#general"
                                                data-toggle="tab">
                                                {{ __('course::dashboard.courses.form.tabs.general') }}
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#targets"
                                                data-toggle="tab">
                                                {{ __('course::dashboard.courses.form.tabs.targets') }}
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#categories"
                                                data-toggle="tab">
                                                {{ __('course::dashboard.courses.form.tabs.categories') }}
                                            </a>
                                        </li>

                                        {{-- <li class="">
                                            <a href="#schedule"
                                                data-toggle="tab">
                                                {{ __('course::dashboard.courses.form.tabs.schedule') }}
                                            </a>
                                        </li> --}}


                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- PAGE CONTENT --}}
                <div class="col-md-9">
                    <div class="tab-content">

                        {{-- CREATE FORM --}}
                        <div class="tab-pane active fade in"
                            id="general">
                            <div class="col-md-10">
                                @include('course::trainer.courses.forms.form')
                            </div>
                        </div>

                        <div class="tab-pane fade in"
                            id="targets">
                            <div class="col-md-10">
                                @include('course::trainer.courses.forms.targets-form')
                            </div>
                        </div>

{{--
                        <div class="tab-pane fade in"
                            id="schedule">
                            <div class="col-md-10">
                                @include('course::dashboard.courses.forms.schedule')
                            </div>
                        </div> --}}


                        <div class="tab-pane fade in"
                            id="categories">

                            <div id="jstree">
                                @include('course::trainer.tree.categories.view',[
                                'mainCategories' => $mainCategories
                                ])
                            </div>
                            <div class="form-group">
                                <input type="hidden"
                                    name="category_id"
                                    id="root_category"
                                    value=""
                                    data-name="category_id">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::trainer.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit"
                                        id="submit"
                                        class="btn btn-lg blue">
                                        {{__('apps::dashboard.buttons.add')}}
                                    </button>
                                    <a href="{{url(route('trainer.courses.index')) }}"
                                        class="btn btn-lg red">
                                        {{__('apps::dashboard.buttons.back')}}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>
@stop
