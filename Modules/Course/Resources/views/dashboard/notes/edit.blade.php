@extends('apps::dashboard.layouts.app')
@section('title', __('course::dashboard.notes.routes.update'))
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ route('dashboard.home') }}">{{ __('apps::dashboard.index.title') }}</a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="{{ url(route('dashboard.notes.index')) }}">
            {{ __('course::dashboard.notes.routes.index') }}
          </a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="#">{{ __('course::dashboard.notes.routes.update') }}</a>
        </li>
      </ul>
    </div>

    <h1 class="page-title"></h1>

    <div class="row">
      {!! Form::model($model, [
      'url' => route('dashboard.notes.update', $model->id),
      'id' => 'updateForm',
      'role' => 'form',
      'method' => 'PUT',
      'class' => 'form-horizontal form-row-seperated',
      'files' => true,
      ]) !!}
      <div class="col-md-12">

        {{-- RIGHT SIDE --}}
        <div class="col-md-3">
          <div class="panel-group accordion scrollable" id="accordion2">
            <div class="panel panel-default">

              <div id="collapse_2_1" class="panel-collapse in">
                <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                      <a href="#global_setting" data-toggle="tab">
                        {{ __('course::dashboard.notes.form.tabs.general') }}
                      </a>
                    </li>
                    <li class="">
                      <a href="#categories" data-toggle="tab">
                        {{ __('course::dashboard.notes.form.tabs.categories') }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane active fade in" id="global_setting">
              <div class="col-md-10">
                @include('course::dashboard.notes.forms.form')
              </div>
            </div>
            <div class="tab-pane fade in" id="categories">
              <h3 class="page-title">{{ __('course::dashboard.notes.form.tabs.categories') }}</h3>
              <div id="jstree">
                @include('course::dashboard.notes.tree.categories.view',compact('mainCategories'))
              </div>
              <div class="form-group">
                <input type="hidden" name="category_id" id="root_category" value="" data-name="category_id">
                <div class="help-block"></div>
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-actions">
                @include('apps::dashboard.layouts._ajax-msg')
                <div class="form-group">
                  <button type="submit" id="submit" class="btn btn-lg green">
                    {{ __('apps::dashboard.buttons.edit') }}
                  </button>
                  <a href="{{ url(route('dashboard.notes.index')) }}" class="btn btn-lg red">
                    {{ __('apps::dashboard.buttons.back') }}
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
