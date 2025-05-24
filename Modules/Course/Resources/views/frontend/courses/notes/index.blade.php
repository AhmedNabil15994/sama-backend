@extends('apps::frontend.layouts.app')
@section('title', __('Notes') )
@push('css')
  <style>
    .p-50{
      padding:50px;
    }
    .course-one__image{
      background-color: #FFF;
    }
  </style>
@endpush
@section('content')
<div class="inner-page bg-color-dark-one">
  <div class="container  p-50">
    <div class="row">
      <div class="col-md-12">
        <div class="courses-block">
          <div class="row">
            @foreach($notes as $key => $note)
            <div class="col-md-4 col-12 col-6 py-4">
              @include('course::frontend.courses.notes.note-card',['note'=>$note])
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
